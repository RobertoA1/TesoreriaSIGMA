<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\ConceptoPago;
use App\Models\Deuda;
use App\Models\Pago;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow){
        if (!isset($search)){
            $query = Pago::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Pago::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);    
        }
        return $query;
    }

    public function index(Request $request){
        $sqlColumns = ['id_pago','id_concepto','id_alumno','fecha_pago', 'monto', 'observaciones'];
        $resource = 'financiera';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;

        $query = PagoController::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = PagoController::doSearch($sqlColumns, $search, $maxEntriesShow);
        }

        $data = [
            'titulo' => 'Pagos',
            'columnas' => [
                'ID',
                'Concepto de Pago',
                'Nombre del Alumno',
                'Fecha de Pago',
                'Monto',
                'Observaciones'
            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'pago_view',
            'create' => 'pago_create',
            'edit' => 'pago_edit',
            'delete' => 'pago_delete',
        ];

        if ($request->input("created", false)){
            $data['created'] = $request->input('created');
        }

        if ($request->input("edited", false)){
            $data['edited'] = $request->input('edited');
        }

        if ($request->input("abort", false)){
            $data['abort'] = $request->input('abort');
        }

        if ($request->input("deleted", false)){
            $data['deleted'] = $request->input('deleted');
        }

        foreach ($query as $pago){
            $pago = Pago::findOrFail($pago->id_pago);

            
            $concepto = $pago->conceptoPago->descripcion ?? ''; 
            $alumno = $pago->alumno->primer_nombre ?? '';     

            array_push($data['filas'],
            [
                $pago->id_pago,  
                $concepto,              
                $alumno,                
                $pago->fecha_pago,      
                $pago->monto,           
                $pago->observaciones,   
            ]);
        }

        return view('gestiones.pago.index', compact('data'));

    }

    public function create(Request $request){
        $alumnos = Alumno::all(['id_alumno', 'codigo_educando']);
        $deudas = Deuda::all(['id_deuda', 'id_alumno', 'id_concepto', 'periodo', 'monto_total']);
        $conceptos = ConceptoPago::all(['id_concepto', 'descripcion']);

        $data = [
            'return' => route('pago_view', ['abort' => true]),
            'alumnos' => $alumnos,
            'deudas' => $deudas,
            'conceptos' => $conceptos,
        ];
        return view('gestiones.pago.create', compact('data'));
    }

    public function createNewEntry(Request $request)
    {
        $request->validate([
            'codigo_alumno'   => 'required|string',
            'id_deuda' => 'required|exists:deudas,id_deuda',
            'metodo_pago' => 'required|array',
            'metodo_pago.*' => 'required|string',
            'detalle_recibo.*' => 'required|string',
            'detalle_monto.*' => 'required|numeric|min:0.01',
            'detalle_fecha.*' => 'required|date',
            'detalle_observaciones.*' => 'nullable|string',
            'voucher_path.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'codigo_alumno.required' => 'Ingrese el código del educando.',
            'id_deuda.required' => 'Seleccione una deuda.',
            'id_deuda.exists' => 'La deuda seleccionada no es válida.',
            'metodo_pago.required' => 'Debe seleccionar un método de pago.',
            'metodo_pago.*.required' => 'Seleccione un método de pago para cada detalle.',
            'detalle_recibo.*.required' => 'Ingrese el número de operación.',
            'detalle_monto.*.required' => 'Ingrese el monto pagado.',
            'detalle_monto.*.numeric' => 'El monto debe ser numérico.',
            'detalle_monto.*.min' => 'El monto debe ser mayor a 0.',
            'detalle_fecha.*.required' => 'Ingrese la fecha del pago.',
            'detalle_fecha.*.date' => 'La fecha ingresada no es válida.',
            'detalle_observaciones.*.string' => 'La observación debe ser texto.',
            'voucher_path.*.file' => 'Debe subir un archivo válido.',
            'voucher_path.*.mimes' => 'Solo se permiten archivos JPG, JPEG, PNG o PDF.',
            'voucher_path.*.max' => 'El archivo no puede superar 2MB.',
        ]);

        if (count($request->input('detalle_monto', [])) > 2) {
            return back()->withErrors([
                'detalle_monto' => 'Solo puede registrar hasta 2 detalles de pago.'
            ])->withInput();
        }

        DB::transaction(function() use ($request) {
            $idDeuda = $request->input('id_deuda');
            $fechas = $request->input('detalle_fecha');
            $montos = $request->input('detalle_monto');
            $recibos = $request->input('detalle_recibo');
            $observaciones = $request->input('detalle_observaciones');
            $metodos = $request->input('metodo_pago');

            $montoTotalPago = collect($montos)->map(fn($m) => floatval($m))->sum();

            $pago = Pago::create([
                'id_deuda' => $idDeuda,
                'fecha_pago' => end($fechas),
                'monto' => $montoTotalPago,
                'observaciones' => $request->input('observaciones'),
                'estado_validacion' => 'pendiente',
            ]);

            foreach ($fechas as $i => $fecha) {
                $metodo = strtolower(trim($metodos[$i] ?? ''));
                $recibo = $recibos[$i] ?? null;
                $monto = floatval($montos[$i] ?? 0);
                $obs = $observaciones[$i] ?? null;

                $voucherPath = null;
                if (in_array($metodo, ['transferencia', 'yape'])) {
                    if (!$request->hasFile("voucher_path.$i")) {
                        throw new \Exception("Debe subir la constancia de pago para el método: $metodo");
                    }
                    $voucherPath = $request->file("voucher_path.$i")->store('vouchers', 'public');
                }

                DetallePago::create([
                    'id_pago' => $pago->getKey(),
                    'fecha_pago' => $fecha,
                    'monto' => $monto,
                    'nro_recibo' => $recibo,
                    'observacion' => $obs,
                    'metodo_pago' => $metodo,
                    'voucher_path' => $voucherPath,
                    'estado_validacion' => 'pendiente',
                ]);
            }
        });

        return redirect()->route('pago_view', ['created' => true])
                        ->with('success', 'Pago registrado correctamente en estado pendiente.');
    }

    public function edit(Request $request, $id)
    {
        if (!isset($id)) {
            return redirect(route('pago_view'));
        }

        $pago = Pago::findOrFail($id);

        $data = [
            'return' => route('pago_view', ['abort' => true]),
            'id' => $id,
            'default' => [
                'fecha_pago' => $pago->fecha_pago instanceof \Carbon\Carbon ? $pago->fecha_pago->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d\TH:i'),                'monto' => $pago->monto,
                'observaciones' => $pago->observaciones,
            ]
        ];

        return view('gestiones.pago.edit', compact('data'));
    }

    public function editEntry(Request $request, $id){
        if (!isset($id)){
            return redirect(route('pago_view'));
        }

        $requested = Pago::find($id);

        if (!$requested) {
            return redirect()->route('pago_view')->with('error', 'Deuda no encontrada.');
        }

        $request->validate([
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
            'observaciones' => 'nullable|max:255',
        ], [
            'fecha_pago.required' => 'Ingrese una fecha válida.',
            'fecha_pago.date' => 'La fecha debe tener un formato válido.',
            'monto.required' => 'Ingrese un monto válido.',
            'monto.numeric' => 'El monto debe ser numérico.',
            'observaciones.max' => 'Las observaciones no pueden superar los 255 caracteres.',
        ]);

        $requested->update([
            'fecha_pago' => $request->input('fecha_pago'),
            'monto' => $request->input('monto'),
            'observaciones' => $request->input('observaciones'),
        ]);

        return redirect(route('pago_view', ['edited' => true]));
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $requested = Pago::find($id);
        $requested->update(['estado' => '0']);

        return redirect(route('pago_view', ['deleted' => true]));
    }

    public function viewDetalles($id)
    {
        if (!isset($id)) {
            return redirect(route('pago_view'));
        }

        $pago = Pago::findOrFail($id);

        $detalles = DetallePago::where('id_pago', $id)->get();

        $alumno = Alumno::select(
            'codigo_educando',
            'codigo_modular',
            'año_ingreso',
            'dni',
            'apellido_paterno',
            'apellido_materno',
            'primer_nombre',
            'otros_nombres',
            'sexo',
            'fecha_nacimiento',
            'direccion',
            'telefono'
        )
        ->where('id_alumno', function($q) use ($pago) {
            $q->select('id_alumno')
            ->from('deudas')
            ->where('id_deuda', $pago->id_deuda)
            ->limit(1);
        })
        ->first();

        return view('gestiones.pago.detalles', compact('pago', 'detalles', 'alumno'));
    }

    public function buscarAlumno($codigo)
    {
        $alumno = Alumno::where('codigo_educando', $codigo)->first();

        if (!$alumno) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el alumno con ese código.'
            ], 404);
        }

        $deudas = Deuda::where('id_alumno', $alumno->id_alumno)->get();

        $deudasFormateadas = $deudas->map(function ($deuda) {
            $pagos = Pago::where('id_deuda', $deuda->id_deuda)->get();

            $pagoIds = $pagos->pluck('id_pago')->toArray();
            $detalles = collect();
            if (!empty($pagoIds)) {
                $detalles = DetallePago::whereIn('id_pago', $pagoIds)->get();
            }

            $montoPagado = $detalles->sum(function ($d) {
                return floatval($d->monto);
            });

            $detallesArr = $detalles->map(function ($d) {
                return [
                    'metodo_pago'      => $d->metodo_pago,
                    'nro_recibo'       => $d->nro_recibo,
                    'monto'            => floatval($d->monto),
                    'fecha_pago'       => $d->fecha_pago ? $d->fecha_pago->format('Y-m-d H:i:s') : null,
                    'observacion'      => $d->observacion,
                    'voucher_path'     => $d->voucher_path,
                    'estado_validacion'=> $d->estado_validacion,
                ];
            })->values();

            return [
                'id_deuda'      => $deuda->id_deuda,
                'periodo'       => $deuda->periodo,
                'monto_total'   => floatval($deuda->monto_total),
                'monto_pagado'  => round($montoPagado, 2),
                'concepto'      => $deuda->conceptoPago ? $deuda->conceptoPago->descripcion : 'Sin concepto',
                'detalles_pago' => $detallesArr,
            ];
        });

        return response()->json([
            'success' => true,
            'alumno' => [
                'id_alumno' => $alumno->id_alumno,
                'codigo_educando' => $alumno->codigo_educando,
                'nombre_completo' => trim($alumno->apellido_paterno . ' ' . $alumno->apellido_materno . ' ' . $alumno->primer_nombre)
            ],
            'deudas' => $deudasFormateadas,
        ]);
    }
}
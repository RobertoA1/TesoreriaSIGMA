<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

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
        $alumnos = \App\Models\Alumno::all(['id_alumno', 'codigo_educando']);
        $deudas = \App\Models\Deuda::all(['id_deuda', 'id_alumno', 'id_concepto', 'periodo', 'monto_total']);
        $conceptos = \App\Models\ConceptoPago::all(['id_concepto', 'descripcion']);

        $data = [
            'return' => route('pago_view', ['abort' => true]),
            'alumnos' => $alumnos,
            'deudas' => $deudas,
            'conceptos' => $conceptos,
        ];
        return view('gestiones.pago.create', compact('data'));
    }

    public function createNewEntry(Request $request){
        $request->validate([
            'id_deuda' => 'required|exists:deudas,id_deuda',
            'detalle_fecha' => 'required|array',
            'detalle_monto' => 'required|array',
            'detalle_recibo' => 'required|array',
            'detalle_observaciones' => 'required|array',
        ],[
            'id_deuda.required' => 'Seleccione una deuda.',
            'detalle_fecha.required' => 'Agregue al menos un detalle de pago.',
        ]);

        $idDeuda = $request->input('id_deuda');
        $fechas = $request->input('detalle_fecha');
        $montos = $request->input('detalle_monto');
        $recibos = $request->input('detalle_recibo');
        $observaciones = $request->input('detalle_observaciones');

        // 1. Sumar todos los montos
        $montoTotalPago = collect($montos)->map(function($m){ return floatval($m); })->sum();

        // 2. Crear el pago principal
        $pago = Pago::create([
            'id_deuda' => $idDeuda,
            'fecha_pago' => end($fechas), // última fecha como fecha del pago principal
            'monto' => $montoTotalPago,
            'observaciones' => $request->input('observaciones'),
            // agrega otros campos si es necesario
        ]);

        // 3. Crear los detalles de pago
        foreach ($fechas as $i => $fecha) {
            \App\Models\DetallePago::create([
                'id_pago' => $pago->id_pago,
                'fecha_pago' => $fecha,
                'monto' => floatval($montos[$i]),
                'nro_recibo' => $recibos[$i],
                'observacion' => $observaciones[$i],
            ]);
        }

        // 4. Actualizar la deuda
        $deuda = \App\Models\Deuda::find($idDeuda);
        $deuda->monto_adelantado = floatval($deuda->monto_adelantado) + $montoTotalPago;
        $deuda->monto_a_cuenta = floatval($deuda->monto_total) - floatval($deuda->monto_adelantado);
        $deuda->save();

        return redirect(route('pago_view', ['created' => true]));
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

        $requested = Pago::where('id_pago', '=', $id);

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

        $requested = Pago::where('id_pago', '=', $id);
        $requested->delete();

        return redirect(route('pago_view', ['deleted' => true]));
    }

    public function viewDetalles($id)
    {
        if (!isset($id)){
            return redirect(route('pago_view'));
        }

        $pago = Pago::findOrFail($id);
        $detalles = \App\Models\DetallePago::where('id_pago', $id)->get();

        return view('gestiones.pago.detalles', compact('pago', 'detalles'));
    }

}
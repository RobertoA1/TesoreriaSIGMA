<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow)
    {
        if (!isset($search)) {
            $query = Deuda::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Deuda::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $sqlColumns = ['id_deuda', 'id_alumno', 'id_concepto', 'periodo', 'monto_total','observacion'];
        $resource = 'financiera';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;

        $query = self::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()) {
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = self::doSearch($sqlColumns, $search, $maxEntriesShow);
        }

        $data = [
            'titulo' => 'Deudas',
            'columnas' => ['ID', 'Alumno', 'Concepto', 'Periodo', 'Monto Total (S/)'],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'deuda_view',
            'create' => 'deuda_create',
            'edit' => 'deuda_edit',
            'delete' => 'deuda_delete',
        ];

        foreach (['created', 'edited', 'abort', 'deleted'] as $flag) {
            if ($request->input($flag, false)) {
                $data[$flag] = $request->input($flag);
            }
        }

        foreach ($query as $deuda) {
            array_push($data['filas'], [
                $deuda->id_deuda,
                $deuda->id_alumno,
                $deuda->id_concepto,
                $deuda->periodo,
                $deuda->observacion,
                number_format($deuda->monto_total, 2)
            ]);
        }

        return view('gestiones.deuda.index', compact('data'));
    }

    public function create()
    {
        $data = [
            'return' => route('deuda_view', ['abort' => true]),
        ];

        return view('gestiones.deuda.create', compact('data'));
    }

    public function createNewEntry(Request $request)
    {
        $request->validate([
            'id_alumno' => 'required|numeric',
            'id_concepto' => 'required|numeric',
            'fecha_limite' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'periodo' => 'required|max:50',
            'monto_a_cuenta' => 'nullable|numeric|min:0',
            'monto_adelantado' => 'nullable|numeric|min:0',
            'observacion' => 'nullable|max:255',
        ], [
            'id_alumno.required' => 'Seleccione un alumno válido.',
            'id_concepto.required' => 'Seleccione un concepto válido.',
            'fecha_limite.required' => 'Ingrese una fecha límite válida.',
            'monto_total.required' => 'Ingrese un monto total válido.',
            'periodo.required' => 'Ingrese un periodo válido.',
            'monto_a_cuenta.numeric' => 'El monto a cuenta debe ser un número válido.',
            'monto_adelantado.numeric' => 'El monto adelantado debe ser un número válido.',
            'observacion.max' => 'La observación no puede superar los 255 caracteres.',
        ]);

        Deuda::create([
            'id_alumno' => $request->input('id_alumno'),
            'id_concepto' => $request->input('id_concepto'),
            'fecha_limite' => $request->input('fecha_limite'),
            'monto_total' => $request->input('monto_total'),
            'periodo' => $request->input('periodo'),
            'monto_a_cuenta' => $request->input('monto_a_cuenta'),
            'monto_adelantado' => $request->input('monto_adelantado'),
            'observacion' => $request->input('observacion'),
            'estado' => 1
        ]);

        return redirect(route('deuda_view', ['created' => true]));
    }

    public function edit(Request $request, $id)
    {
        if (!isset($id)) {
            return redirect(route('deuda_view'));
        }

        $deuda = Deuda::findOrFail($id);

        $data = [
            'return' => route('deuda_view', ['abort' => true]),
            'id' => $id,
            'default' => [
                'id_alumno' => $deuda->id_alumno,
                'id_concepto' => $deuda->id_concepto,
                'fecha_limite' => $deuda->fecha_limite->format('Y-m-d'),
                'monto_total' => $deuda->monto_total,
                'periodo' => $deuda->periodo,
                'monto_a_cuenta' => $deuda->monto_a_cuenta,
                'monto_adelantado' => $deuda->monto_adelantado,
                'observacion' => $deuda->observacion,
            ]
        ];

        return view('gestiones.deuda.edit', compact('data'));
    }

    public function editEntry(Request $request, $id)
    {
        if (!isset($id)) {
            return redirect(route('deuda_view'));
        }

        $request->validate([
            'id_alumno' => 'required|numeric',
            'id_concepto' => 'required|numeric',
            'fecha_limite' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'periodo' => 'required|max:50',
            'monto_a_cuenta' => 'nullable|numeric|min:0',
            'monto_adelantado' => 'nullable|numeric|min:0',
            'observacion' => 'nullable|max:255',
        ]);

        $deuda = Deuda::findOrFail($id);
        $deuda->update([
            'id_alumno' => $request->input('id_alumno'),
            'id_concepto' => $request->input('id_concepto'),
            'fecha_limite' => $request->input('fecha_limite'),
            'monto_total' => $request->input('monto_total'),
            'periodo' => $request->input('periodo'),
            'monto_a_cuenta' => $request->input('monto_a_cuenta'),
            'monto_adelantado' => $request->input('monto_adelantado'),
            'observacion' => $request->input('observacion')
        ]);

        return redirect(route('deuda_view', ['edited' => true]));
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $deuda = Deuda::where('id_deuda', $id)->firstOrFail();
        $deuda->delete();

        return redirect(route('deuda_view', ['deleted' => true]));
    }
}

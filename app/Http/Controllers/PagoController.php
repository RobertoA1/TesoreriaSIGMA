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
        $sqlColumns = ['id_pago', 'nro_recibo', 'fecha_pago', 'monto', 'observaciones'];
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
                'Número de Recibo',
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

            array_push($data['filas'],
            [
                $pago->id_pago,
                $pago->nro_recibo,
                $pago->fecha_pago,
                $pago->monto,
                $pago->observaciones,
            ]); 
        }

        return view('gestiones.pago.index', compact('data'));

    }



    public function create(Request $request){
        $data = [
            'return' => route('pago_view', ['abort' => true]),
        ];

        return view('gestiones.pago.create', compact('data'));
    }

    public function createNewEntry(Request $request){
        $request->validate([
            'nro_recibo' => 'required|max:20',
            'fecha_pago' => 'required',
            'monto' => 'required',
            'observaciones' => 'required'
        ],[
            'nro_recibo.required' => 'Ingrese un número de recibo válido.',
            'fecha_pago.required' => 'Ingrese una fecha válida.',
            'nro_recibo.max' => 'El nro de recibo no puede superar los 20 caracteres.',
            'monto.required' => 'Ingrese un monto válido.',
            'observaciones.required' => 'Ingrese observaciones válidas.'
        ]);

        $nro_recibo = $request->input('nro_recibo');
        $fecha_pago = $request->input('fecha_pago');
        $monto = $request->input('monto');
        $observaciones = $request->input('observaciones');

        Pago::create([
            'nro_recibo' => $nro_recibo,
            'fecha_pago' => $fecha_pago,
            'monto' => $monto,
            'observaciones'=> $observaciones
        ]);

        return redirect(route('pago_view', ['created' => true]));
    }

    public function editEntry(Request $request, $id){
        if (!isset($id)){
            return redirect(route('pago_view'));
        }

        $requested = Pago::where('id_pago', '=', $id);

        if (isset($requested)){
            $newNumeroRecibo = $request->input('nro_recibo');
            $newFechaPago = $request->input('fecha_pago');
            $newMonto = $request->input('monto');
            $newObservaciones = $request->input('observaciones');

            $requested->update(['nro_recibo' => $newNumeroRecibo, 'fecha_pago' => $newFechaPago, 'monto'=> $newMonto, 'observaciones'=> $newObservaciones]);
        }

        return redirect(route('pago_view', ['edited' => true]));
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $requested = Pago::where('id_pago', '=', $id);
        $requested->delete();

        return redirect(route('pago_view', ['deleted' => true]));
    }

}
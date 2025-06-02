@extends('base.administrativo.blank')

@section('titulo')
    Pagos
@endsection

@section('contenido')

@php

use App\Models\Pago;
$filas = [];

$query = Pago::where('estado', '=', '1')->paginate(10);

foreach ($query as $pago) {
    array_push($filas, [
        $pago->id_pago,
        $pago->nro_recibo,
        $pago->fecha_pago,
        $pago->monto,
        $pago->observaciones
    ]);
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
  'filas' => $filas
]

@endphp

@include('layout.tables.table-01', $data)

@endsection
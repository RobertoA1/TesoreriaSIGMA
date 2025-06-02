@extends('base.administrativo.blank')

@section('titulo')
    Conceptos de Pago
@endsection

@section('contenido')

@php

use App\Models\ConceptoPago;
$filas = [];

$query = ConceptoPago::where('estado', '=', '1')->paginate(10);

foreach ($query as $concepto) {
    array_push($filas, [
        $concepto->id_concepto,
        $concepto->descripcion,
        $concepto->escala,    
        $concepto->monto,
    ]);
}

$data = [
  'titulo' => 'Conceptos de Pago',
  'columnas' => [
    'ID',
    'Descripcion',
    'Escala',
    'Monto'
  ],
  'filas' => $filas
]

@endphp

@include('layout.tables.table-01', $data)

@endsection
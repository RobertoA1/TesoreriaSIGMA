@extends('base.administrativo.blank')

@section('titulo')
  Niveles Educativos
@endsection

@section('contenido')

@php

use App\Models\NivelEducativo;

$filas = [];

$query = NivelEducativo::where('estado', '=', '1')->paginate
(10);

foreach ($query as $nivel){
  array_push($filas,
  [
    $nivel->nombre_nivel,
    $nivel->descripcion
  ]
  );
}

$data = [
  'titulo' => 'Niveles Educativos',
  'columnas' => [
    'Nombre del Nivel',
    'Descripción'
  ],
  'filas' => $filas
]

@endphp

@include('layout.tables.table-01', $data)

@endsection
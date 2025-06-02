@extends('base.administrativo.blank')

@section('titulo')
    Familiares
@endsection

@section('contenido')

@php

use App\Models\Familiar;
$filas = [];

$query = Familiar::where('estado', '=', '1')->paginate(10);

foreach ($query as $familiar) {
    array_push($filas, [
        $familiar->dni,
        $familiar->apellido_paterno,
        $familiar->apellido_materno,
        $familiar->primer_nombre,
        $familiar->otros_nombres,
        $familiar->numero_contacto,
        $familiar->correo_electronico,
    ]);
}

$data = [
  'titulo' => 'Familiares',
  'columnas' => [
    'DNI',
    'Apellido Paterno',
    'Apellido Materno',
    'Primer Nombre',
    'Otros Nombres',
    'Número de Contacto',
    'Correo Electrónico'
  ],
  'filas' => $filas
]

@endphp

@include('layout.tables.table-familiares', $data)

@endsection
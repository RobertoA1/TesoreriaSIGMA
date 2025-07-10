@extends('layout.sidebar')

@section('opciones')

    {{-- Gestión Académica --}}
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión Académica',
            'items' => [
                'Grados',
                'Cursos',
            ],
            'links' => [
                'Cursos' => 'curso_view',
                'Grados' => 'grado_view',
            ],
            'icon' => 'birrete'
        ])
    
    {{-- Gestión de Alumnos --}}
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión de Alumnos',
            'items' => [
                'Alumnos',
                'Matrículas',
            ],
            'links' => [
                'Alumnos' => 'alumno_view',
                'Matrículas' => 'matricula_view', 
            ],
            'icon' => 'persona'
        ])
    

    {{-- Gestión Financiera --}}
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión Financiera',
            'items' => [
                'Conceptos de pago',
                'Pagos',
                'Deudas'
            ],
            'links' => [
                'Conceptos de pago' => 'concepto_de_pago_view',
                'Pagos' => 'pago_view',
                'Deudas' => 'deuda_view'
            ],
            'icon' => 'monedas'
        ])
    
@endsection
@extends('layout.sidebar')

@section('opciones')

    {{-- Gestión Académica --}}
    @can('access-resource', 'academica')
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión Académica',
            'items' => [
                'Niveles Educativos',
                'Grados',
                'Cursos',
                'Secciones',
                'Cátedras',
            ],
            'links' => [
                'Niveles Educativos' => 'nivel_educativo_view',
                'Cursos' => 'curso_view',
            ],
            'icon' => 'birrete'
        ])
    @endcan
    
    {{-- Gestión de Alumnos --}}
    @can('access-resource', 'alumnos')
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión de Alumnos',
            'items' => [
                'Alumnos',
                'Matrículas',
                'Familiares',
            ],
            'links' => [
                'Alumnos' => 'alumno_view',
                'Familiares' => 'familiar_view',    
            ],
            'icon' => 'persona'
        ])
    @endcan

    {{-- Gestión de Personal --}}
    @can('access-resource', 'personal')
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión de Personal',
            'items' => [
                'Docentes',
                'Departamentos Académicos',
            ],
            'links' => [
                'Departamentos Académicos' => 'departamento_academico_view'
            ],
            'icon' => 'persona-corbata'
        ])
    @endcan

    {{-- Gestión Administrativa --}}
    @can('access-resource', 'administrativa')
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Gestión Administrativa',
            'items' => [
                'Usuarios',
                'Administrativos',
                'Conceptos de Acción',
                'Historial de Acciones',
            ],
            'links' => [
                'Conceptos de Acción' => 'principal',
                'Administrativos' => 'administrativo_view',
            ],
            'icon' => 'maletin'
        ])
    @endcan

    {{-- Gestión Financiera --}}
    @can('access-resource', 'financiera')
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
    @endcan

    {{-- Reportes y Estadísticas --}}
    @can('access-resource', 'reportes')
        @include('components.para-sidebar.dropdown-button', [
            'name' => 'Reportes y Estadísticas',
            'items' => [
                'Reportes académicos',
                'Reportes financieros',
                'Estadísticas'
            ],
            'links' => [],
            'icon' => 'reporte'
        ])
    @endcan
@endsection
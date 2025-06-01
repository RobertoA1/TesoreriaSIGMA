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
                'Niveles Educativos' => 'pruebalinks.html'
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
            'links' => [],
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
                'a' => 'pruebalinks.html'
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
                'Historial de Acciones',
            ],
            'links' => [
                'a' => 'pruebalinks.html'
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
                'a' => 'pruebalinks.html'
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
            'links' => [
                'Reportes académicos' => 'pruebalinks.html'
            ],
            'icon' => 'reporte'
        ])
    @endcan
@endsection
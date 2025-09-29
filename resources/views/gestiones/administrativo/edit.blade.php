@extends('base.administrativo.blank')

@section('titulo')
  Editar un Administrativo
@endsection

@section('contenido')
<div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
        titulo="Editar Administrativo"
        subtitulo="ID: {{ $data['id'] }}"
        :returnUrl="$data['return']"
        boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
        @method('PATCH')
        @csrf

        <div class="mb-8">
            <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"></path>
                    </x-slot>
                    Información Básica
            </x-ui.section-title>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('components.forms.string', [
                'label' => 'Apellido paterno',
                'error' => $errors->first(Str::snake('Apellido paterno')) ?? false,
                'value' => old(Str::snake('Apellido paterno')) ?? $data['default']['apellido_paterno']
            ])

            @include('components.forms.string', [
                'label' => 'Apellido materno',
                'error' => $errors->first(Str::snake('Apellido materno')) ?? false,
                'value' => old(Str::snake('Apellido materno')) ?? $data['default']['apellido_materno']
            ])

            @include('components.forms.string', [
                'label' => 'Primer nombre',
                'error' => $errors->first(Str::snake('Primer nombre')) ?? false,
                'value' => old(Str::snake('Primer nombre')) ?? $data['default']['primer_nombre']
            ])

            @include('components.forms.string', [
                'label' => 'Otros nombres',
                'error' => $errors->first(Str::snake('Otros nombres')) ?? false,
                'value' => old(Str::snake('Otros nombres')) ?? $data['default']['otros_nombres']
            ])
            </div>
        </div>

        <div class="mb-8">
            <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </x-slot>
                    Información Personal
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'DNI',
                        'error' => $errors->first(Str::snake('DNI')) ?? false,
                        'value' => old(Str::snake('DNI')) ?? $data['default']['dni']
                    ])

                    @include('components.forms.string', [
                        'label' => 'Teléfono',
                        'error' => $errors->first(Str::snake('Teléfono')) ?? false,
                        'value' => old(Str::snake('Teléfono')) ?? $data['default']['telefono']
                    ])

                    @include('components.forms.string', [
                        'label' => 'Seguro social',
                        'error' => $errors->first(Str::snake('Seguro social')) ?? false,
                        'value' => old(Str::snake('Seguro social')) ?? $data['default']['seguro_social']
                    ])

                    @include('components.forms.select', [
                        'label' => 'Estado civil',
                        'error' => $errors->first(Str::snake('Estado civil')) ?? false,
                        'option_values' => ['S', 'C', 'V', 'D'],
                        'options' => ['Soltero', 'Casado', 'Viudo', 'Divorciado'],
                        'value' => old(Str::snake('Estado civil')) ?? $data['default']['estado_civil'],
                    ])
                </div>
        </div>

        <div class="mb-8">
            <x-ui.section-title :iconColor="'text-purple-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-9 0v10a2 2 0 002 2h8a2 2 0 002-2V7H7z"></path>
                    </x-slot>
                    Información Complementaria
            </x-ui.section-title>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @include('components.forms.string', [
                    'label' => 'Dirección',
                    'error' => $errors->first(Str::snake('Dirección')) ?? false,
                    'value' => old(Str::snake('Dirección')) ?? $data['default']['direccion']
                ])

                @include('components.forms.date-picker', [
                    'label' => 'Fecha de Ingreso',
                    'error' => $errors->first(Str::snake('Fecha de Ingreso')) ?? false,
                    'value' => old(Str::snake('Fecha de Ingreso')) ?? $data['default']['fecha_ingreso']
                ])

                @include('components.forms.select', [
                    'label' => 'Cargo',
                    'error' => $errors->first(Str::snake('Cargo')) ?? false,
                    'option_values' => ['Secretaria', 'Director', 'Administrador del Sistema'],
                    'options' => ['Secretaria', 'Director', 'Administrador del Sistema'],
                    'value' => old(Str::snake('Cargo')) ?? $data['default']['cargo'],
                ])

                @include('components.forms.string', [
                    'label' => 'Sueldo',
                    'error' => $errors->first(Str::snake('Sueldo')) ?? false,
                    'value' => old(Str::snake('Sueldo')) ?? $data['default']['sueldo']
                ])
            </div>
        </div>

        <!-- Botones de acción -->
        <x-ui.section-botton
            :returnUrl="$data['return']"
            boton="💾 Guardar Cambios"
        />
    </form>
</div>
@endsection

@section('custom-js')

@endsection


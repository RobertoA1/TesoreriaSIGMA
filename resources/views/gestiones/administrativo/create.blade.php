@extends('base.administrativo.blank')

@section('titulo')
  Crear un Administrativo
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <x-ui.section-header
            titulo="Nuevo Administrativo"
            subtitulo="Registra un nuevo administrativo en el sistema"
            :returnUrl="$data['return']"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PUT')
      @csrf

        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </x-slot>
                    Información Personal
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Apellido Paterno',
                        'name' => Str::snake('Apellido Paterno'),
                        'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
                        'value' => old(Str::snake('Apellido Paterno'), $data['session_data']['apellido_paterno'] ?? '')
                    ])

                    @include('components.forms.string', [
                        'label' => 'Apellido Materno',
                        'name' => Str::snake('Apellido Materno'),
                        'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
                        'value' => old(Str::snake('Apellido Materno'), $data['session_data']['apellido_materno'] ?? '')
                    ])

                    @include('components.forms.string', [
                        'label' => 'Primer Nombre',
                        'name' => Str::snake('Primer Nombre'),
                        'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
                        'value' => old(Str::snake('Primer Nombre'), $data['session_data']['primer_nombre'] ?? '')
                    ])

                    @include('components.forms.string', [
                        'label' => 'Otros Nombres',
                        'name' => Str::snake('Otros Nombres'),
                        'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
                        'value' => old(Str::snake('Otros Nombres'), $data['session_data']['otros_nombres'] ?? '')
                    ])
                </div>
        </div>

        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"></path>
                    </x-slot>
                    Información Básica
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'DNI',
                        'error' => $errors->first(Str::snake('DNI')) ?? false,
                        'value' => old(Str::snake('DNI'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Teléfono',
                        'error' => $errors->first(Str::snake('Teléfono')) ?? false,
                        'value' => old(Str::snake('Teléfono'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Seguro social',
                        'error' => $errors->first(Str::snake('Seguro social')) ?? false,
                        'value' => old(Str::snake('Seguro social'))
                    ])

                    @include('components.forms.select', [
                        'label' => 'Estado civil',
                        'error' => $errors->first(Str::snake('Estado civil')) ?? false,
                        'option_values' => ['S', 'C', 'V', 'D'],
                        'options' => ['Soltero', 'Casado', 'Viudo', 'Divorciado'],
                        'value' => old(Str::snake('Estado civil')),
                    ])
                </div>
        </div>

        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-purple-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-9 0v10a2 2 0 002 2h8a2 2 0 002-2V7H7z"></path>
                    </x-slot>
                    Información General
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Dirección',
                        'error' => $errors->first(Str::snake('Dirección')) ?? false,
                        'value' => old(Str::snake('Dirección'))
                    ])

                    @include('components.forms.date-picker', [
                        'label' => 'Fecha de Ingreso',
                        'error' => $errors->first(Str::snake('Fecha de Ingreso')) ?? false,
                        'value' => old(Str::snake('Fecha de Ingreso'))
                    ])

                    @include('components.forms.select', [
                        'label' => 'Cargo',
                        'error' => $errors->first(Str::snake('Cargo')) ?? false,
                        'option_values' => ['Secretaria', 'Director', 'Administrador del Sistema'],
                        'options' => ['Secretaria', 'Director', 'Administrador del Sistema'],
                        'value' => old(Str::snake('Cargo')),
                    ])

                    @include('components.forms.string', [
                        'label' => 'Sueldo',
                        'error' => $errors->first(Str::snake('Sueldo')) ?? false,
                        'value' => old(Str::snake('Sueldo'))
                    ])
                </div>
        </div>

        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-pink-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </x-slot>
                    Datos de Autenticación
                </x-ui.section-title>
                <div class="col-span-5">
                    @include('components.administrativo.create-usuario-table',[
                        'for' => 'administrador',
                    ])
                </div>
        </div>
    </form>
  </div>
@endsection

@section('custom-js')

@endsection


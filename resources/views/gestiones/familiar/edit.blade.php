
@extends('base.administrativo.blank')

@section('titulo')
  Editar Familiar
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
            titulo="Editar Familiar"
            subtitulo="ID: {{ $data['id'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
        @method('PATCH')
        @csrf

        <!-- Información Básica -->
        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"></path>
                    </x-slot>
                    Información Básica
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @include('components.forms.string', [
                                'label' => 'Primer Nombre',
                                'name' => 'primer_nombre',
                                'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
                                'value' => old('primer_nombre', $data['familiar']->primer_nombre)
                        ])

                        @include('components.forms.string', [
                            'label' => 'Otros Nombres',
                            'name' => 'otros_nombres',
                            'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
                            'value' => old('otros_nombres', $data['familiar']->otros_nombres)
                        ])

                        @include('components.forms.string', [
                            'label' => 'Apellido Paterno',
                            'name' => 'apellido_paterno',
                            'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
                            'value' => old('apellido_paterno', $data['familiar']->apellido_paterno)
                        ])

                        @include('components.forms.string', [
                            'label' => 'Apellido Materno',
                            'name' => 'apellido_materno',
                            'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
                            'value' => old('apellido_materno', $data['familiar']->apellido_materno)
                        ])

                </div>
        </div>

        <!-- Información Personal -->
        <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </x-slot>
                    Información Personal
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string-ineditable', [
                        'label' => 'DNI',
                        'name' => 'dni',
                        'error' => $errors->first(Str::snake('DNI')) ?? false,
                        'value' => old('dni', $data['familiar']->dni),
                        'readonly' => true
                    ])

                    @include('components.forms.string-ineditable', [
                        'label' => 'ID Usuario',
                        'name' => 'id_usuario',
                        'error' => $errors->first(Str::snake('ID Usuario')) ?? false,
                        'value' => old('id_usuario', $data['familiar']->id_usuario),
                        'readonly' => true
                    ])

                    @include('components.forms.string', [
                        'label' => 'Número de Contacto',
                        'name' => 'numero_contacto',
                        'error' => $errors->first(Str::snake('Número de Contacto')) ?? false,
                        'value' => old('numero_contacto', $data['familiar']->numero_contacto)
                    ])

                    @include('components.forms.string', [
                        'label' => 'Correo Electrónico',
                        'name' => 'correo_electronico',
                        'error' => $errors->first(Str::snake('Correo Electrónico')) ?? false,
                        'value' => old('correo_electronico', $data['familiar']->correo_electronico)
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

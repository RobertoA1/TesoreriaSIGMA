@extends('base.administrativo.blank')

@section('titulo')
    Grado | Edición
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Editar el Grado"
            subtitulo="ID: {{ $data['id'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
        />

        <form method="POST" id="form" action="" class="mt-8">
            @method('PATCH')
            @csrf

            <!-- Información del Grado -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </x-slot>
                    Información del Grado
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.forms.string-ineditable', [
                        'label' => 'ID',
                        'name' => 'id',
                        'error' => $errors->first('id') ?? false,
                        'value' => $data['id'],
                        'readonly' => true
                    ])

                    @include('components.forms.combo', [
                        'label' => 'Nivel Educativo',
                        'name' => 'nivel_educativo',
                        'error' => $errors->first('nivel_educativo') ?? false,
                        'value' => old('nivel_educativo', $data['default']['id_nivel']) ?? $data['default']['id_nivel'],
                        'options' => $data['niveles'],
                        'options_attributes' => ['id_nivel', 'descripcion']
                    ])

                    @include('components.forms.string', [
                        'label' => 'Nombre del Grado',
                        'name' => Str::snake('Nombre del Grado'),
                        'error' => $errors->first(Str::snake('Nombre del Grado')) ?? false,
                        'value' => old(Str::snake('Nombre del Grado')) ?? $data['default']['nombre_del_grado']
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
    <script src="{{ asset('js/tables.js') }}"></script>
@endsection

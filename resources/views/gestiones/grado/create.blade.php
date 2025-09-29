@extends('base.administrativo.blank')

@section('titulo')
    Crear un Grado
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Nuevo Grado"
            subtitulo="Registra un nuevo grado académico en el sistema"
            :returnUrl="$data['return']"
        />

        <form method="POST" id="form" action="" class="mt-8">
            @method('PUT')
            @csrf

            <!-- Información del Grado -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </x-slot>
                    Información del Grado
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Nombre del Grado',
                        'name' => Str::snake('Nombre del Grado'),
                        'error' => $errors->first(Str::snake('Nombre del Grado')) ?? false,
                        'value' => old(Str::snake('Nombre del Grado'))
                    ])

                    @include('components.forms.combo', [
                        'label' => 'Nivel Educativo',
                        'name' => Str::snake('NivelEducativo'),
                        'error' => $errors->first(Str::snake('NivelEducativo')) ?? false,
                        'value' => old(Str::snake('NivelEducativo')),
                        'options' => $data['niveles'],
                        'options_attributes' => ['id_nivel', 'descripcion']
                    ])
                </div>
            </div>

            <!-- Botones de acción -->
            <x-ui.section-botton
                :returnUrl="$data['return']"
                boton="🎓 Crear Grado"
            />
        </form>
    </div>
@endsection

@section('custom-js')
@endsection

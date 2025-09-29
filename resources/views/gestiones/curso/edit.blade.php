@extends('base.administrativo.blank')

@section('titulo')
    Editar un Curso
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Editar el Curso"
            subtitulo="ID: {{ $data['id'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
        />

        <form method="POST" id="form" action="" class="mt-8">
            @method('PATCH')
            @csrf

            <!-- Información del Curso -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </x-slot>
                    Información del Curso
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.forms.combo', [
                        'label' => 'Nivel Educativo',
                        'name' => Str::snake('Nivel educativo'),
                        'error' => $errors->first(Str::snake('Nivel educativo')) ?? false,
                        'options_attributes' => ['id_nivel', 'nombre_nivel'],
                        'options' => $data['niveles'],
                        'value' => old(Str::snake('Nivel educativo')) ?? $data['default'][Str::snake('Nivel educativo')],
                    ])

                    @include('components.forms.string', [
                        'label' => 'Código del Curso',
                        'name' => Str::snake('Código del Curso'),
                        'error' => $errors->first(Str::snake('Código del Curso')) ?? false,
                        'value' => old(Str::snake('Código del Curso')) ?? $data['default'][Str::snake('Código del Curso')],
                    ])

                    @include('components.forms.string', [
                        'label' => 'Nombre del Curso',
                        'name' => Str::snake('Nombre del Curso'),
                        'error' => $errors->first(Str::snake('Nombre del Curso')) ?? false,
                        'value' => old(Str::snake('Nombre del Curso')) ?? $data['default'][Str::snake('Nombre del Curso')]
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

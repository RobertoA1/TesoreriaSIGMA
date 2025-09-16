@extends('base.administrativo.blank')

@section('titulo')
    Crear una Seccion
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Nueva Sección"
            subtitulo="Registra una nueva sección académica en el sistema"
            :returnUrl="$data['return']"
        />

        <form method="POST" id="form" action="" class="mt-8">
            @method('PUT')
            @csrf

            <!-- Información Académica -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </x-slot>
                    Información Académica
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.forms.combo_dependient', [
                        'label' => 'Nivel Educativo',
                        'name' => 'nivel_educativo',
                        'error' => $errors->first(Str::snake('Nivel Educativo')) ?? false,
                        'placeholder' => 'Seleccionar nivel educativo...',
                        'value' => old(Str::snake('Nivel Educativo')),
                        'value_field' => 'id_nivel',
                        'text_field' => 'nombre_nivel',
                        'options' => $data['niveles'],
                        'enabled' => true,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Grado',
                        'name' => 'grado',
                        'error' => $errors->first(Str::snake('Grado')) ?? false,
                        'placeholder' => 'Seleccionar grado...',
                        'depends_on' => 'nivel_educativo',
                        'parent_field' => 'id_nivel',
                        'value' => old(Str::snake('Grado')),
                        'value_field' => 'id_grado',
                        'text_field' => 'nombre_grado',
                        'options' => $data['grados'],
                        'enabled' => false,
                    ])

                    @include('components.forms.string', [
                        'label' => 'Seccion',
                        'name' => Str::snake('Seccion'),
                        'error' => $errors->first(Str::snake('Seccion')) ?? false,
                        'value' => old(Str::snake('Seccion'))
                    ])
                </div>
            </div>

            <!-- Botones de acción -->
            <x-ui.section-botton
                :returnUrl="$data['return']"
                boton="✨ Crear Sección"
            />
        </form>
    </div>
@endsection

@section('custom-js')
@endsection

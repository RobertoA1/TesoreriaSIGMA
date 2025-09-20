@extends('base.administrativo.blank')

@section('titulo')
    Sección | Edición
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Editar la Sección"
            subtitulo="Sección: {{ $data['id']['nombreSeccion'] }} - Grado: {{ $data['id']['nombreGrado'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
        />

        <!-- Mensajes de Error -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300" id="error_mess">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" id="form" action="" class="mt-8">
            @method('PATCH')
            @csrf

            <!-- Información Académica -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
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
                        'value' => old(Str::snake('Nivel Educativo')) ?? $data['default'][Str::snake('Nivel educativo')],
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
                        'value' => old(Str::snake('Grado')) ?? $data['default'][Str::snake('Grado')],
                        'value_field' => 'id_grado',
                        'text_field' => 'nombre_grado',
                        'options' => $data['grados'],
                        'enabled' => false,
                    ])

                    @include('components.forms.string', [
                        'label' => 'Seccion',
                        'name' => Str::snake('Seccion'),
                        'error' => $errors->first(Str::snake('Seccion')) ?? false,
                        'value' => old(Str::snake('Seccion')) ?? $data['default'][Str::snake('Seccion')],
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
    <script>
        setTimeout(() => {
            const errorElement = document.getElementById('error_mess');
            if (errorElement) {
                errorElement.style.display = "none";
            }
        }, 3000);
    </script>
@endsection

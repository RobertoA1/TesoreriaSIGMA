@extends('base.administrativo.blank')

@section('titulo')
    Crear un Curso
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Nuevo Curso"
            subtitulo="Registra un nuevo curso en el sistema"
            :returnUrl="$data['return']"
        />

        <form method="POST" id="form" action="" class="mt-8">
            @method('PUT')
            @csrf

            <!-- Información del Curso -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
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
                        'value' => old(Str::snake('Nivel educativo')) ,
                    ])

                    @include('components.forms.string', [
                        'label' => 'Código del Curso',
                        'name' => Str::snake('Código del Curso'),
                        'error' => $errors->first(Str::snake('Código del Curso')) ?? false,
                        'value' => old(Str::snake('Código del Curso'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Nombre del Curso',
                        'name' => Str::snake('Nombre del Curso'),
                        'error' => $errors->first(Str::snake('Nombre del Curso')) ?? false,
                        'value' => old(Str::snake('Nombre del Curso'))
                    ])
                </div>
            </div>

            <!-- Botones de acción -->
            <!-- <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ $data['return'] }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-blue-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
                    value="📚 Crear Curso"
                >
            </div> -->
        </form>
    </div>
@endsection

@section('custom-js')
@endsection

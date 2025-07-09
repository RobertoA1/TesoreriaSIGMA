@extends('base.administrativo.blank')

@section('titulo')
    Crear Familiar
@endsection

@section('contenido')
    <!-- Información del Alumno -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md mb-8">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Asignando Familiar al Alumno</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Estás a punto de crear o asignar un familiar al siguiente estudiante. Verifica los datos antes de continuar:</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
            <div class="space-y-1">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Código Educando</span>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $data['default']['codigo_educando'] }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">DNI</span>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $data['default']['d_n_i'] }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Apellidos y Nombres</span>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $data['default']['apellido_paterno'] }} {{ $data['default']['apellido_materno'] }}, {{ $data['default']['primer_nombre'] }} {{ $data['default']['otros_nombres'] }}
                </p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Año de Ingreso</span>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $data['default']['año_ingreso'] }}</p>
            </div>
        </div>
    </div>

    <!-- Formulario Principal -->
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Nuevo Familiar</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Registra un nuevo familiar en el sistema</p>
            </div>
            <div class="flex gap-3">
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700"
                    value="👨‍👩‍👧‍👦 Crear Familiar"
                >
                <a href="{{ $data['return'] ?? route('familiar.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
            </div>
        </div>

        <form method="POST" id="form" action="{{ route('alumno_guardar_familiares', ['id' => $data['id']]) }}" class="mt-8">

            @csrf

            <!-- Configuración de Usuario -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configuración de Acceso
                </h3>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="crear_usuario" name="crear_usuario" value="1" 
                            {{ old('crear_usuario') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="crear_usuario" class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            ¿Desea crear una cuenta de usuario para este familiar?
                        </label>
                    </div>
                    <p class="text-xs text-blue-600 dark:text-blue-300 mt-2 ml-7">
                        Esto permitirá al familiar acceder al sistema con sus propias credenciales
                    </p>
                </div>
            </div>

            <!-- Información de Identificación -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"></path>
                    </svg>
                    Información de Identificación
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'DNI',
                        'name' => 'dni',
                        'error' => $errors->first(Str::snake('Dni')) ?? false,
                        'value' => old('dni')
                    ])
                </div>
            </div>

            <!-- Información Personal -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Información Personal
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Apellido Paterno',
                        'name' => 'apellido_paterno',
                        'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
                        'value' => old('apellido_paterno')
                    ])
                    @include('components.forms.string', [
                        'label' => 'Apellido Materno',
                        'name' => 'apellido_materno',
                        'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
                        'value' => old('apellido_materno')
                    ])
                    @include('components.forms.string', [
                        'label' => 'Primer Nombre',
                        'name' => 'primer_nombre',
                        'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
                        'value' => old('primer_nombre')
                    ])
                    @include('components.forms.string', [
                        'label' => 'Otros Nombres',
                        'name' => 'otros_nombres',
                        'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
                        'value' => old('otros_nombres')
                    ])
                    @include('components.forms.combo', [
                        'label' => 'Parentesco',
                        'name' => Str::snake('Parentesco'),
                        'error' => $errors->first(Str::snake('Parentesco')) ?? false,
                        'value' => old(Str::snake('Parentesco')),
                        'options' => [
                            ['id' => 'Padre', 'descripcion' => 'Padre'],
                            ['id' => 'Madre', 'descripcion' => 'Madre'],
                            ['id' => 'Tio/a', 'descripcion' => 'Tio/a'],
                            ['id' => 'Abuelo/a', 'descripcion' => 'Abuelo/a'],
                            ['id' => 'Apoderado', 'descripcion' => 'Apoderado'],
                            ['id' => 'Otro', 'descripcion' => 'Otro'],
                        ],
                        'options_attributes' => ['id', 'descripcion']
                    ])
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Información de Contacto
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Número de Contacto',
                        'name' => 'numero_contacto',
                        'error' => $errors->first(Str::snake('Numero de Contacto')) ?? false,
                        'value' => old('numero_contacto')
                    ])
                    @include('components.forms.string', [
                        'label' => 'Correo Electrónico',
                        'name' => 'correo_electronico',
                        'error' => $errors->first(Str::snake('Correo Electronico')) ?? false,
                        'value' => old('correo_electronico')
                    ])
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ $data['return'] ?? route('familiar.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700"
                    value="👨‍👩‍👧‍👦 Crear Familiar"
                >
            </div>
        </form>
    </div>
@endsection

@section('custom-js')
@endsection

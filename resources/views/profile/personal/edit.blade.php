@extends('base.administrativo.blank')

@section('titulo')
Editar Perfil - Personal
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Editar Perfil Personal</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $data['id'] }} | Código: {{ $personal->codigo_personal ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <input form="form" type="submit" 
                class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700 transition-colors" 
                value="💾 Guardar Cambios">
            <a href="{{ $data['return'] }}" 
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                ✕ Cancelar
            </a>
        </div>
    </div>

    <form method="POST" id="form" action="{{ route('perfil.editEntry') }}" enctype="multipart/form-data" class="mt-8">
        @method('PATCH')
        @csrf

        <!-- Información del Usuario -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información del Usuario</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @include('components.forms.string', [
                    'label' => 'Nombre de Usuario',
                    'name' => 'username',
                    'error' => $errors->first('username') ?? false,
                    'value' => old('username') ?? $data['default']['username']
                ])
                
                @include('components.forms.string', [
                    'label' => 'Email',
                    'name' => 'email',
                    'error' => $errors->first('email') ?? false,
                    'value' => old('email') ?? $data['default']['email']
                ])
                
                @include('components.forms.string', [
                    'label' => 'Teléfono',
                    'name' => 'telefono',
                    'error' => $errors->first('telefono') ?? false,
                    'value' => old('telefono') ?? $data['default']['telefono']
                ])
                
                @include('components.forms.combo', [
                    'label' => 'Estado',
                    'name' => 'estado',
                    'error' => $errors->first('estado') ?? false,
                    'value' => old('estado') ?? $data['default']['estado'],
                    'options' => [
                        ['id' => '1', 'nombre' => 'Activo'],
                        ['id' => '0', 'nombre' => 'Inactivo'],
                    ],
                    'options_attributes' => ['id', 'nombre']
                ])
            </div>

            <!-- Foto de Perfil -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Foto de Perfil</h4>
                <div class="flex items-center gap-6">
                    <img src="{{ $data['default']['foto_url'] }}" 
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    <div class="flex-1">
                        <input type="file" name="foto" accept="image/*"
                            class="block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">PNG, JPG hasta 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Personal -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información Personal</h3>
            </div>

            <!-- Datos Personales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'Código Personal',
                    'name' => 'codigo_personal',
                    'error' => $errors->first('codigo_personal') ?? false,
                    'value' => old('codigo_personal') ?? $personal->codigo_personal ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'DNI',
                    'name' => 'dni',
                    'error' => $errors->first('dni') ?? false,
                    'value' => old('dni') ?? $personal->dni ?? ''
                ])
                
                @include('components.forms.combo', [
                    'label' => 'Estado Civil',
                    'name' => 'estado_civil',
                    'error' => $errors->first('estado_civil') ?? false,
                    'value' => old('estado_civil') ?? $personal->estado_civil ?? '',
                    'options' => [
                        ['id' => 'S', 'nombre' => 'Soltero/a'],
                        ['id' => 'C', 'nombre' => 'Casado/a'],
                        ['id' => 'V', 'nombre' => 'Viudo/a'],
                        ['id' => 'D', 'nombre' => 'Divorciado/a'],
                    ],
                    'options_attributes' => ['id', 'nombre']
                ])
            </div>

            <!-- Nombres -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'Primer Nombre',
                    'name' => 'primer_nombre',
                    'error' => $errors->first('primer_nombre') ?? false,
                    'value' => old('primer_nombre') ?? $personal->primer_nombre ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Otros Nombres',
                    'name' => 'otros_nombres',
                    'error' => $errors->first('otros_nombres') ?? false,
                    'value' => old('otros_nombres') ?? $personal->otros_nombres ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Paterno',
                    'name' => 'apellido_paterno',
                    'error' => $errors->first('apellido_paterno') ?? false,
                    'value' => old('apellido_paterno') ?? $personal->apellido_paterno ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Materno',
                    'name' => 'apellido_materno',
                    'error' => $errors->first('apellido_materno') ?? false,
                    'value' => old('apellido_materno') ?? $personal->apellido_materno ?? ''
                ])
            </div>

            <!-- Contacto y Dirección -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'Dirección',
                    'name' => 'direccion',
                    'error' => $errors->first('direccion') ?? false,
                    'value' => old('direccion') ?? $personal->direccion ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Seguro Social',
                    'name' => 'seguro_social',
                    'error' => $errors->first('seguro_social') ?? false,
                    'value' => old('seguro_social') ?? $personal->seguro_social ?? ''
                ])
            </div>

            <!-- Información Laboral -->
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Información Laboral</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.date-picker', [
                        'label' => 'Fecha de Ingreso',
                        'error' => $errors->first(Str::snake('Fecha de Ingreso')) ?? false,
                        'value' => old(Str::snake('Fecha de Ingreso')) ?? $data['default']['fecha_ingreso']
                    ])
                    
                    @include('components.forms.combo', [
                        'label' => 'Departamento',
                        'name' => 'departamento',
                        'error' => $errors->first('departamento') ?? false,
                        'value' => old('departamento') ?? $personal->departamento ?? '',
                        'options' => [
                            ['id' => 'DIRECCION', 'nombre' => 'Dirección'],
                            ['id' => 'PRIMARIA', 'nombre' => 'Primaria'],
                            ['id' => 'SECUNDARIA', 'nombre' => 'Secundaria'],
                        ],
                        'options_attributes' => ['id', 'nombre']
                    ])
                    
                    @include('components.forms.combo', [
                        'label' => 'Categoría',
                        'name' => 'categoria',
                        'error' => $errors->first('categoria') ?? false,
                        'value' => old('categoria') ?? $personal->categoria ?? '',
                        'options' => [
                            ['id' => 'ADMINISTRATIVO', 'nombre' => 'Administrativo'],
                            ['id' => 'DOCENTE', 'nombre' => 'Docente'],
                            ['id' => 'DIRECTOR', 'nombre' => 'Director'],
                        ],
                        'options_attributes' => ['id', 'nombre']
                    ])
                </div>
            </div>
        </div>

        <!-- Seguridad -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cambiar Contraseña</h3>
            </div>
            
            @include('components.forms.password-change', [
                'user' => auth()->user(),
                'errors' => $errors
            ])
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ $data['return'] }}" 
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                ✕ Cancelar
            </a>
            <input form="form" type="submit" 
                class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700 transition-colors" 
                value="💾 Guardar Cambios">
        </div>
    </form>
</div>
@endsection

@section('custom-js')
<script>
    // Preview de imagen
    document.querySelector('input[name="foto"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('img[src*="foto_url"]').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

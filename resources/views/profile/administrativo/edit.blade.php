@extends('base.administrativo.blank')

@section('titulo')
Editar Perfil - Administrativo
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Editar Perfil Administrativo</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $data['id'] }} | Cargo: {{ $admin->cargo ?? 'N/A' }}</p>
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
                <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A23.937 23.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                @include('components.forms.image-upload', [
                    'label' => 'Foto de Perfil',
                    'name' => 'foto',
                    'error' => $errors->first('foto') ?? false,
                    'current_image' => $data['default']['foto_url'] ?? null,
                    'accept' => 'image/*',
                    'max_size' => '2MB'
                ])
            </div>
        </div>

        <!-- Información Personal -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.964 5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información Personal</h3>
            </div>

            <!-- Datos Personales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'DNI',
                    'name' => 'dni',
                    'error' => $errors->first('dni') ?? false,
                    'value' => old('dni') ?? $admin->dni ?? ''
                ])
                
                @include('components.forms.combo', [
                    'label' => 'Estado Civil',
                    'name' => 'estado_civil',
                    'error' => $errors->first('estado_civil') ?? false,
                    'value' => old('estado_civil') ?? $admin->estado_civil ?? '',
                    'options' => [
                        ['id' => 'S', 'nombre' => 'Soltero/a'],
                        ['id' => 'C', 'nombre' => 'Casado/a'],
                        ['id' => 'V', 'nombre' => 'Viudo/a'],
                        ['id' => 'D', 'nombre' => 'Divorciado/a'],
                    ],
                    'options_attributes' => ['id', 'nombre']
                ])
                
                @include('components.forms.string', [
                    'label' => 'Seguro Social',
                    'name' => 'seguro_social',
                    'error' => $errors->first('seguro_social') ?? false,
                    'value' => old('seguro_social') ?? $admin->seguro_social ?? ''
                ])
            </div>

            <!-- Nombres -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'Primer Nombre',
                    'name' => 'primer_nombre',
                    'error' => $errors->first('primer_nombre') ?? false,
                    'value' => old('primer_nombre') ?? $admin->primer_nombre ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Otros Nombres',
                    'name' => 'otros_nombres',
                    'error' => $errors->first('otros_nombres') ?? false,
                    'value' => old('otros_nombres') ?? $admin->otros_nombres ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Paterno',
                    'name' => 'apellido_paterno',
                    'error' => $errors->first('apellido_paterno') ?? false,
                    'value' => old('apellido_paterno') ?? $admin->apellido_paterno ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Materno',
                    'name' => 'apellido_materno',
                    'error' => $errors->first('apellido_materno') ?? false,
                    'value' => old('apellido_materno') ?? $admin->apellido_materno ?? ''
                ])
            </div>

            <!-- Contacto y Dirección -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('components.forms.string', [
                    'label' => 'Dirección',
                    'name' => 'direccion',
                    'error' => $errors->first('direccion') ?? false,
                    'value' => old('direccion') ?? $admin->direccion ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Teléfono Personal',
                    'name' => 'telefono_personal',
                    'error' => $errors->first('telefono_personal') ?? false,
                    'value' => old('telefono_personal') ?? $admin->telefono ?? ''
                ])
            </div>
        </div>

        <!-- Información Laboral -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información Laboral</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @include('components.forms.date-picker', [
                        'label' => 'Fecha de Ingreso',
                        'error' => $errors->first(Str::snake('Fecha de Ingreso')) ?? false,
                        'value' => old(Str::snake('Fecha de Ingreso')) ?? $data['default']['fecha_ingreso']
                    ])
                
                @include('components.forms.combo', [
                    'label' => 'Cargo',
                    'name' => 'cargo',
                    'error' => $errors->first('cargo') ?? false,
                    'value' => old('cargo') ?? $admin->cargo ?? '',
                    'options' => [
                        ['id' => 'SECRETARIO/A', 'nombre' => 'Secretario/a'],
                        ['id' => 'Director', 'nombre' => 'Director'],
                        ['id' => 'AUDITOR', 'nombre' => 'Auditor'],
                        ['id' => 'COORDINADOR', 'nombre' => 'Coordinador'],
                    ],
                    'options_attributes' => ['id', 'nombre']
                ])
                
                @include('components.forms.number', [
                    'label' => 'Sueldo (S/.)',
                    'name' => 'sueldo',
                    'error' => $errors->first('sueldo') ?? false,
                    'value' => old('sueldo') ?? $admin->sueldo ?? '',
                    'readonly' => true,
                    'step' => '0.01',
                    'min' => '0'
                ])
            </div>
        </div>

        <!-- Seguridad -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2V8a2 2 0 002-2V6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Seguridad</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gestiona la seguridad de tu cuenta</p>
                    </div>
                </div>
                <a href="{{ route('perfil.password.show') }}" 
                    class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-red-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-600 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Cambiar Contraseña
                </a>
            </div>
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

    // Formatear sueldo
    document.querySelector('input[name="sueldo"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d.]/g, '');
        e.target.value = value;
    });
</script>
@endsection

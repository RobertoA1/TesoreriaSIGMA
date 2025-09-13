@extends('base.administrativo.blank')

@section('titulo')
Editar Perfil - Familiar
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Editar Perfil Familiar</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $data['id'] }} | DNI: {{ $familiar->dni ?? 'N/A' }}</p>
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
                <div class="w-10 h-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información del Usuario</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                            class="block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 dark:file:bg-pink-900/30 dark:file:text-pink-400">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">PNG, JPG hasta 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Personal -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información Personal</h3>
            </div>

            <!-- DNI -->
            <div class="mb-6">
                <div class="max-w-md">
                    @include('components.forms.string', [
                        'label' => 'DNI',
                        'name' => 'dni',
                        'error' => $errors->first('dni') ?? false,
                        'value' => old('dni') ?? $familiar->dni ?? ''
                    ])
                </div>
            </div>

            <!-- Nombres -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @include('components.forms.string', [
                    'label' => 'Primer Nombre',
                    'name' => 'primer_nombre',
                    'error' => $errors->first('primer_nombre') ?? false,
                    'value' => old('primer_nombre') ?? $familiar->primer_nombre ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Otros Nombres',
                    'name' => 'otros_nombres',
                    'error' => $errors->first('otros_nombres') ?? false,
                    'value' => old('otros_nombres') ?? $familiar->otros_nombres ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Paterno',
                    'name' => 'apellido_paterno',
                    'error' => $errors->first('apellido_paterno') ?? false,
                    'value' => old('apellido_paterno') ?? $familiar->apellido_paterno ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Apellido Materno',
                    'name' => 'apellido_materno',
                    'error' => $errors->first('apellido_materno') ?? false,
                    'value' => old('apellido_materno') ?? $familiar->apellido_materno ?? ''
                ])
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información de Contacto</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('components.forms.string', [
                    'label' => 'Número de Contacto',
                    'name' => 'numero_contacto',
                    'error' => $errors->first('numero_contacto') ?? false,
                    'value' => old('numero_contacto') ?? $familiar->numero_contacto ?? ''
                ])
                
                @include('components.forms.string', [
                    'label' => 'Correo Electrónico Personal',
                    'name' => 'correo_electronico',
                    'error' => $errors->first('correo_electronico') ?? false,
                    'value' => old('correo_electronico') ?? $familiar->correo_electronico ?? ''
                ])
            </div>

            <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Información de Contacto</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                            Esta información será utilizada para comunicaciones importantes relacionadas con el estudiante.
                        </p>
                    </div>
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

    // Validación de DNI
    document.querySelector('input[name="dni"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 8) value = value.slice(0, 8);
        e.target.value = value;
    });

    // Validación de teléfono
    document.querySelector('input[name="numero_contacto"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d\s\-\+$$$$]/g, '');
        e.target.value = value;
    });
</script>
@endsection

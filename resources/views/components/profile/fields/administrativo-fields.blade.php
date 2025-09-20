<!-- Información Personal - Administrativo -->
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
            'error' => $errors?->first('dni') ?? false,
            'value' => old('dni') ?? $data['default']['dni'] ?? ''
        ])
        
        @include('components.forms.combo', [
            'label' => 'Estado Civil',
            'name' => 'estado_civil',
            'error' => $errors?->first('estado_civil') ?? false,
            'value' => old('estado_civil') ?? $data['default']['estado_civil'] ?? '',
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
            'error' => $errors?->first('seguro_social') ?? false,
            'value' => old('seguro_social') ?? $data['default']['seguro_social'] ?? ''
        ])
    </div>

    <!-- Nombres -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @include('components.forms.string', [
            'label' => 'Primer Nombre',
            'name' => 'primer_nombre',
            'error' => $errors?->first('primer_nombre') ?? false,
            'value' => old('primer_nombre') ?? $data['default']['primer_nombre'] ?? ''
        ])
        
        @include('components.forms.string', [
            'label' => 'Otros Nombres',
            'name' => 'otros_nombres',
            'error' => $errors?->first('otros_nombres') ?? false,
            'value' => old('otros_nombres') ?? $data['default']['otros_nombres'] ?? ''
        ])
        
        @include('components.forms.string', [
            'label' => 'Apellido Paterno',
            'name' => 'apellido_paterno',
            'error' => $errors?->first('apellido_paterno') ?? false,
            'value' => old('apellido_paterno') ?? $data['default']['apellido_paterno'] ?? ''
        ])
        
        @include('components.forms.string', [
            'label' => 'Apellido Materno',
            'name' => 'apellido_materno',
            'error' => $errors?->first('apellido_materno') ?? false,
            'value' => old('apellido_materno') ?? $data['default']['apellido_materno'] ?? ''
        ])
    </div>

    <!-- Contacto y Dirección -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @include('components.forms.string', [
            'label' => 'Dirección',
            'name' => 'direccion',
            'error' => $errors?->first('direccion') ?? false,
            'value' => old('direccion') ?? $data['default']['direccion'] ?? ''
        ])
        
        @include('components.forms.string', [
            'label' => 'Teléfono Personal',
            'name' => 'telefono_personal',
            'error' => $errors?->first('telefono_personal') ?? false,
            'value' => old('telefono_personal') ?? $data['default']['telefono_personal'] ?? ''
        ])
    </div>
</div>

<!-- Información Laboral - Administrativo -->
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
            'name' => 'fecha_ingreso',
            'error' => $errors?->first('fecha_ingreso') ?? false,
            'value' => old('fecha_ingreso') ?? $data['default']['fecha_ingreso'] ?? ''
        ])
        
        @include('components.forms.combo', [
            'label' => 'Cargo',
            'name' => 'cargo',
            'error' => $errors?->first('cargo') ?? false,
            'value' => old('cargo') ?? $data['default']['cargo'] ?? '',
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
            'error' => $errors?->first('sueldo') ?? false,
            'value' => old('sueldo') ?? $data['default']['sueldo'] ?? '',
            'readonly' => true,
            'step' => '0.01',
            'min' => '0'
        ])
    </div>
</div>
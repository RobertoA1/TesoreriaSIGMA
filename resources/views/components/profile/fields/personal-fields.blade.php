<!-- Información Personal - Personal -->
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
            'error' => $errors?->first('codigo_personal') ?? false,
            'value' => old('codigo_personal') ?? $data['default']['codigo_personal'] ?? ''
        ])
        
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        @include('components.forms.string', [
            'label' => 'Dirección',
            'name' => 'direccion',
            'error' => $errors?->first('direccion') ?? false,
            'value' => old('direccion') ?? $data['default']['direccion'] ?? ''
        ])
        
        @include('components.forms.string', [
            'label' => 'Seguro Social',
            'name' => 'seguro_social',
            'error' => $errors?->first('seguro_social') ?? false,
            'value' => old('seguro_social') ?? $data['default']['seguro_social'] ?? ''
        ])
    </div>

    <!-- Información Laboral -->
    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Información Laboral</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('components.forms.date-picker', [
                'label' => 'Fecha de Ingreso',
                'name' => 'fecha_ingreso',
                'error' => $errors?->first('fecha_ingreso') ?? false,
                'value' => old('fecha_ingreso') ?? $data['default']['fecha_ingreso'] ?? ''
            ])
            
            @include('components.forms.combo', [
                'label' => 'Departamento',
                'name' => 'departamento',
                'error' => $errors?->first('departamento') ?? false,
                'value' => old('departamento') ?? $data['default']['departamento'] ?? '',
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
                'error' => $errors?->first('categoria') ?? false,
                'value' => old('categoria') ?? $data['default']['categoria'] ?? '',
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
<!-- Información Específica del Familiar -->
<div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Información del Familiar</h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

        @include('components.forms.string', [
            'label' => 'DNI',
            'name' => 'dni',
            'error' => $errors?->first('dni') ?? false,
            'value' => old('dni') ?? $data['default']['dni'] ?? ''
        ])

        @include('components.forms.date', [
            'label' => 'Fecha de Nacimiento',
            'name' => 'fecha_nacimiento',
            'error' => $errors?->first('fecha_nacimiento') ?? false,
            'value' => old('fecha_nacimiento') ?? $data['default']['fecha_nacimiento'] ?? ''
        ])

        
    </div>

    <!-- Información de Contacto -->
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Información de Contacto</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @include('components.forms.string', [
                'label' => 'Número de Contacto',
                'name' => 'numero_contacto',
                'error' => $errors?->first('numero_contacto') ?? false,
                'value' => old('numero_contacto') ?? $data['default']['numero_contacto'] ?? ''
            ])
            
            @include('components.forms.string', [
                'label' => 'Correo Electrónico Personal',
                'name' => 'correo_electronico',
                'error' => $errors?->first('correo_electronico') ?? false,
                'value' => old('correo_electronico') ?? $data['default']['correo_electronico'] ?? ''
            ])
        </div>

        <!-- Información adicional para familiares -->
        <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-green-800 dark:text-green-200">Información de Contacto</h4>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                        Esta información será utilizada para comunicaciones importantes relacionadas con el estudiante.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
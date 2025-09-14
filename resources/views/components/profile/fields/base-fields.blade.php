<!-- Información Base del Usuario (Común para todos los tipos) -->
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
            'error' => $errors?->first('username') ?? false,
            'value' => old('username') ?? $data['default']['username']
        ])

        @include('components.forms.combo', [
            'label' => 'Estado',
            'name' => 'estado',
            'error' => $errors?->first('estado') ?? false,
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
            'name' => 'foto',
            'label' => 'Foto de Perfil',
            'current_image' => $data['default']['foto_url'] ?? null,
            'error' => $errors?->first('foto') ?? false
        ])
    </div>
</div>
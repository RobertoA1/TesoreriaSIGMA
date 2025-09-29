<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br 
                @if($profileType == 'administrativo') from-emerald-500 to-teal-600
                @elseif($profileType == 'familiar') from-pink-500 to-rose-600
                @else from-blue-500 to-purple-600
                @endif 
                flex items-center justify-center">
                @if($profileType == 'administrativo')
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                    </svg>
                @elseif($profileType == 'familiar')
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                @else
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">
                    {{ $title ?? 'Editar Perfil - ' . ucfirst($profileType) }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    ID: {{ $data['id'] }} | {{ $subtitle ?? 'Perfil de ' . ucfirst($profileType) }}
                </p>
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

    <!-- Formulario -->
    <form method="POST" id="form" action="{{ route('perfil.editEntry') }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <!-- Información Base del Usuario (Común para todos) -->
        @include('components.profile.fields.base-fields', [
            'data' => $data,
            'errors' => $errors
        ])

        <!-- Información Específica del Perfil según el tipo -->
        @if($profileType)
            @include('components.profile.fields.' . $profileType . '-fields', [
                'data' => $data,
                'errors' => $errors,
                'user' => $user
            ])
        @endif

        <!-- Sección de Seguridad (Común para todos) -->
        @include('components.profile.fields.security-section', [
            'data' => $data
        ])

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
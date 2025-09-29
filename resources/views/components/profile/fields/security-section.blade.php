<!-- Sección de Seguridad (Común para todos los tipos) -->
<div class="mb-8 bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Seguridad</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gestiona la seguridad de tu cuenta</p>
            </div>
        </div>
        <a href="{{ route('perfil.password.form') ?? route('perfil.password.form') ?? '#' }}" 
            class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-red-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-600 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            Cambiar Contraseña
        </a>
    </div>
</div>
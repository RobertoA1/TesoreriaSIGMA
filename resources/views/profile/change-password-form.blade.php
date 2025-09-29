<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2V8a2 2 0 002-2V6"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Cambiar Contraseña</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Actualiza tu contraseña de forma segura</p>
            </div>
        </div>
        <a href="{{ $returnUrl }}" 
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors">
            ← Volver al Perfil
        </a>
    </div>

    <!-- Password Change Form -->
    <div class="max-w-2xl">
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('perfil.password.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <!-- Current Password -->
            <div class="bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Contraseña Actual</h3>
                
                <div class="relative">
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pr-12 {{ $errors?->has('current_password') ? 'border-red-500 focus:ring-red-500' : '' }}"
                           placeholder="Ingresa tu contraseña actual">
                    
                    <button type="button" 
                            onclick="togglePassword('current_password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                
                @if($errors?->has('current_password'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center animate-pulse">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $errors->first('current_password') }}
                    </p>
                @endif
            </div>
            
            <!-- New Password -->
            <div class="bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Nueva Contraseña</h3>
                
                <div class="space-y-4">
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               oninput="checkPasswordStrength(this.value)"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pr-12 {{ $errors?->has('password') ? 'border-red-500 focus:ring-red-500' : '' }}"
                               placeholder="Ingresa tu nueva contraseña">
                        
                        <button type="button" 
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Fortaleza de la contraseña:</span>
                            <span id="strength-text" class="font-medium">Débil</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div id="strength-bar" class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        
                        <!-- Requirements -->
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div id="req-length" class="flex items-center text-gray-500">
                                <span class="w-4 h-4 mr-1">○</span> 8+ caracteres
                            </div>
                            <div id="req-upper" class="flex items-center text-gray-500">
                                <span class="w-4 h-4 mr-1">○</span> Mayúsculas
                            </div>
                            <div id="req-lower" class="flex items-center text-gray-500">
                                <span class="w-4 h-4 mr-1">○</span> Minúsculas
                            </div>
                            <div id="req-number" class="flex items-center text-gray-500">
                                <span class="w-4 h-4 mr-1">○</span> Números
                            </div>
                            <div id="req-symbol" class="flex items-center text-gray-500">
                                <span class="w-4 h-4 mr-1">○</span> Símbolos
                            </div>
                        </div>
                    </div>
                    
                    @if($errors?->has('password'))
                        <p class="text-sm text-red-600 dark:text-red-400 flex items-center animate-pulse">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- Confirm Password -->
            <div class="bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Confirmar Nueva Contraseña</h3>
                
                <div class="relative">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           oninput="checkPasswordMatch()"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pr-12"
                           placeholder="Confirma tu nueva contraseña">
                    
                    <button type="button" 
                            onclick="togglePassword('password_confirmation')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="match-indicator" class="mt-2 text-sm hidden">
                    <span id="match-text"></span>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-6">
                <a href="{{ $returnUrl }}" 
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700 transition-colors">
                    🔒 Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
}

function checkPasswordStrength(password) {
    const requirements = {
        length: password.length >= 8,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        number: /\d/.test(password),
        symbol: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    
    // Update requirement indicators
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(`req-${req}`);
        if (requirements[req]) {
            element.classList.remove('text-gray-500');
            element.classList.add('text-green-600', 'dark:text-green-400');
            element.querySelector('span').textContent = '✓';
        } else {
            element.classList.remove('text-green-600', 'dark:text-green-400');
            element.classList.add('text-gray-500');
            element.querySelector('span').textContent = '○';
        }
    });
    
    // Calculate strength
    const score = Object.values(requirements).filter(Boolean).length;
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    let width, color, text;
    
    switch(score) {
        case 0:
        case 1:
            width = '20%';
            color = 'bg-red-500';
            text = 'Muy débil';
            break;
        case 2:
            width = '40%';
            color = 'bg-orange-500';
            text = 'Débil';
            break;
        case 3:
            width = '60%';
            color = 'bg-yellow-500';
            text = 'Regular';
            break;
        case 4:
            width = '80%';
            color = 'bg-blue-500';
            text = 'Fuerte';
            break;
        case 5:
            width = '100%';
            color = 'bg-green-500';
            text = 'Muy fuerte';
            break;
    }
    
    strengthBar.style.width = width;
    strengthBar.className = `h-2 rounded-full transition-all duration-300 ${color}`;
    strengthText.textContent = text;
    strengthText.className = `font-medium ${color.replace('bg-', 'text-')}`;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const indicator = document.getElementById('match-indicator');
    const matchText = document.getElementById('match-text');
    
    if (confirmation.length > 0) {
        indicator.classList.remove('hidden');
        
        if (password === confirmation) {
            matchText.textContent = '✓ Las contraseñas coinciden';
            matchText.className = 'text-green-600 dark:text-green-400 flex items-center';
        } else {
            matchText.textContent = '✗ Las contraseñas no coinciden';
            matchText.className = 'text-red-600 dark:text-red-400 flex items-center';
        }
    } else {
        indicator.classList.add('hidden');
    }
}
</script>
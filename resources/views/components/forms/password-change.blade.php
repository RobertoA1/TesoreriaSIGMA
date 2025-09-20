@props([
    'user' => null,
    'errors' => null
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center mb-6">
        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Cambiar Contraseña</h3>
            <p class="text-sm text-gray-600">Actualiza tu contraseña para mantener tu cuenta segura</p>
        </div>
    </div>

    <form method="POST" action="{{ route('perfil.password.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Contraseña Actual -->
        <div class="form-group">
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                Contraseña Actual
                <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <!-- Fixed input element to use proper HTML syntax -->
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    required
                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 {{ $errors && $errors->has('current_password') ? 'border-red-500' : '' }}"
                    placeholder="Ingresa tu contraseña actual">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="current_password">
                    <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            @if($errors && $errors->has('current_password'))
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->first('current_password') }}
                </p>
            @endif
        </div>

        <!-- Nueva Contraseña -->
        <div class="form-group">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Nueva Contraseña
                <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <!-- Fixed input element to use proper HTML syntax -->
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    minlength="8"
                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 {{ $errors && $errors->has('password') ? 'border-red-500' : '' }}"
                    placeholder="Mínimo 8 caracteres">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password">
                    <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Indicador de fortaleza de contraseña -->
            <div class="mt-2">
                <div class="flex items-center space-x-2">
                    <div class="flex-1">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="password-strength-bar" class="h-2 rounded-full transition-all duration-300 bg-gray-300" style="width: 0%"></div>
                        </div>
                    </div>
                    <span id="password-strength-text" class="text-xs text-gray-500">Débil</span>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Usa al menos 8 caracteres con una mezcla de letras, números y símbolos
                </p>
            </div>
            
            @if($errors && $errors->has('password'))
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Confirmar Nueva Contraseña -->
        <div class="form-group">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Confirmar Nueva Contraseña
                <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <!-- Fixed input element to use proper HTML syntax -->
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 {{ $errors && $errors->has('password_confirmation') ? 'border-red-500' : '' }}"
                    placeholder="Confirma tu nueva contraseña">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password_confirmation">
                    <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <div id="password-match" class="mt-1 text-sm hidden">
                <span id="password-match-text"></span>
            </div>
            @if($errors && $errors->has('password_confirmation'))
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                Cambiar Contraseña
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('svg');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });
    });

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    
    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${strength.color}`;
            strengthText.textContent = strength.text;
            strengthText.className = `text-xs ${strength.textColor}`;
        });
    }

    // Password confirmation match
    const confirmInput = document.getElementById('password_confirmation');
    const matchDiv = document.getElementById('password-match');
    const matchText = document.getElementById('password-match-text');
    
    function checkPasswordMatch() {
        if (passwordInput && confirmInput && matchDiv && matchText) {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (confirm.length > 0) {
                matchDiv.classList.remove('hidden');
                if (password === confirm) {
                    matchText.textContent = '✓ Las contraseñas coinciden';
                    matchText.className = 'text-green-600 flex items-center';
                } else {
                    matchText.textContent = '✗ Las contraseñas no coinciden';
                    matchText.className = 'text-red-600 flex items-center';
                }
            } else {
                matchDiv.classList.add('hidden');
            }
        }
    }
    
    if (passwordInput && confirmInput) {
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmInput.addEventListener('input', checkPasswordMatch);
    }

    function calculatePasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score += 25;
        if (password.length >= 12) score += 25;
        if (/[a-z]/.test(password)) score += 10;
        if (/[A-Z]/.test(password)) score += 10;
        if (/[0-9]/.test(password)) score += 15;
        if (/[^A-Za-z0-9]/.test(password)) score += 15;
        
        if (score < 30) {
            return { percentage: score, color: 'bg-red-500', text: 'Débil', textColor: 'text-red-600' };
        } else if (score < 60) {
            return { percentage: score, color: 'bg-yellow-500', text: 'Regular', textColor: 'text-yellow-600' };
        } else if (score < 90) {
            return { percentage: score, color: 'bg-blue-500', text: 'Buena', textColor: 'text-blue-600' };
        } else {
            return { percentage: score, color: 'bg-green-500', text: 'Excelente', textColor: 'text-green-600' };
        }
    }
});
</script>

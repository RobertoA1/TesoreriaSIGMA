@props([
    'name' => 'foto',
    'label' => null,
    'error' => false,
    'currentImage' => auth()->user()->foto 
        ? asset('storage/users/' . auth()->user()->foto) 
        : asset('images/placeholder.svg'), 
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'required' => false,
    'help' => 'PNG, JPG hasta 2MB',
    'readonly' => true
])

<div class="mb-6">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
            {{ $label }}
            @if($required && !$readonly)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    <div class="flex items-center gap-6">
        <!-- Image Preview with Click to Upload -->
        <div class="relative group">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gray-100 dark:bg-gray-800 {{ !$readonly ? 'cursor-pointer' : 'cursor-default' }}">
                <img id="preview-{{ $name }}" 
                     src="{{ $currentImage }}" 
                     class="w-full h-full object-cover transition-all duration-300"
                     alt="Preview">
                
                <!-- Hover Overlay for Upload -->
                @if(!$readonly)
                    <!-- <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                            <svg class="w-6 h-6 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-white text-xs font-medium">Cambiar</span>
                        </div>
                    </div> -->
                
                    <!-- Hidden File Input -->
                    <input type="file" 
                           id="{{ $name }}" 
                           name="{{ $name }}" 
                           accept="{{ $accept }}"
                           @if($required) required @endif
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                @endif
                
                <!-- Loading Overlay -->
                <div id="loading-{{ $name }}" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                </div>
            </div>
            
            <!-- Remove Button -->
            @if(!$readonly)
                <button type="button" 
                        id="remove-{{ $name }}"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors hidden">
                    ×
                </button>
            @endif
        </div>
    </div>
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(!$readonly)
        const input = document.getElementById('{{ $name }}');
        const preview = document.getElementById('preview-{{ $name }}');
        const loading = document.getElementById('loading-{{ $name }}');
        const removeBtn = document.getElementById('remove-{{ $name }}');
        let originalSrc = preview.src;
        
        // Funcionalidad de click para subir archivo
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Show loading
                loading.classList.remove('hidden');
                
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. Máximo {{ $maxSize }}.');
                    input.value = '';
                    loading.classList.add('hidden');
                    return;
                }
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Por favor selecciona una imagen válida.');
                    input.value = '';
                    loading.classList.add('hidden');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    setTimeout(() => {
                        preview.src = e.target.result;
                        loading.classList.add('hidden');
                        removeBtn.classList.remove('hidden');
                        
                        // Add animation
                        preview.style.transform = 'scale(0.8)';
                        preview.style.opacity = '0.5';
                        setTimeout(() => {
                            preview.style.transform = 'scale(1)';
                            preview.style.opacity = '1';
                        }, 100);
                    }, 500); // Simulate loading time
                };
                reader.readAsDataURL(file);
            }
        });
        
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            input.value = '';
            preview.src = originalSrc;
            removeBtn.classList.add('hidden');
            
            // Add animation
            preview.style.transform = 'scale(1.1)';
            setTimeout(() => {
                preview.style.transform = 'scale(1)';
            }, 200);
        });
    @endif
});
</script>

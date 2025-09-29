@props([
    'label' => 'Foto de Perfil',
    'name' => 'foto',
    'error' => false,
    'currentImage' => auth()->user()->foto 
        ? asset('storage/users/' . auth()->user()->foto) 
        : asset('images/placeholder.svg'), 
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'required' => false,
    'help' => 'PNG, JPG hasta 2MB'
])

<div class="mb-6">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    <div class="flex items-center gap-6">
        <!-- Image Preview -->
        <div class="relative">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gray-100 dark:bg-gray-800">
                <img id="preview-{{ $name }}" 
                     src="{{ $currentImage }}" 
                     class="w-full h-full object-cover transition-all duration-300"
                     alt="Preview">
                
                <!-- Loading Overlay -->
                <div id="loading-{{ $name }}" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                </div>
            </div>
            
            <!-- Remove Button -->
            <button type="button" 
                    id="remove-{{ $name }}"
                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors hidden">
                ×
            </button>
        </div>
        
        <!-- Upload Area -->
        <div class="flex-1">
            <div class="relative">
                <input type="file" 
                       id="{{ $name }}" 
                       name="{{ $name }}" 
                       accept="{{ $accept }}"
                       @if($required) required @endif
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors duration-200 bg-gray-50 dark:bg-gray-800/50">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium text-blue-600 dark:text-blue-400">Haz clic para subir</span>
                        o arrastra y suelta
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $help }}</p>
                </div>
            </div>
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
    const input = document.getElementById('{{ $name }}');
    const preview = document.getElementById('preview-{{ $name }}');
    const loading = document.getElementById('loading-{{ $name }}');
    const removeBtn = document.getElementById('remove-{{ $name }}');
    let originalSrc = preview.src;
    
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
    
    removeBtn.addEventListener('click', function() {
        input.value = '';
        preview.src = originalSrc;
        removeBtn.classList.add('hidden');
        
        // Add animation
        preview.style.transform = 'scale(1.1)';
        setTimeout(() => {
            preview.style.transform = 'scale(1)';
        }, 200);
    });
    
    // Drag and drop functionality
    const dropZone = input.parentElement;
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropZone.querySelector('div').classList.add('border-blue-400', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropZone.querySelector('div').classList.remove('border-blue-400', 'bg-blue-50');
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files;
        input.dispatchEvent(new Event('change'));
    }
});
</script>

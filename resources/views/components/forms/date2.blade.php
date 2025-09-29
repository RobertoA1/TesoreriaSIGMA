

@props([
    'label' => '',
    'name' => '',
    'error' => false,
    'value' => '',
    'required' => false,
    'min' => '',
    'max' => '',
    'placeholder' => ''
])

<div class="mb-4">
    <P>NO USANDO</P>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="relative">
        <input 
            type="date" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            @if($min) min="{{ $min }}" @endif
            @if($max) max="{{ $max }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-gray-900 {{ $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
        >
        
        <!-- Calendar Icon -->
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    </div>
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 flex items-center">
            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
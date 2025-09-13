@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'error' => false,
    'placeholder' => '',
    'step' => '1',
    'min' => null,
    'max' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'help' => '',
    'prefix' => '',
    'suffix' => '',
    'class' => ''
])

<div class="form-group mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($prefix)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $prefix }}</span>
            </div>
        @endif
        
        <!-- Fixed input element to use proper HTML syntax instead of JSX -->
        <input 
            type="number" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            step="{{ $step }}"
            @if($min !== null) min="{{ $min }}" @endif
            @if($max !== null) max="{{ $max }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ $prefix ? 'pl-8' : '' }} {{ $suffix ? 'pr-8' : '' }} {{ $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }} {{ $class }}">
        
        @if($suffix)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $suffix }}</span>
            </div>
        @endif
    </div>
    
    @if($help && !$error)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>

<div>
    @if ($error)
        <p class="py-2 text-red-700 dark:text-red-200">{{ $error }}</p>
    @endif

    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>
    
    <input 
        @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif
        @if(isset($value)) value="{{ $value }}" @endif
        type="text" 
        name="{{ isset($name) ? Str::snake($name) : Str::snake($label) }}" 
        @if(!empty($readonly) && $readonly) readonly @endif
        
        class="text-{{$label}} 
            dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 
            dark:focus:border-brand-800 h-11 w-full rounded-lg border 
            px-4 py-2.5 text-sm placeholder:text-gray-400 focus:ring-3 focus:outline-hidden 
            {{ $error ? 'border-red-700 dark:border-red-200' : 'border-gray-300 dark:border-gray-700' }}
            {{ !empty($readonly) && $readonly 
                ? 'bg-gray-200 text-gray-600 border-gray-400 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 cursor-not-allowed' 
                : 'bg-transparent text-gray-800 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30' }}"
    />
</div>

<div>
    @if ($error)
      <p class="py-2 text-red-700 dark:text-red-200">{{ $error }}</p>
    @endif

    <label for="" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>
    <input 
        @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif 
        @if(isset($value)) value="{{ old($name, $value ?? '') }}" @endif 
        type="text" 
        name="{{ $name ?? Str::snake($label) }}"
        @if(!empty($readonly) && $readonly) readonly @endif
        class="text-{{$label}} dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @if($error) border-red-700 dark:border-red-200 @endif" 
    /></div>
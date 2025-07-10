<div class="form-group">
    @if ($error)
        <p class="py-2 text-red-700 dark:text-red-200">{{ $error }}</p>
    @endif
    
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>
    
    <div class="searchable-select-container relative" data-name="{{ Str::snake($label) }}">
        <!-- Input principal -->
        <div class="relative">
            <input 
                type="text" 
                class="searchable-select-input h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 pr-12 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white/90 dark:placeholder:text-white/40 @if($error) border-red-500 dark:border-red-400 @endif" 
                placeholder="Buscar {{ strtolower($label) }}..."
                autocomplete="off"
                data-value="{{ $value ?? '' }}"
                readonly
                style="cursor: pointer;"
            >
            <div class="searchable-select-arrow absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        
        <!-- Dropdown -->
        <div class="searchable-select-dropdown absolute top-full left-0 right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-50" style="display: none;">
            <!-- Campo de búsqueda -->
            <div class="p-3 border-b border-gray-200 dark:border-gray-600">
                <input 
                    type="text" 
                    class="searchable-select-search w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-500 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-white/40 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500/20"
                    placeholder="Buscar..."
                    autocomplete="off"
                >
            </div>
            
            <!-- Lista de opciones -->
            <div class="searchable-select-options max-h-60 overflow-y-auto">
                @foreach($options as $option)
                    @php
                        // FIXED: Handle both objects and arrays
                        if (is_object($option)) {
                            // If it's an object, use object notation
                            $optionValue = $option->{$options_attributes[0]};
                            $optionText = $option->{$options_attributes[1]};
                        } else {
                            // If it's an array, use array notation
                            $optionValue = $option[$options_attributes[0]];
                            $optionText = $option[$options_attributes[1]];
                        }
                    @endphp
                    
                    <div class="searchable-select-option px-4 py-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border-t border-gray-100 dark:border-gray-600 first:border-t-0" 
                         data-value="{{ $optionValue }}"
                         data-text="{{ $optionText }}">
                        <div class="flex justify-between items-center">
                            <span>{{ $optionText }}</span>
                            <span class="selected-icon hidden text-blue-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Input hidden -->
        <input type="hidden" name="{{ isset($name) ? Str::snake($name) : Str::snake($label) }}" value="{{ $value ?? '' }}">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.searchable-select-container');
    
    containers.forEach(container => {
        initSearchableSelect(container);
    });
    
    function initSearchableSelect(container) {
        const input = container.querySelector('.searchable-select-input');
        const searchInput = container.querySelector('.searchable-select-search');
        const dropdown = container.querySelector('.searchable-select-dropdown');
        const hiddenInput = container.querySelector('input[type="hidden"]');
        const options = container.querySelectorAll('.searchable-select-option');
        const arrow = container.querySelector('.searchable-select-arrow svg');
        
        let isOpen = false;
        let selectedValue = input.dataset.value || '';
        
        // CONDITIONAL: Only set initial value if there's actually a value (edit mode)
        function setInitialValue() {
            // Check if we have a meaningful value (not empty, null, or undefined)
            if (selectedValue && selectedValue !== '' && selectedValue !== 'null' && selectedValue !== 'undefined') {
                // This is likely edit mode - find and select the matching option
                const selectedOption = Array.from(options).find(option => 
                    String(option.dataset.value) === String(selectedValue)
                );
                
                if (selectedOption) {
                    const optionText = selectedOption.dataset.text;
                    input.value = optionText;
                    selectedOption.classList.add('selected');
                    const icon = selectedOption.querySelector('.selected-icon');
                    if (icon) icon.classList.remove('hidden');
                    
                    // Ensure hidden input has the correct value
                    hiddenInput.value = selectedValue;
                }
            } else {
                // This is likely create mode - leave everything empty
                input.value = '';
                hiddenInput.value = '';
                
                // Make sure no options are selected
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    const icon = opt.querySelector('.selected-icon');
                    if (icon) icon.classList.add('hidden');
                });
            }
        }
        
        // Set initial value when component loads
        setInitialValue();
        
        // Open/close dropdown
        input.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });
        
        // Real-time search
        searchInput.addEventListener('input', function() {
            filterOptions(this.value);
        });
        
        // Option selection
        options.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                selectOption(this);
            });
        });
        
        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!container.contains(e.target)) {
                closeDropdown();
            }
        });
        
        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const visibleOptions = Array.from(options).filter(opt => 
                opt.style.display !== 'none'
            );
            let currentIndex = visibleOptions.findIndex(opt => 
                opt.classList.contains('highlighted')
            );
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    currentIndex = currentIndex < visibleOptions.length - 1 ? currentIndex + 1 : 0;
                    highlightOption(visibleOptions[currentIndex]);
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    currentIndex = currentIndex > 0 ? currentIndex - 1 : visibleOptions.length - 1;
                    highlightOption(visibleOptions[currentIndex]);
                    break;
                    
                case 'Enter':
                    e.preventDefault();
                    const highlighted = container.querySelector('.searchable-select-option.highlighted');
                    if (highlighted) {
                        selectOption(highlighted);
                    }
                    break;
                    
                case 'Escape':
                    e.preventDefault();
                    closeDropdown();
                    break;
            }
        });
        
        function openDropdown() {
            dropdown.style.display = 'block';
            if (arrow) arrow.style.transform = 'rotate(180deg)';
            isOpen = true;
            
            // Clear search and show all options
            searchInput.value = '';
            filterOptions('');
            
            // Focus on search input
            setTimeout(() => searchInput.focus(), 100);
        }
        
        function closeDropdown() {
            dropdown.style.display = 'none';
            if (arrow) arrow.style.transform = 'rotate(0deg)';
            isOpen = false;
            
            // Clear any highlighting
            options.forEach(opt => opt.classList.remove('highlighted'));
        }
        
        function selectOption(option) {
            // Clear previous selection
            options.forEach(opt => {
                opt.classList.remove('selected', 'highlighted');
                const icon = opt.querySelector('.selected-icon');
                if (icon) icon.classList.add('hidden');
            });
            
            // Select new option
            option.classList.add('selected');
            const icon = option.querySelector('.selected-icon');
            if (icon) icon.classList.remove('hidden');
            
            selectedValue = option.dataset.value;
            const optionText = option.dataset.text;
            
            input.value = optionText;
            hiddenInput.value = selectedValue;
            
            closeDropdown();
            
            // Trigger change event
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
        
        function highlightOption(option) {
            options.forEach(opt => opt.classList.remove('highlighted'));
            if (option) {
                option.classList.add('highlighted');
            }
        }
        
        function filterOptions(searchTerm) {
            const term = searchTerm.toLowerCase().trim();
            
            options.forEach(option => {
                const text = option.dataset.text.toLowerCase();
                const shouldShow = !term || text.includes(term);
                option.style.display = shouldShow ? 'block' : 'none';
            });
        }
    }
});
</script>

<style>
/* Base styles */
.relative { position: relative; }
.absolute { position: absolute; }
.inset-y-0 { top: 0; bottom: 0; }
.top-full { top: 100%; }
.left-0 { left: 0; }
.right-0 { right: 0; }
.z-50 { z-index: 50; }
.mt-1 { margin-top: 0.25rem; }
.flex { display: flex; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.w-full { width: 100%; }
.w-4 { width: 1rem; }
.w-5 { width: 1.25rem; }
.h-4 { height: 1rem; }
.h-5 { height: 1.25rem; }
.h-11 { height: 2.75rem; }
.max-h-60 { max-height: 15rem; }
.overflow-y-auto { overflow-y: auto; }
.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
.py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
.pr-3 { padding-right: 0.75rem; }
.pr-12 { padding-right: 3rem; }
.p-3 { padding: 0.75rem; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.rounded-lg { border-radius: 0.5rem; }
.rounded-md { border-radius: 0.375rem; }
.border { border-width: 1px; }
.border-t { border-top-width: 1px; }
.border-b { border-bottom-width: 1px; }
.first\:border-t-0:first-child { border-top-width: 0; }
.shadow-lg { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
.cursor-pointer { cursor: pointer; }
.pointer-events-none { pointer-events: none; }
.hidden { display: none; }
.transition-transform { transition-property: transform; }
.duration-200 { transition-duration: 200ms; }

/* Selection states */
.searchable-select-option.selected {
    background-color: #eff6ff !important;
    color: #1d4ed8 !important;
}

.searchable-select-option.highlighted {
    background-color: #f3f4f6 !important;
    color: #374151 !important;
}

.dark .searchable-select-option.selected {
    background-color: #1e3a8a !important;
    color: #dbeafe !important;
}

.dark .searchable-select-option.highlighted {
    background-color: #4b5563 !important;
    color: #f9fafb !important;
}

/* Smooth transitions */
.searchable-select-option {
    transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
}
</style>
@props([
    'name',
    'options' => [], // Array of ['value' => '...', 'label' => '...']
    'value' => null,
    'placeholder' => 'Pilih Opsi',
    'searchable' => true,
    'required' => false,
    'id' => null
])

@php
    $id = $id ?? $name;
    // Normalize options to handle different formats
    $normalizedOptions = collect($options)->map(function($option) {
        if (is_array($option)) {
            return [
                'value' => $option['value'] ?? ($option['unit_id'] ?? ($option['id'] ?? '')),
                'label' => $option['label'] ?? ($option['unit_nama'] ?? ($option['name'] ?? ''))
            ];
        }
        return ['value' => $option, 'label' => $option];
    })->values()->toArray();
@endphp

<div x-data="customSelectComponent({ 
    data: {{ json_encode($normalizedOptions) }}, 
    selectedValue: '{{ old($name, $value) }}' 
})" class="relative w-full group">
    
    @if($required)
        <input type="hidden" name="{{ $name }}" x-model="selectedValue" required>
    @else
        <input type="hidden" name="{{ $name }}" x-model="selectedValue">
    @endif

    <button type="button" 
        @click="open = !open" 
        @keydown.escape="open = false"
        class="relative w-full bg-white border border-gray-300 rounded-xl shadow-sm pl-4 pr-10 py-3 text-left cursor-default focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm transition-all duration-200 group-hover:border-gray-400">
        
        <span class="flex items-center">
            <span class="block truncate text-gray-700" 
                  :class="selectedLabel ? 'text-gray-900 font-medium' : 'text-gray-400'"
                  x-text="selectedLabel || '{{ $placeholder }}'">
            </span>
        </span>
        
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <div x-show="open" 
        @click.away="open = false" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute mt-2 w-full rounded-xl bg-white shadow-2xl z-[100] border border-gray-100 overflow-hidden ring-1 ring-black ring-opacity-5"
        x-cloak>
        
        @if($searchable)
        <div class="p-2 bg-gray-50 border-b border-gray-100">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-xs"></i>
                </div>
                <input type="text" 
                    x-model="search" 
                    @click.stop 
                    @keydown.enter.prevent
                    placeholder="Cari..." 
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>
        </div>
        @endif

        <ul class="max-h-60 py-1 text-base overflow-auto focus:outline-none sm:text-sm custom-scrollbar" tabindex="-1">
            <template x-for="item in filteredData" :key="item.value">
                <li @click="select(item)" 
                    class="text-gray-900 cursor-default select-none relative py-2.5 pl-4 pr-10 hover:bg-blue-600 hover:text-white transition-colors duration-150 group/item">
                    
                    <span class="block truncate" 
                          :class="selectedValue == item.value ? 'font-bold' : 'font-normal'"
                          x-text="item.label">
                    </span>

                    <span x-show="selectedValue == item.value" 
                          class="absolute inset-y-0 right-0 flex items-center pr-3"
                          :class="selectedValue == item.value ? 'text-blue-600 group-hover/item:text-white' : ''">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
            </template>
            
            <template x-if="filteredData.length === 0">
                <li class="px-4 py-6 text-sm text-gray-500 text-center italic flex flex-col items-center">
                    <i class="fas fa-search-minus text-gray-300 text-2xl mb-2"></i>
                    {{ __('Data tidak ditemukan.') }}
                </li>
            </template>
        </ul>
    </div>
</div>

@once
<script>
    document.addEventListener('alpine:init', () => {
        if (!Alpine.store('customSelectInitialized')) {
            Alpine.data('customSelectComponent', (config) => ({
                open: false,
                search: '',
                allData: config.data || [],
                selectedValue: config.selectedValue || null,
                
                get selectedLabel() {
                    if (!this.selectedValue) return null;
                    const selected = this.allData.find(item => String(item.value) === String(this.selectedValue));
                    return selected ? selected.label : null;
                },
                
                get filteredData() {
                    const term = this.search.toLowerCase().trim();
                    if (!term) return this.allData;
                    return this.allData.filter(item => 
                        item.label && item.label.toLowerCase().includes(term)
                    );
                },
                
                select(item) {
                    this.selectedValue = String(item.value);
                    this.open = false;
                    this.search = '';
                    // Dispatch event for parent components if needed
                    this.$el.dispatchEvent(new CustomEvent('change', {
                        detail: { value: this.selectedValue, item: item },
                        bubbles: true
                    }));
                }
            }));
            Alpine.store('customSelectInitialized', true);
        }
    });
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endonce

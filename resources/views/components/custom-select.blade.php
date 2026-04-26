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
    $normalizedOptions = collect($options)->map(function($option) {
        if (is_array($option)) {
            $val = $option['value'] ?? ($option['unit_id'] ?? ($option['id'] ?? ''));
            $lbl = $option['label'] ?? ($option['unit_nama'] ?? ($option['name'] ?? ''));
            return array_merge($option, ['value' => $val, 'label' => $lbl]);
        }
        return ['value' => $option, 'label' => $option];
    })->values()->toArray();

    $shouldShowSearch = $searchable && count($normalizedOptions) > 5;
@endphp

<div x-data="customSelectComponent({ 
    data: {{ json_encode($normalizedOptions) }}, 
    selectedValue: '{{ old($name, $value) }}' 
})" class="relative w-full" @click.away="open = false">
    
    @if($required)
        <input type="hidden" name="{{ $name }}" x-model="selectedValue" required>
    @else
        <input type="hidden" name="{{ $name }}" x-model="selectedValue">
    @endif

    {{-- Trigger Button --}}
    <button type="button" 
        @click="open = !open" 
        @keydown.escape="open = false"
        class="relative w-full bg-white border-2 border-gray-100 rounded-2xl shadow-sm pl-5 pr-12 py-4 text-left cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 sm:text-base transition-all duration-300 group">
        
        <span class="flex items-center">
            <span class="block truncate transition-colors duration-300" 
                  :class="selectedLabel ? 'text-gray-900 font-bold' : 'text-gray-400 font-medium'"
                  x-text="selectedLabel || '{{ $placeholder }}'">
            </span>
        </span>
        
        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
            <div class="p-1 rounded-lg bg-gray-50 group-hover:bg-blue-50 transition-colors duration-300">
                <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-transform duration-300" 
                     :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </span>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="absolute mt-3 w-full rounded-2xl bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] z-[9999] border border-gray-100 overflow-hidden ring-1 ring-black/5"
        x-cloak>

        @if($shouldShowSearch)
        <div class="p-3 bg-gray-50/50 border-b border-gray-100">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-blue-500 text-xs"></i>
                </div>
                <input type="text" 
                    x-model="search" 
                    @click.stop 
                    @keydown.enter.prevent
                    placeholder="Cari opsi..." 
                    class="w-full pl-10 pr-4 py-2.5 text-sm border-2 border-gray-100 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-0 transition-all bg-white">
            </div>
        </div>
        @endif

        <ul class="max-h-72 py-2 text-base overflow-auto focus:outline-none sm:text-sm custom-scrollbar" tabindex="-1">
            <template x-for="item in filteredData" :key="item.value">
                <li @click="select(item)" 
                    class="mx-2 my-0.5 rounded-xl text-gray-700 cursor-pointer select-none relative py-3 pl-4 pr-10 transition-all duration-200 group/item"
                    :class="selectedValue == item.value ? 'bg-blue-50 text-blue-700 font-bold' : 'hover:bg-blue-600 hover:text-white'">
                    
                    <span class="block truncate" x-text="item.label"></span>

                    <span x-show="selectedValue == item.value" 
                          class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600 group-hover/item:text-white">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
            </template>
            
            <template x-if="filteredData.length === 0">
                <li class="px-4 py-8 text-sm text-gray-400 text-center italic flex flex-col items-center">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-search-minus text-gray-300 text-xl"></i>
                    </div>
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
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endonce

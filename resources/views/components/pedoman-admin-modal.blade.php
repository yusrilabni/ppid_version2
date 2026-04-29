<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-2 md:p-4" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-6xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-5 py-4 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-500 p-2 rounded-lg shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-[10px] font-medium uppercase tracking-widest italic opacity-70">Portal PPID v2.0 - Panduan Teknis Admin</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-2 rounded-lg">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-4 py-3 border-b-4 font-bold text-xs whitespace-nowrap transition-all flex items-center gap-2 min-h-[50px] uppercase tracking-tighter">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-5 md:p-8 bg-white space-y-12">
            @include('admin.pedoman.tab-profil')
            @include('admin.pedoman.tab-informasi')
            @include('admin.pedoman.tab-transparansi')
            @include('admin.pedoman.tab-pbj')
        </div>

        <!-- Footer (REDUCED SIZES) -->
        <div class="bg-slate-50 p-6 border-t border-slate-200 flex flex-col md:flex-row gap-6 items-center justify-between flex-shrink-0 shadow-inner z-50">
            <div class="flex items-center gap-4 text-slate-400 font-bold uppercase tracking-widest text-[10px] italic">
                <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
                <div>Portal PPID v2.0 <br><span class="text-[9px] text-indigo-500 underline decoration-indigo-100 uppercase tracking-widest font-black">Dinas Kominfo Sinjai</span></div>
            </div>
            
            <div class="flex gap-4 w-full md:w-auto font-bold uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0" 
                        class="px-8 py-3 bg-white text-slate-600 rounded-xl border border-slate-200 text-xs hover:bg-slate-50 transition-all flex items-center gap-3 shadow-md active:scale-95">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-12 py-3 bg-indigo-700 text-white rounded-xl shadow-xl text-xs transition-all hover:bg-indigo-800 hover:scale-[1.05] active:scale-95 border-b-4 border-indigo-900 flex items-center justify-center gap-4">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP' : 'LANJUT KE BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-14 h-14 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-2 border-white p-4 overflow-hidden shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity shadow-inner"></div>
            <i class="fas fa-chalkboard-teacher text-2xl group-hover:rotate-6 transition-transform shadow-indigo-950"></i>
            <div class="absolute bottom-full right-0 mb-4 px-3 py-1.5 bg-indigo-950 text-white text-[9px] font-bold rounded-xl opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-2xl border border-indigo-800 uppercase tracking-widest flex items-center gap-2 italic font-black shadow-indigo-950">
                <i class="fas fa-graduation-cap text-indigo-400"></i> Panduan Admin
            </div>
        </button>
    </div>
@endif

<script>
    document.addEventListener('alpine:init', () => {
        const store = Alpine.store('pedomanAdminModal');
        if (store) {
            store.tabs = [
                { title: 'MENU PROFIL', icon: 'fas fa-user-shield' },
                { title: 'JENIS INFORMASI', icon: 'fas fa-folder-open' },
                { title: 'TRANSPARANSI', icon: 'fas fa-chart-line' },
                { title: 'PBJ', icon: 'fas fa-shopping-cart' }
            ];
        }
    })
</script>

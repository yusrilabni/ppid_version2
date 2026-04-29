<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-2 md:p-4" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-6xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700 relative">

        <!-- Header: Modern & Elegant -->
        <div class="bg-indigo-950 px-5 py-4 flex-shrink-0 border-b border-indigo-900 text-white flex items-center justify-between relative z-[70]">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-500/20 p-2 rounded-xl border border-indigo-400/30">
                    <i class="fas fa-chalkboard-teacher text-indigo-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-base font-black uppercase tracking-widest leading-none">Pedoman Operasional Admin</h3>
                    <p class="text-[10px] text-indigo-300 font-bold uppercase tracking-[0.2em] mt-1 opacity-80">Portal PPID v2.0 - Kendali Kualitas Informasi</p>
                </div>
            </div>
            <button @click="$store.pedomanAdminModal.close()"
                    class="bg-white/5 hover:bg-white/10 text-white transition-all p-2 rounded-lg border border-white/10 group">
                <i class="fas fa-times text-lg group-hover:rotate-90 transition-transform"></i>
            </button>
        </div>

        <!-- Tab Navigation: Fixed & Opaque -->
        <div class="bg-white border-b border-slate-200 flex overflow-x-auto no-scrollbar relative z-[60] shadow-sm px-4">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-indigo-50/30' : 'border-transparent text-slate-400 hover:text-slate-600'"
                        class="px-5 py-3 border-b-2 font-black text-[10px] whitespace-nowrap transition-all flex items-center gap-2 min-h-[48px] uppercase tracking-widest group">
                    <i :class="tab.icon" class="text-sm"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area: Modular Includes -->
        <div class="flex-1 overflow-y-auto p-5 md:p-10 bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:24px_24px] relative z-10">
            <div class="max-w-5xl mx-auto space-y-12 pb-10">
                @include('admin.pedoman.tab-profil')
                @include('admin.pedoman.tab-informasi')
                @include('admin.pedoman.tab-transparansi')
                @include('admin.pedoman.tab-pbj')
            </div>
        </div>

        <!-- Footer: Wizard Style Navigation -->
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex flex-col md:flex-row gap-6 items-center justify-between flex-shrink-0 relative z-[70]">
            <!-- Left: Previous Button -->
            <div class="w-full md:w-40 flex justify-start order-2 md:order-1">
                <button @click="$store.pedomanAdminModal.prevTab()"
                        x-show="$store.pedomanAdminModal.activeTab > 0"
                        class="w-full md:w-auto px-5 py-2.5 bg-white text-slate-600 rounded-xl border-2 border-slate-200 text-[10px] font-black hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm active:scale-95 flex items-center justify-center gap-2 uppercase tracking-tight">
                    <i class="fas fa-chevron-left text-[9px]"></i> Kembali
                </button>
            </div>

            <!-- Middle: Info Text -->
            <div class="flex items-center gap-3 order-1 md:order-2">
                <div class="relative hidden sm:block">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-9 h-9 rounded-xl border-2 border-white shadow-md ring-2 ring-indigo-50">
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 text-center md:text-left leading-tight">
                    Sistem Panduan Mandiri <br><span class="text-indigo-600">Dinas Kominfo Sinjai</span>
                </div>
            </div>

            <!-- Right: Next/Finish Button -->
            <div class="w-full md:w-48 flex justify-end order-3">
                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="w-full md:w-auto px-8 py-2.5 bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-200 text-[10px] font-black transition-all hover:bg-indigo-800 hover:scale-[1.05] active:scale-95 border-b-4 border-indigo-900 flex items-center justify-center gap-3 uppercase tracking-widest">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'Selesai & Tutup' : 'Langkah Berikutnya'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double text-[9px]' : 'fas fa-chevron-right text-[9px]'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-12 h-12 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-2 border-white p-3 overflow-hidden shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fas fa-chalkboard-teacher text-lg group-hover:rotate-6 transition-transform"></i>
            <div class="absolute bottom-full right-0 mb-4 px-3 py-1.5 bg-indigo-950 text-white text-[8px] font-black rounded-lg opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-2xl border border-indigo-800 uppercase tracking-widest flex items-center gap-2 italic">
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
                { title: 'PROFIL OPD', icon: 'fas fa-user-shield' },
                { title: 'MANAJEMEN INFORMASI', icon: 'fas fa-folder-open' },
                { title: 'TRANSPARANSI', icon: 'fas fa-chart-line' },
                { title: 'DATA PBJ', icon: 'fas fa-shopping-cart' }
            ];
        }
    })
</script>

<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-4 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-5 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="bg-indigo-500 p-2.5 rounded-xl shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-[0.2em] opacity-80 italic">Portal PPID v2.0 - Standar Pelayanan Informasi</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-3 rounded-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-md">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-8 py-4 border-b-4 font-black text-xs whitespace-nowrap transition-all flex items-center gap-3 min-h-[64px] uppercase tracking-widest">
                    <i :class="tab.icon" class="text-base"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-12 bg-white space-y-16">
            @include('admin.pedoman.tab-profil')
            @include('admin.pedoman.tab-informasi')
            @include('admin.pedoman.tab-transparansi')
            @include('admin.pedoman.tab-pbj')
        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-10 border-t-8 border-slate-100 flex flex-col md:flex-row gap-10 items-center justify-between flex-shrink-0 shadow-[0_-25px_80px_rgba(0,0,0,0.1)] relative z-50">
            <div class="flex items-center gap-10 text-slate-400 font-black uppercase tracking-[0.6em] leading-tight text-sm italic">
                <div class="flex -space-x-10">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-24 h-24 rounded-full border-[10px] border-white shadow-2xl shadow-indigo-200">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-24 h-24 rounded-full border-[10px] border-white shadow-2xl shadow-indigo-900">
                </div>
                <div>Portal PPID v2.0 <br><span class="text-xs font-black text-indigo-500 italic underline decoration-8 decoration-indigo-100 underline-offset-8 uppercase tracking-[0.4em]">Dinas Kominfo & Persandian Sinjai</span></div>
            </div>
            
            <div class="flex gap-10 w-full md:w-auto font-black uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0" 
                        class="px-12 py-5 bg-white text-slate-600 rounded-[2rem] border-8 border-slate-200 text-base hover:bg-slate-50 transition-all flex items-center gap-6 shadow-3xl active:scale-95 italic shadow-inner">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-20 py-5 bg-indigo-700 text-white rounded-[2rem] shadow-[0_30px_100px_rgba(67,56,202,0.5)] text-base transition-all hover:bg-indigo-800 hover:scale-[1.15] active:scale-95 flex items-center justify-center gap-8 border-b-[16px] border-indigo-950 uppercase italic tracking-widest decoration-white/20 underline decoration-4">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP PANDUAN' : 'LANJUT KE LANGKAH BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-8 right-8" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-20 h-20 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-[0_40px_100px_rgba(67,56,202,0.7)] flex items-center justify-center transition-all duration-500 hover:scale-110 active:scale-95 group relative border-4 border-white p-4 overflow-hidden transition-all duration-700 shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity shadow-inner"></div>
            <i class="fas fa-chalkboard-teacher text-3xl group-hover:rotate-12 transition-transform shadow-indigo-950"></i>
            <div class="absolute bottom-full right-0 mb-6 px-6 py-3 bg-indigo-950 text-white text-[12px] font-black rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-all transform translate-y-8 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-[0_30px_70px_rgba(0,0,0,0.8)] border-4 border-indigo-800 uppercase tracking-widest flex items-center gap-4 italic font-black shadow-indigo-950 shadow-2xl italic underline decoration-8 decoration-indigo-700">
                <i class="fas fa-graduation-cap text-indigo-400 text-2xl animate-bounce"></i> Panduan Admin
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

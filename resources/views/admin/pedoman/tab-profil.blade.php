<div x-show="$store.pedomanAdminModal.activeTab === 0" 
     class="space-y-8 animate-fadeIn">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-3 border-l-4 border-indigo-600 pl-3 uppercase tracking-tighter">
        <div>
            <h4 class="text-lg font-bold text-slate-800 leading-none">Pengelolaan Profil OPD & Pimpinan</h4>
            <p class="text-[9px] text-slate-400 font-medium tracking-widest mt-0.5">Identitas Unit & Struktur Organisasi</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 1. Struktur & Website -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="relative z-10">
                <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-[11px] tracking-wider">
                    <span class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center font-bold text-[10px]">1</span>
                    Struktur & Website OPD
                </h5>
                
                <ul class="space-y-3 text-[11px] mb-6 font-medium text-slate-600 uppercase tracking-tighter">
                    <li class="flex gap-2">
                        <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                        <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                    </li>
                    <li class="flex gap-2">
                        <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                        <span>Cari unit, klik <span class="text-blue-600 border-b border-blue-100">KELOLA PROFIL UNIT</span></span>
                    </li>
                </ul>

                <!-- Mockup Form -->
                <div class="space-y-3 border-t border-slate-50 pt-4">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex gap-3 items-center">
                        <div class="flex-1">
                            <p class="text-[9px] font-bold text-slate-700 uppercase">A. Upload Gambar Struktur</p>
                        </div>
                        <div class="w-16 h-10 bg-white border border-dashed border-indigo-200 rounded-lg flex items-center justify-center relative">
                            <i class="fas fa-sitemap text-indigo-200 text-xs"></i>
                            <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex gap-3 items-center">
                        <div class="flex-1">
                            <p class="text-[9px] font-bold text-slate-700 uppercase">B. URL Website Resmi</p>
                        </div>
                        <div class="w-16 bg-white border border-indigo-100 rounded-md px-1.5 py-1 relative">
                            <span class="text-[6px] text-indigo-300 italic truncate block">https://...</span>
                            <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                        </div>
                    </div>

                    <div class="flex justify-center pt-2">
                        <div class="bg-blue-600 text-white px-5 py-1.5 rounded-lg text-[9px] font-bold shadow-sm uppercase flex items-center gap-1.5">
                            <i class="fas fa-save text-[8px]"></i> Simpan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Data Pimpinan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-[11px] tracking-wider">
                <span class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center font-bold text-[10px]">2</span>
                Data Pimpinan & Pejabat
            </h5>

            <div class="bg-amber-50 p-4 rounded-2xl border border-amber-100 mb-6 flex items-start gap-3">
                <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                <p class="text-[10px] leading-relaxed uppercase tracking-tighter text-amber-800 font-bold">
                    Wajib isi <strong>Tab Identitas</strong> (Nama + Gelar & Status AKTIF).
                </p>
            </div>

            <div class="space-y-4 border-t border-slate-50 pt-4">
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-3">
                    <div class="space-y-1">
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Nama & Gelar</p>
                        <div class="h-8 w-full bg-white border border-slate-200 rounded-lg flex items-center px-3 text-[9px] text-slate-400 italic">Dr. Nama Pimpinan, M.Si</div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Status</p>
                        <div class="h-8 w-full bg-green-50 border border-green-200 rounded-lg flex items-center px-3 text-[9px] text-green-700 font-bold uppercase justify-between">
                            AKTIF <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="flex justify-center pt-1">
                        <div class="bg-indigo-600 text-white px-6 py-1.5 rounded-lg text-[9px] font-bold uppercase">Simpan Profil</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
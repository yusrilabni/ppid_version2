<div x-show="$store.pedomanAdminModal.activeTab === 0" 
     class="space-y-8">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
        <div class="bg-indigo-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Pengelolaan Profil OPD & Pimpinan</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Identity & Organizational Structure</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- 1. Struktur & Website -->
        <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-xs tracking-wider italic">
                    <span class="bg-indigo-600 text-white w-8 h-8 rounded-xl flex items-center justify-center font-black text-sm shadow-md">1</span>
                    Struktur & Website OPD
                </h5>
                
                <ul class="space-y-4 text-[11px] mb-8 font-bold text-slate-600 uppercase tracking-tight">
                    <li class="flex gap-3 items-center">
                        <div class="w-6 h-6 bg-indigo-50 text-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-mouse-pointer text-[10px]"></i></div>
                        <span>Menu <strong class="text-slate-900">Profil</strong> > <strong class="text-slate-900">Tentang OPD</strong></span>
                    </li>
                    <li class="flex gap-3 items-center">
                        <div class="w-6 h-6 bg-indigo-50 text-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-search text-[10px]"></i></div>
                        <span>Cari unit, klik <span class="text-blue-600 underline decoration-blue-200">KELOLA PROFIL UNIT</span></span>
                    </li>
                </ul>

                <!-- Mockup Form -->
                <div class="space-y-4 border-t border-slate-50 pt-6">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex gap-4 items-center">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-700 uppercase italic">A. Upload Gambar Struktur</p>
                        </div>
                        <div class="w-20 h-12 bg-white border-2 border-dashed border-indigo-200 rounded-xl flex items-center justify-center relative">
                            <i class="fas fa-sitemap text-indigo-200 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex gap-4 items-center">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-700 uppercase italic">B. URL Website Resmi</p>
                        </div>
                        <div class="w-20 bg-white border border-indigo-100 rounded-lg px-2 py-1.5">
                            <span class="text-[8px] text-indigo-300 italic truncate block font-bold">https://...</span>
                        </div>
                    </div>

                    <div class="flex justify-center pt-2">
                        <div class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-[10px] font-black shadow-lg shadow-blue-200 uppercase flex items-center gap-2 italic">
                            <i class="fas fa-save"></i> Simpan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Data Pimpinan -->
        <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 shadow-sm relative overflow-hidden">
            <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-xs tracking-wider italic">
                <span class="bg-indigo-600 text-white w-8 h-8 rounded-xl flex items-center justify-center font-black text-sm shadow-md">2</span>
                Data Pimpinan & Pejabat
            </h5>

            <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100 mb-8 flex items-start gap-4">
                <div class="bg-amber-500 text-white p-2 rounded-lg shadow-sm flex-shrink-0"><i class="fas fa-info-circle text-xs"></i></div>
                <p class="text-[10px] leading-relaxed uppercase tracking-tight text-amber-900 font-black italic">
                    Wajib isi <span class="underline decoration-amber-300">Tab Identitas</span> (Nama + Gelar & Status AKTIF).
                </p>
            </div>

            <div class="space-y-5 border-t border-slate-50 pt-6">
                <div class="bg-slate-50 p-5 rounded-[2rem] border border-slate-200 space-y-4">
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Nama & Gelar</p>
                        <div class="h-10 w-full bg-white border-2 border-slate-200 rounded-xl flex items-center px-4 text-[10px] text-slate-400 italic font-bold">Dr. Nama Pimpinan, M.Si</div>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Status Pimpinan</p>
                        <div class="h-10 w-full bg-green-50 border-2 border-green-200 rounded-xl flex items-center px-4 text-[10px] text-green-700 font-black uppercase justify-between italic">
                            AKTIF <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="flex justify-center pt-2">
                        <div class="bg-indigo-600 text-white px-8 py-2.5 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-indigo-200 italic">Simpan Profil</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
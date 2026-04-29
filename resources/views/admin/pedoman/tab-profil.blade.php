<div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition 
     x-transition:enter="transition ease-out duration-300"
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
        <div>
            <h4 class="text-2xl font-black text-slate-800 leading-none">Pengelolaan Profil OPD & Pimpinan</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.3em] mt-1">Identitas Unit & Struktur Organisasi</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- 1. Struktur & Website -->
        <div class="group bg-white p-8 rounded-[2.5rem] border-2 border-slate-100 shadow-xl shadow-slate-200/50 hover:border-indigo-100 transition-all relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <div class="relative z-10">
                <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                    <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">1</span>
                    Struktur & Website OPD
                </h5>
                
                <ul class="space-y-4 text-sm mb-8 leading-relaxed font-bold text-slate-600 uppercase tracking-tighter">
                    <li class="flex gap-3">
                        <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                        <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-search text-indigo-500 mt-1"></i>
                        <span>Cari unit, klik <span class="text-blue-600 border-b-2 border-blue-200">KELOLA PROFIL UNIT</span></span>
                    </li>
                </ul>

                <!-- Mockup UI: Form Profil -->
                <div class="space-y-4 border-t border-slate-100 pt-6">
                    <p class="text-[10px] text-slate-400 font-black mb-2 uppercase tracking-widest">Simulasi Pengisian:</p>
                    
                    <!-- Gambar Struktur -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex gap-4 items-center group/item hover:bg-white transition-colors">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-700 uppercase tracking-tighter">A. Upload Gambar Struktur</p>
                            <p class="text-[9px] text-slate-400 lowercase italic">Format: JPG, PNG (Maks 2MB)</p>
                        </div>
                        <div class="w-24 bg-white border-2 border-dashed border-indigo-200 rounded-xl flex items-center justify-center py-3 relative">
                            <i class="fas fa-sitemap text-indigo-300"></i>
                            <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-indigo-500 shadow-md"></div>
                        </div>
                    </div>

                    <!-- Website URL -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex gap-4 items-center group/item hover:bg-white transition-colors">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-700 uppercase tracking-tighter">B. Input URL Website Resmi</p>
                            <p class="text-[9px] text-slate-400 lowercase italic">Contoh: https://dinas.kab.go.id</p>
                        </div>
                        <div class="w-24 bg-white border border-indigo-100 rounded-lg px-2 py-1.5 shadow-sm relative">
                            <span class="text-[7px] text-indigo-400 font-black italic truncate block">https://...</span>
                            <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-indigo-500 shadow-md"></div>
                        </div>
                    </div>

                    <div class="flex justify-center pt-4">
                        <div class="bg-blue-600 text-white px-8 py-2 rounded-xl text-[10px] font-black shadow-lg shadow-blue-200 border-2 border-white/20 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-save text-[8px]"></i> Simpan Perubahan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Data Pimpinan -->
        <div class="group bg-white p-8 rounded-[2.5rem] border-2 border-slate-100 shadow-xl shadow-slate-200/50 hover:border-amber-100 transition-all relative overflow-hidden font-black">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-amber-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <div class="relative z-10">
                <h5 class="font-black text-amber-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                    <span class="bg-amber-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">2</span>
                    Data Pimpinan & Pejabat
                </h5>

                <div class="bg-amber-50 p-5 rounded-3xl border-2 border-amber-100 mb-8 flex items-start gap-4">
                    <div class="bg-white p-3 rounded-2xl shadow-sm text-amber-600"><i class="fas fa-exclamation-circle text-lg"></i></div>
                    <div class="text-[10px] leading-relaxed uppercase tracking-tighter text-amber-900">
                        <span class="block font-black underline mb-1">Perhatian Khusus:</span>
                        Wajib isi <strong>Tab Identitas</strong> (Nama Lengkap + Gelar & Status AKTIF). Tab Riwayat/Penghargaan bersifat Opsional.
                    </div>
                </div>

                <!-- Mockup UI: Form Pimpinan -->
                <div class="space-y-5 border-t border-slate-100 pt-6">
                    <p class="text-[10px] text-slate-400 font-black mb-2 uppercase tracking-widest italic">Simulasi Tab Identitas:</p>
                    
                    <div class="bg-slate-50 p-6 rounded-[2.5rem] border-2 border-slate-200 space-y-5 shadow-inner">
                        <!-- Nama Input -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-[9px] font-bold shadow-lg shadow-indigo-100">A</span>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Nama Lengkap & Gelar</p>
                            </div>
                            <div class="h-10 w-full bg-white border-2 border-indigo-50 rounded-2xl flex items-center px-4 text-[10px] text-slate-400 italic shadow-sm">
                                Dr. Nama Pimpinan, M.Si
                            </div>
                        </div>

                        <!-- Status Select -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-[9px] font-bold shadow-lg shadow-indigo-100">B</span>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Status Jabatan</p>
                            </div>
                            <div class="h-10 w-full bg-green-50 border-2 border-green-100 rounded-2xl flex items-center px-4 text-[10px] text-green-700 font-black uppercase tracking-[0.3em] justify-between shadow-sm">
                                AKTIF <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                        </div>

                        <div class="flex justify-center pt-2">
                            <div class="bg-amber-600 text-white px-10 py-3 rounded-2xl text-[10px] font-black animate-bounce shadow-2xl border-4 border-white uppercase tracking-widest flex items-center gap-3">
                                <i class="fas fa-user-check text-[10px]"></i> Simpan Profil
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
    <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
        <h4 class="text-2xl font-black text-slate-800">Pengelolaan Profil OPD & Pimpinan</h4>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- 1. Struktur & Website -->
        <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
            <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                <span class="bg-indigo-100 w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">1</span>
                Struktur & Website OPD
            </h5>
            <ul class="space-y-4 text-sm mb-8 leading-relaxed font-bold">
                <li class="flex gap-3">
                    <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                    <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                </li>
                <li class="flex gap-3">
                    <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                    <span>Cari unit Bapak, klik tombol <span class="bg-white text-blue-600 border-2 border-blue-200 px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-sm">KELOLA PROFIL UNIT</span></span>
                </li>
            </ul>
            
            <!-- Simulasi Form Profil -->
            <div class="space-y-4 border-t pt-6 font-black uppercase italic text-[10px]">
                <p class="text-slate-400 mb-2">Simulasi Pengisian Form:</p>
                
                <!-- Gambar Struktur -->
                <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-inner items-center">
                    <div class="flex-1 text-slate-500 leading-tight">A. Upload Gambar Struktur (JPG/PNG). <br><span class="text-[8px] lowercase italic text-indigo-400">Pastikan gambar terlihat jelas.</span></div>
                    <div class="w-32 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl flex items-center justify-center relative py-4">
                        <i class="fas fa-sitemap text-slate-300 text-xl"></i>
                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-500 shadow-lg"></div>
                    </div>
                </div>

                <!-- URL Website -->
                <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-inner items-center">
                    <div class="flex-1 text-slate-500 leading-tight">B. Input URL Website Resmi. <br><span class="text-[8px] lowercase italic text-indigo-400">Contoh: https://dinkes.sinjaikab.go.id</span></div>
                    <div class="w-32 bg-white border-2 border-slate-200 rounded-lg flex items-center px-2 py-2 relative shadow-sm">
                        <span class="text-[7px] text-indigo-400 font-black truncate">https://...</span>
                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-500 shadow-lg"></div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-center pt-4">
                    <div class="bg-blue-600 text-white px-8 py-2 rounded-xl text-[10px] font-bold shadow-lg animate-pulse border-2 border-white uppercase flex items-center gap-2">
                        <i class="fas fa-save"></i> SIMPAN PERUBAHAN
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Data Pimpinan -->
        <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm text-sm font-bold uppercase tracking-tighter">
            <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                <span class="bg-indigo-100 w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">2</span>
                Data Pimpinan & Pejabat
            </h5>
            <ul class="space-y-4 mb-8 leading-relaxed">
                <li class="flex gap-3 text-amber-700 font-black bg-amber-100/50 p-4 rounded-2xl border-2 border-amber-200 text-[11px] italic leading-loose shadow-sm">
                    <i class="fas fa-info-circle text-lg"></i> 
                    <span>WAJIB: Isi Tab Identitas (Nama Lengkap + Gelar & Status Aktif). Tab Riwayat/Award Opsional.</span>
                </li>
                <li class="flex gap-3">
                    <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                    <span>Cari pimpinan, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-md">KELOLA PIMPINAN</span>.</span>
                </li>
            </ul>

            <!-- Simulasi Form Pimpinan -->
            <div class="space-y-4 border-t pt-6">
                <p class="text-[10px] text-slate-400 mb-2 font-black italic">Simulasi Tab Identitas:</p>
                <div class="bg-white p-6 rounded-[2.5rem] border-4 border-slate-100 space-y-5 shadow-inner relative overflow-hidden font-black">
                    
                    <!-- Nama -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg shadow-indigo-200">A</div>
                            <p class="text-[9px] text-slate-500">NAMA LENGKAP + GELAR</p>
                        </div>
                        <div class="h-10 w-full border-2 border-slate-200 rounded-xl bg-slate-50 flex items-center px-4 text-[10px] text-slate-400 italic">Dr. Nama Pimpinan, M.Si</div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg shadow-indigo-200">B</div>
                            <p class="text-[9px] text-slate-500 uppercase">PILIH STATUS JABATAN</p>
                        </div>
                        <div class="h-10 w-full border-2 border-green-200 rounded-xl bg-green-50 flex items-center px-4 text-[10px] text-green-700 font-bold uppercase tracking-widest justify-between">
                            AKTIF <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-center pt-2">
                        <div class="bg-blue-600 text-white px-10 py-3 rounded-2xl text-[10px] font-black animate-bounce shadow-2xl border-4 border-white uppercase tracking-widest">SIMPAN PROFIL</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
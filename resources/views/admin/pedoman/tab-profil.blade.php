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
                <li class="flex gap-3">
                    <i class="fas fa-upload text-indigo-500 mt-0.5"></i>
                    <span>Upload Gambar Struktur & Masukkan URL Website Resmi Unit.</span>
                </li>
            </ul>
            <div class="space-y-4 border-t pt-6 font-black uppercase italic text-[10px]">
                <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-inner items-center">
                    <div class="flex-1 text-slate-500">A. Upload Gambar Struktur (JPG/PNG).</div>
                    <div class="w-32 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl flex items-center justify-center relative py-4">
                        <i class="fas fa-sitemap text-slate-300 text-xl"></i>
                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-500 shadow-lg"></div>
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
                <li class="flex gap-3">
                    <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                    <span>Klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-md">KELOLA PIMPINAN</span> pada unit Bapak.</span>
                </li>
                <li class="bg-amber-100/50 p-4 rounded-2xl border-2 border-amber-200 text-[11px] font-black text-amber-800 italic flex items-start gap-3 leading-loose shadow-sm">
                    <i class="fas fa-info-circle text-lg"></i> 
                    <span>WAJIB: Isi Tab Identitas (Nama Lengkap + Gelar & Status Aktif). Tab Riwayat/Award Opsional.</span>
                </li>
            </ul>
            <div class="space-y-4 border-t pt-6">
                <div class="bg-white p-6 rounded-[2.5rem] border-4 border-slate-100 space-y-4 shadow-inner relative overflow-hidden font-black">
                    <div class="flex items-center gap-4">
                        <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg">A</div>
                        <p class="text-[10px] text-slate-700">Nama Lengkap + Gelar (Dr. Nama, M.Si)</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg">B</div>
                        <p class="text-[10px] text-slate-700 uppercase">Status diatur ke: <span class="text-green-600 underline">AKTIF</span></p>
                    </div>
                    <div class="flex justify-center pt-3">
                        <div class="bg-blue-600 text-white px-10 py-3 rounded-2xl text-xs font-black animate-bounce shadow-2xl border-4 border-white uppercase tracking-widest">SIMPAN PROFIL</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
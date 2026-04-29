<div x-show="$store.pedomanAdminModal.activeTab === 0" 
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
        <div class="bg-indigo-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Manajemen Profil Unit</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Identity & Organizational Structure</p>
        </div>
    </div>
    
    <!-- 01. PENGELOLAAN PROFIL OPD (TENTANG OPD) -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-building text-indigo-600"></i></span> 
                01. Update Struktur & Website (Tentang OPD)
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Navigasi Navbar -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-indigo-400 mb-6 tracking-widest italic">Alur Navigasi Navbar:</h6>
                <div class="space-y-4 text-[11px] font-medium leading-relaxed italic">
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">1</span>
                        <span>Klik menu <strong class="text-white uppercase font-black">PROFIL</strong> di Navbar (Menu Atas).</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">2</span>
                        <span>Pilih sub-menu <strong class="text-white uppercase italic font-black">Tentang OPD</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">3</span>
                        <span>Klik tombol <strong class="text-blue-400 underline uppercase italic font-black">KELOLA PROFIL UNIT</strong> pada baris nama unit Anda.</span>
                    </p>
                </div>
            </div>

            <!-- Detail Form Profil -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-6">
                <h6 class="text-xs font-black text-indigo-700 uppercase italic text-center">Simulasi Tampilan Form:</h6>
                <div class="space-y-4">
                    <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-3">
                        <p class="text-[10px] font-black text-slate-800 uppercase italic leading-none">A. Gambar Struktur Organisasi</p>
                        <div class="w-full h-20 bg-white border-2 border-dashed border-indigo-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-indigo-200"></i>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-2">
                        <p class="text-[10px] font-black text-slate-800 uppercase italic leading-none">B. Link Website Resmi</p>
                        <div class="w-full h-10 bg-white border-2 border-blue-100 rounded-xl flex items-center px-4 text-[9px] text-blue-600 font-bold italic shadow-inner">https://...</div>
                    </div>
                    <div class="bg-indigo-950 p-4 rounded-xl flex justify-center shadow-lg">
                        <div class="bg-white text-indigo-950 px-6 py-2 rounded-lg text-[9px] font-black uppercase italic tracking-widest flex items-center gap-2"><i class="fas fa-save"></i> SIMPAN PROFIL UNIT</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 02. PENGELOLAAN DATA PIMPINAN & PEJABAT -->
    <div class="space-y-8 pt-10 border-t-4 border-slate-100">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-user-tie text-blue-600"></i></span> 
                02. Update Data Pimpinan & Pejabat
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Navigasi 2 Sub Menu -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-blue-400 mb-6 tracking-widest italic">Pilih Sub-Menu Yang Sesuai:</h6>
                <div class="space-y-6">
                    <div class="bg-white/5 p-5 rounded-[2rem] border border-white/10 space-y-3">
                        <p class="text-[10px] font-black uppercase text-blue-300 italic"><i class="fas fa-landmark mr-2"></i> Pejabat Daerah</p>
                        <p class="text-[9px] leading-relaxed text-slate-300 font-bold normal-case italic border-l-2 border-blue-600 pl-3">
                            Wajib dipilih oleh Admin: <br> <strong>DINAS / BADAN / KANTOR / KECAMATAN</strong>.
                        </p>
                    </div>
                    <div class="bg-white/5 p-5 rounded-[2rem] border border-white/10 space-y-3">
                        <p class="text-[10px] font-black uppercase text-emerald-400 italic"><i class="fas fa-house-user mr-2"></i> Unit Lokal</p>
                        <p class="text-[9px] leading-relaxed text-slate-300 font-bold normal-case italic border-l-2 border-emerald-500 pl-3">
                            Wajib dipilih oleh Admin: <br> <strong>KELURAHAN / DESA</strong>.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium leading-relaxed italic text-slate-400 bg-black/20 p-4 rounded-2xl">
                        Alur: Menu <strong class="text-white">PROFIL</strong> > Pilih <strong class="text-white">Pejabat Daerah</strong> / <strong class="text-white">Unit Lokal</strong> > Klik Tombol Biru <strong class="text-blue-400 underline">+ TAMBAH PROFIL PIMPINAN</strong>.
                    </p>
                </div>
            </div>

            <!-- Detail Form Pimpinan -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-6">
                <h6 class="text-xs font-black text-blue-700 uppercase italic text-center">Simulasi Tab Identitas:</h6>
                <div class="space-y-5">
                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-3">
                        <p class="text-[10px] font-black text-slate-800 uppercase italic">A. Nama Lengkap & Gelar <span class="text-red-500">*</span></p>
                        <div class="w-full h-10 bg-white border-2 border-slate-200 rounded-xl flex items-center px-4 text-[9px] text-slate-400 font-bold italic shadow-inner">Dr. Nama Pimpinan, M.Si</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-3">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">B. Foto Profil <span class="text-red-500">*</span></p>
                            <div class="bg-white border-2 border-dashed border-blue-200 h-14 rounded-xl flex items-center justify-center"><i class="fas fa-camera text-blue-200"></i></div>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-3">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">C. Status <span class="text-red-500">*</span></p>
                            <div class="bg-green-600 text-white py-2 rounded-lg text-[8px] font-black uppercase flex items-center justify-center gap-2 italic">AKTIF <i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                    <div class="bg-blue-900 p-5 rounded-2xl flex items-center justify-center gap-3">
                        <div class="bg-white text-blue-900 px-8 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest flex items-center gap-2">
                            <i class="fas fa-save text-[9px]"></i> SIMPAN DATA PIMPINAN
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REMINDER FINAL -->
    <div class="bg-indigo-950 p-10 rounded-[3rem] text-white flex flex-col md:flex-row items-center gap-10 shadow-2xl border-4 border-white/10 relative overflow-hidden">
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="w-16 h-16 bg-white text-indigo-900 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-xl rotate-3">
            <i class="fas fa-desktop text-2xl"></i>
        </div>
        <div class="space-y-2">
            <h6 class="text-sm font-black uppercase italic tracking-widest text-indigo-300">Sinkronisasi Website:</h6>
            <p class="text-[11px] font-bold leading-relaxed text-slate-300 normal-case italic">
                Data yang Anda isi melalui Navbar **PROFIL** ini akan otomatis merakit halaman publik unit Anda. Pastikan Status Pimpinan diatur ke **AKTIF** agar profil pejabat tersebut tampil sempurna di halaman depan warga.
            </p>
        </div>
    </div>
</div>
<div x-show="$store.pedomanAdminModal.activeTab === 0" 
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
        <div class="bg-indigo-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Manajemen Profil & Struktur</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Identity & Organizational Management</p>
        </div>
    </div>
    
    <!-- 1. PENGELOLAAN PROFIL OPD -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-building text-indigo-600"></i></span> 
                01. Pengelolaan Profil OPD (Tentang OPD)
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Navigasi Profil -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-indigo-400 mb-6 tracking-widest italic">Alur Navigasi:</h6>
                <div class="space-y-4 text-[11px] font-medium leading-relaxed italic">
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">1</span>
                        <span>Pada Sidebar, buka kelompok <strong class="text-white">Manajemen Struktur</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">2</span>
                        <span>Pilih menu <strong class="text-white">Organisasi</strong>. Akan muncul daftar unit.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">3</span>
                        <span>Klik ikon folder biru (<i class="fas fa-folder-open text-blue-400"></i>) pada baris unit Anda.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">4</span>
                        <span>Klik tombol biru <strong class="text-blue-400 underline uppercase italic">KELOLA OPD</strong> untuk masuk ke formulir.</span>
                    </p>
                </div>
            </div>

            <!-- Detail Form Profil -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-6">
                <h6 class="text-xs font-black text-indigo-700 uppercase italic">Rincian Pengisian Formulir:</h6>
                
                <div class="space-y-5">
                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">A. Gambar Struktur Organisasi</p>
                            <span class="text-[8px] bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded font-black italic">IMAGE</span>
                        </div>
                        <div class="w-full h-24 bg-white border-2 border-dashed border-indigo-200 rounded-2xl flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-sitemap text-2xl text-indigo-200"></i>
                            <span class="text-[8px] font-bold text-slate-400">Unggah file JPG/PNG Struktur Unit</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">B. URL Website Resmi</p>
                            <span class="text-[8px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded font-black italic">LINK</span>
                        </div>
                        <div class="w-full h-10 bg-white border-2 border-blue-100 rounded-xl flex items-center px-4 text-[9px] text-blue-600 font-bold italic">
                            https://namadinas.sinjaikab.go.id
                        </div>
                    </div>

                    <div class="bg-indigo-900 p-5 rounded-2xl flex items-center justify-center gap-3 shadow-lg shadow-indigo-200">
                        <div class="bg-white text-indigo-900 px-6 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest flex items-center gap-2">
                            <i class="fas fa-save text-[9px]"></i> SIMPAN PROFIL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. PENGELOLAAN PROFIL PIMPINAN -->
    <div class="space-y-8 pt-10 border-t-4 border-slate-100">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-user-tie text-blue-600"></i></span> 
                02. Pengelolaan Profil Pimpinan & Pejabat
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Navigasi Pimpinan -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-blue-400 mb-6 tracking-widest italic">Alur Navigasi:</h6>
                <div class="space-y-4 text-[11px] font-medium leading-relaxed italic">
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-blue-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">1</span>
                        <span>Buka Sidebar > Manajemen Struktur > <strong class="text-white">Profil Pimpinan</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-blue-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">2</span>
                        <span>Klik tombol biru <strong class="text-blue-400 underline uppercase italic">+ TAMBAH PROFIL PIMPINAN</strong>.</span>
                    </p>
                    <div class="bg-amber-500/10 border-l-4 border-amber-500 p-4 rounded-r-2xl">
                        <p class="text-[10px] text-amber-400 font-black uppercase tracking-tight leading-relaxed">
                            PENTING: Form ini menggunakan Sistem TAB. Wajib isi minimal **Tab Identitas** secara lengkap!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Detail Form Pimpinan -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-6">
                <h6 class="text-xs font-black text-blue-700 uppercase italic">Panduan Pengisian (Tab Identitas):</h6>
                
                <div class="space-y-5">
                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-3">
                        <p class="text-[10px] font-black text-slate-800 uppercase italic">A. Nama Lengkap & Gelar <span class="text-red-500">*</span></p>
                        <div class="w-full h-10 bg-white border-2 border-slate-200 rounded-xl flex items-center px-4 text-[9px] text-slate-400 font-bold italic">
                            Dr. Nama Pimpinan, M.Si
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-3">
                        <p class="text-[10px] font-black text-slate-800 uppercase italic">B. Jabatan & Unit Kerja <span class="text-red-500">*</span></p>
                        <div class="w-full h-10 bg-indigo-50 border-2 border-indigo-100 rounded-xl flex items-center justify-between px-4 text-[9px] text-indigo-700 font-black uppercase italic">
                            KEPALA DINAS <i class="fas fa-caret-down"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-3">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">C. Foto <span class="text-red-500">*</span></p>
                            <div class="bg-blue-600 text-white py-2 rounded-lg text-[8px] font-black uppercase flex items-center justify-center gap-2 italic">
                                <i class="fas fa-camera"></i> UNGGAH FOTO
                            </div>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border-2 border-slate-100 space-y-3">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic">D. Status <span class="text-red-500">*</span></p>
                            <div class="bg-green-600 text-white py-2 rounded-lg text-[8px] font-black uppercase flex items-center justify-center gap-2 italic">
                                AKTIF <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-900 p-5 rounded-2xl flex items-center justify-center gap-3">
                        <div class="bg-white text-blue-900 px-8 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest flex items-center gap-2">
                            <i class="fas fa-save text-[9px]"></i> SIMPAN PIMPINAN
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
            <i class="fas fa-flag-checkered text-2xl"></i>
        </div>
        <div class="space-y-2">
            <h6 class="text-sm font-black uppercase italic tracking-widest text-indigo-300">Hasil Akhir:</h6>
            <p class="text-[11px] font-bold leading-relaxed text-slate-300 normal-case italic">
                Setelah semua data di atas disimpan dengan benar, sistem akan secara otomatis merakit halaman **"PROFIL OPD"** di website utama. Warga dapat melihat Struktur Organisasi, Link Website, dan Profil Pejabat Anda secara profesional dan transparan.
            </p>
        </div>
    </div>
</div>
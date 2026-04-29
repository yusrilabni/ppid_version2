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
    
    <!-- PENGELOLAAN PROFIL OPD (TENTANG OPD) -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-building text-indigo-600"></i></span> 
                Update Struktur & Website (Tentang OPD)
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Navigasi Navbar -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-indigo-400 mb-6 tracking-widest italic">Alur Navigasi Navbar Atas:</h6>
                <div class="space-y-4 text-[11px] font-medium leading-relaxed italic">
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">1</span>
                        <span>Pada Navbar (Menu Atas), klik menu <strong class="text-white uppercase font-black">PROFIL</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">2</span>
                        <span>Pilih sub-menu <strong class="text-white uppercase italic font-black">Tentang OPD</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic text-[10px]">3</span>
                        <span>Cari nama unit Anda di daftar, lalu klik tombol biru <strong class="text-blue-400 underline uppercase italic font-black">KELOLA PROFIL UNIT</strong>.</span>
                    </p>
                    <div class="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded-r-2xl">
                        <p class="text-[9px] text-blue-300 font-bold leading-relaxed uppercase tracking-tighter">
                            INFO: Tombol kelola ini hanya muncul jika Anda sudah login sebagai Admin.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Detail Form Profil -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-6">
                <h6 class="text-xs font-black text-indigo-700 uppercase italic text-center">Simulasi Tampilan Form:</h6>
                
                <div class="space-y-5">
                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic leading-none">A. Gambar Struktur Organisasi</p>
                        </div>
                        <div class="w-full h-24 bg-white border-2 border-dashed border-indigo-200 rounded-2xl flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-image text-2xl text-indigo-200"></i>
                            <span class="text-[8px] font-bold text-slate-400 italic">Klik untuk Unggah Gambar Struktur Unit</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border-2 border-slate-100 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic leading-none">B. Link Website Resmi</p>
                        </div>
                        <div class="w-full h-10 bg-white border-2 border-blue-100 rounded-xl flex items-center px-4 text-[9px] text-blue-600 font-bold italic shadow-inner">
                            https://namadinas.sinjaikab.go.id
                        </div>
                    </div>

                    <div class="bg-indigo-950 p-5 rounded-2xl flex items-center justify-center gap-3 shadow-lg shadow-indigo-200">
                        <div class="bg-white text-indigo-950 px-8 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest flex items-center gap-2">
                            <i class="fas fa-save text-[9px]"></i> SIMPAN PROFIL UNIT
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
                Data profil yang Anda kelola melalui menu **Tentang OPD** ini akan otomatis memperbarui tampilan publik pada halaman Profil Unit. Pastikan Gambar Struktur jernih dan URL website sudah benar agar warga dapat mengakses informasi unit Anda dengan mudah.
            </p>
        </div>
    </div>
</div>
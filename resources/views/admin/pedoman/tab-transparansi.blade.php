<div x-show="$store.pedomanAdminModal.activeTab === 2" class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-emerald-600 pl-4 uppercase tracking-tighter">
        <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-chart-line text-2xl"></i>
        </div>
        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-10">
            <div>
                <h4 class="text-xl font-black text-slate-800 leading-none">Layanan Transparansi</h4>
                <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Public Requests & Survey Management</p>
            </div>
        </div>
    </div>

    <!-- 01. PERMOHONAN INFORMASI (PENTING) -->
    <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <i class="fas fa-file-signature text-[100px]"></i>
        </div>
        
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-user-friends text-emerald-600"></i></span> 
                01. Memahami Permohonan Informasi
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-6">
                <div class="bg-red-50 p-6 rounded-[2rem] border-2 border-red-100 space-y-3">
                    <p class="text-[11px] font-black text-red-700 uppercase italic flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> PERINGATAN PENTING:
                    </p>
                    <p class="text-[10px] leading-relaxed text-red-900/80 font-bold italic normal-case">
                        Menu **Permohonan Informasi** adalah layanan khusus untuk **MASYARAKAT/WARGA**. Admin dilarang mengisi form ini atas nama sendiri! 
                    </p>
                </div>
                <div class="bg-slate-50 p-6 rounded-[2rem] border-2 border-slate-100 space-y-3">
                    <p class="text-[11px] font-black text-slate-700 uppercase italic">Siapa Yang Mengisi?</p>
                    <p class="text-[10px] leading-relaxed text-slate-600 font-medium normal-case">
                        Warga yang memerlukan data spesifik yang **BELUM TERSEDIA** di sistem, atau data yang **KURANG LENGKAP** dan membutuhkan rincian lebih detail dari unit kerja Anda.
                    </p>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden border-4 border-slate-800 shadow-xl">
                <h6 class="text-xs font-black uppercase text-emerald-400 mb-6 tracking-widest italic">Alur Bagi Masyarakat:</h6>
                <div class="space-y-4 text-[10px] font-medium leading-relaxed italic">
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-emerald-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic">1</span>
                        <span>Warga harus **LOGIN** menggunakan akun Google resmi di portal PPID.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-emerald-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic">2</span>
                        <span>Klik menu <strong class="text-white uppercase">TRANSPARANSI</strong> > <strong class="text-white uppercase">Permohonan Informasi</strong>.</span>
                    </p>
                    <p class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                        <span class="bg-emerald-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black flex-shrink-0 not-italic">3</span>
                        <span>Klik <strong class="text-blue-400 underline uppercase italic font-black">+ BUAT PERMOHONAN</strong> dan isi detail data yang dibutuhkan.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 02. RESPON ADMIN -->
    <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-100 shadow-sm space-y-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-reply-all text-blue-600"></i></span> 
                02. Tugas Admin Merespon Permohonan
            </h5>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-blue-50/50 p-8 rounded-[3rem] border-2 border-blue-100 space-y-6">
                <p class="text-[11px] leading-relaxed text-blue-900 font-bold normal-case italic">
                    Setiap ada permohonan masuk, Admin wajib memprosesnya tepat waktu sesuai standar pelayanan informasi.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-blue-100 shadow-sm">
                        <div class="bg-orange-500 text-white px-3 py-1 rounded-lg text-[9px] font-black uppercase shadow-md shadow-orange-100 italic">PENDING</div>
                        <p class="text-[10px] font-bold text-slate-500 italic uppercase tracking-tighter">Artinya butuh respon segera!</p>
                    </div>
                    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-blue-100 shadow-sm">
                        <div class="bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg shadow-blue-100">PROSES / BALAS</div>
                        <p class="text-[10px] font-bold text-slate-500 italic uppercase tracking-tighter">Klik tombol ini untuk kirim jawaban.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 text-[11px] font-bold uppercase italic tracking-tighter text-slate-600 border-l-4 border-slate-100 pl-8 py-2">
                <p class="text-blue-700 font-black mb-4 underline decoration-blue-200">Langkah Operasional:</p>
                <ol class="space-y-4 list-decimal list-inside leading-relaxed">
                    <li class="border-b border-slate-50 pb-2">Buka menu **TRANSPARANSI** > **Permohonan**.</li>
                    <li class="border-b border-slate-50 pb-2">Cari judul permohonan milik unit Anda.</li>
                    <li class="border-b border-slate-50 pb-2">Ketik jawaban atau unggah file dokumen yang diminta warga.</li>
                    <li class="text-indigo-600 font-black">Klik SIMPAN. Status akan otomatis berubah menjadi <span class="underline">SELESAI</span>.</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- 03. SURVEI PPID -->
    <div class="bg-indigo-900 p-10 rounded-[3.5rem] text-white shadow-2xl relative overflow-hidden border-4 border-white/10">
        <div class="absolute -bottom-10 -right-10 p-10 opacity-10">
            <i class="fas fa-poll text-[150px]"></i>
        </div>
        
        <div class="relative z-10 space-y-10">
            <div class="flex flex-col md:flex-row gap-8 items-center border-b border-white/10 pb-8">
                <div class="bg-emerald-500 text-white p-5 rounded-[2rem] shadow-xl rotate-3">
                    <i class="fas fa-user-check text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-black uppercase tracking-[0.3em] italic leading-none">Layanan Survei Kepuasan PPID</h5>
                    <p class="text-[11px] text-emerald-300 font-bold uppercase mt-2">Meningkatkan Kualitas Layanan Melalui Umpan Balik Pemohon</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <p class="text-[12px] leading-relaxed text-slate-300 font-bold normal-case italic">
                        Setiap kali permohonan informasi telah **SELESAI** dijawab, Admin wajib mengarahkan warga tersebut untuk mengisi Survei.
                    </p>
                    <div class="bg-white/5 p-6 rounded-[2.5rem] border border-white/10 space-y-4">
                        <p class="text-[10px] font-black uppercase text-emerald-400 italic">Peran Admin Dalam Survei:</p>
                        <ul class="text-[10px] text-slate-400 space-y-3 list-disc list-inside normal-case font-medium italic">
                            <li>Berikan link <strong class="text-white">Transparansi > Survei</strong> kepada warga setelah Anda mengirim jawaban dokumen.</li>
                            <li>Admin juga diperbolehkan mengisi survei ini bersama warga (mendampingi) untuk memastikan feedback masuk ke sistem.</li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-4">
                    <h6 class="text-xs font-black uppercase text-indigo-300 italic tracking-widest">Alur Pengisian Survei:</h6>
                    <div class="space-y-3">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10 flex items-center gap-4">
                            <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black text-[10px]">1</span>
                            <p class="text-[10px] font-bold italic">Menu <strong class="uppercase text-emerald-400">Transparansi</strong> > <strong class="uppercase text-emerald-400">Survei</strong>.</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10 flex items-center gap-4">
                            <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black text-[10px]">2</span>
                            <p class="text-[10px] font-bold italic">Klik tombol <strong class="bg-emerald-500 px-2 py-0.5 rounded text-white text-[8px] uppercase shadow-md">Isi Survei Sekarang</strong>.</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10 flex items-center gap-4">
                            <span class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-black text-[10px]">3</span>
                            <p class="text-[10px] font-bold italic">Jawab pertanyaan kepuasan hingga selesai lalu tekan <strong class="text-emerald-400 underline">SIMPAN</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
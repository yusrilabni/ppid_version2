<div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-12 uppercase font-black italic tracking-tighter text-slate-800">
    <div class="flex items-center gap-4 border-l-8 border-green-600 pl-4 uppercase tracking-tighter">
        <h4 class="text-2xl font-black italic underline underline-offset-4 decoration-green-100 decoration-8">Alur Layanan Permohonan Informasi</h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 font-black uppercase italic tracking-tighter">
        <!-- Mengarahkan Pemohon -->
        <div class="bg-slate-900 rounded-[4rem] p-12 text-white relative overflow-hidden shadow-2xl transition-all hover:scale-[1.02] border-8 border-slate-800 font-black">
            <div class="absolute top-0 right-0 p-12 opacity-10"><i class="fas fa-file-import text-[12rem]"></i></div>
            <h5 class="text-xl font-black mb-10 flex items-center gap-4 italic uppercase underline decoration-indigo-500 decoration-8 underline-offset-8">Mengarahkan Pemohon</h5>
            <div class="space-y-10">
                <div class="flex gap-8 items-start bg-white/10 p-8 rounded-[3rem] border-4 border-white/20 shadow-2xl shadow-green-900/50">
                    <span class="bg-green-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-2xl">1</span>
                    <p class="text-sm tracking-widest pt-3 uppercase italic leading-loose font-black underline decoration-green-400">Minta warga login ke portal PPID (Gunakan Akun Google).</p>
                </div>
                <div class="flex gap-8 items-start bg-white/10 p-8 rounded-[3rem] border-4 border-white/20 shadow-2xl shadow-green-900/50">
                    <span class="bg-green-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-2xl">2</span>
                    <p class="text-sm tracking-widest pt-3 uppercase italic font-black underline decoration-green-400">Pilih menu <strong>Transparansi</strong> > <strong>Permohonan</strong>.</p>
                </div>
            </div>
        </div>

        <!-- Admin Merespon -->
        <div class="bg-white border-[12px] border-slate-100 rounded-[5rem] p-12 shadow-2xl font-black italic uppercase relative overflow-hidden font-black">
            <div class="absolute top-0 left-0 w-4 h-full bg-blue-600 shadow-xl"></div>
            <h5 class="text-xl font-black text-slate-800 mb-10 flex items-center gap-4 uppercase italic underline decoration-blue-500 decoration-8 underline-offset-8">Tugas Admin Merespon</h5>
            <div class="p-10 bg-blue-50 rounded-[4rem] border-8 border-blue-100 shadow-inner">
                <p class="text-base font-black text-blue-800 mb-8 uppercase tracking-widest italic underline decoration-blue-200">Langkah Pengiriman Jawaban:</p>
                <ol class="text-xs text-slate-600 space-y-8 list-decimal list-inside font-black italic tracking-tighter uppercase leading-loose">
                    <li class="bg-white p-5 rounded-[2rem] shadow-xl border-4 border-blue-100 transition-all hover:translate-x-3">Buka Dashboard Permohonan.</li>
                    <li class="bg-white p-5 rounded-[2rem] shadow-xl border-4 border-blue-100 transition-all hover:translate-x-3">Cari permohonan status <span class="text-orange-600 underline decoration-4 underline-offset-4 italic">PENDING</span>.</li>
                    <li class="bg-white p-5 rounded-[2.5rem] shadow-2xl border-8 border-blue-200 transition-all hover:scale-105 font-black text-blue-700 italic">Klik tombol biru <span class="underline">"PROSES / BALAS"</span>.</li>
                    <li class="bg-white p-5 rounded-[2rem] shadow-xl border-4 border-blue-100 transition-all hover:translate-x-3 italic">Tulis Jawaban & Upload Dokumen / URL Folder Jawaban.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
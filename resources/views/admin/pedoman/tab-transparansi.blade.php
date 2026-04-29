<div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-10 uppercase font-black italic tracking-tighter text-slate-800">
    <div class="flex items-center gap-3 border-l-4 border-green-600 pl-3 uppercase tracking-tighter font-black">
        <h4 class="text-base font-bold italic underline underline-offset-4 decoration-green-100 decoration-4">Alur Layanan Permohonan Informasi</h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-black uppercase italic tracking-tighter">
        <!-- Mengarahkan Pemohon -->
        <div class="bg-slate-900 rounded-3xl p-6 text-white relative overflow-hidden shadow-xl transition-all hover:scale-[1.02] border-4 border-slate-800">
            <h5 class="text-sm font-black mb-6 underline decoration-indigo-500 decoration-4 underline-offset-4">Mengarahkan Pemohon</h5>
            <div class="space-y-6">
                <div class="flex gap-4 items-start bg-white/5 p-4 rounded-2xl border border-white/10 shadow-lg">
                    <span class="bg-green-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black text-sm">1</span>
                    <p class="text-[10px] leading-relaxed pt-1 uppercase">Minta warga login ke portal PPID (Gunakan Akun Google).</p>
                </div>
                <div class="flex gap-4 items-start bg-white/5 p-4 rounded-2xl border border-white/10 shadow-lg font-black">
                    <span class="bg-green-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black text-sm">2</span>
                    <p class="text-[10px] leading-relaxed pt-1 uppercase underline decoration-green-400">Pilih menu <strong>Transparansi</strong> > <strong>Permohonan</strong>.</p>
                </div>
            </div>
        </div>

        <!-- Admin Merespon -->
        <div class="bg-white border-4 border-slate-50 rounded-3xl p-6 shadow-xl relative overflow-hidden font-black">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-600 shadow-md"></div>
            <h5 class="text-sm font-black text-slate-800 mb-6 underline decoration-blue-500 decoration-4 underline-offset-4">Tugas Admin Merespon</h5>
            <div class="p-5 bg-blue-50 rounded-2xl border-2 border-blue-100 shadow-inner">
                <p class="text-[10px] font-black text-blue-800 mb-4 underline decoration-blue-200">Langkah Pengiriman Jawaban:</p>
                <ol class="text-[9px] text-slate-600 space-y-4 list-decimal list-inside font-black italic tracking-tighter uppercase leading-relaxed">
                    <li class="bg-white p-3 rounded-xl border border-blue-100 shadow-sm transition-all hover:translate-x-1">Buka Dashboard Permohonan.</li>
                    <li class="bg-white p-3 rounded-xl border border-blue-100 shadow-sm transition-all hover:translate-x-1">Cari permohonan status <span class="text-orange-600 underline">PENDING</span>.</li>
                    <li class="bg-white p-3 rounded-xl shadow-lg border-2 border-blue-200 font-black text-blue-700 italic">Klik tombol biru <span class="underline">"PROSES / BALAS"</span>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div x-show="$store.pedomanAdminModal.activeTab === 2" class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-emerald-600 pl-4 uppercase tracking-tighter">
        <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-chart-line text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Alur Layanan Informasi</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Transparency & Response Management</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-black uppercase italic tracking-tighter">
        <!-- Mengarahkan Pemohon -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl border-4 border-slate-800">
            <h5 class="text-sm font-black mb-8 underline decoration-indigo-500 decoration-4 underline-offset-4 italic uppercase">Mengarahkan Pemohon</h5>
            <div class="space-y-6">
                <div class="flex gap-5 items-start bg-white/5 p-5 rounded-3xl border border-white/10 shadow-lg">
                    <span class="bg-emerald-500 text-white w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-black text-sm shadow-lg shadow-emerald-500/20">1</span>
                    <p class="text-[11px] leading-relaxed pt-1 uppercase italic font-bold">Minta warga login ke portal PPID (Gunakan Akun Google resmi).</p>
                </div>
                <div class="flex gap-5 items-start bg-white/5 p-5 rounded-3xl border border-white/10 shadow-lg font-black">
                    <span class="bg-emerald-500 text-white w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-black text-sm shadow-lg shadow-emerald-500/20">2</span>
                    <p class="text-[11px] leading-relaxed pt-1 uppercase italic underline decoration-emerald-400 font-bold font-black">Pilih menu <strong class="text-white">Transparansi</strong> > <strong class="text-white">Permohonan</strong>.</p>
                </div>
            </div>
        </div>

        <!-- Admin Merespon -->
        <div class="bg-white border-4 border-slate-50 rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden font-black">
            <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
            <h5 class="text-sm font-black text-slate-800 mb-8 underline decoration-blue-500 decoration-4 underline-offset-4 italic uppercase">Tugas Admin Merespon</h5>
            <div class="p-6 bg-blue-50/50 rounded-3xl border-2 border-blue-100 shadow-inner">
                <p class="text-[10px] font-black text-blue-800 mb-6 underline decoration-blue-200 uppercase italic">Langkah Pengiriman Jawaban:</p>
                <ol class="text-[10px] text-slate-600 space-y-5 list-decimal list-inside font-black italic tracking-tighter uppercase leading-relaxed">
                    <li class="bg-white p-4 rounded-2xl border border-blue-100 shadow-sm font-bold">Buka Dashboard Permohonan Informasi.</li>
                    <li class="bg-white p-4 rounded-2xl border border-blue-100 shadow-sm font-bold">Cari permohonan dengan status <span class="text-orange-600 underline">PENDING</span>.</li>
                    <li class="bg-white p-4 rounded-2xl shadow-lg border-2 border-blue-200 font-black text-blue-700 italic text-[11px]">Klik tombol biru <span class="underline decoration-blue-500 decoration-2">"PROSES / BALAS"</span> secara seksama.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
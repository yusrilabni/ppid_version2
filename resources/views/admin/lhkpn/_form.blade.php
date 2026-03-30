@csrf

<!-- Nama Pejabat (Opsional) -->
<div class="space-y-2">
    <label for="full_name" class="block text-sm font-medium text-gray-800">
        Nama Pejabat <span class="text-gray-400 text-xs font-normal">(Opsional - LHKPN akan melekat pada Jabatan)</span>
    </label>
    <div class="relative">
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $official->full_name ?? '') }}"
            placeholder="Masukkan nama pejabat jika diperlukan"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('full_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
        @error('full_name')
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
            </div>
        @enderror
    </div>
    @error('full_name')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Grid: Tahun dan Tanggal -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Tahun Laporan -->
    <div class="space-y-2">
        <label for="report_year" class="block text-sm font-medium text-gray-800">
            Tahun Laporan <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="number" name="report_year" id="report_year" value="{{ old('report_year', date('Y')) }}"
                min="2000" max="{{ date('Y') + 1 }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('report_year') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('report_year')
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
                </div>
            @enderror
        </div>
        @error('report_year')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tanggal Laporan -->
    <div class="space-y-2">
        <label for="report_date" class="block text-sm font-medium text-gray-800">
            Tanggal Laporan <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="date" name="report_date" id="report_date" value="{{ old('report_date', date('Y-m-d')) }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('report_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
             @error('report_date')
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
                </div>
            @enderror
        </div>
         @error('report_date')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Jenis Laporan -->
<div class="space-y-2">
    <label for="report_type" class="block text-sm font-medium text-gray-800">
        Jenis Laporan 
    </label>
    <div class="relative">
        <input type="text" name="report_type" id="report_type" value="{{ old('report_type') }}"
            placeholder="Contoh: Periodik, Awal Menjabat, Akhir Menjabat"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400 @error('report_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
        @error('report_type')
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
            </div>
        @enderror
    </div>
    @error('report_type')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Total Kekayaan -->
<div class="space-y-2">
    <label for="total_wealth" class="block text-sm font-medium text-gray-800">
        Total Kekayaan (Rp) 
    </label>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
        <input type="number" name="total_wealth" id="total_wealth" value="{{ old('total_wealth') }}"
            placeholder="Masukkan jumlah kekayaan tanpa titik atau koma"
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400 @error('total_wealth') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
        @error('total_wealth')
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
            </div>
        @enderror
    </div>
    @error('total_wealth')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- File Upload Section -->
<div class="space-y-4 pt-4 border-t border-gray-100">
    <h3 class="text-lg font-medium text-gray-900 flex items-center">
        <i class="fas fa-upload w-5 h-5 mr-2 text-blue-500"></i>
        Unggah Dokumen LHKPN
    </h3>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-800">
            File Laporan (PDF) <span class="text-red-500">*</span>
        </label>
        <div class="relative group">
            <input type="file" name="file" id="file" accept="application/pdf" required class="hidden" onchange="previewFileName(this, 'pdf-preview')">
            <label for="file"
                class="flex flex-col items-center justify-center w-full h-32 px-4 transition-all duration-200 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 group-hover:border-blue-400">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <i class="fas fa-file-pdf w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-500"></i>
                    <p class="mb-2 text-sm text-gray-500">
                        <span class="font-semibold">Klik untuk upload</span> atau seret dan letakkan
                    </p>
                    <p class="text-xs text-gray-500">PDF (Maks. 10MB)</p>
                </div>
            </label>
        </div>
        <div id="pdf-preview" class="hidden mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle w-5 h-5 text-green-500 mr-2"></i>
                <span class="text-sm text-green-700 font-medium" id="file-file-name"></span>
            </div>
        </div>
        @error('file')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

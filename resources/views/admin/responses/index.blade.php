@extends('admin.layouts.app')

@section('title', 'Respon Survei: ' . $survey->title)

@section('content')
<div class="max-w-full overflow-x-hidden -m-4 sm:-m-6 lg:-m-8"> {{-- Offset the parent padding --}}
    <div class="w-full min-h-screen bg-gray-50 pb-12">
        {{-- Header Section --}}
        <div class="bg-white border-b border-gray-200">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                            <i class="fas fa-chart-pie text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl md:text-2xl font-black text-gray-900 uppercase tracking-tight">Respon Survei</h1>
                            <p class="text-sm text-gray-500 font-medium line-clamp-1">{{ $survey->title }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button" onclick="exportWithCharts()"
                           class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export Excel + Grafik
                        </button>
                        <a href="{{ route('admin.surveys.index') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all active:scale-95">
                            <i class="fas fa-arrow-left mr-2 text-gray-400"></i>
                            Daftar Survei
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Charts Section --}}
        @if(isset($chartData) && count($chartData) > 0)
            <div class="mb-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h2 class="text-lg font-black text-gray-800 uppercase tracking-wider flex items-center">
                            <span class="w-8 h-1 bg-blue-600 rounded-full mr-3"></span>
                            Analisis Visual
                        </h2>
                        <p class="text-xs text-gray-500 mt-1 ml-11">Distribusi jawaban responden berdasarkan pilihan</p>
                    </div>
                    <div class="flex items-center bg-white p-1.5 rounded-2xl border border-gray-200 shadow-sm">
                        <label class="text-[10px] font-black text-gray-400 uppercase px-3">Gaya:</label>
                        <select id="chartTypeSelector" class="bg-gray-50 border-0 rounded-xl px-4 py-2 text-xs font-bold text-blue-700 focus:ring-0 cursor-pointer">
                            <option value="bar">📊 Bar Chart</option>
                            <option value="pie">🍕 Pie Chart</option>
                            <option value="doughnut">🍩 Doughnut</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8">
                    @foreach($chartData as $questionId => $data)
                        @php $question = $survey->questions->find($questionId); @endphp
                        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 group">
                            <div class="flex items-start justify-between mb-6">
                                <div class="max-w-[80%]">
                                    <h3 class="text-sm font-black text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $question->question_text }}</h3>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase mt-1 inline-block">{{ $question->question_type }}</span>
                                </div>
                                <div class="w-8 h-8 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                                    <i class="fas fa-chart-line text-xs"></i>
                                </div>
                            </div>
                            <div class="relative h-64 w-full">
                                <canvas id="chart-{{ $questionId }}"></canvas>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Raw Data Table Section --}}
        <div>
            <div class="mb-6">
                <h2 class="text-lg font-black text-gray-800 uppercase tracking-wider flex items-center">
                    <span class="w-8 h-1 bg-indigo-600 rounded-full mr-3"></span>
                    Data Mentah Respon
                </h2>
                <p class="text-xs text-gray-500 mt-1 ml-11">Total {{ $survey->responses->count() }} responden telah mengisi survei ini</p>
            </div>

            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] sticky left-0 bg-gray-50 z-20 border-r border-gray-100">
                                    No.
                                </th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] min-w-[150px]">
                                    Waktu Submit
                                </th>
                                @foreach ($sortedQuestions as $question)
                                    <th class="px-6 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] min-w-[250px]">
                                        {{ $question->question_text }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($survey->responses as $index => $response)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-6 py-5 whitespace-nowrap sticky left-0 bg-white group-hover:bg-blue-50/50 z-10 border-r border-gray-100 text-sm font-bold text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-700">{{ $response->created_at->format('d M Y') }}</span>
                                            <span class="text-[10px] text-gray-400">{{ $response->created_at->format('H:i') }} WITA</span>
                                        </div>
                                    </td>
                                    @foreach ($sortedQuestions as $question)
                                        <td class="px-6 py-5">
                                            @php
                                                $answer = $response->answers->firstWhere('question_id', $question->id);
                                                $answerText = '-';
                                                if ($answer) {
                                                    if (in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)'])) {
                                                        $optionIds = json_decode($answer->answer_text, true) ?: [$answer->answer_text];
                                                        $selectedOptions = $question->options->whereIn('id', $optionIds);
                                                        
                                                        $formattedOptions = $selectedOptions->map(function($option) use ($question) {
                                                            if ($question->question_type === 'Pilihan Ganda (Berbobot)' && !is_null($option->value)) {
                                                                return $option->value . ' (' . $option->option_text . ')';
                                                            }
                                                            return $option->option_text;
                                                        });
                                                        
                                                        $answerText = $formattedOptions->implode(', ') ?: $answer->answer_text;
                                                    } else {
                                                        $answerText = $answer->answer_text;
                                                    }
                                                }
                                            @endphp
                                            <div class="text-sm text-gray-600 leading-relaxed min-w-[200px] break-words relative group flex justify-between items-center">
                                                <span>{{ $answerText }}</span>
                                                @php
                                                    $isOptions = in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)', 'Skala Kepuasan']);
                                                    $optionsJson = $isOptions ? $question->options->toJson() : '[]';
                                                    $currentAnswerText = $answer ? $answer->answer_text : '';
                                                @endphp
                                                <button type="button" onclick="openEditModal({{ $question->id }}, {{ $response->id }}, '{{ addslashes($question->question_text) }}', '{{ $question->question_type }}', '{{ addslashes($currentAnswerText) }}', {{ $optionsJson }})" class="opacity-0 group-hover:opacity-100 text-blue-500 hover:text-blue-700 transition-opacity p-1" title="Edit Jawaban">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $sortedQuestions->count() + 2 }}" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-gray-300 text-2xl"></i>
                                            </div>
                                            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Belum ada respon tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Answer Modal -->
<div id="editAnswerModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <form id="editAnswerForm" method="POST" action="{{ route('admin.surveys.responses.updateAnswer', $survey->slug) }}">
                @csrf
                <input type="hidden" name="response_id" id="edit_response_id">
                <input type="hidden" name="question_id" id="edit_question_id">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h3 class="text-lg leading-6 font-black text-gray-900" id="modal-title">Edit Jawaban Responden</h3>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm font-semibold text-gray-700 mb-2 p-3 bg-gray-50 rounded-xl border border-gray-100" id="edit_question_text"></p>
                        <div id="edit_input_container" class="mt-4">
                            <!-- Input will be injected here -->
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto transition-all active:scale-95">
                        <i class="fas fa-save mr-2 mt-0.5"></i> Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-5 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(questionId, responseId, questionText, questionType, currentAnswer, options) {
    document.getElementById('edit_question_id').value = questionId;
    document.getElementById('edit_response_id').value = responseId;
    document.getElementById('edit_question_text').innerText = questionText;
    
    let container = document.getElementById('edit_input_container');
    container.innerHTML = ''; // clear
    
    if (questionType === 'Skala Kepuasan') {
        let select = document.createElement('select');
        select.name = 'answer_text';
        select.className = 'mt-1 block w-full pl-3 pr-10 py-3 text-sm font-medium border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-white shadow-sm';
        for(let i=1; i<=5; i++) {
            let opt = document.createElement('option');
            opt.value = i;
            opt.innerText = i + (i === 1 ? ' (Sangat Kurang)' : (i === 5 ? ' (Sangat Baik)' : ''));
            if(currentAnswer == i) opt.selected = true;
            select.appendChild(opt);
        }
        container.appendChild(select);
    } else if (['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)'].includes(questionType)) {
        let select = document.createElement('select');
        select.name = 'answer_text';
        select.className = 'mt-1 block w-full pl-3 pr-10 py-3 text-sm font-medium border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-white shadow-sm';
        
        let parsedCurrent = currentAnswer;
        try {
            let arr = JSON.parse(currentAnswer);
            if(Array.isArray(arr)) parsedCurrent = arr[0]; 
        } catch(e) {}

        options.forEach(function(o) {
            let opt = document.createElement('option');
            opt.value = o.id;
            opt.innerText = o.option_text;
            if(parsedCurrent == o.id) opt.selected = true;
            select.appendChild(opt);
        });
        container.appendChild(select);
    } else {
        let input = document.createElement('textarea');
        input.name = 'answer_text';
        input.rows = 4;
        input.className = 'mt-1 block w-full border border-gray-200 rounded-xl shadow-sm py-3 px-4 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm';
        input.value = currentAnswer;
        container.appendChild(input);
    }
    
    document.getElementById('editAnswerModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editAnswerModal').classList.add('hidden');
}
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f8fafc;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>

@if(isset($chartData) && count($chartData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData);
        const chartInstances = {};
        const chartTypeSelector = document.getElementById('chartTypeSelector');

        const colors = [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', 
            '#ec4899', '#06b6d4', '#84cc16', '#f43f5e', '#14b8a6'
        ];

        function renderCharts(type) {
            Object.keys(chartData).forEach(questionId => {
                const canvas = document.getElementById('chart-' + questionId);
                if (!canvas) return;
                
                const ctx = canvas.getContext('2d');
                const data = chartData[questionId];
                
                if (chartInstances[questionId]) {
                    chartInstances[questionId].destroy();
                }

                let bgColors;
                if (type === 'pie' || type === 'doughnut') {
                    bgColors = data.labels.map((_, index) => colors[index % colors.length]);
                } else {
                    bgColors = colors[0] + '99'; // 60% opacity blue
                }

                chartInstances[questionId] = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.data,
                            backgroundColor: bgColors,
                            borderColor: type === 'bar' ? colors[0] : '#ffffff',
                            borderWidth: type === 'bar' ? 0 : 2,
                            borderRadius: type === 'bar' ? 8 : 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: {
                            legend: {
                                display: type !== 'bar',
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: { size: 10, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 },
                                cornerRadius: 8
                            }
                        },
                        scales: type === 'bar' ? {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' },
                                ticks: { stepSize: 1, font: { size: 10 } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 10, weight: 'bold' } }
                            }
                        } : {}
                    }
                });
            });
        }

        renderCharts('bar');
        chartTypeSelector.addEventListener('change', (e) => renderCharts(e.target.value));
    });

    async function exportWithCharts() {
        const canvases = document.querySelectorAll('canvas');
        if (canvases.length === 0) {
            alert('Tidak ada grafik untuk diekspor.');
            return;
        }

        // Show loading state
        const btn = document.querySelector('button[onclick="exportWithCharts()"]');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengompres Grafik...';

        try {
            const chartImages = [];
            
            for (let canvas of canvases) {
                // Optimasi: Buat canvas sementara untuk pengecekan ukuran
                const tempCanvas = document.createElement('canvas');
                const ctx = tempCanvas.getContext('2d');
                
                // Set max width 500px (Sangat cukup untuk Excel)
                const maxWidth = 500;
                const scale = Math.min(1, maxWidth / canvas.width);
                tempCanvas.width = canvas.width * scale;
                tempCanvas.height = canvas.height * scale;
                
                // Gambar ulang dengan ukuran lebih kecil
                ctx.fillStyle = '#ffffff'; // Background putih agar JPEG tidak hitam
                ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
                ctx.drawImage(canvas, 0, 0, tempCanvas.width, tempCanvas.height);
                
                // Gunakan JPEG kualitas 0.5 (Ukuran file berkurang drastis dibanding PNG)
                const dataUrl = tempCanvas.toDataURL('image/jpeg', 0.5);
                
                // Hapus prefix data:image/jpeg;base64, agar tidak memicu deteksi WAF (Error 403)
                const base64Data = dataUrl.split(',')[1] || dataUrl;
                chartImages.push(base64Data);
            }

            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim Data...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const response = await fetch("{{ route('admin.surveys.responses.exportExcel', $survey) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ 
                    chart_images: chartImages 
                })
            });

            if (!response.ok) {
                if (response.status === 403) {
                    throw new Error('Gagal: Server memblokir data besar (403). Silakan coba lagi atau kurangi jumlah grafik.');
                }
                throw new Error('Terjadi kesalahan server (Error ' + response.status + ')');
            }

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = "Laporan_Survei_{{ $survey->id }}_{{ date('Ymd_His') }}.xlsx";
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Export Error:', error);
            alert(error.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    }
</script>
@endif
@endsection

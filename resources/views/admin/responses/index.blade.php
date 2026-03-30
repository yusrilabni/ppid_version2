@extends('admin.layouts.app')

@section('title', 'Respon Survei: ' . $survey->title)

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Respon Survei</h1>
            <p class="text-sm text-gray-600">{{ $survey->title }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.surveys.responses.export', $survey) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center" target="_blank">
                <i class="fas fa-file-csv mr-2"></i>
                Export CSV
            </a>
            <a href="{{ route('admin.surveys.index') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Survei
            </a>
        </div>
    </div>

    @if(isset($chartData) && count($chartData) > 0)
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Analisis Grafik</h2>
                <div class="flex items-center space-x-2">
                    <label for="chartTypeSelector" class="text-sm font-medium text-gray-700">Jenis Grafik:</label>
                    <select id="chartTypeSelector" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="bar">Grafik Batang (Bar)</option>
                        <option value="pie">Grafik Lingkaran (Pie)</option>
                        <option value="doughnut">Grafik Donat (Doughnut)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($chartData as $questionId => $data)
                    @php
                        $question = $survey->questions->find($questionId);
                    @endphp
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-semibold text-gray-700 mb-2">{{ $question->question_text }}</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="chart-{{ $questionId }}"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartData = @json($chartData);
                const chartInstances = {};
                const chartTypeSelector = document.getElementById('chartTypeSelector');

                // Color palette for Pie/Doughnut charts
                const backgroundColors = [
                    'rgba(54, 162, 235, 0.7)',   // Blue
                    'rgba(255, 99, 132, 0.7)',   // Red
                    'rgba(255, 206, 86, 0.7)',   // Yellow
                    'rgba(75, 192, 192, 0.7)',   // Teal
                    'rgba(153, 102, 255, 0.7)',  // Purple
                    'rgba(255, 159, 64, 0.7)',   // Orange
                    'rgba(199, 199, 199, 0.7)',  // Grey
                    'rgba(83, 102, 255, 0.7)',   // Indigo
                    'rgba(40, 159, 64, 0.7)',    // Greenish
                    'rgba(215, 59, 64, 0.7)',    // Brownish
                ];

                const borderColors = backgroundColors.map(color => color.replace('0.7', '1'));

                function renderCharts(type) {
                    Object.keys(chartData).forEach(questionId => {
                        const ctx = document.getElementById('chart-' + questionId).getContext('2d');
                        const data = chartData[questionId];
                        
                        // Destroy existing chart if it exists
                        if (chartInstances[questionId]) {
                            chartInstances[questionId].destroy();
                        }

                        // Determine colors based on type
                        let bgColors, bColors;
                        if (type === 'pie' || type === 'doughnut') {
                            bgColors = data.labels.map((_, index) => backgroundColors[index % backgroundColors.length]);
                            bColors = data.labels.map((_, index) => borderColors[index % borderColors.length]);
                        } else {
                            bgColors = 'rgba(59, 130, 246, 0.5)'; // Single color for Bar
                            bColors = 'rgb(59, 130, 246)';
                        }

                        // Options configuration
                        const options = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: type !== 'bar', // Hide legend for bar charts usually, show for pie
                                    position: 'bottom'
                                }
                            }
                        };

                        if (type === 'bar') {
                            options.scales = {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            };
                            options.plugins.legend.display = false;
                        }

                        chartInstances[questionId] = new Chart(ctx, {
                            type: type,
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Jumlah Respon',
                                    data: data.data,
                                    backgroundColor: bgColors,
                                    borderColor: bColors,
                                    borderWidth: 1
                                }]
                            },
                            options: options
                        });
                    });
                }

                // Initial render
                renderCharts('bar');

                // Listener for change
                chartTypeSelector.addEventListener('change', function(e) {
                    renderCharts(e.target.value);
                });
            });
        </script>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                            Responden #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Submit
                        </th>
                        @foreach ($sortedQuestions as $question)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ Str::limit($question->question_text, 40) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($survey->responses as $response)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $response->created_at->format('d M Y, H:i') }}
                            </td>
                            @foreach ($sortedQuestions as $question)
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">
                                    @php
                                        $answer = $response->answers->firstWhere('question_id', $question->id);
                                        $answerText = '-';
                                        if ($answer) {
                                            if (in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)'])) {
                                                $optionIds = json_decode($answer->answer_text, true) ?: [$answer->answer_text];
                                                $selectedOptions = $question->options->whereIn('id', $optionIds);
                                                
                                                $formattedOptions = $selectedOptions->map(function($option) use ($question) {
                                                    if ($question->question_type === 'Pilihan Ganda (Berbobot)' && !is_null($option->value)) {
                                                        return $option->value;
                                                    }
                                                    return $option->option_text;
                                                });
                                                
                                                $answerText = $formattedOptions->implode(', ') ?: $answer->answer_text;
                                            } else {
                                                $answerText = $answer->answer_text;
                                            }
                                        }
                                    @endphp
                                    {{ $answerText }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $sortedQuestions->count() + 2 }}" class="px-6 py-12 text-center text-sm text-gray-500">
                                Belum ada respon untuk survei ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

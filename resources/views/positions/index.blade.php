@extends('admin.layouts.app')

@section('title', 'Manajemen Struktur Organisasi')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Struktur Organisasi</h2>
                <p class="text-gray-600">Atur hirarki jabatan secara visual</p>
            </div>
            <a href="{{ route('admin.positions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Jabatan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tampilan Hirarki</h3>
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-3">Tampilan Pohon (Tree View)</h4>
                <div class="border border-gray-200 rounded-lg p-4 bg-white max-h-96 overflow-y-auto">
                    @include('positions.tree', ['positions' => $positions])
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagan Organisasi</h3>
            <div id="chart_org" class="bg-white p-4 rounded-lg border border-gray-200 h-96"></div>
        </div>
    </div>

    <!-- Load Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['orgchart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Parent');
            data.addColumn('string', 'Tooltip');

            // Add root nodes
            @foreach($positions as $position)
                data.addRow(['{!! $position->title !!} - {!! $position->name ?: "Kosong" !!}', '', '']);

                // Add children recursively
                addChildren(data, {!! json_encode($position->toArray()) !!}, '{!! $position->title !!} - {!! $position->name ?: "Kosong" !!}');
            @endforeach

            var chart = new google.visualization.OrgChart(document.getElementById('chart_org'));
            chart.draw(data, {
                allowHtml: true,
                size: 'medium',
                allowCollapse: true
            });
        }

        function addChildren(data, position, parentId) {
            if(position.children && position.children.length > 0) {
                position.children.forEach(function(child) {
                    data.addRow(['{!! child.title !!} - {!! child.name ?: "Kosong" !!}', parentId, '']);
                    if(child.allChildren && child.allChildren.length > 0) {
                        addChildren(data, child, child.title + ' - ' + (child.name || 'Kosong'));
                    }
                });
            }
        }
    </script>
@endsection
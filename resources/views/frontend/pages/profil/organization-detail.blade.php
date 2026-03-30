@extends('frontend.layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Tentang OPD', 'url' => url('/profil/tentang-opd'), 'icon' => 'fas fa-building'],
                    ['title' => Str::limit($organization->name, 25), 'url' => '#', 'icon' => 'fas fa-info-circle']
                ]" />
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">{{ $organization->name }}</h1>
                        <a href="{{ url('/profil/tentang-opd') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $organization->positions->count() }}</div>
                                <div class="text-sm text-blue-600">Jabatan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $total_members }}</div>
                                <div class="text-sm text-blue-600">Anggota</div>
                            </div>
                            <div class="text-center">
                                <a
                                    href="{{ route('public.organizations.svg.chart', $organization->id) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Download SVG
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Text-based Hierarchy from Admin Structures -->
                    <div class="bg-white rounded-xl shadow p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tampilkan hierarki organisasi secara teks</h3>
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="relative pl-6 border-l-2 border-gray-200 space-y-4">
                                @forelse($positions_tree as $position)
                                    @include('frontend.pages.profil.text-hierarchy-position', [
                                        'position' => $position,
                                        'level' => 0
                                    ])
                                @empty
                                    <p class="text-gray-500 text-center py-4">Tidak ada posisi ditemukan untuk organisasi ini</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Visual Hierarchy Chart from Admin Structures -->
                    <div class="bg-white rounded-xl shadow p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualisasi Tentang OPD</h3>
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 overflow-x-auto">
                            <div class="flex justify-center">
                                @if($svg_chart)
                                    <div class="svg-container w-full max-w-full">
                                        <div class="svg-wrapper" style="min-width: 100%;">
                                            {!! $svg_chart !!}
                                        </div>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-8">Tidak ada data tentang OPD untuk ditampilkan</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Download SVG Chart -->
                    <div class="bg-white rounded-xl shadow p-6 mt-6 text-center">
                        <a href="{{ route('public.organizations.svg.chart', $organization->id) }}"
                           target="_blank"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            Download SVG Chart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .svg-container {
            min-height: 400px;
        }
        
        .svg-container svg {
            min-width: 100%;
            min-height: 400px;
        }
        
        .org-chart {
            min-width: 100%;
            padding: 10px;
        }
        
        .org-node {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            margin: 8px auto;
            text-align: center;
            min-width: 150px;
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            max-width: 180px;
        }
        
        .org-node:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.2), 0 4px 6px -2px rgba(59, 130, 246, 0.1);
        }

        .org-node-title {
            font-weight: 600;
            font-size: 13px;
            color: #1f2937;
            margin-bottom: 4px;
            min-height: 20px;
        }

        .org-node-name {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 6px;
            min-height: 16px;
        }

        .org-node-members {
            font-size: 10px;
            color: #4b5563;
            border-top: 1px solid #e5e7eb;
            padding-top: 4px;
            margin-top: 4px;
        }

        .org-children {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            width: 100%;
        }

        .org-level {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Improved Hierarchy Tree Styles */
        .hierarchy-tree {
            padding: 20px;
        }

        .hierarchy-list {
            list-style: none;
            padding: 0;
            margin: 0;
            position: relative;
        }

        .root-list {
            padding: 0;
        }

        .hierarchy-item {
            margin: 10px 0;
            position: relative;
        }

        .hierarchy-item:not(:last-child) {
            padding-bottom: 30px;
        }

        .hierarchy-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            width: 2px;
            height: calc(100% - 40px);
            background: #d1d5db;
            z-index: 1;
        }

        .hierarchy-item:not(:last-child)::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            width: 30%;
            height: 2px;
            background: #d1d5db;
            z-index: 1;
        }

        .position-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
            margin: 0 auto;
            width: 220px;
            text-align: center;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .position-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #3b82f6;
        }

        .position-title {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .position-name {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .position-members {
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            margin-top: 8px;
        }

        .member-item {
            font-size: 11px;
            color: #4b5563;
            padding: 2px 0;
        }

        .children-container {
            margin-top: 30px;
            padding-left: 5%;
        }

        .level-0 .position-card {
            border-color: #3b82f6;
            background-color: #dbeafe;
        }

        .level-1 .position-card {
            border-color: #10b981;
            background-color: #d1fae5;
        }

        .level-2 .position-card {
            border-color: #f59e0b;
            background-color: #fef3c7;
        }

        .level-3 .position-card {
            border-color: #ef4444;
            background-color: #fecaca;
        }

        .level-4 .position-card {
            border-color: #8b5cf6;
            background-color: #f3e8ff;
        }

        /* Organizational Structure Diagram Styles */
        .org-structure-diagram {
            padding: 20px 0;
            min-width: 100%;
        }

        .level-container {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .position-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            width: 100%;
            margin-bottom: 30px;
        }

        .position-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 200px;
        }

        .position-content {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 180px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .position-content:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #3b82f6;
        }

        .position-title {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .position-name {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .position-members {
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            margin-top: 8px;
        }

        .member-badge {
            font-size: 11px;
            color: #4b5563;
            padding: 2px 6px;
            background-color: #f3f4f6;
            border-radius: 20px;
            display: inline-block;
            margin: 2px;
        }

        .children-connector {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .connector-line {
            background-color: #9ca3af;
        }

        .connector-line.vertical {
            width: 2px;
            height: 25px;
        }

        .connector-line.horizontal {
            width: 100%;
            height: 2px;
            margin: 0 10px;
        }

        .children-container {
            width: 100%;
            margin-top: 10px;
        }

        .sub-level {
            margin-top: 10px;
        }

        /* Level-specific styling */
        .level-0 .position-content {
            border-color: #3b82f6;
            background-color: #dbeafe;
            border-width: 3px;
        }

        .level-1 .position-content {
            border-color: #10b981;
            background-color: #d1fae5;
        }

        .level-2 .position-content {
            border-color: #f59e0b;
            background-color: #fef3c7;
        }

        .level-3 .position-content {
            border-color: #ef4444;
            background-color: #fecaca;
        }

        .level-4 .position-content {
            border-color: #8b5cf6;
            background-color: #f3e8ff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hierarchy-tree {
                padding: 10px;
                overflow-x: auto;
            }

            .position-card {
                width: 180px;
                padding: 10px;
            }

            .children-container {
                padding-left: 20px;
            }

            .org-structure-diagram {
                overflow-x: auto;
            }

            .position-row {
                gap: 15px;
            }

            .position-content {
                width: 160px;
                padding: 12px;
            }
        }

        /* Position Card Level Styling */
        .position-card.level-0 {
            border-color: #3b82f6;
            background-color: #dbeafe;
            border-width: 2px;
        }

        .position-card.level-1 {
            border-color: #10b981;
            background-color: #d1fae5;
        }

        .position-card.level-2 {
            border-color: #f59e0b;
            background-color: #fef3c7;
        }

        .position-card.level-3 {
            border-color: #ef4444;
            background-color: #fecaca;
        }

        .member-badge {
            font-size: 10px;
            margin: 1px;
        }

        .svg-container {
            min-width: 100%;
            min-height: 600px;
        }
    </style>
@endpush
@extends('frontend.layouts.app')

@section('title', 'Preview: ' . $laporan->title)

@section('content')
<div class="bg-gray-900 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header / Toolbar -->
        <div class="flex flex-col md:flex-row justify-between items-center bg-gray-800 text-white p-4 rounded-t-lg shadow-lg mb-0 border-b border-gray-700">
            <div class="mb-4 md:mb-0">
                <a href="{{ route('laporan.ppid.index') }}" class="inline-flex items-center text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Laporan
                </a>
                <h1 class="text-lg font-semibold mt-1">{{ $laporan->title }}</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                <button id="btnPrev" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-sm transition-colors">
                    <i class="fas fa-chevron-left"></i> Prev
                </button>
                <span class="text-sm text-gray-400">
                    Page <span id="pageCurrent" class="text-white font-bold">1</span> of <span id="pageTotal" class="text-white font-bold">--</span>
                </span>
                <button id="btnNext" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-sm transition-colors">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Book Viewing Area -->
        <div class="book-wrapper bg-gray-800 rounded-b-lg shadow-2xl relative overflow-hidden flex flex-col items-center justify-center min-h-[600px] lg:min-h-[800px]">
            
            <!-- Loading Indicator -->
            <div id="loading" class="text-center z-20 absolute">
                <svg class="animate-spin h-12 w-12 text-blue-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p id="loading-text" class="text-white text-lg font-medium">Membuka Pratinjau...</p>
                <p id="loading-progress" class="text-sm text-gray-400 mt-2"></p>
            </div>

            <!-- The Book -->
            <div id="book" class="z-10"></div>
        </div>

    </div>
</div>

<style>
    /* Custom Flipbook Styles */
    .stf__wrapper {
        perspective: 4000px;
    }
    
    .page {
        background-color: white;
        box-shadow: inset -1px 0 5px rgba(0,0,0,0.05);
    }

    .page-content {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
    }
    
    .page-content canvas {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endsection

@push('scripts')
    <!-- External Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Use the Laravel route to serve the file
            const url = "{{ route('laporan.ppid.file', $token) }}";
            const loading = document.getElementById('loading');
            const loadingText = document.getElementById('loading-text');
            const bookContainer = document.getElementById('book');
            const pageCurrentSpan = document.getElementById('pageCurrent');
            const pageTotalSpan = document.getElementById('pageTotal');
            
            // PDF.js worker
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

            try {
                // 1. Fetch PDF Data manually
                console.log("Fetching PDF from:", url);
                loadingText.innerText = "Membuka Pratinjau...";

                const cacheBusterUrl = url + '?t=' + new Date().getTime();
                const response = await fetch(cacheBusterUrl);
                
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status} ${response.statusText}`);
                }
                
                const blob = await response.blob();
                if (blob.size === 0) {
                     throw new Error('Server returned empty file (0 bytes).');
                }
                
                loadingText.innerText = "Memproses Halaman...";
                const pdfData = await blob.arrayBuffer();

                // 2. Load PDF from ArrayBuffer
                const loadingTask = pdfjsLib.getDocument({
                    data: pdfData
                });
                
                const pdf = await loadingTask.promise;
                const numPages = pdf.numPages;
                pageTotalSpan.textContent = numPages;

                // 3. Render Logic
                // To keep it integrated, we use a slightly different dimension strategy
                const containerWidth = bookContainer.parentElement.clientWidth;
                // const baseHeight = 800; // Fixed reasonable height
                // const baseWidth = baseHeight / 1.41; 

                // Create DIVs for each page
                for (let i = 1; i <= numPages; i++) {
                    const pageDiv = document.createElement('div');
                    pageDiv.className = 'page';
                    pageDiv.innerHTML = `
                        <div class="page-content">
                            <canvas id="pdf-canvas-${i}"></canvas>
                        </div>
                    `;
                    bookContainer.appendChild(pageDiv);
                }

                // Initialize PageFlip with responsive settings
                const pageFlip = new St.PageFlip(bookContainer, {
                    width: 500, // Base width per page
                    height: 700, // Base height
                    size: 'stretch',
                    minWidth: 300,
                    maxWidth: 1000,
                    minHeight: 400,
                    maxHeight: 1200,
                    showCover: true,
                    maxShadowOpacity: 0.5,
                    usePortrait: true // Single page mode on mobile automatic
                });

                pageFlip.loadFromHTML(document.querySelectorAll('.page'));

                // Hide loading once prepared (though pages render async)
                loading.style.display = 'none';

                const renderPage = async (pageNum) => {
                    const canvas = document.getElementById(`pdf-canvas-${pageNum}`);
                    if (!canvas || canvas.dataset.rendered) return;

                    try {
                        const page = await pdf.getPage(pageNum);
                        
                        // We use a high scale for quality, then let CSS fit it
                        const scale = 2.0; 
                        const viewport = page.getViewport({ scale: scale });

                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        
                        // CSS already handles object-fit: contain

                        const renderContext = {
                            canvasContext: canvas.getContext('2d'),
                            viewport: viewport
                        };
                        
                        await page.render(renderContext).promise;
                        canvas.dataset.rendered = true;

                    } catch (err) {
                        console.error("Error rendering page " + pageNum, err);
                    }
                };

                // Initial Render
                renderPage(1);
                renderPage(2);
                renderPage(3);
                renderPage(4);

                pageFlip.on('flip', (e) => {
                    const currentPageIndex = e.data; 
                    const pageNum = currentPageIndex + 1;
                    
                    renderPage(pageNum);
                    renderPage(pageNum + 1);
                    renderPage(pageNum + 2);
                    renderPage(pageNum + 3);
                });

                setInterval(() => {
                    const current = pageFlip.getCurrentPageIndex() + 1;
                    pageCurrentSpan.textContent = current;
                }, 500);

                document.getElementById('btnPrev').addEventListener('click', () => pageFlip.flipPrev());
                document.getElementById('btnNext').addEventListener('click', () => pageFlip.flipNext());

            } catch (error) {
                console.error("Error loading PDF:", error);
                loading.innerHTML = `<p class="text-red-500 font-bold">Gagal memuat dokumen.</p><p class="text-gray-400 text-sm mt-2">${error.message}</p>`;
            }
        });
    </script>
@endpush
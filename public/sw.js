const CACHE_NAME = 'ppid-cache-v2';
const ASSETS_TO_CACHE = [
    './',
    './css/custom.css',
    './storage/logo/ppid.webp',
    'https://cdn.tailwindcss.com',
    'https://unpkg.com/lucide@latest',
    'https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js',
    'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js'
];

// Install Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

// Activate Service Worker
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch Strategy: Stale-While-Revalidate
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            const fetchPromise = fetch(event.request).then((networkResponse) => {
                // Jangan cache aset dari domain lain jika tidak perlu (opsional)
                if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                  // Jika ini dari CDN atau API, kita tetap bisa cache tapi dengan strategi berbeda.
                  // Untuk kesederhanaan, kita cache saja semuanya.
                }
                
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, networkResponse.clone());
                });
                return networkResponse;
            }).catch(() => {
                // Fallback jika offline dan tidak ada di cache
                return cachedResponse;
            });
            return cachedResponse || fetchPromise;
        })
    );
});

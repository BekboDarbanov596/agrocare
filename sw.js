const CACHE_NAME = 'agrocare-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/css/design-system.css?v=1.6',
    '/css/style.css?v=1.6',
    '/css/responsive.css?v=1.0',
    '/js/icons.js',
    '/icons/icons.svg',
    '/offline.html',
    '/manifest.json'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', (event) => {
    // Only handle navigation requests for offline fallback
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match('/offline.html');
            })
        );
        return;
    }

    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});


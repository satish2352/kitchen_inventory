// Service Worker

// Install event - Cache static assets
self.addEventListener('install', async function () {
  const cache = await caches.open('static012');
  await cache.addAll([
    './sw.js',
    './offline.html'
  ]);
  self.skipWaiting(); // Activate the new SW immediately
});

// Activate event - Clean up old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(cacheName => cacheName !== 'static012')
        .map(cacheName => caches.delete(cacheName))
      );
    })
  );
  self.clients.claim(); // Take control of all open clients
});

// Fetch event - Network first with fallback to cache
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return; // Ignore non-GET requests
  event.respondWith(networkFirst(event.request));
});

async function networkFirst(request) {
  try {
    const networkResponse = await fetch(request);
    return networkResponse;
  } catch (err) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    } else {
      return caches.match('./offline.html');
    }
  }
}

/* Offline HTML Page Content */
const offlinePage = `
<!DOCTYPE html>
<html>
<head>
    <title>Offline</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { color: #333; }
        p { color: #666; }
    </style>
</head>
<body>
    <h1>You are offline</h1>
    <p>It looks like you're not connected to the internet. Please check your connection and try again.</p>
</body>
</html>
`;

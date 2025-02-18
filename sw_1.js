self.addEventListener('install', async function () {
  const cache = await caches.open('static012');
        cache.add('./sw.js'),
        cache.add('./offline.html')
});

self.addEventListener('activate', event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  const request = event.request;
  event.respondWith(networkFirst(request));
});

async function networkFirst(request) 
{
  try 
  {
      const networkResponse = await fetch(request);
      return networkResponse;
  } 
  catch (err) 
  {
      const cachedResponse = await caches.match(request);
      if(cachedResponse)
      {
        return cachedResponse;
      }
      else
      {
        const cachedResponseNew= await caches.match('./offline.html');
        return cachedResponseNew;
      }
  }
}

const CACHE='fb-cache-v1';
const ASSETS=['/financebuddy/','/financebuddy/css/style.css','/financebuddy/js/main.js','/financebuddy/index.php'];
self.addEventListener('install',e=>{ e.waitUntil(caches.open(CACHE).then(c=>c.addAll(ASSETS))); });
self.addEventListener('fetch',e=>{ e.respondWith(fetch(e.request).catch(()=>caches.match(e.request).then(r=>r||caches.match('/financebuddy/')))); });

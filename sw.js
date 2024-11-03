// sw.js

const CACHE_NAME = "offline-cache-v1";
const OFFLINE_URL = "offline/offline.html"; // Changed to relative path
const ASSETS = [
  OFFLINE_URL,                            // Offline page
  "offline/styles.css",                   // Main CSS file, changed to relative path
  "offline/no-wifi.png"                   // Offline image, changed to relative path
];

// Install the service worker and cache assets
self.addEventListener("install", (event) => {
  console.log("Service Worker installing...");
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log("Caching offline assets");
      return cache.addAll(ASSETS);
    })
  );
  self.skipWaiting();
});

// Intercept fetch requests and serve from cache if offline
self.addEventListener("fetch", (event) => {
  event.respondWith(
    fetch(event.request)
      .catch(() => {
        return caches.match(event.request)
          .then((response) => response || caches.match(OFFLINE_URL));
      })
  );
});

// Clean up old caches during activation
self.addEventListener("activate", (event) => {
  console.log("Service Worker activating...");
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((cacheName) => cacheName !== CACHE_NAME)
          .map((cacheName) => caches.delete(cacheName))
      );
    })
  );
  self.clients.claim();
});

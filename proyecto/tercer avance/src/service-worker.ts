/// <reference lib="webworker" />
/* eslint-disable no-restricted-globals */

import { clientsClaim } from 'workbox-core';
import { ExpirationPlugin } from 'workbox-expiration';
import { precacheAndRoute, createHandlerBoundToURL } from 'workbox-precaching';
import { registerRoute } from 'workbox-routing';
import { StaleWhileRevalidate } from 'workbox-strategies';

declare const self: ServiceWorkerGlobalScope;

clientsClaim();

// Precache all of the assets generated by your build process.
precacheAndRoute(self.__WB_MANIFEST);

// Set up App Shell-style routing.
const fileExtensionRegexp = new RegExp('/[^/?]+\\.[^/]+$');
registerRoute(
  ({ request, url }) => {
    if (request.mode !== 'navigate') {
      return false;
    }
    if (url.pathname.startsWith('/_')) {
      return false;
    }
    if (url.pathname.match(fileExtensionRegexp)) {
      return false;
    }
    return true;
  },
  createHandlerBoundToURL(process.env.PUBLIC_URL + '/index.html')
);

// Cache images using a StaleWhileRevalidate strategy.
registerRoute(
  ({ url }) => url.origin === self.location.origin && url.pathname.endsWith('.png'),
  new StaleWhileRevalidate({
    cacheName: 'images',
    plugins: [
      new ExpirationPlugin({ maxEntries: 50 }),
    ],
  })
);

// Cache API responses using NetworkFirst strategy.
registerRoute(
  ({ url }) => url.origin === 'http://52.10.138.197:8000',
  new StaleWhileRevalidate({
    cacheName: 'api-cache',
    plugins: [
      new ExpirationPlugin({
        maxAgeSeconds: 24 * 60 * 60, // 1 day
        maxEntries: 50,
      }),
    ],
  })
);

// Handle registration of incidents (POST requests).
async function handleRegistration(request) {
  try {
    const response = await fetch(request.clone());
    return response;
  } catch (error) {
    const serializedRequest = await serializeRequest(request);
    await storeRequestInQueue(serializedRequest); // Almacenar la solicitud serializada en la cola
    return new Response('Registro guardado para enviar más tarde.', { status: 202 });
  }
}

// Process the registration queue when there is a successful GET request.
async function processQueue() {
  const queue = await getQueue();
  
  if (queue.length > 0) {
    console.log("Reintentando registro en cola");
    for (const serializedRequest of queue) {
      const reconstructedRequest = await reconstructRequest(serializedRequest);
      
      try {
        const response = await fetch(reconstructedRequest);
        await removeRequestFromQueue(serializedRequest);
      } catch (error) {
        console.error('Error processing queued request:', error);
      }
    }
  }
}

// Listen for fetch events to intercept registration (POST) requests.
self.addEventListener('fetch', (event) => {
  if (event.request.method === 'POST' && event.request.url.includes('/api/v1/incidente')) {
    event.respondWith(handleRegistration(event.request));
  } else if (event.request.method === 'GET') {
    event.respondWith(
      (async () => {
        const response = await fetch(event.request);
        processQueue();
        return response;
      })()
    );
  }
});

// Serialize a request into a JSON string.
async function serializeRequest(request) {
  const serialized = {
    url: request.url,
    method: request.method,
    headers: {},
    body: await request.clone().text()
  };

  request.headers.forEach((value, key) => {
    serialized.headers[key] = value;
  });

  console.log("Request POST serializado en JSON");

  return JSON.stringify(serialized);
}

// Store a serialized request in the queue.
async function storeRequestInQueue(serializedRequest) {
  const queue = await getQueue();
  queue.push(serializedRequest);
  console.log("Request guardado en la cola");
  await caches.open('registration-queue').then(cache => cache.put('queue', new Response(JSON.stringify(queue))));
}

// Retrieve the queue of stored requests.
async function getQueue() {
  const cache = await caches.open('registration-queue');
  const cachedQueue = await cache.match('queue');
  const queue = cachedQueue ? await cachedQueue.json() : [];
  console.log("Cola de requests pendientes cargada");
  return queue;
}

// Remove a request from the queue.
async function removeRequestFromQueue(serializedRequest) {
  const queue = await getQueue();
  const updatedQueue = queue.filter(item => item !== serializedRequest);
  console.log("Request removida de la cola");
  await caches.open('registration-queue').then(cache => cache.put('queue', new Response(JSON.stringify(updatedQueue))));
}

// Reconstruct a request from serialized data.
async function reconstructRequest(serializedRequest) {
  const { url, method, headers, body } = JSON.parse(serializedRequest);
  const requestInit = {
    method,
    headers: new Headers(headers),
    body
  };
  const request = new Request(url, requestInit);
  console.log("Request re-construida desde JSON");
  return request;
}

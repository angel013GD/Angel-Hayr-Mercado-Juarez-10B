//Detecta si podemos usar Service Workers
// npm install -g http-server      
// htpp-server -o
if(navigator.serviceWorker){
    navigator.serviceWorker.register('./sw.js')
}
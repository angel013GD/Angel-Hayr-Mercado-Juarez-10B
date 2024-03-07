
if(navigator.serviceWorker){
    console.log("servidor Activo");
    navigator.serviceWorker.register('./sw.js')
}
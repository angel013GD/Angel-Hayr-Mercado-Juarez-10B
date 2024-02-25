function sumaruno(numero) {

    var prom = new Promise(function (resolve,reject) {
        if (numero >= 7) {
            reject("Numero Muy Grande!!");
        }
        setTimeout(function(){
            // return numero +1;
            resolve(numero+1);
        },800);
    })

    return prom;

}
// sumaruno(5).then((res)=>{
//     console.log(res)
//     return sumaruno(res);
// }).then((res)=>{
//     console.log(res)
//     return sumaruno(res);
// }).then((res)=>{
//     console.log(res)
//     return sumaruno(res);
// })

sumaruno(5)
    .then(sumaruno)
    .then(sumaruno)
    .then(nuevoValor=>{
        console.log(nuevoValor);
    }).catch(err =>{
        console.log(err);
    })
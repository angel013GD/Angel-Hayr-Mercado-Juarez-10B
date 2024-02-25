function sumaruno(numero,callback) {
    setTimeout(function(){
        // return numero +1;
        callback(numero+1);
    },800);
}

// console.log(sumaruno(5)); 
sumaruno(5, function (nuevoValor){
    console.log(nuevoValor);
    sumaruno(nuevoValor,function(nuevoValor2){
        console.log(nuevoValor2);
        sumaruno(nuevoValor2,function(nuevoValor3){
            console.log(nuevoValor3);
        })
    })
})
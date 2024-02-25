const fs = require('fs').promises;

async function getData(url) {
    try {
        return fetch(url)
        .then(response => response.json());
    } catch (error) {
        console.error("Error al obtener datos:", error.message);
        throw error; 
    }

}

async function postData(url, body,token) {

    return await fetch(url, {
        method: 'POST',
        body: JSON.stringify(body),
        headers: { 
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
         }

    }).then(response =>

        response.json())
        .then(response => {
            if (response['success']) {
             return response;
            }
            alert(response['messenge']);
        }).catch(response=>{
            console.log(response);
        })

}
async function getDataBlob(url) {
    try {
        const response = await fetch(url);

        const blobData = await response.blob();

        const uint8Array = new Uint8Array(await new Response(blobData).arrayBuffer());

        const bufferData = Buffer.from(uint8Array);
        const pdfFilePath = 'archivo.pdf';
        await fs.writeFile(pdfFilePath, bufferData);

        console.log(`PDF descargado exitosamente como ${pdfFilePath}`);
    } catch (error) {
        console.error("Error al obtener datos:", error.message);
        throw error; 
    }

}
async function postDataClone(url, body, token) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(body),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        });


        const clonedResponse = response.clone();
        console.log(clonedResponse);

        const responseData = await response.json();
        // console.log(responseData);
    } catch (error) {
        console.error(error.message);
        throw error;
    }
}
const apiV3= 'https://visionremota.com.mx/v3apidev/api/v1/';
async function accion() {
    // var urlGet = 'https://rickandmortyapi.com/api/character';

    // let data = await getData(urlGet);
    // console.log(data);

    // var urlPost = `${apiV3}auth/login`;
    // var body = {
    //     nombre_usuario: "angel2",
    //     contrasenia: "80735228c8e9b43410f2b207f0e54fb0"
    // };
    // let data = await postData(urlPost, body);
    // console.log(data);
    // let token= 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdmlzaW9ucmVtb3RhLmNvbS5teFwvdjNhcGlkZXZcL2FwaVwvdjFcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNzA4ODQ1ODMyLCJleHAiOjE3MDg5MzIyMzIsIm5iZiI6MTcwODg0NTgzMiwianRpIjoiUGxkZmxUbFNnV2VEOXk4ZiIsInN1YiI6NzcsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.ObzDwrBK7p_ff6H7y82YioFpCFAnagrR-1zhc9lt9vs';

    // // console.log(data);
    // var urlPost2 = `${apiV3}reportesuso/buscadortarifas/general`;
    // var body2={
    //     usuario:[],
    //     periodo: {
    //         // start: "2023-11-01",
    //         // end: "2023-11-15"
    //     }
    
    // }
    // let data = await postData(urlPost2, body2,token);
    // console.log(data);
    // data.data.Rutas.forEach(element => {
    //     console.log(JSON.stringify(element));
    // });
    // await postDataClone(urlPost2, body2,token);

    var urlPdf = `https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf`;
     await getDataBlob(urlPdf);

}



accion();

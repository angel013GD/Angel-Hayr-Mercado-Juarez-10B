//Detecta si podemos usar Service Workers
// npm install -g http-server      
// htpp-server -o
if(navigator.serviceWorker){
    navigator.serviceWorker.register('./sw.js')
}

async function showMenuOption(opcion) {
    let resultContainer = document.getElementById('result');
    resultContainer.innerHTML = ''; 

    let data = await getData();
    const pendientesResueltos = data.filter(element => element.completed);
    const pendientesSinResolver = data.filter(element => !element.completed);

    switch (opcion) {
        case '1':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes (Solo Id):</h2>";
            data.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id}</p>`;
            });
            break;
        case '2':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes (Id y Titles):</h2>";
            data.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- Title: ${element.title}</p>`;
            });
            break;
        case '3':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes sin resolver (Id y Titles):</h2>";
            pendientesSinResolver.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- Title: ${element.title}</p>`;
            });
            break;
        case '4':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes resueltos (Id y Titles):</h2>";
            pendientesResueltos.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- Title: ${element.title}</p>`;
            });
            break;
        case '5':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes (Id y idUser):</h2>";
            data.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- UserID: ${element.userId}</p>`;
            });
            break;
        case '6':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes resueltos (Id y idUser):</h2>";
            pendientesResueltos.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- UserID: ${element.userId}</p>`;
            });
            break;
        case '7':
            resultContainer.innerHTML = "<h2>Lista de todos los pendientes sin resolver (Id y idUser):</h2>";
            pendientesSinResolver.forEach(element => {
                resultContainer.innerHTML += `<p>ID: ${element.id} -- UserID: ${element.userId}</p>`;
            });
            break;
        default:
            resultContainer.innerHTML = '<p>Opción no válida. Favor de ingresar una opción válida</p>';
    }
}


async function getData() {
    var url = 'https://jsonplaceholder.typicode.com/todos';
    try {
        return fetch(url)
        .then(response => response.json());
    } catch (error) {
        console.error("Error al obtener datos:", error.message);
        throw error; 
    }
}


const readline = require('readline');

const menuList=`
Menu de la NFL:
1 - Lista de todos los pendientes (Solo Id)
2 - Lista de todos los pendientes (Id y Titles)
3 - Lista de todos los pendientes sin resolver (Id y Titles)
4 - Lista de todos los pendientes resueltos (Id y Titles)
5 - Lista de todos los pendientes (Id y idUser)
6 - Lista de todos los pendientes resueltos (Id y idUser)
7 - Lista de todos los pendientes sin resolver (Id y idUser)
8 - Salir
`;

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

function pregunta(pregunta) {
    return new Promise(resolve => {
        rl.question(pregunta, answer => {
            resolve(answer.trim());
        });
    });
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


async function menu() {
    let data = await getData();
    const pendientesResueltos = data.filter(element => element.completed);
    const pendientesSinResolver = data.filter(element => !element.completed);

    while (true) {
        console.log(menuList);

        const opcion = await pregunta('Selecciona una opción (1-8): ');
        switch (opcion) {
            case '1':
                console.log("\nLista de todos los pendientes (Solo Id):");
                data.forEach(element => {
                    console.log(`ID: ${element.id}`);
                });
                break;
            case '2':
                console.log("\nLista de todos los pendientes (Id y Titles):");
                data.forEach(element => {
                    console.log(`ID: ${element.id} -- Title: ${element.title}`);
                });
                break;
            case '3':
                console.log("\nLista de todos los pendientes sin resolver (Id y Titles):");
                pendientesSinResolver.forEach(element => {
                    console.log(`ID: ${element.id} -- Title: ${element.title}`);
                });
                break;
            case '4':
                console.log("\nLista de todos los pendientes resueltos (Id y Titles):");
                pendientesResueltos.forEach(element => {
                    console.log(`ID: ${element.id} -- Title: ${element.title}`);
                });
                break;
            case '5':
                console.log("\nLista de todos los pendientes (Id y idUser):");
                data.forEach(element => {
                    console.log(`ID: ${element.id} -- UserID: ${element.userId}`);
                });
                break;
            case '6':
                console.log("\nLista de todos los pendientes resueltos (Id y idUser):");
                pendientesResueltos.forEach(element => {
                    console.log(`ID: ${element.id} -- UserID: ${element.userId}`);
                });
                break;
            case '7':
                console.log("\nLista de todos los pendientes sin resolver (Id y idUser):");
                pendientesSinResolver.forEach(element => {
                    console.log(`ID: ${element.id} -- UserID: ${element.userId}`);
                });
                break;
            case '8':
                console.log('Hasta luego');
                rl.close();
                return;
            default:
                console.log('Opción no valida. Favor de ingresar una opcion valida');
        }

        let regresarMenu;
        while (true) {
            regresarMenu = await pregunta('¿Deseas regresar al menú? (Si/No): ');
            if (regresarMenu.toLowerCase() === 'si' || regresarMenu.toLowerCase() === 'no') {
                break;
            } else {
                console.log('Opcion no valida. Favor de ingresar "Si" o "No".');
            }
        }
    
        if (regresarMenu.toLowerCase() !== 'si') {
            console.log('Hasta luego');
            rl.close();
            return;
        }
    }
}



menu();

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Direccion;
use App\Models\DatosSeguro;
use App\Models\DatosEmergencia;
use App\Models\Puesto;
use App\Models\Departamento;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Puestos por departamento (deberías tener los IDs correctos según tu base de datos)
        $puestosPorDepartamento = range(1, 30);

        // Datos comunes para los empleados
        $datosEmpleadoComunes = [
            "telefono" => "123456789",
            "correo" => "correo@example.com",
        ];

        // Genera empleados para cada departamento y puesto
        $departamentos = Departamento::all();

        foreach ($departamentos as $departamento) {
            foreach ($puestosPorDepartamento as $puestoId) {
                // Datos específicos del empleado
                $datosEmpleadoEspecificos = [
                    "nombre" => $this->generarNombreAleatorio(),
                    "apellido_paterno" => $this->generarApellidoAleatorio(),
                    "apellido_materno" => $this->generarApellidoAleatorio(),
                    "fecha_nacimiento" => $this->generarFechaNacimientoAleatoria(),
                    "puesto_id" => $puestoId,
                ];

                // Crea el empleado y sus relaciones
                $empleado = Empleado::create(array_merge($datosEmpleadoComunes, $datosEmpleadoEspecificos));
                $empleado->direccion()->create([
                    "calle" => $this->generarDatoAleatorio('Calle'),
                    "colonia" => $this->generarDatoAleatorio('Colonia'),
                    "no_interior" => rand(1, 100),
                    "no_exterior" => rand(100, 9999),
                    "cp" => rand(10000, 99999),
                    "estado" => $this->generarDatoAleatorio('Estado'),
                    "pais" => $this->generarDatoAleatorio('Pais'),
                ]);
                $empleado->datosSeguro()->create([
                    "numero_seguro" => "9451141564",
                    "fecha_alta_seguro" => "1990-01-01",
                ]);
                $empleado->datosEmergencia()->create([
                    "contacto_emergencia" => "ContactoEmergencia",
                    "correo_emergencia" => "emergencia@gmail.com",
                    "telefono_emergencia" => "521664789621",
                    "alergias" => "Ninguna",
                    "tipo_sangre" => "A+",
                ]);
            }
        }
    }

    private function generarNombreAleatorio()
    {
        $nombres = ['Juan', 'Maria', 'Pedro', 'Ana', 'Luis', 'Laura', 'Carlos', 'Marta', 'Javier', 'Elena'];
        return $nombres[array_rand($nombres)];
    }

    private function generarApellidoAleatorio()
    {
        $apellidos = ['Gomez', 'Rodriguez', 'Lopez', 'Perez', 'Fernandez', 'Garcia', 'Martinez', 'Sanchez', 'Romero', 'Serrano'];
        return $apellidos[array_rand($apellidos)];
    }

    private function generarFechaNacimientoAleatoria()
    {
        $inicio = strtotime("1950-01-01");
        $fin = strtotime("2000-12-31");
        $fechaAleatoria = date("Y-m-d", rand($inicio, $fin));
        return $fechaAleatoria;
    }

    private function generarDatoAleatorio($tipo)
    {
        $datosAleatorios = [
            'Calle' => ['Juarez', 'Reforma', 'Hidalgo', 'Benito Juarez', 'Zaragoza'],
            'Colonia' => ['Centro', 'Revolucion', 'Las Flores', 'Del Valle', 'San Miguel'],
            'Estado' => ['Tijuana', 'Monterrey', 'Guadalajara', 'Puebla', 'Queretaro'],
            'Pais' => ['Mexico', 'Estados Unidos', 'Canada', 'Argentina', 'Brasil'],
        ];

        return $datosAleatorios[$tipo][array_rand($datosAleatorios[$tipo])];
    }
}

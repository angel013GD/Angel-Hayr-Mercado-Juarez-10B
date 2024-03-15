<?php
namespace App\Utils;
use Carbon\Carbon;

class Utils{

    /**
     * !FUNCIONES: ALERTAS
     */
    public static function responseSuccess($data,$message="Consulta Exitosa",$code=200){
        return response()->json([
            "status" => true,
            "data" => $data,
            "message" => $message,
        ], $code);
    }

    public static function responseError($data,$message="Error Consulta",$code=200){
        return response()->json([
            "status" => false,
            "data" => $data,
            "message" => $message,
        ], $code);
    }

    public static function responseFuntions($status,$data,$message){
        return [
            "status" => $status,
            "data" => $data,
            "message" => $message,
        ];
    }


    public static function responseJSON($body,$code){
        return response()->json($body,$code);
    }

    /**
     * !FUNCIONES: DEBUGGER
     */
    public static function debuggerQuery($query){

            // Obtén la consulta generada por Laravel sin ejecutarla
            $sqlQuery = $query->toSql();

            // Obtiene los valores enlazados
            $bindings = $query->getBindings();

            // Combina la consulta y los valores enlazados para obtener la consulta final
            $queryWithBindings = vsprintf(str_replace(['?'], ['\'%s\''], $sqlQuery), $bindings);

            // Imprime la consulta SQL con los valores enlazados
            echo $queryWithBindings;

    }


    /**
     * !FUNCIONES: FECHAS
     */

    /**
     * Obtiene los dias restantes del intervalo de fechas
     * Pasandole como parametro un inicio y un final en "STRING"
     * dayBusiness = true (No contar los domingos)
     */
    public static function getDayInterval($fechaInicio,$fechaFinal,$dayBusiness) {

        // Crea una instancia de Carbon
        // Convierte las fechas en objetos Carbon
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $fechaInicio);
        $fechaFinal = Carbon::createFromFormat('Y-m-d', $fechaFinal);

        // Inicializa el contador de días excluyendo los domingos
        $counSunday = 0;
        $counDays = 0;

        // Itera a través de los días en el rango
        while ($fechaInicio->lte($fechaFinal)) {

            if($dayBusiness){
                // Si el día no es domingo, incrementa el contador
                if ($fechaInicio->dayOfWeek == Carbon::SUNDAY) {
                    $counSunday++;
                }
            }
            $counDays++;
            // Avanza al siguiente día
            $fechaInicio->addDay();
        }

        return $counDays-$counSunday;
    }

    /**
     * Obtiene el dia Actual
     * en formato YYYY-MM-DD
     */
    public static function getCurrentDay($zonaHorarioa='America/Los_Angeles'){
        return Carbon::now($zonaHorarioa)->toDateString();
    }


    /**
     * Obtiene el dia anterior del dia ACTUAL
     * en formato YYYY-MM-DD
     */
    public static function getLastDay(){

        // Crea una instancia de Carbon con la fecha actual
        $fechaActual = Carbon::now();

        // Establece la zona horaria para la instancia de Carbon
        $fechaActual->setTimezone('America/Los_Angeles');

        // Resta un día a la fecha actual
        $fechaRestada = $fechaActual->subDay();

        $fechaRestadaFormateada = $fechaRestada->format('Y-m-d');

        return $fechaRestadaFormateada;

    }

    /**
     * Obtiene el PRIMER dia del mes en base a la fecha actual
     * formato por default: YYYY-MM-DD
     */
    public static function getStartDayMonth($format="Y-m-d"){
        $dateStartMonth=Carbon::now()->startOfMonth();
        return $dateStartMonth->format($format);
    }

    /**
     * Obtiene el ULTIMO dia del mes en base a la fecha actual
     * formato por default: YYYY-MM-DD
     */
    public static function getEndDayMonth($format="Y-m-d"){
        $dateEndMonth=Carbon::now()->endOfMonth();
        return $dateEndMonth->format($format);
    }


    /**
     * Obtiene las semana laborales en el rango de fechas
     * pasado como parametro, Las semanas laborales se consideran de lunes - sabados
     * Se puede consigerar una semana laboral si en el rango de fecha comienza de viernes
     * Con que contenga un dia esa semana ya se considera semana laboral
     */
    public static function getBusinessWeeks($start,$end){

        $dateStart=Carbon::parse($start);
        $dateEnd=Carbon::parse($end);

        $semanasLaborales = 0;

        // Recorremos los días desde el primer día hasta el último día del mes
        for ($dia = $dateStart; $dia <= $dateEnd; $dia->addDay()) {

            // Verificamos si el día actual es un día laborable (de lunes a sábado)
            if ($dia->dayOfWeek >= 1 && $dia->dayOfWeek <= 6) {
                // Incrementamos el contador de semanas laborales
                $semanasLaborales++;

                // Saltamos al siguiente sábado para evitar contar la misma semana laboral más de una vez
                $dia->next(Carbon::SATURDAY);
            }
        }

        return $semanasLaborales;
    }

    public static function getNextSaturday($date){

        // Convierte la fecha pasada como parámetro a un objeto Carbon
        $objectDateStart = Carbon::parse($date);
        $dateStart=Carbon::parse($date);
        $numberWeek=$dateStart->isoWeek;


        // Calcula la diferencia de días hasta el próximo sábado (día 6)
        $diasHastaProximoSabado = 6 - $objectDateStart->dayOfWeek;

        // Si la fecha actual ya es un sábado, Enviamos la misma
        // fecha como inicio y final
        if ($diasHastaProximoSabado <= 0) {
            // es sabado
            return[
                "start"=>$dateStart->toDateString(),
                "end"=>$dateStart->toDateString(),
                "isRange"=>true,
                "numberWeek"=>$numberWeek
            ];
        }

        // Añade la diferencia de días para obtener el próximo sábado
        $proximoSabado = $objectDateStart->addDays($diasHastaProximoSabado);

        // Verifica si el próximo sábado pertenece al mismo mes que la fecha de entrada
        if ($proximoSabado->month != $dateStart->month) {
            // Se salió del mes
            return[
                "start"=>$dateStart->toDateString(),
                "end"=>$dateStart->toDateString(),
                "isRange"=>false,
                "numberWeek"=>$numberWeek
            ];
        }

        return[
            "start"=>$dateStart->toDateString(),
            "end"=>$proximoSabado->toDateString(),
            "isRange"=>true,
            "numberWeek"=>$numberWeek

        ];

    }


    /**
     * Calcula los dias faltantes
     * que falta a la fecha actual para que llegue a la fecha final
     *
     */
    public static function getDiasFaltantes($fechaInicio, $fechaFin) {

        $fechaActual = Carbon::now();

        $fechaInicio = Carbon::parse($fechaInicio);
        $fechaFin = Carbon::parse($fechaFin);

        if ($fechaActual->between($fechaInicio, $fechaFin)) {


            return ($fechaActual->diffInDays($fechaFin)) + 1; //Se suma uno porque no toma en cuenta el primer dia

        } else {
            // Se compara si $fechaFin es mayor que $fechaActual
            if($fechaFin->greaterThan($fechaActual)){

                return 6;
            }

            return 0;
        }
    }


    /**
     *!FUNCIONES: CALCULOS
     */
    public  static function calculatePromedio($data,$columnCalculate){

        $arrrayDataColumn = array_column($data, $columnCalculate);

        $countItems=count($data);

        $totalData = array_sum($arrrayDataColumn);

        $promedio=$countItems && $totalData  ? $totalData / $countItems : 0;

        return $promedio;
    }

    public  static function calculateSuma($data,$columnCalculate){

        $arrrayDataColumn = array_column($data, $columnCalculate);

        $totalSuma = array_sum($arrrayDataColumn);

        return $totalSuma;
    }

    public static function calculatePorcentaje($total,$item){

        return $item && $total ?  $item * 100 / $total : 0;

    }


    /**
     * !FUNCIONES: ARRAYS
     */
         /**
      * Filtera un los datos de un array bidimensional
      * @param data type array bidimensoanl
      * @param columnFilter string columna del array donde se va a filtrar los datos
      * @param dataSearch string a buscar para el filtrado de datos
      * @param isArray boolean si es true busca filtra por varios datos, si es false filtra por un dato
      */
      public static function filterArrayData($data,$columnFilter,$dataSearch,$isArray=false){

        $arrayData=array_filter($data,function($row) use ($columnFilter,$dataSearch,$isArray){

            if($isArray){
                if(in_array($row[$columnFilter],$dataSearch)){
                    return $row[$columnFilter];
                };
                return null;
            }else{

                return $row[$columnFilter] === $dataSearch;

            }

        });

        return $arrayData;
     }
}


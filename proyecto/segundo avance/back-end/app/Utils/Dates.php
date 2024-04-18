<?php
namespace App\Utils;
use App\Utils\Utils;
use Carbon\Carbon;

class Dates{

    /**
     * Obtiene el PRIMER dia del mes de la fecha
     */
    public static function getFirstDate($date, $format = 'Y-m-d')
    {
        // Crea un objeto Carbon a partir de la fecha proporcionada
        $dateObject = Carbon::parse($date);

        // Establece el día en 1 para obtener el primer día del mes
        $firstDate = $dateObject->startOfMonth();

        return $firstDate->format($format);
    }
    /**
     * Obtiene el ULTIMO dia del mes de la fecha
     */
    public static function getEndDate($date, $format = 'Y-m-d')
    {
        // Crea un objeto Carbon a partir de la fecha proporcionada
        $dateObject = Carbon::parse($date);

        // Establece el día en 1 para obtener el ultimo día del mes
        $firstDate = $dateObject->endOfMonth();

        return $firstDate->format($format);
    }

    public static function getNumberMonth($date){
        $months=[
            "1"=>'Enero',
            "2"=>'Febrero',
            "3"=>'Marzo',
            "4"=>'Abril',
            "5"=>'Mayo',
            "6"=>'Junio',
            "7"=>'Julio',
            "8"=>'Agosto',
            "9"=>'Septiembre',
            "10"=>'Octubre',
            "11"=>'Noviembre',
            "12"=>'Diciembre'
        ];

        $fechaCarbon = Carbon::parse($date);

        // Obtiene el número del mes
        $numeroMes = ($fechaCarbon->month);

        return $months[$numeroMes];
    }

    public static function getDateHistorico(){

        $currentDate=Carbon::now();
        $year=$currentDate->year;

        return "$year-01-01";
    }

    /**
     * $year: El año para el cual deseas obtener el rango de fechas.
     *  $month: El número de mes (1 para enero, 2 para febrero, etc.) para el cual deseas obtener el rango de fechas.
     */
    public static function getMonthRange($year, $month) {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        return [
            'start' => $startDate->toDateString(),
            'end' => $endDate->toDateString(),
        ];
    }
}


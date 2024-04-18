<?php
namespace App\Utils;
use App\Utils\Utils;
use App\Utils\Options;

class Validations{

    /**
     * !Modulo Dashboard
     * Valida los datos del Modulo Dashboard.
     * Declara variables globales si los datos estan bien
     * para usarlo en las APIS
     */
    public static function paramDashboard($request){

        // DATOS USER
        $rol = $request->input("user.rol");
        $departamento = $request->input("user.departamento");
        $typeDashboard = $request->input('user.typeDashboard');

        /**
         * Opciones:
         * ALL: ver todos los planner
         * o
         * USER: Solo ver su usario
         *
         */
        $viewPlanner = $request->input('user.planners');
        $username = $request->input('user.username');
        $currency = $request->input('view.currency');



        // FILTER
        $dateEnd = $request->input("filter.dateEnd");
        $dateStart = $request->input("filter.dateStart");
        $COMPANYS =$request->input("filter.companys");
        $COMPANYS=!$COMPANYS?null:(!count($COMPANYS)?null:$COMPANYS);
        $CURRENCYS = $request->input("filter.currencys");
        $CURRENCYS=!$CURRENCYS?null:(!count($CURRENCYS)?null:$CURRENCYS);
        $PLANNERS = $request->input("filter.planners");
        $PLANNERS=!$PLANNERS?null:(!count($PLANNERS)?null:$PLANNERS);

        $tc = $request->input("filter.tc");


        $clientes = $request->input("user.clientes");
        $proveedores = $request->input("user.proveedores");
        $etapas = $request->input("user.etapas");


        // VALIDATION
        $statusValidate=self::validateDefault(
            $rol,
            $departamento,
            $typeDashboard,
            $dateStart,
            $dateEnd,
            $tc,
            $clientes,
            $proveedores,
            $etapas,
            $viewPlanner,
            $username,
            $currency
        );

        if(!$statusValidate["status"]){
            return $statusValidate;
        }


        $dashboard=Options::$FILTER_DASHBOARDS[$typeDashboard] ?? null;


        Options::$username = $username;
        Options::$currency = $currency;



        /**
         * Si es "USER" solo puede ver sus DATOS
         * Si es ALL u Otro puede ver los que tenga configurado
         */
        $LIST_PLANNERS = $viewPlanner=="USER"?[Options::$username]:Options::$LIST_PLANNERS_VIEW[$viewPlanner];

        /**
         * Si la lista de filtro de planner viene vacia
         * Verificar si el usario puede ver todo los planner o solo su usario
         */
        $LIST_PLANNERS=!$PLANNERS?$LIST_PLANNERS:$PLANNERS;


        Options::$dashboard = $dashboard;
        Options::$dateStart = $dateStart;
        Options::$dateEnd = $dateEnd;
        Options::$COMPANYS = $COMPANYS;
        Options::$CURRENCYS = $CURRENCYS;
        Options::$PLANNERS = $LIST_PLANNERS;
        Options::$tc = $tc;
        Options::$departamento = $departamento;

        Options::$clientes = $clientes;
        Options::$proveedores = $proveedores;
        Options::$etapas = $etapas;

        return Utils::responseFuntions(true,[],"OK");

    }

    // OK
    public static function validateTypeDashboard($dashboard){

        if(!$dashboard){
            return Utils::responseFuntions(false,[],"Parametro 'typeDashboard' Undefined");
        }

        if(!in_array($dashboard,Options::$LIST_DASHBOARDS)){
            return Utils::responseFuntions(false,[],"Parametro 'typeDashboard' no encontrado en lista de Dashboards");
        }

        return Utils::responseFuntions(true,[],"OK");
    }

    // OK
    public static function validateDateRange($start,$end){

        $regex='/^\d{4}-\d{2}-\d{2}$/';

        if(!$start){
            return Utils::responseFuntions(false,[],"Parametro 'dateStart' Undefined");
        }

        if(!$end){
            return Utils::responseFuntions(false,[],"Parametro 'dateEnd' Undefined");
        }

        if (!preg_match($regex, $start)) {
            return Utils::responseFuntions(false,[],"Parametro 'dateStart' en formato no validato, Formato aceptado: 'YYYY-MM-DD'");
        }

        if(!preg_match($regex, $end)){
            return Utils::responseFuntions(false,[],"Parametro 'dateEnd' en formato no validato, Formato aceptado: 'YYYY-MM-DD'");
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    // OK
    public static function validateDefault($rol,$departamento,$typeDashboard,$dateStart,$dateEnd,$tc,$clientes,$proveedores,$etapas,$viewPlanner,$username,$currency){


        $statusRol=self::validateTypeRol($rol);
        if(!$statusRol["status"]){
            return $statusRol;
        }

        $statusDepartamento=self::validateTypeDepartamento($departamento);
        if(!$statusDepartamento["status"]){
            return $statusDepartamento;
        }

        $statusDashboard=self::validateTypeDashboard($typeDashboard);
        if(!$statusDashboard["status"]){
            return $statusDashboard;
        }

        $statusDate=self::validateDateRange($dateStart,$dateEnd);
        if(!$statusDate["status"]){
            return $statusDate;
        }

        $statusTC=self::validateTypeTC($tc);
        if(!$statusTC["status"]){
            return $statusTC;
        }

        $statusCliente=self::validateFilterCliente($clientes);
        if(!$statusCliente["status"]){
            return $statusCliente;
        }

        $statusProveedores=self::validateFilterProveedores($proveedores);
        if(!$statusProveedores["status"]){
            return $statusProveedores;
        }

        $statusEtapas=self::validateFilterEtapas($etapas);
        if(!$statusEtapas["status"]){
            return $statusEtapas;
        }

        $statusListPlanner=self::validateListPlanner($viewPlanner);
        if(!$statusListPlanner["status"]){
            return $statusListPlanner;
        }

        $statusUsername=self::validateUsername($username);
        if(!$statusUsername["status"]){
            return $statusUsername;
        }

        $statusCurrency=self::validateCurrency($currency);
        if(!$statusCurrency["status"]){
            return $statusCurrency;
        }


        return Utils::responseFuntions(true,[],"OK");
    }


    public static function validateCurrency($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'currency' Undefined en seccion 'view'");
        }


        if(!in_array($data,Options::$LIST_FILTER_CURRENCY)){
            return Utils::responseFuntions(false,[],"Parametro 'currency' no encontrado en lista de currency");
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    public static function validateUsername($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'username' Undefined en seccion 'user'");
        }

        return Utils::responseFuntions(true,[],"OK");
    }

    public static function validateTypeTC($tc){

        if(!$tc){
            return Utils::responseFuntions(false,[],"Parametro 'tc' Undefined");
        }

        return Utils::responseFuntions(true,[],"OK");
    }
    public static function validateTypeRol($rol){

        if(!$rol){
            return Utils::responseFuntions(false,[],"Parametro 'rol' Undefined");
        }

        return Utils::responseFuntions(true,[],"OK");
    }

    public static function validateTypeDepartamento($departamento){

        if(!$departamento){
            return Utils::responseFuntions(false,[],"Parametro 'departamento' Undefined");
        }

        if(!in_array($departamento,Options::$LIST_DEPARTAMENTOS)){
            return Utils::responseFuntions(false,[],"Parametro 'departamento' no encontrado en lista de DEPARTAMENTOS");
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    public static function validateFilterCliente($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'clientes' Undefined");
        }

        if(!in_array($data,Options::$LIST_FILTER_CLIENTES)){
            return Utils::responseFuntions(false,[],"Parametro 'clientes' no encontrado en lista de FILTRO CLIENTES");
        }

        return Utils::responseFuntions(true,[],"OK");
    }

    public static function validateFilterProveedores($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'proveedores' Undefined");
        }

        if(!in_array($data,Options::$LIST_FILTER_PROVEEDORES)){
            return Utils::responseFuntions(false,[],"Parametro 'proveedores' no encontrado en lista de FILTRO PROVEEDORES");
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    public static function validateFilterEtapas($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'etapas' Undefined");
        }

        if(!in_array($data,Options::$LIST_FILTER_ETAPAS)){
            return Utils::responseFuntions(false,[],"Parametro 'etapas' no encontrado en lista de FILTRO ETAPAS");
        }

        return Utils::responseFuntions(true,[],"OK");
    }

    public static function validateListPlanner($data){

        if(!$data){
            return Utils::responseFuntions(false,[],"Parametro 'planners' Undefined en seccion 'user'");
        }

        if(!in_array($data,Options::$LIST_FILTER_PLANNERS_VIEW)){
            return Utils::responseFuntions(false,[],"Parametro 'planners' no encontrado en lista de FILTRO planners");
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    /**
     * Valida que un string no este vacio
     * @param string $string: Datos a validar
     * @param string $messega: Mensaje si esta vacio
     */
    public static function validateString($string,$message){

        if(!$string){
            return Utils::responseFuntions(false,[],$message);
        }

        return Utils::responseFuntions(true,[],"OK");
    }


    /**
    * Valida que un array no este vacio
    * @param array $array: Datos a validar
    * @param string $messega: Mensaje si esta vacio
    */
    public static function validateArray($array,$message){

        if(!$array){
            return Utils::responseFuntions(false,[],$message);
        }

        return Utils::responseFuntions(true,[],"OK");
    }


}


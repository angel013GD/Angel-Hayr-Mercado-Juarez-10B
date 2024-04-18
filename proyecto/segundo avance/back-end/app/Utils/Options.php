<?php
namespace App\Utils;


/**
 * Opciones de Dashboard
 */
class Options{

    public static $username="";

    public static $dashboard=[];
    public static $dateStart=[];
    public static $dateEnd=[];
    public static $COMPANYS=[];
    public static $CURRENCYS=[];


    public static $tc=0;
    public static $departamento;
    public static $ROLES_PLANNER=['planner', 'planner plus', 'planner coordinador'];

    public static $clientes;
    public static $proveedores;
    public static $etapas;





    public static $currency="";
    public static $LIST_FILTER_CURRENCY=["PESOS","DOLARES"];


        /**
     * Los Planner que se pueden visualizar
     * [] : Se pueden visaulizar todos
     * [username] : Solo Se vializan los de la lista
     */
    public static $PLANNERS=[];

    public static $LIST_PLANNERS_VIEW=[
        'ALL' => [], // Si esta vacio puede ver todos
        "USER"=>[]
    ];
    public static $LIST_FILTER_PLANNERS_VIEW=[
        'ALL',
        "USER"
    ];




    /**
     * OPCIONES DE FILTRO
     *  */

     /**
     * OPCIONES DEPARTAMENTO
     */
    public static $FILTER_DEPARTAMENTOS = [
        'ALL' => [],
        'BINACIONAL' => ['Departamento' => 'Binacional'],
        'NACIONAL' => ['Departamento' => 'Nacional']
    ];
    public static $LIST_DEPARTAMENTOS=[
        "ALL",
        "BINACIONAL",
        "NACIONAL"
    ];


    /**
    * OPCIONES PARA VER PLANNER SELECTS
    */
    public static $FILTER_PLANNERS = [
        "ALL"=>[],
        "USER"=>[],
        "userTest"=>["daniel.paz","hernan.garcia"]
    ];


    /**
    * OPCIONES DASHBOARD
    */
    public static $FILTER_DASHBOARDS=[
        "BROKER"=>['Planner','!=','ct.truckline'],
        "CARRIER"=>['Planner','=','ct.truckline'],
        "CONCENTRADO"=>[]
    ];
    public static $LIST_DASHBOARDS=["BROKER","CARRIER","CONCENTRADO"];




    /**
    * OPCIONES PLANNERS username
    */
    public static $FILTER_NOT_PLANNER=['paul', 'pedro'];


    /**
    * OPCIONES CLIENTES
    */
    public static $FILTER_CLIENTES = [
        "ALL"=>[],
        "USER_TEST"=>[],
    ];
    public static $LIST_FILTER_CLIENTES=["ALL","USER_TEST"];



    /**
    * OPCIONES PROVEEDORES
    */
    public static $FILTER_PROVEEDORES = [
        "ALL"=>[],
        "USER_TEST"=>[],
    ];
    public static $LIST_FILTER_PROVEEDORES=["ALL","USER_TEST"];



    /**
    * OPCIONES ETAPAS
    */
    public static $FILTER_ETAPAS=[
        "ALL"=>[],
        "USER_TEST"=>["PreVenta"]
    ];

    public static $LIST_FILTER_ETAPAS=["ALL","USER_TEST"];






    public static $LIST_ETAPAS_ODT=[
        "FINALIZADO_SIN_INCIDENCIAS"=>"Finalizado Sin Incidencias",
        "FINALIZADO_CON_INCIDENCIA_RECHAZO_PARCIAL"=>"Finalizado Con Incidencia de Rechazo Parcial",
        "CANCELADO"=>"Cancelado",
        "FINALIZADO_CON_INCIDENCIA_RECHAZO_TOTAL"=>"Finalizado Con Incidencia de Rechazo Total",
        "FINALIZADO_CON_INCIDENCIA_FALTANTE"=>"Finalizado Con Incidencia de Faltante",
        "DESCARGA"=>"Descarga",
        "TRANSITO"=>"Transito",
        "REGRESO"=>"Regresado",
        "ASIGNADO"=>"Asignado",
        "SOLICITADO"=>"Solicitado",
        "PREVENTA"=>"PreVenta",
        "CARGA"=>"Carga",
        "CONFIRMADO"=>"Confirmado",
    ];


}

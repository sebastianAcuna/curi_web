<?php
    require_once '../secure/intercambio.php';

    //     error_reporting(E_ALL);
    // ini_set('display_errors', '1');

   

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

       

        if(in_array($general->getAction(), $general->getArreglo())){
            
            switch ($action) {
                case 'pasoUno':
                    require_once '../../models/data/comprobar_caracteres.php';
                break;

                case 'pasoDos':
                    echo json_encode(array("codigo" => 1, "data" => NULL));
                    
                break;

                case 'pasoTres':
                    /* echo json_encode(array("codigo" => 1, "data" => NULL)); */
                    require_once '../../models/data/procesar_informacion_sap_zionit.php';
                    
                break;

                case 'pasoCuatro':
                    /* echo json_encode(array("codigo" => 1, "data" => NULL)); */
                    require_once '../../models/data/descargar_datos_sap_zionit.php';

                break;

                case 'limpiarDB':
                    require_once '../../models/data/limpiar_db_intercambio.php';
                    $limpiar = new limpiarDB();
                    $resultado = $limpiar->truncate();
                    echo json_encode($resultado);

                break;

                case 'empezarDelete':
                    require_once '../../models/data/limpiar_db_intercambio.php';
                    $limpiar = new limpiarDB();
                    $resultado = $limpiar->truncateProd();
                    echo json_encode($resultado);

                break;

                case 'traerTemporada':
                    require_once '../../models/data/limpiar_db_intercambio.php';
                    $limpiar = new limpiarDB();
                    $resultado = $limpiar->traerTemporada();
                    echo json_encode($resultado);
                break;

            }

        }

    }
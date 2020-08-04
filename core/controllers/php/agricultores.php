<?php
    require_once '../secure/agricultores.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/agricultores.php';

            switch ($action) {
                case 'traerDatos':
                    $agricultores = new Agricultores();
                    $agricultores->set_rut($_REQUEST["FRut"]);
                    $agricultores->set_razon_social($_REQUEST["FRaS"]);
                    $agricultores->set_telefono($_REQUEST["FTel"]);
                    $agricultores->set_email($_REQUEST["FEmail"]);
                    $agricultores->set_desde($_REQUEST["D"]);
                    $agricultores->traerDatos();
                    echo json_encode($agricultores->data());
                break;
    
                case 'totalDatos':
                    $agricultores = new Agricultores();
                    $agricultores->set_rut($_REQUEST["FRut"]);
                    $agricultores->set_razon_social($_REQUEST["FRaS"]);
                    $agricultores->set_telefono($_REQUEST["FTel"]);
                    $agricultores->set_email($_REQUEST["FEmail"]);
                    $agricultores->totalDatos();
                    echo json_encode($agricultores->data());
                break;

                case 'traerInfo':
                    $agricultores = new Agricultores();
                    $agricultores->set_id($_REQUEST["info"]);
                    $agricultores->traerInfo();
                    echo json_encode($agricultores->data());
                break;

            }

        }

    }
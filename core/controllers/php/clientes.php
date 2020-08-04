<?php
    require_once '../secure/clientes.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/clientes.php';

            switch ($action) {
                case 'traerDatos':
                    $clientes = new Clientes();
                    $clientes->set_rut($_REQUEST["FRut"]);
                    $clientes->set_razon_social($_REQUEST["FRaS"]);
                    $clientes->set_telefono($_REQUEST["FTel"]);
                    $clientes->set_email($_REQUEST["FEmail"]);
                    $clientes->set_desde($_REQUEST["D"]);
                    $clientes->traerDatos();
                    echo json_encode($clientes->data());
                break;
    
                case 'totalDatos':
                    $clientes = new Clientes();
                    $clientes->set_rut($_REQUEST["FRut"]);
                    $clientes->set_razon_social($_REQUEST["FRaS"]);
                    $clientes->set_telefono($_REQUEST["FTel"]);
                    $clientes->set_email($_REQUEST["FEmail"]);
                    $clientes->totalDatos();
                    echo json_encode($clientes->data());
                break;

                case 'traerInfo':
                    $clientes = new Clientes();
                    $clientes->set_id($_REQUEST["info"]);
                    $clientes->traerInfo();
                    echo json_encode($clientes->data());
                break;

            }

        }

    }
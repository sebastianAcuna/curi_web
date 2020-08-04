<?php
    require_once '../secure/materiales.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/materiales.php';

            switch ($action) {
                case 'traerDatos':
                    $materiales = new Materiales();
                    $materiales->set_especie($_REQUEST["FEsp"]);
                    $materiales->set_nombreF($_REQUEST["FFant"]);
                    $materiales->set_nombreH($_REQUEST["FHib"]);
                    $materiales->set_hembra($_REQUEST["FHem"]);
                    $materiales->set_hembra($_REQUEST["FMac"]);
                    $materiales->set_desde($_REQUEST["D"]);
                    $materiales->set_orden($_REQUEST["Orden"]);
                    $materiales->traerDatos();
                    echo json_encode($materiales->data());
    
                break;
    
                case 'totalDatos':
                    $materiales = new Materiales();
                    $materiales->set_especie($_REQUEST["FEsp"]);
                    $materiales->set_nombreF($_REQUEST["FFant"]);
                    $materiales->set_nombreH($_REQUEST["FHib"]);
                    $materiales->set_hembra($_REQUEST["FHem"]);
                    $materiales->set_hembra($_REQUEST["FMac"]);
                    $materiales->totalDatos();
                    echo json_encode($materiales->data());
    
                break;

            }

        }

    }
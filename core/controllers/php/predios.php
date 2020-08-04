<?php
    require_once '../secure/predios.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/predios.php';

            switch ($action) {
                case 'traerDatos':
                    $predios = new Predios();
                    $predios->set_agricultor($_REQUEST["campo0"]);
                    $predios->set_region($_REQUEST["campo1"]);
                    $predios->set_comuna($_REQUEST["campo2"]);
                    $predios->set_nombre($_REQUEST["campo3"]);
                    $predios->set_id_tempo($_REQUEST["Temporada"]);
                    $predios->set_desde($_REQUEST["D"]);
                    $predios->set_orden($_REQUEST["Orden"]);
                    $predios->traerDatos();
                    echo json_encode($predios->data());
                break;
    
                case 'totalDatos':
                    $predios = new Predios();
                    $predios->set_agricultor($_REQUEST["campo0"]);
                    $predios->set_region($_REQUEST["campo1"]);
                    $predios->set_comuna($_REQUEST["campo2"]);
                    $predios->set_nombre($_REQUEST["campo3"]);
                    $predios->set_id_tempo($_REQUEST["Temporada"]);
                    $predios->totalDatos();
                    echo json_encode($predios->data());
                break;

                case 'traerInfo':
                    $predios = new Predios();
                    $predios->set_id($_REQUEST["info"]);
                    $predios->traerInfo();
                    echo json_encode($predios->data());
                break;

                case 'crearPredio':
                    $predios = new Predios();
                    $predios->set_id_agric($_REQUEST["campo0"]);
                    $predios->set_id_tempo($_REQUEST["campo1"]);
                    $predios->set_id_region($_REQUEST["campo2"]);
                    $predios->set_id_comuna($_REQUEST["campo3"]);
                    $predios->set_nombre($_REQUEST["campo4"]);
                    echo $predios->crearPredio();
                break;

                case 'editarPredio':
                    $predios = new Predios();
                    $predios->set_id($_REQUEST["act"]);
                    $predios->set_id_agric($_REQUEST["campo0"]);
                    $predios->set_id_tempo($_REQUEST["campo1"]);
                    $predios->set_id_region($_REQUEST["campo2"]);
                    $predios->set_id_comuna($_REQUEST["campo3"]);
                    $predios->set_nombre($_REQUEST["campo4"]);
                    echo $predios->editarPredio();
                break;

                case 'traerRegiones':
                    $predios = new Predios();
                    $predios->traerRegiones();
                    echo json_encode($predios->data());
                break;

                case 'traerComunas':
                    $predios = new Predios();
                    $predios->set_id_region($_REQUEST["Region"]);
                    $predios->traerComunas();
                    echo json_encode($predios->data());
                break;

            }

        }
    
    }
<?php
    require_once '../secure/potreros.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/potreros.php';

            switch ($action) {
                case 'traerDatos':
                    $potreros = new Potreros();
                    $potreros->set_agricultor($_REQUEST["campo0"]);
                    $potreros->set_predio($_REQUEST["campo1"]);
                    $potreros->set_region($_REQUEST["campo2"]);
                    $potreros->set_comuna($_REQUEST["campo3"]);
                    $potreros->set_nombre($_REQUEST["campo4"]);
                    $potreros->set_id_tempo($_REQUEST["Temporada"]);
                    $potreros->set_desde($_REQUEST["D"]);
                    $potreros->set_orden($_REQUEST["Orden"]);
                    $potreros->traerDatos();
                    echo json_encode($potreros->data());
                break;
    
                case 'totalDatos':
                    $potreros = new Potreros();
                    $potreros->set_agricultor($_REQUEST["campo0"]);
                    $potreros->set_predio($_REQUEST["campo1"]);
                    $potreros->set_region($_REQUEST["campo2"]);
                    $potreros->set_comuna($_REQUEST["campo3"]);
                    $potreros->set_nombre($_REQUEST["campo4"]);
                    $potreros->set_id_tempo($_REQUEST["Temporada"]);
                    $potreros->totalDatos();
                    echo json_encode($potreros->data());
                break;

                case 'traerInfo':
                    $potreros = new Potreros();
                    $potreros->set_id($_REQUEST["info"]);
                    $potreros->traerInfo();
                    echo json_encode($potreros->data());
                break;

                case 'crearPotrero':
                    $potreros = new Potreros();
                    $potreros->set_id_predio($_REQUEST["campo2"]);
                    $potreros->set_nombre($_REQUEST["campo3"]);
                    $potreros->set_nombre_ac($_REQUEST["campo4"]);
                    $potreros->set_telefono_ac($_REQUEST["campo5"]);
                    echo $potreros->crearPotrero();
                break;

                case 'editarPotrero':
                    $potreros = new Potreros();
                    $potreros->set_id($_REQUEST["act"]);
                    $potreros->set_id_predio($_REQUEST["campo2"]);
                    $potreros->set_nombre($_REQUEST["campo3"]);
                    $potreros->set_nombre_ac($_REQUEST["campo4"]);
                    $potreros->set_telefono_ac($_REQUEST["campo5"]);
                    echo $potreros->editarPotrero();
                break;

                case 'traerPredios':
                    $potreros = new Potreros();
                    $potreros->set_id_agric($_REQUEST["Agric"]);
                    $potreros->set_id_tempo($_REQUEST["Tempo"]);
                    $potreros->traerPredios();
                    echo json_encode($potreros->data());
                break;

            }

        }
    
    }
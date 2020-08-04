<?php
    require_once '../secure/stock.php';

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/stock.php';

            switch ($action) {
                case 'traerDatos':

                    $cate = new Categoria();

                    $cate->set_id_esp($_REQUEST["campo0"]);
                    $cate->set_fecha_recepcion($_REQUEST["campo1"]);
                    $cate->set_id_cli($_REQUEST["campo2"]);
                    $cate->set_id_materiales($_REQUEST["campo3"]);

                    $cate->set_genetic($_REQUEST["campo4"]);
                    $cate->set_trait($_REQUEST["campo5"]);
                    $cate->set_sag_resolution_number($_REQUEST["campo6"]);
                    $cate->set_curimapu_batch_number($_REQUEST["campo7"]);
                    $cate->set_curstomer_batch($_REQUEST["campo8"]);
                    $cate->set_quantity_kg($_REQUEST["campo9"]);
                    $cate->set_notes($_REQUEST["campo10"]);
                    $cate->set_seed_treated_by($_REQUEST["campo11"]);
                    $cate->set_curimapu_treated_by($_REQUEST["campo12"]);
                    $cate->set_customer_tsw($_REQUEST["campo13"]);
                    $cate->set_customer_gem_porcentaje($_REQUEST["campo14"]);
                    $cate->set_tsw($_REQUEST["campo15"]);
                    $cate->set_curimapu_germ_porcentaje($_REQUEST["campo16"]);

                    $cate->set_temporada($_REQUEST["Temporada"]);


                    $cate->set_desde($_REQUEST["D"]);
                    $cate->set_orden($_REQUEST["Orden"]);

                    $cate->traerDatos();
                    echo json_encode($cate->data());
                break;

                case 'totalDatos':
                    $cate = new Categoria();

                    $cate->set_id_esp($_REQUEST["campo0"]);
                    $cate->set_fecha_recepcion($_REQUEST["campo1"]);
                    $cate->set_id_cli($_REQUEST["campo2"]);
                    $cate->set_id_materiales($_REQUEST["campo3"]);

                    $cate->set_genetic($_REQUEST["campo4"]);
                    $cate->set_trait($_REQUEST["campo5"]);
                    $cate->set_sag_resolution_number($_REQUEST["campo6"]);
                    $cate->set_curimapu_batch_number($_REQUEST["campo7"]);
                    $cate->set_curstomer_batch($_REQUEST["campo8"]);
                    $cate->set_quantity_kg($_REQUEST["campo9"]);
                    $cate->set_notes($_REQUEST["campo10"]);
                    $cate->set_seed_treated_by($_REQUEST["campo11"]);
                    $cate->set_curimapu_treated_by($_REQUEST["campo12"]);
                    $cate->set_customer_tsw($_REQUEST["campo13"]);
                    $cate->set_customer_gem_porcentaje($_REQUEST["campo14"]);
                    $cate->set_tsw($_REQUEST["campo15"]);
                    $cate->set_curimapu_germ_porcentaje($_REQUEST["campo16"]);

                    $cate->set_temporada($_REQUEST["Temporada"]);


                    $cate->totalDatos();
                    echo json_encode($cate->data());
                break;

            }

        }

    }
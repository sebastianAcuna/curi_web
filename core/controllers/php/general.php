<?php
    require_once '../secure/general.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/general.php';

            switch ($action) {
                case 'traerInfoPerfil':
                    $general = new General();
                    $general->set_id($_REQUEST["info"]);
                    $general->traerInfo();
                    echo json_encode($general->data());
                break;

                case 'ediPerfil':
                    $general = new General();
                    $general->set_id($_REQUEST["act"]);

                    if($_REQUEST["campo2"] != "-"){
                        $general->set_password($_REQUEST["campo2"]);

                    }else{
                        $general->set_password("");

                    }

                    $general->set_telefono($_REQUEST["campo8"]);
                    $general->set_pais($_REQUEST["campo9"]);
                    $general->set_region($_REQUEST["campo10"]);
                    $general->set_provincia($_REQUEST["campo11"]);
                    $general->set_comuna($_REQUEST["campo12"]);
                    $general->set_direccion($_REQUEST["campo13"]);
                    echo $general->ediPerfil();

                break;

                case 'traerRegiones':
                    $general = new General();
                    $general->set_id($_REQUEST["Pais"]);
                    $general->traerRegiones();
                    echo json_encode($general->data());
                break;

                case 'traerProvincias':
                    $general = new General();
                    $general->set_id($_REQUEST["Region"]);
                    $general->traerProvincias();
                    echo json_encode($general->data());
                break;

                case 'traerComunas':
                    $general = new General();
                    $general->set_id($_REQUEST["Provincia"]);
                    $general->traerComunas();
                    echo json_encode($general->data());
                break;

            }

        }

    }
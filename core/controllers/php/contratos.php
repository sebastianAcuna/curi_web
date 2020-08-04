<?php
    require_once '../secure/contratos.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/contratos.php';

            switch ($action) {
                case 'traerDatos':
                    $contratos = new Contratos();
                    $contratos->set_ficha($_REQUEST["campo0"]);
                    $contratos->set_numeroC($_REQUEST["campo1"]);
                    $contratos->set_numeroA($_REQUEST["campo2"]);
                    $contratos->set_cliente ($_REQUEST["campo3"]);
                    $contratos->set_agricultor($_REQUEST["campo4"]);
                    $contratos->set_especie($_REQUEST["campo5"]);
                    $contratos->set_variedad($_REQUEST["campo6"]);
                    $contratos->set_base($_REQUEST["campo7"]);
                    $contratos->set_precio($_REQUEST["campo8"]);
                    $contratos->set_humedad($_REQUEST["campo9"]);
                    $contratos->set_germinacion($_REQUEST["campo10"]);
                    $contratos->set_purezaG($_REQUEST["campo11"]);
                    $contratos->set_purezaF($_REQUEST["campo12"]);
                    $contratos->set_enfermedades($_REQUEST["campo13"]);
                    $contratos->set_malezas($_REQUEST["campo14"]);
                    $contratos->set_desde($_REQUEST["D"]);
                    $contratos->set_orden($_REQUEST["Orden"]);
                    $contratos->set_temporada($_REQUEST["Temporada"]);
                    $contratos->traerDatos();
                    echo json_encode($contratos->data());
                break;

                case 'totalDatos':
                    $contratos = new Contratos();
                    $contratos->set_ficha($_REQUEST["campo0"]);
                    $contratos->set_numeroC($_REQUEST["campo1"]);
                    $contratos->set_numeroA($_REQUEST["campo2"]);
                    $contratos->set_cliente ($_REQUEST["campo3"]);
                    $contratos->set_agricultor($_REQUEST["campo4"]);
                    $contratos->set_especie($_REQUEST["campo5"]);
                    $contratos->set_variedad($_REQUEST["campo6"]);
                    $contratos->set_base($_REQUEST["campo7"]);
                    $contratos->set_precio($_REQUEST["campo8"]);
                    $contratos->set_humedad($_REQUEST["campo9"]);
                    $contratos->set_germinacion($_REQUEST["campo10"]);
                    $contratos->set_purezaG($_REQUEST["campo11"]);
                    $contratos->set_purezaF($_REQUEST["campo12"]);
                    $contratos->set_enfermedades($_REQUEST["campo13"]);
                    $contratos->set_malezas($_REQUEST["campo14"]);
                    $contratos->set_temporada($_REQUEST["Temporada"]);
                    $contratos->totalDatos();
                    echo json_encode($contratos->data());
                break;

            }

        }

    }
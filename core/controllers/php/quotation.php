<?php
    require_once '../secure/quotation.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/quotation.php';

            switch ($action) {
                case 'traerDatos':
                    $quotation = new Quotation();
                    $quotation->set_cliente($_REQUEST["campo0"]);
                    $quotation->set_quotations($_REQUEST["campo1"]);
                    $quotation->set_detalles($_REQUEST["campo2"]);
                    $quotation->set_especies($_REQUEST["campo3"]);
                    $quotation->set_materiales($_REQUEST["campo4"]);
                    $quotation->set_agricultores($_REQUEST["campo5"]);
                    $quotation->set_supervisores($_REQUEST["campo6"]);
                    $quotation->set_desde($_REQUEST["D"]);
                    $quotation->set_orden($_REQUEST["Orden"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->traerDatos();
                    echo json_encode($quotation->data());
    
                break;
    
                case 'totalDatos':
                    $quotation = new Quotation();
                    $quotation->set_cliente($_REQUEST["campo0"]);
                    $quotation->set_quotations($_REQUEST["campo1"]);
                    $quotation->set_detalles($_REQUEST["campo2"]);
                    $quotation->set_especies($_REQUEST["campo3"]);
                    $quotation->set_materiales($_REQUEST["campo4"]);
                    $quotation->set_agricultores($_REQUEST["campo5"]);
                    $quotation->set_supervisores($_REQUEST["campo6"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->totalDatos();
                    echo json_encode($quotation->data());
    
                break;

                case 'traerInfo':
                    $quotation = new Quotation();
                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->traerInfo();
                    echo json_encode($quotation->data());
                break;

                case 'traerInfoPdf':
                    $quotation = new Quotation();
                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->traerInfoPdf();
                    $datos = $quotation->data();

                    $quotation->set_id($datos["data"][0]["id_esp"]);
                    $quotation->traerCheckPdf();
                    $checks = $quotation->data();

                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->ultimaEtapa();
                    $etapa = $quotation->data();

                    echo json_encode(array($datos,$checks,$etapa));
                break;

                case 'traerInfoAnexosPdf':
                    $quotation = new Quotation();
                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->traerInfoAnexosPdf();
                    $datos = $quotation->data();

                    $quotation->traerCheckAnexosPdf();
                    $checks = $quotation->data();

                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->ultimaEtapa();
                    $etapa = $quotation->data();

                    echo json_encode(array($datos,$checks,$etapa));
                break;

            }

        }

    }
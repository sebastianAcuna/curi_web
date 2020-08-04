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
                    $quotation->set_numero($_REQUEST["FNum"]);
                    $quotation->set_cliente($_REQUEST["FCli"]);
                    $quotation->set_especie($_REQUEST["FEsp"]);
                    $quotation->set_observacion($_REQUEST["FObs"]);
                    $quotation->set_haC($_REQUEST["FHAC"]);
                    $quotation->set_mt2C($_REQUEST["FMT2C"]);
                    $quotation->set_siteC($_REQUEST["FSitC"]);
                    $quotation->set_usdC($_REQUEST["FUSDC"]);
                    $quotation->set_euroC($_REQUEST["FEUROC"]);
                    $quotation->set_clpC($_REQUEST["FCLPC"]);
                    $quotation->set_kgC($_REQUEST["FKGC"]);
                    $quotation->set_desde($_REQUEST["D"]);
                    $quotation->set_orden($_REQUEST["Orden"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->traerDatos();
                    echo json_encode($quotation->data());
    
                break;
    
                case 'totalDatos':
                    $quotation = new Quotation();
                    $quotation->set_numero($_REQUEST["FNum"]);
                    $quotation->set_cliente($_REQUEST["FCli"]);
                    $quotation->set_especie($_REQUEST["FEsp"]);
                    $quotation->set_observacion($_REQUEST["FObs"]);
                    $quotation->set_haC($_REQUEST["FHAC"]);
                    $quotation->set_mt2C($_REQUEST["FMT2C"]);
                    $quotation->set_siteC($_REQUEST["FSitC"]);
                    $quotation->set_usdC($_REQUEST["FUSDC"]);
                    $quotation->set_euroC($_REQUEST["FEUROC"]);
                    $quotation->set_clpC($_REQUEST["FCLPC"]);
                    $quotation->set_kgC($_REQUEST["FKGC"]);
                    $quotation->set_temporada($_REQUEST["Temporada"]);
                    $quotation->totalDatos();
                    echo json_encode($quotation->data());
    
                break;

                case 'traerInfo':
                    $quotation = new Quotation();
                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->traerInfo();
                    echo json_encode($quotation->data());
                break;

                case 'traerInfoPdf':
                    $quotation = new Quotation();
                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->traerInfoPdf();
                    $datos = $quotation->data();

                    $quotation->set_id($datos[0]["id_esp"]);
                    $quotation->traerCheckPdf();
                    $checks = $quotation->data();

                    $quotation->set_id($_REQUEST["info"]);
                    $quotation->ultimaEtapa();
                    $etapa = $quotation->data();

                    echo json_encode(array($datos,$checks,$etapa));
                break;

            }

        }

    }
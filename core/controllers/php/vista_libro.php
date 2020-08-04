<?php
    require_once '../secure/vista_libro.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/vista_libro.php';

            switch ($action) {
                case 'traerDatos':
                    $vista = new Vista();
                    $vista->set_razon($_REQUEST["FNom"]);
                    $vista->set_rut($_REQUEST["FRut"]);
                    $vista->set_desde($_REQUEST["D"]);
                    $vista->set_orden($_REQUEST["Orden"]);
                    $vista->traerDatos();
                    echo json_encode($vista->data());
                break;

                case 'totalDatos':
                    $vista = new Vista();
                    $vista->set_razon($_REQUEST["FNom"]);
                    $vista->set_rut($_REQUEST["FRut"]);
                    $vista->totalDatos();
                    echo json_encode($vista->data());
                break;

                case 'traerInfo':
                    $vista = new Vista();
                    $vista->set_plataforma($_REQUEST["plataforma"]);
                    $vista->set_etapa($_REQUEST["etapa"]);
                    $vista->set_especie($_REQUEST["especie"]);
                    $vista->set_id($_REQUEST["cliente"]);
                    $vista->traerInfo();
                    echo json_encode($vista->data());
                break;

                case 'desbloquearVista':
                    $vista = new Vista();
                    echo $vista->desbloquearVista();
                break;

                case 'traerEspecies':
                    $vista = new Vista();
                    $vista->set_id($_REQUEST["eleccion"]);
                    $vista->traerEspecies();
                    echo json_encode($vista->data());
                break;

                case 'traerEtapas':
                    $vista = new Vista();
                    $vista->traerEtapas();
                    echo json_encode($vista->data());
                break;

                case 'eventoCheck':
                    $vista = new Vista();
                    $vista->set_id($_REQUEST["cliente"]);
                    $vista->set_check($_REQUEST["check"]);
                    $vista->set_cambio($_REQUEST["cambio"]);
                    $vista->set_plataforma($_REQUEST["plataforma"]);
                    echo $vista->eventoCheck();
                break;

                case 'marcarChecks':
                    $vista = new Vista();
                    $vista->set_id($_REQUEST["cliente"]);
                    $vista->set_etapa($_REQUEST["etapa"]);
                    $vista->set_especie($_REQUEST["especie"]);
                    $vista->set_cambio($_REQUEST["cambio"]);
                    $vista->set_plataforma($_REQUEST["plataforma"]);
                    echo $vista->marcarChecks();
                break;

            }

        }

    }
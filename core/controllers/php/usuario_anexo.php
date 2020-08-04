<?php
    require_once '../secure/usuario_anexo.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/usuario_anexo.php';

            switch ($action) {
                case 'traerDatos':
                    $asignaciones = new Asignaciones();
                    $asignaciones->set_user($_REQUEST["FUser"]);
                    $asignaciones->set_rut($_REQUEST["FRut"]);
                    $asignaciones->set_nombre($_REQUEST["FNom"]);
                    $asignaciones->set_desde($_REQUEST["D"]);
                    $asignaciones->set_orden($_REQUEST["Orden"]);
                    $asignaciones->traerDatos();
                    echo json_encode($asignaciones->data());
                break;
    
                case 'totalDatos':
                    $asignaciones = new Asignaciones();
                    $asignaciones->set_user($_REQUEST["FUser"]);
                    $asignaciones->set_rut($_REQUEST["FRut"]);
                    $asignaciones->set_nombre($_REQUEST["FNom"]);
                    $asignaciones->totalDatos();
                    echo json_encode($asignaciones->data());
                break;

                case 'traerInfo':
                    $asignaciones = new Asignaciones();
                    $asignaciones->set_id($_REQUEST["info"]);
                    $asignaciones->traerInfo();
                    echo json_encode($asignaciones->data());
                break;

                case 'crearAsignacion':
                    $asignaciones = new Asignaciones();
                    $asignaciones->set_id_usuario($_REQUEST["campo0"]);
                    $asignaciones->set_id_ac($_REQUEST["campo1"]);
                    echo $asignaciones->crearAsignacion();
                break;

                case 'eliminarAsignacion':
                    $asignaciones = new Asignaciones();
                    $asignaciones->set_id($_REQUEST["eliminar"]);
                    echo $asignaciones->eliminarAsignacion();
                break;

            }

        }
    
    }
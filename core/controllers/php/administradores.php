<?php
    require_once '../secure/administradores.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/administradores.php';

            switch ($action) {
                case 'traerDatos':
                    $administradores = new Administradores();
                    $administradores->set_user($_REQUEST["campo0"]);
                    $administradores->set_rut($_REQUEST["campo1"]);
                    $administradores->set_nombre($_REQUEST["campo2"]);
                    $administradores->set_email($_REQUEST["campo3"]);
                    $administradores->set_desde($_REQUEST["D"]);
                    $administradores->set_orden($_REQUEST["Orden"]);
                    $administradores->traerDatos();
                    echo json_encode($administradores->data());
                break;
    
                case 'totalDatos':
                    $administradores = new Administradores();
                    $administradores->set_user($_REQUEST["campo0"]);
                    $administradores->set_rut($_REQUEST["campo1"]);
                    $administradores->set_nombre($_REQUEST["campo2"]);
                    $administradores->set_email($_REQUEST["campo3"]);
                    $administradores->totalDatos();
                    echo json_encode($administradores->data());
                break;

                case 'traerInfo':
                    $administradores = new Administradores();
                    $administradores->set_id($_REQUEST["info"]);
                    $administradores->traerInfo();
                    echo json_encode($administradores->data());
                break;

                case 'crearAdministrador':
                    $administradores = new Administradores();
                    $administradores->set_email($_REQUEST["campo0"]);
                    $administradores->set_user($_REQUEST["campo1"]);
                    $administradores->set_password($_REQUEST["campo2"]);
                    $administradores->set_rut($_REQUEST["campo4"]);
                    $administradores->set_nombre($_REQUEST["campo5"]);
                    $administradores->set_apellido_p($_REQUEST["campo6"]);
                    $administradores->set_apellido_m($_REQUEST["campo7"]);
                    $administradores->set_telefono($_REQUEST["campo8"]);
                    $administradores->set_pais($_REQUEST["campo9"]);
                    $administradores->set_region($_REQUEST["campo10"]);
                    $administradores->set_provincia($_REQUEST["campo11"]);
                    $administradores->set_comuna($_REQUEST["campo12"]);
                    $administradores->set_direccion($_REQUEST["campo13"]);
                    echo $administradores->crearAdministrador();
                break;

                case 'editarAdministrador':
                    $administradores = new Administradores();
                    $administradores->set_id($_REQUEST["act"]);
                    $administradores->set_email($_REQUEST["campo0"]);
                    $administradores->set_user($_REQUEST["campo1"]);

                    if(($_SESSION["mod_pass_curimapu"] == 1 || $_REQUEST["act"] == $_SESSION["IDuser_curimapu"]) && $_REQUEST["campo2"] != "-"){
                        $administradores->set_password($_REQUEST["campo2"]);
                        
                    }else{
                        $administradores->set_password("");

                    }

                    $administradores->set_rut($_REQUEST["campo4"]);
                    $administradores->set_nombre($_REQUEST["campo5"]);
                    $administradores->set_apellido_p($_REQUEST["campo6"]);
                    $administradores->set_apellido_m($_REQUEST["campo7"]);
                    $administradores->set_telefono($_REQUEST["campo8"]);
                    $administradores->set_pais($_REQUEST["campo9"]);
                    $administradores->set_region($_REQUEST["campo10"]);
                    $administradores->set_provincia($_REQUEST["campo11"]);
                    $administradores->set_comuna($_REQUEST["campo12"]);
                    $administradores->set_direccion($_REQUEST["campo13"]);
                    echo $administradores->editarAdministrador();
                break;

                case 'traerComunas':
                    $administradores = new Administradores();
                    $administradores->set_id($_REQUEST["Provincia"]);
                    $administradores->traerComunas();
                    echo json_encode($administradores->data());
                break;


                case 'traerProvincias':
                    $administradores = new Administradores();
                    $administradores->set_id($_REQUEST["Region"]);
                    $administradores->traerProvincias();
                    echo json_encode($administradores->data());
                break;

                case 'traerRegiones':
                    $administradores = new Administradores();
                    $administradores->set_id($_REQUEST["Pais"]);
                    $administradores->traerRegiones();
                    echo json_encode($administradores->data());
                break;

            }

        }
    
    }
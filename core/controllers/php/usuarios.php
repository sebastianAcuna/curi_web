<?php
    require_once '../secure/usuarios.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/usuarios.php';

            switch ($action) {
                case 'traerDatos':
                    $usuarios = new Usuarios();
                    $usuarios->set_user($_REQUEST["FUser"]);
                    $usuarios->set_rut($_REQUEST["FRut"]);
                    $usuarios->set_nombre($_REQUEST["FNom"]);
                    $usuarios->set_email($_REQUEST["FEmail"]);
                    $usuarios->set_eleccion($_REQUEST["FTipo"]);
                    $usuarios->set_desde($_REQUEST["D"]);
                    $usuarios->set_orden($_REQUEST["Orden"]);
                    $usuarios->traerDatos();
                    echo json_encode($usuarios->data());
                break;

                case 'totalDatos':
                    $usuarios = new Usuarios();
                    $usuarios->set_user($_REQUEST["FUser"]);
                    $usuarios->set_rut($_REQUEST["FRut"]);
                    $usuarios->set_nombre($_REQUEST["FNom"]);
                    $usuarios->set_email($_REQUEST["FEmail"]);
                    $usuarios->set_eleccion($_REQUEST["FTipo"]);
                    $usuarios->totalDatos();
                    echo json_encode($usuarios->data());
                break;

                case 'traerInfo':
                    $usuarios = new Usuarios();
                    $usuarios->set_id($_REQUEST["info"]);
                    $usuarios->traerInfo();
                    echo json_encode($usuarios->data());
                break;

                case 'traerDestinatarios':
                    $usuarios = new Usuarios();
                    $usuarios->set_eleccion($_REQUEST["eleccion"]);
                    $usuarios->traerDestinatarios();
                    echo json_encode($usuarios->data());
                break;

                case 'crearUsuario':
                    $usuarios = new Usuarios();
                    $usuarios->set_email($_REQUEST["campo0"]);
                    $usuarios->set_user($_REQUEST["campo1"]);
                    $usuarios->set_password($_REQUEST["campo2"]);
                    $usuarios->set_eleccion($_REQUEST["campo4"]);
                    $usuarios->set_enlazado($_REQUEST["campo5"]);
                    $usuarios->set_rut($_REQUEST["campo6"]);
                    $usuarios->set_nombre($_REQUEST["campo7"]);
                    $usuarios->set_apellido_p($_REQUEST["campo8"]);
                    $usuarios->set_apellido_m($_REQUEST["campo9"]);
                    $usuarios->set_telefono($_REQUEST["campo10"]);
                    $usuarios->set_pais($_REQUEST["campo11"]);
                    $usuarios->set_ciudad($_REQUEST["campo12"]);
                    $usuarios->set_direccion($_REQUEST["campo13"]);
                    echo $usuarios->crearUsuario();
                break;

                case 'editarUsuario':
                    $usuarios = new Usuarios();
                    $usuarios->set_id($_REQUEST["act"]);
                    $usuarios->set_email($_REQUEST["campo0"]);
                    $usuarios->set_user($_REQUEST["campo1"]);

                    if($_REQUEST["campo2"] != "-" && $_SESSION["mod_pass_curimapu"] == 1){
                        $usuarios->set_password($_REQUEST["campo2"]);

                    }else{
                        $usuarios->set_password("");

                    }

                    $usuarios->set_eleccion($_REQUEST["campo4"]);
                    $usuarios->set_enlazado($_REQUEST["campo5"]);
                    $usuarios->set_rut($_REQUEST["campo6"]);
                    $usuarios->set_nombre($_REQUEST["campo7"]);
                    $usuarios->set_apellido_p($_REQUEST["campo8"]);
                    $usuarios->set_apellido_m($_REQUEST["campo9"]);
                    $usuarios->set_telefono($_REQUEST["campo10"]);
                    $usuarios->set_pais($_REQUEST["campo11"]);
                    $usuarios->set_ciudad($_REQUEST["campo12"]);
                    $usuarios->set_direccion($_REQUEST["campo13"]);
                    echo $usuarios->editarUsuario();
                break;

            }

        }

    }
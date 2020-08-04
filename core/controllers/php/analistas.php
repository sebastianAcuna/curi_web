<?php
    require_once '../secure/analistas.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/analistas.php';

            switch ($action) {
                case 'traerDatos':
                    $analistas = new Analistas();
                    $analistas->set_user($_REQUEST["FUser"]);
                    $analistas->set_rut($_REQUEST["FRut"]);
                    $analistas->set_nombre($_REQUEST["FNom"]);
                    $analistas->set_email($_REQUEST["FEmail"]);
                    $analistas->set_desde($_REQUEST["D"]);
                    $analistas->set_orden($_REQUEST["Orden"]);
                    $analistas->traerDatos();
                    echo json_encode($analistas->data());
    
                break;
    
                case 'totalDatos':
                    $analistas = new Analistas();
                    $analistas->set_user($_REQUEST["FUser"]);
                    $analistas->set_rut($_REQUEST["FRut"]);
                    $analistas->set_nombre($_REQUEST["FNom"]);
                    $analistas->set_email($_REQUEST["FEmail"]);
                    $analistas->totalDatos();
                    echo json_encode($analistas->data());
    
                break;

                case 'traerInfo':
                    $analistas = new Analistas();
                    $analistas->set_id($_REQUEST["info"]);
                    $analistas->traerInfo();
                    echo json_encode($analistas->data());
                break;

                case 'crearAnalista':
                    $analistas = new Analistas();
                    $analistas->set_email($_REQUEST["campo0"]);
                    $analistas->set_user($_REQUEST["campo1"]);
                    $analistas->set_password($_REQUEST["campo2"]);
                    $analistas->set_rut($_REQUEST["campo4"]);
                    $analistas->set_nombre($_REQUEST["campo5"]);
                    $analistas->set_apellido_p($_REQUEST["campo6"]);
                    $analistas->set_apellido_m($_REQUEST["campo7"]);
                    $analistas->set_telefono($_REQUEST["campo8"]);
                    $analistas->set_pais($_REQUEST["campo9"]);
                    $analistas->set_region($_REQUEST["campo10"]);
                    $analistas->set_provincia($_REQUEST["campo11"]);
                    $analistas->set_comuna($_REQUEST["campo12"]);
                    $analistas->set_direccion($_REQUEST["campo13"]);
                    echo $analistas->crearAnalista();

                break;

                case 'editarAnalista':
                    $analistas = new Analistas();
                    $analistas->set_id($_REQUEST["act"]);
                    $analistas->set_email($_REQUEST["campo0"]);
                    $analistas->set_user($_REQUEST["campo1"]);

                    if($_REQUEST["campo2"] != "-" && $_SESSION["mod_pass_curimapu"] == 1){
                        $analistas->set_password($_REQUEST["campo2"]);

                    }else{
                        $analistas->set_password("");

                    }

                    $analistas->set_rut($_REQUEST["campo4"]);
                    $analistas->set_nombre($_REQUEST["campo5"]);
                    $analistas->set_apellido_p($_REQUEST["campo6"]);
                    $analistas->set_apellido_m($_REQUEST["campo7"]);
                    $analistas->set_telefono($_REQUEST["campo8"]);
                    $analistas->set_pais($_REQUEST["campo9"]);
                    $analistas->set_region($_REQUEST["campo10"]);
                    $analistas->set_provincia($_REQUEST["campo11"]);
                    $analistas->set_comuna($_REQUEST["campo12"]);
                    $analistas->set_direccion($_REQUEST["campo13"]);
                    echo $analistas->editarAnalista();

                break;

                case 'traerComunas':
                    $analistas = new Analistas();
                    $analistas->set_idSTR($_REQUEST["Provincia"]);
                    $analistas->traerComunas();
                    echo json_encode($analistas->data());
                break;

                case 'traerProvincias':
                    $analistas = new Analistas();
                    $analistas->set_idSTR($_REQUEST["Region"]);
                    $analistas->traerProvincias();
                    echo json_encode($analistas->data());
                break;

                case 'traerRegiones':
                    $analistas = new Analistas();
                    $analistas->set_idSTR($_REQUEST["Pais"]);
                    $analistas->traerRegiones();
                    echo json_encode($analistas->data());
                break;

            }

        }
    
    }
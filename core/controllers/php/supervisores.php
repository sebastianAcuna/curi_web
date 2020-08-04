<?php
    require_once '../secure/supervisores.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/supervisores.php';

            switch ($action) {
                case 'traerDatos':
                    $supervisores = new Supervisores();
                    $supervisores->set_rut($_REQUEST["FRut"]);
                    $supervisores->set_nombre($_REQUEST["FNom"]);
                    $supervisores->set_telefono($_REQUEST["FTel"]);
                    $supervisores->set_email($_REQUEST["FEmail"]);
                    $supervisores->set_desde($_REQUEST["D"]);
                    $supervisores->set_orden($_REQUEST["Orden"]);
                    $supervisores->traerDatos();
                    echo json_encode($supervisores->data());
    
                break;
    
                case 'totalDatos':
                    $supervisores = new Supervisores();
                    $supervisores->set_rut($_REQUEST["FRut"]);
                    $supervisores->set_nombre($_REQUEST["FNom"]);
                    $supervisores->set_telefono($_REQUEST["FTel"]);
                    $supervisores->set_email($_REQUEST["FEmail"]);
                    $supervisores->totalDatos();
                    echo json_encode($supervisores->data());
    
                break;

                case 'traerInfo':
                    $supervisores = new Supervisores();
                    $supervisores->set_id($_REQUEST["info"]);
                    $supervisores->traerInfo();
                    $info = $supervisores->data();
                    $supervisores->traerSupervisados();
                    echo json_encode(array($info,$supervisores->data()));
                break;

                case 'crearSupervisor':
                    $supervisores = new Supervisores();
                    $supervisores->set_email($_REQUEST["campo0"]);
                    $supervisores->set_user($_REQUEST["campo1"]);
                    $supervisores->set_password($_REQUEST["campo2"]);
                    $supervisores->set_rut($_REQUEST["campo4"]);
                    $supervisores->set_nombre($_REQUEST["campo5"]);
                    $supervisores->set_apellido_p($_REQUEST["campo6"]);
                    $supervisores->set_apellido_m($_REQUEST["campo7"]);
                    $supervisores->set_telefono($_REQUEST["campo8"]);
                    $supervisores->set_pais($_REQUEST["campo9"]);
                    $supervisores->set_region($_REQUEST["campo10"]);
                    $supervisores->set_provincia($_REQUEST["campo11"]);
                    $supervisores->set_comuna($_REQUEST["campo12"]);
                    $supervisores->set_direccion($_REQUEST["campo13"]);
                    $supervisores->set_supervisar($_REQUEST["campoS"]);
                    $supervisores->set_supervisados($_REQUEST["campoSup"]);
                    echo $supervisores->crearSupervisor();

                break;

                case 'editarSupervisor':
                    $supervisores = new Supervisores();
                    $supervisores->set_id($_REQUEST["act"]);
                    $supervisores->set_email($_REQUEST["campo0"]);
                    $supervisores->set_user($_REQUEST["campo1"]);

                    if($_REQUEST["campo2"] != "-" && $_SESSION["mod_pass_curimapu"] == 1){
                        $supervisores->set_password($_REQUEST["campo2"]);

                    }else{
                        $supervisores->set_password("");

                    }

                    $supervisores->set_rut($_REQUEST["campo4"]);
                    $supervisores->set_nombre($_REQUEST["campo5"]);
                    $supervisores->set_apellido_p($_REQUEST["campo6"]);
                    $supervisores->set_apellido_m($_REQUEST["campo7"]);
                    $supervisores->set_telefono($_REQUEST["campo8"]);
                    $supervisores->set_pais($_REQUEST["campo9"]);
                    $supervisores->set_region($_REQUEST["campo10"]);
                    $supervisores->set_provincia($_REQUEST["campo11"]);
                    $supervisores->set_comuna($_REQUEST["campo12"]);
                    $supervisores->set_direccion($_REQUEST["campo13"]);
                    $supervisores->set_supervisar($_REQUEST["campoS"]);
                    $supervisores->set_supervisados($_REQUEST["campoSup"]);
                    echo $supervisores->editarSupervisor();

                break;

                case 'traerSupervisores':
                    $supervisores = new Supervisores();
                    $supervisores->set_id($_REQUEST["Sup"]);
                    $supervisores->traerSupervisores();
                    echo json_encode($supervisores->data());
                break;

                case 'traerProvincias':
                    $supervisores = new Supervisores();
                    $supervisores->set_idSTR($_REQUEST["Region"]);
                    $supervisores->traerProvincias();
                    echo json_encode($supervisores->data());
                break;

                case 'traerComunas':
                    $supervisores = new Supervisores();
                    $supervisores->set_idSTR($_REQUEST["Provincia"]);
                    $supervisores->traerComunas();
                    echo json_encode($supervisores->data());
                break;

                case 'traerRegiones':
                    $supervisores = new Supervisores();
                    $supervisores->set_idSTR($_REQUEST["Pais"]);
                    $supervisores->traerRegiones();
                    echo json_encode($supervisores->data());
                break;

            }

        }

    }
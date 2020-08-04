<?php
    require_once '../secure/fichas.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        // echo "print 1";

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/fichas.php';

            // echo "print 2";

            switch ($action) {

                /* Activas */

                case 'traerDatosActivas': 
                    $fichas = new Fichas();
                    $fichas->set_fieldbook($_REQUEST["campo0"]);
                    $fichas->set_fieldman($_REQUEST["campo1"]);
                    $fichas->set_especie($_REQUEST["campo2"]);
                    $fichas->set_agricultor($_REQUEST["campo3"]);
                    $fichas->set_rut($_REQUEST["campo4"]);
                    $fichas->set_telefono($_REQUEST["campo5"]);
                    $fichas->set_administrador($_REQUEST["campo6"]);
                    $fichas->set_telefonoA($_REQUEST["campo7"]);
                    $fichas->set_oferta($_REQUEST["campo8"]);
                    $fichas->set_localidad($_REQUEST["campo9"]);
                    $fichas->set_region($_REQUEST["campo10"]);
                    $fichas->set_comuna($_REQUEST["campo11"]);
                    $fichas->set_haDisponibles($_REQUEST["campo12"]);
                    $fichas->set_direccion($_REQUEST["campo13"]);
                    $fichas->set_repre($_REQUEST["campo14"]);
                    $fichas->set_rutRepre($_REQUEST["campo15"]);
                    $fichas->set_telefonoRepre($_REQUEST["campo16"]);
                    $fichas->set_emailRepre($_REQUEST["campo17"]);
                    $fichas->set_banco($_REQUEST["campo18"]);
                    $fichas->set_cuentaC($_REQUEST["campo19"]);
                    $fichas->set_predio($_REQUEST["campo20"]);
                    $fichas->set_potrero($_REQUEST["campo21"]);
                    $fichas->set_rotacion_desc_1($_REQUEST["campo22"]);
                    $fichas->set_norting($_REQUEST["campo23"]);
                    $fichas->set_easting($_REQUEST["campo24"]);
                    $fichas->set_radio($_REQUEST["campo25"]);
                    $fichas->set_suelo($_REQUEST["campo26"]);
                    $fichas->set_riego($_REQUEST["campo27"]);
                    $fichas->set_experiencia($_REQUEST["campo28"]);
                    $fichas->set_tenencia($_REQUEST["campo29"]);
                    $fichas->set_maquinaria($_REQUEST["campo30"]);
                    $fichas->set_maleza($_REQUEST["campo31"]);
                    $fichas->set_estado($_REQUEST["campo32"]);
                    $fichas->set_comentario($_REQUEST["campo33"]);
                    $fichas->set_numAnexo($_REQUEST["campo34"]);
                    $fichas->set_ficha($_REQUEST["campo35"]);
                    $fichas->set_desde($_REQUEST["D"]);
                    $fichas->set_orden($_REQUEST["Orden"]);
                    $fichas->set_id_tempo($_REQUEST["Temporada"]);
                    $fichas->traerDatosActivas();
                    echo json_encode($fichas->data());
                break;

                case 'totalDatosActivas':
                    $fichas = new Fichas();
                    $fichas->set_fieldbook($_REQUEST["campo0"]);
                    $fichas->set_fieldman($_REQUEST["campo1"]);
                    $fichas->set_especie($_REQUEST["campo2"]);
                    $fichas->set_agricultor($_REQUEST["campo3"]);
                    $fichas->set_rut($_REQUEST["campo4"]);
                    $fichas->set_telefono($_REQUEST["campo5"]);
                    $fichas->set_administrador($_REQUEST["campo6"]);
                    $fichas->set_telefonoA($_REQUEST["campo7"]);
                    $fichas->set_oferta($_REQUEST["campo8"]);
                    $fichas->set_localidad($_REQUEST["campo9"]);
                    $fichas->set_region($_REQUEST["campo10"]);
                    $fichas->set_comuna($_REQUEST["campo11"]);
                    $fichas->set_haDisponibles($_REQUEST["campo12"]);
                    $fichas->set_direccion($_REQUEST["campo13"]);
                    $fichas->set_repre($_REQUEST["campo14"]);
                    $fichas->set_rutRepre($_REQUEST["campo15"]);
                    $fichas->set_telefonoRepre($_REQUEST["campo16"]);
                    $fichas->set_emailRepre($_REQUEST["campo17"]);
                    $fichas->set_banco($_REQUEST["campo18"]);
                    $fichas->set_cuentaC($_REQUEST["campo19"]);
                    $fichas->set_predio($_REQUEST["campo20"]);
                    $fichas->set_potrero($_REQUEST["campo21"]);
                    $fichas->set_rotacion_desc_1($_REQUEST["campo22"]);
                    $fichas->set_norting($_REQUEST["campo23"]);
                    $fichas->set_easting($_REQUEST["campo24"]);
                    $fichas->set_radio($_REQUEST["campo25"]);
                    $fichas->set_suelo($_REQUEST["campo26"]);
                    $fichas->set_riego($_REQUEST["campo27"]);
                    $fichas->set_experiencia($_REQUEST["campo28"]);
                    $fichas->set_tenencia($_REQUEST["campo29"]);
                    $fichas->set_maquinaria($_REQUEST["campo30"]);
                    $fichas->set_maleza($_REQUEST["campo31"]);
                    $fichas->set_estado($_REQUEST["campo32"]);
                    $fichas->set_comentario($_REQUEST["campo33"]);
                    $fichas->set_numAnexo($_REQUEST["campo34"]);
                    $fichas->set_ficha($_REQUEST["campo35"]);
                    $fichas->set_id_tempo($_REQUEST["Temporada"]);
                    $fichas->totalDatosActivas();
                    echo json_encode($fichas->data());
                break;

                case 'traerInfoActiva':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["info"]);
                    $fichas->traerInfoActiva();
                    $info = $fichas->data();
                    $fichas->traerRotacion();
                    echo json_encode(array($info,$fichas->data()));
                break;
                
                case 'editarFichaA':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["act"]);
                    $fichas->set_localidad($_REQUEST["campo4"]);
                    $fichas->set_predio($_REQUEST["campo5"]);
                    $fichas->set_potrero($_REQUEST["campo6"]);
                    $fichas->set_haDisponibles($_REQUEST["campo7"]);
                    $fichas->set_especie($_REQUEST["campo8"]);
                    $fichas->set_tenencia($_REQUEST["campo9"]);
                    $fichas->set_maquinaria($_REQUEST["campo10"]);
                    $fichas->set_experiencia($_REQUEST["campo11"]);
                    $fichas->set_oferta($_REQUEST["campo12"]);
                    $fichas->set_suelo($_REQUEST["campo13"]);
                    $fichas->set_riego($_REQUEST["campo14"]);
                    $fichas->set_maleza($_REQUEST["campo15"]);
                    $fichas->set_estado($_REQUEST["campo16"]);
                    $fichas->set_comentario($_REQUEST["campo17"]);
                    $fichas->set_rotacion_anno_1(date("Y")-4);
                    $fichas->set_rotacion_desc_1($_REQUEST["campo18"]);
                    $fichas->set_rotacion_anno_2(date("Y")-3);
                    $fichas->set_rotacion_desc_2($_REQUEST["campo19"]);
                    $fichas->set_rotacion_anno_3(date("Y")-2);
                    $fichas->set_rotacion_desc_3($_REQUEST["campo20"]);
                    $fichas->set_rotacion_anno_4(date("Y")-1);
                    $fichas->set_rotacion_desc_4($_REQUEST["campo21"]);
                    echo $fichas->editarFichaA();
                break;
                
                /* Fin activas */

                /* Provisorias */

                case 'traerDatosProvisorias':
                    $fichas = new Fichas();
                    $fichas->set_comentario($_REQUEST["FCom"]);
                    $fichas->set_fieldman($_REQUEST["FField"]);
                    $fichas->set_temporada($_REQUEST["FAnno"]);
                    $fichas->set_rut($_REQUEST["FRut"]);
                    $fichas->set_agricultor($_REQUEST["FNAgri"]);
                    $fichas->set_telefono($_REQUEST["FTel"]);
                    $fichas->set_oferta($_REQUEST["FONeg"]);
                    $fichas->set_localidad($_REQUEST["FLoc"]);
                    $fichas->set_region($_REQUEST["FReg"]);
                    $fichas->set_comuna($_REQUEST["FComu"]);
                    $fichas->set_haDisponibles($_REQUEST["FHAD"]);
                    $fichas->set_desde($_REQUEST["D"]);
                    $fichas->set_orden($_REQUEST["Orden"]);
                    $fichas->set_id_tempo($_REQUEST["Temporada"]);
                    $fichas->traerDatosProvisorias();
                    echo json_encode($fichas->data());
                break;

                case 'totalDatosProvisorias':
                    $fichas = new Fichas();
                    $fichas->set_comentario($_REQUEST["FCom"]);
                    $fichas->set_fieldman($_REQUEST["FField"]);
                    $fichas->set_temporada($_REQUEST["FAnno"]);
                    $fichas->set_rut($_REQUEST["FRut"]);
                    $fichas->set_agricultor($_REQUEST["FNAgri"]);
                    $fichas->set_telefono($_REQUEST["FTel"]);
                    $fichas->set_oferta($_REQUEST["FONeg"]);
                    $fichas->set_localidad($_REQUEST["FLoc"]);
                    $fichas->set_region($_REQUEST["FReg"]);
                    $fichas->set_comuna($_REQUEST["FComu"]);
                    $fichas->set_haDisponibles($_REQUEST["FHAD"]);
                    $fichas->set_id_tempo($_REQUEST["Temporada"]);
                    $fichas->totalDatosProvisorias();
                    echo json_encode($fichas->data());
                break;

                case 'crearFicha':

                    // echo "entro crea ficha";
                    // echo $_FILES["imagen"];
                    $cantidadImagenes = $_REQUEST["cantidad_imagenes"];
                    // echo "<pre>";
                    // var_dump($_FILES);
                    // echo "</pre>";
                    // echo "==============";
                    $arr = $_FILES["imagen"];
                    $arrayImagenes = array();
                    $cont = 0;
                    for($f = 0; $f < $cantidadImagenes; $f++){

                        $tmp = array(
                            "name" => $arr["name"][$f],
                            "type" => $arr["type"][$f],
                            "tmp_name" => $arr["tmp_name"][$f],
                            "error" => $arr["error"][$f],
                            "size" => $arr["size"][$f]
                        );
                        array_push($arrayImagenes, $tmp);
                    }

                    // echo "<pre>";
                    // var_dump($arrayImagenes);
                    // echo "</pre>";

                    $fichas = new Fichas();
                    $fichas->set_id_supervisor($_REQUEST["campo1"]);
                    $fichas->set_id_tempo($_REQUEST["campo2"]);
                    $fichas->set_id_agricultor($_REQUEST["campo3"]);
                    $fichas->set_id_region($_REQUEST["campo4"]);
                    $fichas->set_id_comuna($_REQUEST["campo5"]);
                    $fichas->set_localidad($_REQUEST["campo6"]);
                    $fichas->set_haDisponibles($_REQUEST["campo7"]);
                    $fichas->set_oferta($_REQUEST["campo8"]);
                    $fichas->set_comentario($_REQUEST["campo9"]);
                    $fichas->set_imagen($arrayImagenes);

                   
                   echo $fichas->crearFicha();
                break;

                case 'traerInfoProvisoria':

                    $resp = array();

                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["info"]);
                    $fichas->traerInfoProvisoria();
                    array_push($resp, $fichas->data());


                    $fichas2 = new Fichas();
                    $fichas2->set_id($_REQUEST["info"]);
                    $fichas2->traerImagenes();
                    array_push($resp, $fichas2->data());

                    echo json_encode($resp);
                break;

                case 'eliminarImagen':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["info"]);
                    echo  $fichas->eliminarImagen();
                break;

                case 'editarFicha':
                        
                    // echo "entro crea ficha";
                    // echo $_FILES["imagen"];
                    $cantidadImagenes = $_REQUEST["cantidad_imagenes"];
                    // echo "<pre>";
                    // var_dump($_FILES);
                    // echo "</pre>";
                    // echo "==============";
                    $arr = $_FILES["imagen"];
                    $arrayImagenes = array();
                    $cont = 0;
                    for($f = 0; $f < $cantidadImagenes; $f++){

                        $tmp = array(
                            "name" => $arr["name"][$f],
                            "type" => $arr["type"][$f],
                            "tmp_name" => $arr["tmp_name"][$f],
                            "error" => $arr["error"][$f],
                            "size" => $arr["size"][$f]
                        );
                        array_push($arrayImagenes, $tmp);
                    }

                    // echo "<pre>";
                    // var_dump($arrayImagenes);
                    // echo "</pre>";

                    
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["act"]);
                    $fichas->set_id_supervisor($_REQUEST["campo1"]);
                    $fichas->set_id_tempo($_REQUEST["campo2"]);
                    $fichas->set_id_agricultor($_REQUEST["campo3"]);
                    $fichas->set_id_region($_REQUEST["campo4"]);
                    $fichas->set_id_comuna($_REQUEST["campo5"]);
                    $fichas->set_localidad($_REQUEST["campo6"]);
                    $fichas->set_haDisponibles($_REQUEST["campo7"]);
                    $fichas->set_oferta($_REQUEST["campo8"]);
                    $fichas->set_comentario($_REQUEST["campo9"]);
                    $fichas->set_imagen($arrayImagenes);


                    echo $fichas->editarFicha();
                break;

                case 'traerInfoActivar':
                    $resp = array();

                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["info"]);
                    $fichas->traerInfoActivar();
                    array_push($resp, $fichas->data());

                    $fichas2 = new Fichas();
                    $fichas2->set_id($_REQUEST["info"]);
                    $fichas2->traerImagenes();
                    array_push($resp, $fichas2->data());

                    
                    echo json_encode($resp);
                break;

                case 'activarFicha':

                    // echo "entro crea ficha";
                    // echo $_FILES["imagen"];
                    $cantidadImagenes = $_REQUEST["cantidad_imagenes"];
                    // echo "<pre>";
                    // var_dump($_FILES);
                    // echo "</pre>";
                    // echo "==============";
                    $arr = $_FILES["imagen"];
                    $arrayImagenes = array();
                    $cont = 0;
                    for($f = 0; $f < $cantidadImagenes; $f++){

                        $tmp = array(
                            "name" => $arr["name"][$f],
                            "type" => $arr["type"][$f],
                            "tmp_name" => $arr["tmp_name"][$f],
                            "error" => $arr["error"][$f],
                            "size" => $arr["size"][$f]
                        );
                        array_push($arrayImagenes, $tmp);
                    }


                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["act"]);
                    $fichas->set_id_supervisor($_REQUEST["campo1"]);
                    $fichas->set_id_tempo($_REQUEST["campo2"]);
                    $fichas->set_id_agricultor($_REQUEST["campo3"]);
                    $fichas->set_oferta($_REQUEST["campo17"]);
                    $fichas->set_id_especie($_REQUEST["campo18"]);
                    $fichas->set_haDisponibles($_REQUEST["campo19"]);
                    $fichas->set_id_region($_REQUEST["campo20"]);
                    $fichas->set_id_comuna($_REQUEST["campo21"]);
                    $fichas->set_id_predio($_REQUEST["campo22"]);
                    $fichas->set_id_lote($_REQUEST["campo23"]);
                    $fichas->set_localidad($_REQUEST["campo24"]);
                    $fichas->set_rotacion_anno_1(date("Y")-4);
                    $fichas->set_rotacion_desc_1($_REQUEST["campo25"]);
                    $fichas->set_rotacion_anno_2(date("Y")-3);
                    $fichas->set_rotacion_desc_2($_REQUEST["campo26"]);
                    $fichas->set_rotacion_anno_3(date("Y")-2);
                    $fichas->set_rotacion_desc_3($_REQUEST["campo27"]);
                    $fichas->set_rotacion_anno_4(date("Y")-1);
                    $fichas->set_rotacion_desc_4($_REQUEST["campo28"]);
                    $fichas->set_id_suelo($_REQUEST["campo29"]);
                    $fichas->set_id_riego($_REQUEST["campo30"]);
                    $fichas->set_id_experiencia($_REQUEST["campo31"]);
                    $fichas->set_id_tenencia($_REQUEST["campo32"]);
                    $fichas->set_id_maquinaria($_REQUEST["campo33"]);
                    $fichas->set_maleza($_REQUEST["campo34"]);
                    $fichas->set_estado($_REQUEST["campo35"]);
                    $fichas->set_fecha($_REQUEST["campo36"]);
                    $fichas->set_comentario($_REQUEST["campo37"]);
                    $fichas->set_obsProp($_REQUEST["campo38"]);

                    $fichas->set_imagen($arrayImagenes);

                    echo $fichas->activarFicha();
                break;

                case 'rechazarFicha':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["rechazar"]);
                    echo $fichas->rechazarFicha();
                break;

                /* Fin provisorias */

                case 'traerComunas':
                    $fichas = new Fichas();
                    $fichas->set_id_region($_REQUEST["Region"]);
                    $fichas->traerComunas();
                    echo json_encode($fichas->data());
                break;

                /* Fin ubicacion */

                case 'traerPredio':
                    $fichas = new Fichas();
                    $fichas->set_id_comuna($_REQUEST["Comuna"]);
                    $fichas->set_id_agricultor($_REQUEST["Agricola"]);
                    $fichas->traerPredio();
                    echo json_encode($fichas->data());
                break;

                case 'traerPotrero':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["Predio"]);
                    $fichas->traerPotrero();
                    echo json_encode($fichas->data());
                break;

                case 'traerInfoAgri':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["Agri"]);
                    $fichas->traerInfoAgri();
                    echo json_encode($fichas->data());
                break;

                case 'traerImagenes':
                    $fichas = new Fichas();
                    $fichas->set_id($_REQUEST["Ficha"]);
                    $fichas->traerImagenes();
                    echo json_encode($fichas->data());
                break;

                case 'subirImagen':

                    // echo "entro crea prospecto";
                    // echo $_FILES["imagen"];
                    $cantidadImagenes = $_REQUEST["cantidad_imagenes"];
                    // echo "<pre>";
                    // var_dump($_FILES);
                    // echo "</pre>";
                    // echo "==============";
                    $arr = $_FILES["imagen"];
                    $arrayImagenes = array();
                    $cont = 0;
                    for($f = 0; $f < $cantidadImagenes; $f++){

                        $tmp = array(
                            "name" => $arr["name"][$f],
                            "type" => $arr["type"][$f],
                            "tmp_name" => $arr["tmp_name"][$f],
                            "error" => $arr["error"][$f],
                            "size" => $arr["size"][$f]
                        );
                        array_push($arrayImagenes, $tmp);
                    }

                    // echo "<pre>";
                    // var_dump($arrayImagenes);
                    // echo "</pre>";

                    $prospectos = new Fichas();
                    $prospectos->set_id($_REQUEST["act"]);
                    $prospectos->set_imagen($arrayImagenes);
                    echo $prospectos->subirImagen();

                break;

            }

        }

    }
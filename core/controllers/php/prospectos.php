<?php
    require_once '../secure/prospectos.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        // echo "print 1";

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/prospectos.php';

            // echo "print 2";

            switch ($action) {

                /* Activas */

                case 'traerDatosActivas': 
                    $prospectos = new Prospectos();
                    $prospectos->set_fieldman($_REQUEST["campo0"]);
                    $prospectos->set_especie($_REQUEST["campo1"]);
                    $prospectos->set_agricultor($_REQUEST["campo2"]);
                    $prospectos->set_rut($_REQUEST["campo3"]);
                    $prospectos->set_telefono($_REQUEST["campo4"]);
                    $prospectos->set_administrador($_REQUEST["campo5"]);
                    $prospectos->set_telefonoA($_REQUEST["campo6"]);
                    $prospectos->set_oferta($_REQUEST["campo7"]);
                    $prospectos->set_region($_REQUEST["campo8"]);
                    $prospectos->set_provincia($_REQUEST["campo9"]);
                    $prospectos->set_comuna($_REQUEST["campo10"]);
                    $prospectos->set_localidad($_REQUEST["campo11"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo12"]);
                    $prospectos->set_direccion($_REQUEST["campo13"]);
                    $prospectos->set_repre($_REQUEST["campo14"]);
                    $prospectos->set_rutRepre($_REQUEST["campo15"]);
                    $prospectos->set_telefonoRepre($_REQUEST["campo16"]);
                    $prospectos->set_emailRepre($_REQUEST["campo17"]);
                    $prospectos->set_banco($_REQUEST["campo18"]);
                    $prospectos->set_cuentaC($_REQUEST["campo19"]);
                    $prospectos->set_predio($_REQUEST["campo20"]);
                    $prospectos->set_potrero($_REQUEST["campo21"]);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo22"]);
                    $prospectos->set_norting($_REQUEST["campo23"]);
                    $prospectos->set_easting($_REQUEST["campo24"]);
                    $prospectos->set_radio($_REQUEST["campo25"]);
                    $prospectos->set_suelo($_REQUEST["campo26"]);
                    $prospectos->set_riego($_REQUEST["campo27"]);
                    $prospectos->set_experiencia($_REQUEST["campo28"]);
                    $prospectos->set_tenencia($_REQUEST["campo29"]);
                    $prospectos->set_maquinaria($_REQUEST["campo30"]);
                    $prospectos->set_maleza($_REQUEST["campo31"]);
                    $prospectos->set_estado($_REQUEST["campo32"]);
                    $prospectos->set_comentario($_REQUEST["campo33"]);
                    $prospectos->set_prospecto($_REQUEST["campo34"]);
                    $prospectos->set_carga($_REQUEST["campo35"]);
                    $prospectos->set_dispositivo($_REQUEST["campo36"]);
                    $prospectos->set_desde($_REQUEST["D"]);
                    $prospectos->set_orden($_REQUEST["Orden"]);
                    $prospectos->set_id_tempo($_REQUEST["Temporada"]);
                    $prospectos->traerDatosActivas();
                    echo json_encode($prospectos->data());
                break;

                case 'totalDatosActivas':
                    $prospectos = new Prospectos();;
                    $prospectos->set_fieldman($_REQUEST["campo0"]);
                    $prospectos->set_especie($_REQUEST["campo1"]);
                    $prospectos->set_agricultor($_REQUEST["campo2"]);
                    $prospectos->set_rut($_REQUEST["campo3"]);
                    $prospectos->set_telefono($_REQUEST["campo4"]);
                    $prospectos->set_administrador($_REQUEST["campo5"]);
                    $prospectos->set_telefonoA($_REQUEST["campo6"]);
                    $prospectos->set_oferta($_REQUEST["campo7"]);
                    $prospectos->set_region($_REQUEST["campo8"]);
                    $prospectos->set_provincia($_REQUEST["campo9"]);
                    $prospectos->set_comuna($_REQUEST["campo10"]);
                    $prospectos->set_localidad($_REQUEST["campo11"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo12"]);
                    $prospectos->set_direccion($_REQUEST["campo13"]);
                    $prospectos->set_repre($_REQUEST["campo14"]);
                    $prospectos->set_rutRepre($_REQUEST["campo15"]);
                    $prospectos->set_telefonoRepre($_REQUEST["campo16"]);
                    $prospectos->set_emailRepre($_REQUEST["campo17"]);
                    $prospectos->set_banco($_REQUEST["campo18"]);
                    $prospectos->set_cuentaC($_REQUEST["campo19"]);
                    $prospectos->set_predio($_REQUEST["campo20"]);
                    $prospectos->set_potrero($_REQUEST["campo21"]);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo22"]);
                    $prospectos->set_norting($_REQUEST["campo23"]);
                    $prospectos->set_easting($_REQUEST["campo24"]);
                    $prospectos->set_radio($_REQUEST["campo25"]);
                    $prospectos->set_suelo($_REQUEST["campo26"]);
                    $prospectos->set_riego($_REQUEST["campo27"]);
                    $prospectos->set_experiencia($_REQUEST["campo28"]);
                    $prospectos->set_tenencia($_REQUEST["campo29"]);
                    $prospectos->set_maquinaria($_REQUEST["campo30"]);
                    $prospectos->set_maleza($_REQUEST["campo31"]);
                    $prospectos->set_estado($_REQUEST["campo32"]);
                    $prospectos->set_comentario($_REQUEST["campo33"]);
                    $prospectos->set_prospecto($_REQUEST["campo34"]);
                    $prospectos->set_carga($_REQUEST["campo35"]);
                    $prospectos->set_dispositivo($_REQUEST["campo36"]);
                    $prospectos->set_id_tempo($_REQUEST["Temporada"]);
                    $prospectos->totalDatosActivas();
                    echo json_encode($prospectos->data());
                break;

                case 'traerInfoActiva':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["info"]);
                    $prospectos->traerInfoActiva();
                    $info = $prospectos->data();
                    $prospectos->traerRotacion();
                    echo json_encode(array($info,$prospectos->data()));
                break;
                
                case 'editarProspectoA':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["act"]);
                    $prospectos->set_localidad($_REQUEST["campo4"]);
                    $prospectos->set_predio($_REQUEST["campo5"]);
                    $prospectos->set_potrero($_REQUEST["campo6"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo7"]);
                    $prospectos->set_especie($_REQUEST["campo8"]);
                    $prospectos->set_tenencia($_REQUEST["campo9"]);
                    $prospectos->set_maquinaria($_REQUEST["campo10"]);
                    $prospectos->set_experiencia($_REQUEST["campo11"]);
                    $prospectos->set_oferta($_REQUEST["campo12"]);
                    $prospectos->set_suelo($_REQUEST["campo13"]);
                    $prospectos->set_riego($_REQUEST["campo14"]);
                    $prospectos->set_maleza($_REQUEST["campo15"]);
                    $prospectos->set_estado($_REQUEST["campo16"]);
                    $prospectos->set_comentario($_REQUEST["campo17"]);
                    $prospectos->set_rotacion_anno_1(date("Y")-4);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo18"]);
                    $prospectos->set_rotacion_anno_2(date("Y")-3);
                    $prospectos->set_rotacion_desc_2($_REQUEST["campo19"]);
                    $prospectos->set_rotacion_anno_3(date("Y")-2);
                    $prospectos->set_rotacion_desc_3($_REQUEST["campo20"]);
                    $prospectos->set_rotacion_anno_4(date("Y")-1);
                    $prospectos->set_rotacion_desc_4($_REQUEST["campo21"]);
                    echo $prospectos->editarFichaA();
                break;

                case 'cambiarEstado':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["cambiar"]);
                    echo $prospectos->cambiarEstado();
                break;
                
                /* Fin activas */
                
                /* Provisorias */

                case 'traerDatosProvisorias':
                    $prospectos = new Prospectos();
                    $prospectos->set_comentario($_REQUEST["campo0"]);
                    $prospectos->set_fieldman($_REQUEST["campo1"]);
                    $prospectos->set_rut($_REQUEST["campo2"]);
                    $prospectos->set_agricultor($_REQUEST["campo3"]);
                    $prospectos->set_telefono($_REQUEST["campo4"]);
                    $prospectos->set_oferta($_REQUEST["campo5"]);
                    $prospectos->set_region($_REQUEST["campo6"]);
                    $prospectos->set_provincia($_REQUEST["campo7"]);
                    $prospectos->set_comuna($_REQUEST["campo8"]);
                    $prospectos->set_localidad($_REQUEST["campo9"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo10"]);
                    $prospectos->set_prospecto($_REQUEST["campo11"]);
                    $prospectos->set_carga($_REQUEST["campo12"]);
                    $prospectos->set_dispositivo($_REQUEST["campo13"]);
                    $prospectos->set_desde($_REQUEST["D"]);
                    $prospectos->set_orden($_REQUEST["Orden"]);
                    $prospectos->set_id_tempo($_REQUEST["Temporada"]);
                    $prospectos->traerDatosProvisorias();
                    echo json_encode($prospectos->data());
                break;

                case 'totalDatosProvisorias':
                    $prospectos = new Prospectos();
                    $prospectos->set_comentario($_REQUEST["campo0"]);
                    $prospectos->set_fieldman($_REQUEST["campo1"]);
                    $prospectos->set_rut($_REQUEST["campo2"]);
                    $prospectos->set_agricultor($_REQUEST["campo3"]);
                    $prospectos->set_telefono($_REQUEST["campo4"]);
                    $prospectos->set_oferta($_REQUEST["campo5"]);
                    $prospectos->set_region($_REQUEST["campo6"]);
                    $prospectos->set_provincia($_REQUEST["campo7"]);
                    $prospectos->set_comuna($_REQUEST["campo8"]);
                    $prospectos->set_localidad($_REQUEST["campo9"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo10"]);
                    $prospectos->set_prospecto($_REQUEST["campo11"]);
                    $prospectos->set_carga($_REQUEST["campo12"]);
                    $prospectos->set_dispositivo($_REQUEST["campo13"]);
                    $prospectos->set_id_tempo($_REQUEST["Temporada"]);
                    $prospectos->totalDatosProvisorias();
                    echo json_encode($prospectos->data());
                break;

                case 'crearProspecto':

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

                    $prospectos = new Prospectos();
                    $prospectos->set_id_supervisor($_REQUEST["campo1"]);
                    $prospectos->set_id_tempo($_REQUEST["campo2"]);
                    $prospectos->set_id_agricultor($_REQUEST["campo3"]);
                    $prospectos->set_id_region($_REQUEST["campo4"]);
                    $prospectos->set_id_provincia($_REQUEST["campo5"]);
                    $prospectos->set_id_comuna($_REQUEST["campo6"]);
                    $prospectos->set_localidad($_REQUEST["campo7"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo8"]);
                    $prospectos->set_oferta($_REQUEST["campo9"]);
                    $prospectos->set_comentario($_REQUEST["campo10"]);
                    $prospectos->set_norting($_REQUEST["campo11"]);
                    $prospectos->set_easting($_REQUEST["campo12"]);

                    /* Datos extra */
                    $prospectos->set_id_especie($_REQUEST["campo13"]);
                    $prospectos->set_predio($_REQUEST["campo14"]);
                    $prospectos->set_potrero($_REQUEST["campo15"]);
                    $prospectos->set_rotacion_anno_1(date("Y")-4);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo16"]);
                    $prospectos->set_rotacion_anno_2(date("Y")-3);
                    $prospectos->set_rotacion_desc_2($_REQUEST["campo17"]);
                    $prospectos->set_rotacion_anno_3(date("Y")-2);
                    $prospectos->set_rotacion_desc_3($_REQUEST["campo18"]);
                    $prospectos->set_rotacion_anno_4(date("Y")-1);
                    $prospectos->set_rotacion_desc_4($_REQUEST["campo19"]);
                    $prospectos->set_id_suelo($_REQUEST["campo20"]);
                    $prospectos->set_id_riego($_REQUEST["campo21"]);
                    $prospectos->set_id_experiencia($_REQUEST["campo22"]);
                    $prospectos->set_id_tenencia($_REQUEST["campo23"]);
                    $prospectos->set_id_maquinaria($_REQUEST["campo24"]);
                    $prospectos->set_maleza($_REQUEST["campo25"]);
                    $prospectos->set_estado($_REQUEST["campo26"]);
                    $prospectos->set_fecha($_REQUEST["campo27"]);
                    $prospectos->set_obsProp($_REQUEST["campo28"]);

                    $prospectos->set_imagen($arrayImagenes);

                    echo $prospectos->crearFicha();
                break;

                case 'traerInfoProvisoria':

                    $resp = array();

                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["info"]);
                    $prospectos->traerInfoProvisoria();
                    array_push($resp, $prospectos->data());


                    $prospectos2 = new Prospectos();
                    $prospectos2->set_id($_REQUEST["info"]);
                    $prospectos2->traerImagenes();
                    array_push($resp, $prospectos2->data());

                    echo json_encode($resp);
                break;

                case 'eliminarImagen':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["info"]);
                    echo  $prospectos->eliminarImagen();
                break;

                case 'editarProspecto':
                        
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

                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["act"]);
                    $prospectos->set_id_supervisor($_REQUEST["campo1"]);
                    $prospectos->set_id_tempo($_REQUEST["campo2"]);
                    $prospectos->set_id_agricultor($_REQUEST["campo3"]);
                    $prospectos->set_id_region($_REQUEST["campo4"]);
                    $prospectos->set_id_provincia($_REQUEST["campo5"]);
                    $prospectos->set_id_comuna($_REQUEST["campo6"]);
                    $prospectos->set_localidad($_REQUEST["campo7"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo8"]);
                    $prospectos->set_oferta($_REQUEST["campo9"]);
                    $prospectos->set_comentario($_REQUEST["campo10"]);
                    $prospectos->set_norting($_REQUEST["campo11"]);
                    $prospectos->set_easting($_REQUEST["campo12"]);

                    /* Datos extra */
                    $prospectos->set_id_especie($_REQUEST["campo13"]);
                    $prospectos->set_predio($_REQUEST["campo14"]);
                    $prospectos->set_potrero($_REQUEST["campo15"]);
                    $prospectos->set_rotacion_anno_1(date("Y")-4);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo16"]);
                    $prospectos->set_rotacion_anno_2(date("Y")-3);
                    $prospectos->set_rotacion_desc_2($_REQUEST["campo17"]);
                    $prospectos->set_rotacion_anno_3(date("Y")-2);
                    $prospectos->set_rotacion_desc_3($_REQUEST["campo18"]);
                    $prospectos->set_rotacion_anno_4(date("Y")-1);
                    $prospectos->set_rotacion_desc_4($_REQUEST["campo19"]);
                    $prospectos->set_id_suelo($_REQUEST["campo20"]);
                    $prospectos->set_id_riego($_REQUEST["campo21"]);
                    $prospectos->set_id_experiencia($_REQUEST["campo22"]);
                    $prospectos->set_id_tenencia($_REQUEST["campo23"]);
                    $prospectos->set_id_maquinaria($_REQUEST["campo24"]);
                    $prospectos->set_maleza($_REQUEST["campo25"]);
                    $prospectos->set_estado($_REQUEST["campo26"]);
                    $prospectos->set_fecha($_REQUEST["campo27"]);
                    $prospectos->set_obsProp($_REQUEST["campo28"]);
                    
                    $prospectos->set_imagen($arrayImagenes);

                    echo $prospectos->editarFicha();
                break;

                case 'traerInfoActivar':
                    $resp = array();

                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["info"]);
                    $prospectos->traerInfoActivar();
                    array_push($resp, $prospectos->data());

                    $prospectos2 = new Prospectos();
                    $prospectos2->set_id($_REQUEST["info"]);
                    $prospectos2->traerImagenes();
                    array_push($resp, $prospectos2->data());

                    
                    echo json_encode($resp);
                break;

                case 'activarProspecto':

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


                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["act"]);
                    $prospectos->set_id_supervisor($_REQUEST["campo1"]);
                    $prospectos->set_id_tempo($_REQUEST["campo2"]);
                    $prospectos->set_id_agricultor($_REQUEST["campo3"]);
                    $prospectos->set_oferta($_REQUEST["campo17"]);
                    $prospectos->set_id_especie($_REQUEST["campo18"]);
                    $prospectos->set_haDisponibles($_REQUEST["campo19"]);
                    $prospectos->set_id_region($_REQUEST["campo20"]);
                    $prospectos->set_id_provincia($_REQUEST["campo21"]);
                    $prospectos->set_id_comuna($_REQUEST["campo22"]);
                    $prospectos->set_predio($_REQUEST["campo23"]);
                    $prospectos->set_potrero($_REQUEST["campo24"]);
                    $prospectos->set_localidad($_REQUEST["campo25"]);
                    $prospectos->set_rotacion_anno_1(date("Y")-4);
                    $prospectos->set_rotacion_desc_1($_REQUEST["campo26"]);
                    $prospectos->set_rotacion_anno_2(date("Y")-3);
                    $prospectos->set_rotacion_desc_2($_REQUEST["campo27"]);
                    $prospectos->set_rotacion_anno_3(date("Y")-2);
                    $prospectos->set_rotacion_desc_3($_REQUEST["campo28"]);
                    $prospectos->set_rotacion_anno_4(date("Y")-1);
                    $prospectos->set_rotacion_desc_4($_REQUEST["campo29"]);
                    $prospectos->set_id_suelo($_REQUEST["campo30"]);
                    $prospectos->set_id_riego($_REQUEST["campo31"]);
                    $prospectos->set_id_experiencia($_REQUEST["campo32"]);
                    $prospectos->set_id_tenencia($_REQUEST["campo33"]);
                    $prospectos->set_id_maquinaria($_REQUEST["campo34"]);
                    $prospectos->set_maleza($_REQUEST["campo35"]);
                    $prospectos->set_estado($_REQUEST["campo36"]);
                    $prospectos->set_fecha($_REQUEST["campo37"]);
                    $prospectos->set_comentario($_REQUEST["campo38"]);
                    $prospectos->set_obsProp($_REQUEST["campo39"]);
                    $prospectos->set_norting($_REQUEST["campo40"]);
                    $prospectos->set_easting($_REQUEST["campo41"]);

                    $prospectos->set_imagen($arrayImagenes);

                    echo $prospectos->activarFicha();
                break;

                case 'rechazarProspecto':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["rechazar"]);
                    echo $prospectos->rechazarFicha();
                break;

                /* Fin provisorias */

                case 'traerProvincias':
                    $prospectos = new Prospectos();
                    $prospectos->set_id_region($_REQUEST["Region"]);
                    $prospectos->traerProvincias();
                    echo json_encode($prospectos->data());
                break;

                case 'traerComunas':
                    $prospectos = new Prospectos();
                    $prospectos->set_id_provincia($_REQUEST["Provincia"]);
                    $prospectos->traerComunas();
                    echo json_encode($prospectos->data());
                break;

                /* Fin ubicacion */

                case 'traerPredio':
                    $prospectos = new Prospectos();
                    $prospectos->set_id_comuna($_REQUEST["Comuna"]);
                    $prospectos->set_id_agricultor($_REQUEST["Agricola"]);
                    $prospectos->traerPredio();
                    echo json_encode($prospectos->data());
                break;

                case 'traerPotrero':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["Predio"]);
                    $prospectos->traerPotrero();
                    echo json_encode($prospectos->data());
                break;

                case 'traerInfoAgri':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["Agri"]);
                    $prospectos->traerInfoAgri();
                    echo json_encode($prospectos->data());
                break;

                case 'traerImagenes':
                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["Prospecto"]);
                    $prospectos->traerImagenes();
                    echo json_encode($prospectos->data());
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

                    $prospectos = new Prospectos();
                    $prospectos->set_id($_REQUEST["act"]);
                    $prospectos->set_imagen($arrayImagenes);
                    echo $prospectos->subirImagen();

                break;

            }

        }

    }
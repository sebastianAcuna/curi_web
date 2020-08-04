<?php
    require_once '../secure/pro_cli_mat.php';

    // error_reporting(E_ALL);
    // ini_set('display_errors', '1'); 

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        // echo "print 1";

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/pro_cli_mat.php';

            // echo "print 2";

            switch ($action) {

                /* TITULOS */

                case 'traerDatosTitulo': 
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_es_lista($_REQUEST["campo2"]);
                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->traerDatosTitulo();
                    echo json_encode($proCliMat->data());
                break;
                

                case 'totalDatosTitulos':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_es_lista($_REQUEST["campo2"]);
                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->totalDatosTitulos();
                    echo json_encode($proCliMat->data());
                break;

                case 'crearTitulo':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_es_lista($_REQUEST["campo2"]);
                    echo json_encode($proCliMat->crearTitulo());
                break;


                case 'traerInfoTitulo':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_titulo($_REQUEST["info"]);
                    $proCliMat->traerInfoTitulo();
                    echo json_encode($proCliMat->data());
                break;

                case 'editarTitulo':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_titulo($_REQUEST["act"]);
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_es_lista($_REQUEST["campo2"]);
                    echo json_encode($proCliMat->editarTitulo());
                break;
                case 'eliminarTitulo':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_titulo($_REQUEST["rechazar"]);
                    echo json_encode($proCliMat->eliminarTitulo());
                break;

                /*  PROPIEDADES  */
                case 'traerDatosPropiedades': 
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->traerDatosPropiedades();
                    echo json_encode($proCliMat->data());
                break;

                case 'totalDatosPropiedades': 
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->totalDatosPropiedades();
                    echo json_encode($proCliMat->data());
                break;

                case 'crearPropiedad':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    echo json_encode($proCliMat->crearPropiedad());
                break;

                case 'traerInfoPropiedad':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_propiedad($_REQUEST["info"]);
                    $proCliMat->traerInfoPropiedad();
                    echo json_encode($proCliMat->data());
                break;


                 case 'editarPropiedad':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_propiedad($_REQUEST["act"]);
                    $proCliMat->set_nombre_es($_REQUEST["campo0"]);
                    $proCliMat->set_nombre_en($_REQUEST["campo1"]);
                    echo json_encode($proCliMat->editarPropiedad());
                break;

                 case 'eliminarPropiedad':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_propiedad($_REQUEST["rechazar"]);
                    echo json_encode($proCliMat->eliminarPropiedad());
                break;


                /* RELACIONES  */

                case 'traerDatosRelacion': 
                    $proCliMat = new ProCliMat();


                    $proCliMat->set_id_esp($_REQUEST["campo0"]);
                    $proCliMat->set_id_etapa($_REQUEST["campo1"]);
                    $proCliMat->set_id_tempo($_REQUEST["campo2"]);
                    $proCliMat->set_desc_titulo($_REQUEST["campo3"]);
                    $proCliMat->set_desc_propiedad($_REQUEST["campo4"]);
                    $proCliMat->set_aplica($_REQUEST["campo5"]);
                    
                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->traerDatosRelacion();
                    echo json_encode($proCliMat->data());
                break;

                case 'totalDatosRelacion':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_esp($_REQUEST["campo0"]);
                    $proCliMat->set_id_etapa($_REQUEST["campo1"]);
                    $proCliMat->set_id_tempo($_REQUEST["campo2"]);
                    $proCliMat->set_desc_titulo($_REQUEST["campo3"]);
                    $proCliMat->set_desc_propiedad($_REQUEST["campo4"]);
                    $proCliMat->set_aplica($_REQUEST["campo5"]);

                    $proCliMat->set_desde($_REQUEST["D"]);
                    $proCliMat->set_orden($_REQUEST["Orden"]);
                    $proCliMat->totalDatosRelacion();
                    echo json_encode($proCliMat->data());
                break;
                

                case 'crearRelacion':
                    $proCliMat = new ProCliMat();

                    // var_dump($_REQUEST["especies"]);
                    // var_dump(is_array($_REQUEST["especies"]));
                    $arrayEspecies;


                    if($_REQUEST["especies"] != null){

                        $idespecies = json_decode($_REQUEST["especies"]);
                        foreach($idespecies AS $id_es){
                            $arrayEspecies[$id_es] = $id_es;
                        }

                    }

                
                    
                    $proCliMat->set_especies_involucradas($arrayEspecies);



                    $proCliMat->set_id_etapa($_REQUEST["campo0"]);
                    $proCliMat->set_id_titulo($_REQUEST["campo1"]);
                    $proCliMat->set_id_propiedad($_REQUEST["campo2"]);
                    $proCliMat->set_id_tempo($_REQUEST["campo3"]);
                    

                    $proCliMat->set_quien_ingresa($_REQUEST["campo4"]);
                    $proCliMat->set_tipo_campo($_REQUEST["campo5"]);

                    $proCliMat->set_tabla($_REQUEST["campo6"]);
                    $proCliMat->set_campo($_REQUEST["campo7"]);

                    $proCliMat->set_reporte_cliente($_REQUEST["campo8"]);
                    $proCliMat->set_especial($_REQUEST["campo9"]);
                    /* campo10 ahora es el titulo */

                    $proCliMat->set_orden_tabla($_REQUEST["campo11"]);


                    echo json_encode($proCliMat->crearRelacion());
                break;
                case 'editarRelacion':
                    $proCliMat = new ProCliMat();

                    // var_dump($_REQUEST["especies"]);
                    // var_dump(is_array($_REQUEST["especies"]));
                    
                    $arrayEspecies;

                    if($_REQUEST["especies"] != null){

                        $idespecies = json_decode($_REQUEST["especies"]);
                        foreach($idespecies AS $id_es){
                            $arrayEspecies[$id_es] = $id_es;
                        }

                        $proCliMat->set_especies_involucradas($arrayEspecies);

                    }

                    $proCliMat->set_id_etapa($_REQUEST["campo0"]);
                    $proCliMat->set_id_titulo($_REQUEST["campo1"]);
                    $proCliMat->set_id_propiedad($_REQUEST["campo2"]);
                    $proCliMat->set_id_tempo($_REQUEST["campo3"]);
                    

                    $proCliMat->set_quien_ingresa($_REQUEST["campo4"]);
                    $proCliMat->set_tipo_campo($_REQUEST["campo5"]);

                    $proCliMat->set_tabla($_REQUEST["campo6"]);
                    $proCliMat->set_campo($_REQUEST["campo7"]);

                    $proCliMat->set_reporte_cliente($_REQUEST["campo8"]);
                    $proCliMat->set_especial($_REQUEST["campo9"]);
                    /* campo10 ahora es el titulo */
                    $proCliMat->set_orden_tabla($_REQUEST["campo11"]);

                    $proCliMat->set_id_relacion($_REQUEST["act"]);

                    echo json_encode($proCliMat->editarRelacion());
                break;

                case 'traerInfoRelacion':

                    $resp = array();

                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_relacion($_REQUEST["info"]);
                    $proCliMat->traerInfoRelacion();
                    array_push($resp, $proCliMat->data());

                    
                    $proCliMat2 = new ProCliMat();
                    $proCliMat2->set_id_relacion($_REQUEST["info"]);
                    $proCliMat2->set_id_propiedad($_REQUEST["propiedad"]);
                    $proCliMat2->set_id_tempo($_REQUEST["temporada"]);
                    $proCliMat2->traerEspeciesAplican();

                    array_push($resp, $proCliMat2->data());

                    echo json_encode($resp);
                break;

                case 'traerPCMCampos':

                    $proCliMat = new ProCliMat();
                    $proCliMat->set_nombre_en($_REQUEST["value"]);
                    $proCliMat->traerPCMCampos();
                    echo json_encode($proCliMat->data());
                    
                break;
                case 'traerEspeciesCheck':

                    $proCliMat = new ProCliMat();
                    $proCliMat->traerEspeciesCheck();
                    echo json_encode($proCliMat->data());
                    
                break;

                case 'cargarDespuesDe':
                    $proCliMat = new ProCliMat();

                    $proCliMat->set_id_etapa($_REQUEST["etapa"]);
                    $proCliMat->set_id_titulo($_REQUEST["titulo"]);
                    $proCliMat->set_id_tempo($_REQUEST["temporada"]);
                    $proCliMat->set_id_propiedad($_REQUEST["propiedad"]);

                    $proCliMat->cargarDespuesDe();
                    echo json_encode($proCliMat->data());
                    
                break;
                case 'cargarTitulosDespuesDe':
                    $proCliMat = new ProCliMat();

                    $proCliMat->set_id_etapa($_REQUEST["etapa"]);
                    $proCliMat->set_id_tempo($_REQUEST["temporada"]);

                    $proCliMat->cargarTitulosDespuesDe();
                    echo json_encode($proCliMat->data());
                    
                break;
                case 'traerPropiedadesSelect':

                    $proCliMat = new ProCliMat();
                    $proCliMat->traerPropiedadesSelect();
                    echo json_encode($proCliMat->data());
                    
                break;
                case 'traerTituloSelect':

                    $proCliMat = new ProCliMat();
                    $proCliMat->traerTituloSelect();
                    echo json_encode($proCliMat->data());
                    
                break;


                case 'eliminarRelacion':
                    $proCliMat = new ProCliMat();
                    $proCliMat->set_id_relacion($_REQUEST["rechazar"]);
                    echo json_encode($proCliMat->eliminarRelacion());
                break;


                
                


            }

        }

    }
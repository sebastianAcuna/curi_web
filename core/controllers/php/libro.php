<?php
    require_once '../secure/libro.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/libro.php';

            switch ($action) {
                case 'traerDatosResumen':
                    $libro = new Libro();

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_etapa($_REQUEST["Etapa"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);
                    $libro->set_desde($_REQUEST["D"]);
                    $libro->set_orden($_REQUEST["Orden"]);

                    $libro->headTabla();
                    $head = $libro->data();

                    $libro->traerDatosResumen();
                    $datos = $libro->data();
                    $ArrayDatos = array();
                    foreach($datos AS $dato){
                        $ArrayResultado = array();

                        if($dato["visita"] != ""){
                            $ArrayResultado["visita"] = $dato["visita"];
                            $ArrayResultado["anexo"] = $dato["id_ac"];
                            
                            foreach($head AS $valor){
                                
                                if(trim($valor["subHead"]) == "PICTURES"){
                                    $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                                
                                }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                                    $libro->set_tabla($valor["tabla"]);
                                    $libro->set_campo($valor["campo"]);
                                    $libro->set_Q($dato["id_quotation"]);
                                    $libro->set_AC($dato["id_ac"]);
                                    $libro->set_M($dato["id_materiales"]);
                                    $libro->datoForaneo();
                                    $ArrayResultado[$valor["id_prop_mat_cli"]] = $libro->data();
                                }else{
                                    $ArrayResultado[$valor["id_prop_mat_cli"]] = "";
    
                                }
    
                            }

                            array_push($ArrayDatos,$ArrayResultado);

                        }


                    }
                    
                    echo json_encode(array($head,$ArrayDatos));
                break;

                case 'totalDatosResumen':
                    $libro = new Libro();

                    $libro->set_num($_REQUEST["FNum"]);
                    $libro->set_ane($_REQUEST["FAne"]);
                    $libro->set_cli($_REQUEST["FCli"]);
                    $libro->set_esp($_REQUEST["FEsp"]);
                    $libro->set_var($_REQUEST["FVar"]);
                    $libro->set_agr($_REQUEST["FAgr"]);
                    $libro->set_pre($_REQUEST["FPre"]);
                    $libro->set_pot($_REQUEST["FPot"]);

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);

                    $libro->totalDatosResumen();
                    echo json_encode($libro->data());
                break;

                case 'traerDatosTabla':
                    $libro = new Libro();

                    $libro->set_rec($_REQUEST["Campo0"]);
                    $libro->set_num($_REQUEST["Campo1"]);
                    $libro->set_ane($_REQUEST["Campo2"]);
                    $libro->set_esp($_REQUEST["Campo3"]);
                    $libro->set_var($_REQUEST["Campo4"]);
                    $libro->set_agr($_REQUEST["Campo5"]);
                    $libro->set_pre($_REQUEST["Campo6"]);
                    $libro->set_pot($_REQUEST["Campo7"]);

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_etapa($_REQUEST["Etapa"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);
                    $libro->set_desde($_REQUEST["D"]);
                    $libro->set_orden($_REQUEST["Orden"]);

                    $libro->headTabla();
                    $head = $libro->data();
                    $libro->traerDatosTabla();
                    $datos = $libro->data();

                    $ArrayDatos = array();
                    foreach($datos AS $dato){
                        $ArrayResultado = array();

                        $ArrayResultado["recome"] = $dato["recome"];
                        $ArrayResultado["num_lote"] = $dato["num_lote"];
                        $ArrayResultado["num_anexo"] = $dato["num_anexo"];
                        $ArrayResultado["especie"] = $dato["especie"];
                        $ArrayResultado["nom_hibrido"] = $dato["nom_hibrido"];
                        $ArrayResultado["razon_social"] = $dato["razon_social"];
                        $ArrayResultado["predio"] = $dato["predio"];
                        $ArrayResultado["lote"] = $dato["lote"];
                        $ArrayResultado["visita"] = $dato["visita"];
                        $ArrayResultado["anexo"] = $dato["id_ac"];

                        foreach($head AS $valor){
                            
                            if(trim($valor["subHead"]) == "PICTURES"){
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                            
                            }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                                $libro->set_tabla($valor["tabla"]);
                                $libro->set_campo($valor["campo"]);
                                $libro->set_Q($dato["id_quotation"]);
                                $libro->set_AC($dato["id_ac"]);
                                $libro->set_M($dato["id_materiales"]);
                                $libro->datoForaneo();
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = $libro->data();

                            }else{
                                $valores = explode(" | ",$dato["datos"]);
                                for($i = 0; $i < COUNT($valores); $i++){
                                    $campos = explode(" && ",$valores[$i]);
                                    if($valor["id_prop_mat_cli"] == $campos[1]){
                                        $ArrayResultado[$valor["id_prop_mat_cli"]] = $campos[0]." && ".$campos[1]." && ".$campos[2];
    
                                    }

                                }

                            }

                        }

                        array_push($ArrayDatos,$ArrayResultado);

                    }
                    
                    echo json_encode(array($head,$ArrayDatos));
                break;

                case 'totalDatosTabla':
                    $libro = new Libro();

                    $libro->set_rec($_REQUEST["Campo0"]);
                    $libro->set_num($_REQUEST["Campo1"]);
                    $libro->set_ane($_REQUEST["Campo2"]);
                    $libro->set_esp($_REQUEST["Campo3"]);
                    $libro->set_var($_REQUEST["Campo4"]);
                    $libro->set_agr($_REQUEST["Campo5"]);
                    $libro->set_pre($_REQUEST["Campo6"]);
                    $libro->set_pot($_REQUEST["Campo7"]);

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_etapa($_REQUEST["Etapa"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);
                    
                    $libro->totalDatosTabla();
                    echo json_encode($libro->data());
                break;

                case 'traerDatosAll':
                    $libro = new Libro();

                    $libro->set_rec($_REQUEST["Campo0"]);
                    $libro->set_num($_REQUEST["Campo1"]);
                    $libro->set_ane($_REQUEST["Campo2"]);
                    $libro->set_esp($_REQUEST["Campo3"]);
                    $libro->set_var($_REQUEST["Campo4"]);
                    $libro->set_agr($_REQUEST["Campo5"]);
                    $libro->set_pre($_REQUEST["Campo6"]);
                    $libro->set_pot($_REQUEST["Campo7"]);

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);
                    $libro->set_desde($_REQUEST["D"]);
                    $libro->set_orden($_REQUEST["Orden"]);

                    $libro->headAll();
                    $head = $libro->data();
                    $libro->traerDatosAll();
                    $datos = $libro->data();

                    $ArrayDatos = array();
                    foreach($datos AS $dato){
                        $ArrayResultado = array();
                        
                        $ArrayResultado["recome"] = $dato["recome"];
                        $ArrayResultado["num_lote"] = $dato["num_lote"];
                        $ArrayResultado["num_anexo"] = $dato["num_anexo"];
                        $ArrayResultado["especie"] = $dato["especie"];
                        $ArrayResultado["nom_hibrido"] = $dato["nom_hibrido"];
                        $ArrayResultado["razon_social"] = $dato["razon_social"];
                        $ArrayResultado["predio"] = $dato["predio"];
                        $ArrayResultado["lote"] = $dato["lote"];
                        $ArrayResultado["visita"] = $dato["visita"];
                        $ArrayResultado["anexo"] = $dato["id_ac"];

                        foreach($head AS $valor){
                            
                            if(trim($valor["subHead"]) == "PICTURES"){
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                            
                            }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                                $libro->set_tabla($valor["tabla"]);
                                $libro->set_campo($valor["campo"]);
                                $libro->set_Q($dato["id_quotation"]);
                                $libro->set_AC($dato["id_ac"]);
                                $libro->set_M($dato["id_materiales"]);
                                $libro->datoForaneo();
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = $libro->data();

                            }else{

                                $valores = explode(" | ",$dato["datos"]);
                                for($i = 0; $i < COUNT($valores); $i++){
                                    $campos = explode(" && ",$valores[$i]);
                                    if($valor["id_prop_mat_cli"] == $campos[1]){
                                        $ArrayResultado[$valor["id_prop_mat_cli"]] = $campos[0]." && ".$campos[1]." && ".$campos[2];
    
                                    }

                                }

                            }

                        }

                        array_push($ArrayDatos,$ArrayResultado);

                    }
                    
                    echo json_encode(array($head,$ArrayDatos));
                break;

                case 'totalDatosAll':
                    $libro = new Libro();

                    $libro->set_rec($_REQUEST["Campo0"]);
                    $libro->set_num($_REQUEST["Campo1"]);
                    $libro->set_ane($_REQUEST["Campo2"]);
                    $libro->set_esp($_REQUEST["Campo3"]);
                    $libro->set_var($_REQUEST["Campo4"]);
                    $libro->set_agr($_REQUEST["Campo5"]);
                    $libro->set_pre($_REQUEST["Campo6"]);
                    $libro->set_pot($_REQUEST["Campo7"]);

                    $libro->set_id_temporada($_REQUEST["Temporada"]);
                    $libro->set_id_esp($_REQUEST["Especie"]);
                    
                    $libro->totalDatosAll();
                    echo json_encode($libro->data());

                break;
                
                case 'traerImagenes':
                    $libro = new Libro();
                    $libro->set_etapa($_REQUEST["Etapa"]);
                    $libro->set_id($_REQUEST["Info"]);
                    $libro->traerImagenes();
                    echo json_encode($libro->data());
                break;

                case 'asignarValor':
                    $libro = new Libro();
                    $libro->set_info(json_decode($_REQUEST["Info"]));
                    echo $libro->asignarValor();
                break;
                
            }

        }

    }
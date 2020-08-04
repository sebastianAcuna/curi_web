<?php
    require_once '../../db/conectarse_db.php';


    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    $rutUsuario = (isset($_GET['rutUsuario'])) ? $_GET['rutUsuario'] : '18.804.066-7';
    $idCabecera = (isset($idCabecera)) ? $idCabecera : 0;


    $conexionWeb = new Conectar();
    $conexionWeb = $conexionWeb->conexion();

    $conexionDescarga = new Conectar();
    $conexionDescarga = $conexionDescarga->conexion_descarga();


    $tiempo_inicialTotal = microtime(true);
    $fechaHoraInicio = date('Y-m-d H:i:s');

    $arrayRespuestaErronea = array();

    $arrayEspecie;
    $arrayTipoRiego;
    $arrayTipoSuelo;
    $arrayMaterial;
    $arrayTipoEnvase;
    $arrayUM;
    $arrayTipoDespacho;
    $arrayTipoCertificacion;
    $arrayTipoContrato;
    $arrayTemporada;
    $arrayPais;
    $arrayMoneda;
    $arrayIncoterms;
    $arrayEstadoFicha;
    $arrayCondiciones;
    $arrayComuna;
    $arrayCliente;
    $arrayAgricultor;
    $arrayQuotations;
    $arrayPredio;
    $arrayContratoCliente;
    $arrayContratoAgricultor;
    $arrayDetalleQuotation;
    $arrayFicha;
    $arrayAnexoContrato;
    $arrayEmpresa;
    $arrayHistorialPredio;
    $arrayStockSemilla;
    $arrayExport;


    /*  EMPRESA */
    try{
        $sqlWeb = "SELECT * FROM empresa ";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayEmpresa[$data["id_empresa_SAP"]] = $data["id_empresa"];
            }
        }
    
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR SELECT empresa] => ".$error->getMessage()));
    }

    /* UNIDAD DE MEDIDA  */
    try{

        // TRAE TODO LO QUE TENGO EN WEB
        $sqlWeb = "SELECT * FROM unidad_medida;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayUM[$data["id_um_SAP"]] = $data["id_um_SAP"];
            }
        }

        // TRAE TODO LO DE LA BD INTERCAMBIO
        $sqlDescarga = "SELECT * FROM unidad_medida;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        // SI EXISTE ALGO NUEVO EN INTERCAMBIO
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM unidad_medida WHERE id_um_SAP  = ?; ";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_um'], PDO::PARAM_STR);
                // $consultaWeb->execute();


                // if($consultaWeb->rowCount() <= 0){
                    $arrayUM[$valIntercambio["id_um"]] = $valIntercambio["id_um"];
                // }
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO unidad_medida] => ".$error->getMessage()));
    }


    /* TIPO DE DESPACHO  */
    try{

        $sqlWeb = "SELECT * FROM tipo_de_despacho;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoDespacho[$data["id_tipo_desp_SAP"]] = $data["id_tipo_desp_SAP"];
            }
        }


        $tiempo_inicial = microtime(true);
        $sqlDescarga = "SELECT * FROM tipo_de_despacho;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                    // $sqlWeb = "SELECT * FROM tipo_de_despacho WHERE id_tipo_desp_SAP  = ?; ";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_desp']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayTipoDespacho[$valIntercambio["id_tipo_desp"]] = $valIntercambio["id_tipo_desp"];
    
                    // }
            }
        }
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_despacho] => ".$error->getMessage()));
    }


    /* TIPO DE CERTIFICACION  */
    try{

        $sqlWeb = "SELECT * FROM tipo_de_certificacion;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoCertificacion[$data["id_tipo_cert_SAP"]] = $data["id_tipo_cert_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM tipo_de_certificacion;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){

                // $sqlWeb = "SELECT * FROM tipo_de_certificacion WHERE id_tipo_cert_SAP  = ?;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_cert']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayTipoCertificacion[$valIntercambio["id_tipo_cert"]] = $valIntercambio["id_tipo_cert"];

                // }
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_certificacion] => ".$error->getMessage()));
    }

    /* TEMPORADA  */
    try{


        $sqlWeb = "SELECT * FROM temporada;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTemporada[$data["id_tempo_SAP"]] = $data["id_tempo_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM temporada;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                // $sqlWeb = "SELECT * FROM temporada WHERE id_tempo_SAP  = ?;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_tempo']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){
                    $arrayTemporada[$valIntercambio["id_tempo"]] = $valIntercambio["id_tempo"];
                // }
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO temporada] => ".$error->getMessage()));
    }


    /* TIPO CONTRATO  */
    try{

        $sqlWeb = "SELECT * FROM tipo_contrato;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoContrato[$data["id_tipo_cont_SAP"]] = $data["id_tipo_cont_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM tipo_contrato; ";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                    // $sqlWeb = "SELECT * FROM tipo_contrato WHERE id_tipo_cont_SAP  = ?; ";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_cont']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayTipoContrato[$valIntercambio["id_tipo_cont"]] = $valIntercambio["id_tipo_cont"];
                    // }
                }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_contrato] => ".$error->getMessage()));
    }


    /* TIPO SUELO  */
    try{

        $sqlWeb = "SELECT * FROM tipo_suelo ;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoSuelo[$data["id_tipo_suelo_SAP"]] = $data["id_tipo_suelo_SAP"];
            }
    
        }


        $sqlDescarga = "SELECT * FROM tipo_suelo ;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){

            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM tipo_suelo WHERE id_tipo_suelo_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_suelo']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayTipoSuelo[$valIntercambio["id_tipo_suelo"]] = $valIntercambio["id_tipo_suelo"];

                // }
               
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_suelo] => ".$error->getMessage()));
    }


    /* TIPO RIEGO  */
    try{

        $sqlWeb = "SELECT * FROM tipo_riego;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoRiego[$data["id_tipo_riego_SAP"]] = $data["id_tipo_riego_SAP"];
            }
    
        }


        $sqlDescarga = "SELECT * FROM tipo_riego;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM tipo_riego WHERE id_tipo_riego_SAP  = ?;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_riego']);
                // $consultaWeb->execute();
                
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayTipoRiego[$valIntercambio["id_tipo_riego"]] = $valIntercambio["id_tipo_riego"];
                // }
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_riego] => ".$error->getMessage()));
    }

    /* ESPECIE  */
    try{

        $sqlWeb = "SELECT * FROM especie;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayEspecie[$data["id_esp_SAP"]] = $data["id_esp_SAP"];
            }
    
        }


        $sqlDescarga = "SELECT * FROM especie; ";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM especie WHERE id_esp_SAP  = ?;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_esp']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayEspecie[$valIntercambio["id_esp"]] = $valIntercambio["id_esp"];

                // }
                
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO especie] => ".$error->getMessage()));
    }

    /* PAIS  */
    try{

        $sqlWeb = "SELECT * FROM pais;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayPais[$data["id_pais_SAP"]] = $data["id_pais_SAP"];
            }
    
        }


        $sqlDescarga = "SELECT * FROM pais;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM pais WHERE id_pais_SAP  = ?;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_pais']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){
                    $arrayPais[$valIntercambio["id_pais"]] = $valIntercambio["id_pais"];
                // }
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO pais] => ".$error->getMessage()));
    }


    /* MONEDA  */
    try{

        $sqlWeb = "SELECT * FROM moneda;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayMoneda[$data["id_moneda_SAP"]] = $data["id_moneda_SAP"];
            }
        }

        $sqlDescarga = "SELECT * FROM moneda;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM moneda WHERE id_moneda_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_moneda']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayMoneda[$valIntercambio["id_moneda"]] = $valIntercambio["id_moneda"];

                // }
            }
        }
        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO moneda] => ".$error->getMessage()));
    }


    /* INCOTERMS  */
    try{

        $sqlWeb = "SELECT * FROM incoterms;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayIncoterms[$data["id_incot_SAP"]] = $data["id_incot_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM incoterms;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM incoterms WHERE id_incot_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_incot']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayIncoterms[$valIntercambio["id_incot"]] = $valIntercambio["id_incot"];

                
                // }
                
            }
        }

       
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO incoterms] => ".$error->getMessage()));
    }



    /* ESTADO FICHA  */
    try{

        $sqlWeb = "SELECT * FROM estado_ficha;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayEstadoFicha[$data["id_est_fic_SAP"]] = $data["id_est_fic_SAP"];
            }

        }


        $sqlDescarga = "SELECT * FROM estado_ficha;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM estado_ficha WHERE id_est_fic_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_est_fic']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayEstadoFicha[$valIntercambio["id_est_fic"]] = $valIntercambio["id_est_fic"];

                // }
                
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO estado_ficha] => ".$error->getMessage()));
    }



    /* CONDICION */
    try{

        $sqlWeb = "SELECT * FROM condicion;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayCondiciones[$data["id_tipo_condicion_SAP"]] = $data["id_tipo_condicion_SAP"];
            }

        }

        $sqlDescarga = "SELECT * FROM condicion;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM condicion WHERE id_tipo_condicion_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_condicion']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){
                    $arrayCondiciones[$valIntercambio["id_tipo_condicion"]] = $valIntercambio["id_tipo_condicion"];

                // }
                
            }

        }

       
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO condicion] => ".$error->getMessage()));
    }


    /* COMUNA */
    try{

        $sqlWeb = "SELECT * FROM comuna;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayComuna[$data["id_comuna_SAP"]] = $data["id_comuna_SAP"];
            }

        }

        $sqlDescarga = "SELECT * FROM comuna;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $sqlWeb = "SELECT * FROM comuna WHERE id_comuna_SAP  = ? ;";
                // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                // $consultaWeb->bindValue("1", $valIntercambio['id_comuna']);
                // $consultaWeb->execute();
                
                // if($consultaWeb->rowCount() <= 0){

                    $arrayComuna[$valIntercambio["id_comuna"]] = $valIntercambio["id_comuna"];

                // }
                
            }

        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO comuna] => ".$error->getMessage()));
    }




    /*  TABLAS CON REFERENCIAS */

    /* MATERIALES  */
    try{

        $sqlWeb = "SELECT * FROM materiales;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayMaterial[$data["id_materiales_SAP"]] = $data["id_materiales_SAP"];
            }
    
        }
        $sqlDescarga = "SELECT * FROM materiales ;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){

                if($arrayEspecie[$valIntercambio["id_esp"]] == null){
                    /* manejo de errores */
                    array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA materiales]", "tabla"=>"materiales", "campo"=>"id_esp","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_materiales"]));

                }else{
                    /*  existe y se debe proceder de forma normal */
                    // $sqlWeb = "SELECT * FROM materiales WHERE id_materiales_SAP  = ? ;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_materiales']);
                    // $consultaWeb->execute();
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayMaterial[$valIntercambio["id_materiales"]] = $valIntercambio["id_materiales"];
                    // }
                }
            }

        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO materiales] => ".$error->getMessage()));
    }
    

    /* TIPO DE ENVASE  */
    try{

        $sqlWeb = "SELECT * FROM tipo_de_envase;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayTipoEnvase[$data["id_tipo_envase_SAP"]] = $data["id_tipo_envase_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM tipo_de_envase;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){

                if($arrayMaterial[$valIntercambio["id_materiales"]] == null || $arrayUM[$valIntercambio["id_um"]] == null){

                    if($arrayMaterial[$valIntercambio["id_materiales"]] == null){ 
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA tipo_de_envase]", "tabla"=>"tipo_de_envase", "campo"=>"id_materiales","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_materiales"],"id_origen"=>$valIntercambio["id_tipo_envase"]));
                    }


                    if($arrayUM[$valIntercambio["id_um"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA tipo_de_envase]", "tabla"=>"tipo_de_envase", "campo"=>"id_um","tabla_ref"=>"unidad_medida", "valor"=>$valIntercambio["id_um"],"id_origen"=>$valIntercambio["id_tipo_envase"]));
                    }


                }else{
                    // $sqlWeb = "SELECT * FROM tipo_de_envase WHERE id_tipo_envase_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_tipo_envase']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
    
                        $arrayTipoEnvase[$valIntercambio["id_tipo_envase"]] = $valIntercambio["id_tipo_envase"];
                    // }
                }
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_envase] => ".$error->getMessage()));
    }


    /* CLIENTE */
    try{

        $sqlWeb = "SELECT * FROM cliente;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayCliente[$data["id_cli_SAP"]] = $data["id_cli_SAP"];
            }

        }

        $sqlDescarga = "SELECT * FROM cliente;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if($arrayPais[$valIntercambio["id_pais"]] == null){
                    array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA cliente]", "tabla"=>"cliente", "campo"=>"id_pais","tabla_ref"=>"pais", "valor"=>$valIntercambio["id_pais"],"id_origen"=>$valIntercambio["id_cli"]));
                }else{

                    // $sqlWeb = "SELECT * FROM cliente WHERE id_cli_SAP  = ? ;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_cli']);
                    // $consultaWeb->execute();


                    // if($consultaWeb->rowCount() <= 0){

                        $arrayCliente[$valIntercambio["id_cli"]] = $valIntercambio["id_cli"];
                    // }
                }
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cliente] => ".$error->getMessage()));
    }


    /* AGRICULTOR */
    try{

        $sqlWeb = "SELECT * FROM agricultor;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayAgricultor[$data["id_agric_SAP"]] = $data["id_agric_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM agricultor;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if($arrayComuna[$valIntercambio["id_comuna"]] == null){
                    array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA agricultor]", "tabla"=>"agricultor", "campo"=>"id_comuna","tabla_ref"=>"comuna", "valor"=>$valIntercambio["id_comuna"],"id_origen"=>$valIntercambio["id_agric"]));
                    
                }else{
                    // $sqlWeb = "SELECT * FROM agricultor WHERE id_agric_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_agric']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayAgricultor[$valIntercambio["id_agric"]] = $valIntercambio["id_agric"];
                    // }
                }  
            }
        }
        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO agricultor] => ".$error->getMessage()));
    }



        /* STOCK SEMILLAS */
        try{

            $sqlWeb = "SELECT * FROM stock_semillas;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayStockSemilla[$data["id_stock_semilla_sap"]] = $data["id_stock_semilla_sap"];
                }
    
            }
    
            $sqlDescarga = "SELECT * FROM stock_semillas;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
    
                foreach($r as $valIntercambio){
    
                    if( $arrayEspecie[$valIntercambio["id_esp"]] == null || 
                        $arrayCliente[$valIntercambio["id_cli"]] == null || 
                        $arrayMaterial[$valIntercambio["id_materiales"]] == null || 
                        $arrayTemporada[$valIntercambio["id_tempo"]] == null){
                        
                         if($arrayEspecie[$valIntercambio["id_esp"]] == null ) {
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA stock_semillas]", "tabla"=>"stock_semillas", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_stock_semilla"]));
                         }  

                         if($arrayCliente[$valIntercambio["id_cli"]] == null ) {
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA stock_semillas]", "tabla"=>"stock_semillas", "campo"=>"id_cli","tabla_ref"=>"cliente", "valor"=>$valIntercambio["id_cli"],"id_origen"=>$valIntercambio["id_stock_semilla"]));
                         } 

                         if($arrayMaterial[$valIntercambio["id_materiales"]] == null ) {
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA stock_semillas]", "tabla"=>"stock_semillas", "campo"=>"id_materiales","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_materiales"],"id_origen"=>$valIntercambio["id_stock_semilla"]));
                         } 

                         if($arrayTemporada[$valIntercambio["id_tempo"]] == null ) {
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA stock_semillas]", "tabla"=>"stock_semillas", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_stock_semilla"]));
                         } 
                        
                    }else{
                            $arrayStockSemilla[$valIntercambio["id_stock_semilla"]] = $valIntercambio["id_stock_semilla"];
                    }
                }
            }
    
            
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO stock_semillas] => ".$error->getMessage()));
        }


       

    /* QUOTATIONS */
    try{

        $sqlWeb = "SELECT * FROM quotation;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayQuotations[$data["id_quotation_SAP"]] = $data["id_quotation_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM quotation;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if($arrayCliente[$valIntercambio["id_cli"]] == null || $arrayEspecie[$valIntercambio["id_esp"]] == null || $arrayTemporada[$valIntercambio["id_tempo"]] == null){

                    

                    if($arrayCliente[$valIntercambio["id_cli"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA quotation]", "tabla"=>"quotation", "campo"=>"id_cli","tabla_ref"=>"cliente", "valor"=>$valIntercambio["id_cli"],"id_origen"=>$valIntercambio["id_quotation"]));
                        
                    }

                    if($arrayEspecie[$valIntercambio["id_esp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA quotation]", "tabla"=>"quotation", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_quotation"]));
                    }

                    if($arrayTemporada[$valIntercambio["id_tempo"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA quotation]", "tabla"=>"quotation", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_quotation"]));
                    }

                }else{
                    // $sqlWeb = "SELECT * FROM quotation WHERE id_quotation_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_quotation']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayQuotations[$valIntercambio["id_quotation"]] = $valIntercambio["id_quotation"];
    
                    // }
                }
            }
        }


    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO quotation] => ".$error->getMessage()));
    }


    /* PREDIO */
    try{

        $sqlWeb = "SELECT * FROM predio;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayPredio[$data["id_pred_SAP"]] = $data["id_pred_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM predio;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){ 

                if($arrayComuna[$valIntercambio["id_comuna"]] == null){

                    array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA predio]", "tabla"=>"predio", "campo"=>"id_comuna","tabla_ref"=>"comuna", "valor"=>$valIntercambio["id_comuna"],"id_origen"=>$valIntercambio["id_pred"]));
                    
                }else{

                    // $sqlWeb = "SELECT * FROM predio WHERE id_pred_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_pred']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayPredio[$valIntercambio["id_pred"]] = $valIntercambio["id_pred"];
                    // }
                }
            }
        }

       
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO predio] => ".$error->getMessage()));
    }


    /* CONTRATO CLIENTE */
    try{

        $sqlWeb = "SELECT * FROM contrato_cliente;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayContratoCliente[$data["id_concli_SAP"]] = $data["id_concli_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM contrato_cliente;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){

                if($arrayCliente[$valIntercambio["id_cli"]] == null || $arrayEspecie[$valIntercambio["id_esp"]] == null || $arrayEmpresa[$valIntercambio["id_emp"]] == null){

                    if($arrayCliente[$valIntercambio["id_cli"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_cliente]", "tabla"=>"contrato_cliente", "campo"=>"id_cli","tabla_ref"=>"cliente", "valor"=>$valIntercambio["id_cli"],"id_origen"=>$valIntercambio["id_concli"]));
                    }

                    if($arrayEspecie[$valIntercambio["id_esp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_cliente]", "tabla"=>"contrato_cliente", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_concli"]));
                    }

                    if($arrayEmpresa[$valIntercambio["id_emp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_cliente]", "tabla"=>"contrato_cliente", "campo"=>"id_emp","tabla_ref"=>"empresa", "valor"=>$valIntercambio["id_emp"],"id_origen"=>$valIntercambio["id_concli"]));
                    }

                }else{
                    // $sqlWeb = "SELECT * FROM contrato_cliente  WHERE id_concli_SAP = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_concli']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayContratoCliente[$valIntercambio["id_concli"]] = $valIntercambio["id_concli"];
                    // }
                }
            }
        }

       
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO contrato_cliente] => ".$error->getMessage()));
    }


    /* CONTRATO AGRICULTOR */
    try{

        $sqlWeb = "SELECT * FROM contrato_agricultor;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayContratoAgricultor[$data["id_cont_SAP"]] = $data["id_cont_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM contrato_agricultor;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // || $arrayEspecie[$valIntercambio["id_esp"]] == null
                if($arrayEmpresa[$valIntercambio["id_emp"]] == null || $arrayAgricultor[$valIntercambio["id_agric"]] == null || $arrayTemporada[$valIntercambio["id_tempo"]] == null ){

                    if($arrayEmpresa[$valIntercambio["id_emp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_agricultor]", "tabla"=>"contrato_agricultor", "campo"=>"id_emp","tabla_ref"=>"empresa", "valor"=>$valIntercambio["id_emp"],"id_origen"=>$valIntercambio["id_cont"]));
                    }
                    if($arrayAgricultor[$valIntercambio["id_agric"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_agricultor]", "tabla"=>"contrato_agricultor", "campo"=>"id_agric","tabla_ref"=>"agricultor", "valor"=>$valIntercambio["id_agric"],"id_origen"=>$valIntercambio["id_cont"]));
                    }
                    if($arrayTemporada[$valIntercambio["id_tempo"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_agricultor]", "tabla"=>"contrato_agricultor", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_cont"]));
                    }
                    // if($arrayEspecie[$valIntercambio["id_esp"]] == null){
                    //     array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA contrato_agricultor]", "tabla"=>"contrato_agricultor", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_cont"]));
                    // }

                }else{
                    // $sqlWeb = "SELECT * FROM contrato_agricultor  WHERE id_cont_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_cont']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayContratoAgricultor[$valIntercambio["id_cont"]] = $valIntercambio["id_cont"];
                    // }
                }
            }
        }
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO contrato_agricultor] => ".$error->getMessage()));
    }


    /* LOTE */
    try{

        $sqlWeb = "SELECT * FROM lote;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayLotes[$data["id_lote_SAP"]] = $data["id_lote_SAP"];
            }
    
        }

        $sqlDescarga = "SELECT * FROM lote;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if($arrayPredio[$valIntercambio["id_pred"]] == null || $arrayComuna[$valIntercambio["id_comuna"]] == null ){

                    if($arrayPredio[$valIntercambio["id_pred"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA lote]", "tabla"=>"lote", "campo"=>"id_pred","tabla_ref"=>"predio", "valor"=>$valIntercambio["id_pred"],"id_origen"=>$valIntercambio["id_lote"]));
                    }

                    if($arrayComuna[$valIntercambio["id_comuna"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA lote]", "tabla"=>"lote", "campo"=>"id_comuna","tabla_ref"=>"comuna", "valor"=>$valIntercambio["id_comuna"],"id_origen"=>$valIntercambio["id_lote"]));
                    }

                }else{
                    // $sqlWeb = "SELECT * FROM lote  WHERE id_lote_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_lote']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayLotes[$valIntercambio["id_lote"]] = $valIntercambio["id_lote"];
                    // }
                }   
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO lote] => ".$error->getMessage()));
    }


    /* DETALLE_QUOTATION */
    try{

        $sqlWeb = "SELECT * FROM detalle_quotation;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayDetalleQuotation[$data["id_de_quo_SAP"]] = $data["id_de_quo_SAP"];
            }
        }

        $sqlDescarga = "SELECT * FROM detalle_quotation;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){

                if($arrayQuotations[$valIntercambio["id_quotation"]] == null || $arrayMaterial[$valIntercambio["id_materiales"]] == null || $arrayMoneda[$valIntercambio["id_moneda"]] == null || $arrayIncoterms[$valIntercambio["id_incot"]] == null || $arrayTipoContrato[$valIntercambio["id_tipo_cont"]] == null || $arrayUM[$valIntercambio["id_um"]] == null  || $arrayTipoCertificacion[$valIntercambio["id_tipo_cert"]] == null || $arrayCondiciones[$valIntercambio["id_tipo_condicion"]] == null || $arrayTipoEnvase[$valIntercambio["id_tipo_envase"]] == null || $arrayTipoDespacho[$valIntercambio["id_tipo_desp"]] == null ){

                    if($arrayQuotations[$valIntercambio["id_quotation"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_quotation","tabla_ref"=>"quotation", "valor"=>$valIntercambio["id_quotation"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayMaterial[$valIntercambio["id_materiales"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_materiales","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_materiales"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayMoneda[$valIntercambio["id_moneda"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_moneda","tabla_ref"=>"moneda", "valor"=>$valIntercambio["id_moneda"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayIncoterms[$valIntercambio["id_incot"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_incot","tabla_ref"=>"incoterms", "valor"=>$valIntercambio["id_incot"],"id_origen"=>$valIntercambio["id_de_quo"]));  
                    }
                    if($arrayTipoContrato[$valIntercambio["id_tipo_cont"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_tipo_cont","tabla_ref"=>"tipo_contrato", "valor"=>$valIntercambio["id_tipo_cont"],"id_origen"=>$valIntercambio["id_de_quo"]));    
                    }
                    if($arrayUM[$valIntercambio["id_um"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_um","tabla_ref"=>"unidad_medida", "valor"=>$valIntercambio["id_um"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayTipoCertificacion[$valIntercambio["id_tipo_cert"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_tipo_cert","tabla_ref"=>"tipo_de_certificacion", "valor"=>$valIntercambio["id_tipo_cert"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayCondiciones[$valIntercambio["id_tipo_condicion"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_tipo_condicion","tabla_ref"=>"condicion", "valor"=>$valIntercambio["id_tipo_condicion"],"id_origen"=>$valIntercambio["id_de_quo"]));  
                    }
                    if($arrayTipoEnvase[$valIntercambio["id_tipo_envase"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_tipo_envase","tabla_ref"=>"tipo_de_envase", "valor"=>$valIntercambio["id_tipo_envase"],"id_origen"=>$valIntercambio["id_de_quo"]));
                    }
                    if($arrayTipoDespacho[$valIntercambio["id_tipo_desp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA detalle_quotation]", "tabla"=>"detalle_quotation", "campo"=>"id_tipo_desp","tabla_ref"=>"tipo_de_despacho", "valor"=>$valIntercambio["id_tipo_desp"],"id_origen"=>$valIntercambio["id_de_quo"])); 
                    }


                }else{
                    // $sqlWeb = "SELECT * FROM detalle_quotation  WHERE id_de_quo_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_de_quo']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayDetalleQuotation[$valIntercambio["id_de_quo"]] = $valIntercambio["id_de_quo"];
                    // }
                }
                
            }
        }


    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO detalle_quotation] => ".$error->getMessage()));
    }


    /* FICHA */
    try{

        $sqlWeb = "SELECT * FROM ficha;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayFicha[$data["id_ficha_SAP"]] = $data["id_ficha_SAP"];
            }
        }

        $sqlDescarga = "SELECT * FROM ficha;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $arrayQuotations[$val["id_usuario"]] == null ||

                if($arrayEstadoFicha[$valIntercambio["id_est_fic"]] == null || $arrayTemporada[$valIntercambio["id_tempo"]] == null || $arrayEspecie[$valIntercambio["id_esp"]] == null || $arrayAgricultor[$valIntercambio["id_agric"]] == null || $arrayComuna[$valIntercambio["id_comuna"]] == null  || $arrayPredio[$valIntercambio["id_pred"]] == null || $arrayLotes[$valIntercambio["id_lote"]] == null || $arrayTipoSuelo[$valIntercambio["id_tipo_suelo"]] == null || $arrayTipoRiego[$valIntercambio["id_tipo_riego"]] == null ){

                    if($arrayEstadoFicha[$valIntercambio["id_est_fic"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_est_fic","tabla_ref"=>"estado_ficha", "valor"=>$valIntercambio["id_est_fic"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayTemporada[$valIntercambio["id_tempo"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayEspecie[$valIntercambio["id_esp"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayAgricultor[$valIntercambio["id_agric"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_agric","tabla_ref"=>"agricultor", "valor"=>$valIntercambio["id_agric"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayComuna[$valIntercambio["id_comuna"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_comuna","tabla_ref"=>"comuna", "valor"=>$valIntercambio["id_comuna"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayPredio[$valIntercambio["id_pred"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_pred","tabla_ref"=>"predio", "valor"=>$valIntercambio["id_pred"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayLotes[$valIntercambio["id_lote"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_lote","tabla_ref"=>"lote", "valor"=>$valIntercambio["id_lote"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayTipoSuelo[$valIntercambio["id_tipo_suelo"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_tipo_suelo","tabla_ref"=>"tipo_suelo", "valor"=>$valIntercambio["id_tipo_suelo"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }
                    if($arrayTipoRiego[$valIntercambio["id_tipo_riego"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ficha]", "tabla"=>"ficha", "campo"=>"id_tipo_riego","tabla_ref"=>"tipo_riego", "valor"=>$valIntercambio["id_tipo_riego"],"id_origen"=>$valIntercambio["id_ficha"])); 
                    }

                }else{
                    // $sqlWeb = "SELECT * FROM ficha  WHERE id_ficha_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_ficha']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayFicha[$valIntercambio["id_ficha"]] = $valIntercambio["id_ficha"];
                    // }
                }
                
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO ficha] => ".$error->getMessage()));
    }
    /* historial_predio */
    try{

        $sqlWeb = "SELECT * FROM historial_predio;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayHistorialPredio[$data["id_his_pre_sap"]] = $data["id_his_pre"];
            }
        }

        $sqlDescarga = "SELECT * FROM historial_predio;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $valIntercambio){
                // $arrayQuotations[$val["id_usuario"]] == null ||

                if($arrayFicha[$valIntercambio["id_ficha"]] == null){

                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA historial_predio]", "tabla"=>"historial_predio", "campo"=>"id_ficha","tabla_ref"=>"ficha", "valor"=>$valIntercambio["id_ficha"],"id_origen"=>$valIntercambio["id_his_pre"])); 
                    
                }else{
                    // $sqlWeb = "SELECT * FROM ficha  WHERE id_ficha_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_ficha']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayHistorialPredio[$valIntercambio["id_his_pre"]] = $valIntercambio["id_his_pre"];
                    // }
                }
                
            }
        }

    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO historial_predio] => ".$error->getMessage()));
    }


    /* ANEXO_ CONTRATO */
    try{

        $sqlWeb = "SELECT * FROM anexo_contrato;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayAnexoContrato[$data["id_ac_SAP"]] = $data["id_ac_SAP"];
            }
        }
        
        $sqlDescarga = "SELECT * FROM anexo_contrato;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if($arrayContratoAgricultor[$valIntercambio["id_cont"]] == null || $arrayFicha[$valIntercambio["id_ficha"]] == null || $arrayLotes[$valIntercambio["id_lote"]] == null || $arrayMoneda[$valIntercambio["id_moneda"]] == null || $arrayMaterial[$valIntercambio["id_materiales"]] == null || $arrayUM[$valIntercambio["id_um"]] == null || $arrayDetalleQuotation[$valIntercambio["id_de_quo"]] == null ){

                    if($arrayContratoAgricultor[$valIntercambio["id_cont"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_cont","tabla_ref"=>"contrato_agricultor", "valor"=>$valIntercambio["id_cont"],"id_origen"=>$valIntercambio["id_ac"]));
                    }
                    if($arrayFicha[$valIntercambio["id_ficha"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_ficha","tabla_ref"=>"ficha", "valor"=>$valIntercambio["id_ficha"],"id_origen"=>$valIntercambio["id_ac"]));
                    }
                    if($arrayLotes[$valIntercambio["id_lote"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_lote","tabla_ref"=>"lote", "valor"=>$valIntercambio["id_lote"],"id_origen"=>$valIntercambio["id_ac"]));
                    }
                    if($arrayMoneda[$valIntercambio["id_moneda"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_moneda","tabla_ref"=>"moneda", "valor"=>$valIntercambio["id_moneda"],"id_origen"=>$valIntercambio["id_ac"]));
                    }
                    if($arrayMaterial[$valIntercambio["id_materiales"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_materiales","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_materiales"],"id_origen"=>$valIntercambio["id_ac"]));
                    }
                    if($arrayUM[$valIntercambio["id_um"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_um","tabla_ref"=>"unidad_medida", "valor"=>$valIntercambio["id_um"],"id_origen"=>$valIntercambio["id_ac"]));
                    }

                    if($arrayDetalleQuotation[$valIntercambio["id_de_quo"]] == null){
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA anexo_contrato]", "tabla"=>"anexo_contrato", "campo"=>"id_de_quo","tabla_ref"=>"detalle_quotation", "valor"=>$valIntercambio["id_de_quo"],"id_origen"=>$valIntercambio["id_ac"]));
                    }

                }else{
                    // $sqlWeb = "SELECT * FROM anexo_contrato  WHERE id_ac_SAP  = ?;";
                    // $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    // $consultaWeb->bindValue("1", $valIntercambio['id_ac']);
                    // $consultaWeb->execute();
                    
                    // if($consultaWeb->rowCount() <= 0){
                        $arrayAnexoContrato[$valIntercambio["id_ac"]] = $valIntercambio["id_ac"];
                    // }
                }              
            }
        }


    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO anexo_contrato] => ".$error->getMessage()));
    }


     /* EXPORT */
     try{

        $sqlWeb = "SELECT * FROM export;";
        $consultaWeb = $conexionWeb->prepare($sqlWeb);
        $consultaWeb->execute();
        if($consultaWeb->rowCount() > 0){
            $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $data){
                $arrayExport[$data["id_export_sap"]] = $data["id_export_sap"];
            }

        }

        $sqlDescarga = "SELECT * FROM export;";    
        $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
        $consultaDescarga->execute();
        if($consultaDescarga->rowCount() > 0){
            $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $valIntercambio){

                if( $arrayEspecie[$valIntercambio["id_esp"]] == null || 
                    $arrayCliente[$valIntercambio["id_cli"]] == null || 
                    $arrayMaterial[$valIntercambio["id_materiales"]] == null || 
                    $arrayTemporada[$valIntercambio["id_tempo"]] == null ||
                    $arrayAgricultor[$valIntercambio["id_agric"]] == null || 
                    $arrayAnexoContrato[$valIntercambio["id_ac"]] == null){
                    
                     if($arrayEspecie[$valIntercambio["id_esp"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_esp","tabla_ref"=>"especie", "valor"=>$valIntercambio["id_esp"],"id_origen"=>$valIntercambio["id_export"]));
                     }  

                     if($arrayCliente[$valIntercambio["id_cli"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_cli","tabla_ref"=>"cliente", "valor"=>$valIntercambio["id_cli"],"id_origen"=>$valIntercambio["id_export"]));
                     } 

                     if($arrayMaterial[$valIntercambio["id_materiales"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_materiales","tabla_ref"=>"materiales", "valor"=>$valIntercambio["id_materiales"],"id_origen"=>$valIntercambio["id_export"]));
                     } 

                     if($arrayTemporada[$valIntercambio["id_tempo"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_export"]));
                     } 


                     if($arrayAgricultor[$valIntercambio["id_agric"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_agric","tabla_ref"=>"agricultor", "valor"=>$valIntercambio["id_agric"],"id_origen"=>$valIntercambio["id_export"]));
                     } 


                     if($arrayAnexoContrato[$valIntercambio["id_ac"]] == null ) {
                        array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA export]", "tabla"=>"export", "campo"=>"id_ac","tabla_ref"=>"anexo_contrato", "valor"=>$valIntercambio["id_ac"],"id_origen"=>$valIntercambio["id_export"]));
                     } 
                    
                }else{
                        $arrayExport[$valIntercambio["id_export"]] = $valIntercambio["id_export"];
                }
            }
        }

        
    }catch(PDOException $error){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO export] => ".$error->getMessage()));
    }


    /*  AGRI PRED TEMP */
    if(sizeof($arrayRespuestaErronea) <= 0){

        try{
            $sqlDescarga = "SELECT * FROM agri_pred_temp;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);

                // echo var_dump($r);
                // break 2;

                foreach($r as $valIntercambio){
                    if($arrayAgricultor[$valIntercambio["id_agric"]] == null || $arrayTemporada[$valIntercambio["id_tempo"]] == null || $arrayPredio[$valIntercambio["id_pred"]] == null){

                        if($arrayAgricultor[$valIntercambio["id_agric"]] == null){
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA id_agric]", "tabla"=>"agri_pred_temp", "campo"=>"id_agric","tabla_ref"=>"agricultor", "valor"=>$valIntercambio["id_agric"],"id_origen"=>$valIntercambio["id_agri_pred_temp"]));
                        }

                        if($arrayTemporada[$valIntercambio["id_tempo"]] == null){
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA id_tempo]", "tabla"=>"agri_pred_temp", "campo"=>"id_tempo","tabla_ref"=>"temporada", "valor"=>$valIntercambio["id_tempo"],"id_origen"=>$valIntercambio["id_agri_pred_temp"]));
                        }

    
                        if($arrayPredio[$valIntercambio["id_pred"]] == null){
                            array_push($arrayRespuestaErronea, array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA id_pred]", "tabla"=>"agri_pred_temp", "campo"=>"id_pred","tabla_ref"=>"predio", "valor"=>$valIntercambio["id_pred"],"id_origen"=>$valIntercambio["id_agri_pred_temp"]));
                        }

                        
                    }
                }
            }

        }catch(PDOException $e){

            // MANEJO DE ERRORES
            $rollback = true;
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO agri_pred_temp] => ".$error->getMessage()));
            // break 2;
        }

    }



    $tiempo_finalTotal = microtime(true);
    $tiempoFinal = $tiempo_finalTotal - $tiempo_inicialTotal;
    $tiempoTotalMensaje = "Tiempo total ".round($tiempoFinal, 4)." segundos";

    if(sizeof($arrayRespuestaErronea) <= 0){
        echo json_encode(array("codigo" => 1, "mensaje"=>"ningun problema encontrado", "tiempo" => $tiempoTotalMensaje));
    }else{

        array_push($arrayRespuestaErronea, array("codigo" => 9, "mensaje" => $tiempoTotalMensaje));

        echo json_encode(array("codigo" => 2, "data" => $arrayRespuestaErronea));
    }



?>
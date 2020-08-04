<?php
    require_once '../../db/conectarse_db.php';


    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    ini_set('memory_limit', '2048M');

    $rutUsuario = (isset($_GET['rutUsuario'])) ? $_GET['rutUsuario'] : '18.804.066-7';
    $idCabecera = (isset($idCabecera)) ? $idCabecera : 0;


    $conexionWeb = new Conectar();
    $conexionWeb = $conexionWeb->conexion();

    $conexionDescarga = new Conectar();
    $conexionDescarga = $conexionDescarga->conexion_descarga();

    $tiempo_inicialTotal = microtime(true);

    $fechaHoraInicio = date('Y-m-d H:i:s');

    $arrayRespuestaErronea = array();
    $arrayErrorReferencia = array();
    $arrayOkTabla = array();

    $arrayUsuarioAnexos;
    $arrayFichasTemporadas;



    function ingresarHistorial($tabla, $campo, $dato, $tablaReferencia, $estado, $fechaHoraInicio, $rutUsuario, $idCabecera, $idOrigen){

        $conexionWeb = new Conectar();
        $conexionWeb = $conexionWeb->conexion();

        $mensaje = "";
        switch($estado){

            case 1 :
                $mensaje  = $dato;
            break;
            case 2 :
                $mensaje  = 'Registro con ID primaria  '.$idOrigen.'  tiene una  id referencial con valor ( '.$dato.' ) el cual no existe en tabla '.$tablaReferencia;
            break;
        }


        try{
            $fechaHoraFin = date('Y-m-d H:i:s');
            $sqlWeb = "INSERT INTO historial_registros_intermedios (tabla_involucrada, campo_involucrado, descripcion, estado, fecha_hora_inicio, user_tx, fecha_hora_fin, cabecera) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
            $movimientoWeb->bindValue("1", $tabla, PDO::PARAM_STR);
            $movimientoWeb->bindValue("2", $campo, PDO::PARAM_STR);
            $movimientoWeb->bindValue("3", $mensaje, PDO::PARAM_STR);
            $movimientoWeb->bindValue("4", $estado, PDO::PARAM_STR);
            $movimientoWeb->bindValue("5", $fechaHoraInicio, PDO::PARAM_STR);
            $movimientoWeb->bindValue("6", $rutUsuario, PDO::PARAM_STR);
            $movimientoWeb->bindValue("7", $fechaHoraFin,PDO::PARAM_STR);
            $movimientoWeb->bindValue("8", $idCabecera,PDO::PARAM_STR);
            $movimientoWeb->execute();

            if($movimientoWeb->rowCount() > 0){
                if($estado == 2){

                    return array("codigo" => 4, "mensaje" => "[ERROR REFERENCIA ".$tabla."]", "tabla"=>$tabla, "campo"=>$campo,"tabla_ref"=>$tablaReferencia, "valor"=>$dato,"id_origen"=>$idOrigen);
                    // array_push($arrayErrorReferencia, );
                }else{
                    return array("codigo" => 2, "mensaje" => $dato, "tabla"=>$tabla);
                    
                }
           
            }


        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT historial_registros_intermedios] => ".$error->getMessage()));
        }
    }


 

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
    $arrayPredioTemprada;
    $arrayHistorialPredio;

    $arrayUsuario;
    $arrayProvinciaRegion;
    // $arrayRegion;
    $arrayComunaProvicia;
    $arrayStockSemilla;
    $arrayExport;

    $comunasNuevas;


    $conexionWeb->beginTransaction();
    $rolback = false;
    //  $conexionWeb->("LOCK TABLES tbl_othercharge WRITE");
    // for($i = 0; $i < 5 ; $i++){

        // $varError = ($i > 3) ? "user_txe" : "user_tx";
        try{

            $sqlWeb = "INSERT INTO  cabecera_registros_intermedios (user_tx, fecha_hora_inicio) VALUES (?, ?) ";
            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
            $movimientoWeb->bindValue("1", $rutUsuario, PDO::PARAM_STR);
            $movimientoWeb->bindValue("2", $fechaHoraInicio, PDO::PARAM_STR);
            $movimientoWeb->execute();
    
            if($movimientoWeb->rowCount() > 0){
                $sqlWeb = "SELECT  MAX(id_cabecera) as max_id FROM cabecera_registros_intermedios WHERE fecha_hora_inicio = ?  LIMIT 1 ";
                $consultaWeb = $conexionWeb->prepare($sqlWeb);
                $consultaWeb->bindValue("1", $fechaHoraInicio, PDO::PARAM_STR);
                $consultaWeb->execute();
                if($consultaWeb->rowCount() > 0){
                    $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                    $idCabecera = $res[0]["max_id"] + 1;
                }
            }

        }catch(PDOException $error){
            $rolback = true;
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT cabecera_registros_intermedios] => ".$error->getMessage()));
        }

    // }

    if($rolback){
        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK cabecera_registros_intermedios] => ".$error->getMessage()));
        $conexionWeb->rollback();
    }else{
        $conexionWeb->commit();
    }

    // $db->query("UNLOCK TABLES");
    // var_dump($arrayRespuestaErronea);

    // die();




    $arrayQuotationDatos;

if($idCabecera > 0){

    
    /*  EMPRESA */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
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

    }
    
    /* USUARIOS */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        try{

            $sqlWeb = "SELECT * FROM usuarios ";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayUsuario[$data["rut"]] = $data["id_usuario"];
                }
            }
        
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR SELECT usuarios] => ".$error->getMessage()));
        }

    }


    /*  PROVINCIA  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        try{

            $sqlWeb = "SELECT * FROM provincia ";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayProvinciaRegion[$data["id_provincia"]] = $data["id_region"];
                }
            }
        
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR SELECT provincias] => ".$error->getMessage()));
        }

    }


    /* UNIDAD DE MEDIDA  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        
        $rolback = false;

        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM unidad_medida; ";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;
                // begin trasnsaction
                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM unidad_medida WHERE id_um_SAP  = ?; ";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_um']);
                    $consultaWeb->execute();
                    
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  unidad_medida SET id_um_SAP = ?,  nombre = ? WHERE id_um = ?;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_um"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_um"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                // rollback = true
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE unidad_medida] => ".$error->getMessage()));
                            }
                        
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO unidad_medida (id_um_SAP, nombre) VALUES(?, ?);";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_um"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            // rollback = true
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT unidad_medida] => ".$error->getMessage()));
                        }
                    }
                
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK unidad_medida] => c"));
                    $conexionWeb->rollback();
                }else{
                    // echo "commit...";
                    
                    $conexionWeb->commit();


                     /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;

                    array_push($arrayOkTabla,ingresarHistorial('unidad_medida', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                }
            }

            $sqlWeb = "SELECT * FROM unidad_medida;";
                $consultaWeb = $conexionWeb->prepare($sqlWeb);
                $consultaWeb->execute();
                if($consultaWeb->rowCount() > 0){
                    $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res as $data){
                        $arrayUM[$data["id_um_SAP"]] = $data["id_um"];
                    }
            
                }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO unidad_medida] => ".$error->getMessage()));
        }

    }


    /* TIPO DE DESPACHO  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_de_despacho;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                        $sqlWeb = "SELECT * FROM tipo_de_despacho WHERE id_tipo_desp_SAP  = ?; ";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_tipo_desp']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  tipo_de_despacho SET id_tipo_desp_SAP = ?, nombre = ? WHERE id_tipo_desp = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_tipo_desp"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $valWeb["id_tipo_desp"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_de_despacho] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO tipo_de_despacho (id_tipo_desp_SAP, nombre) VALUES(?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_desp"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_de_despacho] => ".$error->getMessage()));
                            }
                        }
                    }

                    if($rolback){
                        // echo "rolback...";
                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_de_despacho] => ".$error->getMessage()));
                        $conexionWeb->rollback();
                    }else{
                        // echo "commit...";
                        $conexionWeb->commit();
                        /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                        $datosTotales += ($datosInsertados + $datosUpdateados);
                        $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                        /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                        $tiempo_final = microtime(true);
                        $tiempo = $tiempo_final - $tiempo_inicial;
                        array_push($arrayOkTabla,ingresarHistorial('tipo_de_despacho', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                        
                    }                

            }

            $sqlWeb = "SELECT * FROM tipo_de_despacho;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoDespacho[$data["id_tipo_desp_SAP"]] = $data["id_tipo_desp"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_despacho] => ".$error->getMessage()));
        }
    }


    /* TIPO DE CERTIFICACION  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_de_certificacion;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                        $sqlWeb = "SELECT * FROM tipo_de_certificacion WHERE id_tipo_cert_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_tipo_cert']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  tipo_de_certificacion SET id_tipo_cert_SAP = ?, nombre = ? WHERE id_tipo_cert = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_tipo_cert"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $valWeb["id_tipo_cert"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_de_certificacion] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO tipo_de_certificacion (id_tipo_cert_SAP, nombre) VALUES(?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_cert"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_de_certificacion] => ".$error->getMessage()));
                            }
                        }
                    }

                    if($rolback){
                        // echo "rolback...";
                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_de_certificacion] => ".$error->getMessage()));
                        $conexionWeb->rollback();
                    }else{

                        $conexionWeb->commit();
                         /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                        $datosTotales += ($datosInsertados + $datosUpdateados);
                        $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                        /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                        $tiempo_final = microtime(true);
                        $tiempo = $tiempo_final - $tiempo_inicial;
                        array_push($arrayOkTabla,ingresarHistorial('tipo_de_certificacion', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                        
                    }

            }

            $sqlWeb = "SELECT * FROM tipo_de_certificacion;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoCertificacion[$data["id_tipo_cert_SAP"]] = $data["id_tipo_cert"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_certificacion] => ".$error->getMessage()));
        }
    }

    /* TEMPORADA  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        
        $rolback = false;
        try{

            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM temporada;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                        $sqlWeb = "SELECT * FROM temporada WHERE id_tempo_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_tempo'], PDO::PARAM_STR);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  temporada SET id_tempo_SAP = ?, nombre = ?, desde = ?, hasta = ? WHERE id_tempo = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_tempo"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["desde"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["hasta"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $valWeb["id_tempo"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE temporada] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO temporada (id_tempo_SAP, nombre, desde, hasta) VALUES(?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tempo"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["desde"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["hasta"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT temporada] => ".$error->getMessage()));
                            }
                        }
                    }

                    if($rolback){
                        // echo "rolback...";
                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK temporada] => ".$error->getMessage()));
                        $conexionWeb->rollback();
                    }else{

                        $conexionWeb->commit();

                        /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                        $datosTotales += ($datosInsertados + $datosUpdateados);
                        $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                        /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                        $tiempo_final = microtime(true);
                        $tiempo = $tiempo_final - $tiempo_inicial;
                        array_push($arrayOkTabla,ingresarHistorial('temporada', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                        

                    }
            }

            $sqlWeb = "SELECT * FROM temporada;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTemporada[$data["id_tempo_SAP"]] = $data["id_tempo"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO temporada] => ".$error->getMessage()));
        }
    }


    /* TIPO CONTRATO  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{

            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_contrato; ";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                        $sqlWeb = "SELECT * FROM tipo_contrato WHERE id_tipo_cont_SAP  = ?; ";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_tipo_cont']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  tipo_contrato SET id_tipo_cont_SAP = ?, descripcion = ? WHERE id_tipo_cont = ?; ";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_tipo_cont"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $valWeb["id_tipo_cont"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_contrato] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO tipo_contrato (id_tipo_cont_SAP, descripcion) VALUES(?, ?); ";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_cont"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_contrato] => ".$error->getMessage()));
                            }
                        }
                    }

                    if($rolback){
                        // echo "rolback...";
                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_contrato] => ".$error->getMessage()));
                        $conexionWeb->rollback();
                    }else{

                        $conexionWeb->commit();

                        /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                        $datosTotales += ($datosInsertados + $datosUpdateados);
                        $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                        /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                        $tiempo_final = microtime(true);
                        $tiempo = $tiempo_final - $tiempo_inicial;
                        array_push($arrayOkTabla,ingresarHistorial('tipo_contrato', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                       
                    }
            }

            $sqlWeb = "SELECT * FROM tipo_contrato;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoContrato[$data["id_tipo_cont_SAP"]] = $data["id_tipo_cont"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_contrato] => ".$error->getMessage()));
        }
    }


    /* TIPO SUELO  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{

            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_suelo ;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM tipo_suelo WHERE id_tipo_suelo_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_tipo_suelo']);
                    $consultaWeb->execute();
                    
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  tipo_suelo SET id_tipo_suelo_SAP = ?,  descripcion = ? WHERE id_tipo_suelo = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_suelo"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_tipo_suelo"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_suelo] => ".$error->getMessage()));
                            }
                        
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO tipo_suelo (id_tipo_suelo_SAP, descripcion) VALUES(?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_tipo_suelo"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_suelo] => ".$error->getMessage()));
                        }
                    }
                
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_suelo] => ".$error->getMessage()));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('tipo_suelo', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }
               
            }

            $sqlWeb = "SELECT * FROM tipo_suelo ;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoSuelo[$data["id_tipo_suelo_SAP"]] = $data["id_tipo_suelo"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_suelo] => ".$error->getMessage()));
        }
    }

    /* TIPO RIEGO  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{


            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_riego;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM tipo_riego WHERE id_tipo_riego_SAP  = ?;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_tipo_riego']);
                    $consultaWeb->execute();
                    
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  tipo_riego SET id_tipo_riego_SAP = ?,  descripcion = ? WHERE id_tipo_riego = ?;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_riego"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_tipo_riego"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_riego] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO tipo_riego (id_tipo_riego_SAP, descripcion) VALUES(?, ?);";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_tipo_riego"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["descripcion"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_riego] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_suelo] => ".$error->getMessage()));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                     /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('tipo_riego', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));
                    
                    

                }
               
            }

            $sqlWeb = "SELECT * FROM tipo_riego;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoRiego[$data["id_tipo_riego_SAP"]] = $data["id_tipo_riego"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_riego] => ".$error->getMessage()));
        }
    }

    /* ESPECIE  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{

            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM especie; ";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM especie WHERE id_esp_SAP  = ?;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_esp']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  especie SET id_esp_SAP = ?,  nombre = ? WHERE id_esp = ?;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_esp"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_esp"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE especie] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO especie (id_esp_SAP, nombre) VALUES(?, ?);";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_esp"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT especie] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK especie] => ".$error->getMessage()));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('especie', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    

                }

                

            }

            $sqlWeb = "SELECT * FROM especie;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayEspecie[$data["id_esp_SAP"]] = $data["id_esp"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO especie] => ".$error->getMessage()));
        }
    }

    /* PAIS  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{


            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM pais;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM pais WHERE id_pais_SAP  = ?;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_pais']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  pais SET id_pais_SAP = ?,  nombre = ?,  continente = ?,  mercado = ? WHERE id_pais = ? ; ";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_pais"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["continente"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["mercado"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $valWeb["id_pais"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE pais] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO pais (id_pais_SAP, nombre, continente, mercado) VALUES(?, ?, ?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_pais"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("3", $val["continente"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("4", $val["mercado"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT pais] => ".$error->getMessage()));
                        }
                    }
                    
                }


                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK pais] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                     /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('pais', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                   

                }
            }

            $sqlWeb = "SELECT * FROM pais;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayPais[$data["id_pais_SAP"]] = $data["id_pais"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO pais] => ".$error->getMessage()));
        }
    }


    /* MONEDA  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{


            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM moneda;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM moneda WHERE id_moneda_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_moneda']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  moneda SET id_moneda_SAP = ?,  nombre = ? WHERE id_moneda = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_moneda"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_moneda"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE moneda] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO moneda (id_moneda_SAP, nombre) VALUES(?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_moneda"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT moneda] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK moneda] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('moneda', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }
            }

            $sqlWeb = "SELECT * FROM moneda;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayMoneda[$data["id_moneda_SAP"]] = $data["id_moneda"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO moneda] => ".$error->getMessage()));
        }
    }


    /* INCOTERMS  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{


            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM incoterms;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM incoterms WHERE id_incot_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_incot']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  incoterms SET id_incot_SAP = ?,  nombre = ?,  descripcion = ? WHERE id_incot = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_incot"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["descripcion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $valWeb["id_incot"], PDO::PARAM_INT);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE incoterms] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO incoterms (id_incot_SAP, nombre, descripcion) VALUES(?, ?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_incot"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("3", $val["descripcion"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT incoterms] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK incoterms] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                     /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('incoterms', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                
                }
            }

            $sqlWeb = "SELECT * FROM incoterms;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayIncoterms[$data["id_incot_SAP"]] = $data["id_incot"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO incoterms] => ".$error->getMessage()));
        }
    }



    /* ESTADO FICHA  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM estado_ficha;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;
                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM estado_ficha WHERE id_est_fic_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_est_fic']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  estado_ficha SET id_est_fic_SAP = ?,  nombre = ? WHERE id_est_fic = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_est_fic"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_est_fic"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  UPDATE estado_ficha] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO estado_ficha (id_est_fic_SAP, nombre) VALUES(?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_est_fic"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT estado_ficha] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK estado_ficha] => c"));
                    $conexionWeb->rollback();
                }else{
                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('estado_ficha', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }
            }

            $sqlWeb = "SELECT * FROM estado_ficha;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayEstadoFicha[$data["id_est_fic_SAP"]] = $data["id_est_fic"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO estado_ficha] => ".$error->getMessage()));
        }
    }

    /* CONDICION */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM condicion;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM condicion WHERE id_tipo_condicion_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_tipo_condicion']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  condicion SET id_tipo_condicion_SAP = ?,  nombre = ? WHERE id_tipo_condicion = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_condicion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_tipo_condicion"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  UPDATE condicion] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO condicion (id_tipo_condicion_SAP, nombre) VALUES(?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_tipo_condicion"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  INSERT condicion] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK condicion] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('condicion', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

            }

            $sqlWeb = "SELECT * FROM condicion;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayCondiciones[$data["id_tipo_condicion_SAP"]] = $data["id_tipo_condicion"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO condicion] => ".$error->getMessage()));
        }
    }

    /* COMUNA */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM comuna;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    $sqlWeb = "SELECT * FROM comuna WHERE id_comuna_SAP  = ? ;";
                    $consultaWeb = $conexionWeb->prepare($sqlWeb);
                    $consultaWeb->bindValue("1", $val['id_comuna']);
                    $consultaWeb->execute();
                    
                    if($consultaWeb->rowCount() > 0){

                        $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rWeb as $valWeb){
                            /* update */
                            try{
                                $sqlWeb = "UPDATE  comuna SET id_comuna_SAP = ?,  nombre = ? WHERE id_comuna = ? ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_comuna"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                                // $movimientoWeb->bindValue("3", "1", PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $valWeb["id_comuna"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas updateadas */
                                $datosUpdateados += $movimientoWeb->rowCount();

                              


                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  UPDATE comuna] => ".$error->getMessage()));
                            }
                            
                        }

                    }else{
                        /* insert */
                        try{
                            $sqlWeb = "INSERT INTO comuna (id_comuna_SAP, nombre, id_provincia) VALUES(?, ?, ?) ;";
                            $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                            $movimientoWeb->bindValue("1", $val["id_comuna"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("2", $val["nombre"], PDO::PARAM_STR);
                            $movimientoWeb->bindValue("3", "1", PDO::PARAM_STR);
                            $movimientoWeb->execute();
                            /*  contar filas insertar */
                            $datosInsertados += $movimientoWeb->rowCount();

                            $comunasNuevas.= "NUEVA COMUNA ID SAP ( ".$val["id_comuna"]." ) NOMBRE ( ".$val["nombre"]." ) \n";
                            
                        }catch(PDOException $error){
                            $rolback = true;
                            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  UPDATE comuna] => ".$error->getMessage()));
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK condicion] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();
                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('comuna', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    

                }

                

            }

            $sqlWeb = "SELECT * FROM comuna;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayComuna[$data["id_comuna_SAP"]] = $data["id_comuna"];

                    $arrayComunaProvicia[$data["id_comuna_SAP"]] = $data["id_provincia"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO comuna] => ".$error->getMessage()));
        }
    }

    /*  TABLAS CON REFERENCIAS */

    /* MATERIALES  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM materiales ;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayEspecie[$val["id_esp"]] == null){
                        /* manejo de errores */
                        array_push($arrayErrorReferencia,ingresarHistorial('materiales', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_materiales"]));
                    }else{

                        /*  existe y se debe proceder de forma normal */
                        $sqlWeb = "SELECT * FROM materiales WHERE id_materiales_SAP  = ? ;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_materiales'], PDO::PARAM_STR);
                        $consultaWeb->execute();
                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  materiales SET id_materiales_SAP = ?, id_esp = ?, nom_fantasia = ?, nom_hibrido = ?, p_hembra = ?, p_macho = ? WHERE id_materiales = ? ;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_materiales"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["nom_fantasia"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["nom_hibrido"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["p_hembra"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["p_macho"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $valWeb["id_materiales"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" =>"[ERROR UPDATE materiales] => ".$error->getMessage()));
                                }
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO materiales (id_materiales_SAP, id_esp, nom_fantasia, nom_hibrido,  p_hembra, p_macho) VALUES(?, ?, ?, ?, ?, ?); ";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_materiales"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["nom_fantasia"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["nom_hibrido"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["p_hembra"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["p_macho"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" =>"[ERROR INSERT materiales] => ".$error->getMessage()));
                            }
                        }
                    }
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK materiales] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('materiales', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));


                    

                }

               
                
            }

            $sqlWeb = "SELECT * FROM materiales;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayMaterial[$data["id_materiales_SAP"]] = $data["id_materiales"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR  PROCESO materiales] => ".$error->getMessage()));
        }
    }
    
    /* TIPO DE ENVASE  */
    if(sizeof($arrayRespuestaErronea) <= 0){
       

        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM tipo_de_envase;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayMaterial[$val["id_materiales"]] == null || $arrayUM[$val["id_um"]] == null){

                        if($arrayMaterial[$val["id_materiales"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('tipo_de_envase', 'id_materiales',$val["id_materiales"], 'materiales', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_tipo_envase"]));
                        }


                        if($arrayUM[$val["id_um"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('tipo_de_envase', 'id_um',$val["id_um"], 'unidad_medida', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_tipo_envase"]));
                        }


                    }else{
                        $sqlWeb = "SELECT * FROM tipo_de_envase WHERE id_tipo_envase_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_tipo_envase']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  tipo_de_envase SET id_tipo_envase_SAP = ?, id_um = ?, id_materiales = ?, nombre = ?, neto = ?, bruto = ? WHERE id_tipo_envase = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_tipo_envase"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["neto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["bruto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $valWeb["id_tipo_envase"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE tipo_de_envase] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO tipo_de_envase (id_tipo_envase_SAP, id_um, id_materiales, nombre, neto, bruto) VALUES(?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_tipo_envase"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["neto"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["bruto"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT tipo_de_envase] => ".$error->getMessage()));
                            }
                        }
                    }


                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_de_envase] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('tipo_de_envase', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

            }

            $sqlWeb = "SELECT * FROM tipo_de_envase;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayTipoEnvase[$data["id_tipo_envase_SAP"]] = $data["id_tipo_envase"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO tipo_de_envase] => ".$error->getMessage()));
        }
    }

    /* CLIENTE */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM cliente;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayPais[$val["id_pais"]] == null){
                        array_push($arrayErrorReferencia,ingresarHistorial('cliente', 'id_pais',$val["id_pais"], 'pais', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_cli"]));
                    }else{

                        $sqlWeb = "SELECT * FROM cliente WHERE id_cli_SAP  = ? ;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_cli']);
                        $consultaWeb->execute();


                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  cliente SET id_cli_SAP = ?,  id_pais = ?,  rut_cliente = ?,  razon_social = ?,  telefono = ?,  email = ?,  ciudad = ?,  direccion = ?,  contacto = ?,  tel_contacto = ?,  rep_legal = ?,  rut_rl = ?,  telefono_rl = ?,  email_rl = ? WHERE id_cli = ? ;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_cli"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayPais[$val["id_pais"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["rut_cliente"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["razon_social"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["telefono"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["email"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $val["ciudad"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $val["direccion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $val["contacto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $val["tel_contacto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("11", $val["rep_legal"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("12", $val["rut_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("13", $val["telefono_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("14", $val["email_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("15", $valWeb["id_cli"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE cliente] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO cliente (id_cli_SAP,  id_pais,  rut_cliente,  razon_social,  telefono,  email,  ciudad,  direccion,  contacto,  tel_contacto,  rep_legal,  rut_rl,  telefono_rl,  email_rl) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_cli"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayPais[$val["id_pais"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["rut_cliente"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["razon_social"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["telefono"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["email"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $val["ciudad"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $val["direccion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $val["contacto"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("10", $val["tel_contacto"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("11", $val["rep_legal"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("12", $val["rut_rl"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("13", $val["telefono_rl"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("14", $val["email_rl"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT cliente] => ".$error->getMessage()));
                            }
                        }
                    }
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK tipo_de_envase] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('cliente', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

               

            }

            $sqlWeb = "SELECT * FROM cliente;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayCliente[$data["id_cli_SAP"]] = $data["id_cli"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cliente] => ".$error->getMessage()));
        }
    }




     /* stock_semillas */
     if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM stock_semillas;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if( $arrayEspecie[$val["id_esp"]] == null || 
                        $arrayCliente[$val["id_cli"]] == null || 
                        $arrayMaterial[$val["id_materiales"]] == null || 
                        $arrayTemporada[$val["id_tempo"]] == null){

                        if($arrayEspecie[$val["id_esp"]] == null ) {
                      
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_stock_semilla"]));
                        } 

                        if($arrayCliente[$val["id_cli"]] == null ) {

                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_cli',$val["id_cli"], 'cliente', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_stock_semilla"]));
                        } 

                        if($arrayMaterial[$val["id_materiales"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_materiales',$val["id_materiales"], 'materiales', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_stock_semilla"]));
                        } 

                        if($arrayTemporada[$val["id_tempo"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_stock_semilla"]));
                        } 


                        
                    }else{

                        $sqlWeb = "SELECT * FROM stock_semillas WHERE id_stock_semilla_sap  = ? ;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_stock_semilla']);
                        $consultaWeb->execute();


                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  stock_semillas SET 
                                    id_stock_semilla_sap = :id_stock_semilla,  
                                    id_esp = :id_esp,  
                                    fecha_recepcion = :fecha_recepcion,  
                                    id_cli = :id_cli,  
                                    id_materiales = :id_materiales,  
                                    genetic = :genetic,  
                                    trait = :trait,  
                                    sag_resolution_number = :sag_resolution_number,  
                                    curimapu_batch_number = :curimapu_batch_number,  
                                    customer_batch = :customer_batch,  
                                    quantity_kg = :quantity_kg,  
                                    notes = :notes,  
                                    seed_treated_by = :seed_treated_by,  
                                    curimapu_treated_by = :curimapu_treated_by,  
                                    customer_tsw = :customer_tsw, 
                                    customer_germ_porcentaje = :customer_germ_porcentaje, 
                                    tsw = :tsw, 
                                    curimapu_germ_porcentaje = :curimapu_germ_porcentaje,
                                    id_tempo = :id_tempo
                                    WHERE id_stock_semilla = :id_stock_semilla ;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue(":id_stock_semilla", $val["id_stock_semilla"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_esp", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":fecha_recepcion", $val["fecha_recepcion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_cli",  $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_materiales", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":genetic", $val["genetic"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":trait", $val["trait"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":sag_resolution_number", $val["sag_resolution_number"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":curimapu_batch_number", $val["curimapu_batch_number"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":customer_batch", $val["customer_batch"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":quantity_kg", $val["quantity_kg"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":notes", $val["notes"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":seed_treated_by", $val["seed_treated_by"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":curimapu_treated_by", $val["curimapu_treated_by"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":customer_tsw", $val["customer_tsw"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":customer_germ_porcentaje", $val["customer_germ_porcentaje"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":tsw", $val["tsw"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":curimapu_germ_porcentaje", $val["curimapu_germ_porcentaje"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_tempo", $val["id_tempo"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_stock_semilla", $valWeb["id_stock_semilla"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE stock_semillas] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO stock_semillas (
                                id_stock_semilla_sap,  
                                id_esp,  
                                fecha_recepcion,  
                                id_cli,  
                                id_materiales,  
                                genetic,  
                                trait,  
                                sag_resolution_number,  
                                curimapu_batch_number,  
                                customer_batch,  
                                quantity_kg,  
                                notes,  
                                seed_treated_by,  
                                curimapu_treated_by,  
                                customer_tsw, 
                                customer_germ_porcentaje, 
                                tsw, 
                                curimapu_germ_porcentaje,
                                id_tempo ) 
                                VALUES(
                                :id_stock_semilla,  
                                :id_esp,  
                                :fecha_recepcion,  
                                :id_cli,  
                                :id_materiales,  
                                :genetic,  
                                :trait,  
                                :sag_resolution_number,  
                                :curimapu_batch_number,  
                                :customer_batch,  
                                :quantity_kg,  
                                :notes,  
                                :seed_treated_by,  
                                :curimapu_treated_by,  
                                :customer_tsw, 
                                :customer_germ_porcentaje, 
                                :tsw, 
                                :curimapu_germ_porcentaje,
                                :id_tempo ) ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue(":id_stock_semilla", $val["id_stock_semilla"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_esp", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":fecha_recepcion", $val["fecha_recepcion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_cli",  $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_materiales", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":genetic", $val["genetic"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":trait", $val["trait"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":sag_resolution_number", $val["sag_resolution_number"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":curimapu_batch_number", $val["curimapu_batch_number"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":customer_batch", $val["customer_batch"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":quantity_kg", $val["quantity_kg"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":notes", $val["notes"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":seed_treated_by", $val["seed_treated_by"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":curimapu_treated_by", $val["curimapu_treated_by"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":customer_tsw", $val["customer_tsw"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":customer_germ_porcentaje", $val["customer_germ_porcentaje"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":tsw", $val["tsw"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":curimapu_germ_porcentaje", $val["curimapu_germ_porcentaje"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_tempo", $val["id_tempo"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT stock_semillas] => ".$error->getMessage()));
                            }
                        }
                    }
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK stock_semillas] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('stock_semillas', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

               

            }

            $sqlWeb = "SELECT * FROM stock_semillas;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayStockSemilla[$data["id_stock_semilla_sap"]] = $data["id_stock_semilla"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cliente] => ".$error->getMessage()));
        }
    }




   

    /* AGRICULTOR */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM agricultor;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayComuna[$val["id_comuna"]] == null){
                        array_push($arrayErrorReferencia,ingresarHistorial('agricultor', 'id_comuna',$val["id_comuna"], 'comuna', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_agric"]));
                    }else{
                        $sqlWeb = "SELECT * FROM agricultor WHERE id_agric_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_agric']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  agricultor SET id_agric_SAP = ?, id_comuna = ?, rut = ?, razon_social = ?, telefono = ?, email = ?, direccion = ?, banco = ?, cuenta_corriente = ?, rep_legal = ?, telefono_rl = ?, email_rl = ?, rut_rl = ?, id_region = ? WHERE id_agric = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_agric"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["rut"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["razon_social"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["telefono"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["email"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $val["direccion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $val["banco"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $val["cuenta_corriente"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $val["rep_legal"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("11", $val["telefono_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("12", $val["email_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("13", $val["rut_rl"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("14", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("15", $valWeb["id_agric"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE agricultor] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO agricultor (id_agric_SAP, id_comuna, rut, razon_social, telefono, email, direccion, banco, cuenta_corriente, rep_legal, telefono_rl, email_rl, rut_rl, id_region) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_agric"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["rut"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["razon_social"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["telefono"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["email"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $val["direccion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $val["banco"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $val["cuenta_corriente"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("10", $val["rep_legal"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("11", $val["telefono_rl"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("12", $val["email_rl"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("13", $val["rut_rl"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("14", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT agricultor] => ".$error->getMessage()));
                            }
                        }
                    }  
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK agricultor] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();


                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('agricultor', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

            }

            $sqlWeb = "SELECT * FROM agricultor;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayAgricultor[$data["id_agric_SAP"]] = $data["id_agric"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO agricultor] => ".$error->getMessage()));
        }
    }




    /* QUOTATIONS */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM quotation;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayCliente[$val["id_cli"]] == null || $arrayEspecie[$val["id_esp"]] == null || $arrayTemporada[$val["id_tempo"]] == null){

                        

                        if($arrayCliente[$val["id_cli"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('quotation', 'id_cli',$val["id_cli"], 'cliente', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_quotation"]));
                        }

                        if($arrayEspecie[$val["id_esp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('quotation', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_quotation"]));
                        }

                        if($arrayTemporada[$val["id_tempo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('quotation', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_quotation"]));
                        }

                    }else{
                        $sqlWeb = "SELECT * FROM quotation WHERE id_quotation_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_quotation']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  quotation SET id_quotation_SAP = ?, id_cli = ?, id_esp = ?, id_tempo = ?, numero_contrato = ?, obs = ? WHERE id_quotation = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_quotation"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["numero_contrato"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["obs"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $valWeb["id_quotation"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE quotation] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO quotation (id_quotation_SAP, id_cli, id_esp, id_tempo, numero_contrato, obs) VALUES(?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_quotation"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["numero_contrato"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["obs"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT quotation] => ".$error->getMessage()));
                            }
                        }
                    }


                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK quotation] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                     /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('quotation', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    

                }

            }

            $sqlWeb = "SELECT * FROM quotation;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayQuotations[$data["id_quotation_SAP"]] = $data["id_quotation"];
                    $arrayQuotationDatos[$data["id_cli"]."__".$data["id_esp"]."__".$data["id_tempo"]] = $data["id_cli"]."__".$data["id_esp"]."__".$data["id_tempo"];
                    $arrayQuotationCliente[$data["id_cli"]] = $data["id_cli"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO quotation] => ".$error->getMessage()));
        }
    }

    /* PREDIO */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM predio;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if( $arrayComuna[$val["id_comuna"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('predio', 'id_comuna',$val["id_comuna"], 'comuna', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_pred"]));
                    }else{
                        $sqlWeb = "SELECT * FROM predio WHERE id_pred_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_pred']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  predio SET id_pred_SAP = ?, id_comuna = ?, nombre = ?, id_region = ? WHERE id_pred = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_pred"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $valWeb["id_pred"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE predio] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO predio (id_pred_SAP, id_comuna, nombre, id_region) VALUES(?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_pred"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT predio] => ".$error->getMessage()));
                            }
                        }
                    }


                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK predio] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('predio', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                   
                }

               

            }

            $sqlWeb = "SELECT * FROM predio;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayPredio[$data["id_pred_SAP"]] = $data["id_pred"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO predio] => ".$error->getMessage()));
        }
    }

    /* CONTRATO CLIENTE */
    if(sizeof($arrayRespuestaErronea) <= 0){
       

        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM contrato_cliente;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;
                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayCliente[$val["id_cli"]] == null || $arrayEspecie[$val["id_esp"]] == null || $arrayEmpresa[$val["id_emp"]] == null){

                        if($arrayCliente[$val["id_cli"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_cliente', 'id_cli',$val["id_cli"], 'cliente', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_concli"]));
                        }

                        if($arrayEspecie[$val["id_esp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_cliente', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_concli"]));
                        }

                        if($arrayEmpresa[$val["id_emp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_cliente', 'id_emp',$val["id_emp"], 'empresa', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_concli"]));
                        }

                    }else{
                        $sqlWeb = "SELECT * FROM contrato_cliente  WHERE id_concli_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_concli']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  contrato_cliente  SET id_concli_SAP = ?, id_cli = ?, id_emp = ?, id_esp = ? WHERE id_concli = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_concli"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayEmpresa[$val["id_emp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $valWeb["id_concli"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE contrato_cliente] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO contrato_cliente  (id_concli_SAP, id_cli, id_emp, id_esp) VALUES(?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_concli"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayEmpresa[$val["id_emp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT contrato_cliente] => ".$error->getMessage()));
                            }
                        }
                    }


                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK contrato_cliente] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('contrato_cliente', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    

                }

            }

            $sqlWeb = "SELECT * FROM contrato_cliente;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayContratoCliente[$data["id_concli_SAP"]] = $data["id_concli"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO contrato_cliente] => ".$error->getMessage()));
        }
    }

    /* CONTRATO AGRICULTOR */
    if(sizeof($arrayRespuestaErronea) <= 0){
       

        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM contrato_agricultor;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    // $arrayEmpresa[$val["id_emp"]] == null || || $arrayEspecie[$val["id_esp"]] == null
                    if($arrayAgricultor[$val["id_agric"]] == null || $arrayTemporada[$val["id_tempo"]] == null ){

                        if($arrayEmpresa[$val["id_emp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_agricultor', 'id_emp',$val["id_emp"], 'empresa', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_cont"]));
                        }
                        if($arrayAgricultor[$val["id_agric"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_agricultor', 'id_agric',$val["id_agric"], 'agricultor', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_cont"]));
                        }
                        if($arrayTemporada[$val["id_tempo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('contrato_agricultor', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_cont"]));
                        }
                        // if($arrayEspecie[$val["id_esp"]] == null){
                        //     array_push($arrayErrorReferencia,ingresarHistorial('contrato_agricultor', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_cont"]));
                        // }

                    }else{
                        $sqlWeb = "SELECT * FROM contrato_agricultor  WHERE id_cont_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_cont']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  contrato_agricultor  SET id_cont_SAP = ?, id_emp = ?, id_agric = ?, id_tempo = ? , id_esp = ?, num_contrato = ? WHERE id_cont = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_cont"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayEmpresa[$val["id_emp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["num_contrato"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $valWeb["id_cont"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE contrato_agricultor] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO contrato_agricultor (id_cont_SAP, id_emp, id_agric, id_tempo , id_esp, num_contrato) VALUES(?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_cont"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayEmpresa[$val["id_emp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["num_contrato"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT contrato_agricultor] => ".$error->getMessage()));
                            }
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK contrato_cliente] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('contrato_agricultor', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));


                   
                }

            }

            $sqlWeb = "SELECT * FROM contrato_agricultor;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayContratoAgricultor[$data["id_cont_SAP"]] = $data["id_cont"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO contrato_agricultor] => ".$error->getMessage()));
        }
    }

    /* LOTE */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM lote;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayPredio[$val["id_pred"]] == null || $arrayComuna[$val["id_comuna"]] == null ){

                        if($arrayPredio[$val["id_pred"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('lote', 'id_pred',$val["id_pred"], 'predio', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_lote"]));
                        }

                        if($arrayComuna[$val["id_comuna"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('lote', 'id_comuna',$val["id_comuna"], 'comuna', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_lote"]));
                        }

                    }else{
                        $sqlWeb = "SELECT * FROM lote  WHERE id_lote_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_lote']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){
        
                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  lote  SET id_lote_SAP = ?, id_pred = ?, id_comuna = ?, nombre = ?, coo_utm_ampros = ? , nombre_ac = ?, telefono_ac = ?, radio = ?, id_region = ? WHERE id_lote = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_lote"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayPredio[$val["id_pred"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["nombre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $val["coo_utm_ampros"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $val["nombre_ac"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $val["telefono_ac"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $val["radio"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $valWeb["id_lote"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE lote] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO lote (id_lote_SAP, id_comuna, id_pred, nombre, coo_utm_ampros , nombre_ac, telefono_ac, radio, id_region) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_lote"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayPredio[$val["id_pred"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["nombre"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["coo_utm_ampros"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $val["nombre_ac"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $val["telefono_ac"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $val["radio"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $arrayProvinciaRegion[$arrayComunaProvicia[$val["id_comuna"]]], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT lote] => ".$error->getMessage()));
                            }
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK lote] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('lote', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));
                }

            }

            $sqlWeb = "SELECT * FROM lote;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayLotes[$data["id_lote_SAP"]] = $data["id_lote"];
                }
        
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO lote] => ".$error->getMessage()));
        }
    }

    /* DETALLE_QUOTATION */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM detalle_quotation;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayQuotations[$val["id_quotation"]] == null || $arrayMaterial[$val["id_materiales"]] == null || $arrayMoneda[$val["id_moneda"]] == null || $arrayIncoterms[$val["id_incot"]] == null || $arrayTipoContrato[$val["id_tipo_cont"]] == null || $arrayUM[$val["id_um"]] == null  || $arrayTipoCertificacion[$val["id_tipo_cert"]] == null || $arrayCondiciones[$val["id_tipo_condicion"]] == null || $arrayTipoEnvase[$val["id_tipo_envase"]] == null || $arrayTipoDespacho[$val["id_tipo_desp"]] == null ){

                        if($arrayQuotations[$val["id_quotation"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_quotation',$val["id_quotation"], 'quotation', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayMaterial[$val["id_materiales"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_materiales',$val["id_materiales"], 'materiales', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayMoneda[$val["id_moneda"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_moneda',$val["id_moneda"], 'moneda', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayIncoterms[$val["id_incot"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_incot',$val["id_incot"], 'incoterms', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayTipoContrato[$val["id_tipo_cont"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_tipo_cont',$val["id_tipo_cont"], 'tipo_contrato', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayUM[$val["id_um"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_um',$val["id_um"], 'unidad_medida', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayTipoCertificacion[$val["id_tipo_cert"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_tipo_cert',$val["id_tipo_cert"], 'tipo_de_certificacion', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayCondiciones[$val["id_tipo_condicion"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_tipo_condicion',$val["id_tipo_condicion"], 'condicion', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayTipoEnvase[$val["id_tipo_envase"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_tipo_envase',$val["id_tipo_envase"], 'tipo_de_envase', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }
                        if($arrayTipoDespacho[$val["id_tipo_desp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('detalle_quotation', 'id_tipo_desp',$val["id_tipo_desp"], 'tipo_de_despacho', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_de_quo"]));
                        }


                    }else{
                        $sqlWeb = "SELECT * FROM detalle_quotation  WHERE id_de_quo_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_de_quo']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  detalle_quotation  SET id_de_quo_SAP = ?,  id_quotation = ?, id_materiales = ?,  id_moneda = ?, id_incot = ?, id_tipo_cont = ?, id_um = ?, id_tipo_cert = ?, id_tipo_condicion = ?, id_tipo_envase = ?, id_tipo_desp = ?, superficie_contr = ?, precio = ?, observaciones_del_precio = ?, kg_contratados = ?, kgxha = ?, humedad = ?, germinacion = ?,  pureza_genetica = ?, fecha_recep_sem =?, pureza_fisica =?, fecha_despacho = ?,  maleza = ?, declaraciones = ?, kg_por_envase = ?, enfermedades = ?  WHERE id_de_quo = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_de_quo"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayQuotations[$val["id_quotation"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayMoneda[$val["id_moneda"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $arrayIncoterms[$val["id_incot"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $arrayTipoContrato[$val["id_tipo_cont"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $arrayTipoCertificacion[$val["id_tipo_cert"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $arrayCondiciones[$val["id_tipo_condicion"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $arrayTipoEnvase[$val["id_tipo_envase"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("11", $arrayTipoDespacho[$val["id_tipo_desp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("12", $val["superficie_contr"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("13", $val["precio"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("14", $val["observaciones_del_precio"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("15", $val["kg_contratados"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("16", $val["kgxha"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("17", $val["humedad"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("18", $val["germinacion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("19", $val["pureza_genetica"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("20", $val["fecha_recep_sem"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("21", $val["pureza_fisica"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("22", $val["fecha_despacho"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("23", $val["maleza"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("24", $val["declaraciones"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("25", $val["kg_por_envase"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("26", $val["enfermedades"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("27", $valWeb["id_de_quo"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE detalle_quotation] => ".$error->getMessage()));
                                }
                                
                            }

                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO detalle_quotation (id_de_quo_SAP,  id_quotation, id_materiales,  id_moneda, id_incot, id_tipo_cont, id_um, id_tipo_cert, id_tipo_condicion, id_tipo_envase, id_tipo_desp, superficie_contr, precio, observaciones_del_precio, kg_contratados, kgxha, humedad, germinacion,  pureza_genetica, fecha_recep_sem, pureza_fisica, fecha_despacho,  maleza, declaraciones, kg_por_envase, enfermedades) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_de_quo"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayQuotations[$val["id_quotation"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayMoneda[$val["id_moneda"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $arrayIncoterms[$val["id_incot"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $arrayTipoContrato[$val["id_tipo_cont"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $arrayTipoCertificacion[$val["id_tipo_cert"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $arrayCondiciones[$val["id_tipo_condicion"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("10", $arrayTipoEnvase[$val["id_tipo_envase"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("11", $arrayTipoDespacho[$val["id_tipo_desp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("12", $val["superficie_contr"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("13", $val["precio"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("14", $val["observaciones_del_precio"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("15", $val["kg_contratados"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("16", $val["kgxha"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("17", $val["humedad"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("18", $val["germinacion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("19", $val["pureza_genetica"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("20", $val["fecha_recep_sem"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("21", $val["pureza_fisica"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("22", $val["fecha_despacho"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("23", $val["maleza"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("24", $val["declaraciones"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("25", $val["kg_por_envase"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("26", $val["enfermedades"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT detalle_quotation] => ".$error->getMessage()));
                            }
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK detalle_quotation] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('detalle_quotation', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

            }

            $sqlWeb = "SELECT * FROM detalle_quotation;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayDetalleQuotation[$data["id_de_quo_SAP"]] = $data["id_de_quo"];
                }
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO detalle_quotation] => ".$error->getMessage()));
        }
    }

    /* FICHA */
    if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM ficha;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){
                    // $arrayQuotations[$val["id_usuario"]] == null ||
                    // arrayUsuario
                    if($arrayUsuario[$val["id_usuario"]] == null || $arrayEstadoFicha[$val["id_est_fic"]] == null || $arrayTemporada[$val["id_tempo"]] == null || $arrayEspecie[$val["id_esp"]] == null || $arrayAgricultor[$val["id_agric"]] == null || $arrayComuna[$val["id_comuna"]] == null  || $arrayPredio[$val["id_pred"]] == null || $arrayLotes[$val["id_lote"]] == null || $arrayTipoSuelo[$val["id_tipo_suelo"]] == null || $arrayTipoRiego[$val["id_tipo_riego"]] == null ){

                        if($arrayEstadoFicha[$val["id_est_fic"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_est_fic',$val["id_est_fic"], 'estado_ficha', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayTemporada[$val["id_tempo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayEspecie[$val["id_esp"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayAgricultor[$val["id_agric"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_agric',$val["id_agric"], 'agricultor', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayComuna[$val["id_comuna"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_comuna',$val["id_comuna"], 'comuna', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayPredio[$val["id_pred"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_pred',$val["id_pred"], 'predio', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayLotes[$val["id_lote"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_lote',$val["id_lote"], 'lote', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayTipoSuelo[$val["id_tipo_suelo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_tipo_suelo',$val["id_tipo_suelo"], 'tipo_suelo', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }
                        if($arrayTipoRiego[$val["id_tipo_riego"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_tipo_riego',$val["id_tipo_riego"], 'tipo_riego', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }

                        if($arrayUsuario[$val["id_usuario"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('ficha', 'id_usuario',$val["id_usuario"], 'usuario', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ficha"]));
                        }

                    }else{
                        $sqlWeb = "SELECT * FROM ficha  WHERE id_ficha_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_ficha']);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                // id_usuario
                                try{
                                    $sqlWeb = "UPDATE  ficha  SET id_ficha_SAP = ?,  id_est_fic = ?, id_tempo = ?,  id_esp = ?, id_agric = ?, id_comuna = ?, id_pred = ?, id_lote = ?, id_tipo_suelo = ?, id_tipo_riego = ?, oferta_de_negocio = ?, localidad = ?, ha_disponibles = ?, experiencia = ?, maleza = ?, estado_general = ?, obs = ?, id_tipo_tenencia_maquinaria = ?, id_tipo_tenencia_terreno = ?, estado_sincro = ?, id_region = ?, id_usuario = ? WHERE id_ficha = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_ficha"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", "2", PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $arrayPredio[$val["id_pred"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $arrayLotes[$val["id_lote"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $arrayTipoSuelo[$val["id_tipo_suelo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $arrayTipoRiego[$val["id_tipo_riego"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("11", $val["oferta_de_negocio"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("12", $val["localidad"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("13", $val["ha_disponibles"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("14", $val["experiencia"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("15", $val["maleza"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("16", $val["estado_general"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("17", $val["obs"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("18", "1", PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("19", "1", PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("20", "1", PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("21", "1", PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("22", $arrayUsuario[$val["id_usuario"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("23", $valWeb["id_ficha"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE ficha] => ".$error->getMessage()));
                                }
                                
                            }

                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO ficha (id_ficha_SAP,  id_est_fic, id_tempo,  id_esp, id_agric, id_comuna, id_pred, id_lote, id_tipo_suelo, id_tipo_riego, oferta_de_negocio, localidad, ha_disponibles, experiencia, maleza, estado_general, obs, id_tipo_tenencia_maquinaria, id_tipo_tenencia_terreno, id_usuario, id_region, estado_sincro) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_ficha"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", "2", PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $arrayComuna[$val["id_comuna"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $arrayPredio[$val["id_pred"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $arrayLotes[$val["id_lote"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $arrayTipoSuelo[$val["id_tipo_suelo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("10", $arrayTipoRiego[$val["id_tipo_riego"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("11", $val["oferta_de_negocio"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("12", $val["localidad"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("13", $val["ha_disponibles"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("14", $val["experiencia"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("15", $val["maleza"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("16", $val["estado_general"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("17", $val["obs"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("18", "1", PDO::PARAM_STR);
                                $movimientoWeb->bindValue("19", "1", PDO::PARAM_STR);
                                $movimientoWeb->bindValue("20", $arrayUsuario[$val["id_usuario"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("21", "1", PDO::PARAM_STR);
                                $movimientoWeb->bindValue("22", "1", PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT ficha] => ".$error->getMessage()));
                            }
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK ficha] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('ficha', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));


            
                }

            }

            $sqlWeb = "SELECT * FROM ficha;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayFicha[$data["id_ficha_SAP"]] = $data["id_ficha"];

                    $arrayUsuarioAnexos[$data["id_ficha"]] = $data["id_usuario"];
                    $arrayFichasTemporadas[$data["id_ficha"]] = $data["id_tempo"];


                }
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO ficha] => ".$error->getMessage()));
        }
    }



        /* historial_predio */
        if(sizeof($arrayRespuestaErronea) <= 0){
       
            $rolback = false;
            try{
                $tiempo_inicial = microtime(true);
                $sqlDescarga = "SELECT * FROM historial_predio;";    
                $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
                $consultaDescarga->execute();
                if($consultaDescarga->rowCount() > 0){
                    $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                    $datosInsertados = 0;
                    $datosUpdateados = 0;
                    $datosTotales = 0;
    
                    $conexionWeb->beginTransaction();
                    foreach($r as $val){
                        // $arrayQuotations[$val["id_usuario"]] == null ||
                        // arrayUsuario
                        if($arrayFicha[$val["id_ficha"]] == null ){
    
                            if($arrayFicha[$val["id_ficha"]] == null){
                                array_push($arrayErrorReferencia,ingresarHistorial('historial_predio', 'id_ficha',$val["id_ficha"], 'ficha', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_his_pre"]));
                            }
                            
                        }else{
                            $sqlWeb = "SELECT * FROM historial_predio  WHERE id_his_pre_sap  = ?;";
                            $consultaWeb = $conexionWeb->prepare($sqlWeb);
                            $consultaWeb->bindValue("1", $val['id_his_pre']);
                            $consultaWeb->execute();
                            
                            if($consultaWeb->rowCount() > 0){
    
                                $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                                foreach($rWeb as $valWeb){
                                
                                    /* update */
                                    // id_usuario
                                    try{
                                        $sqlWeb = "UPDATE  historial_predio  SET id_his_pre_sap = ?, id_ficha = ?, anno = ?,  descripcion = ? WHERE id_his_pre = ?;";
                                        $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                        $movimientoWeb->bindValue("1", $val["id_his_pre"], PDO::PARAM_STR);
                                        $movimientoWeb->bindValue("2", $arrayFicha[$val["id_ficha"]], PDO::PARAM_STR);
                                        $movimientoWeb->bindValue("3", $val["anno"], PDO::PARAM_STR);
                                        $movimientoWeb->bindValue("4", $val["descripcion"], PDO::PARAM_STR);
                                        $movimientoWeb->bindValue("5", $valWeb["id_his_pre"], PDO::PARAM_STR);
                                        $movimientoWeb->execute();
                                        /*  contar filas updateadas */
                                        $datosUpdateados += $movimientoWeb->rowCount();
                                    }catch(PDOException $error){
                                        $rolback = true;
                                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE historial_predio] => ".$error->getMessage()));
                                    }
                                }
    
                            }else{
                                /* insert */
                                try{
                                    $sqlWeb = "INSERT INTO historial_predio (id_his_pre_sap,  id_ficha, anno,  descripcion, tipo) VALUES(?, ?, ?, ?, 'F');";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_his_pre"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayFicha[$val["id_ficha"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $val["anno"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $val["descripcion"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas insertar */
                                    $datosInsertados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT historial_predio] => ".$error->getMessage()));
                                }
                            }
                        }
                        
                    }
    
                    if($rolback){
                        // echo "rolback...";
                        array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK historial_predio] => c"));
                        $conexionWeb->rollback();
                    }else{
    
                        $conexionWeb->commit();
    
                        /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                        $datosTotales += ($datosInsertados + $datosUpdateados);
                        $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                        /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                        $tiempo_final = microtime(true);
                        $tiempo = $tiempo_final - $tiempo_inicial;
                        array_push($arrayOkTabla,ingresarHistorial('historial_predio', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));
    
    
                
                    }
    
                }
    
                $sqlWeb = "SELECT * FROM historial_predio;";
                $consultaWeb = $conexionWeb->prepare($sqlWeb);
                $consultaWeb->execute();
                if($consultaWeb->rowCount() > 0){
                    $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res as $data){
                        $arrayHistorialPredio[$data["id_his_pre_sap"]] = $data["id_his_pre"];
                    }
                }
            }catch(PDOException $error){
                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO ficha] => ".$error->getMessage()));
            }
        }

    // var_dump($arrayUsuarioAnexos);

    /* ANEXO_ CONTRATO */
    if(sizeof($arrayRespuestaErronea) <= 0){
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM anexo_contrato;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if($arrayContratoAgricultor[$val["id_cont"]] == null || $arrayFicha[$val["id_ficha"]] == null || $arrayLotes[$val["id_lote"]] == null || $arrayMoneda[$val["id_moneda"]] == null || $arrayMaterial[$val["id_materiales"]] == null || $arrayUM[$val["id_um"]] == null || $arrayDetalleQuotation[$val["id_de_quo"]] == null ){

                        if($arrayContratoAgricultor[$val["id_cont"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_cont',$val["id_cont"], 'contrato_agricultor', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"])); 
                        }

                        if($arrayFicha[$val["id_ficha"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_ficha',$val["id_ficha"], 'ficha', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"])); 
                        }
                        if($arrayLotes[$val["id_lote"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_lote',$val["id_lote"], 'lote', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"])); 
                        }
                        if($arrayMoneda[$val["id_moneda"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_moneda',$val["id_moneda"], 'moneda', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"])); 
                        }
                        if($arrayMaterial[$val["id_materiales"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_materiales',$val["id_materiales"], 'materiales', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"])); 
                        }
                        if($arrayUM[$val["id_um"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_um',$val["id_um"], 'unidad_medida', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"]));
                        }
                        if($arrayDetalleQuotation[$val["id_de_quo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('anexo_contrato', 'id_de_quo',$val["id_de_quo"], 'detalle_quotation', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_ac"]));
                        }

                    }else{
                        $sqlWeb = "SELECT * FROM anexo_contrato  WHERE id_ac_SAP  = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_ac'], PDO::PARAM_STR);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  anexo_contrato   SET id_ac_SAP = ?,  id_cont = ?, id_ficha = ?,  id_lote = ?, id_moneda = ?, id_materiales = ?, id_um = ?, num_anexo = ?, superficie = ?, base = ?, precio = ?, otras_cond = ?, humedad = ?, germinacion = ?, pureza_genetica = ?, pureza_fisica = ?, maleza = ?, enfermedades = ?, id_de_quo = ? WHERE id_ac = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val["id_ac"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $arrayContratoAgricultor[$val["id_cont"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $arrayFicha[$val["id_ficha"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("4", $arrayLotes[$val["id_lote"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("5", $arrayMoneda[$val["id_moneda"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("6", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("7", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("8", $val["num_anexo"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("9", $val["superficie"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("10", $val["base"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("11", $val["precio"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("12", $val["otras_cond"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("13", $val["humedad"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("14", $val["germinacion"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("15", $val["pureza_genetica"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("16", $val["pureza_fisica"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("17", $val["maleza"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("18", $val["enfermedades"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("19", $arrayDetalleQuotation[$val["id_de_quo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("20", $valWeb["id_ac"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateada \s , id_de_quo = ? */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE anexo_contrato] => ".$error->getMessage()));
                                }
                                
                            }

                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO anexo_contrato (id_ac_SAP,  id_cont, id_ficha,  id_lote, id_moneda, id_materiales, id_um, num_anexo, superficie, base, precio, otras_cond, humedad, germinacion, pureza_genetica, pureza_fisica, maleza, enfermedades, id_de_quo) VALUES(? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $val["id_ac"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayContratoAgricultor[$val["id_cont"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayFicha[$val["id_ficha"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $arrayLotes[$val["id_lote"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $arrayMoneda[$val["id_moneda"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("6", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("7", $arrayUM[$val["id_um"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("8", $val["num_anexo"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("9", $val["superficie"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("10", $val["base"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("11", $val["precio"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("12", $val["otras_cond"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("13", $val["humedad"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("14", $val["germinacion"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("15", $val["pureza_genetica"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("16", $val["pureza_fisica"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("17", $val["maleza"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("18", $val["enfermedades"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("19", $arrayDetalleQuotation[$val["id_de_quo"]], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT anexo_contrato] => ".$error->getMessage()));
                            }
                        }
                    }
                    
                }

                if($rolback){
                    // echo "rolback...<br>";
                    $conexionWeb->rollback();
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK anexo_contrato] => c"));
                    
                }else{
                    // echo "commit...<br>";
                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('anexo_contrato', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                   

                }

            }

            $sqlWeb = "SELECT * FROM anexo_contrato;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayAnexoContrato[$data["id_ac_SAP"]] = $data["id_ac"];


                    $sel = "SELECT * FROM contrato_anexo_temporada WHERE id_cont = :id_cont AND id_ac = :id_ac AND id_tempo = :id_tempo; ";
                    $consultaWeb = $conexionWeb->prepare($sel);
                    $consultaWeb->bindValue(":id_cont", $data["id_cont"], PDO::PARAM_STR);
                    $consultaWeb->bindValue(":id_ac", $data["id_ac"], PDO::PARAM_STR);
                    $consultaWeb->bindValue(":id_tempo", $arrayFichasTemporadas[$data["id_ficha"]], PDO::PARAM_STR);
                    if($consultaWeb->rowCount() <= 0){
                        $ins = "INSERT INTO contrato_anexo_temporada (id_cont, id_ac, id_tempo) VALUES (:id_cont, :id_ac, :id_tempo);";
                        $movimientoWeb = $conexionWeb->prepare($ins);
                        $movimientoWeb->bindValue(":id_cont", $data["id_cont"], PDO::PARAM_STR);
                        $movimientoWeb->bindValue(":id_ac", $data["id_ac"], PDO::PARAM_STR);
                        $movimientoWeb->bindValue(":id_tempo", $arrayFichasTemporadas[$data["id_ficha"]], PDO::PARAM_STR);
                        $movimientoWeb->execute();
                    }

                    

                    $sel = "SELECT * FROM usuario_anexo WHERE id_usuario = :id_usuario AND id_ac = :id_ac ;";
                    $consultaWeb = $conexionWeb->prepare($sel);
                    $consultaWeb->bindValue(":id_usuario", $arrayUsuarioAnexos[$data["id_ficha"]], PDO::PARAM_STR);
                    $consultaWeb->bindValue(":id_ac", $data["id_ac"], PDO::PARAM_STR);
                    $consultaWeb->execute();
                    if($consultaWeb->rowCount() <= 0){
                        $ins = "INSERT INTO usuario_anexo (id_usuario, id_ac) VALUES (:id_usuario, :id_ac); ";
                        $movimientoWeb  = $conexionWeb->prepare($ins);
                        $movimientoWeb->bindValue(":id_usuario",$arrayUsuarioAnexos[$data["id_ficha"]], PDO::PARAM_STR);
                        $movimientoWeb->bindValue(":id_ac",$data["id_ac"], PDO::PARAM_STR);
                        $movimientoWeb->execute();
                    }


                    

                }
            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO anexo_contrato] => ".$error->getMessage()));
        }
    }



      /* EXPORT */
      if(sizeof($arrayRespuestaErronea) <= 0){
       
        $rolback = false;
        try{
            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM export;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();
                foreach($r as $val){

                    if( $arrayEspecie[$val["id_esp"]] == null || 
                        $arrayCliente[$val["id_cli"]] == null || 
                        $arrayMaterial[$val["id_materiales"]] == null || 
                        $arrayTemporada[$val["id_tempo"]] == null ||
                        $arrayAgricultor[$val["id_agric"]] == null || 
                        $arrayAnexoContrato[$val["id_ac"]] == null){

                        if($arrayEspecie[$val["id_esp"]] == null ) {
                      
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_esp',$val["id_esp"], 'especie', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 

                        if($arrayCliente[$val["id_cli"]] == null ) {

                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_cli',$val["id_cli"], 'cliente', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 

                        if($arrayMaterial[$val["id_materiales"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_materiales',$val["id_materiales"], 'materiales', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 

                        if($arrayTemporada[$val["id_tempo"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 

                        if($arrayAgricultor[$val["id_agric"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_agric',$val["id_agric"], 'agricultor', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 

                        if($arrayAnexoContrato[$val["id_ac"]] == null ) {
                            array_push($arrayErrorReferencia,ingresarHistorial('stock_semillas', 'id_ac',$val["id_ac"], 'anexo_contrato', 2, $fechaHoraInicio, $rutUsuario, $idCabecera, $val["id_export"]));
                        } 


                        
                    }else{

                        $sqlWeb = "SELECT * FROM export WHERE id_export_sap  = ? ;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $val['id_export']);
                        $consultaWeb->execute();


                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE  export SET 
                                    id_export_sap = :id_export_sap,  
                                    id_tempo = :id_tempo,  
                                    id_cli = :id_cli,  
                                    id_esp = :id_esp,  
                                    id_materiales = :id_materiales,  
                                    id_ac = :id_ac,  
                                    id_agric = :id_agric,  
                                    lote_cliente = :lote_cliente,  
                                    hectareas = :hectareas,  
                                    fin_lote = :fin_lote,  
                                    kgs_recepcionados = :kgs_recepcionados,  
                                    kgs_limpios = :kgs_limpios,  
                                    kgs_exportados = :kgs_exportados,  
                                    lote_campo = :lote_campo,  
                                    numero_guia = :numero_guia, 
                                    peso_bruto = :peso_bruto, 
                                    tara = :tara, 
                                    peso_neto = :peso_neto,
                                    tipo_export = :tipo_export
                                    WHERE id_stock_semilla = :id_stock_semilla ;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue(":id_export_sap", $val["id_export"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_tempo", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_cli", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_esp",  $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_materiales", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_ac", $arrayAnexoContrato[$val["id_ac"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_agric", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":lote_cliente", $val["lote_cliente"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":hectareas", $val["hectareas"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":fin_lote", $val["fin_lote"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":kgs_recepcionados", $val["kgs_recepcionados"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":kgs_limpios", $val["kgs_limpios"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":kgs_exportados", $val["kgs_exportados"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":lote_campo", $val["lote_campo"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":numero_guia", $val["numero_guia"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":peso_bruto", $val["peso_bruto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":tara", $val["tara"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":peso_neto", $val["peso_neto"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":tipo_export", $val["tipo_export"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue(":id_export", $valWeb["id_export"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE export] => ".$error->getMessage()));
                                }
                                
                            }
        
                        }else{
                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO stock_semillas (
                                    id_export_sap,  
                                    id_tempo,  
                                    id_cli,  
                                    id_esp,  
                                    id_materiales,  
                                    id_ac,  
                                    id_agric,  
                                    lote_cliente,  
                                    hectareas,  
                                    fin_lote,  
                                    kgs_recepcionados,  
                                    kgs_limpios,  
                                    kgs_exportados,  
                                    lote_campo,  
                                    numero_guia, 
                                    peso_bruto, 
                                    tara, 
                                    peso_neto,
                                    tipo_export ) 
                                VALUES(
                                    :id_export_sap,
                                    :id_tempo,
                                    :id_cli,
                                    :id_esp,
                                    :id_materiales,
                                    :id_ac,
                                    :id_agric,
                                    :lote_cliente,
                                    :hectareas,
                                    :fin_lote,
                                    :kgs_recepcionados,
                                    :kgs_limpios,
                                    :kgs_exportados,
                                    :lote_campo,
                                    :numero_guia,
                                    :peso_bruto,
                                    :tara,
                                    :peso_neto,
                                    :tipo_export ) ;";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue(":id_export_sap", $val["id_export"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_tempo", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_cli", $arrayCliente[$val["id_cli"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_esp",  $arrayEspecie[$val["id_esp"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_materiales", $arrayMaterial[$val["id_materiales"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_ac", $arrayAnexoContrato[$val["id_ac"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":id_agric", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":lote_cliente", $val["lote_cliente"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":hectareas", $val["hectareas"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":fin_lote", $val["fin_lote"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":kgs_recepcionados", $val["kgs_recepcionados"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":kgs_limpios", $val["kgs_limpios"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":kgs_exportados", $val["kgs_exportados"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":lote_campo", $val["lote_campo"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":numero_guia", $val["numero_guia"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":peso_bruto", $val["peso_bruto"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":tara", $val["tara"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":peso_neto", $val["peso_neto"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue(":tipo_export", $val["tipo_export"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT export] => ".$error->getMessage()));
                            }
                        }
                    }
                }

                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK export] => c"));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();

                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('stock_semillas', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    
                }

               

            }

            $sqlWeb = "SELECT * FROM export;";
            $consultaWeb = $conexionWeb->prepare($sqlWeb);
            $consultaWeb->execute();
            if($consultaWeb->rowCount() > 0){
                $res = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $data){
                    $arrayExport[$data["id_export_sap"]] = $data["id_export"];
                }

            }
        }catch(PDOException $error){
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cliente] => ".$error->getMessage()));
        }
    }




/*  AGRI PRED TEMP */
    if(sizeof($arrayRespuestaErronea) <= 0){
        $rollback = false;

        try{


            $tiempo_inicial = microtime(true);
            $sqlDescarga = "SELECT * FROM agri_pred_temp;";    
            $consultaDescarga = $conexionDescarga->prepare($sqlDescarga);
            $consultaDescarga->execute();
            if($consultaDescarga->rowCount() > 0){
                $r = $consultaDescarga->fetchAll(PDO::FETCH_ASSOC);
                $datosInsertados = 0;
                $datosUpdateados = 0;
                $datosTotales = 0;

                $conexionWeb->beginTransaction();

                foreach($r as $val){
                    if($arrayAgricultor[$val["id_agric"]] == null || $arrayTemporada[$val["id_tempo"]] == null){
                        if($arrayAgricultor[$val["id_agric"]] == null){ 
                            array_push($arrayErrorReferencia,ingresarHistorial('agri_pred_temp', 'id_agric',$val["id_agric"], 'agricultor', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_agri_pred_temp"]));
                        }

                        if($arrayTemporada[$val["id_tempo"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('agri_pred_temp', 'id_tempo',$val["id_tempo"], 'temporada', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_agri_pred_temp"]));
                        }


                        if($arrayPredio[$val["id_pred"]] == null){
                            array_push($arrayErrorReferencia,ingresarHistorial('agri_pred_temp', 'id_pred',$val["id_pred"], 'predio', 2, $fechaHoraInicio, $rutUsuario, $idCabecera,$val["id_agri_pred_temp"]));
                        }
                    }else{

                        $sqlWeb = "SELECT * FROM agri_pred_temp WHERE id_pred  = ? AND id_tempo = ? AND id_agric = ?;";
                        $consultaWeb = $conexionWeb->prepare($sqlWeb);
                        $consultaWeb->bindValue("1", $arrayPredio[$val['id_pred']], PDO::PARAM_STR);
                        $consultaWeb->bindValue("2", $arrayTemporada[$val['id_tempo']], PDO::PARAM_STR);
                        $consultaWeb->bindValue("3", $arrayAgricultor[$val['id_agric']], PDO::PARAM_STR);
                        $consultaWeb->execute();
                        
                        if($consultaWeb->rowCount() > 0){

                            $rWeb = $consultaWeb->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rWeb as $valWeb){
                            
                                /* update */
                                try{
                                    $sqlWeb = "UPDATE agri_pred_temp SET norting = ?, easting = ? WHERE id_agri_pred_temp = ?;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                    $movimientoWeb->bindValue("1", $val['norting'], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("2", $val["easting"], PDO::PARAM_STR);
                                    $movimientoWeb->bindValue("3", $valWeb["id_agri_pred_temp"], PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  contar filas updateadas */
                                    $datosUpdateados += $movimientoWeb->rowCount();
                                }catch(PDOException $error){
                                    $rolback = true;
                                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR UPDATE agri_pred_temp] => ".$error->getMessage()));
                                }
                                
                            }

                        }else{

                            /* insert */
                            try{
                                $sqlWeb = "INSERT INTO agri_pred_temp (id_agric, id_pred, id_tempo, norting, easting) VALUES(?, ?, ?, ?, ?);";
                                $movimientoWeb = $conexionWeb->prepare($sqlWeb);
                                $movimientoWeb->bindValue("1", $arrayAgricultor[$val["id_agric"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("2", $arrayPredio[$val["id_pred"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("3", $arrayTemporada[$val["id_tempo"]], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("4", $val["norting"], PDO::PARAM_STR);
                                $movimientoWeb->bindValue("5", $val["easting"], PDO::PARAM_STR);
                                $movimientoWeb->execute();
                                /*  contar filas insertar */
                                $datosInsertados += $movimientoWeb->rowCount();
                            }catch(PDOException $error){
                                $rolback = true;
                                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR INSERT agri_pred_temp] => ".$error->getMessage()));
                            }

                        }


                    }

                }


                if($rolback){
                    // echo "rolback...";
                    array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR ROLLBACK agri_pred_temp] => ".$error->getMessage()));
                    $conexionWeb->rollback();
                }else{

                    $conexionWeb->commit();
                    /*  SUMA DE AMBOS TOTALES PARA COMPARAR CON TOTAL ORIGINAL  */
                    $datosTotales += ($datosInsertados + $datosUpdateados);
                    $datosTotales = ($datosTotales <= 0) ? $consultaDescarga->rowCount() : $datosTotales;
                    /*  TIEMPO OBTENIDO ENTRE CONSULTA , PROCESAMIENTO DE DATOS Y RESPUESTA  */
                    $tiempo_final = microtime(true);
                    $tiempo = $tiempo_final - $tiempo_inicial;
                    array_push($arrayOkTabla,ingresarHistorial('agri_pred_temp', '', $datosTotales.' filas de un total de '.$consultaDescarga->rowCount().' datos se ingresaron correctamente en un tiempo de '.round($tiempo, 4).' segundos', '', 1, $fechaHoraInicio, $rutUsuario, $idCabecera,''));

                    

                }


            }

        }catch(PDOException $e){

            // MANEJO DE ERRORES
            $rollback = true;
            array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO agri_pred_temp] => ".$error->getMessage()));
            // break 2;
        }

    }

    /*  PROP CLI MAT */
if(sizeof($arrayRespuestaErronea) <= 0){

        if(sizeof($arrayEspecie) > 0){
            $conexionWeb->beginTransaction();
            $rollback = false;

            $especieTemporadaGuardada;
            $maestroPROCLIMAT = "";

            try{
                $sqlSelect = "SELECT identificador FROM prop_cli_mat WHERE id_esp = ? AND  id_tempo = ?; ";
                $movimientoWeb = $conexionWeb->prepare($sqlSelect);
                $movimientoWeb->bindValue("1", "1", PDO::PARAM_STR);
                $movimientoWeb->bindValue("2", "1", PDO::PARAM_STR);
                $movimientoWeb->execute();
                $resDatosDefault = $movimientoWeb->fetchAll(PDO::FETCH_ASSOC);
                foreach($resDatosDefault AS $valueDefault){
                    $maestroPROCLIMAT[$valueDefault["identificador"]] = $valueDefault["identificador"];
                }


          
                foreach($arrayEspecie as $especiesArray){
                    // echo  $especiesArray." ARRAY ESPECIES <br> ";
                        foreach($arrayTemporada as $temporadasArray){
                            $arrayProCliMat = "";
                            $idEspecieBusca = 1;
    
                            $sqlSelect = "SELECT identificador, id_tempo, id_esp FROM prop_cli_mat WHERE id_esp = ? ;";
                                    $movimientoWeb = $conexionWeb->prepare($sqlSelect);
                                    $movimientoWeb->bindValue("1", $especiesArray, PDO::PARAM_STR);
                                    $movimientoWeb->execute();
                                    /*  no contiene la especie  */
                                    if($movimientoWeb->rowCount() > 0){   
    
                                        $resEspecies = $movimientoWeb->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($resEspecies AS $valueEsp){
                                            $idEspecieBusca = $valueEsp["id_esp"];
                                            if($valueEsp["id_tempo"] == $temporadasArray){
                                                $arrayProCliMat[$valueEsp["identificador"]] = $valueEsp["identificador"];
                                            }
                                        }
                                        
                                    }
    
                                    foreach($maestroPROCLIMAT AS $maestro){
                                        if($arrayProCliMat[$maestro] != $maestro){
    
    
                                            $selectFirst = "SELECT * FROM prop_cli_mat WHERE id_esp = ? AND identificador = ? LIMIT 1 ; ";
                                            $movimientoFirst = $conexionWeb->prepare($selectFirst);
                                            $movimientoFirst->bindValue("1", $idEspecieBusca, PDO::PARAM_STR);
                                            $movimientoFirst->bindValue("2", $maestro, PDO::PARAM_STR);
                                            $movimientoFirst->execute();
                                            /*  si encuentra datos de la especie pero faltan temporadas  */
                                            if($movimientoFirst->rowCount() > 0){
                                                $resARecorres = $movimientoFirst->fetchAll(PDO::FETCH_ASSOC);
    
                                                foreach($resARecorres AS $value){
    
                                    

                                                    $insert = "INSERT INTO prop_cli_mat(id_esp, id_prop, id_etapa, id_tempo, id_sub_propiedad, aplica, orden, foraneo, tabla, campo, tipo_campo, reporte_cliente, especial, identificador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                                                    $insertProp = $conexionWeb->prepare($insert);
                                                    $insertProp->bindValue("1", $especiesArray, PDO::PARAM_STR);
                                                    $insertProp->bindValue("2", $value["id_prop"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("3", $value["id_etapa"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("4", $temporadasArray, PDO::PARAM_STR);
                                                    $insertProp->bindValue("5", $value["id_sub_propiedad"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("6", $value["aplica"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("7", $value["orden"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("8", $value["foraneo"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("9", $value["tabla"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("10", $value["campo"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("11", $value["tipo_campo"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("12", $value["reporte_cliente"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("13", $value["especial"], PDO::PARAM_STR);
                                                    $insertProp->bindValue("14", $maestro, PDO::PARAM_STR);
                                                    $insertProp->execute();
    
                                                }
                                            }
                                        }
                                    }
                        }
                }
            }catch(PDOException $error){
                // MANEJO DE ERRORES
                $rollback = true;
                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO prop_cli_mat] => ".$error->getMessage()));
                // break 2;

            }
            
            if($rollback){
                $conexionWeb->rollback();
            }else{
                $conexionWeb->commit();
            }

        }

    }
           

    /* CLI PCM */
    if(sizeof($arrayRespuestaErronea) <= 0 ){

        // id cliente , id especie
        if(sizeof($arrayQuotationDatos) > 0){

            $conexionWeb->beginTransaction();
            $rollback = false;

            $arrCliPCMExiste;
            $maestroPropMatCli;

            try{

                $selectCliPCM = "SELECT * FROM cli_pcm INNER JOIN prop_cli_mat USING(id_prop_mat_cli); ";
                $movimientoCliPCM = $conexionWeb->prepare($selectCliPCM);
                $movimientoCliPCM->execute();
                /* cantidad total de elemento es prop_cli_mat e id maximo insertado  */
                if($movimientoCliPCM->rowCount() > 0){
                    $conteoCLIPCM = $movimientoCliPCM->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($conteoCLIPCM as $val){
                        $arrCliPCMExiste[$val["id_cli"]."__".$val["id_prop_mat_cli"]."__".$val["id_esp"]."__".$val["id_tempo"]] = $val["id_cli"]."__".$val["id_prop_mat_cli"]."__".$val["id_esp"]."__".$val["id_tempo"];
                    }
    
                }
    
    
    
                $selectCliPCM = "SELECT * FROM prop_cli_mat ; ";
                $movimientoCliPCM = $conexionWeb->prepare($selectCliPCM);
                $movimientoCliPCM->execute();
                /* cantidad total de elemento es prop_cli_mat e id maximo insertado  */
                if($movimientoCliPCM->rowCount() > 0){
                    $conteoCLIPCM = $movimientoCliPCM->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($conteoCLIPCM as $val){
                        $maestroPropMatCli[$val["id_prop_mat_cli"]."__".$val["id_esp"]."__".$val["id_tempo"]] = $val["id_prop_mat_cli"]."__".$val["id_esp"]."__".$val["id_tempo"];
                    }
    
                }
    
    
    
                foreach($arrayQuotationDatos as $valueDato){
    
                    list($clienteArray, $especieArray, $tempoArray) = explode("__", $valueDato);
    
                    foreach($maestroPropMatCli as $valueMaestro){
                        list($idMaestroPCM, $idEspecie, $idTempo) = explode("__",  $valueMaestro);
                        
    
                        $arrCliPCMMaestros[$clienteArray."__".$idMaestroPCM."__".$idEspecie."__".$idTempo] = $clienteArray."__".$idMaestroPCM."__".$idEspecie."__".$idTempo;
    
    
                        if($arrCliPCMMaestros[$clienteArray."__".$idMaestroPCM."__".$idEspecie."__".$idTempo] !=  $arrCliPCMExiste[$clienteArray."__".$idMaestroPCM."__".$especieArray."__".$tempoArray] && $especieArray == $idEspecie && $idTempo == $tempoArray){
                            
                            $sql3 = "INSERT INTO cli_pcm (id_cli, id_prop_mat_cli, ver, registrar) VALUES (?, ?, ?, ?)";
                            $consulta3 = $conexionWeb->prepare($sql3);
    
                                $consulta3->bindValue("1", $clienteArray, PDO::PARAM_INT);
                                $consulta3->bindValue("2", $idMaestroPCM, PDO::PARAM_INT);
                                $consulta3->bindValue("3", 1, PDO::PARAM_INT);
                                $consulta3->bindValue("4", 1, PDO::PARAM_INT);
                                $consulta3->execute();
                            
                                $arrCliPCMExiste[$clienteArray."__".$idMaestroPCM."__".$especieArray."__".$tempoArray] = $clienteArray."__".$idMaestroPCM."__".$especieArray."__".$tempoArray;
                        }
                    }
                }

            }catch(PDOException $error){
                $rollback = true;
                array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cli_pcm] => ".$error->getMessage()));
            }
           

            if($rollback){
                $conexionWeb->rollback();
            }else{
                $conexionWeb->commit();
            }

        }
    }

            
            // $resGuardados;

            // $cantidadElementos;

            /* obtengo array con todo pro_cli_mat y cantidad de elementos por especie_temporada */
            /* $selcPCMG = "SELECT * FROM prop_cli_mat; ";
            $selectPmG = $conexionWeb->prepare($selcPCMG);
            $selectPmG->execute();
            if($selectPmG->rowCount() > 0){
                $resGuardados = $selectPmG->fetchAll(PDO::FETCH_ASSOC);

                foreach($resGuardados AS $val){
                    $resGuardados[$val["id_esp"]."__".$val["id_tempo"]]++;
                }
            } */

            /*  cantidad de elementos e id maxima en pro_cli_mat */
            // $selectCliPCM = "SELECT COUNT(id_prop_mat_cli) AS cantidad, MAX(id_prop_mat_cli) AS id_maximo FROM prop_cli_mat LIMIT 1; ";
            // $movimientoCliPCM = $conexionWeb->prepare($selectCliPCM);
            // $movimientoCliPCM->execute();
            // /* cantidad total de elemento es prop_cli_mat e id maximo insertado  */
            // $conteoCLIPCM = $movimientoCliPCM->fetchAll(PDO::FETCH_ASSOC);

            // echo "<pre>";
            // var_dump($arrayQuotationDatos);
            // echo "</pre>";

            // foreach($arrayQuotationDatos as $numberValue){
            //     // $data["id_cli"]."__".$data["id_esp"]."__".$val["id_tempo"]
            //     list($clienteArray, $especieArray, $tempoArray) = explode("__", $numberValue);
            //     // echo $clienteArray."__".$especieArray."__".$tempoArray."<br>";

            //     try{

            //         /*  si no existe la especie en tabla prop_cli_mat  */
            //         $selectFirst = "SELECT COUNT(id_prop_mat_cli) AS cantidad, MAX(id_prop_mat_cli) AS id_maximo FROM cli_pcm WHERE id_cli = ? LIMIT 1; ";
            //         $movimientoFirst = $conexionWeb->prepare($selectFirst);
            //         $movimientoFirst->bindValue("1", $clienteArray, PDO::PARAM_STR);
            //         $movimientoFirst->execute();
            //         /*  encontro datos de la primera especie  */
            //         if($movimientoFirst->rowCount() > 0){
            //             /*  cantidad total de elementos en cli_pcm e id maximo insertado */
            //             $conteoExistentes = $movimientoFirst->fetchAll(PDO::FETCH_ASSOC);

            //             if($conteoExistentes[0]["cantidad"] > 0){

            //                 if(($conteoExistentes[0]["cantidad"] != $conteoCLIPCM[0]["cantidad"]) || ($conteoExistentes[0]["id_maximo"] != $conteoCLIPCM[0]["id_maximo"]) ){

            //                     $selcPCM = "SELECT * FROM prop_cli_mat WHERE id_prop_mat_cli > ? AND id_esp = ? AND id_tempo = ? ; ";
            //                     $selectPm = $conexionWeb->prepare($selcPCM);
            //                     $selectPm->bindValue("1", $conteoExistentes[0]["id_maximo"], PDO::PARAM_STR);
            //                     $selectPm->bindValue("2", $especieArray, PDO::PARAM_STR);
            //                     $selectPm->bindValue("3", $tempoArray, PDO::PARAM_STR);
            //                     $selectPm->execute();
            //                     if($selectPm->rowCount() > 0){
            //                         $res = $selectPm->fetchAll(PDO::FETCH_ASSOC);

            //                         $sql3 = "INSERT INTO cli_pcm (id_cli, id_prop_mat_cli, ver, registrar) VALUES (?, ?, ?, ?)";
            //                         $consulta3 = $conexionWeb->prepare($sql3);

            //                         foreach($res as $val2){
            //                             $consulta3->bindValue("1", $clienteArray, PDO::PARAM_INT);
            //                             $consulta3->bindValue("2", $val2["id_prop_mat_cli"], PDO::PARAM_INT);
            //                             $consulta3->bindValue("3", 1, PDO::PARAM_INT);
            //                             $consulta3->bindValue("4", 1, PDO::PARAM_INT);
            //                             $consulta3->execute();
            //                         }
            //                     }
            //                 }
            //             }else{

            //                 $selcPCMG = "SELECT * FROM prop_cli_mat WHERE id_esp = ? AND id_tempo = ? ; ";
            //                 $selectPmG = $conexionWeb->prepare($selcPCMG);
            //                 $selectPmG->bindValue("1", $especieArray, PDO::PARAM_INT);
            //                 $selectPmG->bindValue("2", $tempoArray, PDO::PARAM_INT);
            //                 $selectPmG->execute();
            //                 if($selectPmG->rowCount() > 0){
            //                     $resGuardados = $selectPmG->fetchAll(PDO::FETCH_ASSOC);

            //                     $sql3 = "INSERT INTO cli_pcm (id_cli, id_prop_mat_cli, ver, registrar) VALUES (?, ?, ?, ?)";
            //                     $consulta3 = $conexionWeb->prepare($sql3);
            //                     foreach($resGuardados as $val2){
            //                         $consulta3->bindValue("1", $clienteArray, PDO::PARAM_INT);
            //                         $consulta3->bindValue("2", $val2["id_prop_mat_cli"], PDO::PARAM_INT);
            //                         $consulta3->bindValue("3", 1, PDO::PARAM_INT);
            //                         $consulta3->bindValue("4", 1, PDO::PARAM_INT);
            //                         $consulta3->execute();
            //                     }
            //                 }
            //             }
            //         }

            //     }catch(PDOException $error){
            //         $rollback = true;
            //         array_push($arrayRespuestaErronea, array("codigo" => 5, "mensaje" => "[ERROR PROCESO cli_pcm] => ".$error->getMessage()));
            //     }
            // }


            // if($rollback){
            //     $conexionWeb->rollback();
            // }else{
            //     $conexionWeb->commit();
            // }

       
}

    $tiempo_finalTotal = microtime(true);
    $tiempoFinal = $tiempo_finalTotal - $tiempo_inicialTotal;



    $conexion = NULL;
    header('Content-Type: application/json');
    
    if(sizeof($arrayRespuestaErronea) <= 0 && sizeof($arrayErrorReferencia) <= 0){

        if($comunasNuevas != NULL){
            $CorreosErrorInsert = "sacuna@zionit.cl,rdelcanto@zionit.cl,fmarin@zionit.cl,jparada@zionit.cl";
            $fechaHoraInicio = date('d-m-Y H:i:s');
            $DescErrorCorreo="";   
            $DescErrorCorreo=" SE HAN CREADO LAS SIGUIENTES COMUNAS : \n\n";
            $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 		
            $DescErrorCorreo.="\n".$comunasNuevas; 
            //ENVIAR CORREO
            $Cabecera="From: CURIMAPU INTERCAMBIO <>";
            mail($CorreosErrorInsert,"NUEVAS COMUNAS AGREGADAS",$DescErrorCorreo,$Cabecera);
        }

        echo json_encode(array("codigo" => 1, "mensaje"=>"ningun problema encontrado", "dataOk" => $arrayOkTabla, "dataError" => $arrayErrorReferencia));
    }else{
        echo json_encode(array("codigo" => 2, "mensaje"=>"", "data"=>$arrayRespuestaErronea, "dataOk" => $arrayOkTabla, "dataError" => $arrayErrorReferencia));
    }




   


?>
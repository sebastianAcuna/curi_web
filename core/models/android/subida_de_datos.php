<?php
/*     error_reporting(E_ALL);
    ini_set('display_errors', '1'); */

    require_once '../../db/conectarse_db.php';
    

    
    $conexion = new Conectar();
    $conexion = $conexion->conexion();
    
    include_once('../../../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');


    


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $body = json_decode(file_get_contents("php://input"), true);

       
        $arrayFichas = (isset($body["fichas"]) ? $body["fichas"] : array());
        $arrayVisitas = (isset($body["visitas"]) ? $body["visitas"] : array());
        $arrayDetalles = (isset($body["detalles"]) ? $body["detalles"] : array());
        $arrayFotos = (isset($body["fotos"]) ? $body["fotos"] : array());
        $arrayFotosFichas = (isset($body["fotos_fichas"]) ? $body["fotos_fichas"] : array());
        $arrayErrores = (isset($body["errores"]) ? $body["errores"] : array());
        $idDispositivo = (isset($body["id_dispo"]) ? $body["id_dispo"] : 0);
        $idUsuario = (isset($body["id_usuario"]) ? $body["id_usuario"] : 0);
        $cantidadSuma = (isset($body["suma_datos"]) ? $body["suma_datos"] : 0);
        $arrayRotation = (isset($body["crop_rotation"]) ? $body["crop_rotation"] : 0);

        $version = (isset($body["version"]) ? $body["version"] : NULL);


        // $cantidadSuma = $cantidadSuma + sizeof($arrayFotos);


        $CorreosErrorInsert = "sacuna@zionit.cl";
        // seba.nobody@gmail.com
        $fechaHoraInicio =  date('Y-m-d H:i:s');

        $mensajeError = "";
        /* codigo 1 = todo bien; 2 = mal */
        $codigoError = 0;

        $idCabecera = 0;
        $sumaInsertada = 0;

        // todo 
        // sumar ides en tableta, subir 
        $arrayUsuarios;
        $pospectosInsertados;
        
        if($version != NULL){
            
            
            $problema = "";
            $codigoProblema  = 1;
            
            try{
            
                $sql = "SELECT * FROM usuarios ";
                $consulta  = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach($r as $val){

                        $arrayUsuarios[$val["id_usuario"]] = $val["rut"];
                    }
    
                
                }
            }catch(PDOException $e){
                $problema  = $e->getMessage();
                $codigoProblema = 2;
            }


            try{
        
                $sql = "SELECT version_apk FROM empresa WHERE id_empresa_SAP = ? AND version_apk = ? LIMIT 1";
                // echo $sql;
                $consulta  = $conexion->prepare($sql);
                $consulta->bindValue("1", "1", PDO::PARAM_STR);
                $consulta->bindValue("2", $version, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() <= 0){
                    $problema = "VERSION DE APLICACION NO ES LA VERSION ACTUAL";
                    $codigoProblema = 5;
        
                }
            }catch(PDOException $e){
                $problema  = $e->getMessage();
                $codigoProblema = 2;
            }


            if($problema == ""){
                if($idDispositivo > 0 && $idUsuario > 0){

                    try{
        
                        $sql = "SELECT MAX(id_cab_subida) as max_id FROM cabecera_subida WHERE id_dispo_subida = ?  AND estado <= ? ;";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                        $consulta->bindValue("2",0, PDO::PARAM_INT);
                        $consulta->execute();
                        if($consulta->rowCount() > 0){
                            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                            $cabDelete = $r[0]["max_id"];
        
                            if($cabDelete > 0){
                                $sql = "DELETE FROM visita WHERE id_cabecera = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }
                                $sql = "DELETE FROM detalle_visita_prop  WHERE id_cabecera = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }
        
                                /* POR SI NECESITAMOS BORRAR FOTOS MAS ADELANTE */
                                $sql = "SELECT *  FROM fotos WHERE id_cabecera = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
                                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($res as $val){
                                        if(file_exists($val["ruta_foto"])){
                                            unlink($val["ruta_foto"]);
                                        }
                                    }
                                }

                                // visita id 1 fotos => 1 , subo => ... => bajo visita id = 1000, fotos 1
                                // visita id 1001 fotos => 1001 subir ... => bajp visita id 1010, foto 1001
                                // visita id 1002 fotos => 1001 subir ... => bajp visita id 1012, foto 1001


                                // visita id 1 fotos => 1 , subo => ... => bajo visita id = 1001, fotos 1
                                // visita id 1002 fotos => 1001 subir ... => bajp visita id 1012, foto 1001



        
                                $sql = "DELETE FROM fotos WHERE id_cabecera = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }
        
                                $sql = "DELETE FROM errores_tableta WHERE id_cabecera_error = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }
        
                                $sql = "DELETE FROM prospecto WHERE id_cab_subida = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }

                                $sql = "UPDATE cabecera_subida SET estado = ? WHERE id_cab_subida = ? ;";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",2, PDO::PARAM_INT);
                                $consulta->bindValue("2",$cabDelete, PDO::PARAM_INT);
                                $consulta->execute();
                                if($consulta->rowCount() > 0){
        
                                }


                            }
                        }
        
                    }catch(PDOException $e){
                        $codigoError = 1;
                        $mensajeError .= "(DELETE DATOS)".$e->getMessage()."\n";
                    }
        
        
        
                    if($codigoError == 0){

                        try{
                            $sql = "INSERT INTO cabecera_subida (id_dispo_subida, fecha_hora_inicio, id_usuario) VALUES (? , ? , ? );";
                            $consulta = $conexion->prepare($sql);
                            $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                            $consulta->bindValue("2",$fechaHoraInicio, PDO::PARAM_STR);
                            $consulta->bindValue("3",$idUsuario, PDO::PARAM_INT);
                            $consulta->execute();
                            if($consulta->rowCount() <= 0){
                                $codigoError = 2;
                                $mensajeError .= "No se inserto ningun dato \n";
                            }else{

                                $sql1 = "SELECT MAX(id_cab_subida) as max_id FROM cabecera_subida WHERE id_dispo_subida = ? AND id_usuario = ? LIMIT 1;";
                                $consulta1 = $conexion->prepare($sql1);
                                $consulta1->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                                $consulta1->bindValue("2",$idUsuario, PDO::PARAM_INT);
                                $consulta1->execute();
                                if($consulta1->rowCount() > 0){
                                    
                                    $r = $consulta1->fetchAll(PDO::FETCH_ASSOC);
                                    //$mensajeError.= json_decode($consulta1->fetchAll(PDO::FETCH_ASSOC));
                                    $idCabecera = $r[0]["max_id"];
                                }

                                //$mensajeError.= $consulta1->rowCount();
                                
                                if($idCabecera > 0){

                                    if(sizeof($arrayFichas) > 0){
                                        $conexion->beginTransaction();
                                        $rollback = false;

                                        $con  = 0;
                                        $sumaInsertada+= sizeof($arrayFichas);
                                        foreach($arrayFichas as $value){

                                            try{

                                                /* AÑADIR FECHA DE CREACION Y MODIFICACION AL ENTRAR PORSPECTOS */

                                                $select = "SELECT  * FROM prospecto  WHERE id_usuario = :id_usuario AND id_est_fic = :id_est_fic AND  id_tempo = :id_tempo AND  id_agric = :id_agric AND  id_comuna = :id_comuna AND  id_region = :id_region AND  oferta_de_negocio = :oferta_de_negocio AND  localidad = :localidad AND  ha_disponibles = :ha_disponibles AND  obs = :obs AND  id_local = :id_local AND  id_provincia = :id_provincia  AND estado_sincro = 1  ";
                                                $conn = $conexion->prepare($select);
                                                $conn->bindValue(":id_usuario",$value["id_usuario"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_est_fic",($value["id_est_fic"] == 3) ? 2 : 1, PDO::PARAM_INT);
                                                $conn->bindValue(":id_tempo",$value["id_tempo"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_agric",$value["id_agric"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_comuna",$value["id_comuna"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_region",$value["id_region"], PDO::PARAM_STR);
                                                $conn->bindValue(":oferta_de_negocio",$value["oferta_de_negocio"], PDO::PARAM_STR);
                                                $conn->bindValue(":localidad",$value["localidad"], PDO::PARAM_STR);
                                                $conn->bindValue(":ha_disponibles",$value["ha_disponibles"], PDO::PARAM_STR);
                                                $conn->bindValue(":obs",$value["obs"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_local",$value["id_ficha"], PDO::PARAM_STR);
                                                $conn->bindValue(":id_provincia",$value["id_provincia"], PDO::PARAM_STR);
                                                $conn->execute();
                                                if($conn->rowCount() <= 0){
                                                    $sql = "INSERT INTO prospecto (id_usuario, id_est_fic, id_tempo, id_agric, id_comuna, id_region, oferta_de_negocio, localidad, ha_disponibles, obs, id_local, id_cab_subida, norting, easting, id_provincia, user_crea, fecha_crea, user_mod, fecha_mod, predio, lote, id_esp, id_tipo_riego, id_tipo_tenencia_maquinaria, id_tipo_tenencia_terreno, experiencia, maleza, estado_general, fecha_limite_s, obs_prop ,id_tipo_suelo) 
                                                    VALUES(:id_usuario, :id_est_fic, :id_tempo, :id_agric, :id_comuna, :id_region, :oferta_de_negocio, :localidad, :ha_disponibles, :obs, :id_local, :id_cab_subida, :norting, :easting, :id_provincia, :user_crea, :fecha_crea, :user_mod, :fecha_mod, :predio, :lote, :id_esp, :id_tipo_riego, :id_tipo_tenencia_maquinaria, :id_tipo_tenencia_terreno, :experiencia, :maleza, :estado_general, :fecha_limite_s, :obs_prop, :id_tipo_suelo) ";
                                                    $consulta = $conexion->prepare($sql);
                                                    $consulta->bindValue(":id_usuario", $value["id_usuario"],PDO::PARAM_INT);
                                                    $consulta->bindValue(":id_est_fic", ($value["id_est_fic"] == 3) ? 2 : 1,PDO::PARAM_INT);
                                                    $consulta->bindValue(":id_tempo", $value["id_tempo"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_agric", $value["id_agric"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_comuna", $value["id_comuna"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_region", $value["id_region"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":oferta_de_negocio", $value["oferta_de_negocio"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":localidad", $value["localidad"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":ha_disponibles", $value["ha_disponibles"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":obs", $value["obs"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_local", $value["id_ficha"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_cab_subida", $idCabecera,PDO::PARAM_INT);
                                                    $consulta->bindValue(":norting", $value["norting"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":easting", $value["easting"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_provincia", $value["id_provincia"],PDO::PARAM_INT);
                                                    $consulta->bindValue(":user_crea", $arrayUsuarios[$value["id_usuario"]],PDO::PARAM_STR);
                                                    $consulta->bindValue(":fecha_crea", $fechaHoraInicio,PDO::PARAM_STR);
                                                    $consulta->bindValue(":user_mod", $arrayUsuarios[$value["id_usuario"]],PDO::PARAM_STR);
                                                    $consulta->bindValue(":fecha_mod", $fechaHoraInicio,PDO::PARAM_STR);
                                                    $consulta->bindValue(":predio", $value["predio"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":lote", $value["potrero"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_esp", $value["especie"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_tipo_riego", $value["id_tipo_riego"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_tipo_tenencia_maquinaria", ($value["id_tipo_tenencia_maquinaria"] == "PROPIA") ? "1" : "2",PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_tipo_tenencia_terreno", ($value["id_tipo_tenencia_terreno"] == "PROPIA") ? "1" : "2",PDO::PARAM_STR);
                                                    $consulta->bindValue(":experiencia", ($value["experiencia"] != null) ? $value["experiencia"] : "",PDO::PARAM_STR);
                                                    $consulta->bindValue(":maleza", ($value["maleza"] != null) ? $value["maleza"] : "",PDO::PARAM_STR);
                                                    $consulta->bindValue(":estado_general", ($value["estado_general"] != null) ? $value["estado_general"] : "" ,PDO::PARAM_STR);
                                                    $consulta->bindValue(":fecha_limite_s", ($value["fecha_limite_siembra"] != null) ? $value["fecha_limite_siembra"] : "",PDO::PARAM_STR);
                                                    $consulta->bindValue(":obs_prop", $value["observacion_negocio"],PDO::PARAM_STR);
                                                    $consulta->bindValue(":id_tipo_suelo", $value["id_tipo_suelo"],PDO::PARAM_STR);
                                                    $consulta->execute();
                                                    if($consulta->rowCount() > 0){
                                                        $con++;

                                                        $sumaInsertada+= $value["id_ficha"];

                                                        $idProspecto = $conexion->lastInsertId();
                                                        if($idProspecto > 0){
                                                            $pospectosInsertados[$value["id_ficha"]] = $idProspecto;
                                                        }
                                                    }
                                                }else{
                                                    $con++;
                                                    $sumaInsertada+= $value["id_ficha"];
                                                }
                                            }catch(PDOException $error){
                                                $rollback = true;
                                                $mensajeError .= $error."\n";
                                            }
                                        }

                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();

                                            if($con != sizeof($arrayFichas)){
                                                $codigoError = 2;
                                                $mensajeError .= "(FICHAS) cantidad de registros (".sizeof($arrayFichas).") obtenidos no coincide con la cantidad de registros insertados (".$con.").\n";
                                            }
                                        }

                                        
                                    }

                                    if(sizeof($arrayRotation) > 0 && $codigoError == 0){

                                        // $texo = "-->".json_decode($arrayRotation)."---".json_encode($arrayRotation);/


                                        $conexion->beginTransaction();
                                        $rollback = false;

                                        if($pospectosInsertados == null || $pospectosInsertados == ""){
                                            $select = "SELECT * FROM prospecto P INNER JOIN cabecera_subida CS USING(id_cab_subida) WHERE CS.id_dispo_subida = :dispo AND P.estado_sincro = 1 ";
                                            $conn = $conexion->prepare($select);
                                            $conn->bindValue(":dispo",$idDispositivo, PDO::PARAM_STR);
                                            $conn->execute();
                                            if($conn->rowCount() > 0){
                                                $ress = $conn->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($ress AS $vl){
                                                     $pospectosInsertados[$vl["id_local"]] = $vl["id_ficha"];
                                                }
                                            }
                                        }

                                        foreach($arrayRotation as $value){


                                            try{
                                                $select = "SELECT * FROM historial_predio WHERE id_ficha = :id_ficha AND anno = :anno AND descripcion = :descripcion AND tipo = :tipo ";
                                                $conn = $conexion->prepare($select);
                                                $conn->bindValue(":id_ficha",$pospectosInsertados[$value["id_ficha"]], PDO::PARAM_STR);
                                                $conn->bindValue(":anno",$value["anno"], PDO::PARAM_STR);
                                                $conn->bindValue(":descripcion",$value["descripcion"], PDO::PARAM_STR);
                                                $conn->bindValue(":tipo","P", PDO::PARAM_STR);
                                                $conn->execute();
                                                if($conn->rowCount() <= 0){
                                                    $insert = "INSERT INTO historial_predio (id_ficha, anno, descripcion, tipo) VALUES (:id_ficha, :anno, :descripcion, 'P') ";
                                                    $conn = $conexion->prepare($insert);
                                                    $conn->bindValue(":id_ficha",$pospectosInsertados[$value["id_ficha"]], PDO::PARAM_STR);
                                                    $conn->bindValue(":anno",$value["anno"], PDO::PARAM_STR);
                                                    $conn->bindValue(":descripcion",$value["descripcion"], PDO::PARAM_STR);
                                                    $conn->execute();
                                                }
                                            }catch(PDOException $e){
                                                $rollback = true;
                                                $mensajeError .= $error."\n";
                                            }

                                            
                                        }

                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();
                                        }
                                    }


                                    if(sizeof($arrayFotosFichas) > 0 && $codigoError == 0){

                                        $conexion->beginTransaction();
                                        $rollback = false;
                                        $con  = 0;
                                        $sumaInsertada += sizeof($arrayFotosFichas);

                                        foreach($arrayFotosFichas as $value){

                                                $idFicha = 0;
                                            
                                                $select = "SELECT MAX(id_ficha) as max_id FROM prospecto F INNER JOIN cabecera_subida CS  USING (id_cab_subida) WHERE CS.id_dispo_subida = ? AND F.id_local = ? AND CS.id_usuario = ? LIMIT 1 ";
                                                $consulta = $conexion->prepare($select);
                                                $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                                                $consulta->bindValue("2",$value["id_ficha_fotos_local"], PDO::PARAM_INT);
                                                $consulta->bindValue("3",$idUsuario, PDO::PARAM_INT);
                                                $consulta->execute();
                                                if($consulta->rowCount() > 0){
                                                    $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                    //$mensajeError.= json_decode($consulta1->fetchAll(PDO::FETCH_ASSOC));
                                                    $idFicha = $r[0]["max_id"];
                                                }

                                                    if($idFicha > 0){

                                                        $fechaHora = $value["fecha_hora_captura"];
                                                        list($justDate, $justTime) = explode(" ", $fechaHora);
                                                        $fechaHoraNombre = str_replace("-", "", $fechaHora);
                                                        $fechaHoraNombre = str_replace(":", "", $fechaHoraNombre);
                                                        $fechaHoraNombre = str_replace(" ", "", $fechaHoraNombre);


                                                        $nombreArchivoAparte = "F".$idFicha."_".$idDispositivo."_".uniqid()."_".$value["id_ficha_fotos_local"]."_".$fechaHoraNombre."_".$value["id_fotos_fichas"].".jpg";
                                                        $ruta_img = "../../../../curimapu_docum/img_android/$nombreArchivoAparte";
                                                        file_put_contents($ruta_img,base64_decode($value["imagen_foto"]));

                                                        if(file_exists($ruta_img)){

                                                            $respuestaFTP = FunRespDOC_GLOBAL_ALL(
                                                                "img_android",
                                                                $nombreArchivoAparte,
                                                                "NO",
                                                                "",
                                                                "",
                                                                "",
                                                                "",
                                                                "");

                                                            if($respuestaFTP){
                                                                try{
                                                                    $select = "SELECT  * FROM fotos INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida  = fotos.id_cabecera ) WHERE fecha_hora = ? AND cabecera_subida.id_dispo_subida = ? AND tipo = ? LIMIT 1";
                                                                    $conn = $conexion->prepare($select);
                                                                    $conn->bindValue("1",$fechaHora, PDO::PARAM_STR);
                                                                    $conn->bindValue("2",$idDispositivo, PDO::PARAM_INT);
                                                                    $conn->bindValue("3","F", PDO::PARAM_STR);
                                                                    $conn->execute();
                                                                    if($conn->rowCount() <= 0){
                                                                        
                                                                            $sql = "INSERT INTO fotos (id_ficha, fecha, hora, fecha_hora, origen, nombre_foto, ruta_foto, id_cabecera, id_local, tipo) VALUES (?,?,?,?,?,?,?,?,?,?)";
                                                                            $consulta = $conexion->prepare($sql);
                                                                            $consulta->bindValue("1",$idFicha, PDO::PARAM_INT);
                                                                            $consulta->bindValue("2",$justDate, PDO::PARAM_STR);
                                                                            $consulta->bindValue("3",$justTime, PDO::PARAM_STR);
                                                                            $consulta->bindValue("4",$fechaHora, PDO::PARAM_STR);
                                                                            $consulta->bindValue("5", "FICHAS", PDO::PARAM_STR);
                                                                            $consulta->bindValue("6",$value["nombre_foto_ficha"], PDO::PARAM_STR);
                                                                            $consulta->bindValue("7",$ruta_img, PDO::PARAM_STR);
                                                                            $consulta->bindValue("8",$idCabecera, PDO::PARAM_INT);
                                                                            $consulta->bindValue("9",$value["id_fotos_fichas"], PDO::PARAM_INT);
                                                                            $consulta->bindValue("10","F", PDO::PARAM_STR);
                                                                            $consulta->execute();
                                                                            if($consulta->rowCount() > 0){
                                                                                $con++;
                                                                                $sumaInsertada+= $value["id_fotos_fichas"];
                                                                            }
    
                                                                    }else{
                                                                        $con++;
                                                                        $sumaInsertada+= $value["id_fotos_fichas"];
                                                                        // $rollback = true;
                                                                        // $mensajeError .= "[INSERT FOTOS FICHAS] fotos duplicadas";
                                                                    }

                                                                    unlink($ruta_img);
    
                                                                }catch(PDOException $e){
                                                                    $rollback = true;
                                                                    $mensajeError .= "[INSERT FOTOS FICHAS]".$e;
                                                                }
                                                            }else{
                                                                $rollback = true;
                                                                $mensajeError .= "[FTP FOTOS FICHAS]".$e;
                                                            }
                                                        
                                                        }else{
                                                            $rollback = true;
                                                            $codigoError = 2;
                                                            $mensajeError .= "(fotos fichas) No existe imagen en ruta, no se realizo el insert.\n";
                                                        }
                                                    }else{
                                                            $rollback = true;
                                                            $codigoError = 2;
                                                            $mensajeError .= "(fotos fichas) SIN ID DE FICHA .\n".$select;
                                                    }
                                        }

                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();

                                            if($con != sizeof($arrayFotosFichas)){
                                                $codigoError = 2;
                                                $mensajeError .= "(fotos fichas) cantidad de registros (".sizeof($arrayFotosFichas).") obtenidos no coincide con la cantidad de registros insertados (".$con.").\n";
                                            }
                                        }


                                    }

                                    if(sizeof($arrayVisitas) > 0  &&  $codigoError == 0){

                                        $conexion->beginTransaction();
                                        $rollback = false;

                                        $cont = 0;
                                        $sumaInsertada+= sizeof($arrayVisitas);
                                        foreach($arrayVisitas as $value ){
                        
                                            try{

                                                $select = "SELECT  * FROM visita INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida = visita.id_cabecera) WHERE id_dispo_subida = ? AND fecha_r = ? AND hora_r = ?";
                                                $conn = $conexion->prepare($select);
                                                $conn->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                                                $conn->bindValue("2",$value["fecha_r"], PDO::PARAM_STR);
                                                $conn->bindValue("3",$value["hora_r"], PDO::PARAM_STR);
                                                $conn->execute();
                                                if($conn->rowCount() <= 0){

                                                    $sql = "INSERT INTO visita 
                                                    (id_ac, id_est_vis, fecha_r, hora_r, estado_fen, estado_crec, estado_male, estado_fito, cosecha, estado_gen_culti, hum_del_suelo, obs, recome, obs_cre, obs_male, obs_fito, obs_cose, obs_gen, obs_hum, id_cabecera, id_visita_local, id_usuario, porcentaje_humedad) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,?, ?, ?, ?);";
                                                    $consulta = $conexion->prepare($sql);
                                                    $consulta->bindValue("1",$value["id_ac"], PDO::PARAM_INT);
                                                    $consulta->bindValue("2",$value["id_est_vis"], PDO::PARAM_INT);
                                                    $consulta->bindValue("3",$value["fecha_r"], PDO::PARAM_STR);
                                                    $consulta->bindValue("4",$value["hora_r"], PDO::PARAM_STR);
                                                    $consulta->bindValue("5",$value["estado_fen"], PDO::PARAM_STR);
                                                    $consulta->bindValue("6",$value["estado_crec"], PDO::PARAM_STR);
                                                    $consulta->bindValue("7",$value["estado_male"], PDO::PARAM_STR);
                                                    $consulta->bindValue("8",$value["estado_fito"], PDO::PARAM_STR);
                                                    $consulta->bindValue("9",$value["cosecha"], PDO::PARAM_STR);
                                                    $consulta->bindValue("10",$value["estado_fen_culti"], PDO::PARAM_STR);
                                                    $consulta->bindValue("11",$value["hum_del_suelo"], PDO::PARAM_STR);
                                                    $consulta->bindValue("12",$value["obs"], PDO::PARAM_STR);
                                                    $consulta->bindValue("13",$value["recome"], PDO::PARAM_STR);
                                                    $consulta->bindValue("14",($value["obs_creci"]!=null) ? $value["obs_creci"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("15",($value["obs_maleza"]!=null) ? $value["obs_maleza"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("16",($value["obs_fito"]!=null) ? $value["obs_fito"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("17",($value["obs_cosecha"]!=null) ? $value["obs_cosecha"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("18",($value["obs_overall"]!=null) ? $value["obs_overall"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("19",($value["obs_humedad"]!=null) ? $value["obs_humedad"] : "", PDO::PARAM_STR);
                                                    $consulta->bindValue("20",$idCabecera, PDO::PARAM_INT);
                                                    $consulta->bindValue("21",$value["id_visita"], PDO::PARAM_INT);
                                                    $consulta->bindValue("22",$idUsuario, PDO::PARAM_INT);
                                                    $consulta->bindValue("23",($value["percent_humedad"]!=null) ? $value["percent_humedad"] : "", PDO::PARAM_STR);
                                                    $consulta->execute();
                                                    if($consulta->rowCount() > 0){
                                                        $cont++;

                                                        $sumaInsertada+=$value["id_visita"];
                                                    }
                                                }else{
                                                   $cont++;
                                                   $sumaInsertada+= $value["id_visita"];
                                                }
                        
                                            }catch(PDOException $e){
                                                $rollback = true;
                                            }
                                        }


                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();

                                            if($cont != sizeof($arrayVisitas)){
                                                $codigoError = 2;
                                                $mensajeError .= " (VISITAS) cantidad de registros (".sizeof($arrayVisitas).") obtenidos no coincide con la cantidad de registros insertados (".$cont.").\n";
                                            }
                                        }
                                        
                        
                                    }
                
                                    if(sizeof($arrayDetalles) > 0 &&  $codigoError == 0){

                                        $conexion->beginTransaction();
                                        $rollback = false;


                                        $con = 0;
                                        $sumaInsertada+= sizeof($arrayDetalles);
                                        foreach($arrayDetalles as $value ){

                                            $idVisita = 0;

                                            $sql = "SELECT MAX(id_visita) as max_id FROM visita INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida = visita.id_cabecera) 
                                            WHERE id_dispo_subida = ? AND cabecera_subida.id_usuario = ?  AND id_visita_local = ?  LIMIT 1;";
                                            $consulta = $conexion->prepare($sql);
                                            $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                                            $consulta->bindValue("2",$idUsuario, PDO::PARAM_INT);
                                            $consulta->bindValue("3",$value["id_visita"], PDO::PARAM_INT);
                                            $consulta->execute();
                                            if($consulta->rowCount() > 0){
                                                
                                                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                //$mensajeError.= json_decode($consulta1->fetchAll(PDO::FETCH_ASSOC));
                                                $idVisita = $r[0]["max_id"];
                                            }


                                            try{

                                                if($idVisita > 0){

                                                    $sql = "INSERT INTO detalle_visita_prop (id_visita, id_prop_mat_cli, valor, id_cabecera, id_local, user_crea ) VALUES (?, ?, ?, ?, ?, ?)";
                                                    $consulta = $conexion->prepare($sql);
                                                    $consulta->bindValue("1",$idVisita, PDO::PARAM_INT);
                                                    $consulta->bindValue("2",$value["id_prop_mat_cli"], PDO::PARAM_INT);
                                                    $consulta->bindValue("3",$value["valor"], PDO::PARAM_STR);
                                                    $consulta->bindValue("4",$idCabecera, PDO::PARAM_INT);
                                                    $consulta->bindValue("5",$value["id_det_vis_prop_detalle"], PDO::PARAM_INT);
                                                    $consulta->bindValue("6",$arrayUsuarios[$idUsuario], PDO::PARAM_STR);
                                                    $consulta->execute();
                                                    if($consulta->rowCount() > 0){
                                                        $con++;
                                                        $sumaInsertada+=$value["id_det_vis_prop_detalle"];
                                                    }
                                                    
                                                }else{
                                                    $codigoError = 2;
                                                    $mensajeError .= "(DETALLES) NO se encontro visita insertada.  dispositivo = ".$idDispositivo.", idUsuario = ".$idUsuario.", idCabecera = ".$idCabecera.",  local = ".$value['id_visita']."  \n";
                                                }
                                                
                        
                                            }catch(PDOException $e){
                                                $rollback = true;
                                            }
                                        }

                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();

                                            if($con != sizeof($arrayDetalles)){
                                                $codigoError = 2;
                                                $mensajeError .= "(DETALLES) cantidad de registros (".sizeof($arrayDetalles).") obtenidos no coincide con la cantidad de registros insertados (".$con.").\n";
                                            }
                                        }
                                    }
                
                                    if(sizeof($arrayFotos) > 0 &&  $codigoError == 0){
                                        $conexion->beginTransaction();
                                        $rollback = false;

                                        $con = 0;
                                        $sumaInsertada+= sizeof($arrayFotos);
                                        foreach($arrayFotos as $value ){

                                                $idVisita = 0;

                                                $sql = "SELECT MAX(id_visita) as max_id FROM visita INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida = visita.id_cabecera) 
                                                WHERE id_dispo_subida = ? AND cabecera_subida.id_usuario = ? AND id_visita_local = ?  LIMIT 1;";
                                                $consulta = $conexion->prepare($sql);
                                                $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                                                $consulta->bindValue("2",$idUsuario, PDO::PARAM_INT);
                                                $consulta->bindValue("3",$value["id_visita_foto"], PDO::PARAM_INT);
                                                $consulta->execute();
                                                if($consulta->rowCount() > 0){
                                                    
                                                    $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                    //$mensajeError.= json_decode($consulta1->fetchAll(PDO::FETCH_ASSOC));
                                                    $idVisita = $r[0]["max_id"];
                                                }

                                                if($idVisita  > 0){

                                                    $fechaHora = $value["fecha"]." ".$value["hora"];
                                                    $fechaHoraNombre = str_replace("-", "", $fechaHora);
                                                    $fechaHoraNombre = str_replace(":", "", $fechaHoraNombre);
                                                    $fechaHoraNombre = str_replace(" ", "", $fechaHoraNombre);
                            
                                                    $nombreArchivoAparte = "V".$idVisita."_".$idDispositivo."_".uniqid()."_".$value["fieldbook"]."_".$value["id_visita_foto"]."_".$fechaHoraNombre."_".$value["id_foto"].".jpg";
                                                    $ruta_img = "../../../../curimapu_docum/img_android/$nombreArchivoAparte";
                                                    file_put_contents($ruta_img,base64_decode($value["imagen"]));						
                                                    
                                                    if(file_exists($ruta_img)){


                                                        $respuestaFTP = FunRespDOC_GLOBAL_ALL(
                                                            "img_android",
                                                            $nombreArchivoAparte,
                                                            "NO",
                                                            "",
                                                            "",
                                                            "",
                                                            "",
                                                            "");


                                                        if($respuestaFTP){
                                                            try{

                                                                $select = "SELECT  * FROM fotos INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida = fotos.id_cabecera) WHERE fecha_hora = ? AND cabecera_subida.id_dispo_subida = ? AND tipo = ? ";
                                                                $conn = $conexion->prepare($select);
                                                                $conn->bindValue("1",$value["fecha"], PDO::PARAM_STR);
                                                                $conn->bindValue("2",$idDispositivo, PDO::PARAM_INT);
                                                                $conn->bindValue("3","V", PDO::PARAM_STR);
                                                                $conn->execute();
                                                                if($conn->rowCount() <= 0){


                                                                    $sql = "INSERT INTO fotos (id_visita, fecha, hora, fecha_hora, origen, field_book, vista, plano, favorita, nombre_foto, ruta_foto,id_cabecera,id_local, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,?,?,?,?)";
                                                                    $consulta = $conexion->prepare($sql);
                                                                    $consulta->bindValue("1",$idVisita, PDO::PARAM_INT);
                                                                    $consulta->bindValue("2",$value["fecha"], PDO::PARAM_STR);
                                                                    $consulta->bindValue("3",$value["hora"], PDO::PARAM_STR);
                                                                    $consulta->bindValue("4",$fechaHora, PDO::PARAM_STR);
                                                                    $consulta->bindValue("5","visita", PDO::PARAM_STR);
                                                                    $consulta->bindValue("6",$value["fieldbook"], PDO::PARAM_INT);
                                                                    if($value["vista"] == "0") $vista = "cliente";
                                                                    if($value["vista"] == "2") $vista = "agricultor";
                                                                    $consulta->bindValue("7",$vista, PDO::PARAM_STR);
                                                                    $consulta->bindValue("8",($value["plano"] == 0) ? "general" : "detalle" , PDO::PARAM_STR);
                                                                    $consulta->bindValue("9",($value["favorita"]) ? 1 : 0, PDO::PARAM_INT);
                                                                    $consulta->bindValue("10",$value["nombre_foto"], PDO::PARAM_STR);
                                                                    $consulta->bindValue("11",$ruta_img, PDO::PARAM_STR);
                                                                    $consulta->bindValue("12",$idCabecera, PDO::PARAM_INT);
                                                                    $consulta->bindValue("13",$value["id_foto"], PDO::PARAM_INT);
                                                                    $consulta->bindValue("14","V", PDO::PARAM_INT);
                                                                    $consulta->execute();
                                                                    if($consulta->rowCount() > 0){
                                                                        $con++;
                                                                        $sumaInsertada+=$value["id_foto"];

                                                                    }
                                                                }else{
                                                                    $con++;
                                                                    $sumaInsertada+= $value["id_foto"];
                                                                    // $rollback = true;
                                                                    // $mensajeError .= "[INSERT FOTOS] fotos duplicadas";
                                                                }

                                                                unlink($ruta_img);

                                                            }catch(PDOException $e){
                                                                $rollback = true;
                                                                $mensajeError .= "[INSERT FOTOS]".$e;
                                                            }
                                                        }else{
                                                            $rollback = true;
                                                            $mensajeError .= "[FTP FOTOS FICHAS]".$e;
                                                        }
                    
                                                    }else{
                                                        $codigoError = 2;
                                                        $mensajeError .= "(fotos) No existe imagen en ruta, no se realizo el insert.\n";
                                                    }

                                                }else{
                                                    $codigoError = 2;
                                                    $mensajeError .= "(DETALLES) NO se encontro visita insertada.\n";
                                                }
                                        }

                                        if($rollback){
                                            $conexion->rollback();
                                            $codigoError = 2;
                                            $mensajeError .= " ERROR ROLLBACK\n";
                                        }else{
                                            $conexion->commit();

                                            if($con != sizeof($arrayFotos)){
                                                $codigoError = 2;
                                                $mensajeError .= "(fotos) cantidad de registros (".sizeof($arrayFotos).") obtenidos no coincide con la cantidad de registros insertados (".$con.").\n";
                                            }
                                        }
                                    }
                                    
                                    if(sizeof($arrayErrores) > 0  &&  $codigoError == 0){
                                        // $sumaInsertada+= sizeof($arrayFotos);
                                        foreach($arrayErrores as $value){

                                            $sql = "INSERT INTO errores_tableta (codigo_error, mensaje_error, dispo_error, id_cabecera_error) VALUES (? , ? , ? , ? );";
                                            $consulta = $conexion->prepare($sql);
                                            $consulta->bindValue("1",$value["codigo_error"], PDO::PARAM_INT);
                                            $consulta->bindValue("2",$value["mensaje_error"], PDO::PARAM_STR);
                                            $consulta->bindValue("3",$idDispositivo, PDO::PARAM_INT);
                                            $consulta->bindValue("4",$idCabecera, PDO::PARAM_INT);
                                            $consulta->execute();
                                            
                                        }
                                    }


                                    

                                    // $sql = "SELECT * FROM prospecto WHERE id_cab_subida = ?;";    
                                    // $consulta = $conexion->prepare($sql);
                                    // $consulta->bindValue("1", $idCabecera, PDO::PARAM_INT);
                                    // $consulta->execute();
                                    // if($consulta->rowCount() > 0){
                                    //     $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    //     foreach($r as $val){
                                    //         $sumaInsertada+=$val["id_local"];
                                    //     }
                                    // }

                                    // $sql = "SELECT * FROM visita WHERE id_cabecera = ?;";    
                                    // $consulta = $conexion->prepare($sql);
                                    // $consulta->bindValue("1", $idCabecera, PDO::PARAM_INT);
                                    // $consulta->execute();
                                    // if($consulta->rowCount() > 0){
                                    //     $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    //     foreach($r as $val){
                                    //         $sumaInsertada+=$val["id_visita_local"];
                                    //     }
                                    // }
                                    // $sql = "SELECT * FROM detalle_visita_prop WHERE id_cabecera = ?;";    
                                    // $consulta = $conexion->prepare($sql);
                                    // $consulta->bindValue("1", $idCabecera, PDO::PARAM_INT);
                                    // $consulta->execute();
                                    // if($consulta->rowCount() > 0){
                                    //     $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    //     foreach($r as $val){
                                    //         $sumaInsertada+=$val["id_local"];
                                    //     }
                                    // }
                                    // $sql = "SELECT * FROM fotos WHERE id_cabecera = ? ;";    
                                    // $consulta = $conexion->prepare($sql);
                                    // $consulta->bindValue("1", $idCabecera, PDO::PARAM_INT);
                                    // $consulta->execute();
                                    // if($consulta->rowCount() > 0){
                                    //     $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    //     foreach($r as $val){
                                    //         $sumaInsertada+=$val["id_local"];
                                    //     }
                                    // }

                                    if($sumaInsertada != $cantidadSuma){
                                        $codigoError = 2;
                                        $mensajeError .= "SUMA NO COINCIDE SUMA ENVIADA DE TABLETA = ".$cantidadSuma." !=  SUMA INSERTADA = ".$sumaInsertada." \n  MATEMATICA PARA LA SUMA (SUMA(ides) + Tamano Array ) \n ";
                                    }



                                }else{
                                    $codigoError = 2;
                                    $mensajeError .= "id cabecera es 0 , no se realizo ningun insert \n";
                                }
                                
                            }
                        }catch(PDOException $e){
                                $codigoError = 1;
                                $mensajeError .= "(INSERT DATOS)".$e->getMessage()."\n";
                        }

                    }
                    
        
                }else{
                    $codigoError = 2;
                    $mensajeError .= "ID DISPOSITIVO = ".$idDispositivo." E ID USUARIO = ".$idUsuario." NO CORRESPONDEN ";
                }
    
    
                if($codigoError > 0 && $mensajeError != ""){
    
                    $DescErrorCorreo="";   
                    $DescErrorCorreo=" HAN OCURRIDO ERRORES AL SUBIR DATOS: \n\n";
                    $DescErrorCorreo.="  - ID DISPOSITIVO: ".$idDispositivo."\n";
                    $DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
                    $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 		
                    $DescErrorCorreo.="\n".$mensajeError; 
                    //ENVIAR CORREO
                    $Cabecera="From: ERROR MODULE CURIMAPU<>";
                    mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);
                    //FIN ENVIAR CORREO
                }else{
                    $mensajeError .= "TODO BIEN";
                }

                $json_string = json_encode(array("codigo_respuesta" => $codigoError,"mensaje_respuesta" => $mensajeError, "cabecera_respuesta" => $idCabecera));
            }else{
                $json_string = json_encode(array("codigo_respuesta" => 5,"mensaje_respuesta" => "NO POSEE ULTIMA VERSION DE APLICACION", "cabecera_respuesta" => null));

                $DescErrorCorreo="";   
                $DescErrorCorreo=" HAN OCURRIDO ERRORES AL SUBIR DATOS: \n\n";
                $DescErrorCorreo.="  - ID DISPOSITIVO: ".$idDispositivo."\n";
                $DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
                $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 		
                $DescErrorCorreo.="\n NO POSEE ULTIMA VERSION "; 
                //ENVIAR CORREO
                $Cabecera="From: ERROR MODULE CURIMAPU<>";
                mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);

            }
        }else{
            $json_string = json_encode(array("codigo_respuesta" => 5,"mensaje_respuesta" => "NO POSEE ULTIMA VERSION DE APLICACION", "cabecera_respuesta" => null));

            $DescErrorCorreo="";   
            $DescErrorCorreo=" HAN OCURRIDO ERRORES AL SUBIR DATOS: \n\n";
            $DescErrorCorreo.="  - ID DISPOSITIVO: ".$idDispositivo."\n";
            $DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
            $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 		
            $DescErrorCorreo.="\n NO POSEE ULTIMA VERSION "; 
            //ENVIAR CORREO
            $Cabecera="From: ERROR MODULE CURIMAPU<>";
            mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);
        }


        header('Content-Type: application/json');
       // mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",json_encode(array("codigo_respuesta" => $codigoError,"mensaje_respuesta" => $mensajeError, "cabecera_respuesta" => $idCabecera)),$Cabecera);
		echo $json_string;

    }

/*     $json_string = json_encode(array("codigo_respuesta" => 2,"mensaje_respuesta" => "No se creo el registro"));
		echo $json_string; */



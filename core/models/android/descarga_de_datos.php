<?php


    require_once '../../db/conectarse_db.php';

    $conexion = new Conectar();
    $conexion = $conexion->conexion();


    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');



    if($_SERVER['REQUEST_METHOD'] == 'GET'){



        if(isset($_GET['id']) && isset($_GET['id_usuario']) && isset($_GET['version']) ){


            $id = $_GET['id'];
            $idUsuario  = $_GET['id_usuario'];
            $version  = $_GET['version'];
            $idTipoUsuario = 3;

            //$imei = $_GET['imei'];

            //$id = (isset($_GET['id'])) ? $_GET['id'] : 0;


            /* USUARIO */
            $sql = "SELECT * FROM usuarios  INNER JOIN usuario_tipo_usuario USING (id_usuario) WHERE id_usuario = ? GROUP BY usuarios.id_usuario;";    
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue("1",$idUsuario, PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $idTipoUsuario = $r[0]["id_tu"];
            }

    $arrayGeneral = array();

    $arrayDetalleProp = array();
    $arrayRotation = array();
    $arrayValorProp = array();
    $arrayVisita = array();
    $arrayAnexos = array();
    $arrayFichas = array();
    $arrayRegion = array();
    $arrayProvincia = array();
    $arrayComuna = array();
    $arrayEspecie = array();
    $arrayMaterial = array();
    $arrayTemporadas = array();
    $arrayValorUM = array();
    $arrayAgricultores = array();
    $arrayUsuarios = array();
    $arrayPredios = array();
    $arrayLotes = array();
    $arrayTipoRiego = array();
    $arrayTipoSuelo = array();
    $arrayMaquinaria = array();
    $arrayTipoMaquinaria = array();
    $arrayTipoTenenciaTerreno = array();
    $arrayFichaMaquinaria = array();
    $arrayTipoCliente = array();
    $arrayCardViews = array();
    $arrayPCM = array();
    $arrayClientes = array();
    $arrayQuotation = array();
    $arrayProblemas = array();
    $arrayPredAgrTemp = array();



    // CODIGO PARA LLENAR CLI_PCM CON DATOS DE CLIENTES Y DE PRO_CLI_MAT

    // $sql = "SELECT * FROM cliente ";
    // $consulta = $conexion->prepare($sql);
    // $consulta->execute();
    // if($consulta->rowCount() > 0){
    //     $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
    //     foreach($r as $val){
    //         $sql2 = "SELECT * FROM prop_cli_mat";
    //         $consulta2 = $conexion->prepare($sql2);
    //         $consulta2->execute();
    //         if($consulta2->rowCount() > 0){
    //             $r2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);
    //             foreach($r2 as $val2){
    //                 $sql3 = "INSERT INTO cli_pcm (id_cli, id_prop_mat_cli, ver, registrar) VALUES (?, ?, ?, ?)";
    //                 $consulta3 = $conexion->prepare($sql3);
    //                 $consulta3->bindValue("1", $val["id_cli"], PDO::PARAM_INT);
    //                 $consulta3->bindValue("2", $val2["id_prop_mat_cli"], PDO::PARAM_INT);
    //                 $consulta3->bindValue("3", 1, PDO::PARAM_INT);
    //                 $consulta3->bindValue("4", 1, PDO::PARAM_INT);
    //                 $consulta3->execute();
    //             }
    //         }
    //     }
    // }

    $problema = "";
    $codigoProblema  = 1;

    try{

        $sql = "SELECT version_apk FROM empresa WHERE id_empresa_SAP = ? AND version_apk = ? LIMIT 1";
        //  echo $sql;
        $consulta  = $conexion->prepare($sql);
        $consulta->bindValue("1", "1", PDO::PARAM_STR);
        $consulta->bindValue("2", $version, PDO::PARAM_STR);
        $consulta->execute();

        // echo $consulta->rowCount();

        if($consulta->rowCount() <= 0){
            $problema = "VERSION DE APLICACION NO ES LA VERSION ACTUAL";
            $codigoProblema = 5;

        }
    }catch(PDOException $e){
        $problema  = $e->getMessage();
        $codigoProblema = 2;
    }


    if($problema == "" || $codigoProblema <= 1){


        /* CROP ROTATIONS */


    try{
        $where = "";
        if($idTipoUsuario != 5){

          


            $where = "  WHERE historial_predio.tipo = 'F' AND ( (supervisores.id_sup_us = ? || supervisores.id_us_sup = ? || F.id_usuario = ?)   OR   (F.id_ficha IN (SELECT id_ficha FROM anexo_contrato WHERE id_ac IN  (SELECT id_ac FROM usuario_anexo WHERE id_usuario = ?) ) ))";
        }

        $sql = "SELECT * FROM supervisores 
        RIGHT JOIN ficha F ON (F.id_usuario = supervisores.id_us_sup)
        INNER JOIN historial_predio ON (historial_predio.id_ficha = F.id_ficha)
        $where
        GROUP BY historial_predio.id_his_pre ";    
        $consulta = $conexion->prepare($sql);
        if($idTipoUsuario != 5){
            $consulta->bindValue("1", $idUsuario, PDO::PARAM_INT);
            $consulta->bindValue("2", $idUsuario, PDO::PARAM_INT);
            $consulta->bindValue("3", $idUsuario, PDO::PARAM_INT);
            $consulta->bindValue("4", $idUsuario, PDO::PARAM_INT);
        }
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_his_pre" => $val["id_his_pre"],
                    "id_ficha" => $val["id_ficha"],
                    "anno" => $val["anno"],
                    "descripcion"=>$val["descripcion"],
                    "id_ficha_local"=>$val["id_local"],
                    "estado_subida" => 1
                );

                array_push($arrayRotation, $tmp);
            }
        }
	}catch(PDOException $e){
        $problema  = $e->getMessage();
        $codigoProblema = 2;
    }

        /* CLIENTES */
		try{
        $sql = "SELECT * FROM contrato_cliente CL INNER JOIN cliente C USING(id_cli) ";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_cli" => $val["id_cli"],
                    "id_materiales" => $val["id_esp"],
                    "razon_social" => $val["razon_social"]
                );

                array_push($arrayClientes, $tmp);
            }
        }
	}catch(PDOException $e){
        $problema  = $e->getMessage();
        $codigoProblema = 2;
    }


        /* FICHAS */

        // "coo_utm_ref" => $val["coo_utm_ref"],
        // "coo_utm_ampros" => $val["coo_utm_ampros"],
        try{
            $where = "";
            if($idTipoUsuario != 5){
                $where = "  AND ((S.id_sup_us = ? || S.id_us_sup = ? || F.id_usuario = ?) OR (F.id_ficha IN  (SELECT id_ficha FROM anexo_contrato WHERE id_ac IN  (SELECT id_ac FROM usuario_anexo WHERE id_usuario = ?)))) ";
            }

            $sql = "SELECT * FROM ficha F
            LEFT JOIN supervisores S ON (S.id_us_sup = F.id_usuario OR S.id_sup_us = F.id_usuario ) 
            LEFT JOIN lote L USING(id_lote)
            WHERE id_est_fic = ? $where
            GROUP BY F.id_ficha ";    



            // echo $sql;
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue("1", 2, PDO::PARAM_INT);
            if($idTipoUsuario != 5){
                $consulta->bindValue("2", $idUsuario, PDO::PARAM_INT);
                $consulta->bindValue("3", $idUsuario, PDO::PARAM_INT);
                $consulta->bindValue("4", $idUsuario, PDO::PARAM_INT);
                $consulta->bindValue("5", $idUsuario, PDO::PARAM_INT);
            }
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_ficha" => $val["id_ficha"],
                        "id_ficha_local_ficha" => $val["id_local"],
                        "id_est_fic" => $val["id_est_fic"],
                        "id_tempo" => $val["id_tempo"],
                        "id_usuario" => $val["id_usuario"],
                        "id_agric" => $val["id_agric"],
                        "id_comuna" => $val["id_comuna"],
                        "id_region" => $val["id_region"],
                        "oferta_de_negocio" => $val["oferta_de_negocio"],
                        "localidad" => $val["localidad"],
                        "ha_disponibles" => $val["ha_disponibles"],
                        "id_pred" => $val["id_pred"],
                        "id_lote" => $val["id_lote"],
                        "id_tipo_suelo" => $val["id_tipo_suelo"],
                        "id_tipo_riego" => $val["id_tipo_riego"],
                        "experiencia" => $val["experiencia"],
                        "id_tipo_tenencia_maquinaria" => $val["id_tipo_tenencia_maquinaria"],
                        "id_tipo_tenencia_terreno" => $val["id_tipo_tenencia_terreno"],
                        "maleza" => $val["maleza"],
                        "estado_general" => $val["estado_general"],
                        "coo_utm_ampros" => $val["norting"]." ".$val["easting"],
                        "norting" => $val["norting"],
                        "easting" => $val["easting"],
                        "obs" => $val["obs"],
                        "subida" => true
                    );

                    array_push($arrayFichas, $tmp);
                }
            }
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

            /* PREDIOS  */
			try{
				$sql = "SELECT  *  FROM predio ";    
				$consulta = $conexion->prepare($sql);
				$consulta->execute();
				if($consulta->rowCount() > 0){
					$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
					foreach($r as $val){
						$tmp = array(
							"id_pred" => $val["id_pred"],
							"id_comuna" => $val["id_comuna"],
							"id_region" => $val["id_region"],
							"nombre" => $val["nombre"],
							"coo_utm_ref" => $val["coo_utm_ref"]
						);
	
						array_push($arrayPredios, $tmp);
					}
				}
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

           
            /* agri_pred_temp  */
	  try{		
            $sql = "SELECT  *  FROM agri_pred_temp ; ";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_agri_pred_temp" => $val["id_agri_pred_temp"],
                        "id_agric" => $val["id_agric"],
                        "id_pred" => $val["id_pred"],
                        "id_tempo" => $val["id_tempo"],
                        "norting" => $val["norting"],
                        "easting" => $val["easting"]
                    );

                    array_push($arrayPredAgrTemp, $tmp);
                }
            }
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

            /* LOTES  */
			try{
				$sql = "SELECT  *  FROM lote ";    
				$consulta = $conexion->prepare($sql);
				$consulta->execute();
				if($consulta->rowCount() > 0){
					$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
					foreach($r as $val){
						$tmp = array(
							"id_lote" => $val["id_lote"],
							"id_pred" => $val["id_pred"],
							"id_comuna" => $val["id_comuna"],
							"id_region" => $val["id_region"],
							"nombre" => $val["nombre"],
							"coo_utm_ampros" => $val["coo_utm_ampros"],
							"nombre_ac" => $val["nombre_ac"],
							"telefono_ac" => $val["telefono_ac"]
						);
	
						array_push($arrayLotes, $tmp);
					}
				}
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
            /* TIPO SUELO  */
			try{
            $sql = "SELECT  *  FROM tipo_suelo ";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_tipo_suelo" => $val["id_tipo_suelo"],
                        "descripcion" => $val["descripcion"]
                    );

                    array_push($arrayTipoSuelo, $tmp);
                }
            }
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}


            
            /* TIPO RIEGo  */
			try{
				$sql = "SELECT  *  FROM tipo_riego ";    
				$consulta = $conexion->prepare($sql);
				$consulta->execute();
				if($consulta->rowCount() > 0){
					$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
					foreach($r as $val){
						$tmp = array(
							"id_tipo_riego" => $val["id_tipo_riego"],
							"descripcion" => $val["descripcion"]
						);
	
						array_push($arrayTipoRiego, $tmp);
					}
				}
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
            
        
        /* VALORES PROPIEDADES */
		try{
			$sql = "SELECT 
						detalle_visita_prop.id_visita,
						detalle_visita_prop.id_prop_mat_cli,
						detalle_visita_prop.valor
					FROM detalle_visita_prop 
					INNER JOIN cabecera_subida ON (cabecera_subida.id_cab_subida = detalle_visita_prop.id_cabecera)
					WHERE cabecera_subida.estado = ? ";    
			$consulta = $conexion->prepare($sql);
			$consulta->bindValue("1", 1, PDO::PARAM_INT);
			$consulta->execute();
			if($consulta->rowCount() > 0){
				$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
				foreach($r as $val){
					$tmp = array(
						"id_visita" => $val["id_visita"],
						"id_prop_mat_cli" => $val["id_prop_mat_cli"],
						"valor" => $val["valor"],
						"estado_detalle" => 1
					);
	
					array_push($arrayValorProp, $tmp);
				}
			}
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
			
			
			
        $where = "";
        if($idTipoUsuario != 5){
            $where = " INNER JOIN usuario_anexo ON (usuario_anexo.id_ac = anexo_contrato.id_ac) LEFT JOIN supervisores ON (supervisores.id_us_sup = usuario_anexo.id_usuario)  WHERE ( supervisores.id_sup_us = ? || supervisores.id_us_sup = ? || usuario_anexo.id_usuario = ? )";
        }

        /* ANEXOS */
		try{
			$sql = "SELECT 
					anexo_contrato.id_ac,
					CAT.id_tempo,
					contrato_agricultor.id_agric,
					anexo_contrato.id_ficha,
					anexo_contrato.id_lote,
					anexo_contrato.id_materiales,
					anexo_contrato.num_anexo,
					lote.nombre,
					materiales.id_esp,
					anexo_contrato.superficie
				FROM anexo_contrato
				INNER JOIN materiales ON (materiales.id_materiales = anexo_contrato.id_materiales)
				INNER JOIN lote ON (lote.id_lote = anexo_contrato.id_lote)
				LEFT JOIN contrato_agricultor ON (contrato_agricultor.id_cont = anexo_contrato.id_cont)
                LEFT JOIN contrato_anexo_temporada CAT ON (contrato_agricultor.id_cont = CAT.id_cont)
				$where
				GROUP BY anexo_contrato.id_ac ";    
	
	
		 // echo $sql;
	
			$consulta = $conexion->prepare($sql);
			if($idTipoUsuario != 5){
				$consulta->bindValue("1", $idUsuario, PDO::PARAM_INT);
				$consulta->bindValue("2", $idUsuario, PDO::PARAM_INT);
				$consulta->bindValue("3", $idUsuario, PDO::PARAM_INT);
			}
			$consulta->execute();
			if($consulta->rowCount() > 0){
			$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
			foreach($r as $val){
			$tmp = array(
				"id_ac" => $val["id_ac"],
				"id_tempo" => $val["id_tempo"],
				"id_ficha" => $val["id_ficha"],
				"id_agric" => $val["id_agric"],
				"id_materiales" => $val["id_materiales"],
				"num_anexo" => $val["num_anexo"],
				"id_esp" => $val["id_esp"],
				"nombre_potrero" => $val["nombre"],
				"id_potrero" => $val["id_lote"],
				"superficie" => round($val["superficie"], 0),
			);
	
			array_push($arrayAnexos, $tmp);
			}
		 }
	 }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

        /* AGRICULTORES */
		try{
        $sql = "SELECT 
            agricultor.id_agric,
            agricultor.id_comuna,
            agricultor.id_region,
            agricultor.rut,
            agricultor.razon_social,
            agricultor.telefono
        FROM agricultor 
        ORDER BY razon_social ASC
        ";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
            $tmp = array(
                "id_agric" => $val["id_agric"],
                "id_comuna" => $val["id_comuna"],
                "id_region" => $val["id_region"],
                "rut" => $val["rut"],
                "razon_social" => $val["razon_social"],
                "telefono" => $val["telefono"]
            );

            array_push($arrayAgricultores, $tmp);
            }
        }
	}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
                        
        /* TEMPORADAS */
		try{
        $sql = "SELECT * FROM temporada ORDER BY nombre DESC;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_tempo" => $val["id_tempo"],
                    "nombre" => $val["nombre"],
                    "desde" => $val["desde"],
                    "hasta"=>$val["hasta"]
                );

                array_push($arrayTemporadas, $tmp);
                
            }
        }
	}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

        /* REGION */
		try{
        $sql = "SELECT * FROM region;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_region" => $val["id_region"],
                    "nombre" => $val["nombre"],
                    "id_pais" => $val["id_pais"]
                );

                array_push($arrayRegion, $tmp);
                
            }
        }
    }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
    
    
            /* USUARIO */
			try{
            $sql = "SELECT * FROM usuarios  INNER JOIN usuario_tipo_usuario USING (id_usuario) GROUP BY usuarios.id_usuario;";    
            $consulta = $conexion->prepare($sql);
            // $consulta->bindValue("1",3, PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_usuario" => $val["id_usuario"],
                        "rut" => $val["rut"],
                        "user" => $val["user"],
                        "nombre" => $val["nombre"],
                        "apellido_p" => $val["apellido_p"],
                        "apellido_m" => $val["apellido_m"],
                        "telefono" => $val["telefono"],
                        "id_region" => $val["id_region"],
                        "id_pais" => $val["id_pais"],
                        "id_comuna" => $val["id_comuna"],
                        "direccion" => $val["direccion"],
                        "supervisa_otro" => $val["supervisa_otro"],
                        "pass" => $val["pass"],
                        "email" => $val["email"],
                        "tipo_usuario" => $val["id_tu"]
                    );
                    array_push($arrayUsuarios, $tmp);
                }
            }                   
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
    
    
            
        /* COMUNA */
		try{
        $sql = "SELECT * FROM comuna;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_comuna" => $val["id_comuna"],
                    "nombre" => $val["nombre"],
                    "id_provincia" => $val["id_provincia"]
                );

                array_push($arrayComuna, $tmp);
                
            }
        }
    }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
        /* PROVINCIA */
		try{
        $sql = "SELECT * FROM provincia;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_provincia" => $val["id_provincia"],
                    "nombre" => $val["nombre"],
                    "id_region" => $val["id_region"]
                );

                array_push($arrayProvincia, $tmp);
                
            }
        }    
    }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
                
        /* ESPECIE */
		try{
        $sql = "SELECT * FROM especie;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_esp" => $val["id_esp"],
                    "nombre" => $val["nombre"]
                );

                array_push($arrayEspecie, $tmp);
            }
        }
    	}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
        
        /* MATERIALES */
		try{
        $sql = "SELECT * FROM materiales;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_materiales" => $val["id_materiales"],
                    "id_esp" => $val["id_esp"],
                    "nom_fantasia" => $val["nom_fantasia"],
                    "nom_hibrido"=>$val["nom_hibrido"]
                );

                array_push($arrayMaterial, $tmp);
            }
        }
    }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
        /* VALORES UM */
		try{
        $sql = "SELECT * FROM unidad_medida;";    
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            foreach($r as $val){
                $tmp = array(
                    "id_um" => $val["id_um"],
                    "nombre" => $val["nombre"]
                );

                array_push($arrayValorUM, $tmp);
            }
        }
	}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

            /* MAQUINARIA */
			try{
            $sql = "SELECT * FROM maquinaria;";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_maquinaria" => $val["id_maquinaria"],
                        "descripcion" => $val["descripcion"]
                    );
        
                    array_push($arrayMaquinaria, $tmp);
                    
                }
            }
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
            /* FICHA MAQUINARIA */
			try{
            $sql = "SELECT * FROM ficha_maquinaria;";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_ficha_maquinaria" => $val["id_ficha_maquinaria"],
                        "id_maquinaria" => $val["id_maquinaria"],
                        "id_ficha" => $val["id_ficha"]
                    );
        
                    array_push($arrayFichaMaquinaria, $tmp);
                    
                }
            }
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
			
            /* TIPO TENENCIA TERRENO */
			try{
            $sql = "SELECT * FROM tipo_tenencia_terreno;";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_tipo_tenencia_terreno" => $val["id_tipo_tenencia_terreno"],
                        "descripcion" => $val["descripcion"]
                    );
        
                    array_push($arrayTipoTenenciaTerreno, $tmp);
                    
                }
            }
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

            /* datos para cardviews */
            try{
				/* $sql = "SELECT SUM(count(*)) AS Total, CA.id_tempo
						FROM agricultor A 
						INNER JOIN contrato_agricultor CA ON CA.id_agric = A.id_agric
						GROUP BY A.id_agric ";  */  
				$sql = "SELECT SUM(Total) AS Total, id_tempo FROM ( SELECT count(*) AS Total, CA.id_tempo
						FROM agricultor A 
						INNER JOIN contrato_agricultor CA ON CA.id_agric = A.id_agric
						GROUP BY A.id_agric ) Agricultores"; 
				$consulta = $conexion->prepare($sql);
				$consulta->execute();
				if($consulta->rowCount() > 0){
					$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
					foreach($r as $val){
						$tmp = array(
							"nombre" => "Agricultores",
							"total" => ($val["Total"] == null) ? 0 : $val["Total"],
							"tempo" => ($val["id_tempo"] == null) ? 0 : $val["id_tempo"]
						);
			
						array_push($arrayCardViews, $tmp);
						
					}
				}
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
			
			
			try{
					$sql = "SELECT count(*) AS Total, id_tempo
					FROM contrato_agricultor";    
					$consulta = $conexion->prepare($sql);
					$consulta->execute();
					if($consulta->rowCount() > 0){
						$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
						foreach($r as $val){
							$tmp = array(
								"nombre" => "Contratos",
								"total" => ($val["Total"] == null) ? 0 : $val["Total"],
								"tempo" => ($val["id_tempo"] == null) ? 0 : $val["id_tempo"]
							);
		
							array_push($arrayCardViews, $tmp);
							
						}
					}
				}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
			
			
			try{
					$sql = "SELECT count(*) AS Total, id_tempo FROM quotation; ";    
					$consulta = $conexion->prepare($sql);
					$consulta->execute();
					if($consulta->rowCount() > 0){
						$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
						foreach($r as $val){
							$tmp = array(
								"nombre" => "Quotations",
								"total" =>($val["Total"] == null) ? 0 : $val["Total"],
								"tempo" => ($val["id_tempo"] == null) ? 0 : $val["id_tempo"]
							);
		
							array_push($arrayCardViews, $tmp);
							
						}
					}
				}catch(PDOException $e){
					$problema  = $e->getMessage();
					$codigoProblema = 2;
				}


            try{
					$sql = "SELECT count(*) AS Total FROM especie;";    
					$consulta = $conexion->prepare($sql);
					$consulta->execute();
					if($consulta->rowCount() > 0){
						$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
						foreach($r as $val){
							$tmp = array(
								"nombre" => "Especies",
								"total" => ($val["Total"] == null) ? 0 : $val["Total"],
								"tempo" => 0
							);
							array_push($arrayCardViews, $tmp);   
						}
					}
				}catch(PDOException $e){
					$problema  = $e->getMessage();
					$codigoProblema = 2;
				}



			try{
					$sql = "SELECT sum(DQ.superficie_contr) AS Total, Q.id_tempo  FROM detalle_quotation DQ  INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation WHERE DQ.id_um = '1';";    
					$consulta = $conexion->prepare($sql);
					$consulta->execute();
					if($consulta->rowCount() > 0){
						$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
						foreach($r as $val){
							$tmp = array(
								"nombre" => "Hectareas",
								"total" => ($val["Total"] == null) ? 0 : $val["Total"],
								"tempo" => ($val["id_tempo"] == null) ? 0 : $val["id_tempo"]
							);
							array_push($arrayCardViews, $tmp);   
						}
					}
			  }catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
				
            $where = "";
            if($idTipoUsuario != 5){
                $where = "  WHERE V.id_usuario = ? ";
            }

			try{
				$sql = "SELECT count(*) AS Total ,  CA.id_tempo  FROM visita V  INNER JOIN anexo_contrato AC ON AC.id_ac = V.id_ac  INNER JOIN contrato_agricultor CA ON CA.id_cont = AC.id_cont   $where ;";    
				$consulta = $conexion->prepare($sql);
				if($idTipoUsuario != 5){
					$consulta->bindValue("1",$idUsuario, PDO::PARAM_INT);
				}
				$consulta->execute();
				if($consulta->rowCount() > 0){
					$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
					foreach($r as $val){
						$tmp = array(
							"nombre" => "Visitas",
							"total" => ($val["Total"] == null) ? 0 : $val["Total"],
							"tempo" => ($val["id_tempo"] == null) ? 0 : $val["id_tempo"]
						);
						array_push($arrayCardViews, $tmp);   
					}
				}
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
			
			try{
            /* ================================================ */
            /* CLIENTES */
                    $sql = "SELECT * FROM detalle_quotation 
                    INNER JOIN quotation USING (id_quotation)
                    INNER JOIN materiales USING (id_materiales)
                    INNER JOIN anexo_contrato USING (id_de_quo)
                    INNER JOIN cliente USING (id_cli) ;";    
                    $consulta = $conexion->prepare($sql);
                    $consulta->execute();
                    if($consulta->rowCount() > 0){
                        $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($r as $val){
                            $tmp = array(
                                "id_materiales" => $val["id_materiales"],
                                "id_cli" => $val["id_cli"],
                                "razon_social" => $val["razon_social"],
                                "id_ac" => $val["id_ac"],
                                "id_quotation" => $val["id_quotation"],
                                "id_de_quo" => $val["id_de_quo"]
                            );
                
                            array_push($arrayTipoCliente, $tmp);
                        }
                    }
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}

            /* TIPO TENENCIA MAQUINARIA */
			try{
            $sql = "SELECT * FROM tipo_tenencia_maquinaria;";    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $val){
                    $tmp = array(
                        "id_tipo_tenencia_maquinaria" => $val["id_tipo_tenencia_maquinaria"],
                        "descripcion" => $val["descripcion"]
                    );
        
                    array_push($arrayTipoMaquinaria, $tmp);
                    
                }
            }
			}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}
        /* VALORES VISITAS */
		try{
        $where = "";
        if($idTipoUsuario != 5){
            $where = " AND  (s.id_sup_us = ? || s.id_us_sup = ? || ua.id_usuario = ?) ";
        }

        $sql = "SELECT 
        v.id_visita, v.id_ac, v.id_est_vis,  
        v.fecha_p, v.hora_p, v.fecha_hora_p, v.fecha_r, v.hora_r, v.fecha_hora_r, v.estado_fen, v.estado_crec, 
        v.estado_male, v.estado_fito, v.cosecha, v.estado_gen_culti, v.hum_del_suelo,  
        v.obs_fito, v.obs_cre, v.obs_male, v.obs_gen, v.obs_hum, v.obs_cose, v.porcentaje_humedad,
        ca.id_tempo , v.obs, v.recome, v.id_usuario , cs.id_dispo_subida, v.id_visita_local
        FROM visita v
        INNER JOIN usuario_anexo  ua ON (ua.id_ac = v.id_ac)
        INNER JOIN anexo_contrato  ac ON (ac.id_ac = ua.id_ac)
        INNER JOIN contrato_anexo_temporada CAT ON (CAT.id_ac = ac.id_ac)
        INNER JOIN contrato_agricultor ca ON (ca.id_cont = CAT.id_cont)
        LEFT JOIN supervisores s ON (s.id_us_sup = ua.id_usuario)
        INNER JOIN cabecera_subida cs ON (cs.id_cab_subida = v.id_cabecera)
        WHERE v.id_est_vis = ? AND cs.estado = ? $where
        GROUP BY v.id_visita, CAT.id_cont"; 



        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1", 2, PDO::PARAM_INT);
        $consulta->bindValue("2", 1, PDO::PARAM_INT);
        if($idTipoUsuario != 5){
            $consulta->bindValue("3", $idUsuario, PDO::PARAM_INT);
            $consulta->bindValue("4", $idUsuario, PDO::PARAM_INT);
            $consulta->bindValue("5", $idUsuario, PDO::PARAM_INT);
        }
    
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $r = $consulta->fetchAll(PDO::FETCH_ASSOC);

            foreach($r as $val){
                $estado = 0;
                switch ($val["estado_fen"]){
                    case "none":
                    default:
                        $estado = 0;
                        break;
                    case "SOWING":
                    case "SIEMBRA":
                    case "TRANSPLANT":
                    case "TRANSPLANTE":
                    case "VEGETATIVE":
                    case "VEGETATIVO":
                        $estado = 2;
                        break;
                    case "PRE-FLOWERING":
                    case "PRE-FLORACION":
                    case "FLOWERING":
                    case "FLORACION":
                    case "FILL":
                    case "LLENADO":
                        $estado = 3;
                        break;
                    case "PRE-HARVEST":
                    case "PRE-COSECHA":
                    case "POST-HARVEST":
                    case "POST-COSECHA":
                        $estado = 4;
                        break;
                    case "UNSPECIFIED":
                    case "SIN ESPECIFICAR":
                        $estado = 5;
                        break;
                }

                $tmp = array(
                    "id_visita" => $val["id_visita"],
                    "id_visita_local" => $val["id_visita_local"],
                    "id_dispo" => $val["id_dispo_subida"],
                    "id_ac" => $val["id_ac"],
                    "id_est_vis" => $val["id_est_vis"],
                    "fecha_p" => $val["fecha_p"],
                    "hora_p" => $val["hora_p"],
                    "fecha_hora_p " => $val["fecha_hora_p"],
                    "fecha_r" => $val["fecha_r"],
                    "hora_r" => $val["hora_r"],
                    "fecha_hora_r" => $val["fecha_hora_r"],
                    "estado_fen" => $val["estado_fen"],
                    "estado_crec" => $val["estado_crec"],
                    "estado_male" => $val["estado_male"],
                    "estado_fito" => $val["estado_fito"],
                    "cosecha" => $val["cosecha"],
                    "estado_fen_culti" => $val["estado_gen_culti"],
                    "hum_del_suelo" => $val["hum_del_suelo"],
                    "temporada" => $val["id_tempo"],
                    "obs" => $val["obs"],
                    "recome" => $val["recome"],
                    "id_usuario"=>$val["id_usuario"],
                    "estado_server_visitas" => 1,
                    "etapa_visitas" => $estado,
                    "obs_fito" => $val["obs_fito"],
                    "obs_creci" => $val["obs_cre"],
                    "obs_maleza" => $val["obs_male"],
                    "obs_cosecha" => $val["obs_cose"],
                    "obs_overall" => $val["obs_gen"],
                    "obs_humedad" => $val["obs_hum"],
                    "percent_humedad" => $val["porcentaje_humedad"]
                );

                array_push($arrayVisita, $tmp);
            }
        }
	}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}


        /* TIPO TENENCIA MAQUINARIA */
		try{
            $sqlq = "SELECT * FROM quotation GROUP BY id_cli;";    
			$consultaq = $conexion->prepare($sqlq);
			$consultaq->execute();
			if($consultaq->rowCount() > 0){
                $res = $consultaq->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $values){

                    $sql = "SELECT * FROM cli_pcm WHERE id_cli = ?;";    
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",  $values["id_cli"], PDO::PARAM_STR);
                    $consulta->execute();
                    if($consulta->rowCount() > 0){
                        $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($r as $val){
                            $tmp = array(
                                "id_cli_pcm" => $val["id_cli_pcm"],
                                "id_cli" => $val["id_cli"],
                                "id_prop_mat_cli" => $val["id_prop_mat_cli"],
                                "ver" => $val["ver"],
                                "registrar" => $val["registrar"]
                            );
                
                            array_push($arrayPCM, $tmp);
                            
                        }
                    }

                }
            }

			
		}catch(PDOException $e){
            $problema  = $e->getMessage();
            $codigoProblema = 2;
		}
			
        /* QUOTATION */
		try{
			$sql = "SELECT * FROM detalle_quotation INNER JOIN quotation USING (id_quotation) ;";    
			$consulta = $conexion->prepare($sql);
			$consulta->execute();
			if($consulta->rowCount() > 0){
				$r = $consulta->fetchAll(PDO::FETCH_ASSOC);
				foreach($r as $val){
					$tmp = array(
						"id_de_quo" => $val["id_de_quo"],
						"id_quotation" => $val["id_quotation"],
						"id_materiales" => $val["id_materiales"],
						"id_cli" => $val["id_cli"],
						"superficie_contr" => $val["superficie_contr"]
					);
		
					array_push($arrayQuotation, $tmp);
					
				}
			}
		}catch(PDOException $e){
				$problema  = $e->getMessage();
				$codigoProblema = 2;
			}



        /*  PROPIEDADES INTERFAZ */
		try{

            $sqlq = "SELECT * FROM quotation GROUP BY id_esp, id_tempo;";    
			$consultaq = $conexion->prepare($sqlq);
			$consultaq->execute();
			if($consultaq->rowCount() > 0){
                $res = $consultaq->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $values){

                    $sql = "SELECT 
                            -- etapa.nombre,
                            propiedades.nombre_es,
                            propiedades.nombre_en,
                            propiedades.es_lista,
                            -- temporada.nombre,
                            -- temporada.desde,
                            -- temporada.hasta,
                            SP.nombre_es AS nombre_elemento_es,
                            SP.nombre_en AS nombre_elemento_en,
                            PCM.aplica,
                            PCM.orden,
                            PCM.id_prop_mat_cli,
                            PCM.id_esp,
                            PCM.id_prop,
                            PCM.id_etapa,
                            PCM.id_tempo,
                            PCM.tipo_campo,
                            PCM.tabla,
                            PCM.campo,
                            PCM.foraneo
                    
                        FROM
                        prop_cli_mat PCM
                            -- INNER JOIN prop_cli_mat PCM ON (temporada.id_tempo = PCM.id_tempo)
                            INNER JOIN sub_propiedades SP USING(id_sub_propiedad) 
                            LEFT JOIN propiedades ON (PCM.id_prop = propiedades.id_prop)
                            -- INNER JOIN etapa ON (PCM.id_etapa = etapa.id_etapa)
                            WHERE  PCM.id_esp = ? AND PCM.id_tempo = ? AND PCM.aplica = 'SI'  ORDER BY PCM.orden ASC
                            ";
                            // $conexion = $conexion->conexion();
                            $consulta = $conexion->prepare($sql);
                            $consulta->bindValue("1",  $values["id_esp"], PDO::PARAM_STR);
                            $consulta->bindValue("2",  $values["id_tempo"], PDO::PARAM_STR);
                            $consulta->execute();
                            if($consulta->rowCount() > 0){
                                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                foreach($r as $val){
                    
                                    $esLista = ($val["es_lista"] != null) ? $val["es_lista"] : "NO";
                                    $nombreEs = ($val["nombre_es"] != null) ? $val["nombre_es"] : "";
                                    $nombreEn = ($val["nombre_en"] != null) ? $val["nombre_en"] : "";
                    
                                    $tmp = array(
                                        "id_prop_mat_cli" => $val["id_prop_mat_cli"],
                                        "id_etapa" => $val["id_etapa"],
                                        "id_esp" => $val["id_esp"],
                                        "id_prop" => $val["id_prop"],
                                        "id_tempo"=>$val["id_tempo"],
                                        "nombre_prop_es" => $nombreEs,
                                        "nombre_prop_en" => $nombreEn,
                                        "nombre_elemento_es" => $val["nombre_elemento_es"],
                                        "nombre_elemento_en" => $val["nombre_elemento_en"],
                                        "aplica" => $val["aplica"],
                                        "orden"=>$val["orden"],
                                        "tipo_campo"=>$val["tipo_campo"],
                                        "es_lista"=>$esLista,
                                        "tabla"=>$val["tabla"],
                                        "campo"=>$val["campo"],
                                        "foraneo"=>$val["foraneo"]
                                    );
                                    array_push($arrayDetalleProp, $tmp);
                                }
                            }
                }
            }

            
			
		}catch(PDOException $e){
            $problema  = $e->getMessage();
            $codigoProblema = 2;
        }
    }else{

        $DescErrorCorreo="";   
        $DescErrorCorreo=" PROBLEMAS DESCARGANDO DATOS : \n\n";
        $DescErrorCorreo.="  - ID DISPOSITIVO: ".$id."\n";
        $DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
        $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 		
        $DescErrorCorreo.="\n NO POSEE ULTIMA VERSION ".$sql; 
        //ENVIAR CORREO
        $Cabecera="From: ERROR MODULE CURIMAPU<>";
        mail("sacuna@zionit.cl","ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);

    }


    array_push($arrayProblemas, array("codigo_respuesta"=> $codigoProblema, "mensaje_respuesta"=>$problema));




    $arrayGeneral = array(
        "array_detalle_prop" => $arrayDetalleProp,
        "array_rotation_crop" => $arrayRotation,
        "array_valor_prop" => $arrayValorProp,
        "array_visitas" => $arrayVisita,
        "array_anexos" => $arrayAnexos,
        "array_fichas"=>$arrayFichas,
        "array_temporada" => $arrayTemporadas,
        "array_region"=>$arrayRegion,
        "array_provincias" => $arrayProvincia,
        "array_comuna" => $arrayComuna,
        "array_especie" => $arrayEspecie,
        "array_materiales" => $arrayMaterial,
        "array_um"=>$arrayValorUM,
        "array_usuarios" => $arrayUsuarios,
        "array_agricultores" => $arrayAgricultores,
        "array_predios" => $arrayPredios,
        "array_lotes" =>$arrayLotes,
        "array_tipo_riego" => $arrayTipoRiego,
        "array_tipo_suelo" => $arrayTipoSuelo,
        "array_maquinaria" => $arrayMaquinaria,
        "array_tipo_maquinaria" => $arrayTipoMaquinaria,
        "array_tipo_tenencia_terreno" => $arrayTipoTenenciaTerreno,
        "array_ficha_maquinaria" => $arrayFichaMaquinaria,
        "array_tipo_clientes" => $arrayTipoCliente,
        "array_card_views" => $arrayCardViews,
        "array_pcm" => $arrayPCM,
        "array_clientes" => $arrayClientes,
        "array_quotation" => $arrayQuotation,
        "problemas" => $arrayProblemas,
        "array_pred_agr_temp" => $arrayPredAgrTemp
    );


    $conexion = NULL;
    header('Content-Type: application/json');

    echo json_encode($arrayGeneral);
}

    // echo json_encode(array("problemas" =>array("codigo_respuesta"=> 5, "mensaje_respuesta"=>"no posee ultima version")));
}
?>
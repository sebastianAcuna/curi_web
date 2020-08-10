<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    require_once '../../db/conectarse_db.php';
    include_once('../../../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');

    include_once('../../../docs/send_mail.php');

    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $CorreosErrorInsert = "sacuna@zionit.cl";
    // seba.nobody@gmail.com

    $codigoError = 0;
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $fechaHoraFin =  date('Y-m-d H:i:s');

        if(isset($_GET['id']) && isset($_GET['id_usuario']) && isset($_GET['id_cab'])  ){

            $idDispositivo = $_GET['id']; 
            $idUsuario  = $_GET['id_usuario'];
            $idCab = $_GET['id_cab'];


            $conexion->beginTransaction();
            $rollback = false;

            try{

                $sql = "SELECT * FROM cabecera_subida WHERE id_dispo_subida = ? AND id_usuario = ? AND id_cab_subida = ? ;";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$idDispositivo, PDO::PARAM_INT);
                $consulta->bindValue("2",$idUsuario, PDO::PARAM_INT);
                $consulta->bindValue("3",$idCab, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){


                    /*  ACA SE ACTUALIZARA EL ESTADO DE VISITAS, FICHAS, DETALLE VISITAS, FOTOS */

                    $update = "UPDATE visita SET estado_sincro = ? WHERE id_cabecera = ?";
                    $consultaU = $conexion->prepare($update);
                    $consultaU->bindValue("1","1", PDO::PARAM_INT);
                    $consultaU->bindValue("2",$idCab, PDO::PARAM_INT);
                    $consultaU->execute();

                    $update = "UPDATE prospecto SET estado_sincro = ? WHERE id_cab_subida = ?";
                    $consultaU = $conexion->prepare($update);
                    $consultaU->bindValue("1","1", PDO::PARAM_INT);
                    $consultaU->bindValue("2",$idCab, PDO::PARAM_INT);
                    $consultaU->execute();

                    $update = "UPDATE detalle_visita_prop SET estado_sincro = ? WHERE id_cabecera = ?";
                    $consultaU = $conexion->prepare($update);
                    $consultaU->bindValue("1","1", PDO::PARAM_INT);
                    $consultaU->bindValue("2",$idCab, PDO::PARAM_INT);
                    $consultaU->execute();


                    $update = "UPDATE fotos SET estado_sincro = ? WHERE id_cabecera = ?";
                    $consultaU = $conexion->prepare($update);
                    $consultaU->bindValue("1","1", PDO::PARAM_INT);
                    $consultaU->bindValue("2",$idCab, PDO::PARAM_INT);
                    $consultaU->execute();
                    

                    $update = "UPDATE cabecera_subida SET estado = ?, fecha_hora_fin  = ? WHERE id_cab_subida = ? AND id_dispo_subida = ? AND id_usuario = ?; ";
                    $consultaU = $conexion->prepare($update);
                    $consultaU->bindValue("1",1, PDO::PARAM_INT);
                    $consultaU->bindValue("2",$fechaHoraFin, PDO::PARAM_INT);
                    $consultaU->bindValue("3",$idCab, PDO::PARAM_INT);
                    $consultaU->bindValue("4",$idDispositivo, PDO::PARAM_INT);
                    $consultaU->bindValue("5",$idUsuario, PDO::PARAM_INT);
                    $consultaU->execute();
                    if($consultaU->rowCount() <= 0){
                        $codigoError = 2;
                        $mensajeError .= "No se modifico ningun registro.\n";
                    }

                
                }else{
                    $codigoError = 2;
                    $mensajeError .= "No se encontro ningun registro id_dispo_subida = ".$idDispositivo." AND id_usuario = ".$idUsuario." AND id_cab_subida = ".$idCab." .\n";
                }
            }catch(PDOException $e){
                $codigoError = 2;
                $mensajeError .= $e->getMessage()."\n";

                $rollback = true;
            }


            if($rollback){
                $conexion->rollback();
                $codigoError = 2;
                $mensajeError .= $e->getMessage()."\n";
            }else{
                $conexion->commit();
            }

        }else{
            $codigoError = 2;
            $mensajeError .= "ID DISP= ".$idDispositivo." , ID USUARIO = ".$idUsuario.", idCab = ".$idCab." No corresponden\n";
        }


        if($codigoError > 0 && $mensajeError != ""){

            $DescErrorCorreo="";   
			$DescErrorCorreo=" HAN OCURRIDO ERRORES AL COMPROBAR DATOS: \n\n";
			$DescErrorCorreo.="  - ID DISPOSITIVO: ".$idDispositivo."\n";
			$DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
			$DescErrorCorreo.="  - ID CABECERA: ".$idCab."\n";
			$DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraFin."\n"; 		
			$DescErrorCorreo.="\n".$mensajeError; 
			//ENVIAR CORREO
			$Cabecera="From: ERROR MODULE CURIMAPU<>";
			mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);
			//FIN ENVIAR CORREO
        }else{
            $mensajeError .= "TODO BIEN";

            $sql = "SELECT * FROM visita WHERE id_cabecera = :id_cabecera; ";  
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":id_cabecera", $idCab , PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                
                $rr = $consulta->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($rr);
                foreach($rr as $val){
                    enviarCorreoDesdeSubida($val["id_visita"]);
                }
            }
        }



        $conexion = NULL;
        header('Content-Type: application/json');

        // mail($CorreosErrorInsert,"ERROR SUBIR DATOS CURIMAPU",json_encode(array("codigo_respuesta" => $codigoError,"mensaje_respuesta" => $mensajeError, "cabecera_respuesta" => $idCab)),$Cabecera);

        $json_string = json_encode(array("codigo_respuesta" => $codigoError,"mensaje_respuesta" => $mensajeError, "cabecera_respuesta" => $idCab));
		echo $json_string;

    }
    ?>
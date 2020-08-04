<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    require_once '../../db/conectarse_db.php';

    $conexion = new Conectar();
    $conexion = $conexion->conexion();


    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $arrayGeneral = array();
        $arrayProblemas = array();
        $arrayUsuarios = array();
        

        $problema = "";
        $codigoProblema = 1;




        if(isset($_GET['imei']) && isset($_GET['version'])){

            $imei = $_GET['imei'];

            $version = $_GET['version'];

            $id = (isset($_GET['id'])) ? $_GET['id'] : 0;


            try{

                $sql = "SELECT version_apk FROM empresa WHERE id_empresa_SAP = ? AND version_apk = ? LIMIT 1";
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
                if($id <= 0){

                    try{
                        $sql = "SELECT id_dispositivo FROM dispositivos WHERE imei = ? LIMIT 1;";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$imei, PDO::PARAM_STR);
                        $consulta->execute();
                        if($consulta->rowCount() > 0){
                            $r  = $consulta->fetchAll(PDO::FETCH_ASSOC);
                            $id = $r[0]["id_dispositivo"];
                        }else{
    
                            $fecha = date('Y-m-d');
                            $hora = date('H:i:s');
    
    
                            $sql2 = "INSERT INTO dispositivos (imei, fecha_registro,hora_registro) VALUES(?, ?, ?);";
                            $consulta2 = $conexion->prepare($sql2);
                            $consulta2->bindValue("1",$imei, PDO::PARAM_STR);
                            $consulta2->bindValue("2",$fecha, PDO::PARAM_STR);
                            $consulta2->bindValue("3",$hora, PDO::PARAM_STR);
                            $consulta2->execute();
                            if($consulta2->rowCount() > 0){
    
                                $sql3 = "SELECT MAX(id_dispositivo) AS id_dispositivo FROM dispositivos WHERE imei = ? LIMIT 1;";
                                $consulta3 = $conexion->prepare($sql3);
                                $consulta3->bindValue("1",$imei, PDO::PARAM_STR);
                                $consulta3->execute();
                                if($consulta3->rowCount() > 0){
                                    $r2  = $consulta3->fetchAll(PDO::FETCH_ASSOC);
                                    // var_dump($r2);
                                    $id = $r2[0]["id_dispositivo"];
                                }
                                
                            }
    
                        }
    
                    }catch(PDOException $e){
                        $problema  = $e->getMessage();
                        $codigoProblema = 2;
                    }
    
                }
    
                if($id > 0){
                    /* USUARIO */
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
                }
            }



        }else{
            $codigoProblema = 3;
            $problema.= "//FALTA PARAMETRO IMEI O VERSION";
        }

        array_push($arrayProblemas, array("codigo_respuesta"=> $codigoProblema, "mensaje_respuesta"=>$problema));

        if(sizeof($arrayProblemas) > 0){
            $fechaHoraInicio = date('Y-m-d H:i:s');
            $DescErrorCorreo="";   
            $DescErrorCorreo=" PROBLEMAS DESCARGANDO DATOS PRIMERA VEZ: \n\n";
            $DescErrorCorreo.="  - ID DISPOSITIVO: ".$id."\n";
            $DescErrorCorreo.="  - ID USUARIO: ".$idUsuario."\n";
            $DescErrorCorreo.="  - FECHA HORA SERVIDOR: ".$fechaHoraInicio."\n"; 
            //ENVIAR CORREO
            $Cabecera="From: ERROR MODULE CURIMAPU<>";
            mail("sacuna@zionit.cl","ERROR SUBIR DATOS CURIMAPU",$DescErrorCorreo,$Cabecera);
        }

        $arrayGeneral = array(
            "id"=>$id,
            "array_usuarios" => $arrayUsuarios,
            "problemas"=>$arrayProblemas
        );


        $conexion = NULL;
        header('Content-Type: application/json');
        echo json_encode($arrayGeneral);
        
}
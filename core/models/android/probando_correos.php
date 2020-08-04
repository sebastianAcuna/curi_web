<?php 
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
require_once '../../db/conectarse_db.php';

require_once '../../../docs/send_mail.php';

$conexion = new Conectar();
$conexion = $conexion->conexion();


$sql = "SELECT * FROM visita WHERE id_cabecera = :id_cabecera; ";  
$consulta = $conexion->prepare($sql);
$consulta->bindValue(":id_cabecera", 52 , PDO::PARAM_INT);
$consulta->execute();



if($consulta->rowCount() > 0){
    
    $rr = $consulta->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($rr);
    foreach($rr as $val){
        enviarCorreoDesdeSubida($val["id_visita"]);
    }
}



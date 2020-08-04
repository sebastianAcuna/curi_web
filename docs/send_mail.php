<?php 
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

// require_once '../core/db/conectarse_db.php';

require_once '../../../PHPMailer/class.phpmailer.php';
require_once '../../../PHPMailer/class.smtp.php';
require_once '../../../docs/pdf/info_visita.php';
// include_once('../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');


function enviarCorreoDesdeSubida($idVisita){

    $conexion = new Conectar();
    $conexion = $conexion->conexion();


$html = file_get_contents('../../../docs/correo_plantilla.html');



$contenidoAdjunto = array();

$sql = "SELECT 
U.nombre, U.apellido_p, U.apellido_m, 
A.razon_social AS nombre_agricultor, A.rut AS rut_agricultor, A.direccion AS direccion_agricultor,
L.nombre AS nombre_lote,
P.nombre AS nombre_predio,
V.fecha_r AS fecha_visita, V.hora_r AS hora_visita, V.obs AS observacion_visita, V.recome AS recomendacion_visita,
V.estado_fen, V.estado_crec, V.obs_cre, V.estado_male, V.obs_male, V.estado_fito, V.obs_fito, V.cosecha, V.obs_cose,
V.estado_gen_culti, V.obs_gen, V.hum_del_suelo, V.obs_hum, V.porcentaje_humedad, V.id_visita
FROM visita V
INNER JOIN usuarios U USING (id_usuario) 
INNER JOIN anexo_contrato AC USING (id_ac)
INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
INNER JOIN contrato_agricultor CA ON  (CA.id_cont = CAT.id_cont)
INNER JOIN agricultor A USING (id_agric)
INNER JOIN lote L USING (id_lote)
INNER JOIN predio P USING (id_pred)
WHERE id_visita = :id_visita
GROUP BY CAT.id_cont
 ";
$consulta  = $conexion->prepare($sql);
$consulta->bindValue(":id_visita", $idVisita, PDO::PARAM_INT);
$consulta->execute();
if($consulta->rowCount() > 0){
    $arrayVisita = $consulta->fetchAll(PDO::FETCH_ASSOC);
}

$construirDetalleVisita = "";

if($arrayVisita != null && sizeof($arrayVisita) > 0){
    foreach($arrayVisita as $value){

        if($value["fecha_visita"] != null){
            list($y, $m, $d) = explode("-", $value["fecha_visita"]);

            $fechaVisitaConHora =  $d."-".$m."-".$y." ".$value["hora_visita"]; 
        }

        $html = str_replace("{NOMBREAGRONOMO}", $value["nombre"]." ".$value["apellido_p"]." ".$value["apellido_m"],$html);
        $html = str_replace("{NOMBREAGRICULTOR}", strtoupper($value["nombre_agricultor"])   , $html);
        $html = str_replace("{RUTAGRICULTOR}", $value["rut_agricultor"],$html);
        $html = str_replace("{DIRECCIONAGRICULTOR}", $value["direccion_agricultor"],$html);
        $html = str_replace("{FUNDOPOTRERO}", $value["nombre_lote"].", <strong> Lote:</strong> ".$value["nombre_predio"],$html);

        
        $construirDetalleVisita .= "<li style='margin-top:10px;width:700px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'>";
        $construirDetalleVisita .= "<strong>Estado Fenologico:</strong>".$value["estado_fen"]."</li>";

        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Fecha de visita: </strong>".$fechaVisitaConHora." </li>";
        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Estado Crecimiento: </strong>".$value["estado_crec"]." </li>";
        $construirDetalleVisita .= ($value["obs_cre"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_cre"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";

        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Estado Fitosanitario: </strong>".$value["estado_fito"]." </li>";
        $construirDetalleVisita .= ($value["obs_fito"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_fito"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";


        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Estado Maleza: </strong>".$value["estado_male"]." </li>";
        $construirDetalleVisita .= ($value["obs_male"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_male"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";


        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Cosecha: </strong>".$value["cosecha"]." </li>";
        $construirDetalleVisita .= ($value["obs_cose"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_cose"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";

        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Estado Gen. Cultivo: </strong>".$value["estado_gen_culti"]." </li>";
        $construirDetalleVisita .= ($value["obs_gen"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_gen"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";

        
        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Humedad del suelo: </strong>".$value["hum_del_suelo"]." </li>";
        $construirDetalleVisita .= ($value["obs_hum"] != "") ? "<ul style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'> <li>".$value["obs_hum"]."</li> </ul>" : "<ul> <li style='font-size:18px;'>Sin observacion </li> </ul>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";

        $construirDetalleVisita .= "<li style='font-size:18px;'><strong>Porcentaje Humedad: </strong>".round($value["porcentaje_humedad"],2)."% </li>";

        $construirDetalleVisita .= "<li style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'>";
        $construirDetalleVisita .= "<strong>Observacion Visita:</strong>".$value["observacion_visita"]."</li>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";
        $construirDetalleVisita .= "<li style='width:600px;text-align: justify; white-space: pre-wrap;text-overflow:ellipse;text-align:justify;font-size:18px;'>";
        $construirDetalleVisita .= "<strong>Recomendacion Visita:</strong>".$value["recomendacion_visita"]."</li>";
        $construirDetalleVisita .= "<hr style='width:650px;'>";


        $nombre = $value["nombre_agricultor"];

        $sql = "SELECT * FROM fotos WHERE id_visita  = :id_visita AND tipo = :tipo AND vista = :vista ;";
        $consulta  = $conexion->prepare($sql);
        $consulta->bindValue(":id_visita", $value["id_visita"], PDO::PARAM_INT);
        $consulta->bindValue(":tipo", "V", PDO::PARAM_STR);
        $consulta->bindValue(":vista", "agricultor", PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount() > 0){
             $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
            //  var_dump($r);
             foreach($r as $val){
                 $tmp = array(
                     "nombre" => $val["nombre_foto"],
                     "ruta" => $val["ruta_foto"]
                 );

                 array_push($contenidoAdjunto, $tmp);
             }
        }

        array_push($contenidoAdjunto, generarPDF($value["id_visita"], "CORREO", "../../../"));
    }

    $html = str_replace("{INFORMACIONVISITA}", $construirDetalleVisita, $html);
    $emp;
    $sql = "SELECT * FROM empresa ORDER BY id_empresa ASC LIMIT 1";
    $consulta  = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
     $emp = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    $html = str_replace("{NOMBREEMPRESA}", "- ".$emp[0]["nombre"]." -", $html);
}

$email = "correozionit@gmail.com";
$pass = "ZhiLL89_34";
$asunto = "Nueva visita registrada";
$destinatario = array("seba.nobody@gmail.com"=>$nombre,"devil_zero99@hotmail.com"=>$nombre, "fmarin@zionit.cl" => "Felix Marin", 
"felixraulmarinarribas@gmail.com"=>"Felix Marin", "rdelcanto@zionit.cl"=>"Rodrigo del Canto", "zionit.taba2@gmail.com"=>"rodrigo tableta", "jparada@zionit.cl"=>"Josue Parada", 
"tabjpara@gmail.com" => "josue tableta" );
$nombreDesde = "Zionit SPA";
enviarCorreo($email,$pass,$asunto,$destinatario,$nombreDesde,$contenidoAdjunto, $html);
}


function enviarCorreo($email,$pass,$asunto,$destinatario,$nombreDesde, $contenidoAdjunto, $html){
    $mail = new PHPMailer;

    $mail->IsSMTP(); // use SMTP        
    $mail->SMTPDebug = 3;
    $mail->Debugoutput = 'html';

    $mail->Host = "smtp.gmail.com"; // GMail
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls'; //'ssl' -> Con protocolo servidor SSL;
    $mail->SMTPAuth = true;

    $mail->Username = $email;
    $mail->Password = $pass; 

    $mail->setFrom($mail->Username,$nombreDesde);


    foreach($destinatario as $correo => $nombre){
        $mail->AddAddress($correo, $nombre); // recipients email
    }


    $mail->Subject = $asunto;	
    $mail->Body .=  $html;
    $mail->IsHTML(true);
    $mail->ContentType = 'text/html';
    $mail->CharSet = 'UTF-8';

    $mail->SMTPDebug = false;
    $mail->do_debug = 0;


    if(sizeof($contenidoAdjunto) > 0){
        foreach($contenidoAdjunto as $foto){

            $fichero = traerSoloContenido($foto["ruta"], ""); //Aqui guardas el archivo temporalmente.
            $mail->addStringAttachment($fichero, $foto["nombre"]);// 'base64', 'application/pdf'
        }
    }

    if(!$mail->send()) {
        // echo 'Message could not be sent. <br>';
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // echo 'Message has been sent';
    }

}


?>
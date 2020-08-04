<?php
    /* error_reporting(E_ALL);
    ini_set('display_errors', '1'); */
    require_once 'PHPMailer/class.phpmailer.php';
    require_once 'PHPMailer/class.smtp.php';

    $email = "Desde";
    $pass = "Desde";
    $asunto = "El asunto del mensaje";
    $destinatario = "Para";
    $nombre = "Para";

    function enviarCorreo($email,$pass,$asunto,$destinatario,$nombre){
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

        $mail->setFrom($mail->Username,$nombre);
        $mail->AddAddress($destinatario); // recipients email

        $mail->Subject = $asunto;	
        $mail->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
        $mail->Body .= "<p>Mensaje personalizado</p>";
        $mail->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
        $mail->Body .= "<button><a href='www.google.cl'>Hola</a></button>";
        $mail->Body .= "<a href='www.google.cl' style='text-decoration:none'><button>Apruebo</button></a>";
        $mail->IsHTML(true);

        if(!$mail->send()) {
            echo 'Message could not be sent. <br>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;

        } else {
            echo 'Message has been sent';

        }

    }

    enviarCorreo($email,$pass,$asunto,$destinatario,$nombre);

    // Varios destinatarios
    /* $para  = 'sacuna@zionit.cl';
    
    // título
    $título = 'Aprueba o Rechaza';
    
    // mensaje
    $mensaje = '
    <html>
    <head>
      <title>Aprueba o rechaza</title>
    </head>
    <body>
        <strong>Aaahhhhhhhhhhh</strong>
        Ehhhhhhhhhhh
        <button>Butttooonnnn</button>
    </body>
    </html>
    ';
    
    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    // Cabeceras adicionales
    $cabeceras .= 'To: Seba <sacuna@zionit.cl>' . "\r\n";
    $cabeceras .= 'From: Prueba <jparada@zionit.cl>' . "\r\n";
    /* $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
    $cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n"; */
    
    // Enviarlo
    //mail($para, $título, $mensaje, $cabeceras);
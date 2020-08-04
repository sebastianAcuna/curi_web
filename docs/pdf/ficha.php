<?php
    require_once '../../assets/fpdf/fpdf.php';
    require_once '../../core/db/conectarse_db.php';
        
    function textMin($text,$aplicar){
        if(strlen($text) > $aplicar){
            $text = substr($text,0,$aplicar)."...";
                
        }

        return $text;

    }

    $ficha = (isset($_REQUEST['Ficha'])?$_REQUEST['Ficha']:NULL);
    $ficha = filter_var($ficha,FILTER_SANITIZE_NUMBER_INT);

    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $sql = "SELECT concat(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS supervisor, E.nombre AS especie, A.razon_social AS agricultor, A.rut, A.direccion, C.nombre AS comuna, R.nombre AS region, A.telefono, A.rep_legal, A.rut_rl, A.email_rl, P.nombre AS predio, RP.nombre AS region_p, CP.nombre AS comuna_p, F.localidad, L.nombre AS potrero, F.ha_disponibles, TR.descripcion AS riego, TS.descripcion AS suelo, F.obs, F.obs_prop, T.nombre AS temporada, F.experiencia AS experiencia, F.fecha_limite_s AS fecha_limite, TTT.descripcion AS tenencia_terreno, TTM.descripcion AS tenencia_maquinaria, F.maleza, F.estado_general
            FROM ficha F
            INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
            INNER JOIN especie E ON E.id_esp = F.id_esp 
            INNER JOIN agricultor A ON A.id_agric = F.id_agric 
            INNER JOIN comuna C ON C.id_comuna = A.id_comuna 
            LEFT JOIN region R ON R.id_region = A.id_region 
            INNER JOIN predio P ON P.id_pred = F.id_pred 
            INNER JOIN lote L ON L.id_lote = F.id_lote
            INNER JOIN comuna CP ON CP.id_comuna = P.id_comuna 
            LEFT JOIN region RP ON RP.id_region = P.id_region 
            INNER JOIN tipo_suelo TS ON TS.id_tipo_suelo = F.id_tipo_suelo 
            INNER JOIN tipo_riego TR ON TR.id_tipo_riego = F.id_tipo_riego  
            INNER JOIN temporada T ON T.id_tempo = F.id_tempo  
            LEFT JOIN tipo_tenencia_terreno TTT ON TTT.id_tipo_tenencia_terreno =  F.id_tipo_tenencia_terreno
            LEFT JOIN tipo_tenencia_maquinaria TTM ON TTM.id_tipo_tenencia_maquinaria = F.id_tipo_tenencia_maquinaria
            WHERE F.id_ficha = ?";
            
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$ficha, PDO::PARAM_INT);
    $consulta->execute();
    $informacion = $consulta->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT anno, descripcion FROM historial_predio WHERE id_ficha = ? AND tipo = 'F' ORDER BY id_his_pre ASC LIMIT 4";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$ficha, PDO::PARAM_INT);
    $consulta->execute();
    $rotacion = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $consulta = NULL;
    $conexion = NULL;

    /* Creamos conexion con la libreria */
    $pdf = new FPDF("P","mm", "Letter");

    /* Ficha */
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(0,0,strtoupper('Ficha Pre-Contrato'),0,1,'L');

	$pdf->Image('../../assets/images/logo-curimapu-export-small.png',179,5,31,9);
    $pdf->ln(5);

    /* Datos */
    /* 1 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetX(10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(25,8,strtoupper('Fieldman'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(strtoupper($informacion["supervisor"])),0,0,'L');

    $pdf->ln(5);

    /* 2 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(25,8,strtoupper('Temporada'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(strtoupper($informacion["temporada"])),0,0,'L');

    $pdf->ln(5);

    /* 3 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(25,8,strtoupper('Especie'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(strtoupper($informacion["especie"])),0,1,'L');

    $pdf->ln(5);

    /* Detalles del agricultor */
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Detalles del agricultor'),0,1,'L');
    $pdf->ln(5);
    
    /* Datos */
    /* 1 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Razón Social')),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["agricultor"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Rut')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["rut"]),38)),0,0,'L');

    $pdf->ln(5);

    /* 2 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Dirección')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["direccion"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Comuna')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["comuna"]),38)),0,0,'L');

    $pdf->ln(5);

    /* 3 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Región')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["region"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Telefono')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["telefono"]),38)),0,0,'L');

    $pdf->ln(5);

    /* 3 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('REP. Legal'),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["rep_legal"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Rut REP. Legal')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["rut_rl"]),38)),0,0,'L');

    $pdf->ln(5);

    /* 4 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Email'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["email_rl"]),36)),0,1,'L');

    $pdf->ln(5);

    /* Datos del Predio */
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Datos del Predio'),0,1,'L');
    $pdf->ln(5);

    
    /* Datos */
    /* 1 */
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(35,8,strtoupper('Nombre del Predio'),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["predio"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Región')),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["region_p"]),38)),0,0,'L');

    $pdf->ln(5);

    /* 2 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Comuna'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["comuna_p"]),36)));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Localidad'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["localidad"]),38)),0,1,'L');

    $pdf->ln(5);

    /* Datos del Potrero */
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Datos del Potrero'),0,0,'L');

    $pdf->ln(5);

    /* Datos */    
    /* 1 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40,8,strtoupper('Nombre del potrero'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["potrero"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('HAS Disponibles'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["ha_disponibles"]),38)),0,0,'L');

    $pdf->ln(5);
    
    /* 2 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40,8,strtoupper('Riego'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["riego"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Suelo'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["suelo"]),38)),0,0,'L');

    $pdf->ln(5);
    
    /* 3 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40,8,strtoupper('Tipo tenencia terreno'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["tenencia_terreno"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Maquinaria'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["tenencia_maquinaria"]),38)),0,0,'L');

    $pdf->ln(5);
    
    /* 4 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40,8,strtoupper('Experiencia'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["experiencia"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Fecha limite siembra'),0,0,'L');


    list($y, $m, $d) = explode("-",$informacion["fecha_limite"]);
    $nuevaFechaLimite = $d."-".$m."-".$y;


    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin($nuevaFechaLimite,38)),0,0,'L');

    $pdf->ln(5);
    
    /* 5 */

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40,8,strtoupper('Estado maleza'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["maleza"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Estado general'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["estado_general"]),38)),0,1,'L');

    $pdf->ln(5);

    /* Datos del historia */
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Historial predio'),0,0,'L'); 

    $pdf->ln(5);

    /* Datos */
    /* 1 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,'Cultivo '.$rotacion[0]["anno"],0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($rotacion[0]["descripcion"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,'Cultivo '.$rotacion[1]["anno"],0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($rotacion[1]["descripcion"]),38)),0,0,'L');

    $pdf->ln(5);
    
    /* 2 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,'Cultivo '.$rotacion[2]["anno"],0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($rotacion[2]["descripcion"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,'Cultivo '.$rotacion[3]["anno"],0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($rotacion[3]["descripcion"]),38)),0,1,'L');

    $pdf->ln(5);

    /* Observaciones */
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Observaciones'));  

    $pdf->ln(5); 
    
    /* Datos */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,8,strtoupper('Observaciones generales'),0,1,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->MultiCell(0,4,utf8_decode(strtoupper($informacion["obs"])),0,'L');

    $pdf->ln(5); 

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,8,strtoupper('Observaciones propuesta'),0,1,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->MultiCell(0,4,utf8_decode(strtoupper($informacion["obs_prop"])),0,'L');

	$pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0, 0, 0);
	$pdf->SetXY(75,254);
	$pdf->Cell(60,5,utf8_decode('AGRICULTOR/REPRESENTATE LEGAL.'),'T',1,'C',0);

    /* $pdf->Output('D','ficha.pdf'); */
    $pdf->Output('','ficha.pdf');
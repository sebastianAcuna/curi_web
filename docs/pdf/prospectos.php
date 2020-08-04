<?php
    require_once '../../assets/fpdf/fpdf.php';
    require_once '../../core/db/conectarse_db.php';
        
    function textMin($text,$aplicar){
        if(strlen($text) > $aplicar){
            $text = substr($text,0,$aplicar)."...";
                
        }

        return $text;

    }

    class PDF extends FPDF{

        private $fechaHoraImpresion;

        function setFecha($fechaHoraImpresion){
            $this->fechaHoraImpresion = $fechaHoraImpresion;

        }


        function Footer(){
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            $this->SetTextColor(192,192,192);
            $this->Cell(0,10, utf8_decode('Fecha Impresión : '.$this->fechaHoraImpresion),0,0,'R');

        }

    }


    $prospecto = (isset($_REQUEST['Prospecto'])?$_REQUEST['Prospecto']:NULL);
    $prospecto = filter_var($prospecto,FILTER_SANITIZE_NUMBER_INT);

    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $fechaHoraImpresion = date('d-m-Y H:i:s');

    $sql = "SELECT concat(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS supervisor, 
                E.nombre AS especie, 
                A.razon_social AS agricultor, 
                A.rut, A.direccion, 
                C.nombre AS comuna, 
                PR.nombre AS provincia,
                R.nombre AS region, 
                A.telefono, 
                A.rep_legal, 
                A.rut_rl, 
                A.email_rl, 
                P.predio, 
                RP.nombre AS region_p, 
                CP.nombre AS comuna_p, 
                P.localidad, 
                P.lote, 
                P.ha_disponibles, 
                TR.descripcion AS riego, 
                TS.descripcion AS suelo, 
                P.obs, 
                P.obs_prop, 
                T.nombre AS temporada, 
                P.experiencia AS experiencia, 
                P.fecha_limite_s AS fecha_limite, 
                TTT.descripcion AS tenencia_terreno, 
                TTM.descripcion AS tenencia_maquinaria, 
                P.maleza, 
                P.estado_general,
                P.norting,
                P.easting,
                PRP.nombre AS provincia_p,
                P.id_est_fic,
                P.id_ficha
            FROM prospecto P
            LEFT JOIN usuarios U ON U.id_usuario = P.id_usuario 
            LEFT JOIN especie E ON E.id_esp = P.id_esp 
            LEFT JOIN agricultor A ON A.id_agric = P.id_agric 
            LEFT JOIN region R ON R.id_region = A.id_region 
            LEFT JOIN comuna C ON C.id_comuna = A.id_comuna 
            LEFT JOIN provincia PR ON PR.id_provincia = C.id_provincia 
            LEFT JOIN region RP ON RP.id_region = P.id_region 
            LEFT JOIN provincia PRP ON PRP.id_provincia = P.id_provincia 
            LEFT JOIN comuna CP ON CP.id_comuna = P.id_comuna 
            LEFT JOIN tipo_suelo TS ON TS.id_tipo_suelo = P.id_tipo_suelo 
            LEFT JOIN tipo_riego TR ON TR.id_tipo_riego = P.id_tipo_riego  
            LEFT JOIN temporada T ON T.id_tempo = P.id_tempo  
            LEFT JOIN tipo_tenencia_terreno TTT ON TTT.id_tipo_tenencia_terreno =  P.id_tipo_tenencia_terreno
            LEFT JOIN tipo_tenencia_maquinaria TTM ON TTM.id_tipo_tenencia_maquinaria = P.id_tipo_tenencia_maquinaria
            WHERE P.id_ficha = ?";


    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$prospecto, PDO::PARAM_INT);
    $consulta->execute();
    $informacion = $consulta->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT anno, descripcion FROM historial_predio WHERE id_ficha = ? AND tipo = 'P' ORDER BY id_his_pre ASC LIMIT 4";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$prospecto, PDO::PARAM_INT);
    $consulta->execute();
    $rotacion = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $consulta = NULL;
    $conexion = NULL;

    /* Creamos conexion con la libreria */
    $pdf = new PDF("P","mm", "Letter");

    $pdf->setFecha($fechaHoraImpresion);

    /* Ficha */

    $estadoFicha  = ( $informacion["id_est_fic"] == 1 ) ? "PROVISORIO"  : "ACTIVO" ;
    $estadoFicha.= " ( N° ".$informacion["id_ficha"]." )";


    $pdf->AddPage();

    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(50,0,strtoupper('Prospecto Pre-Contrato '),0,0,'L');
    $x = $pdf->getX();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell($x +25, 0 ,utf8_decode($estadoFicha),0,0,'R');

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
    $pdf->Cell(0,8,utf8_decode($informacion["temporada"]),0,0,'L');

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
    $pdf->Cell(0,8,utf8_decode(textMin($informacion["rut"],38)),0,0,'L');

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
    $pdf->Cell(35,8,utf8_decode(strtoupper('Región')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["region"]),36)),0,0,'L');

    $pdf->ln(5);

    /* 3 */
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Provincia')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["provincia"]),38)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,utf8_decode(strtoupper('Comuna')),0,0,'L');
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["comuna"]),38)),0,0,'L');

    $pdf->ln(5);

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
    $pdf->Cell(35,8,strtoupper('Provincia'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["provincia_p"]),36)));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Comuna'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["comuna_p"]),38)));

    $pdf->ln(5);

    /* 3 */

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Localidad'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["localidad"]),36)),0,1,'L');

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
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["lote"]),36)),0,0,'L');

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
    $pdf->Cell(40,8,strtoupper('Tipo de Riego'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["riego"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Tipo de Suelo'),0,0,'L');

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
    $pdf->Cell(35,8,'Maquinaria',0,0,'L');

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

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);

    $fechaLimite = ($informacion["fecha_limite"] == "0000-00-00" || $informacion["fecha_limite"] == "") ? "" : utf8_decode(textMin($informacion["fecha_limite"], 38));

    // $fechaLimite = "";
    list($y, $m, $d) = explode("-",$fechaLimite);
    $nuevaFechaLimite = $d."-".$m."-".$y;

    $pdf->Cell(0,8,$nuevaFechaLimite,0,0,'L');

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
    $pdf->Cell(35,8,'Estado general',0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["estado_general"]),38)),0,1,'L');

    $pdf->ln(5);
    
    /* Datos del historia */
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Coordenadas'),0,0,'L'); 
    
    $pdf->ln(5);

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Norting'),0,0,'L');;

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(65,8,utf8_decode(textMin(strtoupper($informacion["norting"]),36)),0,0,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,8,strtoupper('Easting'),0,0,'L');

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(0,8,utf8_decode(textMin(strtoupper($informacion["easting"]),38)),0,1,'L');

    $pdf->ln(5);

    /* Datos del historia */
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,0,strtoupper('Historial predio'),0,0,'L'); 

    $pdf->ln(5);

    /* Datos */
    if($rotacion != null){
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

    }else{
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(35,8,strtoupper('No posee historial de predio notificado.'),0,1,'L');
    
        $pdf->ln(10);

    }

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
    $pdf->Cell(60,5,utf8_decode(strtoupper('AGRICULTOR/REPRESENTATE LEGAL.')),'T',1,'C',0);
    
    // $pdf->setY(260);
    // $pdf->SetFont('Arial','',8);
    // $pdf->Cell(0, 5, utf8_decode('Fecha de impresión : '.$fechaHoraImpresion), 0, 1, 'R', 0);
    /* $pdf->Output('D','prospecto_'.date("dmYHis").'.pdf'); */
    $pdf->Output('','prospecto_'.date("dmYHis").'.pdf');
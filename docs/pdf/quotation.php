<?php

    require_once '../../assets/fpdf/fpdf.php';
    require_once '../../core/db/conectarse_db.php';

    include_once('../../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');

    function textMin($text,$aplicar){
        if(strlen($text) > $aplicar){
            $text = substr($text,0,$aplicar)."..";
                
        }

        return trim(mb_strtoupper($text,'UTF-8'));

    }

    function voltearFecha($string){
        preg_match('/(\d{4})+(-)+(\d{2})+(-)+(\d{1,2})/', $string, $salida);
        
        
        if(count($salida) >= 1){

            list($y, $m, $d) = explode('-', $string);

            return $d."-".$m."-".$y;

        }else{
            return $string;
        }
    }

    function datoForaneo($tabla,$campo,$AC, $temporada){
        try{

            $conexion = new Conectar();

            if($tabla == "historial_predio"){
                $sql = "SELECT group_concat(CONCAT(anno,': ', IF(descripcion = '', 'Sin cosecha', descripcion)) SEPARATOR ', ') AS Dato FROM ".$tabla;

            }else{
                $sql = "SELECT ".$tabla.".".$campo." AS Dato FROM ".$tabla;

            }

            // echo $sql;

            switch($tabla){
                case "anexo_contrato":
                    $sql .= "   WHERE id_ac = ".$AC;
                break;
                case "materiales":
                    $sql .= "   INNER JOIN anexo_contrato USING(id_materiales)
                                WHERE id_ac = ".$AC;
                break;
                case "agricultor":
                    $sql .= "   
                                INNER JOIN contrato_agricultor USING(id_agric)
                                INNER JOIN contrato_anexo_temporada CAT USING (id_cont)
                                INNER JOIN anexo_contrato ON (anexo_contrato.id_ac = CAT.id_ac)
                                WHERE CAT.id_ac = ".$AC." AND CAT.id_tempo = '".$temporada."' ";
                break;
                case "predio":
                    $sql .= "   INNER JOIN lote USING (id_pred)
                                INNER JOIN anexo_contrato USING (id_lote)
                                WHERE id_ac = ".$AC;
                break;
                case "lote":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_lote)
                                WHERE id_ac = ".$AC;
                break;
                case "visita":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_ac)
                                WHERE id_ac = ".$AC;
                break;
                case "tipo_riego":
                    $sql .= "   INNER JOIN ficha USING (id_tipo_riego)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "tipo_suelo":
                    $sql .= "   INNER JOIN ficha USING (id_tipo_suelo)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "ficha":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "usuarios":
                    $sql .= "   INNER JOIN ficha USING (id_usuario)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "historial_predio":
                    $sql .= "   INNER JOIN ficha USING (id_ficha)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC."
                                GROUP BY id_ficha ";
                break;

            }

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            $consulta->execute();

            $Dato = NULL;

            if($consulta->rowCount() > 0){
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                $Dato = $resultado["Dato"];

            }

            return $Dato;
    
        }catch(PDOException $e){
            echo "[TRAER DATO FORANEO] -> ha ocurrido un error ".$e->getMessage();

        }
    
        $consulta = NULL;
        $conexion = NULL;

    }

    class PDF extends FPDF {
        
        function Footer(){
            $this->SetXY(185,-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,utf8_decode('PAGE '.$this->PageNo().' | {nb}'),0,0,'C');

        }

        function mostrarIMG($img,$a,$b,$c,$d,$f,$temp){
            if($img != ""){
                $TEMPIMGLOC = $temp.'.png';
                $dataURI    = "data:image/png;base64,".$img;
                /* $dataURI    = $img; */
                $dataPieces = explode(',',$dataURI);
                $encodedImg = $dataPieces[1];
                $decodedImg = base64_decode($encodedImg);
        
                //  Check if image was properly decoded
                if( $decodedImg!==false ){
                    //  Save image to a temporary location
                    if( file_put_contents($TEMPIMGLOC,$decodedImg)!==false ){
                        $this->Image($TEMPIMGLOC,$a,$b,$c,$d,$f);
                        //  Delete image from server
                        unlink($TEMPIMGLOC);
    
                    }
                    
                }

            }
    
        }
		
	}

    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_NUMBER_INT);

    $quotation = (isset($_REQUEST['Quotation'])?$_REQUEST['Quotation']:NULL);
    $quotation = filter_var($quotation,FILTER_SANITIZE_STRING);
    
    $especie = (isset($_REQUEST['Especie'])?$_REQUEST['Especie']:NULL);
    $especie = filter_var($especie,FILTER_SANITIZE_STRING);
    
    $cliente = (isset($_REQUEST['Cliente'])?$_REQUEST['Cliente']:NULL);
    $cliente = filter_var($cliente,FILTER_SANITIZE_STRING);
    
    $info = (isset($_REQUEST['Info'])?$_REQUEST['Info']:NULL);
    $info = filter_var($info,FILTER_SANITIZE_NUMBER_INT);
    
    $formato = (isset($_REQUEST['Formato'])?$_REQUEST['Formato']:NULL);
    $formato = filter_var($formato,FILTER_SANITIZE_NUMBER_INT);

    $observacion = (isset($_REQUEST['Observacion'])?$_REQUEST['Observacion']:NULL);
    $datos = json_decode($observacion, true);

    $checks = (isset($_REQUEST['Checks'])?$_REQUEST['Checks']:NULL);
    $checks = json_decode($checks, true);

    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $anexos = array();

    if($formato == '1'){
        $sql = "SELECT AC.id_ac 
                FROM quotation Q
                INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                WHERE Q.id_quotation = ? AND Q.id_tempo = ?
                GROUP BY AC.id_ac";

    }else{
        $sql = "SELECT AC.id_ac 
                FROM quotation Q
                INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
                INNER JOIN contrato_agricultor CA ON CA.id_cont = CAT.id_cont
                WHERE Q.id_cli = ? AND Q.id_tempo = ?
                GROUP BY AC.id_ac
                ORDER BY id_agric ASC";

    }

    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$info, PDO::PARAM_INT);
    $consulta->bindValue("2",$temporada, PDO::PARAM_INT);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $anexos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    }

    $sql = "SELECT nombre FROM temporada WHERE id_tempo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$temporada, PDO::PARAM_INT);
    $consulta->execute();

    $temporada = "";
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetch(PDO::FETCH_ASSOC);

    }

    /* Creamos conexion con la libreria */
    $pdf = new PDF("P","mm", "Letter");
    $pdf->AliasNbPages();

    /* Portada */
    if($formato == '1'){
        $pdf->AddPage();

        switch(mb_strtoupper(trim($especie),'UTF-8')){
            case "FREJOL":
                $pdf->Image('../../assets/portadas/frejol.png',0,50,216,156,"PNG");
            break;
            case "CANOLA":
                $pdf->Image('../../assets/portadas/canola.png',0,50,216,156,"PNG");
            break;
            case "CANOLA BASICA":
                $pdf->Image('../../assets/portadas/canolaB.png',0,50,216,156,"PNG");
            break;
            case "SOYA":
                $pdf->Image('../../assets/portadas/soya.png',0,50,216,156,"PNG");
            break;
            case "MARAVILLA":
                $pdf->Image('../../assets/portadas/maravilla.png',0,50,216,156,"PNG");
            break;
            case "MAIZ":
                $pdf->Image('../../assets/portadas/maiz.png',0,50,216,156,"PNG");
            break;
            case "TRIGO":
                $pdf->Image('../../assets/portadas/trigo.png',0,50,216,156,"PNG");
            break;
            default:
                $pdf->Image('../../assets/portadas/canolaC.png',0,50,216,156,"PNG");
            break;

        }
    
        $pdf->SetFont('Arial','B',25);
        $pdf->SetXY(58,102);
        /* $pdf->Cell(100,10,utf8_decode($especie),0,1,'C'); */
        $pdf->SetFont('Arial','B',22);
        $pdf->ln(5);
        $pdf->SetX(58);
        $pdf->Cell(100,10,utf8_decode(mb_strtoupper($cliente,'UTF-8')),0,1,'C');
        $pdf->SetFont('Arial','B',25);
        $pdf->ln(5);
        $pdf->SetX(58);
        $pdf->Cell(100,10,utf8_decode(mb_strtoupper($temporada["nombre"],'UTF-8')),0,1,'C');
        $pdf->ln(6);
        $pdf->SetX(58);
        $pdf->SetTextColor(81,133,230);
        $pdf->Cell(100,10,utf8_decode(mb_strtoupper($informacion["especie"],'UTF-8')),0,1,'C');

    }

    $especies = array();

    $infoNo = true;

    foreach($anexos as $dato){
        $sql = "SELECT P.nombre AS predio, L.nombre AS lote, A.razon_social AS agricultor, M.nom_hibrido, AC.num_anexo, AC.superficie, F.localidad, V.estado_gen_culti, V.obs_gen, V.estado_crec, V.obs_cre, V.estado_male, V.obs_male, V.estado_fito, V.obs_fito, V.hum_del_suelo, V.obs_hum, E.nombre AS especie, V.fecha_r 
                FROM anexo_contrato AC
                INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
                INNER JOIN contrato_agricultor CA ON CA.id_cont = CAT.id_cont
                INNER JOIN agricultor A ON A.id_agric = CA.id_agric
                INNER JOIN lote L ON L.id_lote = AC.id_lote
                INNER JOIN predio P ON P.id_pred = L.id_pred 
                INNER JOIN visita V ON V.id_ac = AC.id_ac
                INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                INNER JOIN especie E ON E.id_esp = M.id_esp 
                WHERE AC.id_ac = ? 
                ORDER BY V.id_visita DESC LIMIT 1";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$dato["id_ac"], PDO::PARAM_INT);
        $consulta->execute();
        $informacion = $consulta->fetch(PDO::FETCH_ASSOC);

        if($formato != '1' && !in_array(mb_strtoupper(trim($informacion["especie"]),'UTF-8'),$especies) && $informacion["num_anexo"] != ""){
            $pdf->AddPage();
    
            switch(mb_strtoupper(trim($informacion["especie"]),'UTF-8')){
                case "FREJOL":
                    $pdf->Image('../../assets/portadas/frejol.png',0,50,216,156,"PNG");
                break;
                case "CANOLA":
                    $pdf->Image('../../assets/portadas/canola.png',0,50,216,156,"PNG");
                break;
                case "CANOLA BASICA":
                    $pdf->Image('../../assets/portadas/canolaB.png',0,50,216,156,"PNG");
                break;
                case "SOYA":
                    $pdf->Image('../../assets/portadas/soya.png',0,50,216,156,"PNG");
                break;
                case "MARAVILLA":
                    $pdf->Image('../../assets/portadas/maravilla.png',0,50,216,156,"PNG");
                break;
                case "MAIZ":
                    $pdf->Image('../../assets/portadas/maiz.png',0,50,216,156,"PNG");
                break;
                case "TRIGO":
                    $pdf->Image('../../assets/portadas/trigo.png',0,50,216,156,"PNG");
                break;
                default:
                    $pdf->Image('../../assets/portadas/canolaC.png',0,50,216,156,"PNG");
                break;
    
            }
        
            $pdf->SetFont('Arial','B',25);
            $pdf->SetXY(58,102);
            /* $pdf->Cell(100,10,utf8_decode($informacion["especie"]),0,1,'C'); */
            $pdf->Cell(100,10,'',0,1,'C');
            $pdf->SetFont('Arial','B',22);
            $pdf->ln(5);
            $pdf->SetX(58);
            $pdf->Cell(100,10,utf8_decode(mb_strtoupper($cliente,'UTF-8')),0,1,'C');
            $pdf->SetFont('Arial','B',25);
            $pdf->ln(5);
            $pdf->SetX(58);
            $pdf->Cell(100,10,utf8_decode(mb_strtoupper($temporada["nombre"],'UTF-8')),0,1,'C');
            $pdf->ln(6);
            $pdf->SetX(58);
            $pdf->SetTextColor(81,133,230);
            $pdf->Cell(100,10,utf8_decode(mb_strtoupper($informacion["especie"],'UTF-8')),0,1,'C');

            array_push($especies,mb_strtoupper(trim($informacion["especie"]),'UTF-8'));
    
        }

        if($informacion["num_anexo"] != ""){
            $infoNo = false;

            /* Contenido */
            $pdf->AddPage();
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','B',17);
            $pdf->MultiCell(173,5,utf8_decode(mb_strtoupper($informacion["agricultor"].', Anexo Contrato : '.$informacion["num_anexo"],'UTF-8')),0,'L');
            
            $pdf->SetFont('Arial','',15);
            $pdf->Cell(28,5,utf8_decode("VARIEDAD: "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(26,5,utf8_decode(textMin($informacion["nom_hibrido"],6)),0,0,'L');

            $pdf->SetFont('Arial','',15);
            $pdf->Cell(23,5,utf8_decode("PREDIO: "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(38,5,utf8_decode(textMin($informacion["predio"],10)),0,0,'L');

            $pdf->SetFont('Arial','',15);
            $pdf->Cell(28,5,utf8_decode("POTRERO: "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(38,5,utf8_decode(textMin($informacion["lote"],10)),0,1,'L');

            $pdf->SetFont('Arial','B',15);
            $pdf->SetTextColor(255,0,0);
            $pdf->Cell(0,5,utf8_decode(voltearFecha($informacion["fecha_r"])),0,1,'L');
            $pdf->SetTextColor(0,0,0);
            /* $pdf->SetFont('Arial','B',15);
            $pdf->Cell(0,5,utf8_decode($informacion["agricultor"]),0,1,'L');
            $pdf->SetFont('Arial','',15);
            $pdf->Cell(30,5,utf8_decode("- Potrero "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(0,5,utf8_decode($informacion["lote"].", ".$informacion["predio"]),0,1,'L');
            $pdf->SetFont('Arial','',15);
            $pdf->Cell(30,5,utf8_decode("- Variedad "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(0,5,utf8_decode($informacion["nom_hibrido"]),0,1,'L');
            $pdf->SetFont('Arial','',15);
            $pdf->Cell(30,5,utf8_decode("- Anexo "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(0,5,utf8_decode($informacion["num_anexo"]),0,1,'L');
            $pdf->SetFont('Arial','',15);
            $pdf->Cell(30,5,utf8_decode("- Ult. Visita "),0,0,'L');
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(0,5,utf8_decode(voltearFecha($informacion["fecha_r"])),0,1,'L'); */
            
            $pdf->Image('../../assets/images/logo.jpeg',190,4,20,20,"JPG");

            /* Tabla */
            $pdf->SetFont('Arial','B',8);

            /* Foto */
            $sql = "SELECT ruta_foto 
                    FROM fotos F 
                    INNER JOIN visita V ON V.id_visita = F.id_visita
                    WHERE V.id_ac = ? AND (vista = 'cliente' OR vista = 'ambos') AND F.estado_sincro = 1 AND favorita = '1' AND tipo = 'V' 
                    ORDER BY fecha_hora DESC LIMIT 3";
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue("1",$dato["id_ac"], PDO::PARAM_STR);
            $consulta->execute();
            
            if($consulta->rowCount() > 0){

                $fotos = $consulta->fetchAll(PDO::FETCH_ASSOC);

                if($consulta->rowCount() == 3){
                    /* Imagenes */
                    if(isset($fotos[0])){ 
                        $img = traerBaseIMG($fotos[0]["ruta_foto"],"");
                        $pdf->mostrarIMG($img,5,33,100,70,"JPG","fotoUno".$dato["id_ac"]);

                    }

                    if(isset($fotos[1])){ 
                        $img = traerBaseIMG($fotos[1]["ruta_foto"],"");
                        $pdf->mostrarIMG($img,111,33,100,70,"JPG","fotoDos".$dato["id_ac"]);

                    }

                    if(isset($fotos[2])){ 
                        $img = traerBaseIMG($fotos[2]["ruta_foto"],"");
                        $pdf->mostrarIMG($img,58,113,100,70,"JPG","fotoTres".$dato["id_ac"]);

                    }

                }

                if($consulta->rowCount() < 3){
                    /* Imagenes */
                    if(isset($fotos[0])){ 
                        $img = traerBaseIMG($fotos[0]["ruta_foto"],"");
                        $pdf->mostrarIMG($img,48,33,120,75,"JPG","fotoUno".$dato["id_ac"]);

                    }

                    if(isset($fotos[1])){ 
                        $img = traerBaseIMG($fotos[1]["ruta_foto"],"");
                        $pdf->mostrarIMG($img,48,118,120,75,"JPG","fotoDos".$dato["id_ac"]);

                    }

                }

            }
            
            /* Footer */
            $pdf->SetFont('Arial','B',20);
            $pdf->SetXY(58,193);//208
            $pdf->Cell(100,10,'SUMMARY',0,1,'C');

            $pdf->SetFont('Arial','',8);
            $pdf->SetFillColor( 215,215,215 );
			
			$pdf->SetXY(8,203);
            $pdf->Cell(40,6,'GENERAL STATUS',1,1,'C',true);
            $pdf->SetXY(48,203);
            $pdf->Cell(40,6,'GROWTH STATUS',1,1,'C',true);
            $pdf->SetXY(88,203);
            $pdf->Cell(40,6,'WEED PRESSURE STATUS',1,1,'C',true);
            $pdf->SetXY(128,203);
            $pdf->Cell(40,6,'PHYTOSANITARY STATUS',1,1,'C',true);
            $pdf->SetXY(168,203);
            $pdf->Cell(40,6,'SOIL MOISTURE STATUS',1,1,'C',true);

            $pdf->SetXY(8,209);
            $pdf->Cell(40,6,utf8_decode(mb_strtoupper($informacion["estado_gen_culti"],'UTF-8')),1,1,'C');
            $pdf->SetXY(48,209);
            $pdf->Cell(40,6,utf8_decode(mb_strtoupper($informacion["estado_crec"],'UTF-8')),1,1,'C');
            $pdf->SetXY(88,209);
            $pdf->Cell(40,6,utf8_decode(mb_strtoupper($informacion["estado_male"],'UTF-8')),1,1,'C');
            $pdf->SetXY(128,209);
            $pdf->Cell(40,6,utf8_decode(mb_strtoupper($informacion["estado_fito"],'UTF-8')),1,1,'C');
            $pdf->SetXY(168,209);
            $pdf->Cell(40,6,utf8_decode(mb_strtoupper($informacion["hum_del_suelo"],'UTF-8')),1,1,'C');

            /* Estado */
            $pdf->SetFont('Arial','B',8);
            $pdf->Ln(3);
            $pdf->Cell(40,6,'OBSERVATIONS :',0,0,'L');
            $pdf->Ln(5);

            $observaciones = explode("||",$datos[$informacion["num_anexo"]]);
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[0],130)),0,'L');
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[1],130)),0,'L');
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[2],130)),0,'L');
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[3],130)),0,'L');
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[4],130)),0,'L');
            $pdf->MultiCell(0,5,utf8_decode(textMin($observaciones[5],130)),0,'L');

            $pageMas = 0;

            $etapa = array();
            foreach($checks as $check){
                if($informacion["especie"] == $check[3] || $check[3] == "-"){
                    $sql = "SELECT foraneo, tabla, campo FROM prop_cli_mat WHERE id_prop_mat_cli = ?";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$check[0], PDO::PARAM_INT);
                    $consulta->execute();
                    $foraneo = $consulta->fetch(PDO::FETCH_ASSOC);

                    $encontro = false;

                    if($pdf->GetY() >= 230){
                        $pdf->AddPage();
                        $pageMas = 1;

                        /* Footer */
                        $pdf->SetFont('Arial','B',20);
                        $pdf->Cell(100,10,'Fieldbook',0,1,'L');

                    }

                    if(!in_array($check[2],$etapa)){
                        $y = $pdf->GetY();
                        $pdf->SetXY(10,$y+2);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->cell(0,8,utf8_decode(textMin($check[2],38)),0,1,'C');

                        array_push($etapa,$check[2]);

                    }

                    if($foraneo["foraneo"] == "NO"){
                        $sql = "SELECT valor
                                FROM detalle_visita_prop  DVP
                                INNER JOIN visita V USING (id_visita) 
                                WHERE id_ac = ? AND id_prop_mat_cli = ? ";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$dato["id_ac"], PDO::PARAM_INT);
                        $consulta->bindValue("2",$check[0], PDO::PARAM_INT);
                        $consulta->execute();
                        if($consulta->rowCount() > 0){
                            $encontro = true;

                            $valor = $consulta->fetch(PDO::FETCH_ASSOC);
        
                            $y = $pdf->GetY();
                            $pdf->SetXY(10,$y);
                            $pdf->SetFillColor( 215,215,215 );
                            $pdf->SetFont('Arial','',8);
                            $pdf->cell(70,6,utf8_decode(textMin($check[1],38)),1,0,'L',true);
                            $pdf->SetXY(80,$y);
                            $pdf->SetFont('Arial','B',8);
                            $pdf->cell(100,6,utf8_decode(textMin(voltearFecha($valor["valor"]),54)),1,1,'L');
        
                        }

                    }else{
                        $encontro = true;

                        $valor = datoForaneo($foraneo["tabla"],$foraneo["campo"],$dato["id_ac"], $temporada);

                        $y = $pdf->GetY();
                        $pdf->SetXY(10,$y);
                        $pdf->SetFillColor( 215,215,215 );
                        $pdf->SetFont('Arial','',8);
                        $pdf->cell(70,6,utf8_decode(textMin($check[1],38)),1,0,'L',true);
                        $pdf->SetXY(80,$y);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->cell(100,6,utf8_decode(textMin(voltearFecha($valor),54)),1,1,'L');

                    }
                    
                    if(!$encontro){
                        $y = $pdf->GetY();
                        $pdf->SetXY(10,$y);
                        $pdf->SetFillColor( 215,215,215 );
                        $pdf->SetFont('Arial','',8);
                        $pdf->cell(70,6,utf8_decode(textMin($check[1],38)),1,0,'L',true);
                        $pdf->SetXY(80,$y);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->cell(100,6,utf8_decode("SIN INFORMACIÓN"),1,1,'L');

                    }

                }

            }

        }

    }

    if($infoNo){
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',18);
        $pdf->SetXY(58,102);
        $pdf->Cell(100,10,utf8_decode("No existe información actualmente para generar un reporte."),0,1,'C');
        
    }

    $consulta = NULL;
    $conexion = NULL;
    
    /* $pdf->Output('D','quotation.pdf'); */
    $pdf->Output('','quotation.pdf');
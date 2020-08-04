<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    $visita = (isset($_REQUEST['visita'])?$_REQUEST['visita']:NULL);
    $visita = filter_var($visita,FILTER_SANITIZE_NUMBER_INT);
    $rutaPrevia = "../../../";
    include_once('../../../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');
    if($visita != null){
        // require_once $rutaPrevia.'assets/fpdf/fpdf.php';
        // require_once $rutaPrevia.'core/db/conectarse_db.php';
        // include_once($rutaPrevia.'../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');
    }else{
        $rutaPrevia = "../../../";
        require_once $rutaPrevia.'assets/fpdf/fpdf.php';
    }
    

    function textMin($text,$aplicar){
        if(strlen($text) > $aplicar){
            $text = substr($text,0,$aplicar)."...";
                
        }

        return trim($text);

    }


    function formatearFecha($fechaVolteada){
        list($y, $m, $d) = explode("-", $fechaVolteada);
        return $d."-".$m."-".$y;
    }

    global $fecha_r;
    global $lote;

    class PDF extends FPDF {

        function Header(){
            global $fecha_r;
            global $lote;

            $this->SetY(5);
            $this->SetTextColor(247,164,164);
            $this->SetFont('Arial','',8);
            $this->Cell(0,5,utf8_decode('Fecha de Visita: '.$fecha_r.', Potrero: '.$lote),0,1,'L');

        }
        
        function Footer(){
            $this->SetXY(185,-15);
            $this->SetTextColor(137,137,255);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().' | {nb}'),0,0,'C');

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
        
        function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $indent=0){
            //Output text with automatic or explicit line breaks
            $cw=&$this->CurrentFont['cw'];

            if($w==0){
                $w=$this->w-$this->rMargin-$this->x;
                
            }
        
            $wFirst = $w-$indent;
            $wOther = $w;
        
            $wmaxFirst=($wFirst-2*$this->cMargin)*1000/$this->FontSize;
            $wmaxOther=($wOther-2*$this->cMargin)*1000/$this->FontSize;
        
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);

            if($nb>0 && $s[$nb-1]=="\n"){
                $nb--;

            }

            $b=0;
            if($border){
                if($border==1){
                    $border='LTRB';
                    $b='LRT';
                    $b2='LR';

                }else{
                    $b2='';
                    if(is_int(strpos($border,'L')))
                        $b2.='L';
                    if(is_int(strpos($border,'R')))
                        $b2.='R';
                    $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;

                }

            }

            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $ns=0;
            $nl=1;
            $first=true;

            while($i<$nb){
                //Get next character
                $c=$s[$i];
                if($c=="\n"){
                    //Explicit line break
                    if($this->ws>0){
                        $this->ws=0;
                        $this->_out('0 Tw');

                    }

                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $ns=0;
                    $nl++;
                    if($border && $nl==2){
                        $b=$b2;

                    }

                    continue;

                }

                if($c==' ') {
                    $sep=$i;
                    $ls=$l;
                    $ns++;

                }

                $l+=$cw[$c];
        
                if ($first){
                    $wmax = $wmaxFirst;
                    $w = $wFirst;

                }else{
                    $wmax = $wmaxOther;
                    $w = $wOther;

                }
        
                if($l>$wmax){
                    //Automatic line break
                    if($sep==-1){
                        if($i==$j){
                            $i++;

                        }

                        if($this->ws>0){
                            $this->ws=0;
                            $this->_out('0 Tw');

                        }

                        $SaveX = $this->x; 
                        if ($first && $indent>0){
                            $this->SetX($this->x + $indent);
                            $first=false;

                        }

                        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                        $this->SetX($SaveX);

                    }else{
                        if($align=='J'){
                            $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                            $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));

                        }

                        $SaveX = $this->x; 
                        if ($first && $indent>0){
                            $this->SetX($this->x + $indent);
                            $first=false;

                        }

                        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                        $this->SetX($SaveX);
                        $i=$sep+1;

                    }

                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $ns=0;
                    $nl++;

                    if($border && $nl==2){
                        $b=$b2;

                    }

                }else{
                    $i++;

                }

            }

            //Last chunk
            if($this->ws>0){
                $this->ws=0;
                $this->_out('0 Tw');

            }

            if($border && is_int(strpos($border,'B'))){
                $b.='B';

            }

            $this->Cell($w,$h,substr($s,$j,$i),$b,2,$align,$fill);
            $this->x=$this->lMargin;

        }
		
    }      



    
    

    function generarPDF($visita = null, $desde = "CORREO",  $rutaPrevia){
        global $fecha_r;
        global $lote;

        $conexion = new Conectar();
        $conexion = $conexion->conexion();

        $sql = "SELECT V.fecha_r, A.razon_social, L.nombre AS lote, P.nombre AS predio, AC.num_anexo, M.nom_hibrido AS material, E.nombre AS especie, V.estado_fen, V.obs_ef, V.estado_crec, V.obs_cre, V.estado_male, V.obs_male, V.estado_fito, V.obs_fito, V.cosecha, V.obs_cose, V.hum_del_suelo, V.obs_hum, V.estado_gen_culti, V.obs_gen, V.recome, F.localidad, TR.descripcion AS tipo_riego, TS.descripcion AS tipo_suelo, V.id_usuario  
            FROM visita V 
            INNER JOIN anexo_contrato AC USING(id_ac) 
            INNER JOIN contrato_anexo_temporada CAT ON (CAT.id_ac = AC.id_ac)
            INNER JOIN contrato_agricultor CA ON (CA.id_cont = CAT.id_cont) 
            INNER JOIN agricultor A USING(id_agric) 
            INNER JOIN materiales M USING(id_materiales)
            INNER JOIN especie E ON E.id_esp = M.id_esp
            INNER JOIN lote L USING(id_lote)
            INNER JOIN predio P USING(id_pred)
            INNER JOIN ficha F USING(id_ficha) 
            INNER JOIN tipo_riego TR USING(id_tipo_riego) 
            INNER JOIN tipo_suelo TS USING(id_tipo_suelo)  
            WHERE id_visita = ? GROUP BY CAT.id_cont";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$visita, PDO::PARAM_INT);
        $consulta->execute();
        $informacion = $consulta->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre 
                FROM usuarios U 
                WHERE id_usuario = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$informacion["id_usuario"], PDO::PARAM_INT);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre 
                FROM usuarios U 
                INNER JOIN supervisores S ON S.id_sup_us = U.id_usuario
                WHERE S.id_us_sup = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$informacion["id_usuario"], PDO::PARAM_INT);
        $consulta->execute();
        $supervisor = $consulta->fetch(PDO::FETCH_ASSOC);


        

        /* Head */
        $fecha_r = formatearFecha($informacion["fecha_r"]);
        $lote = $informacion["lote"];

         /* Creamos conexion con la libreria */
        $pdf = new PDF("P","mm", "Letter");
        
        

        /* Page */
        $pdf->AliasNbPages();

        /* Contenido */
        $pdf->AddPage();

        $pdf->Image($rutaPrevia.'assets/images/logo.jpeg',190,4,20,20,"JPG");

        /* Titulo */
        $pdf->ln(3);
        $pdf->SetTextColor(0,0,255);
        $pdf->SetFont('Arial','',20);
        $pdf->Cell(0,5,utf8_decode('Informe de Visita'),0,1,'C');
        $pdf->ln(5);
        
        /* Parte 1 */
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30,5,utf8_decode('Fecha'),0,0,'L');
        $pdf->SetFont('Arial','B',8);



        $pdf->Cell(0,5,utf8_decode(': '.formatearFecha($informacion["fecha_r"])),0,1,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30,5,utf8_decode('Agricultor'),0,0,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$informacion["razon_social"])),0,1,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30,5,utf8_decode('Predio',0,0,'L'));
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$informacion["predio"])),0,1,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30,5,utf8_decode('Potrero'),0,0,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$informacion["lote"])),0,1,'L');

        /* Linea */
        $pdf->Cell(0,3,utf8_decode(''),'B',1,'L');

        /* Parte 2 */
        $pdf->ln(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15,5,utf8_decode('Anexo'),0,0,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(45,5,utf8_decode(strtoupper(': '.$informacion["num_anexo"])),0,0,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15,5,utf8_decode('Especie'),0,0,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(45,5,utf8_decode(strtoupper(': '.$informacion["especie"])),0,0,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15,5,utf8_decode('Variedad'),0,0,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(45,5,utf8_decode(strtoupper(': '.$informacion["material"])),0,1,'L');
        $pdf->ln(2);

        /* Estado Fenológico */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(27,5,utf8_decode('Estado Fenológico:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["estado_fen"])),0,1,'L');
        
        if(($informacion["estado_fen"] != "Unspecified" && $informacion["estado_fen"] != "Sin Especificar") && $informacion["obs_ef"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(8,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_ef"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_ef"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode($informacion["obs_ef"]),0,'L',0,$M); 

        }
        
        $pdf->ln(1);

        /* Estado de Crecimiento */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(32,5,utf8_decode('Estado de Crecimiento:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["estado_crec"])),0,1,'L');
        
        if(($informacion["estado_crec"] != "Unspecified" && $informacion["estado_crec"] != "Sin Especificar") && $informacion["obs_cre"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(8,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_cre"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_cre"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode($informacion["obs_cre"]),0,'L',0,$M); 

        }
        
        $pdf->ln(1);

        /* Estado de Malezas */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(27,5,utf8_decode('Estado de Malezas:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["estado_male"])),0,1,'L');
        
        if(($informacion["estado_male"] != "Unspecified" && $informacion["estado_male"] != "Sin Especificar") && $informacion["obs_male"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_male"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_male"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["obs_male"])),0,'L',0,$M); 

        }
        
        $pdf->ln(1);

        /* Estado Fitosanitario */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(29,5,utf8_decode('Estado Fitosanitario:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);;
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["estado_fito"])),0,1,'L');
        
        if(($informacion["estado_fito"] != "Unspecified" && $informacion["estado_fito"] != "Sin Especificar") && $informacion["obs_fito"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,utf8_decode(strtoupper('OBS:')),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_fito"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_fito"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["obs_fito"])),0,'L',0,$M); 

        }
        
        $pdf->ln(1);

        /* Cosecha */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(14,5,utf8_decode('Cosecha:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["cosecha"])),0,1,'L');
        
        if(($informacion["cosecha"] != "Unspecified" && $informacion["cosecha"] != "Sin Especificar") && $informacion["obs_cose"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_cose"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_cose"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["obs_cose"])),0,'L',0,$M);  

        }
        
        $pdf->ln(1);

        /* Humedad del suelo */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(28,5,utf8_decode('Humedad del suelo:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["hum_del_suelo"])),0,1,'L');
        
        if(($informacion["hum_del_suelo"] != "Unspecified" && $informacion["hum_del_suelo"] != "Sin Especificar") && $informacion["obs_hum"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_hum"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_hum"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["obs_hum"])),0,'L',0,$M); 

        }
        
        $pdf->ln(1);

        /* Estado General */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(23,5,utf8_decode('Estado General:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(0,5,utf8_decode(strtoupper($informacion["estado_gen_culti"])),0,1,'L');
        
        if(($informacion["estado_gen_culti"] != "Unspecified" && $informacion["estado_gen_culti"] != "Sin Especificar") && $informacion["obs_gen"] != ""){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,utf8_decode('OBS:'),0,0,'L');
            $pdf->SetFont('Arial','',8);

            $X = (strlen($informacion["obs_gen"]) < 145)?18:10;
            $pdf->SetX($X);

            $M = (strlen($informacion["obs_gen"]) < 145)?18:8;

            $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["obs_gen"])),0,'L',0,$M);  

        }
        
        $pdf->ln(1);

        /* Recomendaciones */
        $pdf->SetTextColor(200,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(27,5,utf8_decode('Recomendaciones:'),0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);

        $X = (strlen($informacion["recome"]) < 135)?37:10;
        $pdf->SetX($X);

        $M = (strlen($informacion["recome"]) < 135)?37:27;

        $pdf->MultiCell(0,5,utf8_decode(strtoupper($informacion["recome"])),0,'L',0,$M);  

        $pdf->ln(3);

        /* Info 1 */
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(23,5,utf8_decode('Localidad'),0,0,'L');
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$informacion["localidad"])),0,1,'L');

        /* Info 2 */
        $pdf->Cell(23,5,utf8_decode('Sistema de riego'),0,0,'L');
        $pdf->Cell(70,5,utf8_decode(strtoupper(': '.$informacion["tipo_riego"])),0,0,'L');
        $pdf->Cell(25,5,utf8_decode('Tipo de suelo'),0,0,'L');
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$informacion["tipo_suelo"])),0,1,'L');

        $usuario = ($supervisor["nombre"] == "") ? $usuario["nombre"]: $supervisor["nombre"];
        $supervisor = ($supervisor["nombre"] == "") ? $usuario : "";

        /* Info 3 */
        $pdf->Cell(23,5,utf8_decode('Fieldman'),0,0,'L');
        $pdf->Cell(70,5,utf8_decode(strtoupper(': '.$usuario)),0,0,'L');
        $pdf->Cell(25,5,utf8_decode('Fieldman assistent'),0,0,'L');
        $pdf->Cell(0,5,utf8_decode(strtoupper(': '.$supervisor)),0,1,'L');

        /* Foto */
        $pdf->AddPage();

        /* Titulo */
        $pdf->ln(3);
        $pdf->SetTextColor(0,0,255);
        $pdf->SetFont('Arial','',20);
        $pdf->Cell(0,5,utf8_decode(strtoupper('Fotos:')),0,1,'L');
        $pdf->ln(5);

        $sql = "SELECT ruta_foto  
                FROM fotos F 
                INNER JOIN visita V ON V.id_visita = F.id_visita
                WHERE V.id_visita = ? AND F.estado_sincro = 1 AND vista = 'agricultor' AND tipo = 'V' 
                ORDER BY favorita DESC";
                /* AND (vista = 'cliente' OR vista = 'ambos') AND F.estado_sincro = 1 AND favorita = '1' AND tipo = 'V' */
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$visita, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->rowCount() > 0){

            $fotos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $cont = COUNT($fotos);
            for($i = 0; $i < $cont; $i++){
                if($i == 0){
                    $img = traerBaseIMG($fotos[$i]["ruta_foto"],"");
                    $pdf->mostrarIMG($img,28,30,160,110,"JPG","IMG"+$i);

                }

                if($i == 1){
                    $img = traerBaseIMG($fotos[$i]["ruta_foto"],"");
                    $pdf->mostrarIMG($img,13,150,90,90,"JPG","IMG"+$i);

                }

                if($i == 2){
                    $img = traerBaseIMG($fotos[$i]["ruta_foto"],"");
                    $pdf->mostrarIMG($img,113,150,90,90,"JPG","IMG"+$i);

                }

                if($i == 3){
                    $pdf->AddPage();
                    $pdf->SetXY(12,20);
                    
                }elseif($i > 5 && ($i+1)%4==0){
                    $pdf->AddPage();
                    $pdf->SetXY(12,20);

                }

                if($i > 2 && $i%2 != 0){
                    $img = traerBaseIMG($fotos[$i]["ruta_foto"],"");

                    $X = $pdf->GetX();
                    $Y = $pdf->GetY()+10;

                    $pdf->mostrarIMG($img,$X,$Y,90,90,"JPG","IMG"+$i);

                }

                if($i > 2 && $i%2 == 0){
                    $img = traerBaseIMG($fotos[$i]["ruta_foto"],"");

                    $X = $pdf->GetX()+100;
                    $Y = $pdf->GetY()+10;

                    $pdf->mostrarIMG($img,$X,$Y,90,90,"JPG","IMG"+$i);

                    $pdf->SetXY(12,120);

                }

            }

        }

        $consulta = NULL;
        $conexion = NULL;
        
        /* $pdf->Output('D','info_visita.pdf'); */

        $nombre = 'info_visita_'.$visita."_".date('YmdHis').'.pdf';
        if($desde == "CORREO"){
            $ruta = '../../../../curimapu_docum/pdf_visitas/'.$nombre;
            $pdf->Output('F',$ruta);

            $respuestaFTP = FunRespDOC_GLOBAL_ALL(
                "pdf_visitas",
                $nombre,
                "NO",
                "",
                "",
                "",
                "",
                "");
            // unlink($ruta);
            return array("ruta" => $ruta, "nombre"=>$nombre);
        }else{
            $pdf->Output('',$nombre);
        }
        
    }

    if($visita != null) generarPDF($visita,"WEB",$rutaPrevia);
    

    

    

    

   
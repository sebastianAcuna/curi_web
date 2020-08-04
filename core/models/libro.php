<?php
    session_start();
    require_once '../../db/conectarse_db.php';

    include_once('../../../../a_funcion_sistemas/sql_resp_ftp_all_pdo.php');

    function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );
		
        return $cadena;
        
	}

    class Libro{
        private $rec, $num, $ane, $esp, $var, $agr, $pre, $pot, $cli;

        private $id, $desde, $orden, $id_temporada, $etapa, $info, $id_esp;

        private $tabla, $campo, $Q, $DQ, $AC, $M;

        private $data;

        public function set_rec($rec){
            $rec = (isset($rec)?$rec:NULL);
            $this->rec = filter_var($rec,FILTER_SANITIZE_STRING);
            
        }

        public function set_num($num){
            $num = (isset($num)?$num:NULL);
            $this->num = filter_var($num,FILTER_SANITIZE_STRING);
            
        }

        public function set_ane($ane){
            $ane = (isset($ane)?$ane:NULL);
            $this->ane = filter_var($ane,FILTER_SANITIZE_STRING);
            
        }

        public function set_esp($esp){
            $esp = (isset($esp)?$esp:NULL);
            $this->esp = filter_var($esp,FILTER_SANITIZE_STRING);
            
        }

        public function set_var($var){
            $var = (isset($var)?$var:NULL);
            $this->var = filter_var($var,FILTER_SANITIZE_STRING);
            
        }

        public function set_agr($agr){
            $agr = (isset($agr)?$agr:NULL);
            $this->agr = filter_var($agr,FILTER_SANITIZE_STRING);
            
        }

        public function set_pre($pre){
            $pre = (isset($pre)?$pre:NULL);
            $this->pre = filter_var($pre,FILTER_SANITIZE_STRING);
            
        }

        public function set_pot($pot){
            $pot = (isset($pot)?$pot:NULL);
            $this->pot = filter_var($pot,FILTER_SANITIZE_STRING);
            
        }

        public function set_cli($cli){
            $cli = (isset($cli)?$cli:NULL);
            $this->cli = filter_var($cli,FILTER_SANITIZE_STRING);
            
        }

        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_desde($desde){
            $desde = (isset($desde)?$desde:NULL);
            $this->desde = filter_var($desde,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_orden($orden){
            $orden = (isset($orden)?$orden:NULL);
            $this->orden = filter_var($orden,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_id_temporada($id_temporada){
            $id_temporada = (isset($id_temporada)?$id_temporada:NULL);
            $this->id_temporada = filter_var($id_temporada,FILTER_SANITIZE_STRING);
            
        }

        public function set_etapa($etapa){
            $etapa = (isset($etapa)?$etapa:NULL);
            $this->etapa = filter_var($etapa,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_id_esp($id_esp){
            $id_esp = (isset($id_esp)?$id_esp:NULL);
            $this->id_esp = filter_var($id_esp,FILTER_SANITIZE_STRING);
            
        }

        public function set_info($info){
            $this->info = (isset($info)?$info:NULL);
            
        }

        public function set_tabla($tabla){
            $tabla = (isset($tabla)?$tabla:NULL);
            $this->tabla = filter_var($tabla,FILTER_SANITIZE_STRING);
            
        }

        public function set_campo($campo){
            $campo = (isset($campo)?$campo:NULL);
            $this->campo = filter_var($campo,FILTER_SANITIZE_STRING);
            
        }

        public function set_Q($Q){
            $Q = (isset($Q)?$Q:NULL);
            $this->Q = filter_var($Q,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_DQ($DQ){
            $DQ = (isset($DQ)?$DQ:NULL);
            $this->DQ = filter_var($DQ,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_AC($AC){
            $AC = (isset($AC)?$AC:NULL);
            $this->AC = filter_var($AC,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_M($M){
            $M = (isset($M)?$M:NULL);
            $this->M = filter_var($M,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_data($data) {
            $this->data = $data;

        }
    
        public function data() {
            return $this->data;

        }

        public function datoForaneo(){
            try{

                $conexion = new Conectar();

                if($this->tabla == "historial_predio"){
                    $sql = "SELECT group_concat(CONCAT(anno,' ==> ',    descripcion) SEPARATOR ' <br> ') AS Dato FROM ".$this->tabla;

                }else{
                    $sql = "SELECT ".$this->tabla.".".$this->campo." AS Dato FROM ".$this->tabla ;

                }

                switch($this->tabla){
                    case "anexo_contrato":
                        $sql .= "   WHERE id_ac = ".$this->AC;
                    break;
                    case "cliente":
                        $sql .= "   INNER JOIN quotation USING(id_cli) 
                                    WHERE id_quotation = ".$this->Q;
                    break;
                    case "especie":
                        $sql .= "   INNER JOIN quotation USING(id_esp)  
                                    WHERE id_quotation = ".$this->Q;
                    break;
                    case "materiales":
                        $sql .= "   WHERE id_materiales = ".$this->M;
                    break;
                    case "agricultor":
                        $sql .= "   INNER JOIN contrato_agricultor USING(id_agric)
                                    INNER JOIN contrato_anexo_temporada CAT USING (id_cont) 
                                    INNER JOIN anexo_contrato ON (anexo_contrato.id_ac = CAT.id_ac)
                                    WHERE CAT.id_ac = ".$this->AC." AND CAT.id_tempo = '".$this->id_temporada."' ";

                                    // echo $sql;
                    break;
                    case "predio":
                        $sql .= "   INNER JOIN lote USING (id_pred) 
                                    INNER JOIN anexo_contrato USING (id_lote) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "lote":
                        $sql .= "   INNER JOIN anexo_contrato USING (id_lote) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "visita":
                        $sql .= "   INNER JOIN anexo_contrato USING (id_ac) 
                                    WHERE id_ac = ".$this->AC." AND ".$this->tabla.".".$this->campo." != '' AND ".$this->tabla.".".$this->campo." != 'NULL' ORDER BY id_visita DESC LIMIT 1";
                    break;
                    /* case "detalle_visita_prop":
                        $sql .= "   INNER JOIN visita USING (id_visita)
                                    INNER JOIN anexo_contrato USING (id_ac)
                                    WHERE id_ac = ".$this->AC;
                    break; */
                    case "tipo_riego":
                        $sql .= "   INNER JOIN ficha USING (id_tipo_riego) 
                                    INNER JOIN anexo_contrato USING (id_ficha) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "tipo_suelo":
                        $sql .= "   INNER JOIN ficha USING (id_tipo_suelo) 
                                    INNER JOIN anexo_contrato USING (id_ficha) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "ficha":
                        $sql .= "   INNER JOIN anexo_contrato USING (id_ficha) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "usuarios":
                        $sql .= "   INNER JOIN visita USING (id_usuario) 
                                    WHERE id_ac = ".$this->AC;
                    break;
                    case "historial_predio":
                        $sql .= "   INNER JOIN ficha USING (id_ficha) 
                                    INNER JOIN anexo_contrato USING (id_ficha) 
                                    WHERE id_ac = ".$this->AC." 
                                    GROUP BY id_ficha";
                    break;

                }

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                // echo $sql;
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    $this->set_data($resultado["Dato"]);

                }else{
                    $this->set_data("");

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATO FORANEO] -> ha ocurrido un error ".$e->getMessage();
            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerDatosResumen(){
            try{
                $conexion = new Conectar();
                /* $sql = "SELECT Q.id_quotation, DQ.id_de_quo, M.id_materiales, AC.id_ac, (SELECT id_visita FROM visita WHERE id_ac = AC.id_ac AND estado_sincro = 1 ORDER BY id_visita DESC LIMIT 1) AS visita
                        FROM quotation Q 
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation 
                        INNER JOIN materiales M ON M.id_materiales = DQ.id_materiales 
                        INNER JOIN anexo_contrato AC ON AC.id_materiales = M.id_materiales "; */

                $sql = "SELECT Q.id_quotation, DQ.id_de_quo, M.id_materiales, AC.id_ac, (SELECT id_visita FROM visita WHERE id_ac = AC.id_ac AND estado_sincro = 1 ORDER BY id_visita DESC LIMIT 1) AS visita
                        FROM anexo_contrato AC 
                        INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo 
                        INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation ";

                        
                            
                    switch($_SESSION["tipo_curimapu"]){
                        case 1:
                            $sql.= "WHERE Q.id_tempo = ? AND Q.id_cli = ? AND Q.id_esp = ?";
                        break;
                        case 2:
                            $sql.= "INNER JOIN contrato_agricultor USING (id_cont)
                                    WHERE Q.id_tempo = ? AND id_agric = ? AND Q.id_esp = ?";
                        break;
                        case 3:
                            $sql.= "WHERE Q.id_tempo = ? AND ( AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario = ?) OR AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))) AND Q.id_esp = ? ";
                        break;
                        case 4:
                        case 5:
                            $sql.= "WHERE Q.id_tempo = ? AND Q.id_esp = ?";
                        break;

                    }

                $sql .= "   GROUP BY AC.id_ac
                            HAVING visita > 0
                            LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$_SESSION["enlace_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_STR);
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("4",$this->id_esp, PDO::PARAM_STR);
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                    break;

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(null);

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS RESUMEN] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalDatosResumen(){
            try{
                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();

                /* $sql = "SELECT count(*) AS Total
                        FROM quotation Q 
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation 
                        INNER JOIN materiales M ON M.id_materiales = DQ.id_materiales 
                        INNER JOIN anexo_contrato AC ON AC.id_materiales = M.id_materiales 
                        INNER JOIN visita V ON V.id_ac = AC.id_ac "; */
                $sql = "SELECT count(*) AS Total
                        FROM anexo_contrato AC 
                        INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo 
                        INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation 
                        INNER JOIN visita V ON V.id_ac = AC.id_ac ";
                            
                    switch($_SESSION["tipo_curimapu"]){
                        case 1:
                            $sql.= "WHERE Q.id_tempo = ? AND Q.id_cli = ? AND Q.id_esp = ?";
                        break;
                        case 2:
                            $sql.= "INNER JOIN contrato_agricultor USING (id_cont)
                                    WHERE Q.id_tempo = ? AND id_agric = ? AND Q.id_esp = ?";
                        break;
                        case 3:
                            $sql.= "WHERE Q.id_tempo = ? AND ( AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario = ?) OR AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))) AND Q.id_esp = ? ";
                        break;
                        case 4:
                        case 5:
                            $sql.= "WHERE Q.id_tempo = ? AND Q.id_esp = ?";
                        break;

                    }

                $sql .= " GROUP BY AC.id_ac";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$_SESSION["enlace_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_STR);
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                        $consulta->bindValue("4",$this->id_esp, PDO::PARAM_STR);
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                    break;

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS RESUMEN] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function headTabla(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT PCM.id_prop_mat_cli, SP.nombre_en AS subHead, P.nombre_en AS Head, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo 
                        FROM cli_pcm CPCM 
                        INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli)  
                        INNER JOIN sub_propiedades SP USING(id_sub_propiedad) 
                        LEFT JOIN propiedades P USING(id_prop) ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= "WHERE CPCM.id_cli = ? AND CPCM.ver = '1' AND PCM.id_etapa = ? AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                    break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $sql.= "WHERE PCM.id_etapa = ? AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                    break;

                }

                $sql.= " AND PCM.aplica = 'SI' GROUP BY PCM.id_prop_mat_cli ORDER BY PCM.orden ASC";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $consulta->bindValue("1",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("4",$this->id_temporada, PDO::PARAM_INT);
                    break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_temporada, PDO::PARAM_INT);
                    break;

                }
                
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[HEAD TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerDatosTabla(){
            try{
                /**********/
                /* Filtro */
                /**********/

                $filtro = "";
                if($this->ane != ""){ $filtro .= " AND num_anexo = '$this->ane'"; }
                if($this->var != ""){ $filtro .= " AND nom_hibrido LIKE '%$this->var%'"; }
                if($this->agr != ""){ $filtro .= " AND razon_social LIKE '%$this->agr%'"; }

                $having = "HAVING visita != 0 ";
                if($this->rec != ""){ $having .= " AND recome LIKE '%$this->rec%'"; }
                if($this->esp != ""){ $having .= " AND especie LIKE '%$this->esp%'"; }
                if($this->num != ""){ $having .= " AND num_lote = '$this->num'"; }
                if($this->pre != ""){ $having .= " AND predio LIKE '%$this->pre%'"; }
                if($this->pot != ""){ $having .= " AND lote LIKE '%$this->pot%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY recome ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY recome DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY num_lote ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY num_lote DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY num_anexo ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY num_anexo DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY E.nombre ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY nom_hibrido ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY nom_hibrido DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY razon_social ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY razon_social DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY predio ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY predio DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY lote ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY lote DESC";
                    break;
                    default:
                        $orden = "ORDER BY id_ac ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/
                
                $conexion = new Conectar();
                $sql = "SELECT id_visita AS visita, AC.id_ac, DQ.id_quotation, M.id_materiales, (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, num_lote, AC.num_anexo, E.nombre AS especie,  M.nom_hibrido, A.razon_social, P.nombre AS predio, L.nombre AS lote, group_concat(CONCAT(_det_vis_prop,' && ', _prop_mat_cli,' && ', valor) SEPARATOR ' | ') AS datos FROM
                    (
                        SELECT id_ac AS _ac, (SELECT id_visita FROM visita WHERE id_ac = _ac ORDER BY id_visita DESC LIMIT 1) AS num_lote, (SELECT id_visita FROM visita INNER JOIN detalle_visita_prop USING(id_visita) WHERE id_ac = _ac ORDER BY id_visita DESC LIMIT 1) AS id_visita, orden, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor
                        FROM detalle_visita_prop DVP
                        INNER JOIN prop_cli_mat USING ( id_prop_mat_cli )
                        INNER JOIN visita USING ( id_visita )
                        WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa = ? AND id_tempo = ? AND id_esp = ?
                        GROUP BY id_ac, id_prop_mat_cli
                        ORDER BY id_det_vis_prop DESC , orden ASC 
                    ) 
                    AS I
                    INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac
                    INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                    INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo
                    INNER JOIN especie E ON E.id_esp = M.id_esp
                    INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                    INNER JOIN lote L ON L.id_lote = F.id_lote
                    INNER JOIN predio P ON P.id_pred = F.id_pred
                    INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I._prop_mat_cli 
                                 WHERE id_visita != '0' AND CPCM.id_cli = ? AND CPCM.ver = '1' ";
                    break;
                    case 2:
                        $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                    break;
                    case 3:
                        $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                                WHERE id_visita != '0' AND ( UA.id_usuario = ? OR UA.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                    break;
                    case 4:
                    case 5:
                        $sql.= " WHERE id_visita != '0'";
                    break;

                }

                $sql .= "   $filtro GROUP BY AC.id_ac $having $orden
                            LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("5",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                    break;
    
                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(null);

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalDatosTabla(){
            try{

                /********/
                /* BIND */
                /********/
    
                $bind = array();

                /**********/
                /* Filtro */
                /**********/

                /* $filtro = "";
                if($this->ane != ""){ $filtro .= " AND num_anexo = '$this->ane'"; }
                if($this->esp != ""){ $filtro .= " AND especie LIKE '%$this->esp%'"; }
                if($this->var != ""){ $filtro .= " AND nom_hibrido LIKE '%$this->var%'"; }
                if($this->agr != ""){ $filtro .= " AND razon_social LIKE '%$this->agr%'"; }

                $having = "HAVING 1 ";
                if($this->rec != ""){ $having .= " AND recome LIKE '%$this->rec%'"; }
                if($this->num != ""){ $having .= " AND num_lote = '$this->num'"; }
                if($this->pre != ""){ $having .= " AND predio LIKE '%$this->pre%'"; }
                if($this->pot != ""){ $having .= " AND lote LIKE '%$this->pot%'"; } */

                $filtro = "";
                if($this->ane != ""){ $filtro .= " AND AC.num_anexo LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->ane."%")); }
                if($this->esp != ""){ $filtro .= " AND E.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->esp."%")); }
                if($this->var != ""){ $filtro .= " AND M.nom_hibrido LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->var."%")); }
                if($this->agr != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agr."%")); }
                if($this->pre != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->pre."%")); }
                if($this->pot != ""){ $filtro .= " AND L.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->pot."%")); }
    
                $having = "HAVING 1 ";
                if($this->rec != ""){ $having .= " AND recome LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rec."%")); }
                if($this->num != ""){ $having .= " AND num_lote LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->num."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                /* $sql = "SELECT count(*) AS Total
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN materiales M ON M.id_materiales = DQ.id_materiales
                        INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                        INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                        INNER JOIN visita V ON V.id_ac = AC.id_ac
                        INNER JOIN detalle_visita_prop DVP ON DVP.id_visita = V.id_visita
                        INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = DVP.id_prop_mat_cli "; */

                $sql = " SELECT (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, id_visita AS num_lote FROM 
                        (
                            SELECT id_ac AS _ac, (SELECT id_visita FROM visita WHERE id_ac = _ac ORDER BY id_visita DESC LIMIT 1) AS id_visita, orden, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor 
                            FROM detalle_visita_prop DVP 
                            INNER JOIN prop_cli_mat USING ( id_prop_mat_cli ) 
                            INNER JOIN visita USING ( id_visita ) 
                            WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa = ? AND id_tempo = ? AND id_esp = ? 
                            GROUP BY id_ac, id_prop_mat_cli 
                            ORDER BY id_det_vis_prop DESC, orden ASC 
                        ) 
                        AS I 
                        INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac 
                        INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo 
                        INNER JOIN especie E ON E.id_esp = M.id_esp 
                        INNER JOIN ficha F ON F.id_ficha = AC.id_ficha 
                        INNER JOIN lote L ON L.id_lote = F.id_lote 
                        INNER JOIN predio P ON P.id_pred = F.id_pred 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I._prop_mat_cli 
                                    WHERE id_visita != '0' AND CPCM.id_cli = ? AND CPCM.ver = '1' ";
                    break;
                    case 2:
                        $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                    break;
                    case 3:
                        $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                                WHERE id_visita != '0' AND ( UA.id_usuario = ? OR UA.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                    break;
                    case 4:
                    case 5:
                        $sql.= " WHERE id_visita != '0'";
                    break;

                }

                $sql .= "$filtro GROUP BY AC.id_ac $having";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $posicion = 0;
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);

                        $posicion = 4;
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("5",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);

                        $posicion = 5;
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_esp, PDO::PARAM_INT);

                        $posicion = 3;
                    break;
    
                }

                foreach($bind AS $dato){
                    $posicion++;
                    switch($dato["Tipo"]){
                        case "STR":
                            $consulta->bindValue($posicion,$dato["Dato"], PDO::PARAM_STR);
                        break;
                        case "INT":
                            $consulta->bindValue($posicion,$dato["Dato"], PDO::PARAM_INT);
                        break;
    
                    }
    
                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function headAll(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT PCM.id_prop_mat_cli, SP.nombre_en AS subHead, P.nombre_en AS Head, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo, PCM.id_etapa
                        FROM cli_pcm CPCM 
                        INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli) 
                        INNER JOIN sub_propiedades SP USING(id_sub_propiedad)
                        LEFT JOIN propiedades P USING(id_prop) ";

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= "WHERE CPCM.id_cli = ? AND CPCM.ver = '1' AND PCM.id_etapa != '1' AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                    break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $sql.= "WHERE PCM.id_etapa != '1' AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                    break;

                }

                $sql.= " AND PCM.aplica = 'SI' GROUP BY PCM.id_prop_mat_cli ORDER BY PCM.id_etapa,  PCM.orden ASC";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $consulta->bindValue("1",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->id_temporada, PDO::PARAM_INT);
                    break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_temporada, PDO::PARAM_INT);
                    break;

                }
                
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[HEAD ALL] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerDatosAll(){
            try{
                /**********/
                /* Filtro */
                /**********/

                $filtro = "";
                if($this->ane != ""){ $filtro .= " AND num_anexo = '$this->ane'"; }
                if($this->esp != ""){ $filtro .= " AND especie LIKE '%$this->esp%'"; }
                if($this->var != ""){ $filtro .= " AND nom_hibrido LIKE '%$this->var%'"; }
                if($this->agr != ""){ $filtro .= " AND razon_social LIKE '%$this->agr%'"; }

                $having = "HAVING visita != 0 ";
                if($this->rec != ""){ $having .= " AND recome LIKE '%$this->rec%'"; }
                if($this->num != ""){ $having .= " AND num_lote = '$this->num'"; }
                if($this->pre != ""){ $having .= " AND predio LIKE '%$this->pre%'"; }
                if($this->pot != ""){ $having .= " AND lote LIKE '%$this->pot%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY recome ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY recome DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY num_lote ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY num_lote DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY num_anexo ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY num_anexo DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY especie ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY especie DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY nom_hibrido ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY nom_hibrido DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY razon_social ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY razon_social DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY predio ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY predio DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY lote ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY lote DESC";
                    break;
                    default:
                        $orden = "ORDER BY id_ac ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_visita AS visita, AC.id_ac, DQ.id_quotation, M.id_materiales, (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, id_visita AS num_lote, AC.num_anexo, E.nombre AS especie,  M.nom_hibrido, A.razon_social, P.nombre AS predio, L.nombre AS lote, group_concat(CONCAT(_det_vis_prop,' && ', _prop_mat_cli,' && ', valor) SEPARATOR ' | ') AS datos FROM
                        (
                            SELECT id_ac AS _ac, (SELECT id_visita FROM visita WHERE id_ac = _ac ORDER BY id_visita DESC LIMIT 1) AS id_visita, orden, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor
                            FROM detalle_visita_prop DVP
                            INNER JOIN prop_cli_mat USING ( id_prop_mat_cli )
                            INNER JOIN visita USING ( id_visita )
                            WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa != 1 AND id_tempo = ? AND id_esp = ?
                            GROUP BY id_ac, id_prop_mat_cli
                            ORDER BY id_det_vis_prop DESC , orden ASC 
                        ) 
                        AS I
                        INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac
                        INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo
                        INNER JOIN especie E ON E.id_esp = M.id_esp
                        INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                        INNER JOIN lote L ON L.id_lote = F.id_lote
                        INNER JOIN predio P ON P.id_pred = F.id_pred
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I._prop_mat_cli 
                                 WHERE id_visita != '0' AND CPCM.id_cli = ? AND CPCM.ver = '1' ";
                    break;
                    case 2:
                        $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                    break;
                    case 3:
                        $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                                WHERE id_visita != '0' AND ( UA.id_usuario = ? OR UA.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                    break;
                    case 4:
                    case 5:
                        $sql.= " WHERE id_visita != '0'";
                    break;

                }

                $sql .= "   $filtro GROUP BY AC.id_ac $having $orden
                            LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_STR);
                        $consulta->bindValue("3",$_SESSION["enlace_curimapu"], PDO::PARAM_STR);
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_STR);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_STR);
                    break;

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(null);

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS ALL] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalDatosAll(){
            try{

                /********/
                /* BIND */
                /********/
    
                $bind = array();

                /**********/
                /* Filtro */
                /**********/

                /* $filtro = "";
                if($this->ane != ""){ $filtro .= " AND num_anexo = '$this->ane'"; }
                if($this->esp != ""){ $filtro .= " AND especie LIKE '%$this->esp%'"; }
                if($this->var != ""){ $filtro .= " AND nom_hibrido LIKE '%$this->var%'"; }
                if($this->agr != ""){ $filtro .= " AND razon_social LIKE '%$this->agr%'"; }

                $having = "HAVING 1 ";
                if($this->rec != ""){ $having .= " AND recome LIKE '%$this->rec%'"; }
                if($this->num != ""){ $having .= " AND num_lote = '$this->num'"; }
                if($this->pre != ""){ $having .= " AND predio LIKE '%$this->pre%'"; }
                if($this->pot != ""){ $having .= " AND lote LIKE '%$this->pot%'"; } */

                $filtro = "";
                if($this->ane != ""){ $filtro .= " AND AC.num_anexo LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->ane."%")); }
                if($this->esp != ""){ $filtro .= " AND E.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->esp."%")); }
                if($this->var != ""){ $filtro .= " AND M.nom_hibrido LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->var."%")); }
                if($this->agr != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agr."%")); }
                if($this->pre != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->pre."%")); }
                if($this->pot != ""){ $filtro .= " AND L.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->pot."%")); }
    
                $having = "HAVING 1 ";
                if($this->rec != ""){ $having .= " AND recome LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rec."%")); }
                if($this->num != ""){ $having .= " AND num_lote LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->num."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = " SELECT (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, id_visita AS num_lote FROM 
                        (
                            SELECT id_ac AS _ac, (SELECT id_visita FROM visita WHERE id_ac = _ac ORDER BY id_visita DESC LIMIT 1) AS id_visita, orden, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor 
                            FROM detalle_visita_prop DVP 
                            INNER JOIN prop_cli_mat USING ( id_prop_mat_cli ) 
                            INNER JOIN visita USING ( id_visita ) 
                            WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa != 1 AND id_tempo = ? AND id_esp = ? 
                            GROUP BY id_ac, id_prop_mat_cli 
                            ORDER BY id_det_vis_prop DESC, orden ASC 
                        ) 
                        AS I 
                        INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac 
                        INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo 
                        INNER JOIN especie E ON E.id_esp = M.id_esp 
                        INNER JOIN ficha F ON F.id_ficha = AC.id_ficha 
                        INNER JOIN lote L ON L.id_lote = F.id_lote 
                        INNER JOIN predio P ON P.id_pred = F.id_pred 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I._prop_mat_cli 
                                    WHERE id_visita != '0' AND CPCM.id_cli = ? AND CPCM.ver = '1' ";
                    break;
                    case 2:
                        $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                    break;
                    case 3:
                        $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                                WHERE id_visita != '0' AND ( UA.id_usuario = ? OR UA.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                    break;
                    case 4:
                    case 5:
                        $sql.= " WHERE id_visita != '0'";
                    break;

                }

                $sql .= "$filtro GROUP BY AC.id_ac $having";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $posicion = 0;
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                    case 2:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("3",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);

                        $posicion = 3;
                    break;
                    case 3:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);
                        $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                        $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);

                        $posicion = 4;
                    break;
                    case 4:
                    case 5:
                        $consulta->bindValue("1",$this->id_temporada, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->id_esp, PDO::PARAM_INT);

                        $posicion = 2;
                    break;
    
                }

                foreach($bind AS $dato){
                    $posicion++;
                    switch($dato["Tipo"]){
                        case "STR":
                            $consulta->bindValue($posicion,$dato["Dato"], PDO::PARAM_STR);
                        break;
                        case "INT":
                            $consulta->bindValue($posicion,$dato["Dato"], PDO::PARAM_INT);
                        break;
    
                    }
    
                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS ALL] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerImagenes(){
            try{
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $filtro = "";
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $filtro = " AND (vista = 'ambos' OR vista = 'cliente')";
                    break;
                    case 2:
                        $filtro = " AND (vista = 'ambos' OR vista = 'agricultor')";
                    break;
                    default:
                    break;

                }

                if($this->etapa < 5){
                    $sql = "SELECT ruta_foto FROM fotos WHERE field_book = ? AND tipo = ? AND id_visita IN (SELECT id_visita FROM visita WHERE id_ac = ? AND estado_sincro = 1) $filtro";

                }else{
                    $sql = "SELECT ruta_foto FROM fotos WHERE field_book != ?  AND tipo = ? AND id_visita IN (SELECT id_visita FROM visita WHERE id_ac = ? AND estado_sincro = 1) $filtro";

                }

                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->etapa, PDO::PARAM_INT);
                $consulta->bindValue("2","V", PDO::PARAM_STR);
                $consulta->bindValue("3",$this->id, PDO::PARAM_INT);
                
                $consulta->execute();
                if($consulta->rowCount() > 0){

                    $respuesta = array();

                    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach($resultado as $dato){
                        array_push($respuesta, array("ruta_foto" => traerBaseIMG($dato["ruta_foto"],"")));

                    }

                    $this->set_data($respuesta);

                }
        
            }catch(PDOException $e){
                echo "[TRAER IMAGENES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function asignarValor(){
            try{

                $datos = json_decode(json_encode($this->info), true);
                $efectividad = count($datos);

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                
                $cont = 0;
                foreach($datos as $key => $valor){
                    if($valor["Original"] != $valor["Cambio"]){
                        if($valor["Efectuar"] == "Si"){
                            $valor["Cambio"] = strtoupper(eliminar_acentos($valor["Cambio"]));
                            if($valor["Tipo"] == "1"){
                                $sql = "UPDATE detalle_visita_prop SET valor = ?, user_mod = ?, fecha_mod = ? WHERE id_det_vis_prop = ?";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$valor["Cambio"], PDO::PARAM_STR);
                                $consulta->bindValue("2",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                                $consulta->bindValue("3",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                                $consulta->bindValue("4",$key, PDO::PARAM_INT);
                                $consulta->execute();

                                $sql = "SELECT * FROM detalle_visita_prop WHERE valor = ? AND id_det_vis_prop = ?";
                                $consulta1 = $conexion->prepare($sql);
                                $consulta1->bindValue("1",$valor["Cambio"], PDO::PARAM_STR);
                                $consulta1->bindValue("2",$key, PDO::PARAM_INT);
                                $consulta1->execute();

                                if($consulta->rowCount() > 0 && $consulta->rowCount() == $consulta1->rowCount()){
                                    $cont++; 
                
                                }
    
                            }elseif($valor["Tipo"] == "2"){
                                $limpiar = explode("+",$key);
                                $key = $limpiar[0];
                                $sql = "INSERT INTO detalle_visita_prop (id_visita, id_prop_mat_cli, valor, id_cabecera, user_crea, fecha_crea) VALUES (?, ?, ?, (SELECT id_cabecera FROM (SELECT id_cabecera FROM detalle_visita_prop WHERE id_visita = ? LIMIT 1) AS sub), ?, ?)";
                                $consulta = $conexion->prepare($sql);
                                $consulta->bindValue("1",$key, PDO::PARAM_INT);
                                $consulta->bindValue("2",$valor["Propiedad"], PDO::PARAM_INT);
                                $consulta->bindValue("3",$valor["Cambio"], PDO::PARAM_STR);
                                $consulta->bindValue("4",$key, PDO::PARAM_INT);
                                $consulta->bindValue("5",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                                $consulta->bindValue("6",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                                $consulta->execute();

                                $sql = "SELECT * FROM detalle_visita_prop WHERE id_visita = ? AND id_prop_mat_cli = ? AND valor = ? AND id_cabecera = (SELECT id_cabecera FROM (SELECT id_cabecera FROM detalle_visita_prop WHERE id_visita = ? LIMIT 1) AS sub)";
                                $consulta1 = $conexion->prepare($sql);
                                $consulta1->bindValue("1",$key, PDO::PARAM_INT);
                                $consulta1->bindValue("2",$valor["Propiedad"], PDO::PARAM_INT);
                                $consulta1->bindValue("3",$valor["Cambio"], PDO::PARAM_STR);
                                $consulta1->bindValue("4",$key, PDO::PARAM_INT);
                                $consulta1->execute();
                                
                                if($consulta->rowCount() > 0 && $consulta->rowCount() == $consulta1->rowCount()){
                                    $cont++; 
                
                                }else{
                                    $sql = "DELETE FROM detalle_visita_prop WHERE id_visita = ? AND id_prop_mat_cli = ? AND valor = ? AND id_cabecera = (SELECT id_cabecera FROM (SELECT id_cabecera FROM detalle_visita_prop WHERE id_visita = ? LIMIT 1) AS sub)";
                                    $consulta1 = $conexion->prepare($sql);
                                    $consulta1->bindValue("1",$key, PDO::PARAM_INT);
                                    $consulta1->bindValue("2",$valor["Propiedad"], PDO::PARAM_INT);
                                    $consulta1->bindValue("3",$valor["Cambio"], PDO::PARAM_STR);
                                    $consulta1->bindValue("4",$key, PDO::PARAM_INT);
                                    $consulta1->execute();

                                }
    
                            }

                        }else{
                            $cont++; 

                        }

                    }else{
                        $cont++; 

                    }

                }

                if($cont == $efectividad){
                    $respuesta = "1";

                }else{
                    $respuesta = "3";

                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[ASIGNAR VALOR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;

        }

    }
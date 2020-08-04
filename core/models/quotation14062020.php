<?php
    require_once '../../db/conectarse_db.php';

    class Quotation{

        private $numero, $cliente, $especie, $observacion, $haC, $mt2C, $siteC, $usdC, $euroC, $clpC, $kgC, $haM, $kgE, $usdE, $usdP, $kgEx, $usdS;

        private $id, $desde, $orden, $temporada;

        private $data;

        public function set_numero($numero){
            $numero = (isset($numero)?$numero:NULL);
            $this->numero = filter_var($numero,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_cliente($cliente){
            $cliente = (isset($cliente)?$cliente:NULL);
            $this->cliente = filter_var($cliente,FILTER_SANITIZE_STRING);

        }
        
        public function set_especie($especie){
            $especie = (isset($especie)?$especie:NULL);
            $this->especie = filter_var($especie,FILTER_SANITIZE_STRING);

        }
        
        public function set_observacion($observacion){
            $observacion = (isset($observacion)?$observacion:NULL);
            $this->observacion = filter_var($observacion,FILTER_SANITIZE_EMAIL);

        }

        public function set_haC($haC){
            $haC = (isset($haC)?$haC:NULL);
            $this->haC = filter_var($haC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_mt2C($mt2C){
            $mt2C = (isset($mt2C)?$mt2C:NULL);
            $this->mt2C = filter_var($mt2C,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_siteC($siteC){
            $siteC = (isset($siteC)?$siteC:NULL);
            $this->siteC = filter_var($siteC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_usdC($usdC){
            $usdC = (isset($usdC)?$usdC:NULL);
            $this->usdC = filter_var($usdC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_euroC($euroC){
            $euroC = (isset($euroC)?$euroC:NULL);
            $this->euroC = filter_var($euroC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_clpC($clpC){
            $clpC = (isset($clpC)?$clpC:NULL);
            $this->clpC = filter_var($clpC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_kgC($kgC){
            $kgC = (isset($kgC)?$kgC:NULL);
            $this->kgC = filter_var($kgC,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_haM($haM){
            $haM = (isset($haM)?$haM:NULL);
            $this->haM = filter_var($haM,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_kgE($kgE){
            $kgE = (isset($kgE)?$kgE:NULL);
            $this->kgE = filter_var($kgE,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_usdE($usdE){
            $usdE = (isset($usdE)?$usdE:NULL);
            $this->usdE = filter_var($usdE,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_usdP($usdP){
            $usdP = (isset($usdP)?$usdP:NULL);
            $this->usdP = filter_var($usdP,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_kgEx($kgEx){
            $kgEx = (isset($kgEx)?$kgEx:NULL);
            $this->kgEx = filter_var($kgEx,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_usdS($usdS){
            $usdS = (isset($usdS)?$usdS:NULL);
            $this->usdS = filter_var($usdS,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_STRING);

        }

        public function set_desde($desde){
            $desde = (isset($desde)?$desde:NULL);
            $this->desde = filter_var($desde,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_orden($orden){
            $orden = (isset($orden)?$orden:NULL);
            $this->orden = filter_var($orden,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_temporada($temporada){
            $temporada = (isset($temporada)?$temporada:NULL);
            $this->temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
            
        }

        public function set_data($data) {
            $this->data = $data;

        }
    
        public function data() {
            return $this->data;
        }

        public function traerDatos(){
            try{
                /**********/
                /* Filtro */
                /**********/

                $filtro = " WHERE Q.id_quotation != 0 ";
                if($this->numero != "") $filtro .= " AND Q.numero_contrato LIKE '%$this->numero%'";
                if($this->cliente != "") $filtro .= " AND C.razon_social LIKE '%$this->cliente%'";
                if($this->especie != "") $filtro .= " AND E.nombre LIKE '%$this->especie%'";
                if($this->observacion != "") $filtro .= " AND Q.obs LIKE '%$this->observacion%'";

                /**********/
                /* Having */
                /**********/

                $having = " HAVING Q.id_quotation !=0 ";
                if($this->haC != "") $having .= " AND superficieHA = '$this->haC'";
                if($this->mt2C != "") $having .= " AND superficieMT = '$this->mt2C'";
                if($this->siteC != "") $having .= " AND superficieSi = '$this->siteC'";
                if($this->usdC != "") $having .= " AND costoUSD = '$this->usdC'";
                if($this->euroC != "") $having .= " AND costoEURO = '$this->euroC'";
                if($this->clpC != "") $having .= " AND costoCLP = '$this->clpC'";
                if($this->kgC != "") $having .= " AND kgs = '$this->kgC'";

                /* if($this->haM != ""){ $having .= " AND haM = '$this->haM'"; }
                if($this->kgE != ""){ $having .= " AND kgE = '$this->kgE'"; }
                if($this->usdE != ""){ $having .= " AND usdE = '$this->usdE'"; }
                if($this->usdP != ""){ $having .= " AND usdP = '$this->usdP'"; }
                if($this->kgEx != ""){ $having .= " AND kgEx = '$this->kgEx'"; }
                if($this->usdS != ""){ $having .= " AND usdS = '$this->usdS'"; } */

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY Q.numero_contrato ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY Q.numero_contrato DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY C.razon_social ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY C.razon_social DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY E.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY Q.obs ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY Q.obs DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY superficieHA ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY superficieHA DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY superficieMT ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY superficieMT DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY superficieSi ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY superficieSi DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY costoUSD ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY costoUSD DESC";
                    break;
                    case 17:
                        $orden = "ORDER BY costoEURO ASC";
                    break;
                    case 18:
                        $orden = "ORDER BY costoEURO DESC";
                    break;
                    case 19:
                        $orden = "ORDER BY costoCLP ASC";
                    break;
                    case 20:
                        $orden = "ORDER BY costoCLP DESC";
                    break;
                    case 21:
                        $orden = "ORDER BY kgs ASC";
                    break;
                    case 22:
                        $orden = "ORDER BY kgs DESC";
                    break;
                    /* case 23:
                        $orden = "ORDER BY Q.email ASC";
                    break;
                    case 24:
                        $orden = "ORDER BY Q.email DESC";
                    break;
                    case 25:
                        $orden = "ORDER BY Q.email ASC";
                    break;
                    case 26:
                        $orden = "ORDER BY Q.email DESC";
                    break;
                    case 27:
                        $orden = "ORDER BY Q.user ASC";
                    break;
                    case 28:
                        $orden = "ORDER BY Q.user DESC";
                    break;
                    case 29:
                        $orden = "ORDER BY Q.rut ASC";
                    break;
                    case 30:
                        $orden = "ORDER BY Q.rut DESC";
                    break;
                    case 31:
                        $orden = "ORDER BY Q.nombre ASC";
                    break;
                    case 32:
                        $orden = "ORDER BY Q.nombre DESC";
                    break;
                    case 33:
                        $orden = "ORDER BY Q.email ASC";
                    break;
                    case 34:
                        $orden = "ORDER BY Q.email DESC";
                    break; */
                    default:
                        $orden = "ORDER BY Q.numero_contrato ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT Q.id_quotation, Q.numero_contrato, C.razon_social, E.nombre, Q.obs, 
                        SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                        SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                        SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                        SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                        SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                        SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                        SUM(DQ.kg_contratados) AS kgs
                        FROM quotation Q 
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                        INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                        INNER JOIN especie E ON E.id_esp = Q.id_esp 
                        $filtro AND Q.id_tempo = ? GROUP BY Q.numero_contrato $having $orden LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function totalDatos(){
            try{
                /**********/
                /* Filtro */
                /**********/

                $filtro = " WHERE Q.id_quotation != 0 ";
                if($this->numero != "") $filtro .= " AND Q.numero_contrato LIKE '%$this->numero%'";
                if($this->cliente != "") $filtro .= " AND C.razon_social LIKE '%$this->cliente%'";
                if($this->especie != "") $filtro .= " AND E.nombre LIKE '%$this->especie%'";
                if($this->observacion != "") $filtro .= " AND Q.obs LIKE '%$this->observacion%'";

                /**********/
                /* Having */
                /**********/

                $having = " HAVING Q.id_quotation !=0 ";
                if($this->haC != "") $having .= " AND superficieHA = '$this->haC'";
                if($this->mt2C != "") $having .= " AND superficieMT = '$this->mt2C'";
                if($this->siteC != "") $having .= " AND superficieSi = '$this->siteC'";
                if($this->usdC != "") $having .= " AND costoUSD = '$this->usdC'";
                if($this->euroC != "") $having .= " AND costoEURO = '$this->euroC'";
                if($this->clpC != "") $having .= " AND costoCLP = '$this->clpC'";
                if($this->kgC != "") $having .= " AND kgs = '$this->kgC'";

                /* if($this->haM != ""){ $having .= " AND haM = '$this->haM'"; }
                if($this->kgE != ""){ $having .= " AND kgE = '$this->kgE'"; }
                if($this->usdE != ""){ $having .= " AND usdE = '$this->usdE'"; }
                if($this->usdP != ""){ $having .= " AND usdP = '$this->usdP'"; }
                if($this->kgEx != ""){ $having .= " AND kgEx = '$this->kgEx'"; }
                if($this->usdS != ""){ $having .= " AND usdS = '$this->usdS'"; } */

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT Q.id_quotation,
                            SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                            SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                            SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                            SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                            SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                            SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                            SUM(DQ.kg_contratados) AS kgs
                        FROM quotation Q 
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                        INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                        INNER JOIN especie E ON E.id_esp = Q.id_esp 
                        $filtro AND Q.id_tempo = ? GROUP BY Q.numero_contrato $having";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function traerInfo(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT E.nombre AS especie, M.nom_hibrido, D.superficie_contr, UM.nombre AS unidadM, D.kg_contratados, D.precio, Mo.nombre AS moneda, I.nombre AS incoterm, C.nombre AS condicion, TC.nombre AS certificacion, D.humedad, D.germinacion, D.pureza_genetica, D.fecha_recep_sem, D.pureza_fisica, D.fecha_despacho, D.enfermedades, D.maleza, D.declaraciones, TE.nombre AS envase, TE.neto, TD.nombre AS despacho, D.observaciones_del_precio
                        FROM detalle_quotation D
                        INNER JOIN materiales M ON M.id_materiales = D.id_materiales
                        INNER JOIN especie E ON E.id_esp = M.id_esp
                        INNER JOIN unidad_medida UM ON UM.id_um = D.id_um
                        INNER JOIN moneda Mo ON Mo.id_moneda = D.id_moneda
                        INNER JOIN incoterms I ON I.id_incot = D.id_incot
                        INNER JOIN condicion C ON C.id_tipo_condicion = D.id_tipo_condicion
                        INNER JOIN tipo_de_certificacion TC ON TC.id_tipo_cert = D.id_tipo_cert
                        INNER JOIN tipo_de_envase TE ON TE.id_tipo_envase = D.id_tipo_envase
                        INNER JOIN tipo_de_despacho TD ON TD.id_tipo_desp = D.id_tipo_desp
                        WHERE D.id_quotation = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function traerInfoPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT AC.num_anexo, Q.id_esp, V.estado_gen_culti, V.obs_gen, V.estado_crec, V.obs_cre, V.estado_male, V.obs_male, V.estado_fito, V.obs_fito, V.hum_del_suelo, V.obs_hum 
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                        INNER JOIN visita V ON V.id_ac = AC.id_ac
                        WHERE Q.id_quotation = ? AND V.estado_sincro = 1 
                        ORDER BY V.id_visita DESC LIMIT 1";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO PDF] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function traerCheckPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_prop_mat_cli, PCM.id_etapa AS etapa, PCM.nombre_en AS sub, P.nombre_en AS pri, especial
                        FROM prop_cli_mat PCM 
                        INNER JOIN propiedades P USING(id_prop) 
                        WHERE id_esp = ? AND aplica = 'SI' AND reporte_cliente = 'SI'
                        ORDER BY orden";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->numero, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TRAER CHECK PDF] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function ultimaEtapa(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT MAX(id_etapa) AS etapa 
                        FROM prop_cli_mat 
                        INNER JOIN detalle_visita_prop USING(id_prop_mat_cli) 
                        INNER JOIN visita USING(id_visita) WHERE id_ac = ? AND visita.estado_sincro = 1";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(NULL);

                }
        
            }catch(PDOException $e){
                echo "[TRAER ULTIMA ETAPA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
    
    }
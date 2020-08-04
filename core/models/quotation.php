<?php
    require_once '../../db/conectarse_db.php';

    class Quotation{

        private $cliente, $quotations, $detalles, $especies, $materiales, $agricultores, $supervisores;

        private $id, $desde, $orden, $temporada;

        private $data;
        
        public function set_cliente($cliente){
            $cliente = (isset($cliente)?$cliente:NULL);
            $this->cliente = filter_var($cliente,FILTER_SANITIZE_STRING);

        }
        
        public function set_quotations($quotations){
            $quotations = (isset($quotations)?$quotations:NULL);
            $this->quotations = filter_var($quotations,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_detalles($detalles){
            $detalles = (isset($detalles)?$detalles:NULL);
            $this->detalles = filter_var($detalles,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_especies($especies){
            $especies = (isset($especies)?$especies:NULL);
            $this->especies = filter_var($especies,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_materiales($materiales){
            $materiales = (isset($materiales)?$materiales:NULL);
            $this->materiales = filter_var($materiales,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_agricultores($agricultores){
            $agricultores = (isset($agricultores)?$agricultores:NULL);
            $this->agricultores = filter_var($agricultores,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_supervisores($supervisores){
            $supervisores = (isset($supervisores)?$supervisores:NULL);
            $this->supervisores = filter_var($supervisores,FILTER_SANITIZE_NUMBER_INT);

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

        public function set_temporada($temporada){
            $temporada = (isset($temporada)?$temporada:NULL);
            $this->temporada = filter_var($temporada,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_data($data) {
            $this->data = $data;

        }
    
        public function data() {
            return $this->data;
        }

        public function traerDatos(){
            try{

                /********/
                /* BIND */
                /********/

                $bind = array();

                /**********/
                /* Filtro */
                /**********/

                $filtro = "";
                if($this->cliente != ""){ $filtro .= " AND C.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->cliente."%")); }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY C.razon_social ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY C.razon_social DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY quotations ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY quotations DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY detalles ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY detalles DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY especies ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY especies DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY materiales ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY materiales DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY agricultores ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY agricultores DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY supervisores ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY supervisores DESC";
                    break;
                    default:
                        $orden = "ORDER BY C.razon_social ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                /* $sql = "SELECT C.id_cli, C.razon_social, 
                        COUNT( DISTINCT Q.id_quotation ) AS quotations, 
                        COUNT( DISTINCT DQ.id_de_quo ) AS detalles, 
                        COUNT( DISTINCT Q.id_esp ) AS especies, 
                        COUNT( DISTINCT DQ.id_materiales ) AS materiales, 
                        COUNT( DISTINCT CA.id_agric ) AS agricultores, 
                        COUNT( DISTINCT UA.id_usuario ) AS supervisores
                        FROM quotation Q
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN anexo_contrato AC ON AC.id_materiales = DQ.id_materiales
                        INNER JOIN contrato_agricultor CA ON CA.id_cont = AC.id_cont
                        INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac
                        WHERE Q.id_tempo = ? 
                        $filtro 
                        GROUP BY C.id_cli 
                        $having 
                        $orden 
                        LIMIT $this->desde,10"; */
                $sql = "SELECT C.id_cli, C.razon_social, 
                        SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                        SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                        SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                        SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                        SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                        SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                        SUM(DQ.kg_contratados) AS kgs, 
                        COUNT(DISTINCT Q.id_quotation) AS cantidad 
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                        INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                        INNER JOIN especie E ON E.id_esp = Q.id_esp 
                        WHERE Q.id_tempo = ? 
                        $filtro 
                        GROUP BY C.id_cli 
                        $orden 
                        LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_INT);

                $posicion = 1;
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
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER DATOS", "msg" => $e->getMessage()));
                /* echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalDatos(){
            try{

                /********/
                /* BIND */
                /********/

                $bind = array();

                /**********/
                /* Filtro */
                /**********/

                $filtro = "";
                if($this->cliente != ""){ $filtro .= " AND C.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->cliente."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT COUNT(*)
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                        INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                        INNER JOIN especie E ON E.id_esp = Q.id_esp 
                        WHERE Q.id_tempo = ? 
                        $filtro 
                        GROUP BY C.id_cli ";
                        
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_INT);

                $posicion = 1;
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
                    $this->set_data(array("status" => "success", "Total" => $consulta->rowCount()));

                }else{
                    $this->set_data(array("status" => "success", "Total" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TOTAL DATOS", "msg" => $e->getMessage()));
                /* echo "[TOTAL DATOS] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerInfo(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT Q.id_quotation, Q.numero_contrato, E.nombre, Q.obs, 
                        SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                        SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                        SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                        SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                        SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                        SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                        SUM(DQ.kg_contratados) AS kgs, 
                        COUNT(DQ.id_de_quo) AS cantidad 
                        FROM quotation Q 
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                        INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                        INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                        INNER JOIN especie E ON E.id_esp = Q.id_esp 
                        WHERE Q.id_cli = ? AND Q.id_tempo = ? 
                        GROUP BY Q.numero_contrato 
                        ORDER BY Q.numero_contrato";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO", "msg" => $e->getMessage()));
                /* echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerInfoAnexosPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT AC.id_ac, AC.num_anexo, Q.id_esp, (SELECT CONCAT( V.recome,' -> ', V.obs,' && ', V.estado_gen_culti,' -> ', V.obs_gen,' && ', V.estado_crec,' -> ', V.obs_cre,' && ', V.estado_male,' -> ', V.obs_male,' && ', V.estado_fito,' -> ', V.obs_fito,' && ', V.hum_del_suelo,' -> ', V.obs_hum)
                                FROM anexo_contrato A
                                INNER JOIN visita V ON V.id_ac = A.id_ac
                                WHERE A.id_ac = AC.id_ac AND V.estado_sincro = 1 
                                ORDER BY V.id_visita DESC LIMIT 1) AS Obs
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                        WHERE Q.id_cli = ? AND Q.id_tempo = ?
                        GROUP BY AC.id_ac";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO PDF C", "msg" => $e->getMessage()));
                /* echo "[TRAER INFO PDF C] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerCheckAnexosPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_prop_mat_cli, E.nombre AS especie, PCM.id_etapa AS etapa, U.nombre AS nombreE, SP.nombre_en AS sub, P.nombre_en AS pri, especial
                        FROM prop_cli_mat PCM 
                        INNER JOIN sub_propiedades SP USING(id_sub_propiedad)
                        INNER JOIN propiedades P USING(id_prop) 
                        INNER JOIN especie E USING(id_esp)
                        INNER JOIN etapa U USING(id_etapa)
                        WHERE id_esp IN (SELECT id_esp FROM quotation INNER JOIN detalle_quotation USING(id_quotation) WHERE id_cli = ?) AND aplica = 'SI' AND reporte_cliente = 'SI' AND id_tempo = ?
                        ORDER BY id_esp, id_etapa, orden ASC";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO PDF C", "msg" => $e->getMessage()));
                /* echo "[TRAER CHECK PDF C] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerInfoPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT AC.num_anexo, Q.id_esp, V.obs, V.estado_gen_culti, V.obs_gen, V.estado_crec, V.obs_cre, V.estado_male, V.obs_male, V.estado_fito, V.obs_fito, V.hum_del_suelo, V.obs_hum 
                        FROM quotation Q
                        INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                        INNER JOIN anexo_contrato AC ON AC.id_de_quo = DQ.id_de_quo
                        INNER JOIN visita V ON V.id_ac = AC.id_ac
                        WHERE Q.id_quotation = ? AND Q.id_tempo = ? AND V.estado_sincro = 1 
                        ORDER BY V.id_visita DESC LIMIT 1";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO PDF", "msg" => $e->getMessage()));
                /* echo "[TRAER INFO PDF] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerCheckPdf(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_prop_mat_cli, PCM.id_etapa AS etapa, U.nombre AS nombreE, SP.nombre_en AS sub, P.nombre_en AS pri, especial
                        FROM prop_cli_mat PCM 
                        INNER JOIN sub_propiedades SP USING(id_sub_propiedad)
                        INNER JOIN propiedades P USING(id_prop) 
                        INNER JOIN etapa U USING(id_etapa)
                        WHERE id_esp = ? AND id_tempo = ? AND aplica = 'SI' AND reporte_cliente = 'SI'
                        ORDER BY id_etapa, orden";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->temporada, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("status" => "success", "data" => $consulta->fetchAll(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO PDF", "msg" => $e->getMessage()));
                /* echo "[TRAER CHECK PDF] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
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
                    $this->set_data(array("status" => "success", "data" => $consulta->fetch(PDO::FETCH_ASSOC)));

                }else{
                    $this->set_data(array("status" => "success", "data" => NULL));

                }
        
            }catch(PDOException $e){
                $this->set_data(array("status" => "error", "exec" => "TRAER INFO PDF", "msg" => $e->getMessage()));
                /* echo "[TRAER ULTIMA ETAPA] -> ha ocurrido un error ".$e->getMessage(); */

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
    
    }
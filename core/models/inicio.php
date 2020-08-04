<?php
    require_once '../../db/conectarse_db.php';

    class Inicio{

        private $temporada;

        private $data;

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

        public function totalAgricultores(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT SUM(Total) AS Total 
                            FROM ( SELECT count(*) AS Total 
                                FROM agricultor A 
                                INNER JOIN contrato_agricultor CA ON CA.id_agric = A.id_agric
                                INNER JOIN contrato_anexo_temporada CAT ON (CAT.id_cont = CA.id_cont)
                                WHERE CAT.id_tempo = ?
                                GROUP BY A.id_agric ) Agricultores";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL AGRICULTORES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalContratos(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total 
                        FROM contrato_agricultor CA
                        INNER JOIN contrato_anexo_temporada CAT USING (id_cont)
                        WHERE CAT.id_tempo = ?  GROUP BY CAT.id_cont";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL CONTRATOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalQuotation(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total 
                        FROM quotation
                        WHERE id_tempo = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL QUOTATION] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalEspecies(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total 
                        FROM especie";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL ESPECIES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalHectareas(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT sum(DQ.superficie_contr) AS Total 
                        FROM detalle_quotation DQ 
                        INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation
                        WHERE Q.id_tempo = ? AND DQ.id_um = '8'";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL HECTAREAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalVisitas(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total 
                        FROM visita V 
                        INNER JOIN anexo_contrato AC ON AC.id_ac = V.id_ac
                        INNER JOIN contrato_anexo_temporada CAT ON (CAT.id_ac = AC.id_ac) 
                        INNER JOIN contrato_agricultor CA ON CA.id_cont = CAT.id_cont
                        WHERE CAT.id_tempo = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL VISITAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function visPredio(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT P.nombre AS predio, COUNT(id_visita) AS visitas
                        FROM predio P
                        INNER JOIN lote USING (id_pred)
                        INNER JOIN anexo_contrato USING (id_lote)
                        LEFT JOIN visita USING (id_ac)
                        WHERE id_tempo = ?
                        GROUP BY id_pred";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[VIS PREDIO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function predNoVis(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT P.nombre AS predio
                        FROM predio P
                        INNER JOIN lote USING (id_pred)
                        INNER JOIN anexo_contrato USING (id_lote)
                        LEFT JOIN visita USING (id_ac)
                        WHERE id_tempo = ? AND fecha_r <= '".date("Y-m-d",strtotime(date("Y-m-d")."- 10 days"))."'
                        GROUP BY id_pred ";

                        // echo $sql;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[PRED NO VIS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function haEspecies(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT SUM(superficie) AS ha, P.nombre AS especie
                        FROM anexo_contrato AC
                        INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
                        INNER JOIN contrato_agricultor CA ON (CA.id_cont = CAT.id_cont)
                        INNER JOIN especie P USING (id_esp)
                        WHERE CAT.id_tempo = ? 
                        GROUP BY P.id_esp; ";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[HA ESPECIES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function haVariedad(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT SUM(superficie) AS ha, M.nom_hibrido AS variedad 
                        FROM anexo_contrato  AC
                        INNER JOIN contrato_anexo_temporada  CAT USING (id_ac)
                        INNER JOIN contrato_agricultor CA ON (CA.id_cont = CAT.id_cont) 
                        INNER JOIN materiales M USING (id_materiales) 
                        WHERE CAT.id_tempo = ? 
                        GROUP BY M.id_materiales; ";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[HA VARIEDAD] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

    }
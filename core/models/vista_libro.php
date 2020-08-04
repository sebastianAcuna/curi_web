<?php
    require_once '../../db/conectarse_db.php';

    class Vista{

        private $razon, $rut;

        private $id, $check, $plataforma, $especie, $etapa, $cambio, $desde, $orden;

        private $data;

        public function set_razon($razon){
            $razon = (isset($razon)?$razon:NULL);
            $this->razon = filter_var($razon,FILTER_SANITIZE_STRING);

        }
        
        public function set_rut($rut){
            $rut = (isset($rut)?$rut:NULL);
            $this->rut = filter_var($rut,FILTER_SANITIZE_STRING);

        }
        
        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_check($check){
            $check = (isset($check)?$check:NULL);
            $this->check = filter_var($check,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_plataforma($plataforma){
            $plataforma = (isset($plataforma)?$plataforma:NULL);
            $this->plataforma = filter_var($plataforma,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_especie($especie){
            $especie = (isset($especie)?$especie:NULL);
            $this->especie = filter_var($especie,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_etapa($etapa){
            $etapa = (isset($etapa)?$etapa:NULL);
            $this->etapa = filter_var($etapa,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_cambio($cambio){
            $cambio = (isset($cambio)?$cambio:NULL);
            $this->cambio = filter_var($cambio,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_desde($desde){
            $desde = (isset($desde)?$desde:NULL);
            $this->desde = filter_var($desde,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_orden($orden){
            $orden = (isset($orden)?$orden:NULL);
            $this->orden = filter_var($orden,FILTER_SANITIZE_NUMBER_INT);
            
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

                $filtro = "WHERE id_cli != 0";
                if($this->razon != "" && !is_null($this->razon)){ $filtro .= " AND razon_social LIKE '%$this->razon%'"; }
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut_cliente LIKE '%$this->rut%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY razon_social ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY razon_social DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY rut_cliente ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY rut_cliente DESC";
                    break;
                    default:
                        $orden = "ORDER BY razon_social ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_cli, razon_social, rut_cliente FROM cliente $filtro $orden LIMIT $this->desde,10";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    $sql = "SELECT CPCM.id_cli, COUNT(*) AS cantidad FROM cli_pcm CPCM INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = CPCM.id_prop_mat_cli WHERE PCM.id_etapa = '2' AND CPCM.ver = '2'";
                    $consulta = $conexion->prepare($sql);
                    $consulta->execute();
                    $cont1 = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    $sql = "SELECT CPCM.id_cli, COUNT(*) AS cantidad  FROM cli_pcm CPCM INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = CPCM.id_prop_mat_cli WHERE PCM.id_etapa = '3' AND CPCM.ver = '2'";
                    $consulta = $conexion->prepare($sql);
                    $consulta->execute();
                    $cont2 = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    $sql = "SELECT CPCM.id_cli, COUNT(*) AS cantidad  FROM cli_pcm CPCM INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = CPCM.id_prop_mat_cli WHERE PCM.id_etapa = '4' AND CPCM.ver = '2'";
                    $consulta = $conexion->prepare($sql);
                    $consulta->execute();
                    $cont3 = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    $this->set_data(array($resultado, $cont1, $cont2, $cont3));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage();

            }

            $consulta = NULL;
            $conexion = NULL;

        }

        public function totalDatos(){
            try{
                /**********/
                /* Filtro */
                /**********/

                $filtro = "WHERE id_cli != 0";
                if($this->razon != "" && !is_null($this->razon)){ $filtro .= " AND razon_social LIKE '%$this->razon%'"; }
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut_cliente LIKE '%$this->rut%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM cliente $filtro";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerInfo(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                
                $sql = "SELECT nombre FROM bloquea_vista INNER JOIN usuarios USING (id_usuario) WHERE id_cli = ? AND id_esp = ? AND id_etapa = ? AND id_plataforma = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->especie, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->etapa, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->plataforma, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    $this->set_data(array("uso" => true, "usuario" => $resultado["nombre"]));

                }else{

                    if($this->plataforma == 1){
                        $sql = "SELECT CPCM.id_cli_pcm, SP.nombre_en, P.nombre_en AS propiedad, CPCM.ver 
                                FROM cli_pcm CPCM 
                                INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli) 
                                INNER JOIN sub_propiedades SP USING(id_sub_propiedad) 
                                INNER JOIN propiedades P USING(id_prop) 
                                WHERE CPCM.id_cli = ? AND PCM.id_esp = ? AND PCM.id_etapa = ? AND PCM.aplica = 'SI'";

                    }else{
                        $sql = "SELECT CPCM.id_cli_pcm, SP.nombre_en, P.nombre_en AS propiedad, CPCM.registrar 
                                FROM cli_pcm CPCM 
                                INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli) 
                                INNER JOIN sub_propiedades SP USING(id_sub_propiedad) 
                                INNER JOIN propiedades P USING(id_prop) 
                                WHERE CPCM.id_cli = ? AND PCM.id_esp = ? AND PCM.id_etapa = ?  AND PCM.aplica = 'SI'";
                    
                    }

                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->especie, PDO::PARAM_INT);
                    $consulta->bindValue("3",$this->etapa, PDO::PARAM_INT);
                    $consulta->execute();
                    if($consulta->rowCount() > 0){
                        $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                        $sql = "INSERT INTO bloquea_vista (id_cli, id_esp, id_etapa, id_plataforma, id_usuario) values (?, ?, ?, ?, ?)";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                        $consulta->bindValue("2",$this->especie, PDO::PARAM_INT);
                        $consulta->bindValue("3",$this->etapa, PDO::PARAM_INT);
                        $consulta->bindValue("4",$this->plataforma, PDO::PARAM_INT);
                        $consulta->bindValue("5",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                        $consulta->execute();

                    }else{
                        $this->set_data(null);

                    }

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function desbloquearVista(){
            try{

                $sql = "DELETE FROM bloquea_vista WHERE id_usuario = ?";
                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                $consulta->execute();

                $resultado = 0;

                if($consulta->rowCount() > 0){
                    $resultado = 1;

                }

                return $resultado;
        
            }catch(PDOException $e){
                echo "[DESBLOQUEAR VISTA] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerEspecies(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT E.id_esp, E.nombre, C.razon_social 
                        FROM especie E 
                        INNER JOIN contrato_cliente CC ON CC.id_esp = E.id_esp 
                        INNER JOIN cliente C ON C.id_cli = CC.id_cli 
                        WHERE CC.id_cli = ? 
                        GROUP BY E.id_esp";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ESPECIES] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerEtapas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_etapa, nombre 
                        FROM etapa 
                        GROUP BY id_etapa";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ETAPAS] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $conexion = NULL;

        }

        public function eventoCheck(){
            try{

                if($this->plataforma == 1){
                    $conexion = new Conectar();
                    $sql = "UPDATE cli_pcm SET ver = ?, user_mod = ?, fecha_mod = ? WHERE id_cli_pcm = ? AND id_cli = ?";
                    $conexion = $conexion->conexion();
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->cambio, PDO::PARAM_INT);
                    $consulta->bindValue("2",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->check, PDO::PARAM_INT);
                    $consulta->bindValue("5",$this->id, PDO::PARAM_INT);
                    $consulta->execute();
    
                    $sql = "SELECT * FROM cli_pcm WHERE ver = ? AND id_cli_pcm = ? AND id_cli = ?";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$this->cambio, PDO::PARAM_INT);
                    $consulta1->bindValue("2",$this->check, PDO::PARAM_INT);
                    $consulta1->bindValue("3",$this->id, PDO::PARAM_INT);
                    $consulta1->execute();
    
                    if($consulta->rowCount() > 0 && $consulta->rowCount() == $consulta1->rowCount()){
                        $respuesta = "1";
    
                    }else{
                        $respuesta = "3";
    
                    }

                }else{
                    $conexion = new Conectar();
                    $sql = "UPDATE cli_pcm SET registrar = ?, user_mod = ?, fecha_mod = ? WHERE id_cli_pcm = ? AND id_cli = ?";
                    $conexion = $conexion->conexion();
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->cambio, PDO::PARAM_INT);
                    $consulta->bindValue("2",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->check, PDO::PARAM_INT);
                    $consulta->bindValue("5",$this->id, PDO::PARAM_INT);
                    $consulta->execute();
    
                    $sql = "SELECT * FROM cli_pcm WHERE registrar = ? AND id_cli_pcm = ? AND id_cli = ?";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$this->cambio, PDO::PARAM_INT);
                    $consulta1->bindValue("2",$this->check, PDO::PARAM_INT);
                    $consulta1->bindValue("3",$this->id, PDO::PARAM_INT);
                    $consulta1->execute();
    
                    if($consulta->rowCount() > 0 && $consulta->rowCount() == $consulta1->rowCount()){
                        $respuesta = "1";
    
                    }else{
                        $respuesta = "3";
    
                    }

                }

                return $respuesta;
        
            }catch(PDOException $e){
                echo "[EVENTO CHECK] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;

        }
        
        public function marcarChecks(){
            try{

                if($this->plataforma == 1){
                    $conexion = new Conectar();
                    $sql = "SELECT id_cli_pcm FROM cli_pcm CPCM INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli) WHERE PCM.id_esp = ? AND PCM.id_etapa = ? AND PCM.aplica = 'SI'";
                    $conexion = $conexion->conexion();
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->especie, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->etapa, PDO::PARAM_INT);
                    $consulta->execute();

                    $cont = 0;
                    if($consulta->rowCount() > 0){
                        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultado as $dato){
                            $sql = "UPDATE cli_pcm SET ver = ?, user_mod = ?, fecha_mod = ? WHERE id_cli_pcm = ? AND id_cli = ?";
                            $consulta1 = $conexion->prepare($sql);
                            $consulta1->bindValue("1",$this->cambio, PDO::PARAM_INT);
                            $consulta1->bindValue("2",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                            $consulta1->bindValue("3",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                            $consulta1->bindValue("4",$dato["id_cli_pcm"], PDO::PARAM_INT);
                            $consulta1->bindValue("5",$this->id, PDO::PARAM_INT);
                            $consulta1->execute();
    
                            $sql = "SELECT * FROM cli_pcm WHERE ver = ? AND id_cli_pcm = ? AND id_cli = ?";
                            $consulta2 = $conexion->prepare($sql);
                            $consulta2->bindValue("1",$this->cambio, PDO::PARAM_INT);
                            $consulta2->bindValue("2",$dato["id_cli_pcm"], PDO::PARAM_INT);
                            $consulta2->bindValue("3",$this->id, PDO::PARAM_INT);
                            $consulta2->execute();
                            
                            if($consulta2->rowCount() > 0){
                                $cont++;

                            }

                        }

                    }

                    if($cont == $consulta->rowCount()){
                        $respuesta = "1";

                    }else{
                        $respuesta = "3";

                    }

                }else{
                    $conexion = new Conectar();
                    $sql = "SELECT id_cli_pcm FROM cli_pcm CPCM INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli) WHERE PCM.id_esp = ? AND PCM.id_etapa = ? AND PCM.aplica = 'SI'";
                    $conexion = $conexion->conexion();
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->especie, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->etapa, PDO::PARAM_INT);
                    $consulta->execute();

                    $cont = 0;
                    if($consulta->rowCount() > 0){
                        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultado as $dato){
                            $sql = "UPDATE cli_pcm SET registrar = ?, user_mod = ?, fecha_mod = ? WHERE id_cli_pcm = ? AND id_cli = ?";
                            $consulta1 = $conexion->prepare($sql);
                            $consulta1->bindValue("1",$this->cambio, PDO::PARAM_INT);
                            $consulta1->bindValue("2",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                            $consulta1->bindValue("3",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                            $consulta1->bindValue("4",$dato["id_cli_pcm"], PDO::PARAM_INT);
                            $consulta1->bindValue("5",$this->id, PDO::PARAM_INT);
                            $consulta1->execute();
    
                            $sql = "SELECT * FROM cli_pcm WHERE registrar = ? AND id_cli_pcm = ? AND id_cli = ?";
                            $consulta2 = $conexion->prepare($sql);
                            $consulta2->bindValue("1",$this->cambio, PDO::PARAM_INT);
                            $consulta2->bindValue("2",$dato["id_cli_pcm"], PDO::PARAM_INT);
                            $consulta2->bindValue("3",$this->id, PDO::PARAM_INT);
                            $consulta2->execute();
                            
                            if($consulta2->rowCount() > 0){
                                $cont++;

                            }

                        }

                    }

                    if($cont == $consulta->rowCount()){
                        $respuesta = "1";

                    }else{
                        $respuesta = "3";

                    }
                    
                }
        
                return $respuesta;

            }catch(PDOException $e){
                echo "[MARCAR CHECKS] -> ha ocurrido un error ".$e->getMessage();

            }
            
            $consulta = NULL;
            $consulta1 = NULL;
            $consulta2 = NULL;
            $conexion = NULL;

        }
    
    }
<?php
    require_once '../../db/conectarse_db.php';

    class Potreros{

        /* ID */
        private $id_predio, $id_agric, $id_tempo;

        /* TEXT */
        private $agricultor, $predio, $region, $comuna, $nombre, $nombre_ac, $telefono_ac;

        /* WHERE */
        private $id, $desde, $orden;

        /* DATA */
        private $data;

        public function set_agricultor($agricultor){
            $agricultor = (isset($agricultor)?$agricultor:NULL);
            $this->agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);

        }

        public function set_predio($predio){
            $predio = (isset($predio)?$predio:NULL);
            $this->predio = filter_var($predio,FILTER_SANITIZE_STRING);

        }

        public function set_region($region){
            $region = (isset($region)?$region:NULL);
            $this->region = filter_var($region,FILTER_SANITIZE_STRING);

        }

        public function set_comuna($comuna){
            $comuna = (isset($comuna)?$comuna:NULL);
            $this->comuna = filter_var($comuna,FILTER_SANITIZE_STRING);

        }
        
        public function set_nombre($nombre){
            $nombre = (isset($nombre)?$nombre:NULL);
            $this->nombre = filter_var($nombre,FILTER_SANITIZE_STRING);

        }
        
        public function set_nombre_ac($nombre_ac){
            $nombre_ac = (isset($nombre_ac)?$nombre_ac:NULL);
            $this->nombre_ac = filter_var($nombre_ac,FILTER_SANITIZE_STRING);

        }
        
        public function set_telefono_ac($telefono_ac){
            $telefono_ac = (isset($telefono_ac)?$telefono_ac:NULL);
            $this->telefono_ac = filter_var($telefono_ac,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_id_agric($id_agric){
            $id_agric = (isset($id_agric)?$id_agric:NULL);
            $this->id_agric = filter_var($id_agric,FILTER_SANITIZE_STRING);

        }

        public function set_id_predio($id_predio){
            $id_predio = (isset($id_predio)?$id_predio:NULL);
            $this->id_predio = filter_var($id_predio,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_id_tempo($id_tempo){
            $id_tempo = (isset($id_tempo)?$id_tempo:NULL);
            $this->id_tempo = filter_var($id_tempo,FILTER_SANITIZE_NUMBER_INT);

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
                if($this->agricultor != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agricultor."%")); }
                if($this->predio != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->predio."%")); }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->region."%")); }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->comuna."%")); }
                if($this->nombre != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%")); }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY A.razon_social ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY A.razon_social DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY P.nombre ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY P.nombre DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY R.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY R.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY C.nombre ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY C.nombre DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY L.nombre ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY L.nombre DESC";
                    break;
                    default:
                        $orden = "ORDER BY A.razon_social, P.nombre, L.nombre ASC";
                    break;

                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT L.id_lote, A.razon_social, P.nombre AS predio, R.nombre AS region, C.nombre AS comuna, L.nombre 
                        FROM lote L 
                        INNER JOIN predio P ON P.id_pred = L.id_pred 
                        INNER JOIN agri_pred_temp APT ON APT.id_pred = P.id_pred
                        INNER JOIN agricultor A ON A.id_agric = APT.id_agric 
                        INNER JOIN region R ON R.id_region = P.id_region 
                        INNER JOIN comuna C ON C.id_comuna = P.id_comuna 
                        WHERE APT.id_tempo = ? 
                        $filtro 
                        $orden 
                        LIMIT $this->desde,10";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_INT);

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
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage();

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
                if($this->agricultor != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agricultor."%")); }
                if($this->predio != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->predio."%")); }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->region."%")); }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->comuna."%")); }
                if($this->nombre != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total  
                        FROM lote L 
                        INNER JOIN predio P ON P.id_pred = L.id_pred 
                        INNER JOIN agri_pred_temp APT ON APT.id_pred = P.id_pred 
                        INNER JOIN agricultor A ON A.id_agric = APT.id_agric 
                        INNER JOIN region R ON R.id_region = P.id_region 
                        INNER JOIN comuna C ON C.id_comuna = P.id_comuna 
                        WHERE APT.id_tempo = ? 
                        $filtro";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_INT);

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
                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT APT.id_agric, APT.id_tempo, L.id_pred, L.nombre, L.nombre_ac, L.telefono_ac 
                        FROM lote L 
                        INNER JOIN predio P ON P.id_pred = L.id_pred 
                        INNER JOIN agri_pred_temp APT ON APT.id_pred = P.id_pred
                        WHERE L.id_lote = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearPotrero(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();

            $existe = false;
            
            try{

                $sql = "SELECT * FROM lote WHERE id_pred = ? AND nombre = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_predio, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->nombre, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "INSERT INTO lote (id_pred, nombre, nombre_ac, telefono_ac, user_crea, fecha_crea) VALUES (?, ?, ?, ?, ?, ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_predio, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("3",$this->nombre_ac, PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->telefono_ac, PDO::PARAM_INT);
                    $consulta->bindValue("5",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("6",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->execute();

                    if($consulta->rowCount() <= 0){
                        $rollback = true;

                    }

                }else{
                    $rollback = true;
                    $existe = true;

                }

            }catch(PDOException $e){
                echo "[CREAR POTRERO] -> ha ocurrido un error ".$e->getMessage();

            }
            
            if($rollback){
                $conexion->rollback();
                $respuesta = "3";

            }else{
                $conexion->commit();
                $respuesta = (!$existe)?"1":"2";

            }
        
            $consulta = NULL;
            $conexion = NULL;

            return $respuesta;

        }

        public function editarPotrero(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();

            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $sql = "SELECT * FROM lote WHERE id_lote != ? AND id_pred = ? AND nombre = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_predio, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->nombre, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "UPDATE lote SET id_pred = ?, nombre = ?, nombre_ac = ?, telefono_ac = ?, user_mod = ?, fecha_mod = ? WHERE id_lote = ?";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_predio, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("3",$this->nombre_ac, PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->telefono_ac, PDO::PARAM_INT);
                    $consulta->bindValue("5",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("6",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("7",$this->id, PDO::PARAM_INT);
                    $consulta->execute();

                    if($consulta->rowCount() <= 0){
                        $rollback = true;

                    }

                }else{
                    $rollback = true;
                    $existe = true;

                }

            }catch(PDOException $e){
                echo "[EDITAR POTRERO] -> ha ocurrido un error ".$e->getMessage();

            }
            
            if($rollback){
                $conexion->rollback();
                $respuesta = "3";

            }else{
                $conexion->commit();
                $respuesta = (!$existe)?"1":"2";

            }
        
            $consulta = NULL;
            $conexion = NULL;

            return $respuesta;

        }
    
        public function traerPredios(){
            try{
                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_pred, nombre FROM predio INNER JOIN agri_pred_temp APT USING(id_pred) WHERE id_agric = ? AND id_tempo = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_agric, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER PREDIOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

    }
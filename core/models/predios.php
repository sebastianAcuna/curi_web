<?php
    require_once '../../db/conectarse_db.php';

    class Predios{

        /* ID */
        private $id_agric, $id_tempo, $id_region, $id_comuna;

        /* TEXT */
        private $agricultor, $region, $comuna, $nombre;

        /* WHERE */
        private $id, $desde, $orden;

        /* DATA */
        private $data;

        public function set_agricultor($agricultor){
            $agricultor = (isset($agricultor)?$agricultor:NULL);
            $this->agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);

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

        public function set_id_agric($id_agric){
            $id_agric = (isset($id_agric)?$id_agric:NULL);
            $this->id_agric = filter_var($id_agric,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_id_tempo($id_tempo){
            $id_tempo = (isset($id_tempo)?$id_tempo:NULL);
            $this->id_tempo = filter_var($id_tempo,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_id_region($id_region){
            $id_region = (isset($id_region)?$id_region:NULL);
            $this->id_region = filter_var($id_region,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_id_comuna($id_comuna){
            $id_comuna = (isset($id_comuna)?$id_comuna:NULL);
            $this->id_comuna = filter_var($id_comuna,FILTER_SANITIZE_NUMBER_INT);

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
                        $orden = "ORDER BY R.nombre ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY R.nombre DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY C.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY C.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY P.nombre ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY P.nombre DESC";
                    break;
                    default:
                        $orden = "ORDER BY A.razon_social, P.nombre ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT P.id_pred, A.razon_social, R.nombre AS region, C.nombre AS comuna, P.nombre 
                        FROM predio P 
                        INNER JOIN agri_pred_temp APT USING(id_pred) 
                        INNER JOIN agricultor A USING(id_agric) 
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
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->region."%")); }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->comuna."%")); }
                if($this->nombre != ""){ $filtro .= " AND P.nombre LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT COUNT(*) AS Total 
                        FROM predio P 
                        INNER JOIN agri_pred_temp APT USING(id_pred) 
                        INNER JOIN agricultor A USING(id_agric) 
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
                $sql = "SELECT id_agric, id_tempo, id_comuna, id_region, nombre 
                        FROM predio 
                        INNER JOIN agri_pred_temp USING(id_pred) 
                        WHERE id_pred = ?";
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

        public function crearPredio(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();

            $existe = false;

            try{

                $sql = "SELECT * FROM predio INNER JOIN agri_pred_temp USING(id_pred) WHERE id_agric = ? AND id_tempo = ? AND id_region = ? AND id_comuna = ? AND nombre = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_agric, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_region, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->id_comuna, PDO::PARAM_INT);
                $consulta->bindValue("5",$this->nombre, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "INSERT INTO predio (id_region, id_comuna, nombre, user_crea, fecha_crea) VALUES (?, ?, ?, ?, ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_region, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_comuna, PDO::PARAM_INT);
                    $consulta->bindValue("3",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("4",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("5",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->execute();

                    if($consulta->rowCount() <= 0){
                        $rollback = true;

                    }

                    $sql = "INSERT INTO agri_pred_temp (id_agric, id_pred, id_tempo) VALUES (?, (SELECT MAX(id_pred) FROM predio WHERE id_region = ? AND id_comuna = ? AND nombre = ?), ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_agric, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_region, PDO::PARAM_INT);
                    $consulta->bindValue("3",$this->id_comuna, PDO::PARAM_INT);
                    $consulta->bindValue("4",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("5",$this->id_tempo, PDO::PARAM_INT);
                    $consulta->execute();
                    
                    if($consulta->rowCount() <= 0){
                        $rollback = true;

                    }

                }else{
                    $rollback = true;
                    $existe = true;

                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[CREAR PREDIO] -> ha ocurrido un error ".$e->getMessage();

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

        public function editarPredio(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();

            $existe = false;

            try{
                $sql = "SELECT * FROM predio INNER JOIN agri_pred_temp USING(id_pred) WHERE id_agric = ? AND id_tempo = ? AND id_region = ? AND id_comuna = ? AND nombre = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_agric, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_region, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->id_comuna, PDO::PARAM_INT);
                $consulta->bindValue("5",$this->nombre, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0){

                    $sql = "UPDATE predio SET id_region = ?, id_comuna = ?, nombre = ?, user_mod = ?, fecha_mod = ? WHERE id_pred = ?";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_region, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_comuna, PDO::PARAM_INT);
                    $consulta->bindValue("3",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("4",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("5",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("6",$this->id, PDO::PARAM_INT);
                    $consulta->execute();

                    $predio = false;
                    if($consulta->rowCount() <= 0){
                        $predio = true;

                    }

                    $sql = "UPDATE agri_pred_temp SET id_agric = ?, id_tempo = ? WHERE id_pred = ?";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_agric, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                    $consulta->bindValue("3",$this->id, PDO::PARAM_INT);
                    $consulta->execute();

                    $agri_pred = false;
                    if($consulta->rowCount() <= 0){
                        $agri_pred = true;

                    }

                    if($predio && $agri_pred){
                        $rollback = true;

                    }
                    
                }else{
                    $rollback = true;
                    $existe = true;

                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[EDITAR PREDIO] -> ha ocurrido un error ".$e->getMessage();

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

        public function traerRegiones(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT * FROM region";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER REGIONES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerComunas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT C.id_comuna, C.nombre FROM comuna C INNER JOIN provincia P ON C.id_provincia = P.id_provincia WHERE P.id_region = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_region, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER COMUNAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
    
    }
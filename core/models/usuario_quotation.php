<?php
    require_once '../../db/conectarse_db.php';

    class Asignaciones{
        
        /* IDS */
        private $id_usuario, $id_det_quo;

        /* FILTROS */
        private $user, $rut, $nombre;

        /* UTILIDAD */
        private $id, $desde, $orden;

        private $data;
        
        /* IDS */
        public function set_id_usuario($id_usuario){
            $id_usuario = (isset($id_usuario)?$id_usuario:NULL);
            $this->id_usuario = filter_var($id_usuario,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_id_det_quo($id_det_quo){
            $id_det_quo = (isset($id_det_quo)?$id_det_quo:NULL);
            $this->id_det_quo = filter_var($id_det_quo,FILTER_SANITIZE_NUMBER_INT);

        }

        /* FILTROS */
        public function set_user($user){
            $user = (isset($user)?$user:NULL);
            $this->user = filter_var($user,FILTER_SANITIZE_STRING);

        }
        
        public function set_rut($rut){
            $rut = (isset($rut)?$rut:NULL);
            $this->rut = filter_var($rut,FILTER_SANITIZE_STRING);

        }
        
        public function set_nombre($nombre){
            $nombre = (isset($nombre)?$nombre:NULL);
            $this->nombre = filter_var($nombre,FILTER_SANITIZE_STRING);

        }
        
        /* UTILIDAD */
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

        /* FUNCIONES */
        public function traerDatos(){
            try{

                /********/
                /* BIND */
                /********/

                $bind = array();

                /**********/
                /* Filtro */
                /**********/

                $filtro = " WHERE UTU.id_tu = 1";
                if($this->user != ""){ $filtro .= " AND U.user LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->user."%")); }
                if($this->rut != ""){ $filtro .= " AND U.rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut."%")); }
                if($this->nombre != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%"));}

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY U.user ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY U.user DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY U.rut ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY U.rut DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY U.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY U.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY cantidad ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY cantidad DESC";
                    break;
                    default:
                        $orden = "ORDER BY U.nombre ASC";
                    break;

                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT U.id_usuario, U.user, U.rut, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre, COUNT(UDQ.id_usuario_det_quo) AS cantidad 
                        FROM usuarios U 
                        INNER JOIN usuario_det_quo UDQ ON UDQ.id_usuario = U.id_usuario 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro GROUP BY UDQ.id_usuario $orden LIMIT $this->desde,10";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $posicion = 0;
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

                $filtro = " WHERE UTU.id_tu = 1";
                if($this->user != ""){ $filtro .= " AND U.user LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->user."%")); }
                if($this->rut != ""){ $filtro .= " AND U.rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut."%")); }
                if($this->nombre != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%"));}

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT COUNT(UDQ.id_usuario_det_quo) AS cantidad 
                        FROM usuarios U 
                        INNER JOIN usuario_det_quo UDQ ON UDQ.id_usuario = U.id_usuario 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro GROUP BY UDQ.id_usuario";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                $posicion = 0;
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
                $sql = "SELECT UDQ.id_usuario_det_quo, Q.numero_contrato, DQ.id_de_quo FROM usuario_det_quo UDQ INNER JOIN detalle_quotation DQ USING(id_de_quo) INNER JOIN quotation Q USING(id_quotation) WHERE UDQ.id_usuario = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearAsignacion(){

            /* Conexion */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            /* Rollback */
            $rollback = false;
            $conexion->beginTransaction();

            /* Existe */
            $encontro = false;

            /* Respuesta */
            $respuesta = "";

            try{

                $sql = "SELECT * FROM usuario_det_quo WHERE id_usuario = ? AND id_de_quo = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_usuario, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_det_quo, PDO::PARAM_INT);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "INSERT INTO usuario_det_quo (id_usuario, id_de_quo) VALUES (?, ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_usuario, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_det_quo, PDO::PARAM_INT);
                    $consulta->execute();


                    if($consulta->rowCount() > 0){
                        $rollback = false;
    
                    }else{
                        $rollback = true;
    
                    }

                }else{
                    $rollback = false;
                    $encontro = true;

                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[CREAR ASIGNACION] -> ha ocurrido un error ".$e->getMessage();

            }
                
            if($rollback){
                $conexion->rollback();
                $respuesta = "3";
                
            }else{
                $conexion->commit();
                $respuesta = ($encontro)?"2":"1";

            }
        
            $consulta = NULL;
            $conexion = NULL;
            
            return $respuesta;

        }
        
        public function traerDetalles(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT Q.numero_contrato, DQ.id_de_quo FROM usuarios U INNER JOIN quotation Q ON Q.id_cli = U.enlazado INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation WHERE U.id_usuario = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DETALLES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function eliminarAsignacion(){

            /* Conexion */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            /* Rollback */
            $rollback = false;
            $conexion->beginTransaction();

            try{
                $sql = "DELETE FROM usuario_det_quo WHERE id_usuario_det_quo = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                if($consulta->rowCount() > 0){
                    $rollback = false;

                }else{
                    $rollback = true;

                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[ELIMINAR ASIGNACION] -> ha ocurrido un error ".$e->getMessage();

            }
                
            if($rollback){
                $conexion->rollback();
                $respuesta = "2";
                
            }else{
                $conexion->commit();
                $respuesta = "1";

            }
        
            $consulta = NULL;
            $conexion = NULL;
            
            return $respuesta;
        }
    
    }
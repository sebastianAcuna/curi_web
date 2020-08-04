<?php
    require_once '../../db/conectarse_db.php';

    class Asignaciones{
        
        private $id_usuario, $id_ac;

        private $user, $rut, $nombre;

        private $id, $desde, $orden;

        private $data;
        
        public function set_id_usuario($id_usuario){
            $id_usuario = (isset($id_usuario)?$id_usuario:NULL);
            $this->id_usuario = filter_var($id_usuario,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_id_ac($id_ac){
            $id_ac = (isset($id_ac)?$id_ac:NULL);
            $this->id_ac = filter_var($id_ac,FILTER_SANITIZE_STRING);

        }

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
                /**********/
                /* Filtro */
                /**********/

                $filtro = " WHERE UTU.id_tu = 3";
                if($this->user != "" && !is_null($this->user)){ $filtro .= " AND U.user LIKE '%$this->user%'"; }
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND U.rut LIKE '%$this->rut%'"; }
                if($this->nombre != ""){ $filtro .= " AND (nombre LIKE '%$this->nombre%'  OR apellido_p LIKE '%$this->nombre%'  OR apellido_m LIKE '%$this->nombre%')"; }

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
                $sql = "SELECT U.id_usuario, U.user, U.rut, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre, COUNT(UA.id_ac) AS cantidad 
                        FROM usuarios U 
                        INNER JOIN usuario_anexo UA ON UA.id_usuario = U.id_usuario 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro GROUP BY UA.id_usuario $orden LIMIT $this->desde,10";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
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
                /**********/
                /* Filtro */
                /**********/

                $filtro = " WHERE UTU.id_tu = 3";
                if($this->user != "" && !is_null($this->user)){ $filtro .= " AND U.user LIKE '%$this->user%'"; }
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND U.rut LIKE '%$this->rut%'"; }
                if($this->nombre != "" && !is_null($this->nombre)){ $filtro .= " AND U.nombre LIKE '%$this->nombre%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT COUNT(UA.id_ac) AS cantidad 
                        FROM usuarios U 
                        INNER JOIN usuario_anexo UA ON UA.id_usuario = U.id_usuario 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro GROUP BY UA.id_usuario";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
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
                $sql = "SELECT UA.id_ua, AC.num_anexo FROM usuario_anexo UA INNER JOIN anexo_contrato AC ON AC.id_ac = UA.id_ac WHERE UA.id_usuario = ?";
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
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $sql = "SELECT * FROM usuario_anexo WHERE id_usuario = ? AND id_ac = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_usuario, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_ac, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "INSERT INTO usuario_anexo (id_usuario, id_ac) VALUES (?, ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->id_usuario, PDO::PARAM_INT);
                    $consulta->bindValue("2",$this->id_ac, PDO::PARAM_STR);
                    $consulta->execute();

                    $sql = "SELECT * FROM usuario_anexo WHERE id_usuario = ? AND id_ac = ?";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$this->id_usuario, PDO::PARAM_INT);
                    $consulta1->bindValue("2",$this->id_ac, PDO::PARAM_STR);
                    $consulta1->execute();

                    if($consulta->rowCount() > 0 && $consulta->rowCount() == $consulta1->rowCount()){
                        $respuesta = "1";
    
                    }else{
                        $respuesta = "3";

                    }

                }else{
                    $respuesta = "2";

                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[CREAR ASIGNACION] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;

        }

        public function eliminarAsignacion(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $sql = "DELETE FROM usuario_anexo WHERE id_ua = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                $sql = "SELECT * FROM usuario_anexo WHERE id_ua = ?";
                $consulta1 = $conexion->prepare($sql);
                $consulta1->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta1->execute();

                if($consulta->rowCount() > 0 && $consulta1->rowCount() == 0){
                    $respuesta = "1";

                }else{
                    $respuesta = "2";

                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[ELIMINAR ASIGNACION] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;
        }
    
    }
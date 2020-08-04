<?php
    require_once '../../db/conectarse_db.php';

    class General{

        private $password, $telefono, $pais, $region, $provincia, $comuna, $direccion;

        private $id;

        private $data;

        public function set_password($password){
            $password = (isset($password)?$password:NULL);
            $password = filter_var($password,FILTER_SANITIZE_STRING);
            $this->password = ($password != NULL)?md5($password):"";

        }

        public function set_telefono($telefono){
            $telefono = (isset($telefono)?$telefono:NULL);
            $this->telefono = filter_var($telefono,FILTER_SANITIZE_STRING);

        }

        public function set_pais($pais){
            $pais = (isset($pais)?$pais:NULL);
            $this->pais = filter_var($pais,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_region($region){
            $region = (isset($region)?$region:NULL);
            $this->region = filter_var($region,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_provincia($provincia){
            $provincia = (isset($provincia)?$provincia:NULL);
            $this->provincia = filter_var($provincia,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_comuna($comuna){
            $comuna = (isset($comuna)?$comuna:NULL);
            $this->comuna = filter_var($comuna,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_direccion($direccion){
            $direccion = (isset($direccion)?$direccion:NULL);
            $this->direccion = filter_var($direccion,FILTER_SANITIZE_STRING);

        }
        
        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_data($data) {
            $this->data = $data;

        }
    
        public function data() {
            return $this->data;
        }

        public function traerInfo(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT email, user, rut, nombre, apellido_p, apellido_m, telefono, id_pais, id_region, id_provincia, id_comuna, direccion FROM usuarios U WHERE U.id_usuario = ?";
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

        public function ediPerfil(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();
            $respuesta = "2";

            try{

                $sql = "UPDATE usuarios SET telefono = ?, id_pais = ?, id_region = ?, id_provincia = ?, id_comuna = ?, direccion = ?, user_mod = ?, fecha_mod = ?";
                
                if($this->password != ""){
                    $sql .= ", pass = ? ";

                }

                $sql .= " WHERE id_usuario = ?";
                
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->telefono, PDO::PARAM_STR);
                $consulta->bindValue("2",$this->pais, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->region, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->provincia, PDO::PARAM_INT);
                $consulta->bindValue("5",$this->comuna, PDO::PARAM_INT);
                $consulta->bindValue("6",$this->direccion, PDO::PARAM_STR);
                $consulta->bindValue("7",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                $consulta->bindValue("8",date("Y-m-d H:i:s"), PDO::PARAM_STR);

                if($this->password != ""){
                    $consulta->bindValue("9",$this->password, PDO::PARAM_STR);
                    $consulta->bindValue("10",$this->id, PDO::PARAM_INT);

                }else{
                    $consulta->bindValue("9",$this->id, PDO::PARAM_INT);

                }

                $consulta->execute();

                if($consulta->rowCount() > 0 ){
                    $respuesta = "1";

                }else{
                    $rollback = true;

                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[EDITAR PERFIL] -> ha ocurrido un error ".$e->getMessage();

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

        public function traerRegiones(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_region, nombre FROM region WHERE id_pais = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
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
                $sql = "SELECT id_comuna, nombre FROM comuna WHERE id_provincia = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
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

        public function traerProvincias(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_provincia, nombre FROM provincia WHERE id_region = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER PROVINCIAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
    
    }
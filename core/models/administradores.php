<?php
    require_once '../../db/conectarse_db.php';

    class Administradores{

        private $user, $rut, $nombre, $email, $password, $apellido_p, $apellido_m, $telefono, $pais, $region, $provincia, $comuna, $direccion;

        private $id, $desde, $orden;

        private $data;

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
        
        public function set_email($email){
            $email = (isset($email)?$email:NULL);
            $this->email = filter_var($email,FILTER_SANITIZE_EMAIL);

        }

        public function set_password($password){
            $password = (isset($password)?$password:NULL);
            $password = filter_var($password,FILTER_SANITIZE_STRING);
            $this->password = ($password != NULL)?md5($password):"";
            
        }

        public function set_apellido_p($apellido_p){
            $apellido_p = (isset($apellido_p)?$apellido_p:NULL);
            $this->apellido_p = filter_var($apellido_p,FILTER_SANITIZE_STRING);

        }

        public function set_apellido_m($apellido_m){
            $apellido_m = (isset($apellido_m)?$apellido_m:NULL);
            $this->apellido_m = filter_var($apellido_m,FILTER_SANITIZE_STRING);

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

                $filtro = " WHERE UTU.id_tu = 5";
                if($this->user != ""){ $filtro .= " AND user LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->user."%")); }
                if($this->rut != ""){ $filtro .= " AND rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut."%")); }
                if($this->nombre != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%"));}
                if($this->email != ""){ $filtro .= " AND email LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->email."%")); }

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
                        $orden = "ORDER BY U.email ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY U.email DESC";
                    break;
                    default:
                        $orden = "ORDER BY U.user ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT U.id_usuario, U.user, U.rut, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre, U.email 
                        FROM usuarios U 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro 
                        $orden 
                        LIMIT $this->desde,10";
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

                $filtro = " WHERE UTU.id_tu = 5";
                if($this->user != ""){ $filtro .= " AND user LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->user."%")); }
                if($this->rut != ""){ $filtro .= " AND rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut."%")); }
                if($this->nombre != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->nombre."%"));}
                if($this->email != ""){ $filtro .= " AND email LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->email."%")); }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total 
                        FROM usuarios U 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro ";
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
                $sql = "SELECT U.email, U.user, U.rut, U.nombre, U.apellido_p, U.apellido_m, U.telefono, U.id_pais, U.id_region, U.id_comuna, U.direccion, U.id_provincia FROM usuarios U 
                INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE U.id_usuario = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $mod = 0;
                    if($_SESSION["IDuser_curimapu"] == $this->id){
                        $mod = 1;

                    }

                    $this->set_data(array($consulta->fetch(PDO::FETCH_ASSOC),"per" => $mod));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearAdministrador(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $sql = "SELECT * FROM usuarios WHERE rut = ? OR email = ? OR user = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->rut, PDO::PARAM_STR);
                $consulta->bindValue("2",$this->email, PDO::PARAM_STR);
                $consulta->bindValue("3",$this->user, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "INSERT INTO usuarios (rut, email, user, pass, nombre, apellido_p, apellido_m, telefono, id_region, id_pais, id_comuna, direccion, user_crea, fecha_crea, id_provincia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->rut, PDO::PARAM_STR);
                    $consulta->bindValue("2",$this->email, PDO::PARAM_STR);
                    $consulta->bindValue("3",$this->user, PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->password, PDO::PARAM_STR);
                    $consulta->bindValue("5",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("6",$this->apellido_p, PDO::PARAM_STR);
                    $consulta->bindValue("7",$this->apellido_m, PDO::PARAM_STR);
                    $consulta->bindValue("8",$this->telefono, PDO::PARAM_STR);
                    $consulta->bindValue("9",$this->region, PDO::PARAM_STR);
                    $consulta->bindValue("10",$this->pais, PDO::PARAM_STR);
                    $consulta->bindValue("11",$this->comuna, PDO::PARAM_STR);
                    $consulta->bindValue("12",$this->direccion, PDO::PARAM_STR);
                    $consulta->bindValue("13",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("14",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("15",$this->provincia, PDO::PARAM_STR);
                    $consulta->execute();

                    $sql = "SELECT * FROM usuarios WHERE rut = ? AND email = ? AND user = ? AND pass = ? AND nombre = ? AND apellido_p = ? AND apellido_m = ? AND telefono = ? AND id_region = ? AND id_pais = ? AND id_comuna = ? AND direccion = ? AND id_provincia = ? ";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$this->rut, PDO::PARAM_STR);
                    $consulta1->bindValue("2",$this->email, PDO::PARAM_STR);
                    $consulta1->bindValue("3",$this->user, PDO::PARAM_STR);
                    $consulta1->bindValue("4",$this->password, PDO::PARAM_STR);
                    $consulta1->bindValue("5",$this->nombre, PDO::PARAM_STR);
                    $consulta1->bindValue("6",$this->apellido_p, PDO::PARAM_STR);
                    $consulta1->bindValue("7",$this->apellido_m, PDO::PARAM_STR);
                    $consulta1->bindValue("8",$this->telefono, PDO::PARAM_STR);
                    $consulta1->bindValue("9",$this->region, PDO::PARAM_STR);
                    $consulta1->bindValue("10",$this->pais, PDO::PARAM_STR);
                    $consulta1->bindValue("11",$this->comuna, PDO::PARAM_STR);
                    $consulta1->bindValue("12",$this->direccion, PDO::PARAM_STR);
                    $consulta1->bindValue("13",$this->provincia, PDO::PARAM_STR);
                    $consulta1->execute();

                    if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){
                        $resultado = $consulta1->fetch(PDO::FETCH_ASSOC);

                        $sql = "SELECT * FROM usuario_tipo_usuario WHERE id_usuario = ?";
                        $consulta2 = $conexion->prepare($sql);
                        $consulta2->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                        $consulta2->execute();
                        if($consulta2->rowCount() > 0 ){
                            $sql = "DELETE FROM usuario_tipo_usuario WHERE id_usuario = ?";
                            $consulta3 = $conexion->prepare($sql);
                            $consulta3->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                            $consulta3->execute();

                        }

                        $sql = "INSERT INTO usuario_tipo_usuario (id_usuario, id_tu) VALUES (?, '5')";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$resultado["id_usuario"], PDO::PARAM_STR);
                        $consulta->execute();
                        
                        $sql = "SELECT * FROM usuario_tipo_usuario WHERE id_usuario = ?";
                        $consulta1 = $conexion->prepare($sql);
                        $consulta1->bindValue("1",$resultado["id_usuario"], PDO::PARAM_STR);
                        $consulta1->execute();

                        if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){
                            $respuesta = "1";
                        }else{
                            $sql = "DELETE FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE rut = ? AND email = ? AND user = ?)";
                            $consulta = $conexion->prepare($sql);
                            $consulta->bindValue("1",$this->rut, PDO::PARAM_STR);
                            $consulta->bindValue("2",$this->email, PDO::PARAM_STR);
                            $consulta->bindValue("3",$this->user, PDO::PARAM_STR);
                            $consulta->execute();
                            if ($consulta->rowCount() > 0) {
                                $respuesta = "3";
                            }else{
                                $respuesta = "4";
                            }
                        }
    
                    }else{
                        $sql = "DELETE FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE rut = ? AND email = ? AND user = ?)";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$this->rut, PDO::PARAM_STR);
                        $consulta->bindValue("2",$this->email, PDO::PARAM_STR);
                        $consulta->bindValue("3",$this->user, PDO::PARAM_STR);
                        $consulta->execute();
                        if ($consulta->rowCount() > 0) {
                            $respuesta = "3";
                        }else{
                            $respuesta = "4";
                        }
                    }

                }else{
                    $respuesta = "2";
                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[CREAR ADMINISTRADOR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $consulta2 = NULL;
            $consulta3 = NULL;
            $conexion = NULL;

        }

        public function editarAdministrador(){
            try{
                
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $sql = "SELECT * FROM usuarios WHERE id_usuario != ? AND (rut = ? OR email = ? OR user = ?)";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->rut, PDO::PARAM_STR);
                $consulta->bindValue("3",$this->email, PDO::PARAM_STR);
                $consulta->bindValue("4",$this->user, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "UPDATE usuarios SET rut = ?, email = ?, user = ?, nombre = ?, apellido_p = ?, apellido_m = ?, telefono = ?, id_pais = ?, id_region = ?, id_comuna = ?, direccion = ?, user_mod = ?, fecha_mod = ? , id_provincia = ? ";

                    if(($_SESSION["mod_pass_curimapu"] == "1" || $_SESSION["IDuser_curimapu"] == $this->id) && $this->password != ""){
                        $sql .= ",pass = ? ";

                    }

                    $sql .= "WHERE id_usuario = ?";

                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1",$this->rut, PDO::PARAM_STR);
                    $consulta->bindValue("2",$this->email, PDO::PARAM_STR);
                    $consulta->bindValue("3",$this->user, PDO::PARAM_STR);
                    $consulta->bindValue("4",$this->nombre, PDO::PARAM_STR);
                    $consulta->bindValue("5",$this->apellido_p, PDO::PARAM_STR);
                    $consulta->bindValue("6",$this->apellido_m, PDO::PARAM_STR);
                    $consulta->bindValue("7",$this->telefono, PDO::PARAM_STR);
                    $consulta->bindValue("8",$this->pais, PDO::PARAM_STR);
                    $consulta->bindValue("9",$this->region, PDO::PARAM_STR);
                    $consulta->bindValue("10",$this->comuna, PDO::PARAM_STR);
                    $consulta->bindValue("11",$this->direccion, PDO::PARAM_STR);
                    $consulta->bindValue("12",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("13",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("14",$this->provincia, PDO::PARAM_STR);

                    if(($_SESSION["mod_pass_curimapu"] == "1" || $_SESSION["IDuser_curimapu"] == $this->id) && $this->password != ""){
                        $consulta->bindValue("15",$this->password, PDO::PARAM_STR);
                        $consulta->bindValue("16",$this->id, PDO::PARAM_INT);

                    }else{
                        $consulta->bindValue("15",$this->id, PDO::PARAM_INT);

                    }

                    $consulta->execute();

                    $sql = "SELECT * FROM usuarios WHERE rut = ? AND email = ? AND user = ? AND nombre = ? AND apellido_p = ? AND apellido_m = ? AND telefono = ? AND id_pais = ? AND id_region = ? AND id_comuna = ? AND direccion = ? AND id_usuario = ? AND id_provincia = ?";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$this->rut, PDO::PARAM_STR);
                    $consulta1->bindValue("2",$this->email, PDO::PARAM_STR);
                    $consulta1->bindValue("3",$this->user, PDO::PARAM_STR);
                    $consulta1->bindValue("4",$this->nombre, PDO::PARAM_STR);
                    $consulta1->bindValue("5",$this->apellido_p, PDO::PARAM_STR);
                    $consulta1->bindValue("6",$this->apellido_m, PDO::PARAM_STR);
                    $consulta1->bindValue("7",$this->telefono, PDO::PARAM_STR);
                    $consulta1->bindValue("8",$this->pais, PDO::PARAM_STR);
                    $consulta1->bindValue("9",$this->region, PDO::PARAM_STR);
                    $consulta1->bindValue("10",$this->comuna, PDO::PARAM_STR);
                    $consulta1->bindValue("11",$this->direccion, PDO::PARAM_STR);
                    $consulta1->bindValue("12",$this->id, PDO::PARAM_INT);
                    $consulta1->bindValue("13",$this->provincia, PDO::PARAM_INT);
                    $consulta1->execute();

                    if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){
                        $respuesta = "1";
    
                    }else{
                        $respuesta = "3";

                    }

                }else{
                    $respuesta = "2";

                }

                return $respuesta;

            }catch(PDOException $e){
                echo "[EDITAR ADMINISTRADOR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;

        }

        public function traerComunas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT C.id_comuna, C.nombre FROM comuna C  WHERE id_provincia = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_STR);
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
                $sql = "SELECT P.id_provincia, P.nombre FROM provincia P  WHERE P.id_region = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_STR);
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

        public function traerRegiones(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_region, nombre FROM region WHERE id_pais = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_STR);
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
    
    }
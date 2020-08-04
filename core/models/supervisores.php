<?php
    require_once '../../db/conectarse_db.php';

    class Supervisores{

        private $user, $rut, $nombre, $email, $password, $apellido_p, $apellido_m, $telefono, $pais, $region, $comuna, $direccion, $supervisar, $supervisados, $provincia;

        private $id, $idSTR, $desde, $orden;

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
            $this->telefono = filter_var($telefono,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_pais($pais){
            $pais = (isset($pais)?$pais:NULL);
            $this->pais = filter_var($pais,FILTER_SANITIZE_STRING);

        }

        public function set_region($region){
            $region = (isset($region)?$region:NULL);
            $this->region = filter_var($region,FILTER_SANITIZE_STRING);

        }

        public function set_provincia($provincia){
            $provincia = (isset($provincia)?$provincia:NULL);
            $this->provincia = filter_var($provincia,FILTER_SANITIZE_STRING);

        }

        public function set_comuna($comuna){
            $comuna = (isset($comuna)?$comuna:NULL);
            $this->comuna = filter_var($comuna,FILTER_SANITIZE_STRING);

        }

        public function set_direccion($direccion){
            $direccion = (isset($direccion)?$direccion:NULL);
            $this->direccion = filter_var($direccion,FILTER_SANITIZE_STRING);

        }

        public function set_supervisar($supervisar){
            $supervisar = (isset($supervisar)?$supervisar:NULL);
            $supervisar = filter_var($supervisar,FILTER_SANITIZE_NUMBER_INT);

            if($supervisar == 1){
                $this->supervisar = "SI";

            }else if($supervisar == 2){
                $this->supervisar = "NO";

            }else{
                $this->supervisar = "";
                
            }

        }

        public function set_supervisados($supervisados){
            $supervisados = (isset($supervisados)?$supervisados:NULL);
            $this->supervisados = filter_var($supervisados,FILTER_SANITIZE_STRING);

        }
        
        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_idSTR($idSTR){
            $idSTR = (isset($idSTR)?$idSTR:NULL);
            $this->idSTR = filter_var($idSTR,FILTER_SANITIZE_STRING);

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
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut LIKE '%$this->rut%'"; }
                if($this->nombre != "" && !is_null($this->nombre)){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE '%$this->nombre%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY U.rut ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY U.rut DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY U.nombre ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY U.nombre DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY U.telefono ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY U.telefono DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY U.email ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY U.email DESC";
                    break;
                    default:
                        $orden = "ORDER BY U.nombre ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT U.id_usuario, U.rut, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre, U.telefono, U.email 
                        FROM usuarios U 
                        INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario 
                        $filtro 
                        $orden 
                        LIMIT $this->desde,10";
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
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut LIKE '%$this->rut%'"; }
                if($this->nombre != "" && !is_null($this->nombre)){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE '%$this->nombre%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario $filtro";
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

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT U.email, U.user, U.rut, U.nombre, U.apellido_p, U.apellido_m, U.telefono, U.id_pais, U.id_region, U.id_comuna, U.direccion, U.supervisa_otro , U.id_provincia FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE U.id_usuario = ?";
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

        public function traerSupervisados(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }else{
                    $this->set_data(null);

                }
        
            }catch(PDOException $e){
                echo "[TRAER SUPERVISADOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearSupervisor(){
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

                    $sql = "INSERT INTO usuarios (rut, email, user, pass, nombre, apellido_p, apellido_m, telefono, id_region, id_pais, id_comuna, direccion, supervisa_otro, user_crea, fecha_crea, id_provincia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
                    $consulta->bindValue("13",$this->supervisar, PDO::PARAM_STR);
                    $consulta->bindValue("14",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("15",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("16",$this->provincia, PDO::PARAM_STR);
                    $consulta->execute();

                    $sql = "SELECT * FROM usuarios WHERE rut = ? AND email = ? AND user = ? AND pass = ? AND nombre = ? AND apellido_p = ? AND apellido_m = ? AND telefono = ? AND id_region = ? AND id_pais = ? AND id_comuna = ? AND direccion = ? AND supervisa_otro = ? AND id_provincia = ?";
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
                    $consulta1->bindValue("13",$this->supervisar, PDO::PARAM_STR);
                    $consulta1->bindValue("14",$this->provincia, PDO::PARAM_STR);
                    $consulta1->execute();

                    $resultado = $consulta1->fetch(PDO::FETCH_ASSOC);

                    if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){

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

                        $sql = "INSERT INTO usuario_tipo_usuario (id_usuario, id_tu) VALUES (?, '3')";
                        $consulta2 = $conexion->prepare($sql);
                        $consulta2->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                        $consulta2->execute();

                        $sql = "SELECT * FROM usuario_tipo_usuario WHERE id_usuario = ? AND id_tu = '3'";
                        $consulta3 = $conexion->prepare($sql);
                        $consulta3->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                        $consulta3->execute();

                        if($consulta2->rowCount() > 0 && $consulta2->rowCount() == $consulta3->rowCount()){
                            $res = 1;
                        }else{
                            $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
                            $consulta3 = $conexion->prepare($sql);
                            $consulta3->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                            $consulta3->execute();
                            if ($consulta3->rowCount() > 0) {
                                $res = 3;
                            }else{
                                $res = 4;
                            }
                        }
    
                    }

                    if($res == 1){
                        $sup = explode(",",$this->supervisados);
                        $cont = 0;
                        if($this->supervisar == "SI"){
                            $sql = "SELECT * FROM supervisores WHERE id_sup_us = ?";
                            $consulta2 = $conexion->prepare($sql);
                            $consulta2->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                            $consulta2->execute();
                            if($consulta2->rowCount() > 0 ){
                                $sql = "DELETE FROM supervisores WHERE id_sup_us = ?";
                                $consulta3 = $conexion->prepare($sql);
                                $consulta3->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                                $consulta3->execute();
    
                            }

                            /* Asignar supervisores */
                            for($i = 0; $i < (COUNT($sup)-1); $i++){
                                $sql = "INSERT INTO supervisores (id_sup_us, id_us_sup) VALUES (?, ?)";
                                $consulta2 = $conexion->prepare($sql);
                                $consulta2->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                                $consulta2->bindValue("2",$sup[$i], PDO::PARAM_INT);
                                $consulta2->execute();

                                if($consulta2->rowCount() > 0){
                                    $cont++;
            
                                }

                            }
                            
                            $verificar = 0;
                            for($i = 0; $i < 2; $i++){
                                $sql = "SELECT * FROM supervisores WHERE id_sup_us = ? AND id_us_sup = ?";
                                $consulta2 = $conexion->prepare($sql);
                                $consulta2->bindValue("1",$resultado["id_usuario"], PDO::PARAM_INT);
                                $consulta2->bindValue("2",$sup[$i], PDO::PARAM_INT);
                                $consulta2->execute();
                                
                                if($consulta2->rowCount() > 0 ){
                                    $verificar++;
            
                                }
    
                            }

                            if($verificar != $cont){
                                $sql = "DELETE FROM supervisores WHERE id_sup_us = ?";
                                $consulta3 = $conexion->prepare($sql);
                                $consulta3->bindValue("1",$resultado["id_usuario"], PDO::PARAM_STR);
                                $consulta3->execute();
                                if ($consulta3->rowCount() > 0) {
                                    $cont = 0;

                                }

                            }
    
                        }

                    }

                    if($consulta->rowCount() > 0 && $res == 1 && $consulta->rowCount() == $consulta1->rowCount()){
                        if((COUNT($sup)-1) != $cont){
                            $respuesta = "11";

                        }else{
                            $respuesta = "1";

                        }

                    }else{
                        $respuesta = $res;

                    }

                }else{
                    $respuesta = "2";

                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[CREAR SUPERVISOR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $consulta2 = NULL;
            $consulta3 = NULL;
            $conexion = NULL;

        }

        public function editarSupervisor(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $conexion->beginTransaction();

                $sql = "SELECT * FROM usuarios WHERE id_usuario != ? AND (rut = ? OR email = ? OR user = ?)";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->rut, PDO::PARAM_STR);
                $consulta->bindValue("3",$this->email, PDO::PARAM_STR);
                $consulta->bindValue("4",$this->user, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() == 0 ){

                    $sql = "UPDATE usuarios SET rut = ?, email = ?, user = ?, nombre = ?, apellido_p = ?, apellido_m = ?, telefono = ?, id_pais = ?, id_region = ?, id_comuna = ?, direccion = ?, supervisa_otro = ?, user_mod = ?, fecha_mod = ?, id_provincia = ? ";
                    
                    if($_SESSION["mod_pass_curimapu"] == "1" && $this->password != ""){
                        $sql .= " , pass = ? ";

                    }

                    $sql .= " WHERE id_usuario = ?";
                    
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
                    $consulta->bindValue("12",$this->supervisar, PDO::PARAM_STR);
                    $consulta->bindValue("13",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("14",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                    $consulta->bindValue("15",$this->provincia, PDO::PARAM_STR);

                    if($_SESSION["mod_pass_curimapu"] == "1" && $this->password != ""){
                        $consulta->bindValue("16",$this->password, PDO::PARAM_STR);
                        $consulta->bindValue("17",$this->id, PDO::PARAM_INT);

                    }else{
                        $consulta->bindValue("16",$this->id, PDO::PARAM_INT);

                    }

                    $consulta->execute();

                    $sup = explode(",",$this->supervisados);
                    $cont = 0;
                    $contS = 0;
                    if($this->supervisar == "SI"){
                        for($i = 0; $i < (COUNT($sup)-1); $i++){
                            $sql = "SELECT * FROM supervisores WHERE id_sup_us = ? AND id_us_sup = ?";
                            $consulta2 = $conexion->prepare($sql);
                            $consulta2->bindValue("1",$this->id, PDO::PARAM_INT);
                            $consulta2->bindValue("2",$sup[$i], PDO::PARAM_INT);
                            $consulta2->execute();
                            
                            if($consulta2->rowCount() > 0 ){
                                $contS++;
        
                            }
                        }

                        if($contS != (COUNT($sup)-1)){
                            /* Asignar supervisores */
                            $sql = "DELETE FROM supervisores WHERE id_sup_us = ?";
                            $consulta3 = $conexion->prepare($sql);
                            $consulta3->bindValue("1",$this->id, PDO::PARAM_INT);
                            $consulta3->execute();
                            for($i = 0; $i < (COUNT($sup)-1); $i++){
                                $sql = "INSERT INTO supervisores (id_sup_us, id_us_sup) VALUES ( ?, ?)";
                                $consulta4 = $conexion->prepare($sql);
                                $consulta4->bindValue("1",$this->id, PDO::PARAM_INT);
                                $consulta4->bindValue("2",$sup[$i], PDO::PARAM_INT);
                                $consulta4->execute();
                                
                                if($consulta4->rowCount() > 0 ){
                                    $cont++;
                                }
                            }
                        }

                    }else{
                        $sql = "DELETE FROM supervisores WHERE id_sup_us = ?";
                        $consulta3 = $conexion->prepare($sql);
                        $consulta3->bindValue("1",$this->id, PDO::PARAM_INT);
                        $consulta3->execute();
                    }

                    if(($consulta->rowCount() > 0 && (COUNT($sup)-1) == $cont)){
                        $respuesta = "1";
                    }else{
                        $rollback = true;
                        $respuesta = "3";
                    }
                    
                }else{
                    $respuesta = "2";
                    $rollback = true;
                }

                if($rollback){
                    $conexion->rollback();
                }else{
                    $conexion->commit();
                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[EDITAR SUPERVISOR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta2 = NULL;
            $consulta3 = NULL;
            $consulta4 = NULL;
            $conexion = NULL;

        }

        public function traerSupervisores(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT U.id_usuario, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE UTU.id_tu = 3 AND U.id_usuario != ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
                }
        
            }catch(PDOException $e){
                echo "[TRAER SUPERVISORES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }


        public function traerComunas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT C.id_comuna, C.nombre FROM comuna C  WHERE id_provincia = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->idSTR, PDO::PARAM_STR);
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
                $consulta->bindValue("1",$this->idSTR, PDO::PARAM_STR);
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
                $consulta->bindValue("1",$this->idSTR, PDO::PARAM_STR);
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
<?php
    require_once '../../db/conectarse_db.php';

    class Clientes{

        private $rut, $razon_social, $telefono, $email;

        private $id, $desde, $orden;

        private $data;
        
        public function set_rut($rut){
            $rut = (isset($rut)?$rut:NULL);
            $this->rut = filter_var($rut,FILTER_SANITIZE_STRING);

        }
        
        public function set_razon_social($razon_social){
            $razon_social = (isset($razon_social)?$razon_social:NULL);
            $this->razon_social = filter_var($razon_social,FILTER_SANITIZE_STRING);

        }

        public function set_telefono($telefono){
            $telefono = (isset($telefono)?$telefono:NULL);
            $this->telefono = filter_var($telefono,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_email($email){
            $email = (isset($email)?$email:NULL);
            $this->email = filter_var($email,FILTER_SANITIZE_EMAIL);

        }
        
        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_STRING);

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

                $filtro = " WHERE id_cli != 0";
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut_cliente LIKE '%$this->rut%'"; }
                if($this->razon_social != "" && !is_null($this->razon_social)){ $filtro .= " AND razon_social LIKE '%$this->razon_social%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY rut_cliente ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY rut_cliente DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY razon_social ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY razon_social DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY telefono ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY telefono DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY email ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY email DESC";
                    break;
                    default:
                        $orden = "ORDER BY rut_cliente ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_cli, rut_cliente, razon_social, telefono, email FROM cliente $filtro $orden LIMIT $this->desde,10";
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

                $filtro = " WHERE id_cli != 0";
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut_cliente LIKE '%$this->rut%'"; }
                if($this->razon_social != "" && !is_null($this->razon_social)){ $filtro .= " AND razon_social LIKE '%$this->razon_social%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

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

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT C.rut_cliente, C.razon_social, C.telefono, C.email, P.nombre, C.ciudad, C.direccion, C.rep_legal, C.rut_rl, C.telefono_rl, C.email_rl FROM cliente C INNER JOIN pais P ON P.id_pais = C.id_pais WHERE id_cli = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_STR);
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
    
    }
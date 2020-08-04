<?php
    require_once '../../db/conectarse_db.php';

    class Agricultores{

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

                $filtro = " WHERE id_agric != 0";
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut LIKE '%$this->rut%'"; }
                if($this->razon_social != "" && !is_null($this->razon_social)){ $filtro .= " AND razon_social LIKE '%$this->razon_social%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY rut ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY rut DESC";
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
                        $orden = "ORDER BY rut ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_agric, rut, razon_social, telefono, email FROM agricultor $filtro $orden LIMIT $this->desde,10";
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

                $filtro = " WHERE id_agric != 0";
                if($this->rut != "" && !is_null($this->rut)){ $filtro .= " AND rut LIKE '%$this->rut%'"; }
                if($this->razon_social != "" && !is_null($this->razon_social)){ $filtro .= " AND razon_social LIKE '%$this->razon_social%'"; }
                if($this->telefono != "" && !is_null($this->telefono)){ $filtro .= " AND telefono LIKE '%$this->telefono%'"; }
                if($this->email != "" && !is_null($this->email)){ $filtro .= " AND email LIKE '%$this->email%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM agricultor $filtro";
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
                $sql = "SELECT rut, razon_social, telefono, email, R.nombre AS region, C.nombre AS comuna, direccion, rep_legal, rut_rl, telefono_rl, email_rl, banco, cuenta_corriente 
                        FROM agricultor A
                        INNER JOIN region R ON R.id_region = A.id_region
                        INNER JOIN comuna C ON C.id_comuna = A.id_comuna
                        WHERE id_agric = ?";
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
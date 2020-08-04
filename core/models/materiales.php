<?php
    require_once '../../db/conectarse_db.php';

    class Materiales{

        private $especie, $nombreF, $nombreH, $hembra, $macho;

        private $desde, $orden;

        private $data;

        public function set_especie($especie){
            $especie = (isset($especie)?$especie:NULL);
            $this->especie = filter_var($especie,FILTER_SANITIZE_STRING);

        }
        
        public function set_nombreF($nombreF){
            $nombreF = (isset($nombreF)?$nombreF:NULL);
            $this->nombreF = filter_var($nombreF,FILTER_SANITIZE_STRING);

        }
        
        public function set_nombreH($nombreH){
            $nombreH = (isset($nombreH)?$nombreH:NULL);
            $this->nombreH = filter_var($nombreH,FILTER_SANITIZE_STRING);

        }
        
        public function set_hembra($hembra){
            $hembra = (isset($hembra)?$hembra:NULL);
            $this->hembra = filter_var($hembra,FILTER_SANITIZE_STRING);

        }

        public function set_macho($macho){
            $macho = (isset($macho)?$macho:NULL);
            $this->macho = filter_var($macho,FILTER_SANITIZE_STRING);

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

                $filtro = " WHERE M.id_materiales != 0";
                if($this->especie != "" && !is_null($this->especie)){ $filtro .= " AND E.nombre LIKE '%$this->especie%'"; }
                if($this->nombreF != "" && !is_null($this->nombreF)){ $filtro .= " AND M.nom_fantasia LIKE '%$this->nombreF%'"; }
                if($this->nombreH != "" && !is_null($this->nombreH)){ $filtro .= " AND M.nom_hibrido LIKE '%$this->nombreH%'"; }
                if($this->hembra != "" && !is_null($this->hembra)){ $filtro .= " AND M.p_hembra LIKE '%$this->hembra%'"; }
                if($this->macho != "" && !is_null($this->macho)){ $filtro .= " AND M.p_macho LIKE '%$this->macho%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY E.nombre, M.nom_fantasia ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY M.nom_fantasia ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY M.nom_fantasia DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY M.nom_hibrido ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY M.nom_hibrido DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY M.p_hembra ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY M.p_hembra DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY M.p_macho ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY M.p_macho DESC";
                    break;
                    default:
                        $orden = "ORDER BY E.nombre, M.nom_fantasia, M.nom_hibrido, M.p_hembra, M.p_macho ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT E.nombre AS especie, M.nom_fantasia, M.nom_hibrido, M.p_hembra, M.p_macho FROM materiales M INNER JOIN especie E ON E.id_esp = M.id_esp $filtro $orden LIMIT $this->desde,10";
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

                $filtro = " WHERE M.id_materiales != 0";
                if($this->especie != "" && !is_null($this->especie)){ $filtro .= " AND E.nombre LIKE '%$this->especie%'"; }
                if($this->nombreF != "" && !is_null($this->nombreF)){ $filtro .= " AND M.nom_fantasia LIKE '%$this->nombreF%'"; }
                if($this->nombreH != "" && !is_null($this->nombreH)){ $filtro .= " AND M.nom_hibrido LIKE '%$this->nombreH%'"; }
                if($this->hembra != "" && !is_null($this->hembra)){ $filtro .= " AND M.p_hembra LIKE '%$this->hembra%'"; }
                if($this->macho != "" && !is_null($this->macho)){ $filtro .= " AND M.p_macho LIKE '%$this->macho%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM materiales M INNER JOIN especie E ON E.id_esp = M.id_esp $filtro";
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

    }
<?php

    require_once '../../db/conectarse_db.php';

    class Tablas{
        
        private $tabla;
        private $columns;
        private $signo;
        private $valores;
        private $cont;
        private $id;

        private $data;
        private $datos;
        
        public function set_tabla($tabla){
            $tabla = (isset($tabla)?$tabla:NULL);
            $this->tabla = filter_var($tabla,FILTER_SANITIZE_STRING);

        }

        public function set_columns($columns){
            $columns = (isset($columns)?$columns:NULL);
            $this->columns = filter_var($columns,FILTER_SANITIZE_STRING);

        }

        public function set_signo($signo){
            $this->signo = $signo;

        }

        public function set_valores($valores){
            $valores = (isset($valores)?$valores:NULL);
            $this->valores = filter_var($valores,FILTER_SANITIZE_STRING);

        }

        public function set_cont($cont){
            $this->cont = $cont;

        }

        public function set_id($id){
            $id = (isset($id)?$id:NULL);
            $this->id = filter_var($id,FILTER_SANITIZE_STRING);

        }

        public function setdata($data) {
            $this->data = $data;

        }
    
        public function data() {
            return $this->data;
        }

        public function setdatos($datos) {
            $this->datos = $datos;

        }
    
        public function datos() {
            return $this->datos;
        }

        public function traerTablas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT * FROM a_tablas ORDER BY nombre ASC";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));
                }
        
            }catch(PDOException $e){
                echo "[TRAER TABLAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerDatos(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT nombre, espannol, ingles, comentariosbd FROM a_campos WHERE id_tabla = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }


        public function traerSoloNombreTabla(){
            try{
                
                $conexion = new Conectar();
                $sql = "SELECT nombre FROM a_tablas WHERE id_tablas = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $res  = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $this->setdata($res[0]["nombre"]);
                }
            }catch(PDOException $e){
                echo "[TRAER NOMBRE TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;
        }
       
        public function traerEstructura(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, IS_NULLABLE, EXTRA, COLUMN_KEY 
                        FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE TABLE_SCHEMA = 'curimapu_tabletas' AND TABLE_NAME = ?";

                        // echo $sql;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ESTRUCTURA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }


        public function traerSoloNombreTablaProduccion(){
            try{
                
                $conexion = new Conectar();
                $sql = "SELECT nombre FROM a_tablas WHERE id_tablas = ?";
                $conexion = $conexion->conexion_produccion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $res  = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $this->setdata($res[0]["nombre"]);
                }
            }catch(PDOException $e){
                echo "[TRAER NOMBRE TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;
        }

        public function traerEstructuraProduccion(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, IS_NULLABLE, EXTRA, COLUMN_KEY 
                        FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE TABLE_SCHEMA = 'curimapu_tabletas' AND TABLE_NAME = ?";

                        // echo $sql;
                $conexion = $conexion->conexion_produccion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ESTRUCTURA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerDatosTb(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT ".$this->columns." FROM ".$this->tabla;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdatos($consulta->fetchAll(PDO::FETCH_NUM));
                }
            }catch(PDOException $e){
                echo "[TRAER DATOS TB] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerRegistro(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT ".$this->columns." FROM ".$this->tabla." WHERE ".$this->valores." = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdatos($consulta->fetchAll(PDO::FETCH_NUM));

                }
        
            }catch(PDOException $e){
                echo "[TRAER REGISTRO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerRelaciones(){
            try{
                $conexion = new Conectar();
                $sql = "SELECT T.id_tablas, T.nombre   FROM a_relaciones R  INNER JOIN a_tablas T ON  T.id_tablas = R.primaria  WHERE R.foranea = (SELECT id_tabla FROM a_tablas WHERE key_1 = ? )";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->columns, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));
                }
        
            }catch(PDOException $e){
                echo "[TRAER RELACIONES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerTotalRegistros(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT COUNT(*) AS Total FROM ".$this->tabla;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdatos($consulta->fetch(PDO::FETCH_ASSOC));
                }
            }catch(PDOException $e){
                echo "[TRAER TOTAL REGISTROS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerTotalCampos(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT COUNT(*) AS Total FROM a_campos WHERE id_tabla = (SELECT id_tablas FROM a_tablas WHERE nombre = ?)";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->tabla, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdatos($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER TOTAL CAMPOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function traerNombreTabla(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT nombre  FROM a_tablas  WHERE key_1 = ? ";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->columns, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetch(PDO::FETCH_ASSOC));

                }else{
                    $this->setdata(null);

                }
        
            }catch(PDOException $e){
                echo "[TRAER NOMBRE TABLA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerAsociaciones(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT P.nombre AS Primaria, F.nombre AS Foranea, P.id_tablas AS ID_P, F.id_tablas AS ID_F FROM a_relaciones R INNER JOIN a_tablas P ON P.id_tablas = R.primaria INNER JOIN a_tablas F ON F.id_tablas = R.foranea WHERE R.primaria = ? OR R.foranea = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ASOCIACIONES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function traerReferencia(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT * FROM ".$this->tabla." WHERE ".$this->columns." = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->valores, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->setdata($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER REFERENCIA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearRegistro(){
            try{
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $Dato = explode("||",$this->valores);
                $cc = explode(",", $this->columns);

                for($i = 0; $i < count($this->cont); $i++){
                    if($i > 0){ $datoABuscar.= " AND ";}
                    $datoABuscar .= " ".$cc[$i]. " = '".$Dato[$i]."' ";

                }

                $sql = "SELECT * FROM  ".$this->tabla." WHERE ".$datoABuscar;
                $consulta1 = $conexion->prepare($sql);
                $consulta1->execute();

                if($consulta1->rowCount() <= 0){
                    $sql = "INSERT INTO ".$this->tabla." (".$this->columns.") VALUES (".$this->signo.");";
                    $consulta = $conexion->prepare($sql);

                    for($i = 0; $i < count($this->cont); $i++){
                        $consulta->bindValue($i+1, $Dato[$i], PDO::PARAM_STR);

                    }

                    $consulta->execute();

                    $sql = "SELECT * FROM  ".$this->tabla." WHERE ".$datoABuscar;
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->execute();

                    if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount()) ){
                        /*  SE INGRESO DE FORMA CORRECTA TODO SIGUE PROCEDIMIENTO NORMAL */
                        $respuesta  = "1";
                    }else{
                        /*  SE INSERTO PERO NO ES IGUAL A LO QUE ENCONTRO  */
                        $sql = "DELETE FROM ".$this->tabla." WHERE ".$datoABuscar;
                        $consulta2 = $conexion->prepare($sql);
                        $consulta2->execute();
                        $respuesta  = "3";

                    }

                }else{
                    /*  DATO REPETIDO NO SE INGRESARA  */
                    $respuesta = "2";

                }
            }catch(PDOException $e){
                echo "[CREAR REGISTRO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $consulta2 = NULL;
            $conexion = NULL;

            echo $respuesta;

        }
        
        public function editarRegistro(){
            try{
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $Dato = explode("||",$this->valores);
                $cc = explode(",", $this->columns);

                for($i = 0; $i < count($this->cont); $i++){
                    if($i > 0){ $datoABuscar.= " AND ";}
                    $campo = explode("= ?", $cc[$i]);
                    $datoABuscar .= " ".$campo[0]. " = '".$Dato[$i]."' ";
                }

                $sql = "SELECT * FROM  ".$this->tabla." WHERE ".$datoABuscar;
                $consulta1 = $conexion->prepare($sql);
                $consulta1->execute();

                if($consulta1->rowCount() <= 0){
                    $sql = "UPDATE ".$this->tabla." SET ".$this->columns." WHERE ".$this->signo." = ? ";
                    $consulta = $conexion->prepare($sql);
                    for($i = 0; $i < count($this->cont); $i++){
                        $consulta->bindValue($i+1, $Dato[$i], PDO::PARAM_STR);

                    }

                    $consulta->bindValue((count($this->cont)+1), $this->id, PDO::PARAM_INT);
                    $consulta->execute();

                    $sql = "SELECT * FROM  ".$this->tabla." WHERE ".$datoABuscar;
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->execute();

                    if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount()) ){
                        /*  SE UPDATEO DE FORMA CORRECTA TODO SIGUE PROCEDIMIENTO NORMAL */
                        $respuesta  = "1";

                    }else{
                        /*  SE UPDATEO PERO DE MANERA INCORRECTA  */
                        $respuesta  = "3";

                    }

                }else{
                    /*  DATO REPETIDO NO SE INGRESARA  */
                    $respuesta = "2";

                }
        
            }catch(PDOException $e){
                echo "[EDITAR REGISTRO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $consulta1 = NULL;
            $conexion = NULL;

            echo $respuesta;

        }

        public function eliminarRegistro(){
            try{
                $conexion = new Conectar();
                $sql = "DELETE FROM ".$this->tabla." WHERE ".$this->columns." = ? ";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1", $this->id, PDO::PARAM_INT);
                $consulta->execute();
                if ($consulta->rowCount() > 0) {
                    $sql = "SELECT * FROM ".$this->tabla." WHERE ".$this->columns." = ? ";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue("1", $this->id, PDO::PARAM_INT);
                    $consulta->execute();
                    
                    if ($consulta->rowCount() > 0) {
                        $respuesta = "3";

                    }else{
                        $respuesta = "1";

                    }

                }else{
                    $respuesta = "2";
                }
            
            }catch(PDOException $e){
                echo "[ELIMINAR REGISTRO] -> ha ocurrido un error ".$e->getMessage();
                
            }
        
            $consulta = NULL;
            $conexion = NULL;

            echo $respuesta;

        }
    
    }
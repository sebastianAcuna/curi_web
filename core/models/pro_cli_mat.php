<?php
    session_start();
    require_once '../../db/conectarse_db.php';

    // error_reporting(E_ALL);
    // ini_set('display_errors', '1'); 

    class ProCliMat{

        /*  COMPARTIDO POR TODOS  */
        private $nombre_es, $nombre_en, $desde, $orden, $filtro;

        /*  SOLO TITULO  */
        private $id_titulo, $es_lista;

        /*  SOLO SUB PROPIEDADES  */
        private $id_propiedad;

        
        
        /* SOLO RELACION  */
        private $id_relacion, $id_esp, $id_etapa, $id_tempo, $aplica, $orden_tabla,  $foraneo, $tabla, $campo, $tipo_campo, $reporte_cliente, $especial, $identificador, $desc_titulo, $desc_propiedad;

        private $especies_involucradas;

        private $quien_ingresa;



        public function set_quien_ingresa($quien_ingresa){
            $quien_ingresa = (isset($quien_ingresa)?$quien_ingresa:NULL);
            $this->quien_ingresa = filter_var($quien_ingresa,FILTER_SANITIZE_STRING);
        }

        /*  COMPARTIDO POR TODOS  */
        public function set_nombre_es($nombre_es){
            $nombre_es = (isset($nombre_es)?$nombre_es:NULL);
            $this->nombre_es = filter_var($nombre_es,FILTER_SANITIZE_STRING);
        }

        public function set_nombre_en($nombre_en){
            $nombre_en = (isset($nombre_en)?$nombre_en:NULL);
            $this->nombre_en = filter_var($nombre_en,FILTER_SANITIZE_STRING);
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

        public function set_especies_involucradas($especies_involucradas) {
            $this->especies_involucradas = $especies_involucradas;
        }



        /*  SOLO TITULO  */
        public function set_id_titulo($id_titulo){
            $id_titulo = (isset($id_titulo)?$id_titulo:NULL);
            $this->id_titulo = filter_var($id_titulo,FILTER_SANITIZE_NUMBER_INT);
        }

        public function set_es_lista($es_lista){
            $es_lista = (isset($es_lista)?$es_lista:NULL);
            $this->es_lista = filter_var($es_lista,FILTER_SANITIZE_STRING);
        }

        /*  SOLO SUB PROPIEDADES  */
        public function set_id_propiedad($id_propiedad){
            $id_propiedad = (isset($id_propiedad)?$id_propiedad:NULL);
            $this->id_propiedad = filter_var($id_propiedad,FILTER_SANITIZE_NUMBER_INT);
        }



        /*  SOLO RELACION */

        public function set_id_relacion($id_relacion){
            $id_relacion = (isset($id_relacion)?$id_relacion:NULL);
            $this->id_relacion = filter_var($id_relacion,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_id_esp($id_esp){
            $id_esp = (isset($id_esp)?$id_esp:NULL);
            $this->id_esp = filter_var($id_esp,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_id_etapa($id_etapa){
            $id_etapa = (isset($id_etapa)?$id_etapa:NULL);
            $this->id_etapa = filter_var($id_etapa,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_id_tempo($id_tempo){
            $id_tempo = (isset($id_tempo)?$id_tempo:NULL);
            $this->id_tempo = filter_var($id_tempo,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_orden_tabla($orden_tabla){
            $orden_tabla = (isset($orden_tabla)?$orden_tabla:NULL);
            $this->orden_tabla = filter_var($orden_tabla,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_identificador($identificador){
            $identificador = (isset($identificador)?$identificador:NULL);
            $this->identificador = filter_var($identificador,FILTER_SANITIZE_NUMBER_INT);
        }
        public function set_aplica($aplica){
            $aplica = (isset($aplica)?$aplica:NULL);
            $this->aplica = filter_var($aplica,FILTER_SANITIZE_STRING);
        }
        public function set_foraneo($foraneo){
            $foraneo = (isset($foraneo)?$foraneo:NULL);
            $this->foraneo = filter_var($foraneo,FILTER_SANITIZE_STRING);
        }
        public function set_tabla($tabla){
            $tabla = (isset($tabla)?$tabla:NULL);
            $this->tabla = filter_var($tabla,FILTER_SANITIZE_STRING);
        }
        public function set_campo($campo){
            $campo = (isset($campo)?$campo:NULL);
            $this->campo = filter_var($campo,FILTER_SANITIZE_STRING);
        }
        public function set_tipo_campo($tipo_campo){
            $tipo_campo = (isset($tipo_campo)?$tipo_campo:NULL);
            $this->tipo_campo = filter_var($tipo_campo,FILTER_SANITIZE_STRING);
        }
        public function set_reporte_cliente($reporte_cliente){
            $reporte_cliente = (isset($reporte_cliente)?$reporte_cliente:NULL);
            $this->reporte_cliente = filter_var($reporte_cliente,FILTER_SANITIZE_STRING);
        }
        public function set_especial($especial){
            $especial = (isset($especial)?$especial:NULL);
            $this->especial = filter_var($especial,FILTER_SANITIZE_STRING);
        }

        

        public function set_desc_titulo($desc_titulo){
            $desc_titulo = (isset($desc_titulo)?$desc_titulo:NULL);
            $this->desc_titulo = filter_var($desc_titulo,FILTER_SANITIZE_STRING);
        }
        public function set_desc_propiedad($desc_propiedad){
            $desc_propiedad = (isset($desc_propiedad)?$desc_propiedad:NULL);
            $this->desc_propiedad = filter_var($desc_propiedad,FILTER_SANITIZE_STRING);
        }


        public function tipoCampo($esLista, $tipo_campo){
    

            if($esLista == "SI"){
    
                switch($tipo_campo){
                    case 'DATE':
                        return "RECYCLER_GENERICO_DATE";
                    break; 
                    case 'INT':
                        return "RECYCLER_GENERICO_INT";
                    break; 
                    case 'CHECK':
                        return "RECYCLER_GENERICO_STRING";
                    break; 
                    case 'TEXT':
                        return "RECYCLER_GENERICO_STRING";
                    break; 
                    case 'DECIMAL':
                        return "RECYCLER_GENERICO_DECIMAL";
                    break; 
                    case 'TEXTVIEW':
                        return "RECYCLER_GENERICO_TEXTVIEW";
                    break; 
                    default:
                        return "RECYCLER_GENERICO_STRING";
                    break; 
                }
    
            }else{
                return $tipo_campo;
            }
        }




        /* TITULOS */
        public function traerDatosTitulo(){
            try{
                /**********/
                /* Filtro */
                /**********/
                $filtro = "WHERE 1 ";

                if($this->nombre_es != ""){ $filtro .= " AND P.nombre_es LIKE '%$this->nombre_es%' "; }
                if($this->nombre_en != ""){ $filtro .= " AND P.nombre_en LIKE '%$this->nombre_en%' "; }
                if($this->es_lista != ""){ $filtro .= " AND P.es_lista LIKE '%$this->es_lista%' "; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY P.nombre_es ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY P.nombre_es DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY P.nombre_en ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY P.nombre_en DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY P.es_lista ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY P.es_lista DESC";
                    break;
                    default:
                        $orden = "ORDER BY P.nombre_es ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT P.nombre_es, P.nombre_en, P.es_lista, P.id_prop
                        FROM propiedades P
                        $filtro  $orden LIMIT $this->desde,10";

                        // echo $sql;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS TITULOS] -> ha ocurrido un error ".$e->getMessage();
            }
        
            $consulta = NULL;
            $conexion = NULL;

        }


        public function totalDatosTitulos(){
            try{
                 /**********/
                /* Filtro */
                /**********/
                $filtro = "WHERE 1 ";

                if($this->nombre_es != ""){ $filtro .= " AND P.nombre_es LIKE '%$this->nombre_es%' "; }
                if($this->nombre_en != ""){ $filtro .= " AND P.nombre_en LIKE '%$this->nombre_en%' "; }
                if($this->es_lista != ""){ $filtro .= " AND P.es_lista LIKE '%$this->es_lista%' "; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM propiedades P
                        $filtro ";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $this->set_data(array("Total" => $r[0]["Total"]));
                }
            }catch(PDOException $e){
                echo "[TOTAL DATOS TITULOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function crearTitulo(){
            $conexion = new Conectar();
            $conexion = $conexion->conexion();
            $rollback = false;

            $conexion->beginTransaction();

            $fechaHora = date("Y-m-d H:i:s");

            try{

                $sql = "INSERT INTO propiedades ( nombre_es, nombre_en, es_lista ) VALUES (:nombre_es, :nombre_en, :es_lista);";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(":nombre_es",strtoupper($this->nombre_es), PDO::PARAM_STR);
                $consulta->bindValue(":nombre_en",strtoupper($this->nombre_en), PDO::PARAM_STR);
                $consulta->bindValue(":es_lista",$this->es_lista, PDO::PARAM_STR);
                $consulta->execute();

                if($consulta->rowCount() <= 0 ){
                    $rollback = true;
                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[CREAR TITULO ] -> ha ocurrido un error ".$e->getMessage();
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

        public function traerInfoTitulo(){

            $conexion = new Conectar();
            $sql = "SELECT P.nombre_es, P.nombre_en, P.es_lista, P.id_prop FROM propiedades P WHERE P.id_prop = :id_titulo";
            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);

            
            $consulta->bindValue(":id_titulo",$this->id_titulo, PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
            }

            $consulta = NULL;
            $conexion = NULL;

        }
        
        public function editarTitulo(){
            $conexion = new Conectar();
            $conexion = $conexion->conexion();
            $rollback = false;

            $conexion->beginTransaction();

            $fechaHora = date("Y-m-d H:i:s");

            try{

                $sql = "UPDATE  propiedades SET nombre_es = :nombre_es, nombre_en = :nombre_en , es_lista = :es_lista  WHERE id_prop = :id_titulo ;";

                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(":nombre_es",strtoupper($this->nombre_es), PDO::PARAM_STR);
                $consulta->bindValue(":nombre_en",strtoupper($this->nombre_en), PDO::PARAM_STR);
                $consulta->bindValue(":es_lista",$this->es_lista, PDO::PARAM_STR);
                $consulta->bindValue(":id_titulo",$this->id_titulo, PDO::PARAM_INT);
                $consulta->execute();


                    $sql = "SELECT id_prop_mat_cli, tipo_campo FROM prop_cli_mat WHERE id_prop = :id_titulo ; ";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue(":id_titulo",$this->id_titulo, PDO::PARAM_STR);
                    $consulta->execute();
                    if($consulta->rowCount() > 0){
                        $res = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($res AS $r){

                            if($this->es_lista == "SI"){

                                switch($r["tipo_campo"]){
                                    case "DATE";
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_DATE";
                                    break;
                                    case "TEXT";
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_STRING";
                                    break;
                                    case "INT";
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_INT";
                                    break;
                                    case "TEXTVIEW";
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_TEXTVIEW";
                                    break;
                                    case "DECIMAL";
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_DECIMAL";
                                    break;
                                    default:
                                        $r["tipo_campo"] = "RECYCLER_GENERICO_STRING";
                                    break;
                                }

                            }else{
                                switch($r["tipo_campo"]){
                                    case "RECYCLER_GENERICO_DATE";
                                     $r["tipo_campo"] = "DATE";
                                    break;
                                    case "RECYCLER_GENERICO_STRING";
                                        $r["tipo_campo"] = "TEXT";
                                    break;
                                    case "RECYCLER_GENERICO_INT";
                                        $r["tipo_campo"] = "INT";
                                    break;
                                    case "RECYCLER_GENERICO_TEXTVIEW";
                                      $r["tipo_campo"] = "TEXTVIEW";
                                    break;
                                    case "RECYCLER_GENERICO_DECIMAL";
                                        $r["tipo_campo"] = "DECIMAL";
                                    break;
                                    
                                }
                            }

                            $sql = "UPDATE prop_cli_mat SET tipo_campo = :tipo_campo WHERE id_prop_mat_cli = :id_prop ;";
                            $consulta = $conexion->prepare($sql);
                            $consulta->bindValue(":tipo_campo",$r["tipo_campo"], PDO::PARAM_STR);
                            $consulta->bindValue(":id_prop",$r["id_prop_mat_cli"], PDO::PARAM_STR);
                            $consulta->execute();
                        }
                    }

            }catch(PDOException $e){
                $rollback = true;
                echo "[EDITAR TITULO ] -> ha ocurrido un error ".$e->getMessage();
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

        public function eliminarTitulo(){
            $conexion = new Conectar();
            $conexion = $conexion->conexion();
            $rollback = false;

            $conexion->beginTransaction();

            $fechaHora = date("Y-m-d H:i:s");
            try{

                $sql = "SELECT * FROM prop_cli_mat WHERE id_prop = :id_titulo; ";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(":id_titulo",$this->id_titulo, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    
                    $respuesta = "2";

                }else{
                    $sql = "DELETE FROM  propiedades WHERE id_prop = :id_titulo; ";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue(":id_titulo",$this->id_titulo, PDO::PARAM_INT);
                    $consulta->execute();
                }
            }catch(PDOException $e){
                $rollback = true;
                echo "[ELIMINAR TITULO ] -> ha ocurrido un error ".$e->getMessage();
            }

            if($rollback){
                $conexion->rollback();
                $respuesta = "3";
            }else{
                if($respuesta == "" ){
                    $conexion->commit();
                    $respuesta = "1";
                }
            }

            $consulta = NULL;
            $conexion = NULL;

            return $respuesta;
        }

        /*  FIN TITULOS  */
        

    /*  PROPIEDADES  */

    public function traerDatosPropiedades(){
        try{
            /**********/
            /* Filtro */
            /**********/
            $filtro = "WHERE 1 ";

            if($this->nombre_es != ""){ $filtro .= " AND SP.nombre_es LIKE '%$this->nombre_es%' "; }
            if($this->nombre_en != ""){ $filtro .= " AND SP.nombre_en LIKE '%$this->nombre_en%' "; }

            /*********/
            /* Orden */
            /*********/

            $orden = "";
            switch($this->orden){
                case 1:
                    $orden = "ORDER BY SP.nombre_es ASC";
                break;
                case 2:
                    $orden = "ORDER BY SP.nombre_es DESC";
                break;
                case 3:
                    $orden = "ORDER BY SP.nombre_en ASC";
                break;
                case 4:
                    $orden = "ORDER BY SP.nombre_en DESC";
                break;
                default:
                    $orden = "ORDER BY SP.nombre_es ASC";
                break;
            }

            /*******/
            /* SQL */
            /*******/

            $conexion = new Conectar();
            $sql = "SELECT SP.nombre_es, SP.nombre_en, SP.id_sub_propiedad
                    FROM sub_propiedades SP
                    $filtro  $orden LIMIT $this->desde,10";

                    // echo $sql;
            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
            }
    
        }catch(PDOException $e){
            echo "[TRAER DATOS PROPIEDADES] -> ha ocurrido un error ".$e->getMessage();
        }
    
        $consulta = NULL;
        $conexion = NULL;

    }

    public function totalDatosPropiedades(){
        try{
             /**********/
            /* Filtro */
            /**********/
            $filtro = "WHERE 1 ";

            if($this->nombre_es != ""){ $filtro .= " AND SP.nombre_es LIKE '%$this->nombre_es%' "; }
            if($this->nombre_en != ""){ $filtro .= " AND SP.nombre_en LIKE '%$this->nombre_en%' "; }

            /*******/
            /* SQL */
            /*******/

            $conexion = new Conectar();
            $sql = "SELECT count(*) AS Total FROM sub_propiedades SP $filtro ";
            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $this->set_data(array("Total" => $r[0]["Total"]));
            }
        }catch(PDOException $e){
            echo "[TOTAL DATOS PROPIEDADES] -> ha ocurrido un error ".$e->getMessage();

        }
    
        $consulta = NULL;
        $conexion = NULL;

    }


    public function crearPropiedad(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");

        try{

            $sql = "INSERT INTO sub_propiedades ( nombre_es, nombre_en ) VALUES (:nombre_es, :nombre_en);";
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":nombre_es",strtoupper($this->nombre_es), PDO::PARAM_STR);
            $consulta->bindValue(":nombre_en",strtoupper($this->nombre_en), PDO::PARAM_STR);
            $consulta->execute();

            if($consulta->rowCount() <= 0 ){
                $rollback = true;
            }

        }catch(PDOException $e){
            $rollback = true;
            echo "[CREAR PROPIEDAD ] -> ha ocurrido un error ".$e->getMessage();
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

    public function editarPropiedad(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");

        try{

            $sql = "UPDATE sub_propiedades SET nombre_es = :nombre_es, nombre_en = :nombre_en  WHERE id_sub_propiedad = :id_propiedad ;";

            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":nombre_es",strtoupper($this->nombre_es), PDO::PARAM_STR);
            $consulta->bindValue(":nombre_en",strtoupper($this->nombre_en), PDO::PARAM_STR);
            $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_INT);
            $consulta->execute();

        }catch(PDOException $e){
            $rollback = true;
            echo "[EDITAR PROPIEDAD ] -> ha ocurrido un error ".$e->getMessage();
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

    public function traerInfoPropiedad(){
        $conexion = new Conectar();
        $sql = "SELECT SP.nombre_es, SP.nombre_en, SP.id_sub_propiedad FROM sub_propiedades SP WHERE SP.id_sub_propiedad = :id_propiedad";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_INT);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }

        $consulta = NULL;
        $conexion = NULL;
    }

    public function eliminarPropiedad(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");
        try{

            $sql = "SELECT * FROM prop_cli_mat WHERE id_sub_propiedad = :id_propiedad; ";
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_INT);
            $consulta->execute();
            if($consulta->rowCount() > 0){
                
                $respuesta = "2";

            }else{
                $sql = "DELETE FROM  sub_propiedades WHERE id_sub_propiedad = :id_propiedad; ";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_INT);
                $consulta->execute();
            }
        }catch(PDOException $e){
            $rollback = true;
            echo "[ELIMINAR PROPIEDAD ] -> ha ocurrido un error ".$e->getMessage();
        }

        if($rollback){
            $conexion->rollback();
            $respuesta = "3";
        }else{
            if($respuesta == "" ){
                $conexion->commit();
                $respuesta = "1";
            }
        }

        $consulta = NULL;
        $conexion = NULL;

        return $respuesta;
    }

    /*  FIN PROPIEDADES  */

    /*  RELACIONES  */

    public function traerDatosRelacion(){

        try{
                /**********/
                /* Filtro */
                /**********/
                $filtro = "WHERE 1 ";


                if($this->desc_titulo != ""){ $filtro .= " AND T.nombre_es LIKE '%$this->desc_titulo%' "; }
                if($this->desc_propiedad != ""){ $filtro .= " AND P.nombre_es LIKE '%$this->desc_propiedad%' "; }
                if($this->aplica != ""){ $filtro .= " AND PCM.aplica LIKE '%$this->aplica%' "; }

                if($this->id_esp != ""){ $filtro .= " AND PCM.id_esp = '$this->id_esp' "; }
                if($this->id_etapa != ""){ $filtro .= " AND PCM.id_etapa = '$this->id_etapa' "; }
                if($this->id_tempo != ""){ $filtro .= " AND PCM.id_tempo = '$this->id_tempo' "; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY E.nombre ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY ET.nombre ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY ET.nombre DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY TE.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY TE.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY T.nombre_es ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY T.nombre_es DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY P.nombre_es ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY P.nombre_es DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY PCM.aplica ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY PCM.aplica DESC";
                    break;
                    default:
                        $orden = "ORDER BY PCM.id_esp, PCM.id_tempo, PCM.id_etapa, P.nombre_es DESC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT 
                PCM.id_prop_mat_cli, PCM.id_esp, PCM.id_prop, PCM.id_etapa, PCM.id_tempo, PCM.id_sub_propiedad, PCM.aplica, PCM.orden, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo, PCM.reporte_cliente, PCM.especial, PCM.identificador, T.nombre_es AS titulo, P.nombre_es AS propiedad, E.nombre AS especie, ET.nombre AS etapa, TE.nombre AS temporada
                        FROM prop_cli_mat PCM
                        INNER JOIN especie E USING (id_esp)
                        INNER JOIN temporada TE USING (id_tempo)
                        LEFT JOIN propiedades T USING (id_prop)
                        INNER JOIN sub_propiedades P USING (id_sub_propiedad)
                        INNER JOIN etapa ET USING (id_etapa)

                        $filtro  $orden LIMIT $this->desde,10";

                        // echo $sql;
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS RELACION] -> ha ocurrido un error ".$e->getMessage();
            }
        
            $consulta = NULL;
            $conexion = NULL;
    }

    public function totalDatosRelacion() {

            try{
                /**********/
               /* Filtro */
               /**********/
               $filtro = "WHERE 1 ";


               if($this->desc_titulo != ""){ $filtro .= " AND T.nombre_es LIKE '%$this->desc_titulo%' "; }
               if($this->desc_propiedad != ""){ $filtro .= " AND P.nombre_es LIKE '%$this->desc_propiedad%' "; }
               if($this->aplica != ""){ $filtro .= " AND PCM.aplica LIKE '%$this->aplica%' "; }

               if($this->id_esp != ""){ $filtro .= " AND PCM.id_esp = '$this->id_esp' "; }
               if($this->id_etapa != ""){ $filtro .= " AND PCM.id_etapa = '$this->id_etapa' "; }
               if($this->id_tempo != ""){ $filtro .= " AND PCM.id_tempo = '$this->id_tempo' "; }

               /*******/
               /* SQL */
               /*******/

               $conexion = new Conectar();
               $sql = "SELECT count(*) AS Total FROM prop_cli_mat PCM
               INNER JOIN especie E USING (id_esp)
               INNER JOIN temporada TE USING (id_tempo)
               LEFT JOIN propiedades T USING (id_prop)
               INNER JOIN sub_propiedades P USING (id_sub_propiedad)
               INNER JOIN etapa ET USING (id_etapa)
                $filtro ";
               $conexion = $conexion->conexion();
               $consulta = $conexion->prepare($sql);
               $consulta->execute();
               if($consulta->rowCount() > 0){
                   $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                   $this->set_data(array("Total" => $r[0]["Total"]));
               }
           }catch(PDOException $e){
               echo "[TOTAL DATOS RELACIONES] -> ha ocurrido un error ".$e->getMessage();

           }
       
           $consulta = NULL;
           $conexion = NULL;

    }

    public function crearRelacion(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");
        $arrayAplican;
        $esLista;
        $orden;

        try{

            if(sizeof($this->especies_involucradas) > 0){

                $sql = "SELECT * FROM especie ";
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    foreach($res AS $species){
                        $things = $this->especies_involucradas;
                        if($species["id_esp"] == $this->especies_involucradas[$species["id_esp"]] ){ 
                            $arrayAplican[$species["id_esp"]] = "SI";
                        }else{
                            $arrayAplican[$species["id_esp"]] = "NO";
                        }
                    }
                }


                $sql = "SELECT * FROM propiedades";
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach($prop AS $props){
                        $esLista[$props["id_prop"]] = $props["es_lista"];
                    }
                }
                $esLista[0] = "NO";


                
            
                $this->id_titulo = ($this->id_etapa == 1) ? 0 : $this->id_titulo;
                $this->foraneo = $this->foraneo = ($this->tipo_campo == "TEXTVIEW") ? "SI" : "NO";
                $identificador = 0;

                $sql = "SELECT MAX(identificador) AS identificador FROM prop_cli_mat WHERE id_tempo = :id_tempo  LIMIT 1;";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $identificador = $prop[0]["identificador"] + 1;
                }else{
                    $identificador = 1;
                }

                // $ordenIdent = $identificador + 100;

               
                $id_orden = $this->orden_tabla;
                $orden = $id_orden + 10;

               

                foreach($arrayAplican AS $idEsp => $aplica){

                    // $sql = "SELECT orden FROM prop_cli_mat WHERE id_sub_propiedad = :id_orden AND id_esp = :id_esp AND id_tempo = :id_tempo LIMIT 1;";
                    // $consulta = $conexion->prepare($sql);
                    // $consulta->bindValue(":id_orden",$id_orden, PDO::PARAM_STR);
                    // $consulta->bindValue(":id_esp",$idEsp, PDO::PARAM_STR);
                    // $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                    // $consulta->execute();
                    // if($consulta->rowCount() > 0){
                    //     $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    //     $orden = $prop[0]["orden"] + 10;
                    // }
                    

                    $sql = "INSERT INTO prop_cli_mat ( id_esp, id_prop, id_etapa, id_tempo, id_sub_propiedad, aplica, orden, foraneo, tabla, campo, tipo_campo, reporte_cliente, especial, identificador, ingresa, id_orden ) VALUES (:id_esp, :id_prop, :id_etapa, :id_tempo, :id_sub_propiedad, :aplica, :orden, :foraneo, :tabla, :campo, :tipo_campo, :reporte_cliente, :especial, :identificador, :ingresa, :id_orden);";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindValue(":id_esp",$idEsp, PDO::PARAM_STR);
                    $consulta->bindValue(":id_prop",$this->id_titulo, PDO::PARAM_STR);
                    $consulta->bindValue(":id_etapa",$this->id_etapa, PDO::PARAM_STR);
                    $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue(":id_sub_propiedad",$this->id_propiedad, PDO::PARAM_STR);
                    $consulta->bindValue(":aplica",$aplica, PDO::PARAM_STR);
                    $consulta->bindValue(":orden",$orden, PDO::PARAM_STR);
                    $consulta->bindValue(":foraneo",$this->foraneo, PDO::PARAM_STR);
                    $consulta->bindValue(":tabla",($this->tabla != null && $this->foraneo != "NO") ? $this->tabla : "", PDO::PARAM_STR);
                    $consulta->bindValue(":campo",($this->campo != null && $this->foraneo != "NO") ? $this->campo : "", PDO::PARAM_STR);
                    $consulta->bindValue(":tipo_campo",$this->tipoCampo($esLista[$this->id_titulo], $this->tipo_campo), PDO::PARAM_STR);
                    $consulta->bindValue(":reporte_cliente",$this->reporte_cliente, PDO::PARAM_STR);
                    $consulta->bindValue(":especial",$this->especial, PDO::PARAM_STR);
                    $consulta->bindValue(":identificador",$identificador, PDO::PARAM_STR);
                    $consulta->bindValue(":ingresa",$this->quien_ingresa, PDO::PARAM_STR);
                    $consulta->bindValue(":id_orden",$id_orden, PDO::PARAM_STR);
                    $consulta->execute();
        
                    if($consulta->rowCount() <= 0 ){
                        $rollback = true;
                    }

                    $lastId  = $conexion->lastInsertId();

                    if($lastId > 0){

                        $sql = "SELECT id_cli FROM quotation GROUP BY id_cli ";
                        $consulta = $conexion->prepare($sql);
                        $consulta->execute();
                        if($consulta->rowCount() > 0){
                            $pp = $consulta->fetchAll(PDO::FETCH_ASSOC);

                            foreach($pp as $res){
                                if($res["id_cli"] > 0){
                                    $sql = "INSERT INTO cli_pcm ( id_cli, id_prop_mat_cli, ver, registrar, user_crea, fecha_crea, user_mod, fecha_mod ) VALUES (:id_cli, :id_prop_mat_cli, :ver, :registrar, :user_crea, :fecha_crea, :user_mod, :fecha_mod );";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->bindValue(":id_cli",$res["id_cli"], PDO::PARAM_STR);
                                    $consulta->bindValue(":id_prop_mat_cli",$lastId, PDO::PARAM_STR);
                                    $consulta->bindValue(":ver","1", PDO::PARAM_STR);
                                    $consulta->bindValue(":registrar","1", PDO::PARAM_STR);
                                    $consulta->bindValue(":user_crea",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                                    $consulta->bindValue(":fecha_crea",$fechaHora, PDO::PARAM_STR);
                                    $consulta->bindValue(":user_mod",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                                    $consulta->bindValue(":fecha_mod",$fechaHora, PDO::PARAM_STR);
                                    $consulta->execute();
                                }
                            }
                        }
                    }
                }

            }

        }catch(PDOException $e){
            $rollback = true;
            echo "[CREAR RELACION ] -> ha ocurrido un error ".$e->getMessage();
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


    public function traerPCMCampos(){
        $conexion = new Conectar();
        $sql = "SELECT * FROM pro_cli_mat_campo
                WHERE nombre_pcm_tabla = :nombre_en ORDER BY nombre_pcm_tabla ASC ; ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":nombre_en",$this->nombre_en, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;

    }

    public function traerPropiedadesSelect(){
        $conexion = new Conectar();
        $sql = "SELECT * FROM sub_propiedades ORDER BY nombre_es ASC; ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;

    }

    public function traerTituloSelect(){
        $conexion = new Conectar();
        $sql = "SELECT * FROM propiedades ORDER BY nombre_es ASC; ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;

    }

    
    public function cargarDespuesDe(){
        $conexion = new Conectar();
        $sql = "SELECT 
                    PCM.orden, SP.nombre_en, SP.nombre_es 
        FROM        prop_cli_mat PCM 
        INNER JOIN  sub_propiedades SP USING(id_sub_propiedad)  
        WHERE       PCM.id_prop = :id_prop AND 
                    PCM.id_tempo = :id_tempo AND 
                    PCM.id_etapa = :id_etapa AND 
                    PCM.id_sub_propiedad != :id_propiedad 
        GROUP BY    PCM.id_sub_propiedad
        ORDER BY    PCM.orden ASC; ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_prop",$this->id_titulo, PDO::PARAM_STR);
        $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
        $consulta->bindValue(":id_etapa",$this->id_etapa, PDO::PARAM_STR);
        $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;

    }


    public function cargarTitulosDespuesDe(){
        $conexion = new Conectar();
        $sql = "SELECT 
                    PCM.id_prop, P.nombre_en, P.nombre_es 
        FROM        prop_cli_mat PCM 
        INNER JOIN  propiedades P USING(id_prop)  
        WHERE       PCM.id_tempo = :id_tempo AND 
                    PCM.id_etapa = :id_etapa 
        GROUP BY    PCM.id_prop
        ORDER BY    PCM.orden ASC; ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
        $consulta->bindValue(":id_etapa",$this->id_etapa, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;

    }

    public function editarRelacion(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");
        $arrayAplican;
        $esLista;
        $orden;

        try{

            if(sizeof($this->especies_involucradas) > 0 && $this->especies_involucradas != null){


                $sql = "SELECT * FROM especie ";
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    foreach($res AS $species){
                        $things = $this->especies_involucradas;
                        if($species["id_esp"] == $this->especies_involucradas[$species["id_esp"]] ){ 
                            $arrayAplican[$species["id_esp"]] = "SI";
                        }
                    }
                }
            }else{
                $arrayAplican["0"] = "NO";
            }

                $sql = "SELECT * FROM propiedades";
                $consulta = $conexion->prepare($sql);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach($prop AS $props){
                        $esLista[$props["id_prop"]] = $props["es_lista"];
                    }
                }
                $esLista[0] = "NO";


                
            
                $this->id_titulo = ($this->id_etapa == 1) ? 0 : $this->id_titulo;
                $this->foraneo = $this->foraneo = ($this->tipo_campo == "TEXTVIEW") ? "SI" : "NO";


                // $identificador = 0;

                // $sql = "SELECT MAX(identificador) AS identificador FROM prop_cli_mat WHERE id_tempo = :id_tempo  LIMIT 1;";
                // $consulta = $conexion->prepare($sql);
                // $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                // $consulta->execute();
                // if($consulta->rowCount() > 0){
                //     $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                //     $identificador = $prop[0]["identificador"] + 1;
                // }
               
               
                $id_orden = $this->orden_tabla;
                $orden = $id_orden + 10;

                foreach($arrayAplican AS $idEsp => $aplica){

                    // $sql = "SELECT orden FROM prop_cli_mat WHERE id_sub_propiedad = :id_orden AND id_esp = :id_esp AND id_tempo = :id_tempo LIMIT 1;";
                    // $consulta = $conexion->prepare($sql);
                    // $consulta->bindValue(":id_orden",$id_orden, PDO::PARAM_STR);
                    // $consulta->bindValue(":id_esp",$idEsp, PDO::PARAM_STR);
                    // $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                    // $consulta->execute();
                    // if($consulta->rowCount() > 0){
                    //     $prop = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    //     $orden = $prop[0]["orden"] + 10;
                    // }else{
                    //     $sql = "SELECT MAX(orden) as max_orden FROM prop_cli_mat ;";
                    //     $consulta2 = $conexion->prepare($sql);
                    //     $consulta2->execute();
                    //     if($consulta2->rowCount() > 0){
                    //         $prop = $consulta2->fetchAll(PDO::FETCH_ASSOC);
                    //         $orden = $prop[0]["max_orden"] + 100;
                    //     }
                    // }


                    $add = ($idEsp > 0) ? " id_esp = :id_esp ," : "";

                    $sql = "UPDATE prop_cli_mat SET $add id_prop = :id_prop, id_etapa = :id_etapa, id_tempo = :id_tempo, id_sub_propiedad = :id_sub_propiedad, aplica = :aplica, orden = :orden, foraneo = :foraneo, tabla = :tabla, campo = :campo, tipo_campo = :tipo_campo, reporte_cliente = :reporte_cliente, especial = :especial, ingresa = :ingresa, id_orden = :id_orden WHERE id_prop_mat_cli = :id_relacion";
                    $consulta = $conexion->prepare($sql);
                    if ($idEsp > 0) $consulta->bindValue(":id_esp",$idEsp, PDO::PARAM_STR);
                    $consulta->bindValue(":id_prop",$this->id_titulo, PDO::PARAM_STR);
                    $consulta->bindValue(":id_etapa",$this->id_etapa, PDO::PARAM_STR);
                    $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue(":id_sub_propiedad",$this->id_propiedad, PDO::PARAM_STR);
                    $consulta->bindValue(":aplica",$aplica, PDO::PARAM_STR);
                    $consulta->bindValue(":orden",$orden, PDO::PARAM_STR);
                    $consulta->bindValue(":foraneo",$this->foraneo, PDO::PARAM_STR);
                    $consulta->bindValue(":tabla",($this->tabla != null && $this->foraneo != "NO") ? $this->tabla : "", PDO::PARAM_STR);
                    $consulta->bindValue(":campo",($this->campo != null && $this->foraneo != "NO") ? $this->campo : "", PDO::PARAM_STR);
                    $consulta->bindValue(":tipo_campo",$this->tipoCampo($esLista[$this->id_titulo], $this->tipo_campo), PDO::PARAM_STR);
                    $consulta->bindValue(":reporte_cliente",$this->reporte_cliente, PDO::PARAM_STR);
                    $consulta->bindValue(":especial",$this->especial, PDO::PARAM_STR);
                    $consulta->bindValue(":ingresa",$this->quien_ingresa, PDO::PARAM_STR);
                    $consulta->bindValue(":id_orden",$id_orden, PDO::PARAM_STR);

                    $consulta->bindValue(":id_relacion",$this->id_relacion, PDO::PARAM_STR);
                    $consulta->execute();
        
                    if($consulta->rowCount() <= 0 ){
                        $rollback = true;
                    }
                }
            

        }catch(PDOException $e){
            $rollback = true;
            echo "[EDITAR RELACION ] -> ha ocurrido un error ".$e->getMessage();
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




    public function trearEspeciesRelacionadas(){
        $conexion = new Conectar();
        $sql = "SELECT  PCM.id_esp FROM prop_cli_mat PCM  WHERE id_prop_mat_cli = :id_relacion GROUP BY PCM.id_esp ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_relacion",$this->id_relacion, PDO::PARAM_INT);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_especies_involucradas($consulta->fetchAll(PDO::FETCH_ASSOC));
        }

        $consulta = NULL;
        $conexion = NULL;
    }
   
    
    public function traerInfoRelacion(){
        $conexion = new Conectar();
        $sql = "SELECT 
        PCM.id_prop_mat_cli, PCM.id_esp, PCM.id_prop, PCM.id_etapa, PCM.id_tempo, PCM.id_sub_propiedad, PCM.aplica, PCM.orden, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo, PCM.reporte_cliente, PCM.especial, PCM.identificador, T.nombre_es AS titulo, P.nombre_es AS propiedad, E.nombre AS especie, ET.nombre AS etapa, TE.nombre AS temporada, PCM.ingresa, PCMT.nombre_real AS nombre_real_tabla,  PCMC.nombre_real AS nombre_real_campo, id_orden 
                FROM prop_cli_mat PCM
                INNER JOIN especie E USING (id_esp)
                INNER JOIN temporada TE USING (id_tempo)
                LEFT JOIN propiedades T USING (id_prop)
                INNER JOIN sub_propiedades P USING (id_sub_propiedad)
                INNER JOIN etapa ET USING (id_etapa)
                LEFT JOIN pro_cli_mat_tabla PCMT ON (PCM.tabla = PCMT.nombre_real)
                LEFT JOIN pro_cli_mat_campo PCMC ON (PCM.campo = PCMC.nombre_real)
                WHERE id_prop_mat_cli = :id_relacion";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_relacion",$this->id_relacion, PDO::PARAM_INT);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }

        $consulta = NULL;
        $conexion = NULL;
    }


    public function traerEspeciesAplican(){
        $conexion = new Conectar();
        $sql = "SELECT id_esp
                FROM prop_cli_mat
                WHERE id_sub_propiedad = :id_propiedad AND id_tempo = :id_tempo
                AND aplica = 'SI'
                GROUP BY id_esp";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id_propiedad",$this->id_propiedad, PDO::PARAM_INT);
        $consulta->bindValue(":id_tempo",$this->id_tempo, PDO::PARAM_INT);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;
    }

    public function traerEspeciesCheck(){
        $conexion = new Conectar();
        $sql = " SELECT * FROM especie ";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        if($consulta->rowCount() > 0){
            $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));
        }
        $consulta = NULL;
        $conexion = NULL;
    }



        
    public function eliminarRelacion(){
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
        $rollback = false;

        $conexion->beginTransaction();

        $fechaHora = date("Y-m-d H:i:s");
        try{
            
            $sql = "DELETE FROM  prop_cli_mat WHERE id_prop_mat_cli = :id_relacion; ";
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":id_relacion",$this->id_relacion, PDO::PARAM_INT);
            $consulta->execute();

            $sql = "DELETE FROM  cli_pcm WHERE id_prop_mat_cli = :id_relacion; ";
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(":id_relacion",$this->id_relacion, PDO::PARAM_INT);
            $consulta->execute();

            
        }catch(PDOException $e){
            $rollback = true;
            echo "[ELIMINAR RELACION ] -> ha ocurrido un error ".$e->getMessage();
        }

        if($rollback){
            $conexion->rollback();
            $respuesta = "3";
        }else{
            $conexion->commit();
            $respuesta = "1";
        }

        $consulta = NULL;
        $conexion = NULL;

        return $respuesta;
    }
}

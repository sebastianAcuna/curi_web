<?php
    session_start();
    require_once '../../db/conectarse_db.php';

    class Fichas{

        private $id_supervisor, $id_agricultor, $id_region, $id_comuna, $id_tempo, $id_predio, $id_lote, $id_especie, $id_tenencia, $id_maquinaria, $id_experiencia, $id_suelo, $id_riego;

        private $fieldbook, $fieldman, $temporada, $especie, $rut, $agricultor, $telefono, $administrador, $telefonoA, $oferta, $localidad, $region, $comuna, $haDisponibles, $direccion, $repre, $rutRepre, $telefonoRepre, $emailRepre, $banco, $cuentaC, $predio, $potrero, $rotacion_anno_1, $rotacion_desc_1, $rotacion_anno_2, $rotacion_desc_2, $rotacion_anno_3, $rotacion_desc_3, $rotacion_anno_4, $rotacion_desc_4, $norting, $easting, $radio, $suelo, $riego, $experiencia, $tenencia, $maquinaria, $maleza, $estado, $comentario, $fecha, $obsProp;

        private $id, $desde, $orden;

        private $data;

        private $imagen;



        /*  IMAGENES  12-06-2020 */
        public function set_imagen($imagen){
            $this->imagen =$imagen;
        }




        /* IDS */
        
        public function set_id_supervisor($id_supervisor){
            $id_supervisor = (isset($id_supervisor)?$id_supervisor:NULL);
            $this->id_supervisor = filter_var($id_supervisor,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_id_agricultor($id_agricultor){
            $id_agricultor = (isset($id_agricultor)?$id_agricultor:NULL);
            $this->id_agricultor = filter_var($id_agricultor,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_region($id_region){
            $id_region = (isset($id_region)?$id_region:NULL);
            $this->id_region = filter_var($id_region,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_comuna($id_comuna){
            $id_comuna = (isset($id_comuna)?$id_comuna:NULL);
            $this->id_comuna = filter_var($id_comuna,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_tempo($id_tempo){
            $id_tempo = (isset($id_tempo)?$id_tempo:NULL);
            $this->id_tempo = filter_var($id_tempo,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_predio($id_predio){
            $id_predio = (isset($id_predio)?$id_predio:NULL);
            $this->id_predio = filter_var($id_predio,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_id_lote($id_lote){
            $id_lote = (isset($id_lote)?$id_lote:NULL);
            $this->id_lote = filter_var($id_lote,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_id_especie($id_especie){
            $id_especie = (isset($id_especie)?$id_especie:NULL);
            $this->id_especie = filter_var($id_especie,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_tenencia($id_tenencia){
            $id_tenencia = (isset($id_tenencia)?$id_tenencia:NULL);
            $this->id_tenencia = filter_var($id_tenencia,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_maquinaria($id_maquinaria){
            $id_maquinaria = (isset($id_maquinaria)?$id_maquinaria:NULL);
            $this->id_maquinaria = filter_var($id_maquinaria,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_experiencia($id_experiencia){
            $id_experiencia = (isset($id_experiencia)?$id_experiencia:NULL);
            $this->id_experiencia = filter_var($id_experiencia,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_suelo($id_suelo){
            $id_suelo = (isset($id_suelo)?$id_suelo:NULL);
            $this->id_suelo = filter_var($id_suelo,FILTER_SANITIZE_STRING);

        }
        
        public function set_id_riego($id_riego){
            $id_riego = (isset($id_riego)?$id_riego:NULL);
            $this->id_riego = filter_var($id_riego,FILTER_SANITIZE_STRING);

        }
        
        /* FIN IDS */

        public function set_fieldbook($fieldbook){
            $fieldbook = (isset($fieldbook)?$fieldbook:NULL);
            $this->fieldbook = filter_var($fieldbook,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_fieldman($fieldman){
            $fieldman = (isset($fieldman)?$fieldman:NULL);
            $this->fieldman = filter_var($fieldman,FILTER_SANITIZE_STRING);

        }

        public function set_temporada($temporada){
            $temporada = (isset($temporada)?$temporada:NULL);
            $this->temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
            
        }
        
        public function set_especie($especie){
            $especie = (isset($especie)?$especie:NULL);
            $this->especie = filter_var($especie,FILTER_SANITIZE_STRING);

        }
        
        public function set_agricultor($agricultor){
            $agricultor = (isset($agricultor)?$agricultor:NULL);
            $this->agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);

        }
        
        public function set_rut($rut){
            $rut = (isset($rut)?$rut:NULL);
            $this->rut = filter_var($rut,FILTER_SANITIZE_STRING);

        }

        public function set_telefono($telefono){
            $telefono = (isset($telefono)?$telefono:NULL);
            $this->telefono = filter_var($telefono,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_administrador($administrador){
            $administrador = (isset($administrador)?$administrador:NULL);
            $this->administrador = filter_var($administrador,FILTER_SANITIZE_STRING);

        }

        public function set_telefonoA($telefonoA){
            $telefonoA = (isset($telefonoA)?$telefonoA:NULL);
            $this->telefonoA = filter_var($telefonoA,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_oferta($oferta){
            $oferta = (isset($oferta)?$oferta:NULL);
            $this->oferta = filter_var($oferta,FILTER_SANITIZE_STRING);

        }

        public function set_localidad($localidad){
            $localidad = (isset($localidad)?$localidad:NULL);
            $this->localidad = filter_var($localidad,FILTER_SANITIZE_STRING);

        }

        public function set_region($region){
            $region = (isset($region)?$region:NULL);
            $this->region = filter_var($region,FILTER_SANITIZE_STRING);

        }

        public function set_comuna($comuna){
            $comuna = (isset($comuna)?$comuna:NULL);
            $this->comuna = filter_var($comuna,FILTER_SANITIZE_STRING);

        }

        public function set_haDisponibles($haDisponibles){
            $haDisponibles = (isset($haDisponibles)?$haDisponibles:NULL);
            $this->haDisponibles = filter_var($haDisponibles,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_direccion($direccion){
            $direccion = (isset($direccion)?$direccion:NULL);
            $this->direccion = filter_var($direccion,FILTER_SANITIZE_STRING);

        }
        
        public function set_repre($repre){
            $repre = (isset($repre)?$repre:NULL);
            $this->repre = filter_var($repre,FILTER_SANITIZE_STRING);

        }
        
        public function set_rutRepre($rutRepre){
            $rutRepre = (isset($rutRepre)?$rutRepre:NULL);
            $this->rutRepre = filter_var($rutRepre,FILTER_SANITIZE_STRING);

        }
        
        public function set_telefonoRepre($telefonoRepre){
            $telefonoRepre = (isset($telefonoRepre)?$telefonoRepre:NULL);
            $this->telefonoRepre = filter_var($telefonoRepre,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_emailRepre($emailRepre){
            $emailRepre = (isset($emailRepre)?$emailRepre:NULL);
            $this->emailRepre = filter_var($emailRepre,FILTER_SANITIZE_EMAIL);

        }
        
        public function set_banco($banco){
            $banco = (isset($banco)?$banco:NULL);
            $this->banco = filter_var($banco,FILTER_SANITIZE_STRING);

        }
        
        public function set_cuentaC($cuentaC){
            $cuentaC = (isset($cuentaC)?$cuentaC:NULL);
            $this->cuentaC = filter_var($cuentaC,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_predio($predio){
            $predio = (isset($predio)?$predio:NULL);
            $this->predio = filter_var($predio,FILTER_SANITIZE_STRING);

        }
        
        public function set_potrero($potrero){
            $potrero = (isset($potrero)?$potrero:NULL);
            $this->potrero = filter_var($potrero,FILTER_SANITIZE_STRING);

        }
        
        public function set_rotacion_anno_1($rotacion_anno_1){
            $rotacion_anno_1 = (isset($rotacion_anno_1)?$rotacion_anno_1:NULL);
            $this->rotacion_anno_1 = filter_var($rotacion_anno_1,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_rotacion_desc_1($rotacion_desc_1){
            $rotacion_desc_1 = (isset($rotacion_desc_1)?$rotacion_desc_1:NULL);
            $this->rotacion_desc_1 = filter_var($rotacion_desc_1,FILTER_SANITIZE_STRING);

        }
        
        public function set_rotacion_anno_2($rotacion_anno_2){
            $rotacion_anno_2 = (isset($rotacion_anno_2)?$rotacion_anno_2:NULL);
            $this->rotacion_anno_2 = filter_var($rotacion_anno_2,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_rotacion_desc_2($rotacion_desc_2){
            $rotacion_desc_2 = (isset($rotacion_desc_2)?$rotacion_desc_2:NULL);
            $this->rotacion_desc_2 = filter_var($rotacion_desc_2,FILTER_SANITIZE_STRING);

        }
        
        public function set_rotacion_anno_3($rotacion_anno_3){
            $rotacion_anno_3 = (isset($rotacion_anno_3)?$rotacion_anno_3:NULL);
            $this->rotacion_anno_3 = filter_var($rotacion_anno_3,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_rotacion_desc_3($rotacion_desc_3){
            $rotacion_desc_3 = (isset($rotacion_desc_3)?$rotacion_desc_3:NULL);
            $this->rotacion_desc_3 = filter_var($rotacion_desc_3,FILTER_SANITIZE_STRING);

        }
        
        public function set_rotacion_anno_4($rotacion_anno_4){
            $rotacion_anno_4 = (isset($rotacion_anno_4)?$rotacion_anno_4:NULL);
            $this->rotacion_anno_4 = filter_var($rotacion_anno_4,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_rotacion_desc_4($rotacion_desc_4){
            $rotacion_desc_4 = (isset($rotacion_desc_4)?$rotacion_desc_4:NULL);
            $this->rotacion_desc_4 = filter_var($rotacion_desc_4,FILTER_SANITIZE_STRING);

        }
        
        public function set_norting($norting){
            $norting = (isset($norting)?$norting:NULL);
            $this->norting = filter_var($norting,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_easting($easting){
            $easting = (isset($easting)?$easting:NULL);
            $this->easting = filter_var($easting,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_radio($radio){
            $radio = (isset($radio)?$radio:NULL);
            $this->radio = filter_var($radio,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_suelo($suelo){
            $suelo = (isset($suelo)?$suelo:NULL);
            $this->suelo = filter_var($suelo,FILTER_SANITIZE_STRING);

        }
        
        public function set_riego($riego){
            $riego = (isset($riego)?$riego:NULL);
            $this->riego = filter_var($riego,FILTER_SANITIZE_STRING);

        }
        
        public function set_experiencia($experiencia){
            $experiencia = (isset($experiencia)?$experiencia:NULL);
            $this->experiencia = filter_var($experiencia,FILTER_SANITIZE_STRING);

        }
        
        public function set_tenencia($tenencia){
            $tenencia = (isset($tenencia)?$tenencia:NULL);
            $this->tenencia = filter_var($tenencia,FILTER_SANITIZE_STRING);

        }
        
        public function set_maquinaria($maquinaria){
            $maquinaria = (isset($maquinaria)?$maquinaria:NULL);
            $this->maquinaria = filter_var($maquinaria,FILTER_SANITIZE_STRING);

        }
        
        public function set_maleza($maleza){
            $maleza = (isset($maleza)?$maleza:NULL);
            $this->maleza = filter_var($maleza,FILTER_SANITIZE_STRING);

        }
        
        public function set_estado($estado){
            $estado = (isset($estado)?$estado:NULL);
            $this->estado = filter_var($estado,FILTER_SANITIZE_STRING);

        }
        
        public function set_comentario($comentario){
            $comentario = (isset($comentario)?$comentario:NULL);
            $this->comentario = filter_var($comentario,FILTER_SANITIZE_STRING);

        }
        
        public function set_fecha($fecha){
            $fecha = (isset($fecha)?$fecha:NULL);
            $this->fecha = filter_var($fecha,FILTER_SANITIZE_STRING);

        }
        
        public function set_obsProp($obsProp){
            $obsProp = (isset($obsProp)?$obsProp:NULL);
            $this->obsProp = filter_var($obsProp,FILTER_SANITIZE_STRING);

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

        /* Activas */

        public function traerDatosActivas(){
            try{
                /**********/
                /* Filtro */
                /**********/
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                }else{ 
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                }

                if($this->fieldman != ""){ $filtro .= " AND (U.nombre LIKE '%$this->fieldman%' OR U.apellido_p LIKE '%$this->fieldman%' OR U.apellido_m LIKE '%$this->fieldman%')"; }
                if($this->temporada != ""){ $filtro .= " AND T.nombre LIKE '%$this->temporada%'"; }
                if($this->especie != ""){ $filtro .= " AND E.nombre LIKE '%$this->especie%'"; }
                if($this->agricultor != ""){ $filtro .= " AND  A.razon_social LIKE '%$this->agricultor%'"; }
                if($this->rut != ""){ $filtro .= " AND A.rut LIKE '%$this->rut%'"; }
                if($this->telefono != ""){ $filtro .= " AND A.telefono LIKE '%$this->telefono%'"; }
                if($this->administrador != ""){ $filtro .= " AND L.nombre_ac LIKE '%$this->administrador%'"; }
                if($this->telefonoA != ""){ $filtro .= " AND L.telefono_ac LIKE '%$this->telefonoA%'"; }
                if($this->oferta != ""){ $filtro .= " AND F.oferta_de_negocio LIKE '%$this->oferta%'"; }
                if($this->localidad != ""){ $filtro .= " AND F.localidad LIKE '%$this->localidad%'"; }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE '%$this->region%'"; }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE '%$this->comuna%'"; }
                if($this->haDisponibles != ""){ $filtro .= " AND F.ha_disponibles LIKE '%$this->haDisponibles%'"; }
                if($this->direccion != ""){ $filtro .= " AND A.direccion LIKE '%$this->direccion%'"; }
                if($this->repre != ""){ $filtro .= " AND A.rep_legal LIKE '%$this->repre%'"; }
                if($this->rutRepre != ""){ $filtro .= " AND A.rut_rl LIKE '%$this->rutRepre%'"; }
                if($this->telefonoRepre != ""){ $filtro .= " AND A.telefono_rl LIKE '%$this->telefonoRepre%'"; }
                if($this->emailRepre != ""){ $filtro .= " AND A.email_rl LIKE '%$this->emailRepre%'"; }
                if($this->banco != ""){ $filtro .= " AND A.banco LIKE '%$this->banco%'"; }
                if($this->cuentaC != ""){ $filtro .= " AND A.cuenta_corriente LIKE '%$this->cuentaC%'"; }
                if($this->predio != ""){ $filtro .= " AND P.nombre LIKE '%$this->predio%'"; }
                if($this->potrero != ""){ $filtro .= " AND L.nombre LIKE '%$this->potrero%'"; }
                if($this->rotacion_desc_1 != ""){ $filtro .= " AND H.descripcion LIKE '%$this->rotacion_desc_1%'"; }
                if($this->norting != ""){ $filtro .= " AND L.coo_utm_ampros LIKE '%$this->norting%'"; }
                if($this->easting != ""){ $filtro .= " AND L.coo_utm_ampros LIKE '%$this->easting%'"; }
                if($this->radio != ""){ $filtro .= " AND L.radio LIKE '%$this->radio%'"; }
                if($this->suelo != ""){ $filtro .= " AND TS.descripcion LIKE '%$this->suelo%'"; }
                if($this->riego != ""){ $filtro .= " AND TR.descripcion LIKE '%$this->riego%'"; }
                if($this->experiencia != ""){ $filtro .= " AND F.experiencia LIKE '%$this->experiencia%'"; }
                if($this->tenencia != ""){ $filtro .= " AND TT.descripcion LIKE '%$this->tenencia%'"; }
                if($this->maquinaria != ""){ $filtro .= " AND TM.descripcion LIKE '%$this->maquinaria%'"; }
                if($this->maleza != ""){ $filtro .= " AND F.maleza LIKE '%$this->maleza%'"; }
                if($this->estado != ""){ $filtro .= " AND F.estado_general LIKE '%$this->estado%'"; }
                if($this->comentario != ""){ $filtro .= " AND F.obs LIKE '%$this->comentario%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY fielbook ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY fielbook DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY fieldman ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY fieldman DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY T.nombre ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY T.nombre DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY E.nombre ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY A.razon_social ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY A.razon_social DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY A.rut ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY A.rut DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY A.telefono ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY A.telefono DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY L.nombre_ac ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY L.nombre_ac DESC";
                    break;
                    case 17:
                        $orden = "ORDER BY L.telefono_ac ASC";
                    break;
                    case 18:
                        $orden = "ORDER BY L.telefono_ac DESC";
                    break;
                    case 19:
                        $orden = "ORDER BY A.oferta_de_negocio ASC";
                    break;
                    case 20:
                        $orden = "ORDER BY A.oferta_de_negocio DESC";
                    break;
                    case 21:
                        $orden = "ORDER BY A.localidad ASC";
                    break;
                    case 22:
                        $orden = "ORDER BY A.localidad DESC";
                    break;
                    case 23:
                        $orden = "ORDER BY R.nombre ASC";
                    break;
                    case 24:
                        $orden = "ORDER BY R.nombre DESC";
                    break;
                    case 25:
                        $orden = "ORDER BY C.nombre ASC";
                    break;
                    case 26:
                        $orden = "ORDER BY C.nombre DESC";
                    break;
                    case 27:
                        $orden = "ORDER BY F.ha_disponible ASC";
                    break;
                    case 28:
                        $orden = "ORDER BY F.ha_disponible DESC";
                    break;
                    case 29:
                        $orden = "ORDER BY A.direccion ASC";
                    break;
                    case 30:
                        $orden = "ORDER BY A.direccion DESC";
                    break;
                    case 31:
                        $orden = "ORDER BY A.rep_legal ASC";
                    break;
                    case 32:
                        $orden = "ORDER BY A.rep_legal DESC";
                    break;
                    case 33:
                        $orden = "ORDER BY A.rut_rl ASC";
                    break;
                    case 34:
                        $orden = "ORDER BY A.rut_rl DESC";
                    break;
                    case 35:
                        $orden = "ORDER BY A.telefono_rl ASC";
                    break;
                    case 36:
                        $orden = "ORDER BY A.telefono_rl DESC";
                    break;
                    case 37:
                        $orden = "ORDER BY A.email_rl ASC";
                    break;
                    case 38:
                        $orden = "ORDER BY A.email_rl DESC";
                    break;
                    case 39:
                        $orden = "ORDER BY A.banco ASC";
                    break;
                    case 40:
                        $orden = "ORDER BY A.banco DESC";
                    break;
                    case 41:
                        $orden = "ORDER BY A.cuenta_corriente ASC";
                    break;
                    case 42:
                        $orden = "ORDER BY A.cuenta_corriente DESC";
                    break;
                    case 43:
                        $orden = "ORDER BY P.nombre ASC";
                    break;
                    case 44:
                        $orden = "ORDER BY P.nombre DESC";
                    break;
                    case 45:
                        $orden = "ORDER BY L.nombre ASC";
                    break;
                    case 46:
                        $orden = "ORDER BY L.nombre DESC";
                    break;
                    /* case 49:
                        $orden = "ORDER BY F.norting ASC";
                    break;
                    case 50:
                        $orden = "ORDER BY F.norting DESC";
                    break;
                    case 51:
                        $orden = "ORDER BY F.easting ASC";
                    break;
                    case 52:
                        $orden = "ORDER BY F.easting DESC";
                    break; */
                    case 53:
                        $orden = "ORDER BY F.radio ASC";
                    break;
                    case 54:
                        $orden = "ORDER BY F.radio DESC";
                    break;
                    case 55:
                        $orden = "ORDER BY TS.descripcion ASC";
                    break;
                    case 56:
                        $orden = "ORDER BY TS.descripcion DESC";
                    break;
                    case 57:
                        $orden = "ORDER BY TR.descripcion ASC";
                    break;
                    case 58:
                        $orden = "ORDER BY TR.descripcion DESC";
                    break;
                    case 59:
                        $orden = "ORDER BY F.experiencia ASC";
                    break;
                    case 60:
                        $orden = "ORDER BY F.experiencia DESC";
                    break;
                    case 61:
                        $orden = "ORDER BY TT.descripcion ASC";
                    break;
                    case 62:
                        $orden = "ORDER BY TT.descripcion DESC";
                    break;
                    case 63:
                        $orden = "ORDER BY TM.maquinaria ASC";
                    break;
                    case 64:
                        $orden = "ORDER BY TM.maquinaria DESC";
                    break;
                    case 65:
                        $orden = "ORDER BY F.maleza ASC";
                    break;
                    case 66:
                        $orden = "ORDER BY F.maleza DESC";
                    break;
                    case 67:
                        $orden = "ORDER BY F.estado_general ASC";
                    break;
                    case 68:
                        $orden = "ORDER BY F.estado_general DESC";
                    break;
                    case 69:
                        $orden = "ORDER BY F.obs ASC";
                    break;
                    case 70:
                        $orden = "ORDER BY F.obs DESC";
                    break;
                    default:
                        $orden = "ORDER BY fieldman DESC";
                    break;
                }

                /*******/
                /* SQL */

                /*******/

                $conexion = new Conectar();
                $sql = "SELECT (SELECT id_ac FROM anexo_contrato INNER JOIN visita USING(id_ac) WHERE anexo_contrato.id_ficha = F.id_ficha GROUP BY id_ac LIMIT 1) AS fielbook, F.id_ficha, CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS fieldman, T.nombre AS temporada, E.nombre AS especie, A.rut, A.razon_social, A.telefono, L.nombre_ac, L.telefono_ac, F.oferta_de_negocio, F.localidad, R.nombre AS region , C.nombre AS comuna, F.ha_disponibles, A.direccion, A.rep_legal, A.rut_rl, A.telefono_rl, A.email_rl, A.banco, A.cuenta_corriente, P.nombre AS predio, L.nombre AS potrero, group_concat(H.anno,' => ',H.descripcion) AS rotacion, L.coo_utm_ampros, L.radio, TR.descripcion AS riego, TS.descripcion AS suelo, F.experiencia, TT.descripcion AS tenencia, TM.descripcion AS maquinaria, F.maleza, F.estado_general, F.obs 
                        FROM ficha F 
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN especie E ON E.id_esp = F.id_esp 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN region R ON R.id_region = F.id_region 
                        INNER JOIN comuna C ON C.id_comuna = F.id_comuna 
                        LEFT JOIN historial_predio H ON H.id_ficha = F.id_ficha 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        INNER JOIN predio P ON P.id_pred = F.id_pred 
                        INNER JOIN lote L ON L.id_lote = F.id_lote 
                        INNER JOIN tipo_suelo TS ON TS.id_tipo_suelo = F.id_tipo_suelo 
                        INNER JOIN tipo_riego TR ON TR.id_tipo_riego = F.id_tipo_riego 
                        INNER JOIN tipo_tenencia_terreno TT ON TT.id_tipo_tenencia_terreno = F.id_tipo_tenencia_terreno 
                        INNER JOIN tipo_tenencia_maquinaria TM ON TM.id_tipo_tenencia_maquinaria = F.id_tipo_tenencia_maquinaria 
                        $filtro GROUP BY F.id_ficha $orden LIMIT $this->desde,10";

                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);

                }else{
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);

                }
                
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS ACTIVAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function totalDatosActivas(){
            try{
                /**********/
                /* Filtro */
                /**********/
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                }else{ 
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                }

                if($this->fieldman != ""){ $filtro .= " AND (U.nombre LIKE '%$this->fieldman%' OR U.apellido_p LIKE '%$this->fieldman%' OR U.apellido_m LIKE '%$this->fieldman%')"; }
                if($this->temporada != ""){ $filtro .= " AND T.nombre LIKE '%$this->temporada%'"; }
                if($this->especie != ""){ $filtro .= " AND E.nombre LIKE '%$this->especie%'"; }
                if($this->agricultor != ""){ $filtro .= " AND  A.razon_social LIKE '%$this->agricultor%'"; }
                if($this->rut != ""){ $filtro .= " AND A.rut LIKE '%$this->rut%'"; }
                if($this->telefono != ""){ $filtro .= " AND A.telefono LIKE '%$this->telefono%'"; }
                if($this->administrador != ""){ $filtro .= " AND L.nombre_ac LIKE '%$this->administrador%'"; }
                if($this->telefonoA != ""){ $filtro .= " AND L.telefono_ac LIKE '%$this->telefonoA%'"; }
                if($this->oferta != ""){ $filtro .= " AND F.oferta_de_negocio LIKE '%$this->oferta%'"; }
                if($this->localidad != ""){ $filtro .= " AND F.localidad LIKE '%$this->localidad%'"; }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE '%$this->region%'"; }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE '%$this->comuna%'"; }
                if($this->haDisponibles != ""){ $filtro .= " AND F.ha_disponibles LIKE '%$this->haDisponibles%'"; }
                if($this->direccion != ""){ $filtro .= " AND A.direccion LIKE '%$this->direccion%'"; }
                if($this->repre != ""){ $filtro .= " AND A.rep_legal LIKE '%$this->repre%'"; }
                if($this->rutRepre != ""){ $filtro .= " AND A.rut_rl LIKE '%$this->rutRepre%'"; }
                if($this->telefonoRepre != ""){ $filtro .= " AND A.telefono_rl LIKE '%$this->telefonoRepre%'"; }
                if($this->emailRepre != ""){ $filtro .= " AND A.email_rl LIKE '%$this->emailRepre%'"; }
                if($this->banco != ""){ $filtro .= " AND A.banco LIKE '%$this->banco%'"; }
                if($this->cuentaC != ""){ $filtro .= " AND A.cuenta_corriente LIKE '%$this->cuentaC%'"; }
                if($this->predio != ""){ $filtro .= " AND P.nombre LIKE '%$this->predio%'"; }
                if($this->potrero != ""){ $filtro .= " AND L.nombre LIKE '%$this->potrero%'"; }
                if($this->rotacion_desc_1 != ""){ $filtro .= " AND H.descripcion LIKE '%$this->rotacion_desc_1%'"; }
                if($this->norting != ""){ $filtro .= " AND L.coo_utm_ampros LIKE '%$this->norting%'"; }
                if($this->easting != ""){ $filtro .= " AND L.coo_utm_ampros LIKE '%$this->easting%'"; }
                if($this->radio != ""){ $filtro .= " AND L.radio LIKE '%$this->radio%'"; }
                if($this->suelo != ""){ $filtro .= " AND TS.descripcion LIKE '%$this->suelo%'"; }
                if($this->riego != ""){ $filtro .= " AND TR.descripcion LIKE '%$this->riego%'"; }
                if($this->experiencia != ""){ $filtro .= " AND F.experiencia LIKE '%$this->experiencia%'"; }
                if($this->tenencia != ""){ $filtro .= " AND TT.descripcion LIKE '%$this->tenencia%'"; }
                if($this->maquinaria != ""){ $filtro .= " AND TM.descripcion LIKE '%$this->maquinaria%'"; }
                if($this->maleza != ""){ $filtro .= " AND F.maleza LIKE '%$this->maleza%'"; }
                if($this->estado != ""){ $filtro .= " AND F.estado_general LIKE '%$this->estado%'"; }
                if($this->comentario != ""){ $filtro .= " AND F.obs LIKE '%$this->comentario%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT F.id_ficha FROM ficha F  
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN especie E ON E.id_esp = F.id_esp 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN region R ON R.id_region = F.id_region 
                        INNER JOIN comuna C ON C.id_comuna = F.id_comuna 
                        LEFT JOIN historial_predio H ON H.id_ficha = F.id_ficha 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        INNER JOIN predio P ON P.id_pred = F.id_pred 
                        INNER JOIN lote L ON L.id_lote = F.id_lote 
                        INNER JOIN tipo_suelo TS ON TS.id_tipo_suelo = F.id_tipo_suelo 
                        INNER JOIN tipo_riego TR ON TR.id_tipo_riego = F.id_tipo_riego 
                        INNER JOIN tipo_tenencia_terreno TT ON TT.id_tipo_tenencia_terreno = F.id_tipo_tenencia_terreno 
                        INNER JOIN tipo_tenencia_maquinaria TM ON TM.id_tipo_tenencia_maquinaria = F.id_tipo_tenencia_maquinaria 
                        $filtro GROUP BY F.id_ficha";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);

                }else{
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS ACTIVAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function traerInfoActiva(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT concat(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS supervisor, F.id_comuna, T.nombre AS temporada, A.razon_social AS agricultor, F.localidad, P.nombre AS predio, L.nombre AS lote , F.ha_disponibles, E.nombre AS especie, TT.descripcion AS tenencia, TM.descripcion AS maquinaria, F.experiencia, F.oferta_de_negocio, TS.descripcion AS suelo, TR.descripcion AS riego, F.maleza, F.estado_general, F.obs 
                        FROM ficha F
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        INNER JOIN predio P ON P.id_pred = F.id_pred 
                        INNER JOIN lote L ON L.id_lote = F.id_lote
                        INNER JOIN especie E ON E.id_esp = F.id_esp  
                        INNER JOIN tipo_suelo TS ON TS.id_tipo_suelo = F.id_tipo_suelo 
                        INNER JOIN tipo_riego TR ON TR.id_tipo_riego = F.id_tipo_riego 
                        INNER JOIN tipo_tenencia_terreno TT ON TT.id_tipo_tenencia_terreno = F.id_tipo_tenencia_terreno 
                        INNER JOIN tipo_tenencia_maquinaria TM ON TM.id_tipo_tenencia_maquinaria = F.id_tipo_tenencia_maquinaria 
                        WHERE F.id_ficha = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO ACTIVA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function editarFichaA(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $sql = "UPDATE ficha SET localidad = ?, id_pred = ?, id_lote = ?, ha_disponibles = ?, id_esp = ?, tipo_tenencia = ?, maquinaria = ?, experiencia = ?, oferta_de_negocio = ?, tipo_suelo = ?, tipo_riego = ?, maleza = ?, estado_general = ?, obs = ? WHERE id_ficha = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->localidad, PDO::PARAM_STR);
                $consulta->bindValue("2",$this->id_predio, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_lote, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->haDisponibles, PDO::PARAM_STR);
                $consulta->bindValue("5",$this->especie, PDO::PARAM_INT);
                $consulta->bindValue("6",$this->tenencia, PDO::PARAM_STR);
                $consulta->bindValue("7",$this->maquinaria, PDO::PARAM_STR);
                $consulta->bindValue("8",$this->experiencia, PDO::PARAM_STR);
                $consulta->bindValue("9",$this->oferta, PDO::PARAM_STR);
                $consulta->bindValue("10",$this->suelo, PDO::PARAM_STR);
                $consulta->bindValue("11",$this->riego, PDO::PARAM_STR);
                $consulta->bindValue("12",$this->maleza, PDO::PARAM_STR);
                $consulta->bindValue("13",$this->estado, PDO::PARAM_STR); 
                $consulta->bindValue("14",$this->comentario, PDO::PARAM_STR);
                $consulta->bindValue("15",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                $sql = "SELECT * FROM ficha WHERE localidad = ? AND id_pred = ? AND id_lote = ? AND ha_disponibles = ? AND id_esp = ? AND tipo_tenencia = ? AND maquinaria = ? AND experiencia = ? AND oferta_de_negocio = ? AND tipo_suelo = ? AND tipo_riego = ? AND maleza = ? AND estado_general = ? AND obs = ? AND id_ficha = ?";
                $consulta1 = $conexion->prepare($sql);
                $consulta1->bindValue("1",$this->localidad, PDO::PARAM_STR);
                $consulta1->bindValue("2",$this->id_predio, PDO::PARAM_INT);
                $consulta1->bindValue("3",$this->id_lote, PDO::PARAM_INT);
                $consulta1->bindValue("4",$this->haDisponibles, PDO::PARAM_STR);
                $consulta1->bindValue("5",$this->especie, PDO::PARAM_INT);
                $consulta1->bindValue("6",$this->tenencia, PDO::PARAM_STR);
                $consulta1->bindValue("7",$this->maquinaria, PDO::PARAM_STR);
                $consulta1->bindValue("8",$this->experiencia, PDO::PARAM_STR);
                $consulta1->bindValue("9",$this->oferta, PDO::PARAM_STR);
                $consulta1->bindValue("10",$this->suelo, PDO::PARAM_STR);
                $consulta1->bindValue("11",$this->riego, PDO::PARAM_STR);
                $consulta1->bindValue("12",$this->maleza, PDO::PARAM_STR);
                $consulta1->bindValue("13",$this->estado, PDO::PARAM_STR); 
                $consulta1->bindValue("14",$this->comentario, PDO::PARAM_STR);
                $consulta1->bindValue("15",$this->id, PDO::PARAM_INT);
                $consulta1->execute();

                $cont = 0;
                $contS = 0;
                if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){
                    $cont++;
                    for($i = 0; $i < 4; $i++){
                        $sql = "UPDATE historial_predio SET descripcion = ? WHERE anno = ? AND id_ficha = ?";
                        $consulta = $conexion->prepare($sql);
                        switch($i){
                            case 0:
                                $consulta->bindValue("1",$this->rotacion_desc_1, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_1, PDO::PARAM_INT);
                            break;
                            case 1:
                                $consulta->bindValue("1",$this->rotacion_desc_2, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_2, PDO::PARAM_INT);
                            break;
                            case 2:
                                $consulta->bindValue("1",$this->rotacion_desc_3, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_3, PDO::PARAM_INT);
                            break;
                            case 3:
                                $consulta->bindValue("1",$this->rotacion_desc_4, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_4, PDO::PARAM_INT);
                            break;

                        }
                        $consulta->bindValue("3",$this->id, PDO::PARAM_INT);
                        $consulta->execute();
                    
                        if($consulta->rowCount() > 0 ){
                            $cont++;

                        }

                    }

                    $contS++;
                    for($i = 0; $i < 4; $i++){
                        $sql = "SELECT * FROM historial_predio WHERE descripcion = ? AND anno = ? AND id_ficha = ?";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                        switch($i){
                            case 0:
                                $consulta->bindValue("1",$this->rotacion_desc_1, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_1, PDO::PARAM_INT);
                            break;
                            case 1:
                                $consulta->bindValue("1",$this->rotacion_desc_2, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_2, PDO::PARAM_INT);
                            break;
                            case 2:
                                $consulta->bindValue("1",$this->rotacion_desc_3, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_3, PDO::PARAM_INT);
                            break;
                            case 3:
                                $consulta->bindValue("1",$this->rotacion_desc_4, PDO::PARAM_STR);
                                $consulta->bindValue("2",$this->rotacion_anno_4, PDO::PARAM_INT);
                            break;

                        }
                        $consulta->bindValue("3",$this->id, PDO::PARAM_INT);
                        $consulta->execute();
                        
                        if($consulta->rowCount() > 0 ){
                            $contS++;

                        }

                    }

                    if($cont == 5 && $contS == 5){
                        $respuesta = "1";

                    }else{
                        $respuesta = "3";

                    }

                }else{
                    $respuesta = "3";

                }
                
                return $respuesta;
        
            }catch(PDOException $e){
                echo "[EDITAR FICHA ACTIVA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        /* Fin activas */

        public function traerRotacion(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT anno, descripcion FROM historial_predio WHERE id_ficha = ? ORDER BY id_his_pre DESC LIMIT 4";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER ROTACION] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        /* Provisorias */

        public function traerDatosProvisorias(){
            try{
                /**********/
                /* Filtro */
                /**********/
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 1 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                }else{ 
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 1 AND F.id_tempo = ? ";

                }

                if($this->comentario != ""){ $filtro .= " AND F.obs LIKE '%$this->comentario%'"; }
                if($this->fieldman != ""){ $filtro .= " AND (U.nombre LIKE '%$this->fieldman%' OR U.apellido_p LIKE '%$this->fieldman%' OR U.apellido_m LIKE '%$this->fieldman%')"; }
                if($this->temporada != ""){ $filtro .= " AND T.nombre LIKE '%$this->temporada%'"; }
                if($this->rut != ""){ $filtro .= " AND A.rut LIKE '%$this->rut%'"; }
                if($this->agricultor != ""){ $filtro .= " AND  A.razon_social LIKE '%$this->agricultor%'"; }
                if($this->telefono != ""){ $filtro .= " AND A.telefono LIKE '%$this->telefono%'"; }
                if($this->oferta != ""){ $filtro .= " AND F.oferta_de_negocio LIKE '%$this->oferta%'"; }
                if($this->localidad != ""){ $filtro .= " AND F.localidad LIKE '%$this->localidad%'"; }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE '%$this->region%'"; }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE '%$this->comuna%'"; }
                if($this->haDisponibles != ""){ $filtro .= " AND F.ha_disponibles LIKE '%$this->haDisponibles%'"; }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY F.obs ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY F.obs DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY fieldman ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY fieldman DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY temporada ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY temporada DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY A.rut ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY A.rut DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY A.razon_social ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY A.razon_social DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY A.telefono ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY A.telefono DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY F.oferta_de_negocio ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY F.oferta_de_negocio DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY F.localidad ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY F.localidad DESC";
                    break;
                    case 17:
                        $orden = "ORDER BY region ASC";
                    break;
                    case 18:
                        $orden = "ORDER BY region DESC";
                    break;
                    case 19:
                        $orden = "ORDER BY comuna ASC";
                    break;
                    case 20:
                        $orden = "ORDER BY comuna DESC";
                    break;
                    case 21:
                        $orden = "ORDER BY F.ha_disponibles ASC";
                    break;
                    case 22:
                        $orden = "ORDER BY F.ha_disponibles DESC";
                    break;
                    default:
                        $orden = "ORDER BY F.id_ficha ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT F.id_ficha, F.obs, CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS fieldman, T.nombre AS temporada, A.rut, A.razon_social, A.telefono, F.oferta_de_negocio, F.localidad, R.nombre AS region , C.nombre AS comuna, F.ha_disponibles FROM ficha F 
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN region R ON R.id_region = F.id_region 
                        INNER JOIN comuna C ON C.id_comuna = F.id_comuna 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        $filtro GROUP BY F.id_ficha $orden LIMIT $this->desde,10";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);

                if($_SESSION["tipo_curimapu"] == 3){
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);

                }else{
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER DATOS PROVISORIAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function totalDatosProvisorias(){
            try{
                /**********/
                /* Filtro */
                /**********/
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 1 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                }else{ 
                    $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 1 AND F.id_tempo = ? ";

                }

                if($this->comentario != ""){ $filtro .= " AND F.obs LIKE '%$this->comentario%'"; }
                if($this->fieldman != ""){ $filtro .= " AND (U.nombre LIKE '%$this->fieldman%' OR U.apellido_p LIKE '%$this->fieldman%' OR U.apellido_m LIKE '%$this->fieldman%')"; }
                if($this->temporada != ""){ $filtro .= " AND T.nombre LIKE '%$this->temporada%'"; }
                if($this->rut != ""){ $filtro .= " AND A.rut LIKE '%$this->rut%'"; }
                if($this->agricultor != ""){ $filtro .= " AND  A.razon_social LIKE '%$this->agricultor%'"; }
                if($this->telefono != ""){ $filtro .= " AND A.telefono LIKE '%$this->telefono%'"; }
                if($this->oferta != ""){ $filtro .= " AND F.oferta_de_negocio LIKE '%$this->oferta%'"; }
                if($this->localidad != ""){ $filtro .= " AND F.localidad LIKE '%$this->localidad%'"; }
                if($this->region != ""){ $filtro .= " AND R.nombre LIKE '%$this->region%'"; }
                if($this->comuna != ""){ $filtro .= " AND C.nombre LIKE '%$this->comuna%'"; }
                if($this->haDisponibles != ""){ $filtro .= " AND F.ha_disponibles LIKE '%$this->haDisponibles%'"; }

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT count(*) AS Total FROM ficha F
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN region R ON R.id_region = F.id_region 
                        INNER JOIN comuna C ON C.id_comuna = F.id_comuna 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        $filtro GROUP BY F.id_ficha";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                
                if($_SESSION["tipo_curimapu"] == 3){
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);

                }else{
                    $consulta->bindValue("1",$this->id_tempo, PDO::PARAM_STR);

                }

                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data(array("Total" => $consulta->rowCount()));

                }
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS PROVISORIAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function crearFicha(){
            $conexion = new Conectar();
            $conexion = $conexion->conexion();
            $rollback = false;

            $conexion->beginTransaction();

            $fechaHora = date("Y-m-d H:i:s");

            try{

                $sql = "INSERT INTO ficha (estado_sincro, id_est_fic, id_usuario, id_tempo, id_agric, id_region, id_comuna, localidad, ha_disponibles, oferta_de_negocio, obs, user_crea, fecha_crea) VALUES ('1', '1', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_supervisor, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_agricultor, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->id_region, PDO::PARAM_INT);
                $consulta->bindValue("5",$this->id_comuna, PDO::PARAM_INT);
                $consulta->bindValue("6",$this->localidad, PDO::PARAM_STR);
                $consulta->bindValue("7",$this->haDisponibles, PDO::PARAM_STR);
                $consulta->bindValue("8",$this->oferta, PDO::PARAM_STR);
                $consulta->bindValue("9",$this->comentario, PDO::PARAM_STR);
                $consulta->bindValue("10",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                $consulta->bindValue("11",$fechaHora, PDO::PARAM_STR);
                $consulta->execute();

                
                if($consulta->rowCount() > 0 ){

                    $sql = "SELECT MAX(id_ficha) as max_id FROM ficha WHERE estado_sincro = '1' AND user_crea = ? AND fecha_crea = ? LIMIT 1 ;";
                    $consulta1 = $conexion->prepare($sql);
                    $consulta1->bindValue("1",$_SESSION["rut_curimapu"], PDO::PARAM_INT);
                    $consulta1->bindValue("2",$fechaHora, PDO::PARAM_STR);
                    $consulta1->execute();
                    if($consulta1->rowCount() > 0){
                        $regg = $consulta1->fetchAll(PDO::FETCH_ASSOC);
                        $idFicha = $regg[0]["max_id"];

                        $value = $this->imagen;

                        foreach($value as $imagenes){
                            $nombreImagenOrignal = $imagenes["name"];
                            list($nn, $dot) = explode(".",$nombreImagenOrignal);

                            list($fecha, $hora) = explode(" ", $fechaHora);

                            $fechaHoraNombre = str_replace(" ", $fechaHora);
                            $fechaHoraNombre = str_replace("-", $fechaHoraNombre);
                            $fechaHoraNombre = str_replace(":", $fechaHoraNombre);



                            $nombreArchivoAparte = "FW".$idFicha."_0_".uniqid()."_0_".$fechaHoraNombre."_0.".$dot;
                            $ruta_img = "../../../../curimapu_docum/img_android/$nombreArchivoAparte";
    
                            copy($imagenes["tmp_name"], $ruta_img);

                            if(file_exists($ruta_img)){

                                $ins = "INSERT INTO fotos (id_ficha, tipo, fecha, hora, fecha_hora, nombre_foto, ruta_foto, estado_sincro) VALUES (?, ?, ?, ?, ?, ?, ?,?);";
                                $cons = $conexion->prepare($ins);
                                $cons->bindValue("1",$idFicha, PDO::PARAM_INT);
                                $cons->bindValue("2","F", PDO::PARAM_STR);
                                $cons->bindValue("3",$fecha, PDO::PARAM_STR);
                                $cons->bindValue("4",$hora, PDO::PARAM_STR);
                                $cons->bindValue("5",$fechaHora, PDO::PARAM_STR);
                                $cons->bindValue("6",$imagenes["name"], PDO::PARAM_STR);
                                $cons->bindValue("7",$ruta_img, PDO::PARAM_STR);
                                $cons->bindValue("8","1", PDO::PARAM_STR);
                                $cons->execute();
                            }
                        }   
                    }
                }else{
                    $rollback = true;
                }

                if($rollback){
                    $conexion->rollback();
                    $respuesta = "3";
                    
                }else{
                    $conexion->commit();
                    $respuesta = "1";
                }
                
                return $respuesta;

            }catch(PDOException $e){
                echo "[CREAR FICHA PROVISORIA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function traerInfoProvisoria(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT id_usuario, id_tempo, id_agric, id_region, id_comuna, localidad, ha_disponibles, oferta_de_negocio, obs FROM ficha WHERE id_ficha = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO PROVISORIAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function editarFicha(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            $rollback = false;
            $conexion->beginTransaction();
            $fechaHora = date("Y-m-d H:i:s");
            try{

                
                $sql = "UPDATE ficha SET id_usuario = ?, id_tempo = ?, id_agric = ?, id_region = ?, id_comuna = ?, localidad = ?, ha_disponibles = ?, oferta_de_negocio = ?, obs = ?, user_mod = ?, fecha_mod = ? WHERE id_ficha = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_supervisor, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_agricultor, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->id_region, PDO::PARAM_INT);
                $consulta->bindValue("5",$this->id_comuna, PDO::PARAM_INT);
                $consulta->bindValue("6",$this->localidad, PDO::PARAM_STR);
                $consulta->bindValue("7",$this->haDisponibles, PDO::PARAM_STR);
                $consulta->bindValue("8",$this->oferta, PDO::PARAM_STR);
                $consulta->bindValue("9",$this->comentario, PDO::PARAM_STR);
                $consulta->bindValue("10",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                $consulta->bindValue("11",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                $consulta->bindValue("12",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                if($consulta->rowCount() > 0 ){

                    $value = $this->imagen;

                    foreach($value as $imagenes){
                        $nombreImagenOrignal = $imagenes["name"];
                        list($nn, $dot) = explode(".",$nombreImagenOrignal);

                        list($fecha, $hora) = explode(" ", $fechaHora);

                        $fechaHoraNombre = str_replace(" ", $fechaHora);
                        $fechaHoraNombre = str_replace("-", $fechaHoraNombre);
                        $fechaHoraNombre = str_replace(":", $fechaHoraNombre);



                        $nombreArchivoAparte = "FW".$this->id."_0_".uniqid()."_0_".$fechaHoraNombre."_0.".$dot;
                        $ruta_img = "../../../../curimapu_docum/img_android/$nombreArchivoAparte";

                        copy($imagenes["tmp_name"], $ruta_img);

                        if(file_exists($ruta_img)){

                            $ins = "INSERT INTO fotos (id_ficha, tipo, fecha, hora, fecha_hora, nombre_foto, ruta_foto, estado_sincro) VALUES (?, ?, ?, ?, ?, ?, ?,?);";
                            $cons = $conexion->prepare($ins);
                            $cons->bindValue("1",$this->id, PDO::PARAM_INT);
                            $cons->bindValue("2","F", PDO::PARAM_STR);
                            $cons->bindValue("3",$fecha, PDO::PARAM_STR);
                            $cons->bindValue("4",$hora, PDO::PARAM_STR);
                            $cons->bindValue("5",$fechaHora, PDO::PARAM_STR);
                            $cons->bindValue("6",$imagenes["name"], PDO::PARAM_STR);
                            $cons->bindValue("7",$ruta_img, PDO::PARAM_STR);
                            $cons->bindValue("8","1", PDO::PARAM_STR);
                            $cons->execute();
                        }
                    } 

                }else{
                    $rollback = true;
                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[EDITAR FICHA PROVISORIA] -> ha ocurrido un error ".$e->getMessage();

            }
                
                if($rollback){
                    $conexion->rollback();
                    $respuesta = "4";
                }else{
                    $conexion->commit();
                    $respuesta = "1";
                }
                
                return $respuesta;

    
            $conexion = NULL;

        }

        public function traerInfoActivar(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT F.id_agric, F.id_usuario, F.id_tempo, F.oferta_de_negocio, F.ha_disponibles, F.localidad, F.id_region, F.id_comuna, F.obs 
                        FROM ficha F
                        INNER JOIN usuarios U ON U.id_usuario = F.id_usuario 
                        INNER JOIN agricultor A ON A.id_agric = F.id_agric 
                        INNER JOIN temporada T ON T.id_tempo = F.id_tempo 
                        WHERE F.id_ficha = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO ACTIVAR] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
        
        public function activarFicha(){

            $conexion = new Conectar();
            $conexion = $conexion->conexion();
            $rollback = false;
            $conexion->beginTransaction();
            $fechaHora = date("Y-m-d H:i:s");
            try{

                $sql = "UPDATE ficha SET id_est_fic = '2', id_usuario = ?, id_tempo = ?, id_agric = ?, oferta_de_negocio = ?, id_esp = ?, ha_disponibles = ?, id_region = ?, id_comuna = ?, id_pred = ?, id_lote = ?, localidad = ?, id_tipo_suelo = ?, id_tipo_riego = ?, experiencia = ?, id_tipo_tenencia_maquinaria = ?, id_tipo_tenencia_terreno = ?, maleza = ?, estado_general = ?, fecha_limite_s = ?, obs = ?, obs_prop = ?, user_mod = ?, fecha_mod = ? WHERE id_ficha = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_supervisor, PDO::PARAM_INT);
                $consulta->bindValue("2",$this->id_tempo, PDO::PARAM_INT);
                $consulta->bindValue("3",$this->id_agricultor, PDO::PARAM_INT);
                $consulta->bindValue("4",$this->oferta, PDO::PARAM_STR);
                $consulta->bindValue("5",$this->id_especie, PDO::PARAM_INT);
                $consulta->bindValue("6",$this->haDisponibles, PDO::PARAM_STR);
                $consulta->bindValue("7",$this->id_region, PDO::PARAM_INT);
                $consulta->bindValue("8",$this->id_comuna, PDO::PARAM_INT);
                $consulta->bindValue("9",$this->id_predio, PDO::PARAM_INT);
                $consulta->bindValue("10",$this->id_lote, PDO::PARAM_INT);
                $consulta->bindValue("11",$this->localidad, PDO::PARAM_STR);
                $consulta->bindValue("12",$this->id_suelo, PDO::PARAM_INT);
                $consulta->bindValue("13",$this->id_riego, PDO::PARAM_INT);
                $consulta->bindValue("14",$this->id_experiencia, PDO::PARAM_STR);
                $consulta->bindValue("15",$this->id_tenencia, PDO::PARAM_INT);
                $consulta->bindValue("16",$this->id_maquinaria, PDO::PARAM_INT);
                $consulta->bindValue("17",$this->maleza, PDO::PARAM_STR);
                $consulta->bindValue("18",$this->estado, PDO::PARAM_STR);
                $consulta->bindValue("19",$this->fecha, PDO::PARAM_STR);
                $consulta->bindValue("20",$this->comentario, PDO::PARAM_STR);
                $consulta->bindValue("21",$this->obsProp, PDO::PARAM_STR);
                $consulta->bindValue("22",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                $consulta->bindValue("23",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                $consulta->bindValue("24",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                $cont = 0;
                // $contS = 0;
                if($consulta->rowCount() > 0 ){
                    $cont++;

                    for($i = 0; $i < 4; $i++){
                        $sql = "INSERT INTO historial_predio (id_ficha, anno, descripcion) VALUES (?, ?, ?)";
                        $consulta2 = $conexion->prepare($sql);
                        $consulta2->bindValue("1",$this->id, PDO::PARAM_INT);
                        switch($i){
                            case 0:
                                $consulta2->bindValue("2",$this->rotacion_anno_1, PDO::PARAM_INT);
                                $consulta2->bindValue("3",$this->rotacion_desc_1, PDO::PARAM_STR);
                            break;
                            case 1:
                                $consulta2->bindValue("2",$this->rotacion_anno_2, PDO::PARAM_INT);
                                $consulta2->bindValue("3",$this->rotacion_desc_2, PDO::PARAM_STR);
                            break;
                            case 2:
                                $consulta2->bindValue("2",$this->rotacion_anno_3, PDO::PARAM_INT);
                                $consulta2->bindValue("3",$this->rotacion_desc_3, PDO::PARAM_STR);
                            break;
                            case 3:
                                $consulta2->bindValue("2",$this->rotacion_anno_4, PDO::PARAM_INT);
                                $consulta2->bindValue("3",$this->rotacion_desc_4, PDO::PARAM_STR);
                            break;
                        }

                        $consulta2->execute();
                        if($consulta2->rowCount() > 0 ){
                            $cont++;
                        }
                    }


                    $value = $this->imagen;

                    foreach($value as $imagenes){
                        $nombreImagenOrignal = $imagenes["name"];
                        list($nn, $dot) = explode(".",$nombreImagenOrignal);

                        list($fecha, $hora) = explode(" ", $fechaHora);

                        $fechaHoraNombre = str_replace(" ", $fechaHora);
                        $fechaHoraNombre = str_replace("-", $fechaHoraNombre);
                        $fechaHoraNombre = str_replace(":", $fechaHoraNombre);



                        $nombreArchivoAparte = "FW".$this->id."_0_".uniqid()."_0_".$fechaHoraNombre."_0.".$dot;
                        $ruta_img = "../../../../curimapu_docum/img_android/$nombreArchivoAparte";

                        copy($imagenes["tmp_name"], $ruta_img);

                        if(file_exists($ruta_img)){

                            $ins = "INSERT INTO fotos (id_ficha, tipo, fecha, hora, fecha_hora, nombre_foto, ruta_foto, estado_sincro) VALUES (?, ?, ?, ?, ?, ?, ?,?);";
                            $cons = $conexion->prepare($ins);
                            $cons->bindValue("1",$this->id, PDO::PARAM_INT);
                            $cons->bindValue("2","F", PDO::PARAM_STR);
                            $cons->bindValue("3",$fecha, PDO::PARAM_STR);
                            $cons->bindValue("4",$hora, PDO::PARAM_STR);
                            $cons->bindValue("5",$fechaHora, PDO::PARAM_STR);
                            $cons->bindValue("6",$imagenes["name"], PDO::PARAM_STR);
                            $cons->bindValue("7",$ruta_img, PDO::PARAM_STR);
                            $cons->bindValue("8","1", PDO::PARAM_STR);
                            $cons->execute();
                        }
                    } 

                    if($cont != 5){
                        $rollback = true;
                    }

                }else{
                    $rollback = true;
                }

            }catch(PDOException $e){
                $rollback = true;
                echo "[ACTIVAR FICHA] -> ha ocurrido un error ".$e->getMessage();
            }

                if($rollback){
                    $conexion->rollback();
                    $respuesta = "3";
                }else{
                    $conexion->commit();
                    $respuesta = "1";
                }

            return $respuesta;
            $conexion = NULL;

        }
        
        public function rechazarFicha(){
            try{

                $conexion = new Conectar();
                $conexion = $conexion->conexion();
                $sql = "UPDATE ficha SET id_est_fic = '3', user_mod = ?, fecha_mod = ? WHERE id_ficha = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$_SESSION["rut_curimapu"], PDO::PARAM_STR);
                $consulta->bindValue("2",date("Y-m-d H:i:s"), PDO::PARAM_STR);
                $consulta->bindValue("3",$this->id, PDO::PARAM_INT);
                $consulta->execute();

                $sql = "SELECT * FROM ficha WHERE id_est_fic = '3' AND id_ficha = ?";
                $consulta1 = $conexion->prepare($sql);
                $consulta1->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta1->execute();

                if($consulta->rowCount() > 0 && ($consulta->rowCount() == $consulta1->rowCount())){
                    $respuesta = "1";

                }else{
                    $respuesta = "3";

                }
                
                return $respuesta;
        
            }catch(PDOException $e){
                echo "[RECHAZAR FICHA] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        /* Fin provisorias */

        public function traerComunas(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT C.id_comuna, C.nombre FROM comuna C INNER JOIN provincia P ON C.id_provincia = P.id_provincia WHERE P.id_region = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_region, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER COMUNAS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        /* Fin Ubicacion */

        public function traerPredio(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_pred, nombre FROM predio WHERE id_comuna = ? AND id_agric = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id_comuna, PDO::PARAM_STR);
                $consulta->bindValue("2",$this->id_agricultor, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER PREDIOS] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function traerPotrero(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT id_lote, nombre FROM lote WHERE id_pred = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER POTRERO] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }

        public function traerInfoAgri(){
            try{

                $conexion = new Conectar();
                $sql = "SELECT razon_social, rut, email, telefono, region.nombre AS region, comuna.nombre AS comuna, rep_legal, rut_rl, telefono_rl, email_rl, banco, cuenta_corriente 
                        FROM agricultor 
                        LEFT JOIN region USING(id_region) 
                        LEFT JOIN comuna USING(id_comuna) 
                        WHERE id_agric = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetch(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER INFO AGRICULTOR] -> ha ocurrido un error ".$e->getMessage();

            }
            $conexion = NULL;
        }

        public function eliminarImagen(){

            
            try{
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $sql = "SELECT ruta_foto, id_foto FROM fotos  WHERE  tipo = 'F' AND id_foto = ?";
        
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $r = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($r as $value){

                        if(file_exists($value["ruta_foto"])){
                            unlink($value["ruta_foto"]);
                        }

                        $sql = "DELETE FROM fotos WHERE id_foto = ? AND tipo = 'F'; ";
                        $del = $conexion->prepare($sql);
                        $del->bindValue("1",$value["id_foto"], PDO::PARAM_INT);
                        $del->execute();
                        if($del->rowCount() > 0){
                            $respuesta = "1";
                        }else{
                            $respuesta = "2";
                        }
                    }

                }else{
                    $respuesta = "3";
                }
        
            }catch(PDOException $e){
                echo "[TRAER IMAGENES] -> ha ocurrido un error ".$e->getMessage();

            }

            return $respuesta;
        
            $conexion = NULL;
        }

        public function traerImagenes(){
            try{
                $conexion = new Conectar();
                $conexion = $conexion->conexion();

                $sql = "SELECT ruta_foto, id_foto FROM fotos  WHERE  tipo = 'F' AND id_ficha  IN (SELECT id_ficha FROM ficha WHERE id_ficha = ? AND estado_sincro = 1)";
                
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->id, PDO::PARAM_INT);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $this->set_data($consulta->fetchAll(PDO::FETCH_ASSOC));

                }
        
            }catch(PDOException $e){
                echo "[TRAER IMAGENES] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $conexion = NULL;

        }
    
    }
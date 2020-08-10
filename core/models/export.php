<?php

session_start();
require_once '../../db/conectarse_db.php';

    class Export{
        
        private $id_export;  
        private $id_esp;  
        private $id_cli;  
        private $id_materiales;  
        private $id_ac;  
        private $id_agric;  
        private $lote_cliente;  
        private $hectareas;  
        private $fin_lote;  
        private $kgs_recepcionado;  
        private $kgs_limpios;  
        private $kgs_exportados;  
        private $lote_campo;  
        private $numero_guia;  
        private $peso_bruto; 
        private $peso_neto; 
        private $tara; 
        private $rut_agricultor;

        private $temporada;
        
        
        private $id, $desde, $orden;

        
        private $variable;
        private $data;


        public function set_id_export($id_export){
            $id_export = (isset($id_export)?strtoupper($id_export):NULL);
            $this->id_export = filter_var($id_export,FILTER_SANITIZE_STRING);
        }
        public function set_variable($variable){
            $variable = (isset($variable)?strtoupper($variable):NULL);
            $this->variable = filter_var($variable,FILTER_SANITIZE_STRING);
        }

        public function set_id_esp($id_esp){
            $id_esp = (isset($id_esp)?strtoupper($id_esp):NULL);
            $this->id_esp = filter_var($id_esp,FILTER_SANITIZE_STRING);
        }

        public function set_id_cli($id_cli){
            $id_cli = (isset($id_cli)?strtoupper($id_cli):NULL);
            $this->id_cli = filter_var($id_cli,FILTER_SANITIZE_STRING);
        }

        public function set_id_materiales($id_materiales){
            $id_materiales = (isset($id_materiales)?strtoupper($id_materiales):NULL);
            $this->id_materiales = filter_var($id_materiales,FILTER_SANITIZE_STRING);
        }


        public function set_id_ac($id_ac){
            $id_ac = (isset($id_ac)?strtoupper($id_ac):NULL);
            $this->id_ac = filter_var($id_ac,FILTER_SANITIZE_STRING);
        }



        public function set_id_agric($id_agric){
            $id_agric = (isset($id_agric)?strtoupper($id_agric):NULL);
            $this->id_agric = filter_var($id_agric,FILTER_SANITIZE_STRING);
        }

        public function set_lote_cliente($lote_cliente){
            $lote_cliente = (isset($lote_cliente)?strtoupper($lote_cliente):NULL);
            $this->lote_cliente = filter_var($lote_cliente,FILTER_SANITIZE_STRING);
        }

        public function set_hectareas($hectareas){
            $hectareas = (isset($hectareas)?strtoupper($hectareas):NULL);
            $this->hectareas = filter_var($hectareas,FILTER_SANITIZE_STRING);
        }

        public function set_fin_lote($fin_lote){
            $fin_lote = (isset($fin_lote)?strtoupper($fin_lote):NULL);
            $this->fin_lote = filter_var($fin_lote,FILTER_SANITIZE_STRING);
        }

        public function set_kgs_recepcionado($kgs_recepcionado){
            $kgs_recepcionado = (isset($kgs_recepcionado)?strtoupper($kgs_recepcionado):NULL);
            $this->kgs_recepcionado = filter_var($kgs_recepcionado,FILTER_SANITIZE_STRING);
        }

        public function set_kgs_limpios($kgs_limpios){
            $kgs_limpios = (isset($kgs_limpios)?strtoupper($kgs_limpios):NULL);
            $this->kgs_limpios = filter_var($kgs_limpios,FILTER_SANITIZE_STRING);
        }

        public function set_kgs_exportados($kgs_exportados){
            $kgs_exportados = (isset($kgs_exportados)?strtoupper($kgs_exportados):NULL);
            $this->kgs_exportados = filter_var($kgs_exportados,FILTER_SANITIZE_STRING);
        }

        public function set_lote_campo($lote_campo){
            $lote_campo = (isset($lote_campo)?strtoupper($lote_campo):NULL);
            $this->lote_campo = filter_var($lote_campo,FILTER_SANITIZE_STRING);
        }

        public function set_numero_guia($numero_guia){
            $numero_guia = (isset($numero_guia)?strtoupper($numero_guia):NULL);
            $this->numero_guia = filter_var($numero_guia,FILTER_SANITIZE_STRING);
        }

        public function set_peso_bruto($peso_bruto){
            $peso_bruto = (isset($peso_bruto)?strtoupper($peso_bruto):NULL);
            $this->peso_bruto = filter_var($peso_bruto,FILTER_SANITIZE_STRING);
        }
        public function set_peso_neto($peso_neto){
            $peso_neto = (isset($peso_neto)?strtoupper($peso_neto):NULL);
            $this->peso_neto = filter_var($peso_neto,FILTER_SANITIZE_STRING);
        }
        public function set_tara($tara){
            $tara = (isset($tara)?strtoupper($tara):NULL);
            $this->tara = filter_var($tara,FILTER_SANITIZE_STRING);
        }

        public function set_rut_agricultor($rut_agricultor){
            $rut_agricultor = (isset($rut_agricultor)?strtoupper($rut_agricultor):NULL);
            $this->rut_agricultor = filter_var($rut_agricultor,FILTER_SANITIZE_STRING);
        }

        

    

        public function set_temporada($temporada){
            $temporada = (isset($temporada)?strtoupper($temporada):NULL);
            $this->temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
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
    
        public function get_data() {
            return $this->data;
        }

        public function data() {
            return $this->data;
            
        }

        public function traerDatosPlanta(){

            /* CONEXION */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            try{

                /********/
                /* BIND */
                /********/
            
                $bind = array();
                
                /**********/
                /* Filtro */
                /**********/
                
                $filtro = " WHERE id_export IS NOT NULL  ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }

                


                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }
                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->id_ac != ""){ $filtro .= " AND AC.num_anexo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_ac."%")); }
                if($this->temporada != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->temporada)); }
                if($this->id_agric != ""){ $filtro .= " AND A.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_agric."%")); }
                
                if($this->lote_cliente != ""){ $filtro .= " AND ST.lote_cliente LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_cliente."%")); }
                
                if($this->hectareas != ""){ $filtro .= " AND ST.hectareas LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->hectareas."%")); }
                if($this->fin_lote != ""){ $filtro .= " AND ST.fin_lote LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->fin_lote."%")); }



                if($this->kgs_recepcionado != ""){ $filtro .= " AND ST.kgs_recepcionado LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_recepcionado."%")); }
                if($this->kgs_limpios != ""){ $filtro .= " AND ST.kgs_limpios LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_limpios."%")); }
                if($this->kgs_exportados != ""){ $filtro .= " AND ST.kgs_exportados LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_exportados."%")); }
                // if($this->tara != ""){ $filtro .= " AND ST.tara LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tara."%")); }
                // if($this->lote_campo != ""){ $filtro .= " AND ST.lote_campo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_campo."%")); }
                // if($this->numero_guia != ""){ $filtro .= " AND ST.numero_guia LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numero_guia."%")); }
                // if($this->peso_bruto != ""){ $filtro .= " AND ST.peso_bruto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_bruto."%")); }
                // if($this->peso_neto != ""){ $filtro .= " AND ST.peso_neto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_neto."%")); }
 


                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:  $orden = "ORDER BY E.nombre ASC"; break;
                    case 2:  $orden = "ORDER BY E.nombre DESC";  break;

                    // case 3: $orden = "ORDER BY ST.fecha_recepcion ASC";  break;
                    // case 4:  $orden = "ORDER BY ST.fecha_recepcion DESC";  break;

                    case 3: $orden = "ORDER BY C.razon_social ASC";break;
                    case 4: $orden = "ORDER BY C.razon_social DESC";break;

                    case 5: $orden = "ORDER BY M.nom_hibrido ASC";break;
                    case 6: $orden = "ORDER BY M.nom_hibrido DESC";break;

                    case 7: $orden = "ORDER BY AC.num_anexo ASC";break;
                    case 8: $orden = "ORDER BY AC.num_anexo DESC";break;

                    case 9: $orden = "ORDER BY ST.lote_cliente ASC";break;
                    case 10: $orden = "ORDER BY ST.lote_cliente DESC";break;

                    case 11: $orden = "ORDER BY A.razon_social ASC";break;
                    case 12: $orden = "ORDER BY A.razon_social DESC";break;

                    case 13: $orden = "ORDER BY ST.hectareas ASC";break;
                    case 14: $orden = "ORDER BY ST.hectareas DESC";break;

                    case 15: $orden = "ORDER BY ST.fin_lote ASC";break;
                    case 16: $orden = "ORDER BY ST.fin_lote DESC";break;

                    case 17: $orden = "ORDER BY ST.kgs_recepcionado ASC";break;
                    case 18: $orden = "ORDER BY ST.kgs_recepcionado DESC";break;

                    case 19: $orden = "ORDER BY ST.kgs_limpios ASC";break;
                    case 20: $orden = "ORDER BY ST.kgs_limpios DESC";break;

                    case 21: $orden = "ORDER BY ST.kgs_exportados ASC";break;
                    case 22: $orden = "ORDER BY ST.kgs_exportados DESC";break;

                  
                    default: $orden = "ORDER BY ST.id_export DESC";break;
                }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                            ST.id_export,
                            ST.id_export_sap,  
                            ST.id_esp,  
                            ST.id_cli,  
                            ST.id_materiales,  
                            ST.id_ac,  
                            ST.id_tempo,  
                            ST.id_agric,  
                            ST.lote_cliente,  
                            ST.hectareas,  
                            ST.fin_lote,  
                            ST.kgs_recepcionado,  
                            ST.kgs_limpios,  
                            ST.kgs_exportados,  
                            ST.lote_campo,  
                            A.razon_social AS nombre_agricultor,
                            C.razon_social AS nombre_cliente,
                            E.nombre AS nombre_especie,
                            M.nom_hibrido AS nombre_material,
                            AC.num_anexo
                        FROM export ST
                        INNER JOIN  especie E USING(id_esp)
                        INNER JOIN  materiales M USING(id_materiales)
                        INNER JOIN  cliente C USING(id_cli)
                        INNER JOIN  anexo_contrato AC USING(id_ac)
                        INNER JOIN agricultor A USING(id_agric)

                        $filtro  $orden LIMIT $this->desde,10";



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
        
                $consulta = NULL;
        
            }catch(PDOException $e){
                echo "[TRAER DATOS PLANTA export] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }


        public function totalDatosPlanta(){

            /* CONEXION */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            try{

                /********/
                /* BIND */
                /********/
            
                $bind = array();
                
                /**********/
                /* Filtro */
                /**********/
                
                $filtro = " WHERE id_export IS NOT NULL  ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }
                
                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }
                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->id_ac != ""){ $filtro .= " AND AC.num_anexo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_ac."%")); }
                if($this->temporada != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->temporada)); }
                if($this->id_agric != ""){ $filtro .= " AND A.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_agric."%")); }
                
                if($this->lote_cliente != ""){ $filtro .= " AND ST.lote_cliente LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_cliente."%")); }
                
                if($this->hectareas != ""){ $filtro .= " AND ST.hectareas LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->hectareas."%")); }
                if($this->fin_lote != ""){ $filtro .= " AND ST.fin_lote LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->fin_lote."%")); }



                if($this->kgs_recepcionado != ""){ $filtro .= " AND ST.kgs_recepcionado LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_recepcionado."%")); }
                if($this->kgs_limpios != ""){ $filtro .= " AND ST.kgs_limpios LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_limpios."%")); }
                if($this->kgs_exportados != ""){ $filtro .= " AND ST.kgs_exportados LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_exportados."%")); }
                // if($this->tara != ""){ $filtro .= " AND ST.tara LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tara."%")); }
                // if($this->lote_campo != ""){ $filtro .= " AND ST.lote_campo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_campo."%")); }
                // if($this->numero_guia != ""){ $filtro .= " AND ST.numero_guia LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numero_guia."%")); }
                // if($this->peso_bruto != ""){ $filtro .= " AND ST.peso_bruto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_bruto."%")); }
                // if($this->peso_neto != ""){ $filtro .= " AND ST.peso_neto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_neto."%")); }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                COUNT(id_export) AS Total
                FROM export ST
                INNER JOIN  especie E USING(id_esp)
                INNER JOIN  materiales M USING(id_materiales)
                INNER JOIN  cliente C USING(id_cli)
                INNER JOIN  agricultor A USING (id_agric)
                INNER JOIN  anexo_contrato AC USING(id_ac)

            $filtro ";

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
                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $this->set_data(array("Total" =>$res[0]["Total"]));
                }
        
                $consulta = NULL;
        
            }catch(PDOException $e){
                echo "[totalDatosPlanta export] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }


        public function traerDatosRecepcion(){

            /* CONEXION */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            try{

                /********/
                /* BIND */
                /********/
            
                $bind = array();
                
                /**********/
                /* Filtro */
                /**********/
                
                $filtro = " WHERE id_export IS NOT NULL  ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }


                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                // if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }
                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->id_ac != ""){ $filtro .= " AND AC.num_anexo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_ac."%")); }
                if($this->temporada != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->temporada)); }
                if($this->id_agric != ""){ $filtro .= " AND A.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_agric."%")); }
                
                if($this->lote_cliente != ""){ $filtro .= " AND ST.lote_cliente LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_cliente."%")); }
                
                if($this->hectareas != ""){ $filtro .= " AND ST.hectareas LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->hectareas."%")); }
                if($this->fin_lote != ""){ $filtro .= " AND ST.fin_lote LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->fin_lote."%")); }



                if($this->kgs_recepcionado != ""){ $filtro .= " AND ST.kgs_recepcionado LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_recepcionado."%")); }
                if($this->kgs_limpios != ""){ $filtro .= " AND ST.kgs_limpios LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_limpios."%")); }
                if($this->kgs_exportados != ""){ $filtro .= " AND ST.kgs_exportados LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_exportados."%")); }
                if($this->lote_campo != ""){ $filtro .= " AND ST.lote_campo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_campo."%")); }
                if($this->tara != ""){ $filtro .= " AND ST.tara LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tara."%")); }

                if($this->numero_guia != ""){ $filtro .= " AND ST.numero_guia LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numero_guia."%")); }
                if($this->peso_bruto != ""){ $filtro .= " AND ST.peso_bruto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_bruto."%")); }
                if($this->peso_neto != ""){ $filtro .= " AND ST.peso_neto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_neto."%")); }
                if($this->rut_agricultor != ""){ $filtro .= " AND A.rut LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut_agricultor."%")); }
 


                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:  $orden = "ORDER BY E.nombre ASC"; break;
                    case 2:  $orden = "ORDER BY E.nombre DESC";  break;

                    // case 3: $orden = "ORDER BY ST.fecha_recepcion ASC";  break;
                    // case 4:  $orden = "ORDER BY ST.fecha_recepcion DESC";  break;

                    case 3: $orden = "ORDER BY  M.nom_hibrido ASC";break;
                    case 4: $orden = "ORDER BY  M.nom_hibrido DESC";break;

                    case 5: $orden = "ORDER BY AC.num_anexo ASC";break;
                    case 6: $orden = "ORDER BY AC.num_anexo DESC";break;

                    case 7: $orden = "ORDER BY A.razon_social ASC";break;
                    case 8: $orden = "ORDER BY A.razon_social DESC";break;

                    case 9: $orden = "ORDER BY A.rut ASC";break;
                    case 10: $orden = "ORDER BY A.rut DESC";break;

                    case 11: $orden = "ORDER BY ST.lote_campo ASC";break;
                    case 12: $orden = "ORDER BY ST.lote_campo DESC";break;

                    case 13: $orden = "ORDER BY ST.numero_guia ASC";break;
                    case 14: $orden = "ORDER BY ST.numero_guia DESC";break;

                    case 15: $orden = "ORDER BY ST.peso_bruto ASC";break;
                    case 16: $orden = "ORDER BY ST.peso_bruto DESC";break;

                    case 17: $orden = "ORDER BY ST.tara ASC";break;
                    case 18: $orden = "ORDER BY ST.tara DESC";break;

                    case 19: $orden = "ORDER BY ST.peso_neto ASC";break;
                    case 20: $orden = "ORDER BY ST.peso_neto DESC";break;

                  
                    default: $orden = "ORDER BY ST.id_export DESC";break;
                }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                            ST.id_export,
                            ST.id_export_sap,  
                            ST.id_esp,  
                            ST.id_cli,  
                            ST.id_materiales,  
                            ST.id_ac,  
                            ST.id_tempo,  
                            ST.id_agric,  
                            ST.lote_cliente,  
                            ST.hectareas,  
                            ST.fin_lote,  
                            ST.kgs_recepcionado,  
                            ST.kgs_limpios,  
                            ST.kgs_exportados,  
                            ST.lote_campo,  
                            ST.numero_guia, 
                            ST.peso_bruto, 
                            ST.tara,
                            ST.peso_neto, 
                            A.razon_social AS nombre_agricultor,
                            A.rut,
                            E.nombre AS nombre_especie,
                            M.nom_hibrido AS nombre_material,
                            AC.num_anexo
                        FROM export ST
                        INNER JOIN  especie E USING(id_esp)
                        INNER JOIN  materiales M USING(id_materiales)
                        INNER JOIN  agricultor A USING (id_agric)
                        INNER JOIN  anexo_contrato AC USING(id_ac)

                        $filtro  $orden LIMIT $this->desde,10";



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
        
                $consulta = NULL;
        
            }catch(PDOException $e){
                echo "[TRAER DATOS RECEPCION export] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }


        public function totalDatosRecepcion(){

            /* CONEXION */
            $conexion = new Conectar();
            $conexion = $conexion->conexion();

            try{

                /********/
                /* BIND */
                /********/
            
                $bind = array();
                
                /**********/
                /* Filtro */
                /**********/
                
                $filtro = " WHERE id_export IS NOT NULL  ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }
                
                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                // if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }
                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->id_ac != ""){ $filtro .= " AND AC.num_anexo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_ac."%")); }
                if($this->temporada != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->temporada)); }
                if($this->id_agric != ""){ $filtro .= " AND A.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_agric."%")); }
                
                if($this->lote_cliente != ""){ $filtro .= " AND ST.lote_cliente LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_cliente."%")); }
                
                if($this->hectareas != ""){ $filtro .= " AND ST.hectareas LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->hectareas."%")); }
                if($this->fin_lote != ""){ $filtro .= " AND ST.fin_lote LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->fin_lote."%")); }



                if($this->kgs_recepcionado != ""){ $filtro .= " AND ST.kgs_recepcionado LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_recepcionado."%")); }
                if($this->kgs_limpios != ""){ $filtro .= " AND ST.kgs_limpios LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_limpios."%")); }
                if($this->kgs_exportados != ""){ $filtro .= " AND ST.kgs_exportados LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->kgs_exportados."%")); }
                if($this->tara != ""){ $filtro .= " AND ST.tara LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tara."%")); }
                if($this->lote_campo != ""){ $filtro .= " AND ST.lote_campo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->lote_campo."%")); }
                if($this->numero_guia != ""){ $filtro .= " AND ST.numero_guia LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numero_guia."%")); }
                if($this->peso_bruto != ""){ $filtro .= " AND ST.peso_bruto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_bruto."%")); }
                if($this->peso_neto != ""){ $filtro .= " AND ST.peso_neto LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->peso_neto."%")); }

                if($this->rut_agricultor != ""){ $filtro .= " AND A.rut LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->rut_agricultor."%")); }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                COUNT(id_export) AS Total
                FROM export ST
                INNER JOIN  especie E USING(id_esp)
                INNER JOIN  materiales M USING(id_materiales)
                INNER JOIN  agricultor A USING (id_agric)
                INNER JOIN  anexo_contrato AC USING(id_ac)

            $filtro ";

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
                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $this->set_data(array("Total" =>$res[0]["Total"]));
                }
        
                $consulta = NULL;
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS RECEPCION export] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }



    
    }
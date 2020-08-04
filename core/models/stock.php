<?php

session_start();
require_once '../../db/conectarse_db.php';

    class Categoria{
        
        private $id_stock_semilla;  
        private $id_esp;  
        private $fecha_recepcion;  
        private $id_cli;  
        private $id_materiales;  
        private $genetic;  
        private $trait;  
        private $sag_resolution_number;  
        private $curimapu_batch_number;  
        private $customer_batch;  
        private $quantity_kg;  
        private $notes;  
        private $seed_treated_by;  
        private $curimapu_treated_by;  
        private $customer_tsw; 
        private $customer_germ_porcentaje; 
        private $tsw; 
        private $curimapu_germ_porcentaje;
        private $temporada;
        
        
        private $id, $desde, $orden;

        
        private $variable;
        private $data;


        public function set_id_stock_semilla($id_stock_semilla){
            $id_stock_semilla = (isset($id_stock_semilla)?strtoupper($id_stock_semilla):NULL);
            $this->id_stock_semilla = filter_var($id_stock_semilla,FILTER_SANITIZE_STRING);
        }
        public function set_variable($variable){
            $variable = (isset($variable)?strtoupper($variable):NULL);
            $this->variable = filter_var($variable,FILTER_SANITIZE_STRING);
        }

        public function set_id_esp($id_esp){
            $id_esp = (isset($id_esp)?strtoupper($id_esp):NULL);
            $this->id_esp = filter_var($id_esp,FILTER_SANITIZE_STRING);
        }


        public function set_fecha_recepcion($fecha_recepcion){
            $fecha_recepcion = (isset($fecha_recepcion)?strtoupper($fecha_recepcion):NULL);
            $this->fecha_recepcion = filter_var($fecha_recepcion,FILTER_SANITIZE_STRING);
        }

        public function set_id_cli($id_cli){
            $id_cli = (isset($id_cli)?strtoupper($id_cli):NULL);
            $this->id_cli = filter_var($id_cli,FILTER_SANITIZE_STRING);
        }

        public function set_id_materiales($id_materiales){
            $id_materiales = (isset($id_materiales)?strtoupper($id_materiales):NULL);
            $this->id_materiales = filter_var($id_materiales,FILTER_SANITIZE_STRING);
        }

        public function set_genetic($genetic){
            $genetic = (isset($genetic)?strtoupper($genetic):NULL);
            $this->genetic = filter_var($genetic,FILTER_SANITIZE_STRING);
        }

        public function set_trait($trait){
            $trait = (isset($trait)?strtoupper($trait):NULL);
            $this->trait = filter_var($trait,FILTER_SANITIZE_STRING);
        }

        public function set_sag_resolution_number($sag_resolution_number){
            $sag_resolution_number = (isset($sag_resolution_number)?strtoupper($sag_resolution_number):NULL);
            $this->sag_resolution_number = filter_var($sag_resolution_number,FILTER_SANITIZE_STRING);
        }

        public function set_curimapu_batch_number($curimapu_batch_number){
            $curimapu_batch_number = (isset($curimapu_batch_number)?strtoupper($curimapu_batch_number):NULL);
            $this->curimapu_batch_number = filter_var($curimapu_batch_number,FILTER_SANITIZE_STRING);
        }

        public function set_curstomer_batch($customer_batch){
            $customer_batch = (isset($customer_batch)?strtoupper($customer_batch):NULL);
            $this->customer_batch = filter_var($customer_batch,FILTER_SANITIZE_STRING);
        }

        public function set_quantity_kg($quantity_kg){
            $quantity_kg = (isset($quantity_kg)?strtoupper($quantity_kg):NULL);
            $this->quantity_kg = filter_var($quantity_kg,FILTER_SANITIZE_STRING);
        }

        public function set_notes($notes){
            $notes = (isset($notes)?strtoupper($notes):NULL);
            $this->notes = filter_var($notes,FILTER_SANITIZE_STRING);
        }

        public function set_seed_treated_by($seed_treated_by){
            $seed_treated_by = (isset($seed_treated_by)?strtoupper($seed_treated_by):NULL);
            $this->seed_treated_by = filter_var($seed_treated_by,FILTER_SANITIZE_STRING);
        }

        public function set_curimapu_treated_by($curimapu_treated_by){
            $curimapu_treated_by = (isset($curimapu_treated_by)?strtoupper($curimapu_treated_by):NULL);
            $this->curimapu_treated_by = filter_var($curimapu_treated_by,FILTER_SANITIZE_STRING);
        }

        public function set_customer_tsw($customer_tsw){
            $customer_tsw = (isset($customer_tsw)?strtoupper($customer_tsw):NULL);
            $this->customer_tsw = filter_var($customer_tsw,FILTER_SANITIZE_STRING);
        }

        public function set_customer_gem_porcentaje($customer_germ_porcentaje){
            $customer_germ_porcentaje = (isset($customer_germ_porcentaje)?strtoupper($customer_germ_porcentaje):NULL);
            $this->customer_germ_porcentaje = filter_var($customer_germ_porcentaje,FILTER_SANITIZE_STRING);
        }

        public function set_tsw($tsw){
            $tsw = (isset($tsw)?strtoupper($tsw):NULL);
            $this->tsw = filter_var($tsw,FILTER_SANITIZE_STRING);
        }

        public function set_curimapu_germ_porcentaje($curimapu_germ_porcentaje){
            $curimapu_germ_porcentaje = (isset($curimapu_germ_porcentaje)?strtoupper($curimapu_germ_porcentaje):NULL);
            $this->curimapu_germ_porcentaje = filter_var($curimapu_germ_porcentaje,FILTER_SANITIZE_STRING);
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

        public function traerDatos(){

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
                
                $filtro = " WHERE id_stock_semilla IS NOT NULL ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }
                
                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                if($this->fecha_recepcion != ""){ $filtro .= " AND ST.fecha_recepcion = ? "; array_push($bind,array("Tipo" => "STR", "Dato" => $this->fecha_recepcion)); }
                if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }

                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->genetic != ""){ $filtro .= " AND ST.genetic LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->genetic."%")); }
                if($this->trait != ""){ $filtro .= " AND ST.trait LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->trait."%")); }
                if($this->sag_resolution_number != ""){ $filtro .= " AND ST.sag_resolution_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->sag_resolution_number."%")); }
                if($this->curimapu_batch_number != ""){ $filtro .= " AND ST.curimapu_batch_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_batch_number."%")); }



                if($this->customer_batch != ""){ $filtro .= " AND ST.customer_batch LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_batch."%")); }
                if($this->quantity_kg != ""){ $filtro .= " AND ST.quantity_kg LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->quantity_kg."%")); }
                if($this->notes != ""){ $filtro .= " AND ST.notes LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->notes."%")); }
                if($this->seed_treated_by != ""){ $filtro .= " AND ST.seed_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->seed_treated_by."%")); }
                if($this->curimapu_treated_by != ""){ $filtro .= " AND ST.curimapu_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_treated_by."%")); }
                if($this->customer_tsw != ""){ $filtro .= " AND ST.customer_tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_tsw."%")); }
                if($this->customer_germ_porcentaje != ""){ $filtro .= " AND ST.customer_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_germ_porcentaje."%")); }
                if($this->tsw != ""){ $filtro .= " AND ST.tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tsw."%")); }
                if($this->curimapu_germ_porcentaje != ""){ $filtro .= " AND ST.curimapu_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_germ_porcentaje."%")); }
                
                if($this->temporada != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "STR", "Dato" => $this->temporada)); }
                


                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:  $orden = "ORDER BY E.nombre ASC"; break;
                    case 2:  $orden = "ORDER BY E.nombre DESC";  break;

                    case 3: $orden = "ORDER BY ST.fecha_recepcion ASC";  break;
                    case 4:  $orden = "ORDER BY ST.fecha_recepcion DESC";  break;

                    case 5: $orden = "ORDER BY C.razon_social ASC";break;
                    case 6: $orden = "ORDER BY C.razon_social DESC";break;

                    case 7: $orden = "ORDER BY M.nombre ASC";break;
                    case 8: $orden = "ORDER BY M.nombre DESC";break;

                    case 9: $orden = "ORDER BY ST.genetic ASC";break;
                    case 10: $orden = "ORDER BY ST.genetic DESC";break;

                    case 11: $orden = "ORDER BY ST.trait ASC";break;
                    case 12: $orden = "ORDER BY ST.trait DESC";break;

                    case 13: $orden = "ORDER BY ST.sag_resolution_number ASC";break;
                    case 14: $orden = "ORDER BY ST.sag_resolution_number DESC";break;

                    case 15: $orden = "ORDER BY ST.curimapu_batch_number ASC";break;
                    case 16: $orden = "ORDER BY ST.curimapu_batch_number DESC";break;

                    case 17: $orden = "ORDER BY ST.customer_batch ASC";break;
                    case 18: $orden = "ORDER BY ST.customer_batch DESC";break;

                    case 19: $orden = "ORDER BY ST.quantity_kg ASC";break;
                    case 20: $orden = "ORDER BY ST.quantity_kg DESC";break;

                    case 21: $orden = "ORDER BY ST.notes ASC";break;
                    case 22: $orden = "ORDER BY ST.notes DESC";break;

                    case 23: $orden = "ORDER BY ST.seed_treated_by ASC";break;
                    case 24: $orden = "ORDER BY ST.seed_treated_by DESC";break;

                    case 25: $orden = "ORDER BY ST.curimapu_treated_by ASC";break;
                    case 26: $orden = "ORDER BY ST.curimapu_treated_by DESC";break;

                    case 27: $orden = "ORDER BY ST.customer_tsw ASC";break;
                    case 28: $orden = "ORDER BY ST.customer_tsw DESC";break;

                    case 29: $orden = "ORDER BY ST.customer_germ_porcentaje ASC";break;
                    case 30: $orden = "ORDER BY ST.customer_germ_porcentaje DESC";break;

                    case 31: $orden = "ORDER BY ST.tsw ASC";break;
                    case 32: $orden = "ORDER BY ST.tsw DESC";break;

                    case 33: $orden = "ORDER BY ST.curimapu_germ_porcentaje ASC";break;
                    case 34: $orden = "ORDER BY ST.curimapu_germ_porcentaje DESC";break;

                
                    default: $orden = "ORDER BY ST.fecha_recepcion DESC";break;
                }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                            ST.id_stock_semilla_sap,  
                            ST.id_esp,  
                            ST.fecha_recepcion,  
                            ST.id_cli,  
                            ST.id_materiales,  
                            ST.genetic,  
                            ST.trait,  
                            ST.sag_resolution_number,  
                            ST.curimapu_batch_number,  
                            ST.customer_batch,  
                            ST.quantity_kg,  
                            ST.notes,  
                            ST.seed_treated_by,  
                            ST.curimapu_treated_by,  
                            ST.customer_tsw, 
                            ST.customer_germ_porcentaje, 
                            ST.tsw, 
                            ST.curimapu_germ_porcentaje,
                            C.razon_social,
                            E.nombre AS nombre_especie,
                            M.nom_hibrido AS nombre_material
                        FROM stock_semillas ST
                        INNER JOIN  especie E USING(id_esp)
                        INNER JOIN  materiales M USING(id_materiales)
                        INNER JOIN  cliente C USING(id_cli) 
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
                echo "[TRAER DATOS stock_semillas] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }


        public function totalDatos(){

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
                
                $filtro = " WHERE 1 ";
                // if($_SESSION["tipo_curimapu"] == 3){
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? AND (F.id_usuario = ? OR F.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";

                // }else{ 
                //     $filtro = " WHERE F.estado_sincro = 1 AND F.id_est_fic = 2 AND F.id_tempo = ? ";

                // }
                
                if($this->id_esp != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $this->id_esp)); }
                if($this->fecha_recepcion != ""){ $filtro .= " AND ST.fecha_recepcion = ? "; array_push($bind,array("Tipo" => "STR", "Dato" => $this->fecha_recepcion)); }
                if($this->id_cli != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_cli."%")); }

                if($this->id_materiales != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->id_materiales."%")); }
                if($this->genetic != ""){ $filtro .= " AND ST.genetic LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->genetic."%")); }
                if($this->trait != ""){ $filtro .= " AND ST.trait LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->trait."%")); }
                if($this->sag_resolution_number != ""){ $filtro .= " AND ST.sag_resolution_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->sag_resolution_number."%")); }
                if($this->curimapu_batch_number != ""){ $filtro .= " AND ST.curimapu_batch_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_batch_number."%")); }



                if($this->customer_batch != ""){ $filtro .= " AND ST.customer_batch LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_batch."%")); }
                if($this->quantity_kg != ""){ $filtro .= " AND ST.quantity_kg LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->quantity_kg."%")); }
                if($this->notes != ""){ $filtro .= " AND ST.notes LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->notes."%")); }
                if($this->seed_treated_by != ""){ $filtro .= " AND ST.seed_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->seed_treated_by."%")); }
                if($this->curimapu_treated_by != ""){ $filtro .= " AND ST.curimapu_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_treated_by."%")); }
                if($this->customer_tsw != ""){ $filtro .= " AND A.customer_tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_tsw."%")); }
                if($this->customer_germ_porcentaje != ""){ $filtro .= " AND A.customer_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->customer_germ_porcentaje."%")); }
                if($this->tsw != ""){ $filtro .= " AND A.tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->tsw."%")); }
                if($this->curimapu_germ_porcentaje != ""){ $filtro .= " AND A.curimapu_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->curimapu_germ_porcentaje."%")); }



                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT 
                           COUNT(id_stock_semilla) as Total
                        FROM stock_semillas ST
                        INNER JOIN  especie E USING(id_esp)
                        INNER JOIN  materiales M USING(id_materiales)
                        INNER JOIN  cliente C USING(id_cli) 
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
                echo "[TRAER DATOS stock_semillas] -> ha ocurrido un error ".$e->getMessage();

            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }

    
    }
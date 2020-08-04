<?php
    require_once '../../db/conectarse_db.php';

    class Contratos{

        private $ficha, $numeroC, $numeroA, $cliente, $agricultor, $especie, $variedad, $base, $precio, $humedad, $germinacion, $purezaG, $purezaF, $enfermedades, $malezas;

        private $desde, $orden, $temporada;

        private $data;
        
        public function set_ficha($ficha){
            $ficha = (isset($ficha)?$ficha:NULL);
            $this->ficha = filter_var($ficha,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_numeroC($numeroC){
            $numeroC = (isset($numeroC)?$numeroC:NULL);
            $this->numeroC = filter_var($numeroC,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_numeroA($numeroA){
            $numeroA = (isset($numeroA)?$numeroA:NULL);
            $this->numeroA = filter_var($numeroA,FILTER_SANITIZE_STRING);

        }

        public function set_cliente($cliente){
            $cliente = (isset($cliente)?$cliente:NULL);
            $this->cliente = filter_var($cliente,FILTER_SANITIZE_STRING);

        }
        
        public function set_agricultor($agricultor){
            $agricultor = (isset($agricultor)?$agricultor:NULL);
            $this->agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);

        }
        
        public function set_especie($especie){
            $especie = (isset($especie)?$especie:NULL);
            $this->especie = filter_var($especie,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_variedad($variedad){
            $variedad = (isset($variedad)?$variedad:NULL);
            $this->variedad = filter_var($variedad,FILTER_SANITIZE_STRING);

        }
        
        public function set_base($base){
            $base = (isset($base)?$base:NULL);
            $this->base = filter_var($base,FILTER_SANITIZE_NUMBER_INT);

        }
        
        public function set_precio($precio){
            $precio = (isset($precio)?$precio:NULL);
            $this->precio = filter_var($precio,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }

        public function set_humedad($humedad){
            $humedad = (isset($humedad)?$humedad:NULL);
            $this->humedad = filter_var($humedad,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_germinacion($germinacion){
            $germinacion = (isset($germinacion)?$germinacion:NULL);
            $this->germinacion = filter_var($germinacion,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_purezaG($purezaG){
            $purezaG = (isset($purezaG)?$purezaG:NULL);
            $this->purezaG = filter_var($purezaG,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_purezaF($purezaF){
            $purezaF = (isset($purezaF)?$purezaF:NULL);
            $this->purezaF = filter_var($purezaF,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

        }
        
        public function set_enfermedades($enfermedades){
            $enfermedades = (isset($enfermedades)?$enfermedades:NULL);
            $this->enfermedades = filter_var($enfermedades,FILTER_SANITIZE_STRING);

        }
        
        public function set_malezas($malezas){
            $malezas = (isset($malezas)?$malezas:NULL);
            $this->malezas = filter_var($malezas,FILTER_SANITIZE_STRING);

        }

        public function set_desde($desde){
            $desde = (isset($desde)?$desde:NULL);
            $this->desde = filter_var($desde,FILTER_SANITIZE_NUMBER_INT);

        }

        public function set_orden($orden){
            $orden = (isset($orden)?$orden:NULL);
            $this->orden = filter_var($orden,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_temporada($temporada){
            $temporada = (isset($temporada)?$temporada:NULL);
            $this->temporada = filter_var($temporada,FILTER_SANITIZE_NUMBER_INT);
            
        }

        public function set_data($data) {
            $this->data = $data;

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

                $filtro = "";
                if($this->ficha != ""){ $filtro .= " AND A.id_ficha = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->ficha)); }
                if($this->numeroC != ""){ $filtro .= " AND C.num_contrato LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->numeroC)); }
                if($this->numeroA != ""){ $filtro .= " AND A.num_anexo LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numeroA."%")); }
                if($this->cliente != ""){ $filtro .= " AND CL.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->cliente."%")); }
                if($this->agricultor != ""){ $filtro .= " AND AG.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agricultor."%")); }
                if($this->especie != ""){ $filtro .= " AND M.id_esp LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->especie."%")); }
                if($this->variedad != ""){ $filtro .= " AND M.nom_hibrido LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->variedad."%")); }
                if($this->base != ""){ $filtro .= " AND A.base = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->base)); }
                if($this->precio != ""){ $filtro .= " AND A.precio = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->precio)); }
                if($this->humedad != ""){ $filtro .= " AND A.humedad LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->humedad."%")); }
                if($this->germinacion != ""){ $filtro .= " AND A.germinacion LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->germinacion."%")); }
                if($this->purezaG != ""){ $filtro .= " AND A.pureza_genetica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->purezaG."%")); }
                if($this->purezaF != ""){ $filtro .= " AND A.pureza_fisica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->purezaF."%")); }
                if($this->enfermedades != ""){ $filtro .= " AND A.enfermedades LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->enfermedades."%")); }
                if($this->malezas != ""){ $filtro .= " AND A.maleza LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->malezas."%")); }

                /*********/
                /* Orden */
                /*********/

                $orden = "";
                switch($this->orden){
                    case 1:
                        $orden = "ORDER BY C.num_contrato ASC";
                    break;
                    case 2:
                        $orden = "ORDER BY C.num_contrato DESC";
                    break;
                    case 3:
                        $orden = "ORDER BY A.num_anexo ASC";
                    break;
                    case 4:
                        $orden = "ORDER BY A.num_anexo DESC";
                    break;
                    case 5:
                        $orden = "ORDER BY CL.razon_social ASC";
                    break;
                    case 6:
                        $orden = "ORDER BY CL.razon_social DESC";
                    break;
                    case 7:
                        $orden = "ORDER BY AG.razon_social ASC";
                    break;
                    case 8:
                        $orden = "ORDER BY AG.razon_social DESC";
                    break;
                    case 9:
                        $orden = "ORDER BY E.nombre ASC";
                    break;
                    case 10:
                        $orden = "ORDER BY E.nombre DESC";
                    break;
                    case 11:
                        $orden = "ORDER BY M.nom_hibrido ASC";
                    break;
                    case 12:
                        $orden = "ORDER BY M.nom_hibrido DESC";
                    break;
                    case 13:
                        $orden = "ORDER BY A.base ASC";
                    break;
                    case 14:
                        $orden = "ORDER BY A.base DESC";
                    break;
                    case 15:
                        $orden = "ORDER BY A.precio ASC";
                    break;
                    case 16:
                        $orden = "ORDER BY A.precio DESC";
                    break;
                    case 17:
                        $orden = "ORDER BY A.humedad ASC";
                    break;
                    case 18:
                        $orden = "ORDER BY A.humedad DESC";
                    break;
                    case 19:
                        $orden = "ORDER BY A.germinacion ASC";
                    break;
                    case 20:
                        $orden = "ORDER BY A.germinacion DESC";
                    break;
                    case 21:
                        $orden = "ORDER BY A.pureza_genetica ASC";
                    break;
                    case 22:
                        $orden = "ORDER BY A.pureza_genetica DESC";
                    break;
                    case 23:
                        $orden = "ORDER BY A.pureza_fisica ASC";
                    break;
                    case 24:
                        $orden = "ORDER BY A.pureza_fisica DESC";
                    break;
                    case 25:
                        $orden = "ORDER BY A.enfermedades ASC";
                    break;
                    case 26:
                        $orden = "ORDER BY A.enfermedades DESC";
                    break;
                    case 27:
                        $orden = "ORDER BY A.maleza ASC";
                    break;
                    case 28:
                        $orden = "ORDER BY A.maleza DESC";
                    break;
                    case 29:
                        $orden = "ORDER BY A.id_ficha ASC";
                    break;
                    case 30:
                        $orden = "ORDER BY A.id_ficha DESC";
                    break;
                    default:
                        $orden = "ORDER BY C.num_contrato ASC";
                    break;
                }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT A.id_ficha, C.num_contrato, A.num_anexo, CL.razon_social, AG.razon_social AS agricultor, E.nombre, M.nom_hibrido, A.base, A.precio, A.humedad, A.germinacion, A.pureza_genetica, A.pureza_fisica, A.enfermedades, A.maleza 
                        FROM anexo_contrato A 
                        INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
                        INNER JOIN contrato_agricultor C ON C.id_cont = CAT.id_cont 
                        INNER JOIN agricultor AG ON AG.id_agric = C.id_agric 
                        INNER JOIN materiales M ON M.id_materiales = A.id_materiales 
                        INNER JOIN especie E ON E.id_esp = M.id_esp 
                        INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = A.id_de_quo 
                        INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation 
                        INNER JOIN contrato_cliente CC ON CC.id_cli = Q.id_cli 
                        INNER JOIN cliente CL ON CL.id_cli= CC.id_cli 
                        WHERE A.id_ac != 0 AND CAT.id_tempo = ? $filtro GROUP BY A.num_anexo $orden LIMIT $this->desde,10";

                $consulta = $conexion->prepare($sql);

                $consulta->bindValue("1",$this->temporada, PDO::PARAM_STR);

                $posicion = 1;
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
                echo "[TRAER DATOS] -> ha ocurrido un error ".$e->getMessage();

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

                $filtro = "";
                if($this->ficha != ""){ $filtro .= " AND A.id_ficha = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->ficha)); }
                if($this->numeroC != ""){ $filtro .= " AND C.num_contrato LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->numeroC)); }
                if($this->numeroA != ""){ $filtro .= " AND A.num_anexo LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->numeroA."%")); }
                if($this->cliente != ""){ $filtro .= " AND CL.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->cliente."%")); }
                if($this->agricultor != ""){ $filtro .= " AND AG.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->agricultor."%")); }
                if($this->especie != ""){ $filtro .= " AND M.id_esp LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->especie."%")); }
                if($this->variedad != ""){ $filtro .= " AND M.nom_hibrido LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->variedad."%")); }
                if($this->base != ""){ $filtro .= " AND A.base = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->base)); }
                if($this->precio != ""){ $filtro .= " AND A.precio = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $this->precio)); }
                if($this->humedad != ""){ $filtro .= " AND A.humedad LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->humedad."%")); }
                if($this->germinacion != ""){ $filtro .= " AND A.germinacion LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->germinacion."%")); }
                if($this->purezaG != ""){ $filtro .= " AND A.pureza_genetica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->purezaG."%")); }
                if($this->purezaF != ""){ $filtro .= " AND A.pureza_fisica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->purezaF."%")); }
                if($this->enfermedades != ""){ $filtro .= " AND A.enfermedades LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->enfermedades."%")); }
                if($this->malezas != ""){ $filtro .= " AND A.maleza LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$this->malezas."%")); }

                /*******/
                /* SQL */
                /*******/

                $sql = "SELECT COUNT(Totales) AS Total FROM (SELECT COUNT(*) AS Totales FROM anexo_contrato A 
                            INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
                            INNER JOIN contrato_agricultor C ON C.id_cont = CAT.id_cont 
                            INNER JOIN agricultor AG ON AG.id_agric = C.id_agric 
                            INNER JOIN materiales M ON M.id_materiales = A.id_materiales 
                            INNER JOIN especie E ON E.id_esp = M.id_esp 
                            INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = A.id_de_quo 
                            INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation 
                            INNER JOIN contrato_cliente CC ON CC.id_cli = Q.id_cli 
                            INNER JOIN cliente CL ON CL.id_cli= CC.id_cli
                            LEFT JOIN ficha F ON F.id_ficha = A.id_ficha 
                            WHERE A.id_ac != 0 AND CAT.id_tempo = ? $filtro GROUP BY A.num_anexo) AS Contador";

                $consulta = $conexion->prepare($sql);

                $consulta->bindValue("1",$this->temporada, PDO::PARAM_INT);

                $posicion = 1;
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

                $consulta = NULL;
        
            }catch(PDOException $e){
                echo "[TOTAL DATOS] -> ha ocurrido un error ".$e->getMessage();
            }
    
            /* CIERRE CONEXION */
            $conexion = NULL;

        }
    
    }
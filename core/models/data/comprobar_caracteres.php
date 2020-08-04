<?php
    require_once '../../db/conectarse_db.php';

    /**********************/
    /* VALIDAR CARACTERES */
    /**********************/
    // sleep(5);
    
    // echo "acaaaa";
    function textValido($valor){
        // ãâäàåêëèïîìôöòðõüûùÃÄÅÈÊËÎÏÖÕÔÒÜÛÙ

        /* Variables */
        $caracteres_invalidos = array();

        /* Caracteres validos º A*/
        $validador = "ãâäàåêëèïîìôöòðõüûùÃÄÅÊËÈÏÎÖÒÔÕÜÛÙáéíóúÁÉÍÓÚabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890@.-−_()°º+$,;:=#%/|¿?¡!*[{<>}]&' ";
        $validadorLen = mb_strlen($validador, 'ISO-8859-1');
    
        /* Cadena a validar */
        /* $valor = strtoupper($valor); */
        $valor = mb_strtoupper($valor, 'ISO-8859-1');
         
        $valorLen = mb_strlen($valor, 'ISO-8859-1');

        /* Recorrer cadena */
        for($i = 0; $i < $valorLen; $i++){
            $existe = false;
            $caracter = mb_substr($valor,$i,1);

            /* Recorrer caracteres validos */
            for($e = 0; $e < $validadorLen; $e++){
                $caracterV = mb_substr($validador,$e,1);

                if($caracter == $caracterV){
                    $existe = true;
                    break;

                }

            }

            if(!$existe){
                array_push($caracteres_invalidos, $caracter);

            }

        }

        if(COUNT($caracteres_invalidos) > 0){
            $caracteres = "";

            $c = 0;
            foreach($caracteres_invalidos as $caracter){
                $c++;
                $caracteres .= ($c == 1) ? $caracter : $caracter." - ";

            }

            $retorno = "La cadena: '".$valor."' posee el caracter: '".$caracteres."', el cual no esta dentro de nuestros caracteres validos.";

        }else{
            $retorno = NULL;

        }

        return $retorno;

    }

    /************/
    /* CONEXION */
    /************/
    
    $conexion = new Conectar();
    $conexion = $conexion->conexion_descarga();

    /***********/
    /* FUNCION */
    /***********/

    function Comprobar($resultado){
        $errores = array();

        foreach($resultado as $registro => $datos){
            $error = array();
            foreach($datos as $key => $valor){
                if(!is_numeric($key)){
                    if($valor != ""){
                        $estado = textValido($valor);

                        if($estado != NULL){
                            $error[$key] = mb_convert_encoding($estado, 'UTF-8', 'UTF-8');

                        }

                    }

                }

            }

            if(COUNT($error) > 0){
                $errores[$registro] = $error;

            }

        }

        return $errores;

    }

    /***********/
    /* INFORME */
    /***********/

    $datos = array();
    $informe = array();

    /**************/
    /* AGRICULTOR */
    /**************/

    $agricultor = array();
    
    $sql = "SELECT * FROM agricultor";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $agricultor = $consulta->fetchAll();

    }

    $informe["agricultor"] = Comprobar($agricultor);



    /**************/
    /* STOCK SEMILLAS */
    /**************/

    $stock_semillas = array();
    
    $sql = "SELECT * FROM stock_semillas";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $stock_semillas = $consulta->fetchAll();

    }

    $informe["stock_semillas"] = Comprobar($stock_semillas);



    

    /******************/
    /* ANEXO_CONTRATO */
    /******************/

    $anexo_contrato = array();
    
    $sql = "SELECT * FROM anexo_contrato";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $anexo_contrato = $consulta->fetchAll();

    }

    $informe["anexo_contrato"] = Comprobar($anexo_contrato);

    /***********/
    /* CLIENTE */
    /***********/

    $cliente = array();
    
    $sql = "SELECT * FROM cliente";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $cliente = $consulta->fetchAll();

    }

    $informe["cliente"] = Comprobar($cliente);

    /**********/
    /* COMUNA */
    /**********/

    $comuna = array();
    
    $sql = "SELECT * FROM comuna";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $comuna = $consulta->fetchAll();

    }

    $informe["comuna"] = Comprobar($comuna);

    /*************/
    /* CONDICION */
    /*************/

    $condicion = array();
    
    $sql = "SELECT * FROM condicion";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $condicion = $consulta->fetchAll();

    }

    $informe["condicion"] = Comprobar($condicion);

    /***********************/
    /* CONTRATO AGRICULTOR */
    /***********************/

    $contrato_agricultor = array();
    
    $sql = "SELECT * FROM contrato_agricultor";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $contrato_agricultor = $consulta->fetchAll();

    }

    $informe["contrato_agricultor"] = Comprobar($contrato_agricultor);

    /********************/
    /* CONTRATO CLIENTE */
    /********************/

    $contrato_cliente = array();
    
    $sql = "SELECT * FROM contrato_cliente";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $contrato_cliente = $consulta->fetchAll();

    }

    $informe["contrato_cliente"] = Comprobar($contrato_cliente);

    /*********************/
    /* DETALLE QUOTATION */
    /*********************/

    $detalle_quotation = array();
    
    $sql = "SELECT * FROM detalle_quotation";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $detalle_quotation = $consulta->fetchAll();

    }

    $informe["detalle_quotation"] = Comprobar($detalle_quotation);

    /***********/
    /* ESPECIE */
    /***********/

    $especie = array();
    
    $sql = "SELECT * FROM especie";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $especie = $consulta->fetchAll();

    }

    $informe["especie"] = Comprobar($especie);

    /****************/
    /* ESTADO FICHA */
    /****************/

    $estado_ficha = array();
    
    $sql = "SELECT * FROM estado_ficha";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $estado_ficha = $consulta->fetchAll();

    }

    $informe["estado_ficha"] = Comprobar($estado_ficha);

    /*********/
    /* FICHA */
    /*********/

    $ficha = array();
    
    $sql = "SELECT * FROM ficha";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $ficha = $consulta->fetchAll();

    }

    $informe["ficha"] = Comprobar($ficha);

    /********************/
    /* HISTORIAL PREDIO */
    /********************/

    $historial_predio = array();
    
    $sql = "SELECT * FROM historial_predio";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $historial_predio = $consulta->fetchAll();

    }

    $informe["historial_predio"] = Comprobar($historial_predio);

    /*************/
    /* INCOTERMS */
    /*************/

    $incoterms = array();
    
    $sql = "SELECT * FROM incoterms";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $incoterms = $consulta->fetchAll();

    }

    $informe["incoterms"] = Comprobar($incoterms);

    /********/
    /* LOTE */
    /********/

    $lote = array();
    
    $sql = "SELECT * FROM lote";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $lote = $consulta->fetchAll();

    }

    $informe["lote"] = Comprobar($lote);

    /**************/
    /* MATERIALES */
    /**************/

    $materiales = array();
    
    $sql = "SELECT * FROM materiales";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $materiales = $consulta->fetchAll();

    }

    $informe["materiales"] = Comprobar($materiales);

    /**********/
    /* MONEDA */
    /**********/

    $moneda = array();
    
    $sql = "SELECT * FROM moneda";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $moneda = $consulta->fetchAll();

    }

    $informe["moneda"] = Comprobar($moneda);

    /********/
    /* PAIS */
    /********/

    $pais = array();
    
    $sql = "SELECT * FROM pais";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $pais = $consulta->fetchAll();

    }

    $informe["pais"] = Comprobar($pais);

    /**********/
    /* PREDIO */
    /**********/

    $predio = array();
    
    $sql = "SELECT * FROM predio";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $predio = $consulta->fetchAll();

    }

    $informe["predio"] = Comprobar($predio);

    /*************/
    /* QUOTATION */
    /*************/

    $quotation = array();
    
    $sql = "SELECT * FROM quotation";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $quotation = $consulta->fetchAll();

    }

    $informe["quotation"] = Comprobar($quotation);

    /*************/
    /* TEMPORADA */
    /*************/

    $temporada = array();
    
    $sql = "SELECT * FROM temporada";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetchAll();

    }

    $informe["temporada"] =  Comprobar($temporada);

    /*****************/
    /* TIPO CONTRATO */
    /*****************/

    $tipo_contrato = array();
    
    $sql = "SELECT * FROM tipo_contrato";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_contrato = $consulta->fetchAll();

    }

    $informe["tipo_contrato"] = Comprobar($tipo_contrato);

    /**********************/
    /* TIPO CERTIFICACION */
    /**********************/

    $tipo_de_certificacion = array();
    
    $sql = "SELECT * FROM tipo_de_certificacion";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_de_certificacion = $consulta->fetchAll();

    }

    $informe["tipo_certificacion"] = Comprobar($tipo_de_certificacion);

    /*****************/
    /* TIPO DESPACHO */
    /*****************/

    $tipo_de_despacho = array();
    
    $sql = "SELECT * FROM tipo_de_despacho";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_de_despacho = $consulta->fetchAll();

    }

    $informe["tipo_despacho"] = Comprobar($tipo_de_despacho);

    /***************/
    /* TIPO ENVASE */
    /***************/

    $tipo_de_envase = array();
    
    $sql = "SELECT * FROM tipo_de_envase";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_de_envase = $consulta->fetchAll();

    }

    $informe["tipo_envase"] = Comprobar($tipo_de_envase);

    /**************/
    /* TIPO RIEGO */
    /**************/

    $tipo_riego = array();
    
    $sql = "SELECT * FROM tipo_riego";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_riego = $consulta->fetchAll();

    }

    $informe["tipo_riego"] = Comprobar($tipo_riego);

    /**************/
    /* TIPO SUELO */
    /**************/

    $tipo_suelo = array();
    
    $sql = "SELECT * FROM tipo_suelo";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $tipo_suelo = $consulta->fetchAll();

    }

    $informe["tipo_suelo"] = Comprobar($tipo_suelo);

    /*****************/
    /* UNIDAD MEDIDA */
    /*****************/

    $unidad_medida = array();
    
    $sql = "SELECT * FROM unidad_medida";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $unidad_medida = $consulta->fetchAll();

    }

    $informe["unidad_medida"] = Comprobar($unidad_medida);

    /**********/
    /* CODIGO */
    /**********/

    $errores = 0;
    foreach($informe as $tablas){
        $errores += COUNT($tablas);

    }
    $codigo = ($errores>0)?2:1;

    /****************/
    /* MUESTRA INFO */
    /****************/

    // echo "acaaaa codigo: ".$codigo." data".$informe;
    echo json_encode(array("codigo" => $codigo, "data" =>$informe));

    // switch (json_last_error()) {
    //     case JSON_ERROR_NONE:
    //         echo ' - No errors';
    //     break;
    //     case JSON_ERROR_DEPTH:
    //         echo ' - Maximum stack depth exceeded';
    //     break;
    //     case JSON_ERROR_STATE_MISMATCH:
    //         echo ' - Underflow or the modes mismatch';
    //     break;
    //     case JSON_ERROR_CTRL_CHAR:
    //         echo ' - Unexpected control character found';
    //     break;
    //     case JSON_ERROR_SYNTAX:
    //         echo ' - Syntax error, malformed JSON';
    //     break;
    //     case JSON_ERROR_UTF8:
    //         echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
    //     break;
    //     default:
    //         echo ' - Unknown error';
    //     break;
    // }

    // echo PHP_EOL;
    //  var_dump(array("codigo" => $codigo, "data" =>$informe));
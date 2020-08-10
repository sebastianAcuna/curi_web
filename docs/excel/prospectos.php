<?php

    function textWeb($texto){
        $texto = ($texto == 0 || $texto == "" || $texto == "0")?"Web":$texto;

        return $texto;

    }



    function formatoNumerico($numero){

        return number_format($numero, 2, ",", "." );
    }

    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=prospecto_".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";

    // echo "<pre>";
    // var_dump($_REQUEST);
    // echo "<?pre>";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);

    $Tprospecto = (isset($_REQUEST['Prospecto'])?$_REQUEST['Prospecto']:NULL);
    $Tprospecto = filter_var($Tprospecto,FILTER_SANITIZE_NUMBER_INT);

    if($Tprospecto == 1){
        $fieldman = (isset($_REQUEST['FProsA1'])?$_REQUEST['FProsA1']:NULL);
        $fieldman = filter_var($fieldman,FILTER_SANITIZE_STRING);
        if($fieldman != "") $tituloFiltros .= " Fieldman (".$fieldman.")";

        $tempo = (isset($_REQUEST['FProsA2'])?$_REQUEST['FProsA2']:NULL);
        $tempo = filter_var($tempo,FILTER_SANITIZE_NUMBER_INT);
        /* if($tempo != "") $tituloFiltros .= " Temporada (".$tempo.")"; */
        
        $especie = (isset($_REQUEST['FProsA3'])?$_REQUEST['FProsA3']:NULL);
        $especie = filter_var($especie,FILTER_SANITIZE_NUMBER_INT);
        /* if($especie != "") $tituloFiltros .= " Especie (".$especie.")"; */
        
        $agricultor = (isset($_REQUEST['FProsA4'])?$_REQUEST['FProsA4']:NULL);
        $agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);
        if($agricultor != "") $tituloFiltros .= " Agricultor (".$agricultor.")";
        
        $rut = (isset($_REQUEST['FProsA5'])?$_REQUEST['FProsA5']:NULL);
        $rut = filter_var($rut,FILTER_SANITIZE_STRING);
        if($rut != "") $tituloFiltros .= " Rut (".$rut.")";
        
        $telefono = (isset($_REQUEST['FProsA6'])?$_REQUEST['FProsA6']:NULL);
        $telefono = filter_var($telefono,FILTER_SANITIZE_STRING);
        if($telefono != "") $tituloFiltros .= " Telefono (".$telefono.")";
        
        $oferta = (isset($_REQUEST['FProsA9'])?$_REQUEST['FProsA9']:NULL);
        $oferta = filter_var($oferta,FILTER_SANITIZE_STRING);
        if($oferta != "") $tituloFiltros .= " Oferta (".$oferta.")";
        
        $region = (isset($_REQUEST['FProsA10'])?$_REQUEST['FProsA10']:NULL);
        $region = filter_var($region,FILTER_SANITIZE_STRING);
        /* if($region != "") $tituloFiltros .= " Region (".$region.")"; */

        $provincia = (isset($_REQUEST['FProsA11'])?$_REQUEST['FProsA11']:NULL);
        $provincia = filter_var($provincia,FILTER_SANITIZE_STRING);
        /* if($provincia != "") $tituloFiltros .= " Provincia (".$provincia.")"; */

        $comuna = (isset($_REQUEST['FProsA12'])?$_REQUEST['FProsA12']:NULL);
        $comuna = filter_var($comuna,FILTER_SANITIZE_STRING);
        /* if($comuna != "") $tituloFiltros .= " Comuna (".$comuna.")"; */
        
        $localidad = (isset($_REQUEST['FProsA13'])?$_REQUEST['FProsA13']:NULL);
        $localidad = filter_var($localidad,FILTER_SANITIZE_STRING);
        if($localidad != "") $tituloFiltros .= " Localidad (".$localidad.")";
        
        $haDisponibles = (isset($_REQUEST['FProsA14'])?$_REQUEST['FProsA14']:NULL);
        $haDisponibles = filter_var($haDisponibles,FILTER_SANITIZE_STRING);
        if($haDisponibles != "") $tituloFiltros .= " HA Disponibles (".$haDisponibles.")";
        
        $direccion = (isset($_REQUEST['FProsA15'])?$_REQUEST['FProsA15']:NULL);
        $direccion = filter_var($direccion,FILTER_SANITIZE_STRING);
        if($direccion != "") $tituloFiltros .= " Dirección (".$direccion.")";
        
        $repre = (isset($_REQUEST['FProsA16'])?$_REQUEST['FProsA16']:NULL);
        $repre = filter_var($repre,FILTER_SANITIZE_STRING);
        if($repre != "") $tituloFiltros .= " Representante legal (".$repre.")";
        
        $rutRepre = (isset($_REQUEST['FProsA17'])?$_REQUEST['FProsA17']:NULL);
        $rutRepre = filter_var($rutRepre,FILTER_SANITIZE_STRING);
        if($rutRepre != "") $tituloFiltros .= " Rut representante (".$rutRepre.")";
        
        $telefonoRepre = (isset($_REQUEST['FProsA18'])?$_REQUEST['FProsA18']:NULL);
        $telefonoRepre = filter_var($telefonoRepre,FILTER_SANITIZE_NUMBER_INT);
        if($telefonoRepre != "") $tituloFiltros .= " Telefono representante (".$telefonoRepre.")";
        
        $emailRepre = (isset($_REQUEST['FProsA19'])?$_REQUEST['FProsA19']:NULL);
        $emailRepre = filter_var($emailRepre,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($emailRepre != "") $tituloFiltros .= " Email representante (".$emailRepre.")";
        
        $banco = (isset($_REQUEST['FProsA20'])?$_REQUEST['FProsA20']:NULL);
        $banco = filter_var($banco,FILTER_SANITIZE_STRING);
        if($banco != "") $tituloFiltros .= " Banco (".$banco.")";
        
        $cuentaC = (isset($_REQUEST['FProsA21'])?$_REQUEST['FProsA21']:NULL);
        $cuentaC = filter_var($cuentaC,FILTER_SANITIZE_STRING);
        if($cuentaC != "") $tituloFiltros .= " Cuenta corriente (".$cuentaC.")";

        $predio = (isset($_REQUEST['FProsA22'])?$_REQUEST['FProsA22']:NULL);
        $predio = filter_var($predio,FILTER_SANITIZE_STRING);
        if($predio != "") $tituloFiltros .= " Predio (".$predio.")";
        
        $potrero = (isset($_REQUEST['FProsA23'])?$_REQUEST['FProsA23']:NULL);
        $potrero = filter_var($potrero,FILTER_SANITIZE_STRING);
        if($potrero != "") $tituloFiltros .= " Potrero (".$potrero.")";

        $rotacion = (isset($_REQUEST['FProsA24'])?$_REQUEST['FProsA24']:NULL);
        $rotacion = filter_var($rotacion,FILTER_SANITIZE_STRING);
        if($rotacion != "") $tituloFiltros .= " Rotación (".$rotacion.")";
        
        $norting = (isset($_REQUEST['FProsA25'])?$_REQUEST['FProsA25']:NULL);
        $norting = filter_var($norting,FILTER_SANITIZE_STRING);
        if($norting != "") $tituloFiltros .= " Norting (".$norting.")";
        
        $easting = (isset($_REQUEST['FProsA26'])?$_REQUEST['FProsA26']:NULL);
        $easting = filter_var($easting,FILTER_SANITIZE_STRING);
        if($easting != "") $tituloFiltros .= " Easting (".$easting.")";
        
        /* $radio = (isset($_REQUEST['FProsA28'])?$_REQUEST['FProsA27']:NULL);
        $radio = filter_var($radio,FILTER_SANITIZE_STRING);
        if($radio != "") $tituloFiltros .= " Radio (".$radio.")";
        */

        $suelo = (isset($_REQUEST['FProsA28'])?$_REQUEST['FProsA28']:NULL);
        $suelo = filter_var($suelo,FILTER_SANITIZE_NUMBER_INT);
        /* if($suelo != "") $tituloFiltros .= " Tipo de suelo (".$suelo.")"; */
        
        $riego = (isset($_REQUEST['FProsA29'])?$_REQUEST['FProsA29']:NULL);
        $riego = filter_var($riego,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        /* if($riego != "") $tituloFiltros .= " Tipo de riego (".$maleza.")"; */
        
        $experiencia = (isset($_REQUEST['FProsA30'])?$_REQUEST['FProsA30']:NULL);
        $experiencia = filter_var($experiencia,FILTER_SANITIZE_STRING);
        /* if($experiencia != "") $tituloFiltros .= " Experiencia (".$estado.")"; */
        
        $tenencia = (isset($_REQUEST['FProsA31'])?$_REQUEST['FProsA31']:NULL);
        $tenencia = filter_var($tenencia,FILTER_SANITIZE_STRING);
        /* if($tenencia != "") $tituloFiltros .= " Tenencia (".$tenencia.")"; */
        
        $maquinaria = (isset($_REQUEST['FProsA32'])?$_REQUEST['FProsA32']:NULL);
        $maquinaria = filter_var($maquinaria,FILTER_SANITIZE_STRING);
        /* if($maquinaria != "") $tituloFiltros .= " Maquinaria (".$maquinaria.")"; */
        
        $maleza = (isset($_REQUEST['FProsA33'])?$_REQUEST['FProsA33']:NULL);
        $maleza = filter_var($maleza,FILTER_SANITIZE_STRING);
        if($maleza != "") $tituloFiltros .= " Maleza (".$maleza.")";
        
        $estado = (isset($_REQUEST['FProsA34'])?$_REQUEST['FProsA34']:NULL);
        $estado = filter_var($estado,FILTER_SANITIZE_STRING);
        if($estado != "") $tituloFiltros .= " Estado (".$estado.")";
        
        $comentario = (isset($_REQUEST['FProsA35'])?$_REQUEST['FProsA35']:NULL);
        $comentario = filter_var($comentario,FILTER_SANITIZE_STRING);
        if($comentario != "") $tituloFiltros .= " Observaciones (".$comentario.")";
        
        $prospecto = (isset($_REQUEST['FProsA36'])?$_REQUEST['FProsA36']:NULL);
        $prospecto = filter_var($prospecto,FILTER_SANITIZE_STRING);
        if($prospecto != "") $tituloFiltros .= " Prospecto (".$prospecto.")";

        $carga = (isset($_REQUEST['FProsA37'])?$_REQUEST['FProsA37']:NULL);
        $carga = filter_var($carga,FILTER_SANITIZE_STRING);
        if($carga != "") $tituloFiltros .= " Carga (".$carga.")";
        
        $dispositivo = (isset($_REQUEST['FProsA38'])?$_REQUEST['FProsA38']:NULL);
        $dispositivo = filter_var($dispositivo,FILTER_SANITIZE_STRING);
        if($dispositivo != "") $tituloFiltros .= " Dispositivo (".$dispositivo.")";

        /********/
        /* BIND */
        /********/
    
        $bind = array();
    
        /**********/
        /* Filtro */
        /**********/

        $filtro = "";
                
        if($fieldman != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$fieldman."%")); }
        if($tempo != ""){ $filtro .= " AND P.id_tempo = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $tempo)); }
        if($especie != ""){ $filtro .= " AND P.id_esp =  ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $especie)); }
        if($agricultor != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$agricultor."%")); }
        if($rut != ""){ $filtro .= " AND A.rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$rut."%")); }
        if($telefono != ""){ $filtro .= " AND A.telefono LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$telefono."%")); }
        if($oferta != ""){ $filtro .= " AND P.oferta_de_negocio LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$oferta."%")); }
        if($region != ""){ $filtro .= " AND P.id_region LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $region)); }
        if($provincia != ""){ $filtro .= " AND P.id_provincia LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $provincia)); }
        if($comuna != ""){ $filtro .= " AND P.id_comuna LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $comuna)); }
        if($localidad != ""){ $filtro .= " AND P.localidad LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$localidad."%")); }
        if($haDisponibles != ""){ $filtro .= " AND P.ha_disponibles LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$haDisponibles."%")); }
        if($direccion != ""){ $filtro .= " AND A.direccion LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$direccion."%")); }
        if($repre != ""){ $filtro .= " AND A.rep_legal LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$repre."%")); }
        if($rutRepre != ""){ $filtro .= " AND A.rut_rl LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$rutRepre."%")); }
        if($telefonoRepre != ""){ $filtro .= " AND A.telefono_rl LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$telefonoRepre."%")); }
        if($emailRepre != ""){ $filtro .= " AND A.email_rl LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$emailRepre."%")); }
        if($banco != ""){ $filtro .= " AND A.banco LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$banco."%")); }
        if($cuentaC != ""){ $filtro .= " AND A.cuenta_corriente LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$cuentaC."%")); }
        if($predio != ""){ $filtro .= " AND P.predio LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$predio."%")); }
        if($potrero != ""){ $filtro .= " AND P.lote LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$potrero."%")); }
        if($rotacion != ""){ $filtro .= " AND H.descripcion LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$rotacion."%")); }
        if($norting != ""){ $filtro .= " AND P.norting LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$norting."%")); }
        if($easting != ""){ $filtro .= " AND P.easting LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$easting."%")); }
        if($suelo != ""){ $filtro .= " AND P.id_tipo_suelo LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $suelo)); }
        if($riego != ""){ $filtro .= " AND P.id_tipo_riego LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $riego)); }
        if($experiencia != ""){ $filtro .= " AND P.experiencia = ?"; array_push($bind,array("Tipo" => "STR", "Dato" => $experiencia)); }
        if($tenencia != ""){ $filtro .= " AND P.id_tipo_tenencia_terreno LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $tenencia)); }
        if($maquinaria != ""){ $filtro .= " AND P.id_tipo_tenencia_maquinaria LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $maquinaria)); }
        if($maleza != ""){ $filtro .= " AND P.maleza LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$maleza."%")); }
        if($estado != ""){ $filtro .= " AND P.estado_general LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$estado."%")); }
        if($comentario != ""){ $filtro .= " AND P.obs LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$comentario."%")); }
        if($prospecto != ""){ $filtro .= " AND P.id_ficha = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $prospecto)); }
        if($carga != ""){ $filtro .= " AND P.id_cab_subida = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $carga)); }
        if($dispositivo != ""){ $filtro .= " AND CS.id_dispo_subida = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $dispositivo)); }

        /*********/
        /* Orden */
        /*********/

        $orden = "";
        switch($order){
            /* case 1:
                $orden = "ORDER BY fieldman ASC";
            break;
            case 2:
                $orden = "ORDER BY fieldman DESC";
            break; */
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
                $orden = "ORDER BY P.ha_disponible ASC";
            break;
            case 28:
                $orden = "ORDER BY P.ha_disponible DESC";
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
                $orden = "ORDER BY P.predio ASC";
            break;
            case 44:
                $orden = "ORDER BY P.predio DESC";
            break;
            case 45:
                $orden = "ORDER BY P.lote ASC";
            break;
            case 46:
                $orden = "ORDER BY P.lote DESC";
            break;
            
            case 49:
                $orden = "ORDER BY P.norting ASC";
            break;
            case 50:
                $orden = "ORDER BY P.norting DESC";
            break;
            case 51:
                $orden = "ORDER BY P.easting ASC";
            break;
            case 52:
                $orden = "ORDER BY P.easting DESC";
            break;
            /* case 53:
                $orden = "ORDER BY P.radio ASC";
            break;
            case 54:
                $orden = "ORDER BY P.radio DESC";
            break;  */
           
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
                $orden = "ORDER BY P.experiencia ASC";
            break;
            case 60:
                $orden = "ORDER BY P.experiencia DESC";
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
                $orden = "ORDER BY P.maleza ASC";
            break;
            case 66:
                $orden = "ORDER BY P.maleza DESC";
            break;
            case 67:
                $orden = "ORDER BY P.estado_general ASC";
            break;
            case 68:
                $orden = "ORDER BY P.estado_general DESC";
            break;
            case 69:
                $orden = "ORDER BY P.obs ASC";
            break;
            case 70:
                $orden = "ORDER BY P.obs DESC";
            break;
            default:
                $orden = "ORDER BY fecha_mod DESC";
            break;
        }

        /*******/
        /* SQL */
        /*******/

        $conexion = new Conectar();

        $sql = "SELECT P.id_ficha, 
                    CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS fieldman, 
                    T.nombre AS temporada, 
                    E.nombre AS especie, 
                    A.rut, 
                    A.razon_social, 
                    A.telefono, 
                    P.oferta_de_negocio, 
                    P.localidad, 
                    R.nombre AS region, 
                    PR.nombre AS provincia, 
                    C.nombre AS comuna, 
                    P.ha_disponibles, 
                    A.direccion, 
                    A.rep_legal, 
                    A.rut_rl, 
                    A.telefono_rl, 
                    A.email_rl, 
                    A.banco, 
                    A.cuenta_corriente, 
                    group_concat(CASE WHEN H.tipo = 'P' THEN CONCAT(H.anno,' => ',H.descripcion) END ORDER BY H.anno DESC SEPARATOR '//') AS rotacion, 
                    P.predio, 
                    P.lote, 
                    TR.descripcion AS riego, 
                    TS.descripcion AS suelo, 
                    P.experiencia, 
                    TT.descripcion AS tenencia, 
                    TM.descripcion AS maquinaria, 
                    P.maleza, 
                    P.estado_general, 
                    P.obs, 
                    P.norting, 
                    P.easting, 
                    P.id_cab_subida, 
                    CS.id_dispo_subida, 
                    CS.fecha_hora_inicio, 
                    CS.fecha_hora_fin , 
                    P.fecha_mod
                FROM prospecto P 
                INNER JOIN usuarios U ON U.id_usuario = P.id_usuario 
                INNER JOIN especie E ON E.id_esp = P.id_esp 
                INNER JOIN agricultor A ON A.id_agric = P.id_agric 
                INNER JOIN region R ON R.id_region = P.id_region 
                INNER JOIN provincia PR ON PR.id_provincia = P.id_provincia 
                INNER JOIN comuna C ON C.id_comuna = P.id_comuna 
                LEFT JOIN historial_predio H ON H.id_ficha = P.id_ficha 
                INNER JOIN temporada T ON T.id_tempo = P.id_tempo 
                INNER JOIN tipo_suelo TS ON TS.id_tipo_suelo = P.id_tipo_suelo 
                INNER JOIN tipo_riego TR ON TR.id_tipo_riego = P.id_tipo_riego 
                LEFT JOIN tipo_tenencia_terreno TT ON TT.id_tipo_tenencia_terreno = P.id_tipo_tenencia_terreno 
                LEFT JOIN tipo_tenencia_maquinaria TM ON TM.id_tipo_tenencia_maquinaria = P.id_tipo_tenencia_maquinaria 
                LEFT JOIN cabecera_subida CS ON CS.id_cab_subida = P.id_cab_subida 
                WHERE P.id_tempo = ? AND P.estado_sincro = 1 AND P.id_est_fic = 2 $filtro GROUP BY P.id_ficha $orden";

                echo $sql;
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$temporada, PDO::PARAM_STR);

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

        $prospectosA = array();

        if($consulta->rowCount() > 0){
            $prospectosA = $consulta->fetchAll(PDO::FETCH_ASSOC);

        }

        $tituloFicha = "Activos";

    }elseif($Tprospecto == 2){
        $comentario = (isset($_REQUEST['FProsP1'])?$_REQUEST['FProsP1']:NULL);
        $comentario = filter_var($comentario,FILTER_SANITIZE_STRING);
        if($comentario != "") $tituloFiltros .= " Comentario (".$comentario.")";

        $fieldman = (isset($_REQUEST['FProsP2'])?$_REQUEST['FProsP2']:NULL);
        $fieldman = filter_var($fieldman,FILTER_SANITIZE_STRING);
        if($fieldman != "") $tituloFiltros .= " Fieldman (".$fieldman.")";
        
        $tempo = (isset($_REQUEST['FProsP3'])?$_REQUEST['FProsP3']:NULL);
        $tempo = filter_var($tempo,FILTER_SANITIZE_STRING);
        /* if($tempo != "") $tituloFiltros .= " Temporada (".$tempo.")"; */
        
        $rut = (isset($_REQUEST['FProsP4'])?$_REQUEST['FProsP4']:NULL);
        $rut = filter_var($rut,FILTER_SANITIZE_STRING);
        if($rut != "") $tituloFiltros .= " Rut (".$rut.")";
        
        $agricultor = (isset($_REQUEST['FProsP5'])?$_REQUEST['FProsP5']:NULL);
        $agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);
        if($agricultor != "") $tituloFiltros .= " Agricultor (".$agricultor.")";
        
        $telefono = (isset($_REQUEST['FProsP6'])?$_REQUEST['FProsP6']:NULL);
        $telefono = filter_var($telefono,FILTER_SANITIZE_STRING);
        if($telefono != "") $tituloFiltros .= " Telefono (".$telefono.")";
        
        $oferta = (isset($_REQUEST['FProsP7'])?$_REQUEST['FProsP7']:NULL);
        $oferta = filter_var($oferta,FILTER_SANITIZE_STRING);
        if($oferta != "") $tituloFiltros .= " Oferta (".$oferta.")";
        
        $region = (isset($_REQUEST['FProsP8'])?$_REQUEST['FProsP8']:NULL);
        $region = filter_var($region,FILTER_SANITIZE_NUMBER_INT);
        /* if($region != "") $tituloFiltros .= " Region (".$region.")"; */
        
        $provincia = (isset($_REQUEST['FProsP9'])?$_REQUEST['FProsP9']:NULL);
        $provincia = filter_var($provincia,FILTER_SANITIZE_NUMBER_INT);
        /* if($provincia != "") $tituloFiltros .= " Provincia (".$provincia.")"; */
        
        $comuna = (isset($_REQUEST['FProsP10'])?$_REQUEST['FProsP10']:NULL);
        $comuna = filter_var($comuna,FILTER_SANITIZE_NUMBER_INT);
        /* if($comuna != "") $tituloFiltros .= " Comuna (".$comuna.")"; */
        
        $localidad = (isset($_REQUEST['FProsP11'])?$_REQUEST['FProsP11']:NULL);
        $localidad = filter_var($localidad,FILTER_SANITIZE_STRING);
        if($localidad != "") $tituloFiltros .= " Localidad (".$localidad.")";
        
        $haDisponibles = (isset($_REQUEST['FProsP12'])?$_REQUEST['FProsP12']:NULL);
        $haDisponibles = filter_var($haDisponibles,FILTER_SANITIZE_STRING);
        if($haDisponibles != "") $tituloFiltros .= " HA Disponibles (".$haDisponibles.")";
        
        $prospecto = (isset($_REQUEST['FProsP13'])?$_REQUEST['FProsP13']:NULL);
        $prospecto = filter_var($prospecto,FILTER_SANITIZE_STRING);
        if($prospecto != "") $tituloFiltros .= " Prospecto (".$prospecto.")";
        
        $carga = (isset($_REQUEST['FProsP14'])?$_REQUEST['FProsP14']:NULL);
        $carga = filter_var($carga,FILTER_SANITIZE_STRING);
        if($carga != "") $tituloFiltros .= " Carga (".$carga.")";
        
        $dispositivo = (isset($_REQUEST['FProsP15'])?$_REQUEST['FProsP15']:NULL);
        $dispositivo = filter_var($dispositivo,FILTER_SANITIZE_STRING);
        if($dispositivo != "") $tituloFiltros .= " Dispositivo (".$dispositivo.")";

        /********/
        /* BIND */
        /********/
    
        $bind = array();

        /**********/
        /* Filtro */
        /**********/

        $filtro = "";
                
        if($comentario != ""){ $filtro .= " AND P.obs LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$comentario."%")); }
        if($fieldman != ""){ $filtro .= " AND CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$fieldman."%")); }
        if($tempo != ""){ $filtro .= " AND P.id_tempo = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $tempo)); }
        if($rut != ""){ $filtro .= " AND A.rut LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$rut."%")); }
        if($agricultor != ""){ $filtro .= " AND A.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$agricultor."%")); }
        if($telefono != ""){ $filtro .= " AND A.telefono LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$telefono."%")); }
        if($oferta != ""){ $filtro .= " AND P.oferta_de_negocio LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$oferta."%")); }
        if($region != ""){ $filtro .= " AND P.id_region LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $region)); }
        if($provincia != ""){ $filtro .= " AND P.id_provincia LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $provincia)); }
        if($comuna != ""){ $filtro .= " AND P.id_comuna LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $comuna)); }
        if($localidad != ""){ $filtro .= " AND P.localidad LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$localidad."%")); }
        if($haDisponibles != ""){ $filtro .= " AND A.ha_disponibles LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$haDisponibles."%")); }
        if($prospecto != ""){ $filtro .= " AND P.id_ficha = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $prospecto)); }
        if($carga != ""){ $filtro .= " AND P.id_cab_subida = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $carga)); }
        if($dispositivo != ""){ $filtro .= " AND CS.id_dispo_subida = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $dispositivo)); }
        
        /*********/
        /* Orden */
        /*********/

        $orden = "";
        switch($order){
            case 1:
                $orden = "ORDER BY P.obs ASC";
            break;
            case 2:
                $orden = "ORDER BY P.obs DESC";
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
                $orden = "ORDER BY P.oferta_de_negocio ASC";
            break;
            case 14:
                $orden = "ORDER BY P.oferta_de_negocio DESC";
            break;
            case 15:
                $orden = "ORDER BY P.localidad ASC";
            break;
            case 16:
                $orden = "ORDER BY P.localidad DESC";
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
                $orden = "ORDER BY P.ha_disponibles ASC";
            break;
            case 22:
                $orden = "ORDER BY P.ha_disponibles DESC";
            break;
            default:
                $orden = "ORDER BY P.id_ficha ASC";
            break;
        }

        /*******/
        /* SQL */
        /*******/

        $conexion = new Conectar();
        $sql = "SELECT P.id_ficha, 
                    P.obs, 
                    CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS fieldman, 
                    T.nombre AS temporada, 
                    A.rut, 
                    A.razon_social, 
                    A.telefono, 
                    P.oferta_de_negocio, 
                    R.nombre AS region , 
                    PR.nombre AS provincia, 
                    C.nombre AS comuna, 
                    P.localidad, 
                    P.ha_disponibles, 
                    P.id_cab_subida, 
                    CS.id_dispo_subida, 
                    CS.fecha_hora_inicio, 
                    CS.fecha_hora_fin 
                FROM prospecto P 
                INNER JOIN usuarios U ON U.id_usuario = P.id_usuario 
                INNER JOIN agricultor A ON A.id_agric = P.id_agric 
                INNER JOIN region R ON R.id_region = P.id_region 
                INNER JOIN provincia PR ON PR.id_provincia = P.id_provincia 
                INNER JOIN comuna C ON C.id_comuna = P.id_comuna 
                INNER JOIN temporada T ON T.id_tempo = P.id_tempo 
                LEFT JOIN cabecera_subida CS ON CS.id_cab_subida = P.id_cab_subida 
                WHERE P.estado_sincro = 1 AND P.id_est_fic = 1 AND P.id_tempo = ? $filtro $orden";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$temporada, PDO::PARAM_STR);

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

        $prospectosP = array();

        if($consulta->rowCount() > 0){
            $prospectosP = $consulta->fetchAll(PDO::FETCH_ASSOC);

        }

        $tituloFicha = "Provisorios";

    }

    $sql = "SELECT nombre FROM temporada WHERE id_tempo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
    $consulta->execute();

    $temporada = "";
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetch(PDO::FETCH_ASSOC);

    }


  

    $consulta = NULL;
    $conexion = NULL;

?>
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table border="1" cellpadding="2" cellspacing="0" width="100%"> 
        <caption style="font-size: 2em; color: green;"> <strong> Prospectos <?=$tituloFicha?> </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>
        <?php
            if($Tprospecto == 1){
        ?>
                <thead>
                    <?php
                        if(strlen($tituloFiltros) > 46):
                    ?>
                    <tr>
                        <th colspan="36" style="background: lightsteelblue"> <?=$tituloFiltros?> </th>
                    </tr>
                    <?php
                        endif;
                    ?>
                    <tr style="font-size: 1em; background: lightgreen">
                        <th> # </th>
                            <th> Fieldman </th>
                            <th> Temporada </th>
                            <th> Especie </th>
                            <th> Razon social </th>
                            <th> Rut </th>
                            <th> Telefono </th>
                            <th> Oferta de negocio </th>
                            <th> Region </th>
                            <th> Provincia </th>
                            <th> Comuna </th>
                            <th> Localidad </th>
                            <th> HA disponibles </th>
                            <th> Direccion </th>
                            <th> Representante legal </th>
                            <th> Rut representante </th>
                            <th> Tel. representante </th>
                            <th> Mail contacto </th>
                            <th> Banco </th>
                            <th> Cuenta corriente </th>
                            <th> Predio </th>
                            <th> Potrero </th>
                            <th style="background:lightblue;"> Año</th>
                            <th style="background:lightblue;"> Cultivo </th>
                            <th style="background:lightblue;"> Año</th>
                            <th style="background:lightblue;"> Cultivo </th>
                            <th style="background:lightblue;"> Año</th>
                            <th style="background:lightblue;"> Cultivo </th>
                            <th style="background:lightblue;"> Año</th>
                            <th style="background:lightblue;"> Cultivo </th>
                            <th> Norting </th>
                            <th> Easting </th>
                            <th> Tipo de suelo </th>
                            <th> Tipo de riego </th>
                            <th> Experiencia en el cultivo </th>
                            <th> Tipo tenencia </th>
                            <th> Maquinaria </th>
                            <th> Carga de malezas </th>
                            <th> Estado general </th>
                            <th> Observaciones </th>
                            <th> Prospecto </th>
                            <th> Carga </th>
                            <th> Dispositivo </th>
                            <th> Inicio subida </th>
                            <th> Termino subida </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                        if(count($prospectosA) > 0):
                            $i = 0;
                            foreach($prospectosA AS $dato):
                                $i++;
                                ?>
                                <tr>
                                    <?php
                                        // $rotacion = explode(",",$dato["rotacion"]);
                                    ?>
                                    <td><?=$i?></td>
                                    <td><?=$dato["fieldman"]?></td>
                                    <td><?=$dato["temporada"]?></td>
                                    <td><?=$dato["especie"]?></td>
                                    <td><?=$dato["razon_social"]?></td>
                                    <td><?=$dato["rut"]?></td>
                                    <td><?=$dato["telefono"]?></td>
                                    <td><?=$dato["oferta_de_negocio"]?></td>
                                    <td><?=$dato["region"]?></td>
                                    <td><?=$dato["provincia"]?></td>
                                    <td><?=$dato["comuna"]?></td>
                                    <td><?=$dato["localidad"]?></td>
                                    <td><?=formatoNumerico($dato["ha_disponibles"])?></td>
                                    <td><?=$dato["direccion"]?></td>
                                    <td><?=$dato["rep_legal"]?></td>
                                    <td><?=$dato["rut_rl"]?></td>
                                    <td><?=$dato["telefono_rl"]?></td>
                                    <td><?=$dato["email_rl"]?></td>
                                    <td><?=$dato["banco"]?></td>
                                    <td><?=$dato["cuenta_corriente"]?></td>
                                    <td><?=$dato["predio"]?></td>
                                    <td><?=$dato["lote"]?></td>

                                    <?php
                                    
                                        $rotacionColumnas = explode("//", $dato["rotacion"]);
                                        $totalRotaciones = sizeof($rotacionColumnas);
                                        $count = 0;

                                            /* ANO MAS ALTO */
                                            echo "<td>";    
                                                // echo $count."<= ".$totalRotaciones;
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[0] : "";
                                            echo "</td>";
                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[1] : "";
                                            echo "</td>";
                                            $count++;

                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[0] : "";
                                            echo "</td>";
                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[1] : "";
                                            echo "</td>";
                                            $count++;

                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[0] : "";
                                            echo "</td>";

                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[1] : "";
                                            echo "</td>";
                                            $count++;

                                            /*  ANNO MAS BAJO */
                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[0] : "";
                                            echo "</td>";
                                            echo "<td>";
                                                echo ($count <= $totalRotaciones) ? explode("=>",$rotacionColumnas[$count])[1] : "";
                                            echo "</td>";
                                            $count++;

                                        ?>
                                    
                                    <td><?=number_format($dato["norting"], 7, ",", "." )?></td>
                                    <td><?=number_format($dato["easting"], 7, ",", "." )?></td>
                                    <td><?=$dato["suelo"]?></td>
                                    <td><?=$dato["riego"]?></td>
                                    <td><?=$dato["experiencia"]?></td>
                                    <td><?=$dato["tenencia"]?></td>
                                    <td><?=$dato["maquinaria"]?></td>
                                    <td><?=$dato["maleza"]?></td>
                                    <td><?=$dato["estado_general"]?></td>
                                    <td><?=$dato["obs"]?></td>
                                    <td><?=$dato["id_ficha"]?></td>
                                    <td><?=textWeb($dato["id_cab_subida"])?></td>
                                    <td><?=textWeb($dato["id_dispo_subida"])?></td>
                                    <td><?=textWeb($dato["fecha_hora_inicio"])?></td>
                                    <td><?=textWeb($dato["fecha_hora_fin"])?></td>
                                </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="38" align="center"> No existen registros asociados a los parametros establecidos en el prospecto activo </td>
                            </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
        <?php
            }elseif($Tprospecto == 2){
        ?>
                <thead>
                    <?php
                        if(strlen($tituloFiltros) > 46):
                    ?>
                    <tr>
                        <th colspan="12" style="background: lightsteelblue"> <?=$tituloFiltros?> </th>
                    </tr>
                    <?php
                        endif;
                    ?>
                    <tr style="font-size: 1em; background: lightgreen">
                        <th> # </th>
                        <th> Comentario </th>
                        <th> Fieldman </th>
                        <th> Temporada </th>
                        <th> Rut </th>
                        <th> Nombre agricultor </th>
                        <th> Telefono </th>
                        <th> Oferta de negocio </th>
                        <th> Region </th>
                        <th> Provincia </th>
                        <th> Comuna </th>
                        <th> Localidad </th>
                        <th> HA Disponibles </th>
                        <th> Prospecto </th>
                        <th> Carga </th>
                        <th> Dispositivo </th>
                        <th> Inicio subida </th>
                        <th> Termino subida </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                        if(count($prospectosP) > 0):
                            $i = 0;
                            foreach($prospectosP AS $dato):
                                $i++;
                    ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$dato["obs"]?></td>
                                    <td><?=$dato["fieldman"]?></td>
                                    <td><?=$dato["temporada"]?></td>
                                    <td><?=$dato["rut"]?></td>
                                    <td><?=$dato["razon_social"]?></td>
                                    <td><?=$dato["telefono"]?></td>
                                    <td><?=$dato["oferta_de_negocio"]?></td>
                                    <td><?=$dato["region"]?></td>
                                    <td><?=$dato["provincia"]?></td>
                                    <td><?=$dato["comuna"]?></td>
                                    <td><?=$dato["localidad"]?></td>
                                    <td><?=formatoNumerico($dato["ha_disponibles"])?></td>
                                    <td><?=$dato["id_ficha"]?></td>
                                    <td><?=$dato["id_cab_subida"]?></td>
                                    <td><?=$dato["id_dispo_subida"]?></td>
                                    <td><?=$dato["fecha_hora_inicio"]?></td>
                                    <td><?=$dato["fecha_hora_fin"]?></td>
                                </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="14" align="center"> No existen registros asociados a los parametros establecidos en el prospecto provisorio </td>
                            </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
        <?php
            }
        ?>
    </table>
</body>
</html>
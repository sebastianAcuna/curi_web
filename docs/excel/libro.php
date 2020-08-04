<?php
  /*   error_reporting(E_ALL);
    ini_set('display_errors', '1'); */
    session_start();
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=libro".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);
    
    $especie = (isset($_REQUEST["Especie"])?$_REQUEST["Especie"]:NULL);
    $especie = filter_var($especie,FILTER_SANITIZE_STRING);

    $libro = (isset($_REQUEST['Libro'])?$_REQUEST['Libro']:NULL);
    $libro = filter_var($libro,FILTER_SANITIZE_NUMBER_INT);

    function datoForaneo($tabla,$campo,$AC,$Q,$M){
        try{

            $conexion = new Conectar();

            if($tabla == "historial_predio"){
                $sql = "SELECT group_concat(CONCAT(anno,' ==> ',    descripcion) SEPARATOR ' <br> ') AS Dato FROM ".$tabla;

            }else{
                $sql = "SELECT ".$tabla.".".$campo." AS Dato FROM ".$tabla;

            }

            switch($tabla){
                case "anexo_contrato":
                    $sql .= "   WHERE id_ac = ".$AC;
                break;
                case "cliente":
                    $sql .= "   INNER JOIN quotation USING(id_cli)
                                WHERE id_quotation = ".$Q;
                break;
                case "especie":
                    $sql .= "   INNER JOIN quotation USING(id_esp) 
                                WHERE id_quotation = ".$Q;
                break;
                case "materiales":
                    $sql .= "   WHERE id_materiales = ".$M;
                break;
                case "agricultor":
                    $sql .= "   INNER JOIN contrato_agricultor USING(id_agric)
                                INNER JOIN anexo_contrato USING(id_cont)
                                WHERE id_ac = ".$AC;
                break;
                case "predio":
                    $sql .= "   INNER JOIN lote USING (id_pred)
                                INNER JOIN anexo_contrato USING (id_lote)
                                WHERE id_ac = ".$AC;
                break;
                case "lote":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_lote)
                                WHERE id_ac = ".$AC;
                break;
                case "visita":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_ac)
                                WHERE id_ac = ".$AC;
                break;
                case "tipo_riego":
                    $sql .= "   INNER JOIN ficha USING (id_tipo_riego)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "tipo_suelo":
                    $sql .= "   INNER JOIN ficha USING (id_tipo_suelo)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "ficha":
                    $sql .= "   INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC;
                break;
                case "usuarios":
                    $sql .= "   INNER JOIN visita USING (id_usuario)
                                WHERE id_ac = ".$AC;
                break;
                case "historial_predio":
                    $sql .= "   INNER JOIN ficha USING (id_ficha)
                                INNER JOIN anexo_contrato USING (id_ficha)
                                WHERE id_ac = ".$AC."
                                GROUP BY id_ficha ";
                break;

            }

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            $consulta->execute();

            $Dato = NULL;

            if($consulta->rowCount() > 0){
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                $Dato = $resultado["Dato"];

            }

            return $Dato;
    
        }catch(PDOException $e){
            echo "[TRAER DATO FORANEO] -> ha ocurrido un error ".$e->getMessage();

        }
    
        $conexion = NULL;

    }






    switch($libro){
        case 1:
            $tituloLibro = "Resumen";

            /*********/
            /* Orden */
            /*********/

            $orden = "";
            switch($order){
                case 1:
                    $orden = "ORDER BY L.id_lote ASC";
                break;
                case 2:
                    $orden = "ORDER BY L.id_lote DESC";
                break;
                case 3:
                    $orden = "ORDER BY num_anexo ASC";
                break;
                case 4:
                    $orden = "ORDER BY num_anexo DESC";
                break;
                case 5:
                    $orden = "ORDER BY C.razon_social ASC";
                break;
                case 6:
                    $orden = "ORDER BY C.razon_social DESC";
                break;
                case 7:
                    $orden = "ORDER BY E.nombre ASC";
                break;
                case 8:
                    $orden = "ORDER BY E.nombre DESC";
                break;
                case 9:
                    $orden = "ORDER BY M.nom_hibrido ASC";
                break;
                case 10:
                    $orden = "ORDER BY M.nom_hibrido DESC";
                break;
                case 11:
                    $orden = "ORDER BY A.razon_social ASC";
                break;
                case 12:
                    $orden = "ORDER BY A.razon_social DESC";
                break;
                case 13:
                    $orden = "ORDER BY P.nombre ASC";
                break;
                case 14:
                    $orden = "ORDER BY P.nombre DESC";
                break;
                case 15:
                    $orden = "ORDER BY L.nombre ASC";
                break;
                case 16:
                    $orden = "ORDER BY L.nombre DESC";
                break;
                default:
                    $orden = "ORDER BY numero ASC";
                break;
            }

            /*******/
            /* SQL */
            /*******/
            $conexion = new Conectar();
            $sql = "SELECT Q.id_quotation, DQ.id_de_quo, M.id_materiales, AC.id_ac, (SELECT id_visita FROM visita WHERE id_ac = AC.id_ac AND estado_sincro = 1 ORDER BY id_visita DESC LIMIT 1) AS visita
                    FROM anexo_contrato AC 
                    INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                    INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo 
                    INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation ";
                
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= "WHERE Q.id_tempo = ? AND Q.id_cli = ? AND Q.id_esp = ?";
                    break;
                    case 2:
                        $sql.= "INNER JOIN contrato_agricultor USING (id_cont)
                                WHERE Q.id_tempo = ? AND id_agric = ? AND Q.id_esp = ?";
                    break;
                    case 3:
                        $sql.= "WHERE Q.id_tempo = ? AND ( AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario = ?) OR AC.id_ac IN (SELECT id_ac FROM visita WHERE id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))) AND Q.id_esp = ? ";
                    break;
                    case 4:
                    case 5:
                        $sql.= "WHERE Q.id_tempo = ? AND Q.id_esp = ?";
                    break;

                }

            $sql .= "   GROUP BY AC.id_ac
                        HAVING visita > 0";

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                case 2:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["enlace_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$especie, PDO::PARAM_STR);
                break;
                case 3:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
                    $consulta->bindValue("2",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_STR);
                    $consulta->bindValue("4",$especie, PDO::PARAM_STR);
                break;
                case 4:
                case 5:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                break;

            }

            $consulta->execute();

            $datos = array();

            if($consulta->rowCount() > 0){
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $conexion = new Conectar();
            $sql = "SELECT PCM.id_prop_mat_cli, SP.nombre_en AS subHead, P.nombre_en AS Head, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo 
                    FROM cli_pcm CPCM 
                    INNER JOIN prop_cli_mat PCM USING(id_prop_mat_cli)  
                    INNER JOIN sub_propiedades SP USING(id_sub_propiedad) 
                    LEFT JOIN propiedades P USING(id_prop) ";

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $sql.= "WHERE CPCM.id_cli = ? AND CPCM.ver = '1' AND PCM.id_etapa = ? AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $sql.= "WHERE PCM.id_etapa = 1 AND PCM.id_esp = ? AND PCM.id_tempo = ?";
                break;

            }

            $sql.= " AND PCM.aplica = 'SI' GROUP BY PCM.id_prop_mat_cli ORDER BY PCM.id_prop, PCM.orden ASC";



            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $consulta->bindValue("1",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("3",$temporada, PDO::PARAM_INT);
                case 2:
                case 3:
                case 4:
                case 5:
                    $consulta->bindValue("1",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("2",$temporada, PDO::PARAM_INT);
                break;

            }
            
            $consulta->execute();

            $head = array();

            if($consulta->rowCount() > 0){
                $head = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $libroR = array();
            foreach($datos AS $dato){
                $ArrayResultado = array();
                
                foreach($head AS $valor){
                    
                    if(trim($valor["subHead"]) == "PICTURES"){
                    
                    }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = datoForaneo($valor["tabla"],$valor["campo"],$dato["id_ac"],$dato["id_quotation"],$dato["id_materiales"]);

                    }else{
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = "Sin información";

                    }

                }
                
                array_push($libroR,$ArrayResultado);

            }
        break;

        case 2:
        case 3:
        case 4:

            if($libro == 2){
                $tituloLibro = "Sowing";
                $etapa = 2;

            }elseif($libro == 3){
                $tituloLibro = "Flowering";
                $etapa = 3;

            }else{
                $tituloLibro = "Harvest";
                $etapa = 4;

            }

            $rec = (isset($_REQUEST["Campo0"])?$_REQUEST["Campo0"]:NULL);
            $rec = filter_var($rec,FILTER_SANITIZE_STRING);
            if($rec != "") $tituloFiltros .= " Recomendaciones (".$rec.")";

            $num = (isset($_REQUEST["Campo1"])?$_REQUEST["Campo1"]:NULL);
            $num = filter_var($num,FILTER_SANITIZE_STRING);
            if($num != "") $tituloFiltros .= " Field Number (".$num.")";

            $ane = (isset($_REQUEST["Campo2"])?$_REQUEST["Campo2"]:NULL);
            $ane = filter_var($ane,FILTER_SANITIZE_STRING);
            if($ane != "") $tituloFiltros .= " Anexo (".$ane.")";

            $esp = (isset($_REQUEST["Campo3"])?$_REQUEST["Campo3"]:NULL);
            $esp = filter_var($esp,FILTER_SANITIZE_STRING);
            if($esp != "") $tituloFiltros .= " Especie (".$esp.")";

            $var = (isset($_REQUEST["Campo4"])?$_REQUEST["Campo4"]:NULL);
            $var = filter_var($var,FILTER_SANITIZE_STRING);
            if($var != "") $tituloFiltros .= " Variedad (".$var.")";

            $agr = (isset($_REQUEST["Campo5"])?$_REQUEST["Campo5"]:NULL);
            $agr = filter_var($agr,FILTER_SANITIZE_STRING);
            if($agr != "") $tituloFiltros .= " Agricultor (".$agr.")";

            $pre = (isset($_REQUEST["Campo6"])?$_REQUEST["Campo6"]:NULL);
            $pre = filter_var($pre,FILTER_SANITIZE_STRING);
            if($agr != "") $tituloFiltros .= " Predio (".$agr.")";

            $pot = (isset($_REQUEST["Campo7"])?$_REQUEST["Campo7"]:NULL);
            $pot = filter_var($pot,FILTER_SANITIZE_STRING);
            if($pot != "") $tituloFiltros .= " Potrero (".$pot.")";

            $filtro = "";
            if($rec != ""){ $filtro .= " AND recome LIKE '%$rec%'"; }
            if($num != ""){ $filtro .= " AND num_lote LIKE '%$num%'"; }
            if($ane != ""){ $filtro .= " AND num_anexo LIKE '%$ane%'"; }
            if($esp != ""){ $filtro .= " AND especie LIKE '%$esp%'"; }
            if($var != ""){ $filtro .= " AND nom_hibrido LIKE '%$var%'"; }
            if($agr != ""){ $filtro .= " AND razon_social LIKE '%$agr%'"; }
            if($pre != ""){ $filtro .= " AND predio LIKE '%$pre%'"; }
            if($pot != ""){ $filtro .= " AND lote LIKE '%$pot%'"; }

            /*********/
            /* Orden */
            /*********/

            $orden = "";
            switch($orden){
                case 1:
                    $orden = "ORDER BY recome ASC";
                break;
                case 2:
                    $orden = "ORDER BY recome DESC";
                break;
                case 3:
                    $orden = "ORDER BY num_lote ASC";
                break;
                case 4:
                    $orden = "ORDER BY num_lote DESC";
                break;
                case 5:
                    $orden = "ORDER BY num_anexo ASC";
                break;
                case 6:
                    $orden = "ORDER BY num_anexo DESC";
                break;
                case 7:
                    $orden = "ORDER BY especie ASC";
                break;
                case 8:
                    $orden = "ORDER BY especie DESC";
                break;
                case 9:
                    $orden = "ORDER BY nom_hibrido ASC";
                break;
                case 10:
                    $orden = "ORDER BY nom_hibrido DESC";
                break;
                case 11:
                    $orden = "ORDER BY razon_social ASC";
                break;
                case 12:
                    $orden = "ORDER BY razon_social DESC";
                break;
                case 13:
                    $orden = "ORDER BY predio ASC";
                break;
                case 14:
                    $orden = "ORDER BY predio DESC";
                break;
                case 15:
                    $orden = "ORDER BY lote ASC";
                break;
                case 16:
                    $orden = "ORDER BY lote DESC";
                break;
                default:
                    $orden = "ORDER BY AC.id_ac ASC";
                break;
            }

            /*******/
            /* SQL */
            /*******/

            $conexion = new Conectar();
            $sql = "SELECT id_visita AS visita, AC.id_ac, DQ.id_quotation, M.id_materiales, (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, AC.id_lote AS num_lote, AC.num_anexo, E.nombre AS especie,  M.nom_hibrido, A.razon_social, P.nombre AS predio, L.nombre AS lote, group_concat(CONCAT(_det_vis_prop,' && ', _prop_mat_cli,' && ', valor) SEPARATOR ' | ') AS datos FROM
                    (
                        SELECT id_visita, orden, id_ac AS _ac, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor
                        FROM detalle_visita_prop DVP
                        INNER JOIN prop_cli_mat USING ( id_prop_mat_cli )
                        INNER JOIN visita USING ( id_visita )
                        WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa = ? AND id_tempo = ? AND id_esp = ?
                        GROUP BY id_ac, id_prop_mat_cli
                        ORDER BY id_det_vis_prop DESC , prop_cli_mat.id_prop, orden ASC 
                    ) 
                    AS I
                    INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac
                    INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                    INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo
                    INNER JOIN especie E ON E.id_esp = M.id_esp
                    INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                    INNER JOIN lote L ON L.id_lote = F.id_lote
                    INNER JOIN predio P ON P.id_pred = P.id_pred
                    INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
                switch($_SESSION["tipo_curimapu"]){
                    case 1:
                        $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I.id_prop_mat_cli
                                    WHERE id_visita != '0' AND Q.id_cli = ? AND CPCM.ver = '1' ";
                    break;
                    case 2:
                        $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                    break;
                    case 3:
                        $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                                WHERE id_visita != '0' AND ( UA.id_usuario = ? OR UA.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                    break;
                    case 4:
                    case 5:
                        $sql.= " WHERE id_visita != '0'";
                    break;

                }

            $sql .= " $filtro GROUP BY AC.id_ac $orden";

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            switch($_SESSION["tipo_curimapu"]){
                case 1:
                case 2:
                    $consulta->bindValue("1",$etapa, PDO::PARAM_INT);
                    $consulta->bindValue("2",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("3",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("4",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                break;
                case 3:
                    $consulta->bindValue("1",$etapa, PDO::PARAM_INT);
                    $consulta->bindValue("2",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("3",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                    $consulta->bindValue("5",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                break;
                case 4:
                case 5:
                    $consulta->bindValue("1",$etapa, PDO::PARAM_INT);
                    $consulta->bindValue("2",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("3",$especie, PDO::PARAM_INT);
                break;

            }

            $consulta->execute();
            
            $datos = array();

            if($consulta->rowCount() > 0){
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $conexion = new Conectar();
            $sql = "SELECT PCM.id_prop_mat_cli, SP.nombre_en AS subHead, P.nombre_en AS Head, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo FROM cli_pcm CPCM 
                    INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = CPCM.id_prop_mat_cli 
                    LEFT JOIN propiedades P ON P.id_prop = PCM.id_prop 
                    LEFT JOIN sub_propiedades SP ON SP.id_sub_propiedad = PCM.id_sub_propiedad 
                    ";
                    
            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $sql.= "WHERE CPCM.id_cli = ? AND PCM.id_etapa = ? AND CPCM.ver = '1' AND PCM.id_esp = ? ";
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $sql.= "WHERE PCM.id_etapa = ? AND PCM.id_esp = ? ";
                break;

            }

            $sql.= " AND PCM.aplica = 'SI' GROUP BY PCM.id_prop_mat_cli ORDER BY PCM.id_prop, PCM.orden ASC";

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $consulta->bindValue("1",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                    $consulta->bindValue("2",$etapa, PDO::PARAM_INT);
                    $consulta->bindValue("3",$especie, PDO::PARAM_INT);
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $consulta->bindValue("1",$etapa, PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                break;

            }
            
            $consulta->execute();

            $head = array();

            if($consulta->rowCount() > 0){
                $head = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $libroG = array();
            foreach($datos AS $dato){
                $ArrayResultado = array();

                $ArrayResultado["recome"] = $dato["recome"];
                $ArrayResultado["num_lote"] = $dato["num_lote"];
                $ArrayResultado["num_anexo"] = $dato["num_anexo"];
                $ArrayResultado["especie"] = $dato["especie"];
                $ArrayResultado["nom_hibrido"] = $dato["nom_hibrido"];
                $ArrayResultado["razon_social"] = $dato["razon_social"];
                $ArrayResultado["predio"] = $dato["predio"];
                $ArrayResultado["lote"] = $dato["lote"];
                
                foreach($head AS $valor){
                    
                    if(trim($valor["subHead"]) == "PICTURES"){
                    
                    }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = datoForaneo($valor["tabla"],$valor["campo"],$dato["id_ac"],$dato["id_quotation"],$dato["id_materiales"]);

                    }else{
                        $valores = explode(" | ",$dato["datos"]);
                        for($i = 0; $i < COUNT($valores); $i++){
                            $campos = explode(" && ",$valores[$i]);
                            if($valor["id_prop_mat_cli"] == $campos[1]){
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = $campos[0]." && ".$campos[1]." && ".$campos[2];

                            }

                        }

                    }

                }
                
                array_push($libroG,$ArrayResultado);

            }

        break;

        case 5:

            $tituloLibro = "All";

            $rec = (isset($_REQUEST["Campo0"])?$_REQUEST["Campo0"]:NULL);
            $rec = filter_var($rec,FILTER_SANITIZE_STRING);
            if($rec != "") $tituloFiltros .= " Recomendaciones (".$rec.")";

            $num = (isset($_REQUEST["Campo1"])?$_REQUEST["Campo1"]:NULL);
            $num = filter_var($num,FILTER_SANITIZE_STRING);
            if($num != "") $tituloFiltros .= " Field Number (".$num.")";

            $ane = (isset($_REQUEST["Campo2"])?$_REQUEST["Campo2"]:NULL);
            $ane = filter_var($ane,FILTER_SANITIZE_STRING);
            if($ane != "") $tituloFiltros .= " Anexo (".$ane.")";

            $esp = (isset($_REQUEST["Campo3"])?$_REQUEST["Campo3"]:NULL);
            $esp = filter_var($esp,FILTER_SANITIZE_STRING);
            if($esp != "") $tituloFiltros .= " Especie (".$esp.")";

            $var = (isset($_REQUEST["Campo4"])?$_REQUEST["Campo4"]:NULL);
            $var = filter_var($var,FILTER_SANITIZE_STRING);
            if($var != "") $tituloFiltros .= " Variedad (".$var.")";

            $agr = (isset($_REQUEST["Campo5"])?$_REQUEST["Campo5"]:NULL);
            $agr = filter_var($agr,FILTER_SANITIZE_STRING);
            if($agr != "") $tituloFiltros .= " Agricultor (".$agr.")";

            $pre = (isset($_REQUEST["Campo6"])?$_REQUEST["Campo6"]:NULL);
            $pre = filter_var($pre,FILTER_SANITIZE_STRING);
            if($agr != "") $tituloFiltros .= " Predio (".$agr.")";

            $pot = (isset($_REQUEST["Campo7"])?$_REQUEST["Campo7"]:NULL);
            $pot = filter_var($pot,FILTER_SANITIZE_STRING);
            if($pot != "") $tituloFiltros .= " Potrero (".$pot.")";

            $filtro = "";
            if($rec != ""){ $filtro .= " AND recome LIKE '%$rec%'"; }
            if($num != ""){ $filtro .= " AND num_lote LIKE '%$num%'"; }
            if($ane != ""){ $filtro .= " AND num_anexo LIKE '%$ane%'"; }
            if($esp != ""){ $filtro .= " AND especie LIKE '%$esp%'"; }
            if($var != ""){ $filtro .= " AND nom_hibrido LIKE '%$var%'"; }
            if($agr != ""){ $filtro .= " AND razon_social LIKE '%$agr%'"; }
            if($pre != ""){ $filtro .= " AND predio LIKE '%$pre%'"; }
            if($pot != ""){ $filtro .= " AND lote LIKE '%$pot%'"; }

            /*********/
            /* Orden */
            /*********/

            $orden = "";
            switch($orden){
                case 1:
                    $orden = "ORDER BY recome ASC";
                break;
                case 2:
                    $orden = "ORDER BY recome DESC";
                break;
                case 3:
                    $orden = "ORDER BY num_lote ASC";
                break;
                case 4:
                    $orden = "ORDER BY num_lote DESC";
                break;
                case 5:
                    $orden = "ORDER BY num_anexo ASC";
                break;
                case 6:
                    $orden = "ORDER BY num_anexo DESC";
                break;
                case 7:
                    $orden = "ORDER BY especie ASC";
                break;
                case 8:
                    $orden = "ORDER BY especie DESC";
                break;
                case 9:
                    $orden = "ORDER BY nom_hibrido ASC";
                break;
                case 10:
                    $orden = "ORDER BY nom_hibrido DESC";
                break;
                case 11:
                    $orden = "ORDER BY razon_social ASC";
                break;
                case 12:
                    $orden = "ORDER BY razon_social DESC";
                break;
                case 13:
                    $orden = "ORDER BY predio ASC";
                break;
                case 14:
                    $orden = "ORDER BY predio DESC";
                break;
                case 15:
                    $orden = "ORDER BY lote ASC";
                break;
                case 16:
                    $orden = "ORDER BY lote DESC";
                break;
                default:
                    $orden = "ORDER BY AC.id_ac ASC";
                break;
            }

            /*******/
            /* SQL */
            /*******/

            $conexion = new Conectar();
            $sql = "SELECT id_visita AS visita, AC.id_ac, DQ.id_quotation, M.id_materiales, (SELECT recome FROM visita WHERE id_ac = AC.id_ac ORDER BY id_visita DESC LIMIT 1) AS recome, AC.id_lote AS num_lote, AC.num_anexo, E.nombre AS especie,  M.nom_hibrido, A.razon_social, P.nombre AS predio, L.nombre AS lote, group_concat(CONCAT(_det_vis_prop,' && ', _prop_mat_cli,' && ', valor) SEPARATOR ' | ') AS datos FROM
                    (
                        SELECT id_visita, orden, id_ac AS _ac, id_prop_mat_cli AS _prop_mat_cli,(  SELECT MAX( id_det_vis_prop ) AS id_det_vis_prop FROM detalle_visita_prop INNER JOIN visita USING ( id_visita ) WHERE id_ac = _ac AND id_prop_mat_cli = _prop_mat_cli ) AS _det_vis_prop, ( SELECT valor FROM detalle_visita_prop WHERE id_det_vis_prop = _det_vis_prop ) AS valor
                        FROM detalle_visita_prop DVP
                        INNER JOIN prop_cli_mat USING ( id_prop_mat_cli )
                        INNER JOIN visita USING ( id_visita )
                        WHERE visita.estado_sincro = 1 AND id_est_vis = 2 AND id_etapa != 1 AND id_tempo = ? AND id_esp = ?
                        GROUP BY id_ac, id_prop_mat_cli
                        ORDER BY id_det_vis_prop DESC , prop_cli_mat.id_prop, orden ASC 
                    ) 
                    AS I
                    INNER JOIN anexo_contrato AC ON AC.id_ac = I._ac
                    INNER JOIN materiales M ON M.id_materiales = AC.id_materiales 
                    INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = AC.id_de_quo
                    INNER JOIN especie E ON E.id_esp = M.id_esp
                    INNER JOIN ficha F ON F.id_ficha = AC.id_ficha
                    INNER JOIN lote L ON L.id_lote = F.id_lote
                    INNER JOIN predio P ON P.id_pred = F.id_pred
                    INNER JOIN agricultor A ON A.id_agric = F.id_agric ";
                        
            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $sql.= " INNER JOIN cli_pcm CPCM ON CPCM.id_prop_mat_cli = I.id_prop_mat_cli
                                WHERE id_visita != '0' AND Q.id_cli = ? AND CPCM.ver = '1' ";
                break;
                case 2:
                    $sql.= " WHERE id_visita != '0' AND F.id_agric = ? ";
                break;
                case 3:
                    $sql.= "INNER JOIN usuario_anexo UA ON UA.id_ac = AC.id_ac 
                            WHERE id_visita != '0' AND ( U.id_usuario = ? OR U.id_usuario IN (SELECT id_us_sup FROM supervisores WHERE id_sup_us = ?))";
                break;
                case 4:
                case 5:
                    $sql.= " WHERE id_visita != '0'";
                break;

            }

            $sql .= " $filtro GROUP BY AC.id_ac $orden";

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);
            switch($_SESSION["tipo_curimapu"]){
                case 1:
                case 2:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("3",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                break;
                case 3:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                    $consulta->bindValue("3",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                    $consulta->bindValue("4",$_SESSION["IDuser_curimapu"], PDO::PARAM_INT);
                break;
                case 4:
                case 5:
                    $consulta->bindValue("1",$temporada, PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                break;

            }

            $consulta->execute();
            
            $datos = array();

            if($consulta->rowCount() > 0){
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $conexion = new Conectar();
            $sql = "SELECT PCM.id_prop_mat_cli, SP.nombre_en AS subHead, P.nombre_en AS Head, PCM.foraneo, PCM.tabla, PCM.campo, PCM.tipo_campo FROM cli_pcm CPCM 
                    INNER JOIN prop_cli_mat PCM ON PCM.id_prop_mat_cli = CPCM.id_prop_mat_cli 
                    LEFT JOIN propiedades P ON P.id_prop = PCM.id_prop
                    INNER JOIN sub_propiedades SP USING(id_sub_propiedad) ";

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $sql.= "WHERE CPCM.id_cli = ? AND CPCM.ver = '1' AND PCM.id_etapa != '1' AND PCM.id_esp = ? ";
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $sql.= "WHERE PCM.id_etapa != '1' AND PCM.id_esp = ? ";
                break;

            }

            $sql.= " AND PCM.aplica = 'SI' GROUP BY PCM.id_prop_mat_cli ORDER BY  PCM.id_etapa, PCM.id_prop, PCM.orden ASC";

            $conexion = $conexion->conexion();
            $consulta = $conexion->prepare($sql);

            switch($_SESSION["tipo_curimapu"]){
                case 1:
                    $consulta->bindValue("1",$_SESSION["enlace_curimapu"], PDO::PARAM_INT);
                    $consulta->bindValue("2",$especie, PDO::PARAM_INT);
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $consulta->bindValue("1",$especie, PDO::PARAM_INT);
                break;

            }
            
            $consulta->execute();

            $head = array();

            if($consulta->rowCount() > 0){
                $head = $consulta->fetchAll(PDO::FETCH_ASSOC);

            }

            $libroG = array();
            foreach($datos AS $dato){
                $ArrayResultado = array();

                $ArrayResultado["recome"] = $dato["recome"];
                $ArrayResultado["num_lote"] = $dato["num_lote"];
                $ArrayResultado["num_anexo"] = $dato["num_anexo"];
                $ArrayResultado["especie"] = $dato["especie"];
                $ArrayResultado["nom_hibrido"] = $dato["nom_hibrido"];
                $ArrayResultado["razon_social"] = $dato["razon_social"];
                $ArrayResultado["predio"] = $dato["predio"];
                $ArrayResultado["lote"] = $dato["lote"];
                
                foreach($head AS $valor){
                    
                    if(trim($valor["subHead"]) == "PICTURES"){
                    
                    }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = datoForaneo($valor["tabla"],$valor["campo"],$dato["id_ac"],$dato["id_quotation"],$dato["id_materiales"]);

                    }else{
                        $valores = explode(" | ",$dato["datos"]);
                        for($i = 0; $i < COUNT($valores); $i++){
                            $campos = explode(" && ",$valores[$i]);
                            if($valor["id_prop_mat_cli"] == $campos[1]){
                                $ArrayResultado[$valor["id_prop_mat_cli"]] = $campos[0]." && ".$campos[1]." && ".$campos[2];

                            }

                        }

                    }

                }
                
                array_push($libroG,$ArrayResultado);

            }

        break;

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
        <caption style="font-size: 2em; color: green;"> <strong> Libro de campo | Seccion <?=$tituloLibro?> </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>
        <?php
            if($libro == 1){
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
                        <?php
                            $columnas = array();
                            foreach($head as $dato){
                                if(trim($dato["subHead"]) != "PICTURES"){
                                    array_push($columnas, array(0 => $dato["id_prop_mat_cli"], 1 => $dato["tipo_campo"], 2 => $dato["tabla"], 3 => $dato["campo"], 4 => $dato["foraneo"], 5 => $dato["subHead"]));
    
                                    echo "<th>".$dato["subHead"]."</th>";

                                }

                            }
                        ?>
                    </tr>

                </thead>
            
                <tbody>
                    <?php
                        if(count($libroR) > 0):
                            $i = 0;
                            foreach($libroR AS $dato):
                                $i++;
                    ?>
                            <tr>
                                <?php
                                    for($i = 0; $i < count($columnas); $i++){
                                        $encontro = false;

                                        if($dato[$columnas[$i][0]] != ""){
                                            $encontro = true;
                                            if(strpos($dato[$columnas[$i][0]]," && ")){
                                                $valor = explode(" && ",$dato[$columnas[$i][0]]);

                                                echo "<td>".$valor[2]."</td>";

                                            }else{
                                                echo "<td>".$dato[$columnas[$i][0]]."</td>";

                                            }

                                        }
   
                                        if(!$encontro){
                                            echo "<td></td>";
        
                                        }

                                    }

                                ?>
                            </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="33" align="center"> No existen registros asociados a los parametros establecidos en el libro de campo (Resumen) </td>
                            </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
        <?php
            }elseif($libro == 2 || $libro == 3 || $libro == 4 || $libro == 5){
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
                    
                        $thead = array();
                        foreach($head as $dato){
                            $thead[$dato["Head"]] = (!isset($thead[$dato["Head"]])) ? 1 : $thead[$dato["Head"]]+1;

                        }

                    ?>
                    
                    <tr style="font-size: 1em; background: lightgreen">
                        <th rowspan='2'> # </th>
                        <th colspan='6'></th>
                        <th colspan='2'> Field </th>
                        <?php
                            $titulos = array();
                            $contColspan = 0;
                            foreach($head as $dato){
                                $contColspan += $thead[$dato["Head"]];
                                echo (!in_array($dato["Head"], $titulos)) ? "<th colspan='".$thead[$dato["Head"]]."'>".$dato["Head"]."</th>" : "";
                                if(!in_array($dato["Head"], $titulos)) array_push($titulos, $dato["Head"]);
                            }
                        ?>
                    </tr>
                    <tr style="font-size: 1em; background: lightgreen">
                        <th> Recomendaciones </th>
                        <th> Field Number </th>
                        <th> Anexo </th>
                        <th> Especie </th>
                        <th> Variedad </th>
                        <th> Agricultor </th>
                        <th> Predio </th>
                        <th> Potrero </th>
                        <?php
                            $columnas = array();
                            foreach($head as $dato){
                                array_push($columnas, array(0 => $dato["id_prop_mat_cli"], 1 => $dato["tipo_campo"], 2 => $dato["tabla"], 3 => $dato["campo"], 4 => $dato["foraneo"], 5 => $dato["subHead"]));

                                echo "<th>".$dato["subHead"]."</th>";

                            }
                        ?>
                    </tr>

                </thead>
            
                <tbody>
                    <?php
                        if(count($libroG) > 0):
                            $a = 0;
                            foreach($libroG AS $key => $dato):
                                $a++;

                    ?>
                                <tr>
                                    <td><?=$a?></td>
                                    <td><?=$dato["recome"]?></td>
                                    <td><?=$dato["num_lote"]?></td>
                                    <td><?=$dato["num_anexo"]?></td>
                                    <td><?=$dato["especie"]?></td>
                                    <td><?=$dato["nom_hibrido"]?></td>
                                    <td><?=$dato["razon_social"]?></td>
                                    <td><?=$dato["predio"]?></td>
                                    <td><?=$dato["lote"]?></td>
                                <?php
                                    for($i = 0; $i < count($columnas); $i++){
                                        $encontro = false;

                                        if(isset($dato[$columnas[$i][0]]) && $dato[$columnas[$i][0]] != ""){
                                            $encontro = true;
                                            if(strpos($dato[$columnas[$i][0]]," && ")){
                                                $valor = explode(" && ",$dato[$columnas[$i][0]]);

                                                echo "<td>".$valor[2]."</td>";

                                            }else{
                                                echo "<td>".$dato[$columnas[$i][0]]."</td>";

                                            }

                                        }
   
                                        if(!$encontro){
                                            echo "<td></td>";
        
                                        }

                                    }

                                ?>
                                </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="<?=count($columnas)+1?>" align="center"> No existen registros </td>
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
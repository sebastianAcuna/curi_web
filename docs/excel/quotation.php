<?php
    /* error_reporting(E_ALL);
    ini_set('display_errors', '1'); */
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=quotation".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);

    $cliente = (isset($_REQUEST['FQuo1'])?$_REQUEST['FQuo1']:NULL);
    $cliente = filter_var($cliente,FILTER_SANITIZE_STRING);
    if($cliente != "") $tituloFiltros .= " Cliente (".$cliente.")";

    /* $quotations = (isset($_REQUEST['FQuo2'])?$_REQUEST['FQuo2']:NULL);
    $quotations = filter_var($quotations,FILTER_SANITIZE_NUMBER_INT);
    if($quotations != "") $tituloFiltros .= " Quotations (".$quotations.")";
    
    $detalles = (isset($_REQUEST['FQuo3'])?$_REQUEST['FQuo3']:NULL);
    $detalles = filter_var($detalles,FILTER_SANITIZE_NUMBER_INT);
    if($detalles != "") $tituloFiltros .= " Detalles (".$detalles.")";
    
    $especies = (isset($_REQUEST['FQuo4'])?$_REQUEST['FQuo4']:NULL);
    $especies = filter_var($especies,FILTER_SANITIZE_NUMBER_INT);
    if($especies != "") $tituloFiltros .= " Especies (".$especies.")";
    
    $materiales = (isset($_REQUEST['FQuo5'])?$_REQUEST['FQuo5']:NULL);
    $materiales = filter_var($materiales,FILTER_SANITIZE_NUMBER_INT);
    if($materiales != "") $tituloFiltros .= " Materiales (".$materiales.")";
    
    $agricultores = (isset($_REQUEST['FQuo6'])?$_REQUEST['FQuo6']:NULL);
    $agricultores = filter_var($agricultores,FILTER_SANITIZE_NUMBER_INT);
    if($agricultores != "") $tituloFiltros .= " Agricultores (".$agricultores.")";
    
    $supervisores = (isset($_REQUEST['FQuo7'])?$_REQUEST['FQuo7']:NULL);
    $supervisores = filter_var($supervisores,FILTER_SANITIZE_NUMBER_INT);
    if($supervisores != "") $tituloFiltros .= " Supervisores (".$supervisores.")"; */
    
    $exl = (isset($_REQUEST['exl'])?$_REQUEST['exl']:NULL);
    $exl = filter_var($exl,FILTER_SANITIZE_NUMBER_INT);
    $name = (isset($_REQUEST['name'])?$_REQUEST['name']:NULL);
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $tipo = (isset($_REQUEST['tipo'])?$_REQUEST['tipo']:NULL);
    $tipo = filter_var($tipo,FILTER_SANITIZE_NUMBER_INT);

    /********/
    /* BIND */
    /********/

    $bind = array();

    /**********/
    /* Filtro */
    /**********/

    $filtro = "";
    if($cliente != ""){ $filtro .= " AND C.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$cliente."%")); }

    /**********/
    /* Having */
    /**********/

    /* $having = " HAVING Q.id_quotation != 0 ";
    if($quotations != ""){ $having .= " AND quotations = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $quotations)); }
    if($detalles != ""){ $having .= " AND detalles = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $detalles)); }
    if($especies != ""){ $having .= " AND especies = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $especies)); }
    if($materiales != ""){ $having .= " AND materiales = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $materiales)); }
    if($agricultores != ""){ $having .= " AND agricultores = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $agricultores)); }
    if($supervisores != ""){ $having .= " AND supervisores = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $supervisores)); } */

    /*********/
    /* Orden */
    /*********/

    $orden = "";
    switch($order){
        case 1:
            $orden = "ORDER BY C.razon_social ASC";
        break;
        case 2:
            $orden = "ORDER BY C.razon_social DESC";
        break;
        case 3:
            $orden = "ORDER BY quotations ASC";
        break;
        case 4:
            $orden = "ORDER BY quotations DESC";
        break;
        case 5:
            $orden = "ORDER BY detalles ASC";
        break;
        case 6:
            $orden = "ORDER BY detalles DESC";
        break;
        case 7:
            $orden = "ORDER BY especies ASC";
        break;
        case 8:
            $orden = "ORDER BY especies DESC";
        break;
        case 9:
            $orden = "ORDER BY materiales ASC";
        break;
        case 10:
            $orden = "ORDER BY materiales DESC";
        break;
        case 11:
            $orden = "ORDER BY agricultores ASC";
        break;
        case 12:
            $orden = "ORDER BY agricultores DESC";
        break;
        case 13:
            $orden = "ORDER BY supervisores ASC";
        break;
        case 14:
            $orden = "ORDER BY supervisores DESC";
        break;
        default:
            $orden = "ORDER BY C.razon_social ASC";
        break;

    }

    $conexion = new Conectar();
    $conexion = $conexion->conexion();
    if($tipo == '1'){
        $sql = "SELECT Q.id_quotation, Q.numero_contrato, C.razon_social, E.nombre, Q.obs, 
                SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                SUM(DQ.kg_contratados) AS kgs
                FROM quotation Q 
                INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                INNER JOIN especie E ON E.id_esp = Q.id_esp 
                WHERE Q.id_tempo = ? 
                GROUP BY Q.id_quotation ";
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

    }else{
        $sql = "SELECT Q.id_quotation, Q.numero_contrato, C.razon_social, E.nombre, Q.obs, 
                SUM(CASE WHEN UM.nombre LIKE '%HA%' THEN DQ.superficie_contr ELSE 0 END) AS superficieHA, 
                SUM(CASE WHEN UM.nombre LIKE '%MT%' THEN DQ.superficie_contr ELSE 0 END) AS superficieMT, 
                SUM(CASE WHEN UM.nombre LIKE '%SITE%' THEN DQ.superficie_contr ELSE 0 END) AS superficieSi, 
                SUM(CASE WHEN M.nombre LIKE '%USD%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoUSD, 
                SUM(CASE WHEN M.nombre LIKE '%EURO%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoEURO, 
                SUM(CASE WHEN M.nombre LIKE '%CLP%' THEN DQ.kg_contratados*DQ.precio ELSE 0 END) AS costoCLP,
                SUM(DQ.kg_contratados) AS kgs
                FROM quotation Q 
                INNER JOIN detalle_quotation DQ ON DQ.id_quotation = Q.id_quotation
                INNER JOIN moneda M ON M.id_moneda = DQ.id_moneda
                INNER JOIN unidad_medida UM ON UM.id_um = DQ.id_um
                INNER JOIN cliente C ON C.id_cli = Q.id_cli 
                INNER JOIN especie E ON E.id_esp = Q.id_esp 
                WHERE Q.id_tempo = ? AND Q.id_cli = ? 
                GROUP BY Q.id_quotation ";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
        $consulta->bindValue("2",$exl, PDO::PARAM_STR);

    }

    $consulta->execute();

    $quotation = array();

    if($consulta->rowCount() > 0){
        $quotation = $consulta->fetchAll(PDO::FETCH_ASSOC);

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
        <?
            if($tipo == '1'){
        ?>
            <caption style="font-size: 2em; color: green;"> <strong> Quotations </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>
        <?
            }else{
        ?>
            <caption style="font-size: 2em; color: green;"> <strong> Quotations <?=$name?> </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>
        <?
            } ;
        ?>

        <thead>
            <?php
                if(strlen($tituloFiltros) > 46):
            ?>
            <tr>
                <th colspan="18" style="background: lightsteelblue"> <?=$tituloFiltros?> </th>
            </tr>
            <?php
                endif;
            ?>
            <tr style="font-size: 1em; background: lightgreen">
                <th> # </th>
                <th> Número </th>
                <th> Cliente </th>
                <th> Especie </th>
                <th> Observacion </th>
                <th> Ha Contrated </th>
                <th> MT2 Contrated </th>
                <th> Site Contrated </th>
                <th> USD Contrated </th>
                <th> EURO Contrated </th>
                <th> CLP Contrated </th>
                <th> KG Contrated </th>
                <th> HA Measured </th>
                <th> KG Estimated </th>
                <th> USD Estimated </th>
                <th> USD Plan </th>
                <th> KG Export </th>
                <th> USD Sold </th>
            </tr>
        </thead>

        <tbody>
        <?php
            if(count($quotation) > 0):
                $i = 0;
                foreach($quotation AS $dato):
                    $i++;
        ?>
                    <tr> 
                        <td><?=$i?></td>
                        <td><?=$dato["numero_contrato"]?></td>
                        <td><?=$dato["razon_social"]?></td>
                        <td><?=$dato["nombre"]?></td>
                        <td><?=$dato["obs"]?></td>
                        <td><?=$dato["superficieHA"]?></td>
                        <td><?=$dato["superficieMT"]?></td>
                        <td><?=$dato["superficieSi"]?></td>
                        <td><?=$dato["costoUSD"]?></td>
                        <td><?=$dato["costoEURO"]?></td>
                        <td><?=$dato["costoCLP"]?></td>
                        <td><?=$dato["kgs"]?></td>
                        <td> Sin Información </td>
                        <td> Sin Información </td>
                        <td> Sin Información </td>
                        <td> Sin Información </td>
                        <td> Sin Información </td>
                        <td> Sin Información </td>
                    </tr>
        <?php
                endforeach;
            else:
        ?>
                <tr> 
                    <td colspan="18" align="center"> No existen registros asociados a los parametros establecidos en la quotation </td>
                </tr>
        <?php
            endif;
        ?>
        </tbody>
    </table>
</body>
</html>
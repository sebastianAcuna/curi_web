<?php
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=export".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);

    $export = (isset($_REQUEST['Export'])?$_REQUEST['Export']:NULL);
    $export = filter_var($export,FILTER_SANITIZE_NUMBER_INT);

    if($export == 1){
        $especie = (isset($_REQUEST['FPla1'])?$_REQUEST['FPla1']:NULL);
        $especie = filter_var($especie,FILTER_SANITIZE_STRING);
        if($especie != "") $tituloFiltros .= " Especie (".$especie.")";

        $temporada = (isset($_REQUEST['FPla2'])?$_REQUEST['FPla2']:NULL);
        $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
        if($temporada != "") $tituloFiltros .= " Temporada (".$temporada.")";

        $cliente = (isset($_REQUEST['FPla3'])?$_REQUEST['FPla3']:NULL);
        $cliente = filter_var($cliente,FILTER_SANITIZE_STRING);
        if($cliente != "") $tituloFiltros .= " Cliente (".$cliente.")";
        
        $variedad = (isset($_REQUEST['FPla4'])?$_REQUEST['FPla4']:NULL);
        $variedad = filter_var($variedad,FILTER_SANITIZE_STRING);
        if($variedad != "") $tituloFiltros .= " Variedad (".$variedad.")";
        
        $anexo = (isset($_REQUEST['FPla5'])?$_REQUEST['FPla5']:NULL);
        $anexo = filter_var($anexo,FILTER_SANITIZE_STRING);
        if($anexo != "") $tituloFiltros .= " Anexo (".$anexo.")";
        
        $lote = (isset($_REQUEST['FPla6'])?$_REQUEST['FPla6']:NULL);
        $lote = filter_var($lote,FILTER_SANITIZE_STRING);
        if($lote != "") $tituloFiltros .= " Lote Cliente (".$lote.")";
        
        $agricultor = (isset($_REQUEST['FPla7'])?$_REQUEST['FPla7']:NULL);
        $agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);
        if($agricultor != "") $tituloFiltros .= " Agricultor (".$agricultor.")";
        
        $hectareas = (isset($_REQUEST['FPla8'])?$_REQUEST['FPla8']:NULL);
        $hectareas = filter_var($hectareas,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($hectareas != "") $tituloFiltros .= " Hectareas (".$hectareas.")";
        
        $fin = (isset($_REQUEST['FPla9'])?$_REQUEST['FPla9']:NULL);
        $fin = filter_var($fin,FILTER_SANITIZE_STRING);
        if($fin != "") $tituloFiltros .= " Fin de lote (".$fin.")";
        
        $kgsR = (isset($_REQUEST['FPla10'])?$_REQUEST['FPla10']:NULL);
        $kgsR = filter_var($kgsR,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($kgsR != "") $tituloFiltros .= " Kgs Recepcionado (".$kgsR.")";
        
        $kgsL = (isset($_REQUEST['FPla11'])?$_REQUEST['FPla11']:NULL);
        $kgsL = filter_var($kgsL,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($kgsL != "") $tituloFiltros .= " Kgs Limpios (".$kgsL.")";
        
        $kgsE = (isset($_REQUEST['FPla12'])?$_REQUEST['FPla12']:NULL);
        $kgsE = filter_var($kgsE,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($kgsE != "") $tituloFiltros .= " Kgs Exportados (".$kgsE.")";
    
        /**********/
        /* Filtro */
        /**********/

        /* $filtro = " WHERE F.id_est_fic = 2";
        if($especie != "") $filtro .= " AND x LIKE '%$especie%'";
        if($temporada != "") $filtro .= " AND x LIKE '%$temporada%'";
        if($cliente != "") $filtro .= " AND x LIKE '%$cliente%'";
        if($variedad != "") $filtro .= " AND  x LIKE '%$variedad%'";
        if($anexo != "") $filtro .= " AND x LIKE '%$anexo%'";
        if($lote != "") $filtro .= " AND x LIKE '%$lote%'";
        if($agricultor != "") $filtro .= " AND x LIKE '%$agricultor%'";
        if($hectareas != "") $filtro .= " AND x LIKE '%$hectareas%'";
        if($fin != "") $filtro .= " AND x LIKE '%$fin%'";
        if($kgsR != "") $filtro .= " AND x LIKE '%$kgsR%'";
        if($kgsL != "") $filtro .= " AND x LIKE '%$kgsL%'";
        if($kgsE != "") $filtro .= " AND x LIKE '%$kgsE%'"; */

        /*********/
        /* Orden */
        /*********/

        /* $orden = "";
        switch($order){
            default:
                $orden = "ORDER BY fieldman DESC";
            break;

        } */

        /*******/
        /* SQL */
        /*******/

        /* $conexion = new Conectar();
        $sql = "";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
        $consulta->execute(); */

        $exportsP = array();

        /* if($consulta->rowCount() > 0){
            $exportsP = $consulta->fetchAll(PDO::FETCH_ASSOC);

        } */

        $tituloFicha = "Planta";

    }elseif($export == 2){
        $especie = (isset($_REQUEST['FRec1'])?$_REQUEST['FRec1']:NULL);
        $especie = filter_var($especie,FILTER_SANITIZE_STRING);
        if($especie != "") $tituloFiltros .= " Especie (".$especie.")";

        $temporada = (isset($_REQUEST['FRec2'])?$_REQUEST['FRec2']:NULL);
        $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
        if($temporada != "") $tituloFiltros .= " Temporada (".$temporada.")";
        
        $variedad = (isset($_REQUEST['FRec3'])?$_REQUEST['FRec3']:NULL);
        $variedad = filter_var($variedad,FILTER_SANITIZE_STRING);
        if($variedad != "") $tituloFiltros .= " Variedad (".$variedad.")";
        
        $anexo = (isset($_REQUEST['FRec4'])?$_REQUEST['FRec4']:NULL);
        $anexo = filter_var($anexo,FILTER_SANITIZE_STRING);
        if($anexo != "") $tituloFiltros .= " Anexo (".$anexo.")";
        
        $agricultor = (isset($_REQUEST['FRec5'])?$_REQUEST['FRec5']:NULL);
        $agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);
        if($agricultor != "") $tituloFiltros .= " Agricultor (".$agricultor.")";
        
        $rut = (isset($_REQUEST['FRec6'])?$_REQUEST['FRec6']:NULL);
        $rut = filter_var($rut,FILTER_SANITIZE_STRING);
        if($rut != "") $tituloFiltros .= " Rut Agricultor (".$rut.")";
        
        $lote = (isset($_REQUEST['FRec7'])?$_REQUEST['FRec7']:NULL);
        $lote = filter_var($lote,FILTER_SANITIZE_STRING);
        if($lote != "") $tituloFiltros .= " Lote Campo (".$lote.")";
        
        $numero = (isset($_REQUEST['FRec8'])?$_REQUEST['FRec8']:NULL);
        $numero = filter_var($numero,FILTER_SANITIZE_NUMBER_INT);
        if($numero != "") $tituloFiltros .= " Numero Guia (".$numero.")";
        
        $peso = (isset($_REQUEST['FRec9'])?$_REQUEST['FRec9']:NULL);
        $peso = filter_var($peso,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($peso != "") $tituloFiltros .= " Peso Bruto (".$peso.")";
        
        $tara = (isset($_REQUEST['FRec10'])?$_REQUEST['FRec10']:NULL);
        $tara = filter_var($tara,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($tara != "") $tituloFiltros .= " Tara (".$tara.")";
        
        $neto = (isset($_REQUEST['FRec11'])?$_REQUEST['FRec11']:NULL);
        $neto = filter_var($neto,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        if($neto != "") $tituloFiltros .= " Peso Neto (".$neto.")";

        /**********/
        /* Filtro */
        /**********/

        /* $filtro = " WHERE x = 1";
        if($especie != ""){ $filtro .= " AND x LIKE '%$especie%'"; }
        if($temporada != ""){ $filtro .= " AND x LIKE '%$temporada%'"; }
        if($variedad != ""){ $filtro .= " AND x LIKE '%$variedad%'"; }
        if($anexo != ""){ $filtro .= " AND x LIKE '%$anexo%'"; }
        if($agricultor != ""){ $filtro .= " AND  x LIKE '%$agricultor%'"; }
        if($rut != ""){ $filtro .= " AND x LIKE '%$rut%'"; }
        if($lote != ""){ $filtro .= " AND x LIKE '%$lote%'"; }
        if($numero != ""){ $filtro .= " AND x LIKE '%$numero%'"; }
        if($peso != ""){ $filtro .= " AND x LIKE '%$peso%'"; }
        if($tara != ""){ $filtro .= " AND x LIKE '%$tara%'"; }
        if($neto != ""){ $filtro .= " AND x LIKE '%$neto%'"; } */
        
        /*********/
        /* Orden */
        /*********/

        /* $orden = "";
        switch($order){
            default:
                $orden = "ORDER BY F.id_export ASC";
            break;
        } */

        /*******/
        /* SQL */
        /*******/

        /* $conexion = new Conectar();
        $sql = "";
        $conexion = $conexion->conexion();
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
        $consulta->execute(); */

        $exportsR = array();

        /* if($consulta->rowCount() > 0){
            $exportsR = $consulta->fetchAll(PDO::FETCH_ASSOC);

        } */

        $tituloFicha = "Recepcion";

    }
    $conexion = new Conectar();
    $sql = "SELECT nombre FROM temporada WHERE id_tempo = ?";
    $conexion = $conexion->conexion();
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
        <caption style="font-size: 2em; color: green;"> <strong> Export <?=$tituloFicha?> </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>
        <?php
            if($export == 1){
        ?>
                <thead>
                    <?php
                        if(strlen($tituloFiltros) > 46):
                    ?>
                    <tr>
                        <th colspan="13" style="background: lightsteelblue"> <?=$tituloFiltros?> </th>
                    </tr>
                    <?php
                        endif;
                    ?>
                    <tr style="font-size: 1em; background: lightgreen">
                            <th> # </th>
                            <th> Especie </th>
                            <th> Temporada </th>
                            <th> Cliente </th>
                            <th> Variedad </th>
                            <th> Anexo </th>
                            <th> Lote Cliente </th>
                            <th> Agricultor </th>
                            <th> Hectareas </th>
                            <th> Fin de Lote </th>
                            <th> Kgs Recepcionado </th>
                            <th> Kgs Limpios </th>
                            <th> Kgs Exportados </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                        if(count($exportsP) > 0):
                            $i = 0;
                            foreach($exportsP AS $dato):
                                $i++;
                    ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="13" align="center"> No existen registros asociados a los parametros establecidos en export planta </td>
                            </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
        <?php
            }elseif($export == 2){
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
                        <th> Especie </th>
                        <th> Temporada </th>
                        <th> Variedad </th>
                        <th> Anexo </th>
                        <th> Agricultor </th>
                        <th> Rut Agricultor </th>
                        <th> Lote Campo </th>
                        <th> Número Guía </th>
                        <th> Peso Bruto </th>
                        <th> Tara </th>
                        <th> Peso Neto </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                        if(count($exportsR) > 0):
                            $i = 0;
                            foreach($exportsR AS $dato):
                                $i++;
                    ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                            <tr> 
                                <td colspan="12" align="center"> No existen registros asociados a los parametros establecidos en export recepcion </td>
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
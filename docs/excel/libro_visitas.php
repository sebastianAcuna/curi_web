<?php
    /* error_reporting(E_ALL);
    ini_set('display_errors', '1'); */
    session_start();
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=libro".date("d-m-Y").".xls");

    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_NUMBER_INT);
    
    $especie = (isset($_REQUEST["Especie"])?$_REQUEST["Especie"]:NULL);
    $especie = filter_var($especie,FILTER_SANITIZE_NUMBER_INT);



    function formatonumeros_sin_ceros($valor) {
        list($phpEntero,$phpDecimal)=split("\.",$valor);
        $LargoDecimal=strlen($phpDecimal);
        $Largo=0;
        for($i=0;$i<=$LargoDecimal;$i++)
        {
            if($phpDecimal{$i}!=0)
                {
                    $Largo=$i+1;
                } 
        }
        $formato_num = number_format($valor,$Largo,',','.');
        return $formato_num;
    }


    /*******/
    /* SQL */
    /*******/
    $conexion = new Conectar();
    $sql = "SELECT AC.num_anexo, M.nom_hibrido, A.razon_social, P.nombre AS predio, L.nombre AS lote, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS usuario, V.fecha_r, V.hora_r, V.estado_fen, V.estado_crec, V.estado_male, V.estado_fito, V.cosecha, V.estado_gen_culti, V.hum_del_suelo, V.obs, V.recome, V.obs_ef, V.obs_cre, V.obs_male, V.obs_fito, V.obs_cose, V.obs_gen, V.obs_hum, V.porcentaje_humedad 
            FROM visita V 
            INNER JOIN anexo_contrato AC USING(id_ac) 
            INNER JOIN lote L USING(id_lote) 
            INNER JOIN predio P USING(id_pred) 
            INNER JOIN contrato_anexo_temporada CAT USING (id_ac)
            INNER JOIN contrato_agricultor CA ON (CA.id_cont = CAT.id_cont) 
            INNER JOIN agricultor A USING(id_agric) 
            INNER JOIN materiales M USING(id_materiales) 
            INNER JOIN usuarios U USING(id_usuario) 
            WHERE CAT.id_tempo = ? AND M.id_esp = ? AND V.estado_sincro = 1 AND id_est_vis = 2 
            GROUP BY V.id_visita  
            ORDER BY AC.num_anexo, V.fecha_r, V.hora_r ASC";

    $conexion = $conexion->conexion();
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
    $consulta->bindValue("2",$especie, PDO::PARAM_STR);
    $consulta->execute();

    $datos = array();

    if($consulta->rowCount() > 0){
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    }

    $sql = "SELECT nombre FROM temporada WHERE id_tempo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
    $consulta->execute();

    $temporada = "";
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetch(PDO::FETCH_ASSOC);

    }

    $sql = "SELECT nombre FROM especie WHERE id_esp = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$especie, PDO::PARAM_STR);
    $consulta->execute();

    $especie = "";
    if($consulta->rowCount() > 0){
        $especie = $consulta->fetch(PDO::FETCH_ASSOC);

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
        <caption style="font-size: 2em; color: green;"> <strong> Visitas del Libro de campo </strong> ( Temporada : <?=$temporada["nombre"]?> ) ( Especie : <?=$especie["nombre"]?> )</caption>
        <thead>
            <tr>
                <th> Anexo </th>
                <th> Variedad </th>
                <th> Agricultor </th>
                <th> Predio </th>
                <th> Potrero </th>
                <th> Fieldman </th>
                <th> Fecha visita </th>
                <th> Hora visita </th>
                <th> Estado feneologico </th>
                <th> Observacion F.</th>
                <th> Estado de crecimiento </th>
                <th> Observacion E.C.</th>
                <th> Estado de maleza </th>
                <th> Observacion M.</th>
                <th> Estado fitosanitario </th>
                <th> Observacion E.F.</th>
                <th> Cosecha </th>
                <th> Observacion C.</th>
                <th> Estado general </th>
                <th> Observacion E.G.</th>
                <th> Humedad del suelo </th>
                <th> Observacion H.S.</th>
                <th> Porcentaje de humedad </th>
                <th> Observacion general </th>
                <th> Recomendacion </th>
            </tr>
        </thead>
        <tbody>
            <?
                if(COUNT($datos) > 0){
                    foreach($datos as $dato){
            ?>
                        <tr>
                            <td> <?=$dato["num_anexo"]?> </td>
                            <td> <?=$dato["nom_hibrido"]?> </td>
                            <td> <?=$dato["razon_social"]?> </td>
                            <td> <?=$dato["predio"]?> </td>
                            <td> <?=$dato["lote"]?> </td>
                            <td> <?=$dato["usuario"]?> </td>
                            <td> <?=$dato["fecha_r"]?> </td>
                            <td> <?=$dato["hora_r"]?> </td>
                            <td> <?=$dato["estado_fen"]?> </td>
                            <td> <?=$dato["obs_ef"]?> </td>
                            <td> <?=$dato["estado_crec"]?> </td>
                            <td> <?=$dato["obs_cre"]?> </td>
                            <td> <?=$dato["estado_male"]?> </td>
                            <td> <?=$dato["obs_male"]?> </td>
                            <td> <?=$dato["estado_fito"]?> </td>
                            <td> <?=$dato["obs_fito"]?> </td>
                            <td> <?=$dato["cosecha"]?> </td>
                            <td> <?=$dato["obs_cose"]?> </td>
                            <td> <?=$dato["estado_gen_culti"]?> </td>
                            <td> <?=$dato["obs_gen"]?> </td>
                            <td> <?=$dato["hum_del_suelo"]?> </td>
                            <td> <?=$dato["obs_hum"]?> </td>
                            <td> <?=formatonumeros_sin_ceros($dato["porcentaje_humedad"])?> </td>
                            <td> <?=$dato["obs"]?> </td>
                            <td> <?=$dato["recome"]?> </td>
                        </tr>
            <?
                    }
                }else{
            ?>
                    <tr>
                        <td colspan="24" align="center"> No existen visitas </td>
                    </tr>
            <?
                }
            ?>
        </tbody>
    </table>
</body>
</html>
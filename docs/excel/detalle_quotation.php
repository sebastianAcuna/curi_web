<?php
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=detalle_quotation-".date("d-m-Y").".xls");
    
    $quotation = (isset($_REQUEST['Info'])?$_REQUEST['Info']:NULL);
    $quotation = filter_var($quotation,FILTER_SANITIZE_STRING);

    $numero = (isset($_REQUEST['Num'])?$_REQUEST['Num']:NULL);
    $numero = filter_var($numero,FILTER_SANITIZE_STRING);

    $conexion = new Conectar();
    $sql = "SELECT D.id_de_quo, E.nombre AS especie, M.nom_hibrido, D.superficie_contr, UM.nombre AS unidadM, D.kg_contratados, D.precio, D.kgxha, Mo.nombre AS moneda, I.nombre AS incoterm, C.nombre AS condicion, TC.nombre AS certificacion, D.humedad, D.germinacion, D.pureza_genetica, D.fecha_recep_sem, D.pureza_fisica, D.fecha_despacho, D.enfermedades, D.maleza, D.declaraciones, TE.nombre AS envase, TE.neto, TD.nombre AS despacho, D.observaciones_del_precio
            FROM detalle_quotation D
            INNER JOIN materiales M ON M.id_materiales = D.id_materiales
            INNER JOIN especie E ON E.id_esp = M.id_esp
            INNER JOIN unidad_medida UM ON UM.id_um = D.id_um
            INNER JOIN moneda Mo ON Mo.id_moneda = D.id_moneda
            INNER JOIN incoterms I ON I.id_incot = D.id_incot
            INNER JOIN condicion C ON C.id_tipo_condicion = D.id_tipo_condicion
            INNER JOIN tipo_de_certificacion TC ON TC.id_tipo_cert = D.id_tipo_cert
            INNER JOIN tipo_de_envase TE ON TE.id_tipo_envase = D.id_tipo_envase
            INNER JOIN tipo_de_despacho TD ON TD.id_tipo_desp = D.id_tipo_desp
            WHERE D.id_quotation = ?";
    $conexion = $conexion->conexion();
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$quotation, PDO::PARAM_STR);
    $consulta->execute();

    $detalle = array();

    if($consulta->rowCount() > 0){
        $detalle = $consulta->fetchAll(PDO::FETCH_ASSOC);

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
        <caption style="font-size: 2em; color: green;"> <strong> Detalle de quotation  N°<?=$numero?> </strong> </caption>

        <thead>
            <tr style="font-size: 1em; background: lightgreen">
                <th> # </th>
                <th> Especie </th>
                <th> Variedad </th>
                <th> Superficie contratada </th>
                <th> Superficie </th>
                <th> Kg Contracted </th>
                <th> Price </th>
                <th> (=) Contrated </th>
                <th> Currency </th>
                <th> Kg/Ha </th>
                <th> Incoterms </th>
                <th> Condition </th>
                <th> Certification </th>
                <th> Humedad </th>
                <th> Germinación </th>
                <th> Pureza genética </th>
                <th> Fecha recepción de semilla </th>
                <th> Pureza fisica </th>
                <th> Fecha de despacho </th>
                <th> Enfermedades </th>
                <th> Malezas </th>
                <th> Declaraciones adicionales </th>
                <th> Tipo de envase </th>
                <th> Kg Envase </th>
                <th> Tipo de despacho </th>
                <th> Observaciones de precio </th>
                <th> N° Detalle </th>
            </tr>
        </thead>

        <tbody>
        <?php
            if(count($detalle)):
                $i = 0;
                foreach($detalle AS $dato):
                    $i++;
        ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$dato["especie"]?></td>
                        <td><?=$dato["nom_hibrido"]?></td>
                        <td><?=number_format($dato["superficie_contr"], 2, ",", "." )?></td>
                        <td><?=$dato["unidadM"]?></td>
                        <td><?=number_format($dato["kg_contratados"], 2, ",", "." )?></td>
                        <td><?=number_format($dato["precio"], 2, ",", "." )?></td>
                        <td><?=number_format(round(($dato["kg_contratados"]*$dato["precio"]),2), 2, ",", "." )?></td>
                        <td><?=$dato["moneda"]?></td>
                        <td><?=number_format($dato["kgxha"], 2, ",", "." )?></td>
                        <td><?=$dato["incoterm"]?></td>
                        <td><?=$dato["condicion"]?></td>
                        <td><?=$dato["certificacion"]?></td>
                        <td><?=number_format($dato["humedad"], 2, ",", "." )?></td>
                        <td><?=$dato["germinacion"]?></td>
                        <td><?=$dato["pureza_genetica"]?></td>
                        <td><?=$dato["fecha_recep_sem"]?></td>
                        <td><?=$dato["pureza_fisica"]?></td>
                        <td><?=$dato["fecha_despacho"]?></td>
                        <td><?=$dato["enfermedades"]?></td>
                        <td><?=$dato["maleza"]?></td>
                        <td><?=$dato["declaraciones"]?></td>
                        <td><?=$dato["envase"]?></td>
                        <td><?=$dato["neto"]?></td>
                        <td><?=$dato["despacho"]?></td>
                        <td><?=$dato["observaciones_del_precio"]?></td>
                        <td><?=$dato["id_de_quo"]?></td>
                    </tr>
        <?php
                endforeach;
            else:
        ?>
                <tr> 
                    <td colspan="19" align="center"> No existen detalles para la quotation </td>
                </tr>
        <?php
            endif;
        ?>
        </tbody>
    </table>
</body>
</html>
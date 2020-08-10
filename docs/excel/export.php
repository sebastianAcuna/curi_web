<?php

//  ini_set('display_errors', 1);
//     ini_set('display_startup_errors', 1);
//     error_reporting(E_ALL);
    // require_once '../../core/db/conectarse_db.php';
    require "../../core/db/conectarse_db.php";
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=export".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $respuesta ;
    $filtro = "";
    $bind = array() ;
   
    $filtro = " WHERE id_export IS NOT NULL ";
    if($_REQUEST['campo0'] != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $_REQUEST['campo0'])); }
    if($_REQUEST['campo1'] != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo1']."%")); }
    if($_REQUEST['campo2'] != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo2']."%")); }
    if($_REQUEST['campo3'] != ""){ $filtro .= " AND AC.num_anexo LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo3']."%")); }
    if($_REQUEST['Temporada'] != ""){ $filtro .= " AND ST.id_tempo = ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $_REQUEST['Temporada'])); }
    if($_REQUEST['campo4'] != ""){ $filtro .= " AND A.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo4']."%")); }
    
    if($_REQUEST['campo5'] != ""){ $filtro .= " AND ST.lote_cliente LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo5']."%")); }
    
    if($_REQUEST['campo6'] != ""){ $filtro .= " AND ST.hectareas LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo6']."%")); }
    if($_REQUEST['campo7'] != ""){ $filtro .= " AND ST.fin_lote LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo7']."%")); }



    if($_REQUEST['campo8'] != ""){ $filtro .= " AND ST.kgs_recepcionado LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo8']."%")); }
    if($_REQUEST['campo9'] != ""){ $filtro .= " AND ST.kgs_limpios LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo9']."%")); }
    if($_REQUEST['campo10'] != ""){ $filtro .= " AND ST.kgs_exportados LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST['campo10']."%")); }


     /* CONEXION */
     $conexion = new Conectar();
     $conexion = $conexion->conexion();

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
                        $filtro ";


        // echo $sql;
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
            $respuesta = $consulta->fetchAll(PDO::FETCH_ASSOC);

        }

        $consulta = NULL;





    $sql = "SELECT * FROM temporada WHERE id_tempo = ? ";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$_REQUEST['Temporada'], PDO::PARAM_STR);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

?>
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table border="1" cellpadding="2" cellspacing="0" width="100%"> 
        <caption style="font-size: 2em; color: green;"> <strong> Export <?=$tituloFicha?> </strong> ( Temporada : <?=$temporada[0]["nombre"]?> ) </caption>
        
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
                            foreach($respuesta AS $value):
                                $i++; ?>
                                <tr>
                                <td> <?php echo $i;?></td>
                                    <td> <?php echo $value["nombre_especie"];?></td>
                                    <td> <?php echo $value["nombre_cliente"];?></td>
                                    <td> <?php echo $value["nombre_material"];?></td>
                                    <td> <?php echo $value["num_anexo"];?></td>
                                    <td> <?php echo $value["lote_cliente"];?></td>
                                    <td> <?php echo $value["nombre_agricultor"];?></td>
                                    <td> <?php echo $value["hectareas"];?></td>
                                    <td> <?php echo $value["fin_lote"];?></td>
                                    <td> <?php echo $value["kgs_recepcionado"];?></td>
                                    <td> <?php echo $value["kgs_limpios"];?></td>
                                    <td> <?php echo $value["kgs_exportados"];?></td>
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
    </table>
</body>
</html>
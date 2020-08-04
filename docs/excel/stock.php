<?php
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=stock".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    require "../../core/db/conectarse_db.php";

    $respuesta ;
    $filtro = "";
    $bind = array() ;
   

    if($_REQUEST["campo0"] != ""){ $filtro .= " AND ST.id_esp =  ? "; array_push($bind,array("Tipo" => "INT", "Dato" => $_REQUEST["campo0"])); }
    if($_REQUEST["campo1"] != ""){ $filtro .= " AND ST.fecha_recepcion = ? "; array_push($bind,array("Tipo" => "STR", "Dato" => $_REQUEST["campo1"])); }
    if($_REQUEST["campo2"] != ""){ $filtro .= " AND C.razon_social LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo2"]."%")); }

    if($_REQUEST["campo3"] != ""){ $filtro .= " AND M.nom_hibrido LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo3"]."%")); }
    if($_REQUEST["campo4"] != ""){ $filtro .= " AND ST.genetic LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo4"]."%")); }
    if($_REQUEST["campo5"] != ""){ $filtro .= " AND ST.trait LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo5"]."%")); }
    if($_REQUEST["campo6"] != ""){ $filtro .= " AND ST.sag_resolution_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo6"]."%")); }
    if($_REQUEST["campo7"] != ""){ $filtro .= " AND ST.curimapu_batch_number LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo7"]."%")); }



    if($_REQUEST["campo8"] != ""){ $filtro .= " AND ST.customer_batch LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo8"]."%")); }
    if($_REQUEST["campo9"] != ""){ $filtro .= " AND ST.quantity_kg LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo9"]."%")); }
    if($_REQUEST["campo10"] != ""){ $filtro .= " AND ST.notes LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo10"]."%")); }
    if($_REQUEST["campo11"] != ""){ $filtro .= " AND ST.seed_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo11"]."%")); }
    if($_REQUEST["campo12"] != ""){ $filtro .= " AND ST.curimapu_treated_by LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo12"]."%")); }
    if($_REQUEST["campo13"] != ""){ $filtro .= " AND ST.customer_tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo13"]."%")); }
    if($_REQUEST["campo14"] != ""){ $filtro .= " AND ST.customer_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo14"]."%")); }
    if($_REQUEST["campo15"] != ""){ $filtro .= " AND ST.tsw LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo15"]."%")); }
    if($_REQUEST["campo16"] != ""){ $filtro .= " AND ST.curimapu_germ_porcentaje LIKE ? "; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$_REQUEST["campo16"]."%")); }


     /* CONEXION */
     $conexion = new Conectar();
     $conexion = $conexion->conexion();

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
            $filtro  ";


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

    
    

?>
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table border="1" cellpadding="2" cellspacing="0" width="100%"> 
        <caption style="font-size: 2em; color: green;"> <strong> Stock Seed ( <?=date("d-m-Y")?> ) </strong> </caption>

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
                <th> Especie </th>
                <th> Fecha de Recepción </th>
                <th> Cliente </th>
                <th> Variedad </th>
                <th> Genetic </th>
                <th> Trait </th>
                <th> Sag Resolution Number </th>
                <th> Curimapu Batch Number </th>
                <th> Customer Batch </th>
                <th> Quantity Kg </th>
                <th> Notes </th>
                <th> Seed Treated by </th>
                <th> Curimapu Treated by </th>
                <th> Customer TSW </th>
                <th> Customer Germ % </th>
                <th> TSW </th>
                <th> Curimapu Germ % </th>
            </tr>
        </thead>

        <tbody>
        <?php
            $cont = 0;
                foreach($respuesta AS $value): 
                    $cont++;
                ?>
                    <tr> 
                            <td> <?php echo $cont;?></td>
                            <td> <?php echo $value["nombre_especie"];?></td>
                            <td> <?php echo $value["fecha_recepcion"];?></td>
                            <td> <?php echo $value["razon_social"];?></td>
                            <td> <?php echo $value["nombre_material"];?></td>
                            <td> <?php echo $value["genetic"];?></td>
                            <td> <?php echo $value["trait"];?></td>
                            <td> <?php echo $value["sag_resolution_number"];?></td>
                            <td> <?php echo $value["curimapu_batch_number"];?></td>
                            <td> <?php echo $value["customer_batch"];?></td>
                            <td> <?php echo $value["quantity_kg"];?></td>
                            <td> <?php echo $value["notes"];?></td>
                            <td> <?php echo $value["seed_treated_by"];?></td>
                            <td> <?php echo $value["curimapu_treated_by"];?></td>
                            <td> <?php echo $value["customer_tsw"];?></td>
                            <td> <?php echo $value["customer_germ_porcentaje"];?></td>
                            <td> <?php echo $value["tsw"];?></td>
                            <td> <?php echo $value["curimapu_germ_porcentaje"];?></td>
                    
                    </tr>
                 <?php  endforeach;  ?>
        </tbody>
    </table>
</body>
</html>
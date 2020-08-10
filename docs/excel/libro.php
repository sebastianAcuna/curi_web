<?php
    /* error_reporting(E_ALL);
    ini_set('display_errors', '1'); */
    require_once '../../core/db/conectarse_db.php';

    $incluyendoLibro = true;
    require_once '../../core/models/libro.php';

    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=libro".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);
    
    $especie = (isset($_REQUEST["Especie"])?$_REQUEST["Especie"]:NULL);
    $especie = filter_var($especie,FILTER_SANITIZE_STRING);

    $etapa = (isset($_REQUEST['Libro'])?$_REQUEST['Libro']:NULL);
    $etapa = filter_var($etapa,FILTER_SANITIZE_NUMBER_INT);

    switch($etapa){
        case 1:
            $tituloLibro = "Resumen";
            
            $Libro = new Libro();

            $Libro->set_id_temporada($temporada);
            $Libro->set_etapa(1);
            $Libro->set_id_esp($especie);
            $Libro->set_orden($order);

            $Libro->headTabla();
            $head = $Libro->data();

            $Libro->traerDatosResumen();
            $datos = $Libro->data();

            $libroR = array();
            foreach($datos AS $dato){
                $ArrayResultado = array();

                if($dato["visita"] != ""){
                    $ArrayResultado["visita"] = $dato["visita"];
                    $ArrayResultado["anexo"] = $dato["id_ac"];
                    
                    foreach($head AS $valor){
                        
                        if(trim($valor["subHead"]) == "PICTURES"){
                            $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                        
                        }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                            $Libro->set_tabla($valor["tabla"]);
                            $Libro->set_campo($valor["campo"]);
                            $Libro->set_Q($dato["id_quotation"]);
                            $Libro->set_AC($dato["id_ac"]);
                            $Libro->set_M($dato["id_materiales"]);
                            $Libro->datoForaneo();
                            $ArrayResultado[$valor["id_prop_mat_cli"]] = $Libro->data();
                        }else{
                            $ArrayResultado[$valor["id_prop_mat_cli"]] = "";

                        }

                    }

                    array_push($libroR,$ArrayResultado);

                }


            }

        break;

        case 2:
        case 3:
        case 4:

            if($etapa == 2){
                $tituloLibro = "Sowing";
                $etapa = 2;

            }elseif($etapa == 3){
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
            if($pre != "") $tituloFiltros .= " Predio (".$pre.")";

            $pot = (isset($_REQUEST["Campo7"])?$_REQUEST["Campo7"]:NULL);
            $pot = filter_var($pot,FILTER_SANITIZE_STRING);
            if($pot != "") $tituloFiltros .= " Potrero (".$pot.")";

            $libro = new Libro();

            $libro->set_rec($rec);
            $libro->set_num($num);
            $libro->set_ane($ane);
            $libro->set_esp($esp);
            $libro->set_var($var);
            $libro->set_agr($agr);
            $libro->set_pre($pre);
            $libro->set_pot($pot);

            $libro->set_id_temporada($temporada);
            $libro->set_etapa($etapa);
            $libro->set_id_esp($especie);
            $libro->set_orden($order);

            $libro->headTabla();
            $head = $libro->data();

            $libro->traerDatosTabla();
            $datos = $libro->data();

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
                $ArrayResultado["visita"] = $dato["visita"];
                $ArrayResultado["anexo"] = $dato["id_ac"];

                foreach($head AS $valor){
                    
                    if(trim($valor["subHead"]) == "PICTURES"){
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                    
                    }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                        $libro->set_tabla($valor["tabla"]);
                        $libro->set_campo($valor["campo"]);
                        $libro->set_Q($dato["id_quotation"]);
                        $libro->set_AC($dato["id_ac"]);
                        $libro->set_M($dato["id_materiales"]);
                        $libro->datoForaneo();
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = $libro->data();

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
            if($pre != "") $tituloFiltros .= " Predio (".$pre.")";

            $pot = (isset($_REQUEST["Campo7"])?$_REQUEST["Campo7"]:NULL);
            $pot = filter_var($pot,FILTER_SANITIZE_STRING);
            if($pot != "") $tituloFiltros .= " Potrero (".$pot.")";

            $libro = new Libro();

            $libro->set_rec($rec);
            $libro->set_num($num);
            $libro->set_ane($ane);
            $libro->set_esp($esp);
            $libro->set_var($var);
            $libro->set_agr($agr);
            $libro->set_pre($pre);
            $libro->set_pot($pot);

            $libro->set_id_temporada($temporada);
            $libro->set_etapa($etapa);
            $libro->set_id_esp($especie);
            $libro->set_orden($order);

            $libro->headAll();
            $head = $libro->data();

            $libro->traerDatosAll();
            $datos = $libro->data();

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
                $ArrayResultado["visita"] = $dato["visita"];
                $ArrayResultado["anexo"] = $dato["id_ac"];

                foreach($head AS $valor){
                    
                    if(trim($valor["subHead"]) == "PICTURES"){
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = "PICTURES";
                    
                    }else if($valor["foraneo"] == "SI" && $valor["tabla"] != "" && $valor["campo"] != "" && $valor["tabla"] != "detalle_visita_prop"){
                        $libro->set_tabla($valor["tabla"]);
                        $libro->set_campo($valor["campo"]);
                        $libro->set_Q($dato["id_quotation"]);
                        $libro->set_AC($dato["id_ac"]);
                        $libro->set_M($dato["id_materiales"]);
                        $libro->datoForaneo();
                        $ArrayResultado[$valor["id_prop_mat_cli"]] = $libro->data();

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

    $conexion = new Conectar();
    $conexion = $conexion->conexion();
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
            if($etapa == 1){
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
                            $colspan = 0;
                            $columnas = array();
                            foreach($head as $dato){
                                if(trim($dato["subHead"]) != "PICTURES"){
                                    array_push($columnas, array(0 => $dato["id_prop_mat_cli"], 1 => $dato["tipo_campo"], 2 => $dato["tabla"], 3 => $dato["campo"], 4 => $dato["foraneo"], 5 => $dato["subHead"]));
    
                                    echo "<th>".$dato["subHead"]."</th>";

                                    $colspan++;
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

                                                echo "<td>".mb_strtoupper($valor[2], 'UTF-8')."</td>";

                                            }else{
                                                echo "<td>".mb_strtoupper($dato[$columnas[$i][0]], 'UTF-8')."</td>";

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
                                <td colspan="<?=$colspan?>" align="center"> No existen registros asociados a los parametros establecidos en el libro de campo (Resumen) </td>
                            </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
        <?php
            }elseif($etapa == 2 || $etapa == 3 || $etapa == 4 || $etapa == 5){
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
                                <td colspan="<?=count($columnas)+9?>" align="center"> No existen registros </td>
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
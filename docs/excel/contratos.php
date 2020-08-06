<?php
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=contratos".date("d-m-Y").".xls");

    $tituloFiltros = "Los actuales registros han sido filtrados por:";
    
    $temporada = (isset($_REQUEST['Temporada'])?$_REQUEST['Temporada']:NULL);
    $temporada = filter_var($temporada,FILTER_SANITIZE_STRING);
    
    $order = (isset($_REQUEST['Orden'])?$_REQUEST['Orden']:NULL);
    $order = filter_var($order,FILTER_SANITIZE_NUMBER_INT);

    $ficha = (isset($_REQUEST['FCont0'])?$_REQUEST['FCont0']:NULL);
    $ficha = filter_var($ficha,FILTER_SANITIZE_NUMBER_INT);
    if($ficha != "") $tituloFiltros .= " Ficha (".$ficha.")";

    $numeroC = (isset($_REQUEST['FCont1'])?$_REQUEST['FCont1']:NULL);
    $numeroC = filter_var($numeroC,FILTER_SANITIZE_STRING);
    if($numeroC != "") $tituloFiltros .= " Numero de contrato (".$numeroC.")";

    $numeroA = (isset($_REQUEST['FCont2'])?$_REQUEST['FCont2']:NULL);
    $numeroA = filter_var($numeroA,FILTER_SANITIZE_STRING);
    if($numeroA != "") $tituloFiltros .= " Numero de anexo (".$numeroA.")";
    
    $cliente = (isset($_REQUEST['FCont3'])?$_REQUEST['FCont3']:NULL);
    $cliente = filter_var($cliente,FILTER_SANITIZE_STRING);
    if($cliente != "") $tituloFiltros .= " Cliente (".$cliente.")";
    
    $agricultor = (isset($_REQUEST['FCont4'])?$_REQUEST['FCont4']:NULL);
    $agricultor = filter_var($agricultor,FILTER_SANITIZE_STRING);
    if($agricultor != "") $tituloFiltros .= " Agricultor (".$agricultor.")";
    
    $especie = (isset($_REQUEST['FCont5'])?$_REQUEST['FCont5']:NULL);
    $especie = filter_var($especie,FILTER_SANITIZE_NUMBER_INT);
    if($especie != "") $tituloFiltros .= " Especie (".$especie.")";
    
    $variedad = (isset($_REQUEST['FCont6'])?$_REQUEST['FCont6']:NULL);
    $variedad = filter_var($variedad,FILTER_SANITIZE_STRING);
    if($variedad != "") $tituloFiltros .= " Variedad (".$variedad.")";
    
    $base = (isset($_REQUEST['FCont7'])?$_REQUEST['FCont7']:NULL);
    $base = filter_var($base,FILTER_SANITIZE_NUMBER_INT);
    if($base != "") $tituloFiltros .= " Base (".$base.")";
    
    $precio = (isset($_REQUEST['FCont8'])?$_REQUEST['FCont8']:NULL);
    $precio = filter_var($precio,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    if($precio != "") $tituloFiltros .= " Precio (".$precio.")";
    
    $humedad = (isset($_REQUEST['FCont9'])?$_REQUEST['FCont9']:NULL);
    $humedad = filter_var($humedad,FILTER_SANITIZE_STRING);
    if($humedad != "") $tituloFiltros .= " Humedad (".$humedad.")";
    
    $germinacion = (isset($_REQUEST['FCont10'])?$_REQUEST['FCont10']:NULL);
    $germinacion = filter_var($germinacion,FILTER_SANITIZE_STRING);
    if($germinacion != "") $tituloFiltros .= " Germinacion (".$germinacion.")";
    
    $purezaG = (isset($_REQUEST['FCont11'])?$_REQUEST['FCont11']:NULL);
    $purezaG = filter_var($purezaG,FILTER_SANITIZE_STRING);
    if($purezaG != "") $tituloFiltros .= " Pureza Genetica (".$purezaG.")";
    
    $purezaF = (isset($_REQUEST['FCont12'])?$_REQUEST['FCont12']:NULL);
    $purezaF = filter_var($purezaF,FILTER_SANITIZE_STRING);
    if($purezaF != "") $tituloFiltros .= " Pureza Fisica (".$purezaF.")";
    
    $enfermedades = (isset($_REQUEST['FCont13'])?$_REQUEST['FCont13']:NULL);
    $enfermedades = filter_var($enfermedades,FILTER_SANITIZE_STRING);
    if($enfermedades != "") $tituloFiltros .= " Enfermedades (".$enfermedades.")";
    
    $malezas = (isset($_REQUEST['FCont14'])?$_REQUEST['FCont14']:NULL);
    $malezas = filter_var($malezas,FILTER_SANITIZE_STRING);
    if($malezas != "") $tituloFiltros .= " Malezas (".$malezas.")";

    /* CONEXION */
    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    /********/
    /* BIND */
    /********/

    $bind = array();

    /**********/
    /* Filtro */
    /**********/

    $filtro = "";
    if($ficha != ""){ $filtro .= " AND A.id_ficha = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $ficha)); }
    if($numeroC != ""){ $filtro .= " AND C.num_contrato LIKE ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $numeroC)); }
    if($numeroA != ""){ $filtro .= " AND A.num_anexo LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$numeroA."%")); }
    if($cliente != ""){ $filtro .= " AND CL.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$cliente."%")); }
    if($agricultor != ""){ $filtro .= " AND AG.razon_social LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$agricultor."%")); }
    if($especie != ""){ $filtro .= " AND M.id_esp LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$especie."%")); }
    if($variedad != ""){ $filtro .= " AND M.nom_hibrido LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$variedad."%")); }
    if($base != ""){ $filtro .= " AND A.base = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $base)); }
    if($precio != ""){ $filtro .= " AND A.precio = ?"; array_push($bind,array("Tipo" => "INT", "Dato" => $precio)); }
    if($humedad != ""){ $filtro .= " AND A.humedad LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$humedad."%")); }
    if($germinacion != ""){ $filtro .= " AND A.germinacion LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$germinacion."%")); }
    if($purezaG != ""){ $filtro .= " AND A.pureza_genetica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$purezaG."%")); }
    if($purezaF != ""){ $filtro .= " AND A.pureza_fisica LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$purezaF."%")); }
    if($enfermedades != ""){ $filtro .= " AND A.enfermedades LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$enfermedades."%")); }
    if($malezas != ""){ $filtro .= " AND A.maleza LIKE ?"; array_push($bind,array("Tipo" => "STR", "Dato" => "%".$malezas."%")); }

    /*********/
    /* Orden */
    /*********/

    $orden = "";
    switch($order){
        case 1:
            $orden = "ORDER BY C.num_contrato ASC";
        break;
        case 2:
            $orden = "ORDER BY C.num_contrato DESC";
        break;
        case 3:
            $orden = "ORDER BY A.num_anexo ASC";
        break;
        case 4:
            $orden = "ORDER BY A.num_anexo DESC";
        break;
        case 5:
            $orden = "ORDER BY CL.razon_social ASC";
        break;
        case 6:
            $orden = "ORDER BY CL.razon_social DESC";
        break;
        case 7:
            $orden = "ORDER BY AG.razon_social ASC";
        break;
        case 8:
            $orden = "ORDER BY AG.razon_social DESC";
        break;
        case 9:
            $orden = "ORDER BY E.nombre ASC";
        break;
        case 10:
            $orden = "ORDER BY E.nombre DESC";
        break;
        case 11:
            $orden = "ORDER BY M.nom_hibrido ASC";
        break;
        case 12:
            $orden = "ORDER BY M.nom_hibrido DESC";
        break;
        case 13:
            $orden = "ORDER BY A.base ASC";
        break;
        case 14:
            $orden = "ORDER BY A.base DESC";
        break;
        case 15:
            $orden = "ORDER BY A.precio ASC";
        break;
        case 16:
            $orden = "ORDER BY A.precio DESC";
        break;
        case 17:
            $orden = "ORDER BY A.humedad ASC";
        break;
        case 18:
            $orden = "ORDER BY A.humedad DESC";
        break;
        case 19:
            $orden = "ORDER BY A.germinacion ASC";
        break;
        case 20:
            $orden = "ORDER BY A.germinacion DESC";
        break;
        case 21:
            $orden = "ORDER BY A.pureza_genetica ASC";
        break;
        case 22:
            $orden = "ORDER BY A.pureza_genetica DESC";
        break;
        case 23:
            $orden = "ORDER BY A.pureza_fisica ASC";
        break;
        case 24:
            $orden = "ORDER BY A.pureza_fisica DESC";
        break;
        case 25:
            $orden = "ORDER BY A.enfermedades ASC";
        break;
        case 26:
            $orden = "ORDER BY A.enfermedades DESC";
        break;
        case 27:
            $orden = "ORDER BY A.maleza ASC";
        break;
        case 28:
            $orden = "ORDER BY A.maleza DESC";
        break;
        case 29:
            $orden = "ORDER BY A.id_ficha ASC";
        break;
        case 30:
            $orden = "ORDER BY A.id_ficha DESC";
        break;
        default:
            $orden = "ORDER BY C.num_contrato ASC";
        break;
    }

    /*******/
    /* SQL */
    /*******/

    $sql = "SELECT A.id_ficha, C.num_contrato, A.num_anexo, CL.razon_social, AG.razon_social AS agricultor, E.nombre, M.nom_hibrido, A.base, A.precio, A.humedad, A.germinacion, A.pureza_genetica, A.pureza_fisica, A.enfermedades, A.maleza 
            FROM anexo_contrato A 
            INNER JOIN contrato_anexo_temporada CAT ON (CAT.id_ac = A.id_ac)
            INNER JOIN contrato_agricultor C ON C.id_cont = CAT.id_cont 
            INNER JOIN agricultor AG ON AG.id_agric = C.id_agric 
            INNER JOIN materiales M ON M.id_materiales = A.id_materiales 
            INNER JOIN especie E ON E.id_esp = M.id_esp 
            INNER JOIN detalle_quotation DQ ON DQ.id_de_quo = A.id_de_quo 
            INNER JOIN quotation Q ON Q.id_quotation = DQ.id_quotation 
            INNER JOIN contrato_cliente CC ON CC.id_cli = Q.id_cli 
            INNER JOIN cliente CL ON CL.id_cli= CC.id_cli 
            WHERE A.id_ac != 0 AND CAT.id_tempo = ? $filtro GROUP BY A.num_anexo $orden";

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

    $contratos = array();

    if($consulta->rowCount() > 0){
        $contratos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    }

    $sql = "SELECT nombre FROM temporada WHERE id_tempo = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue("1",$temporada, PDO::PARAM_STR);
    $consulta->execute();

    $temporada = "";
    if($consulta->rowCount() > 0){
        $temporada = $consulta->fetch(PDO::FETCH_ASSOC);

    }

    /* CIERRE CONEXION */
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
        <caption style="font-size: 2em; color: green;"> <strong> Contratos </strong> ( Temporada : <?=$temporada["nombre"]?> ) </caption>

        <thead>
            <?php
                if(strlen($tituloFiltros) > 46):
            ?>
            <tr>
                <th colspan="16" style="background: lightsteelblue"> <?=$tituloFiltros?> </th>
            </tr>
            <?php
                endif;
            ?>
            <tr style="font-size: 1em; background: lightgreen">
                <th> # </th>
                <th> Ficha </th>
                <th> Número contrato </th>
                <th> Número anexo </th>
                <th> Cliente </th>
                <th> Agricultor </th>
                <th> Especie </th>
                <th> Variedad </th>
                <th> Base </th>
                <th> Precio </th>
                <th> Humedad </th>
                <th> Germinación </th>
                <th> Pureza Genética </th>
                <th> Pureza Física </th>
                <th> Enfermedades </th>
                <th> Malezas </th>
            </tr>
        </thead>

        <tbody>
        <?php
            if(count($contratos) > 0):
                $i = 0;
                foreach($contratos AS $dato):
                    $i++;
        ?>
                    <tr> 
                        <td><?=$i?></td>
                        <td><?=$dato["id_ficha"]?></td>
                        <td><?=$dato["num_contrato"]?></td>
                        <td><?=$dato["num_anexo"]?></td>
                        <td><?=$dato["razon_social"]?></td>
                        <td><?=$dato["agricultor"]?></td>
                        <td><?=$dato["nombre"]?></td>
                        <td><?=$dato["nom_hibrido"]?></td>
                        <td><?=$dato["base"]?></td>
                        <td><?=$dato["precio"]?></td>
                        <td><?=$dato["humedad"]?></td>
                        <td><?=$dato["germinacion"]?></td>
                        <td><?=$dato["pureza_genetica"]?></td>
                        <td><?=$dato["pureza_fisica"]?></td>
                        <td><?=$dato["enfermedades"]?></td>
                        <td><?=$dato["maleza"]?></td>
                    </tr>
        <?php
                endforeach;
            else:
        ?>
                <tr> 
                    <td colspan="16" align="center"> No existen registros asociados a los parametros establecidos en el contrato </td>
                </tr>
        <?php
            endif;
        ?>
        </tbody>
    </table>
</body>
</html>
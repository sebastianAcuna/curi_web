<?php
    require_once '../../core/db/conectarse_db.php';
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=planilla_agricultor_".date("d-m-Y").".xls");
?>
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table border="0" cellpadding="2" cellspacing="0" width="100%"> 
        <caption style="font-size: 1.7em; color: green;"> <strong> Planilla Agricultor </strong></caption> 
        <tbody>
            <tr>

            </tr>
            <tr>
                <td colspan="4" align="center">
                    <strong style="font-size: 1.2em; color: gray;"> Información Personal </strong>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Rut </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Razón Social </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Teléfono </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Región </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Comuna </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Dirección </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td colspan="4" align="center">
                    <strong style="font-size: 1.2em; color: gray;"> Datos del Representante Legal </strong>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Representate Legal </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Rut </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Teléfono </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Mail </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <strong style="font-size: 1.2em; color: gray;"> Datos del Administrador de Campo </strong>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Nombre </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Teléfono </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <strong style="font-size: 1.2em; color: gray;"> Datos Bancarios (Nacional) </strong>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Banco </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Tipo de Cuenta </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Número Cuenta Corriente </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <strong style="font-size: 1.2em; color: gray;"> Datos Bancarios (Internacional) </strong>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td>
                    <strong style="font-size: 1.2em;"> Banco </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Tipo de Cuenta </strong>
                </td>
                <td>
                    <strong style="font-size: 1.2em;"> Número Cuenta Corriente </strong>
                </td>
            </tr>
            <tr style="border: 1pt solid black;">
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
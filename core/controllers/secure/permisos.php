<?php
    session_start();

    if(empty($_SESSION["rut_curimapu"])){
        echo '<script>document.location = "login.php"</script>';
        die;

    }

    if($_SERVER['SCRIPT_NAME'] != "/curimapu/index.php"){
        $page = substr($_SERVER['SCRIPT_NAME'], 21);

        switch($page){
            case "pro_cli_mat.php":
                if($_SESSION["tipo_curimapu"] != 4 && $_SESSION["tipo_curimapu"] != 5 && $_SESSION["prop_curimapu"] == 0){
                    require 'acceso_prohibido.php';
                    die;
                }
            break;
            case "administradores.php":
            case "analistas.php":
            case "usuarios.php":
            case "agricultores.php":
            case "clientes.php":
            case "supervisores.php":
            case "vista_libro.php":
            case "predios.php":
            case "potreros.php":
            case "usuario_anexo.php":
            case "usuario_quotation.php":
            case "materiales.php":
            case "quoatation.php":
            case "contratos.php":
                if($_SESSION["tipo_curimapu"] != 4 && $_SESSION["tipo_curimapu"] != 5){
                    require 'acceso_prohibido.php';
                    die;
                }
            break;
            case "libro.php":
                if($_SESSION["tipo_curimapu"] < 1 && $_SESSION["tipo_curimapu"] > 5){
                    require 'acceso_prohibido.php';
                    die;

                }
            break;
            case "fichas.php":
            case "prospectos.php":
            case "stock.php":
            case "export.php":
                if($_SESSION["tipo_curimapu"] != 3 && $_SESSION["tipo_curimapu"] != 4 && $_SESSION["tipo_curimapu"] != 5){
                    require 'acceso_prohibido.php';
                    die;

                }
            break;

            case "tablas.php":
            break;

        }

    }
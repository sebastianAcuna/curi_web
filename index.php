<?php

    require_once 'core/controllers/secure/permisos.php';
    require_once "core/db/conectarse_db.php";
    

    function textMin($text,$aplicar){
        if(strlen($text) > $aplicar){
            $text = substr($text,0,$aplicar)."..."; 
        }
        return $text;
    }

?>

<!DOCTYPE html>
<html lang="ES">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> Curimapu </title>

        <!--     ICO DE LA PAGINA     -->
	    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

        <!--     BOOTSTRAP -> CSS     -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!--     FONTAWESOME     -->
        <link href="assets/fontawesome/css/all.css" rel="stylesheet">

        <!--     STYLE     -->
        <link href="assets/css/page.css" rel="stylesheet">
        
        <!--     STYLE     -->
        <link href="assets/css/card.css" rel="stylesheet">
        
        <!--     PAGINACION     -->
        <link href="assets/css/paginacion.css" rel="stylesheet">

        <!--     LIGHTBOX     -->
        <link rel="stylesheet" href="assets/css/lightbox.min.css">
        <script src="assets/js/lightbox-plus-jquery.min.js"></script>

        <!--     SELECT2     -->
        <link rel="stylesheet" href="assets/css/select2.min.css">

        <!--     SCRIPTS     -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <?="<script> const puas = ".$_SESSION["tipo_curimapu"].";</script>"?>
        <?="<script> const mpoa = ".$_SESSION["mod_pass_curimapu"].";</script>"?>
        <script src="assets/js/pre-funciones.js?<?=date("YmdHis")?>"></script>

    </head>

    <body>

  
        <!-- Sidebar / Contenido -->
        <div class="d-flex general" id="general">
            <!-- Sidebar -->
            <div class="bg-light border-right sidebar">
                <div class="list-group list-group-flush" id="menu">
                        <li class="list-group-item list-group-item-action bg-light">
                            <span><strong>Usuario:</strong></span>
                            <br>
                            <div style="display:flex; justify-content:space-between;align-items:center;flex-wrap:wrap;">
                                <span><strong><? echo textMin($_SESSION["user_curimapu"], 16)?></strong></span>
                                <?php if($_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5 || $_SESSION["tipo_curimapu"] == 3): ?>
                                <i id="cambiarPass" data-edi="<?php echo $_SESSION['IDuser_curimapu']; ?>" class="fas fa-users-cog text-white btn btn-success btn-sm" title="configurar cuenta" style="padding:0.5em;width:30px; height:30px;"></i>
                                <?php endif; ?>
                             
                            </div>
                            

                        </li>
                        <a href="#Inicio" class="list-group-item list-group-item-action bg-light" id="inicio">
                            <i class="fa fa-home"></i>
                            Inicio
                        </a>
                    <?php if($_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5): ?>
                        <li class="list-group-item list-group-item-action bg-light" id="sub-menu-1">
                            <i class="fas fa-users-cog"></i>
                            Mantenedor
                        </li>
                            <li class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1">
                                <span><strong>Usuarios</strong></span>
                            </li>
                            <a href="#Administradores" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="administradores">
                                <i class="fas fa-user-tie"></i>
                                Administradores
                            </a>
                            <a href="#Analistas" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="analistas">
                                <i class="fas fa-user-tie"></i>
                                Analistas
                            </a>
                            <a href="#Supervisores" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="supervisores">
                                <i class="fas fa-user-tie"></i>
                                Supervisores
                            </a>
                            <a href="#Usuarios" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="usuarios">
                                <i class="fas fa-user-tie"></i>
                                Usuarios
                            </a>
                            <li class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1">
                                <span><strong>Información</strong></span>
                            </li>
                            <a href="#Agricultores" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="agricultores">
                                <i class="fas fa-user-tie"></i>
                                Agricultores
                            </a>
                            <a href="#Clientes" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="clientes">
                                <i class="fas fa-user-tie"></i>
                                Clientes
                            </a>
                            <li class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1">
                                <span><strong>Vista</strong></span>
                            </li>
                            <a href="#Vista_libro" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="vista_libro">
                            <i class="fa fa-book"></i>
                                Vista cli lc
                            </a>
                            <?php
                                if(($_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5) && $_SESSION["prop_curimapu"] == 1): 
                            ?>
                                <a href="#Pro_cli_mat" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="pro_cli_mat">
                                <i class="fa fa-book"></i>
                                    prop-esp-temp
                                </a>
                            <?php
                                endif;
                            ?>
                            <li class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1">
                                <span><strong>Ubicacion</strong></span>
                            </li>
                            <a href="#Predios" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="predios">
                            <i class="fa fa-book"></i>
                                Predios
                            </a>
                            <a href="#Potreros" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="potreros">
                            <i class="fa fa-book"></i>
                                Potreros
                            </a>
                            <li class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1">
                                <span><strong>Asignacion</strong></span>
                            </li>
                            <a href="#Usuario_anexo" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="usuario_anexo">
                            <i class="fa fa-book"></i>
                                Usuario a anexo
                            </a>
                            <a href="#Usuario_quotation" class="list-group-item list-group-item-action bg-light submenu oculto" name="sub-1" id="usuario_quotation">
                            <i class="fa fa-book"></i>
                                C - D. Quotat.
                            </a>
                        <a href="#Materiales" class="list-group-item list-group-item-action bg-light" id="materiales">
                            <i class="far fa-edit"></i>
                            Materiales
                        </a>
                        <a href="#Quotation" class="list-group-item list-group-item-action bg-light" id="quotation">
                            <i class="fab fa-quora"></i>
                            Cliente Quotation
                        </a>
                        <a href="#Contratos" class="list-group-item list-group-item-action bg-light" id="contratos">
                            <i class="fas fa-handshake"></i>
                            Anexos de contrato
                        </a>
                    <?php 
                        endif;
                        if($_SESSION["tipo_curimapu"] == 3 || $_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5): 
                    ?>
                        <a href="#Prospectos" class="list-group-item list-group-item-action bg-light" id="prospectos">
                            <i class="far fa-file-archive"></i>
                            Prospectos
                        </a>
                        <a href="#Fichas" class="list-group-item list-group-item-action bg-light" id="fichas">
                            <i class="far fa-file-archive"></i>
                            Fichas
                        </a>
                    <?php 
                        endif;
                        if($_SESSION["tipo_curimapu"] > 0 && $_SESSION["tipo_curimapu"] < 6): 
                    ?>
                        <a href="#Libro" class="list-group-item list-group-item-action bg-light" id="libro">
                            <i class="fa fa-book"></i>
                            Libro de campo
                        </a>
                    <?php
                        endif;
                        if($_SESSION["tipo_curimapu"] == 3 || $_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5): 
                    ?>
                        <a href="#Stock" class="list-group-item list-group-item-action bg-light" id="stock">
                            <i class="fas fa-seedling"></i>
                            Stock semillas
                        </a>
                        <a href="#Export" class="list-group-item list-group-item-action bg-light" id="export">
                            <i class="fas fa-file-export"></i>
                            Export
                        </a>
                    <?php 
                        endif;
                        if($_SESSION["IDuser_curimapu"] == 1 || $_SESSION["IDuser_curimapu"] == 2): 
                    ?>
                        <a href="#Tablas" class="list-group-item list-group-item-action bg-light" id="tablas">
                        <i class="fas fa-table"></i>
                            Tablas
                        </a>
                    <?php
                        endif;
                    ?>
                     <?php if($_SESSION["tipo_curimapu"] == 4 || $_SESSION["tipo_curimapu"] == 5): ?>
                    <a href="#Intercambio" class="list-group-item list-group-item-action bg-light" id="intercambio">
                        <i class="fas fa-exchange-alt"></i>
                        Intercambio
                    </a>
                    <?php
                        endif;
                    ?>

                    
                    <a href="#Cerrar" class="list-group-item list-group-item-action bg-light sidebar-footer" id="Cerrar" title="Cerrar sesion">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>
            </div>
            <!-- FIN -> Sidebar -->

            <!-- Contenido -->
            <div class="contenido">

                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" id="navbar">
                    <i class="fas fa-angle-double-left act-tog" id="menu-toggle"></i>
                    <img src="assets/images/logo-curimapu-export-small.png">
                    <h4 style="margin-left: 5em"><?php echo ($_SESSION["rut_curimapu"] == "18.804.076-7" || $_SESSION["rut_curimapu"] == "9.411.789-5") ? "SERVIDOR (".$_SERVER["SERVER_ADDR"].")" : ""; ?></h4>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#contenidoNav" aria-controls="contenidoNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="contenidoNav">
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <h4>Temporada: </h4>
                            </li>
                            <li class="nav-item">
                                <div class="input-group" style="margin-left: 5px; min-width: 200px">
                                    <div class="input-group-append" id="button-addon4" style="margin-right: 2px">
                                        <button class="btn-danger" type="button" id="btnMenosTemporada">-</button>
                                    </div>
                                    <select style="width:60%" id="selectTemporada" required>
                                        <?php
                                            $conexion = new Conectar();
                                            $conexion = $conexion->conexion();

                                            $sql = "SELECT id_tempo, nombre FROM temporada ORDER BY nombre DESC";
                                            $consulta = $conexion->prepare($sql);
                                            $consulta->execute();
                                            if($consulta->rowCount() > 0){
                                                
                                                $temporadas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($temporadas as $temporada):
                                        ?>
                                                    <option value="<?=$temporada["id_tempo"]?>"><?=$temporada["nombre"]?></option>
                                        <?php
                                                endforeach;
                                            }else{
                                        ?>
                                            <option value="">No existen temporadas</option>
                                        <?php    
                                            }
                                            $consulta = NULL;
                                            $conexion = NULL;
                                        ?>
                                    </select>
                                    <div class="input-group-append" id="button-addon4" style="margin-left: 2px">
                                        <button class="btn-success" type="button" id="btnMasTemporada">+</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid" id="divCargaGeneral" style="display:none">
                    <div class="container-fluid divCarga">
                        <i class="fas fa-spinner fa-5x fa-spin"></i>
                        <h4>Estamos procesando su solicitud, espere un momento por favor.</h4>
                    </div>
                </div>
                <!-- FIN -> Navbar -->
                <div class="container-fluid" id="contenido">
                </div>

            </div>
            <!-- FIN -> Contenido -->

            <!-- Modal -->
            <div class="modal fade" id="modalCambia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tituloModalIndex"> Editar <?php echo $_SESSION["user_curimapu"];?> </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form id="formIndex">
                                    <h1 class="title"> Datos de inicio de sesión </h1>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Email </label> (<label style="color:red">*</label>)
                                            <input id="emailIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el email. Ej: Ejemplo@ejemplo.com"  maxlength="50" disabled>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Nombre de usuario</label> (<label style="color:red">*</label>)
                                            <input id="usernameIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el usuario. Ej: Adm" maxlength="20" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Contraseña</label> (<label style="color:red">*</label>)
                                            <input id="passIndex" class="form-control form-control-sm" type="password" placeholder="Ingrese la contraseña." maxlength="10" required>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Verificar contraseña</label> (<label style="color:red">*</label>)
                                            <input id="verificarPassIndex" class="form-control form-control-sm" type="password" placeholder="Ingrese nuevamente la contraseña" maxlength="10" required>
                                        </div>
                                    </div>

                                    <h1 class="title"> Información personal </h1>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Rut</label> (<label style="color:red">*</label>)
                                            <input id="rutIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el rut. Ej: 9.999.999-9" maxlength="12" disabled>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Nombre</label> (<label style="color:red">*</label>)
                                            <input id="nombreIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre." maxlength="20" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Apellido paterno</label> (<label style="color:red">*</label>)
                                            <input id="apellidoPIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el apellido paterno." maxlength="20" disabled>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Apellido materno</label> (<label style="color:red">*</label>)
                                            <input id="apellidoMIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el apellido materno." maxlength="20" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Teléfono</label> (<label style="color:red">*</label>)
                                            <input id="telefonoIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese el teléfono."  maxlength="20" required>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>País</label> (<label style="color:red">*</label>)
                                            <select style="width: 100%" id="paisIndex" required>
                                                <?php
                                                    /* Conexion */
                                                    $conexion = new Conectar();
                                                    $conexion = $conexion->conexion();
                                                    $sql = "SELECT * FROM pais";
                                                    $consulta = $conexion->prepare($sql);
                                                    $consulta->execute();
                                                    if($consulta->rowCount() > 0){  
                                                    
                                                ?>
                                                        <option value="">Seleccione un pais</option>
                                                <?php
                                                        $paises = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($paises as $pais): ?>
                                                            <option value="<?=$pais["id_pais"]?>"><?=$pais["nombre"]?></option>
                                                <?php 
                                                        endforeach;
                                                    }else{ 

                                                ?>
                                                        <option value="">No existen paises</option>
                                                <?php 
                                                    }  

                                                    $consulta = NULL;
                                                    $conexion = NULL;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Región</label> (<label style="color:red">*</label>)
                                            <select style="width: 100%" id="regionIndex" required>
                                                <option value="">Seleccione un país</option>
                                            </select>
                                        </div>


                                        <div class="col-lg-6 col-sm-12">
                                            <label>provincia</label> (<label style="color:red">*</label>)
                                            <select style="width: 100%" id="provinciaIndex" required>
                                                <option value="">Seleccione una provincia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-lg-6 col-sm-12">
                                            <label>Comuna</label> (<label style="color:red">*</label>)
                                            <select style="width: 100%" id="comunaIndex" required>
                                                <option value="">Seleccione una comuna</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 col-sm-12">
                                            <label>Dirección</label> (<label style="color:red">*</label>)
                                            <input id="direccionIndex" class="form-control form-control-sm" type="text" placeholder="Ingrese la dirección."  maxlength="60" required>
                                        </div>
                                    </div>
                            </form>
                            
                            <div class="alert alert-danger" role="alert" id="errorModIndex" hidden>
                                <h4 class="alert-heading">ATENCION!!</h4>
                                <p id="errorMenjIndex"> </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="optionModIndex">Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Termina el modal -->

        </div>
        <!-- FIN -> Sidebar / Contenido -->

        <!--     SCRIPTS     -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/sweetalert.min.js"></script>
        <script src="assets/js/post-funciones.js?<?echo date("YmdHis")?>"></script>
        <script src="core/controllers/js/general.js"></script>

        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> -->
        <!-- <script src="assets/js/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->

    </body>

</html>
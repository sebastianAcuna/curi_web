<?php
    // require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";

    session_start();
?>

<!-- STYLE DE ANIMACION DE CHECK Y ERROR (¿SERA EN ESTA HOJA EL MEJOR LUGAR?) -->
<style>
    /* ANIMACION CHECK Y ERROR CSS INTERCAMBIO */

    .hideIcon{
        display:none;
    }

    .showIcon{
        display:inline;
    }

    svg {
        width: 100px;
        display: block;
        margin: 40px auto 0;
    }
    
    .icon-eva {
        stroke-dasharray: 1000;
        stroke-dashoffset: 0;
    }

    .icon-eva.circle {
        -webkit-animation: dash .9s ease-in-out;
        animation: dash .9s ease-in-out;
    }

    .icon-eva.line {
        stroke-dashoffset: 1000;
        -webkit-animation: dash .9s .35s ease-in-out forwards;
        animation: dash .9s .35s ease-in-out forwards;
    }

    .icon-eva.check {
        stroke-dashoffset: -100;
        -webkit-animation: dash-check .9s .35s ease-in-out forwards;
        animation: dash-check .9s .35s ease-in-out forwards;
    }
    
    @-webkit-keyframes dash {
        0% {
            stroke-dashoffset: 1000;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes dash {
        0% {
            stroke-dashoffset: 1000;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }

    @-webkit-keyframes dash-check {
        0% {
            stroke-dashoffset: -100;
        }
        100% {
            stroke-dashoffset: 900;
        }
    }

    @keyframes dash-check {
        0% {
            stroke-dashoffset: -100;
        }
        100% {
            stroke-dashoffset: 900;
        }
    }
</style>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Bd Intercambio </h1>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Barra navegabilidad -->
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="descargas-tab" data-toggle="tab" href="#descargas" role="tab" aria-controls="descargas" aria-selected="true"> Descarga </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" id="subida-tab" data-toggle="tab" href="#subida" role="tab" aria-controls="subida" aria-selected="false"> Subida </a>
            </li>
        </ul>
    </div> 
</div>
<!-- FIN barra navegabilidad -->


<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="descargas" role="tabpanel" aria-labelledby="descargas-tab">
    <button id="startDownload" class="btn btn-primary">Comenzar proceso de descarga</button>
    
    <?php 
        if($_SESSION["rut_curimapu"] == "18.804.066-7" || $_SESSION["rut_curimapu"] == "9.411.789-5" || $_SESSION["rut_curimapu"] == "15.953.693-9" ) :  ?>
            <button id="startDelete" class="btn btn-danger"> ELIMINAR BASE DE DATOS CURIMAPU_TABLETAS </button>
        <?php 
            else: ?>
            <input type="hidden" id="startDelete" name="startDelete">
        <?php endif; ?>

    <div>
        <div id="contenedor_migajas" style="display:flex; align-items:center">
            
        </div>
    </div>
    <!-- Contenedor de la tabla ACTIVAS -->
        <div class="container-fluid" >
            <div id="conenedor_info_descarga">
                <div id="cuadro_paso_1" style="display:none;flex-direction:column;align-items:center">
                    <div id="icon_download_success" class="hideIcon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="icon-eva circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <polyline class="icon-eva check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                        </svg>
                    </div>

                    <div id="icon_download_error" class="hideIcon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="icon-eva circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <line class="icon-eva line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                            <line class="icon-eva line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2" />
                        </svg>
                    </div>
                        
                    <i id="icon_download_charge" class="fas fa-spinner fa-5x fa-spin"></i>
                    <h3 id="titulo_paso_1">Comenzando paso 1 ...</h3>
                    <h4 id="sub_paso_1">Comprobando caracteres</h4>

                
                    <div style="display:flex;">
                        <button id="btnSiguiente" class="btn btn-success disabled">Continuar</button>
                        <button id="botonLimpiar" class="btn btn-danger disabled hideIcon">limpiar bd intercambio</button>
                    </div>

                    <div class="table-responsive hideIcon" id="tablaOk" style="width:50%">
                        <h4>Datos ingresados</h4>
                        <table  class="table table-striped table-hover table-bordered ">
                            <thead>
                                <th>
                                    Tabla
                                </th>
                                <th>
                                    Informacion
                                </th>
                            </thead>
                            <tbody id="datosOk">
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive hideIcon" id="tablaDeErrores" style="width:50%">
                        <h4>Datos con referencias erroneas</h4>
                        <table  class="table table-striped table-hover table-bordered ">
                            <thead>
                                <th>
                                    Tabla
                                </th>
                                <th>
                                    Columna
                                </th>
                                <th>
                                    Errores
                                </th>
                            </thead>
                            <tbody id="tablaErrores">
                                
                            </tbody>
                        </table>
                    </div>

                    <div id="tablaErroresRef" class="table-responsive hideIcon" style="width:50%">
                        <h4>problemas de codigo</h4>
                        <table  class="table table-striped table-hover table-bordered ">
                            <thead>
                                <th>
                                    Tabla
                                </th>
                                <th>
                                    Mensaje
                                </th>
                            </thead>
                            <tbody id="datosErrores">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show " id="subida" role="tabpanel" aria-labelledby="subida-tab">
    <h2>bye</h2>
    </div>
</div>
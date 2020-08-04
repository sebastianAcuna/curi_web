<?php
    require_once '../controllers/secure/permisos.php';
    require_once '../db/conectarse_db.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Libro de campo </h1>
        <form method="POST" id="formExport">
            <img src="assets/images/ms-excel.png" id="descExcel" title="Informe libro de campo">
        </form>
        <?php if($_SESSION["tipo_curimapu"] == 5): ?>
            <form method="POST" id="formExportVis">
                <img src="assets/images/ms-excel.png" id="descExcelVis" title="Informe de visitas" style="filter: hue-rotate(120deg);">
            </form>
        <?php endif; ?>
        <?php if($_SESSION["tipo_curimapu"] == 5): ?> <button type="button" class="btn btn-primary" id="guardarLibro"> Guardar </button> <?php endif; ?>
		<div class="col-lg-4 col-md-3 col-sm-2">
            <label>Especie :  </<label>
            <select style="width: 100%" id="SelEspecies" required>
                <?php
                    $conexion = new Conectar();
                    $sql = "SELECT * FROM especie ORDER BY nombre ASC";
                    $conexion = $conexion->conexion();
                    $consulta = $conexion->prepare($sql);
                    $consulta->execute();
                    if($consulta->rowCount() > 0){
                        $especies = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        foreach($especies as $especie):
                ?>
                            <option value="<?=$especie["id_esp"]?>"><?=$especie["nombre"]?></option>
                <?php
                        endforeach;
                    }else{
                ?>
                        <option value="">No existen especies</option>
                <?php    
                    }
                    
                    /* Cierre conexiones DB */
                    $consulta = NULL;
                    $conexion = NULL;
                ?>
            </select>
        </div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Barra navegabilidad -->
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="resumen-tab" data-toggle="tab" href="#resumen" role="tab" aria-controls="resumen" aria-selected="true"> Resumen </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sowing-tab" data-toggle="tab" href="#sowing" role="tab" aria-controls="sowing" aria-selected="false"> Sowing </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="flowering-tab" data-toggle="tab" href="#flowering" role="tab" aria-controls="flowering" aria-selected="false"> Flowering </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="harvest-tab" data-toggle="tab" href="#harvest" role="tab" aria-controls="harvest" aria-selected="false"> Harvest </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false"> All </a>
            </li>
        </ul>
    </div> 
</div>
<!-- FIN barra navegabilidad -->

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
        <!-- Contenedor de la tabla RESUMEN -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaResumen">
                    <thead id="headResumen">
                        <tr>
                            <th> Tabla de resumen </th>
                        </tr>
                    </thead>
                    <tbody id="datosResumen">
                    </tbody>
                    <tfoot id="paginacionResumen">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla RESUMEN -->
    </div>

    <div class="tab-pane fade show" id="sowing" role="tabpanel" aria-labelledby="sowing-tab">
        <!-- Contenedor de la tabla SOWING -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaSowing">
                    <thead id="headSowing">
                        <tr>
                            <th> Tabla de sowing </th>
                        </tr>
                    </thead>
                    <tbody id="datosSowing">
                    </tbody>
                    <tfoot id="paginacionSowing">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla SOWING -->
    </div>
    
    <div class="tab-pane fade show" id="flowering" role="tabpanel" aria-labelledby="flowering-tab">
        <!-- Contenedor de la tabla FLOWERING -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaFlowering">
                    <thead id="headFlowering">
                        <tr>
                            <th> Tabla de flowering </th>
                        </tr>
                    </thead>
                    <tbody id="datosFlowering">
                    </tbody>
                    <tfoot id="paginacionFlowering">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla FLOWERING -->
    </div>
    
    <div class="tab-pane fade show" id="harvest" role="tabpanel" aria-labelledby="harvest-tab">
        <!-- Contenedor de la tabla HARVEST -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaHarvest">
                    <thead id="headHarvest">
                        <tr>
                            <th> Tabla de harvest </th>
                        </tr>
                        
                    </thead>
                    <tbody id="datosHarvest">
                    </tbody>
                    <tfoot id="paginacionHarvest">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla HARVEST -->
    </div>
    
    <div class="tab-pane fade show" id="all" role="tabpanel" aria-labelledby="all-tab">
        <!-- Contenedor de la tabla ALL -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaAll">
                    <thead id="headAll">
                        <tr>
                            <th> Tabla de All </th>
                        </tr>

                    </thead>
                    <tbody id="datosAll">
                    </tbody>
                    <tfoot id="paginacionAll">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla ALL -->
    </div>
    
    <div id="paginacion">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImages" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Galeria </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenedor -->
                <div class="container-fluid" >
                    <div class="table-responsive">
                        <div class="galeria" id="galeria">
                        </div>
                    </div>
                </div>
                <!-- Termina contenedor -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<!-- Modal -->
<div class="modal fade show" id="modalCarga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="container-fluid divCarga">
                <i class="fas fa-spinner fa-5x fa-spin"></i>
                <h4>Estamos procesando su solicitud, espere un momento por favor.</h4>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->
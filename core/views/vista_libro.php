<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Mantenedor de libro de campo </h1>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaLibroCampo">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMLC1" name="FMLC" placeholder="Nombre" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMLC2" name="FMLC" placeholder="Rut" > </th>
                    <th scope="col" colspan="3"> Libros </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5):?> <th scope="col"> </th> <?php endif; ?>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Nombre <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> Siembra </th>
                    <th> <div> Floración </th>
                    <th> <div> Cosecha </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5):?> <th> Acciones </th> <?php endif; ?>
                </tr>
            </thead>
            <tbody id="datos">
            </tbody>
        </table>
    </div>
    
    <div id="paginacion">
    </div>
</div>
<!-- Termina contenedor de la tabla -->

<?php
    if($_SESSION["tipo_curimapu"] == 5):
?>

<!-- Modal -->
<div class="modal fade" id="modalLibro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">    
                    <div class="col-lg-12 col-sm-12">
                        <label>Especie</label>
                        <select style="width: 100%" id="especies">
                            <option value="">Seleccione una especie</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group row">    
                    <div class="col-lg-12 col-sm-12">
                        <label>Etapa</label>
                        <select style="width: 100%" id="etapas">
                            <option value="">Seleccione una especie</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group row">    
                    <div class="col-lg-12 col-sm-12">
                        <label>Plataforma</label>
                        <select style="width: 100%" id="plataforma">
                            <option value="">Seleccione una etapa</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group row" id="checks">   
                </div> 
            </div>
            <div class="modal-footer">
                <button style='display: none' type="button" class="btn btn-primary" data-dismiss="modal" id="btnConfirmar"> Liberar vista </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnCancelar">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<?php
    endif;
?>
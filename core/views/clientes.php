<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo page -->
            <div>
                <h1 class="Titulo"> Listado de clientes </h1>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaClientes">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCli1" name="FCli" placeholder="Rut" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCli2" name="FCli" placeholder="Razón social" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCli3" name="FCli" placeholder="telefono" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCli4" name="FCli" placeholder="Email" > </th>
                    <th scope="col"> </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Razón social <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Telefono <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Email <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> Acciones </th>
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

<!-- Modal -->
<div class="modal fade" id="modalCli" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="title"> Información cliente </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Rut: </strong></label>
                        <label id="rut"></label>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Razón social: </strong></label>
                        <label id="razon"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Telefono: </strong></label>
                        <label id="telefono"></label>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Email: </strong></label>
                        <label id="email"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>País: </strong></label>
                        <label id="pais"></label>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Ciudad: </strong></label>
                        <label id="ciudad"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Dirección: </strong></label>
                        <label id="direccion"></label>
                    </div>
                </div>
                <h1 class="title"> Datos del representante legal </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Representante legal: </strong></label>
                        <label id="rl"></label>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Rut: </strong></label>
                        <label id="rutRL"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Telefono: </strong></label>
                        <label id="telefonoRL"></label>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label><strong>Email: </strong></label>
                        <label id="emailRL"></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->
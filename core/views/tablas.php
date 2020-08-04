<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Mantenedor de tablas <?php echo ($_SESSION["rut_curimapu"] == "18.804.076-7" || $_SESSION["rut_curimapu"] == "9.411.789-5") ? "(".$_SERVER["SERVER_ADDR"].")" : ""; ?></h1>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaTablas">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Tablas </th>
                    <th> Descripcion </th>
                    <th> Campos </th>
                    <th> registros </th>
                    <th> Acciones </th>
                </tr>
            </thead>
            <tbody id="datos">
            </tbody>
        </table>
    </div>
</div>
<!-- Termina contenedor de la tabla -->

<!-- Modal -->
<div class="modal fade" id="modalTb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoTabla"> </h5>
                <button id='btnAsoc' type='button' class='btn btn-danger' data-tb='' data-info='' style='margin: 0 20px; padding:.1rem .3rem'> <i id='iAsoc' data-tb='' data-info='' class='far fa-handshake'></i> </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaTb">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nombre </th>
                                <th> Español </th>
                                <th> Ingles </th>
                                <th> Comentariosbd </th>
                            </tr>
                        </thead>
                        <tbody id="datosTb">
                        </tbody>
                    </table>

                    <h5 class="modal-title" id="infoRel" style="display: none"> </h5>

                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaR" style="display: none">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Tabla </th>
                                <th> Cantidad de registros </th>
                                <th> Ver tabla </th>
                                <th> Tablas asociadas </th>
                                <th> Formularios del sistema asociados </th>
                            </tr>
                        </thead>
                        <tbody id="datosR">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                    <span id="id_datos_faltantes" class="alert alert-danger"></span>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->


<!-- Modal -->
<div class="modal fade" id="modalCre" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoTabla3"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <form id="formCre">
                        <!-- Tabla -->
                        <table class="table table-striped table-hover table-bordered" id="tablaCre">
                            <thead>
                                <tr>
                                    <th>
                                        Campo
                                    </th>
                                    <th>
                                        Datos a ingresar
                                    </th>
                                    <th style="width:80px">
                                        Tabla
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="datosCre">
                            </tbody>
                        </table>
                    </form>
                    <div class="alert alert-danger" role="alert" id="errorMod" hidden>
                        <h4 class="alert-heading">ATENCION!!</h4>
                        <p id="errorMenj"> </p>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="optionCre">Agregar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<!-- Modal -->
<div class="modal fade" id="modalOp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoTabla2"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaOp">
                        <thead id="cabeceraOp">
                        </thead>
                        <tbody id="datosOp">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<!-- Modal -->
<div class="modal fade" id="modalTbAsoc" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoTabla4"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <!-- Tabla -->
                    <h5> Tablas en donde actua como FK</h5>
                    <table class="table table-striped table-hover table-bordered" id="tablaCre">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Nombre de la tabla
                                </th>
                                <th>
                                    Ver tabla
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datosTbPri">
                        </tbody>
                    </table>
                    <h5> Tablas que son FK de la tabla</h5>
                    <table class="table table-striped table-hover table-bordered" id="tablaCre">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Nombre de la tabla
                                </th>
                                <th>
                                    Ver tabla
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datosTbFor">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->
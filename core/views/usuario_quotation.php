<?php
    require_once '../controllers/secure/permisos.php';
    require_once '../db/conectarse_db.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Mantenedor de Asignación usuario (Cliente) a detalle de quotation </h1>
                <?php if($_SESSION["tipo_curimapu"] == 5): ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUDQ"> Nueva asignación </button> <?php endif; ?>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaUDQ">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FUDQ1" name="FUDQ" placeholder="Nombre de usuario"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FUDQ2" name="FUDQ" placeholder="Rut"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FUDQ3" name="FUDQ" placeholder="Nombre"> </th>
                    <th scope="col"> </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5):?> <th scope="col"> </th> <?php endif; ?>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Nombre de usuario <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Nombre <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Cantidad Detalle Q. <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th> Acciones </th> <?php endif; ?>
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
        /* Conexion */
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
?>

        <!-- Modal -->
        <div class="modal fade" id="modalUDQ" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Nueva asignación </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUDQ">
                            <h1 class="title"> Asignación </h1>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Usuario</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="usuario" required>
                                        <?php
                                            $sql = "SELECT U.id_usuario, CONCAT(U.nombre,' ',U.apellido_p,' ',U.apellido_m) AS nombre, U.user 
                                                    FROM usuarios U
                                                    INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario
                                                    WHERE UTU.id_tu = '1' ORDER BY U.nombre ASC  ";
                                            $consulta = $conexion->prepare($sql);
                                            $consulta->execute();
                                            if($consulta->rowCount() > 0){
                                        ?>
                                                <option value="">Seleccione un usuario</option>
                                        <?php
                                                $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($usuarios as $usuario):
                                        ?>
                                                    <option value="<?=$usuario["id_usuario"]?>"><?=$usuario["nombre"]?>(<?=$usuario["user"]?>)</option>
                                        <?php
                                                endforeach;
                                            }else{
                                        ?>
                                                <option value="">No existen usuarios</option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>Detalle de quotation</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="det_quo" required>
                                        <option value="">Seleccione un Detalle </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="alert alert-danger" role="alert" id="errorMod" hidden>
                            <h4 class="alert-heading">ATENCION!!</h4>
                            <p id="errorMenj"> </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="optionMod">Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Termina el modal -->

        <!-- Modal -->
        <div class="modal fade" id="modalIA" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModal"> Nueva asignación </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <!-- Tabla -->
                            <table class="table table-striped table-hover table-bordered" id="tablaIA">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Detalle de quotation </th>
                                        <th> Accion </th>
                                    </tr>
                                </thead>
                                <tbody id="datosDetQuo">
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

<?php
        /* Cierre conexiones DB */
        $consulta = NULL;
        $conexion = NULL;
    endif;
?>
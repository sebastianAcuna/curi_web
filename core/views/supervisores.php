<?php
    require_once '../controllers/secure/permisos.php';
    require_once '../db/conectarse_db.php';

    /* Conexion */
    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $title = "";
    $sql = "SELECT desc_ayuda FROM ayuda_condicion WHERE id_cond_ayuda = '3'";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();

    if($consulta->rowCount() > 0){
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $title = $resultado["desc_ayuda"];

    }
    
    /* Cierre conexiones DB */
    $consulta = NULL;
    $conexion = NULL;
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <h1 class="Titulo"> Mantenedor de supervisores </h1>
            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSup"> Nuevo supervisor </button> <?php endif; ?>
            <button type="button" class="btn btn-secondary btn-circle btn-md float-right" data-toggle="tooltip" data-placement="left" title="<?=$title?>">
                <i class="fas fa-question"></i>
            </button>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaSupervisores">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSup1" name="FSup" placeholder="Rut" maxlength="12" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSup2" name="FSup" placeholder="Nombre" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSup3" name="FSup" placeholder="Telefono" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSup4" name="FSup" placeholder="Email" > </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5):?> <th scope="col"> </th> <?php endif; ?>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Nombre <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Telefono <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Email <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
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
        /* Conexion */
        $conexion = new Conectar();
        $conexion = $conexion->conexion();
?>

        <!-- Modal -->
        <div class="modal fade" id="modalSup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModal"> Nuevo supervisor </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formSup">
                            <h1 class="title"> Datos de inicio de sesión </h1>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Email</label> <label style="color:red">*</label>
                                    <input id="email" class="form-control form-control-sm" type="text" placeholder="Ingrese el email. Ej: Ejemplo@ejemplo.com"  maxlength="50" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>Nombre de usuario</label> <label style="color:red">*</label>
                                    <input id="username" class="form-control form-control-sm" type="text" placeholder="Ingrese el usuario. Ej: Adm" maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Contraseña</label> <label style="color:red">*</label>
                                    <input id="pass" class="form-control form-control-sm" type="password" placeholder="Ingrese la contraseña." maxlength="10" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>Verificar contraseña</label> <label style="color:red">*</label>
                                    <input id="verificarPass" class="form-control form-control-sm" type="password" placeholder="Ingrese nuevamente la contraseña" maxlength="10" required>
                                </div>
                            </div>
                            <h1 class="title"> Información personal </h1>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Rut</label> <label style="color:red">*</label>
                                    <input id="rut" class="form-control form-control-sm" type="text" placeholder="Ingrese el rut. Ej: 9.999.999-9" maxlength="12" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>Nombre</label> <label style="color:red">*</label>
                                    <input id="nombre" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre." maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Apellido paterno</label> <label style="color:red">*</label>
                                    <input id="apellidoP" class="form-control form-control-sm" type="text" placeholder="Ingrese el apellido paterno." maxlength="20" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>Apellido materno</label> <label style="color:red">*</label>
                                    <input id="apellidoM" class="form-control form-control-sm" type="text" placeholder="Ingrese el apellido materno." maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Teléfono</label> <label style="color:red">*</label>
                                    <input id="telefono" class="form-control form-control-sm" type="text" placeholder="Ingrese el teléfono."  maxlength="20" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label>País</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="pais" required>
                                        <?php
                                            $sql = "SELECT * FROM pais";
                                            $consulta = $conexion->prepare($sql);
                                            $consulta->execute();
                                            if($consulta->rowCount() > 0){
                                        ?>
                                                <option value="">Seleccione un pais</option>
                                        <?php
                                                $paises = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($paises as $pais):
                                        ?>
                                                    <option value="<?=$pais["id_pais"]?>"><?=$pais["nombre"]?></option>
                                        <?php
                                                endforeach;
                                            }else{
                                        ?>
                                                <option value="">No existen paises</option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Región</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="region" required>
                                        <option value="">Seleccione un país</option>
                                    </select>
                                </div>


                                <div class="col-lg-6 col-sm-12">
                                    <label>provincia</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="provincia" required>
                                        <option value="">Seleccione una provincia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                            <div class="col-lg-6 col-sm-12">
                                    <label>Comuna</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="comuna" required>
                                        <option value="">Seleccione una comuna</option>
                                    </select>
                                </div>


                                <div class="col-lg-6 col-sm-12">
                                    <label>Dirección</label> <label style="color:red">*</label>
                                    <input id="direccion" class="form-control form-control-sm" type="text" placeholder="Ingrese la dirección."  maxlength="60" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-2 col-sm-12">
                                    <label>¿Supervisa a otros?</label> <label style="color:red">*</label>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="siS" name="supervisar" value="1">
                                        <label class="form-check-label" for="siS">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="noS" name="supervisar" value="2">
                                        <label class="form-check-label" for="noS">No</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12" id="listaSupervisores" hidden>
                                    <select multiple style="width: 100%" id="selSupervisores" required>
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
                        <button type="submit" class="btn btn-success" id="optionMod">Agregar</button>
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
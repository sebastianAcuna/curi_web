<?php
    require_once "../controllers/secure/permisos.php";
    require_once "../db/conectarse_db.php";

    /* Obtener informacion de ayuda (icono ?)*/
    $conexion = new Conectar();
    $conexion = $conexion->conexion();

    $sql = "SELECT desc_ayuda FROM ayuda_condicion WHERE id_cond_ayuda = '1'";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();

    $title = "";
    if($consulta->rowCount() > 0){
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $title = $resultado["desc_ayuda"];

    }
    /* FIN */
    
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <h1 class="Titulo"> Mantenedor de administradores </h1>
            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdm"> Nuevo administrador </button> <?php endif; ?>
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
        <table class="table table-striped table-hover table-bordered" id="tablaAdministradores">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FAdm1" name="FAdm" placeholder="Nombre de usuario"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FAdm2" name="FAdm" placeholder="Rut"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FAdm3" name="FAdm" placeholder="Nombre"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FAdm4" name="FAdm" placeholder="Email"> </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5):?> <th scope="col"> </th> <?php endif; ?>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Nombre de usuario <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Nombre <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Email <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
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
?>

        <!-- Modal -->
        <div class="modal fade" id="modalAdm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModal"> Nuevo administrador </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdm">
                            <h1 class="title"> Datos de inicio de sesión </h1>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Email</label> <label style="color:red">*</label>
                                    <input id="email" class="form-control form-control-sm" type="text" placeholder="Ingrese el email. Ej: Ejemplo@ejemplo.com" maxlength="50" required>
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
                                    <input id="telefono" class="form-control form-control-sm" type="text" placeholder="Ingrese el teléfono." maxlength="20" required>
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
                                                $conexion = NULL;
                                            }else{
                                        ?>
                                            <option value="">No existen paises</option>
                                        <?php    
                                            }
                                            /* Cierre conexiones DB */
                                            $consulta = NULL;
                                            $conexion = NULL;

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
                                    <label>Provincia</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="provincia" required>
                                        <option value="">Seleccione una provincia</option>
                                    </select>
                                </div>

                              
                            </div>
                            <div class="form-group row">

                            <div class="col-lg-6 col-sm-12">
                                    <label>Comuna</label> <label style="color:red">*</label>
                                    <select style="width: 100%" id="comuna" required>
                                        <option value="">Seleccione una region</option>
                                    </select>
                                </div>

                                
                                <div class="col-lg-6 col-sm-12">
                                    <label>Dirección</label> <label style="color:red">*</label>
                                    <input id="direccion" class="form-control form-control-sm" type="text" placeholder="Ingrese la dirección." maxlength="60" required>
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

<?php
    endif;
?>
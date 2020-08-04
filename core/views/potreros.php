<?php
    require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Mantenedor de potreros </h1>
                <?php if($_SESSION["tipo_curimapu"] == 5): ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPot"> Nuevo potrero </button> <?php endif; ?>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaPotreros">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPot1" name="FPot" placeholder="Agricultor" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPot2" name="FPot" placeholder="Predio" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPot3" name="FPot" placeholder="Region" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPot4" name="FPot" placeholder="Comuna" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPot5" name="FPot" placeholder="Nombre" > </th>
                    <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th scope="col"> </th> <?php endif; ?>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Agricultor <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Predio <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Region <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Comuna <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Nombre <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
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
<div class="modal fade" id="modalPot" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"> Nuevo potrero </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPot">
                <h1 class="title"> Datos del predio </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            <label>Agricultor</label> <label style="color:red">*</label>
                            <select style="width:100%" id="Pot1" required>
                                <?php
                                    $sql = "SELECT id_agric, razon_social FROM agricultor";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un agricultor</option>
                                <?php
                                        $agricultores = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($agricultores as $agricultor):
                                ?>
                                            <option value="<?=$agricultor["id_agric"]?>"><?=$agricultor["razon_social"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen agricultores</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Temporada</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="Pot2" required>
                                <?php
                                    $sql = "SELECT * FROM temporada";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione una temporada</option>
                                <?php
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
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Predio</label> <label style="color:red">*</label>
                            <select style="width:100%" id="Pot3" required>
                                <option value="">Seleccione un agricultor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            <label>Nombre</label> <label style="color:red">*</label>
                            <input id="Pot4" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre del potrero" maxlength="50" required>
                        </div>
                    </div>
                    <h1 class="title"> Datos del administrador </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            <label>Nombre</label> <label style="color:red">*</label>
                            <input id="Pot5" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre del administrador" maxlength="50" required>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label>Telefono</label> <label style="color:red">*</label>
                            <input id="Pot6" class="form-control form-control-sm" type="text" placeholder="Ingrese el telefono del administrador" maxlength="20" required>
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
<?php
    require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";

    /* Conexion */
    $conexion = new Conectar();
    $conexion = $conexion->conexion();
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Fichas </h1>
        <form method="POST" id="formExport">
            <img src="assets/images/ms-excel.png" id="descExcel">
        </form>
       
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->


    <div class="tab-pane fade show active" id="activas" role="tabpanel" aria-labelledby="activas-tab">
        <!-- Contenedor de la tabla ACTIVAS -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaActivas">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA1" name="FFichA" placeholder="Fieldbook" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA2" name="FFichA" placeholder="Fieldman" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA3" name="FFichA" placeholder="Temporada" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA4" name="FFichA" placeholder="Especie" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA5" name="FFichA" placeholder="Razon social" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA6" name="FFichA" placeholder="Rut" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA7" name="FFichA" placeholder="Telefono" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA8" name="FFichA" placeholder="Nombre administrador" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA9" name="FFichA" placeholder="Tel. Administrador" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA10" name="FFichA" placeholder="Oferta de negocio" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA11" name="FFichA" placeholder="Localidad" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA12" name="FFichA" placeholder="Region" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA13" name="FFichA" placeholder="Comuna" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA14" name="FFichA" placeholder="HA disponibles" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA15" name="FFichA" placeholder="Direccion" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA16" name="FFichA" placeholder="Representante legal" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA17" name="FFichA" placeholder="Rut representante" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA18" name="FFichA" placeholder="Tel. representante" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA19" name="FFichA" placeholder="Mail contacto" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA20" name="FFichA" placeholder="Banco" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA21" name="FFichA" placeholder="Cuenta corriente" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA22" name="FFichA" placeholder="Predio" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA23" name="FFichA" placeholder="Potrero" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA24" name="FFichA" placeholder="Rotación" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA25" name="FFichA" placeholder="Norting" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA26" name="FFichA" placeholder="Easting" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA27" name="FFichA" placeholder="Radio" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA28" name="FFichA" placeholder="Tipo de suelo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA29" name="FFichA" placeholder="Tipo de riego" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA30" name="FFichA" placeholder="Experiencia en el cultivo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA31" name="FFichA" placeholder="Tipo tenencia" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA32" name="FFichA" placeholder="Maquinaria" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA33" name="FFichA" placeholder="Carga de malezas" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA34" name="FFichA" placeholder="Estado general" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA35" name="FFichA" placeholder="Observaciones" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA36" name="FFichA" placeholder="Número anexo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FFichA37" name="FFichA" placeholder="Ficha" > </th>
                            <th scope="col"> </th>
                        </tr>
                        <tr>
                            <th> # </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Fieldbook <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Fieldman <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Temporada <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Razon social <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Rut <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Telefono <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Nombre administrador <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Tel. Administrador <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Oferta de negocio <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> Localidad <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="23" data-act="0"></i> Region <i class="fas fa-arrow-down" data-ord="24" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="25" data-act="0"></i> Comuna <i class="fas fa-arrow-down" data-ord="26" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="27" data-act="0"></i> HA disponibles <i class="fas fa-arrow-down" data-ord="28" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="29" data-act="0"></i> Direccion <i class="fas fa-arrow-down" data-ord="30" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="31" data-act="0"></i> Representante legal <i class="fas fa-arrow-down" data-ord="32" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="33" data-act="0"></i> Rut representante <i class="fas fa-arrow-down" data-ord="34" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="35" data-act="0"></i> Tel. representante <i class="fas fa-arrow-down" data-ord="36" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="37" data-act="0"></i> Mail contacto <i class="fas fa-arrow-down" data-ord="38" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="39" data-act="0"></i> Banco <i class="fas fa-arrow-down" data-ord="40" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="41" data-act="0"></i> Cuenta corriente <i class="fas fa-arrow-down" data-ord="42" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="43" data-act="0"></i> Predio <i class="fas fa-arrow-down" data-ord="44" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="45" data-act="0"></i> Potrero <i class="fas fa-arrow-down" data-ord="46" data-act="0"> </i> </div> </th>
                            <th> <div> Rotación </div> </th>
                            <th> <div> Norting </div> </th>
                            <th> <div> Easting </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="53" data-act="0"></i> Radio <i class="fas fa-arrow-down" data-ord="54" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="55" data-act="0"></i> Tipo de suelo <i class="fas fa-arrow-down" data-ord="56" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="57" data-act="0"></i> Tipo de riego <i class="fas fa-arrow-down" data-ord="58" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="59" data-act="0"></i> Experiencia en el cultivo <i class="fas fa-arrow-down" data-ord="60" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="61" data-act="0"></i> Tipo tenencia <i class="fas fa-arrow-down" data-ord="62" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="63" data-act="0"></i> Maquinaria <i class="fas fa-arrow-down" data-ord="64" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="65" data-act="0"></i> Carga de malezas <i class="fas fa-arrow-down" data-ord="66" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="67" data-act="0"></i> Estado general <i class="fas fa-arrow-down" data-ord="68" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="69" data-act="0"></i> Observaciones <i class="fas fa-arrow-down" data-ord="70" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="71" data-act="0"></i> Número anexo <i class="fas fa-arrow-down" data-ord="72" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="73" data-act="0"></i> Ficha <i class="fas fa-arrow-down" data-ord="74" data-act="0"> </i> </div> </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody id="datosActivas">
                    </tbody>
                    <tfoot id="paginacionActivas">
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla ACTIVAS -->
    </div>

    
    
    <div id="paginacion">
    </div>

<?php
    if($_SESSION["tipo_curimapu"] == 5 || $_SESSION["tipo_curimapu"] == 3):
?>

<!-- Modal -->
<div class="modal fade" id="modalFich" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalF"> Nueva ficha </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formFich" enctype="multipart/form-data">
                    <h1 class="title"> Datos provisorios</h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Estado</label>
                            <input id="FichP1" class="form-control form-control-sm" type="text" value="Provisoria" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Supervisor</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichP2" required>
                                <?php
                                    $sql = "SELECT U.id_usuario, CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS nombre FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE UTU.id_tu = 3";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un supervisor</option>
                                <?php
                                        $supervisores = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($supervisores as $supervisor):
                                ?>
                                            <option value="<?=$supervisor["id_usuario"]?>"><?=$supervisor["nombre"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen supervisores</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Temporada</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichP3" required>
                                <?php
                                    $sql = "SELECT id_tempo, nombre FROM temporada ORDER BY nombre DESC";
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
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Agricultor</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichP4" required>
                                <?php
                                    $sql = "SELECT id_agric, rut, razon_social FROM agricultor";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un agricultor</option>
                                <?php
                                        $agricultores = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($agricultores as $agricultor):
                                ?>
                                            <option value="<?=$agricultor["id_agric"]?>"><?=$agricultor["rut"]?> - <?=$agricultor["razon_social"]?></option>
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
                    </div>
                    <h1 class="title"> Datos predio</h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Region</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichP5" required>
                                <?php
                                    $sql = "SELECT * FROM region";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione una region</option>
                                <?php
                                        $regiones = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($regiones as $region):
                                ?>
                                            <option value="<?=$region["id_region"]?>"><?=$region["nombre"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen regiones</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Comuna</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichP6" required>
                                <option value="">Seleccione una region</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Localidad</label> <label style="color:red">*</label>
                            <input id="FichP7" class="form-control form-control-sm" type="text" required>
                        </div>
                    </div>
                    <h1 class="title"> Datos propuesta </h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Has disponible</label> <label style="color:red">*</label>
                            <input id="FichP8" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Propuesta de negocio</label> <label style="color:red">*</label>
                            <input id="FichP9" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <label>Observaciones</label>
                            <textarea class="form-control" id="FichP10" rows="3" placeholder="Ingrese observaciones"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                            <input class="form-control" type="file" name="imagenprovisoria" id="imagenprovisoria">  
                        </div>         
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                        <h3>nuevas Imagenes</h3>
                            <div id="contenedorImagenesProvisorias"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                            <div id="contenedorImagenesProvisoriasAntiguas"></div>
                        </div>
                    </div>
                </form>
                <br>
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
    if($_SESSION["tipo_curimapu"] == 5):
?>

<!-- Modal -->
<div class="modal fade" id="modalUpd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalU"> Activar ficha </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpd" enctype="multipart/form-data">
                    <!-- DATOS FICHA -->
                    <h1 class="title"> Datos ficha </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Estado</label>
                            <input id="FichAI1" class="form-control form-control-sm" type="text" value="Provisoria" disabled required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Supervisor</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA1" required>
                                <?php
                                    $sql = "SELECT U.id_usuario, CONCAT(U.nombre, ' ', U.apellido_p, ' ', U.apellido_m) AS nombre FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE UTU.id_tu = 3";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un supervisor</option>
                                <?php
                                        $supervisores = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($supervisores as $supervisor):
                                ?>
                                            <option value="<?=$supervisor["id_usuario"]?>"><?=$supervisor["nombre"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen supervisores</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Temporada</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA2" required>
                                <?php
                                    $sql = "SELECT id_tempo, nombre FROM temporada ORDER BY nombre DESC";
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
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Agricultor</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA3" required>
                                <?php
                                    $sql = "SELECT id_agric, rut, razon_social FROM agricultor";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un agricultor</option>
                                <?php
                                        $agricultores = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($agricultores as $agricultor):
                                ?>
                                            <option value="<?=$agricultor["id_agric"]?>"><?=$agricultor["rut"]?> - <?=$agricultor["razon_social"]?></option>
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
                    </div>

                    <!-- DATOS AGRICULTOR -->
                    <h1 class="title"> Datos agricultor </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-5 col-sm-6 space">
                            <label>Razón social</label>
                            <input id="infoA1" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Rut</label>
                            <input id="infoA2" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Correo</label>
                            <input id="infoA3" class="form-control form-control-sm" type="text" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Teléfono</label>
                            <input id="infoA4" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Región</label>
                            <input id="infoA5" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Comuna</label>
                            <input id="infoA6" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Nombre Representante Legal</label>
                            <input id="infoA7" class="form-control form-control-sm" type="text" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Rut  Representante Legal</label>
                            <input id="infoA8" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Teléfono Representante Legal</label>
                            <input id="infoA9" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Correo representante Legal</label>
                            <input id="infoA10" class="form-control form-control-sm" type="text" disabled>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Banco</label>
                            <input id="infoA11" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Tipo de Cuenta</label>
                            <input id="infoA12" class="form-control form-control-sm" type="text" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>N° cuenta</label>
                            <input id="infoA13" class="form-control form-control-sm" type="text" disabled>
                        </div>
                    </div>

                    <!-- DATOS PREDIO -->
                    <h1 class="title"> Datos predio </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Oferta de negocio</label> <label style="color:red">*</label>
                            <input id="FichA4" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Especie</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA5" required>
                                <?php
                                    $sql = "SELECT * FROM especie";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione una especie</option>
                                <?php
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
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Has disponibles</label> <label style="color:red">*</label>
                            <input id="FichA6" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Region</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA7" required>
                                <?php
                                    $sql = "SELECT * FROM region";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione una region</option>
                                <?php
                                        $regiones = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($regiones as $region):
                                ?>
                                            <option value="<?=$region["id_region"]?>"><?=$region["nombre"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen regiones</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Comuna</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA8" required>
                                <option value="">Seleccione una comuna</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Predio</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA9" required>
                                <option value="">Seleccione un predio</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Potrero</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA10" required>
                                <option value="">Seleccione un predio</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Localidad</label> <label style="color:red">*</label>
                            <input id="FichA11" class="form-control form-control-sm" type="text" required>
                        </div>
                    </div>

                    <!-- ROTACION -->
                    <h1 class="title"> Rotación </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Cultivo <?=date("Y")-4?></label>
                            <input id="FichA12" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Cultivo <?=date("Y")-3?></label>
                            <input id="FichA13" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Cultivo <?=date("Y")-2?></label>
                            <input id="FichA14" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Cultivo <?=date("Y")-1?></label>
                            <input id="FichA15" class="form-control form-control-sm" type="text">
                        </div>
                    </div>

                    
                    <!-- DATOS PREDIO -->
                    <h1 class="title"> Datos informativo </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Tipo de suelo</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA16" required>
                                <?php
                                    $sql = "SELECT * FROM tipo_suelo";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un tipo</option>
                                <?php
                                        $suelos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($suelos as $suelo):
                                ?>
                                            <option value="<?=$suelo["id_tipo_suelo"]?>"><?=$suelo["descripcion"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen tipos</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Tipo de riego</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA17" required>
                                <?php
                                    $sql = "SELECT * FROM tipo_riego";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un tipo</option>
                                <?php
                                        $riegos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($riegos as $riego):
                                ?>
                                            <option value="<?=$riego["id_tipo_riego"]?>"><?=$riego["descripcion"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen tipos</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Experiencia</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA18" required>
                                <option value="">Seleccione una afirmacion</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Tenencia</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA19" required>
                                <?php
                                    $sql = "SELECT * FROM tipo_tenencia_terreno";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un tipo</option>
                                <?php
                                        $terrenos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($terrenos as $terreno):
                                ?>
                                            <option value="<?=$terreno["id_tipo_tenencia_terreno"]?>"><?=$terreno["descripcion"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen tipos</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Maquinaria</label> <label style="color:red">*</label>
                            <select style="width: 100%" id="FichA20" required>
                                <?php
                                    $sql = "SELECT * FROM tipo_tenencia_maquinaria";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0){
                                ?>
                                        <option value="">Seleccione un tipo</option>
                                <?php
                                        $maquinarias = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($maquinarias as $maquina):
                                ?>
                                            <option value="<?=$maquina["id_tipo_tenencia_maquinaria"]?>"><?=$maquina["descripcion"]?></option>
                                <?php
                                        endforeach;
                                    }else{
                                ?>
                                       <option value="">No existen tipos</option>
                                <?php    
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Carga de malezas</label> <label style="color:red">*</label>
                            <input id="FichA21" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Estado general</label> <label style="color:red">*</label>
                            <input id="FichA22" class="form-control form-control-sm" type="text" required>
                        </div>
                        <div class="col-lg-2 col-sm-6 space">
                            <label>Fecha limite siembra</label> <label style="color:red">*</label>
                            <input id="FichA23" class="form-control form-control-sm" type="date" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 col-sm-12">
                            <label>Observaciones</label>
                            <textarea id="FichA24" class="form-control" rows="3" placeholder="Ingrese observaciones"></textarea>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <label>Observaciones de $ negocio o min garantizado (USD/HA)</label>
                            <textarea id="FichA25" class="form-control" rows="3" placeholder="Ingrese observaciones"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                            <input class="form-control" type="file" name="imagenActivar" id="imagenActivar">  
                        </div>         
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                        <h3>nuevas Imagenes</h3>
                            <div id="contenedorImagenesActivar"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 space">
                            <div id="contenedorImagenesActivarAntiguas"></div>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="errorModA" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p id="errorMenjA"> </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="optionUpd">Agregar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<?php
    endif;
?>

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Informacion </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="title"> Datos ficha </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-2 col-sm-6 space">
                        <label class="T1"><strong>Estado: </strong></label>
                        <label class="T2" id="FichI1"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Supervisor: </strong></label>
                        <label class="T2" id="FichI2"></label>
                    </div>
                    <div class="col-lg-2 col-sm-6 space">
                        <label class="T1"><strong>Año: </strong></label>
                        <label class="T2" id="FichI3"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Agricultor: </strong></label>
                        <label class="T2" id="FichI4"></label>
                    </div>
                </div>
                <h1 class="title"> Datos predio </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Localidad: </strong></label>
                        <label class="T2" id="FichI5"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Predio: </strong></label>
                        <label class="T2" id="FichI6"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Potrero: </strong></label>
                        <label class="T2" id="FichI7"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Has disponibles: </strong></label>
                        <label class="T2" id="FichI8"></label>
                    </div>
                </div>
                <h1 class="title"> Datos informativo </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Especie: </strong></label>
                        <label class="T2" id="FichI9"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Tenencia: </strong></label>
                        <label class="T2" id="FichI10"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Maquinaria: </strong></label>
                        <label class="T2" id="FichI11"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Experiencia: </strong></label>
                        <label class="T2" id="FichI12"></label>
                    </div>
                    <div class="col-lg-4 col-sm-6 space">
                        <label class="T1"><strong>Propuesta de negocio: </strong></label>
                        <label class="T2" id="FichI13"></label>
                    </div>
                </div>
                <h1 class="title"> Estado predio </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Tipo de suelo: </strong></label>
                        <label class="T2" id="FichI14"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Tipo de riego: </strong></label>
                        <label class="T2" id="FichI15"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Carga de malezas: </strong></label>
                        <label class="T2" id="FichI16"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Estado general: </strong></label>
                        <label class="T2" id="FichI17"></label>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <label class="T1"><strong>Observaciones: </strong></label>
                        <label class="T2" id="FichI18"></label>
                    </div>
                </div>
                <h1 class="title"> Historial predio </h1>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Cultivo <?=date("Y")-4?>: </strong></label>
                        <label class="T2" id="FichI19"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Cultivo <?=date("Y")-3?>: </strong></label>
                        <label class="T2" id="FichI20"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Cultivo <?=date("Y")-2?>: </strong></label>
                        <label class="T2" id="FichI21"></label>
                    </div>
                    <div class="col-lg-3 col-sm-6 space">
                        <label class="T1"><strong>Cultivo <?=date("Y")-1?>: </strong></label>
                        <label class="T2" id="FichI22"></label>
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
                <form id='formIMG' enctype='multipart/form-data' style="display: none;">
                    <h1 class='title'> Agregar imagenes </h1>
                    <hr>
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 space'>
                            <input class='form-control' type='file' name='imagenNew' id='imagenNew'>
                        </div>         
                    </div>
    
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 space'>
                            <h3>nuevas Imagenes</h3>
                            <div id='contenedorImagenesNew'></div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="alert alert-danger" role="alert" id="errorModI" hidden>
                            <h4 class="alert-heading">ATENCION!!</h4>
                            <p id="errorMenjI"> </p> 
                        </div>     
                    </div>

                    <div class='row'>
                        <div class='col-lg-12 col-sm-12'>
                            <button type="button" class="btn btn-success" style="padding:0.5rem" id="subirIMG">Agregar imagenes</button>
                        </div>     
                    </div>
                </form>
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

<?php
    /* Cierre conexiones DB */
    $consulta = NULL;
    $conexion = NULL;
?>
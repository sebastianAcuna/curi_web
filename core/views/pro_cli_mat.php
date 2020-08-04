<?php
    require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";
?>

<style>
.ocultar{
    display:none;
}
.mostrar{
    display:inherit;
}
</style>
<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Mantenedor de propiedades-especie-temporada </h1>
            </div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="titulo-tab" data-toggle="tab" href="#titulos" role="tab" aria-controls="titulos" aria-selected="true"> Titulos </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="propiedades-tab" data-toggle="tab" href="#propiedades" role="tab" aria-controls="propiedades" aria-selected="true"> Propiedades </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="relacion-tab" data-toggle="tab" href="#relacion" role="tab" aria-controls="relacion" aria-selected="true"> Propiedad-Especie-Temporada </a>
            </li>
        </ul>
    </div> 
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="titulos" role="tabpanel" aria-labelledby="titulos-tab">
    
        <div class="container-fluid" >
            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <!-- <button type="button" class="btn btn-primary btn-Aresolution" data-toggle="modal" data-target="#modalTit"> Nuevo titulo </button> --> <?php endif; ?>
        
            <div class="table-responsive">
            <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaTitulos">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FTit1" name="FTit" placeholder="Nombre español" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FTit2" name="FTit" placeholder="Nombre ingles" > </th>
                            <th scope="col"> 
                                <select name="FTit" class="form-control form-control-sm" id="FTit3"> 
                                    <option value="">Todos</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select> 
                            </th>
                            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th scope="col"> <button type="button" class="btn btn-primary btn-Bresolution" data-toggle="modal" data-target="#modalTit"> <i class="fas fa-plus"></i> </button> </th> <?php endif; ?>
                        </tr>
                        <tr>
                            <th> # </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> nombre español <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> nombre ingles <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> ¿es lista? <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th> Acciones </th> <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="datosTitulos">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- propiedades -->
    <div class="tab-pane fade show " id="propiedades" role="tabpanel" aria-labelledby="propiedades-tab">
        <div class="container-fluid" >
            <?php if($_SESSION["tipo_curimapu"] == 5): ?> <!-- <button type="button" class="btn btn-primary btn-Aresolution" data-toggle="modal" data-target="#modalProp"> Nueva propiedad </button> --> <?php endif; ?>
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaPropiedades">
                        <thead>
                            <tr>
                                <th scope="col"> </th>
                                <th scope="col"> <input type="text" class="form-control form-control-sm" id="FProp1" name="FProp" placeholder="Nombre español" > </th>
                                <th scope="col"> <input type="text" class="form-control form-control-sm" id="FProp2" name="FProp" placeholder="Nombre ingles" > </th>
                                <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th scope="col"> <button type="button" class="btn btn-primary btn-Bresolution" data-toggle="modal" data-target="#modalProp"> <i class="fas fa-plus"></i> </button> </th> <?php endif; ?>
                            </tr>
                            <tr>
                                <th> # </th>
                                <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> nombre español <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                                <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> nombre ingles <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                                <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th> Acciones </th> <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="datosPropiedades">
                        </tbody>
                    </table>
            </div>
            </div>
        </div>

    <!--  pro cli mat -->
    <div class="tab-pane fade show " id="relacion" role="tabpanel" aria-labelledby="relacion-tab">
    <div class="container-fluid" >
    <?php if($_SESSION["tipo_curimapu"] == 5): ?> <!-- <button type="button" class="btn btn-primary btn-Aresolution" data-toggle="modal" data-target="#modalRel"> Nueva Relacion </button> --> <?php endif; ?>

        <div class="table-responsive">
            <!-- Tabla -->
            <table class="table table-striped table-hover table-bordered" id="tablaRelacion">
                <thead>
                    <tr>
                        <th scope="col"> </th>
                        <th scope="col"> 
                            <select name="FRel" id="FRel1" style="width: 100%" > 
                                <?php 
                                /* Conexion */
                                    $conexion = new Conectar();
                                    $conexion = $conexion->conexion();
                                    $sql = "SELECT * FROM especie";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0) :
                                        ?> <option value="">Todas</option> <?

                                        $especies = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($especies as $especie): ?>
                                            <option value="<?=$especie["id_esp"]?>"><?=$especie["nombre"]?></option>
                                        <?php endforeach;
                                        else: ?>
                                            <option value="">No Existen especies</option>
                                        <?php endif;
                                    $consulta = NULL;
                                    $conexion = NULL;
                                ?>
                            </select> 
                        </th>
                        <th scope="col"> 
                            <select name="FRel" id="FRel2" style="width: 100%"> 
                                <?php 
                                /* Conexion */
                                    $conexion = new Conectar();
                                    $conexion = $conexion->conexion();
                                    $sql = "SELECT * FROM etapa";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0) :
                                        ?> <option value="">Todas</option> <?

                                        $etapas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($etapas as $etapa): ?>
                                            <option value="<?=$etapa["id_etapa"]?>"><?=$etapa["nombre"]?></option>
                                        <?php endforeach;
                                        else: ?>
                                            <option value="">No Existen Etapas</option>
                                        <?php endif;
                                    $consulta = NULL;
                                    $conexion = NULL;
                                ?>
                            </select>
                        
                        </th>
                        <th scope="col"> 
                            <select name="FRel"  id="FRel3" style="width: 100%"> 
                                <?php 
                                    /* Conexion */
                                    $conexion = new Conectar();
                                    $conexion = $conexion->conexion();
                                    $sql = "SELECT * FROM temporada ORDER BY nombre DESC";
                                    $consulta = $conexion->prepare($sql);
                                    $consulta->execute();
                                    if($consulta->rowCount() > 0) :
                                        ?> <option value="">Todas</option> <?

                                        $temporadas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($temporadas as $temporada): ?>
                                            <option value="<?=$temporada["id_tempo"]?>"><?=$temporada["nombre"]?></option>
                                        <?php endforeach;
                                        else: ?>
                                            <option value="">No Existen Temporadas</option>
                                        <?php endif;
                                    $consulta = NULL;
                                    $conexion = NULL;
                                ?>
                            </select>
                        </th>
                        <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRel4" name="FRel" placeholder="Titulo" > </th>
                        <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRel5" name="FRel" placeholder="Propiedad" > </th>
                        <th scope="col"> 
                            <select name="FRel"  id="FRel6" style="width: 100%"> 
                                <option value="">Todos</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select> 
                        </th>
                        <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th scope="col"> <button type="button" class="btn btn-primary btn-Bresolution" data-toggle="modal" data-target="#modalRel"> <i class="fas fa-plus"></i> </button> </th> <?php endif; ?>
                    </tr>
                    <tr>
                        <th> # </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Etapa <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Temporada <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Titulo <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> propiedad <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                        <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Aplica <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                        <?php if($_SESSION["tipo_curimapu"] == 5): ?> <th> Acciones </th> <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="datosRelaciones">
                </tbody>
            </table>
        </div>
    </div>    
    </div>

    <div id="paginacion"> </div>
</div>

<!-- Termina contenedor de la tabla -->

<?php
    if($_SESSION["tipo_curimapu"] == 5):

        /* Conexion */
        // $conexion = new Conectar();
        // $conexion = $conexion->conexion();
?>

<!-- Modal TITULO -->
   <div class="modal fade" id="modalTit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal"> Nuevo titulo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTitulo">
                        <h1 class="title"> Datos del titulo </h1>
                        <hr>
                        <div class="form-group row">
                            <div class="col-lg-4 col-sm-12">
                                <label>Nombre en español</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <input type="text" class="form-control form-control-sm" id="mTitulo1" name="mTitulo" placeholder="ingrese nombre en español">
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>Nombre en ingles</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <input type="text" class="form-control form-control-sm" id="mTitulo2" name="mTitulo" placeholder="ingrese nombre en inlges">
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>¿es lista?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select id="mTitulo3" style="width: 100%" name="mTitulo">
                                    <option value="">seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
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
                    <button type="submit" class="btn btn-success" id="optionModTit">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-- Termina el modal -->


<!-- Modal PROPIEDAD -->
   <div class="modal fade" id="modalProp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalProp"> Nuevo titulo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form id="formProp">
                            <h1 class="title"> Datos propiedad </h1>
                            <hr>
                            <div class="form-group row">
                                <div class="col-lg-4 col-sm-12">
                                    <label>Nombre en español</label><label style="color:red">*</label>
                                    <input type="text" class="form-control form-control-sm" id="mProp1" name="mProp">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label>Nombre en ingles</label><label style="color:red">*</label>
                                    <input type="text" class="form-control form-control-sm" id="mProp2" name="mProp2">
                                </div>
                                
                            </div>
                        </form>
                    <div class="alert alert-danger" role="alert" id="errorMod" hidden>
                        <h4 class="alert-heading">ATENCION!!</h4>
                        <p id="errorMenj"> </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="optionModProp">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-- Termina el modal -->

<!-- Modal -->
    <div class="modal fade" id="modalRel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalRel"> Nueva Relación </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formRel">
                        <h1 class="title"> Datos propiedad-especie-temporada </h1>
                        <hr>
                        <div class="form-group row">
                        <div class="col-lg-3 col-sm-12">
                                <label>Etapa</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel4" style="width:100%">
                                    <?php 
                                        /* Conexion */
                                        $conexion = new Conectar();
                                        $conexion = $conexion->conexion();
                                        $sql = "SELECT * FROM etapa";
                                        $consulta = $conexion->prepare($sql);
                                        $consulta->execute();
                                        if($consulta->rowCount() > 0) :
                                            ?> <option value="">seleccione...</option> <?
                                            $etapas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($etapas as $etapa): ?>
                                                <option value="<?=$etapa["id_etapa"]?>"><?=$etapa["nombre"]?></option>
                                            <?php endforeach;
                                            else: ?>
                                                <option value="">No Existen Etapas</option>
                                            <?php endif;
                                        $consulta = NULL;
                                        $conexion = NULL;
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-sm-12">
                                <div id="contenedor_titulo" class="">
                                    <label>Titulo</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                    <select name="mRel" id="mRel1" style="width:100%"> </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <label>Propiedad</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel2" style="width:100%"> </select>
                            </div>

                            <div class="col-lg-3 col-sm-12">
                                <label>Temporada</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel3" style="width:100%">
                                    <?php 
                                        /* Conexion */
                                        $conexion = new Conectar();
                                        $conexion = $conexion->conexion();
                                        $sql = "SELECT * FROM temporada";
                                        $consulta = $conexion->prepare($sql);
                                        $consulta->execute();
                                        if($consulta->rowCount() > 0) :
                                            ?> <option value="">seleccione...</option> <?
                                            $temporadas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($temporadas as $temporada): ?>
                                                <option value="<?=$temporada["id_tempo"]?>"><?=$temporada["nombre"]?></option>
                                            <?php endforeach;
                                            else: ?>
                                                <option value="">No Existen Temporadas</option>
                                            <?php endif;
                                        $consulta = NULL;
                                        $conexion = NULL;
                                    ?>
                                </select>
                            </div>

                            
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12">
                                <label>¿Quien ingresa la informacion?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel5"  style="width:100%">
                                    <option value="">seleccione...</option> 
                                    <option value="SAP">Viene desde SAP</option> 
                                    <option value="TABLET">Fieldman</option> 
                                    <option value="WEB">Administrador</option> 
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <label>Tipo de dato</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel6"  style="width:100%">
                                    <option value="">seleccione...</option> 
                                    <option value="TEXTVIEW">Solo se muestra</option> 
                                    <option value="TEXT">Texto Alfanumerico</option> 
                                    <option value="INT">Numerico entero</option> 
                                    <option value="DECIMAL">Numerico decimal</option> 
                                    <option value="CHECK">check</option> 
                                    <option value="DATE">fecha</option> 
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div id="contenedor_donde" class="ocultar">
                                    <label>¿de donde?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                    <select name="mRel" id="mRel7"  style="width:100%">
                                        <?php 
                                        /* Conexion */
                                        $conexion = new Conectar();
                                        $conexion = $conexion->conexion();
                                        $sql = "SELECT * FROM pro_cli_mat_tabla";
                                        $consulta = $conexion->prepare($sql);
                                        $consulta->execute();
                                        if($consulta->rowCount() > 0) :
                                            ?> <option value="">seleccione...</option> <?
                                            $pcmTablas = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($pcmTablas as $pcmTabla): ?>
                                                <option title="<?=$pcmTabla["descripcion"]?>" value="<?=$pcmTabla["nombre_real"]?>"><?=$pcmTabla["nombre_vista"]?></option>
                                            <?php endforeach;
                                            else: ?>
                                                <option value="">No Existen tablas</option>
                                            <?php endif;
                                        $consulta = NULL;
                                        $conexion = NULL;
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div id="contenedor_informacion" class="ocultar">
                                    <label>¿que informacion?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                    <select name="mRel" id="mRel8"  style="width:100%">
                                      
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12">
                            
                                <label>¿Aparecera en reporte cliente?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel9"  style="width:100%">
                                    <option value="">seleccione...</option> 
                                    <option value="SI">SI</option> 
                                    <option value="NO">NO</option> 
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <label>¿Especial para SYNGENTA ?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                <select name="mRel" id="mRel10"  style="width:100%">
                                    <option value="">seleccione...</option> 
                                    <option value="SI">SI</option> 
                                    <option value="NO">NO</option> 
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div id="contenedor_despues_titulo" class="">
                                    <label>¿En o despues de (Titulo) ?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                    <select name="mRel" id="mRel12"  style="width:100%"> </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div id="contenedor_despues" class="">
                                    <label>¿ despues de (Propiedad)?</label> (<label title="campo obligatorio" style="color:red">*</label>)
                                    <select name="mRel" id="mRel11"  style="width:100%">  </select>
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                        <h1 class="title"> Especies que lo aplican </h1>
                        <hr>
                        <div class="form-group row">
                            <div class="col-lg-12 col-sm-12">
                                <div style="display:flex; flex-direction:row;align-items:center;flex-wrap:wrap;" id="contenedor_especies_check"> </div>
                            </div>
                        </div>
                        
                       
                    </form>
                    
                    <div class="alert alert-danger" role="alert" id="errorMod" hidden>
                        <h4 class="alert-heading">ATENCION!!</h4>
                        <p id="errorMenj"> </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="optionModRelaciones">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

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
    <!-- Termina el modal -->

<?php
        /* Cierre conexiones DB */
        $consulta = NULL;
        $conexion = NULL;
    endif;
?>
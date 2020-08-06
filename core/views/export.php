<?php
    require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Export </h1>
        <form method="POST" id="formExport">
            <img src="assets/images/ms-excel.png" id="descExcel">
        </form>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Barra navegabilidad -->
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="planta-tab" data-toggle="tab" href="#planta" role="tab" aria-controls="planta" aria-selected="true"> Planta </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" id="recepcion-tab" data-toggle="tab" href="#recepcion" role="tab" aria-controls="recepcion" aria-selected="false"> Recepcion </a>
            </li> -->
        </ul>
    </div> 
</div>
<!-- FIN barra navegabilidad -->

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="planta" role="tabpanel" aria-labelledby="planta-tab">
        <!-- Contenedor de la tabla PLANTA -->
        <div class="container-fluid" >
            <div class="table-responsive">
                <!-- Tabla -->
                <table class="table table-striped table-hover table-bordered" id="tablaPlanta">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col"> 
                                <select id="FPla1" name="FPla" style="width:100%;">
                                        <option value="">Seleccione</option>
                                            <?php

                                                $conexion = new Conectar();
                                                $conexion = $conexion->conexion();

                                                $sql = "SELECT * FROM especie ORDER BY nombre ASC";
                                                $res = $conexion->prepare($sql);
                                                $res->execute();
                                                if($res->rowCount() > 0) :
                                                    $r = $res->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($r as $val) : ?>
                                                        <option value="<?php echo $val["id_esp"];?>"><?php echo $val["nombre"];?></option>
                                                    <?php endforeach;
                                                else : ?>    
                                                    <option value="">No hay especies </option>
                                                <?php endif;

                                            ?>
                                    </select>
                            
                            </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla3" name="FPla" placeholder="Cliente" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla4" name="FPla" placeholder="Variedad" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla5" name="FPla" placeholder="Anexo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla6" name="FPla" placeholder="Lote Cliente" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla7" name="FPla" placeholder="Agricultor" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla8" name="FPla" placeholder="Hectareas" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla9" name="FPla" placeholder="Fin de Lote" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla10" name="FPla" placeholder="Kgs Recepcionado" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla11" name="FPla" placeholder="Kgs Limpios" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FPla12" name="FPla" placeholder="Kgs Exportados" > </th>
                        </tr>
                        <tr>
                            <th> # </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Variedad <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Anexo <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Lote Cliente <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Agricultor <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Hectareas <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Fin de Lote <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Kgs Recepcionado <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Kgs Limpios <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> Kgs Exportados <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                        </tr>
                    </thead>
                    <tbody id="datosPlanta">
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Termina contenedor de la tabla PLANTA -->
    </div>

    <!-- <div class="tab-pane fade" id="recepcion"  role="tabpanel" aria-labelledby="recepcion-tab">
        <div class="container-fluid" >
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="tablaRecepcion">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">
                                    <select id="FRec1" name="FRec" style="width:100%;">
                                        <option value="">Seleccione</option>
                                           
                                    </select>
                            </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec3" name="FRec" placeholder="Variedad" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec4" name="FRec" placeholder="Anexo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec5" name="FRec" placeholder="Agricultor" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec6" name="FRec" placeholder="Rut Agricultor" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec7" name="FRec" placeholder="Lote Campo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec8" name="FRec" placeholder="Número Guía" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec9" name="FRec" placeholder="Peso Bruto" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec10" name="FRec" placeholder="Tara" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FRec11" name="FRec" placeholder="Peso Neto" > </th>
                        </tr>
                        <tr>
                            <th> # </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Variedad <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Anexo <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Agricultor <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Rut Agricultor <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Lote Campo <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Número Guía <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Peso Bruto <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Tara <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Peso Neto <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                        </tr>
                    </thead>
                    <tbody id="datosRecepcion">
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div> -->
    
    <div id="paginacion">
    </div>
</div>
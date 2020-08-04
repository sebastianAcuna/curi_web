<?php
    require_once '../controllers/secure/permisos.php';
    require "../db/conectarse_db.php";
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Stock Seed </h1>
        <form method="POST" id="formExport">
            <img src="assets/images/ms-excel.png" id="descExcel">
        </form>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla STOCK -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaStock">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> 

                    <select id="FSto1" name="FSto" style="width:100%;">
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
                    <th scope="col"> <input type="date" class="form-control form-control-sm" id="FSto2" name="FSto" placeholder="Fecha de Recepción" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto3" name="FSto" placeholder="Cliente" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto4" name="FSto" placeholder="Variedad" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto5" name="FSto" placeholder="Genetic" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto6" name="FSto" placeholder="Trait" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto7" name="FSto" placeholder="Sag Resolution Number" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto8" name="FSto" placeholder="Curimapu Batch Number" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto9" name="FSto" placeholder="Customer Batch" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto10" name="FSto" placeholder="Quantity Kg" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto11" name="FSto" placeholder="Notes" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto12" name="FSto" placeholder="Seed Treated by" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto13" name="FSto" placeholder="Curimapu Treated by" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto14" name="FSto" placeholder="Customer TSW" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto15" name="FSto" placeholder="Customer Germ %" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto16" name="FSto" placeholder="TSW" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSto17" name="FSto" placeholder="Curimapu Germ %" > </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Fecha de Recepción <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Variedad <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Genetic <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Trait <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Sag Resolution Number <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Curimapu Batch Number <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Customer Batch <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Quantity Kg <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> Notes <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="23" data-act="0"></i> Seed Treated by <i class="fas fa-arrow-down" data-ord="24" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="25" data-act="0"></i> Curimapu Treated by <i class="fas fa-arrow-down" data-ord="26" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="27" data-act="0"></i> Customer TSW <i class="fas fa-arrow-down" data-ord="28" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="29" data-act="0"></i> Customer Germ % <i class="fas fa-arrow-down" data-ord="30" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="31" data-act="0"></i> TSW <i class="fas fa-arrow-down" data-ord="32" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="33" data-act="0"></i> Curimapu Germ % <i class="fas fa-arrow-down" data-ord="34" data-act="0"> </i> </div> </th>
                </tr>
            </thead>
            <tbody id="datos">
            </tbody>
        </table>
    </div>
    
    <div id="paginacion">
    </div>
</div>
<!-- Termina contenedor de la tabla STOCK -->
<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
            <!-- Titulo mantenedor -->
            <div>
                <h1 class="Titulo"> Materiales </h1>
            </div>
		</div>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaMateriales">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMat1" name="FMat" placeholder="Especie" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMat2" name="FMat" placeholder="Nombre de fantasía" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMat3" name="FMat" placeholder="Nombre híbrido" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMat4" name="FMat" placeholder="P. Hembra" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FMat5" name="FMat" placeholder="P. Macho" > </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Nombre de fantasía <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Nombre híbrido <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> P. Hembra <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> P. Macho <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
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
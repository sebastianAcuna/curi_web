<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Anexos de contrato </h1>
        <form method="POST" id="formExport">
            <img src="assets/images/ms-excel.png" id="descExcel">
        </form>
	</div>
</div>
<!-- Fin contenedor head de cuerpo -->

<!-- Contenedor de la tabla -->
<div class="container-fluid" >
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-bordered" id="tablaContratos">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont0" name="FCont" placeholder="Ficha" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont1" name="FCont" placeholder="Número contrato" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont2" name="FCont" placeholder="Número anexo" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont3" name="FCont" placeholder="Cliente" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont4" name="FCont" placeholder="Agricultor" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont5" name="FCont" placeholder="Especie" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont6" name="FCont" placeholder="Variedad" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont7" name="FCont" placeholder="Base" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont8" name="FCont" placeholder="Precio" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont9" name="FCont" placeholder="Humedad" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont10" name="FCont" placeholder="Germinación" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont11" name="FCont" placeholder="Pureza Genética" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont12" name="FCont" placeholder="Pureza Física" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont13" name="FCont" placeholder="Enfermedades" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FCont14" name="FCont" placeholder="Malezas" > </th>
                    <!-- <th scope="col"> </th> -->
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="29" data-act="0"></i> Ficha <i class="fas fa-arrow-down" data-ord="30" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Número contrato <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Número anexo <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Agricultor <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Variedad <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Base <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Precio <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Humedad <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Germinación <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> Pureza Genética <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="23" data-act="0"></i> Pureza Física <i class="fas fa-arrow-down" data-ord="24" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="25" data-act="0"></i> Enfermedades <i class="fas fa-arrow-down" data-ord="26" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="27" data-act="0"></i> Malezas <i class="fas fa-arrow-down" data-ord="28" data-act="0"> </i> </div> </th>
                    <!-- <th> Acciones </th> -->
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
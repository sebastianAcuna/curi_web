<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Cliente Quotation </h1>
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
        <table class="table table-striped table-hover table-bordered" id="tablaQuotation">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo1" name="FQuo" placeholder="Cliente" > </th>
                    <!-- <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo2" name="FQuo" placeholder="Quotations" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo3" name="FQuo" placeholder="Detalles" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo4" name="FQuo" placeholder="Especies" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo5" name="FQuo" placeholder="Materiales" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo6" name="FQuo" placeholder="Agricultores" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo7" name="FQuo" placeholder="Supervisores" > </th> -->
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <!-- <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Quotations <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Detalle quotations <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Especies <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Materiales <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Agricultores <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Supervisores <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th> -->
                    <th> HA CONTRACTED </th>
                    <th> MT2 CONTRACTED </th>
                    <th> SITE CONTRACTED </th>
                    <th> USD CONTRACTED </th>
                    <th> EURO CONTRACTED </th>
                    <th> CLP CONTRACTED </th>
                    <th> KG CONTRACTED </th>
                    <th> HA MEASURED </th>
                    <th> KG ESTIMATED </th>
                    <th> USD ESTIMATED </th>
                    <th> USD PLAN </th>
                    <th> KG EXPORT </th>
                    <th> USD SOLD </th>
                    <th> Acciones </th>
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

<!-- Modal -->
<div class="modal fade" id="modalAnx" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoAnexos"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaAnx">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Número </th>
                                <th> Especie </th>
                                <th> Observacion </th>
                                <th> HA CONTRACTED </th>
                                <th> MT2 CONTRACTED </th>
                                <th> SITE CONTRACTED </th>
                                <th> USD CONTRACTED </th>
                                <th> EURO CONTRACTED </th>
                                <th> CLP CONTRACTED </th>
                                <th> KG CONTRACTED </th>
                                <th> HA MEASURED </th>
                                <th> KG ESTIMATED </th>
                                <th> USD ESTIMATED </th>
                                <th> USD PLAN </th>
                                <th> KG EXPORT </th>
                                <th> USD SOLD </th>
                                <th> Acciones </th>
                            </tr>
                        </thead>
                        <tbody id="datosAnx">
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

<!-- Modal -->
<div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoPdf"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPdf" style="padding: 10px 25px">
                </form>
                    <h1 class="title"> Observaciones del PDF </h1>
                    <hr>
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaPdf">
                        <thead>
                            <tr>
                                <td colspan="12">
                                    El contenido de las observaciones sera el que se vera en el pdf.
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Contrato
                                </th>
                                <th>
                                    General Status 
                                </th>
                                <th>
                                    Observation 
                                </th>
                                <th>
                                    Growth Status 
                                </th>
                                <th>
                                    Observation 
                                </th>
                                <th>
                                    Weed pressure status 
                                </th>
                                <th>
                                    Observation 
                                </th>
                                <th>
                                    Phytosanitary Status
                                </th> 
                                <th>
                                    Observation 
                                </th>
                                <th>
                                    Soil Moisture Status  
                                </th>
                                <th>
                                    Observation 
                                </th>
                            </tr>
                        </thead>
                        <tbody id="obsPdf">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" id="formGPDF">
                    <button type="button" class="btn btn-success" id="generarPDF">Generar PDF</button>
                </form>
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
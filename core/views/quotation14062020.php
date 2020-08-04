<?php
    require_once '../controllers/secure/permisos.php';
?>

<!-- Contenedor head de cuerpo -->
<div class="container-fluid">
	<div class="row head-title">
        <!-- Titulo mantenedor -->
        <h1 class="Titulo"> Detalle de quotation </h1>
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
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo1" name="FQuo" placeholder="Número" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo2" name="FQuo" placeholder="Cliente" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo3" name="FQuo" placeholder="Especie" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo4" name="FQuo" placeholder="Observaciones" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo5" name="FQuo" placeholder="HA CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo6" name="FQuo" placeholder="MT2 CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo7" name="FQuo" placeholder="SITE CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo8" name="FQuo" placeholder="USD CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo9" name="FQuo" placeholder="EURO CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo10" name="FQuo" placeholder="CLP CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo11" name="FQuo" placeholder="KG CONTRACTED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo12" name="FQuo" placeholder="HA MEASURED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo13" name="FQuo" placeholder="KG ESTIMATED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo14" name="FQuo" placeholder="USD ESTIMATED" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo15" name="FQuo" placeholder="USD PLAN" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo16" name="FQuo" placeholder="KG EXPORT" > </th>
                    <th scope="col"> <input type="text" class="form-control form-control-sm" id="FQuo17" name="FQuo" placeholder="USD SOLD" > </th>
                    <th scope="col"> </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> Número <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Observacion <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> HA CONTRACTED <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> MT2 CONTRACTED <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> SITE CONTRACTED <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> USD CONTRACTED <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> EURO CONTRACTED <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> CLP CONTRACTED <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> KG CONTRACTED <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="23" data-act="0"></i> HA MEASURED <i class="fas fa-arrow-down" data-ord="24" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="25" data-act="0"></i> KG ESTIMATED <i class="fas fa-arrow-down" data-ord="26" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="27" data-act="0"></i> USD ESTIMATED <i class="fas fa-arrow-down" data-ord="28" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="29" data-act="0"></i> USD PLAN <i class="fas fa-arrow-down" data-ord="30" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="31" data-act="0"></i> KG EXPORT <i class="fas fa-arrow-down" data-ord="32" data-act="0"> </i> </div> </th>
                    <th> <div> <i class="fas fa-arrow-up" data-ord="33" data-act="0"></i> USD SOLD <i class="fas fa-arrow-down" data-ord="34" data-act="0"> </i> </div> </th>
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
<div class="modal fade" id="modalDet" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoDetalle"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <!-- Tabla -->
                    <table class="table table-striped table-hover table-bordered" id="tablaTb">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Especie </th>
                                <th> Variedad </th>
                                <th> Superficie contratada </th>
                                <th> Superficie </th>
                                <th> Contrated </th>
                                <th> Kg Contracted </th>
                                <th> Price </th>
                                <th> Currency </th>
                                <th> Kg/Ha </th>
                                <th> Incoterms </th>
                                <th> Condition </th>
                                <th> Certification </th>
                                <th> Humedad </th>
                                <th> Germinación </th>
                                <th> Pureza genética </th>
                                <th> Fecha recepción de semilla </th>
                                <th> Pureza fisica </th>
                                <th> Fecha de despacho </th>
                                <th> Enfermedades </th>
                                <th> Malezas </th>
                                <th> Declaraciones adicionales </th>
                                <th> Tipo de envase </th>
                                <th> Kg Envase </th>
                                <th> Tipo de despacho </th>
                                <th> Observaciones de precio </th>
                            </tr>
                        </thead>
                        <tbody id="datosDet">
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
                            <tr>
                                <td colspan="12">
                                    El contenido de las observaciones sera el que se vera en el pdf.
                                </td>
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
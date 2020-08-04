
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCont"> Crear nuevo contrado agricultor </button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCal"> Calidad </button>
<!-- Modal -->
<div class="modal fade" id="modalCont" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Nuevo contrato </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCont">
                    <h1 class="title"> Datos mínimos de creación de contratos</h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Año</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="annoCont" required>
                                <?php
                                    $año = date("Y");
                                    echo $año;
                                    for($i = $año; $i > ($año-10); $i--){
                                ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Número contrato</label> <label style="color:red">*</label>
                            <input id="contratoCont" class="form-control form-control-sm" type="text" placeholder="Ingrese número contrato." required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Número de anexo</label> <label style="color:red">*</label>
                            <input id="anexoCont" class="form-control form-control-sm" type="text" placeholder="Ingrese número contrato." required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Agricultor</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="agricultorCont" required>
                                <option value="">Seleccione un agricultor</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Ficha</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="fichaCont" required>
                                <option value="">Seleccione una ficha</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Especie</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="especieCont" required>
                                <option value="">Seleccione una especie</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Variedad</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="variedadCont" required>
                                <option value="">Seleccione una variedad</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-7 space">
                            <label>Sugerencia ficha</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="sugerenciaCont">
                        </div>
                        <div class="col-lg-1 col-sm-5 space">
                            <label>Medida</label> 
                            <select class="form-control form-control-sm" id="medidaCont" required>
                                <option value="1">HA</option>
                                <option value="2">M2</option>
                                <option value="3">Site</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            </label>Base</label> <label style="color:red">*</label>
                            <input id="baseCont" class="form-control form-control-sm" type="text" placeholder="Ingrese número contrato." required>
                        </div>
                        <div class="col-lg-4 col-sm-7 space">
                            <label>Precio</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="precioCont">
                        </div>
                        <div class="col-lg-1 col-sm-5 space">
                            <label>Moneda</label> 
                            <select class="form-control form-control-sm" id="monedaCont" required>
                                <option value="1">HA</option>
                                <option value="2">M2</option>
                                <option value="3">Site</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            </label>Otras condiciones</label>
                            <textarea class="form-control" id="condicionesCont" rows="3" placeholder="Ingrese otras condiciones"></textarea>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="ErrorMod" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p></p>
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

<!-- Modal -->
<div class="modal fade" id="modalCal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Características de calidad </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCal">
                    <h1 class="title"> Detalle Contrato </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-5">
                            <label>Número contrato</label>
                            <input class="form-control" type="text" name="info" id="numeroContratoCon" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-7">
                            <label>Agricultor</label>
                            <input class="form-control" type="text" name="info" id="agricultorCon2" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Especie</label>
                            <input class="form-control" type="text" name="info" id="especieCont2" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Variedad</label>
                            <input class="form-control" type="text" name="info" id="variedadCont2" disabled>
                        </div>
                    </div>
                    <h1 class="title"> Modificar caracteristicas del contrato </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Humedad</label>
                            <input class="form-control" type="text" name="info" id="humedadCont">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Germinación</label>
                            <input class="form-control" type="text" name="info" id="germinacionCont">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Pureza genetica</label>
                            <input class="form-control" type="text" name="info" id="purezaGCont">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Pureza fisica</label>
                            <input class="form-control" type="text" name="info" id="purezaFCont">
                        </div>
                        <div class="col-lg-6 col-sm-12 space">
                            <label>Malezas</label>
                            <textarea class="form-control" id="malezaCont" rows="3" placeholder="Ingrese malezas"></textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12 space">
                            <label>Enfermedades</label>
                            <textarea class="form-control" id="enfermedadesCont" rows="3" placeholder="Ingrese enfermedades"></textarea>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="ErrorMod1" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="optionMod1">Agregar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->
<!-- ****************************************************************************************************************************** -->
<!-- Ficha -->
<div class="col-lg-5 col-sm-6 space">
    <label>Norting</label>
    <input id="FichA15" class="form-control form-control-sm" type="text">
</div>
<div class="col-lg-5 col-sm-6 space">
    <label>Easting</label> 
    <input id="FichA16" class="form-control form-control-sm" type="text">
</div>
<div class="col-lg-2 col-sm-6 space">
    <label>Obtener posición</label>
    <br>
    <button type="button" class="btn btn-success" id="FichA17" style="margin: 0; margin-left: 33px; padding: 0.5rem 0.75rem;"> <i class="fas fa-map-marked-alt"></i> </button>
</div>
<div class="col-lg-12 col-sm-12 space">
    <div id="map"></div>
</div>
<!-- ****************************************************************************************************************************** -->
<!-- Materiales -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMat"> Nuevo material </button>
<!-- Modal -->
<div class="modal fade" id="modalMat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Nuevo material </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMat">
                    <h1 class="title"> Datos del material </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            </label>Especie</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="especie" required>
                                <option value="">Seleccione una especie</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            </label>Nombre de fantasía</label> <label style="color:red">*</label>
                            <input id="nombreFant" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre de fantasía." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            </label>Nombre híbrido</label> <label style="color:red">*</label>
                            <input id="nnombreHib" class="form-control form-control-sm" type="text" placeholder="Ingrese el nombre híbrido." required>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            </label>P- Hembra</label> <label style="color:red">*</label>
                            <input id="pHembra" class="form-control form-control-sm" type="text" placeholder="Ingrese P. Hembra." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            </label>P. Macho</label> <label style="color:red">*</label>
                            <input id="pMacho" class="form-control form-control-sm" type="text" placeholder="Ingrese P. Macho." required>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="ErrorMod" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p></p>
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
<!-- ****************************************************************************************************************************** -->
<!-- Quotation -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalQuo"> Crear nuevo contrado quotation </button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVar"> Variedad </button>
<!-- Modal -->
<div class="modal fade" id="modalQuo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Nuevo quotation </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formQuo">
                    <h1 class="title"> Datos mínimos de creación quotation</h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            <label>Año</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="annoQuo" required>
                                <?php
                                    $año = date("Y");
                                    echo $año;
                                    for($i = $año; $i > ($año-10); $i--){
                                ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            </label>Número contrato quotation</label> <label style="color:red">*</label>
                            <input id="numeroQuo" class="form-control form-control-sm" type="text" placeholder="Ingrese número contrato." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            </label>Cliente</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="clienteQuo" required>
                                <option value="">Seleccione un cliente</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            </label>Especie</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="especieQuo" required>
                                <option value="">Seleccione una especie</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-12">
                            </label>Observaciones</label>
                            <textarea class="form-control" id="observacionesQuo" rows="3" placeholder="Ingrese observaciones"></textarea>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="ErrorMod" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p></p>
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

<!-- Modal -->
<div class="modal fade" id="modalVar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Nueva variedad </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVar">
                    <h1 class="title"> Detalle quotation </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-5">
                            <label>Número quotation</label>
                            <input class="form-control" type="text" name="info" id="numeroVar" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-7">
                            <label>Especie</label>
                            <input class="form-control" type="text" name="info" id="especieVar" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label>Cliente</label>
                            <input class="form-control" type="text" name="info" id="clienteVar" disabled>
                        </div>
                    </div>
                    <h1 class="title"> Detalle variedad </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-5 space">
                            <label>Especie</label>
                            <input class="form-control" type="text" name="info" id="especieVari" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-7 space">
                            <label>Variedad</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="variedadVar" required>
                                <option value="">Seleccione una especie</option>
                            </select>
                        </div>
                    </div>
                    <h1 class="title"> Detalle contrato </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-7 space">
                            <label>Tipo contrato</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="tipoContratoVar" required>
                                <option value="1">HA</option>
                                <option value="2">Contrato por kg</option>
                                <option value="3">Site</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Superfice contratada</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="superficieVar">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Medida</label> 
                            <select class="form-control form-control-sm" id="medidaVar" required>
                                <option value="1">HA</option>
                                <option value="2">M2</option>
                                <option value="3">Contrato por superficie</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-7 space">
                            <label>Contrato comercial</label>
                            <input class="form-control" type="text" name="info" id="contratoComercialVar" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Precio</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="precioVar">
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                        <label>Moneda</label> 
                            <select class="form-control form-control-sm" id="monedaVar" required>
                                <option value="1">USD</option>
                                <option value="2">EURO</option>
                                <option value="3">CLP</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Incoterms</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="incotermsVar" required>
                                <option value="">Seleccione un incoterms</option>
                                <option value="1">FOB</option>
                                <option value="2">EXW</option>
                                <option value="3">FCA</option>
                                <option value="4">EXFAB</option>
                                <option value="5">CPT</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Tipo de certificación</label> <label style="color:red">*</label>
                            <select class="form-control form-control-sm" id="tipoCertificadoVar" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="1">AOSCA</option>
                                <option value="2">OECD</option>
                                <option value="3">CORRIENTE</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>KG Contratado</label>
                            <input class="form-control" type="text" name="info" id="kgContratadoVar" disabled>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Kg/HA</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="kghaVar" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Condicion</label>
                            <select class="form-control form-control-sm" id="condicionVar" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="1">GMO</option>
                                <option value="2">GMO FREE</option>
                                <option value="3">CONVENCIONAL</option>
                            </select>
                        </div>
                    </div>
                    <h1 class="title"> Detalle calidad </h1>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Humedad</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="humedadVar" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Germinación</label>
                            <input class="form-control" type="text" name="info" id="germinacionVar" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Pureza genetica</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="purezaGVar" required>
                        </div>
                        <div class="col-lg-3 col-sm-6 space">
                            <label>Pureza fisica</label> <label style="color:red">*</label>
                            <input class="form-control" type="text" name="info" id="purezaFVar" required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Fecha recepción de semilla</label>
                            <input class="form-control" type="date" name="info" id="fechaSemillaVar" required>
                        </div>
                        <div class="col-lg-4 col-sm-6 space">
                            <label>Fecha de despacho</label>
                            <input class="form-control" type="date" name="info" id="fechaDespachoVar" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4 col-sm-12 space">
                            <label>Malezas</label>
                            <textarea class="form-control" id="malezasVar" rows="3" placeholder="Ingrese malezas"></textarea>
                        </div>
                        <div class="col-lg-4 col-sm-12 space">
                            <label>Declaraciones adicionales</label>
                            <textarea class="form-control" id="declaracionesVar" rows="3" placeholder="Ingrese declaraciones adicionales"></textarea>
                        </div>
                        <div class="col-lg-4 col-sm-12 space">
                            <label>Enfermedades</label>
                            <textarea class="form-control" id="enfermedadesVar" rows="3" placeholder="Ingrese enfermedades"></textarea>
                        </div>
                    </div>
                </form>
                <div class="alert alert-danger" role="alert" id="ErrorMod1" hidden>
                    <h4 class="alert-heading">ATENCION!!</h4>
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="optionMod1">Agregar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Termina el modal -->

<tr>
                            <th rowspan="3"> # </th>
                            <th colspan="8"></th>
                            <th colspan="2"> Field </th>
                            <th colspan="2"> Coordenate </th>
                            <th> Aviso Siembra SAG </th>
                            <th colspan="4"> Crop Rotation </th>
                            <th colspan="3"> Análisis de Suelo</th>
                            <th> Isolation </th>
                            <th> Lines </th>
                            <th colspan="2"> Sowing Lot </th>
                            <th> Sowing Date Start </th>
                            <th> Sowing Date End </th>
                            <th> Sowing Seed / meter </th>
                            <th> Row Distance (m) </th>
                            <th colspan="4"> Spread Urea (N) </th>
                            <th colspan="3"> Pre Emergence Herbicide </th>
                            <th colspan="6"> Herbicide Spraying Date </th>
                            <th colspan="3"> Bruchus pisorum L. and Sclerotinia preventive application </th>
                            <th>  Plant/m  </th>
                            <th> Population (plants/ha) </th>
                            <th colspan="3"> Foliar Application </th>
                            <th rowspan="3"> Acciones </th>
                        </tr>
                        <tr>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow1" name="FSow" placeholder="PICTURES" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow2" name="FSow" placeholder="RECOMENDACIONES" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow3" name="FSow" placeholder="Field Number" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow4" name="FSow" placeholder="Anexo" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow5" name="FSow" placeholder="Cliente" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow6" name="FSow" placeholder="Especie" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow7" name="FSow" placeholder="Variedad" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow8" name="FSow" placeholder="Agricultor" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow9" name="FSow" placeholder="Predio" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow10" name="FSow" placeholder="Potrero" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow11" name="FSow" placeholder="Norting" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow12" name="FSow" placeholder="Easting" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow13" name="FSow" placeholder="Aviso Siembra SAG" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow14" name="FSow" placeholder="2013" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow15" name="FSow" placeholder="2014" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow16" name="FSow" placeholder="2015" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow17" name="FSow" placeholder="2016" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow18" name="FSow" placeholder="Entregado" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow19" name="FSow" placeholder="Tipo de Mezcla Aplicada" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow20" name="FSow" placeholder="Cantidad Aplicada" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow21" name="FSow" placeholder="Meters" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow22" name="FSow" placeholder="Female" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow23" name="FSow" placeholder="Female" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow24" name="FSow" placeholder="Real Sowing Female (kg)" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow25" name="FSow" placeholder="Female" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow26" name="FSow" placeholder="Female" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow27" name="FSow" placeholder="F" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow28" name="FSow" placeholder="Row Distance (m)" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow29" name="FSow" placeholder="Dose 1" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow30" name="FSow" placeholder="Date 1" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow31" name="FSow" placeholder="Dose 2" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow32" name="FSow" placeholder="Date 2" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow33" name="FSow" placeholder="Date" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow34" name="FSow" placeholder="Dose" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow35" name="FSow" placeholder="Water (Lts)" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow36" name="FSow" placeholder="Name 1" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow37" name="FSow" placeholder="Date 1" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow38" name="FSow" placeholder="Name 2" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow39" name="FSow" placeholder="Date 2" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow40" name="FSow" placeholder="Name 3" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow41" name="FSow" placeholder="Date 3" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow42" name="FSow" placeholder="Date" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow43" name="FSow" placeholder="Product" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow44" name="FSow" placeholder="Dose (Lt/Ha)" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow45" name="FSow" placeholder="F" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow46" name="FSow" placeholder="F" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow47" name="FSow" placeholder="Foliar" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow48" name="FSow" placeholder="Dose" > </th>
                            <th scope="col"> <input type="text" class="form-control form-control-sm" id="FSow49" name="FSow" placeholder="Date" > </th>
                        </tr>
                        <tr>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="1" data-act="0"></i> PICTURES <i class="fas fa-arrow-down" data-ord="2" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="3" data-act="0"></i> RECOMENDACIONES <i class="fas fa-arrow-down" data-ord="4" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="5" data-act="0"></i> Field Number <i class="fas fa-arrow-down" data-ord="6" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="7" data-act="0"></i> Anexo <i class="fas fa-arrow-down" data-ord="8" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="9" data-act="0"></i> Cliente <i class="fas fa-arrow-down" data-ord="10" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="11" data-act="0"></i> Especie <i class="fas fa-arrow-down" data-ord="12" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="13" data-act="0"></i> Variedad <i class="fas fa-arrow-down" data-ord="14" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="15" data-act="0"></i> Agricultor <i class="fas fa-arrow-down" data-ord="16" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="17" data-act="0"></i> Predio <i class="fas fa-arrow-down" data-ord="18" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="19" data-act="0"></i> Potrero <i class="fas fa-arrow-down" data-ord="20" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="21" data-act="0"></i> Norting <i class="fas fa-arrow-down" data-ord="22" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="23" data-act="0"></i> Easting <i class="fas fa-arrow-down" data-ord="24" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="25" data-act="0"></i> Aviso Siembra SAG <i class="fas fa-arrow-down" data-ord="26" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="27" data-act="0"></i> 2013 <i class="fas fa-arrow-down" data-ord="28" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="29" data-act="0"></i> 2014 <i class="fas fa-arrow-down" data-ord="30" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="31" data-act="0"></i> 2015 <i class="fas fa-arrow-down" data-ord="32" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="33" data-act="0"></i> 2016 <i class="fas fa-arrow-down" data-ord="34" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="35" data-act="0"></i> Entregado <i class="fas fa-arrow-down" data-ord="36" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="37" data-act="0"></i> Tipo de Mezcla Aplicada <i class="fas fa-arrow-down" data-ord="38" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="39" data-act="0"></i> Cantidad Aplicada <i class="fas fa-arrow-down" data-ord="40" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="41" data-act="0"></i> Meters <i class="fas fa-arrow-down" data-ord="42" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="43" data-act="0"></i> Female <i class="fas fa-arrow-down" data-ord="44" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="45" data-act="0"></i> Female <i class="fas fa-arrow-down" data-ord="46" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="47" data-act="0"></i> Real Sowing Female (kg) <i class="fas fa-arrow-down" data-ord="48" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="49" data-act="0"></i> Female <i class="fas fa-arrow-down" data-ord="50" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="51" data-act="0"></i> Female <i class="fas fa-arrow-down" data-ord="52" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="53" data-act="0"></i> F <i class="fas fa-arrow-down" data-ord="54" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="55" data-act="0"></i> Row Distance (m) <i class="fas fa-arrow-down" data-ord="56" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="57" data-act="0"></i> Dose 1 <i class="fas fa-arrow-down" data-ord="58" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="59" data-act="0"></i> Date 1 <i class="fas fa-arrow-down" data-ord="60" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="61" data-act="0"></i> Dose 2 <i class="fas fa-arrow-down" data-ord="62" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="63" data-act="0"></i> Date 2 <i class="fas fa-arrow-down" data-ord="64" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="65" data-act="0"></i> Date <i class="fas fa-arrow-down" data-ord="66" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="67" data-act="0"></i> Dose <i class="fas fa-arrow-down" data-ord="68" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="69" data-act="0"></i> Water (Lts) <i class="fas fa-arrow-down" data-ord="70" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="71" data-act="0"></i> Name 1 <i class="fas fa-arrow-down" data-ord="72" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="73" data-act="0"></i> Date 1 <i class="fas fa-arrow-down" data-ord="74" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="75" data-act="0"></i> Name 2 <i class="fas fa-arrow-down" data-ord="76" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="77" data-act="0"></i> Date 2 <i class="fas fa-arrow-down" data-ord="78" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="79" data-act="0"></i> Name 3 <i class="fas fa-arrow-down" data-ord="80" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="81" data-act="0"></i> Date 3 <i class="fas fa-arrow-down" data-ord="82" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="83" data-act="0"></i> Date <i class="fas fa-arrow-down" data-ord="84" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="85" data-act="0"></i> Product <i class="fas fa-arrow-down" data-ord="86" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="87" data-act="0"></i> Dose (Lt/Ha) <i class="fas fa-arrow-down" data-ord="88" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="89" data-act="0"></i> F <i class="fas fa-arrow-down" data-ord="90" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="91" data-act="0"></i> F <i class="fas fa-arrow-down" data-ord="92" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="93" data-act="0"></i> Foliar <i class="fas fa-arrow-down" data-ord="94" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="95" data-act="0"></i> Dose <i class="fas fa-arrow-down" data-ord="96" data-act="0"> </i> </div> </th>
                            <th> <div> <i class="fas fa-arrow-up" data-ord="96" data-act="0"></i> Date <i class="fas fa-arrow-down" data-ord="98" data-act="0"> </i> </div> </th>
                        </tr>
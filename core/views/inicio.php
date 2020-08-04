<?php
    require_once '../controllers/secure/permisos.php';
?> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Agricultores</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalAgric">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-hat-cowboy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Contratos</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalCont">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="far fa-handshake"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Quotations</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalQuo">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fab fa-quora"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Especies</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalEsp">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-spa"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Hectareas</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalHec">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-map"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Visitas</h5>
                                <span class="h2 font-weight-bold mb-0" id="totalVis">0</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row" align="center">
            <div class="col-lg-6 col-sm-12" style="margin-bottom: 1rem">
                <div id="visPredio"></div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <h5 class="Titulo"> Predios no visitados durante los ultimos 10 dias</h5>
                <div id="predNoVis" class="row" align="center">
                    <div class="col-lg-6 col-sm-12" style="margin-bottom: 1rem">
                        <ul id="predNoVis1" class="list-group list-group-flush">
                        </ul>
                    </div>
                    <div class="col-lg-6 col-sm-12" style="margin-bottom: 1rem">
                        <ul id="predNoVis2" class="list-group list-group-flush">
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row" align="center">
            <div class="col-lg-6 col-sm-12" style="margin-bottom: 1rem">
                <div id="haEspecies"></div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div id="haVariedad"></div>
            </div>
        </div>
    </div>
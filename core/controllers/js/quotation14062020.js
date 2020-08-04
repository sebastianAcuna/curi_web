/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/quotation.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FNum = document.getElementById("FQuo1").value;
        var FCli = document.getElementById("FQuo2").value;
        var FEsp = document.getElementById("FQuo3").value;
        var FObs = document.getElementById("FQuo4").value;
        var FHAC = document.getElementById("FQuo5").value;
        var FMT2C = document.getElementById("FQuo6").value;
        var FSitC = document.getElementById("FQuo7").value;
        var FUSDC = document.getElementById("FQuo8").value;
        var FEUROC = document.getElementById("FQuo9").value;
        var FCLPC = document.getElementById("FQuo10").value;
        var FKGC = document.getElementById("FQuo11").value;
        var FHAM = document.getElementById("FQuo12").value;
        var FKGE = document.getElementById("FQuo13").value;
        var FUSDE = document.getElementById("FQuo14").value;
        var FUSDP = document.getElementById("FQuo15").value;
        var FKGEX = document.getElementById("FQuo16").value;
        var FUSDS = document.getElementById("FQuo17").value;

        // Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&Temporada='+Temporada+'&FNum='+FNum+'&FCli='+FCli+'&FEsp='+FEsp+'&FObs='+FObs+'&FHAC='+FHAC+'&FMT2C='+FMT2C+'&FSitC='+FSitC+'&FUSDC='+FUSDC+'&FEUROC='+FEUROC+'&FCLPC='+FCLPC+'&FKGC='+FKGC+'&FHAM='+FHAM+'&FKGE='+FKGE+'&FUSDE='+FUSDE+'&FUSDP='+FUSDP+'&FKGEX='+FKGEX+'&FUSDS='+FUSDS,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null && resp.length != 0){

                    $.each(resp,function(i,item){
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.numero_contrato)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            Contenido += "<td "+minText(item.obs)+"</td>";
                            Contenido += "<td "+minText(item.superficieHA)+"</td>";
                            Contenido += "<td "+minText(item.superficieMT)+"</td>";
                            Contenido += "<td "+minText(item.superficieSi)+"</td>";
                            Contenido += "<td "+minText(item.costoUSD)+"</td>";
                            Contenido += "<td "+minText(item.costoEURO)+"</td>";
                            Contenido += "<td "+minText(item.costoCLP)+"</td>";
                            Contenido += "<td "+minText(((item.kgs)?item.kgs:0))+"</td>";
                            Contenido += "<td "+minText(((item.ham)?item.ham:0))+"</td>";
                            Contenido += "<td "+minText(((item.kge)?item.kge:0))+"</td>";
                            Contenido += "<td "+minText(((item.usde)?item.usde:0))+"</td>";
                            Contenido += "<td "+minText(((item.usdp)?item.usdp:0))+"</td>";
                            Contenido += "<td "+minText(((item.kgex)?item.kgex:0))+"</td>";
                            Contenido += "<td "+minText(((item.usds)?item.usds:0))+"</td>";
                            Contenido += "<td class='fix-edi' align='center' style='min-width:100px'>";
                            Contenido += "<button type='button' class='btn btn-success' data-ver='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-search' data-ver='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' ></i> </button>";
                            Contenido += "<button type='button' class='btn btn-danger' data-pdf='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' data-nom='"+item.nombre+"' data-cli='"+item.razon_social+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-file-pdf' data-pdf='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' data-nom='"+item.nombre+"' data-cli='"+item.razon_social+"' ></i> </button>";
                            Contenido += "<button type='button' class='btn btn-success' data-exl='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-file-excel' data-exl='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' ></i> </button> </td>";
                        Contenido += "</tr>";

                    });

                }else{
                    Contenido = "<tr> <td colspan='20' style='text-align:center'> No existen quotation </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='20' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });

    }

    function totalDatos(){
    
        //Datos de filtro
        var FNum = document.getElementById("FQuo1").value;
        var FCli = document.getElementById("FQuo2").value;
        var FEsp = document.getElementById("FQuo3").value;
        var FObs = document.getElementById("FQuo4").value;
        var FHAC = document.getElementById("FQuo5").value;
        var FMT2C = document.getElementById("FQuo6").value;
        var FSitC = document.getElementById("FQuo7").value;
        var FUSDC = document.getElementById("FQuo8").value;
        var FEUROC = document.getElementById("FQuo9").value;
        var FCLPC = document.getElementById("FQuo10").value;
        var FKGC = document.getElementById("FQuo11").value;
        var FHAM = document.getElementById("FQuo12").value;
        var FKGE = document.getElementById("FQuo13").value;
        var FUSDE = document.getElementById("FQuo14").value;
        var FUSDP = document.getElementById("FQuo15").value;
        var FKGEX = document.getElementById("FQuo16").value;
        var FUSDS = document.getElementById("FQuo17").value;
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&Temporada='+Temporada+'&FNum='+FNum+'&FCli='+FCli+'&FEsp='+FEsp+'&FObs='+FObs+'&FHAC='+FHAC+'&FMT2C='+FMT2C+'&FSitC='+FSitC+'&FUSDC='+FUSDC+'&FEUROC='+FEUROC+'&FCLPC='+FCLPC+'&FKGC='+FKGC+'&FHAM='+FHAM+'&FKGE='+FKGE+'&FUSDE='+FUSDE+'&FUSDP='+FUSDP+'&FKGEX='+FKGEX+'&FUSDS='+FUSDS,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp != null && resp.length != 0){
                    sessionStorage.TotalAct = resp.Total;
        
                }else{
                    sessionStorage.TotalAct = 0;
        
                }

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                reject(textStatus+" => "+responseText);

            });

        });

    }

    function traerInfo(info,num){
        $.ajax({
            data:'action=traerInfo&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            if(resp != null && resp.length != 0){

                Contenido = "";
                $.each(resp,function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td "+minText(item.especie)+"</td>";
                        Contenido += "<td "+minText(item.nom_hibrido)+"</td>";
                        Contenido += "<td "+minText(item.superficie_contr)+"</td>";
                        Contenido += "<td "+minText(item.unidadM)+"</td>";
                        Contenido += "<td "+minText((item.kg_contratados*item.precio))+"</td>";
                        Contenido += "<td "+minText(item.kg_contratados)+"</td>";
                        Contenido += "<td "+minText(item.precio)+"</td>";
                        Contenido += "<td "+minText(item.moneda)+"</td>";
                        Contenido += "<td "+minText((item.kg_contratados/item.superficie_contr))+"</td>";
                        Contenido += "<td "+minText(item.incoterm)+"</td>";
                        Contenido += "<td "+minText(item.condicion)+"</td>";
                        Contenido += "<td "+minText(item.certificacion)+"</td>";
                        Contenido += "<td "+minText(item.humedad)+"</td>";
                        Contenido += "<td "+minText(item.germinacion)+"</td>";
                        Contenido += "<td "+minText(item.pureza_genetica)+"</td>";
                        Contenido += "<td "+minText(item.fecha_recep_sem)+"</td>";
                        Contenido += "<td "+minText(item.pureza_fisica)+"</td>";
                        Contenido += "<td "+minText(item.fecha_despacho)+"</td>";
                        Contenido += "<td "+minText(item.enfermedades)+"</td>";
                        Contenido += "<td "+minText(item.maleza)+"</td>";
                        Contenido += "<td "+minText(item.declaraciones)+"</td>";
                        Contenido += "<td "+minText(item.envase)+"</td>";
                        Contenido += "<td "+minText(item.neto)+"</td>";
                        Contenido += "<td "+minText(item.despacho)+"</td>";
                        Contenido += "<td "+minText(item.observaciones_del_precio)+"</td>";
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='26' style='text-align:center'> No existen detalles de quotation </td> </tr>";

            }

            document.getElementById("datosDet").innerHTML = Contenido;
            document.getElementById("infoDetalle").innerText = "Detalle de quotation N°"+num;
            $("#modalDet").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerInfoPdf(info,num,nom,cli){
        $.ajax({
            data:'action=traerInfoPdf&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var ContenidoCheck = "";
            var ContenidoObs = "";

            if(resp[1] != null){

                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h1 class='title'> Datos del PDF </h1><hr>";
                ContenidoCheck +=        "<div class='alert alert-success' role='alert'>";
                ContenidoCheck +=          "Obs: El orden que tomaran los datos en el PDF es el orden de los checks de izquierda a derecha fila a fila.";
                ContenidoCheck +=        "</div>";

                $.each(resp[1],function(i,item){
                    if(item.especial == "NO" || (item.especial == "SI" && cli.toLowerCase().includes("syngenta"))){
                        var nombre = (item.sub.trim() == item.pri.trim()) ? item.sub.trim() : item.pri.trim()+" - "+item.sub.trim();
                        var check = (item.etapa <= resp[2].etapa)? "checked":"";
                        ContenidoCheck +=  (i%3 == 0) ? "</div><div class='form-group row'>" : "";
                        ContenidoCheck +=  "<div class='col-lg-4 col-sm-12'>";
                        ContenidoCheck +=       "<div class='form-group form-check'>";
                        ContenidoCheck +=           "<input type='checkbox' class='form-check-input' name='inputPdf' data-nom='"+nombre+"' id='"+item.id_prop_mat_cli+"' "+check+">";
                        ContenidoCheck +=           "<label class='form-check-label' for='"+item.id_prop_mat_cli+"'> <strong>"+nombre+"</strong></label>";
                        ContenidoCheck +=       "</div>";
                        ContenidoCheck +=   "</div>";

                    }

                });

            }else{
                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h4> No se encontraron datos de información para asignar al pdf, debido a que no existen datos. </h4>";
                ContenidoCheck +=    "</div>";

            }


            
            if(resp[0] != null){

                $.each(resp[0],function(i,item){
                    ContenidoObs += "<tr>";
                        ContenidoObs += "<td>"+(i+1)+"</td>";
                        ContenidoObs += "<td "+minText(item.num_anexo)+"</td>";
                        ContenidoObs += "<td "+minText(item.estado_gen_culti)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='General_Status' value='"+item.obs_gen+"'></td>";
                        ContenidoObs += "<td "+minText(item.estado_crec)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Growth_Status' value='"+item.obs_cre+"'></td>";
                        ContenidoObs += "<td "+minText(item.estado_male)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Weed_pressure_status' value='"+item.obs_male+"'></td>";
                        ContenidoObs += "<td "+minText(item.estado_fito)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Phytosanitary_Status' value='"+item.obs_fito+"'></td>";
                        ContenidoObs += "<td "+minText(item.hum_del_suelo)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Soil_Moisture_Status' value='"+item.obs_hum+"'></td>";
                    ContenidoObs += "</tr>";

                });

            }else{
                ContenidoObs = "<tr> <td colspan='12' style='text-align:center'> No existen observaciones </td> </tr>";

            }

            document.getElementById("formPdf").innerHTML = ContenidoCheck;
            document.getElementById("obsPdf").innerHTML = ContenidoObs;
            document.getElementById("generarPDF").dataset.quo = num;
            document.getElementById("generarPDF").dataset.nom = nom;
            document.getElementById("generarPDF").dataset.cli = cli;
            document.getElementById("generarPDF").dataset.info = info;
            document.getElementById("infoPdf").innerText = "Preparacion PDF quotation N°"+num;
            $("#modalPdf").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

/*              Fin traer datos              */
/*==================================================================================================================================*/
/*              Traer informacion              */

    function informacion() { 
        const promiseDatos = traerDatos(1);

        promiseDatos.then(
            result => totalDatos().then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            /* finaly => console.log() */
            
        );
    
    }

    informacion();

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Ejecutar paginacion              */

    var paginacion = document.getElementById("paginacion");
        
    paginacion.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "BUTTON" ) {
            var pagina = e.target.dataset.page;
            traerDatos(pagina);
            paginador();

        }
        
    });

/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Ejecutar eventos de la tabla              */

    var tabla = document.getElementById("tablaQuotation");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.ver != undefined) {
            var ver = e.target.dataset.ver;
            var num = e.target.dataset.num;
            traerInfo(ver,num);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.pdf != undefined) {
            var pdf = e.target.dataset.pdf;
            var num = e.target.dataset.num;
            var nom = e.target.dataset.nom;
            var cli = e.target.dataset.cli;
            traerInfoPdf(pdf,num,nom,cli);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.exl != undefined) {
            var exl = e.target.dataset.exl;
            var num = e.target.dataset.num;
            descargaExcelDetalle(e,exl,num);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            traerDatos(1);

        }
        
    });

    var datos = document.getElementById("datosDet");
    
    datos.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td" && e.target.name != undefined) {
            verMas(e.target,1);
    
        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td" && e.target.name != undefined){
            verMas(e.target);
    
        }
        
    });
    
/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FQuo"){
            traerDatos(1);

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FQuo1":
                e.returnValue = keyValida(e,"N",e.target);
            break;
            case "FQuo2":
            case "FQuo3":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FQuo4":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;
            case "FQuo5":
            case "FQuo6":
            case "FQuo7":
            case "FQuo8":
            case "FQuo9":
            case "FQuo10":
            case "FQuo11":
            case "FQuo12":
            case "FQuo13":
            case "FQuo14":
            case "FQuo15":
            case "FQuo16":
            case "FQuo17":
                e.returnValue = keyValida(e,"ND",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e){
        e.preventDefault();
        
        var filtros = document.getElementsByName("FQuo");

        //Orden de datos
        var Orden = obtenerOrden();

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        var campos = "?Temporada="+Temporada+"&Orden="+Orden;

        for(let i = 0; i < filtros.length; i++){
            if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
                campos += "&"+filtros[i].id+"="+filtros[i].value;

            }

        }
        
        let form = document.getElementById('formExport');
        form.action = "docs/excel/quotation.php"+campos;
        form.submit();

    }

    function descargaExcelDetalle(e,Info,Num){
        e.preventDefault();
        let form = document.getElementById('formExport');
        form.action = "docs/excel/detalle_quotation.php?Info="+Info+"&Num="+Num;
        form.submit();

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        descargaExcel(e);

    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaPdf(e){
        e.preventDefault();
        
        var input = document.getElementsByName("inputPdf");

        var checks = new Array();
        for(let i = 0; i < input.length; i++){
            if(input[i].checked){
                checks.push({0 : input[i].id, 1 : input[i].dataset.nom});

            }

        }

        var observacion = document.getElementsByName("observation");

        var obs = new Object();
        for(let i = 0; i < observacion.length; i++){
            if(observacion[i].value != ""){
                obs[observacion[i].dataset.id] = (obs[observacion[i].dataset.id]) ? obs[observacion[i].dataset.id]+" || "+observacion[i].dataset.name+": "+observacion[i].value : observacion[i].dataset.name+": "+observacion[i].value;

            }

        }

        //Quotation de datos
        var Quotation = e.target.dataset.quo;

        //Especie
        var Especie = e.target.dataset.nom;

        //Cliente
        var Cliente = e.target.dataset.cli;

        //Info
        var Info = e.target.dataset.info;

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        var campos = "?Temporada="+Temporada+"&Quotation="+Quotation+"&Especie="+Especie+"&Cliente="+Cliente+"&Info="+Info+"&Observacion="+JSON.stringify(obs)+"&Checks="+JSON.stringify(checks);

        /* for(let i = 0; i < input.length; i++){
            campos += "&"+input[i].id+"="+input[i].checked;

        } */

        let form = document.getElementById('formGPDF');
        form.action = "docs/pdf/quotation.php"+campos;
        form.submit();

    }

    document.getElementById("generarPDF").addEventListener('click', function(e) {
        descargaPdf(e);

    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
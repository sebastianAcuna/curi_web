/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/quotation.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){
        // Data del ajax
        var data = "";
        data = "action=traerDatos";

        // Orden de datos
        var Orden = obtenerOrden();
        data += "&Orden="+Orden;

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);
        data += "&D="+Des;

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        var filtros = document.getElementsByName("FQuo");

        for (let i = 0; i < filtros.length; i++){
            var value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:data,
                url:urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp.status == "success" && resp.data != null){

                    $.each(resp.data,function(i,item){
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            /* Contenido += "<td "+minText(item.quotations)+"</td>";
                            Contenido += "<td "+minText(item.detalles)+"</td>";
                            Contenido += "<td "+minText(item.especies)+"</td>";
                            Contenido += "<td "+minText(item.materiales)+"</td>";
                            Contenido += "<td "+minText(item.agricultores)+"</td>";
                            Contenido += "<td "+minText(item.supervisores)+"</td>"; */
                            Contenido += "<td "+separador(minText(item.superficieHA))+"</td>";
                            Contenido += "<td "+separador(minText(item.superficieMT))+"</td>";
                            Contenido += "<td "+separador(minText(item.superficieSi))+"</td>";
                            Contenido += "<td "+separador(minText(item.costoUSD))+"</td>";
                            Contenido += "<td "+separador(minText(item.costoEURO))+"</td>";
                            Contenido += "<td "+separador(minText(item.costoCLP))+"</td>";
                            Contenido += "<td "+separador(minText(((item.kgs)?item.kgs:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.ham)?item.ham:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.kge)?item.kge:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.usde)?item.usde:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.usdp)?item.usdp:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.kgex)?item.kgex:0)))+"</td>";
                            Contenido += "<td "+separador(minText(((item.usds)?item.usds:0)))+"</td>";
                            Contenido += "<td class='fix-edi' align='center' style='min-width:100px'>";
                            Contenido += "<button type='button' class='btn btn-success' data-ver='"+item.id_cli+"' data-name='"+item.razon_social+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-search' data-ver='"+item.id_cli+"' data-name='"+item.razon_social+"' ></i> </button>";
                            Contenido += "<button type='button' class='btn btn-danger' data-pdf='"+item.id_cli+"' data-name='"+item.razon_social+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-file-pdf' data-pdf='"+item.id_cli+"' data-name='"+item.razon_social+"' ></i> </button>";
                            Contenido += "<button type='button' class='btn btn-success' data-exl='"+item.id_cli+"' data-name='"+item.razon_social+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-file-excel' data-exl='"+item.id_cli+"' data-name='"+item.razon_social+"' ></i> </button> </td>";
                        Contenido += "</tr>";

                    });

                }else if(resp.status == "success" && resp.data == null){
                    Contenido = "<tr> <td colspan='16' style='text-align:center'> No existen registros </td> </tr>";

                }else if(resp.status == "error"){
                    Contenido = "<tr> <td colspan='16' style='text-align:center'> Ups(1).. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='16' style='text-align:center'> Ups(2).. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });

    }

    function totalDatos(){
        // Data del ajax
        var data = "";
        data = "action=totalDatos";

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        var filtros = document.getElementsByName("FQuo");

        for (let i = 0; i < filtros.length; i++){
            var value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:data,
                url:urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp.status == "success" && resp.Total != null){
                    sessionStorage.TotalAct = resp.Total;
        
                }else if(resp.status == "success" && resp.Total == null){
                    sessionStorage.TotalAct = 0;
        
                }

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                reject(textStatus+" => "+responseText);

            });

        });

    }

    function traerInfo(info,cliente){
        // Data del ajax
        var data = "";
        data = "action=traerInfo";

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Info
        data += "&info="+info;

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var Contenido = "";
            
            if(resp.status == "success" && resp.data != null){

                Contenido = "";
                $.each(resp.data,function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td "+minText(item.numero_contrato)+"</td>";
                        Contenido += "<td "+minText(item.nombre)+"</td>";
                        Contenido += "<td "+minText(item.obs)+"</td>";
                        Contenido += "<td "+separador(minText(item.superficieHA))+"</td>";
                        Contenido += "<td "+separador(minText(item.superficieMT))+"</td>";
                        Contenido += "<td "+separador(minText(item.superficieSi))+"</td>";
                        Contenido += "<td "+separador(minText(item.costoUSD))+"</td>";
                        Contenido += "<td "+separador(minText(item.costoEURO))+"</td>";
                        Contenido += "<td "+separador(minText(item.costoCLP))+"</td>";
                        Contenido += "<td "+separador(minText(((item.kgs)?item.kgs:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.ham)?item.ham:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.kge)?item.kge:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.usde)?item.usde:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.usdp)?item.usdp:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.kgex)?item.kgex:0)))+"</td>";
                        Contenido += "<td "+separador(minText(((item.usds)?item.usds:0)))+"</td>";
                        Contenido += "<td class='fix-edi' align='center' style='min-width:80px'>";
                        Contenido += "<button type='button' class='btn btn-danger' data-pdfanx='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' data-nom='"+item.nombre+"' data-cli='"+cliente+"' style='margin: 0 5px 0 0; padding:.1rem .3rem'> <i class='fas fa-file-pdf' data-pdfanx='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' data-nom='"+item.nombre+"' data-cli='"+cliente+"' ></i> </button>";
                        Contenido += "<button type='button' class='btn btn-success' data-exlanx='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-file-excel' data-exlanx='"+item.id_quotation+"' data-num='"+item.numero_contrato+"' ></i> </button> </td>";
                    Contenido += "</tr>";

                });

            }else if(resp.status == "success" && resp.data == null){
                Contenido = "<tr> <td colspan='20' style='text-align:center'> No existen registros </td> </tr>";

            }else if(resp.status == "error"){
                Contenido = "<tr> <td colspan='20' style='text-align:center'> Ups(1).. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";

            }

            document.getElementById("datosAnx").innerHTML = Contenido;
            document.getElementById("infoAnexos").innerText = "Lista Quotation : "+cliente;

            $("#modalAnx").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='20' style='text-align:center'> Ups(2).. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datos").innerHTML = Contenido;

            console.log(textStatus+" => "+responseText);

        });

    }

    function traerInfoAnexosPdf(info,num,nom,cli){
        // Data del ajax
        var data = "";
        data = "action=traerInfoAnexosPdf";

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Info
        data += "&info="+info;

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var ContenidoCheck = "";
            var ContenidoObs = "";

            if(resp[1].status == "success" && resp[1].data != null){

                var titulos = new Array();
                var especies = new Array();
                var e = 0;

                ContenidoCheck +=   "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=       "<h1 class='title'> Datos del PDF </h1><hr>";
                ContenidoCheck +=       "<div class='alert alert-success' role='alert'>";
                ContenidoCheck +=           "Obs:";
                ContenidoCheck +=           "<br>";
                ContenidoCheck +=           "- El disponer de checks a elegir, no representa que los anexos presentan información, si descubre un anexo faltante, verifique si posee visitas.";
                ContenidoCheck +=           "<br>";
                ContenidoCheck +=           "- El orden que tomaran los datos en el PDF es el orden de los checks de izquierda a derecha fila a fila.";
                ContenidoCheck +=       "</div>";
                ContenidoCheck +=       "<div class='form-group form-check'>";
                ContenidoCheck +=          "<input type='checkbox' class='form-check-input' name='inputChecks' id='todosCheck'>";
                ContenidoCheck +=          "<label class='form-check-label' for='todosCheck'> <strong> Marcar / Desmarcar todos</strong></label>";
                ContenidoCheck +=       "</div>";

                $.each(resp[1].data,function(i,item){
                    if(item.especial == "NO" || (item.especial == "SI" && cli.toLowerCase().includes("syngenta"))){
                        var nombre = (item.sub.trim() == item.pri.trim()) ? item.sub.trim() : item.pri.trim()+" - "+item.sub.trim();
                        var check = (item.etapa <= resp[2].data.etapa)? "checked":"";

                        e = (titulos.indexOf(item.nombreE) == -1)? 0 : e+1;
                        ContenidoCheck +=  (especies.indexOf(item.especie) == -1) ? "</div><div class='col-lg-12 col-sm-12' align='center'>" : "";
                        ContenidoCheck +=      (especies.indexOf(item.especie) == -1) ? "<h5>"+item.especie+"</h5><hr></div>": "";
                         
                        ContenidoCheck +=  (titulos.indexOf(item.nombreE) == -1) ? "</div><div class='col-lg-12 col-sm-12' align='center'>" : "";
                        ContenidoCheck +=      (titulos.indexOf(item.nombreE) == -1) ? "<h5>"+item.nombreE+"</h5><hr></div>": "";
                        ContenidoCheck +=  (e%3 == 0) ? "</div><div class='form-group row'>" : "";
                        ContenidoCheck +=       "<div class='col-lg-4 col-sm-12'>";
                        ContenidoCheck +=           "<div class='form-group form-check'>";
                        ContenidoCheck +=               "<input type='checkbox' class='form-check-input' name='inputPdf' data-etap='"+item.nombreE+"' data-nom='"+nombre+"' id='"+item.id_prop_mat_cli+"' "+check+">";
                        ContenidoCheck +=               "<label class='form-check-label' for='"+item.id_prop_mat_cli+"'> <strong>"+nombre+"</strong></label>";
                        ContenidoCheck +=           "</div>";
                        ContenidoCheck +=       "</div>";

                        if(titulos.indexOf(item.nombreE) == -1) titulos.push(item.nombreE);
                        if(especies.indexOf(item.especie) == -1) especies.push(item.especie);

                    }

                });

            }else if(resp[1].status == "success" && resp[1].data == null){
                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h4> No existe contenido para seleccionar y rellenar el pdf actualmente. </h4>";
                ContenidoCheck +=    "</div>";

            }else if(resp[1].status == "error"){
                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h4> Ups(1).. Hemos encontrado una falla en la comunicación con el sistema, si el problema persiste notifique a sistema. </h4>";
                ContenidoCheck +=    "</div>";
                
            }

            if(resp[0].status == "success" && resp[0].data != null){

                $.each(resp[0].data,function(i,item){
                    if(item.Obs != null){
                        ContenidoObs += "<tr>";
                            ContenidoObs += "<td>"+(i+1)+"</td>";
                            ContenidoObs += "<td "+minText(item.num_anexo)+"</td>";
    
                            let obs = item.Obs.split(" && ");
                            let gen = obs[0].split(" -> ");
                            let gro = obs[1].split(" -> ");
                            let wee = obs[2].split(" -> ");
                            let phy = obs[3].split(" -> ");
                            let soi = obs[4].split(" -> ");
    
                            ContenidoObs += "<td "+minText(gen[0])+"</td>";
                            ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='General_Status' value='"+gen[1]+"'  maxlength='130'></td>";
                            ContenidoObs += "<td "+minText(gro[0])+"</td>";
                            ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Growth_Status' value='"+gro[1]+"'  maxlength='130'></td>";
                            ContenidoObs += "<td "+minText(wee[0])+"</td>";
                            ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Weed_pressure_status' value='"+wee[1]+"' maxlength='130'></td>";
                            ContenidoObs += "<td "+minText(phy[0])+"</td>";
                            ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Phytosanitary_Status' value='"+phy[1]+"' maxlength='130'></td>";
                            ContenidoObs += "<td "+minText(soi[0])+"</td>";
                            ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Soil_Moisture_Status' value='"+soi[1]+"' maxlength='130'></td>";
                        ContenidoObs += "</tr>";

                    }else{
                        ContenidoObs += "<tr>";
                            ContenidoObs += "<td>"+(i+1)+"</td>";
                            ContenidoObs += "<td "+minText(item.num_anexo)+"</td>";
                            ContenidoObs += "<td colspan='10' align='center'> Este anexo no posee observaciones debido a que no posee visitas </td>";
                        ContenidoObs += "</tr>";

                    }

                });

            }else if(resp[0].status == "success" && resp[0].data == null){
                ContenidoObs = "<tr> <td colspan='12' style='text-align:center'> No existen observaciones </td> </tr>";

            }else if(resp[0].status == "error"){
                ContenidoObs = "<tr> <td colspan='12' style='text-align:center'> Ups(2).. Hemos encontrado una falla en la comunicación con el sistema, si el problema persiste notifique a sistema. </td> </tr>";
                
            }

            document.getElementById("formPdf").innerHTML = ContenidoCheck;
            document.getElementById("obsPdf").innerHTML = ContenidoObs;
            document.getElementById("generarPDF").dataset.quo = "";
            document.getElementById("generarPDF").dataset.nom = "";
            document.getElementById("generarPDF").dataset.cli = cli;
            document.getElementById("generarPDF").dataset.info = info;
            document.getElementById("generarPDF").dataset.formato = 2;
            document.getElementById("infoPdf").innerText = "Preparacion PDF cliente "+cli;
            $("#modalPdf").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerInfoPdf(info,num,nom,cli){
        // Data del ajax
        var data = "";
        data = "action=traerInfoPdf";

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Info
        data += "&info="+info;

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var ContenidoCheck = "";
            var ContenidoObs = "";

            if(resp[1].status == "success" && resp[1].data != null){

                var titulos = new Array();
                var e = 0;

                ContenidoCheck +=   "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=       "<h1 class='title'> Datos del PDF </h1><hr>";
                ContenidoCheck +=       "<div class='alert alert-success' role='alert'>";
                ContenidoCheck +=           "Obs: El orden que tomaran los datos en el PDF es el orden de los checks de izquierda a derecha fila a fila.";
                ContenidoCheck +=       "</div>";
                ContenidoCheck +=       "<div class='form-group form-check'>";
                ContenidoCheck +=          "<input type='checkbox' class='form-check-input' name='inputChecks' id='todosCheck'>";
                ContenidoCheck +=          "<label class='form-check-label' for='todosCheck'> <strong> Marcar / Desmarcar todos</strong></label>";
                ContenidoCheck +=       "</div>";

                $.each(resp[1].data,function(i,item){
                    if(item.especial == "NO" || (item.especial == "SI" && cli.toLowerCase().includes("syngenta"))){
                        var nombre = (item.sub.trim() == item.pri.trim()) ? item.sub.trim() : item.pri.trim()+" - "+item.sub.trim();
                        var check = (item.etapa <= resp[2].data.etapa)? "checked":"";

                        e = (titulos.indexOf(item.nombreE) == -1)? 0 : e+1;
                        
                        ContenidoCheck +=  (titulos.indexOf(item.nombreE) == -1) ? "</div><div class='col-lg-12 col-sm-12' align='center'>" : "";
                        ContenidoCheck +=      (titulos.indexOf(item.nombreE) == -1) ? "<h5>"+item.nombreE+"</h5><hr></div>": "";
                        ContenidoCheck +=  (e%3 == 0) ? "</div><div class='form-group row'>" : "";
                        ContenidoCheck +=       "<div class='col-lg-4 col-sm-12'>";
                        ContenidoCheck +=           "<div class='form-group form-check'>";
                        ContenidoCheck +=               "<input type='checkbox' class='form-check-input' name='inputPdf' data-nom='"+nombre+"' id='"+item.id_prop_mat_cli+"' "+check+">";
                        ContenidoCheck +=               "<label class='form-check-label' for='"+item.id_prop_mat_cli+"'> <strong>"+nombre+"</strong></label>";
                        ContenidoCheck +=           "</div>";
                        ContenidoCheck +=       "</div>";

                        if(titulos.indexOf(item.nombreE) == -1) titulos.push(item.nombreE);

                    }

                });

            }else if(resp[1].status == "success" && resp[1].data == null){
                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h4> No existe contenido para seleccionar y rellenar el pdf actualmente. </h4>";
                ContenidoCheck +=    "</div>";

            }else if(resp[1].status == "error"){
                ContenidoCheck +=    "<div class='col-lg-12 col-sm-12'>";
                ContenidoCheck +=        "<h4> Ups(1).. Hemos encontrado una falla en la comunicación con el sistema, si el problema persiste notifique a sistema. </h4>";
                ContenidoCheck +=    "</div>";
                
            }

            if(resp[0].status == "success" && resp[0].data != null){

                $.each(resp[0].data,function(i,item){
                    ContenidoObs += "<tr>";
                        ContenidoObs += "<td>"+(i+1)+"</td>";
                        ContenidoObs += "<td "+minText(item.num_anexo)+"</td>";
                        ContenidoObs += "<td "+minText(item.estado_gen_culti)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='General_Status' value='"+item.obs_gen+"' maxlength='130'></td>";
                        ContenidoObs += "<td "+minText(item.estado_crec)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Growth_Status' value='"+item.obs_cre+"' maxlength='130'></td>";
                        ContenidoObs += "<td "+minText(item.estado_male)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Weed_pressure_status' value='"+item.obs_male+"' maxlength='130'></td>";
                        ContenidoObs += "<td "+minText(item.estado_fito)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Phytosanitary_Status' value='"+item.obs_fito+"' maxlength='130'></td>";
                        ContenidoObs += "<td "+minText(item.hum_del_suelo)+"</td>";
                        ContenidoObs += "<td><input type='text' class='form-control form-control-sm inp-lib-text' name='observation' data-id='"+item.num_anexo+"' data-name='Soil_Moisture_Status' value='"+item.obs_hum+"' maxlength='130'></td>";
                    ContenidoObs += "</tr>";

                });

            }else if(resp[0].status == "success" && resp[0].data == null){
                ContenidoObs = "<tr> <td colspan='12' style='text-align:center'> No existen observaciones </td> </tr>";

            }else if(resp[0].status == "error"){
                ContenidoObs = "<tr> <td colspan='12' style='text-align:center'> Ups(2).. Hemos encontrado una falla en la comunicación con el sistema, si el problema persiste notifique a sistema. </td> </tr>";
                
            }

            document.getElementById("formPdf").innerHTML = ContenidoCheck;
            document.getElementById("obsPdf").innerHTML = ContenidoObs;
            document.getElementById("generarPDF").dataset.quo = num;
            document.getElementById("generarPDF").dataset.nom = nom;
            document.getElementById("generarPDF").dataset.cli = cli;
            document.getElementById("generarPDF").dataset.info = info;
            document.getElementById("generarPDF").dataset.formato = 1;
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
            var name = e.target.dataset.name;
            traerInfo(ver,name);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.pdf != undefined) {
            var pdf = e.target.dataset.pdf;
            var name = e.target.dataset.name;
            traerInfoAnexosPdf(pdf,"","",name);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.exl != undefined) {
            var exl = e.target.dataset.exl;
            var name = e.target.dataset.name;
            descargaExcel(e,exl,name,2);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            informacion();

        }
        
    });

    var datos = document.getElementById("datosAnx");
    
    datos.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.pdfanx != undefined) {
            var pdfanx = e.target.dataset.pdfanx;
            var num = e.target.dataset.num;
            var nom = e.target.dataset.nom;
            var cli = e.target.dataset.cli;
            traerInfoPdf(pdfanx,num,nom,cli);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.exlanx != undefined) {
            var exlanx = e.target.dataset.exlanx;
            var num = e.target.dataset.num;
            descargaExcelDetalle(e,exlanx,num);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td" && e.target.name != undefined) {
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
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FQuo1":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;
            case "FQuo2":
            case "FQuo3":
            case "FQuo4":
            case "FQuo5":
            case "FQuo6":
            case "FQuo7":
                e.returnValue = keyValida(e,"N",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Marcas todos los checks              */

    var checks = document.getElementById("formPdf");
        
    checks.addEventListener("click", function(e){
        if(e.target.checked == true && e.target.id == "todosCheck"){
            var checks = document.getElementsByName("inputPdf");
            for (i = 0; i < checks.length; i++){
                if(checks[i].type == "checkbox"){
                    checks[i].checked = true;

                }
            } 

        }else if(e.target.id == "todosCheck"){
            var checks = document.getElementsByName("inputPdf");
            for (i = 0; i < checks.length; i++){
                if(checks[i].type == "checkbox"){
                    checks[i].checked = false

                }
            } 

        }
        
    });

/*              Fin de marcas todos los checks              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e,exl,name,tipo){
        e.preventDefault();
        
        var filtros = document.getElementsByName("FQuo");

        //Orden de datos
        var Orden = obtenerOrden();

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        var campos = "?Temporada="+Temporada+"&Orden="+Orden;

        /* Datos */
        campos += "&exl="+exl;
        campos += "&name="+name;
        campos += "&tipo="+tipo;

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
        descargaExcel(e,'','',1);

    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaPdf(e){
        e.preventDefault();

        /* FormData */
        let frmData = new FormData;
        
        /* Inputs */
        let input = document.getElementsByName("inputPdf");

        /* Checks */
        let checks = new Array();
        for(let i = 0; i < input.length; i++){
            if(input[i].checked){
                checks.push({0 : input[i].id, 1 : input[i].dataset.nom, 2 : input[i].dataset.etap});

            }

        }

        /* Observaciones */
        let observacion = document.getElementsByName("observation");

        let obs = new Object();
        for(let i = 0; i < observacion.length; i++){
            if(observacion[i].value != ""){
                obs[observacion[i].dataset.id] = (obs[observacion[i].dataset.id]) ? obs[observacion[i].dataset.id]+" || "+observacion[i].dataset.name+": "+observacion[i].value : observacion[i].dataset.name+": "+observacion[i].value;

            }

        }

        // Temporada
        let Temporada = document.getElementById("selectTemporada").value;
        frmData.append('Temporada', Temporada);

        //Quotation
        let Quotation = e.target.dataset.quo;
        frmData.append('Quotation', Quotation);

        //Especie
        let Especie = e.target.dataset.nom;
        frmData.append('Especie', Especie);

        //Cliente
        let Cliente = e.target.dataset.cli;
        frmData.append('Cliente', Cliente);

        //Info
        let Info = e.target.dataset.info;
        frmData.append('Info', Info);

        //Formato
        let Formato = e.target.dataset.formato;
        frmData.append('Formato', Formato);

        //Observacion
        frmData.append('Observacion', JSON.stringify(obs));

        //Formato
        frmData.append('Checks', JSON.stringify(checks));

        $.ajax({
            url:"docs/pdf/quotation.php",
            method:"POST",
            data:frmData,
            cache:false,
            contentType: false,
            processData:false,
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                $("#modalAnx").modal('hide');
                $("#modalPdf").modal('hide');
                $("#modalCarga").modal('show');

            },
            error: function() {
                swal("Ops!", "Hemos encontrado una falla, por ende no se pudo descargar el PDF, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            },
            complete: function() {
                $("#modalCarga").modal('hide');
            },
        }).done(function(resp){
            let a = document.createElement('a');
            let url = window.URL.createObjectURL(resp);
            a.href = url;
            a.download = 'quotation_'+Cliente+'.pdf';
            a.setAttribute("target", "_blank");
            a.click();
            window.URL.revokeObjectURL(url);

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

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
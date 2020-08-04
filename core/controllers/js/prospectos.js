/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/prospectos.php";

    var arrayImagenes = new Array();

    var tablaActivas = document.getElementById("tablaActivas");

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Limpiar filtros              */

    function limpiarFiltros(){
        var FProsA = document.getElementsByName("FProsA");
        var FProsP = document.getElementsByName("FProsP");

        FProsA.forEach( function(element) { 
            element.value = "";

        });

        FProsP.forEach( function(element) { 
            element.value = "";

        });

        var up = document.getElementsByClassName("fa-arrow-up");

        for(let item of up) {
            item.dataset.act = 0;
            item.style.color = "black";

        };
        
        var down = document.getElementsByClassName("fa-arrow-down");

        for(let item of down) {
            item.dataset.act = 0;
            item.style.color = "black";

        };
        
    }


/*              Fin de limpiar filtros              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatosActivas(Page){
        // Data del ajax
        let data = "";
        data = "action=traerDatosActivas";

        // Orden de datos
        let Orden = obtenerOrden();
        data += "&Orden="+Orden;

        // Ve que pagina es y trae los datos correspondientes a tal
        let Des = obtenerPagina(Page);
        data += "&D="+Des;

        // Temporada de operacion
        let Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FProsA");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
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

                if(resp != null){
                    
                    $.each(resp,function(i,item){
                        let rotacion = (item.rotacion != null) ? item.rotacion.split(",") : "";
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.fieldman)+"</td>";
                            Contenido += "<td "+minText(item.temporada)+"</td>";
                            Contenido += "<td "+minText(item.especie)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.telefono)+"</td>";
                            Contenido += "<td "+minText(item.nombre_ac)+"</td>";
                            Contenido += "<td "+minText(item.telefono_ac)+"</td>";
                            Contenido += "<td "+minText(item.oferta_de_negocio)+"</td>";
                            Contenido += "<td "+minText(item.region)+"</td>";
                            Contenido += "<td "+minText(item.provincia)+"</td>";
                            Contenido += "<td "+minText(item.comuna)+"</td>";
                            Contenido += "<td "+minText(item.localidad)+"</td>";
                            Contenido += "<td "+minText(item.ha_disponibles)+"</td>";
                            Contenido += "<td "+minText(item.direccion)+"</td>";
                            Contenido += "<td "+minText(item.rep_legal)+"</td>";
                            Contenido += "<td "+minText(item.rut_rl)+"</td>";
                            Contenido += "<td "+minText(item.telefono_rl)+"</td>";
                            Contenido += "<td "+minText(item.email_rl)+"</td>";
                            Contenido += "<td "+minText(item.banco)+"</td>";
                            Contenido += "<td "+minText(item.cuenta_corriente)+"</td>";
                            Contenido += "<td "+minText(item.predio)+"</td>";
                            Contenido += "<td "+minText(item.lote)+"</td>";
                            Contenido += "<td style='min-width:200px'>";
                            if(rotacion[0] && rotacion[0].length > 8) Contenido += "<div>"+rotacion[0]+"</div>";
                            if(rotacion[1] && rotacion[1].length > 8) Contenido += "<div>"+rotacion[1]+"</div>";
                            if(rotacion[2] && rotacion[2].length > 8) Contenido += "<div>"+rotacion[2]+"</div>";
                            if(rotacion[3] && rotacion[3].length > 8) Contenido += "<div>"+rotacion[3]+"</div>";
                            Contenido += "</td>";
                            Contenido += "<td "+minText(item.norting)+"</td>";
                            Contenido += "<td "+minText(item.easting)+"</td>";
                            Contenido += "<td "+minText(item.radio)+"</td>";
                            Contenido += "<td "+minText(item.suelo)+"</td>";
                            Contenido += "<td "+minText(item.riego)+"</td>";
                            Contenido += "<td "+minText(item.experiencia)+"</td>";
                            Contenido += "<td "+minText(item.tenencia)+"</td>";
                            Contenido += "<td "+minText(item.maquinaria)+"</td>";
                            Contenido += "<td "+minText(item.maleza)+"</td>";
                            Contenido += "<td "+minText(item.estado_general)+"</td>";
                            Contenido += "<td "+minText(item.obs)+"</td>";
                            Contenido += "<td "+minText(item.id_ficha)+"</td>";

                            let carga = (item.id_cab_subida != 0)?item.id_cab_subida:"Web";
                            let dispo = (item.id_cab_subida != 0)?item.id_dispo_subida:"Web";
                            let fechaI = (item.id_cab_subida != 0)?item.fecha_hora_inicio:"Web";
                            let fechaF = (item.id_cab_subida != 0)?item.fecha_hora_fin:"Web";

                            Contenido += "<td "+minText(carga)+"</td>";
                            Contenido += "<td "+minText(dispo)+"</td>";
                            Contenido += "<td "+minText(fechaI)+"</td>";
                            Contenido += "<td "+minText(fechaF)+"</td>";
                            
                            let width = (puas == 5)?130:110;

                            Contenido += "<td class='fix-edi' align='center' style='min-width:"+width+"px !important'>";
                            // Contenido += "<div style='display:flex; flex-direction:column; align-items:center;justify-content:space-between;'>";
                            Contenido += "<button type='button' class='btn btn-danger' data-pdf='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-file-pdf' data-pdf='"+item.id_ficha+"'></i> </button>";
                            Contenido += "<button type='button' class='btn btn-info' data-images='"+item.id_ficha+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-images' data-images='"+item.id_ficha+"'></i> </button>";
                            Contenido += "<button type='button' class='btn btn-success' data-info='"+item.id_ficha+"' style='margin: 0 5px 0 0; padding:.1rem .3rem'> <i class='fas fa-search' data-info='"+item.id_ficha+"'></i> </button>";
                        
                            if(puas == 5){
                                Contenido += "<button type='button' class='btn btn-warning' data-cmb='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem' title='Pasar a provisorio'> <i class='fas fa-exchange-alt' data-cmb='"+item.id_ficha+"'></i> </button>";
                            
                            }

                            // Contenido += "</div>";
                            Contenido += "</td>";
                        Contenido += "</tr>";

                    });

                }else{
                    Contenido = "<tr> <td colspan='42' style='text-align:center'> No existen registros </td> </tr>";

                }

                document.getElementById("datosActivas").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='42' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datosActivas").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatosActivas(){
        // Data del ajax
        let data = "";
        data = "action=totalDatosActivas";

        // Temporada de operacion
        let Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FProsA");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
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
                if(resp != null){
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

    function traerDatosProvisorias(Page){
        // Data del ajax
        let data = "";
        data = "action=traerDatosProvisorias";

        // Orden de datos
        let Orden = obtenerOrden();
        data += "&Orden="+Orden;

        // Ve que pagina es y trae los datos correspondientes a tal
        let Des = obtenerPagina(Page);
        data += "&D="+Des;

        // Temporada de operacion
        let Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FProsP");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;

        }

        // colspan dinamico
        var colspan = (puas == 5) ? 21 : 20;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:data,
                url:urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null){
                    $.each(resp,function(i,item){   
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td" +minText(item.obs)+"</td>";
                            Contenido += "<td "+minText(item.fieldman)+"</td>";
                            Contenido += "<td "+minText(item.temporada)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.telefono)+"</td>";
                            Contenido += "<td "+minText(item.oferta_de_negocio)+"</td>";
                            Contenido += "<td "+minText(item.region)+"</td>";
                            Contenido += "<td "+minText(item.provincia)+"</td>";
                            Contenido += "<td "+minText(item.comuna)+"</td>";
                            Contenido += "<td "+minText(item.localidad)+"</td>";
                            Contenido += "<td "+minText(item.ha_disponibles)+"</td>";
                            Contenido += "<td "+minText(item.id_ficha)+"</td>";

                            let carga = (item.id_cab_subida != 0)?item.id_cab_subida:"Web";
                            let dispo = (item.id_cab_subida != 0)?item.id_dispo_subida:"Web";
                            let fechaI = (item.id_cab_subida != 0)?item.fecha_hora_inicio:"Web";
                            let fechaF = (item.id_cab_subida != 0)?item.fecha_hora_fin:"Web";

                            Contenido += "<td "+minText(carga)+"</td>";
                            Contenido += "<td "+minText(dispo)+"</td>";
                            Contenido += "<td "+minText(fechaI)+"</td>";
                            Contenido += "<td "+minText(fechaF)+"</td>";
                            if(puas == 5) {
                                Contenido += "<td class='fix-edi' style='min-width:140px !important'>";
                                Contenido += "<button type='button' class='btn btn-success' data-acti='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem' title='Activar prospecto'> <i class='fas fa-check' data-acti='"+item.id_ficha+"' title='Activar prospecto'></i> </button>";
                                Contenido += "<button type='button' class='btn btn-info' data-edi='"+item.id_ficha+"' style='margin: 0 5px; padding:.1rem .3rem' title='Editar prospecto'> <i class='fas fa-pencil-alt' data-edi='"+item.id_ficha+"' title='Editar prospecto'></i> </button>";
                                Contenido += "<button type='button' class='btn btn-danger' data-eli='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem' title='Rechazar prospecto'> <i class='fas fa-times' data-eli='"+item.id_ficha+"' title='Rechazar prospecto'></i> </button>";
                                Contenido += "<button type='button' class='btn btn-info' data-images='"+item.id_ficha+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-images' data-images='"+item.id_ficha+"'></i> </button>";
                                Contenido += "</td>";
                            }
                            if(puas == 3) {
                                Contenido += "<td class='fix-edi' style='min-width:100px !important'>";
                                Contenido += "<button type='button' class='btn btn-success' data-acti='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem' title='Activar prospecto'> <i class='fas fa-check' data-acti='"+item.id_ficha+"' title='Activar prospecto'></i> </button>";
                                Contenido += "<button type='button' class='btn btn-info' data-edi='"+item.id_ficha+"' style='margin: 0 5px; padding:.1rem .3rem' title='Editar prospecto'> <i class='fas fa-pencil-alt' data-edi='"+item.id_ficha+"' title='Editar prospecto'></i> </button>";
                                Contenido += "</td>";
                            }
                        Contenido += "</tr>";

                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen registros </td> </tr>";

                }

                document.getElementById("datosProvisorias").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datosProvisorias").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatosProvisorias(){
        // Data del ajax
        let data = "";
        data = "action=totalDatosProvisorias";

        // Temporada de operacion
        let Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FProsP");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
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
                if(resp != null){
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

    /* Edit */
    
    function traerInfoActiva(info){
        $.ajax({
            data:'action=traerInfoActiva&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){

            if(resp[0] != null){

                document.getElementById("ProsI1").innerText = "Activa";
                document.getElementById("ProsI2").innerText = sinInformacion(resp[0].supervisor);
                document.getElementById("ProsI3").innerText = sinInformacion(resp[0].temporada);
                document.getElementById("ProsI4").innerText = sinInformacion(resp[0].agricultor);
                document.getElementById("ProsI5").innerText = sinInformacion(resp[0].localidad);
                document.getElementById("ProsI6").innerText = sinInformacion(resp[0].predio);
                document.getElementById("ProsI7").innerText = sinInformacion(resp[0].lote);
                document.getElementById("ProsI8").innerText = sinInformacion(resp[0].ha_disponibles);
                document.getElementById("ProsI9").innerText = sinInformacion(resp[0].especie);
                document.getElementById("ProsI10").innerText = sinInformacion(resp[0].tenencia);
                document.getElementById("ProsI11").innerText = sinInformacion(resp[0].maquinaria);
                document.getElementById("ProsI12").innerText = sinInformacion(resp[0].experiencia);
                document.getElementById("ProsI13").innerText = sinInformacion(resp[0].oferta_de_negocio);
                document.getElementById("ProsI14").innerText = sinInformacion(resp[0].suelo);
                document.getElementById("ProsI15").innerText = sinInformacion(resp[0].riego);
                document.getElementById("ProsI16").innerText = sinInformacion(resp[0].maleza);
                document.getElementById("ProsI17").innerText = sinInformacion(resp[0].estado_general);
                document.getElementById("ProsI18").innerText = sinInformacion(resp[0].obs);

                let cont = 22;
                let fecha = new Date();
                for(let e = 1; e < 5; e++){
                    let anno = fecha.getFullYear()-e;
    
                    $.each(resp[1],function(i,item){
            
                        if(item.anno == anno){
                            document.getElementById("ProsI"+cont--).innerText = sinInformacion(item.descripcion);
    
                        }
        
                    });
                    
                }

                $("#modalInfo").modal('show');

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }
    
    function traerInfoProvisoria(info){
        arrayImagenes = new Array();
        limpiarImagenes();
        $.ajax({
            data:'action=traerInfoProvisoria&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false,
            beforeSend: function() {
                $("#modalCarga").modal('show');
            },
            complete: function() {
                $("#modalCarga").modal('hide');
            },
        }).done(function(osd){
            
            if(osd[0] != null){
                var resp = osd[0];
                var fotos = (osd.length > 1) ? osd[1] : null;

                traerProvincias(resp.id_region, 1);
                traerComunas(resp.id_provincia, 1);

                formPros.elements[1].value = resp.id_usuario;
                $('#'+formPros.elements[1].id).select2().trigger('change');
                formPros.elements[2].value = resp.id_tempo;
                $('#'+formPros.elements[2].id).select2().trigger('change');
                formPros.elements[3].value = resp.id_agric;
                $('#'+formPros.elements[3].id).select2().trigger('change');
                formPros.elements[4].value = resp.id_region;
                $('#'+formPros.elements[4].id).select2().trigger('change');
                formPros.elements[5].value = resp.id_provincia;
                $('#'+formPros.elements[5].id).select2().trigger('change');
                formPros.elements[6].value = resp.id_comuna;
                $('#'+formPros.elements[6].id).select2().trigger('change');
                formPros.elements[7].value = resp.localidad;
                formPros.elements[8].value = resp.ha_disponibles;
                formPros.elements[9].value = resp.oferta_de_negocio;
                formPros.elements[10].value = resp.obs;
                formPros.elements[11].value = resp.norting;
                formPros.elements[12].value = resp.easting;

                /* Datos extras */
                formPros.elements[13].value = resp.id_esp;
                $('#'+formPros.elements[13].id).select2().trigger('change');
                formPros.elements[14].value = resp.predio;
                formPros.elements[15].value = resp.lote;

                let datos = resp.historial;
                let c1 = "";
                let c2 = "";
                let c3 = "";
                let c4 = "";
                if(datos != "" && datos != null){
                    let seccion = datos.split(" && ");
                    c1 = (seccion[0].indexOf("=>") > -1)?seccion[0].split("=>"):"";
                    c2 = (seccion[1].indexOf("=>") > -1)?seccion[1].split("=>"):"";
                    c3 = (seccion[2].indexOf("=>") > -1)?seccion[2].split("=>"):"";
                    c4 = (seccion[3].indexOf("=>") > -1)?seccion[3].split("=>"):"";

                }

                formPros.elements[16].value = (c1[1] != undefined)?c1[1]:"";
                formPros.elements[17].value = (c2[1] != undefined)?c2[1]:"";
                formPros.elements[18].value = (c3[1] != undefined)?c3[1]:"";
                formPros.elements[19].value = (c4[1] != undefined)?c4[1]:"";

                formPros.elements[20].value = resp.id_tipo_suelo;
                $('#'+formPros.elements[20].id).select2().trigger('change');
                formPros.elements[21].value = resp.id_tipo_riego;
                $('#'+formPros.elements[21].id).select2().trigger('change');
                formPros.elements[22].value = resp.experiencia.toUpperCase();
                $('#'+formPros.elements[22].id).select2().trigger('change');
                formPros.elements[23].value = resp.id_tipo_tenencia_terreno;
                $('#'+formPros.elements[23].id).select2().trigger('change');
                formPros.elements[24].value = resp.id_tipo_tenencia_maquinaria;
                $('#'+formPros.elements[24].id).select2().trigger('change');
                formPros.elements[25].value = resp.maleza;
                formPros.elements[26].value = resp.estado_general;
                formPros.elements[27].value = resp.fecha_limite_s;
                formPros.elements[28].value = resp.obs_prop;

                var previewZone = document.getElementById('contenedorImagenesProvisoriasAntiguas');
                // var divTitle = document.getElementById('img_agregadas_provisorias');
                // divTitle.innerText =  "Imagenes ya agregadas";
                previewZone.innerHTML = "";

                contenido = "";
                if(fotos != null && fotos.length > 0){
                    contenido+= "<h3>Imagenes ya agregadas</h3>";
                    contenido+= "<div style='display:flex;flex-direction:row;'>";
                    $.each(fotos,function(i,item){
                        contenido+= "<div style='display:flex;flex-direction:column;' id='container_"+item.id_foto+"'>";
                            contenido += "<i style='cursor:pointer;' class='fas fa-window-close text-danger fa-2x' onclick='eliminarimagen("+item.id_foto+");'></i>";
                            contenido += "<img src='data:image/jpeg;base64,"+item.ruta_foto+"' style='height:120px;width:120px;'>";
                        contenido+= "</div>";
                    });
                    contenido+= "</div>";
                }
                previewZone.innerHTML = contenido;
                

                btnAgregar.dataset.act = info;
                btnAgregar.innerText  = "Editar prospecto";
                document.getElementById("tituloModalP").innerHTML = "Editar prospecto <button onclick=\"descargaPdf(this.target, '"+resp.id_ficha+"');\" type='button' class='btn btn-danger' data-pdf='"+resp.id_ficha+"' style='margin: 0; padding:.1rem .3rem'> <i onclick=\"descargaPdf(this.target, '"+resp.id_ficha+"');\" data-pdf='"+resp.id_ficha+"' class='fas fa-file-pdf'></i>";
                $("#modalPros").modal('show');




            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    $("#modalPros").on('shown.bs.modal', function () {
        $("#modalCarga").modal('hide');

    });

    function eliminarimagen(info){
        // console.log("click en delete");

        $.ajax({
            data:'action=eliminarImagen&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            // console.log(resp);
            switch(resp){
                case 1:
                    // console.log("entro aca");
                    var dd = document.getElementById("container_"+info);
                    dd.remove();
                    break;
            }

        });

    }
    
    /* Activar */

    function traerInfoActivar(info){
        $.ajax({
            data:'action=traerInfoActivar&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false,
            beforeSend: function() {
                $("#modalCarga").modal('show');
            },
            complete: function() {
                $("#modalCarga").modal('hide');
            },
        }).done(function(osd){
            
            
            if(osd[0] != null){
                var resp = osd[0];
                var fotos = (osd.length > 1) ? osd[1] : null;
                traerInfoAgri(resp.id_agric);
                traerProvincias(resp.id_region, 2);
                traerComunas(resp.id_provincia, 2);

                formUpd.elements[0].value = "Provisoria";
                formUpd.elements[1].value = resp.id_usuario;
                $('#'+formUpd.elements[1].id).select2().trigger('change'); // Visual Fieldman
                formUpd.elements[2].value = resp.id_tempo;
                $('#'+formUpd.elements[2].id).select2().trigger('change'); // Visual Temporada
                formUpd.elements[3].value = resp.id_agric;
                $('#'+formUpd.elements[3].id).select2().trigger('change'); // Visual Agricultor
                formUpd.elements[17].value = resp.oferta_de_negocio;
                formUpd.elements[19].value = resp.ha_disponibles;
                formUpd.elements[20].value = resp.id_region;
                $('#'+formUpd.elements[20].id).select2().trigger('change'); // Visual Region
                formUpd.elements[21].value = resp.id_provincia;
                $('#'+formUpd.elements[21].id).select2().trigger('change'); // Visual Provincia
                formUpd.elements[22].value = resp.id_comuna;
                $('#'+formUpd.elements[22].id).select2().trigger('change'); // Visual Comuna
                formUpd.elements[25].value = resp.localidad;
                formUpd.elements[38].value = resp.obs;
                formUpd.elements[40].value = resp.norting;
                formUpd.elements[41].value = resp.easting;

                /* Datos extras */
                formUpd.elements[18].value = resp.id_esp;
                $('#'+formUpd.elements[18].id).select2().trigger('change');
                formUpd.elements[23].value = resp.predio;
                formUpd.elements[24].value = resp.lote;

                let datos = resp.historial;
                let c1 = "";
                let c2 = "";
                let c3 = "";
                let c4 = "";
                if(datos != "" && datos != null){
                    let seccion = datos.split(" && ");
                    c1 = (seccion[0].indexOf("=>") > -1)?seccion[0].split("=>"):"";
                    c2 = (seccion[1].indexOf("=>") > -1)?seccion[1].split("=>"):"";
                    c3 = (seccion[2].indexOf("=>") > -1)?seccion[2].split("=>"):"";
                    c4 = (seccion[3].indexOf("=>") > -1)?seccion[3].split("=>"):"";

                }

                formUpd.elements[26].value = (c1[1] != undefined)?c1[1]:"";
                formUpd.elements[27].value = (c2[1] != undefined)?c2[1]:"";
                formUpd.elements[28].value = (c3[1] != undefined)?c3[1]:"";
                formUpd.elements[29].value = (c4[1] != undefined)?c4[1]:"";

                formUpd.elements[30].value = resp.id_tipo_suelo;
                $('#'+formUpd.elements[30].id).select2().trigger('change');
                formUpd.elements[31].value = resp.id_tipo_riego;
                $('#'+formUpd.elements[31].id).select2().trigger('change');
                formUpd.elements[32].value = resp.experiencia.toUpperCase();
                $('#'+formUpd.elements[32].id).select2().trigger('change');
                formUpd.elements[33].value = resp.id_tipo_tenencia_terreno;
                $('#'+formUpd.elements[33].id).select2().trigger('change');
                formUpd.elements[34].value = resp.id_tipo_tenencia_maquinaria;
                $('#'+formUpd.elements[34].id).select2().trigger('change');
                formUpd.elements[35].value = resp.maleza;
                formUpd.elements[36].value = resp.estado_general;
                formUpd.elements[37].value = resp.fecha_limite_s;
                formUpd.elements[39].value = resp.obs_prop;


                var previewZone = document.getElementById('contenedorImagenesActivarAntiguas');
                // var divTitle = document.getElementById('img_agregadas_provisorias');
                // divTitle.innerText =  "Imagenes ya agregadas";
                previewZone.innerHTML = "";

                contenido = "";
                if(fotos != null && fotos.length > 0){
                    contenido+= "<h3>Imagenes ya agregadas</h3>";
                    contenido+= "<div style='display:flex;flex-direction:row;'>";
                    $.each(fotos,function(i,item){
                        contenido+= "<div style='display:flex;flex-direction:column;' id='container_"+item.id_foto+"'>";
                            contenido += "<i style='cursor:pointer;' class='fas fa-window-close text-danger fa-2x' onclick='eliminarimagen("+item.id_foto+");'></i>";
                            contenido += "<img src='data:image/jpeg;base64,"+item.ruta_foto+"' style='height:120px;width:120px;'>";
                        contenido+= "</div>";
                    });
                    contenido+= "</div>";
                }
                previewZone.innerHTML = contenido;



                btnActivar.dataset.act = info;
                btnActivar.innerText  = "Activar prospecto";
                document.getElementById("tituloModalU").innerText = "Activar prospecto";
                $("#modalUpd").modal('show');

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    $("#modalUpd").on('shown.bs.modal', function () {
        $("#modalCarga").modal('hide');
        
    });

    /* Rechazar */

    function rechazarProspecto(rechazar){

        swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de rechazar un prospecto.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    data:'action=rechazarProspecto&rechazar='+rechazar,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha rechazado correctamente el prospecto.", "success");
        
                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
        
                    }
        
                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);
        
                }).always(function(){
                    informacionProvisorias();
        
                });
            }

        });

    }

    /* Pasar a provisorio */

    function cambiarEstado(cambiar){

        swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de pasar un prospecto de activo a provisorio.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    data:'action=cambiarEstado&cambiar='+cambiar,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha cambiado correctamente el estado del prospecto.", "success");
        
                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
        
                    }
        
                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);
        
                }).always(function(){
                    informacionActivas();
        
                });
            }

        });

    }

/*              Fin traer datos              */
/*==================================================================================================================================*/
/*              Traer informacion              */

    function informacionActivas() { 
        const promiseDatos = traerDatosActivas(1);

        promiseDatos.then(
            result => totalDatosActivas().then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            /* finaly => console.log() */
            
        );

    }

    function informacionProvisorias() { 
        const promiseDatos = traerDatosProvisorias(1);

        promiseDatos.then(
            result => totalDatosProvisorias().then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            /* finaly => console.log() */
            
        );

    }

    informacionActivas();

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Ejecutar paginacion              */

    var paginacion = document.getElementById("paginacion");
        
    paginacion.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "BUTTON" ) {
            var pagina = e.target.dataset.page;
            var tab = document.getElementById("myTab").children;

            for(var i = 0; i < tab.length; i++){
                if(i == 0 && tab[i].children[0].classList.contains("active")){
                    traerDatosActivas(pagina);
                    paginador();

                }else{
                    traerDatosProvisorias(pagina);
                    paginador();
                }
            }
        }
    });

/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Cambio de pestañas              */

    var tab = document.getElementById("myTab");

    tab.addEventListener("click", function(e){
        if(e.target.nodeName == "A"){

            limpiarFiltros();

            var seleccion = e.target.id;

            switch(seleccion){
                case "activas-tab":
                    informacionActivas();

                break;

                case "provisorias-tab":
                    informacionProvisorias();

                break;

            }

        }
        
    });

/*              Fin de cambio de pestañas              */
/*==================================================================================================================================*/
/*              Ejecutar eventos de la tabla               */

    function ejecutarOrden(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.acti != undefined) {
            var acti = e.target.dataset.acti;
            arrayImagenes = new Array();
            limpiarImagenesActivar();
            traerInfoActivar(acti);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.info != undefined) {
            var info = e.target.dataset.info;
            traerInfoActiva(info);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.images != undefined) {
            var info = e.target.dataset.images;
            arrayImagenes = new Array();
            
            var etapa = 0;
            var active = document.getElementsByClassName("nav-link active")[0].id;
            switch(active){
                case "activas-tab":
                    etapa = 1;
                    limpiarImagenesNew();
                break;

                case "provisorias-tab":
                    etapa = 2;
                    limpiarImagenes();
                break;

            }

            traerImagenes(info,etapa);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.edi != undefined) {
            var edi = e.target.dataset.edi;
            arrayImagenes = new Array();
            limpiarImagenes();
            traerInfoProvisoria(edi);


        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.pdf != undefined) {
            var pdf = e.target.dataset.pdf;
            descargaPdf(e,pdf);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.eli != undefined) {
            var eli = e.target.dataset.eli;
            rechazarProspecto(eli);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.cmb != undefined) {
            var cmb = e.target.dataset.cmb;
            cambiarEstado(cmb);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target,2);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            var active = document.getElementsByClassName("nav-link active")[0].id;

            switch(active){
                case "activas-tab":
                    informacionActivas();
                break;

                case "provisorias-tab":
                    informacionProvisorias();
                break;

            }

        }

    }
    
    tablaActivas.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });

    var tablaProvisorias = document.getElementById("tablaProvisorias");
    
    tablaProvisorias.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });
    
/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tablaActivas.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FProsA"){
            informacionActivas();

        }
        
    });

    tablaProvisorias.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FProsP"){
            informacionProvisorias();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tablaActivas.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FProsA1":
            case "FProsA3":
            case "FProsA4":
            case "FProsA7":
            case "FProsA9":
            case "FProsA10":
            case "FProsA11":
            case "FProsA12":
            case "FProsA13":
            case "FProsA15":
            case "FProsA16":
            case "FProsA20":
            case "FProsA21":
            case "FProsA22":
            case "FProsA23":
            case "FProsA24":
            case "FProsA28":
            case "FProsA29":
            case "FProsA30":
            case "FProsA31":
            case "FProsA32":
            case "FProsA33":
            case "FProsA34":
            case "FProsA35":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;
            case "FProsA2":
            case "FProsA6":
            case "FProsA8":
            case "FProsA18":
                e.returnValue = keyValida(e,"F",e.target);
            break;
            case "FProsA5":
            case "FProsA17":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FProsA14":
            case "FProsA25":
            case "FProsA26":
            case "FProsA27":
                e.returnValue = keyValida(e,"ND",e.target);
            break;
            case "FProsA19":
                e.returnValue = keyValida(e,"C",e.target);
            break;
            case "FProsA36":
            case "FProsA37":
            case "FProsA38":
                e.returnValue = keyValida(e,"N",e.target);
            break;

        }
        
    });

    tablaProvisorias.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FProsP1":
            case "FProsP2":
            case "FProsP5":
            case "FProsP7":
            case "FProsP8":
            case "FProsP9":
            case "FProsP10":
            case "FProsP11":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;
            case "FProsP3":
            case "FProsP6":
                e.returnValue = keyValida(e,"F",e.target);
            break;
            case "FProsP4":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FProsP12":
                e.returnValue = keyValida(e,"ND",e.target);
            break;
            case "FProsP13":
            case "FProsP14":
            case "FProsP15":
                e.returnValue = keyValida(e,"N",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas == 5 || puas == 3){

/*==================================================================================================================================*/
/*              Agregar imagen              */
        /* ACTIVAS  */

        var agregarImagenActivar = document.getElementById("imagenActivar");
        
        agregarImagenActivar.addEventListener("change", function(ex){
            // console.log(ex.target.files[0]);
            // var act = 0
            // if(ex.target.dataset.act != undefined) act = ex.target.dataset.act;
            if(ex.target && ex.target.nodeName == 'INPUT'){

                // switch
                // console.log(ex.target.files[0].type);
                switch(ex.target.files[0].type){
                    case 'image/png':
                    case 'image/jpeg':
                    case 'image/jpg':
                        if(!arrayImagenes.includes(ex.target.files[0])){
                            arrayImagenes.push(ex.target.files[0]);
                        }
                        break;
                    default:
                        swal("Ops!", "Solo puede subir imagenes a el prospecto", "error");
                        break;
                
                }

                

            mostrarImagenesActivar(arrayImagenes);
            }

        });

        function limpiarImagenesActivar(){
            var div  = document.getElementById("contenedorImagenesActivar");
            div.innerHTML = '';
            var div  = document.getElementById("contenedorImagenesActivarAntiguas");
            div.innerHTML = '';
        }

        function mostrarImagenesActivar(arrayDeImagenes){

            var div  = document.getElementById("contenedorImagenesActivar");

            div.innerHTML = '';

            var divContPlus = document.createElement('div');
            divContPlus.setAttribute('style', 'display:flex;flex-direction:row;');

            divContPlus.innerHTML = '';
            if(arrayDeImagenes != null && arrayDeImagenes.length > 0){
                for(let i = 0; i < arrayDeImagenes.length; i++){
                
                    var reader = new FileReader();
                    reader.onload = function(e){
        
        
                        var divcon = document.createElement('div');
                        divcon.setAttribute('style', 'display:flex;flex-direction:column;');
        
        
                        var filePreview = document.createElement('img');
                        filePreview.id = 'file-preview';
                        filePreview.setAttribute('style', 'height:120px;width:120px;')
                        //e.target.result contents the base64 data from the image uploaded
                        filePreview.src = e.target.result;
                        var previewZone = document.getElementById('contenedorImagenesActivar');
        
                        var imgClose = document.createElement('i');
                        imgClose.setAttribute('class', 'fas fa-window-close text-danger fa-2x');
                        imgClose.setAttribute('style', 'cursor:pointer;');
        
                        imgClose.addEventListener('click', function(){
        
                                var e = arrayDeImagenes.indexOf( arrayDeImagenes[i] );
                                arrayDeImagenes.splice( e, 1);
        
                                mostrarImagenesActivar(arrayDeImagenes);
                        })
        
        
                        divcon.appendChild(imgClose);
                        divcon.appendChild(filePreview);
        
                        divContPlus.appendChild(divcon);
        
                        previewZone.appendChild(divContPlus);
                    }
        
                    reader.readAsDataURL(arrayDeImagenes[i]);
                }
            }
        }

        /* FIN ACTIVAS  */
        /*=======================================*/
        /* ACTIVADA  */

        var agregarimagenNew = document.getElementById("imagenNew");
        
        agregarimagenNew.addEventListener("change", function(ex){
            // console.log(ex.target.files[0]);
            // var act = 0
            // if(ex.target.dataset.act != undefined) act = ex.target.dataset.act;
            if(ex.target && ex.target.nodeName == 'INPUT'){

                // switch
                // console.log(ex.target.files[0].type);
                switch(ex.target.files[0].type){
                    case 'image/png':
                    case 'image/jpeg':
                    case 'image/jpg':
                        if(!arrayImagenes.includes(ex.target.files[0])){
                            arrayImagenes.push(ex.target.files[0]);
                            
                        }
                        break;
                    default:
                        swal("Ops!", "Solo puede subir imagenes a el prospecto", "error");
                        ex.target.value = "";
                        break;
                
                }

                

                mostrarImagenesNew(arrayImagenes);
            }

        });

        function limpiarImagenesNew(){
            var div  = document.getElementById("contenedorImagenesNew");
            div.innerHTML = '';
            var div  = document.getElementById("galeria");
            div.innerHTML = '';
        }

        function mostrarImagenesNew(arrayDeImagenes){

            var div  = document.getElementById("contenedorImagenesNew");

            div.innerHTML = '';

            var divContPlus = document.createElement('div');
            divContPlus.setAttribute('style', 'display:flex;flex-direction:row;');

            divContPlus.innerHTML = '';
            if(arrayDeImagenes != null && arrayDeImagenes.length > 0){
                for(let i = 0; i < arrayDeImagenes.length; i++){
                
                    var reader = new FileReader();
                    reader.onload = function(e){
        
        
                        var divcon = document.createElement('div');
                        divcon.setAttribute('style', 'display:flex;flex-direction:column;');
        
        
                        var filePreview = document.createElement('img');
                        filePreview.id = 'file-preview';
                        filePreview.setAttribute('style', 'height:120px;width:120px;')
                        //e.target.result contents the base64 data from the image uploaded
                        filePreview.src = e.target.result;
                        var previewZone = document.getElementById('contenedorImagenesNew');
        
                        var imgClose = document.createElement('i');
                        imgClose.setAttribute('class', 'fas fa-window-close text-danger fa-2x');
                        imgClose.setAttribute('style', 'cursor:pointer;');
        
                        imgClose.addEventListener('click', function(){
        
                                var e = arrayDeImagenes.indexOf( arrayDeImagenes[i] );
                                arrayDeImagenes.splice( e, 1);
        
                                mostrarImagenesNew(arrayDeImagenes);
                        })
        
        
                        divcon.appendChild(imgClose);
                        divcon.appendChild(filePreview);
        
                        divContPlus.appendChild(divcon);
        
                        previewZone.appendChild(divContPlus);
                    }
        
                    reader.readAsDataURL(arrayDeImagenes[i]);
                }
            }
            
            document.getElementById("errorModI").hidden = true;
        }

        /* FIN ACTIVADA  */

/*              Fin de agregar imagen              */
/*==================================================================================================================================*/
/*              Evento key inputs formulario              */
        
        var formUpd = document.getElementById("formUpd");

        formUpd.addEventListener('keypress', function(e) {
            document.getElementById("errorModA").hidden = true;
            var id = e.target.id;
            switch(id){
                case "ProsA4":
                case "ProsA10":
                case "ProsA11":
                case "ProsA12":
                case "ProsA13":
                case "ProsA14":
                case "ProsA15":
                case "ProsA16":
                case "ProsA22":
                case "ProsA23":
                case "ProsA25":
                case "ProsA26":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
                break;
                case "ProsA6":
                case "ProsA27":
                case "ProsA28":
                    e.returnValue = keyValida(e,"ND",e.target);
                break;

            }
            
        });

/*              Fin de evento key inputs formulario              */
/*==================================================================================================================================*/
/*              Function crear/editar prospecto              */

        function optionUpd(act){
            var llenado = true;
            var valido = true;
            var action = "activarProspecto";
            var mnj = "activado"

            var frmData = new FormData;

            frmData.append("action", action);
            frmData.append("act", act);

            for (var i = 0; i < formUpd.elements.length; i++){
                var value = formUpd.elements[i].value.trim();
                var id = formUpd.elements[i].id;
                if(value.length == "" || value.length == 0){
                    if(id != "infoA1" && id != "infoA2" && id != "infoA3" && id != "infoA4" && id != "infoA5" && id != "infoA6" && id != "infoA7" && id != "infoA8" && id != "infoA9" && id != "infoA10" && id != "infoA11" && id != "infoA12" && id != "infoA13" && id != "ProsA13" && id != "ProsA14" && id != "ProsA15" && id != "ProsA16" && id != "ProsA25" && id != "ProsA26" && id != "imagenActivar"){
                        llenado = false;
                        break;

                    }
                
                }else{
                    if((id == "ProsA4" || id == "ProsA10" || id == "ProsA11" || id == "ProsA12" || id == "ProsA13" || id == "ProsA14" || id == "ProsA15" || id == "ProsA16" || id == "ProsA22" || id == "ProsA23" || id == "ProsA25" || id == "ProsA26") && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }

                    if(id == "ProsA6" && id == "ProsA27" && id == "ProsA28" && !textValido("ND",value)){
                        valido = false;
                        break;

                    }

                }

                frmData.append("campo"+[i], value);

            }

            if(arrayImagenes.length > 0){
                for(let v = 0; v < arrayImagenes.length; v++){
                    frmData.append('imagen['+v+']', arrayImagenes[v]);
                }
                frmData.append('cantidad_imagenes', arrayImagenes.length);
            }

            if(llenado && valido){
                

                $.ajax({
                    data: frmData,
                    url: urlDes,
                    type:'POST',
                    processData: false,
                    contentType: false,
                    // dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el prospecto.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ingresado el prospecto, pero ocurrio un error con el historial del predio, notifique a un supervisor.", "info");

                    }else if(resp == 3){
                        swal("Atencion!", "Intento actualizar los datos, con los mismos datos que ya poseia.", "info");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalUpd").modal("hide");
                    informacionProvisorias();

                });

            }else if(!llenado){
                document.getElementById("errorModA").hidden = false;
                document.getElementById("errorMenjA").innerText = "Debe completar todos los campos requeridos.";

            }else{
                document.getElementById("errorModA").hidden = false;
                document.getElementById("errorMenjA").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

            }

        }

/*              Fin de function crear/editar prospecto              */
/*==================================================================================================================================*/
/*              Crear/Editar prospecto              */

        var btnActivar = document.getElementById("optionUpd");

        btnActivar.addEventListener("click", function(e){
            var act = e.target.dataset.act;
            if(act != undefined) optionUpd(act);

        });

/*              Fin de crear/editar prospecto              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalUpd').on('hidden.bs.modal', function (e) {
            formUpd.reset();
            btnActivar.dataset.act = 0;
            btnActivar.dataset.opc = 0;
            document.getElementById("tituloModalU").innerText = "Activar prospecto";
            
            $("#ProsA1").select2().trigger('change');
            $("#ProsA2").select2().trigger('change');
            selAgri.select2().trigger('change');
            $("#ProsA5").select2().trigger('change');
            $("#ProsA7").select2().trigger('change');
            $("#ProsA8").select2().trigger('change');
            $("#ProsA9").select2().trigger('change');
            $("#ProsA17").select2().trigger('change');
            $("#ProsA18").select2().trigger('change');
            $("#ProsA19").select2().trigger('change');
            $("#ProsA20").select2().trigger('change');
            $("#ProsA21").select2().trigger('change');

        });

        $('#modalImages').on('hidden.bs.modal', function (e) {
            agregarimagenNew.value = "";
            document.getElementById("errorModI").hidden = true;

            arrayImagenes = new Array();
            limpiarImagenesNew();

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Subir img en prospecto activada              */

        function subirImagen(act){
            var datos = false;
            var action = "subirImagen";

            var frmData = new FormData;

            frmData.append("action", action);
            frmData.append("act", act);

            if(arrayImagenes.length > 0){
                for(let v = 0; v < arrayImagenes.length; v++){
                    frmData.append('imagen['+v+']', arrayImagenes[v]);

                }

                frmData.append('cantidad_imagenes', arrayImagenes.length);

                datos = true;
            }

            if(datos){

                $.ajax({
                    data: frmData,
                    url: urlDes,
                    type:'POST',
                    processData: false,
                    contentType: false,
                    // dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se han subido correctamente las imagenes.", "success");

                    }else if(resp == 4){
                        swal("Atencion!", "No se han podido subir las imagenes", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalImages").modal("hide");
                    informacionActivas();

                });

            }else{
                document.getElementById("errorModI").hidden = false;
                document.getElementById("errorMenjI").innerText = "No estas subiendo ninguna imagen.";

            }

        }

        var btnSubirImg = document.getElementById("subirIMG");

        btnSubirImg.addEventListener("click", function(e){
            var act = e.target.dataset.act;
            if(act != undefined) subirImagen(act);

        });

/*              Fin subir img en prospecto activada              */
/*==================================================================================================================================*/
        
    }

    
    if(puas == 5 || puas == 3){

/*==================================================================================================================================*/
/*              Agregar imagen              */

        /* PROVISORIAS */
        
        var agregarImagen = document.getElementById("imagenprovisoria");
        
        agregarImagen.addEventListener("change", function(ex){
            // console.log(ex.target.files[0]);
            // var act = 0
            // if(ex.target.dataset.act != undefined) act = ex.target.dataset.act;
            if(ex.target && ex.target.nodeName == 'INPUT'){

                // switch
                // console.log(ex.target.files[0].type);
                switch(ex.target.files[0].type){
                    case 'image/png':
                    case 'image/jpeg':
                    case 'image/jpg':
                        if(!arrayImagenes.includes(ex.target.files[0])){
                            arrayImagenes.push(ex.target.files[0]);
                        }
                        break;
                    default:
                        swal("Ops!", "Solo puede subir imagenes a el prospecto", "error");
                        break;
                
                }

                

            mostrarImagenes(arrayImagenes);
            }

        });

        function limpiarImagenes(){
            var div  = document.getElementById("contenedorImagenesProvisorias");
            div.innerHTML = '';
            var div  = document.getElementById("contenedorImagenesProvisoriasAntiguas");
            div.innerHTML = '';
        }

        function mostrarImagenes(arrayDeImagenes){

            var div  = document.getElementById("contenedorImagenesProvisorias");

            div.innerHTML = '';

            var divContPlus = document.createElement('div');
            divContPlus.setAttribute('style', 'display:flex;flex-direction:row;');

            divContPlus.innerHTML = '';
            if(arrayDeImagenes != null && arrayDeImagenes.length > 0){
                for(let i = 0; i < arrayDeImagenes.length; i++){
                
                    var reader = new FileReader();
                    reader.onload = function(e){
        
        
                        var divcon = document.createElement('div');
                        divcon.setAttribute('style', 'display:flex;flex-direction:column;');
        
        
                        var filePreview = document.createElement('img');
                        filePreview.id = 'file-preview';
                        filePreview.setAttribute('style', 'height:120px;width:120px;')
                        //e.target.result contents the base64 data from the image uploaded
                        filePreview.src = e.target.result;
                        var previewZone = document.getElementById('contenedorImagenesProvisorias');
        
                        var imgClose = document.createElement('i');
                        imgClose.setAttribute('class', 'fas fa-window-close text-danger fa-2x');
                        imgClose.setAttribute('style', 'cursor:pointer;');
        
                        imgClose.addEventListener('click', function(){
        
                                var e = arrayDeImagenes.indexOf( arrayDeImagenes[i] );
                                arrayDeImagenes.splice( e, 1);
        
                                mostrarImagenes(arrayDeImagenes);
                        })
        
        
                        divcon.appendChild(imgClose);
                        divcon.appendChild(filePreview);
        
                        divContPlus.appendChild(divcon);
        
                        previewZone.appendChild(divContPlus);
                    }
        
                    reader.readAsDataURL(arrayDeImagenes[i]);
                }
            }
        }

        /* FIN PROVISORIA */

/*              Fin de agregar imagen              */
/*==================================================================================================================================*/
/*              Evento key inputs formulario              */

        var formPros = document.getElementById("formPros");

        formPros.addEventListener('keypress', function(e) {
            document.getElementById("errorMod").hidden = true;
            var id = e.target.id;
            switch(id){
                case "ProsP8":
                case "ProsP15":
                case "ProsP16":
                case "ProsP17":
                case "ProsP18":
                case "ProsP19":
                case "ProsP20":
                case "ProsP26":
                case "ProsP27":
                    e.returnValue = keyValida(e,"LTNE",e.target);
                break;
                case "ProsP9":
                case "ProsP12":
                case "ProsP13":
                    e.returnValue = keyValida(e,"ND",e.target);
                break;
                case "ProsP10":
                case "ProsP11":
                case "ProsP29":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
                break;

            }
            
        });

/*              Fin de evento key inputs formulario              */
/*==================================================================================================================================*/
/*              Function crear/editar prospecto              */

        function optionAdm(act){
            var llenado = true;
            var valido = true;
            var action = "crearProspecto";

            var mnj = "creado"
            if(act > 0) action = "editarProspecto"; mnj = "actualizado";
            
            var frmData = new FormData;

            frmData.append("action", action);
            if(act > 0) frmData.append("act", act);

            for (var i = 0; i < formPros.elements.length; i++){
                var value = formPros.elements[i].value.trim();
                var id = formPros.elements[i].id;

                if(value.length == "" || value.length == 0){
                    if(id != "ProsP11" && id != "imagenprovisoria" && id != "ProsP14" && id != "ProsP15" && id != "ProsP16" && id != "ProsP17" && id != "ProsP18" && id != "ProsP19" && id != "ProsP20" && id != "ProsP21" && id != "ProsP22" && id != "ProsP23" && id != "ProsP24" && id != "ProsP25" && id != "ProsP26" && id != "ProsP27" && id != "ProsP28" && id != "ProsP29"){
                        llenado = false;
                        break;
                    }
                
                }else{
                    if(id == "ProsP8" && !textValido("LTNE",value)){
                        valido = false;
                        break;
                        
                    }

                    if(id == "ProsP9" && id == "ProsP12" && id == "ProsP13" && !textValido("ND",value)){
                        valido = false;
                        break;

                    }

                    if((id == "ProsP10" || id == "ProsP11") && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }

                }

                frmData.append("campo"+[i], value);
            }
            
            if(arrayImagenes.length > 0){
                for(let v = 0; v < arrayImagenes.length; v++){
                    frmData.append('imagen['+v+']', arrayImagenes[v]);
                }
                frmData.append('cantidad_imagenes', arrayImagenes.length);
            }


            if(llenado && valido){
                
                $.ajax({
                    data:frmData,
                    url: urlDes,
                    type:'POST',
                    // dataType:'JSON',
                    processData: false,
                    contentType: false,
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el prospecto.", "success");

                    }else if(resp == 3){
                        swal("Atencion!", "Intento actualizar los datos, con los mismos datos que ya poseia.", "info");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalPros").modal("hide");
                    informacionProvisorias();

                });

            }else if(!llenado){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos requeridos.";

            }else{
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

            }

        }

/*              Fin de function crear/editar prospecto              */
/*==================================================================================================================================*/
/*              Crear/Editar prospecto              */

        var btnAgregar = document.getElementById("optionMod");

        btnAgregar.addEventListener("click", function(e){
            var act = 0
            if(e.target.dataset.act != undefined) act = e.target.dataset.act;
            optionAdm(act);

        });

/*              Fin de crear/editar prospecto              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalPros').on('hidden.bs.modal', function (e) {
            formPros.reset();
            btnAgregar.dataset.act = 0;
            btnAgregar.innerText  = "Agregar";
            document.getElementById("tituloModalP").innerText = "Nuevo prospecto";
            document.getElementById("ProsP6").innerHTML = "<option value=''> Selecciona una region </option>";
            document.getElementById("ProsP7").innerHTML = "<option value=''> Selecciona una region </option>";
            $('#'+formPros.elements[1].id).select2().trigger('change');
            $('#'+formPros.elements[2].id).select2().trigger('change');
            $('#'+formPros.elements[3].id).select2().trigger('change');
            $('#'+formPros.elements[4].id).select2().trigger('change');
            $('#'+formPros.elements[5].id).select2().trigger('change');
            $('#'+formPros.elements[6].id).select2().trigger('change');
            $('#'+formPros.elements[13].id).select2().trigger('change');
            $('#'+formPros.elements[20].id).select2().trigger('change');
            $('#'+formPros.elements[21].id).select2().trigger('change');
            $('#'+formPros.elements[22].id).select2().trigger('change');
            $('#'+formPros.elements[23].id).select2().trigger('change');
            $('#'+formPros.elements[24].id).select2().trigger('change');

            arrayImagenes = new Array();
            limpiarImagenes();

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Region / Provincia / Comuna              */

        function traerComunas(Provincia,form){
            $.ajax({
                data:'action=traerComunas&Provincia='+Provincia,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                
                if(resp != null){
                        
                        Contenido += "<option value=''> Seleccione una comuna </option>";
                    $.each(resp,function(i,item){
                        Contenido += "<option value='"+item.id_comuna+"'>"+item.nombre+"</option>";
                    
                    });

                }else{
                    Contenido = "<option value=''> No existen comunas </option>";

                }
                
                if(form == 1){
                    document.getElementById("ProsP7").innerHTML = Contenido;

                }else{
                    document.getElementById("ProsA9").innerHTML = Contenido;

                }
                

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        function traerProvincias(Region,form){
            $.ajax({
                data:'action=traerProvincias&Region='+Region,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                
                if(resp != null){
                        
                        Contenido += "<option value=''> Seleccione una provincia </option>";
                    $.each(resp,function(i,item){
                        Contenido += "<option value='"+item.id_provincia+"'>"+item.nombre+"</option>";
                    
                    });

                }else{
                    Contenido = "<option value=''> No existen provincias </option>";

                }
                
                if(form == 1){
                    document.getElementById("ProsP6").innerHTML = Contenido;

                }else{
                    document.getElementById("ProsA8").innerHTML = Contenido;

                }
                

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        /* Provisoria */

        var selRegionP = $("#ProsP5");

        selRegionP.on('select2:select', function (e) {
            traerProvincias(e.target.value,1);
            document.getElementById("ProsP7").innerHTML = "<option value=''> Selecciona una provincia </option>";

        });

        var selProvinciaP = $("#ProsP6");

        selProvinciaP.on('select2:select', function (e) {
            traerComunas(e.target.value,1);

        });

        /* Activa */

        var selRegionA = $("#ProsA7");

        selRegionA.on('select2:select', function (e) {
            traerProvincias(e.target.value,2);
            document.getElementById("ProsA8").innerHTML = "<option value=''> Selecciona una provincia </option>";

        });

        var selProvinciaA = $("#ProsA8");

        selProvinciaA.on('select2:select', function (e) {
            traerComunas(e.target.value,2);

        });

/*              Fin de Region / Provincia / Comuna              */
/*==================================================================================================================================*/
/*              Traer info agricultor              */

        function traerInfoAgri(Agri){
            $.ajax({
                data:'action=traerInfoAgri&Agri='+Agri,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp != null){
                    formUpd.elements[4].value = resp.razon_social;
                    formUpd.elements[5].value = resp.rut;
                    formUpd.elements[6].value = resp.email;
                    formUpd.elements[7].value = resp.telefono;
                    formUpd.elements[8].value = resp.region;
                    formUpd.elements[9].value = resp.comuna;
                    formUpd.elements[10].value = resp.rep_legal;
                    formUpd.elements[11].value = resp.rut_rl;
                    formUpd.elements[12].value = resp.telefono_rl;
                    formUpd.elements[13].value = resp.email_rl;
                    formUpd.elements[14].value = resp.banco;
                    formUpd.elements[15].value = "-";
                    formUpd.elements[16].value = resp.cuenta_corriente;

                }

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        var selAgri = $("#ProsA3");

        selAgri.on('select2:select', function (e) {
            traerInfoAgri(e.target.value);

        });
        
/*              Fin de traer info agricultor              */
/*==================================================================================================================================*/
/*              Select2              */

        /* Provisoria */
        $("#ProsP2").select2();
        $("#ProsP3").select2();
        $("#ProsP4").select2();
        $("#ProsP7").select2();
        selProvinciaP.select2();
        selRegionP.select2();

        /* Activa */
        $("#ProsA1").select2();
        $("#ProsA2").select2();
        selAgri.select2();
        $("#ProsA5").select2();
        selProvinciaA.select2();
        selRegionA.select2();
        $("#ProsA17").select2();
        $("#ProsA18").select2();
        $("#ProsA19").select2();
        $("#ProsA20").select2();
        $("#ProsA21").select2();

        /* Datos extra provisoria */
        $("#ProsP14").select2();
        $("#ProsP21").select2();
        $("#ProsP22").select2();
        $("#ProsP23").select2();
        $("#ProsP24").select2();
        $("#ProsP25").select2();

        /* FILTROS */
        $("#FProsA2").select2();        
        $("#FProsA2").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA3").select2();        
        $("#FProsA3").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA10").select2();        
        $("#FProsA10").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA11").select2();        
        $("#FProsA11").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA12").select2();        
        $("#FProsA12").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA28").select2();        
        $("#FProsA28").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA29").select2();        
        $("#FProsA29").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA30").select2();        
        $("#FProsA30").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA31").select2();        
        $("#FProsA31").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsA32").select2();        
        $("#FProsA32").on('select2:select', function (e) {
            informacionActivas();
    
        });
        $("#FProsP3").select2();        
        $("#FProsP3").on('select2:select', function (e) {
            informacionProvisorias();
    
        });
        $("#FProsP8").select2();        
        $("#FProsP8").on('select2:select', function (e) {
            informacionProvisorias();
    
        });
        $("#FProsP9").select2();        
        $("#FProsP9").on('select2:select', function (e) {
            informacionProvisorias();
    
        });
        $("#FProsP10").select2();        
        $("#FProsP10").on('select2:select', function (e) {
            informacionProvisorias();
    
        });
    
/*              Fin de select2              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e){
        e.preventDefault();

        var filtros = "";
        
        //Orden de datos
        var Orden = (obtenerOrden() > 0) ? obtenerOrden() : 0;

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Pestaña activa
        var active = document.getElementsByClassName("nav-link active")[0].id;
        switch(active){
            case "activas-tab":
                activa = 1;
                filtros = document.getElementsByName("FProsA");
            break;

            case "provisorias-tab":
                activa = 2;
                filtros = document.getElementsByName("FProsP");
            break;

        }

        var campos = "?Temporada="+Temporada+"&Orden="+Orden+"&Prospecto="+activa;

        for(let i = 0; i < filtros.length; i++){
            if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
                campos += "&"+filtros[i].id+"="+filtros[i].value;

            }

        }

        let form = document.getElementById('formExport');
        form.action = "docs/excel/prospectos.php"+campos;
        form.submit();

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        descargaExcel(e);

    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Descargar pdf              */

    function descargaPdf(e,prospecto){
        if(e!=null) e.preventDefault();

        let form = document.getElementById('formExport');
        form.action = "docs/pdf/prospectos.php?Prospecto="+prospecto;
        form.setAttribute("target", "_blank");
        form.submit();

    }

/*              Fin de descargar pdf              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/


/*  11-06-2020 Sebastian Acuña modifica */
/*==================================================================================================================================*/
/* Imagenes */

    function traerImagenes(Prospecto,etapa){

        // console.log(Prospecto);
        $.ajax({
            data:'action=traerImagenes&Prospecto='+Prospecto,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            beforeSend: function() {
                $("#modalCarga").modal('show');
            },
            complete: function() {
                $("#modalCarga").modal('hide');
            },
        }).done(function(resp){
            var contenido = "";

            if(resp != null && resp.length > 0){
                if(etapa == 2 && puas != 5){
                    document.getElementById("formIMG").style.display = "none";
                    $.each(resp,function(i,item){
                        contenido += "<a href='data:image/jpeg;base64,"+item.ruta_foto+"' data-lightbox='mygallery'> <img src='data:image/jpeg;base64,"+item.ruta_foto+"'> </a>";
    
                    });

                }else if(puas == 5){
                    document.getElementById("formIMG").style.display = "";
                    btnSubirImg.dataset.act = Prospecto;

                    contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                    contenido+= "<hr>"; 
                    contenido+= "<div style='display:flex;flex-direction:row;'>";
                    $.each(resp,function(i,item){
                        contenido+= "<div style='display:flex;flex-direction:column;' id='container_"+item.id_foto+"'>";
                            contenido += "<i style='cursor:pointer;' class='fas fa-window-close text-danger fa-2x' onclick='eliminarimagen("+item.id_foto+");'></i>";
                            contenido += "<img src='data:image/jpeg;base64,"+item.ruta_foto+"' style='height:120px;width:120px;'>";
                        contenido+= "</div>";
                    });
                    contenido+= "</div>";

                }else{
                    document.getElementById("formIMG").style.display = "none";
                    $.each(resp,function(i,item){
                        contenido += "<a href='data:image/jpeg;base64,"+item.ruta_foto+"' data-lightbox='mygallery'> <img src='data:image/jpeg;base64,"+item.ruta_foto+"'> </a>";
    
                    });

                }

            }else{
                if(etapa == 2 && puas != 5){
                    contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                    contenido+= "<hr>"; 
                    contenido+= "<h3> No existen imagenes </h3>";

                }else if(puas == 5){
                    document.getElementById("formIMG").style.display = "";
                    btnSubirImg.dataset.act = Prospecto;

                    contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                    contenido+= "<hr>"; 
                    contenido+= "<h3> No existen imagenes </h3>";

                }else{
                    contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                    contenido+= "<hr>"; 
                    contenido+= "<h3> No existen imagenes </h3>";

                }

            }

            document.getElementById("galeria").innerHTML = contenido;
        
            $("#modalImages").modal('show');
            
        })

    }

    $("#modalImages").on('shown.bs.modal', function () {
        $("#modalCarga").modal('hide');
        
    });

/*==================================================================================================================================*/
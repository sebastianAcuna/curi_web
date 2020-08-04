/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/libro.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Revertir escritura              */

    function revertirEscritura(element){
        var guardado = JSON.parse(sessionStorage.getItem('libro'));
        var input = element.previousElementSibling;
        var identificacion = input.dataset.id;
        var limpio = new Object();
        
        for(dato in guardado) {
            if(dato == identificacion){
                input.value = guardado[dato]["Original"];
                input.style = "border-color: ";
                element.parentElement.removeChild(element);

            }else{
                limpio[dato] =  guardado[dato];


            }

        }

        if(Object.keys(limpio).length === 0){
            sessionStorage.removeItem('libro');

        }else{
            sessionStorage.setItem('libro', JSON.stringify(limpio));

        }

    }

/*              Fin de revertir escritura              */
/*==================================================================================================================================*/
/*              Limpiar filtros              */

    function limpiarFiltros(){
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
/*              Traer los datos de los libros              */

    function traerDatosResumen(Page){
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Especie
        var Especie = document.getElementById("SelEspecies").value;
        
        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        //Orden de datos
        var Orden = obtenerOrden();

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatosResumen&Temporada='+Temporada+'&Etapa=1&Especie='+Especie+'&D='+Des+'&Orden='+Orden,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var tHead = "<tr> <th> Tabla de resumen </th> </tr>";
                var body = true;
                var contenido = "";
                var columnas = new Array();
                var contColspan = 0;

                if(resp[0] != null && resp[0].length != 0){
                    tHead = "<tr>";
                    $.each(resp[0],function(i,item){
                        columnas.push({0 : item.id_prop_mat_cli, 1 : item.tipo_campo, 2 : item.tabla, 3 : item.campo, 4 : item.foraneo, 5 : item.subHead.trim()});
                        tHead += "<th "+minTextTH(item.subHead)+"</th>";

                        contColspan += 1;
                    });
                    tHead += "</tr>";

                }else{
                    body = false;
                    contColspan = 1;

                }

                if(resp[1] != null && resp[1].length != 0 && body){
                    $.each(resp[1],function(i,item){
                        contenido +=    "<tr>";
                        $.each(item,function(key,valor){
                            for(let e = 0; e < columnas.length; e++){
                                if(columnas[e][0] == key){
                                    if(columnas[e][5] == "PICTURES"){
                                        contenido += "<td class='fix-edi-l'> <button type='button' class='btn btn-info' data-images='"+item.anexo+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-images' data-images='"+item.anexo+"'></i> </button> </td>";
                                    
                                    }else{
                                        if(columnas[e][5] == "ESTADO GENERAL(GENERAL STATUS)" || columnas[e][5] == "ESTADO DE CRECIMIENTO (STATE OF GROWTH)" || columnas[e][5] == "ESTADO DE MALEZAS( WEED STATUS)" || columnas[e][5] == "ESTADO FITOSANITARIO (PHYTOSANITARY STAT" || columnas[e][5] == "HUMEDAD DEL SUELO (SOIL MOISTURE)" || columnas[e][5] == "COSECHA (HARVEST)"){
                                            var color = "";
                                            switch(valor){
                                                case "Excelente":
                                                    color = "";
                                                    break;
                                                case "Buena":
                                                    color = "";
                                                    break;
                                                case "Regular":
                                                    color = "";
                                                    break;
                                                case "Mala":
                                                    color = "";
                                                    break;
                                                case "Sin especificar":
                                                    color = "";
                                                    break;
                                            }
                                            contenido +=    "<td style='background:"+color+"' "+minText(formatearFecha(valor))+"</td>";

                                        }else{
                                            contenido +=    "<td "+minText(formatearFecha(valor))+"</td>";

                                        }
    
                                    }

                                }
                            }
                        });
                        contenido +=    "</tr>";
                    });

                }else{
                    contenido = "<tr> <td colspan='"+contColspan+"'>No existen datos</td> </tr>";

                }

                document.getElementById("headResumen").innerHTML = tHead;
                document.getElementById("datosResumen").innerHTML = contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datosResumen").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatosResumen(){
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Especie
        var Especie = document.getElementById("SelEspecies").value;
    
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatosResumen&Temporada='+Temporada+'&Especie='+Especie,
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

    function traerDatosTabla(Etapa,Page){
        //Datos de filtro
        var inputs = document.getElementsByName("FLib");
        var filtros = JSON.parse(sessionStorage.getItem('filtros'));
        var filtrado = Array("", "", "", "", "", "", "", "");

        if(filtros != null){
            var campos = "";
            for(let i = 0; i < inputs.length; i++){
                if(inputs[i].value != "" && inputs[i].value != null && inputs[i].value != undefined && inputs[i].value.length > 0){
                    campos += "&Campo"+i+"="+inputs[i].value;
    
                }

                filtrado[i] = (inputs[i].value != null) ? inputs[i].value : "";
    
            }

        }

        sessionStorage.setItem('filtros', JSON.stringify(filtrado));

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Especie
        var Especie = document.getElementById("SelEspecies").value;
        
        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);
        
        //Orden de datos
        var Orden = obtenerOrden();

        // Determinar el action
        var action = (Etapa == 5) ? action = "traerDatosAll" : "traerDatosTabla";

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action='+action+'&Temporada='+Temporada+'&Etapa='+Etapa+'&Especie='+Especie+'&D='+Des+'&Orden='+Orden+campos,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                switch(Etapa){
                    case 2:
                        var tHead = "<tr> <th> Tabla de sowing </th> </tr>";
                    break;
                    case 3:
                        var tHead = "<tr> <th> Tabla de flowering </th> </tr>";
                    break;
                    case 4:
                        var tHead = "<tr> <th> Tabla de harvest </th> </tr>";
                    break;
                    case 5:
                        var tHead = "<tr> <th> Tabla All </th> </tr>";
                    break;

                }

                var body = true;
                var contenido = "";
                var columnas = new Array();
                var contColspan = 10;

                if(resp[0] != null && resp[0].length != 0){
                    /* Conocer el colspan de cada cabecera */
                    var head = new Object();
                    $.each(resp[0],function(i,item){
                        head[item.Head] = (isNaN(head[item.Head])) ? 1 : head[item.Head]+1;
                    });
                    
                    /* Titulos en la cabecera */
                    var titulos = new Array();
                    tHead = "<tr>";
                    tHead += "<th rowspan='3'> # </th>";
                    tHead += "<th colspan='6'></th>";
                    tHead += "<th colspan='2'> Field </th>";
                    $.each(resp[0],function(i,item){
                        contColspan += head[item.Head];
                        tHead +=  (titulos.indexOf(item.Head) == -1) ? "<th colspan='"+head[item.Head]+"' rowspan='2'>"+item.Head+"</th>" : "";
                        if(titulos.indexOf(item.Head) == -1) titulos.push(item.Head);
                    });
                    tHead += "<th rowspan='3'> Acciones </th>";
                    tHead += "</tr>";

                    var filtros = JSON.parse(sessionStorage.getItem('filtros'));
                    if(filtros == null) filtros = Array("", "", "", "", "", "", "", "");

                    /* Filtro */
                    tHead += "<tr>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[0])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[1])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[2])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[3])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[4])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[5])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[6])+"'> </th>";
                    tHead += "<th> <input type='text' class='form-control form-control-sm' name='FLib' placeholder='Filtrar por:' style='min-width:100px' value='"+formatearFecha(filtros[7])+"'> </th>";
                    tHead += "</tr>";

                    /* Cabecera principal, referente al dato */
                    tHead += "<tr>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='1' data-act='"+((Orden == 1) ? "1' style='color: green'" : "0'")+"></i> Recomendaciones <i class='fas fa-arrow-down' data-ord='2' data-act='"+((Orden == 2) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='3' data-act='"+((Orden == 3) ? "1' style='color: green'" : "0'")+"></i> Field Number <i class='fas fa-arrow-down' data-ord='4' data-act='"+((Orden == 4) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='5' data-act='"+((Orden == 5) ? "1' style='color: green'" : "0'")+"></i> Anexo <i class='fas fa-arrow-down' data-ord='6' data-act='"+((Orden == 6) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='7' data-act='"+((Orden == 7) ? "1' style='color: green'" : "0'")+"></i> Especie <i class='fas fa-arrow-down' data-ord='8' data-act='"+((Orden == 8) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='9' data-act='"+((Orden == 9) ? "1' style='color: green'" : "0'")+"></i> Variedad <i class='fas fa-arrow-down' data-ord='1"+((Orden == 10) ? "1' style='color: green'" : "0'")+" data-act='"+((Orden == 1) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='11' data-act='"+((Orden == 11) ? "1' style='color: green'" : "0'")+"></i> Agricultor <i class='fas fa-arrow-down' data-ord='12' data-act='"+((Orden == 12) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='13' data-act='"+((Orden == 13) ? "1' style='color: green'" : "0'")+"></i> Predio <i class='fas fa-arrow-down' data-ord='14' data-act='"+((Orden == 14) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    tHead += "<th> <div> <i class='fas fa-arrow-up' data-ord='15' data-act='"+((Orden == 15) ? "1' style='color: green'" : "0'")+"></i> Potrero <i class='fas fa-arrow-down' data-ord='16' data-act='"+((Orden == 16) ? "1' style='color: green'" : "0'")+"></i> </div> </th>";
                    $.each(resp[0],function(i,item){
                        columnas.push({0 : item.id_prop_mat_cli, 1 : item.tipo_campo, 2 : item.tabla, 3 : item.campo, 4 : item.foraneo, 5 : item.subHead.trim()});
                        /* tHead += "<th>"+item.subHead+"</th>"; */
                        tHead += "<th "+minTextTH(item.subHead)+"</th>";
                    });
                    tHead += "</tr>";

                }else{
                    body = false;
                    contColspan = 1;

                }

                if(resp[1] != null && resp[1].length != 0 && body){
                    $.each(resp[1],function(i,item){
                        contenido +=    "<tr>";
                        contenido +=        "<td>"+(i+1)+"</td>";
                        contenido +=        "<td "+minText(item.recome)+"</td>";
                        contenido +=        "<td "+minText(item.num_lote)+"</td>";
                        contenido +=        "<td class='fix-edi-left-1'"+minText(item.num_anexo)+"</td>";
                        contenido +=        "<td class='fix-edi-left-2'"+minText(item.especie)+"</td>";
                        contenido +=        "<td "+minText(item.nom_hibrido)+"</td>";
                        contenido +=        "<td class='fix-edi-left-3'"+minText(item.razon_social)+"</td>";
                        contenido +=        "<td "+minText(item.predio)+"</td>";
                        contenido +=        "<td "+minText(item.lote)+"</td>";

                        if(Etapa != 5 && puas == 5){
                            for(let e = 0; e < columnas.length; e++){
                                var encontro = false;
                                $.each(item,function(key,valor){
                                    if(columnas[e][0] == key){
                                        encontro = true;

                                        if(columnas[e][4] == "SI" && columnas[e][2] != "detalle_visita_prop"){
                                            if(valor.toString().indexOf(" && ") > 0){
                                                var dato = valor.split(" && ");
    
                                                contenido +=    "<td "+minText(dato[2])+"</td>";
                
                                            }else{
                                                contenido +=    "<td "+minText(valor)+"</td>";

                                            }
    
                                        }else{
                                            if(valor.toString().indexOf(" && ") > 0){
                                                var dato = valor.split(" && ");
    
                                                if(columnas[e][0] == dato[1]){
                                                    switch(columnas[e][1]){
                                                        case 'DATE':
                                                        case 'RECYCLER_GENERICO_DATE':
                                                            contenido +=    "<td><div class='libro-cont-inp'><input type='date' class='form-control form-control-sm inp-lib-date' name='libro' data-ty='1' data-id='"+dato[0]+"' data-prop='"+columnas[e][0]+"' value='"+dato[2]+"'></div></td>";
                                                        break;
                                                        case 'TEXT':
                                                        case 'CHECK':
                                                        case 'TEXTVIEW':
                                                        case 'RECYCLER_UNO_TEXTVIEW':
                                                        case 'RECYCLER_GENERICO_TEXTVIEW':
                                                        case 'RECYCLER_GENERICO_STRING':
                                                        case 'INT':
                                                        case 'DECIMAL':
                                                        case 'RECYCLER_GENERICO_INT':
                                                        case 'RECYCLER_GENERICO_DECIMAL':
                                                        case 'RECYCLER_GENERICO_DOUBLE':
                                                        case 'RECYCLER_GENERICO_SPINNER':
                                                            contenido +=    "<td><div class='libro-cont-inp'><input type='text' class='form-control form-control-sm inp-lib-text' name='libro' data-ty='1' data-id='"+dato[0]+"' data-prop='"+columnas[e][0]+"' value='"+dato[2]+"'></div></td>";
                                                        break;
                                                        case 'PICTURE':
                                                            contenido +=    "<td><div class='libro-cont-inp'><input disabled type='text' class='form-control form-control-sm inp-lib-text' name='libro' data-ty='1' data-id='"+dato[0]+"' data-prop='"+columnas[e][0]+"' value='"+dato[2]+"'></div></td>";
                                                        break;

                                                    }
                
                                                }
        
                                            }
    
                                        }
    
                                    }
                                    
                                });
        
                                if(!encontro){
                                    switch(columnas[e][1]){
                                        case 'DATE':
                                        case 'RECYCLER_GENERICO_DATE':
                                            contenido +=    "<td><div class='libro-cont-inp'><input type='date' class='form-control form-control-sm inp-lib-date' name='libro' data-ty='2' data-prop='"+columnas[e][0]+"' data-id='"+item.visita+"+"+columnas[e][0]+"' value=''></div></td>";
                                        break;
                                        case 'TEXT':
                                        case 'CHECK':
                                        case 'TEXTVIEW':
                                        case 'RECYCLER_UNO_TEXTVIEW':
                                        case 'RECYCLER_GENERICO_TEXTVIEW':
                                        case 'RECYCLER_GENERICO_STRING':
                                        case 'INT':
                                        case 'DECIMAL':
                                        case 'RECYCLER_GENERICO_INT':
                                        case 'RECYCLER_GENERICO_DECIMAL':
                                        case 'RECYCLER_GENERICO_DOUBLE':
                                        case 'RECYCLER_GENERICO_SPINNER':
                                            contenido +=    "<td><div class='libro-cont-inp'><input type='text' class='form-control form-control-sm inp-lib-text'name='libro' data-ty='2' data-prop='"+columnas[e][0]+"' data-id='"+item.visita+"+"+columnas[e][0]+"' value=''></div></td>";
                                        break;
                                        case 'PICTURE':
                                            contenido +=    "<td><div class='libro-cont-inp'><input disabled type='text' class='form-control form-control-sm inp-lib-text'name='libro' data-ty='2' data-prop='"+columnas[e][0]+"' data-id='"+item.visita+"+"+columnas[e][0]+"' value=''></div></td>";
                                        break;

                                    }
    
                                }

                            }

                        }else{
                            for(let e = 0; e < columnas.length; e++){
                                var encontro = false;
                                $.each(item,function(key,valor){
                                    if(columnas[e][0] == key){
                                        encontro = true;

                                        if(columnas[e][4] == "SI" && columnas[e][2] != "detalle_visita_prop"){
                                            if(valor.toString().indexOf(" && ") > 0){
                                                var dato = valor.split(" && ");
    
                                                contenido +=    "<td "+minText(formatearFecha(dato[2]))+"</td>";
                
                                            }else{
                                                contenido +=    "<td "+minText(formatearFecha(valor))+"</td>";

                                            }
    
                                        }else{
                                            if(valor.toString().indexOf(" && ") > 0){
                                                var dato = valor.split(" && ");
    
                                                contenido +=    "<td "+minText(formatearFecha(dato[2]))+"</td>";
                
                                            }
    
                                        }
    
                                    }
                                    
                                });
        
                                if(!encontro){
                                    contenido +=    "<td></td>";
    
                                }

                            }

                        }

                        contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-images='"+item.anexo+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-images' data-images='"+item.anexo+"'></i> </button> </td>";
                        contenido +=    "</tr>";
                        
                    });

                }else{
                    contenido = "<tr> <td colspan='"+contColspan+"'>No existen datos</td> </tr>";

                }

                switch(Etapa){
                    case 2:
                        document.getElementById("headSowing").innerHTML = tHead;
                        document.getElementById("headFlowering").innerHTML = "";
                        document.getElementById("headHarvest").innerHTML = "";
                        document.getElementById("headAll").innerHTML = "";
                        document.getElementById("datosSowing").innerHTML = contenido;
                    break;
                    case 3:
                        document.getElementById("headSowing").innerHTML = "";
                        document.getElementById("headFlowering").innerHTML = tHead;
                        document.getElementById("headHarvest").innerHTML = "";
                        document.getElementById("headAll").innerHTML = "";
                        document.getElementById("datosFlowering").innerHTML = contenido;
                    break;
                    case 4:
                        document.getElementById("headSowing").innerHTML = "";
                        document.getElementById("headFlowering").innerHTML = "";
                        document.getElementById("headHarvest").innerHTML = tHead;
                        document.getElementById("headAll").innerHTML = "";
                        document.getElementById("datosHarvest").innerHTML = contenido;
                    break;
                    case 5:
                        document.getElementById("headSowing").innerHTML = "";
                        document.getElementById("headFlowering").innerHTML = "";
                        document.getElementById("headHarvest").innerHTML = "";
                        document.getElementById("headAll").innerHTML = tHead;
                        document.getElementById("datosAll").innerHTML = contenido;
                    break;

                }

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                contenido = "<tr> <td style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                switch(Etapa){
                    case 2:
                        document.getElementById("datosSowing").innerHTML = contenido;
                    break;
                    case 3:
                        document.getElementById("datosFlowering").innerHTML = contenido;
                    break;
                    case 4:
                        document.getElementById("datosHarvest").innerHTML = contenido;
                    break;
                    case 5:
                        document.getElementById("datosAll").innerHTML = contenido;
                    break;

                }

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatosTabla(Etapa){
        //Datos de filtro
        var inputs = document.getElementsByName("FLib");

        if(inputs != null){
            var campos = "";
            for(let i = 0; i < inputs.length; i++){
                if(inputs[i].value != "" && inputs[i].value != null && inputs[i].value != undefined && inputs[i].value.length > 0){
                    campos += "&Campo"+i+"="+inputs[i].value;
    
                }
    
            }

        }
        
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Especie
        var Especie = document.getElementById("SelEspecies").value;

        // Determinar el action
        var action = (Etapa == 5) ? action = "totalDatosAll" : "totalDatosTabla";
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action='+action+'&Temporada='+Temporada+'&Etapa='+Etapa+'&Especie='+Especie+campos,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
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

    /* Imagenes */

    function traerImagenes(Etapa,Info){

        $.ajax({
            data:'action=traerImagenes&Etapa='+Etapa+'&Info='+Info,
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
                $.each(resp,function(i,item){
                    contenido += "<a href='data:image/jpeg;base64,"+item.ruta_foto+"' data-lightbox='mygallery'> <img src='data:image/jpeg;base64,"+item.ruta_foto+"'> </a>";

                });

            }else{
                contenido = "<h3> No existen imagenes </h3>";

            }

            document.getElementById("galeria").innerHTML = contenido;
        
            $("#modalImages").modal('show');
            
        })

    }

    $("#modalImages").on('shown.bs.modal', function () {
        $("#modalCarga").modal('hide');
        
    });

/*              Fin de traer los datos de los libro              */
/*==================================================================================================================================*/
/*              Traer informacion              */

    function informacionResumen(Page) { 
        const promiseDatos = traerDatosResumen(Page);

        promiseDatos.then(
            result => totalDatosResumen().then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            /* finaly => console.log() */
            
        );

    }

    function informacionTabla(Etapa,Page) { 
        const promiseDatos = traerDatosTabla(Etapa,Page);

        promiseDatos.then(
            result => totalDatosTabla(Etapa).then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            finaly => sessionStorage.DesAct = 0, sessionStorage.PageAct = 1

        );

    }

    informacionResumen(1);

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Guardar libro              */

    if(puas == 5){
        function asignarValor(){
            var guardado = sessionStorage.getItem('libro');
    
            $.ajax({
                data:'action=asignarValor&Info='+guardado,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                if(resp == 1){
                    swal("Exito!", "Se han actualizado correctamente los datos.", "success");
    
                }else if(resp == 3){
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
    
                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
    
                }
    
            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);
    
            }).always(function(){
                sessionStorage.removeItem("libro");
                var active = document.getElementsByClassName("nav-link active")[0].id;
    
                switch(active){
                    case "resumen-tab":
                        informacionResumen(1);
                    break;
    
                    case "sowing-tab":
                        informacionTabla(2,1);
                    break;
    
                    case "flowering-tab":
                        informacionTabla(3,1);
                    break;
    
                    case "harvest-tab":
                        informacionTabla(4,1);
                    break;
    
                    case "all-tab":
                        informacionTabla(5,1);
                    break;
    
                }
    
            });
    
        }
    
        document.getElementById("guardarLibro").addEventListener("click", function(e){
            asignarValor();
            
        });

        function asignandoValor(element){
            var padre = element.parentElement;
            var input = element;
            var valor = element.value
            var identificacion = input.dataset.id;

            /* I */
            if(input.style.borderColor == ""){
                input.style = "border-color: green";
                
                var recuperar = document.createElement('i');
                recuperar.className = "fas fa-redo-alt";
                recuperar.dataset.rec = "Y";
                padre.appendChild(recuperar);

            }

            /* Cambio */
            if(sessionStorage.libro){
                var guardado = JSON.parse(sessionStorage.getItem('libro'));
                var cambio = false;
                for(dato in guardado) {
                    if(dato == identificacion){
                        guardado[dato]["Cambio"] = valor.trim();
                        guardado[dato]["Efectuar"] = "Si";
                        cambio = true;

                    }

                }

                if(cambio){
                    sessionStorage.setItem('libro', JSON.stringify(guardado));

                }


            }

        }
        
    }

/*              Fin de guardar libro              */
/*==================================================================================================================================*/
/*              Ejecutar paginacion              */

    var paginacion = document.getElementById("paginacion");
        
    paginacion.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "BUTTON" ) {
            sessionStorage.removeItem("libro");
            var pagina = e.target.dataset.page;
            var active = document.getElementsByClassName("nav-link active")[0].id;

            switch(active){
                case "resumen-tab":
                    traerDatosResumen(pagina);
                break;

                case "sowing-tab":
                    traerDatosTabla(2,pagina);
                break;

                case "flowering-tab":
                    traerDatosTabla(3,pagina);
                break;

                case "harvest-tab":
                    traerDatosTabla(4,pagina);
                break;

                case "all-tab":
                    traerDatosTabla(5,pagina);
                break;

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
                case "resumen-tab":
                    informacionResumen();
                break;

                case "sowing-tab":
                    informacionTabla(2);
                break;

                case "flowering-tab":
                    informacionTabla(3);
                break;

                case "harvest-tab":
                    informacionTabla(4);
                break;

                case "all-tab":
                    informacionTabla(5);
                break;

            }

        }
        
    });

/*              Fin de cambio de pestañas              */
/*==================================================================================================================================*/
/*              Ejecutar orden              */

    function ejecutarOrden(e){
        if(e.target.nodeName == "INPUT" && e.target.name == "libro"){
            var identificacion = e.target.dataset.id;
            var original = e.target.value;
            var tipo = e.target.dataset.ty;
            var prop = e.target.dataset.prop;

            /* Cambio */
            if(sessionStorage.libro){
                var guardado = JSON.parse(sessionStorage.getItem('libro'));
                var nuevo = true;

                for(dato in guardado) {
                    
                    if(guardado[identificacion]){
                        nuevo = false;

                    }

                }

                if(nuevo){
                    guardado[identificacion] =  {"Original" : original, "Cambio" : "", "Propiedad" : prop, "Tipo" : tipo, "Efectuar" : "No"};

                    sessionStorage.setItem('libro', JSON.stringify(guardado));

                }


            }else{
                var datos = new Object();
                datos[identificacion] =  {"Original" : original, "Cambio" : "", "Propiedad" : prop, "Tipo" : tipo, "Efectuar" : "No"};

                sessionStorage.setItem('libro', JSON.stringify(datos));
                
            }

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td" && e.target.name != undefined) {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td" && e.target.name != undefined){
            verMas(e.target,2);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.rec != undefined){
            revertirEscritura(e.target);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.images != undefined) {
            var images = e.target.dataset.images;
            var active = document.getElementsByClassName("nav-link active")[0].id;
            var etapa = 0;
            switch(active){
                case "resumen-tab":
                    etapa = 1;
                break;

                case "sowing-tab":
                    etapa = 2;
                break;

                case "flowering-tab":
                    etapa = 3;
                break;

                case "harvest-tab":
                    etapa = 4;
                break;

                case "all-tab":
                    etapa = 5;
                break;

            }

            traerImagenes(etapa,images);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);

            var active = document.getElementsByClassName("nav-link active")[0].id;

            switch(active){
                case "resumen-tab":
                    informacionResumen(1);
                break;

                case "sowing-tab":
                    informacionTabla(2,1);
                break;

                case "flowering-tab":
                    informacionTabla(3,1);
                break;

                case "harvest-tab":
                    informacionTabla(4,1);
                break;

                case "all-tab":
                    informacionTabla(5,1);
                break;

            }

        }

    }

    var bodyResumen = document.getElementById("tablaResumen");
    
    bodyResumen.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });

    var bodySowing = document.getElementById("tablaSowing");
    
    bodySowing.addEventListener("click", function(e){
        ejecutarOrden(e);

    });

    var bodyFlowering = document.getElementById("tablaFlowering");
    
    bodyFlowering.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });

    var bodyHarvest = document.getElementById("tablaHarvest");
    
    bodyHarvest.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });

    var bodyAll = document.getElementById("tablaAll");
    
    bodyAll.addEventListener("click", function(e){
        ejecutarOrden(e);
        
    });
    
/*              Fin de ejecutar              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    var filtroResumen = document.getElementById("tablaResumen");

    filtroResumen.addEventListener('change', function(e) {
        if(e.target.name == "FRes"){
            informacionResumen(1);
            var FRes = document.getElementsByName("FRes");        
            var filtros = JSON.parse(sessionStorage.getItem('filtros'));
            var filtrado = Array("", "a", "", "", "", "", "", "");
    
            if(filtros != null){
                var campos = "";
                for(let i = 0; i < FRes.length; i++){
                    if(FRes[i].value != "" && FRes[i].value != null && FRes[i].value != undefined && FRes[i].value.length > 0){
                        campos += "&Campo"+i+"="+FRes[i].value;
        
                    }
    
                    filtrado[i] = (FRes[i].value != null) ? FRes[i].value : "";
        
                }
    
            }
    
            sessionStorage.setItem('filtros', JSON.stringify(filtrado));

        }
        
    });

    var filtroSowing = document.getElementById("tablaSowing");

    filtroSowing.addEventListener('change', function(e) {
        if(e.target.name == "FLib"){
            informacionTabla(2,1);

        }

        if(e.target.name == "libro"){
            asignandoValor(e.target);

        }
        
    });

    var filtroFlowering = document.getElementById("tablaFlowering");

    filtroFlowering.addEventListener('change', function(e) {
        if(e.target.name == "FLib"){
            informacionTabla(3,1);

        }

        if(e.target.name == "libro"){
            asignandoValor(e.target);

        }
        
    });

    var filtroHarvest = document.getElementById("tablaHarvest");

    filtroHarvest.addEventListener('change', function(e) {
        if(e.target.name == "FLib"){
            informacionTabla(4,1);

        }

        if(e.target.name == "libro"){
            asignandoValor(e.target);

        }
        
    });

    var filtroAll = document.getElementById("tablaAll");

    filtroAll.addEventListener('change', function(e) {
        if(e.target.name == "FLib"){
            informacionTabla(5,1);

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Ejecutar select especie              */

    var selEspecies = $("#SelEspecies");

    selEspecies.on('select2:select', function (e) {
        var active = document.getElementsByClassName("nav-link active")[0].id;

        switch(active){
            case "resumen-tab":
                informacionResumen(1);
            break;

            case "sowing-tab":
                informacionTabla(2,1);
            break;

            case "flowering-tab":
                informacionTabla(3,1);
            break;

            case "harvest-tab":
                informacionTabla(4,1);
            break;

            case "all-tab":
                informacionTabla(5,1);
            break;

        }

    });

/*              Fin de ejecutar select especie              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e){
        e.preventDefault();

        var filtros = "";
        
        //Orden de datos
        var Orden = (obtenerOrden() > 0) ? obtenerOrden() : 0;

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        // Especie
        var Especie = document.getElementById("SelEspecies").value;

        // Pestaña activa
        var active = document.getElementsByClassName("nav-link active")[0].id;
        switch(active){
            case "resumen-tab":
                activa = 1;
                filtros = document.getElementsByName("FRes");
            break;
            case "sowing-tab":
                activa = 2;
                filtros = document.getElementsByName("FLib");
            break;
            case "flowering-tab":
                activa = 3;
                filtros = document.getElementsByName("FLib");
            break;
            case "harvest-tab":
                activa = 4;
                filtros = document.getElementsByName("FLib");
            break;
            case "all-tab":
                activa = 5;
                filtros = document.getElementsByName("FLib");
            break;

        }

        var campos = "?Temporada="+Temporada+"&Orden="+Orden+"&Especie="+Especie+"&Libro="+activa;

        for(let i = 0; i < filtros.length; i++){
            if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
                console.log(filtros[i]);
                campos += "&Campo"+i+"="+filtros[i].value;

            }

        }

        let form = document.getElementById('formExport');
        form.action = "docs/excel/libro.php"+campos;
        form.submit();

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        
        descargaExcel(e);

    });

    if(puas == 5){
        function descargaExcelVis(e){
            e.preventDefault();

            // Temporada de operacion
            var Temporada = document.getElementById("selectTemporada").value;
            // console.log("1 ++>"+Temporada);
            // Especie
            var Especie = document.getElementById("SelEspecies").value;
            // console.log("2 ++>"+Especie);
            // Campos
            var campos = "?Temporada="+Temporada+"&Especie="+Especie;
            // console.log("3 ++>"+campos);
            let form = document.getElementById('formExportVis');
            form.action = "docs/excel/libro_visitas.php"+campos;
            form.submit();

        }

        document.getElementById("descExcelVis").addEventListener('click', function(e) {
            descargaExcelVis(e);

        });
        
    }

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Select2              */

    selEspecies.select2();
    selEspecies.on("click", function () {
        $('.select2-search__field').focus()
    });
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/

    /* var ajaxLoadTimeout;
    $(document).ajaxStart(function() {
        ajaxLoadTimeout = setTimeout(function() { 
            var divCarga = document.getElementById("divCargaGeneral");
            divCarga.style.display = "";
        }, 50);
    
    }).ajaxSuccess(function() {
        clearTimeout(ajaxLoadTimeout);
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";
        
    }); */
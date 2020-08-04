/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/tablas.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Limpiar campos              */

    function limpiar(){
        for (var i = 0; i < formCre.elements.length; i++){
            formCre.elements[i].value = "";

        }

    }

/*              Fin de limpiar campos              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerTablas(){
        $.ajax({
            data:'action=traerTablas',
            url: urlDes,
            type:'POST',
            dataType:'JSON'
        }).done(function(resp){
            var Contenido = "";

            if(resp[0].length != 0 && resp != null){
                
                $.each(resp[0],function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td>"+item.nombre+"</td>";
                        Contenido += "<td>"+item.descripcion+"</td>";
                        Contenido += "<td>"+resp[2][i]+"</td>";
                        Contenido += "<td>"+resp[1][i]+"</td>";
                        Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-info='"+item.nombre+"' data-tb='"+item.id_tablas+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-search' data-info='"+item.nombre+"' data-tb='"+item.id_tablas+"'></i> </button>";
                        Contenido += "<button type='button' class='btn btn-info' data-nom='"+item.nombre+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-list' data-nom='"+item.nombre+"'></i> </button>";
                        Contenido += "<button type='button' class='btn btn-success' data-cre='"+item.nombre+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-plus-square' data-cre='"+item.nombre+"'></i> </button> </td>";
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='6' style='text-align:center'> No existen tablas </td> </tr>";

            }

            document.getElementById("datos").innerHTML = Contenido;

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='6' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datos").innerHTML = Contenido;

            console.log(textStatus+" => "+responseText);

        });
    
    }

    function traerInfo(tb){
        $.ajax({
            data:'action=traerInfo&tb='+tb,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var Contenido = "";

           let nombreFaltanteBd = "";
           let nombreFaltanteBd14 = "";
           let nombreFaltanteTable = "";

           let bd = Array();
           let table = Array();
           let bd14 = Array();

            $.each(resp[1],function(i1,answ1){
                bd.push(answ1.COLUMN_NAME);
            });

            $.each(resp[0],function(i2,answ2){
                table.push(answ2.nombre);
            });

            $.each(resp[2],function(i2,answ2){
                bd14.push(answ2.COLUMN_NAME);
            });

        //    console.log(bd14);

            conteoM =0;
            $.each(bd, (i3, it) => {
                if(!table.includes(it)){
                    
                    if(conteoM > 0){ nombreFaltanteTable+=",";}
                    nombreFaltanteTable+= it;  
                    conteoM++;     
                }
            });

            conteoM =0;
            $.each(table, (i3, it) => {
                if(!bd.includes(it)){
                    if(conteoM > 0){ nombreFaltanteBd+=",";}
                    nombreFaltanteBd+= it;  
                    conteoM++;      
                }
            });

            conteoM =0;
            $.each(bd14, (i3, it) => {
                if(!bd.includes(it)){
                    if(conteoM > 0){ nombreFaltanteBd14+=",";}
                    nombreFaltanteBd14+= it;  
                    conteoM++;      
                }
            });



     
            let mensajeAMostar = "";
            let a = false;
            if(nombreFaltanteBd.length > 0 ){
                a = true;
                mensajeAMostar+="En Base de datos ya no existen los siguientes campos (" + nombreFaltanteBd+ " ) <br>";
            }
            if( nombreFaltanteTable.length > 0){
                a= true;
                mensajeAMostar+="En la tabla a_campos no existen los siguientes campos que si estan en base de datos (" + nombreFaltanteTable + " ) <br> ";
            }
            if( nombreFaltanteBd14.length > 0){
                a= true;
                mensajeAMostar+="Existen las siguientes inconsistencias entre los servidores de desarrollo y produccion (" + nombreFaltanteBd14 + " ) <br> ";
            }

            if(a){
                document.getElementById("id_datos_faltantes").innerHTML = mensajeAMostar;
            }
            

            if(resp[0].length != 0){
                
                $.each(resp[0],function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td data-click='Y' style='cursor:pointer'>"+item.nombre+"</td>";
                        Contenido += "<td>"+item.espannol+"</td>";
                        Contenido += "<td>"+item.ingles+"</td>";
                        Contenido += "<td>"+item.comentariosbd+"</td>";
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='5' style='text-align:center'> No existen datos </td> </tr>";

            }
            
            document.getElementById("datosTb").innerHTML = Contenido;
            
            $("#modalTb").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerInfoTb(tb){
        $.ajax({
            data:'action=traerInfoTb&tb='+tb,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var tr = "";
            var Contenido = "";
            var key = "";
            var column = "";

            if(resp[0] != null && resp[0].length != 0){
                
                tr += "<tr>";
                    tr += "<th> # </th>";
                $.each(resp[0],function(i,item){
                    if(item.COLUMN_KEY == "PRI"){
                        key = i;
                        column = item.COLUMN_NAME;
                    }
                    tr += "<th style='min-width:175px'>"+item.COLUMN_NAME+"</th>";

                });
                    tr += "<th> Acciones </th>";
                tr += "</tr>";

            }else{
                Contenido = "<tr> <th colspan='1' style='text-align:center'> No existen columnas </th> </tr>";

            }

            if(resp[1] != null && resp[1].length > 0){
                
                $.each(resp[1],function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        for(var u = 0; u < resp[0].length; u++){
                            Contenido += "<td "+minText(item[u])+"</td>";

                        }
                        Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-tb='"+tb+"' data-key='"+item[key]+"' data-column='"+column+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-tb='"+tb+"' data-key='"+item[key]+"' data-column='"+column+"'></i> </button>";
                        Contenido += "<button type='button' class='btn btn-danger' data-tb='"+tb+"' data-eli='"+item[key]+"' data-column='"+column+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-backspace' data-tb='"+tb+"' data-eli='"+item[key]+"' data-column='"+column+"'></i> </button> </td>";
                    Contenido += "</tr>";
                });

            }else{
                Contenido = "<tr> <td colspan='"+(resp[0].length+2)+"' style='text-align:center'> No existen datos </td> </tr>";

            }

            document.getElementById("cabeceraOp").innerHTML = tr;
            document.getElementById("datosOp").innerHTML = Contenido;

            $("#modalOp").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerInfoTbCreacion(tb,edi,column){
        $.ajax({
            data:'action=traerInfoTbCreacion&tb='+tb+'&edi='+edi+'&column='+column,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            var Contenido = "";
            var key = "";
            var column = "";

            if(edi == 0 && column == 0){
                if(resp[0] != null && resp[0].length != 0){
                    $.each(resp[0],function(i,item){
                        var msjReq = (item.IS_NULLABLE == "YES")? "": " <label style='color:red'>*</label>";
                        var requerid = (item.IS_NULLABLE == "YES")? "": "required";
                        var foranea = (resp[1][i]) ? resp[1][i].nombre : "";
                        var recortar = (foranea != "") ? "style='width: 100px'" : "";
                        var style = (foranea != "") ? "style='display: flex; align-items: center'" : "";
                        Contenido += "<tr>";
                            if(item.EXTRA != "auto_increment"){
                                Contenido += "<td style='width:350px'>"+item.COLUMN_NAME+msjReq+"</td>";
                                Contenido += "<td "+style+"> <input type='text' "+recortar+" data-null='"+item.IS_NULLABLE+"' data-column='"+item.COLUMN_NAME+"' data-type='"+item.DATA_TYPE+"' data-foranea='"+foranea+"' class='form-control form-control-sm' "+requerid+">";
                                if(resp[1][i]){
                                    Contenido += "<span style='margin-left: 50px;'></span>";
                                    Contenido += "</td>";
                                    Contenido += "<td align='center'> <button type='button' class='btn btn-info' data-info='"+resp[1][i].nombre+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-table' data-info='"+resp[1][i].nombre+"'></i> </button> </td>";

                                }else{
                                    Contenido += "</td>";
                                    Contenido += "<td></td>";
                                }
                            }else{
                                Contenido += "<td style='width:350px'>"+item.COLUMN_NAME+"</td>";
                                Contenido += "<td></td>";
                            }
                        Contenido += "</tr>";
    
                    });
    
                }else{
                    Contenido = "<tr> <td colspan='1' style='text-align:center'> Actualmente no se pueden agregar  </td> </tr>";
    
                }

            }else{
                if(resp[0] != null && resp[0].length != 0){
                    $.each(resp[0],function(i,item){
                        var msjReq = (item.IS_NULLABLE == "YES")? "": " <label style='color:red'>*</label>";
                        var requerid = (item.IS_NULLABLE == "YES")? "": "required";
                        var foranea = (resp[2][i]) ? resp[2][i].nombre : "";
                        var recortar = (foranea != "") ? "style='width: 100px'" : "";
                        var style = (foranea != "") ? "style='display: flex; align-items: center'" : "";
                        if(item.COLUMN_KEY == "PRI"){
                            key = i;
                            column = item.COLUMN_NAME;
                        }
                        Contenido += "<tr>";
                            if(item.EXTRA != "auto_increment"){
                                Contenido += "<td style='width:350px'>"+item.COLUMN_NAME+msjReq+"</td>";
                                Contenido += "<td "+style+"> <input type='text' "+recortar+" data-null='"+item.IS_NULLABLE+"' data-column='"+item.COLUMN_NAME+"' data-type='"+item.DATA_TYPE+"' data-foranea='"+foranea+"' class='form-control form-control-sm' "+requerid+" value='"+resp[1][0][i]+"'>";
                                if(resp[2][i]){
                                    Contenido += "<span style='margin-left: 50px;'></span>";
                                    Contenido += "</td>";
                                    Contenido += "<td align='center'> <button type='button' class='btn btn-info' data-info='"+resp[2][i].nombre+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-table' data-info='"+resp[2][i].nombre+"'></i> </button> </td>";

                                }else{
                                    Contenido += "</td>";
                                    Contenido += "<td></td>";
                                }
                            }else{
                                Contenido += "<td style='width:350px'>"+item.COLUMN_NAME+"</td>";
                                Contenido += "<td></td>";
                            }
                        Contenido += "</tr>";
    
                    });
                    
                    btnOption.dataset.where = column;
                    btnOption.dataset.act = resp[1][0][key];
    
                }

            }


            btnOption.dataset.tb = tb;
            document.getElementById("infoTabla3").innerHTML = "Editar registro en la tabla <strong>"+tb+"</strong>";
            document.getElementById("datosCre").innerHTML = Contenido;

            $("#modalOp").modal('hide');
            $("#modalCre").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerRelaciones(column){
        $.ajax({
            data:'action=traerRelaciones&column='+column,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            var titulo = document.getElementById("infoRel");
            var tabla = document.getElementById("tablaR");
            var datos = document.getElementById("datosR");

            if(resp[0] != null && resp[0].length != 0 && resp[1] != null && resp[1].length != 0 && resp[2] != null && resp[2].length != 0){
                
                var Contenido = "";

                $.each(resp[0],function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td>"+item.nombre+"</td>";
                        Contenido += "<td>"+resp[1][i]+"</td>";
                        Contenido += "<td align='center'> <button type='button' class='btn btn-info' data-info='"+item.nombre+"' data-tb='"+item.id_tablas+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-table' data-info='"+item.nombre+"' data-tb='"+item.id_tablas+"'></i> </button> </td>";
                        Contenido += "<td align='center'> <button type='button' class='btn btn-danger' data-info='"+item.nombre+"' data-asoc='"+item.id_tablas+"' style='margin: 0; padding:.1rem .3rem'> <i class='far fa-handshake' data-info='"+item.nombre+"' data-asoc='"+item.id_tablas+"'></i> </button> </td>";
                        Contenido += "<td align='center'> <button type='button' class='btn btn-success' data-for='"+item.id_tablas+"' style='margin: 0; padding:.1rem .3rem'> <i class='fab fa-wpforms' data-for='"+item.id_tablas+"'></i> </button> </td>";
                    Contenido += "</tr>";

                });
                
                titulo.style.display = "";
                tabla.style.display = "";
                titulo.innerHTML = "Listado de tablas donde se hace referencia a la tabla => "+resp[2].nombre;
                datos.innerHTML = Contenido;

            }else{
                titulo.style.display = "none";
                tabla.style.display = "none";

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function traerAsociaciones(tb){
        $.ajax({
            data:'action=traerAsociaciones&tb='+tb,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            var Contenido = "";
            var cont = 1;

            if(resp.length != 0 && resp != null){
                cont = 1;
                $.each(resp,function(i,item){
                    if(item.ID_P != tb){
                        Contenido += "<tr>";
                            Contenido += "<td>"+cont+"</td>";
                            Contenido += "<td>"+item.Primaria+"</td>";
                            Contenido += "<td align='center'> <button type='button' class='btn btn-info' data-info='"+item.Primaria+"' data-tb='"+item.ID_P+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-table' data-info='"+item.Primaria+"' data-tb='"+item.ID_P+"'></i> </button> </td>";
                        Contenido += "</tr>";
                        cont++;

                    }

                });

                if(cont == 1){
                    Contenido = "<tr> <td colspan='3' style='text-align:center'> No existen asociaciones </td> </tr>";

                }

            }else{
                Contenido = "<tr> <td colspan='3' style='text-align:center'> No existen asociaciones </td> </tr>";

            }
            
            document.getElementById("datosTbPri").innerHTML = Contenido;

            var Contenido = "";

            if(resp.length != 0 && resp != null){
                cont = 1;
                $.each(resp,function(i,item){
                    if(item.ID_F != tb){
                        Contenido += "<tr>";
                            Contenido += "<td>"+cont+"</td>";
                            Contenido += "<td>"+item.Foranea+"</td>";
                            Contenido += "<td align='center'> <button type='button' class='btn btn-info' data-info='"+item.Foranea+"' data-tb='"+item.ID_F+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-table' data-info='"+item.Foranea+"' data-tb='"+item.ID_F+"'></i> </button> </td>";
                        Contenido += "</tr>";
                        cont++;
                    }

                });

                if(cont == 1){
                    Contenido = "<tr> <td colspan='3' style='text-align:center'> No existen asociaciones </td> </tr>";
                    
                }

            }else{
                Contenido = "<tr> <td colspan='3' style='text-align:center'> No existen asociaciones </td> </tr>";

            }
            
            document.getElementById("datosTbFor").innerHTML = Contenido;
            
            $("#modalTbAsoc").modal('show');

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }
    
    function traerReferencia(element,tabla,column,valor){
        $.ajax({
            data:'action=traerReferencia&tabla='+tabla+'&column='+column+'&valor='+valor,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null){
                element.dataset.nunRef = undefined;
                element.nextElementSibling.style.color = "green";
                Contenido = "Existe una refencia al ID ingresado -> <strong style='cursor:pointer' data-toggle='collapse' data-target='#IDR"+column+"' aria-expanded='false' aria-controls='IDR"+column+"'>REFERENCIA</strong>";;
                
                Contenido += "<div class='collapse' id='IDR"+column+"'>";
                Contenido += "  <div class='card card-body' style='color:black'>";
                Contenido += "      <ul>";
                $.each(resp,function(i,item){
                    Contenido += "<li>"+i+" = "+item+"</li>";

                });
                Contenido += "      </ul>";
                Contenido += "  </div>";
                Contenido += "</div>";
                element.nextElementSibling.innerHTML = Contenido;

            }else{
                element.dataset.nunRef = column;
                element.nextElementSibling.style.color = "red";
                element.nextElementSibling.innerText = "No existe referencia a el ID ingresado";
                
            }

        });

    }

    traerTablas();

/*              Fin de traer datos              */
/*==================================================================================================================================*/
/*              Ejecutar eventos de la tabla              */

    var body = document.getElementById("tablaTablas");
    
    body.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined) {
            var tb = e.target.dataset.tb;
            var info = e.target.dataset.info;
            document.getElementById("infoTabla").innerHTML = "Campos de la tabla <strong>"+info+"</strong>";
            btnAsoc.dataset.tb = tb;
            btnAsoc.dataset.info = info;
            document.getElementById("iAsoc").dataset.tb = tb;
            document.getElementById("iAsoc").dataset.info = info;
            traerInfo(tb);

        }

        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.nom != undefined) {
            var nom = e.target.dataset.nom;
            document.getElementById("infoTabla2").innerHTML = "Datos de la tabla <strong>"+nom+"</strong>";
            traerInfoTb(nom);

        }

        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.cre != undefined) {
            var cre = e.target.dataset.cre;
            document.getElementById("infoTabla3").innerHTML = "Ingresar registro en la tabla <strong>"+cre+"</strong>";
            traerInfoTbCreacion(cre,0,0);

        }
        
    });

    var bodyOp = document.getElementById("datosOp");

    bodyOp.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined && e.target.dataset.key != undefined && e.target.dataset.column != undefined) {
            var tb = e.target.dataset.tb;
            var key = e.target.dataset.key;
            var column = e.target.dataset.column;
            traerInfoTbCreacion(tb,key,column);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined && e.target.dataset.eli != undefined && e.target.dataset.column != undefined) {
            var tb = e.target.dataset.tb;
            var eli = e.target.dataset.eli;
            var column = e.target.dataset.column;
            eliminarRegistro(tb,eli,column);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target,2);

        }
        
    });

    var bodyTb = document.getElementById("datosTb");

    bodyTb.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "TD" && e.target.dataset.click != undefined && e.target.dataset.click == "Y") {
            var column = e.target.innerText;
            traerRelaciones(column);

        }
        
    });

    var bodyR = document.getElementById("datosR");

    bodyR.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined) {
            document.getElementById("infoRel").style.display = "none";
            document.getElementById("tablaR").style.display = "none";
            document.getElementById("infoRel").innerHTML = "";
            document.getElementById("datosR").innerHTML = "";

            var tb = e.target.dataset.tb;
            var info = e.target.dataset.info;
            document.getElementById("infoTabla").innerHTML = "Campos de la tabla <strong>"+info+"</strong>";
            btnAsoc.dataset.tb = tb;
            btnAsoc.dataset.info = info;
            traerInfo(tb);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.asoc != undefined) {
            document.getElementById("infoRel").style.display = "none";
            document.getElementById("tablaR").style.display = "none";
            document.getElementById("infoRel").innerHTML = "";
            document.getElementById("datosR").innerHTML = "";

            var asoc = e.target.dataset.asoc;
            var info = e.target.dataset.info;
            $("#modalTb").modal('hide');
            document.getElementById("infoTabla4").innerHTML = "Asociaciones de la tabla <strong>"+info+"</strong>";
            traerAsociaciones(asoc);

        }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.for != undefined) {

        }
        
    });

    var bodyTbP = document.getElementById("datosTbPri");

    bodyTbP.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined) {
            $("#modalTbAsoc").modal('hide');
            var tb = e.target.dataset.tb;
            var info = e.target.dataset.info;
            document.getElementById("infoTabla").innerHTML = "Campos de la tabla <strong>"+info+"</strong>";
            btnAsoc.dataset.tb = tb;
            btnAsoc.dataset.info = info;
            traerInfo(tb);

        }
        
    });

    var bodyTbF = document.getElementById("datosTbFor");

    bodyTbF.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.tb != undefined) {
            $("#modalTbAsoc").modal('hide');
            var tb = e.target.dataset.tb;
            var info = e.target.dataset.info;
            document.getElementById("infoTabla").innerHTML = "Campos de la tabla <strong>"+info+"</strong>";
            traerInfo(tb);

        }
        
    });

    var btnAsoc = document.getElementById("btnAsoc");

    btnAsoc.addEventListener("click", function(e){
        document.getElementById("infoRel").style.display = "none";
        document.getElementById("tablaR").style.display = "none";
        document.getElementById("infoRel").innerHTML = "";
        document.getElementById("datosR").innerHTML = "";

        var tb = e.target.dataset.tb;
        var info = e.target.dataset.info;
        $("#modalTb").modal('hide');
        document.getElementById("infoTabla4").innerHTML = "Asociaciones de la tabla <strong>"+info+"</strong>";
        traerAsociaciones(tb);

    });

    var bodyCre = document.getElementById("datosCre");

    bodyCre.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.info != undefined) {
            var info = e.target.dataset.info;
            document.getElementById("infoTabla2").innerHTML = "Datos de la tabla <strong>"+info+"</strong>";
            traerInfoTb(info);

        }
        
    });

/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Evento key inputs formulario              */

    var formCre = document.getElementById("formCre");

    formCre.addEventListener('keypress', function(e) {
        document.getElementById("errorMod").hidden = true;
        var type = e.target.dataset.type;
        if(type){
            switch(type){
                case "text":
                case "varchar":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
                break;
                case "bigint":
                case "int":
                case "double":
                    e.returnValue = keyValida(e,"ND",e.target);
                break;
                case "datetime":
                    e.returnValue = keyValida(e,"NFH",e.target);
                break;
                case "date":
                    e.returnValue = keyValida(e,"NF",e.target);
                break;
                case "time":
                    e.returnValue = keyValida(e,"NH",e.target);
                break;

            }

        }

        if(e.keyCode == 13){
            var act = 0
            if(e.target.dataset.act != undefined) act = e.target.dataset.act; var where = e.target.dataset.where;
            optionTb(act,where);

        }
        
    });
    
    formCre.addEventListener('focusin', function(e) {
        var foranea = e.target.dataset.foranea;

        if(foranea != ""){
            var columna = e.target.dataset.column;
            var valor = e.target.value;
            traerReferencia(e.target,foranea,columna,valor);

        }
        
    });
    
    formCre.addEventListener('keyup', function(e) {
        var foranea = e.target.dataset.foranea;

        if(foranea != ""){
            var columna = e.target.dataset.column;
            var valor = e.target.value;
            traerReferencia(e.target,foranea,columna,valor);

        }
        
    });

/*              Fin de evento key inputs formulario              */
/*==================================================================================================================================*/
/*              Function crear/editar registro              */

    function goAction(action,campos,valores,tb,mnj,act){
        $.ajax({
            data:'action='+action+campos+valores+'&tb='+tb,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp == 1){
                swal("Exito!", "Se ha "+mnj+" correctamente el registro.", "success");
                limpiar();

            }else if(resp == 2){
                swal("Atencion!", "Ya existe un registro con los datos actuales del formulario.", "error");

            }else if(resp == 3){
                swal("Atencion!", "Su registro ha sido invalidado, dado que se ha ejecutado incorrectamente debido al sistema.", "error");

            }else{
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);

        }).always(function(){
            if(act > 0) $("#modalCre").modal("hide");
            traerTablas();
            btnOption.disabled = false;

        });

    }

    function optionTb(act,where){
        var llenado = true;
        var valido = true;
        var campos = "&campos=";
        var valores = "&valores=";
        var campRef = "";

        for (var i = 0; i < formCre.elements.length; i++){

            if(formCre.elements[i].nodeName == "INPUT"){

                var value = formCre.elements[i].value.trim();
                var type = formCre.elements[i].dataset.type;
                var column = formCre.elements[i].dataset.column;
                var nulo = formCre.elements[i].dataset.null;
                var nunRef = formCre.elements[i].dataset.nunRef;

                if(nunRef != undefined && nunRef != "undefined") campRef += (campRef == "") ? nunRef : ", "+nunRef;

                if((value.length == "" || value.length == 0) && nulo == "NO"){
                    llenado = false;
                    break;
                
                }else{
                    if((type == "text" || type == "varchar") && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }

                    if((type == "bigint" || type == "int" || type == "double") && !textValido("ND",value)){
                        valido = false;
                        break;

                    }

                    if((type == "datetime") && !textValido("NFH",value)){
                        valido = false;
                        break;

                    }

                    if((type == "date") && !textValido("NF",value)){
                        valido = false;
                        break;

                    }

                    if((type == "time") && !textValido("NH",value)){
                        valido = false;
                        break;

                    }

                }

                if(!textValido("LTNExE",column)){
                    valido = false;
                    break;

                }

                if(i == 0){
                    campos += column;
                    valores += value;

                }else{
                    campos += ","+column;
                    valores += "||"+value;

                }
                
            }

        }

        if(llenado && valido){
            var tb = btnOption.dataset.tb;
            var action = "crearRegistro";
            var mnj = "creado";

            if(act > 0) action = "editarRegistro&act="+act+"&where="+where; mnj = "actualizado";

            if(campRef != ""){
                swal({
                    title: "¿Estas seguro?",
                    text: "Actualmente el o los campos: * "+campRef+" * no poseen referencia.",
                    icon: "warning",
                    buttons: ["Cancelar", true],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        goAction(action,campos,valores,tb,mnj,act)
                        
                    }else{
                        btnOption.disabled = false;

                    }
    
                });

            }else{
                goAction(action,campos,valores,tb,mnj,act)

            }

        }else if(!llenado){
            document.getElementById("errorMod").hidden = false;
            document.getElementById("errorMenj").innerText = "Debe completar todos los campos requeridos.";

        }else{
            document.getElementById("errorMod").hidden = false;
            document.getElementById("errorMenj").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

        }

    }

/*              Fin de function crear/editar registro              */
/*==================================================================================================================================*/
/*              Function crear/editar registro              */

    function eliminarRegistro(tb,eli,column){

        swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de eliminar un registro.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    data:'action=eliminarRegistro&tb='+tb+'&eli='+eli+'&column='+column,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha eliminado correctamente el registro.", "success");
        
                    }else if(resp == 2){
                        swal("Atencion!", "No se ha eliminado correctamente el registro.", "error");
        
                    }else if(resp == 3){
                        swal("Atencion!", "No se ha eliminado correctamente el registro.", "error");
        
                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
        
                    }
        
                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);
        
                }).always(function(){
                    $("#modalOp").modal("hide");
                    traerTablas();
        
                });
            }

        });

    }

/*              Fin de function crear/editar registro              */
/*==================================================================================================================================*/
/*              Crear/Editar registro              */

    var btnOption = document.getElementById("optionCre");

    btnOption.addEventListener("click", function(e){
        var act = 0
        if(e.target.dataset.act != undefined) act = e.target.dataset.act; var where = e.target.dataset.where; 
        if(act > 0) e.target.disabled = true;
        optionTb(act,where);

    });

/*              Fin de crear/editar registro              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

    $('#modalCre').on('hidden.bs.modal', function (e) {
        document.getElementById("formCre").reset();
        btnOption.dataset.act = 0;
        document.getElementById("errorMod").hidden = true;

    });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
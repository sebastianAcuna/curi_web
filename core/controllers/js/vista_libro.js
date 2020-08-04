/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/vista_libro.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FNom = document.getElementById("FMLC1").value;
        var FRut = document.getElementById("FMLC2").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        // colspan dinamico
        var colspan = (puas == 5) ? 7 : 6;
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FNom='+FNom+'&FRut='+FRut,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp.length != 0){

                    $.each(resp[0],function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.rut_cliente)+"</td>";
                            
                            $.each(resp[1],function(e,elemento){
                                Contenido += "<td "+minText(((elemento.id_cli == item.id_cli && elemento.cantidad > 0)?"Personalizado":"Por defecto"))+"</td>";
                            });                            
                            $.each(resp[2],function(e,elemento){
                                Contenido += "<td "+minText(((elemento.id_cli == item.id_cli && elemento.cantidad > 0)?"Personalizado":"Por defecto"))+"</td>";
                            });                            
                            $.each(resp[3],function(e,elemento){
                                Contenido += "<td "+minText(((elemento.id_cli == item.id_cli && elemento.cantidad > 0)?"Personalizado":"Por defecto"))+"</td>";
                            });
                            if(puas == 5) Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-act='"+item.id_cli+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-act='"+item.id_cli+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen datos </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                reject(textStatus);

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });

    }

    function totalDatos(){
    
        //Datos de filtro
        var FNom = document.getElementById("FMLC1").value;
        var FRut = document.getElementById("FMLC2").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FNom='+FNom+'&FRut='+FRut,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp.length != 0){
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

/*              Fin de traer datos              */
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

    var tabla = document.getElementById("tablaLibroCampo");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.act != undefined) {
            var act = e.target.dataset.act;
            document.getElementById("btnCancelar").dataset.elec = act;
            $("#modalLibro").modal('show');
            traerEspecies(act);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            informacion();

        }
        
    });
    
/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FMLC"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "LTE":
                e.returnValue = keyValida(e,3,e.target);
            break;
            case "R":
                e.returnValue = keyValida(e,4,e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas == 5){

/*==================================================================================================================================*/
/*              Rellenar modal              */

        function traerEspecies(eleccion){
            $.ajax({
                data:'action=traerEspecies&eleccion='+eleccion,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                var cliente = "";
                if(resp != null){

                    Contenido += "<option value=''> Seleccione una especie </option>";
                        
                    $.each(resp,function(i,item){
                        cliente = item.razon_social;
                        Contenido +=  "<option value='"+item.id_esp+"'>"+item.nombre+"</option>";
                    
                    });

                }else{
                    Contenido = "<option value=''> No existen especies </option>";

                }
                
                document.getElementById("especies").innerHTML = Contenido;
                document.getElementById("tituloModal").innerText = "Vista libro de campo: "+cliente;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        function traerEtapas(eleccion){
            if(eleccion != ""){
                $.ajax({
                    data:'action=traerEtapas',
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    var Contenido = "";
                    
                    if(resp != null){
        
                        Contenido += "<option value=''> Seleccione una etapa </option>";
                            
                        $.each(resp,function(i,item){
                            if(item.nombre != "RESUME" && item.nombre != "ALL") Contenido +=  "<option value='"+item.id_etapa+"'>"+item.nombre+"</option>";
                        
                        });
        
                    }else{
                        Contenido = "<option value=''> No existen etapas </option>";
        
                    }
                    
                    document.getElementById("etapas").innerHTML = Contenido;
        
                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);
        
                });

            }else{
                Contenido = "<option value=''> Seleccione una especie </option>";
                document.getElementById("etapas").innerHTML = Contenido;

            }

        }

        function mostrarPlataforma(eleccion){
            if(eleccion != ""){
                var Contenido = "";

                Contenido += "<option value=''> Seleccione una plataforma </option>";
                Contenido += "<option value='1'> Web </option>";
                Contenido += "<option value='2'> Tableta </option>";
                
                document.getElementById("plataforma").innerHTML = Contenido;

            }else{
                Contenido = "<option value=''> Seleccione una etapa </option>";
                document.getElementById("plataforma").innerHTML = Contenido;

            }

        }

        function traerInfo(especie,etapa,plataforma){
            var cliente = document.getElementById("btnCancelar").dataset.elec;
            $.ajax({
                data:'action=traerInfo&plataforma='+plataforma+'&etapa='+etapa+'&especie='+especie+'&cliente='+cliente,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                var marcar = false;
                var cant = 0;
                
                if(resp.uso){
                    document.getElementById("btnConfirmar").style.display = "none";
                    Contenido = "<h4> Se ha bloqueado la vista, dado que actualmente el usuario => '"+resp.usuario+"' esta realizando modificaciones.</h4>";

                }else if(resp != null){
                    document.getElementById("btnConfirmar").style.display = "block";
                    var titlePlataforma = (plataforma == 1) ? "(Web)" : "(Tableta)";

                    Contenido +=    "<div class='col-lg-12 col-sm-12'>";
                    Contenido +=        "<h1 class='title'> Campos de la etapa "+titlePlataforma+"</h1><hr>";
                    Contenido +=    "</div><div class='col-lg-12 col-sm-12' style='text-align: center'>";
                    Contenido +=      "<div class='form-group form-check'>";
                    Contenido +=          "<input type='checkbox' class='form-check-input' name='inputChecks' id='todosCheck'>";
                    Contenido +=          "<label class='form-check-label' for='todosCheck'> <strong> Marcar / Desmarcar todos</strong></label>";
                    Contenido +=      "</div>";

                    var titulos = new Array();
                    $.each(resp,function(i,item){
                        var ver = (plataforma == 1) ? item.ver : item.registrar;
                        if(ver == 1) cant = cant + 1;
                        
                        Contenido +=  (titulos.indexOf(item.propiedad) == -1) ? "</div><div class='col-lg-4 col-sm-12'>" : "";
                        Contenido +=      (titulos.indexOf(item.propiedad) == -1) ? "<h5>"+item.propiedad+"</h5><hr>" : "";
                        Contenido +=      "<div class='form-group form-check'>";
                        Contenido +=          (ver == 1) ? "<input type='checkbox' class='form-check-input' name='inputChecks' id='"+item.id_cli_pcm+"' checked>" : "<input type='checkbox' class='form-check-input' name='inputChecks' id='"+item.id_cli_pcm+"'>";
                        Contenido +=          "<label class='form-check-label' for='"+item.id_cli_pcm+"'> <strong>"+item.nombre_en+"</strong></label>";
                        Contenido +=      "</div>";
                        if(titulos.indexOf(item.propiedad) == -1) titulos.push(item.propiedad);
                    });
                    
                    if(cant == resp.length) marcar = true;


                }else{
                    Contenido = "<h4> No se encontraron resultados actualmente para el cliente.</h4>";

                }
                
                document.getElementById("checks").innerHTML = Contenido; 
                if(marcar) document.getElementById("todosCheck").checked = true;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }
        
        function desbloquearVista(){
            $.ajax({
                data:'action=desbloquearVista',
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){

            }).fail(function( jqXHR, textStatus, responseText) {

            });

        }

        var selEspecies = $("#especies");

        selEspecies.on('select2:select', function (e) {
            document.getElementById("btnConfirmar").style.display = "none";
            desbloquearVista();
            traerEtapas(e.target.value);
            document.getElementById("plataforma").innerHTML = " <option value=''>Seleccione una etapa</option>";
            document.getElementById("checks").innerHTML = ""; 

        });

        var selEtapas = $("#etapas");

        selEtapas.on('select2:select', function (e) {
            document.getElementById("btnConfirmar").style.display = "none";
            desbloquearVista();
            mostrarPlataforma(e.target.value);
            document.getElementById("checks").innerHTML = ""; 

        });

        var selPlataforma = $("#plataforma");

        selPlataforma.on('select2:select', function (e) {
            desbloquearVista();
            traerInfo(selEspecies.val(), selEtapas.val(), e.target.value);

        });

/*              Fin de rellenar modal              */
/*==================================================================================================================================*/
/*              Evento checks              */

        function eventoCheck(plataforma,check,cambio){
            var cliente = document.getElementById("btnCancelar").dataset.elec;
            $.ajax({
                data:'action=eventoCheck&cliente='+cliente+'&plataforma='+plataforma+'&check='+check+'&cambio='+cambio,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 3){
                    swal("Error!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                }

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        function marcarChecks(especie,etapa,plataforma,cambio){
            var cliente = document.getElementById("btnCancelar").dataset.elec;
            $.ajax({
                data:'action=marcarChecks&cliente='+cliente+'&etapa='+etapa+'&especie='+especie+'&plataforma='+plataforma+'&cambio='+cambio,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 1){
                    traerInfo(especie,etapa,plataforma);

                }else if(resp == 3){
                    swal("Error!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                }

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        var checks = document.getElementById("checks");

        checks.addEventListener("change", function(e){
            var cambio = (selPlataforma.val() == 1) ? (e.target.checked) ? 1 : 2 : (e.target.checked) ? 1 : 0;

            if(e.target.id == "todosCheck"){
                marcarChecks(selEspecies.val(), selEtapas.val(), selPlataforma.val(), cambio);

            }else{
                eventoCheck(selPlataforma.val(), e.target.id, cambio);

            }

        });

/*              Fin de evento checks              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalLibro').on('hidden.bs.modal', function (e) {
            document.getElementById("btnConfirmar").style.display = "none";
            desbloquearVista();
            informacion();
            document.getElementById("especies").innerHTML = " <option value=''>Seleccione una especie</option>";
            document.getElementById("etapas").innerHTML = " <option value=''>Seleccione una especie</option>";
            document.getElementById("plataforma").innerHTML = " <option value=''>Seleccione una etapa</option>";
            document.getElementById("checks").innerHTML = "";

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/

    }

/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    selEspecies.select2();
    selEtapas.select2();
    selPlataforma.select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
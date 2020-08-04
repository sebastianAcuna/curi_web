/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/potreros.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){
        // Data del ajax
        let data = "";
        data = "action=traerDatos";

        // Orden de datos
        let Orden = obtenerOrden();
        data += "&Orden="+Orden;

        // Ve que pagina es y trae los datos correspondientes a tal
        let Des = obtenerPagina(Page);
        data += "&D="+Des;

        // Temporada de operacion
        let Temporada = obtenerTemporada();
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FPot");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }

        // colspan dinamico
        let colspan = (puas == 5) ? 7 : 6;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:data,
                url:urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                let Contenido = "";

                if(resp != null && resp.length != 0){
                    
                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.predio)+"</td>";
                            Contenido += "<td "+minText(item.region)+"</td>";
                            Contenido += "<td "+minText(item.comuna)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-edi='"+item.id_lote+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-edi='"+item.id_lote+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen potreros </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                let Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });
    
    }

    function totalDatos(){
        // Data del ajax
        let data = "";
        data = "action=totalDatos";

        // Temporada de operacion
        let Temporada = obtenerTemporada();
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FPot");

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

    function traerInfo(info){
        $.ajax({
            data:'action=traerInfo&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            if(resp != null){
                traerPredios(resp.id_agric,resp.id_tempo);

                formPot.elements[0].value = resp.id_agric;
                $('#'+formPot.elements[0].id).select2().trigger('change');
                formPot.elements[1].value = resp.id_tempo;
                $('#'+formPot.elements[1].id).select2().trigger('change');
                formPot.elements[2].value = resp.id_pred;
                $('#'+formPot.elements[2].id).select2().trigger('change');
                formPot.elements[3].value = resp.nombre;
                formPot.elements[4].value = resp.nombre_ac;
                formPot.elements[5].value = resp.telefono_ac;

                btnAgregar.dataset.act = info;
                document.getElementById("tituloModal").innerText = "Editar lote";
                $("#modalPot").modal('show');

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

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

    var tabla = document.getElementById("tablaPotreros");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.edi != undefined) {
            var edi = e.target.dataset.edi;
            traerInfo(edi);

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
        if(name == "FPot"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FPot1":
            case "FPot2":
            case "FPot3":
            case "FPot4":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FPot5":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas == 5){

/*==================================================================================================================================*/
/*              Evento key inputs formulario              */

        var formPot = document.getElementById("formPot");

        formPot.addEventListener('keypress', function(e) {
            document.getElementById("errorMod").hidden = true;
            var id = e.target.id;
            switch(id){
                case "Pot4":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
                break;
                case "Pot5":
                    e.returnValue = keyValida(e,"LTE",e.target);
                break;
                case "Pot6":
                    e.returnValue = keyValida(e,"F",e.target);
                break;

            }
            
        });

/*              Fin de evento key inputs formulario              */
/*==================================================================================================================================*/
/*              Function crear/editar predio              */

        function optionPre(act){
            var llenado = true;
            var valido = true;
            var campos = "";

            for (var i = 0; i < formPot.elements.length; i++){
                var value = formPot.elements[i].value.trim();
                var id = formPot.elements[i].id;

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }else{
                    if(id == "Pot4" && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }
                    
                    if(id == "Pot5" && !textValido("LTE",value)){
                        valido = false;
                        break;

                    }

                    if(id == "Pot6" && !textValido("F",value)){
                        valido = false;
                        break;

                    }

                }

                campos += "&campo"+[i]+"="+value;

            }

            if(llenado && valido){
                var action = "crearPotrero";
                var mnj = "creado"
                if(act > 0) action = "editarPotrero&act="+act; mnj = "actualizado";

                $.ajax({
                    data:'action='+action+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el potrero.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ya existe un potrero con el mismo nombre, agricultor y predio", "error");

                    }else if(resp == 3){
                        swal("Atencion!", "Verifique si sus datos ingresados no existen actualmente en el sistema, ya que debido a ellos no se efectuo ninguna acción.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalPot").modal("hide");
                    informacion();

                });

            }else if(!llenado){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos requeridos.";

            }else if(!valido){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

            }

        }

/*              Fin de function crear/editar predio              */
/*==================================================================================================================================*/
/*              Crear/Editar predio              */

        var btnAgregar = document.getElementById("optionMod");

        btnAgregar.addEventListener("click", function(e){
            var act = 0
            if(e.target.dataset.act != undefined) act = e.target.dataset.act;
            optionPre(act);

        });

/*              Fin de crear/editar predio              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalPot').on('hidden.bs.modal', function (e) {
            formPot.reset();
            btnAgregar.dataset.act = 0;
            selAgic.select2().trigger('change');
            selTempo.select2().trigger('change');
            document.getElementById("errorMod").hidden = true;
            document.getElementById("tituloModal").innerText = "Nuevo potrero";
            document.getElementById("Pot3").innerHTML = "<option value=''> Seleccione un agricultor </option>";

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Traer predio              */

        function traerPredios(Agric, Tempo){
            $.ajax({
                data:'action=traerPredios&Agric='+Agric+'&Tempo='+Tempo,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                
                if(resp != null){

                    Contenido += "<option value=''> Seleccione un predio </option>";
                        
                    $.each(resp,function(i,item){
                        Contenido += "<option value='"+item.id_pred+"'>"+item.nombre+"</option>";
                    
                    });

                }else{
                    Contenido = "<option value=''> No existen predios </option>";

                }
                
                document.getElementById("Pot3").innerHTML = Contenido;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        var selAgic = $("#Pot1");

        var selTempo = $("#Pot2");

        selAgic.on('select2:select', function (e) {
            let tempo = selTempo.val();
            traerPredios(e.target.value,tempo);

        });

        selTempo.on('select2:select', function (e) {
            let agri = selAgic.val();
            traerPredios(agri,e.target.value);

        });

/*              Fin de traer predio              */
/*==================================================================================================================================*/
/*              Select2              */

        selAgic.select2();
        selTempo.select2();
        $("#Pot3").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/

    }

/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
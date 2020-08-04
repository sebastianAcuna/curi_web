/*==================================================================================================================================*/
/*              Variables globales              */

var urlDes = "core/controllers/php/predios.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        let FAgric = document.getElementById("FPre1").value;
        let FReg = document.getElementById("FPre2").value;
        let FCom = document.getElementById("FPre3").value;
        let FNom = document.getElementById("FPre4").value;

        //Orden de datos
        let Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        let Des = obtenerPagina(Page);

        // Temporada de operacion
        let Temporada = obtenerTemporada();

        // colspan dinamico
        let colspan = (puas == 5) ? 6 : 5;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&Temporada='+Temporada+'&FAgric='+FAgric+'&FReg='+FReg+'&FCom='+FCom+'&FNom='+FNom,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                let Contenido = "";

                if(resp != null && resp.length != 0){
                    
                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.region)+"</td>";
                            Contenido += "<td "+minText(item.comuna)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-edi='"+item.id_pred+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-edi='"+item.id_pred+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen predios </td> </tr>";

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
    
        //Datos de filtro
        let FAgric = document.getElementById("FPre1").value;
        let FReg = document.getElementById("FPre2").value;
        let FCom = document.getElementById("FPre3").value;
        let FNom = document.getElementById("FPre4").value;

        // Temporada de operacion
        let Temporada = obtenerTemporada();

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FAgric='+FAgric+'&FReg='+FReg+'&FCom='+FCom+'&FNom='+FNom+'&Temporada='+Temporada,
                url: urlDes,
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
                traerComunas(resp.id_region);

                formPre.elements[0].value = resp.id_agric;
                $('#'+formPre.elements[0].id).select2().trigger('change');
                formPre.elements[1].value = resp.id_region;
                $('#'+formPre.elements[1].id).select2().trigger('change');
                formPre.elements[2].value = resp.id_comuna;
                $('#'+formPre.elements[2].id).select2().trigger('change');
                formPre.elements[3].value = resp.nombre;

                btnAgregar.dataset.act = info;
                document.getElementById("tituloModal").innerText = "Editar predio";
                $("#modalPre").modal('show');

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

    var tabla = document.getElementById("tablaPredios");
    
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
        if(name == "FPre"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FPre1":
            case "FPre2":
            case "FPre3":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FPre4":
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

        var formPre = document.getElementById("formPre");

        formPre.addEventListener('keypress', function(e) {
            document.getElementById("errorMod").hidden = true;
            var id = e.target.id;
            switch(id){
                case "Pre4":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
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

            for (var i = 0; i < formPre.elements.length; i++){
                var value = formPre.elements[i].value.trim();
                var id = formPre.elements[i].id;

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }else{
                    if(id == "Pre4" && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }

                }

                campos += "&campo"+[i]+"="+value;

            }

            if(llenado && valido){
                var action = "crearPredio";
                var mnj = "creado"
                if(act > 0) action = "editarPredio&act="+act; mnj = "actualizado";

                $.ajax({
                    data:'action='+action+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el predio.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ya existe un predio con el mismo nombre, agricultor y ubicación", "error");

                    }else if(resp == 3){
                        swal("Atencion!", "Verifique si sus datos ingresados no existen actualmente en el sistema, ya que debido a ellos no se efectuo ninguna acción.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalPre").modal("hide");
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

        $('#modalPre').on('hidden.bs.modal', function (e) {
            document.getElementById("errorMod").hidden = true;
            formPre.reset();
            btnAgregar.dataset.act = 0;
            $('#'+formPre.elements[0].id).select2().trigger('change');
            $('#'+formPre.elements[1].id).select2().trigger('change');
            document.getElementById("tituloModal").innerText = "Nuevo predio";
            document.getElementById("Pre3").innerHTML = "<option value=''> Seleccione una region </option>";

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Comuna              */

        function traerComunas(Region){
            $.ajax({
                data:'action=traerComunas&Region='+Region,
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
                
                document.getElementById("Pre3").innerHTML = Contenido;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        var selRegion = $("#Pre2");

        selRegion.on('select2:select', function (e) {
            traerComunas(e.target.value);

        });

/*              Fin de Comuna              */
/*==================================================================================================================================*/

    }

/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    $("#Pre1").select2();
    selRegion.select2();
    $("#Pre3").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
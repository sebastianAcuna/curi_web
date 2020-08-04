/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/administradores.php";

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

        // Filtros
        let filtros = document.getElementsByName("FAdm");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            data += "&campo"+[i]+"="+value;

        }

        // colspan dinamico
        let colspan = (puas == 5) ? 6 : 5;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:data,
                url:urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                let Contenido = "";
                if(resp != null){
                    
                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.user)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            Contenido += "<td "+minText(item.email)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'><button type='button' class='btn btn-info' data-edi='"+item.id_usuario+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-edi='"+item.id_usuario+"'></i> </button></td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen administradores </td> </tr>";

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

        // Filtros
        let filtros = document.getElementsByName("FAdm");

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
            dataType:'JSON'
        }).done(function(resp){
            
            if(resp[0] != null && resp[0].length != 0){
                traerRegiones(resp[0].id_pais);
                traerComunas(resp[0].id_provincia);
                traerProvincias(resp[0].id_region);

                formAdm.elements[0].value = resp[0].email;
                formAdm.elements[1].value = resp[0].user;

                if(mpoa == 0 && resp.per != 1){
                    formAdm.elements[2].value = "**************************";
                    formAdm.elements[2].disabled = true;
                    formAdm.elements[3].value = "**************************";
                    formAdm.elements[3].disabled = true;

                }else{
                    formAdm.elements[2].value = "-";
                    formAdm.elements[3].value = "-";
                    formAdm.elements[2].dataset.per = 1;
                    formAdm.elements[3].dataset.per = 1;

                }

                formAdm.elements[4].value = resp[0].rut;
                formAdm.elements[5].value = resp[0].nombre;
                formAdm.elements[6].value = resp[0].apellido_p;
                formAdm.elements[7].value = resp[0].apellido_m;
                formAdm.elements[8].value = resp[0].telefono;

                formAdm.elements[9].value = resp[0].id_pais;
                $('#'+formAdm.elements[9].id).select2().trigger('change');

                formAdm.elements[10].value = resp[0].id_region;
                $('#'+formAdm.elements[10].id).select2().trigger('change');

                formAdm.elements[11].value = resp[0].id_provincia;
                $('#'+formAdm.elements[11].id).select2().trigger('change');

                formAdm.elements[12].value = resp[0].id_comuna;
                $('#'+formAdm.elements[12].id).select2().trigger('change');

                formAdm.elements[13].value = resp[0].direccion;

                btnAgregar.dataset.act = info;
                document.getElementById("tituloModal").innerText = "Editar administrador";
                $("#modalAdm").modal('show');

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
            let pagina = e.target.dataset.page;
            traerDatos(pagina);
            paginador();

        }
        
    });
    
/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Ejecutar eventos de la tabla              */

    var tabla = document.getElementById("tablaAdministradores");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.edi != undefined) {
            let edi = e.target.dataset.edi;
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
        let name = e.target.name;
        if(name == "FAdm"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        let id = e.target.id;
        switch(id){
            case "FAdm1":
                e.returnValue = keyValida(e,"L",e.target);
            break;
            case "FAdm2":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FAdm3":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FAdm4":
                e.returnValue = keyValida(e,"C",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas == 5){

/*==================================================================================================================================*/
/*              Evento key inputs formulario              */

        var formAdm = document.getElementById("formAdm");

        formAdm.addEventListener('keypress', function(e) {
            document.getElementById("errorMod").hidden = true;
            let id = e.target.id;
            switch(id){
                case "email":
                    e.returnValue = keyValida(e,"C",e.target);
                break;
                case "pass":
                case "verificarPass":
                    e.returnValue = keyValida(e,"LTNEx",e.target);
                break;
                case "rut":
                    e.returnValue = keyValida(e,"R",e.target);
                break;
                case "nombre":
                case "apellidoP":
                case "apellidoM":
                    e.returnValue = keyValida(e,"LTE",e.target);
                break;
                case "username":
                    e.returnValue = keyValida(e,"L",e.target);
                break;
                case "direccion":
                    e.returnValue = keyValida(e,"LTNExE",e.target);
                break;
                case "telefono":
                    e.returnValue = keyValida(e,"F",e.target);
                break;

            }
            
        });

/*              Fin de evento key inputs formulario              */
/*==================================================================================================================================*/
/*              Function crear/editar administrador              */

        function optionAdm(act){
            let llenado = true;
            let valido = true;
            let pass = true;
            let campos = "";

            for (let i = 0; i < formAdm.elements.length; i++){
                let value = formAdm.elements[i].value.trim();
                let id = formAdm.elements[i].id;
                let disabled = formAdm.elements[i].disabled;
                let per = formAdm.elements[i].dataset.per;

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }else{
                    if(id == "email" && !textValido("C",value)){
                        valido = false;
                        break;
                    }

                    if((id == "pass" || id == "verificarPass") && disabled == false && act > 0 && mpoa == 1 && per != 1){
                        valido = false;
                        break;

                    }else if((id == "pass" || id == "verificarPass") && disabled == false && act == 0 && !textValido("LTNEx",value)){
                        valido = false;
                        break;

                    }

                    if(id == "rut" && !textValido("R",value)){
                        valido = false;
                        break;

                    }

                    if(id == "username" && !textValido("L",value)){
                        valido = false;
                        break;

                    }

                    if((id == "apellidoP" || id == "apellidoM" || id == "nombre") && !textValido("LTE",value)){
                        valido = false;
                        break;

                    }

                    if(id == "direccion" && !textValido("LTNExE",value)){
                        valido = false;
                        break;
                    }

                    if(id == "telefono" && !textValido("F",value)){
                        valido = false;
                        break;

                    }

                }


                campos += "&campo"+[i]+"="+value;

            }

            if(document.getElementById("pass").value != document.getElementById("verificarPass").value){
                pass = false;

            }

            if(llenado && valido && pass){
                let action = "crearAdministrador";
                let mnj = "creado"
                if(act > 0) action = "editarAdministrador&act="+act, mnj = "actualizado";

                $.ajax({
                    data:'action='+action+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el administrador.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ya existe un usuario que posee un rut, nombre de usuario o email igual a los ingresados.", "error");

                    }else if(resp == 3){
                        swal("Atencion!", "Verifique si sus datos ingresados no existen actualmente en el sistema, ya que debido a ellos no se efectuo ninguna acción.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalAdm").modal("hide");
                    informacion();

                });

            }else if(!llenado){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos requeridos.";

            }else if(!valido){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

            }else if(!pass){
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "La contraseña y su verificacion no son iguales.";

            }

        }

/*              Fin de function crear/editar administrador              */
/*==================================================================================================================================*/
/*              Crear/Editar administrador              */

        var btnAgregar = document.getElementById("optionMod");

        btnAgregar.addEventListener("click", function(e){
            let act = 0
            if(e.target.dataset.act != undefined) act = e.target.dataset.act;
            optionAdm(act);

        });

/*              Fin de crear/editar administrador              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalAdm').on('hidden.bs.modal', function (e) {
            formAdm.reset();
            btnAgregar.dataset.act = 0;
            formAdm.elements[2].disabled = false;
            formAdm.elements[3].disabled = false;
            $('#'+formAdm.elements[9].id).select2().trigger('change');
            document.getElementById("tituloModal").innerText = "Nuevo administrador";
            document.getElementById("comuna").innerHTML = "<option value=''> Seleccione una region </option>";
            document.getElementById("region").innerHTML = "<option value=''> Seleccione un pais </option>";
            document.getElementById("provincia").innerHTML = "<option value=''> Seleccione una provincia </option>";
            document.getElementById("errorMod").hidden = true;

        });
        
/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Comuna              */


        function traerProvincias(Region){
            if(Region != "" && Region != null && Region != undefined){
                $.ajax({
                    data:'action=traerProvincias&Region='+Region,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null && resp.length != 0){

                        Contenido += "<option value=''> Seleccione una provincia </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_provincia+"'>"+item.nombre+"</option>";
                        
                        });

                    }else{
                        Contenido = "<option value=''> No existen provincias </option>";

                    }
                    
                    document.getElementById("provincia").innerHTML = Contenido;

                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);

                });

            }else{
                document.getElementById("provincia").innerHTML = "<option value=''> Seleccione una region </option>";

            }

        }

        function traerComunas(Provincia){
            if(Provincia != "" && Provincia != null && Provincia != undefined){
                $.ajax({
                    data:'action=traerComunas&Provincia='+Provincia,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null && resp.length != 0){
    
                        Contenido += "<option value=''> Seleccione una comuna </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_comuna+"'>"+item.nombre+"</option>";
                        
                        });
    
                    }else{
                        Contenido = "<option value=''> No existen comunas </option>";
    
                    }
                    
                    document.getElementById("comuna").innerHTML = Contenido;
    
                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);
    
                });

            }else{
                document.getElementById("comuna").innerHTML = "<option value=''> Seleccione una region </option>";

            }

        }

        var selRegion = $("#region");

        selRegion.on('select2:select', function (e) {
            traerProvincias(e.target.value);
            traerComunas(0);

        });

        var selProvincia = $("#provincia");

        selProvincia.on('select2:select', function (e) {
            traerComunas(e.target.value);

        });

        function traerRegiones(Pais){
            if(Pais != "" && Pais != null && Pais != undefined){
                $.ajax({
                    data:'action=traerRegiones&Pais='+Pais,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null && resp.length != 0){
    
                        Contenido += "<option value=''> Seleccione una region </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_region+"'>"+item.nombre+"</option>";
                        
                        });
    
                    }else{
                        Contenido = "<option value=''> No existen regiones </option>";
    
                    }
                    
                    document.getElementById("region").innerHTML = Contenido;
    
                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);
    
                });

            }else{
                document.getElementById("region").innerHTML = "<option value=''> Seleccione un pais </option>";

            }

        }

        var selPais = $("#pais");

        selPais.on('select2:select', function (e) {
            traerRegiones(e.target.value);
            traerComunas(0);
            traerProvincias(0);

        });

/*              Fin de Comuna              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    selPais.select2();
    selRegion.select2();
    $("#comuna").select2();
    $("#provincia").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Tooltip              */

    $('[data-toggle="tooltip"]').tooltip();
    
/*              Fin de tooltip              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        let divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
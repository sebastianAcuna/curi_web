/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/usuarios.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FUser = document.getElementById("FUser1").value;
        var FRut = document.getElementById("FUser2").value;
        var FNom = document.getElementById("FUser3").value;
        var FEmail = document.getElementById("FUser4").value;
        var FTipo = document.getElementById("FUser5").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        // colspan dinamico
        var colspan = (puas == 5) ? 7 : 6;
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FUser='+FUser+'&FRut='+FRut+'&FNom='+FNom+'&FEmail='+FEmail+'&FTipo='+FTipo,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null && resp.length != 0){

                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.user)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            Contenido += "<td "+minText(item.email)+"</td>";
                            Contenido += "<td "+minText(item.descripcion)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-edi='"+item.id_usuario+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-edi='"+item.id_usuario+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen usuarios </td> </tr>";

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
        var FUser = document.getElementById("FUser1").value;
        var FRut = document.getElementById("FUser2").value;
        var FNom = document.getElementById("FUser3").value;
        var FEmail = document.getElementById("FUser4").value;
        var FTipo = document.getElementById("FUser5").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FUser='+FUser+'&FRut='+FRut+'&FNom='+FNom+'&FEmail='+FEmail+'&FTipo='+FTipo,
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

    function traerInfo(info){
        $.ajax({
            data:'action=traerInfo&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            if(resp != null){
                traerDestinatarios(resp.id_tu);

                formUser.elements[0].value = resp.email;
                formUser.elements[1].value = resp.user;

                if(mpoa == 0){
                    formUser.elements[2].value = "**************************";
                    formUser.elements[2].disabled = true;
                    formUser.elements[3].value = "**************************";
                    formUser.elements[3].disabled = true;

                }else{
                    formUser.elements[2].value = "-";
                    formUser.elements[3].value = "-";

                }

                formUser.elements[4].value = resp.id_tu;
                $('#'+formUser.elements[4].id).select2().trigger('change');
                formUser.elements[5].value = resp.enlazado;
                $('#'+formUser.elements[5].id).select2().trigger('change');
                formUser.elements[6].value = resp.rut;
                formUser.elements[7].value = resp.nombre;
                formUser.elements[8].value = resp.apellido_p;
                formUser.elements[9].value = resp.apellido_m;
                formUser.elements[10].value = resp.telefono;
                formUser.elements[11].value = resp.id_pais;
                $('#'+formUser.elements[11].id).select2().trigger('change');
                formUser.elements[12].value = resp.ciudad;
                formUser.elements[13].value = resp.direccion;

                btnAgregar.dataset.act = info;
                document.getElementById("tituloModal").innerText = "Editar usuario";
                $("#modalUser").modal('show');

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

    var tabla = document.getElementById("tablaUsuarios");
    
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
        if(name == "FUser"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FUser1":
                e.returnValue = keyValida(e,"L",e.target);
            break;
            case "FUser2":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FUser3":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FUser4":
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

        var formUser = document.getElementById("formUser");

        formUser.addEventListener('keypress', function(e) {
            document.getElementById("errorMod").hidden = true;
            var id = e.target.id;
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
                case "ciudad":
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

        function optionUser(act){
            var llenado = true;
            var valido = true;
            var pass = true;
            var campos = "";

            for (var i = 0; i < formUser.elements.length; i++){
                var value = formUser.elements[i].value.trim();
                var id = formUser.elements[i].id;
                var disabled = formUser.elements[i].disabled;

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }else{
                    if(id == "email" && !textValido("C",value)){
                        valido = false;
                        break;

                    }

                    if((id == "pass" || id == "verificarPass") && disabled == false && act > 0 && mpoa != 1){
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

                    if((id == "nombre" || id == "apellidoP" || id == "apellidoM" || id == "ciudad") && !textValido("LTE",value)){
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
                var action = "crearUsuario";
                var mnj = "creado"
                if(act > 0) action = "editarUsuario&act="+act, mnj = "actualizado";

                $.ajax({
                    data:'action='+action+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el usuario.", "success");

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
                    $("#modalUser").modal("hide");
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
            var act = 0
            if(e.target.dataset.act != undefined) act = e.target.dataset.act;
            optionUser(act);

        });

/*              Fin de crear/editar administrador              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalUser').on('hidden.bs.modal', function (e) {
            formUser.reset();
            btnAgregar.dataset.act = 0;
            formUser.elements[2].disabled = false;
            formUser.elements[3].disabled = false;
            document.getElementById("tituloModal").innerText = "Nuevo usuario";

            $('#'+formUser.elements[4].id).select2().trigger('change');
            formUser.elements[5].innerHTML = "<option value=''> Seleccione un destinatario </option>";
            $('#'+formUser.elements[11].id).select2().trigger('change');
            document.getElementById("errorMod").hidden = true;;
        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Traer destinatarios              */

        function traerDestinatarios(eleccion){
            $.ajax({
                data:'action=traerDestinatarios&eleccion='+eleccion,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var Contenido = "";
                
                if(resp != null){

                    Contenido += "<option value=''> Seleccione un destinatario </option>";
                        
                    $.each(resp,function(i,item){
                        Contenido +=  (eleccion == 1) ? "<option value='"+item.id_cli+"'>"+item.razon_social+"</option>" : "<option value='"+item.id_agric+"'>"+item.razon_social+"</option>";
                    
                    });

                }else{
                    Contenido = "<option value=''> No existen destinatarios </option>";

                }
                
                document.getElementById("destinatario").innerHTML = Contenido;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            });

        }

        var tipoDestinatario = $("#tipoDestinatario");

        tipoDestinatario.on('select2:select', function (e) {
            traerDestinatarios(e.target.value);

        });

/*              Fin de traer destinatarios              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    $("#tipoDestinatario").select2();
    $("#destinatario").select2();
    $("#pais").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Tooltip              */

    $('[data-toggle="tooltip"]').tooltip();
    
/*              Fin de tooltip              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
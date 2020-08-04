/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/supervisores.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FRut = document.getElementById("FSup1").value;
        var FNom = document.getElementById("FSup2").value;
        var FTel = document.getElementById("FSup3").value;
        var FEmail = document.getElementById("FSup4").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        // colspan dinamico
        var colspan = (puas == 5) ? 6 : 5;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FRut='+FRut+'&FNom='+FNom+'&FTel='+FTel+'&FEmail='+FEmail,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null){

                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            Contenido += "<td "+minText(item.telefono)+"</td>";
                            Contenido += "<td "+minText(item.email)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-edi='"+item.id_usuario+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-edi='"+item.id_usuario+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen supervisores </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });

    }

    function totalDatos(){
    
        //Datos de filtro
        var FRut = document.getElementById("FSup1").value;
        var FNom = document.getElementById("FSup2").value;
        var FTel = document.getElementById("FSup3").value;
        var FEmail = document.getElementById("FSup4").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FRut='+FRut+'&FNom='+FNom+'&FTel='+FTel+'&FEmail='+FEmail,
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
                btnAgregar.dataset.act = info;

                traerRegiones(resp[0].id_pais);
                traerComunas(resp[0].id_provincia);
                traerProvincias(resp[0].id_region);

                formSup.elements[0].value = resp[0].email;
                formSup.elements[1].value = resp[0].user;

                if(mpoa == 0){
                    formSup.elements[2].value = "**************************";
                    formSup.elements[2].disabled = true;
                    formSup.elements[3].value = "**************************";
                    formSup.elements[3].disabled = true;

                }else{
                    formSup.elements[2].value = "-";
                    formSup.elements[3].value = "-";

                }

                formSup.elements[4].value = resp[0].rut;
                formSup.elements[5].value = resp[0].nombre;
                formSup.elements[6].value = resp[0].apellido_p;
                formSup.elements[7].value = resp[0].apellido_m;
                formSup.elements[8].value = resp[0].telefono;
                formSup.elements[9].value = resp[0].id_pais;
                $('#'+formSup.elements[9].id).select2().trigger('change');

                formSup.elements[10].value = resp[0].id_region;
                $('#'+formSup.elements[10].id).select2().trigger('change');

                formSup.elements[11].value = resp[0].id_provincia;
                $('#'+formSup.elements[11].id).select2().trigger('change');

                formSup.elements[12].value = resp[0].id_comuna;
                $('#'+formSup.elements[12].id).select2().trigger('change');

                formSup.elements[13].value = resp[0].direccion;

                if(resp[0].supervisa_otro == "SI"){
                    formSup.elements[14].checked = true;
                    traerSupervisores();

                    var sel = formSup.elements[16];
                    for (let i = 0; i < sel.length; i++) {
                        $.each(resp[1],function(e,item){
                            if(sel[i].value == item.id_us_sup){
                                sel[i].selected = true;
    
                            };
                        });
                    }

                }else{
                    formSup.elements[15].checked = true;
                
                }

                document.getElementById("tituloModal").innerText = "Editar supervisor";
                $("#modalSup").modal('show');
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

    var tabla = document.getElementById("tablaSupervisores");
    
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
        if(name == "FSup"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FSup1":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FSup2":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FSup3":
                e.returnValue = keyValida(e,"F",e.target);
            break;
            case "FSup4":
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

        var formSup = document.getElementById("formSup");

        formSup.addEventListener('keypress', function(e) {
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
            var llenado = true;
            var valido = true;
            var pass = true;
            var campos = "";

            for (var i = 0; i < formSup.elements.length-3; i++){
                var value = formSup.elements[i].value.trim();
                var id = formSup.elements[i].id;
                var disabled = formSup.elements[i].disabled;

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

            var checked = "";
            var supervisar = document.getElementsByName("supervisar");
            for (var i = 0; i < supervisar.length; i++){
                var value = supervisar[i].value;

                if(supervisar[i].checked){
                    checked += "&campoS="+value;

                }

            }

            if(checked == ""){
                llenado = false;

            }else{
                campos += checked;

            }

            var supervisados = "";
            var selSupervisores = document.getElementById("selSupervisores");
            for(let i = 0; i < selSupervisores.length; i++){
                if(selSupervisores[i].selected){
                    supervisados += selSupervisores[i].value+",";

                }
            }
            campos += "&campoSup="+supervisados;

            if(document.getElementById("pass").value != document.getElementById("verificarPass").value){
                pass = false;

            }

            if(llenado && valido && pass){
                var action = "crearSupervisor";
                var mnj = "creado"
                if(act > 0) action = "editarSupervisor&act="+act, mnj = "actualizado";

                $.ajax({
                    data:'action='+action+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha "+mnj+" correctamente el supervisor.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ya existe un usuario que posee un rut, nombre de usuario o email igual a los ingresados.", "error");

                    }else if(resp == 3){
                        swal("Atencion!", "Verifique si sus datos ingresados no existen actualmente en el sistema, ya que debido a ellos no se efectuo ninguna acción.", "error");

                    }else if(resp == 11){
                        swal("Atencion!", "El usuario a sido creado, pero no se ha podido asignar correctamente a quien supervisa, debe volver a completar este campo.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalSup").modal("hide");
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
            optionAdm(act);

        });

/*              Fin de crear/editar administrador              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalSup').on('hidden.bs.modal', function (e) {
            formSup.reset();
            btnAgregar.dataset.act = 0;
            formSup.elements[2].disabled = false;
            formSup.elements[3].disabled = false;
            $('#'+formSup.elements[9].id).select2().trigger('change');
            document.getElementById("tituloModal").innerText = "Nuevo supervisor";
            document.getElementById("comuna").innerHTML = "<option value=''> Seleccione una provincia </option>";
            document.getElementById("region").innerHTML = "<option value=''> Seleccione un pais </option>";
            document.getElementById("provincia").innerHTML = "<option value=''> Seleccione una region </option>";
            document.getElementById("listaSupervisores").hidden = true;
            document.getElementById("selSupervisores").innerHTML = "";
            document.getElementById("errorMod").hidden = true;

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Comuna              */

        function traerComunas(provincia){
            if(provincia != "" && provincia != null && provincia != undefined){
                $.ajax({
                    data:'action=traerComunas&Provincia='+provincia,
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
                    
                    document.getElementById("comuna").innerHTML = Contenido;

                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);

                });

            }else{
                document.getElementById("comuna").innerHTML = "<option value=''> Seleccione una provincia </option>";

            }

        }


        function traerProvincias(Region){
            if(Region != "" && Region != null && Region != undefined){
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
                    
                    document.getElementById("provincia").innerHTML = Contenido;

                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);

                });

            }else{
                document.getElementById("provincia").innerHTML = "<option value=''> Seleccione una region </option>";

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
                    var Contenido = "";
                    
                    if(resp != null){
    
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
/*              Supervisores              */

        function traerSupervisores(){
            var Sup = btnAgregar.dataset.act;
            $.ajax({
                data:'action=traerSupervisores&Sup='+Sup,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                var contenido = "";
                
                if(resp != null){

                    $.each(resp,function(i,item){
                        contenido += "<option value='"+item.id_usuario+"'>"+item.nombre+"</option>";
                    });

                }else{
                    contenido = "<option value=''> No existen supervisores </option>";

                }

                document.getElementById("selSupervisores").innerHTML = contenido;

            }).fail(function( jqXHR, textStatus, responseText) {
                console.log(textStatus+" => "+responseText);

            }).always(function() {
                document.getElementById("listaSupervisores").hidden = false;
            
            });

        }

        var checkSup = document.getElementById("siS");

        checkSup.addEventListener("change", function(e){
            traerSupervisores();

        });

        var checkSup = document.getElementById("noS");

        checkSup.addEventListener("change", function(e){
            document.getElementById("listaSupervisores").hidden = true;
            document.getElementById("selSupervisores").innerHTML = "";

        });

/*              Fin de Supervisores              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    selPais.select2();
    selRegion.select2();
    selProvincia.select2();
    $("#comuna").select2();
    $("#selSupervisores").select2();
    $("#provincia").select2();
    
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
    
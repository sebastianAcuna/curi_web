/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDesIndex = "core/controllers/php/general.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    var btnCambiaPass = document.getElementById("cambiarPass");
    if(btnCambiaPass != null && btnCambiaPass  != undefined){
        btnCambiaPass.addEventListener("click", function(e){
            if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.edi != undefined) {
                var edi = e.target.dataset.edi;
                traerInfoPerfil(edi);

            }
                
        });

    }

    function traerInfoPerfil(info){
        $.ajax({
            data:'action=traerInfoPerfil&info='+info,
            url:urlDesIndex,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            
            if(resp != null){
                btnModPerfil.dataset.act = info;

                traerRegionesIndex(resp.id_pais);
                traerProvinciasIndex(resp.id_region);
                traerComunasIndex(resp.id_provincia);

                formIndex.elements[0].value = resp.email;
                formIndex.elements[1].value = resp.user;

                formIndex.elements[2].value = "-";
                formIndex.elements[3].value = "-";

                formIndex.elements[4].value = resp.rut;
                formIndex.elements[5].value = resp.nombre;
                formIndex.elements[6].value = resp.apellido_p;
                formIndex.elements[7].value = resp.apellido_m;
                formIndex.elements[8].value = resp.telefono;

                formIndex.elements[9].value = resp.id_pais;
                $('#'+formIndex.elements[9].id).select2().trigger('change');
                
                formIndex.elements[10].value = resp.id_region;
                $('#'+formIndex.elements[10].id).select2().trigger('change');

                formIndex.elements[11].value = resp.id_provincia;
                $('#'+formIndex.elements[11].id).select2().trigger('change');

                formIndex.elements[12].value = resp.id_comuna;
                $('#'+formIndex.elements[12].id).select2().trigger('change');

                formIndex.elements[13].value = resp.direccion;
                
                $("#modalCambia").modal('show');

            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

/*              Fin de traer datos              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas > 2){

/*==================================================================================================================================*/
/*              Evento key inputs formulario              */

        var formIndex = document.getElementById("formIndex");

        formIndex.addEventListener('keypress', function(e) {
            document.getElementById("errorModIndex").hidden = true;
            var id = e.target.id;
            switch(id){
                case "pass":
                case "verificarPass":
                    e.returnValue = keyValida(e,"LTNEx",e.target);
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
/*              Function editar perfil              */

        function ediPerfil(act){
            // Data del ajax
            let data = "";
            data = "action=ediPerfil&act="+act

            let llenado = true;
            let valido = true;
            let pass = true;

            for (let i = 0; i < formIndex.elements.length; i++){
                let value = formIndex.elements[i].value.trim();
                let id = formIndex.elements[i].id;

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }else{
                    if((id == "passIndex" || id == "verificarPassIndex") && !textValido("LTNEx",value)){
                        valido = false;
                        break;

                    }

                    if(id == "direccionIndex" && !textValido("LTNExE",value)){
                        valido = false;
                        break;

                    }

                    if(id == "telefonoIndex" && !textValido("F",value)){
                        valido = false;
                        break;

                    }

                }

                data += "&campo"+[i]+"="+value;

            }

            if(document.getElementById("passIndex").value != document.getElementById("verificarPassIndex").value){
                pass = false;

            }

            if(llenado && valido && pass){
                $.ajax({
                    data:data,
                    url:urlDesIndex,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha editado correctamente su perfil.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "No se ha podido editar correctamente su perfil, verifique que no ha repetido la información ya existen, si el error persiste, comuníquese con sistema.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalCambia").modal("hide");

                });

            }else if(!llenado){
                document.getElementById("errorModIndex").hidden = false;
                document.getElementById("errorMenjIndex").innerText = "Debe completar todos los campos requeridos.";

            }else if(!valido){
                document.getElementById("errorModIndex").hidden = false;
                document.getElementById("errorMenjIndex").innerText = "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).";

            }else if(!pass){
                document.getElementById("errorModIndex").hidden = false;
                document.getElementById("errorMenjIndex").innerText = "La contraseña y su verificacion no son iguales.";

            }

        }

/*              Fin de function editar perfil              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalCambia').on('hidden.bs.modal', function (e) {
            document.getElementById("errorModIndex").hidden = true;

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/
/*              Editar perfil              */

        var btnModPerfil = document.getElementById("optionModIndex");
        if(btnModPerfil != null && btnModPerfil  != undefined){
            btnModPerfil.addEventListener("click", function(e){
                if(e.target.dataset.act != undefined && e.target.dataset.act != ""){ 
                    act = e.target.dataset.act;
                    ediPerfil(act);

                }else{
                    swal("Atencion!", "No hemos detectado su perfil, por favor recargue la página o cierra el navegar y vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    $("#modalCambia").modal("hide");

                }
                    
            });
        }

/*              Fin de editar perfil              */
/*==================================================================================================================================*/
/*              Region / Provincia / Comuna              */

        function traerRegionesIndex(Pais){
            if(Pais != "" && Pais != null && Pais != undefined){
                $.ajax({
                    data:'action=traerRegiones&Pais='+Pais,
                    url: urlDesIndex,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null){
    
                        Contenido += "<option value=''> Seleccione una region </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_region+"'>"+item.nombre+"</option>";
                        
                        });
    
                    }else{
                        Contenido = "<option value=''> No existen regiones </option>";
    
                    }
                    
                    document.getElementById("regionIndex").innerHTML = Contenido;
    
                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);
    
                });

            }else{
                document.getElementById("regionIndex").innerHTML = "<option value=''> Seleccione un pais </option>";

            }

        }

        function traerProvinciasIndex(Region){
            if(Region != "" && Region != null && Region != undefined){
                $.ajax({
                    data:'action=traerProvincias&Region='+Region,
                    url: urlDesIndex,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null){

                        Contenido += "<option value=''> Seleccione una provincia </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_provincia+"'>"+item.nombre+"</option>";
                        
                        });

                    }else{
                        Contenido = "<option value=''> No existen provincias </option>";

                    }
                    
                    document.getElementById("provinciaIndex").innerHTML = Contenido;

                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);

                });

            }else{
                document.getElementById("provinciaIndex").innerHTML = "<option value=''> Seleccione una region </option>";

            }

        }

        function traerComunasIndex(provincia){
            if(provincia != "" && provincia != null && provincia != undefined){
                $.ajax({
                    data:'action=traerComunas&Provincia='+provincia,
                    url: urlDesIndex,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    let Contenido = "";
                    
                    if(resp != null){

                        Contenido += "<option value=''> Seleccione una comuna </option>";
                            
                        $.each(resp,function(i,item){
                            Contenido += "<option value='"+item.id_comuna+"'>"+item.nombre+"</option>";
                        
                        });

                    }else{
                        Contenido = "<option value=''> No existen comunas </option>";

                    }
                    
                    document.getElementById("comunaIndex").innerHTML = Contenido;

                }).fail(function( jqXHR, textStatus, responseText) {
                    console.log(textStatus+" => "+responseText);

                });

            }else{
                document.getElementById("comunaIndex").innerHTML = "<option value=''> Seleccione una provincia </option>";

            }

        }

        var selRegionIndex = $("#regionIndex");

        selRegionIndex.on('select2:select', function (e) {
            traerProvinciasIndex(e.target.value);
            traerComunasIndex(0);

        });

        var selProvinciaIndex = $("#provinciaIndex");

        selProvinciaIndex.on('select2:select', function (e) {
            traerComunasIndex(e.target.value);

        });

        var selPaisIndex = $("#paisIndex");

        selPaisIndex.on('select2:select', function (e) {
            traerRegionesIndex(e.target.value);
            traerComunasIndex(0);
            traerProvinciasIndex(0);

        });

/*              Fin de Region / Provincia / Comuna              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    selPaisIndex.select2();
    selRegionIndex.select2();
    selProvinciaIndex.select2();
    $("#comunaIndex").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
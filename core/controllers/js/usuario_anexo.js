/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/usuario_anexo.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){
        //Datos de filtro
        var FUser = document.getElementById("FUA1").value;
        var FRut = document.getElementById("FUA2").value;
        var FNom = document.getElementById("FUA3").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        // colspan dinamico
        var colspan = (puas == 5) ? 6 : 5;

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FUser='+FUser+'&FRut='+FRut+'&FNom='+FNom,
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
                            Contenido += "<td "+minText(item.cantidad)+"</td>";
                            if(puas == 5) Contenido += "<td class='fix-edi'><button type='button' class='btn btn-info' data-info='"+item.id_usuario+"' data-nom='"+item.nombre+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-pencil-alt' data-info='"+item.id_usuario+"' data-nom='"+item.nombre+"'></i> </button></td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen datos </td> </tr>";

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
        var FUser = document.getElementById("FUA1").value;
        var FRut = document.getElementById("FUA2").value;
        var FNom = document.getElementById("FUA3").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FUser='+FUser+'&FRut='+FRut+'&FNom='+FNom,
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

    function traerInfo(info,nombre){
        $.ajax({
            data:'action=traerInfo&info='+info,
            url: urlDes,
            type:'POST',
            dataType:'JSON'
        }).done(function(resp){
            
            if(resp != null && resp.length != 0){
                var Contenido = "";
                    
                $.each(resp,function(i,item){
                    Contenido += "<tr>";
                        Contenido += "<td>"+(i+1)+"</td>";
                        Contenido += "<td "+minText(item.num_anexo)+"</td>";
                        if(puas == 5) Contenido += "<td class='fix-edi'><button type='button' class='btn btn-danger' data-eli='"+item.id_ua+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-times' data-eli='"+item.id_ua+"'></i> </button></td>";
                    Contenido += "</tr>";
                });

            }else{
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen asignaciones </td> </tr>";

            }

            document.getElementById("datosAnexos").innerHTML = Contenido;
            document.getElementById("tituloModal").innerText = "Anexos asignados a "+nombre;
            $("#modalIA").modal('show');

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

    var tabla = document.getElementById("tablaUA");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.info != undefined) {
            var info = e.target.dataset.info;
            var nom = e.target.dataset.nom;
            traerInfo(info,nom);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);

            informacion();

        }
        
    });

    var tablaIA = document.getElementById("tablaIA");
    
    tablaIA.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.eli != undefined) {
            var eli = e.target.dataset.eli;
            eliminarUA(eli);

        }
        
    });
    
/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FUA"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FUA1":
                e.returnValue = keyValida(e,"L",e.target);
            break;
            case "FUA2":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FUA3":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

    if(puas == 5){

/*==================================================================================================================================*/
/*              Function crear asignacion              */

        function optionUA(){
            var llenado = true;
            var campos = "";

            for (var i = 0; i < formUA.elements.length; i++){
                var value = formUA.elements[i].value.trim();

                if(value.length == "" || value.length == 0){
                    llenado = false;
                    break;
                
                }

                campos += "&campo"+[i]+"="+value;

            }

            if(llenado){
                $.ajax({
                    data:'action=crearAsignacion'+campos,
                    url: urlDes,
                    type:'POST',
                    dataType:'JSON',
                    async: false
                }).done(function(resp){
                    if(resp == 1){
                        swal("Exito!", "Se ha creado correctamente la asignación.", "success");

                    }else if(resp == 2){
                        swal("Atencion!", "Ya existe una asignacion entre el usuario y el anexo elegidos.", "error");

                    }else{
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                    }

                }).fail(function( jqXHR, textStatus, responseText) {
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                    console.log(textStatus+" => "+responseText);

                }).always(function(){
                    $("#modalUA").modal("hide");
                    informacion();

                });

            }else{
                document.getElementById("errorMod").hidden = false;
                document.getElementById("errorMenj").innerText = "Debe completar todos los campos requeridos.";

            }

        }

/*              Fin de function crear asignacion              */
/*==================================================================================================================================*/
/*              Function crear asignacion              */

        function eliminarUA(eliminar){

            swal({
                title: "¿Estas seguro?",
                text: "Estas a punto de eliminar una asignación.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        data:'action=eliminarAsignacion&eliminar='+eliminar,
                        url: urlDes,
                        type:'POST',
                        dataType:'JSON',
                        async: false
                    }).done(function(resp){
                        if(resp == 1){
                            swal("Exito!", "Se ha eliminado correctamente la asignación.", "success");
            
                        }else{
                            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            
                        }
            
                    }).fail(function( jqXHR, textStatus, responseText) {
                        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                        console.log(textStatus+" => "+responseText);
            
                    }).always(function(){
                        informacion();
            
                    });
                }

            });

        }

/*              Fin de function crear asignacion              */
/*==================================================================================================================================*/
/*              Crear asignacion              */

        var btnAgregar = document.getElementById("optionMod");

        btnAgregar.addEventListener("click", function(e){
            optionUA();

        });

/*              Fin de crear asignacion              */
/*==================================================================================================================================*/
/*              Al cerrarse el modal              */

        $('#modalUA').on('hidden.bs.modal', function (e) {
            document.getElementById("errorMod").hidden = true;
            formUA.reset();
            $('#usuario').select2().trigger('change');
            $('#anexo').select2().trigger('change');

        });

/*              Fin de al cerrarse el modal              */
/*==================================================================================================================================*/

    }
    
/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Select2              */

    $("#usuario").select2();
    $("#anexo").select2();
    
/*              Fin de select2              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
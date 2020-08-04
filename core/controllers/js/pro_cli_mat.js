/*==================================================================================================================================*/
/*              Variables globales              */

var urlDes = "core/controllers/php/pro_cli_mat.php";

/*  DIV CONTENEDOR DE TABS */
var tab = document.getElementById("myTab");

/*  FORMULARIOS EN MODALES  */
var formTitulo = document.getElementById("formTitulo");
var formProp = document.getElementById("formProp");
var formRel = document.getElementById("formRel");

/*  BOTONES ACEPTAR EN MODAL  */
var btnModalTitulo = document.getElementById("optionModTit");
var btnModalPropiedades = document.getElementById("optionModProp");
var btnModalRelaciones = document.getElementById("optionModRelaciones");


/*  TABLAS CONTENEDORAS  */
var tablaTitulos = document.getElementById("tablaTitulos");
var tablaPropiedades = document.getElementById("tablaPropiedades");
var tablaRelaciones = document.getElementById("tablaRelacion");


/*  PAGINACION  */
var paginacion = document.getElementById("paginacion");

var arrayEspecies = new Array();
var checkboxes = document.getElementsByName("especiesAplica");


/*              Fin de variables globales              */
/*==================================================================================================================================*/



/*  SELECCIONA UNA PESTAÑA */
tab.addEventListener("click", function(e){
    if(e.target.nodeName == "A"){
        limpiarFiltros();
        var seleccion = e.target.id;
        switch(seleccion){
            case "titulo-tab":  informacionTitulos();  break;
            case "propiedades-tab": informacionPropiedades(); break;
            case "relacion-tab":  informacionRelacion();  break;
        }

    }
    
});




/*  TITULOS */
function informacionTitulos(){
    const promiseDatos = traerDatosTitulos(1);

    promiseDatos.then(
        result => totalDatosTitulos().then( result => paginador(), error => console.log(error)),
        error => console.log(error)
    ).finally(
        /* finaly => console.log() */    
    );
}

informacionTitulos();

function traerDatosTitulos(Page){
    // Data del ajax
    let data = "";
    data = "action=traerDatosTitulo";

    // Orden de datos
    let Orden = obtenerOrden();
    data += "&Orden="+Orden;

    // Ve que pagina es y trae los datos correspondientes a tal
    let Des = obtenerPagina(Page);
    data += "&D="+Des;

    // Filtros
    let filtros = document.getElementsByName("FTit");


    for (let i = 0; i < filtros.length; i++){
        let value = filtros[i].value.trim();
        data += "&campo"+[i]+"="+value;
    }

    // colspan dinamico
    var colspan = 5;

    return new Promise(function(resolve, reject) {

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON'
        }).done(function(resp){
            var Contenido = "";

            if(resp != null){
                $.each(resp,function(i,item){   
                    Contenido += "<tr>";
                        Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                        Contenido += "<td" +minText(item.nombre_es)+"</td>";
                        Contenido += "<td "+minText(item.nombre_en)+"</td>";
                        Contenido += "<td "+minText(item.es_lista)+"</td>";

                        if(puas == 5) {
                            Contenido += "<td class='fix-edi' style='min-width:100px !important'>";
                            Contenido += "<button type='button' class='btn btn-info' data-edi='"+item.id_prop+"' style='margin: 0 5px; padding:.1rem .3rem' title='Editar Propiedad'> <i class='fas fa-pencil-alt' data-edi='"+item.id_prop+"' title='Editar Propiedad'></i> </button>";
                            Contenido += "<button type='button' class='btn btn-danger' data-eli='"+item.id_prop+"' style='margin: 0; padding:.1rem .3rem' title='ELiminar Propiedad'> <i class='fas fa-times' data-eli='"+item.id_prop+"' title='ELiminar Propiedad'></i> </button>";
                            
                            Contenido += "</td>";
                        }
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen registros </td> </tr>";

            }

            document.getElementById("datosTitulos").innerHTML = Contenido;

            resolve();

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datosTitulos").innerHTML = Contenido;

            reject(textStatus+" => "+responseText);

        });

    });

}

function totalDatosTitulos(){
    // Data del ajax
    let data = "";
    data = "action=totalDatosTitulos";

    // Filtros
    let filtros = document.getElementsByName("FTit");

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

/* CREAR / ACTUALIZAR TITULOS  */
function optionUpdTitulo(act){
    var llenado = true;
    var valido = true;
    var action = "crearTitulo";
    var mnj = "creado"

    if(act > 0) action = "editarTitulo"; mnj = "actualizado";

    var frmData = new FormData;

    frmData.append("action", action);
    frmData.append("act", act);

    for (var i = 0; i < formTitulo.elements.length; i++){
        var value = formTitulo.elements[i].value.trim();
        var id = formTitulo.elements[i].id;
        if(value.length == "" || value.length == 0){
            llenado = false;
            break;
        }
        else{
            if((id == "mTitulo1" || id == "mTitulo2" || id == "mTitulo3") && !textValido("LTNExE",value)){
                valido = false;
                break;
            }
            if(id == "mTitulo1" && id == "mTitulo2" && id == "mTitulo3" && !textValido("ND",value)){
                valido = false;
                break;
            }
        }

        frmData.append("campo"+[i], value);

    }

    if(llenado && valido){
    
        $.ajax({
            data: frmData,
            url: urlDes,
            type:'POST',
            processData: false,
            contentType: false,
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp == 1){
                swal("Exito!", "Se ha "+mnj+" correctamente el titulo.", "success");
            }else{
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);

        }).always(function(){
            $("#modalTit").modal("hide");
            informacionTitulos();

        });

    }else if(!llenado){
        swal("ATENCION!", "Debe completar todos los campos requeridos.", "warning");
    }else{
        swal("ATENCION!", "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).", "error");
    }

}


function traerInfoTitulo(info){
    $.ajax({
        data:'action=traerInfoTitulo&info='+info,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){

            

            formTitulo.elements[0].value = resp[0].nombre_es;
            formTitulo.elements[1].value = resp[0].nombre_en;
            formTitulo.elements[2].value = resp[0].es_lista;
            $('#'+formTitulo.elements[2].id).select2().trigger('change');
            
            btnModalTitulo.dataset.act = info;
            btnModalTitulo.innerText  = "Editar Titulo";
            document.getElementById("tituloModal").innerHTML = "Editar Titulo";
            $("#modalTit").modal('show');

        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });

}

/* Rechazar */

function eliminarTitulo(rechazar){

    swal({
        title: "¿Estas seguro?",
        text: "Estas a punto de eliminar este titulo, si esta asociado en alguna relación, no se podra elminar.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                data:'action=eliminarTitulo&rechazar='+rechazar,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 1){
                    swal("Exito!", "Se eliminado el titulo correctamente.", "success");
                }else if (resp == 2){
                    swal("Hey!", "Este titulo se esta ocupando en una(s) relacion(es), no se podra eliminar.", "error");
                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                }
    
            }).fail(function( jqXHR, textStatus, responseText) {
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                console.log(textStatus+" => "+responseText);
            }).always(function(){
                informacionTitulos();
    
            });
        }

    });

}




btnModalTitulo.addEventListener("click", function(e){
    var act = 0
    if(e.target.dataset.act != undefined) act = e.target.dataset.act;
    optionUpdTitulo(act);
});

/*  FIN TITULOS  */

/*  PROPIEDADES  */


function informacionPropiedades(){
    const promiseDatos = traerDatosPropiedades(1);

    promiseDatos.then(
        result => totalDatosPropiedades().then( result => paginador(), error => console.log(error)),
        error => console.log(error)

    ).finally(
        /* finaly => console.log() */
        
    );
}

function traerDatosPropiedades(Page){
    // Data del ajax
    let data = "";
    data = "action=traerDatosPropiedades";

    // Orden de datos
    let Orden = obtenerOrden();
    data += "&Orden="+Orden;

    // Ve que pagina es y trae los datos correspondientes a tal
    let Des = obtenerPagina(Page);
    data += "&D="+Des;

    // Filtros
    let filtros = document.getElementsByName("FProp");


    for (let i = 0; i < filtros.length; i++){
        let value = filtros[i].value.trim();
        data += "&campo"+[i]+"="+value;
    }

    // colspan dinamico
    var colspan = 4;

    return new Promise(function(resolve, reject) {

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON'
        }).done(function(resp){
            var Contenido = "";

            if(resp != null){
                $.each(resp,function(i,item){   
                    Contenido += "<tr>";
                        Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                        Contenido += "<td" +minText(item.nombre_es)+"</td>";
                        Contenido += "<td "+minText(item.nombre_en)+"</td>";

                        if(puas == 5) {
                            Contenido += "<td class='fix-edi' style='min-width:100px !important'>";
                            Contenido += "<button type='button' class='btn btn-info' data-edi='"+item.id_sub_propiedad+"' style='margin: 0 5px; padding:.1rem .3rem' title='Editar Propiedad'> <i class='fas fa-pencil-alt' data-edi='"+item.id_sub_propiedad+"' title='Editar Propiedad'></i> </button>";
                            Contenido += "<button type='button' class='btn btn-danger' data-eli='"+item.id_sub_propiedad+"' style='margin: 0; padding:.1rem .3rem' title='ELiminar Propiedad'> <i class='fas fa-times' data-eli='"+item.id_sub_propiedad+"' title='ELiminar Propiedad'></i> </button>";
                            
                            Contenido += "</td>";
                        }
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen registros </td> </tr>";

            }

            document.getElementById("datosPropiedades").innerHTML = Contenido;

            resolve();

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datosPropiedades").innerHTML = Contenido;

            reject(textStatus+" => "+responseText);

        });

    });

}

function totalDatosPropiedades(){
    // Data del ajax
    let data = "";
    data = "action=totalDatosPropiedades";

    // Filtros
    let filtros = document.getElementsByName("FProp");

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


/* CREAR / ACTUALIZAR PROPIEDADES  */
function optionUpdPropiedades(act){
    var llenado = true;
    var valido = true;
    var action = "crearPropiedad";
    var mnj = "creado"

    if(act > 0) action = "editarPropiedad"; mnj = "actualizado";

    var frmData = new FormData;

    frmData.append("action", action);
    frmData.append("act", act);

    for (var i = 0; i < formProp.elements.length; i++){
        var value = formProp.elements[i].value.trim();
        var id = formProp.elements[i].id;
        if(value.length == "" || value.length == 0){
            llenado = false;
            break;
        }
        else{
            if((id == "mProp1" || id == "mProp2") && !textValido("LTNExE",value)){
                valido = false;
                break;
            }
            if(id == "mProp1" && id == "mProp2" && !textValido("ND",value)){
                valido = false;
                break;
            }
        }

        frmData.append("campo"+[i], value);

    }

    if(llenado && valido){
    
        $.ajax({
            data: frmData,
            url: urlDes,
            type:'POST',
            processData: false,
            contentType: false,
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp == 1){
                swal("Exito!", "Se ha "+mnj+" correctamente la propiedad.", "success");
            }else{
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);

        }).always(function(){
            $("#modalProp").modal("hide");
            informacionPropiedades();
        });

    }else if(!llenado){
        swal("ATENCION!", "Debe completar todos los campos requeridos.", "warning");
    }else{
        swal("ATENCION!", "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).", "error");
    }

}

function traerInfoPropiedad(info){
    $.ajax({
        data:'action=traerInfoPropiedad&info='+info,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){

            formProp.elements[0].value = resp[0].nombre_es;
            formProp.elements[1].value = resp[0].nombre_en;
            
            btnModalPropiedades.dataset.act = info;
            btnModalPropiedades.innerText  = "Editar Propiedad";
            document.getElementById("tituloModalProp").innerHTML = "Editar Propiedad";
            $("#modalProp").modal('show');

        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });

}

function traerInfoPropiedad(info){
    $.ajax({
        data:'action=traerInfoPropiedad&info='+info,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){

            formProp.elements[0].value = resp[0].nombre_es;
            formProp.elements[1].value = resp[0].nombre_en;
           
         
            btnModalPropiedades.dataset.act = info;
            btnModalPropiedades.innerText  = "Editar Propiedad";
            document.getElementById("tituloModalProp").innerHTML = "Editar Propiedad";
            $("#modalProp").modal('show');

        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });

}

function eliminarPropiedad(rechazar){

    swal({
        title: "¿Estas seguro?",
        text: "Estas a punto de eliminar esta propiedad, si esta asociado en alguna relación, no se podra eliminar.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                data:'action=eliminarPropiedad&rechazar='+rechazar,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 1){
                    swal("Exito!", "Se eliminado la propiedad correctamente.", "success");
                }else if (resp == 2){
                    swal("Hey!", "Esta propiedad se esta ocupando en una(s) relacion(es), no se podra eliminar.", "error");
                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                }
    
            }).fail(function( jqXHR, textStatus, responseText) {
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                console.log(textStatus+" => "+responseText);
            }).always(function(){
                informacionPropiedades();
    
            });
        }

    });

}


btnModalPropiedades.addEventListener("click", function(e){
    var act = 0
    if(e.target.dataset.act != undefined) act = e.target.dataset.act;
    optionUpdPropiedades(act);
});

/*  FIN PROPIEDADES */



/*  RELACIONES  */
function informacionRelacion(){
    const promiseDatos = traerDatosRelacion(1);

    promiseDatos.then(
        result => totalDatosRelacion().then( result => paginador(), error => console.log(error)),
        error => console.log(error)

    ).finally(
        /* finaly => console.log() */
        
    );
}




function traerDatosRelacion(Page){
    // Data del ajax
    let data = "";
    data = "action=traerDatosRelacion";

    // Orden de datos
    let Orden = obtenerOrden();
    data += "&Orden="+Orden;

    // Ve que pagina es y trae los datos correspondientes a tal
    let Des = obtenerPagina(Page);
    data += "&D="+Des;

    // Filtros
    let filtros = document.getElementsByName("FRel");


    for (let i = 0; i < filtros.length; i++){
        let value = filtros[i].value.trim();
        data += "&campo"+[i]+"="+value;
    }

    // colspan dinamico
    var colspan = 8;

    return new Promise(function(resolve, reject) {

        $.ajax({
            data:data,
            url:urlDes,
            type:'POST',
            dataType:'JSON'
        }).done(function(resp){
            var Contenido = "";

            if(resp != null){
                $.each(resp,function(i,item){   
                    Contenido += "<tr>";
                        Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                        Contenido += "<td" +minText(item.especie)+"</td>";
                        Contenido += "<td "+minText(item.etapa)+"</td>";
                        Contenido += "<td "+minText(item.temporada)+"</td>";
                        Contenido += "<td "+minText(item.titulo)+"</td>";
                        Contenido += "<td "+minText(item.propiedad)+"</td>";
                        Contenido += "<td "+minText(item.aplica)+"</td>";

                        if(puas == 5) {
                            Contenido += "<td class='fix-edi' style='min-width:100px !important'>";
                            Contenido += "<button type='button' class='btn btn-info' data-tempo='"+item.id_tempo+"' data-prop='"+item.id_sub_propiedad+"' data-edi='"+item.id_prop_mat_cli+"' style='margin: 0 5px; padding:.1rem .3rem' title='Editar Propiedad'> <i class='fas fa-pencil-alt' data-tempo='"+item.id_tempo+"' data-prop='"+item.id_sub_propiedad+"' data-edi='"+item.id_prop_mat_cli+"' title='Editar Propiedad'></i> </button>";
                            Contenido += "<button type='button' class='btn btn-danger' data-eli='"+item.id_prop_mat_cli+"' style='margin: 0; padding:.1rem .3rem' title='ELiminar Propiedad'> <i class='fas fa-times' data-eli='"+item.id_prop_mat_cli+"' title='ELiminar Propiedad'></i> </button>";
                            
                            Contenido += "</td>";
                        }
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> No existen registros </td> </tr>";

            }

            document.getElementById("datosRelaciones").innerHTML = Contenido;

            resolve();

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='"+colspan+"' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datosRelaciones").innerHTML = Contenido;

            reject(textStatus+" => "+responseText);

        });

    });

}


function totalDatosRelacion(){
    // Data del ajax
    let data = "";
    data = "action=totalDatosRelacion";

    // Filtros
    let filtros = document.getElementsByName("FRel");

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

function traerInfoRelacion(info, propiedad, temporada){
    $.ajax({
        data:'action=traerInfoRelacion&info='+info+'&propiedad='+propiedad+'&temporada='+temporada,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp[0] != null){

            // formRel.elements[0].value = resp[0].nombre_es;
            // formRel.elements[1].value = resp[0].nombre_en;

            formRel.elements[0].value = resp[0][0].id_etapa;
            $('#'+formRel.elements[0].id).select2().trigger('change');

            if(resp[0][0].id_etapa == "1"){
                document.getElementById("contenedor_titulo").classList.add("ocultar");
            }else{
                document.getElementById("contenedor_titulo").classList.remove("ocultar");
            }

            traerTituloSelect(resp[0][0].id_prop);
            formRel.elements[1].value = resp[0][0].id_prop;
            $('#'+formRel.elements[1].id).select2().trigger('change');
            
            traerPropiedadesSelect(resp[0][0].id_sub_propiedad);

            formRel.elements[2].value = resp[0][0].id_sub_propiedad;
            $('#'+formRel.elements[2].id).select2().trigger('change');

            formRel.elements[3].value = resp[0][0].id_tempo;
            $('#'+formRel.elements[3].id).select2().trigger('change');

            formRel.elements[0].value = resp[0][0].id_etapa;
            $('#'+formRel.elements[0].id).select2().trigger('change');


            formRel.elements[4].value = resp[0][0].ingresa;
            $('#'+formRel.elements[4].id).select2().trigger('change');

            if(resp[0][0].tipo_campo != null){

                

                // console.log(resp[0][0].tipo_campo);
                switch(resp[0][0].tipo_campo){
                    case 'RECYCLER_GENERICO_DATE':
                        resp[0][0].tipo_campo = 'DATE';
                        break;
                    case 'RECYCLER_GENERICO_STRING':
                        resp[0][0].tipo_campo = 'TEXT';
                        break;
                    case 'RECYCLER_GENERICO_INT':
                        resp[0][0].tipo_campo = 'INT';
                        break;
                    case 'RECYCLER_GENERICO_TEXTVIEW':
                        resp[0][0].tipo_campo = 'TEXTVIEW';
                        document.getElementById("contenedor_donde").classList.remove("ocultar");
                        document.getElementById("contenedor_informacion").classList.remove("ocultar");
                        break;
                    case 'TEXTVIEW':
                        document.getElementById("contenedor_donde").classList.remove("ocultar");
                        document.getElementById("contenedor_informacion").classList.remove("ocultar");
                        break;
                    case 'RECYCLER_GENERICO_DECIMAL':
                        resp[0][0].tipo_campo = 'DECIMAL';
                        break;
                    default:
                        resp[0][0].tipo_campo = resp[0][0].tipo_campo;
                        break;
                }
            }

            formRel.elements[5].value = resp[0][0].tipo_campo;
            $('#'+formRel.elements[5].id).select2().trigger('change');

            formRel.elements[6].value = resp[0][0].nombre_real_tabla;
            $('#'+formRel.elements[6].id).select2().trigger('change');

            traerPCMCampos(resp[0][0].nombre_real_tabla, resp[0][0].nombre_real_campo);

            formRel.elements[8].value = resp[0][0].reporte_cliente;
            $('#'+formRel.elements[8].id).select2().trigger('change');

            formRel.elements[9].value = resp[0][0].especial;
            $('#'+formRel.elements[9].id).select2().trigger('change');
            
            // formRel.elements[10].value = resp[0][0].id_orden;
            // $('#'+formRel.elements[10].id).select2().trigger('change');

            cargarTitulosDespuesDe(resp[0][0].id_prop);


            cargarDespuesDe(resp[0][0].id_orden);
            formRel.elements[11].value = resp[0][0].id_orden;

            traerEspeciesCheck(0);


            if(checkboxes != null && checkboxes != undefined){
                checkboxes.forEach((el) => {
                    if(resp[1] != null){
                        resp[1].forEach((xx) => {
                            if(el.id == xx.id_esp){
                                el.checked = true;
                                if(arrayEspecies.indexOf(el.id) == -1){
                                    if(el.id == resp[0][0].id_esp){
                                        arrayEspecies.push(el.id);
                                    }
                                }
                            }
                        });
                    }

                    el.disabled = true;
                    if(el.id == resp[0][0].id_esp){
                        el.disabled = false;
                    }
                });
            }
       
            btnModalRelaciones.dataset.act = info;
            btnModalRelaciones.innerText  = "Editar Propiedad";
            document.getElementById("tituloModalRel").innerHTML = "Editar Relacion";
            $("#modalRel").modal('show');

        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });

}

function eliminarRelacion(rechazar){

    swal({
        title: "¿Estas seguro?",
        text: "Estas a punto de eliminar esta relación.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                data:'action=eliminarRelacion&rechazar='+rechazar,
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 1){
                    swal("Exito!", "Se eliminado la relacion correctamente.", "success");
                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                }
    
            }).fail(function( jqXHR, textStatus, responseText) {
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                console.log(textStatus+" => "+responseText);
            }).always(function(){
                informacionRelacion();
    
            });
        }

    });

}


function nombreCampoModals(id_campo){

    switch(id_campo){

        case 'mRel1':
            return "Titulo";
        case 'mRel2':
            return "Propiedad";
        case 'mRel3':
            return "Temporada";
        case 'mRel4':
            return "Etapa";
        case 'mRel5':
            return "Quien Ingresa";
        case 'mRel6':
            return "Tipo de dato";
        case 'mRel9':
            return "Aparece en reporte cliente";
        case 'mRel10':
            return "Especial SYNGENTA";
        case 'mRel11':
            return "ordenado despues de";
        case 'mRel7':
            return "De donde";
        case 'mRel8':
            return "Que informacion";

    }
}


function optionUpdRelaciones(act){
    var llenado = true;
    var valido = true;
    var action = "crearRelacion";
    var mnj = "creado"

    if(act > 0) action = "editarRelacion"; mnj = "actualizado";

    var frmData = new FormData;

    frmData.append("action", action);
    frmData.append("act", act);

    for (var i = 0; i < formRel.elements.length; i++){
        var value = formRel.elements[i].value.trim();
        var id = formRel.elements[i].id;

        var comprobando = (id == "mRel5" && value == "SAP");
        mensajeVacio = ""


        if((id == "mRel2"  || id == "mRel3" || id == "mRel4" || id == "mRel5" || id == "mRel6" || id == "mRel9" || id == "mRel10" || id == "mRel11") && (value.length == "" || value.length == 0) ){
            llenado = false;
            mensajeVacio += " "+nombreCampoModals(id)+" ";
            break;
            
        }else if(comprobando && (id == "mRel7" || id == "mRel8") && (value.length == "" || value.length == 0)){
            mensajeVacio += " "+nombreCampoModals(id)+" ";
            llenado = false;
            break;
        }else{
            if((id == "mRel2"  || id == "mRel3" || id == "mRel4" || id == "mRel5" || id == "mRel6" || id == "mRel9" || id == "mRel10" || id == "mRel11") && !textValido("LTNExE",value)){
                valido = false;
                break;
            }
            
            if(id == "mRel2"  && id == "mRel3" && id == "mRel4" && id == "mRel5" && id == "mRel6" && id == "mRel9" && id == "mRel10" && id == "mRel11" && !textValido("ND",value)){
                valido = false;
                break;
            }

        }
        
        frmData.append("campo"+[i], value);
    }

    let checks = new Array();

    if(checkboxes != null && checkboxes != undefined){
        checkboxes.forEach((el) => {
            let checked = el.checked;
            let disabled = el.disabled;

            if(checked && disabled != true){
                checks.push(el.id);

            }

        });
    }
        
    if(checks.length > 0){
        frmData.append("especies", JSON.stringify(checks));
    }

    if(llenado && valido){
    
        $.ajax({
            data: frmData,
            url: urlDes,
            type:'POST',
            processData: false,
            contentType: false,
            dataType:'JSON',
            async: false,
            beforeSend: function() {
                if(act <= 0) $("#modalCarga").modal('show');
            },
            
            complete: function() {
                if(act <= 0) $("#modalCarga").modal('hide');
            },
        }).done(function(resp){

            $("#modalCarga").modal('hide');

            if(resp == 1){
                $("#modalCarga").modal('hide');
                swal("Exito!", "Se ha "+mnj+" correctamente la relación.", "success");
            }else{
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            $("#modalCarga").modal('hide');
            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);

        }).always(function(){
            $("#modalCarga").modal('hide');
            $("#modalRel").modal("hide");
            informacionRelacion();
        });

    }else if(!llenado){
        $("#modalCarga").modal('hide');
        swal("ATENCION!", "Debe completar todos los campos requeridos.( "+ mensajeVacio + " ) ", "warning");
    }else{
        $("#modalCarga").modal('hide');
        swal("ATENCION!", "Debe completar todos los campos de forma correcta, sin caracteres invalidos (Ej: !'#$%&/{}) y como corresponde que se debe llenar cada campo (Ej: rut -> 9.999.999-9).", "error");
    }
}


function cargarDespuesDe(id_orden){
    var etapa =  (document.getElementById("mRel4") != null) ? document.getElementById("mRel4").value : null;
    var titulo =  (document.getElementById("mRel12") != null) ? document.getElementById("mRel12").value : null;
    var propiedad =  (document.getElementById("mRel2") != null) ? document.getElementById("mRel2").value : null;
    var temporada =  (document.getElementById("mRel3") != null) ? document.getElementById("mRel3").value : null;

    if((etapa != null && etapa != '') && (propiedad != null && propiedad != '')  && (temporada != null && temporada != '') ){
        titulo = (etapa > 1) ? titulo : 0;

        var enviar = `etapa=${etapa}&titulo=${titulo}&propiedad=${propiedad}&temporada=${temporada}`;

        $.ajax({
            data:'action=cargarDespuesDe&'+enviar,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null){
                Contenido = "";
                Contenido += "<option value=''> Seleccione... </option>";
                            
                $.each(resp,function(i,item){
                    Contenido += "<option title='"+item.nombre_en+"' value='"+item.orden+"'";
                    Contenido += (id_orden == item.orden) ? "selected":"";
                    Contenido += ">"+item.nombre_es+"</option>";
                });
    
                document.getElementById("contenedor_despues").classList.remove("ocultar");
                document.getElementById("mRel11").innerHTML = Contenido;
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            document.getElementById("contenedor_despues").classList.add("ocultar");
            // swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);
        }).always(function(){

        });

    }else{
        document.getElementById("contenedor_despues").classList.add("ocultar");
    }
 }


 function cargarTitulosDespuesDe(id_prop){
    var etapa =  (document.getElementById("mRel4") != null) ? document.getElementById("mRel4").value : null;
    var temporada =  (document.getElementById("mRel3") != null) ? document.getElementById("mRel3").value : null;

    if((etapa != null && etapa != '') && (temporada != null && temporada != '') ){
        var enviar = `etapa=${etapa}&temporada=${temporada}`;

        $.ajax({
            data:'action=cargarTitulosDespuesDe&'+enviar,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            // console.log(resp);
            if(resp != null){
                Contenido = "";
                Contenido += "<option value=''> Seleccione... </option>";
                            
                $.each(resp,function(i,item){
                    Contenido += "<option title='"+item.nombre_en+"' value='"+item.id_prop+"'";
                    Contenido += (id_prop == item.id_prop) ? "selected":"";
                    Contenido += ">"+item.nombre_es+"</option>";
                });
    
                document.getElementById("contenedor_despues_titulo").classList.remove("ocultar");
                document.getElementById("mRel12").innerHTML = Contenido;
            }

        }).fail(function( jqXHR, textStatus, responseText) {

            document.getElementById("contenedor_despues_titulo").classList.add("ocultar");
            // swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
            console.log(textStatus+" => "+responseText);
        }).always(function(){

        });

    }else{
        // console.log("("+etapa+"!= null && "+etapa+" != '') && ("+temporada+" != null && "+temporada+" != '')" );
        document.getElementById("contenedor_despues_titulo").classList.add("ocultar");
    }

 }


/* SELECT ETAPA  */
$('#mRel4').on("select2:select", function(e) { 
    let options = ``;
    options += `<option value=""> seleccione...</option>`;
    switch(e.target.value){
        case "1":
            document.getElementById("contenedor_titulo").classList.add("ocultar");
            options += `<option value="TEXTVIEW">Solo Se muestra</option>`;
        break;
        default:
            cargarTitulosDespuesDe();
            cargarDespuesDe();
            document.getElementById("contenedor_titulo").classList.remove("ocultar");
            options += `<option value="TEXTVIEW">Solo se muestra</option> 
            <option value="TEXT">Texto Alfanumerico</option> 
            <option value="INT">Numerico entero</option> 
            <option value="DECIMAL">Numerico decimal</option> 
            <option value="CHECK">check</option> 
            <option value="DATE">fecha</option> `;
        break;
    }
    
    document.getElementById("mRel6").innerHTML = options;

 });

 /* SELECT PROPIEDAD  */
$('#mRel2').on("select2:select",function(e) {
    cargarTitulosDespuesDe();
    cargarDespuesDe();
});
// $('#mRel2').on("select2:select",  (e) => cargarDespuesDe() );
$('#mRel12').on("select2:select",  (e) => cargarDespuesDe() );

 /* SELECT TEMPORADA  */
$('#mRel3').on("select2:select",function(e) {
    cargarTitulosDespuesDe();
    cargarDespuesDe();
});




$('#mRel5').on("select2:select", function(e) { 
    let options = ``;
    options += `<option value=""> seleccione...</option>`;
    switch(e.target.value){
        case "SAP":
            options += `<option value="TEXTVIEW">Solo Se muestra</option>`;
            // document.getElementById("contenedor_donde").classList.remove("ocultar");
            // document.getElementById("contenedor_informacion").classList.remove("ocultar");
        break;
        default:
            document.getElementById("contenedor_donde").classList.add("ocultar");
            document.getElementById("contenedor_informacion").classList.add("ocultar");
            options += `<option value="TEXTVIEW">Solo se muestra</option> 
            <option value="TEXT">Texto Alfanumerico</option> 
            <option value="INT">Numerico entero</option> 
            <option value="DECIMAL">Numerico decimal</option> 
            <option value="CHECK">check</option> 
            <option value="DATE">fecha</option> `;
          
        break;
    }
    document.getElementById("mRel6").innerHTML = options;
 });

$('#mRel6').on("select2:select", function(e) { 
    switch(e.target.value){
        case "TEXTVIEW":
            document.getElementById("contenedor_donde").classList.remove("ocultar");
            document.getElementById("contenedor_informacion").classList.remove("ocultar");
        break;
        default:
            document.getElementById("contenedor_donde").classList.add("ocultar");
            document.getElementById("contenedor_informacion").classList.add("ocultar");
        break;
    }
 });



btnModalRelaciones.addEventListener("click", function(e){
    var act = 0
    if(e.target.dataset.act != undefined) act = e.target.dataset.act;
    optionUpdRelaciones(act);
});

/*  FIN RELACIONES  */


function ejecutarOrden(e){

    if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.edi != undefined) {
        var edi = e.target.dataset.edi;
            var active = document.getElementsByClassName("nav-link active")[0].id;
            switch(active){
                case "titulo-tab":
                    traerInfoTitulo(edi);
                break;
                case "propiedades-tab":
                    traerInfoPropiedad(edi);
                    // traerInfoProvisoria(edi);
                break;
                case "relacion-tab":

                    var prop = e.target.dataset.prop;
                    var tempo = e.target.dataset.tempo;

                    arrayEspecies = new Array();
                    traerInfoRelacion(edi, prop, tempo);
                    // traerInfoRe(edi);
                    // traerInfoProvisoria(edi);
                break;

            }

    }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.eli != undefined) {
        var eli = e.target.dataset.eli;
        var active = document.getElementsByClassName("nav-link active")[0].id;
        switch(active){
            case "titulo-tab":
                eliminarTitulo(eli);
            break;

            case "propiedades-tab":
                eliminarPropiedad(eli);
            break;
            case "relacion-tab":
                eliminarRelacion(eli);
                // traerInfoProvisoria(edi);
            break;

        }
    }else if(e.target && e.target.nodeName == "I") {
        activarOrden(e.target);
        
        var active = document.getElementsByClassName("nav-link active")[0].id;

        switch(active){

            case "titulo-tab":
                informacionTitulos();
            break;

            case "propiedades-tab":
                informacionPropiedades();
            break;
            case "relacion-tab":
                arrayEspecies =  new Array();
                informacionRelacion();
                // traerInfoProvisoria(edi);
            break;

        }

    }
}


tablaTitulos.addEventListener("click", function(e){
    ejecutarOrden(e);
});

tablaTitulos.addEventListener('change', function(e) {
    var name = e.target.name;
    if(name == "FTit"){
        informacionTitulos();
    }
});


tablaPropiedades.addEventListener("click", function(e){
    ejecutarOrden(e);
});

tablaPropiedades.addEventListener('change', function(e) {
    var name = e.target.name;
    if(name == "FProp"){
        informacionPropiedades();
    }
});

tablaRelaciones.addEventListener("click", function(e){
    ejecutarOrden(e);
});

tablaRelaciones.addEventListener('change', function(e) {
    var name = e.target.name;
    console.log(name);
    if(name == "FRel"){
        informacionRelacion();
    }
});

$('#FRel1').on("select2:select", function(e) {  informacionRelacion(); });
$('#FRel2').on("select2:select", function(e) {  informacionRelacion(); });
$('#FRel3').on("select2:select", function(e) {  informacionRelacion(); });
$('#FRel6').on("select2:select", function(e) {  informacionRelacion(); });


$('#mRel7').on("select2:select", function(e) { traerPCMCampos(e.target.value, ""); });


function traerPropiedadesSelect(setSelected){
    $.ajax({
        data:'action=traerPropiedadesSelect',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        if(resp != null){
            Contenido = "";
            Contenido += "<option value=''> Seleccione... </option>";
                        
            $.each(resp,function(i,item){
                Contenido += "<option title='"+item.nombre_en+"' value='"+item.id_sub_propiedad+"'";
                if(setSelected > 0 && setSelected == item.id_sub_propiedad){  Contenido += " selected "; }
                Contenido += " >"+item.nombre_es+"</option>";
            });

            document.getElementById("mRel2").innerHTML = Contenido;
        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });
}

function traerTituloSelect(setSelected){
    $.ajax({
        data:'action=traerTituloSelect',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){
            // console.log(resp);
            Contenido = "";

            Contenido += "<option value=''> Seleccione... </option>";
                        
            $.each(resp,function(i,item){
                Contenido += "<option title='"+item.nombre_en+"' value='"+item.id_prop+"'";
                if(setSelected > 0 && setSelected == item.id_prop){
                    Contenido += " selected ";
                }
                Contenido += " >"+item.nombre_es+"</option>";
            
            });

            document.getElementById("mRel1").innerHTML = Contenido;
        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });
}

function traerEspeciesCheck(setSelected){
    $.ajax({
        data:'action=traerEspeciesCheck',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){
            // console.log(resp);
            Contenido = ``;
           
            
            $.each(resp,function(i,item){

                let nombreMayus = item.nombre.toUpperCase();
                Contenido += `<div class="col-lg-2 col-sm-6">`;
                Contenido += `<div style="display:flex; justify-content:flex-start; align-items:center;">`;

                Contenido += `<input type="checkbox" style="margin-right:0.5em;" name="especiesAplica" id="${ item.id_esp }" `;
                if(setSelected > 0){
                    switch(item.id_esp){
                        case 3:
                        case 7:
                        case 8:
                        case 13:
                        case 20:
                        case 23:
                        case 35:
                        case 37:
                            // console.log("checked");
                            if(arrayEspecies.indexOf(item.id_esp) == -1){
                                arrayEspecies.push(item.id_esp);
                            }
                            Contenido += " checked ";
                        break;
                    }
                }
                
                Contenido += ` >`;
                Contenido += `<label  for="${ item.id_esp }" > ${ nombreMayus} </label>`;


                Contenido += `</div>`;
                Contenido += `</div>`;
            });

            

            document.getElementById("contenedor_especies_check").innerHTML = Contenido;
        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });
}

function traerPCMCampos(value, setSelected){
    console.log(setSelected);
    $.ajax({
        data:'action=traerPCMCampos&value='+value,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false,
    }).done(function(resp){
        
        if(resp != null){
            // console.log(resp);
            Contenido = "";

            Contenido += "<option value=''> Seleccione desde donde </option>";
                        
            $.each(resp,function(i,item){
                Contenido += "<option title='"+item.descripcion+"' value='"+item.nombre_real+"'";
                if(setSelected != "" && setSelected == item.nombre_real){
                    Contenido += " selected ";
                }
                Contenido += " >"+item.nombre_vista+"</option>";
            
            });

            document.getElementById("mRel8").innerHTML = Contenido;
        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);
    });
}



if(checkboxes != null && checkboxes != undefined){
    // console.log(checkboxes);
    checkboxes.forEach((el) => {
        el.addEventListener('click', function(e){
            if(e.target.checked){
                // console.log("true");
                if(arrayEspecies.indexOf(e.target.id) == -1){
                    arrayEspecies.push(e.target.id);
                }
            }else{
                // console.log("false");
                if(arrayEspecies.indexOf(e.target.id) > -1){
                    arrayEspecies.splice(arrayEspecies.indexOf(e.target.id), 1);
                }
            }
        });
    });
}


/*  RESETEAR MODALS  */
$('#modalTit').on('hidden.bs.modal', function (e) {
    formTitulo.reset();
    btnModalTitulo.dataset.act = 0;
    btnModalTitulo.dataset.opc = 0;
    document.getElementById("tituloModal").innerText = "Nuevo Titulo";
    
    $("#mTitulo3").select2().trigger('change');
});

$('#modalProp').on('hidden.bs.modal', function (e) {
    formProp.reset();
    btnModalPropiedades.dataset.act = 0;
    btnModalPropiedades.dataset.opc = 0;
    document.getElementById("tituloModalProp").innerText = "Nueva Propiedad";

    $("#mTitulo3").select2().trigger('change');
    
});

$('#modalRel').on('hidden.bs.modal', function (e) {
    formRel.reset();
    btnModalRelaciones.dataset.act = 0;
    btnModalRelaciones.dataset.opc = 0;
    document.getElementById("tituloModalRel").innerText = "Nueva Relación";
    btnModalRelaciones.innerText = "Agregar";

    arrayEspecies = new Array();

    if(checkboxes != null && checkboxes != undefined){
        checkboxes.forEach((el) => {
            el.disabled = false;
        });
    }
    
    document.getElementById("contenedor_donde").classList.add("ocultar");
    document.getElementById("contenedor_informacion").classList.add("ocultar");

    $("#mRel1").select2().trigger('change');
    $("#mRel2").select2().trigger('change');
    $("#mRel3").select2().trigger('change');
    $("#mRel4").select2().trigger('change');
    $("#mRel5").select2().trigger('change');
    $("#mRel6").select2().trigger('change');
    $("#mRel7").select2().trigger('change');
    $("#mRel8").select2().trigger('change');
    $("#mRel9").select2().trigger('change');
    $("#mRel10").select2().trigger('change');
    $("#mRel11").select2().trigger('change');
    $("#mRel12").select2().trigger('change');

    $("#modalCarga").modal('hide');
    
});

$('#modalRel').on('shown.bs.modal', function (e) {

    // console.log(btnModalRelaciones.dataset.act);
    if(btnModalRelaciones.dataset.act == undefined || btnModalRelaciones.dataset.act  <= 0){
        traerPropiedadesSelect(0);
        traerTituloSelect(0);
        traerEspeciesCheck(1);
    }

    
   
    document.getElementById("tituloModalRel").innerText = "Nueva Relación";
    
});

/*  PAGINACION  */

paginacion.addEventListener("click", function(e){
    if(e.target && e.target.nodeName == "BUTTON" ) {
        var pagina = e.target.dataset.page;
        var tab = document.getElementById("myTab").children;

        for(var i = 0; i < tab.length; i++){
            if(i == 0 && tab[i].children[0].classList.contains("active")){
                traerDatosTitulos(pagina);
                paginador();

            }else if(i == 1 && tab[i].children[0].classList.contains("active")){
                traerDatosPropiedades(pagina);
                paginador();
            }else{
                traerDatosRelacion(pagina);
                paginador();
            }
        }
    }
});

/*  END PAGINACION  */


 /* RELACION */
 $("#FRel1").select2();
 $("#FRel2").select2();
 $("#FRel3").select2();
 $("#FRel6").select2();
 $("#FRel7").select2();

 $("#mRel1").select2();
 $("#mRel2").select2();
 $("#mRel3").select2();
 $("#mRel4").select2();
 $("#mRel5").select2();
 $("#mRel6").select2();
 $("#mRel7").select2();
 $("#mRel8").select2();
 $("#mRel9").select2();
 $("#mRel10").select2();
 $("#mRel11").select2();
 $("#mRel12").select2();


 /* TITULO  */
 $("#mTitulo3").select2();


function limpiarFiltros(){
    var FTit = document.getElementsByName("FTit");
    var FProp = document.getElementsByName("FProp");
    var FRel = document.getElementsByName("FRel");

    FTit.forEach( function(element) { 
        element.value = "";

    });
    FProp.forEach( function(element) { 
        element.value = "";
    });

    FRel.forEach( function(element) { 
        element.value = "";
    });

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

$(function() {
    var divCarga = document.getElementById("divCargaGeneral");
    divCarga.style.display = "none";

});
/*==================================================================================================================================*/
/*              Variables globales              */

var urlDes = "core/controllers/php/fichas.php";

var arrayImagenes = new Array();

var tablaActivas = document.getElementById("tablaActivas");

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Limpiar filtros              */

function limpiarFiltros(){
    var FFichA = document.getElementsByName("FFichA");

    FFichA.forEach( function(element) { 
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


/*              Fin de limpiar filtros              */
/*==================================================================================================================================*/
/*              Agregar imagen              */

/* ACTIVADA  */

var agregarimagenNew = document.getElementById("imagenNew");

agregarimagenNew.addEventListener("change", function(ex){
    // console.log(ex.target.files[0]);
    // var act = 0
    // if(ex.target.dataset.act != undefined) act = ex.target.dataset.act;
    if(ex.target && ex.target.nodeName == 'INPUT'){

        // switch
        // console.log(ex.target.files[0].type);
        switch(ex.target.files[0].type){
            case 'image/png':
            case 'image/jpeg':
            case 'image/jpg':
                if(!arrayImagenes.includes(ex.target.files[0])){
                    arrayImagenes.push(ex.target.files[0]);
                    
                }
                break;
            default:
                swal("Ops!", "Solo puede subir imagenes a el prospecto", "error");
                ex.target.value = "";
                break;
        
        }

        

        mostrarImagenesNew(arrayImagenes);
    }

});

function limpiarImagenesNew(){
    var div  = document.getElementById("contenedorImagenesNew");
    div.innerHTML = '';
    var div  = document.getElementById("galeria");
    div.innerHTML = '';
}

function mostrarImagenesNew(arrayDeImagenes){

    var div  = document.getElementById("contenedorImagenesNew");

    div.innerHTML = '';

    var divContPlus = document.createElement('div');
    divContPlus.setAttribute('style', 'display:flex;flex-direction:row;');

    divContPlus.innerHTML = '';
    if(arrayDeImagenes != null && arrayDeImagenes.length > 0){
        for(let i = 0; i < arrayDeImagenes.length; i++){
        
            var reader = new FileReader();
            reader.onload = function(e){


                var divcon = document.createElement('div');
                divcon.setAttribute('style', 'display:flex;flex-direction:column;');


                var filePreview = document.createElement('img');
                filePreview.id = 'file-preview';
                filePreview.setAttribute('style', 'height:120px;width:120px;')
                //e.target.result contents the base64 data from the image uploaded
                filePreview.src = e.target.result;
                var previewZone = document.getElementById('contenedorImagenesNew');

                var imgClose = document.createElement('i');
                imgClose.setAttribute('class', 'fas fa-window-close text-danger fa-2x');
                imgClose.setAttribute('style', 'cursor:pointer;');

                imgClose.addEventListener('click', function(){

                        var e = arrayDeImagenes.indexOf( arrayDeImagenes[i] );
                        arrayDeImagenes.splice( e, 1);

                        mostrarImagenesNew(arrayDeImagenes);
                })


                divcon.appendChild(imgClose);
                divcon.appendChild(filePreview);

                divContPlus.appendChild(divcon);

                previewZone.appendChild(divContPlus);
            }

            reader.readAsDataURL(arrayDeImagenes[i]);
        }
    }
    
    document.getElementById("errorModI").hidden = true;
}

/* FIN ACTIVADA  */

/*              Fin de agregar imagen              */
/*==================================================================================================================================*/
/*              Traer datos              */

function traerDatosActivas(Page){
    // Data del ajax
    var data = "";
    data = "action=traerDatosActivas";

    // Orden de datos
    var Orden = obtenerOrden();
    data += "&Orden="+Orden;

    // Ve que pagina es y trae los datos correspondientes a tal
    var Des = obtenerPagina(Page);
    data += "&D="+Des;

    // Temporada de operacion
    var Temporada = document.getElementById("selectTemporada").value;
    data += "&Temporada="+Temporada;

    // Filtros
    var filtros = document.getElementsByName("FFichA");

    for (let i = 0; i < filtros.length; i++){
        var value = filtros[i].value.trim();

        
        data += "&campo"+[i]+"="+value;
    }

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
                    var rotacion = (item.rotacion != null) ? item.rotacion.split(",") : "";
                    var coor = (item.coo_utm_amFich != null) ? item.coo_utm_amFich.split(" ") : "";
                    Contenido += "<tr>";
                        Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                        Contenido += "<td>"+((item.fielbook != null) ? 'Posee fieldbook' : 'No posee fielbook')+"</td>";
                        Contenido += "<td "+minText(item.fieldman)+"</td>";
                        Contenido += "<td "+minText(item.temporada)+"</td>";
                        Contenido += "<td "+minText(item.especie)+"</td>";
                        Contenido += "<td "+minText(item.razon_social)+"</td>";
                        Contenido += "<td "+minText(item.rut)+"</td>";
                        Contenido += "<td "+minText(item.telefono)+"</td>";
                        Contenido += "<td "+minText(item.nombre_ac)+"</td>";
                        Contenido += "<td "+minText(item.telefono_ac)+"</td>";
                        Contenido += "<td "+minText(item.oferta_de_negocio)+"</td>";
                        Contenido += "<td "+minText(item.localidad)+"</td>";
                        Contenido += "<td "+minText(item.region)+"</td>";
                        Contenido += "<td "+minText(item.comuna)+"</td>";
                        Contenido += "<td "+minText(item.ha_disponibles)+"</td>";
                        Contenido += "<td "+minText(item.direccion)+"</td>";
                        Contenido += "<td "+minText(item.rep_legal)+"</td>";
                        Contenido += "<td "+minText(item.rut_rl)+"</td>";
                        Contenido += "<td "+minText(item.telefono_rl)+"</td>";
                        Contenido += "<td "+minText(item.email_rl)+"</td>";
                        Contenido += "<td "+minText(item.banco)+"</td>";
                        Contenido += "<td "+minText(item.cuenta_corriente)+"</td>";
                        Contenido += "<td "+minText(item.predio)+"</td>";
                        Contenido += "<td "+minText(item.potrero)+"</td>";
                        Contenido += "<td style='min-width:200px'>";
                        if(rotacion[0] && rotacion[0].length > 8) Contenido += "<div>"+rotacion[0]+"</div>";
                        if(rotacion[1] && rotacion[1].length > 8) Contenido += "<div>"+rotacion[1]+"</div>";
                        if(rotacion[2] && rotacion[2].length > 8) Contenido += "<div>"+rotacion[2]+"</div>";
                        if(rotacion[3] && rotacion[3].length > 8) Contenido += "<div>"+rotacion[3]+"</div>";
                        Contenido += "</td>";
                        Contenido += "<td>"+sinInformacion(coor[0])+"</td>";
                        Contenido += "<td>"+sinInformacion(coor[1])+"</td>";
                        Contenido += "<td "+minText(item.radio)+"</td>";
                        Contenido += "<td "+minText(item.suelo)+"</td>";
                        Contenido += "<td "+minText(item.riego)+"</td>";
                        Contenido += "<td "+minText(item.experiencia)+"</td>";
                        Contenido += "<td "+minText(item.tenencia)+"</td>";
                        Contenido += "<td "+minText(item.maquinaria)+"</td>";
                        Contenido += "<td "+minText(item.maleza)+"</td>";
                        Contenido += "<td "+minText(item.estado_general)+"</td>";
                        Contenido += "<td "+minText(item.obs)+"</td>";
                        Contenido += "<td "+minText(item.num_anexo)+"</td>";
                        Contenido += "<td "+minText(item.id_ficha)+"</td>";
                        Contenido += "<td class='fix-edi' align='center' style='min-width:110px !important'>";
                        // Contenido += "<div style='display:flex; flex-direction:column; align-items:center;justify-content:space-between;'>";
                        Contenido += "<button type='button' class='btn btn-danger' data-pdf='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-file-pdf' data-pdf='"+item.id_ficha+"'></i> </button>";
                        Contenido += "<button type='button' class='btn btn-info' data-images='"+item.id_ficha+"' style='margin: 0 5px; padding:.1rem .3rem'> <i class='fas fa-images' data-images='"+item.id_ficha+"'></i> </button>";
                        Contenido += "<button type='button' class='btn btn-success' data-info='"+item.id_ficha+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-search' data-info='"+item.id_ficha+"'></i> </button>";
                        // Contenido += "</div>";
                        Contenido += "</td>";
                    Contenido += "</tr>";

                });

            }else{
                Contenido = "<tr> <td colspan='39' style='text-align:center'> No existen registros </td> </tr>";

            }

            document.getElementById("datosActivas").innerHTML = Contenido;

            resolve();

        }).fail(function( jqXHR, textStatus, responseText) {
            Contenido = "<tr> <td colspan='39' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
            
            document.getElementById("datosActivas").innerHTML = Contenido;

            reject(textStatus+" => "+responseText);

        });

    });

}

function totalDatosActivas(){
    // Data del ajax
    var data = "";
    data = "action=totalDatosActivas";

    // Temporada de operacion
    var Temporada = document.getElementById("selectTemporada").value;
    data += "&Temporada="+Temporada;

    // Filtros
    var filtros = document.getElementsByName("FFichA");

    for (let i = 0; i < filtros.length; i++){
        var value = filtros[i].value.trim();

        
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

/* Edit */

function traerInfoActiva(info){
    $.ajax({
        data:'action=traerInfoActiva&info='+info,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        if(resp != null){

            document.getElementById("FichI1").innerText = "Activa";
            document.getElementById("FichI2").innerText = sinInformacion(resp[0].supervisor);
            document.getElementById("FichI3").innerText = sinInformacion(resp[0].temporada);
            document.getElementById("FichI4").innerText = sinInformacion(resp[0].agricultor);
            document.getElementById("FichI5").innerText = sinInformacion(resp[0].localidad);
            document.getElementById("FichI6").innerText = sinInformacion(resp[0].predio);
            document.getElementById("FichI7").innerText = sinInformacion(resp[0].lote);
            document.getElementById("FichI8").innerText = sinInformacion(resp[0].ha_disponibles);
            document.getElementById("FichI9").innerText = sinInformacion(resp[0].especie);
            document.getElementById("FichI10").innerText = sinInformacion(resp[0].tenencia);
            document.getElementById("FichI11").innerText = sinInformacion(resp[0].maquinaria);
            document.getElementById("FichI12").innerText = sinInformacion(resp[0].experiencia);
            document.getElementById("FichI13").innerText = sinInformacion(resp[0].oferta_de_negocio);
            document.getElementById("FichI14").innerText = sinInformacion(resp[0].suelo);
            document.getElementById("FichI15").innerText = sinInformacion(resp[0].riego);
            document.getElementById("FichI16").innerText = sinInformacion(resp[0].maleza);
            document.getElementById("FichI17").innerText = sinInformacion(resp[0].estado_general);
            document.getElementById("FichI18").innerText = sinInformacion(resp[0].obs);

            let cont = 22;
            let fecha = new Date();
            for(let e = 1; e < 5; e++){
                let anno = fecha.getFullYear()-e;

                $.each(resp[1],function(i,item){
        
                    if(item.anno == anno){
                        document.getElementById("FichI"+cont--).innerText = sinInformacion(item.descripcion);

                    }
    
                });
                
            }
            

            $("#modalInfo").modal('show');

        }

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);

    });

}

function eliminarimagen(info){
    // console.log("click en delete");

    $.ajax({
        data:'action=eliminarImagen&info='+info,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){
        // console.log(resp);
        switch(resp){
            case 1:
                // console.log("entro aca");
                var dd = document.getElementById("container_"+info);
                dd.remove();
                break;
        }

    });

}

/*              Fin traer datos              */
/*==================================================================================================================================*/
/*              Traer informacion              */

function informacionActivas() { 
    const promiseDatos = traerDatosActivas(1);

    promiseDatos.then(
        result => totalDatosActivas().then( result => paginador(), error => console.log(error)),
        error => console.log(error)

    ).finally(
        /* finaly => console.log() */
        
    );

}

informacionActivas();

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Ejecutar paginacion              */

var paginacion = document.getElementById("paginacion");
    
paginacion.addEventListener("click", function(e){
    if(e.target && e.target.nodeName == "BUTTON" ) {
        var pagina = e.target.dataset.page;
        traerDatosActivas(pagina);
        paginador();

    }

});

/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Ejecutar eventos de la tabla               */

function ejecutarOrden(e){
    if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.info != undefined) {
        var info = e.target.dataset.info;
        traerInfoActiva(info);

    }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.images != undefined) {
        var info = e.target.dataset.images;
        arrayImagenes = new Array();
        limpiarImagenesNew();
        traerImagenes(info);

    }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.pdf != undefined) {
        var pdf = e.target.dataset.pdf;
        descargaPdf(e,pdf);

    }else if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.eli != undefined) {
        var eli = e.target.dataset.eli;
        rechazarFicha(eli);

    }else if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
        verMas(e.target,1);

    }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
        verMas(e.target,2);

    }else if(e.target && e.target.nodeName == "I") {
        activarOrden(e.target);
        informacionActivas();

    }

}

tablaActivas.addEventListener("click", function(e){
    ejecutarOrden(e);
    
});

/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

tablaActivas.addEventListener('change', function(e) {
    var name = e.target.name;
    if(name == "FFichA"){
        informacionActivas();

    }
    
});

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

tablaActivas.addEventListener('keypress', function(e) {
    var id = e.target.id;
    switch(id){
        case "FFichA1":
        case "FFichA2":
        case "FFichA4":
        case "FFichA5":
        case "FFichA8":
        case "FFichA10":
        case "FFichA11":
        case "FFichA12":
        case "FFichA13":
        case "FFichA15":
        case "FFichA16":
        case "FFichA20":
        case "FFichA22":
        case "FFichA23":
        case "FFichA24":
        case "FFichA28":
        case "FFichA29":
        case "FFichA30":
        case "FFichA31":
        case "FFichA32":
        case "FFichA33":
        case "FFichA34":
        case "FFichA35":
        case "FFichA36":
            e.returnValue = keyValida(e,"LTNExE",e.target);
        break;
        case "FFichA3":
        case "FFichA7":
        case "FFichA9":
        case "FFichA14":
        case "FFichA18":
        case "FFichA21":
            e.returnValue = keyValida(e,"F",e.target);
        break;
        case "FFichA6":
        case "FFichA17":
            e.returnValue = keyValida(e,"R",e.target);
        break;
        case "FFichA14":
        case "FFichA25":
        case "FFichA26":
        case "FFichA27":
            e.returnValue = keyValida(e,"ND",e.target);
        break;
        case "FFichA19":
            e.returnValue = keyValida(e,"C",e.target);
        break;
        case "FFichA37":
            e.returnValue = keyValida(e,"N",e.target);
        break;

    }
    
});

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Requiere permisos              */

if(puas == 5){

/*==================================================================================================================================*/
/*              Subir img en ficha activada              */

    function subirImagen(act){
        var datos = false;
        var action = "subirImagen";

        var frmData = new FormData;

        frmData.append("action", action);
        frmData.append("act", act);

        if(arrayImagenes.length > 0){
            for(let v = 0; v < arrayImagenes.length; v++){
                frmData.append('imagen['+v+']', arrayImagenes[v]);

            }

            frmData.append('cantidad_imagenes', arrayImagenes.length);

            datos = true;
        }

        if(datos){

            $.ajax({
                data: frmData,
                url: urlDes,
                type:'POST',
                processData: false,
                contentType: false,
                // dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp == 1){
                    swal("Exito!", "Se han subido correctamente las imagenes.", "success");

                }else if(resp == 2){
                    swal("Atencion!", "No se han podido subir las imagenes", "error");

                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

                }

            }).fail(function( jqXHR, textStatus, responseText) {
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
                console.log(textStatus+" => "+responseText);

            }).always(function(){
                $("#modalImages").modal("hide");
                informacionActivas();

            });

        }else{
            document.getElementById("errorModI").hidden = false;
            document.getElementById("errorMenjI").innerText = "No estas subiendo ninguna imagen.";

        }

    }

    var btnSubirImg = document.getElementById("subirIMG");

    btnSubirImg.addEventListener("click", function(e){
        var act = e.target.dataset.act;
        if(act != undefined) subirImagen(act);

    });

/*              Fin subir img en ficha activada              */
/*==================================================================================================================================*/
    
}

/*              Fin de requerir permisos              */
/*==================================================================================================================================*/
/*              Descargar excel              */

function descargaExcel(e){
    e.preventDefault();

    var filtros = "";
    
    //Orden de datos
    var Orden = (obtenerOrden() > 0) ? obtenerOrden() : 0;

    // Temporada de operacion
    var Temporada = document.getElementById("selectTemporada").value;

    // Pestaña activa
    activa = 1;
    filtros = document.getElementsByName("FFichA");

    var campos = "?Temporada="+Temporada+"&Orden="+Orden+"&Ficha="+activa;

    for(let i = 0; i < filtros.length; i++){
        if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
            campos += "&"+filtros[i].id+"="+filtros[i].value;

        }

    }

    let form = document.getElementById('formExport');
    form.action = "docs/excel/fichas.php"+campos;
    form.submit();

}

document.getElementById("descExcel").addEventListener('click', function(e) {
    descargaExcel(e);

});

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Descargar pdf              */

function descargaPdf(e,ficha){
    e.preventDefault();

    let form = document.getElementById('formExport');
    form.action = "docs/pdf/ficha.php?Ficha="+ficha;
    form.setAttribute("target", "_blank");
    form.submit();

}

/*              Fin de descargar pdf              */
/*==================================================================================================================================*/
/*              Div de espera              */

$(function() {
    var divCarga = document.getElementById("divCargaGeneral");
    divCarga.style.display = "none";

});

/*              Fin de div de espera              */
/*==================================================================================================================================*/


/*  11-06-2020 Sebastian Acuña modifica */
/*==================================================================================================================================*/
/* Imagenes */

function traerImagenes(Ficha){

    // console.log(Ficha);
    $.ajax({
        data:'action=traerImagenes&Ficha='+Ficha,
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        beforeSend: function() {
            $("#modalCarga").modal('show');
        },
        complete: function() {
            $("#modalCarga").modal('hide');
        },
    }).done(function(resp){
        var contenido = "";

        if(resp != null && resp.length > 0){
            if(puas != 5){
                document.getElementById("formIMG").style.display = "none";
                $.each(resp,function(i,item){
                    contenido += "<a href='data:image/jpeg;base64,"+item.ruta_foto+"' data-lightbox='mygallery'> <img src='data:image/jpeg;base64,"+item.ruta_foto+"'> </a>";

                });

            }else{
                document.getElementById("formIMG").style.display = "";
                btnSubirImg.dataset.act = Ficha;

                contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                contenido+= "<hr>"; 
                contenido+= "<div style='display:flex;flex-direction:row;'>";
                $.each(resp,function(i,item){
                    contenido+= "<div style='display:flex;flex-direction:column;' id='container_"+item.id_foto+"'>";
                        contenido += "<i style='cursor:pointer;' class='fas fa-window-close text-danger fa-2x' onclick='eliminarimagen("+item.id_foto+");'></i>";
                        contenido += "<img src='data:image/jpeg;base64,"+item.ruta_foto+"' style='height:120px;width:120px;'>";
                    contenido+= "</div>";
                });
                contenido+= "</div>";

            }

        }else{
            if(puas != 5){
                contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                contenido+= "<hr>"; 
                contenido+= "<h3> No existen imagenes </h3>";

            }else{
                document.getElementById("formIMG").style.display = "";
                btnSubirImg.dataset.act = Ficha;

                contenido+= "<h1 class='title'> Imagenes agregadas </h1>";
                contenido+= "<hr>"; 
                contenido+= "<h3> No existen imagenes </h3>";

            }

        }

        document.getElementById("galeria").innerHTML = contenido;
    
        $("#modalImages").modal('show');
        
    })

}

$("#modalImages").on('shown.bs.modal', function () {
    $("#modalCarga").modal('hide');
    
});

/*==================================================================================================================================*/
/*              Select2              */

    /* FILTROS */
    $("#FFichA4").select2();        
    $("#FFichA4").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA12").select2();        
    $("#FFichA12").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA13").select2();        
    $("#FFichA13").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA28").select2();        
    $("#FFichA28").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA29").select2();        
    $("#FFichA29").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA30").select2();        
    $("#FFichA30").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA31").select2();        
    $("#FFichA31").on('select2:select', function (e) {
        informacionActivas();

    });
    $("#FFichA32").select2();        
    $("#FFichA32").on('select2:select', function (e) {
        informacionActivas();

    });
    
/*              Fin de select2              */
/*==================================================================================================================================*/
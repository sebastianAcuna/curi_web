/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/export.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Limpiar filtros              */

    function limpiarFiltros(){
        var FPla = document.getElementsByName("FPla");
        // var FRec = document.getElementsByName("FRec");

        FPla.forEach( function(element) { 
            element.value = "";

        });

        // FRec.forEach( function(element) { 
        //     element.value = "";

        // });

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
/*              Traer datos              */

    function traerDatosPlanta(Page){

        let filtros = document.getElementsByName("FPla");


        let data = "";

        //Orden de datos
        var Orden = obtenerOrden();
        data += "&Orden="+Orden;


        // Ve que pagina es y trae los datos correspondientes a tal
        let Des = obtenerPagina(Page);
        data += "&D="+Des;

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;


        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatosPlanta'+data,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null && resp.length != 0){
                    
                    $.each(resp,function(i,item){
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.nombre_especie)+"</td>";
                            Contenido += "<td "+minText(item.nombre_cliente)+"</td>";
                            Contenido += "<td "+minText(item.nombre_material)+"</td>";
                            Contenido += "<td "+minText(item.num_anexo)+"</td>";
                            Contenido += "<td "+minText(item.lote_cliente)+"</td>";
                            Contenido += "<td "+minText(item.nombre_agricultor)+"</td>";
                            Contenido += "<td "+minText(separador(item.hectareas))+"</td>";
                            Contenido += "<td "+minText(item.fin_lote)+"</td>";
                            Contenido += "<td "+minText(separador(item.kgs_recepcionado))+"</td>";
                            Contenido += "<td "+minText(separador(item.kgs_limpios))+"</td>";
                            Contenido += "<td "+minText(separador(item.kgs_exportados))+"</td>";
                        Contenido += "</tr>";

                    });

                }else{
                    Contenido = "<tr> <td colspan='13' style='text-align:center'> No existe resultado para la planta </td> </tr>";

                }

                document.getElementById("datosPlanta").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='13' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datosPlanta").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatosPlanta(){
    
        let filtros = document.getElementsByName("FPla");


        let data = "";

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;


        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatosPlanta'+data,
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



    // function traerDatosRecepcion(Page){

    //     let filtros = document.getElementsByName("FRec");


    //     let data = "";

    //     //Orden de datos
    //     var Orden = obtenerOrden();
    //     data += "&Orden="+Orden;


    //     // Ve que pagina es y trae los datos correspondientes a tal
    //     let Des = obtenerPagina(Page);
    //     data += "&D="+Des;

    //     // Temporada de operacion
    //     var Temporada = document.getElementById("selectTemporada").value;
    //     data += "&Temporada="+Temporada;


    //     for (let i = 0; i < filtros.length; i++){
    //         let value = filtros[i].value.trim();

            
    //         data += "&campo"+[i]+"="+value;
    //     }

    //     return new Promise(function(resolve, reject) {

    //         $.ajax({
    //             data:'action=traerDatosRecepcion'+data,
    //             url: urlDes,
    //             type:'POST',
    //             dataType:'JSON'
    //         }).done(function(resp){
    //             var Contenido = "";

    //             if(resp != null &&  resp.length != 0){
                    
    //                 $.each(resp,function(i,item){   
    //                     Contenido += "<tr>";
    //                         Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
    //                         Contenido += "<td "+minText(item.nombre_especie)+"</td>";
    //                         Contenido += "<td "+minText(item.nombre_material)+"</td>";
    //                         Contenido += "<td "+minText(item.num_anexo)+"</td>";
    //                         Contenido += "<td "+minText(item.nombre_agricultor)+"</td>";
    //                         Contenido += "<td "+minText(item.rut)+"</td>";
    //                         Contenido += "<td "+minText(item.lote_campo)+"</td>";
    //                         Contenido += "<td "+minText(item.numero_guia)+"</td>";
    //                         Contenido += "<td "+minText(separador(item.peso_bruto))+"</td>";
    //                         Contenido += "<td "+minText(separador(item.tara))+"</td>";
    //                         Contenido += "<td "+minText(separador(item.peso_neto))+"</td>";
    //                     Contenido += "</tr>";

    //                 });

    //             }else{
    //                 Contenido = "<tr> <td colspan='12' style='text-align:center'> No existen registro en recepcion </td> </tr>";

    //             }

    //             document.getElementById("datosRecepcion").innerHTML = Contenido;

    //             resolve();

    //         }).fail(function( jqXHR, textStatus, responseText) {
    //             Contenido = "<tr> <td colspan='12' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
    //             document.getElementById("datosRecepcion").innerHTML = Contenido;

    //             reject(textStatus+" => "+responseText);

    //         });

    //     });

    // }
  
    // function totalDatosRecepcion(){
    
    //     let filtros = document.getElementsByName("FRec");


    //     let data = "";

    //     // Temporada de operacion
    //     var Temporada = document.getElementById("selectTemporada").value;
    //     data += "&Temporada="+Temporada;


    //     for (let i = 0; i < filtros.length; i++){
    //         let value = filtros[i].value.trim();

            
    //         data += "&campo"+[i]+"="+value;
    //     }
        
    //     return new Promise(function(resolve, reject) {

    //         $.ajax({
    //             data:'action=totalDatosRecepcion'+data,
    //             url: urlDes,
    //             type:'POST',
    //             dataType:'JSON',
    //             async: false
    //         }).done(function(resp){
    //             if(resp.length != 0){
    //                 sessionStorage.TotalAct = resp.Total;
        
    //             }else{
    //                 sessionStorage.TotalAct = 0;
        
    //             }

    //             resolve();

    //         }).fail(function( jqXHR, textStatus, responseText) {
    //             reject(textStatus+" => "+responseText);

    //         });

    //     });

    // }

/*              fin de traer datos              */
/*==================================================================================================================================*/
/*              Traer informacion              */

    function informacionPlanta() { 
        const promiseDatos = traerDatosPlanta(1);

        promiseDatos.then(
            result => totalDatosPlanta().then( result => paginador(), error => console.log(error)),
            error => console.log(error)

        ).finally(
            /* finaly => console.log() */
            
        );

    }

    // function informacionRecepcion() { 
    //     const promiseDatos = traerDatosRecepcion(1);

    //     promiseDatos.then(
    //         result => totalDatosRecepcion().then( result => paginador(), error => console.log(error)),
    //         error => console.log(error)

    //     ).finally(
    //         /* finaly => console.log() */
            
    //     );

    // }

    informacionPlanta();

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Ejecutar paginacion              */


// $("#FRec1").select2();

// $('#FRec1').on("select2:select", (e) =>  informacionRecepcion(1));

$("#FPla1").select2();

$('#FPla1').on("select2:select", (e) =>  informacionPlanta(1));

    var paginacion = document.getElementById("paginacion");
        
    paginacion.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "BUTTON" ) {
            var pagina = e.target.dataset.page;
            var tab = document.getElementById("myTab").children;

            for(var i = 0; i < tab.length; i++){
                if(i == 0 && tab[i].children[0].classList.contains("active")){
                    traerDatosPlanta(pagina);
                    paginador();

                }else{
                    traerDatosRecepcion(pagina);
                    paginador();

                }

            }

        }
        
    });

/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Cambio de pestañas              */

    var tab = document.getElementById("myTab");

    tab.addEventListener("click", function(e){
        if(e.target.nodeName == "A"){
            
            limpiarFiltros();

            var seleccion = e.target.id;

            switch(seleccion){
                case "planta-tab":
                    informacionPlanta();

                break;

                // case "recepcion-tab":
                //     informacionRecepcion();

                // break;

            }

        }
        
    });

/*              Fin de cambio de pestañas              */
/*==================================================================================================================================*/
/*              Ejecutar orden              */

    function ejecutarOrden(e){
        if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target,2);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);

            var active = document.getElementsByClassName("nav-link active")[0].id;

            switch(active){
                case "planta-tab":
                    traerDatosPlanta(1);
                break;

                // case "recepcion-tab":
                //     traerDatosRecepcion(1);
                // break;

            }

        }

    }

    var tablaPlanta = document.getElementById("tablaPlanta");
    
    tablaPlanta.addEventListener("click", function(e){
        ejecutarOrden(e);

    });

    // var tablaRecepcion = document.getElementById("tablaRecepcion");
    
    // tablaRecepcion.addEventListener("click", function(e){
    //     ejecutarOrden(e);

    // });
    
/*              Fin de ejecutar              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tablaPlanta.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FPla"){
            informacionPlanta();

        }
        
    });

    // tablaRecepcion.addEventListener('change', function(e) {
    //     var name = e.target.name;
    //     if(name == "FRec"){
    //         informacionRecepcion();

    //     }
        
    // });

/*              Fin de ejecutar filtros              */
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
        var active = document.getElementsByClassName("nav-link active")[0].id;
        switch(active){
            case "planta-tab":
                activa = 1;
                filtros = document.getElementsByName("FPla");
            break;

            // case "recepcion-tab":
            //     activa = 2;
            //     filtros = document.getElementsByName("FRec");
            // break;

        }

        var campos = "?Temporada="+Temporada+"&Orden="+Orden+"&Export="+activa;

        for(let i = 0; i < filtros.length; i++){
            if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
                campos += "&"+filtros[i].id+"="+filtros[i].value;

            }

        }
        
        let form = document.getElementById('formExport');
        form.action = "docs/excel/export.php"+campos;
        form.submit();

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        descargaExcel(e);
    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/

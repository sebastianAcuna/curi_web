/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/contratos.php";

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
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FCont");

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

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

                if(resp != null && resp.length != 0){

                    $.each(resp,function(i,item){
                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.id_ficha)+"</td>";
                            Contenido += "<td "+minText(item.num_contrato)+"</td>";
                            Contenido += "<td "+minText(item.num_anexo)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.agricultor)+"</td>";
                            Contenido += "<td "+minText(item.nombre)+"</td>";
                            Contenido += "<td "+minText(item.nom_hibrido)+"</td>";
                            Contenido += "<td "+minText(item.base)+"</td>";
                            Contenido += "<td "+minText(item.precio)+"</td>";
                            Contenido += "<td "+minText(item.humedad)+"</td>";
                            Contenido += "<td "+minText(item.germinacion)+"</td>";
                            Contenido += "<td "+minText(item.pureza_genetica)+"</td>";
                            Contenido += "<td "+minText(item.pureza_fisica)+"</td>";
                            Contenido += "<td "+minText(item.enfermedades)+"</td>";
                            Contenido += "<td "+minText(item.maleza)+"</td>";
                        Contenido += "</tr>";

                    });

                }else{
                    Contenido = "<tr> <td colspan='15' style='text-align:center'> No existen contratos </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='16' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
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
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        // Filtros
        let filtros = document.getElementsByName("FCont");

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

/*              Fin traer datos              */
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
/*              Ejecutar orden              */

    var tabla = document.getElementById("tablaContratos");
    
    tabla.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target,2);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            informacion();

        }
        
    });
    
/*              Fin de ejecutar              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        let name = e.target.name;
        if(name == "FCont"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        let id = e.target.id;
        switch(id){
            case "FCont0":
            case "FCont1":
                e.returnValue = keyValida(e,"N",e.target);
            break;
            case "FCont2":
            case "FCont3":
            case "FCont4": 
            case "FCont5": 
            case "FCont6": 
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;
            case "FCont7":
            case "FCont8":
                e.returnValue = keyValida(e,"ND",e.target);
            break;
            case "FCont9":
            case "FCont10":
            case "FCont11":
            case "FCont12":
                e.returnValue = keyValida(e,"LN",e.target);
            break;
            case "FCont13":
            case "FCont14":
                e.returnValue = keyValida(e,"LNE",e.target);
            break;
            
        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e){
        e.preventDefault();

        let filtros = document.getElementsByName("FCont");
        
        //Orden de datos
        let Orden = obtenerOrden();

        // Temporada de operacion
        let Temporada = document.getElementById("selectTemporada").value;

        let campos = "?Temporada="+Temporada+"&Orden="+Orden;

        for(let i = 0; i < filtros.length; i++){
            if(filtros[i].value != "" && filtros[i].value != null && filtros[i].value != undefined && filtros[i].value.length > 0){
                campos += "&"+filtros[i].id+"="+filtros[i].value;

            }

        }
        
        let form = document.getElementById('formExport');
        form.action = "docs/excel/contratos.php"+campos;
        form.submit();

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        descargaExcel(e);

    });

/*              Fin de descargar excel              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        let divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
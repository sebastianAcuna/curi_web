/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/stock.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Todo lo relacionado con el stock              */

    function traerDatos(Page){


        let filtros = document.getElementsByName("FSto");


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
                data:'action=traerDatos'+data,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null){
                    if(resp.length != 0){
                    
                        $.each(resp,function(i,item){   
                            Contenido += "<tr>";
                                Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                                Contenido += "<td "+minText(item.nombre_especie)+"</td>";
                                Contenido += "<td "+minText(formatearFecha(item.fecha_recepcion))+"</td>";
                                Contenido += "<td "+minText(item.razon_social)+"</td>";
                                Contenido += "<td "+minText(item.nombre_material)+"</td>";
                                Contenido += "<td "+minText(item.genetic)+"</td>";
                                Contenido += "<td "+minText(item.trait)+"</td>";
                                Contenido += "<td "+minText(item.sag_resolution_number)+"</td>";
                                Contenido += "<td "+minText(item.curimapu_batch_number)+"</td>";
                                Contenido += "<td "+minText(item.customer_batch)+"</td>";
                                Contenido += "<td "+minText(item.quantity_kg)+"</td>";
                                Contenido += "<td "+minText(item.notes)+"</td>";
                                Contenido += "<td "+minText(item.seed_treated_by)+"</td>";
                                Contenido += "<td "+minText(item.curimapu_treated_by)+"</td>";
                                Contenido += "<td "+minText(item.customer_tsw)+"</td>";
                                Contenido += "<td "+minText(item.customer_germ_porcentaje)+"</td>";
                                Contenido += "<td "+minText(item.tsw)+"</td>";
                                Contenido += "<td "+minText(item.curimapu_germ_porcentaje)+"</td>";
                            Contenido += "</tr>";
    
                        });
    
                    }else{
                        Contenido = "<tr> <td colspan='19' style='text-align:center'> No existe stock </td> </tr>";
    
                    }
                }else{
                    Contenido = "<tr> <td colspan='19' style='text-align:center'> No existe stock </td> </tr>";
                }
                

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='19' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });

        });

    }

    function totalDatos(){
    
        //Datos de filtro
        // Filtros

        let data = "";
        let filtros = document.getElementsByName("FSto");

        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;
        data += "&Temporada="+Temporada;

        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos'+data,
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
            var pagina = e.target.dataset.page;
            traerDatos(pagina);
            paginador();

        }
        
    });

/*              Fin de ejecutar paginacion              */
/*==================================================================================================================================*/
/*              Ejecutar orden              */

    var tabla = document.getElementById("tablaStock");
    
    tabla.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "TD" && e.target.className == "min-td") {
            verMas(e.target,1);

        }else if(e.target && e.target.nodeName == "TD" && e.target.className == "max-td"){
            verMas(e.target,2);

        }else if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            traerDatos(1);

        }
        
    });
    
/*              Fin de ejecutar              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FSto"){
            traerDatos(1);
        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Descargar excel              */


    $("#FSto1").select2();

    $('#FSto1').on("select2:select", (e) =>  traerDatos(1));

    function descargaExcel(e){

        e.preventDefault();

        let filtros = document.getElementsByName("FSto");


        let data = "";

        //Orden de datos
        var Orden = obtenerOrden();
        data += "?Orden="+Orden;




        for (let i = 0; i < filtros.length; i++){
            let value = filtros[i].value.trim();

            
            data += "&campo"+[i]+"="+value;
        }

        let form = document.getElementById('formExport');
        form.action = "docs/excel/stock.php"+data;
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
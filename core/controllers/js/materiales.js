/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/materiales.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FEsp = document.getElementById("FMat1").value;
        var FFant = document.getElementById("FMat2").value;
        var FHib = document.getElementById("FMat3").value;
        var FHem = document.getElementById("FMat4").value;
        var FMac = document.getElementById("FMat5").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FEsp='+FEsp+'&FFant='+FFant+'&FHib='+FHib+'&FHem='+FHem+'&FMac='+FMac,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null && resp.length != 0){

                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.especie)+"</td>";
                            Contenido += "<td "+minText(item.nom_fantasia)+"</td>";
                            Contenido += "<td "+minText(item.nom_hibrido)+"</td>";
                            Contenido += "<td "+minText(item.p_hembra)+"</td>";
                            Contenido += "<td "+minText(item.p_macho)+"</td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='6' style='text-align:center'> No existen materiales </td> </tr>";

                }

                document.getElementById("datos").innerHTML = Contenido;

                resolve();

            }).fail(function( jqXHR, textStatus, responseText) {
                Contenido = "<tr> <td colspan='6' style='text-align:center'> Ups.. Intentamos conectarnos con el sistema, pero no hemos podido. </td> </tr>";
                
                document.getElementById("datos").innerHTML = Contenido;

                reject(textStatus+" => "+responseText);

            });
            
        });

    }

    function totalDatos(){
    
        //Datos de filtro
        var FEsp = document.getElementById("FMat1").value;
        var FFant = document.getElementById("FMat2").value;
        var FHib = document.getElementById("FMat3").value;
        var FHem = document.getElementById("FMat4").value;
        var FMac = document.getElementById("FMat5").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FEsp='+FEsp+'&FFant='+FFant+'&FHib='+FHib+'&FHem='+FHem+'&FMac='+FMac,
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

    var tabla = document.getElementById("tablaMateriales");
    
    tabla.addEventListener("click", function(e){
        if(e.target && e.target.nodeName == "I") {
            activarOrden(e.target);
            
            informacion();

        }
        
    });
    
/*              Fin de ejecutar eventos de la tabla              */
/*==================================================================================================================================*/
/*              Ejecutar filtros              */

    tabla.addEventListener('change', function(e) {
        var name = e.target.name;
        if(name == "FMat"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FMat1":
                e.returnValue = keyValida(e,"LTE",e.target);
            break;
            case "FMat2":
            case "FMat3":
            case "FMat4":
            case "FMat5":
                e.returnValue = keyValida(e,"LTNExE",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
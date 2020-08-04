/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/agricultores.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function traerDatos(Page){

        //Datos de filtro
        var FRut = document.getElementById("FAgri1").value;
        var FRaS = document.getElementById("FAgri2").value;
        var FTel = document.getElementById("FAgri3").value;
        var FEmail = document.getElementById("FAgri4").value;

        //Orden de datos
        var Orden = obtenerOrden();

        // Ve que pagina es y trae los datos correspondientes a tal
        var Des = obtenerPagina(Page);

        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=traerDatos&D='+Des+'&Orden='+Orden+'&FRut='+FRut+'&FRaS='+FRaS+'&FTel='+FTel+'&FEmail='+FEmail,
                url: urlDes,
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                var Contenido = "";

                if(resp != null && resp.length != 0){

                    $.each(resp,function(i,item){

                        Contenido += "<tr>";
                            Contenido += "<td>"+(parseInt(Des)+i+1)+"</td>";
                            Contenido += "<td "+minText(item.rut)+"</td>";
                            Contenido += "<td "+minText(item.razon_social)+"</td>";
                            Contenido += "<td "+minText(item.telefono)+"</td>";
                            Contenido += "<td "+minText(item.email)+"</td>";
                            Contenido += "<td class='fix-edi'> <button type='button' class='btn btn-info' data-info='"+item.id_agric+"' style='margin: 0; padding:.1rem .3rem'> <i class='fas fa-search' data-info='"+item.id_agric+"'></i> </button> </td>";
                        Contenido += "</tr>";
                    });

                }else{
                    Contenido = "<tr> <td colspan='6' style='text-align:center'> No existen agricultores </td> </tr>";

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
        var FRut = document.getElementById("FAgri1").value;
        var FRaS = document.getElementById("FAgri2").value;
        var FTel = document.getElementById("FAgri3").value;
        var FEmail = document.getElementById("FAgri4").value;
    
        
        return new Promise(function(resolve, reject) {

            $.ajax({
                data:'action=totalDatos&FRut='+FRut+'&FRaS='+FRaS+'&FTel='+FTel+'&FEmail='+FEmail,
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
                document.getElementById("rut").innerText = sinInformacion(resp.rut);
                document.getElementById("nombre").innerText = sinInformacion(resp.razon_social);
                document.getElementById("telefono").innerText = sinInformacion(resp.telefono);
                document.getElementById("email").innerText = sinInformacion(resp.email);
                document.getElementById("region").innerText = sinInformacion(resp.region);
                document.getElementById("comuna").innerText = sinInformacion(resp.comuna);
                document.getElementById("direccion").innerText = sinInformacion(resp.direccion);
                document.getElementById("rl").innerText = sinInformacion(resp.rep_legal);
                document.getElementById("rutRL").innerText = sinInformacion(resp.rut_rl);
                document.getElementById("telefonoRL").innerText = sinInformacion(resp.telefono_rl);
                document.getElementById("emailRL").innerText = sinInformacion(resp.email_rl);
                document.getElementById("banco").innerText = sinInformacion(resp.banco);
                document.getElementById("numCC").innerText = sinInformacion(resp.cuenta_corriente);

                document.getElementById("tituloModal").innerText = "Agricultor: "+sinInformacion();
                $("#modalAgri").modal('show');

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

    var tabla = document.getElementById("tablaAgricultores");
    
    tabla.addEventListener("click", function(e){
        if(e.target && (e.target.nodeName == "BUTTON" || e.target.nodeName == "I") && e.target.dataset.info != undefined) {
            var info = e.target.dataset.info;
            traerInfo(info);

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
        if(name == "FAgri"){
            informacion();

        }
        
    });

/*              Fin de ejecutar filtros              */
/*==================================================================================================================================*/
/*              Evento key inputs filtros              */

    tabla.addEventListener('keypress', function(e) {
        var id = e.target.id;
        switch(id){
            case "FAgri1":
                e.returnValue = keyValida(e,"R",e.target);
            break;
            case "FAgri2":
                e.returnValue = keyValida(e,"LE",e.target);
            break;
            case "FAgri3":
                e.returnValue = keyValida(e,"F",e.target);
            break;
            case "FAgri4":
                e.returnValue = keyValida(e,"C",e.target);
            break;

        }
        
    });

/*              Fin de evento key inputs filtros              */
/*==================================================================================================================================*/
/*              Descargar excel              */

    function descargaExcel(e,desde){
        e.preventDefault();

        if(desde == 1){
            let form = document.getElementById('formExport');
            form.action = "docs/excel/agricultor.php";
            form.submit();
            
        }

    }

    document.getElementById("descExcel").addEventListener('click', function(e) {
        descargaExcel(e,1);

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
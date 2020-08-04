/*==================================================================================================================================*/
/*              Variables globales              */

var urlDes = "core/controllers/php/intercambio.php";

//  Swal = import('assets/js/sweetalert2.all.min.js');

/*              Fin de variables globales              */
/*==================================================================================================================================*/

/*              comenzar proceso    */

var btnStart = document.getElementById("startDownload");
var btnDeleteALL = document.getElementById("startDelete");
var btnSiguiente = document.getElementById("btnSiguiente");
var botonLimpiar = document.getElementById("botonLimpiar");
var contenedor = document.getElementById("cuadro_paso_1");
var iconSuccess = document.getElementById("icon_download_success");
var iconError = document.getElementById("icon_download_error");
var iconCharge = document.getElementById("icon_download_charge");
var titulo_paso_1 = document.getElementById("titulo_paso_1");
var sub_paso_1 = document.getElementById("sub_paso_1");

var tablaErrores = document.getElementById("tablaErrores");
var tablaDeErrores = document.getElementById("tablaDeErrores");

var tablaOk = document.getElementById("tablaOk");
var datosOk = document.getElementById("datosOk");
var tablaErroresRef = document.getElementById("tablaErroresRef");
var datosErrores = document.getElementById("datosErrores");
var contenedor_migajas = document.getElementById("contenedor_migajas");

btnStart.addEventListener("click", function(){

        swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de comenzar un proceso de descarga de informacion (SAP => curiweb), esto tomará un tiempo.",
            icon: "info",
            buttons: true,
            dangerMode: true
        })
        .then((action) => {
            if (action) {
               ajaxPasoUno();
            }
        });

});

btnDeleteALL.addEventListener("click", function(){
        swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de eliminar tablas importantes de curimapu_tabletas.",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
        .then((action) => {
            if (action) {

                swal("Solo para estar seguro, escriba 'Harvol' antes de continuar ", {
                    content: "input",
                  })
                  .then((value) => {
                    if(value == 'Harvol'){
                        empezarDelete();
                    }else{
                        swal({
                            title: "ATENTO",
                            text: "Para realizar esta accion, DEBES, ingresar la palabra que se solicita, solo para tener una doble confirmacion ",
                            icon: "info",
                            buttons: true,
                            dangerMode: true
                        })
                    }
                  });
            }
        });

});

function empezarDelete(){

   contenedor.style.display = "flex";
   titulo_paso_1.innerText = "eliminado informacion";
   sub_paso_1.innerText = "esto puede tardar un momento, por favor no cierre ni cambie de pestana";
   btnSiguiente.innerText = "terminar";
   btnSiguiente.classList.add("disabled");

   $.ajax({
        data:'action=empezarDelete',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        if(resp != null){
            if(resp.codigo == 1){
                swal("Exito!", "Se ha logrado limpiar los datos de origen de manera exitosa.", "success");
                titulo_paso_1.innerText = "";
                sub_paso_1.innerText = "";
                btnSiguiente.innerText = "";
                btnSiguiente.classList.add("disabled");
                contenedor.style.display = "none";
                // successAjaxViewTryAgain("Todo realizado con exito", "Se ha descargado e ingresado todo de manera correcta", "reintentar", false);
            }else{
                var data = resp.data;
                var origen = "";

                $.each(data,function(i,item){
                    origen = (i == 0)? item.tabla : " ,"+item.tabla;
                });

                swal("Error!", "No se ha logrado limpiar los datos de origen de manera exitosa. \n Origen erroneo: "+origen, "error");
                
            }

        }else{
            swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

        }

    });


   
}

botonLimpiar.addEventListener("click", function(){

       limpiarDB();

});

btnSiguiente.addEventListener("click", function(e){

    var act = e.target.dataset.etapa;

    switch(act){
            /* etapa 1 */
        case '1':
            btnStart.classList.remove("hideIcon");
            btnStart.classList.add("showIcon");

            // Swal.fire({
            //     title: 'Error!',
            //     text: 'Do you want to continue',
            //     icon: 'error',
            //     confirmButtonText: 'Cool'
            //   }).then((action) => {
            //     if (action) {
            //         ajaxPasoUno();
            //      }
            //   });


            swal({
                title: "¿Estas seguro?",
                text: "Estas a punto de comenzar un proceso de descarga de informacion (SAP => curiweb), esto tomará un tiempo.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((action) => {
                if (action) {
                   ajaxPasoUno();
                }
            });

            break;
            /* etapa 2 */
        case '2':
            btnStart.classList.add("hideIcon");
            btnStart.classList.remove("showIcon");
            swal({
                title: "¿Estas seguro?",
                text: "Estas a punto de comenzar etapa 2\nEsta generara un respaldo de la bd, tomará un tiempo.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((action) => {
                if (action) {
                   ajaxPasoDos();
                }
            });
            break;
            /* etapa 3 */
        case '3':
            btnStart.classList.add("hideIcon");
            btnStart.classList.remove("showIcon");
            swal({
                title: "¿Estas seguro?",
                text: "Estas a punto de comenzar etapa 3\nEsta comprueba referencias de ID, tomará un tiempo.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((action) => {
                if (action) {
                   ajaxPasoTres();
                }
            });
            break
            /* etapa 4 */
        case '4':
            btnStart.classList.remove("hideIcon");
            btnStart.classList.add("showIcon");

            swal({
                title: "¿Estas seguro?",
                text: "Estas a punto de comenzar etapa 4\nEsta descargará,ingresará o cambiará datos en curimapu web, tomará un tiempo.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((action) => {
                if (action) {
                   ajaxPasoCuatro();
                }
            });
            break

    }

});

function preAjaxView(messageTitle, messageSub){

    botonLimpiar.classList.remove("showIcon");
    botonLimpiar.classList.add("hideIcon");
    botonLimpiar.classList.add("disabled");

   // Mostrar check
   iconSuccess.classList.remove("showIcon");
   iconSuccess.classList.add("hideIcon");

   // Ocultar error
   iconError.classList.remove("showIcon");
   iconError.classList.add("hideIcon");

   iconCharge.classList.remove("hideIcon");
   iconCharge.classList.add("showIcon");



    tablaDeErrores.classList.add("hideIcon");
    tablaDeErrores.classList.remove("showIcon");


    tablaOk.classList.add("hideIcon");
    tablaOk.classList.remove("showIcon");



    tablaErroresRef.classList.add("hideIcon");
    tablaErroresRef.classList.remove("showIcon");

   titulo_paso_1.innerText = messageTitle;
   sub_paso_1.innerText = messageSub;

   btnSiguiente.innerText = "siguiente";
   btnSiguiente.classList.add("disabled");
}

function successAjaxView(messageTitle, messageSub, muestraTablaOk ,$nombreSgte){

    botonLimpiar.classList.remove("showIcon");
    botonLimpiar.classList.add("hideIcon");
    botonLimpiar.classList.add("disabled");


        // Mostrar check
        iconSuccess.classList.remove("hideIcon");
        iconSuccess.classList.add("showIcon");

        // Ocultar error
        iconError.classList.remove("showIcon");
        iconError.classList.add("hideIcon");

        iconCharge.classList.add("hideIcon");
        iconCharge.classList.remove("showIcon");


        titulo_paso_1.innerText = messageTitle;
        sub_paso_1.innerText = messageSub;


        if(muestraTablaOk){
            tablaOk.classList.remove("hideIcon");
            tablaOk.classList.add("showIcon");
        }else{
            tablaOk.classList.add("hideIcon");
            tablaOk.classList.remove("showIcon");
        }
        

        tablaErroresRef.classList.add("hideIcon");
        tablaErroresRef.classList.remove("showIcon");


        tablaDeErrores.classList.add("hideIcon");
        tablaDeErrores.classList.remove("showIcon");

        btnSiguiente.innerText = $nombreSgte;
        btnSiguiente.classList.remove("disabled");
}

function successAjaxViewTryAgain(messageTitle, messageSub, $nombreSgte, muestraTablaOk){

        // Mostrar check
        iconSuccess.classList.remove("hideIcon");
        iconSuccess.classList.add("showIcon");

        // Ocultar error
        iconError.classList.remove("showIcon");
        iconError.classList.add("hideIcon");

        iconCharge.classList.add("hideIcon");
        iconCharge.classList.remove("showIcon");


        titulo_paso_1.innerText = messageTitle;
        sub_paso_1.innerText = messageSub;

        // btnSiguiente.innerText = nombreSgte;

        if(muestraTablaOk){
            tablaOk.classList.remove("hideIcon");
            tablaOk.classList.add("showIcon");
        }else{
            tablaOk.classList.add("hideIcon");
            tablaOk.classList.remove("showIcon");
        }
        

        tablaErroresRef.classList.add("hideIcon");
        tablaErroresRef.classList.remove("showIcon");


        tablaDeErrores.classList.add("hideIcon");
        tablaDeErrores.classList.remove("showIcon");

        btnSiguiente.innerText = $nombreSgte;
        btnSiguiente.classList.remove("disabled");
}

function ErrorAjaxView(messageTitle, messageSub,nombreSgte, muestraTabla, muestraTablaOk){

    botonLimpiar.classList.remove("showIcon");
    botonLimpiar.classList.add("hideIcon");
    botonLimpiar.classList.add("disabled");


        // Mostrar check
        iconSuccess.classList.add("hideIcon");
        iconSuccess.classList.remove("showIcon");

        // Ocultar error
        iconError.classList.add("showIcon");
        iconError.classList.remove("hideIcon");


        iconCharge.classList.add("hideIcon");
        iconCharge.classList.remove("showIcon");

        if(muestraTabla){
            tablaDeErrores.classList.remove("hideIcon");
            tablaDeErrores.classList.add("showIcon");
        }
        
        /* else{
            tablaDeErrores.classList.add("hideIcon");
            tablaDeErrores.classList.remove("showIcon");
        } */

        if(muestraTablaOk){
            tablaOk.classList.remove("hideIcon");
            tablaOk.classList.add("showIcon");

            tablaErroresRef.classList.remove("hideIcon");
            tablaErroresRef.classList.add("showIcon");
        }
        
       /*  else{
            tablaOk.classList.add("hideIcon");
            tablaOk.classList.remove("showIcon");

            tablaErroresRef.classList.add("hideIcon");
            tablaErroresRef.classList.remove("showIcon");
        } */
        


        titulo_paso_1.innerText = messageTitle;
        sub_paso_1.innerText = messageSub;

        btnSiguiente.innerText = nombreSgte;
        btnSiguiente.classList.remove("disabled");
}

function ajaxPasoUno(){

    contenedor.style.display = "flex";

    preAjaxView("Comenzando paso 1 ...","Comprobando caracteres");

    $.ajax({
        data:'action=pasoUno',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        switch(resp.codigo){
            case 1:

                child = `<div style="display:flex;align-items:center;" title="ningun caracter extraño entontrado"> <h3>  paso 1 </h3> <i style="margin-left:1rem;" class="fas fa-check fa-2x text-success"></i> </div>`;
               
                contenedor_migajas.innerHTML = child;
                
                


                successAjaxView("Primer paso realizado con exito", "ningun caracter extraño entontrado", false, "siguiente");
                btnSiguiente.dataset.etapa = 2;
                
                break;
            case 2:
                child = `<div style="display:flex;align-items:center;" title="Se han encontrado caracteres invalidos, por favor, compruebelos y vuelva a intentarlo"> <h3>  paso 1 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
                contenedor_migajas.innerHTML =  child;

            ErrorAjaxView("problemas con el primer paso",  "Se han encontrado caracteres invalidos, por favor, compruebelos y vuelva a intentarlo", "reintentar", true, false);
            btnSiguiente.dataset.etapa = 1;
            
                const data = resp.data;
                var mensaje = ``;

                // console.log(resp); 
                for(element in data){     
                           
                    // console.log(Object.keys(data[element]));
                    if(Object.keys(data[element]).length > 0){
                    //    console.log(data[element]);
                        for(columna in data[element]){
                            // console.log(data[element][columna]);
                        
                            for(columnaFinal in data[element][columna]){
                                mensaje += `<tr>`;
                                mensaje += `<td> ${element} </td>`;
                                mensaje += `<td> ${columnaFinal} </td>`;
                                mensaje += `<td> ${data[element][columna][columnaFinal]} </td>`;
                                mensaje += `</tr>`;
                            }
                            
                           
                        }
                        
                    }
                }

                tablaErrores.innerHTML = mensaje;

                break;
        }
       

    }).fail(function( jqXHR, textStatus, responseText) {
        btnSiguiente.dataset.etapa = 1;
        child = `<div style="display:flex;align-items:center;" title="Se han encontrado caracteres invalidos, por favor, compruebelos y vuelva a intentarlo"> <h3>  paso 1 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
        contenedor_migajas.innerHTML = child;
        ErrorAjaxView("problemas con el primer paso",  "Se han encontrado caracteres invalidos, por favor, compruebelos y vuelva a intentarlo", "reintentar", false, false);
        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

    }).always(function(){
        // informacionProvisorias();
    });
}

function ajaxPasoDos(){

    preAjaxView("Comenzando paso 2 ...","Respaldando Base de datos");

    $.ajax({
        data:'action=pasoDos',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        switch(resp.codigo){
            case 1:

                
                
                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="Base de datos se respaldo de manera correcta"> <h3>  paso 2 </h3> <i style="margin-left:1rem;" class="fas fa-check fa-2x text-success"></i> </div>`;
               
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
                successAjaxView("Segundo paso realizado con exito", "Base de datos se respaldo de manera correcta", false, "siguiente");
                btnSiguiente.dataset.etapa = 3;
                
                break;
            case 2:
                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="No se pudo comprobar si el respaldo se realizo de manera correcta, vuelva a intentarlo, si el problema persiste, contecte con un administrador."> <h3>  paso 2 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
               
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
                ErrorAjaxView("Problemas con el segundo paso",  "No se pudo comprobar si el respaldo se realizo de manera correcta, vuelva a intentarlo, si el problema persiste, contecte con un administrador.", "volver a comenzar", true, false);
                btnSiguiente.dataset.etapa = 1;
    
                break;
        }
       

    }).fail(function( jqXHR, textStatus, responseText) {

        btnSiguiente.dataset.etapa = 1;
        child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="No se pudo comprobar si el respaldo se realizo de manera correcta, vuelva a intentarlo, si el problema persiste, contecte con un administrador."> <h3>  paso 2 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
               
        contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
        ErrorAjaxView("problemas con el segundo paso",  "No se pudo comprobar si el respaldo se realizo de manera correcta, vuelva a intentarlo, si el problema persiste, contecte con un administrador.", "volver a comenzar", false);
        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

    }).always(function(){
        // informacionProvisorias();
    });
}

function ajaxPasoTres(){

    preAjaxView("Comenzando paso 3 ...","Comprobacion de referencias");

    $.ajax({
        data:'action=pasoTres',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        switch(resp.codigo){
            case 1:
                

                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="Todas las referencias coinciden"> <h3>  paso 3 </h3> <i style="margin-left:1rem;" class="fas fa-check fa-2x text-success"></i> </div>`;
               
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
                successAjaxView("Tercer paso realizado con exito", "Todas las referencias coinciden", false, "siguiente");
                btnSiguiente.dataset.etapa = 4;
                
                break;
            case 2:

                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="Hay referencias inexistentes en algunas tablas."> <h3>  paso 3 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;

                ErrorAjaxView("Problemas con el tercer paso",  "Hay referencias inexistentes en algunas tablas.", "volver a comenzar", true, false);
                btnSiguiente.dataset.etapa = 1;

                data = resp.data;

                var mensaje = ``;
                for(element in data){
                    mensaje += `<tr>`;
                    if(data[element]["codigo"] == 4){
                        mensaje += `<td> ${data[element]["tabla"]} </td>`;
                        mensaje += `<td> ${data[element]["campo"]} </td>`;
                        mensaje += `<td> Registro con ID primaria ${data[element]["id_origen"]} tiene una  id referencial con valor ( ${data[element]["valor"]} ) el cual no existe en tabla ${data[element]["tabla_ref"]} </td>`;
                    }
                    
                }

                tablaErrores.innerHTML = mensaje;

                break;

        }
       

    }).fail(function( jqXHR, textStatus, responseText) {
        btnSiguiente.dataset.etapa = 1;
        child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="Hay referencias inexistentes en algunas tablas."> <h3>  paso 3 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
        contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
        ErrorAjaxView("problemas con el tercer paso",  "Hay referencias inexistentes en algunas tablas.", "volver a comenzar", false, false);
        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

    }).always(function(){
        // informacionProvisorias();
    });
}

function ajaxPasoCuatro(){

    preAjaxView("Comenzando paso 4 ...","Descarga e ingreso de información desde BD intercambio a curiweb");

    $.ajax({
        data:'action=pasoCuatro',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){

        switch(resp.codigo){
            case 1:
               
                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="Se ha descargado e ingresado todo de manera correcta"> <h3>  paso 4 </h3> <i style="margin-left:1rem;" class="fas fa-check fa-2x text-success"></i> </div>`;
               
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
                
                successAjaxView("Cuarto paso realizado con exito", "Se ha descargado e ingresado todo de manera correcta", true, "reintentar");
                btnSiguiente.dataset.etapa = 1;

                botonLimpiar.classList.remove("hideIcon");
                botonLimpiar.classList.add("showIcon");
                botonLimpiar.classList.remove("disabled");

                /* errores sintaxys COD 5 */
                mensaje3 = ``;
                /* console.log("datos ok");
                console.log(dataOk); */

                dataOk = resp.dataOk;

                if(dataOk.length > 0){
                    for(element in dataOk){
                    
                        if(dataOk[element]["codigo"] == 2){
                            mensaje3 += `<tr>`;
                            mensaje3 += `<td> ${dataOk[element]["tabla"]} </td>`;
                            mensaje3 += `<td> ${dataOk[element]["mensaje"]} </td>`;
                            mensaje3 += `</tr>`;
                        }
                    }
                }else{
                    mensaje3+= `<tr><td colspan="2"> ningun registro encontrado </td></tr>`;
                }
                datosOk.innerHTML = mensaje3; 

                // limpiarDB();
                    
                traerTemporada();
                
                break;
            case 2:

                child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="No se pudo ingresar la información a base de datos curiweb."> <h3>  paso 4 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
               
                contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
                ErrorAjaxView("Problemas con el cuarto paso",  "No se pudo ingresar la información a base de datos curiweb.", "volver a comenzar", true, true);
                btnSiguiente.dataset.etapa = 1;

                /* error referencial */
                dataError = resp.dataError;
                /* error bd sintaxis */
                data = resp.data;
                /* datos ingresados correctamente */
                dataOk = resp.dataOk;
                

                /* errores referencia */
                var mensaje = ``;
                if(dataError.length > 0){
                    for(element in dataError){
                        if(dataError[element]["codigo"] == 4){
                            mensaje += `<tr>`;
                            mensaje += `<td> ${dataError[element]["tabla"]} </td>`;
                            mensaje += `<td> ${dataError[element]["campo"]} </td>`;
                            mensaje += `<td> Registro con ID primaria ${dataError[element]["id_origen"]} tiene una  id referencial con valor ( ${dataError[element]["valor"]} ) el cual no existe en tabla ${dataError[element]["tabla_ref"]} </td>`;
                            mensaje += `</tr>`;
                        }
        
                    }
                }else{
                    mensaje+= `<tr><td colspan="3" > ningun registro encontrado </td></tr>`;
                }
                tablaErrores.innerHTML = mensaje;

                /* errores sintaxys COD 5 */
                mensaje2 = ``;
                if(data.length > 0){
                        for(element in data){
                            
                            if(data[element]["codigo"] == 5){
                                mensaje2 += `<tr>`;
                                mensaje2 += `<td> ${data[element]["tabla"]} </td>`;
                                mensaje2 += `<td> ${data[element]["mensaje"]} </td>`;
                                mensaje2 += `</tr>`;
                            }
                            
                        }

                }else{
                    mensaje2+= `<tr><td colspan="2" > ningun registro encontrado </td></tr>`;
                }
                datosErrores.innerHTML = mensaje2;


                /* errores sintaxys COD 3 */
                mensaje3 = ``;
                /* console.log("dataOk");
                console.log(dataOk); */
                if(dataOk.length > 0){
                    for(element in dataOk){
                    
                        if(dataOk[element]["codigo"] == 2){
                            mensaje3 += `<tr>`;
                            mensaje3 += `<td> ${dataOk[element]["tabla"]} </td>`;
                            mensaje3 += `<td> ${dataOk[element]["mensaje"]} </td>`;
                            mensaje3 += `</tr>`;
                        }
                    }
                }else{
                    mensaje3+= `<tr><td colspan="2"> ningun registro encontrado </td></tr>`;
                }
                
                datosOk.innerHTML = mensaje3;


                break;

        }
       

    }).fail(function( jqXHR, textStatus, responseText) {
        btnSiguiente.dataset.etapa = 1;
        child = `<div style="display:flex;margin-left:1rem;align-items:center;" title="No se pudo ingresar la información a base de datos curiweb."> <h3>  paso 4 </h3> <i style="margin-left:1rem;" class="fas fa-times fa-2x text-danger"></i> </div>`;
               
        contenedor_migajas.innerHTML = contenedor_migajas.innerHTML + child;
        ErrorAjaxView("problemas con el cuarto paso",  "No se pudo ingresar la información a base de datos curiweb.", "volver a comenzar", false, true);
        swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");

    }).always(function(){
        // informacionProvisorias();
    });
}

function limpiarDB(){
    swal({
        title: "¿Limpiar datos de origen?",
        text: "El ingreso y cambio de datos en curimapu web desde los datos de origen se ha realizado con exito!\nActualmente puedes limpiar los datos de origen, ¿Quieres hacerlo?.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((action) => {

        if(action){
            $.ajax({
                data:'action=limpiarDB',
                url: urlDes,
                type:'POST',
                dataType:'JSON',
                async: false
            }).done(function(resp){
                if(resp != null){
                    if(resp.codigo == 1){
                        swal("Exito!", "Se ha logrado limpiar los datos de origen de manera exitosa.", "success");
                        successAjaxViewTryAgain("Todo realizado con exito", "Se ha descargado e ingresado todo de manera correcta", "reintentar", false);
                    }else{
                        var data = resp.data;
                        var origen = "";
    
                        $.each(data,function(i,item){
                            origen = (i == 0)? item.tabla : " ,"+item.tabla;
    
                        });
    
                        swal("Error!", "No se ha logrado limpiar los datos de origen de manera exitosa. \n Origen erroneo: "+origen, "error");
                        
                    }
    
                }else{
                    swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
    
                }
               
            }).fail(function( jqXHR, textStatus, responseText) {
                swal("Ops!", "Hemos encontrado una falla, por ende se cancelaron todas las acciones, vuelva a intentarlo, si el error persiste, comuníquese con sistema.", "error");
        
            }).always(function(){
    
            });
        }else{
            btnSiguiente.dataset.etapa = 5;
            successAjaxViewTryAgain("Todo realizado con exito", "Se ha descargado e ingresado todo de manera correcta", "reintentar", false);
        }
    
    });

}

function traerTemporada(){
    $.ajax({
        data:'action=traerTemporada',
        url: urlDes,
        type:'POST',
        dataType:'JSON',
        async: false
    }).done(function(resp){
        let Contenido = "";
        
        if(resp != null){
            $.each(resp,function(i,item){
                Contenido += "<option value='"+item.id_tempo+"'>"+item.nombre+"</option>";
            
            });

        }else{
            Contenido = "<option value=''> No existen temporadas </option>";

        }
        
        document.getElementById("selectTemporada").innerHTML = Contenido;

    }).fail(function( jqXHR, textStatus, responseText) {
        console.log(textStatus+" => "+responseText);

    });

}

/*              Fin de comenzar proceso   */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
/*==================================================================================================================================*/
/*              Paginacion              */

    function mostrarTitle(page,mostrar,total){
        let title = "";

        if(page == 1){
            title = "Registros desde el 1° hasta el ";

        }else{
            title = "Registros desde el "+((page-1)*mostrar)+"° hasta el ";

        }

        if(((page+1)*mostrar) > total){
            title += total+"° de "+total+" registros.";

        }else{
            title += ((page)*mostrar)+"° de "+total+" registros.";

        }
        
        return title;
                
    }

    function paginador(){

        //Definimos parametros
        let PageActual = parseInt(sessionStorage.PageAct);
        let Elementos_A_Mostrar = 10;
        let Numero_Total = parseInt(sessionStorage.TotalAct);

        // Comenzamos

        let Numero_paginas = Math.ceil(Numero_Total / Elementos_A_Mostrar);

        let Primera = (PageActual - 3) > 1 ? PageActual - 3 : 1;

        let Ultima = (PageActual + 3) < Numero_paginas ? PageActual + 3 : Numero_paginas;

        // Generamos la numeracion de la pagina

        let Paginacion = "";

        if (Numero_paginas > 1) {

            Paginacion += "<section class='paginacion'>";
            Paginacion += "<ul>";

            // Inicio
            if(PageActual > 1) {
                Paginacion += '<li ><button data-page="1" title="Total registro: '+Numero_Total+'"> &laquo; </button></li>';
            }

            // Anterior
            if (PageActual > 1) {
                Paginacion += '<li ><button data-page="'+(PageActual-1)+'" title="'+mostrarTitle((PageActual-1),Elementos_A_Mostrar,Numero_Total)+'"> &larr; Anterior</button></li>';
            }

            // Si la primera del grupo no es la pagina 1, mostramos la 1 y los ...
            if (Primera != 1) {
                Paginacion += '<li ><button data-page="1" title="'+mostrarTitle(1,Elementos_A_Mostrar,Numero_Total)+'"> 1 </button></li>';
                Paginacion += '<li>...</li>';
            }

            // Mostramos la página actual, las 3 anteriores y las 3 posteriores
            for (let i = Primera; i <= Ultima; i++){
                Paginacion += '<li ><button class="'+( PageActual == i ? 'active': '')+'" data-page="'+i+'" title="'+mostrarTitle(i,Elementos_A_Mostrar,Numero_Total)+'">'+i+'</button></li>';
            }

            // Si la ultima del grupo no es la ultima, mostramos la ultima y los ...
            if (Ultima != Numero_paginas) {
                Paginacion += '<li>...</li>';
                Paginacion += '<li ><button data-page="'+Numero_paginas+'" title="'+mostrarTitle(Numero_paginas,Elementos_A_Mostrar,Numero_Total)+'"> '+Numero_paginas+' </button></li>';
            }

            // Siguiente
            if (PageActual > 0 && PageActual < Numero_paginas) {
                Paginacion += '<li ><button data-page="'+(PageActual+1)+'" title="'+mostrarTitle((PageActual+1),Elementos_A_Mostrar,Numero_Total)+'"> Siguiente &rarr; </button></li>';
            }

            // Ultima pagina
            if (PageActual > 0 && PageActual < Numero_paginas) {
                Paginacion += '<li ><button data-page="'+Numero_paginas+'" title="Total registro: '+Numero_Total+'"> &raquo; </button></li>';
            }

            Paginacion += "</ul>";
            Paginacion += "</section>";

            // Definimos donde se paginara
            document.getElementById("paginacion").innerHTML = Paginacion;

        }else{
            Paginacion = "";

            // Definimos donde se paginara
            document.getElementById("paginacion").innerHTML = Paginacion;

        }

    }

/*              Fin de paginacion              */
/*==================================================================================================================================*/
/*              Separador de miles o decimales              */

    function separador(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }


    function formatearFecha(str){
        let rgx = /^\d{4}([\-/.])(0?[1-9]|1[1-2])\1(3[01]|[12][0-9]|0?[1-9])$/;

        if(rgx.test(str)){
            fechas = str.split("-");
            return fechas[2] + "-" + fechas[1] + "-" + fechas[0];
        }else{
            return str;
        }
    }

/*              Fin de separador de miles o decimales              */
/*==================================================================================================================================*/
/*              minimizar text              */

    function minText(text){
        let texto = "";
        let dato = sinInformacion(text);
        let align = "";

        if(!isNaN(parseFloat(dato)) && isFinite(dato)){
            align = "right";
            dato = truncar(dato,2).toString();
            
        }else{
            dato = dato.toString().toUpperCase();
            align = "left";

        }
            

        if(dato != null){
            if(dato.length >= 60 && dato.length < 207){
                texto = " class='min-width: 300px' align='"+align+"' >"+dato;
    
            }else if(dato.length >= 20 && dato.length < 60){
                texto = " style='min-width: 200px' align='"+align+"' > "+dato;
    
            }else if(dato.length < 20){
                texto = " style='min-width: 100px' align='"+align+"' > "+dato;
    
            }else if(dato.length >= 207){
                texto += " class='min-td' name='verMenos' align='"+align+"' >"+dato.slice(0,207)+".....<td class='max-td' name='verMas' style='display:none'>"+dato+"</td>";
    
            }

        }else{
            texto = " align='"+align+"'  > "+dato;

        }

        return texto;

    }

    function minTextTH(text){
        let texto = "";
        let dato = text;
        let align = "center";
        
        if(dato.length >= 60 && dato.length < 207){
            texto = " style='min-width: 350px' align='"+align+"' >"+dato;

        }else if(dato.length >= 20 && dato.length < 60){
            texto = " style='min-width: 250px' align='"+align+"' > "+dato;

        }else if(dato.length < 20){
            texto = " style='min-width: 150px' align='"+align+"' > "+dato;

        }

        return texto;

    }

/*              Fin de minimizar text              */
/*==================================================================================================================================*/
/*              Ver mas              */

    function verMas(Obj,accion){
        switch(accion){
            case 1:
                Obj.style.display = "none";
                Obj.nextElementSibling.style.display = "";

            break;

            case 2:
                Obj.style.display = "none";
                Obj.previousElementSibling.style.display = "";

            break;

        }
        
    }

/*              Fin de ver mas              */
/*==================================================================================================================================*/
/*              Activar orden              */

    // Funcion que activa y desactiva el orden elegido por el usuario
    function activarOrden(Obj){
        // Ver si activa o desactiva este orden
        let cont = 0;

        let info = Obj.dataset.act;

        let seleccion = Obj.classList[1];

        if(info == 1){
            cont = 1;

        }

        if(seleccion == "fa-arrow-up" || seleccion == "fa-arrow-down"){
            
            let up = document.getElementsByClassName("fa-arrow-up");

            for(let item of up) {
                item.dataset.act = 0;
                item.style.color = "black";

            };
            
            let down = document.getElementsByClassName("fa-arrow-down");

            for(let item of down) {
                item.dataset.act = 0;
                item.style.color = "black";

            };

        }

        if(cont == 0){
            Obj.dataset.act = 1;
            Obj.style.color = "green";

        }

    }

/*              Fin de activar orden              */
/*==================================================================================================================================*/
/*              Obtener orden              */

    // Funcion que activa y desactiva el orden elegido por el usuario
    function obtenerOrden(){
        let Orden = "";

        let up = document.getElementsByClassName("fa-arrow-up");

        for(let item of up) {
            if(item.offsetParent){
                if(item.dataset.act == 1){
                    Orden = item.dataset.ord;
                    
                }

            }

        };

        if(Orden == ""){
        
            let down = document.getElementsByClassName("fa-arrow-down");
    
            for(let item of down) {
                if(item.offsetParent){
                    if(item.dataset.act == 1){
                        Orden = item.dataset.ord;
        
                    }
                
                }
    
            };

        }

        return Orden;

    }

/*              Fin de obtener orden              */
/*==================================================================================================================================*/
/*              Obtener pagina              */

    function obtenerPagina(Page){
        if(Page > 1){
            sessionStorage.PageAct = Page;
            sessionStorage.DesAct = ((Page-1)*10);

        }else{
            sessionStorage.PageAct = (Page != undefined)? Page : 1;
            sessionStorage.DesAct = 0;

        }

        return sessionStorage.DesAct;

    }

/*              Fin de obtener pagina              */
/*==================================================================================================================================*/
/*              Obtener temporada              */

    function obtenerTemporada(){
        let temporada = document.getElementById("selectTemporada").value

        return temporada;

    }

/*              Fin de obtener temporada              */
/*==================================================================================================================================*/
/*              Keypress valida              */

    function keyValida(e,valida,input){
        let key = e.keyCode || e.which;
        let tecla = String.fromCharCode(key).toLowerCase();
        let validador = "";
        /* 
            Significado abreviatura
            L = Letras
            T = Tildes
            E = Espacio
            N = Numero
            D = Decimal
            R = Rut
            C = Correo
            Co = Coordenadas
            F = Fecha
            H = Hora
            Ex = Extra
            F = Telefono
        */
        switch(valida){
            case "LT":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz";
            break;
            case "LTE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz ";
            break;
            case "L":
                validador = "abcdefghijklmnñopqrstuvwxyz";
            break;
            case "LE":
                validador = "abcdefghijklmnñopqrstuvwxyz ";
            break;
            case "N":
                validador = "1234567890";
            break;
            case "NE":
                validador = "1234567890 ";
            break;
            case "F":
                validador = "1234567890-+ ";
            break;
            case "LTN":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890";
            break;
            case "LTNE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890 ";
            break;
            case "LN":
                validador = "abcdefghijklmnñopqrstuvwxyz1234567890";
            break;
            case "LNE":
                validador = "abcdefghijklmnñopqrstuvwxyz1234567890 ";
            break;
            case "R":
                validador = "1234567890.-k";
            break;
            case "C":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_";
            break;
            case "ND":
                validador = "-1234567890.";
            break;
            case "NFH":
                validador = "1234567890:- ";
            break;
            case "NF":
                validador = "1234567890-";
            break;
            case "NH":
                validador = "1234567890:";
            break;
            case "LTNEx":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_()°+$,;:=#%/|¿?¡!*[{<>}]&";
            case "LTNExE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_()°+$,;:=#%/|¿?¡!*[{<>}]& ";
            break;

        }

        let especiales = [13];
        let tecla_especial = false
        for(let i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                input.blur();
                break;
            }

        }
        /* if(validador.indexOf(tecla) == -1 && !tecla_especial){ */
            
        let valido = true;
        if(validador.indexOf(tecla) == -1){
            valido = false;

            if(key != 13){
                element = document.getElementById("mensajeKey")
                if(element == null){
                    let mensaje = window.document.createElement('span');
                    mensaje.textContent = "El caracter "+tecla+" no es valido.";
                    mensaje.style.color = "blue";
                    mensaje.id = 'mensajeKey';
    
                    let next = (input.nextSibling == null) ? input.nextSibling : input.nextSibling.nextSibling;
                    input.parentNode.insertBefore( mensaje, next);
                    swal("Atencion", "El caracter "+tecla+" no es valido. \n Caracteres validos: \n "+validador, "info");
    
                }else{
                    element.textContent = "El caracter "+tecla+" no es valido.";
                    swal("Atencion", "El caracter "+tecla+" no es valido. \n Caracteres validos: \n "+validador, "info");
    
                }

            }
        
        }else{
            element = document.getElementById("mensajeKey");  
            if(element != null){
                element.parentNode.removeChild(element);

            }

        }

        return valido;

    }

/*              Fin de keypress valida              */
/*==================================================================================================================================*/
/*              Texto input valido              */

    function textValido(valida,value){
        let validador = "";
        switch(valida){
            case "LT":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz";
            break;
            case "LTE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz ";
            break;
            case "L":
                validador = "abcdefghijklmnñopqrstuvwxyz";
            break;
            case "LE":
                validador = "abcdefghijklmnñopqrstuvwxyz ";
            break;
            case "N":
                validador = "1234567890";
            break;
            case "NE":
                validador = "1234567890 ";
            break;
            case "F":
                validador = "1234567890-+ ";
            break;
            case "LTN":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890";
            break;
            case "LTNE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890 ";
            break;
            case "LN":
                validador = "abcdefghijklmnñopqrstuvwxyz1234567890";
            break;
            case "LNE":
                validador = "abcdefghijklmnñopqrstuvwxyz1234567890 ";
            break;
            case "R":
                validador = "1234567890.-k";
            break;
            case "C":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_";
            break;
            case "ND":
                validador = "-1234567890.";
            break;
            case "NFH":
                validador = "1234567890:- ";
            break;
            case "NF":
                validador = "1234567890-";
            break;
            case "NH":
                validador = "1234567890:";
            break;
            case "LTNEx":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_()°+$,;:=#%/|¿?¡!*[{<>}]&";
            break;
            case "LTNExE":
                validador = "áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.-_()°+$,;:=#%/|¿?¡!*[{<>}]& ";
            break;

        }

        let valido = true;
        let valor = value.toLowerCase();
        let valueLen = value.length;
        for(let i = 0; i < valueLen; i++){
            if(validador.indexOf(valor[i]) === -1){
                valido = false;
                break;

            }

        }

        return valido;

    }

/*              Fin de texto input valido              */
/*==================================================================================================================================*/
/*              Truncar              */

    function truncar(x, posiciones = 0) {
        let s = x.toString()
        let l = s.length
        let decimalLength = s.indexOf('.') + 1
    
        if (l - decimalLength <= posiciones){
            return x
        }
        // Parte decimal del número
        let isNeg  = x < 0
        let decimal =  x % 1
        let entera  = isNeg ? Math.ceil(x) : Math.floor(x)
        // Parte decimal como número entero
        // Ejemplo: parte decimal = 0.77
        // decimalFormated = 0.77 * (10^posiciones)
        // si posiciones es 2 ==> 0.77 * 100
        // si posiciones es 3 ==> 0.77 * 1000
        let decimalFormated = Math.floor(
        Math.abs(decimal) * Math.pow(10, posiciones)
        )
        // Sustraemos del número original la parte decimal
        // y le sumamos la parte decimal que hemos formateado
        let finalNum = entera + 
        ((decimalFormated / Math.pow(10, posiciones))*(isNeg ? -1 : 1))
        
        return finalNum
    
    }  

/*              Fin de truncar              */
/*==================================================================================================================================*/
/*              Devuelve dato o msj sin informacion              */

    function sinInformacion(text) {
        let texto = (text == 0 || (text != null && text != 'NULL' && text != undefined && text != "")) ? text.toString() : text;

        return (texto != null && texto != 'NULL' && texto != undefined && texto != "") ? text : "Sin información";
    
    }  

/*              Fin de devuelve dato o msj sin informacion              */
/*==================================================================================================================================*/
/*              Revisar si existe el element a eliminar              */

    setInterval(function(){
        element = document.getElementById("mensajeKey");  
        if(element != null){
            element.parentNode.removeChild(element);

        }

    }, 2000);

/*              Fin de revisar si existe el element a eliminar              */
/*==================================================================================================================================*/
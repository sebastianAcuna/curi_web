/*==================================================================================================================================*/
/*              Cambiar I de toggle              */

    function cambiarI(){
        var w = window.outerWidth;
        var btn = document.getElementById("menu-toggle");
        var sidebar = document.getElementById("general");

        if(w < 990){
            if(btn.classList.contains("fa-angle-double-left")){
                btn.classList.remove("fa-angle-double-left");
                btn.classList.add("fa-angle-double-right");

            }

            if(sidebar.classList.contains("toggled")){
                btn.classList.remove("fa-angle-double-right");
                btn.classList.add("fa-angle-double-left");

            }

        }else{
            if(btn.classList.contains("fa-angle-double-right")){
                btn.classList.remove("fa-angle-double-right");
                btn.classList.add("fa-angle-double-left");

            }else if(!sidebar.classList.contains("toggled")){
                btn.classList.remove("fa-angle-double-left");
                btn.classList.add("fa-angle-double-right");

            }

        }

    }

/*              FIN-> Cambiar I de toggle              */
/*==================================================================================================================================*/
/*              Activar / Desactivar sidebar              */

    var btn = document.getElementById("menu-toggle");

    btn.addEventListener('click', function(){
        var sidebar = document.getElementById("general");
        
        sidebar.classList.toggle('toggled');

        this.parentElement.classList.toggle('complet-nav');

        cambiarI();

    });

/*              FIN -> Activar / Desactivar sidebar              */
/*==================================================================================================================================*/
/*              Funcion que activa y desactiva seleccion del menu              */

    function agregarActive(click){
        var menu = document.getElementById("menu");

        menu.childNodes.forEach( function(element) {
            if(element.nodeName == "A" && element.classList.contains('activo')){
                element.classList.remove('activo');

            }

        });

        click.classList.add('activo');
        
    }

/*              FIN-> Funcion que activa y desactiva seleccion del menu              */
/*==================================================================================================================================*/
/*              Cargar seleccion de menu en cuerpo de pagina              */

    var menu = document.getElementById("menu");

    menu.addEventListener('click', function(e){
        // console.log(e);
        if(e.target && e.target.nodeName == "LI") {
            if(e.target.id){
                var submenu = e.target.id.slice(9);
                var submenus = document.getElementsByName("sub-"+submenu);

                var cont = submenus.length;

                for(var i = 0; i < cont; i++){
                    submenus[i].classList.toggle('oculto');

                }

            }

        }else if(e.target && e.target.nodeName == "A"){
            if(e.target.id){
                    cambioHash(e.target.id);
            }

        }

        
    });

/*              FIN-> Cargar seleccion de menu en cuerpo de pagina              */
/*==================================================================================================================================*/
/*              Funcion cambia el script dinamicamente              */

    function scriptDinamico(element){

        
        var extra = new Date();
        var script = document.querySelector('script[id=dinamic]');

        if(script){
            script.parentNode.removeChild(script);

        }
        /* console.log("me cargue " + element); */
        var ref = window.document.getElementsByTagName( 'script' )[ 3 ];

        var script = window.document.createElement( 'script' );

        script.src = 'core/controllers/js/'+element+'.js?'+extra.getMonth()+extra.getDate()+extra.getHours()+extra.getMinutes();
        script.id = 'dinamic';

        ref.parentNode.insertBefore( script, ref );
        
    }

/*              FIN-> Funcion cambia el script dinamicamente              */
/*==================================================================================================================================*/
/*              Cambiar contenido cuando cambia el hash              */

    function cambioHash(ref){
        sessionStorage.removeItem("libro");
        sessionStorage.removeItem('filtros');

        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "";

        var seleccion = document.location.hash;
        var limpia = "inicio";
        if(seleccion && ref == null){
            limpia = seleccion.slice(1).toLowerCase();

            var opcion = document.getElementById(limpia);

            if(opcion && limpia != "mantenedor"){

                $("#contenido").load('core/views/'+ limpia + '.php', function(response, status, xhr) {
                    if (status == "error") {
                        document.location = "";

                    }

                    if(status == "success"){
                        if(!document.getElementById("acceso_prohibido")){
                            scriptDinamico(limpia);

                        }

                    }
                    
                });
                
                agregarActive(document.getElementById(limpia));

            }else{
                if(limpia != "mantenedor"){
                    limpia = "inicio";
                    $("#contenido").load('core/views/'+limpia+'.php', function(response, status, xhr) {
                        if (status == "error") {
                            document.location = "";
    
                        }
    
                        if(status == "success"){
                            if(!document.getElementById("acceso_prohibido")){
                                scriptDinamico(limpia);
    
                            }
    
                        }
                        
                    });

                    document.location.hash = "#Inicio";
                    agregarActive(document.getElementById("inicio"));

                }

            }

        }else if(ref != null){
            $("#contenido").load('core/views/'+ref+'.php', function(response, status, xhr) {
                if (status == "error") {
                    document.location = "";

                }

                if(status == "success"){
                    if(!document.getElementById("acceso_prohibido")){
                        scriptDinamico(ref);

                    }

                }
                
            });

            agregarActive(document.getElementById(ref)); 

        }else{
            $("#contenido").load('core/views/'+limpia+'.php', function(response, status, xhr) {
                if (status == "error") {
                    document.location = "";

                }

                if(status == "success"){
                    if(!document.getElementById("acceso_prohibido")){
                        scriptDinamico(limpia);

                    }

                }
                
            });

            agregarActive(document.getElementById("inicio"));             

        }

        /********************************************************/
        /* Define el limite de datos inicial de los integrantes */
        /********************************************************/

            sessionStorage.DesAct = 0;

        /***************************/
        /* Pagina actual de inicio */
        /***************************/

            sessionStorage.PageAct = 1;

    }

/*              FIN -> Cambiar contenido cuando cambia el hash              */
/*==================================================================================================================================*/
/*              Al cargar / Recargar la pestaña, muestre un menu predeterminado o seleccionado              */

    window.addEventListener('load', cambioHash(null));

/*              FIN -> Al cargar / Recargar la pestaña, muestre un menu predeterminado o seleccionado              */
/*==================================================================================================================================*/
/*              Al cambiar el hash carga la pestaña a la que quiere ir              */

    /* window.addEventListener("hashchange", cambioHash(null)); */

/*              FIN -> Al cambiar el hash carga la pestaña a la que quiere ir              */
/*==================================================================================================================================*/
/*              Funcion que ajusta el estado del menu en base a la pantalla              */

    function tamañoPestaña(e){
        var w = window.outerWidth;
        var sidebar = document.getElementById("general");
        var navbar = document.getElementById("navbar");
        var cont = 0;
        
        if (w < 990) {
            if(sidebar.classList.contains("toggled")){
                sidebar.classList.remove("toggled");
                navbar.classList.add("complet-nav");
                cont++;
            
            }else if(!navbar.classList.contains("complet-nav")){
                navbar.classList.add("complet-nav");
                cont++;

            }

        }else{
            if(!sidebar.classList.contains("toggled")){
                navbar.classList.remove("complet-nav");
                sidebar.classList.add("toggled");
                cont++;
            
            }else if(navbar.classList.contains("complet-nav")){
                navbar.classList.remove("complet-nav");
                cont++;

            }

        }

        if(cont > 0){
            cambiarI();

        }

    }

/*              FIN-> Funcion que ajusta el estado del menu en base a la pantalla              */
/*==================================================================================================================================*/
/*              Aplicar funcion tamañoPestaña al cargar y cambiar medidas de la pantalla              */

    window.addEventListener('load', tamañoPestaña);

    window.addEventListener('resize', tamañoPestaña);

/*              FIN-> Aplicar funcion tamañoPestaña al cargar y cambiar medidas de la pantalla              */
/*==================================================================================================================================*/
/*              Cerrar Sesion              */

    document.getElementById("Cerrar").addEventListener("click", function(e){
        $.ajax({
            data:'action=cerrarSesion',
            url: 'core/controllers/php/login.php',
            type:'POST',
            dataType:'JSON'
        })

    });
    
/*              FIN-> Cerrar Sesion              */
/*==================================================================================================================================*/
/*              Temporada              */

    if(document.getElementById("selectTemporada")){

        document.getElementById("btnMenosTemporada").addEventListener('click', function(){
            var select = document.getElementById("selectTemporada");
            var len = select.length;
            var index = select.selectedIndex;
        
            if(index < len-1){
                select.selectedIndex = index+1;
                $("#selectTemporada").select2().trigger('change');
                var hash = document.location.hash;
    
                switch(hash){
                    case "#Inicio":
                        informacion();
                    break;
                    case "#Quotation":
                        informacion();
                    break;
                    case "#Contratos":
                        informacion();
                    break;
                    case "#Prospectos":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionActivas();
                        }else{
                            informacionProvisorias();
                        }

                        break;
                    case "#Export":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionPlanta();
                        }else{
                            informacionRecepcion();
                        }
                    break;
                    case "#Fichas":
                        informacionActivas();
                    break;
                    case "#Libro":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionResumen();
                        }else if(tab.children[1].children[0].classList.contains("active")){
                            informacionTabla(2);
                        }else if(tab.children[2].children[0].classList.contains("active")){
                            informacionTabla(3);
                        }else if(tab.children[3].children[0].classList.contains("active")){
                            informacionTabla(4);
                        }else if(tab.children[4].children[0].classList.contains("active")){
                            informacionTabla(5);
                        }
                    break;
    
                    default:
                        informacion();
                    break;

                }
    
            }
    
        });
    
        document.getElementById("btnMasTemporada").addEventListener('click', function(){
            var select = document.getElementById("selectTemporada");
            var index = select.selectedIndex;

            if(index > 0){
                select.selectedIndex = index-1;
                $("#selectTemporada").select2().trigger('change');
                var hash = document.location.hash;
    
                switch(hash){
                    case "#Inicio":
                        informacion();
                    break;
                    case "#Quotation":
                        informacion();
                    break;
                    case "#Contratos":
                        informacion();
                    break;
                    case "#Prospectos":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionActivas();
                        }else{
                            informacionProvisorias();
                        }
                    break;
                    case "#Export":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionPlanta();
                        }else{
                            informacionRecepcion();
                        }
                        break;
                    case "#Fichas":
                        informacionActivas();
                    break;
                    case "#Libro":
                        if(tab.children[0].children[0].classList.contains("active")){
                            informacionResumen();
                        }else if(tab.children[1].children[0].classList.contains("active")){
                            informacionTabla(2);
                        }else if(tab.children[2].children[0].classList.contains("active")){
                            informacionTabla(3);
                        }else if(tab.children[3].children[0].classList.contains("active")){
                            informacionTabla(4);
                        }else if(tab.children[4].children[0].classList.contains("active")){
                            informacionTabla(5);
                        }
                    break;
                    
                    default:
                        informacion();
                    break;

                }
    
            }
    
        });

        $("#selectTemporada").on('select2:select', function (e) {

            var hash = document.location.hash;

            switch(hash){
                case "#Inicio":
                    informacion();
                break;
                case "#Quotation":
                    informacion();
                break;
                case "#Contratos":
                    informacion();
                break;
                case "#Prospectos":
                    if(tab.children[0].children[0].classList.contains("active")){
                        informacionActivas();
                    }else{
                        informacionProvisorias();
                    }
                break;
                case "#Fichas":
                    informacionActivas();
                break;
                case "#Libro":
                    if(tab.children[0].children[0].classList.contains("active")){
                        informacionResumen();
                    }else if(tab.children[1].children[0].classList.contains("active")){
                        informacionTabla(2);
                    }else if(tab.children[2].children[0].classList.contains("active")){
                        informacionTabla(3);
                    }else if(tab.children[3].children[0].classList.contains("active")){
                        informacionTabla(4);
                    }else if(tab.children[4].children[0].classList.contains("active")){
                        informacionTabla(5);
                    }
                break;
                
                default:
                    informacion();
                break;

            }

        });

        $("#selectTemporada").select2();

    }
    
/*              Fin de temporada              */
/*==================================================================================================================================*/
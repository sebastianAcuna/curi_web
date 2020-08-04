/*==================================================================================================================================*/
/*              Variables globales              */

    var urlDes = "core/controllers/php/inicio.php";

/*              Fin de variables globales              */
/*==================================================================================================================================*/
/*              Traer datos              */

    function totalAgricultores(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalAgricultores&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                document.getElementById("totalAgric").innerText = resp.Total;
    
            }else{
                document.getElementById("totalAgric").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function totalContratos(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalContratos&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                document.getElementById("totalCont").innerText = resp.Total;
    
            }else{
                document.getElementById("totalCont").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function totalQuotation(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalQuotation&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                document.getElementById("totalQuo").innerText = resp.Total;
    
            }else{
                document.getElementById("totalQuo").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function totalEspecies(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalEspecies&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                document.getElementById("totalEsp").innerText = resp.Total;
    
            }else{
                document.getElementById("totalEsp").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function totalHectareas(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalHectareas&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                var total = (resp.Total == null) ? 0 : resp.Total;
                document.getElementById("totalHec").innerText = truncar(total,2);
    
            }else{
                document.getElementById("totalHec").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function totalVisitas(){
    
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=totalVisitas&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){
            if(resp != null && resp.length != 0){
                document.getElementById("totalVis").innerText = resp.Total;
    
            }else{
                document.getElementById("totalVis").innerText = 0;
    
            }

        }).fail(function( jqXHR, textStatus, responseText) {
            console.log(textStatus+" => "+responseText);

        });

    }

    function visPredio() {
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=visPredio&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){

            var datos = new Array();

            if(resp != null && resp.length > 0){
                $.each(resp,function(i,item){
                    datos.push([item.predio,Number(item.visitas)]);
    
                });

            }else{
                datos = [["Sin predios",1]]

            }

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Predios');
            data.addColumn('number', 'Visitas');
            data.addRows(datos);

            var width = 400;
            if(resp != null && resp.length == 1){
                width = 400;

            }else if(resp != null && resp.length > 1 && resp.length < 7){
                width = 600;

            }else if(resp != null && resp.length > 6){
                width = 800;

            }

            var options = {
                width: width,
                legend: { position: 'none' },
                chart: {
                    title: 'Visitas por predio',
                    subtitle: 'Predios que poseen un anexo' },
                axes: {
                    x: {
                        0: { side: 'top', label: 'Predios'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }

            };
      
            var chart = new google.charts.Bar(document.getElementById('visPredio'));
            // Convert the Classic options to Material options.
            chart.draw(data, google.charts.Bar.convertOptions(options));

        });

    }

    function predNoVis() {
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=predNoVis&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){

            var contenido = "";
            var contenido2 = "";
            if(resp != null && resp.length > 0){
                $.each(resp,function(i,item){
                    if(i%2 == 0){
                        contenido += "<li class='list-group-item'>"+item.predio+"</li>";
                        
                    }else{
                        contenido2 += "<li class='list-group-item'>"+item.predio+"</li>";

                    }
    
                });

                document.getElementById('predNoVis1').innerHTML = contenido;
                document.getElementById('predNoVis2').innerHTML = contenido2;

            }else{
                document.getElementById('predNoVis').innerHTML = "<div class='col-lg-12 col-sm-12'><strong>No se encontraron predios no visitados en los ultimos 10 dias</strong></div>";

            }
            

        });

    }

    function haEspecies() {
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=haEspecies&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){

            var datos = new Array();

            if(resp != null && resp.length > 0){
                $.each(resp,function(i,item){
                    datos.push([item.especie,Number(item.ha)]);
    
                });

            }else{
                datos = [["Sin especies",1]]

            }

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Especies');
            data.addColumn('number', 'HA');
            data.addRows(datos);
    
            var options = {
                title:'HA por especie',
                width:600,
                height:400,
                is3D: true
    
            };

            var chart = new google.visualization.PieChart(document.getElementById('haEspecies'));
            chart.draw(data, options);

        });

    }

    function haVariedad() {
        // Temporada de operacion
        var Temporada = document.getElementById("selectTemporada").value;

        $.ajax({
            data:'action=haVariedad&Temporada='+Temporada,
            url: urlDes,
            type:'POST',
            dataType:'JSON',
            async: false
        }).done(function(resp){

            var datos = new Array();

            if(resp != null && resp.length > 0){
                $.each(resp,function(i,item){
                    datos.push([item.variedad,Number(item.ha)]);
    
                });

            }else{
                datos = [["Sin variedades",1]]

            }
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Variedad');
            data.addColumn('number', 'Ha');
            data.addRows(datos);
    
            var options = {
                title:'HA por variedad',
                width:600,
                height:400,
                is3D: true
    
            };

            var chart = new google.visualization.PieChart(document.getElementById('haVariedad'));
            chart.draw(data, options);

        });

    }

/*              Fin de traer datos              */
/*==================================================================================================================================*/
/*              Traer informacion              */

    function drawCharts() {
        haEspecies();
        haVariedad();

    }

    function drawBars() {
        visPredio();

    }

    function informacion() { 
        totalAgricultores();
        totalContratos();
        totalQuotation();
        totalEspecies();
        totalHectareas();
        totalVisitas();
        
        predNoVis();

        google.charts.load('current', {'packages': ['corechart'], 'callback': drawCharts});
        google.charts.load('current', {'packages': ['bar'], 'callback': drawBars});
    
    } 

    informacion();
    
    window.onresize = doALoadOfStuff;

    function doALoadOfStuff() {
        google.charts.load('current', {'packages': ['corechart'], 'callback': drawCharts});
        google.charts.load('current', {'packages': ['bar'], 'callback': drawBars});

    }

/*              Fin de traer informacion              */
/*==================================================================================================================================*/
/*              Div de espera              */

    $(function() {
        var divCarga = document.getElementById("divCargaGeneral");
        divCarga.style.display = "none";

    });
    
/*              Fin de div de espera              */
/*==================================================================================================================================*/
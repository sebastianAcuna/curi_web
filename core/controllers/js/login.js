/*==================================================================================================================================*/
/*              Iniciar sesion              */

    function login(){
        var user = document.getElementById("user").value.trim();
        var pass = document.getElementById("contraseña").value.trim();

        if(user != "" && pass != ""){
            $.ajax({
                data:'action=iniciarSesion&user='+user+'&pass='+pass,
                url: 'core/controllers/php/login.php',
                type:'POST',
                dataType:'JSON'
            }).done(function(resp){
                if(resp == 1){
                    window.location.replace("index.php");

                }else if(resp == 2){
                    swal("Atencion!", "Actualmente su cuenta se encuentra inactiva.", "info");
                    LimpiarCampos();

                }else{
                    swal("Atencion!", "El usuario y/o la contraseña ingresados no son correctos, vuelva a intentarlo.", "error");
                    LimpiarCampos();

                }

            });

        }else{
            swal("Atencion!", "Debe completar ambos campos para poder iniciar sesion.", "error");
            LimpiarCampos();

        }

    }

    var btn = document.getElementById("logear");

    btn.addEventListener('click', function(){
        login();

    });

/*              Fin de iniciar sesion              */
/*==================================================================================================================================*/
/*              Limpiar campos              */

    function LimpiarCampos(){
        document.getElementById("user").value = "";
        document.getElementById("contraseña").value = "";

    }

/*              Fin de limpiar campos              */
/*==================================================================================================================================*/
/*              Al cargar la pestaña              */

    window.addEventListener('load', function(){
        LimpiarCampos();

    });

/*              Fin de al cargar la pestaña              */
/*==================================================================================================================================*/
/*              Al presionar la tecla Enter              */

    window.addEventListener('keypress', function(event) {
        var keycode = event.keyCode || event.which;
        if(keycode == '13') {
            login();

        }

    });

/*              Fin de al presionar la tecla Enter              */
/*==================================================================================================================================*/
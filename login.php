<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--     ICO DE LA PAGINA     -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- Referencia a Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Referencia a estilo del Login -->
    <link rel="stylesheet" href="assets/css/login.css">

    <title>Iniciar Sesion</title>

</head>
<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">

            <!-- Icono -->
            <div class="fadeIn first">
                <img src="assets/images/export-on.png" id="icon" alt="User Icon" />
                <h1>Curimapu Export</h1>
            </div>

            <!-- Formulario -->
            <form id="Iniciar">
                <input type="text" id="user" class="fadeIn second" name="user" placeholder="Ingrese su usuario">
                <input type="password" id="contraseña" class="fadeIn third" name="contraseña" placeholder="Ingrese su contraseña">
                <input type="button" id="logear" class="fadeIn fourth" value="Iniciar sesion">
            </form>

            <div id="formFooter">
                © Zionit
            </div>
        </div>
    </div>

    <!--     SCRIPTS     -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="core/controllers/js/login.js"></script>

</body>
</html>
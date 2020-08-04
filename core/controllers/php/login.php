<?php
    session_start();

    require_once '../secure/login.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/login.php';

            switch ($action) {

                case 'iniciarSesion':
                    $login = new Login();
                    $login->set_user($_REQUEST["user"]);
                    $login->set_pass($_REQUEST["pass"]);
                    echo $login->iniciarSesion();

                break;

                case 'cerrarSesion':
                    $login = new Login();
                    echo $login->cerrarSesion();
                break;

            }

        }

    }
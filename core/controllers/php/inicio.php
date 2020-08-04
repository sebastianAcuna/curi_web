<?php
    require_once '../secure/inicio.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/inicio.php';

            switch ($action) {
                case 'totalAgricultores':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalAgricultores();
                    echo json_encode($inicio->data());

                break;
    
                case 'totalContratos':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalContratos();
                    echo json_encode($inicio->data());
                break;
    
                case 'totalQuotation':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalQuotation();
                    echo json_encode($inicio->data());
                break;
    
                case 'totalEspecies':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalEspecies();
                    echo json_encode($inicio->data());
                break;
    
                case 'totalHectareas':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalHectareas();
                    echo json_encode($inicio->data());
                break;
    
                case 'totalVisitas':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->totalVisitas();
                    echo json_encode($inicio->data());
                break;
    
                case 'visPredio':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->visPredio();
                    echo json_encode($inicio->data());
                break;
    
                case 'predNoVis':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->predNoVis();
                    echo json_encode($inicio->data());
                break;
    
                case 'haEspecies':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->haEspecies();
                    echo json_encode($inicio->data());
                break;
    
                case 'haVariedad':
                    $inicio = new Inicio();
                    $inicio->set_temporada($_REQUEST["Temporada"]);
                    $inicio->haVariedad();
                    echo json_encode($inicio->data());
                break;

            }

        }

    }
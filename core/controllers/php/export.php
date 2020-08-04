<?php
    require_once '../secure/export.php';

    if(isset($_REQUEST['action'])){
        $action=(isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action= filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){

            require_once '../../models/export.php';

            switch ($action) {
                case 'traerDatosPlanta':
                    $exp = new Export();
                    
                    $exp->set_id_esp($_REQUEST['campo0']);
                    $exp->set_id_cli($_REQUEST['campo1']);
                    $exp->set_id_materiales($_REQUEST['campo2']);
                    $exp->set_id_ac($_REQUEST['campo3']);
                    $exp->set_lote_cliente($_REQUEST['campo4']);
                    $exp->set_id_agric($_REQUEST['campo5']);
                    $exp->set_hectareas($_REQUEST['campo6']);
                    $exp->set_fin_lote($_REQUEST['campo7']);
                    $exp->set_kgs_recepcionado($_REQUEST['campo8']);
                    $exp->set_kgs_limpios($_REQUEST['campo9']);
                    $exp->set_kgs_exportados($_REQUEST['campo10']);


                    $exp->set_temporada($_REQUEST['Temporada']);
                    $exp->set_desde($_REQUEST['D']);
                    $exp->set_orden($_REQUEST['Orden']);

                    $exp->traerDatosPlanta();
                    echo json_encode($exp->data());
                    

                break;

                case 'totalDatosPlanta':

                    $exp = new Export();

                    $exp->set_id_esp($_REQUEST['campo0']);
                    $exp->set_id_cli($_REQUEST['campo1']);
                    $exp->set_id_materiales($_REQUEST['campo2']);
                    $exp->set_id_ac($_REQUEST['campo3']);
                    $exp->set_lote_cliente($_REQUEST['campo4']);
                    $exp->set_id_agric($_REQUEST['campo5']);
                    $exp->set_hectareas($_REQUEST['campo6']);
                    $exp->set_fin_lote($_REQUEST['campo7']);
                    $exp->set_kgs_recepcionado($_REQUEST['campo8']);
                    $exp->set_kgs_limpios($_REQUEST['campo9']);
                    $exp->set_kgs_exportados($_REQUEST['campo10']);


                    $exp->set_temporada($_REQUEST['Temporada']);

                    $exp->totalDatosPlanta();
                    echo json_encode($exp->data());

                break;

                case 'traerDatosRecepcion':

                    $exp = new Export();
                    
                    $exp->set_id_esp($_REQUEST['campo0']);
                    $exp->set_id_materiales($_REQUEST['campo1']);
                    $exp->set_id_ac($_REQUEST['campo2']);
                    $exp->set_id_agric($_REQUEST['campo3']);
                    $exp->set_rut_agricultor($_REQUEST['campo4']);
                    $exp->set_lote_campo($_REQUEST['campo5']);
                    $exp->set_numero_guia($_REQUEST['campo6']);
                    $exp->set_peso_bruto($_REQUEST['campo7']);
                    $exp->set_tara($_REQUEST['campo8']);
                    $exp->set_peso_neto($_REQUEST['campo9']);



                   
                    $exp->set_temporada($_REQUEST['Temporada']);
                    $exp->set_desde($_REQUEST['D']);
                    $exp->set_orden($_REQUEST['Orden']);

                    $exp->traerDatosRecepcion();
                    echo json_encode($exp->data());
                   

                break;

                case 'totalDatosRecepcion':
                    $exp = new Export();
                    
                    $exp->set_id_esp($_REQUEST['campo0']);
                    $exp->set_id_materiales($_REQUEST['campo1']);
                    $exp->set_id_ac($_REQUEST['campo2']);
                    $exp->set_id_agric($_REQUEST['campo3']);
                    $exp->set_rut_agricultor($_REQUEST['campo4']);
                    $exp->set_lote_campo($_REQUEST['campo5']);
                    $exp->set_numero_guia($_REQUEST['campo6']);
                    $exp->set_peso_bruto($_REQUEST['campo7']);
                    $exp->set_tara($_REQUEST['campo8']);
                    $exp->set_peso_neto($_REQUEST['campo9']);

                    $exp->set_temporada($_REQUEST['Temporada']);

                    $exp->totalDatosRecepcion();
                    echo json_encode($exp->data());

                break;

            }

        }

    }
<?php
    require_once '../secure/tablas.php';

    if(isset($_REQUEST['action'])){
        $action = (isset($_REQUEST['action'])?$_REQUEST['action']:NULL);
        $action = filter_var($action,FILTER_SANITIZE_STRING);

        $general=new Action();
        $general->setAction($action);

        if(in_array($general->getAction(), $general->getArreglo())){
            
            require_once '../../models/tablas.php';
            
            switch ($action) {
                case 'traerTablas':
                    $tablas = new Tablas();
                    $tablas->traerTablas();
                    $info = $tablas->data();

                    $totalesR = array();
                    $totalesC = array();
                    foreach($info as $dato){
                        $tablas->set_tabla($dato["nombre"]);
                        $tablas->traerTotalRegistros();
                        $total = $tablas->datos();
                        array_push($totalesR,$total["Total"]);

                        $tablas->traerTotalCampos();
                        $total = $tablas->datos();
                        array_push($totalesC,$total["Total"]);

                    }

                    echo json_encode(array($tablas->data(),$totalesR,$totalesC));

                break;

                case 'traerInfo':
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_NUMBER_INT);

                    $respuesta = array();

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->traerDatos();


                    /* SE AGREGA A ARRAY ELEMENTOS ORIGINALES DE LA FUNCION  */
                    array_push($respuesta, $tablas->data());

                    /* SE INSTANCIA NUEVA CLASE PARA TRAER SCHEMA  */
                    $tablas2 = new Tablas();
                    $tablas2->set_tabla($tabla);
                    
                    $tablas2->traerSoloNombreTabla();
                    $tablas2->set_tabla($tablas2->data());
                    $tablas2->traerEstructura();
                    /* SE AGREGA A ARRAY ELEMENTOS DE SCHEMA DE SERVIDOR PREDETERMINADO  */
                    array_push($respuesta, $tablas2->data());
                    

                    /* SE INSTANCIA NUEVA CLASE PARA TRAER SCHEMA  */
                    $tablas3 = new Tablas();
                    $tablas3->set_tabla($tabla);
                    
                    $tablas3->traerSoloNombreTablaProduccion();
                    $tablas3->set_tabla($tablas3->data());
                    $tablas3->traerEstructuraProduccion();
                    /* SE AGREGA A ARRAY ELEMENTOS DE SCHEMA DE SERVIDOR PREDETERMINADO  */
                    array_push($respuesta, $tablas3->data());

                    
                    
                    echo json_encode($respuesta);

                break;

                case 'traerInfoTb':
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->traerEstructura();
                    $info = $tablas->data();

                    $columns = "";
                    $cont = 0;
                    foreach($info as $column){
                        if($cont == 0){
                            $columns .= $column["COLUMN_NAME"];

                        }else{
                            $columns .= ", ".$column["COLUMN_NAME"];

                        }

                        $cont++;

                    }
                    
                    $tablas->set_columns($columns);
                    $tablas->traerDatosTb();
                    echo json_encode(array($info,$tablas->datos()));

                break;

                case 'traerInfoTbCreacion':
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_STRING);
                    
                    $id = (isset($_REQUEST['edi'])?$_REQUEST['edi']:NULL);
                    $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

                    $where = (isset($_REQUEST['column'])?$_REQUEST['column']:NULL);
                    $where = filter_var($where,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->traerEstructura();
                    $info = $tablas->data();

                    $columns = "";
                    $cont = 0;
                    $tabla = array();
                    foreach($info as $column){
                        if($cont == 0){
                            $columns .= $column["COLUMN_NAME"];

                        }else{
                            $columns .= ", ".$column["COLUMN_NAME"];

                        }
                        
                        $tablas->set_columns($column["COLUMN_NAME"]);
                        $tablas->traerNombreTabla();
                        if($tablas->data()){
                            $tabla[$cont] = $tablas->data();

                        }

                        $cont++;

                    }

                    if($id != 0){
                        $tablas->set_id($id);
                        $tablas->set_columns($columns);
                        $tablas->set_valores($where);
                        $tablas->traerRegistro();
                        echo json_encode(array($info,$tablas->datos(),$tabla));

                    }else{
                        echo json_encode(array($info,$tabla));

                    }

                break;

                case 'traerRelaciones':
                    $column = (isset($_REQUEST['column'])?$_REQUEST['column']:NULL);
                    $column = filter_var($column,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_columns($column);
                    $tablas->traerRelaciones();
                    $info = $tablas->data();

                    $totales = array();
                    foreach($info as $dato){
                        $tablas->set_tabla($dato["nombre"]);
                        $tablas->traerTotalRegistros();
                        $total = $tablas->datos();
                        array_push($totales,$total["Total"]);

                    }
                    
                    $tablas->traerNombreTabla();

                    echo json_encode(array($info,$totales,$tablas->data()));

                break;

                case 'traerAsociaciones':
                    $id = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

                    $tablas = new Tablas();
                    $tablas->set_id($id);
                    $tablas->traerAsociaciones();
                    echo json_encode($tablas->data());
                    
                break;

                case 'traerReferencia':
                    $tablas = new Tablas();
                    $tablas->set_tabla($_REQUEST['tabla']);
                    $tablas->set_columns($_REQUEST['column']);
                    $tablas->set_valores($_REQUEST['valor']);
                    $tablas->traerReferencia();
                    echo json_encode($tablas->data());
                    
                break;

                case 'crearRegistro':
                    $campos = (isset($_REQUEST['campos'])?$_REQUEST['campos']:NULL);
                    $campos = filter_var($campos,FILTER_SANITIZE_STRING);
                    $cont = explode(",",$campos);
                    $signo = "";
                    for($i = 0; $i < count($cont); $i++){
                        if($i > 0){
                            $signo .= ",?";

                        }else{
                            $signo .= "?";

                        }

                    }
                    
                    $valores = (isset($_REQUEST['valores'])?$_REQUEST['valores']:NULL);
                    $valores = filter_var($valores,FILTER_SANITIZE_STRING);
                    
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->set_columns($campos);
                    $tablas->set_signo($signo);
                    $tablas->set_valores($valores);
                    $tablas->set_cont($cont);
                    $tablas->crearRegistro();

                break;

                case 'editarRegistro':
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_STRING);

                    $campos = (isset($_REQUEST['campos'])?$_REQUEST['campos']:NULL);
                    $campos = filter_var($campos,FILTER_SANITIZE_STRING);

                    $cont = explode(",",$campos);
                    $columns = "";
                    for($i = 0; $i < count($cont); $i++){
                        if($i > 0){
                            $columns .= ", ".$cont[$i]." = ?";

                        }else{
                            $columns .= $cont[$i]." = ?";

                        }

                    }
                    
                    $valores = (isset($_REQUEST['valores'])?$_REQUEST['valores']:NULL);
                    $valores = filter_var($valores,FILTER_SANITIZE_STRING);
                    
                    $signo = (isset($_REQUEST['where'])?$_REQUEST['where']:NULL);
                    $signo = filter_var($signo,FILTER_SANITIZE_STRING);

                    $id = (isset($_REQUEST['act'])?$_REQUEST['act']:NULL);
                    $id = filter_var($id,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->set_columns($columns);
                    $tablas->set_valores($valores);
                    $tablas->set_cont($cont);
                    $tablas->set_signo($signo);
                    $tablas->set_id($id);
                    $tablas->editarRegistro();

                break;

                case 'eliminarRegistro':
                    $tabla = (isset($_REQUEST['tb'])?$_REQUEST['tb']:NULL);
                    $tabla = filter_var($tabla,FILTER_SANITIZE_STRING);
                    
                    $column = (isset($_REQUEST['column'])?$_REQUEST['column']:NULL);
                    $column = filter_var($column,FILTER_SANITIZE_STRING);

                    $id = (isset($_REQUEST['eli'])?$_REQUEST['eli']:NULL);
                    $id = filter_var($id,FILTER_SANITIZE_STRING);

                    $tablas = new Tablas();
                    $tablas->set_tabla($tabla);
                    $tablas->set_columns($column);
                    $tablas->set_id($id);
                    $tablas->eliminarRegistro();

                break;

            }

        }
    
    }
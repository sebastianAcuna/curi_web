<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            if($_SESSION["tipo_curimapu"] == 5){
                $this->arreglo=array("traerDatosResumen","totalDatosResumen","traerDatosTabla","totalDatosTabla","traerDatosAll","totalDatosAll","traerImagenes","asignarValor","datoForaneo");
            }else{
                $this->arreglo=array("traerDatosResumen","totalDatosResumen","traerDatosTabla","totalDatosTabla","traerDatosAll","totalDatosAll","traerImagenes","datoForaneo");
            }

        }
        public function getArreglo() {
            return $this->arreglo;
        }

        public function getAction() {
            return $this->action;
        }

        public function setArreglo($arreglo) {
            $this->arreglo = $arreglo;
        }

        public function setAction($action) {
            $this->action = $action;
        }


    }
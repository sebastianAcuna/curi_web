<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            if($_SESSION["tipo_curimapu"] == 5){
                $this->arreglo=array("traerDatosActivas","totalDatosActivas","traerDatosProvisorias","totalDatosProvisorias","crearFicha","editarFicha","editarFichaA","activarFicha","rechazarFicha","traerInfoActiva","traerInfoActivar","traerInfoProvisoria","traerRegiones","traerComunas","traerPredio","traerPotrero","traerInfoAgri","traerImagenes","eliminarImagen","subirImagen");
            }else if($_SESSION["tipo_curimapu"] == 4){
                $this->arreglo=array("traerDatosActivas","totalDatosActivas","traerDatosProvisorias","totalDatosProvisorias","traerInfoActiva","traerImagenes","eliminarImagen");
            }else if($_SESSION["tipo_curimapu"] == 3){
                $this->arreglo=array("traerDatosActivas","totalDatosActivas","traerDatosProvisorias","totalDatosProvisorias","traerInfoActiva","crearFicha","editarFicha","traerInfoProvisoria","traerRegiones","traerComunas","traerPredio","traerPotrero","traerImagenes","eliminarImagen");
            }else{
                $this->arreglo=array("");
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
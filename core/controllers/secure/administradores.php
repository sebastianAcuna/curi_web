<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            if($_SESSION["tipo_curimapu"] == 5){
                $this->arreglo=array("traerDatos","totalDatos","crearAdministrador","editarAdministrador","traerInfo","traerComunas","traerRegiones", "traerProvincias");
            }else if($_SESSION["tipo_curimapu"] == 4){
                $this->arreglo=array("traerDatos","totalDatos");
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
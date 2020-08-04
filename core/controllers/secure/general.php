<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            if($_SESSION["tipo_curimapu"] >= 3){
                $this->arreglo=array("traerInfoPerfil","traerRegiones","traerProvincias","traerComunas","ediPerfil");
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
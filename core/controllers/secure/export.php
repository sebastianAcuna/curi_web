<?php

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            $this->arreglo=array("traerDatosPlanta","totalDatosPlanta","traerDatosRecepcion","totalDatosRecepcion");
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
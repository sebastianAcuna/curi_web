<?php

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            $this->arreglo=array("iniciarSesion","cerrarSesion");
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
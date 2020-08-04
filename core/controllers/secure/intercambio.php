<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            $this->arreglo=array("pasoUno","pasoDos","pasoTres","pasoCuatro","limpiarDB","empezarDelete","traerTemporada");

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
<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            $this->arreglo=array("totalAgricultores","totalContratos","totalQuotation","totalEspecies","totalHectareas","totalVisitas","visPredio","predNoVis","haEspecies","haVariedad");
            
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
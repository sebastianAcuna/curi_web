<?php
    session_start();

    class Action {
        private $arreglo;
        private $action;

        public function __construct() {
            if($_SESSION["tipo_curimapu"] == 5 || $_SESSION["tipo_curimapu"] == 3){
                $this->arreglo=array("traerDatosTitulo","totalDatosTitulos", "crearTitulo", "traerInfoTitulo", "editarTitulo", "eliminarTitulo", "traerDatosPropiedades", "totalDatosPropiedades", "crearPropiedad", "editarPropiedad", "traerInfoPropiedad", "eliminarPropiedad", "traerDatosRelacion", "totalDatosRelacion", "eliminarRelacion", "traerInfoRelacion", "crearRelacion", "editarRelacion", "traerPCMCampos", "traerPropiedadesSelect", "traerTituloSelect", "traerEspeciesCheck", "cargarDespuesDe", "cargarTitulosDespuesDe");
            }
            else{
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
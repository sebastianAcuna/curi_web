<?php
    require_once 'dbConfig.php';

    class Conectar{

        /* Datos DB */
        private $hostname = HOST_NAME;
        private $database = DATABASE_NAME;
        private $user = USER;
        private $password = PASSWORD;
        private $charset = CHARSET;

        /* DATOS AMBIENTE */
        private $hostnameAmbiente = HOST_NAME_CONFIGURACION;
        private $databaseAmbiente = DATABASE_NAME_CONFIGURACION;
        private $userAmbiente = USER_CONFIGURACION;
        private $passwordAmbiente = PASSWORD_CONFIGURACION;
        private $charsetAmbiente = CHARSET_CONFIGURACION;


        /* comparar bases de datos */
        private $hostnameDos = HOST_NAME_DOS;
        private $databaseDos = DATABASE_NAME_DOS;
        private $userDos = USER_DOS;
        private $passwordDos = PASSWORD_DOS;
        private $charsetDos = CHARSET_DOS;

        /* conexion a base de datos para descargar  */
        private $hostnameDescarga = HOST_NAME_INTERCAMBIO_DESCARGA;
        private $databaseDescarga = DATABASE_NAME_INTERCAMBIO_DESCARGA;
        private $userDescarga = USER_INTERCAMBIO_DESCARGA;
        private $passwordDescarga = PASSWORD_INTERCAMBIO_DESCARGA;
        private $charsetDescarga = CHARSET_INTERCAMBIO_DESCARGA;

        /* conexion a base de datos para subir */
        private $hostnameSubida = HOST_NAME_INTERCAMBIO_SUBIDA;
        private $databaseSubida = DATABASE_NAME_INTERCAMBIO_SUBIDA;
        private $userSubida = USER_INTERCAMBIO_SUBIDA;
        private $passwordSubida = PASSWORD_INTERCAMBIO_SUBIDA;
        private $charsetSubida = CHARSET_INTERCAMBIO_SUBIDA;

        /*  conexion principal, curimapu_web */
        public function conexion(){

            try{

                $opciones = array(
                            PDO::ATTR_EMULATE_PREPARES=>false,
                            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                        );

                $this->conexion=new PDO('mysql:host='.$this->hostname.';dbname='.$this->database, $this->user, $this->password, $opciones);

                $this->conexion->exec('SET NAMES '.$this->charset.'');

            } catch (PDOException $error){

                echo "¡ERROR: !".$error->getMessage();
                die();

            }

            return $this->conexion;

        }

        /*  conexion a base de datos en  configuracion */
        public function conexionAmbiente(){

            try{

                $opciones = array(
                            PDO::ATTR_EMULATE_PREPARES=>false,
                            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                        );

                $this->conexion=new PDO('mysql:host='.$this->hostnameAmbiente.';dbname='.$this->databaseAmbiente, $this->userAmbiente, $this->passwordAmbiente, $opciones);

                $this->conexion->exec('SET NAMES '.$this->charsetAmbiente.'');

            } catch (PDOException $error){

                echo "¡ERROR: !".$error->getMessage();
                die();

            }

            return $this->conexion;

        }

        /*  conexion para comparar bases de datos, entre desarrollo y produccion */
        public function conexion_produccion(){

            try{

                $opciones = array(
                            PDO::ATTR_EMULATE_PREPARES=>false,
                            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                        );

                $this->conexionDos=new PDO('mysql:host='.$this->hostnameDos.';dbname='.$this->databaseDos, $this->userDos, $this->passwordDos, $opciones);

                $this->conexionDos->exec('SET NAMES '.$this->charsetDos.'');

            } catch (PDOException $error){

                echo "¡ERROR: !".$error->getMessage();
                die();

            }

            return $this->conexionDos;

        }


        /*  conexion para descargar datos de base de datos intercambio */
        public function conexion_descarga(){
            try{

                $opciones = array(
                            PDO::ATTR_EMULATE_PREPARES=>false,
                            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                        );

                $this->conexion_descarga=new PDO('mysql:host='.$this->hostnameDescarga.';dbname='.$this->databaseDescarga, $this->userDescarga, $this->passwordDescarga, $opciones);

                $this->conexion_descarga->exec('SET NAMES '.$this->charset.'');

            }catch(PDOException $error){

                echo "¡ERROR: !".$error->getMessage();
                die();

            }

            return $this->conexion_descarga;
        }


         /*  conexion para subir datos a base de datos intercambio */
        public function conexion_subida(){
            try{

                $opciones = array(
                            PDO::ATTR_EMULATE_PREPARES=>false,
                            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                        );

                $this->conexionSubida=new PDO('mysql:host='.$this->hostnameSubida.';dbname='.$this->databaseSubida, $this->userSubida, $this->passwordSubida, $opciones);

                $this->conexionSubida->exec('SET NAMES '.$this->charset.'');

            }catch(PDOException $error){

                echo "¡ERROR: !".$error->getMessage();
                die();

            }

            return $this->conexionSubida;
        }

    }
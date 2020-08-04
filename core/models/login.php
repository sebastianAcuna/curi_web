<?php
    require_once '../../db/conectarse_db.php';

    class Login{

        private $user, $pass;

        public function set_user($user){
            $user = (isset($user)?$user:NULL);
            $this->user = filter_var($user,FILTER_SANITIZE_STRING);

        }
        
        public function set_pass($pass){
            $pass = (isset($pass)?$pass:NULL);
            $pass = filter_var($pass,FILTER_SANITIZE_STRING);
            $this->pass = md5($pass);

        }
        
        public function iniciarSesion(){
            try{

                /*******/
                /* SQL */
                /*******/

                $conexion = new Conectar();
                $sql = "SELECT U.id_usuario, U.user, U.rut, UTU.id_tu, U.enlazado, U.mod_pass, U.mod_prop FROM usuarios U INNER JOIN usuario_tipo_usuario UTU ON UTU.id_usuario = U.id_usuario WHERE U.user = ? AND U.pass = ?";
                $conexion = $conexion->conexion();
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue("1",$this->user, PDO::PARAM_STR);
                $consulta->bindValue("2",$this->pass, PDO::PARAM_STR);
                $consulta->execute();
                if($consulta->rowCount() > 0){
                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    $_SESSION["user_curimapu"] = $resultado["user"];
                    $_SESSION["rut_curimapu"] = $resultado["rut"];
                    $_SESSION["IDuser_curimapu"] = $resultado["id_usuario"];
                    $_SESSION["tipo_curimapu"] = $resultado["id_tu"];
                    $_SESSION["enlace_curimapu"] = $resultado["enlazado"];
                    $_SESSION["mod_pass_curimapu"] = $resultado["mod_pass"];
                    $_SESSION["prop_curimapu"] = $resultado["mod_prop"];

                    $repuesta = 1;

                }else{
                    $repuesta = 3;

                }

                return $repuesta;
        
            }catch(PDOException $e){
                echo "[INICIAR SESION] -> ha ocurrido un error ".$e->getMessage();

            }
        
            $consulta = NULL;
            $conexion = NULL;

        }

        public function cerrarSesion(){
            try{
                // Destruir todas las variables de sesión.
                $_SESSION = array();

                // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
                // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }

                // Finalmente, destruir la sesión.
                session_destroy();
        
            }catch(PDOException $e){
                echo "[CERRAR SESION] -> ha ocurrido un error ".$e->getMessage();

            }

        }
    
    }
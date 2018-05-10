<!DOCTYPE html>
<?php
session_start();
$_SESSION["servidor"] = "";
$_SESSION["cn"] = "";
$_SESSION["basedn"] = "";
$_SESSION["clave"] = "";
?>
<html lang="en">
    <head>
        <title>Identificacion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/Logo.png"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="scripts/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="styles/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="styles/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="scripts/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="styles/login-util.css">
        <link rel="stylesheet" type="text/css" href="styles/login-main.css">
        <!--===============================================================================================-->
    </head>
    <body>

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img src="images/Logo.png" alt="IMG">
                    </div>

                    <form class="login100-form validate-form" action="php/controlador.php">
                        <span class="login100-form-title">
                            DAPBerry
                        </span>

                        <div class="wrap-input100 validate-input" data-validate = "Es necesario validar el servidor: 172.17.23.218/www.dapberry.com">
                            <input class="input100" type="text" name="servidor" placeholder="Servidor">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-server" aria-hidden="true"></i>
                            </span>
                        </div>
                        
                        <div class="wrap-input100 validate-input" data-validate = "Hay que especificar un usuario: admin">
                            <input class="input100" type="text" name="usuario" placeholder="Usuario">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Debes pertenecer a un dominio: example.com">
                            <input class="input100" type="text" name="dominio" placeholder="Dominio">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-code-fork" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Es necesaria una contraseña">
                            <input class="input100" type="password" name="clave" placeholder="Clave">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        
                        <input type="hidden" name="accion" value="acceder">

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>

<!--                        <div class="text-center p-t-12">
                            <span class="txt1">
                                Forgot
                            </span>
                            <a class="txt2" href="#">
                                Username / Password?
                            </a>
                        </div>-->

<!--                        <div class="text-center p-t-136">
                            <a class="txt2" href="#">
                                Create your Account
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>




        <!--===============================================================================================-->	
        <script src="scripts/jquery/jquery-3.3.1.js"></script>
        <!--===============================================================================================-->
        <script src="scripts/popper/popper.js"></script>
        <script src="scripts/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script src="scripts/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="scripts/tilt/tilt.jquery.min.js"></script>
        <script >
            $('.js-tilt').tilt({
                scale: 1.1
            })
        </script>
        <!--===============================================================================================-->
        <script src="scripts/login-main.js"></script>

    </body>
</html>
<?php
session_start();
require_once("conexion.php");
require("Funciones.php");

$con = conectar_bd();

if (isset($_POST["envio"])) {
    $email = $_SESSION["email"];
    $usuario = obtenerDatosUsuario($email);

  
    $Datos = [$_POST["Red1"], $_POST["Red2"], $_POST["Red3"], $_POST["Red4"]];


    $existe_usr = consultar_existe_usr($con, 'redesd', 'CorrDisc', $email);

    $tabla = 'redesd';
    $columnas = 'CorrDisc, LinkRedeD';


    foreach ($Datos as $red) {
        if (!empty($red)) {
            $valores = [$email, $red];
            insertar_usr($con, $tabla, $columnas, $valores, $existe_usr);
        }
    }
}


header("Location: Login_YM.php");
exit;
?>
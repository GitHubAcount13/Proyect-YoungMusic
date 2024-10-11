<?php
require_once("conexion.php");
require("Funciones.php");

$con = conectar_bd();

if (isset($_POST["envio"])) {
    $email = $_POST["email"];
    $contrasenia = $_POST["pass"];
    logear($con, $email, $contrasenia);
    header("Usuario_YM.php");
}

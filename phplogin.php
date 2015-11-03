<?php
require 'clases/AutoCarga.php';

$usuarios = array(
    "juan" => "abc",
    "pepe" => "abc"
);

$sesion = new Session();

$nombre = Request::post("nombre");
$pass = Request::post("pass");

foreach ($usuarios as $key => $value) {
echo $nombre;
echo $pass;
    if(isset($usuarios[$nombre]) && $usuarios[$nombre] == $pass){
        $user = new Usuario($nombre);
        $sesion->setUser($nombre);
        $sesion->sendRedirect("user.php");
        exit();
    }else{
        $sesion->sendRedirect("phplogout.php");
    }
}
<?php
require 'clases/AutoCarga.php';
$sesion = new Session();
$sesion->leerArchivo();
if (!$sesion->isLogged()) {
    $sesion->sendRedirect("phplogout.php");
    exit();
}
$c = Request::get("c");
$cancion = $sesion->get($c);
$user = $sesion->getUser();
if($user!=$cancion->getUser()){
    echo "esta cancion es privada";
    exit();
}
$sesion->borrarCancion($cancion->getNombre());
header("Location: user.php");
<?php
require 'clases/AutoCarga.php';

$sesion = new Session();
if (!$sesion->isLogged()) {
    $sesion->sendRedirect("phplogout.php");
    exit();
}
$user = $sesion->getUser();

$nombre = Request::post("nombre");
$subir = new FileUpload("input");
$subir->setDestino("canciones/$nombre/");
if(!$subir->subida()){
    echo "Ha ocurrido un error: es posible que las extensiones de los archivos no"
    . " sean los correctos o que el nombre de la cancion que quieres subir ya exista";
    exit();
}

$user = $sesion->getUser();
$genero = Request::post("genero");
$privado = Request::post("privado");

$partesAudio = pathinfo($_FILES["input"]["name"][0]);
$audio = $partesAudio['filename'] . "." . $partesAudio['extension'];
$partesImagen = pathinfo($_FILES["input"]["name"][1]);
$imagen = $partesImagen['filename'] . "." . $partesImagen['extension'];

$fecha = Server::getRequestDate("Y") ."-". Server::getRequestDate("M")."-"
        . Server::getRequestDate("D")."-" . Server::getRequestDate("h")."-"
        . Server::getRequestDate("m");

$cancion = new Cancion($user, $nombre, $genero, $audio, $imagen, $privado);

$arra = array();
$arra[$nombre] = array(
    "user" => $user,
    "genero" => $genero,
    "audio" => $audio,
    "imagen" => $imagen,
    "privado" => $privado,
    "fecha" => $fecha,
    "visitas" => 0
);

$sesion->leerArchivo();
$sesion->addCancion($arra);
$sesion->guardarArchivo();

$sesion->set($cancion);
$sesion->set($nombre, $cancion);
header("Location: escuchar.php?c=$nombre");
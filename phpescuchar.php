<?php

require 'clases/AutoCarga.php';

$sesion = new Session();
if (!$sesion->isLogged()) {
    $sesion->sendRedirect("phplogout.php");
    exit();
}
$cancion = $sesion->getCancion();
$name = $cancion->getNombre();

$img = Request::get("img");
if ($img == 1) {
    $imagen = $cancion->getImagen();
    $trozos = pathinfo($imagen);
    $extension = $trozos["extension"];
    if ($extension == "jpg") {
        header('Content-type: image/jpg');
    } elseif ($extension == "png") {
        header('Content-type: image/png');
    } elseif ($extension == "jpeg") {
        header('Content-type: image/jpeg');
    }
    readfile("../../canciones/$name/$imagen");
}

$aud = Request::get("aud");
if ($aud == 1) {
    $audio = $cancion->getAudio();
    $trozos = pathinfo($audio);
    $extension = $trozos["extension"];
    if ($extension == "mp3") {
        $mime_type = "audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3";
        header('Content-type: {$mime_type}');
        header('Content-length: ' . filesize("../../canciones/$name/$audio"));
        header('Content-Disposition: attachament; filename="'.$audio.'"');
    }
    //echo "../../canciones/$name/$audio";
    //readfile("../../canciones/$name/$audio");
    echo "<embed src =\"../../canciones/$name/$audio\"></embed>";
}
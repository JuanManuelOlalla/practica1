<?php
class Cancion {
    private $user, $nombre, $genero, $audio, $imagen, $privado, $fecha, $visitas;

    function __construct($user=null, $nombre=null, $genero=null, $audio=null, $imagen=null, $privado=false, $fecha=null, $visitas=0) {
        $this->user = $user;
        $this->nombre = $nombre;
        $this->genero = $genero;
        $this->audio = $audio;
        $this->imagen = $imagen;
        $this->privado = $privado;
        $this->fecha = $fecha;
        $this->visitas = $visitas;
    }
    
    function getVisitas() {
        return $this->visitas;
    }

    function setVisitas($visitas) {
        $this->visitas = $visitas;
    }
    function getUser() {
        return $this->user;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getGenero() {
        return $this->genero;
    }

    function getAudio() {
        return $this->audio;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getPrivado() {
        return $this->privado;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function setAudio($audio) {
        $this->audio = $audio;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setPrivado($privado) {
        $this->privado = $privado;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    function mostrarCanciones($arra, $user){
        
    }
}

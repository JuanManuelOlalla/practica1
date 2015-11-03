<?php
class Usuario {
    private $nombre, $clave;
    
    function __construct($nombre=null, $clave=null) {
        $this->nombre = $nombre;
        $this->clave = $clave;
    }
    function getNombre() {
        return $this->nombre;
    }

    function getClave() {
        return $this->clave;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    public function __toString() {
        return $this->nombre;
    }

}

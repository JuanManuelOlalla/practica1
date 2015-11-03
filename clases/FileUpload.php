<?php

class FileUpload {

    private $input;
    private $files;
    private $destino;
    private $nombre;
    private $maximo;
    private $extension;
    private $tipo;
    private $error_php;
    private $arrayDeTipos = array(
        "jpg" => 1,
        "gif" => 1,
        "png" => 1,
        "jpeg" => 1,
        "mp3" => 1
    );
    private $arrayDeImagenes = array(
        "jpg" => 1,
        "gif" => 1,
        "png" => 1,
        "jpeg" => 1,
    );
    private $arrayDeAudios = array(
        "mp3" => 1,
        "m4p" => 1,
        "m4a" => 1,
        "wav" => 1,
    );

    function __construct($param) {
        $this->input = $param;
        $this->nombre = "";
        $this->tipo = array();
        $this->extension = array();
        $this->error_php = UPLOAD_ERR_OK;
        $this->files = $_FILES[$param];
    }

    public function getErrorPHP() {
        return $this->errorPHP;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setNombre($param) {
        $this->nombre = $param;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setMaximo($maximo) {
        $this->maximo = $maximo;
    }

    public function addExtension($param) {
        if (is_array($param)) {
            $this->extension = array_merge($this->extension, $param);
        } else {
            $this->extension[] = $param;
        }
    }

    public function addTipo($tipo) {
        if (!$this->isTipo($tipo)) {
            $this->arrayDeTipos[$tipo] = 1;
            return true;
        }
        return false;
    }

    public function isTipo($tipo) {
        return isset($this->arrayDeTipos[$tipo]);
    }

    public function removeTipo($tipo) {
        if ($this->isTipo($tipo)) {
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }
    
    
    public function isAudio($tipo){
        return isset($this->arrayDeAudios[$tipo]);
    }
    
    public function isImagen($tipo){
        return isset($this->arrayDeImagenes[$tipo]);
    }

    public function getMensajeError() {
        return $this->error_php;
    }

    private function isInput() {
        if (!isset($_FILES[$this->input])) {
            $this->error_php = "NO existe el campo";
            return false;
        }
        return true;
    }

    private function isError() {
        if ($this->files["error"] != UPLOAD_ERR_OK) {
            return true;
        }
        return false;
    }

    private function isTamano() {
        if ($this->files["size"] > $this->maximo) {
            $this->error_php = "sobre pasa tamaño";
            return false;
        }
        return true;
    }

    private function isExtension($param) {
        if (sizeof($this->extension) > 0 &&
                !in_array($param, $this->extension)) {
            $this->error_php = "extension no valida";
            return false;
        }
        return true;
    }

    private function isCarpeta() {
        if (!file_exists($this->destino) && !is_dir($this->destino)) {
            return false;
        }
        return true;
    }

    private function crearCarpeta() {
        return mkdir($this->destino, 0777, true);
    }

    public function subida() {
        
        if (!$this->isCarpeta()) {
            $this->crearCarpeta();
        } else {
            return false;
        }
                
        for ($key=0; $key<2; $key++) {
             
            if ($_FILES[$this->input]["error"][$key] == UPLOAD_ERR_OK) {
                
                $this->files = $_FILES[$this->input];
                $this->errorPHP = $this->files["error"];
                
                $partes = pathinfo($this->files["name"][$key]);
                $extension = $partes['extension'];
                $nombre = $partes['filename'];
                
                if($key==0 && !$this->isAudio($extension)){
                    return false;
                }
                if($key==1 && !$this->isImagen($extension)){
                    return false;
                }
                
                move_uploaded_file($_FILES[$this->input]["tmp_name"][$key], $this->destino . $nombre . "." . $extension);
                
                if($key==1){
                    move_uploaded_file($_FILES[$this->input]["tmp_name"][$key], $this->destino . $nombre . "." . $extension);
                    return true;
                }
            }
        }
    }

}

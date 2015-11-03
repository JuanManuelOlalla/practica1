<?php
class Session {
    private static $iniciada = false;
    
    function __construct($nombre=null) {
        if(!self::$iniciada){
            if($nombre!=null){
                session_name($nombre);
            }
            session_start();
            $this->_control();
        }
        self::$iniciada = true;
    }
    
    private function _control(){
            $ip = $this->get('_ip');
            $cliente = $this->get('_cliente');
            if($ip == NULL & $cliente == NULL){
                $this->set('_ip', Server::getCLientAdress());
                $this->set('_cliente', Server::getUserAgent());
            }else{
                if($ip !== Server::getCLientAdress() || $cliente !== Server::getUserAgent()){
                    $this->destroy();
                    //$this->trusted = false;
                }
            }
    }
    
    function get($nombre) {
        if(isset($_SESSION[$nombre])){
            return $_SESSION[$nombre];
        }
        return null;
    }
    
    function set($nombre, $valor){
        $_SESSION[$nombre]= $valor;
    }
    
    function setUser($usuario){
        $this->set("_usuario", $usuario);
    }
    
    function isLogged(){
        return $this->getUser()!=null;
    }
    
    function getUser(){
        return $this->get("_usuario");
    }
    
    function delete($nombre){
        if(isset($_SESSION["nombre"])){
            unset($_SESSION["nombre"]);
        }
    }
    
    function destroy(){
        session_destroy();
    }
    
    function sendRedirect($destino = "index.php", $final=true){
        header("Location: $destino");
        if($final===true){
            exit();
        }
    }
    
    function borrarCancion($nombre) {
        $arra = $this->getArra();
        array_map('unlink', glob("canciones/$nombre/*"));
        rmdir("canciones/$nombre");
        $this->delete($nombre);
        unset($arra[$nombre]);
        $this->setArra($arra);
        $this->guardarArchivo();
    }
    
    function get2AleatoriosCreadosHoy(){
        $arra = $this->getArra();
        $ano = Server::getRequestDate("Y"); $mes = Server::getRequestDate("M"); $dia = Server::getRequestDate("D");
        $arraHoy = array();
        $flag = false;
        foreach ($arra as $key=> $fila) {
            $partes = explode("-", $arra[$key]["fecha"]);
            if($partes[0]==$ano){
                if($partes[1]==$mes){
                    if($partes[2]==$dia){
                        if($arra[$key]["privado"]!="ON"){
                            array_push($arraHoy, $arra[$key]);
                            $flag = true;
                            $save = $key;
                        }
                    }
                }
            }
        }
        if($flag==false){ return "No hay canciones subidas hoy"; }
        if(count($arraHoy)==1){
            $a = array();
            $a[$save] = $arra[$save];
            return $a;
        }
        $aleatorio = rand(0, count($arraHoy)-1);
        $aleatorio2 = $aleatorio;
        while($aleatorio2==$aleatorio){
            $aleatorio2 = rand(0, count($arraHoy)-1);
        }
        $arraAleatorio = array(); 
        $n = 0;
        foreach ($arra as $key=> $fila) {
            if($n==$aleatorio || $n==$aleatorio2){
                $arraAleatorio[$key]=$arra[$key];
            }
            $n = $n+1;
        }
        //$arraAleatorio = array_rand($arraHoy, 2);
        return $arraAleatorio;
    }
    
    function getMasVista(){
        $arra = $this->getArra();
        $ordenado = array();
        $publicas = array();
        foreach ($arra as $key=> $fila) {
            if($arra[$key]["privado"]!="ON"){
                $publicas[$key] = $arra[$key];
            }
        }
        foreach ($publicas as $key=> $fila) {
            $ordenado[$key] = $fila["visitas"];
            $save = $key;
        }
                
        if(count($ordenado)==0){ return false; }
        if(count($ordenado)==1){
            $a = array();
            $a[$save] = $publicas[$save];
            return $a;
        }
        array_multisort($ordenado, SORT_NUMERIC, SORT_DESC, $publicas);
        return array_slice($publicas, 0, 1, true);
    }
    
    function ordenarArra($orden){
        $tipo = SORT_STRING;
        $tipo2 = SORT_ASC;
        $arra = $this->getArra();
        if($orden=="visitas"){
            $tipo = SORT_NUMERIC;
            $tipo2 = SORT_DESC;
        }
        if($orden=="masAntiguo"){
            $orden="fecha";
        }
        if($orden=="nombre"){
            ksort($arra);
            $this->setArra($arra);
            return;
        }
        $ordenado = array();
        foreach ($arra as $key=> $fila) {
            $ordenado[$key] = $fila[$orden];
        }
        array_multisort($ordenado, $tipo, $tipo2, $arra);
        
        $this->setArra($arra);
    }
    
    function setArra($arra){
        $this->set("_arra", $arra);
    }
    
    function getArra(){
        return $this->get("_arra");
    }
    
    function doVisita($nombre){
        $arra=$this->getArra();
        $arra[$nombre]["visitas"]= $arra[$nombre]["visitas"]+1;
        $this->setArra($arra);
    }
    
    function addCancion($arra2){
        if(file_exists("canciones/archivo.txt")){
            $arra = array_merge($arra2, $this->getArra());
            $this->setArra($arra);
        }else{
            $this->setArra($arra2);
        }
    }
    
    function guardarArchivo() {
        $arra = $this->getArra();
        file_put_contents("canciones/archivo.txt", serialize($arra));
    }

    function leerArchivo() {
        if(file_exists("canciones/archivo.txt")){
            $this->setArra(unserialize(file_get_contents("canciones/archivo.txt")));
            return true;
        }else{
            return false;
        }
    }
    
}

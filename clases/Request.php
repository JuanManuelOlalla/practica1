<?php

class Request {
    
    //filtrar y limpiar valores
    private static function clean($valor, $filtrar){
        if($filtrar===true){
            $valor = htmlspecialchars($valor);
        }
        return trim($valor);
    }
    
    //$_GET[nombre], $_POST[nombre]
    private static function read($parametro, $filtrar=true, $indice = null) {
        if(is_array($parametro)){
            if ($indice === null) {
                $array = array();
                foreach ($parametro as $value) {
                    $array[] = self::clean($value, $filtrar);
                }
                return $array;
            } else if($parametro[$indice]){
                return self::clean($parametro[$indice], $filtrar);
            }
        } else{
            return self::clean($parametro, $filtrar);
        }
    }
    static function get($nombre, $filtrar=true, $indice = null) {
        if (isset($_GET[$nombre])) {
            return self::read($_GET[$nombre], $filtrar, $indice);
        }
        return null;
    }

    static function post($nombre, $filtrar=true, $indice = null) {
        if (isset($_POST[$nombre])) {
            return self::read($_POST[$nombre], $filtrar, $indice);
        }
        return null;
    }

    static function req($nombre, $indice =null) {
        $valor = self::post($nombre, $indice);
        if ($valor !== null) {
            return $valor;
        }
        return self::get($nombre, $indice);
    }

    static function readArray($nombre, $indice = null) {
        if (isset($_GET[$nombre])) {
            if ($indice === null) {
                $array = array();
                foreach ($_GET[$nombre] as $value) {
                    $array[] = self::clean($value);
                }
                return $array;
            } else if($_GET[$nombre][$indice]){
                return self::clean($_GET[$nombre][$indice]);
            }
        }
        return null;
    }

    static function numeroDeValores($nombre) {
        if ($nombre != null) {
            return count(self::req($nombre));
        }
        return null;
    }

    static function readArray2($nombre, $indice = null) {
        $array = self::req("$nombre");
        $valores = "";
        if ($indice === null && $array != null) {
            foreach ($array as $clave => $valor) {
                $valores .= "<br/>indice: $clave; valor: $valor<br/>";
            }
            return $valores;
        } else if ($array != null && isset($array[$indice])) {
            $valores = "<br/>indice: $indice; valor: $array[$indice]<br/>";
            return $valores;
        }
        return null;
    }
}

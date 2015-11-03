<?php
    require 'clases/AutoCarga.php';

    function mostrarTodos(){
        $sesion = new Session();
        $user = $sesion->getUser();
        $arra2 = unserialize(file_get_contents("canciones/archivo.txt"));
        foreach ($arra2 as $key => $valor) {
            if ($arra2[$key]["privado"] == "ON" && $user != $arra2[$key]["user"]) {
                //No muestra los videos privados de otros users.
            } else {
                echo '<img src="canciones/' . $key . '/' . $arra2[$key]["imagen"] . '"/>';
                $cancion = new Cancion($arra2[$key]["user"], $key, $arra2[$key]["genero"], $arra2[$key]["audio"], $arra2[$key]["imagen"], $arra2[$key]["privado"]);
                $sesion->set($key, $cancion);
                echo "<a href=\"escuchar.php?c=$key\">Escuchar</a>";
            }
        }
    }
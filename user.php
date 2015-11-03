<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>usuario</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <section id="contenedor">
        <header>
        <a href="index.php"><img id="logo" src="css/images/podcast.png"/></a>
        <a href="index.php">Index</a>
        <a href="buscar.php">Canciones</a>
        <a href="user.php">perfil</a>
        </header>
        <section id="menu">
        </br>
        </br>
        <a href="new.php">NuevaCancion</a>
        </br>
        </br>
        <a href="phplogout.php">Logout</a>
        </section>
        <?php
        require 'clases/AutoCarga.php';
        $sesion = new Session();
        $sesion->leerArchivo();
        
        if (!$sesion->isLogged()) {
            $sesion->sendRedirect("phplogout.php");
            exit();
        }
        $user = $sesion->getUser();
        if (file_exists("canciones/archivo.txt")) {
            $arra2 = $sesion->getArra();
            echo "</br></br>"."Canciones de: $user";

            foreach ($arra2 as $key => $value) {
                if ($arra2[$key]["user"] == $user) {
                    echo '<section class="izquierda"> <a href="escuchar.php?c='.$key.'"> <img class="imagenesBuscar" src="canciones/' . $key . '/' . $arra2[$key]["imagen"] . '"/></a></section>';

                    $cancion = new Cancion($user, $key, $arra2[$key]["genero"], $arra2[$key]["audio"], $arra2[$key]["imagen"], $arra2[$key]["privado"]);
                    $sesion->set($key, $cancion);
                    echo "<section class=\"derecha\">";
                    echo "</br>".$key;
                    echo "</br>".$arra2[$key]["visitas"];
                    echo "</br>".$arra2[$key]["genero"];
                    echo "</br>".$arra2[$key]["fecha"];
                    echo "</br>"."<a href=\"phpBorrar.php?c=$key\">Borrar</a>";
                    echo "</section>";
                }
            }
        } else {
            echo "Sin canciones";
        }
        ?>
        </section>
    </body>
</html>

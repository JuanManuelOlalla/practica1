<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Escuchar</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <section id="contenedor">
            <header>
                <a href="index.php"><img id="logo" src="css/images/podcast.png"/></a>
                <a href="index.php">Index</a>
                <a href="buscar.php">Canciones</a>
                <?php
                require 'clases/AutoCarga.php';
                $sesion = new Session();
                $sesion->leerArchivo();
                $c = Request::get("c");
                $user = $sesion->getUser();
                if (!$sesion->isLogged()) {
                    ?>
                    <form id="formu1" action="phplogin.php" method="POST">
                        <input type="text" name="nombre" value="" placeholder="usuario"/>
                        <input type="password" name="pass" value="" placeholder="contraseña"/><input type="submit" value="ok" />
                    </form>
                </header>
                    <?php
                } else {
                    ?>
                    <a href="user.php">Mis canciones</a>
                    <a href="phplogout.php">Logout</a>
                    
                    <?php
                }
                $cancion = $sesion->get($c);
                if ($cancion->getPrivado() == "ON" && $user != $cancion->getUser()) {
                    echo "esta cancion es privada";
                    exit();
                }
                $name = $cancion->getNombre();
                $imagen = $cancion->getImagen();
                $audio = $cancion->getAudio();

                $sesion->doVisita($name);
                $sesion->guardarArchivo();

                echo "</br></br></br>Reproduciendo:" . $cancion->getNombre();
                echo "</br><img id=\"imagenReproducir\" src=\"canciones/$name/$imagen\"/>";
                echo "<embed id=\"repro\" src =\"canciones/$name/$audio\" autostart=\"true\" play=\"true\">";
                ?>
                </body>
                </html>

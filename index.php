<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>inicio</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <section id="contenedor">
        <header>
        <?php
        require 'clases/AutoCarga.php';
        $sesion = new Session();
        if (!$sesion->isLogged()) {
            ?>
            <form id="formu1" action="phplogin.php" method="POST">
                <input type="text" name="nombre" value="" placeholder="usuario"/>
                <input type="password" name="pass" value="" placeholder="contraseña"/><input type="submit" value="ok" />
            </form>
            <?php
        } else {
            ?>
            <a href="phplogout.php">Logout</a>
            <?php
        }
        ?>
        <a href="index.php"><img id="logo" src="css/images/podcast.png"/></a>
        <a href="index.php">Index</a>
        <a href="buscar.php">Canciones</a>
        <a href="user.php">perfil</a>
        </header>
        <?php
        if (!$sesion->leerArchivo()) {
            echo "No hay canciones";
            exit();
        }
        ?>
        <section id="masVista">
        <?php
        $cancionMasVista = $sesion->getMasVista();
        if ($cancionMasVista == false) {
            echo "Todas las canciones son privadas";
        } else {
            echo "<section id=\"titulo1\">Cancion mas escuchada:</section>";
            $key = key($cancionMasVista);
            $cancion = new Cancion($cancionMasVista[$key]["user"], $key, $cancionMasVista[$key]["genero"], $cancionMasVista[$key]["audio"], $cancionMasVista[$key]["imagen"], $cancionMasVista[$key]["privado"]);
            $sesion->set($key, $cancion);
            echo '<a href="escuchar.php?c='.$key.'"> <img class="imagenes" src="canciones/' . $key . '/' . $cancionMasVista[$key]["imagen"] . '"/></a>';            
            echo "</br>$key";
            ?>
            </section>
            <section id="aleatorias">
            <?php
            echo "</br></br>";
            echo "<section id=\"titulo1\">Canciones aleatorias subidas hoy:</section>";
            $aleatorias = $sesion->get2AleatoriosCreadosHoy();
            foreach ($aleatorias as $key => $valor) {
                echo '<a href="escuchar.php?c='.$key.'"> <img class="imagenesAle" src="canciones/' . $key . '/' . $aleatorias[$key]["imagen"] . '"/></a>';
                $cancion = new Cancion($aleatorias[$key]["user"], $key, $aleatorias[$key]["genero"], $aleatorias[$key]["audio"], $aleatorias[$key]["imagen"], $aleatorias[$key]["privado"]);
                $sesion->set($key, $cancion);
            }
        }
        ?>
        </section>
    </body>
</html>

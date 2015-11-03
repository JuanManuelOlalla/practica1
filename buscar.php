<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>canciones</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <section id="contenedor">
        <header>
        <a href="index.php"><img id="logo" src="css/images/podcast.png"/></a>
        <a href="index.php">Index</a>
        <a href="buscar.php">Canciones</a>
        <a href="user.php">perfil</a>
        <?php
        require 'clases/AutoCarga.php';
        $sesion = new Session();
        $user = $sesion->getUser();

        $nom = Request::get("nom");
        $gene = Request::get("gene");
        $orden = Request::get("orden");
        ?>
        
        <?php
        if (!$sesion->isLogged()) {
            ?>
            <form id="formu1" action="phplogin.php" method="POST">
                <input type="text" name="nombre" value="" placeholder="usuario"/>
                <input type="password" name="pass" value="" placeholder="contraseña"/><input type="submit" value="ok" />
            </form>
            <?php
        } else {
            ?>
            <a href="user.php">Mis canciones</a>
            <a href="phplogout.php">Logout</a>
            <?php
        }
        ?>

        </header>
        <form id="formu2" action="buscar.php" method="get" enctype="multipart/form-data">
            <input type="text" name="nom" value="" placeholder="nombreCancion"/>Genero:
            <select name="gene">
                <option>todos</option>
                <option>rock</option>
                <option>country</option>
                <option>blues</option>
                <option>reggae</option>
                <option>rap</option>
                <option>classic</option>
            </select>
            Ordenar:
            <select name="orden">
                <option>masAntiguo</option>
                <option>visitas</option>
                <option>genero</option>
                <option>user</option>
                <option>nombre</option>
            </select></br>
            <input type="submit" value="buscar" />
        </form>

        <?php
        if (file_exists("canciones/archivo.txt")) {
            if (isset($orden)) {
                $sesion->ordenarArra($orden);
                echo "</br>"."Ordenado por: $orden";
            }
            $arra2 = $sesion->getArra();
            foreach ($arra2 as $key => $valor) {
                if ($arra2[$key]["privado"] == "ON" && $user != $arra2[$key]["user"]) {
                    //No muestra los videos privados de otros users.
                } else {
                    if ($nom == $key || !isset($nom) || $nom == "") { //filtro por nombre
                        if ($gene == $arra2[$key]["genero"] || !isset($gene) || $gene == "todos") { //filtro por genero
                            echo '<section class="izquierda"> <a href="escuchar.php?c='.$key.'"> <img class="imagenesBuscar" src="canciones/' . $key . '/' . $arra2[$key]["imagen"] . '"/></a></section>';
                            ?> <section class="derecha">
                            <?php
                            echo "</br>".$key;
                            echo "</br>".$arra2[$key]["visitas"];
                            echo "</br>".$arra2[$key]["genero"];
                            echo "</br>".$arra2[$key]["fecha"];
                            echo "</br>".$arra2[$key]["user"];
                            $cancion = new Cancion($arra2[$key]["user"], $key, $arra2[$key]["genero"], $arra2[$key]["audio"], $arra2[$key]["imagen"], $arra2[$key]["privado"]);
                            $sesion->set($key, $cancion);
                            ?></section>
                            <?php
                        }
                    }
                }
            }
        } else {
            echo "sin canciones";
        }
        ?>
        
        </section>
    </body>
</html>

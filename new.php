<!DOCTYPE html>
        <?php
        require 'clases/AutoCarga.php';
            $sesion = new Session();
            if(!$sesion->isLogged()){
                $sesion->sendRedirect("phplogout.php");
                exit();
            }
            $user = $sesion->getUser();
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nueva Cancion</title>
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
        <a href="phplogout.php">Logout</a>
        </section>
        <div>
            </br>Nueva canción:</br></br>
            <form action="phpnew.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" value="" placeholder="nombreCancion" required="required"/></br>
                <select name="genero">
                    <option>rock</option>
                    <option>country</option>
                    <option>blues</option>
                    <option>reggae</option>
                    <option>rap</option>
                    <option>classic</option>
                </select></br>
                Audio: <input type="file" name="input[]" value="" required="required"/></br>
                Imagen: <input type="file" name="input[]" value="" required="required"/></br>
                privado:<input type="checkbox" name="privado" value="ON" /></br>
                <input type="submit" value="Crear" />
            </form>
        </div>
    </body>
</html>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Procesar Archivo</title>
        <script src="js/jquery.js"></script>
        <script src="js/javascript.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>
        <div class="content">
            <a href="index.html">INDEX </a> <br>
            <a href="agregar.html">Agregar un Empleado </a><br> 
            <a href="file_empleados.html">Agregar Empleados desde archivo</a><br>
            <a href="del_registros.php">Eliminar Registros </a><br> 
            <a href="del_empleados.php">Eliminar tabla Empleados</a>
            <?php
                /*
                origen: 
                */

                include('conectar.php');
                //include('conectar_local.php');
                $ruta="archivos/";   //REMOTA
                $query="";
                //$ruta="c:/"; //LOCAL
                $allowedExts = array("txt", "dat");
                $extension = end(explode(".", $_FILES["file"]["name"]));
                if (($_FILES["file"]["type"] == "text/plain")
                    || ($_FILES["file"]["type"] == "application/txt")
                    || ($_FILES["file"]["type"] == "text/anytex")
                    || ($_FILES["file"]["type"] == "application/octet-stream")
                    && in_array($extension, $allowedExts))

                {
                    if ($_FILES["file"]["error"] > 0)
                    {
                        echo "Error: " . $_FILES["file"]["error"] . "<br>";
                    }
                    else
                    {
                        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                        echo "Type: " . $_FILES["file"]["type"] . "<br>";
                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                        echo "Almacenamiento temporal: " . $_FILES["file"]["tmp_name"]."<br>";
                        $ruta=$ruta . $_FILES["file"]["name"];

                        echo "ruta a subir: ".$ruta;
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                            $ruta);
                        echo "<br>ruta a subir".$ruta;
                        echo "<br>Archivo subido correctamente : " . $ruta;

                        if($con) echo "<br>conexion establecida";
                        else echo "<br>error en la conexión";


                        //$ruta = "archivos/" . $_FILES["file"]["name"];
                        echo "<br>ruta: ".$ruta;
                        if(file_exists($ruta))
                        {
                            $query="LOAD DATA INFILE ";
                            $query.="'".$ruta."'";
                            $query.=" REPLACE INTO TABLE empleado (numEmpleado,nombre,apellidoPaterno,apellidoMaterno)";
                            if(mysqli_query($con,$query))
                                echo "<br>información cargada";
                            else echo "<br>error en cargar archivo a la DB ".mysqli_error($con);
                        }            
                        echo "<br>query: $query";
                    }
                }
                else
                {
                    echo "Archivo no cargado";
                }
                mysqli_close($con);
            ?>
        </div>
    </body>
</html>
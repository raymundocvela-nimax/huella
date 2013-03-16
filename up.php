<?php
    include('conectar.php');
    $ruta="archivos/";
    //$ruta="c:/";
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

            echo "ruta a subir: ".$ruta . $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"],
                $ruta . $_FILES["file"]["name"]);
            echo "<br>ruta a subir".$ruta . $_FILES["file"]["name"];
            echo "<br>Archivo subido correctamente : " . $ruta . $_FILES["file"]["name"];

            if($con) echo "<br>conexion establecida";
            else echo "<br>error en la conexión";


            $ruta = "archivos/" . $_FILES["file"]["name"];
            echo "<br>ruta: ".$ruta;
            if(file_exists($ruta))
            {
                $query="LOAD DATA INFILE ";
                $query.="'".$ruta."'";
                $query.=" REPLACE INTO TABLE registro (numEmpleado,Fecha,Hora)";
                if(mysqli_query($con,$query))
                    echo "<br>información cargada";
                else echo "<br>error en cargar archivo a la DB ".mysqli_error($con);
            }            
            echo "<br> $query";
        }
    }
    else
    {
        echo "Archivo no cargado";
    }
    mysqli_close($con);
?>
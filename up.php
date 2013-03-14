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
            echo "ruta a subir".$ruta . $_FILES["file"]["name"];
            echo "Archivo subido correctamente : " . $ruta . $_FILES["file"]["name"];
            
            if($con)
            echo "<br>conexion establecida";
            else echo "<br>error en la conexión";
            
            $query="LOAD DATA INFILE ";
            $query.="'".$ruta . $_FILES["file"]["name"]."'";
            
            
            $query.=" REPLACE INTO TABLE registro (numEmpleado,Fecha,Hora)";
            if(mysql_query($query,$con))
            echo "<br>información cargada";
            else
            echo "<br>error en cargar archivo a la DB ".mysql_error($con);
            echo "<br> $query";                   
        }
    }
    else
    {
        echo "Archivo no cargado";
    }
?>
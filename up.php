<?php
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
            echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br>";

            move_uploaded_file($_FILES["file"]["tmp_name"],
                "archivos/" . $_FILES["file"]["name"]);
            echo "Archivo subido correctamente : " . "archivos/" . $_FILES["file"]["name"];
        }
    }
    else
    {
        echo "Invalid file";
    }
?>
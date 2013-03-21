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
                origen: up_empleados

                Script que recoge el nombre del archivo con la lista completa de empleados
                cargado al servidor,
                verifica que sea valido
                verifica que el empleado no este en tabla empleado
                si- manda alerta
                no- inserta el registro num empleado nombre a tabla empleado
                */
                include('conectar.php');
                //include('conectar_local.php');
                $ruta="archivos/";   //REMOTA
                //$ruta="c:/"; //LOCAL


                //extensiones permitidas
                $allowedExts = array("txt", "dat");
                $extension = end(explode(".", $_FILES["file"]["name"]));
                if (($_FILES["file"]["type"] == "text/plain")
                    || ($_FILES["file"]["type"] == "application/txt")
                    || ($_FILES["file"]["type"] == "text/anytex")
                    || ($_FILES["file"]["type"] == "application/octet-stream")
                    && in_array($extension, $allowedExts))
                {
                    if ($_FILES["file"]["error"] > 0){
                        echo "Error: " . $_FILES["file"]["error"] . "<br>";
                    }
                    else{
                        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                        echo "Type: " . $_FILES["file"]["type"] . "<br>";
                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                        echo "Almacenamiento temporal: " . $_FILES["file"]["tmp_name"]."<br>";
                        $ruta=$ruta.$_FILES["file"]["name"];
                        echo "ruta a subir: ".$ruta;
                        //movemos archivo de almacenamiento temporal a directorio
                        if(move_uploaded_file($_FILES["file"]["tmp_name"],$ruta))
                            echo "<br>Archivo subido correctamente : " . $ruta;
                        else echo "error, archivo no subido";

                        //procesamos archivo
                        if($fp=fopen($ruta,"r")){
                            while(!feof($fp)){               
                                $line=fgets($fp);
                                echo "<br><br>".$numEmpleado=strtok($line," \t");
                                echo " ".$ap=strtok(" \t");
                                echo " ".$am=strtok(" \t");
                                $nom1=strtok(" \t");
                                if($nom2=strtok(" \t")) $nombre=$nom1." ".$nom2;
                                else $nombre=$nom1;
                                echo " ".$nombre;
                                //Verificar si ya existe registro con numEmpleado de tabla empleado
                                $query="SELECT idEmpleado,nombre,apellidoPaterno,apellidoMaterno FROM empleado WHERE numEmpleado ='$numEmpleado'";
//                                echo "<br>$query";
                                $res=mysqli_query($con,$query);
                                if($row=mysqli_fetch_array($res)){
                                    $idEmp=$row[0];
                                    //Ya existe empleado, no agregar
                                    echo "<br>Verifica los datos, Ya existe empleado con: <br>
                                    IdEmp=$idEmp<br>
                                    numEMpleado:  $numEmpleado<br>
                                    nombre: $row[1] $row[2] $row[3]";
                                }
                                //No existe Registro, insertamos
                                else{
                                    $query="INSERT INTO empleado (numEmpleado,nombre,apellidoPaterno,apellidoMaterno) VALUES ('$numEmpleado','$nombre','$ap','$am')";
                                    if(mysqli_query($con,$query)) echo "<br>Empleado agregado correctamente";
                                    else echo "empleado no agregado".mysqli_error($con);
//                                    echo "<br>".$query;                            
                                }
                            }
                        }
                        else echo "<br>error al abrir el archivo ";
                    }
                }
                mysqli_close($con);
            ?>
        </div>
    </body>
</html>
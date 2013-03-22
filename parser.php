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
                origen: index.php
                Script que recoge el nombre del archivo con los registros de todos los empleados
                cargado al servidor,
                verifica que sea valido
                recupera de tabla empleado idEmpleado segun numEmpleado,
                verifica si en tabla registroEmpleado hay registros con IdEmpleado y fecha indicados
                Si- obtiene idRegistro e inserta registro idRegistro y Hora nuevo a tabla registroHora
                No- Inserta idEmpleado y fecha, recupera IdRegistro,
                Inserta idRegistro y hora en tabla registroHora

                */
                include('conectar.php');
                //include('conectar_local.php');
                $query="SELECT idEmpleado FROM empleado";
                $res=mysqli_query($con,$query);
                //Tabla vacía??
                if($row=mysqli_fetch_array($res)){
                    $ruta="archivos/";   //REMOTA
                    //$ruta="c:/archivos/"; //LOCAL

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
                            //movemos archivo de lmacenamiento temporal a directorio
                            if(move_uploaded_file($_FILES["file"]["tmp_name"],$ruta))
                                echo "<br>Archivo subido correctamente : " . $ruta;
                            else echo "error, archivo no subido";

                            //procesamos archivo            
                            if($fp=fopen($ruta,"r")){
                                while(!feof($fp)){               
                                    $line=fgets($fp);
                                    echo "<br><br>".$numEmpleado=strtok($line," \t");
                                    echo "\t".$fecha=strtok(" \t");
                                    echo "\t".$hora=strtok(" \t");
                                    $idEmp="";
                                    $idRegistro="";
                                    //Existe el empleado?
                                    $query="SELECT idEmpleado FROM empleado WHERE numEmpleado ='$numEmpleado'";
//                                    echo "<br>$query";
                                    $res=mysqli_query($con,$query);
                                    //Recuperar idEmpleado de tabla empleado
                                    if($row=mysqli_fetch_array($res)){
                                        $idEmp=$row[0];
//                                        echo "<br>El IdEmp=$idEmp";
                                        //existe registro con ese idEmp y fecha en la tabla registroempleado?
                                        $query="SELECT idRegistro FROM registroEmpleado WHERE empleado_idEmpleado='$idEmp' AND Fecha='$fecha'";
//                                        echo "<br>$query";
                                        $res=mysqli_query($con,$query);
                                        if($row=mysqli_fetch_array($res,MYSQLI_NUM)){
                                            $idRegistro=$row[0];
                                            //Si existe
                                            echo "<br> Ya hay empleado con idEmp=$idEmp y fecha: $fecha";
                                        }else{
                                            //No existe, Insertamos nuevo Registro en tabla registroEmpleado
                                            $query="INSERT INTO registroEmpleado (empleado_idEmpleado,Fecha) VALUES('$idEmp','$fecha')";
                                            if(mysqli_query($con,$query)){
                                                echo "<br>Registro idEmp y fecha agregado correctamente";
//                                                echo "<br>".$query;
                                                //obtenermos el id del registro insertado
                                                $idRegistro= mysqli_insert_id($con);
                                            }                        
                                            else echo "<br>Registro no agregado ".mysqli_error($con);
                                        }
                                        //CONSIREDAR SI HAY HORAS REPEDITAS
                                        //Con $idregistro y $hora Insertamos registro  registroHora
                                        if($idRegistro!=null){
                                            $query="SELECT idregistroHora FROM registroHora WHERE registroEmpleado_idRegistro='$idRegistro' AND Hora='$hora'";
                                            $res=mysqli_query($con,$query);
                                            if($row=mysqli_fetch_array($res)){
                                                echo "<br>El Registro YA EXISTE ".$row[0];
                                            }else {
                                                $query="INSERT INTO registroHora (registroEmpleado_idRegistro,Hora)
                                                VALUES ('$idRegistro','$hora')";
                                                if(mysqli_query($con, $query)) echo "<br>Registro hr agregado correctamente";
                                                else echo "<br>Registro hr NO AGREGADO ".mysqli_error($con);
//                                                echo "<br>".$query;
                                            }
                                        }
                                        else echo "<br>No se inserto registro xq idRegistro= $idRegistro - null?";                
                                    } else echo "<br>Sin IdEmp, el empleado NO EXISTE??!";
                                }
                            }
                            else echo "error al abrir el archivo ";
                        }
                    }
                }else echo "<br>La Tabla empleados no contiene Registros";
                mysqli_close($con);
            ?>

        </div>
    </body>
</html>
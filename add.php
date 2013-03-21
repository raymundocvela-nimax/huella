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
                //include('conectar_local.php');
                include('conectar.php');
                $num=trim(strtoupper($_POST['num']));
                $nom=trim(strtoupper($_POST['nom']));
                $ap=trim(strtoupper($_POST['apep']));
                $am=trim(strtoupper($_POST['apem']));
                $query="SELECT numEmpleado FROM empleado WHERE numEmpleado='$num'";
                $res=mysqli_query($con,$query);
                if($row=mysqli_fetch_array($res))
                    echo "<br>Usuario existente";
                else{
                    $query="INSERT INTO empleado (numEmpleado,nombre,apellidoPaterno,apellidoMaterno) VALUES('$num','$nom','$ap','$am')";
                    if(mysqli_query($con,$query))
                        echo "<br>Empleado agregado correctamente";
                    else echo "<br>Registro no agregado ".mysqli_error($con);
                }
                echo "<br>$query";
                mysqli_close($con);
            ?>
        </div>
    </body>
</html>
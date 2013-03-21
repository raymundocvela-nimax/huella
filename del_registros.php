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
            <a href="del_empleados.php">Eliminar tabla Empleados</a>

            <?php
                //include('conectar_local.php');
                include('conectar.php');

                $query0="SET FOREIGN_KEY_CHECKS=0";
                $query1="TRUNCATE TABLE registroempleado";
                $query2="SET FOREIGN_KEY_CHECKS=1";
                if(mysqli_query($con,$query0)) echo "";
                else "<br> Error 0 ".mysqli_error($con);

                if(mysqli_query($con,$query1)) echo "<br>Tabla registroempleados eliminada correctamente";
                else "<br> Error al eliminar ".mysqli_error($con);

                $query1="TRUNCATE TABLE registrohora";

                if(mysqli_query($con,$query1)) echo "<br>Tabla registrohora eliminada correctamente";
                else "<br> Error al eliminar ".mysqli_error($con);

                if(mysqli_query($con,$query2)) echo "";
                else "<br> Error 2 ".mysqli_error($con);
                mysqli_close($con);
            ?>
        </div>
    </body>
</html>
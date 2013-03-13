<?php
    include('conectar.php');
    $num=$_POST['num'];
    $nom=$_POST['nom'];
    $ap=$_POST['apep'];
    $am=$_POST['apem'];
    $query="SELECT numEmpleado FROM Empleado WHERE numEmpleado='$num'";
    $res=mysql_query($query,$con);
    if(mysql_fetch_array($res))
        echo "<br>Usuario existente";
    $query="INSERT INTO Empleado (numEmpleado,nombre,apellidoPaterno,apellidoMaterno) VALUES('$num','$nom','$ap','$am')";
    if(mysql_query($query,$con)) echo "Empleado agregado correctamente";
    else echo "Registro no agregado ".mysql_error($con);
    echo "<br>$query";
?>

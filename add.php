<?php
    include('conectar_local.php');
    $num=trim(strtoupper($_POST['num']));
    $nom=trim(strtoupper($_POST['nom']));
    $ap=trim(strtoupper($_POST['apep']));
    $am=trim(strtoupper($_POST['apem']));
    $query="SELECT numEmpleado FROM Empleado WHERE numEmpleado='$num'";
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
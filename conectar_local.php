<?php
    $host="localhost";
    $usr="sanangel";
    $psw="123456";
    $namedb="sanangel_2426973";
    $con=mysqli_connect($host,$usr,$psw,$namedb) or die;
    if(mysqli_errno($con)){
        echo "<br>No se realizo la conexión ".mysqli_connect_error();
    }else echo "<br>Conexión establecida";
?>
<?php
$server="sql2.bravehost.com";
$usr="sanangel";
$psw="123456";
$con=mysql_connect($server,$usr,$psw) or die;
if($con){
    $namedb="sanangel_2426973";
mysql_selectdb($namedb);
}
else echo "<br>Error en la conexion";

?>

<?php
$server="sql2.bravehost.com";
$usr="sanangel";
$psw="123456" ;
$con=mysql_connect($server,$usr,$psw) or die;
$namedb="sanangel_2426973";
mysql_selectdb($namedb);
?>

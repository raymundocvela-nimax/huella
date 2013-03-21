<?php
  include('conectar_local.php');
  
  $query0="SET FOREIGN_KEY_CHECKS=0";
  $query1="TRUNCATE TABLE registroempleado";
  $query2="SET FOREIGN_KEY_CHECKS=1";
  if(mysqli_query($con,$query0)) echo "<br>foreing=0";
  else "<br> Error 0 ".mysqli_error($con);
  
  if(mysqli_query($con,$query1)) echo "<br>Tabla registroempleados eliminada correctamente";
  else "<br> Error al eliminar ".mysqli_error($con);
  
  $query1="TRUNCATE TABLE registrohora";
  
  if(mysqli_query($con,$query1)) echo "<br>Tabla registrohora eliminada correctamente";
  else "<br> Error al eliminar ".mysqli_error($con);
  
  if(mysqli_query($con,$query2)) echo "<br>foreing=1";
  else "<br> Error 2 ".mysqli_error($con);
  mysqli_close($con);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Busqueda Avanzada</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>
        <div class="content">
            <a href="index.html">INDEX </a> <br>
            <a href="agregar.html">Agregar un Empleado </a><br> 
            <a href="file_empleados.html">Agregar Empleados desde archivo</a><br>
            <a href="del_registros.php">Eliminar Registros </a><br> 

            <?php
                //include('conectar_local.php');
                include('conectar.php');
                $idFiltro=$_REQUEST['idFiltro'];
                /*Dependiendo el valor (1,2,3,4 ó 5) ejecutará la 
                función:
                1:Asistencias
                2:Quien
                3:Esta
                4:horario
                5:Retardo
                */

                $idParam=$_REQUEST['idParam'];
                /*
                Dependiendo el valor (1,2 ó 3) realizará 
                una Busqueda por
                1:Lista de idsEmpleado separados por comas
                2:idEmpleado
                3:Todos

                */

                $fechas=$_REQUEST['fechas'];
                /*
                -si el idFiltro es = 1,4 ó 5
                recibe un conjunto de fechas separadas por "," 
                formato 2012-06-29 aaaa-mm-dd 

                -si el idFiltro es = 2 o 3
                recibe una sola fecha
                */
                $hr=$_REQUEST['hr'];
                /*
                -si el idFiltro es = 2 o 3
                recibe una hora formato hh:mm:ss
                */

                $idsEmp=$_REQUEST['idsEmp'];
                //DUDA se buscara por idEmpleado o numEmpleado??, lo tome como numEmpleado
                /*
                -si el idFiltro es = 1,4 ó 5
                recibe un conjunto de idEmpleados separados por "," 

                -si el idFiltro es = 2 o 3
                recibe solo un idEmp
                */

                $numRegi=2;//Numero de registros minimos para tomar como asistencia un dia 
                //$numRegi=$_REQUEST['numRegi'];

                switch($idFiltro){
                    case 1:
                        asistencia($idParam,$fechas,$idsEmp);
                        break;

                    case 2:
                        quien($fechas,$hr);
                        break;

                    case 3:
                        esta($fechas,$hr,$idsEmp);
                        break;

                    case 4:
                        horario($idParam,$fechas,$idsEmp);
                        break;

                    case 5:
                        retardo($idParam,$fechas,$idsEmp);
                        break;

                    default:
                        echo "\nerror";
                        break;
                }

                function asistencia($idParam,$fechas,$idsEmp){
                    $resultado="";
                    switch ($idParam){
                        case 1://Lista de empleados
                            global $numRegi;
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $idEmp=strtok($idsEmp,",");
                                while($idEmp!==false){
                                    $query="SELECT DISTINCT numEmpleado, nombre,            
                                    apellidoPaterno, apellidoMaterno, Fecha
                                    FROM empleado, registroEmpleado, registroHora
                                    WHERE numEmpleado='".$idEmp."' AND idEmpleado = 
                                    empleado_idEmpleado
                                    AND Fecha =  '".$fecha."'
                                    AND idRegistro=registroEmpleado_idRegistro
                                    AND ( SELECT COUNT(*) FROM registroHora WHERE 
                                    registroEmpleado_idRegistro =  idRegistro  ) >='".
                                    $numRegi."'";
                                    $res=mysqli_query($con,$query);
                                    while($row=mysqli_fetch_array($res)){
                                        echo"numEmpleado:$row[0]\n";
                                        echo"nombre:$row[1] $row[2] $row[3]\n";
                                        echo"fecha:$row[4]\n\n";
                                    }
                                    $empleado=strtok(",");
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        case 2://Busqueda por un idEmpleado
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $query="SELECT DISTINCT numEmpleado, nombre,            
                                apellidoPaterno, apellidoMaterno, Fecha
                                FROM empleado, registroEmpleado, registroHora
                                WHERE numEmpleado='".$idsEmp."' AND idEmpleado = 
                                empleado_idEmpleado
                                AND Fecha =  '".$fecha."'
                                AND idRegistro=registroEmpleado_idRegistro
                                AND ( SELECT COUNT(*) FROM registroHora WHERE 
                                registroEmpleado_idRegistro =  idRegistro  ) >='".
                                $numRegi."'";
                                $res=mysqli_query($con,$query);
                                while($row=mysqli_fetch_array($res)){
                                    echo"numEmpleado:$row[0]\n";
                                    echo"nombre:$row[1] $row[2] $row[3]\n";
                                    echo"fecha:$row[4]\n\n";
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        case 3://Busqueda de todos los empleados que asistieron en esas fechas
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $query="SELECT DISTINCT numEmpleado, nombre,            
                                apellidoPaterno, apellidoMaterno, Fecha
                                FROM empleado, registroEmpleado, registroHora
                                WHERE idEmpleado = 
                                empleado_idEmpleado
                                AND Fecha =  '".$fecha."'
                                AND idRegistro=registroEmpleado_idRegistro
                                AND ( SELECT COUNT(*) FROM registroHora WHERE 
                                registroEmpleado_idRegistro =  idRegistro  ) >='".
                                $numRegi."'";
                                $res=mysqli_query($con,$query);
                                while($row=mysqli_fetch_array($res)){
                                    echo"numEmpleado:$row[0]\n";
                                    echo"nombre:$row[1] $row[2] $row[3]\n";
                                    echo"fecha:$row[4]\n\n";
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        default:
                            echo "\nerror";
                            break;
                    }
                }

                function quien($fechas,$hr){
                /*
                Si incluimos la hora exacta de quien estuvo no servira de mucho,
                pue sno habra muchos registros coincidentes , seria mejor dar un rango de horas no?
                se complica saber cual es registro de salida, ya que unos no tienen otros si
                por eso puse que me diera los registros entre las 16:00:00 y las 22:00:00
                */
                    $query="SELECT numEmpleado, nombre,            
                    apellidoPaterno, apellidoMaterno, Fecha,hora
                    FROM empleado, registroEmpleado, registroHora
                    WHERE idEmpleado = 
                    empleado_idEmpleado
                    AND Fecha =  '".$fechas."'
                    AND idRegistro=registroEmpleado_idRegistro
                    AND Hora > '16:00:00' AND Hora < '22:00:00'";
                    $res=mysqli_query($con,$query);
                    while($row=mysqli_fetch_array($res)){
                        echo"numEmpleado:$row[0]\n";
                        echo"nombre:$row[1] $row[2] $row[3]\n";
                        echo"fecha:$row[4]\n";
                        echo"hr salida:$row[5]\n\n";
                    }
                }

                function esta($fechas,$hr,$idsEmp){
                    $query="SELECT numEmpleado, nombre,            
                    apellidoPaterno, apellidoMaterno, Fecha,hora
                    FROM empleado, registroEmpleado, registroHora
                    WHERE idEmpleado='".$idsEmp."' AND idEmpleado = 
                    empleado_idEmpleado
                    AND Fecha =  '".$fechas."'
                    AND idRegistro=registroEmpleado_idRegistro
                    AND Hora > '16:00:00' AND Hora < '22:00:00'";
                    $res=mysqli_query($con,$query);
                    while($row=mysqli_fetch_array($res)){
                        echo"numEmpleado:$row[0]\n";
                        echo"nombre:$row[1] $row[2] $row[3]\n";
                        echo"fecha:$row[4]\n";
                        echo"hr salida:$row[5]\n\n";
                    }

                }


                function horario($idParam,$fechas,$idsEmp){

                }


                function retardo($idParam,$fechas,$idsEmp){
                    $resultado="";
                    switch ($idParam){
                        case 1://Lista de empleados que llegaron despues de las 08:01:00 y antes de las 10:00:00
                            global $numRegi;
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $idEmp=strtok($idsEmp,",");
                                while($idEmp!==false){
                                    $query="SELECT numEmpleado, nombre,            
                                    apellidoPaterno, apellidoMaterno, Fecha,hora
                                    FROM empleado, registroEmpleado, registroHora
                                    WHERE idEmpleado='".$idEmp."' AND idEmpleado = 
                                    empleado_idEmpleado
                                    AND Fecha =  '".$fecha."'
                                    AND idRegistro=registroEmpleado_idRegistro
                                    AND Hora > '08:01:00' AND Hora < '10:00:00'";
                                    $res=mysqli_query($con,$query);
                                    while($row=mysqli_fetch_array($res)){
                                        echo"numEmpleado:$row[0]\n";
                                        echo"nombre:$row[1] $row[2] $row[3]\n";
                                        echo"fecha:$row[4]\n";
                                        echo"hora:$row[5]\n\n";
                                    }
                                    $empleado=strtok(",");
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        case 2://empleado que llegaron despues de las 08:01:00 y antes de las 10:00:00
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $query="SELECT numEmpleado, nombre,            
                                apellidoPaterno, apellidoMaterno, Fecha,hora
                                FROM empleado, registroEmpleado, registroHora
                                WHERE idEmpleado='".$idEmp."' AND idEmpleado = 
                                empleado_idEmpleado
                                AND Fecha =  '".$fecha."'
                                AND idRegistro=registroEmpleado_idRegistro
                                AND Hora > '08:01:00' AND Hora < '10:00:00'";
                                $res=mysqli_query($con,$query);
                                while($row=mysqli_fetch_array($res)){
                                    echo"numEmpleado:$row[0]\n";
                                    echo"nombre:$row[1] $row[2] $row[3]\n";
                                    echo"fecha:$row[4]\n\n";
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        case 3://Busqueda de todos los empleados que llegaron despues de las 08:01:00 y antes de las 10:00:00
                            $fecha=strtok($fechas,",");
                            while($fecha!==false){
                                $query="SELECT numEmpleado, nombre,            
                                apellidoPaterno, apellidoMaterno, Fecha,hora
                                FROM empleado, registroEmpleado, registroHora
                                WHERE idEmpleado = 
                                empleado_idEmpleado
                                AND Fecha =  '".$fecha."'
                                AND idRegistro=registroEmpleado_idRegistro
                                AND Hora > '08:01:00' AND Hora < '10:00:00'";
                                $res=mysqli_query($con,$query);
                                while($row=mysqli_fetch_array($res)){
                                    echo"numEmpleado:$row[0]\n";
                                    echo"nombre:$row[1] $row[2] $row[3]\n";
                                    echo"fecha:$row[4]\n\n";
                                }
                                $fecha=strtok(",");
                            }
                            break;

                        default:
                            echo "\nerror";
                            break;
                    }
                }
                mysqli_close($con);
            ?>
        </div>
    </body>
</html>
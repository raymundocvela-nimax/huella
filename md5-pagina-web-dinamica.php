<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>md5-pagina-web-dinamica.php</title>
    </head>
    <?php
        /*
        * HACKING BALLZ
        *┏┓┏┓╋╋╋╋┏┓┏┓╋╋╋╋╋┏━━┓╋╋╋╋╋╋╋┏━━┓
        *┃┗┛┣━┓┏━┫┣╋╋━┳┳━┓┃┏┓┣━┓┏┓┏┓╋┣━━┃
        *┃┏┓┃╋┗┫━┫━┫┃┃┃┃╋┃┃┏┓┃╋┗┫┗┫┗┓┃━━┫
        *┗┛┗┻━━┻━┻┻┻┻┻━╋┓┃┗━━┻━━┻━┻━┛┗━━┛
        *╋╋╋╋╋╋╋╋╋╋╋╋╋╋┗━┛
        *
        * ...internet desde cero!
        * HTTP://HACKINGBALLZ.COM
        * 
        * md5-pagina-web-dinamica.php (25/01/2012) | v.1
        * larry hans | hackingballz
        *
        * http://hackingballz.com/pagina-web-dinamica/
        */

        if(!$_POST['submit']){
        ?>
        <form id="form1" name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
            Escriba su nombre: 
            <input type="text" name="nombre" id="nombre" />
            <input type="submit" name="submit" id="submit" value="Obtener MD5" />
        </form>
        <p>
            <?php
            }else{  
            ?>
        </p>
        <p><strong>El equivalente de <?php echo $_POST['nombre']; ?> en MD5 es: </strong></p>
        <p><?php echo md5($_POST['nombre']); ?></p>
        <p><a href="javascript:history.go(-1)">Clic aquí</a> para realizar otra conversión.</p>
        <?php
        }
    ?>
    <body>
    </body>
</html>
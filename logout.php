<?php
///////////////////////////////////////////////////////
// Eliminar Cache /////////////////////////////////////
///////////////////////////////////////////////////////
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
///////////////////////////////////////////////////////
// Inicio de Sesión ///////////////////////////////////
///////////////////////////////////////////////////////
session_start();
session_destroy();
///////////////////////////////////////////////////////
// Animación logotipo /////////////////////////////////
///////////////////////////////////////////////////////
$efectos = array("animate__bounce", "animate__bounce", "animate__rubberBand", "animate__shakeY", "animate__tada", "animate__jello", "animate__heartBeat", "animate__bounceIn", "animate__fadeIn", "animate__flipInX");
$animacion = array_rand($efectos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página-->
<title>Adegermex S.A. de C.V. | Inicio</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css?ver=3.00" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" type="text/css"/>
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" height="2" bgcolor="#478A33">&nbsp;</td>
    <td width="50%" bgcolor="#E83442">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<div class="tabcontent"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><img src="imagenes/adegermex-logo.png" width="500" height="122" class="animate__animated <?php echo $efectos[$animacion]; ?>"/></td>
  </tr>
</table>
<br />
<table width="600" border="0" align="center" cellpadding="2" cellspacing="5">
  <tr>
    <td align="center" class="titulo">Sistema de Proyectos de I+D</td>
  </tr>
  <tr>
    <td align="center" class="subtitulo">La sesión de usuario ha sido termianada con éxito. <a href="index.php">Volver a Ingresar</a></td>
  </tr>
  <tr>
    <td>
    	<table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        	<tr>
<td bgcolor="#FFFFFF"><br />
          <br />
          <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="titulo">Sesión Finalizada</td>
            </tr>
          </table>
          <br />          <br /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="subtitulo">© 2023 Adegermex S.A. de C.V. Todos los Derechos Reservados<br/><a href="https://www.adegermex.com.mx/" target="_blank">www.adegermex.com.mx</a></td>
  </tr>
</table></div>
</body>
</html>
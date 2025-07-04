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
if(empty($_SESSION['id_usuario'])){
	}
	else {
		header('Location: principal.php');	
	}
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
<link rel="stylesheet" href="css/css.css?version=5.0" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" type="text/css"/>
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" height="2" bgcolor="#E83442">&nbsp;</td>
    <td width="50%" bgcolor="#478A33">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td align="center"><span class="titulo">Sistema de Proyectos de I+D</span></td>
  </tr>
  <tr>
    <td align="center"><span class="subtitulo">Iniciar Sesión</span></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
          <td width="375" align="center"><img src="imagenes/adegermex-logo.png" width="348" height="84" class="animate__animated <?php echo $efectos[$animacion]; ?>"/></td>
          <td width="5" align="center"><img src="imagenes/linea-400.png" width="1" height="280" /></td>
          <td width="550" align="center">
          <form action="engines/login.php" method="post">
          <table width="500" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td>Usuario</td>
            </tr>
            <tr>
              <td><input name="usuario" type="text" required="required" class="textbox-login" id="usuario" placeholder="Ingrese su usuario" maxlength="20" autofocus="autofocus" autocomplete="off"/></td>
            </tr>
          </table>
            <br />
            <table width="500" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td>Contraseña</td>
              </tr>
              <tr>
                <td><input name="password" type="password" required="required" class="textbox-login" id="password" placeholder="Ingrese su contraseña" maxlength="20" autocomplete="off"/></td>
              </tr>
            </table>
            <br />
            <table width="480" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="center"><input class="boton-login" type="submit" name="entrar" id="entrar" value="Entrar" /></td>
              </tr>
          </table>
          </form></td>
        </tr>
  </table>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><span class="subtitulo">© 2023 Adegermex S.A. de C.V. Todos los Derechos Reservados<br/>
      <a href="https://www.adegermex.com.mx/" target="_blank">www.adegermex.com.mx</a></span></td>
  </tr>
</table>
</div>
</body>
</html>
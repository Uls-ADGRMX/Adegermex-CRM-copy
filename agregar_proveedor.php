<?php
///////////////////////////////////////////////////////
// Inicio de Sesión ///////////////////////////////////
///////////////////////////////////////////////////////
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include 'scripts/conexion.php';
///////////////////////////////////////////////////////
// Datos del Usuario //////////////////////////////////
///////////////////////////////////////////////////////
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proveedores</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#196589">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <?php include "header.php"; ?><br /></td>
  </tr>
</table>
<br />
<?php include "menu.php"; ?>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Proveedores</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Alta de Proveedor</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <form action="engines/alta_proveedor.php" method="post">
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td>Nombre del Proveedor</td>
            </tr>
            <tr>
              <td><input name="nombre" type="text" required="required" class="textbox" id="nombre" placeholder="Ejemplo: ALKAN Quimica S.A. de C.V." autocomplete="off" autofocus="autofocus"/></td>
            </tr>
          </table>
          <br />
          <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
            </tr>
            <tr>
            	<td align="center" class="subtitulo">
                	<br />ó <a href="proveedores.php#contenido">Cancelar</a>
                </td>
            </tr>
          </table>
        </form>
      <br /></td>
    </tr>
  </table>
  <br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
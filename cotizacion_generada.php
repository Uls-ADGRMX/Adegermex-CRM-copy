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
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
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
///////////////////////////////////////////////////////
// ID de la cotización ////////////////////////////////
///////////////////////////////////////////////////////
$idc = $_GET['idc'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Cotizaciones</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#D1266A">&nbsp;</td>
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
    <td align="center" class="titulo">Cotizaciones</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4"><a name="contenido" id="contenido"></a>Generar nueva Cotización</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br />
      <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
          <td width="162" class="subtitulo">Generalidades</td>
          <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
          <td width="162" class="subtitulo">Producto</td>
          <td width="50" align="center"><img src="imagenes/3-activo.png" width="39" height="40" /></td>
          <td width="162" class="subtitulo">Incrementables</td>
          <td width="50" align="center"><img src="imagenes/4-activo.png" width="39" height="40" /></td>
          <td width="164" class="subtitulo">Información Comercial</td>
        </tr>
      </table>
      <br />
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center" class="titulo">¡Cotización generada exitosamente!</td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4">Folio de la Cotización: <strong><?php echo $idc; ?></strong></td>
        </tr>
        <tr>
          <td align="center"><a href="cotizacion.php?id=<?php echo $idc; ?>#contenido">Ver la Cotización</a> | <a href="cotizaciones.php#contenido">Ir a Cotizaciones</a></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/proyecto_generado.jpg" width="280" height="244" /><br /></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
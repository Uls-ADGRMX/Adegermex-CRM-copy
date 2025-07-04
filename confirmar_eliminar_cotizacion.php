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
///////////////////////////////////////////////////////
// ID de la Cotización ////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion de la Cotización //////////////////////////
///////////////////////////////////////////////////////
$cotizacion=mysql_query("SELECT tmcotizaciones.id_cotizacion, tmcotizaciones.id_cliente, tcclientes.nombre AS cliente
FROM tmcotizaciones
JOIN tcclientes
WHERE tmcotizaciones.id_cliente = tcclientes.id_cliente AND id_cotizacion='$id'", $conexion) or die(mysql_error());
$arraycotizacion = mysql_fetch_object($cotizacion);
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Eliminar Cotización</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br />
      <form action="engines/eliminar_cotizacion.php?id=<?php echo $id; ?>" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/elimnar.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><strong>Eliminar Cotización</strong></td>
        </tr>
        <tr>
          <td align="center">¿Desea eliminar la cotización <strong>folio <?php echo $arraycotizacion->id_cotizacion; ?></strong> del cliente <strong><?php echo $arraycotizacion->cliente; ?></strong>?</td>
        </tr>
        <tr>
          <td align="center" class="factura-texto-min">Si la cotización es eliminada, no podrá ser recuperada.</td>
        </tr>
      </table>
      <br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-celiminar" type="submit" name="eliminar" id="eliminar" value="Confirmar: Eliminar Cotización" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="cotizacion.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
    </table></form><br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
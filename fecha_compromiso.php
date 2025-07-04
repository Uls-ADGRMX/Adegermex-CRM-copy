<?php
// Inicio de Sesión
session_start();
// Si la sesión no se ha iniciado redireccionamos
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
// Inlcluimos la conexión a la Base de Datos
include 'scripts/conexion.php';
// Datos del Usuario
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
///////////////////////////////////////////////////////
// ID del Proyecto ////////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$proyecto = "SELECT * FROM tmproyectos WHERE id_proyecto=$id";
$datos=mysql_query($proyecto, $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proyectos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#27A9E3">&nbsp;</td>
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
    <td align="center" class="titulo">Proyectos</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Asignar Fecha Compromiso</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <form action="engines/compromiso.php" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/fecha_compromiso.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><strong>Definir Fecha Compromiso</strong></td>
        </tr>
        <tr>
          <td align="center">Definir la Fecha Compromiso de entrega del proyecto <strong><?php echo $nombre_proyecto; ?></strong> para el día:</td>
        </tr>
        <tr>
          <td align="center"><br />
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" />
            <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id; ?>" /><input name="fecha_compromiso" type="date" class="textbox-med" id="fecha_compromiso" value="<?php
            date_default_timezone_set('America/Mexico_City');
		$fecha=date("Y-m-d");
		$fecha_sugerida = strtotime('+10 day', strtotime($fecha));
		$fecha_sugerida=date('Y-m-d',$fecha_sugerida); echo $fecha_sugerida;
			?>"/></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-casignar" type="submit" name="fecha" id="fecha" value="Definir Fecha Compromiso" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="proyecto.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
      </table></form>      <br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Rechazar Proyecto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
<form action="engines/rechazar.php" method="post">
<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/rechazar.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center"><strong class="factura-texto4">Rechazar Proyecto</strong></td>
        </tr>
        <tr>
          <td align="center">Está apunto de rechazar el proyecto <strong><?php echo $nombre_proyecto; ?></strong>.
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" />
            <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id; ?>" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2"><br />
            <table width="500" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td class="factura-texto3"><strong class="factura-texto2">Indique el motivo por el cual es rechazado el proyecto</strong></td>
                </tr>
              <tr>
                <td><textarea name="comentarios" class="textbox-box" id="comentarios" autocomplete="off" placeholder="¿Cuál es el motivo de rechazar el proyecto <?php echo $nombre_proyecto; ?>?" required="required"></textarea></td>
                </tr>
              </table></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-crechazar" type="submit" name="rechazar" id="rechazar" value="Confirmar Rechazar Proyecto" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="proyecto.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
</table></form><br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
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
// Consulta para información del Insumo ///////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$insumo = "SELECT * FROM tcinsumos WHERE id_insumo='$id'";
$info=mysql_query($insumo, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Insumos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
    	<tr>
        	<td height="1" bgcolor="#FFB848">&nbsp;</td>
        </tr>
        <tr>
        	<td bgcolor="#FFFFFF"><br />
				<?php include "header.php"; ?>
                <br />
            </td>
         </tr>
     </table>
<br />
<?php include "menu.php"; ?>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Insumos</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Cambiar código del Insumo</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <form action="engines/cambiar_codigo.php" method="post">
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center">Nombre del Insumo</td>
          </tr>
          <tr>
            <td align="center" class="factura-texto4"><strong><?php echo $infoarray->nombre; ?></strong></td>
          </tr>
          <tr>
            <td align="center" class="factura-texto4"><img src="imagenes/linea-950.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
              <br />
              Al cambiar el código del Insumo este se modificara también en los módulos de <strong>Proveedores</strong>, <strong>Fórmulas</strong> y <strong>Costos</strong>.</td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="375" align="center">Código actual del Insumo</td>
            <td width="150" align="center">&nbsp;</td>
            <td width="375" align="center">Nuevo código del Insumo</td>
          </tr>
          <tr>
            <td align="center"><span class="factura-texto4"><strong><?php echo $infoarray->codigo; ?></strong></span></td>
            <td align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
            <td align="center"><input name="codigo_nuevo" type="text" required="required" class="textbox-med" id="codigo_nuevo" placeholder="Ejemplo: 10100201" autocomplete="off" autofocus="autofocus"/><input type="hidden" id="id_insumo" name="id_insumo" value="<?php echo $infoarray->id_insumo; ?>"/><input type="hidden" id="codigo_actual" name="codigo_actual" value="<?php echo $infoarray->codigo; ?>"/></td>
          </tr>
</table>
        <br />
        <br />
        <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
        <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
      </tr>
      <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="editar_insumo.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
</table></form><br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
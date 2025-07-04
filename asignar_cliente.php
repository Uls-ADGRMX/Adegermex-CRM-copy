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
// Consulta para información del Cliente //////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
$cliente = "SELECT * FROM tcclientes WHERE id_cliente=$id";
$datos=mysql_query($cliente, $conexion) or die(mysql_error());
$arraycliente = mysql_fetch_object($datos);
$nombre_cliente = $arraycliente->nombre;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Clientes</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#2255A4">&nbsp;</td>
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
    <td align="center" class="titulo">Clientes</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Asignar Cliente</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <form action="engines/asignar_cliente.php" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/asignar.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><strong>Asignar Cliente</strong></td>
        </tr>
      </table>
        <br />
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
              <br />
              Todos los proyectos activos del cliente serán asignados al nuevo usuario para seguimiento.<br />
              Los proyectos <strong>Finalizados</strong> y <strong>Eliminados</strong> no serán asignados.</td>
          </tr>
        </table>
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center">Asignar el cliente <strong><?php echo $nombre_cliente; ?></strong> al agente de ventas:
              <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $id; ?>" />
              <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" /></td>
          </tr>
          <tr>
            <td align="center"><br />
              <select name="agente" class="textbox-med" id="agente" style="height:30px;">
                <optgroup label="Agentes de Ventas">
                  <?php 
			  $agentes=mysql_query("SELECT * FROM tcusuarios WHERE tipo_usuario='Agente de Ventas' AND status='Activo' ORDER BY nombre ASC",$conexion);
			  while($fila=mysql_fetch_array($agentes))
			  {
				  echo "<option value=".$fila['id_usuario'].">".$fila['nombre']."</option>";
				  }
			?>
                  </optgroup>
                <optgroup label="Administradores">
                  <?php 
			  $administradores=mysql_query("SELECT * FROM tcusuarios WHERE tipo_usuario='Administrador' AND status='Activo' ORDER BY nombre ASC",$conexion);
			  while($fila=mysql_fetch_array($administradores))
			  {
				  echo "<option value=".$fila['id_usuario'].">".$fila['nombre']."</option>";
				  }
			?>
                  </optgroup>
              </select></td>
          </tr>
        </table>
        <br />
        <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
          <td align="center"><input class="boton-casignar" type="submit" name="asignar" id="asignar" value="Asignar Cliente" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="cliente.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
</table></form>      <br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
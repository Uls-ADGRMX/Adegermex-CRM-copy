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
<title>Adegermex S.A. de C.V. | Usuarios</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#DA542E">&nbsp;</td>
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
    <td align="center" class="titulo">Usuarios</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td align="center"><a href="agregar_usuario.php#contenido">
        <input class="boton-login" type="submit" name="agregar" id="agregar" value="Alta de nuevo Usuario"/>
      </a></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Usuarios en sistema</td>
    <td width="500" align="right" class="factura-texto4"><?php
                                    	$usuarios=mysql_query("SELECT * FROM tcusuarios ORDER BY id_usuario ASC",$conexion);
										$numero_usuarios=mysql_num_rows($usuarios);
											if ($numero_usuarios==0)
												{
													echo '0';
												}
											else {
												echo $numero_usuarios;
												}
												?> usuarios en total</td>
  </tr>
</table>
<br />
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="subtitulo">
    <td width="200"><span class="finalizado">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Usuario Activo</td>
    <td width="200"><span class="eliminado">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Usuario Inactivo</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr class="encabezado-tabla">
        <td width="1">&nbsp;</td>
        <td width="214">Nombre del Usuario</td>
        <td width="233">Departamento</td>
        <td width="140">Tipo de Usuario</td>
        <td width="105">Fecha de Alta</td>
        <td width="114">Usuario</td>
        <td width="95">Opciones</td>
      </tr>
      <?php 
while($fila=mysql_fetch_array($usuarios)){
	?>
      <tr>
      		<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
      </tr>
      <tr class="celda-activa">
        <td bgcolor="<?php
          		switch ($fila['status']) {
    				case "Activo":
        				echo "#48A623";
        				break;
    				case "Inactivo":
        				echo "#CB0016";
        				break;
						}
						?>">&nbsp;</td>
        <td><?php echo '<a href="editar_usuario.php?id='.$fila['id_usuario'].'#contenido" class="link">'.$fila['nombre'].'</a>'; ?></td>
        <td width="233"><?php echo $fila['departamento']; ?></td>
        <td width="140"><?php echo $fila['tipo_usuario']; ?></td>
        <td width="105"><?php echo $fila['fecha_alta']; ?></td>
        <td width="114"><?php echo $fila['usuario']; ?></td>
        <td width="95">
        	<table width="90" border="0" align="center" cellpadding="0" cellspacing="0">
          		<tr>
            		<td align="center"><a href="engines/activar_usuario.php?id=<?php echo $fila['id_usuario']; ?>"><img src="imagenes/activar.png" width="14" height="14" title="Activar"/ class="opacidad-accion"></a></td>
            		<td align="center"><a href="engines/desactivar_usuario.php?id=<?php echo $fila['id_usuario']; ?>"><img src="imagenes/eliminar.png" width="14" height="14" title="Desactivar"/ class="opacidad-accion"></a></td>
            		<td align="center"><a href="editar_usuario.php?id=<?php echo $fila['id_usuario']; ?>#contenido"><img src="imagenes/editar.png" width="14" height="14" title="Editar"/ class="opacidad-accion"></a></td>
          		</tr>
        </table>
        </td>
      </tr>
      <?php 
  }
  ?> 
    </table>
    <br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
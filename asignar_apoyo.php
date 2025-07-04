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
// ID del Proyecto ////////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$proyecto = "SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.id_usuasignado, tmproyectos.id_usuasignado2, tcusuarios.nombre, (SELECT tcusuarios.nombre FROM tcusuarios WHERE tmproyectos.id_usuasignado2 = tcusuarios.id_usuario AND tmproyectos.id_proyecto='$id') AS nombre_apoyo
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usuasignado = tcusuarios.id_usuario AND tmproyectos.id_proyecto='$id'";
$datos=mysql_query($proyecto, $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
$id_usuasignado = $arrayproyecto->id_usuasignado;
$nombre_asignado = $arrayproyecto->nombre;
$id_usuasignado2 = $arrayproyecto->id_usuasignado2;
$nombre_apoyo = $arrayproyecto->nombre_apoyo;
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Asignar Proyecto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br />
      <form action="engines/asignar_apoyo.php" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td colspan="3" align="center"><img src="imagenes/asignar_apoyo.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="factura-texto4"><strong>Asignar Proyecto</strong></td>
        </tr>
        <tr>
          <td colspan="3" align="center">Asignar el desarrollador(a) de apoyo para el proyecto <strong><?php echo $nombre_proyecto; ?></strong>:
            <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id; ?>"><input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>">
            <br />
            <br /></td>
        </tr>
        <tr>
          <td width="450" align="right"><?php echo $nombre_asignado; ?>&nbsp;</td>
          <td width="50" align="center" class="titulo"><strong>+</strong></td>
          <td width="450"><select name="desarrollador" class="textbox-med" id="desarrollador" style="height:30px;">
            <?php
			if ($id_usuasignado2<>"0"){
				echo '<optgroup label="Desarrollador(a) de apoyo">
					<option value="'.$id_usuasignado2.'">'.$nombre_apoyo.'</option>
					</optgroup>';
					}
			?>
            <optgroup label="Desarrolladores">
              <?php
              $desarrolladores=mysql_query("SELECT * FROM tcusuarios WHERE tipo_usuario='Desarrollador' AND status='Activo' AND id_usuario<>$id_usuasignado2 AND id_usuario<>$id_usuasignado ORDER BY nombre ASC",$conexion);
			  	while($fila=mysql_fetch_array($desarrolladores))
					{
						echo '<option value="'.$fila['id_usuario'].'">'.$fila['nombre'].'</option>';
					}
				?>
              </optgroup>
            <optgroup label="Administradores">
              <?php
              $administradores=mysql_query("SELECT * FROM tcusuarios WHERE tipo_usuario='Administrador' AND status='Activo' AND id_usuario<>$id_usuasignado2 AND id_usuario<>$id_usuasignado ORDER BY nombre ASC",$conexion);
			  	while($fila=mysql_fetch_array($administradores))
					{
						echo '<option value="'.$fila['id_usuario'].'">'.$fila['nombre'].'</option>';
					}
				?>
              </optgroup>
            <?php
			if ($id_usuasignado2<>"0"){
				echo '<optgroup label="Eliminar asignación">
					<option value="0">Eliminar asignación de apoyo</option>
					</optgroup>';
					}
			?>
            </select></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-casignar" type="submit" name="asignar" id="asignar" value="Asignar Desarrollador(a) de Apoyo" /></td>
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
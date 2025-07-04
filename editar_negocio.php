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
$proyecto = "SELECT tmproyectos.nombre_proyecto, tmproyectos.potencial, tmrequisitos.vmensual_num, tmrequisitos.ptarget_num, tmrequisitos.caplic_num, tmrequisitos.caplic_mon
FROM tmproyectos
JOIN tmrequisitos
WHERE tmproyectos.id_proyecto=tmrequisitos.id_proyecto AND tmproyectos.id_proyecto=$id";
$datos=mysql_query($proyecto, $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
$potencial = $arrayproyecto->potencial;
$vmensual_num = $arrayproyecto->vmensual_num;
$ptarget_num = $arrayproyecto->ptarget_num;
$caplic_num = $arrayproyecto->caplic_num;
$caplic_mon = $arrayproyecto->caplic_mon;
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Editar Información de Negocio</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <form action="engines/modificar_negocio.php" method="post" name="edtneg">
    <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center" class="titulo"><?php echo $nombre_proyecto; ?></td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto">El <strong>Potencial del Proyecto</strong> actualmente esta definido como <strong><?php switch ($potencial) {
    				case "1":
        				echo "Alto <img src='imagenes/alta.png' title='Potencial Alto'>";
        				break;
					case "2":
        				echo "Medio <img src='imagenes/normal.png' title='Potencial Medio'>";
        				break;
    				case "3":
        				echo "Bajo <img src='imagenes/baja.png' title='Potencial Bajo'>";
        				break;
						} ?></strong>.</td>
        </tr>
</table>
      <br />
      <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td colspan="2"><strong>Volumen Mensual</strong></td>
          <td colspan="2"><strong>Precio de venta target por KG</strong></td>
          <td colspan="2"><strong>Costo de la Aplicación</strong></td>
        </tr>
        <tr>
          <td width="90"><input name="vmensual_num" type="number" min="1" step="1" class="textbox-min" id="vmensual_num" placeholder="#" autocomplete="off" value="<?php echo $vmensual_num; ?>"/></td>
          <td width="210"><select name="vmensual_uni" class="textbox-min" id="vmensual_uni" style="height:30px;">
            <option>Kilogramos</option>
          </select></td>
          <td width="90"><input name="ptarget_num" type="number" min="0.01" step="0.01" class="textbox-min" id="ptarget_num" placeholder="$" autocomplete="off" value="<?php echo $ptarget_num; ?>"/></td>
          <td width="210"><select name="ptarget_mon" class="textbox-min" id="ptarget_mon" style="height:30px;">
            <option>Dolares</option>
          </select></td>
          <td width="90"><input name="caplic_num" type="number" min="1" step="0.01" class="textbox-min" id="caplic_num" placeholder="$" autocomplete="off" value="<?php echo $caplic_num; ?>"/></td>
          <td width="210"><select name="caplic_mon" class="textbox-min" id="caplic_mon" style="height:30px;">
          <option><?php echo $caplic_mon; ?></option>
            <option>Pesos</option>
            <option>Dolares</option>
          </select></td>
        </tr>
    </table>
      <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $id; ?>"/><input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>"/><br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="button" name="guardar" id="guardar" value="Guardar Cambios" onclick="edtneg.submit()"/></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="proyecto.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
    </table>
      <br />
      </form></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
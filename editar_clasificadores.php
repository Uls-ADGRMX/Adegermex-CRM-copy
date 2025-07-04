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
$proyecto = "SELECT tmproyectos.nombre_proyecto, tmproyectos.tipo, tmproyectos.categoria, tmproyectos.segmento
FROM tmproyectos
WHERE tmproyectos.id_proyecto=$id";
$datos=mysql_query($proyecto, $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
$tipo = $arrayproyecto->tipo;
$categoria = $arrayproyecto->categoria;
$segmento = $arrayproyecto->segmento;
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Editar Clasificadores del Proyecto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <form action="engines/modificar_clasificadores.php" method="post" name="edtcla">
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
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Tipo de Proyecto</strong></td>
          <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Categoría del Proyecto</strong></td>
          <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Segmento del Proyecto</strong></td>
        </tr>
        <tr>
          <td align="center"><select name="tipo" class="textbox-med" id="tipo" style="height:30px;">
          	<option><?php echo $tipo; ?></option>
            <optgroup label="Tipo de Proyecto">
            <option>Proactivo</option>
            <option>Reactivo</option>
            </optgroup>
          </select></td>
          <td align="center"><select name="categoria" class="textbox-med" id="categoria" style="height:30px;">
          	<option><?php echo $categoria; ?></option>
            <optgroup label="Categoría del Proyecto">
                <option>Ajos y Cebollas</option>
                <option>ADEROME Dairy</option>
                <option>ADEROME PVH</option>
                <option>ADEROME Seasoning</option>
                <option>ADEROME Smoke</option>
                <option>ADEROME YE</option>
                <option>Extractos de Té</option>
                <option>Presentación de Tecnologías</option>
                <option>Productos en Riesgo</option>
                <option>Sabores (QA)</option>
                <option>Tomates</option>
                <option>Otro</option>
            </optgroup>
          </select></td>
          <td align="center"><select name="segmento" class="textbox-med" id="segmento" style="height:30px;">
          	<option><?php echo $segmento; ?></option>
                <optgroup label="Panificación">
                	<option>Panificación - Sweet</option>
                	<option>Panificación - Harinas</option>
                	<option>Panificación - Cereales</option>
                </optgroup>
                <optgroup label="Lácteos">
                	<option>Lácteos - Quesos</option>
                	<option>Lácteos - Yogurth</option>
                	<option>Lácteos - Leche</option>
                </optgroup>
                <optgroup label="Bebidas">
                	<option>Bebidas - Alcohólicas</option>
                	<option>Bebidas - Isotonicas</option>
                	<option>Bebidas - Energéticas</option>
                	<option>Bebidas - Gasificadas</option>
                	<option>Bebidas - Base Agua</option>
                </optgroup>
                <optgroup label="Cárnicos">
                	<option>Cárnicos</option>
                </optgroup>
                <optgroup label="Snacks">
                	<option>Snacks</option>
                </optgroup>
                <optgroup label="Culinario">
                	<option>Culinario</option>
                </optgroup>
                <optgroup label="Vegetales">
                	<option>Vegetales</option>
                </optgroup>
                <optgroup label="Food Service">
                	<option>Food Service</option>
                </optgroup>
                <optgroup label="Otro">
                	<option>Otro</option>
                </optgroup>
          </select></td>
        </tr>
    </table>
      <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $id; ?>"/><input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>"/><br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="button" name="guardar" id="guardar" value="Guardar Cambios" onclick="edtcla.submit()"/></td>
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
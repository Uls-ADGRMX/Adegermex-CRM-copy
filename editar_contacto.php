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
// Consulta para información del Contacto /////////////
///////////////////////////////////////////////////////
$id_contacto = $_GET['id'];
$id_cliente = $_GET['idc'];
$contacto = "SELECT * FROM tmcontactos WHERE id_contacto=$id_contacto";
$datos=mysql_query($contacto, $conexion) or die(mysql_error());
$arraycontacto = mysql_fetch_object($datos);
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Editar Contacto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id_contacto; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <form action="engines/modificar_contacto.php" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/editar_contacto.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><strong>Editar Contacto</strong></td>
        </tr>
      </table>
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="265">Nombre del contacto</td>
            <td width="265">Teléfono</td>
            <td width="270">Correo electrónico</td>
          </tr>
          <tr>
            <td><input name="nombre_contacto" type="text" class="textbox-med" id="nombre_contacto" placeholder="Nombre del contacto" autocomplete="off" required="required" autofocus="autofocus" value="<?php echo $arraycontacto->nombre_contacto; ?>"/></td>
            <td><input name="telefono" type="tel" class="textbox-med" id="telefono" placeholder="Teléfono" autocomplete="off" required="required" value="<?php echo $arraycontacto->telefono; ?>"/></td>
            <td><input name="correo" type="email" class="textbox-med" id="correo" placeholder="Correo electrónico" autocomplete="off" required="required" value="<?php echo $arraycontacto->correo; ?>"/></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="265">Puesto</td>
            <td width="265">Departamento</td>
            <td width="270">&nbsp;</td>
          </tr>
          <tr>
            <td><input name="puesto" type="text" class="textbox-med" id="puesto" placeholder="Puesto" autocomplete="off" required="required" value="<?php echo $arraycontacto->puesto; ?>"/></td>
            <td><select name="departamento" class="textbox-med" id="departamento" style="height:35px;">
            <option><?php echo $arraycontacto->departamento; ?></option>
              <optgroup label="Dirección General">
                <option>Dirección General</option>
                </optgroup>
              <optgroup label="Dirección de Administración y Finanzas">
                <option>Dirección de Administración y Finanzas</option>
                <option>Compras</option>
                <option>Contabilidad</option>
                <option>Costos</option>
                <option>Gestión de Calidad</option>
                <option>Recursos Humanos</option>
                <option>Sistemas</option>
                <option>Ventas</option>
                </optgroup>
              <optgroup label="Dirección de Operaciones">
                <option>Dirección de Operaciones</option>
                <option>Almacén</option>
                <option>Calidad</option>
                <option>Investigación y Desarrollo</option>
                <option>Mantenimiento</option>
                <option>Planeación</option>
                <option>Producción</option>
                </optgroup>
              <optgroup label="Otro">
                <option>Otro</option>
                </optgroup>
            </select></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente; ?>" />
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" />
        <input type="hidden" id="id_contacto" name="id_contacto" value="<?php echo $id_contacto; ?>" />
        <br />
        <br />
        <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
          <td align="center"><input class="boton-casignar" type="submit" name="guardar" id="guardar" value="Guardar Cambios" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="cliente.php?id=<?php echo $id_cliente; ?>#contenido">Cancelar</a></td>
        </tr>
</table></form>      <br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
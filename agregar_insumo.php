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
    <?php include "header.php"; ?><br /></td>
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
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Alta de nuevo Insumo</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td bgcolor="#FFFFFF"><br />
        <form action="engines/alta_insumo.php" method="post">
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td>Código del Insumo</td>
            </tr>
            <tr>
              <td><input name="codigo" type="text" required="required" class="textbox" id="codigo" placeholder="Ejemplo: 10100201" autocomplete="off" autofocus="autofocus"/></td>
            </tr>
          </table>
          <br />
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td>Nombre del Insumo</td>
            </tr>
            <tr>
              <td><input name="nombre" type="text" required="required" class="textbox" id="nombre" placeholder="Ejemplo: Ácido Cítrico" autocomplete="off"/></td>
            </tr>
          </table>
          <br />
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td>Código del Proveedor</td>
            </tr>
            <tr>
              <td><input name="codigo_proveedor" type="text" class="textbox" id="codigo_proveedor" placeholder="Ejemplo: ITEM23071987" autocomplete="off"/></td>
            </tr>
          </table>
<br />
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td width="250">Unidad de Medida</td>
              <td width="300">Categoría</td>
            </tr>
            <tr>
              <td>
              	<select name="unidad_medida" class="textbox-med" id="unidad_medida" style="height:30px;">
                	<optgroup label="Unidad de Medida">
                    	<option>Kilogramo</option>
                        <option>Litro</option>
                        <option>Pieza</option>
                    </optgroup>
                 </select>
               </td>
              <td>
              	<select name="categoria" class="textbox-med" id="categoria" style="height:30px;">
                	<optgroup label="Categoría">
                    	<option>Aditivos</option>
                        <option>Ajos</option>
                        <option>Alimentos de origen vegetal</option>
                        <option>Cebollas</option>
                        <option>Chiles</option>
                        <option>Colores</option>
                        <option>Condimentos y especias</option>
                        <option>Cristales</option>
                        <option>Derivados cárnicos</option>
                        <option>Deshidratados</option>
                        <option>Edulcorantes</option>
                        <option>Extractos de levadura</option>
                        <option>Extractos naturales</option>
                        <option>Grasas / Aceites</option>
                        <option>Lácteos</option>
                        <option>Oleorresinas</option>
                        <option>Proteínas</option>
                        <option>PVH</option>
                        <option>Quesos enzimáticos</option>
                        <option>Sabores</option>
                        <option>Texturizados</option>
                        <option>Vehículos / Carrier</option>
                        <option>Vitaminas</option>
                        <option>Otro</option>
                 </select>
              </td>
            </tr>
          </table>
          <br />
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td width="250">Origen</td>
              <td width="300">Tipo</td>
            </tr>
            <tr>
              <td>
              	<select name="origen" class="textbox-med" id="origen" style="height:30px;">
                	<optgroup label="Origen">
                    	<option>Nacional</option>
                        <option>Extranjero</option>
                    </optgroup>
                 </select>
              </td>
              <td>
              	<select name="tipo" class="textbox-med" id="tipo" style="height:30px;">
                	<optgroup label="Tipo">
                    	<option value="Insumo de linea">Insumo de línea</option>
                        <option value="Insumo de IyD">Insumo de IyD</option>
                    </optgroup>
                 </select>
              </td>
            </tr>
          </table>
          <br />
          <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td>Comentario</td>
            </tr>
            <tr>
              <td>
              	<textarea name="comentario" cols="45" rows="5" class="textbox-comentario" id="comentario" style="width:550px;" autocomplete="off" placeholder="Escriba un comentario para el insumo"></textarea>
              </td>
            </tr>
          </table>
          <br />
          <br />
          <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
            </tr>
            <tr>
            	<td align="center" class="subtitulo">
                	<br />ó <a href="insumos.php#contenido">Cancelar</a>
                </td>
            </tr>
          </table>
        </form>
      <br /></td>
    </tr>
  </table>
  <br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
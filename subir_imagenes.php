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
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
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
// ID del Producto  y tipo de imagen //////////////////
///////////////////////////////////////////////////////
$id_producto = $_GET['id'];
$tipo_subir = $_GET['t'];
///////////////////////////////////////////////////////
// Informacion del Producto ///////////////////////////
///////////////////////////////////////////////////////
$producto = "SELECT tmproductos.*, tcusuarios.nombre FROM tmproductos JOIN tcusuarios WHERE tmproductos.id_usuario = tcusuarios.id_usuario AND id_producto=$id_producto";
$datos=mysql_query($producto, $conexion) or die(mysql_error());
$arrayproducto = mysql_fetch_object($datos);
$nombre_producto = $arrayproducto->nombre_producto;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Inteligencia de Mercado</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#393E46">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <?php include "header.php"; ?><br />
    </td>
  </tr>
</table>
<br />
<?php include "menu.php"; ?>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Inteligencia de Mercado</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Subir Imágenes</td>
      <td width="500" align="right" class="factura-texto4">ID: <?php echo $id_producto; ?></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="950" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td align="center" class="factura-texto4"><strong><?php echo $nombre_producto; ?></strong></td>
          </tr>
          <tr>
            <td align="center"><img src="imagenes/linea-950.png" width="800" height="1" /></td>
          </tr>
        </table>
        <form action="engines/subir_imagenes.php" method="post" enctype="multipart/form-data">
        <table width="700" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="450" align="center"><label for="adjuntar"><img src="imagenes/galeria.png" width="180" height="180" title="Subir Imágen" class="opacidad" />
              <input id="adjuntar" name="adjuntar" class="adjuntar" type="file" accept=".jpg, .png, .jpeg, .bmp"/>
            </label></td>
          </tr>
          <tr>
            <td align="center"><span id="narchivo" class="subtitulo">Seleccione un archivo para cargar</span></td>
          </tr>
        </table>
        <br />
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
              <br />
              Puede cargar imágenes en formato <strong>JPG, PNG y BMP</strong>.<br />
              Puede cargar imágenes de hasta <strong>5 Megabytes</strong>.</td>
          </tr>
      </table>
        <br />
        <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Subir Imagen" /></td>
          </tr>
          <tr>
            <td align="center" class="subtitulo"><br />
              <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>"> <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto; ?>"> <input type="hidden" name="tipo_subir" id="tipo_subir" value="<?php echo $tipo_subir; ?>"> ó <a href="producto.php?id=<?php echo $id_producto; ?>#contenido">Cancelar</a></td>
          </tr>
</table>
        </form>
        <br />
      </td>
    </tr>
</table><br />
  <?php include "footer.php"; ?></div>
<br />
<script>
	let input = document.getElementById("adjuntar");
	let imageName = document.getElementById("narchivo")
	input.addEventListener('change', ()=>{
		let inputImage = document.querySelector("input[type=file]").files[0];
		imageName.innerHTML = "<strong>Archivo seleccionado:</strong> <i>" + inputImage.name + "</i>&nbsp;<img src='imagenes/check.png'/>";
	})
</script>
</body>
</html>
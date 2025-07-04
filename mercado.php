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
<title>Adegermex S.A. de C.V. | Inteligencia de Mercado</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Busqueda de Cliente -->
<script>
function loadXMLDoc()
	{
		var xmlhttp;
		var n=document.getElementById('buscar').value;
		if(n==''){
			document.getElementById("resultado").innerHTML="";
			return;
	}
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("resultado").innerHTML=xmlhttp.responseText;
		}
		else {
			document.getElementById("resultado").innerHTML='<center><img src="imagenes/loading.gif" width="16" height="11" /></center>';
			}
		}
		xmlhttp.open("POST","engines/buscar_producto.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#393E46"><br /></td>
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
    <td align="center" class="titulo">Inteligencia de Mercado</td>
  </tr>
</table>
<br />
<div class="tabcontent">
<?php
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Agente de Ventas"){
	echo '
	<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr>
			<td align="center">
				<a href="generar_producto.php#contenido"><input class="boton-login" type="submit" name="agregar" id="agregar" value="Generar nuevo Producto"/</a>
			</td>
		</tr>
	</table>
	<br />';
}
?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Buscar Producto</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br />
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Buscar</td>
        </tr>
        <tr>
          <td><input name="buscar" type="text" required="required" class="textbox" id="buscar" placeholder="Ejemplo: Tequila Don Julio Reposado 700ml" autocomplete="off" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
        </tr>
      </table>
      <br />
      <div id="resultado"></div>
      <br />
      <br /></td>
  </tr>
</table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Productos recientemente agregados</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
<?php
$productos = mysql_query("SELECT * FROM tmproductos ORDER BY id_producto DESC LIMIT 15",$conexion);
$numero_productos=mysql_num_rows($productos);
	if ($numero_productos==0){
		echo '
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td align="center" bgcolor="#FFFFFF">
					<br />
					<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center"><img src="imagenes/mercado.png" width="180" height="180" /></td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay <strong>Productos</strong> agregados recientemente.</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>
		</table>
		<br/>';
		}
	  else {
		  while($fila=mysql_fetch_array($productos)){
			  echo '
			  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			  	<tr>
					<td width="247" align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; padding-left:15px; padding-right:15px;">
						<a href="producto.php?id='.$fila['id_producto'].'#contenido">';
						$nombre_imagen = $fila['nombre_imagen'];
						$ruta_imagen = 'adjuntos/productos/'.$nombre_imagen;
						if($nombre_imagen=="0" OR $nombre_imagen=="")
						{
							echo '<img src="imagenes/noimagen.png" width="250" height="250" class="opacidad" />';
						}
						else {
							if(file_exists($ruta_imagen))
							{
								echo '<img src="adjuntos/productos/'.$nombre_imagen.'" width="250" height="250" class="opacidad" />';
							}
							else {
								echo '<img src="imagenes/noimagen.png" width="250" height="250" class="opacidad" />';
							}
						}
						echo '</a>
						<br />
					</td>
					<td valign="top" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; padding-left:15px; padding-right:15px;">
						<table width="670" border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td colspan="2"><span class="factura-texto4"><strong>'.$fila['nombre_producto'].'</strong></span></td>
							</tr>
							<tr>
								<td colspan="2"><span class="noaprobado">'.$fila['categoria'].'</span> - <span class="generado-sin">'.$fila['subcategoria'].'</span></td>
							</tr>
							<tr>
								<td colspan="2" class="texto-moneda-2" style="padding-top:15px; padding-bottom:15px;">$'.$fila['precio'].' MXN</td>
							</tr>
							<tr>
								<td width="140"><strong><span class="factura-texto2">Fecha de Alta</span></strong></td>
								<td width="514">'.$fila['fecha_alta'].' a las '.$fila['hora_alta'].' horas</td>
							</tr>
							<tr>
								<td><strong>Marca Comercial</strong></td>
								<td>'.$fila['marca'].'</td>
							</tr>
							<tr>
								<td><strong>Fabricante</strong></td>
								<td>'.$fila['fabricante'].'</td>
							</tr>
							<tr>
								<td colspan="2" align="right"><a href="producto.php?id='.$fila['id_producto'].'#contenido"><input name="ver_producto" type="button" class="boton-remuestreo" id="ver_producto" value="Ver Producto" /></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br/>';
			}
		}
	?>
	<?php include "footer.php"; ?></div>
    <br />
</body>
</html>
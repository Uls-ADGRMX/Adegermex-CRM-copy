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
<title>Adegermex S.A. de C.V. | Proveedores</title>
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
		xmlhttp.open("POST","engines/buscar_proveedor.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#196589">&nbsp;</td>
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
    <td align="center" class="titulo">Proveedores</td>
  </tr>
</table>
<br />
<div class="tabcontent">
<?php
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Agente de Compras"){
	echo '
<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td align="center"><a href="agregar_proveedor.php#contenido">
        <input class="boton-login" type="submit" name="agregar" id="agregar" value="Alta de nuevo Proveedor"/>
      </a></td>
    </tr>
  </table><br />';
}
?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Buscar Proveedor</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
        <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td>Buscar</td>
          </tr>
          <tr>
            <td><input name="buscar" type="text" required="required" class="textbox" id="buscar" placeholder="Ejemplo: ALKAN Quimica S.A. de C.V." autocomplete="off" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
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
    <td width="500" class="factura-texto4">Últimos 30 proveedores registrados</td>
    <td width="500" align="right" class="factura-texto4"><?php
                                    	$proveedores=mysql_query("SELECT * FROM tcproveedores",$conexion);
										$numero_proveedores=mysql_num_rows($proveedores);
											if ($numero_proveedores==0)
												{
													echo '0';
												}
											else {
												echo $numero_proveedores;
												}
												?> proveedores en total</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <?php
	  $proveedores=mysql_query("SELECT * FROM tcproveedores ORDER BY id_proveedor DESC LIMIT 30",$conexion);
	  $numero_proveedores=mysql_num_rows($proveedores);
	  if ($numero_proveedores==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/proveedor.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Proveedores</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
		  <tr class="encabezado-tabla">
		  <td width="600">Nombre del Proveedor</td>
		  <td width="241"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha de Alta</td>
		  <td width="93">Opciones</td>
		  </tr>';
		  while($fila=mysql_fetch_array($proveedores)){
			  echo '
			  <tr>
			  <td colspan="4"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
			  </tr>
			  <tr class="celda-activa">
			  <td><a href="proveedor.php?id='.$fila['id_proveedor'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
			  <td>'.$fila['fecha_alta'].'  |  '.$fila['hora_alta'].'</td>
			  <td width="93">
			  <table width="70" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			  <td align="center" width="35"><a href="editar_proveedor.php?id='.$fila['id_proveedor'].'#contenido"><img src="imagenes/editar.png" width="14" height="14" title="Editar" class="opacidad-accion"></a></td>
			  <td align="center" width="35"><a href="proveedor.php?id='.$fila['id_proveedor'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" class="opacidad-accion" title="Detalles"/></a></td>
			  </tr>
        </table>
        </td>
      </tr>';
	  }
	  echo '</table>';
	  }
	  ?>
    <br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
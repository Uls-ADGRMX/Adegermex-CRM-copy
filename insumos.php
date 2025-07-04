<?php
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
include 'scripts/conexion.php';
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
		xmlhttp.open("POST","engines/buscar_insumo.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#FDCF07">&nbsp;</td>
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
<?php
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Desarrollador" OR $tipo_usuario=="Agente de Compras"){
	echo '
	<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr>
			<td align="center">
				<a href="agregar_insumo.php#contenido"><input class="boton-login" type="submit" name="agregar" id="agregar" value="Alta de nuevo Insumo"/></a>
			</td>
		</tr>
	</table>
	<br />';
}
?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Buscar Insumo</td>
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
            <td><input name="buscar" type="text" required="required" class="textbox" id="buscar" placeholder="Código, nombre del insumo, categoría o tipo" autocomplete="off" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
          </tr>
        </table>
        <br />
      <div id="resultado"></div><br/>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Últimos 20 insumos registrados</td>
    <td width="500" align="right" class="factura-texto4"><?php
                                    	$insumos=mysql_query("SELECT * FROM tcinsumos",$conexion);
										$numero_insumos=mysql_num_rows($insumos);
											if ($numero_insumos==0)
												{
													echo '0';
												}
											else {
												echo $numero_insumos;
												}
												?> insumos en total</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <?php
	  $insumos=mysql_query("
	  SELECT tcinsumos.id_insumo AS id,
	  tcinsumos.codigo,
	  tcinsumos.nombre,
	  (SELECT tmcostos.valor_pesos FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS costo_pesos,
	  (SELECT tmcostos.valor_dolares FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS costo_dolares,
	  (SELECT tmcostos.moneda FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS moneda,
	  (SELECT tcproveedores.nombre FROM tcproveedores JOIN tmcostos WHERE tmcostos.id_proveedor = tcproveedores.id_proveedor AND tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS proveedor
	  FROM tcinsumos ORDER BY id DESC LIMIT 20",$conexion);
	  $numero_insumos=mysql_num_rows($insumos);
	  if ($numero_insumos==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/insumo.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Insumos</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '
		  <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
		  	<tr class="encabezado-tabla">
				<td width="120">Código</td>
				<td width="300">Nombre del Insumo</td>
				<td width="120"><img src="imagenes/mexico-min.png" width="16" height="12" /> Costo</td>
				<td width="120"><img src="imagenes/usa-min.png" width="17" height="13" /> Costo</td>
				<td width="280">Proveedor</td>
				<td width="90">Opciones</td>
			</tr>';
		  while($fila=mysql_fetch_array($insumos)){
			  echo '
			<tr>
				<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
			</tr>
			<tr class="celda-activa">
			  	<td>'.$fila['codigo'].'</td>
				<td><a href="insumo.php?id='.$fila['id'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
				<td>';
				if ($fila['costo_pesos']=="0" OR $fila['costo_pesos']==""){
					echo 'Sin registrar';	
				}
				else {
					echo '<strong>$ '.number_format($fila['costo_pesos'],4,".",",").'</strong>';
					if ($fila['moneda']=="1") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';}
				}
				echo '</td>
				<td>';
				if ($fila['costo_dolares']=="0" OR $fila['costo_dolares']==""){
					echo 'Sin registrar';	
				}
				else {
					echo '<strong>$ '.number_format($fila['costo_dolares'],4,".",",").'</strong>';
					if ($fila['moneda']=="2") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';}
				}
				echo '</td>
				<td>';
				if ($fila['proveedor']=="0" OR $fila['proveedor']==""){
					echo 'Sin registrar';
				}
				else {
					echo $fila['proveedor'];
				}
				echo '</td>
				<td>
					<table width="70" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center" width="35">
								<a href="editar_insumo.php?id='.$fila['id'].'#contenido"><img src="imagenes/editar.png" width="14" height="14" title="Editar" class="opacidad-accion"></a>
							</td>
							<td align="center" width="35">
								<a href="insumo.php?id='.$fila['id'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" class="opacidad-accion" title="Detalles"/></a>
							</td>
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
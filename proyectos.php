<?php
///////////////////////////////////////////////////////
// Eliminar Cache /////////////////////////////////////
///////////////////////////////////////////////////////
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
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
// Consulta para información de Parámetros ////////////
///////////////////////////////////////////////////////
$configuracion = "SELECT * FROM tmconfiguracion WHERE id_configuracion='1'";
$info=mysql_query($configuracion, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$orden_potencial = $infoarray->orden_potencial;
$eliminados = $infoarray->eliminados;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proyectos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css?version=5.0" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Busqueda de Proyecto -->
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
		xmlhttp.open("POST","engines/buscar_proyecto.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
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
<div class="tabcontent">
<?php
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Agente de Ventas"){
	echo '<br/>
	<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr>
			<td align="center"><a href="generar_proyecto.php#contenido"><input class="boton-login" type="submit" name="generar" id="generar" value="Generar Nuevo Proyecto"/></a>
			</td>
		</tr>
	</table>';
}
?>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Proyectos activos</td>
    <td width="500" align="right" class="factura-texto4"><?php
	if ($orden_potencial=="1")
	{
		if ($eliminados=="1")
		{
			if ($id_usuario=="29"){
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.status<>'Eliminado' AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY potencial ASC",$conexion);
			}
			else {
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.status<>'Eliminado' ORDER BY potencial ASC",$conexion);
			}
		}
		else
		{
			if($id_usuario=="29"){
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY potencial ASC",$conexion);
			}
			else {
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente ORDER BY potencial ASC",$conexion);
			}
		}
	}
	else {
		if ($eliminados=="1")
		{
			if($id_usuario=="29"){
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.status<>'Eliminado' AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY id_proyecto DESC",$conexion);
			}
			else {
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.status<>'Eliminado' ORDER BY id_proyecto DESC",$conexion);
			}
		}
		else
		{
			if($id_usuario=="29"){
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY id_proyecto DESC",$conexion);
			}
			else {
			$proyectos=mysql_query("
			SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
			FROM tmproyectos
			JOIN tcusuarios
			JOIN tcclientes
			WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente ORDER BY id_proyecto DESC",$conexion);
			}
		}
	}
	$numero_proyectos=mysql_num_rows($proyectos);
	if ($numero_proyectos==0)
	{
		echo '0 poyectos en total';
	}
	else {
		echo $numero_proyectos.' proyectos en total';
		}
	?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
<?php
if($numero_proyectos=="0"){
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#FFFFFF">
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/oops.png" width="180" height="180" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">No hay Proyectos</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">Actualmente no se tiene ningún Proyecto registrado en el sistema.</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	}
	else {
		echo '
		<br/>
		<table width="470" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
				<td>Buscar:</td>
			</tr>
			<tr>
				<td align="center"><input type="text" name="buscar" id="buscar" class="textbox-filtrar" placeholder="Nombre del proyecto, cliente, agente de ventas ó status" autocomplete="off" onkeyup="loadXMLDoc()"/></td>
			</tr>
			<tr>
				<td align="center">
					<br/>
					<a href="engines/exportar_proyectos.php"><img src="imagenes/exportar_proyectos.png" border="0" class="opacidad-accion"></a>
				</td>
			</tr>
		</table>
		<br/>
		<br/>
		<div id="resultado"></div>
		<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr class="encabezado-tabla">
				<td width="50">Folio</td>
				<td width="375">Nombre del Proyecto</td>
				<td width="250">Cliente / Prospecto</td>
				<td width="145">Status</td>
				<td width="70">Prioridad</td>
				<td width="60" align="center">Detalles</td>
			</tr>';
			while($fila=mysql_fetch_array($proyectos)){
				echo '
				<tr>
					<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
				</tr>
				<tr class="';
				switch ($fila['cierre_venta']){
					case "1":
						echo "celda-cierre-si";
						break;
					case "0":
						echo "celda-cierre-no";
						break;
					case "":
						echo "celda-activa2";
						break;
					}
				echo '">
				<td>'.$fila['id_proyecto'].'</td>
				<td>';
				switch ($fila['potencial']){
					case "1":
						echo "<img src='imagenes/alta.png' title='Potencial Alto'>";
						break;
					case "2":
						echo "<img src='imagenes/normal.png' title='Potencial Medio'>";
        				break;
    				case "3":
        				echo "<img src='imagenes/baja.png' title='Potencial Bajo'>";
        				break;
						}
				echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="tooltip"><span class="tooltiptext">Generado por '.$fila['generador'].' | '.$fila['fecha_generacion'].'</span>'.$fila['nombre_proyecto'].'</a></td>
				<td>'.$fila['cliente'].'</td>
				<td><span class="';
				switch ($fila['status']) {
					case "Generado / Sin Asignar":
						echo "generado-sin";
						break;
					case "Autorizado":
        				echo "autorizado";
        				break;
    				case "Generado / Asignado":
        				echo "generado-asignado";
        				break;
					case "En Desarrollo":
        				echo "desarrollo";
        				break;
					case "Rechazado":
        				echo "rechazado";
        				break;
					case "Muestra Entregada":
        				echo "muestra";
        				break;
					case "Enviado al Cliente":
        				echo "cliente";
        				break;
					case "Aprobado":
        				echo "aprobado";
        				break;
					case "No Aprobado":
        				echo "noaprobado";
        				break;
					case "Reformular":
        				echo "reformular";
        				break;
    				case "Finalizado":
        				echo "finalizado";
        				break;
					case "Eliminado":
        				echo "eliminado";
        				break;
					case "Prueba Piloto":
        				echo "prueba";
        				break;
					case "Recotizar":
        				echo "recotizar";
        				break;
					case "Revisado":
						echo "revisado";
						break;
					case "Remuestreo":
						echo "remuestreo";
						break;
						}
				echo '">'.$fila['status'].'</span></td>
				<td>';
				if ($fila['prioridad']=="Urgente"){ echo "<span class='texto-urgente'>Urgente</span>"; } else { echo $fila['prioridad']; }
				switch ($fila['prioridad']){
					case 'Alta':
						echo "<img src='imagenes/alta.png'/>";
        				break;
					case 'Baja':
						echo "<img src='imagenes/baja.png'/>";
        				break;
					case 'Normal':
        				echo "<img src='imagenes/normal.png'/>";
        				break;
					case 'Urgente':
        				echo "<img src='imagenes/urgente.png'/>";
        				break;	
					}
				echo '</td>
				<td align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
			</tr>';
		}
	echo '</table><br/>';
}
?>
<br/>
</td>
</tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
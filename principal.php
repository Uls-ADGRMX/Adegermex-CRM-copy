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
$correo = $arrayusuario->correo;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Panel de Administración</title>
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
		var t=document.getElementById('idd').value;
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
		xmlhttp.send("q="+n+"&"+"d="+t);
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#EB8715">&nbsp;</td>
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
    <td align="center" class="titulo">Panel de Administración</td>
  </tr>
</table>
<div class="tabcontent">
<?php
///////////////////////////////////////////////////////
// Proyectos esperando autorización ///////////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Consultor"){
///////////////////////////////////////////////////////
// Usuario Walter Wilde  //////////////////////////////
///////////////////////////////////////////////////////
	if ($id_usuario=="29")
	{
	$paut=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND (tmproyectos.status='Generado / Sin Asignar' OR tmproyectos.status='Revisado') AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	}
	else {
	$paut=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND (tmproyectos.status='Generado / Sin Asignar' OR tmproyectos.status='Revisado') ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	}
	$npaut=mysql_num_rows($paut);
	if ($npaut<>0){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Proyectos esperando autorización</td>
				<td class="factura-texto4" align="right" style="padding-right:10px;">'.$npaut.' en total</td>
			</tr>
		</table>
		<br />
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF"><br />
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr class="encabezado-tabla">
							<td width="50">Folio</td>
							<td width="390">Nombre del Proyecto</td>
							<td width="95">Generado el</td>
							<td width="140">Generado por</td>
							<td width="145">Status</td>
							<td width="70">Prioridad</td>
							<td width="60" align="center">Detalles</td>
						</tr>';
						while($fila=mysql_fetch_array($paut)){
							echo '
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="';
						switch ($fila['cierre_venta']) {
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
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="390">';
							switch ($fila['potencial']) {
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
							echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
							<td width="95">'.$fila['fecha_generacion'].'</td>
							<td width="140">'.$fila['generador'].'</td>
							<td width="145"><span class="';
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
							<td width="70">';
							if ($fila['prioridad']=="Urgente") {
								echo "<span class='texto-urgente'>Urgente</span>";
								}
								else {
									echo $fila['prioridad'];
									}
							switch ($fila['prioridad']) {
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
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
else {
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="factura-texto4">Proyectos esperando autorización</td>
		</tr>
	</table>
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td bgcolor="#FFFFFF">
				<br />
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">¡Está al día!</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">No hay proyectos pendientes de autorizar</td>
					</tr>
				</table>
				<br />
			</td>
		</tr>
	</table>';
	}
}
///////////////////////////////////////////////////////
// Proyectos esperando asignación /////////////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Consultor"){
///////////////////////////////////////////////////////
// Usuario Walter Wilde  //////////////////////////////
///////////////////////////////////////////////////////
	if ($id_usuario==29)
	{
	$pasig=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.status='Autorizado' AND (tmproyectos.id_usugenera='29' OR tmproyectos.id_usugenera='24' OR tmproyectos.id_usugenera='9' OR tmproyectos.id_usugenera='28' OR tmproyectos.id_usugenera='25' OR tmproyectos.id_usugenera='12' OR tmproyectos.id_usugenera='30' OR tmproyectos.id_usugenera='31') ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	}
	else {
	$pasig=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.status='Autorizado' ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	}
	$npasig=mysql_num_rows($pasig);
	if ($npasig<>0){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Proyectos esperando asignación</td>
				<td class="factura-texto4" align="right" style="padding-right:10px;">'.$npasig.' en total</td>
			</tr>
		</table>
		<br />
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF"><br />
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr class="encabezado-tabla">
							<td width="50">Folio</td>
							<td width="390">Nombre del Proyecto</td>
							<td width="95">Generado el</td>
							<td width="140">Generado por</td>
							<td width="145">Status</td>
							<td width="70">Prioridad</td>
							<td width="60" align="center">Detalles</td>
						</tr>';
						while($fila=mysql_fetch_array($pasig)){
							echo '
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="';
						switch ($fila['cierre_venta']) {
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
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="390">';
							switch ($fila['potencial']) {
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
							echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
							<td width="95">'.$fila['fecha_generacion'].'</td>
							<td width="140">'.$fila['generador'].'</td>
							<td width="145"><span class="';
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
							<td width="70">';
							if ($fila['prioridad']=="Urgente") {
								echo "<span class='texto-urgente'>Urgente</span>";
								}
								else {
									echo $fila['prioridad'];
									}
							switch ($fila['prioridad']) {
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
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
else {
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="factura-texto4">Proyectos esperando asignación</td>
		</tr>
	</table>
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td bgcolor="#FFFFFF">
				<br />
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">¡Está al día!</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">No hay proyectos pendientes de asignar</td>
					</tr>
				</table>
				<br />
			</td>
		</tr>
	</table>';
	}
}
///////////////////////////////////////////////////////
// Proyectos que le han asignado //////////////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Desarrollador"){
	$pqlha=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_usuasignado = $id_usuario ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	$npqlha=mysql_num_rows($pqlha);
	if ($npqlha<>0){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Proyectos que le han asignado</td>
				<td class="factura-texto4" align="right" style="padding-right:10px;">'.$npqlha.' en total</td>
			</tr>
		</table>
		<br />
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF">
					<br/>
					<table width="470" border="0" align="center" cellpadding="2" cellspacing="0">
						<tr>
							<td>Buscar:</td>
						</tr>
						<tr>
							<td align="center" class="subtitulo">
								<input type="text" name="buscar" id="buscar" class="textbox-filtrar" placeholder="Nombre del proyecto, cliente, agente de ventas ó status" autocomplete="off" onkeyup="loadXMLDoc()"/>
								<input type="hidden" name="idd" id="idd" autocomplete="off" value="'.$id_usuario.'"/>
							</td>
						</tr>
					</table>
					<br/>
					<table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center" width="400">
								<a href="engines/exportar_proyectos.php"><img src="imagenes/exportar_proyectos.png" border="0" class="opacidad-accion"></a>
							</td>
							<td align="center" width="400">
								<a href="engines/exportar_eventos.php"><img src="imagenes/exportar_eventos.png" border="0" class="opacidad-accion"></a>
							</td>
						</tr>
					</table>
					<br/>
					<br/>
					<div id="resultado"></div>
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr class="encabezado-tabla">
							<td width="50">Folio</td>
							<td width="390">Nombre del Proyecto</td>
							<td width="95">Generado el</td>
							<td width="140">Generado por</td>
							<td width="145">Status</td>
							<td width="70">Prioridad</td>
							<td width="60" align="center">Detalles</td>
						</tr>';
						while($fila=mysql_fetch_array($pqlha)){
							echo '
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="';
						switch ($fila['cierre_venta']) {
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
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="390">';
							switch ($fila['potencial']) {
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
							echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
							<td width="95">'.$fila['fecha_generacion'].'</td>
							<td width="140">'.$fila['generador'].'</td>
							<td width="145"><span class="';
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
							<td width="70">';
							if ($fila['prioridad']=="Urgente") {
								echo "<span class='texto-urgente'>Urgente</span>";
								}
								else {
									echo $fila['prioridad'];
									}
							switch ($fila['prioridad']) {
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
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
else {
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="factura-texto4">Proyectos que le han asignado</td>
		</tr>
	</table>
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td bgcolor="#FFFFFF">
				<br />
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">¡Está al día!</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">No tiene proyectos asignados</td>
					</tr>
				</table>
				<br />
			</td>
		</tr>
	</table>';
	}
}
///////////////////////////////////////////////////////
// Proyectos que ha generado //////////////////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Agente de Ventas"){
	if ($tipo_usuario=="Agente de Ventas")
		{
			echo '
			<br/>
			<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
				<tr>
					<td align="center"><a href="generar_proyecto.php#contenido"><input class="boton-login" type="submit" name="generar" id="generar" value="Generar Nuevo Proyecto"/></a></td>
				</tr>
			</table>';
		}
$pqhg=mysql_query("SELECT tmproyectos.id_proyecto,
tmproyectos.nombre_proyecto,
tmproyectos.fecha_generacion,
tmproyectos.status,
tmproyectos.prioridad,
tmproyectos.potencial,
tmproyectos.cierre_venta,
(SELECT tcusuarios.nombre FROM tcusuarios WHERE tcusuarios.id_usuario = tmproyectos.id_usuasignado) AS asignado
FROM tmproyectos
WHERE tmproyectos.id_usugenera = $id_usuario ORDER BY tmproyectos.id_proyecto DESC",$conexion);
	$npqhg=mysql_num_rows($pqhg);
	if ($npqhg<>0){
		echo '<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Proyectos que ha generado</td>
				<td class="factura-texto4" align="right" style="padding-right:10px;">'.$npqhg.' en total</td>
			</tr>
		</table>
		<br />
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF">
					<br />';
					if ($tipo_usuario=="Agente de Ventas")
					{
						echo '
					<table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center" width="400">
								<a href="engines/exportar_proyectos.php"><img src="imagenes/exportar_proyectos.png" border="0" class="opacidad-accion"></a>
							</td>
							<td align="center" width="400">
								<a href="engines/exportar_eventos.php"><img src="imagenes/exportar_eventos.png" border="0" class="opacidad-accion"></a>
							</td>
						</tr>
					</table>
					<br/>';
					}
					echo '
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr class="encabezado-tabla">
							<td width="50">Folio</td>
							<td width="390">Nombre del Proyecto</td>
							<td width="95">Generado el</td>
							<td width="140">Asignado a</td>
							<td width="145">Status</td>
							<td width="70">Prioridad</td>
							<td width="60" align="center">Detalles</td>
						</tr>';
						while($fila=mysql_fetch_array($pqhg)){
							echo '
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="';
						switch ($fila['cierre_venta']) {
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
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="390">';
							switch ($fila['potencial']) {
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
							echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
							<td width="95">'.$fila['fecha_generacion'].'</td>
							<td width="140">';
							if(empty($fila['asignado'])) { echo 'Sin Asignar'; } else { echo $fila['asignado']; }
							echo '</td>
							<td width="145"><span class="';
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
							<td width="70">';
							if ($fila['prioridad']=="Urgente") {
								echo "<span class='texto-urgente'>Urgente</span>";
								}
								else {
									echo $fila['prioridad'];
									}
							switch ($fila['prioridad']) {
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
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
else {
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="factura-texto4">Proyectos que ha generado</td>
		</tr>
	</table>
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td bgcolor="#FFFFFF">
				<br />
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">¡Está al día!</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">No ha generado proyectos</td>
					</tr>
				</table>
				<br />
			</td>
		</tr>
	</table>';
	}
}
///////////////////////////////////////////////////////
// Últimos 30 proyectos que ha asignado ///////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario"){
	$pqha=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS asignado
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usuasignado = tcusuarios.id_usuario AND tmproyectos.id_usuasignador = $id_usuario ORDER BY tmproyectos.id_proyecto DESC LIMIT 30",$conexion);
	$npqha=mysql_num_rows($pqha);
	if ($npqha<>0){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Últimos 30 proyectos que ha asignado</td>
				<td class="factura-texto4" align="right" style="padding-right:10px;">'.$npqha.' en total</td>
			</tr>
		</table>
		<br />
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF"><br />
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr class="encabezado-tabla">
							<td width="50">Folio</td>
							<td width="390">Nombre del Proyecto</td>
							<td width="95">Generado el</td>
							<td width="140">Asignado a</td>
							<td width="145">Status</td>
							<td width="70">Prioridad</td>
							<td width="60" align="center">Detalles</td>
						</tr>';
						while($fila=mysql_fetch_array($pqha)){
							echo '
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="';
						switch ($fila['cierre_venta']) {
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
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="390">';
							switch ($fila['potencial']) {
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
							echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
							<td width="95">'.$fila['fecha_generacion'].'</td>
							<td width="140">'.$fila['asignado'].'</td>
							<td width="145"><span class="';
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
							<td width="70">';
							if ($fila['prioridad']=="Urgente") {
								echo "<span class='texto-urgente'>Urgente</span>";
								}
								else {
									echo $fila['prioridad'];
									}
							switch ($fila['prioridad']) {
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
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
else {
	echo '
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="factura-texto4">Últimos 30 proyectos que ha asignado</td>
		</tr>
	</table>
	<br/>
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td bgcolor="#FFFFFF">
				<br />
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
					</tr>
					<tr>
						<td align="center" class="titulo">¡Está al día!</td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">No hay proyectos asignados</td>
					</tr>
				</table>
				<br />
			</td>
		</tr>
	</table>';
	}
}
///////////////////////////////////////////////////////
// Costos esperabdo incrementables ////////////////////
///////////////////////////////////////////////////////
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Agente de Compras"){
	$costosinc=mysql_query("
	SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tmcostos.id_costo, tmcostos.fecha_alta, tmcostos.hora_alta, tmcostos.moneda, tmcostos.c_pesos, tmcostos.c_dolares, tcusuarios.nombre AS nombre_usuario
	FROM tmcostos
	JOIN tcinsumos, tcusuarios
	WHERE tmcostos.id_insumo = tcinsumos.id_insumo AND tmcostos.id_usuario = tcusuarios.id_usuario AND tmcostos.incrementables='1' ORDER BY id_costo DESC", $conexion);
	$numero_costosinc=mysql_num_rows($costosinc);
	if ($numero_costosinc=="0"){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Costos esperando incrementables</td>
			</tr>
		</table>
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF">
					<br/>
					<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
						</tr>
						<tr>
							<td align="center" class="titulo">¡Está al día!</td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay costos en espera de incrementables</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
		else {
			echo '<br/>
			<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td class="factura-texto4">Costos esperando incrementables</td>
				</tr>
			</table>
			<br/>
			<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
				<tr>
					<td bgcolor="#FFFFFF" align="center">
						<br/>
						<table width="950" border="0" cellspacing="0" cellpadding="4">
							<tr class="encabezado-tabla">
								<td width="110">Código del Insumo</td>
								<td width="300">Nombre del Insumo</td>
								<td width="145"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha de Alta</td>
								<td width="135">Costo</td>
								<td width="140"><img src="imagenes/user.png" width="18" height="18" /> Registrado por</td>
								<td width="120" align="center">Incrementables</td>
							</tr>';
							while($filaci=mysql_fetch_array($costosinc)){
								echo '
								<tr>
									<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
								</tr>
								<tr class="celda-activa2">
									<td>'.$filaci['codigo'].'</td>
									<td><a href="insumo.php?id='.$filaci['id_insumo'].'#contenido" class="link">'.$filaci['nombre'].'</a></td>
									<td>'.$filaci['fecha_alta'].' | '.$filaci['hora_alta'].'</td>';
									if ($filaci['moneda']=="2"){
										echo '<td>$ '.number_format($filaci['c_dolares'],4,".",",").' <img src="imagenes/usa-min.png" width="17" height="13" /></td>';
										}
									else {
										echo '<td>$ '.number_format($filaci['c_pesos'],4,".",",").' <img src="imagenes/mexico-min.png" width="17" height="13" /></td>';
										}
									echo '<td>'.$filaci['nombre_usuario'].'</td>';
									if ($tipo_usuario<>"Administrador"){
										echo '<td align="center">En espera</td>';
									}
									else {
										echo '<td align="center"><a href="incrementable.php?id='.$filaci['id_costo'].'#contenido">Registrar</a></td>';
									}
								echo '</tr>';
								}
					echo '
						</table>
						<br/>
					</td>
				</tr>
			</table>';
			}
		}
	else {
		}
///////////////////////////////////////////////////////
// Clientes esperando asignación //////////////////////
///////////////////////////////////////////////////////
if($tipo_usuario=="Administrador"){
	$cea=mysql_query("SELECT tcclientes.id_cliente, tcclientes.nombre, tcclientes.fecha_alta, tcclientes.hora_alta, tcclientes.tipo, tcclientes.pertenece FROM tcclientes WHERE id_asignado='0' ORDER BY nombre ASC", $conexion);
	$nces=mysql_num_rows($cea);
	if ($nces=="0"){
		echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="factura-texto4">Clientes esperando asignación</td>
			</tr>
		</table>
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td bgcolor="#FFFFFF">
					<br/>
					<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center"><img src="imagenes/ok.png" width="100" height="100" /></td>
						</tr>
						<tr>
							<td align="center" class="titulo">¡Está al día!</td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay clientes en espera de asignación</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>
		</table>';
		}
		else {
			echo '<br/>
			<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td class="factura-texto4">Clientes esperando asignación</td>
				</tr>
			</table>
			<br/>
			<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
				<tr>
					<td bgcolor="#FFFFFF" align="center">
						<br/>
						<table width="950" border="0" cellspacing="0" cellpadding="4">
							<tr class="encabezado-tabla">
								<td width="400">Nombre del Cliente / Prospecto</td>
								<td width="180"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha de Alta</td>
								<td width="120">Tipo</td>
								<td width="250">Pertenece a</td>
							</tr>';
							while($fila=mysql_fetch_array($cea)){
								echo '
								<tr>
									<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
								</tr>
								<tr class="celda-activa2">
									<td><a href="cliente.php?id='.$fila['id_cliente'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
									<td>'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
									<td>'.$fila['tipo'].'</td>
									<td>'.$fila['pertenece'].'</td>
								</tr>';
								}
					echo '
						</table>
						<br/>
					</td>
				</tr>
			</table>';
			}
		}
	else {
		}
?>
<br/>
<?php include "footer.php"; ?></div>
<br/>
</body>
</html>
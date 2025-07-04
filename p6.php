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
// Zona Horaria predeterminada ////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// Datos del Reporte //////////////////////////////////
///////////////////////////////////////////////////////
$fecha_inicial = $_GET['fi'];
$fecha_final = $_GET['ff'];
if ($fecha_inicial > $fecha_final)
{
	$fr = 1;
}
else {
	$fr = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Estadísticas</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#B31919">&nbsp;</td>
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
    <td align="center" class="titulo">Estadísticas</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td class="factura-texto4"><a name="contenido" id="contenido"></a>Reporte</td>
  </tr>
</table>
<br />
<div id="report">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF" align="center"><br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center" class="titulo">Proyectos por Segmento</td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><img src="imagenes/linea-800.png" width="900" height="1" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><span class="subtitulo">Reporte generado el: <?php echo '<strong>'.$fecha.'</strong> a las <strong>'.$hora.'</strong> horas'?></span></td>
        </tr>
      </table>
      <br/>
<?php
  if($fr==0) {
	echo '
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" class="mensaje-correcto">Usted está consultando información correspondiente al periodo del <strong>'.$fecha_inicial.'</strong> al <strong>'.$fecha_final.'</strong>.</td>
		</tr>
	</table>
	<br/>';
  }
  else if ($fr==1) {
	echo '
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" class="mensaje-error">El periodo de fechas ingresado es incorrecto. La fecha inicial es mayor a la fecha final.</td>
		</tr>
	</table>
	<br/>';
  }
?>
</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF" align="center"><br />
<?php
if($fr==1)
{
	echo '
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#FFFFFF">
				<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="imagenes/fecha.png" width="180" height="180" /></td>
					</tr>
					<tr>
						<td align="center" class="factura-texto2">El periodo de tiempo seleccionado es incorrecto. Por favor verifiquelo y <a href="estadisticas.php#reportes">vuelva a intentarlo</a>.</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	';	
}
else {
$segmentos=mysql_query("SELECT DISTINCT tmproyectos.segmento
FROM tmproyectos ORDER BY tmproyectos.segmento ASC",$conexion);
while($fila=mysql_fetch_array($segmentos)){
	$sg = $fila['segmento'];
	$proyectos = mysql_query("
	SELECT tmproyectos.*, tcclientes.nombre AS cliente
	FROM tmproyectos
	JOIN tcclientes
	WHERE tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.segmento = '$sg' AND tmproyectos.fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY id_proyecto ASC",$conexion);
	$nproyectos = mysql_num_rows($proyectos);
	echo '
	<table width="950" border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td class="factura-texto4" align="center" bgcolor="#EFEFEF">'.$fila['segmento'].'<br/><span class="subtitulo">'.$nproyectos.' proyectos en total</span></td>
		</tr>
        <tr>
          <td><br/>';
if ($nproyectos=="0")
{
	echo 'No hay proyectos generados.<br/>';
}
else {
		  echo '<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr class="encabezado-tabla">
				<td width="50">Folio</td>
				<td width="375">Nombre del Proyecto</td>
				<td width="250">Cliente / Prospecto</td>
				<td width="145">Status</td>
				<td width="70">Prioridad</td>
				<td width="60" align="center">Detalles</td>
			</tr>';
			while($proyecto=mysql_fetch_array($proyectos)){
				echo '
				<tr>
					<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
				</tr>
				<tr class="';
				switch ($proyecto['cierre_venta']){
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
				<td>'.$proyecto['id_proyecto'].'</td>
				<td>';
				switch ($proyecto['potencial']){
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
				echo ' <a href="proyecto.php?id='.$proyecto['id_proyecto'].'#contenido" class="tooltip"><span class="tooltiptext">Fecha de Generación: '.$proyecto['fecha_generacion'].'</span>'.$proyecto['nombre_proyecto'].'</a></td>
				<td>'.$proyecto['cliente'].'</td>
				<td><span class="';
				switch ($proyecto['status']) {
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
				echo '">'.$proyecto['status'].'</span></td>
				<td>';
				if ($proyecto['prioridad']=="Urgente"){ echo "<span class='texto-urgente'>Urgente</span>"; } else { echo $proyecto['prioridad']; }
				switch ($proyecto['prioridad']){
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
				<td align="center"><a href="proyecto.php?id='.$proyecto['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
			</tr>';
		}
	echo '</table>';
}
echo '<br/>
	</td>
</tr>
</table>
';
}
}
?>
<br /></td>
  </tr>
</table>
</div>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
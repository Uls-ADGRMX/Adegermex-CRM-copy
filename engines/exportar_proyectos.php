<?php
///////////////////////////////////////////////////////
// Inicio de Sesión ///////////////////////////////////
///////////////////////////////////////////////////////
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: ../index.php');
}
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
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
/////////////////////////////////////////////////////
// Fecha y Hora Actual //////////////////////////////
/////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$anio = date("Y");
$mes = date("m");
$dia = date("d");
$hora = date("H");
$minuto = date("i");
$segundo = date("s");
$fecha = $anio."-".$mes."-".$dia."_".$hora."-".$minuto."-".$segundo;
$gfecha = date("Y-m-d");
$ghora = date("H-i-s");
/////////////////////////////////////////////////////
// Formato del Archvivo a Generar ///////////////////
/////////////////////////////////////////////////////
header("Content-type: application/vnd.ms-excel; name='excel'; charset='utf-8';");
header("Content-Disposition: filename=Proyectos_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<head>
<meta http-equiv='Content-Type' content='charset=utf-8' />
</head>";
echo '<body>';
echo '<table width="1500" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr>
			<td align="center" colspan="7"><h2>Adegermex S.A. de C.V. Plataforma</h5></td>
		</tr>
		<tr>
			<td align="center" colspan="7"><h3>Proyectos de I+D | Reporte Generado: '.$gfecha.' a las '.$ghora.' horas</h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr bgcolor="#EEEEEE">
          <td width="100" align="center"><b>Folio</b></td>
          <td width="400"><b>Nombre del Proyecto</b></td>
          <td width="400"><b>Nombre del Cliente</b></td>
          <td width="180"><b>Generado por</b></td>
		  <td width="180"><b>Status</b></td>
		  <td width="140"><b>Tipo de Proyecto</b></td>
		  <td width="210"><b>Categoría del Proyecto</b></td>
		  <td width="140"><b>Segmento del Proyecto</b></td>
		  <td width="140"><b>Potencial de Negocio</b></td>
		  <td width="140"><b>Venta Anual (USD)</b></td>
		  <td width="145" align="center"><b>Fecha de Generación</b></td>
		  <td width="145" align="center"><b>Fecha de Término</b></td>
		  <td width="170" align="center"><b>Fecha de Última Actualización</b></td>
		  <td width="170" align="center"><b>Días sin Actividad</b></td>
		  <td width="140"><b>Tipo de Aprobación</b></td>
		  <td width="140"><b>Tipo de No Aprobación</b></td>
        </tr>';
		if($tipo_usuario=="Agente de Ventas")
		{
			$proyectos=mysql_query("SELECT * FROM tmproyectos WHERE tmproyectos.id_usugenera='$id_usuario' ORDER BY id_proyecto DESC",$conexion);
		}
		elseif($tipo_usuario=="Desarrollador")
		{
			$proyectos=mysql_query("SELECT * FROM tmproyectos WHERE tmproyectos.id_usuasignado='$id_usuario' ORDER BY id_proyecto DESC",$conexion);
		}
		else {
			$proyectos=mysql_query("SELECT * FROM tmproyectos ORDER BY id_proyecto DESC",$conexion);
		}
	while($fila=mysql_fetch_array($proyectos)){
	echo "<tr>";
	echo "<td align='center'>".$fila['id_proyecto']."</td>";
	echo "<td>".$fila['nombre_proyecto']."</td>";
	echo "<td>";
	$id_cliente = $fila['id_cliente'];
	if ($id_cliente==0)
	{
		echo "Sin Cliente Definido";
	}
	else {
	$cliente = mysql_query("SELECT nombre FROM tcclientes WHERE id_cliente=$id_cliente", $conexion);
	$arraycliente = mysql_fetch_object($cliente);
	echo $arraycliente->nombre;
	}
	echo "</td>";
	echo "<td>";
	$id_usugenera = $fila['id_usugenera'];
	$generador = mysql_query("SELECT nombre FROM tcusuarios WHERE id_usuario=$id_usugenera", $conexion);
	$arraygenerador = mysql_fetch_object($generador);
	echo $arraygenerador->nombre;
	echo "</td>";
	echo "<td bgcolor='";
	switch ($fila['status']) {
		case "Generado / Sin Asignar":
			echo "#333333";
			break;
		case "Autorizado":
        	echo "#48A623";
        	break;
    	case "Generado / Asignado":
        	echo "#2255A4";
        	break;
		case "En Desarrollo":
        	echo "#EB8715";
        	break;
		case "Rechazado":
        	echo "#A73728";
        	break;
		case "Muestra Entregada":
        	echo "#48C9B0";
        	break;
		case "Enviado al Cliente":
        	echo "#2E86C1";
        	break;
		case "Aprobado":
        	echo "#1FA7CF";
        	break;
		case "No Aprobado":
        	echo "#442662";
        	break;
		case "Reformular":
        	echo "#E7D50F";
        	break;
    	case "Finalizado":
        	echo "#48A623";
        	break;
		case "Eliminado":
        	echo "#CB0016";
        	break;
		case "Prueba Piloto":
        	echo "#FF6400";
        	break;
		case "Recotizar":
        	echo "#D1266A";
        	break;
		case "Revisado":
			echo "#7D3C98";
			break;
		case "Remuestreo":
			echo "#526D82";
			break;
		}
	echo "'><font color='#FFFFFF'>".$fila['status']."</font></td>";
	echo "<td>".$fila['tipo']."</td>";
	echo "<td>".$fila['categoria']."</td>";
	echo "<td>".$fila['segmento']."</td>";
	echo "<td>";
	switch ($fila['potencial']) {
		case "1":
			echo "Alto";
			break;
		case "2":
        	echo "Medio";
        	break;
    	case "3":
        	echo "Bajo";
        	break;
		}
	echo "</td>";
	echo "<td>";
	$id_proyecto = $fila['id_proyecto'];
	$venta = mysql_query("SELECT vanual_num FROM tmrequisitos WHERE id_proyecto=$id_proyecto", $conexion);
	$arrayventa = mysql_fetch_object($venta);
	echo number_format($arrayventa->vanual_num,0,".",",");
	echo "</td>";
	echo "<td align='center'>".$fila['fecha_generacion']."</td>";
	echo "<td align='center'>".$fila['fecha_termino']."</td>";
	echo "<td align='center'>";
	$id_proyecto = $fila['id_proyecto'];
	$actualizacion = mysql_query("SELECT tmeventos.id_evento, tmeventos.id_proyecto, tmeventos.fecha FROM tmeventos WHERE id_proyecto=$id_proyecto ORDER BY id_evento DESC LIMIT 1", $conexion);
	$arrayactualizacion = mysql_fetch_object($actualizacion);
	$afecha = $arrayactualizacion->fecha;
	echo $afecha;
	echo "</td>";
	$fecha1 = new DateTime($gfecha);
	$fecha2 = new DateTime($afecha);
	$diff = $fecha1->diff($fecha2);
	echo "<td align='center'>".$diff->days."</td>";
	echo "<td>";
	switch ($fila['aprobacion']) {
		case "":
			echo "No Definido";
			break;
		case "1":
			echo "Comercial";
			break;
		case "2":
        	echo "Técnica";
        	break;
    	case "3":
        	echo "Comercial y Técnica";
        	break;
		}
	echo "</td>";
	echo "<td>";
	switch ($fila['noaprobacion']) {
		case "":
			echo "No Definido";
			break;
		case "1":
			echo "Comercial";
			break;
		case "2":
        	echo "Técnica";
        	break;
    	case "3":
        	echo "Comercial y Técnica";
        	break;
		}
	echo "</td>";
	echo "</tr>";
	}
echo "</table>";
echo "</body>";
?>
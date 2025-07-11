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
header("Content-Disposition: filename=Eventos_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<head>
<meta http-equiv='Content-Type' content='charset=utf-8' />
</head>";
echo '<body>';
echo '<table width="980" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr>
			<td align="center" colspan="7"><h2>Adegermex S.A. de C.V. Plataforma</h5></td>
		</tr>
		<tr>
			<td align="center" colspan="7"><h3>Eventos de I+D | Reporte Generado: '.$gfecha.' a las '.$ghora.' horas</h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr bgcolor="#EEEEEE">
          <td width="120" align="center"><b>Folio del Evento</b></td>
          <td width="120" align="center"><b>Folio del Proyecto</b></td>
          <td width="400" align="center"><b>Nombre del Cliente</b></td>
          <td width="180" align="center"><b>Nombre del Usuario</b></td>
          <td width="160" align="center"><b>Tipo de Evento</b></td>
		  <td width="145" align="center"><b>Fecha</b></td>
		  <td width="145" align="center"><b>Hora</b></td>
		  <td width="480"><b>Evento</b></td>
		  <td width="260"><b>Archivo Adjunto</b></td>
          <td width="150" align="center"><b>Peso Adjunto</b></td>
		  <td width="150"><b>Tipo Adjunto</b></td>
        </tr>';
		if($tipo_usuario=="Agente de Ventas" OR $tipo_usuario=="Desarrollador")
		{
			$eventos=mysql_query("SELECT * FROM tmeventos WHERE id_usuario='$id_usuario' ORDER BY id_evento DESC",$conexion);
		}
		else {
			$eventos=mysql_query("SELECT * FROM tmeventos ORDER BY id_evento DESC",$conexion);
		}
	while($fila=mysql_fetch_array($eventos)){
	echo "<tr>";
	echo "<td align='center'>".$fila['id_evento']."</td>";
	echo "<td align='center'>".$fila['id_proyecto']."</td>";
	echo "<td>";
	$id_cliente = $fila['id_cliente'];
	$id_proyecto = $fila['id_proyecto'];
	if ($id_cliente==0)
	{
	$cliente = mysql_query("SELECT tcclientes.nombre FROM tcclientes JOIN tmproyectos WHERE tcclientes.id_cliente = tmproyectos.id_cliente AND tmproyectos.id_proyecto = $id_proyecto", $conexion);
	$arraycliente = mysql_fetch_object($cliente);
	echo $arraycliente->nombre;
	}
	if ($id_proyecto==0)
	{
	$cliente = mysql_query("SELECT tcclientes.nombre FROM tcclientes WHERE tcclientes.id_cliente = $id_cliente", $conexion);
	$arraycliente = mysql_fetch_object($cliente);
	echo $arraycliente->nombre;
	}
	echo "</td>";
	echo "<td>";
	$id_usu = $fila['id_usuario'];
	$usu = mysql_query("SELECT nombre FROM tcusuarios WHERE id_usuario = $id_usu", $conexion);
	$arrayusu = mysql_fetch_object($usu);
	echo $arrayusu->nombre;
	echo "</td>";
	echo "<td align='center'>".$fila['tipo_evento']."</td>";
	echo "<td align='center'>".$fila['fecha']."</td>";
	echo "<td align='center'>".$fila['hora']."</td>";
	echo "<td>".$fila['evento']."</td>";
	echo "<td>".$fila['nombre_adjunto']."</td>";
	echo "<td align='center'>".$fila['peso_adjunto']."</td>";
	echo "<td>".$fila['tipo_adjunto']."</td>";
	echo "</tr>";
	}
echo "</table>";
echo "</body>";
?>
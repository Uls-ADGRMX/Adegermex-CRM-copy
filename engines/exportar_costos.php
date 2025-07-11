<?php
/////////////////////////////////////////////////////
// Conexión de la Base de Datos /////////////////////
/////////////////////////////////////////////////////
include '../scripts/conexion.php';
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
header("Content-Disposition: filename=Costos_$fecha.xls");
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
			<td align="center" colspan="7"><h3>Costos de I+D | Reporte Generado: '.$gfecha.' a las '.$ghora.' horas</h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr bgcolor="#EEEEEE">
          <td width="100" align="center"><b>Folio</b></td>
          <td width="120" align="center"><b>Fecha Alta</b></td>
          <td width="120" align="center"><b>Hora de Alta</b></td>
          <td width="170" align="center"><b>Código del Insumo</b></td>
          <td width="480"><b>Nombre del Insumo</b></td>
		  <td width="480"><b>Proveedor</b></td>
		  <td width="180"><b>Nombre del Usuario</b></td>
		  <td width="180"><b>Moneda de Origen</b></td>
		  <td width="150" align="center"><b>Costo MXN</b></td>
          <td width="150" align="center"><b>Costo USD</b></td>
		  <td width="150" align="center"><b>Tipo de Cambio Aplicado</b></td>
		  <td width="550"><b>Comentario</b></td>
        </tr>';
$costos=mysql_query("
SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tcproveedores.id_proveedor, tcproveedores.nombre AS proveedor, tcusuarios.id_usuario, tcusuarios.nombre AS usuario, tmcostos.*
FROM tmcostos
JOIN tcinsumos
JOIN tcproveedores
JOIN tcusuarios
WHERE tmcostos.id_insumo=tcinsumos.id_insumo AND tmcostos.id_proveedor=tcproveedores.id_proveedor AND tmcostos.id_usuario=tcusuarios.id_usuario ORDER BY tmcostos.id_costo DESC
",$conexion);
while($fila=mysql_fetch_array($costos)){
	echo "<tr>";
	echo "<td align='center'>".$fila['id_costo']."</td>";
	echo "<td align='center'>".$fila['fecha_alta']."</td>";
	echo "<td align='center'>".$fila['hora_alta']."</td>";
	echo "<td align='center'>".$fila['codigo']."</td>";
	echo "<td>".$fila['nombre']."</td>";
	echo "<td>".$fila['proveedor']."</td>";
	echo "<td>".$fila['usuario']."</td>";
	echo "<td>";
	if ($fila['moneda']=="1") { echo "Peso"; } else { echo "Dólar";};
	echo "</td>";
	echo "<td align='center'>".number_format($fila['valor_pesos'],4,".",",")."</td>";
	echo "<td align='center'>".number_format($fila['valor_dolares'],4,".",",")."</td>";
	echo "<td align='center'>".number_format($fila['tcaplicado'],4,".",",")."</td>";
	echo "<td>".$fila['comentario']."</td>";
	echo "</tr>";
	}
echo "</table>";
echo "</body>";
?>
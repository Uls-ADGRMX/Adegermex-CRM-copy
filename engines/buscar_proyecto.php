<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Valor de la búsqueda ///////////////////////////////
///////////////////////////////////////////////////////
$q = $_POST["q"];
///////////////////////////////////////////////////////
// Valor del ID del Desarrollador /////////////////////
///////////////////////////////////////////////////////
if(empty($_POST["d"])){
$usuario = mysql_query("SELECT id_usuario FROM tcusuarios WHERE nombre LIKE '%".$q."%'", $conexion);
$arrayusu = mysql_fetch_object($usuario);
if (empty($arrayusu->id_usuario)){$u = "°";} else {$u = $arrayusu->id_usuario;}
$cliente = mysql_query("SELECT id_cliente FROM tcclientes WHERE nombre LIKE '%".$q."%'", $conexion);
$arraycli = mysql_fetch_object($cliente);
if (empty($arraycli->id_cliente)){$c = "]";} else {$c = $arraycli->id_cliente;}
$resul_proyecto = mysql_query("
SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.id_cliente, tcclientes.nombre AS cliente
FROM tmproyectos
JOIN tcusuarios
JOIN tcclientes
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND (tmproyectos.nombre_proyecto LIKE '%".$q."%' OR tmproyectos.id_cliente LIKE '%".$c."%' OR tmproyectos.status LIKE '%".$q."%' OR tmproyectos.id_usugenera LIKE '%".$u."%') ORDER BY tmproyectos.id_proyecto DESC LIMIT 30",$conexion);
}
else {
$d = $_POST["d"];
$usuario = mysql_query("SELECT id_usuario FROM tcusuarios WHERE nombre LIKE '%".$q."%'", $conexion);
$arrayusu = mysql_fetch_object($usuario);
if (empty($arrayusu->id_usuario)){$u = "°";} else {$u = $arrayusu->id_usuario;}
$cliente = mysql_query("SELECT id_cliente FROM tcclientes WHERE nombre LIKE '%".$q."%'", $conexion);
$arraycli = mysql_fetch_object($cliente);
if (empty($arraycli->id_cliente)){$c = "]";} else {$c = $arraycli->id_cliente;}
$resul_proyecto = mysql_query("
SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tmproyectos.id_usuasignado, tcusuarios.nombre AS generador, tcclientes.id_cliente, tcclientes.nombre AS cliente
FROM tmproyectos
JOIN tcusuarios
JOIN tcclientes
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.id_usuasignado = ".$d." AND (tmproyectos.nombre_proyecto LIKE '%".$q."%' OR tmproyectos.id_cliente LIKE '%".$c."%' OR tmproyectos.status LIKE '%".$q."%' OR tmproyectos.id_usugenera LIKE '%".$u."%') ORDER BY tmproyectos.id_proyecto DESC LIMIT 30",$conexion);
}
if(mysql_num_rows($resul_proyecto)==0)
	{
		echo '
		<span class="factura-texto3"><strong><center>No hay resultados que mostrar</center></strong></span><br/>
		<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr>
		<td><img src="imagenes/linea-950.png" width="950" height="1" /></td>
		</tr>
		</table><br/><br/><br/>';
	}
else
	{
		echo '
		<span class="factura-texto3"><strong><center>Resultados de la Búsqueda</center></strong></span><br/>
		<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr class="encabezado-tabla">
				<td width="50">Folio</td>
				<td width="375">Nombre del Proyecto</td>
				<td width="250">Cliente / Prospecto</td>
				<td width="145">Status</td>
				<td width="70">Prioridad</td>
				<td width="60" align="center">Detalles</td>
			</tr>';
			while($fila=mysql_fetch_array($resul_proyecto)){
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
		echo "<br/>";
		echo '<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr>
		<td class="subtitulo" align="center">Mostrando resultados: <strong>Máximo 30 registros</strong> | Ordenados por: <strong>Fecha</strong> en <strong>Descendente</strong></td>
		</tr>
		<tr>
		<td><img src="imagenes/linea-950.png" width="950" height="1" /></td>
		</tr>
		</table>';
		echo '<br/><br/><br/>';
	}
?>
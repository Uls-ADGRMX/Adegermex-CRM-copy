<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include ("../scripts/conexion.php");
///////////////////////////////////////////////////////
// Búsqueda de clientes por variable //////////////////
///////////////////////////////////////////////////////
$q = $_POST["q"];
$cliente = "SELECT * FROM tcclientes WHERE nombre LIKE '%".$q."%' ORDER BY id_cliente ASC LIMIT 10";
$resul_cliente = mysql_query($cliente,$conexion);
if(mysql_num_rows($resul_cliente)==0)
	{
		echo "<span class='subtitulo'><center>No hay resultados que mostrar</center></span>";
	}
else
	{
		echo "
		<table width='950' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr class='encabezado-tabla'>
        <td width='600'><img src='imagenes/user.png' width='18' height='18' /> Nombre del Cliente / Prospecto</td>
        <td width='241'><img src='imagenes/calendario.png' width='16' height='16' /> Fecha de Alta</td>
        <td width='93'>Opciones</td>
      </tr>";
		while($fila_cliente=mysql_fetch_array($resul_cliente))
			{
			echo "<tr><td colspan='4'><img src='imagenes/linea-950.png' width='950' height='1'/></td></tr>";
			echo "<tr class='celda-activa'>";
			echo "<td><a href='cliente.php?id=".$fila_cliente['id_cliente']."#contenido' class='link'>".$fila_cliente['nombre']."</a></td>";
			echo "<td>".$fila_cliente['fecha_alta']."  |  ".$fila_cliente['hora_alta']."</td>";
			echo "<td>";
			echo "<table width='70' border='0' cellpadding='0' cellspacing='0'><tr>";
			echo "<td align='center'><a href='cliente.php?id=".$fila_cliente['id_cliente']."#contenido'><img src='imagenes/detalles.png' width='14' height='14' title='Detalles' class='opacidad-accion'></a></td>";
			echo "</tr></table>";
			echo "</td>";
			echo "</tr>";
			}
		echo "</tr></table>";
	}
?>
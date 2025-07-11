<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include ("../scripts/conexion.php");
///////////////////////////////////////////////////////
// Búsqueda de proveedores por variable ///////////////
///////////////////////////////////////////////////////
$q = $_POST["q"];
$proveedor = "SELECT * FROM tcproveedores WHERE nombre LIKE '%".$q."%' ORDER BY id_proveedor ASC LIMIT 10";
$resul_proveedor = mysql_query($proveedor,$conexion);
if(mysql_num_rows($resul_proveedor)==0)
	{
		echo "<span class='subtitulo'><center>No hay resultados que mostrar</center></span>";
	}
else
	{
		echo "
		<table width='950' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr class='encabezado-tabla'>
        <td width='600'>Nombre del Proveedor</td>
        <td width='241'><img src='imagenes/calendario.png' width='16' height='16' /> Fecha de Alta</td>
        <td width='93'>Opciones</td>
      </tr>";
		while($fila_proveedor=mysql_fetch_array($resul_proveedor))
			{
			echo "<tr><td colspan='4'><img src='imagenes/linea-950.png' width='950' height='1'/></td></tr>";
			echo "<tr class='celda-activa'>";
			echo "<td><a href='proveedor.php?id=".$fila_proveedor['id_proveedor']."#contenido' class='link'>".$fila_proveedor['nombre']."</a></td>";
			echo "<td>".$fila_proveedor['fecha_alta']."  |  ".$fila_proveedor['hora_alta']."</td>";
			echo "<td>";
			echo "<table width='70' border='0' cellpadding='0' cellspacing='0'><tr>";
			echo "<td width='35' align='center'><a href='editar_proveedor.php?id=".$fila_proveedor['id_proveedor']."#contenido'><img src='imagenes/editar.png' width='14' height='14' title='Editar' class='opacidad-accion'></a></td>";
			echo "<td width='35' align='center'><a href='proveedor.php?id=".$fila_proveedor['id_proveedor']."#contenido'><img src='imagenes/detalles.png' width='14' height='14' title='Detalles' class='opacidad-accion'></a></td>";
			echo "</tr></table>";
			echo "</td>";
			echo "</tr>";
			}
		echo "</tr></table>";
	}
?>
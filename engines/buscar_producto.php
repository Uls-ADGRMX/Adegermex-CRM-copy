<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include ("../scripts/conexion.php");
///////////////////////////////////////////////////////
// Búsqueda de producto por variable //////////////////
///////////////////////////////////////////////////////
$q = $_POST["q"];
$producto = "SELECT * FROM tmproductos WHERE nombre_producto LIKE '%".$q."%' ORDER BY id_producto ASC LIMIT 10";
$resul_producto = mysql_query($producto,$conexion);
if(mysql_num_rows($resul_producto)==0)
	{
		echo "<span class='subtitulo'><center>No hay resultados que mostrar</center></span>";
	}
else
	{
		echo "
		<table width='950' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr class='encabezado-tabla'>
        <td width='470'><img src='imagenes/descripcion.png' width='18' height='18' /> Nombre del Producto</td>
        <td width='250'>Categoría</td>
        <td width='150'><img src='imagenes/calendario.png' width='16' height='16' /> Fecha de Alta</td>
        <td width='80'>Opciones</td>
      </tr>";
		while($fila_producto=mysql_fetch_array($resul_producto))
			{
			echo "<tr><td colspan='4'><img src='imagenes/linea-950.png' width='950' height='1'/></td></tr>";
			echo "<tr class='celda-activa'>";
			echo "<td><a href='producto.php?id=".$fila_producto['id_producto']."#contenido' class='link'>".$fila_producto['nombre_producto']."</a></td>";
			echo "<td>".$fila_producto['categoria']."</td>";
			echo "<td>".$fila_producto['fecha_alta']."  |  ".$fila_producto['hora_alta']."</td>";
			echo "<td>";
			echo "<table width='70' border='0' cellpadding='0' cellspacing='0'><tr>";
			echo "<td align='center'><a href='producto.php?id=".$fila_producto['id_producto']."#contenido'><img src='imagenes/detalles.png' width='14' height='14' title='Detalles' class='opacidad-accion'></a></td>";
			echo "</tr></table>";
			echo "</td>";
			echo "</tr>";
			}
		echo "</tr></table>";
	}
?>
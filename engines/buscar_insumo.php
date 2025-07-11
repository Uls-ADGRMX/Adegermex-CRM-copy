<?php
include ("../scripts/conexion.php");
$q = $_POST["q"];
$insumo = "
	  SELECT tcinsumos.id_insumo AS id,
	  tcinsumos.codigo,
	  tcinsumos.nombre,
	  tcinsumos.categoria,
	  tcinsumos.tipo,
	  (SELECT tmcostos.valor_pesos FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS costo_pesos,
	  (SELECT tmcostos.valor_dolares FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS costo_dolares,
	  (SELECT tmcostos.moneda FROM tmcostos WHERE tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS moneda,
	  (SELECT tcproveedores.nombre FROM tcproveedores JOIN tmcostos WHERE tmcostos.id_proveedor = tcproveedores.id_proveedor AND tmcostos.id_insumo = id AND (tmcostos.incrementables = '0' OR tmcostos.incrementables = '2') ORDER BY tmcostos.id_costo DESC LIMIT 1) AS proveedor
	  FROM tcinsumos
	  WHERE tcinsumos.codigo LIKE '%".$q."%' OR tcinsumos.nombre LIKE '%".$q."%' OR tcinsumos.categoria LIKE '%".$q."%' OR tcinsumos.tipo LIKE '%".$q."%' ORDER BY id ASC LIMIT 20";
$resul_insumo = mysql_query($insumo,$conexion);
if(mysql_num_rows($resul_insumo)==0)
	{
		echo "<span class='subtitulo'><center>No hay resultados que mostrar</center></span>";
	}
else
	{
		echo "
		<table width='950' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr class='encabezado-tabla'>
			<td width='120'>Código</td>
			<td width='300'>Nombre del Insumo</td>
			<td width='120'><img src='imagenes/mexico-min.png' width='16' height='12' /> Costo</td>
			<td width='120'><img src='imagenes/usa-min.png' width='16' height='12' /> Costo</td>
			<td width='280'>Proveedor</td>
			<td width='90'>Opciones</td>
      </tr>";
		while($fila_insumo=mysql_fetch_array($resul_insumo))
			{
			echo "<tr><td colspan='6'><img src='imagenes/linea-950.png' width='950' height='1'/></td></tr>";
			echo "<tr class='celda-activa'>";
			echo "<td>".$fila_insumo['codigo']."</td>";
			echo "<td><a href='insumo.php?id=".$fila_insumo['id']."#contenido' class='link'>".$fila_insumo['nombre']."</a></td>";
			echo "<td>";
			if ($fila_insumo['costo_pesos']=="0" OR $fila_insumo['costo_pesos']==""){
					echo 'Sin registrar';	
				}
			else {
				echo '<strong>$ '.number_format($fila_insumo['costo_pesos'],4,".",",").'</strong>';
				if ($fila_insumo['moneda']=="1") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';}
				}
			echo "</td>";
			echo "<td>";
			if ($fila_insumo['costo_dolares']=="0" OR $fila_insumo['costo_dolares']==""){
				echo 'Sin registrar';	
				}
			else {
				echo '<strong>$ '.number_format($fila_insumo['costo_dolares'],4,".",",").'</strong>';
				if ($fila_insumo['moneda']=="2") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';}
				}
			echo "</td>";
			echo "<td>";
			if ($fila_insumo['proveedor']=="0" OR $fila_insumo['proveedor']==""){
				echo 'Sin registrar';
			}
			else {
				echo $fila_insumo['proveedor'];
			}
			echo "</td>";
			echo "<td>";
			echo "<table width='70' border='0' cellpadding='0' cellspacing='0'><tr>";
			echo "<td align='center' width='35'><a href='editar_insumo.php?id=".$fila_insumo['id']."#contenido'><img src='imagenes/editar.png' width='14' height='14' title='Editar' class='opacidad-accion'></a></td>";
			echo "<td align='center' width='35'><a href='insumo.php?id=".$fila_insumo['id']."#contenido'><img src='imagenes/detalles.png' width='14' height='14' title='Detalles' class='opacidad-accion'></a></td>";
			echo "</tr></table>";
			echo "</td>";
			echo "</tr>";
			}
		echo "</tr></table>";
	}
?>
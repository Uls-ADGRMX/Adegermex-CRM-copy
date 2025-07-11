<?php
include ("../scripts/conexion.php");
$q = $_POST["q"];
$insumo = "SELECT * FROM tcinsumos WHERE codigo LIKE '%".$q."%' OR nombre LIKE '%".$q."%' ORDER BY id_insumo ASC LIMIT 1";
$resul_insumo = mysql_query($insumo,$conexion);
if(mysql_num_rows($resul_insumo)==0)
	{
		echo "<span class='titulo'>&nbsp;</span><input type='hidden' name='id_insumo' id='id_insumo' value='0'>";
	}
else
	{
		$array = mysql_fetch_object($resul_insumo);
		echo "<span class='titulo'>".$array->nombre."</span><input type='hidden' name='id_insumo' id='id_insumo' value='".$array->id_insumo."'>";
	}
?>
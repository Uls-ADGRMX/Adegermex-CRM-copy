<?php
include '../scripts/conexion.php';
$id = $_GET["id"];
$modificar = mysql_query("UPDATE tmcotizaciones SET status='Eliminada' WHERE id_cotizacion='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Cotizaciones\n\nError al eliminar la cotización")</script>';
			echo "<script language='javascript'>window.location='../cotizaciones.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
	echo '<script language="javascript">alert("Cation : Cotizaciones\n\nLa cotización se eliminó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../cotizacion.php?id=".$id."#contenido'</script>";
	die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
	exit();
mysql_close($conexion);
?>
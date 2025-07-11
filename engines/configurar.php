<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores de la Configuración ////////////
///////////////////////////////////////////////////////
if (isset($_POST['noti1'])){$noti1 = "1";} else {$noti1 = "0";}
if (isset($_POST['noti2'])){$noti2 = "1";} else {$noti2 = "0";}
if (isset($_POST['noti3'])){$noti3 = "1";} else {$noti3 = "0";}
if (isset($_POST['asignar_cliente'])){$asignar_cliente = "1";} else {$asignar_cliente = "0";}
if (isset($_POST['orden_potencial'])){$orden_potencial = "1";} else {$orden_potencial = "0";}
if (isset($_POST['eliminados'])){$eliminados = "1";} else {$eliminados = "0";}
$pbi = $_POST['pbi'];
$pbf = $_POST['pbf'];
$pmi = $_POST['pmi'];
$pmf = $_POST['pmf'];
$pai = $_POST['pai'];
$paf = $_POST['paf'];
if (isset($_POST['recalcular'])){$recalcular = "1";} else {$recalcular = "0";}
///////////////////////////////////////////////////////
// Modificación de Parámetros /////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmconfiguracion SET asignar_cliente='$asignar_cliente', orden_potencial='$orden_potencial', eliminados='$eliminados', pbi='$pbi', pbf='$pbf', pmi='$pmi', pmf='$pmf', pai='$pai', paf='$paf', noti1='$noti1', noti2='$noti2', noti3='$noti3' WHERE id_configuracion='1'", $conexion);
if (!$modificar) {
	echo '<script language="javascript">alert("Cation : Configuración\n\nError al modificar los parámetros de configuración.")</script>';
	echo "<script language='javascript'>window.location='../configuracion.php#contenido'</script>";
	die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
	exit();
}
else {
	echo '<script language="javascript">alert("Cation : Configuración\n\nSe modificaron los parámetros correctamente.")</script>';
	}
///////////////////////////////////////////////////////
// Recalculo de Potencial de Negocio //////////////////
///////////////////////////////////////////////////////
if($recalcular==1)
{
	$proyectos=mysql_query("
	SELECT tmproyectos.id_proyecto, tmproyectos.status, tmproyectos.potencial, tmrequisitos.id_requisito, tmrequisitos.vanual_num
	FROM tmproyectos
	JOIN tmrequisitos
	WHERE tmproyectos.id_proyecto = tmrequisitos.id_proyecto AND tmproyectos.status<>'Eliminado' AND tmproyectos.status<>'Finalizado'",$conexion);
		while($fila=mysql_fetch_array($proyectos)){
			$id_proyecto = $fila['id_proyecto'];
			$vanual_num = $fila['vanual_num'];
			if ($vanual_num>=$pbi && $vanual_num<=$pbf) { $potencial="3"; }
			if ($vanual_num>=$pmi && $vanual_num<=$pmf) { $potencial="2"; }
			if ($vanual_num>=$pai && $vanual_num<$paf) { $potencial="1"; }
			if ($vanual_num>=$paf) { $potencial="1"; }
			$actualizar = mysql_query("UPDATE tmproyectos SET potencial='$potencial' WHERE id_proyecto='$id_proyecto'", $conexion);
			if (!$actualizar) {
				echo '<script language="javascript">alert("Cation : Configuración\n\nError actualizar el potencial de negocio.")</script>';
				echo "<script language='javascript'>window.location='../configuracion.php#contenido'</script>";
				die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
				exit();
				}
				else{
					}
		}
	echo '<script language="javascript">alert("Cation : Configuración\n\nEl recalculo se completó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../configuracion.php#contenido'</script>";
	die();
	exit();
}
else
{
	echo "<script language='javascript'>window.location='../configuracion.php#contenido'</script>";	
	die();
	exit();
}
mysql_close($conexion);
?>
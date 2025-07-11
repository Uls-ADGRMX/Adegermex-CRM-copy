<?php
include '../scripts/conexion.php';
$id = $_GET["id"];
$id_proyecto = $_GET["idp"];
// Eliminar Fórmula
$modificar = mysql_query("UPDATE tmformulas SET status='Eliminada' WHERE id_formula='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError al eliminar la fórmula")</script>';
			echo "<script language='javascript'>window.location='../formulas.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Mensaje de Confirmación
if ($id_proyecto=="0"){
	echo '<script language="javascript">alert("Cation : Fórmulas\n\nLa fórmula se eliminó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../formula.php?id=".$id."#contenido'</script>";
	die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
	exit();
}
else {
	echo '<script language="javascript">alert("Cation : Fórmulas\n\nLa fórmula se eliminó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#formulaciones'</script>";
	die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
	exit();
}
mysql_close($conexion);
?>
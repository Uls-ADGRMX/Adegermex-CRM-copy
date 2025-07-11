<?php
include '../scripts/conexion.php';
$id = $_GET["id"];
$tipo = $_GET["tipo"];
$tipo_formula = mysql_query("UPDATE tmformulas SET master='$tipo' WHERE id_formula='$id'", $conexion);
		if (!$tipo_formula) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError al cambiar el tipo de Fórmula")</script>';
			echo "<script language='javascript'>window.location='../formula.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else{
	echo '<script language="javascript">alert("Cation : Fórmulas\n\nSe cambio el tipo de fórmula correctamente")</script>';
	echo "<script language='javascript'>window.location='../formula.php?id=".$id."#contenido'</script>";
	die();
}
	mysql_close($conexion);
?>
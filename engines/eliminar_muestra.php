<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores de la Muestra //////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$idp = $_GET["idp"];
///////////////////////////////////////////////////////
// Eliminar registro de Muestra ///////////////////////
///////////////////////////////////////////////////////
$eliminar = mysql_query("DELETE FROM tmmuestras WHERE id_muestra='$id'", $conexion);
	if (!$eliminar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al eliminar registro de muestra.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$idp."#entregadas'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nSe eliminó correctamente el registro de muestra.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$idp."#entregadas'</script>";
		}
	mysql_close($conexion);
?>
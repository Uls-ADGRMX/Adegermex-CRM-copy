<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Tipo de Cambio /////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
///////////////////////////////////////////////////////
// Eliminar registro de Tipo de Cambio ////////////////
///////////////////////////////////////////////////////
$eliminar = mysql_query("DELETE FROM tctcambio WHERE id_tcambio='$id'", $conexion);
		if (!$eliminar) {
			echo '<script language="javascript">alert("Cation : Tipo de Cambio\n\nError al eliminar registro de tipo de cambio.")</script>';
			echo "<script language='javascript'>window.location='../tipo_cambio.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
			echo '<script language="javascript">alert("Cation : Tipo de Cambio\n\nSe eliminó correctamente el registro de tipo de cambio.")</script>';
			echo "<script language='javascript'>window.location='../tipo_cambio.php#contenido'</script>";
mysql_close($conexion);
?>
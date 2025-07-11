<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Contacto ///////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$idc = $_GET["idc"];
///////////////////////////////////////////////////////
// Eliminar registro de Contacto //////////////////////
///////////////////////////////////////////////////////
$eliminar = mysql_query("DELETE FROM tmcontactos WHERE id_contacto='$id'", $conexion);
	if (!$eliminar) {
		echo '<script language="javascript">alert("Cation : Clientes\n\nError al eliminar el contacto.")</script>';
		echo "<script language='javascript'>window.location='../cliente.php?id=".$idc."#contactos'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		echo '<script language="javascript">alert("Cation : Clientes\n\nSe eliminó correctamente el contacto.")</script>';
		echo "<script language='javascript'>window.location='../cliente.php?id=".$idc."#contactos'</script>";
		}
	mysql_close($conexion);
?>
<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores de la Imagen ///////////////////
///////////////////////////////////////////////////////
$id_imagen = $_GET["id_imagen"];
$imagen = "SELECT id_producto FROM tcimagenes WHERE id_imagen='$id_imagen'";
$datos=mysql_query($imagen, $conexion) or die(mysql_error());
$arrayimagen = mysql_fetch_object($datos);
$id_producto = $arrayimagen->id_producto;
///////////////////////////////////////////////////////
// Eliminar registro de la Imagen /////////////////////
///////////////////////////////////////////////////////
$eliminar = mysql_query("DELETE FROM tcimagenes WHERE id_imagen='$id_imagen'", $conexion);
	if (!$eliminar) {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError al eliminar la imagen.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nSe eliminó la imagen correctamente.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		}
	mysql_close($conexion);
?>
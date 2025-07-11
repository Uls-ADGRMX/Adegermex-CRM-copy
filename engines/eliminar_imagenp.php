<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores de la Imagen ///////////////////
///////////////////////////////////////////////////////
$id_producto = $_GET["id_producto"];
///////////////////////////////////////////////////////
// Eliminar registro de la Imagen /////////////////////
///////////////////////////////////////////////////////
$eliminar = mysql_query("UPDATE tmproductos SET nombre_imagen='0', peso_imagen='0', tipo_imagen='0' WHERE id_producto='$id_producto'", $conexion);
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
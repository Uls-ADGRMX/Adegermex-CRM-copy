<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Proveedor //////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$nombre = strtoupper($_POST['nombre']);
///////////////////////////////////////////////////////
// Modificación de Proveedor //////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tcproveedores SET nombre='$nombre' WHERE id_proveedor='$id'", $conexion);
if (!$modificar) {
	echo '<script language="javascript">alert("Cation : Proveedores\n\nError al modificar los datos del proveedor.")</script>';
	echo "<script language='javascript'>window.location='../proveedores.php#contenido'</script>";
	die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
	exit();
}
else {
	echo '<script language="javascript">alert("Cation : Proveedores\n\nSe modificó el proveedor correctamente.")</script>';
	echo "<script language='javascript'>window.location='../proveedores.php#contenido'</script>";
	die();
	}
mysql_close($conexion);
?>
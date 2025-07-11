<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// Variables y valores del Proveedor //////////////////
///////////////////////////////////////////////////////
$nombre = strtoupper($_POST['nombre']);
///////////////////////////////////////////////////////
// Validación de Proveedor existente //////////////////
///////////////////////////////////////////////////////
$proveedor = mysql_query("SELECT * FROM tcproveedores WHERE nombre='$nombre'",$conexion) or die(mysql_error());
if (mysql_num_rows($proveedor)==0) {
	$insertar = mysql_query("INSERT INTO tcproveedores (nombre, fecha_alta, hora_alta) VALUES ('{$nombre}', '{$fecha}', '{$hora}')", $conexion);
	if (!$insertar) {
		echo '<script language="javascript">alert("Cation : Proveedores\n\nError al agregar el proveedor al sistema.")</script>';
		echo "<script language='javascript'>window.location='../proveedores.php#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
		echo '<script language="javascript">alert("Cation : Proveedores\n\nEl proveedor se generó correctamente.")</script>';
		echo "<script language='javascript'>window.location='../proveedores.php#contenido'</script>";
	}
	else {
		echo '<script language="javascript">alert("Cation : Proveedores\n\nEl proveedor que intenta agregar ya existe.\n\nVerifique los datos e ingrese un nombre de proveedor distinto.")</script>';
		echo "<script language='javascript'>window.location='../proveedores.php#contenido'</script>";
		die();
		}
mysql_close($conexion);
?>
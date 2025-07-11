<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Usuario ////////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
///////////////////////////////////////////////////////
// Modificación de Usuario ////////////////////////////
///////////////////////////////////////////////////////
$desactivar = mysql_query("UPDATE tcusuarios SET status='Inactivo' WHERE id_usuario='$id'", $conexion);
		if (!$desactivar) {
			echo '<script language="javascript">alert("Cation : Usuarios\n\nError al desactivar el usuario.")</script>';
			echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else{
	echo '<script language="javascript">alert("Cation : Usuarios\n\nEl usuario se desactivó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
	die();
}
mysql_close($conexion);
?>
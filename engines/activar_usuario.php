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
$activar = mysql_query("UPDATE tcusuarios SET status='Activo' WHERE id_usuario='$id'", $conexion);
		if (!$activar) {
			echo '<script language="javascript">alert("Cation : Usuarios\n\nError al activar el usuario.")</script>';
			echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else{
	echo '<script language="javascript">alert("Cation : Usuarios\n\nEl usuario se activó correctamente.")</script>';
	echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
	die();
}
mysql_close($conexion);
?>
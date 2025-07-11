<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Usuario ////////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$nombre = $_POST['nombre'];
$departamento = $_POST['departamento'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$correo = $_POST['correo'];
$tipo_usuario = $_POST['tipo_usuario'];
if (isset($_POST['autoriza']))
	{
	$autoriza = "1";
	}
	else {
	$autoriza = "0";
	}
if (isset($_POST['asigna']))
	{
	$asigna = "1";
	}
	else {
	$asigna = "0";
	}
$usuario = strtolower($usuario);
$password = strtolower($password);
$correo = strtolower($correo);
///////////////////////////////////////////////////////
// Modificación de Usuario ////////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tcusuarios SET nombre='$nombre', usuario='$usuario', password='$password', tipo_usuario='$tipo_usuario', departamento='$departamento', correo='$correo', autoriza='$autoriza', asigna='$asigna' WHERE id_usuario='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Usuarios\n\nError al modificar los datos del usuario.")</script>';
			echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else{
	echo '<script language="javascript">alert("Cation : Usuarios\n\nSe modificó el usuario correctamente.")</script>';
	echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
	die();
}
mysql_close($conexion);
?>
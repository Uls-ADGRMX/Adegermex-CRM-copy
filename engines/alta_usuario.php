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
// Variables y valores del Usuario ////////////////////
///////////////////////////////////////////////////////
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
// Validación de Usuario existente ////////////////////
///////////////////////////////////////////////////////
$operador = mysql_query("SELECT * FROM tcusuarios WHERE usuario='$usuario'",$conexion) or die(mysql_error());
if (mysql_num_rows($operador)==0)
{
$insertar = mysql_query("INSERT INTO tcusuarios (nombre, usuario, password, tipo_usuario, departamento, correo, fecha_alta, hora_alta, status, autoriza, asigna)
						VALUES ('{$nombre}', '{$usuario}', '{$password}', '{$tipo_usuario}', '{$departamento}', '{$correo}', '{$fecha}','{$hora}', 'Activo', '{$autoriza}', '{$asigna}')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Usuarios\n\nError al agregar el usuario al sistema.")</script>';
			echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
			echo '<script language="javascript">alert("Cation : Usuarios\n\nEl usuario se generó correctamente.")</script>';
			echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
}
else {
	echo '<script language="javascript">alert("Cation : Usuarios\n\nEl usuario que intenta agregar ya existe.\n\nVerifique los datos e ingrese un nombre de usuario distinto.")</script>';
	echo "<script language='javascript'>window.location='../usuarios.php#contenido'</script>";
	die();
}
mysql_close($conexion);
?>
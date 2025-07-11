<?php
// Inicio de Sesión
session_start();
// Si la sesión no se ha iniciado redireccionamos
if(empty($_SESSION['id_usuario'])){
	header('Location: ../index.php');
}
// Inlcluimos la conexión a la Base de Datos
include '../scripts/conexion.php';
// Datos del Usuario
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
///////////////////////////////////////////////////////
// ID del Proyecto ////////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
// Establece Zona Horaria Predeterminada
date_default_timezone_set('America/Mexico_City');
// Asigna valores a las Variables de Fecha/Hora
$fecha=date("Y-m-d");
$hora=date("H:i:s");
// Verificación de Usuario Existente
$modificar = mysql_query("UPDATE tmproyectos SET status='Muestra Entregada' WHERE id_proyecto='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al cambiar status del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}			
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "Se realiza la <strong>Entrega de Muestras</strong> solicitadas al área de Ventas, por parte del desarrollador ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Mensaje de confirmación y redirección de la página
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe reportó la entrega de muestras correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id#contenido'</script>";

	// Cierre de la Conexion con la Base de Datos
	mysql_close($conexion);
?>
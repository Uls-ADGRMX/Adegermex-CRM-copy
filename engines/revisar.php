<?php
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: ../index.php');
}
include '../scripts/conexion.php';
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
$id = $_GET['id'];
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$modificar = mysql_query("UPDATE tmproyectos SET status='Revisado' WHERE id_proyecto='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al cambiar status del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php?id=".$id."'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
$evento = "El proyecto fue <strong>Revisado</strong> por ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php?id=".$id."'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
echo '<script language="javascript">alert("Cation : Proyectos\n\nEl proyecto se envió a revisión correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
mysql_close($conexion);
?>
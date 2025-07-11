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
// Variables y valores de la asignación ///////////////
///////////////////////////////////////////////////////
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
$desarrollador = $_POST['desarrollador'];
///////////////////////////////////////////////////////
// Actualizar asignación //////////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmproyectos SET id_usuasignado2='$desarrollador' WHERE id_proyecto='$id_proyecto'", $conexion);
	if (!$modificar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al asignar el Proyecto")</script>';
		echo "<script language='javascript'>window.location='../proyectos.php'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
	}			
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
if ($desarrollador=="0")
{
$evento = "Se eliminó la asignación del desarrollador de apoyo por el administrador ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento) VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
	if (!$insertar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
		echo "<script language='javascript'>window.location='../proyectos.php'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe eliminó la asignación de apoyo correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";
}
else {
$usuasignado2 = "SELECT * FROM tcusuarios WHERE id_usuario=$desarrollador";
$datos=mysql_query($usuasignado2, $conexion) or die(mysql_error());
$arrayasignado2 = mysql_fetch_object($datos);
$evento = "Se asignó a <strong>".$arrayasignado2->nombre."</strong> como desarrollador de apoyo por el administrador ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento) VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
	if (!$insertar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
		echo "<script language='javascript'>window.location='../proyectos.php'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe asignó el proyecto correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";
}
mysql_close($conexion);
?>
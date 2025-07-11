<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Zona Horaria predeterminada ////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// Información del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
if(empty($_POST['nombre_proyecto']))
{
	$nombre_proyecto = "Proyecto Sin Nombre Definido";
}
else {
	$nombre_proyecto = $_POST['nombre_proyecto'];
	$nombre_proyecto = ucfirst($nombre_proyecto);
}
$fecha_requerida = $_POST['fecha_requerida'];
if (empty($_POST['descripcion']))
{
	$descripcion = "Sin Descripción Definida";	
}
else {
	$descripcion = $_POST['descripcion'];
	$descripcion = ucfirst($descripcion);
}
///////////////////////////////////////////////////////
// Modificar Clasificadores del Proyecto //////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmproyectos SET nombre_proyecto='$nombre_proyecto', fecha_requerida='$fecha_requerida', descripcion='$descripcion' WHERE id_proyecto='$id_proyecto'", $conexion);
	if (!$modificar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al modificar las generalidades del proyecto.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "Las <strong>Generalidades del Proyecto</strong> fueron modificados por";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////	
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe modificaron las generalidades del proyecto correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
mysql_close($conexion);
?>
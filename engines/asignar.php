<?php
include '../scripts/conexion.php'; 
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
$desarrollador = $_POST['desarrollador'];
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$modificar = mysql_query("UPDATE tmproyectos SET id_usuasignador='$id_usuario', id_usuasignado='$desarrollador' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al asignar el Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}			
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$usuasignado = "SELECT * FROM tcusuarios WHERE id_usuario=$desarrollador";
$datos=mysql_query($usuasignado, $conexion) or die(mysql_error());
$arrayasignado = mysql_fetch_object($datos);

$evento = "El proyecto fue asignado a <strong>".$arrayasignado->nombre."</strong> por el administrador ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Cambiar Status
$modificar = mysql_query("UPDATE tmproyectos SET status='Generado / Asignado' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al cambiar status del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Actualizar Fecha
$modificar = mysql_query("UPDATE tmproyectos SET fecha_asignacion='$fecha', hora_asignacion='$hora' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al actualizar fecha de asignación del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Mensaje de confirmación y redirección de la página
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe asignó el proyecto correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";

	// Cierre de la Conexion con la Base de Datos
	mysql_close($conexion);
?>
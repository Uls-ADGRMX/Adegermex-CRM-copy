<?php
// Conexión a la Base de Datos
include '../scripts/conexion.php'; 
// Valores de Formulario mediante POST e ID del Campo
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
// Establece Zona Horaria Predeterminada
date_default_timezone_set('America/Mexico_City');
// Asigna valores a las Variables de Fecha/Hora
$fecha=date("Y-m-d");
$hora=date("H:i:s");
// Verificación de Usuario Existente
$modificar = mysql_query("UPDATE tmproyectos SET status='Eliminado' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al eliminar el Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "El proyecto fue eliminado por ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
			// Mensaje de confirmación y redirección de la página
			echo '<script language="javascript">alert("Cation : Proyectos\n\nEl proyecto fue eliminado correctamente.")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";
	// Cierre de la Conexion con la Base de Datos
	mysql_close($conexion);
?>
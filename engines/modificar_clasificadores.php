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
$tipo = $_POST['tipo'];
$categoria = $_POST['categoria'];
$segmento = $_POST['segmento'];
///////////////////////////////////////////////////////
// Modificar Clasificadores del Proyecto //////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmproyectos SET tipo='$tipo', categoria='$categoria', segmento='$segmento' WHERE id_proyecto='$id_proyecto'", $conexion);
	if (!$modificar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al modificar los clasificadores del proyecto.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "Los <strong>Clasificadores del Proyecto</strong> fueron modificados por";
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
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe modificaron los clasificadores del proyecto correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
mysql_close($conexion);
?>
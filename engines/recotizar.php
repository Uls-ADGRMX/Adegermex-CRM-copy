<?php
include '../scripts/conexion.php';
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
$comentarios = $_POST['comentarios'];
$comentarios = ucfirst($comentarios);
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$modificar = mysql_query("UPDATE tmproyectos SET status='Recotizar' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al cambiar status del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}			
$evento = "Se solicitó la <strong>Recotización</strong> del proyecto por el Cliente, lo indicó ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('{$id_proyecto}','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','{$evento}')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
$comentario = "<strong>Comentario de la Recotización</strong>: ".$comentarios;
$comentar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('{$id_proyecto}', '{$id_usuario}', 'Comentario', '{$fecha}','{$hora}', '{$comentario}')", $conexion);
		if (!$comentar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Comentario")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe solicitó la recotización correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";
mysql_close($conexion);
?>
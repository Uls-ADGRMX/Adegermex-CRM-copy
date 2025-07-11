<?php
// Conexión a la Base de Datos
include '../scripts/conexion.php'; 
// Valores de Formulario mediante POST e ID del Campo
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
$fecha_compromiso = $_POST['fecha_compromiso'];
// Establece Zona Horaria Predeterminada
date_default_timezone_set('America/Mexico_City');
// Asigna valores a las Variables de Fecha/Hora
$fecha=date("Y-m-d");
$hora=date("H:i:s");
// Verificación de Usuario Existente
$modificar = mysql_query("UPDATE tmproyectos SET fecha_compromiso='$fecha_compromiso' WHERE id_proyecto='$id_proyecto'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al establecer la fecha compromiso del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}			
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$fcom = "SELECT * FROM tmproyectos WHERE id_proyecto=$id_proyecto";
$dfcom=mysql_query($fcom, $conexion) or die(mysql_error());
$arrayfcom = mysql_fetch_object($dfcom);

$evento = "La <strong>Fecha Compromiso</strong> del proyecto se indicó para el día <strong>".$arrayfcom->fecha_compromiso."</strong> por ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
// Mensaje de confirmación y redirección de la página
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe estableció la fecha compromiso correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#contenido'</script>";

	// Cierre de la Conexion con la Base de Datos
	mysql_close($conexion);
?>
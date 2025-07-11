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
// Insertar muestras de línea /////////////////////////
///////////////////////////////////////////////////////
$id_proyecto = $_POST['id_proyecto'];
$id_usuario = $_POST['id_usuario'];
for ($a=1; $a<=15; $a++){
	if (empty($_POST['codigo'.$a.'']) OR empty($_POST['nombre_muestra'.$a.'']) OR empty($_POST['cantidad'.$a.'']) OR empty($_POST['unidadn'.$a.'']))
	{
	}
	else
	{
		$codigo = strtoupper($_POST['codigo'.$a.'']);
		$nombre_muestra = strtoupper($_POST['nombre_muestra'.$a.'']);
		$cantidad = $_POST['cantidad'.$a.''];
		$unidadn = $_POST['unidadn'.$a.''];
		$unidad = $_POST['unidad'.$a.''];
		$muestra = mysql_query("INSERT INTO tmmuestras (id_proyecto, id_usuario, fecha_alta, hora_alta, codigo, nombre_muestra, cantidad, unidadn, unidad, origen)
			VALUES ('{$id_proyecto}','{$id_usuario}','{$fecha}','{$hora}','{$codigo}','{$nombre_muestra}','{$cantidad}','{$unidadn}','{$unidad}', 'E')", $conexion);
		if (!$muestra) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción de Muestras")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		}
	}
}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "Se registran las <strong>Muestras Entregadas</strong> del proyecto por el desarrollador";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_proyecto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe registraron correctamente las muestras entregadas.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=$id_proyecto#entregadas'</script>";
mysql_close($conexion);
?>
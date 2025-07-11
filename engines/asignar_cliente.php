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
// Variables y valores del Cliente ////////////////////
///////////////////////////////////////////////////////
$id_cliente = $_POST['id_cliente'];
$id_usuario = $_POST['id_usuario'];
$agente = $_POST['agente'];
///////////////////////////////////////////////////////
// Asignación del Cliente /////////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tcclientes SET id_asignado='$agente' WHERE id_cliente='$id_cliente'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al asignar el Cliente")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Asignación de Proyectos ////////////////////////////
///////////////////////////////////////////////////////
$proyectos = mysql_query("UPDATE tmproyectos SET id_usugenera='$agente' WHERE status<>'Finalizado' AND status<>'Eliminado' AND id_cliente=$id_cliente", $conexion);
		if (!$proyectos) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al asignar los Proyectos")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$usuasignado = "SELECT * FROM tcusuarios WHERE id_usuario=$agente";
$datos=mysql_query($usuasignado, $conexion) or die(mysql_error());
$arrayasignado = mysql_fetch_object($datos);
$evento = "El cliente fue asignado a <strong>".$arrayasignado->nombre."</strong> por el usuario ";
$insertar = mysql_query("INSERT INTO tmeventos (id_cliente, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_cliente','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
echo '<script language="javascript">alert("Cation : Clientes\n\nSe asignó el cliente correctamente.")</script>';
echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contenido'</script>";
mysql_close($conexion);
?>
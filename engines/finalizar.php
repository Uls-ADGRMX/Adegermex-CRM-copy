<?php
///////////////////////////////////////////////////////
// Inicio de Sesión ///////////////////////////////////
///////////////////////////////////////////////////////
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Datos del Usuario //////////////////////////////////
///////////////////////////////////////////////////////
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
///////////////////////////////////////////////////////
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// Variables y valores del Proyecto ///////////////////
///////////////////////////////////////////////////////
$id = $_POST['id_proyecto'];
$cierre_venta = $_POST['cierre_venta'];
///////////////////////////////////////////////////////
// Variables y valores del Cliente ////////////////////
///////////////////////////////////////////////////////
$cliente = "SELECT tcclientes.tipo, tcclientes.id_cliente FROM tcclientes JOIN tmproyectos WHERE tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.id_proyecto = '$id'";
$datos=mysql_query($cliente, $conexion) or die(mysql_error());
$arraycliente = mysql_fetch_object($datos);
$id_cliente = $arraycliente->id_cliente;
$tipo_cliente = $arraycliente->tipo;
if($cierre_venta=="1" AND $tipo_cliente=="Prospecto")
{
	$new_win = "1";	
}
else {
	$new_win = "0";
}
///////////////////////////////////////////////////////
// Actualizar información del Proyecto ////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmproyectos SET status='Finalizado', fecha_termino='$fecha', hora_termino='$hora', cierre_venta='$cierre_venta', new_win='$new_win' WHERE id_proyecto='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError al cambiar status del Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Insertar Evento del Proyecto ///////////////////////
///////////////////////////////////////////////////////
$evento = "El proyecto de desarrollo es <strong>Finalizado</strong> por ";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Actualizar información del Cliente /////////////////
///////////////////////////////////////////////////////
if ($cierre_venta=="1" AND $tipo_cliente=="Prospecto")
{
	$modificar = mysql_query("UPDATE tcclientes SET tipo='Cliente' WHERE id_cliente='$id_cliente'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al actualizar el tipo de Cliente")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Insertar Evento del Cliente ////////////////////////
///////////////////////////////////////////////////////
$evento = "El <strong>Prospecto</strong> fue convertido en <strong>Cliente</strong> por la venta del proyecto con folio <strong>".$id."</strong> del agente de ventas ";
$insertar = mysql_query("INSERT INTO tmeventos (id_cliente, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_cliente','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		}
echo '<script language="javascript">alert("Cation : Proyectos\n\nEl proyecto finalizó correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=".$id."#contenido'</script>";
mysql_close($conexion);
?>
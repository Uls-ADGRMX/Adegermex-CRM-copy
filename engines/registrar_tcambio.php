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
// Variables y valores del Tipo de Cambio /////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
if(empty($_POST['valor']))
{
	$valor = "1";
	$valor = number_format($valor,4,".",",");
}
else {
	$valor = $_POST['valor'];
	$valor = number_format($valor,4,".",",");
}
///////////////////////////////////////////////////////
// Insertar Tipo de Cambio ////////////////////////////
///////////////////////////////////////////////////////
$tcambio = mysql_query("INSERT INTO tctcambio (id_usuario, valor, fecha_alta, hora_alta)
						VALUES ('{$id_usuario}','{$valor}', '{$fecha}', '{$hora}')", $conexion);
		if (!$tcambio) {
			echo '<script language="javascript">alert("Cation : Tipo de Cambio\n\nError al registrar el tipo de cambio.")</script>';
			echo "<script language='javascript'>window.location='../tipo_cambio.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
			echo '<script language="javascript">alert("Cation : Tipo de Cambio\n\nSe registró correctamente el tipo de cambio.")</script>';
			echo "<script language='javascript'>window.location='../tipo_cambio.php#contenido'</script>";
mysql_close($conexion);
?>
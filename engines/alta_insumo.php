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
// Variables y valores del Insumo /////////////////////
///////////////////////////////////////////////////////
$codigo = strtoupper($_POST['codigo']);
$nombre = strtoupper($_POST['nombre']);
if(empty($_POST['codigo_proveedor'])){ $codigo_proveedor = "No Definido"; } else { $codigo_proveedor = strtoupper($_POST['codigo_proveedor']); }
$unidad_medida = $_POST['unidad_medida'];
$categoria = $_POST['categoria'];
$origen = $_POST['origen'];
$tipo = $_POST['tipo'];
if(empty($_POST['comentario'])){ $comentario = "No Definido"; } else { $comentario = ucfirst($_POST['comentario']); }
///////////////////////////////////////////////////////
// Generar alta de Insumo /////////////////////////////
///////////////////////////////////////////////////////
$insumo = mysql_query("SELECT * FROM tcinsumos WHERE codigo='$codigo'",$conexion) or die(mysql_error());
if (mysql_num_rows($insumo)==0)
	{
		$insertar = mysql_query("INSERT INTO tcinsumos (codigo, nombre, fecha_alta, hora_alta, codigo_proveedor, unidad_medida, categoria, origen, tipo, comentario) VALUES ('{$codigo}', '{$nombre}', '{$fecha}', '{$hora}', '{$codigo_proveedor}', '{$unidad_medida}', '{$categoria}', '{$origen}', '{$tipo}', '{$comentario}')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Insumos\n\nError de inserción en la Base de Datos")</script>';
			echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
		}
		echo '<script language="javascript">alert("Cation : Insumos\n\nEl insumo se generó correctamente.")</script>';
		echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
	}
		else {
			echo '<script language="javascript">alert("Cation : Insumos\n\nEl código del insumo ingresado ya existe.\n\nVerifique los datos e inténtelo nuevamente.")</script>';
			echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
			die();
			}
mysql_close($conexion);
?>
<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Insumo /////////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$nombre = strtoupper($_POST['nombre']);
if(empty($_POST['codigo_proveedor'])){
	$codigo_proveedor = "No Definido";
	}
	else {
		$codigo_proveedor = strtoupper($_POST['codigo_proveedor']);
		}
$unidad_medida = $_POST['unidad_medida'];
$categoria = $_POST['categoria'];
$origen = $_POST['origen'];
$tipo = $_POST['tipo'];
if(empty($_POST['comentario'])){
	$comentario = "No Definido";
	}
	else {
		$comentario = ucfirst($_POST['comentario']);
		}
///////////////////////////////////////////////////////
// Modificar Insumo ///////////////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tcinsumos SET nombre='$nombre', codigo_proveedor='$codigo_proveedor', unidad_medida='$unidad_medida', categoria='$categoria', origen='$origen', tipo='$tipo', comentario='$comentario' WHERE id_insumo='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Insumos\n\nError al modificar los datos del insumo.")</script>';
			echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else{
	echo '<script language="javascript">alert("Cation : Insumos\n\nSe modificó el insumo correctamente.")</script>';
	echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
	die();
}
	mysql_close($conexion);
?>
<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Variables y valores del Insumo /////////////////////
///////////////////////////////////////////////////////
$id_insumo = $_POST["id_insumo"];
$codigo_actual = $_POST["codigo_actual"];
if(empty($_POST['codigo_nuevo']) OR $codigo_nuevo==" ")
	{
		echo '<script language="javascript">alert("Cation : Insumos\n\nEl código del insumo ingresado es incorrecto.")</script>';
		echo "<script language='javascript'>window.location='../cambiar_codigo.php?id=".$id_insumo."#contenido'</script>";
		die();
	}
	else {
		$codigo_nuevo = strtoupper($_POST["codigo_nuevo"]);
	}
///////////////////////////////////////////////////////
// Validación de código existente /////////////////////
///////////////////////////////////////////////////////
$existe = mysql_query("SELECT * FROM tcinsumos WHERE codigo='$codigo_nuevo'",$conexion) or die(mysql_error());
if (mysql_num_rows($existe)==0)
	{
		$cambiar = mysql_query("UPDATE tcinsumos SET codigo='$codigo_nuevo' WHERE id_insumo='$id_insumo'", $conexion);
		if (!$cambiar) {
				echo '<script language="javascript">alert("Cation : Insumos\n\nError al modificar el código del insumo.")</script>';
				echo "<script language='javascript'>window.location='../insumos.php#contenido'</script>";
				die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
				exit();
				}
				else {
					echo '<script language="javascript">alert("Cation : Insumos\n\nSe modificó el código del insumo correctamente.")</script>';
					echo "<script language='javascript'>window.location='../insumo.php?id=".$id_insumo."#contenido'</script>";
					die();
				}
	}
	else {
		echo '<script language="javascript">alert("Cation : Insumos\n\nEl código del insumo ingresado ya existe.\n\nVerifique los datos e inténtelo nuevamente.")</script>';
		echo "<script language='javascript'>window.location='../cambiar_codigo.php?id=".$id_insumo."#contenido'</script>";
		die();
	}
mysql_close($conexion);
?>
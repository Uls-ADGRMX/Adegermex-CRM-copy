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
///////////////////////////////////////////////////////
// Consulta para información de Parámetros ////////////
///////////////////////////////////////////////////////
$configuracion = "SELECT * FROM tmconfiguracion WHERE id_configuracion='1'";
$info=mysql_query($configuracion, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$pbi = $infoarray->pbi;
$pbf = $infoarray->pbf;
$pmi = $infoarray->pmi;
$pmf = $infoarray->pmf;
$pai = $infoarray->pai;
$paf = $infoarray->paf;
///////////////////////////////////////////////////////
// Información de Negocio /////////////////////////////
///////////////////////////////////////////////////////
$vanual_mon = "Dolares";
if(empty($_POST['vmensual_num'])){ $vmensual_num = "0"; } else { $vmensual_num = $_POST['vmensual_num']; }
$vmensual_uni = $_POST['vmensual_uni'];
if(empty($_POST['ptarget_num'])){ $ptarget_num = "0"; } else { $ptarget_num = $_POST['ptarget_num']; }
$ptarget_mon = $_POST['ptarget_mon'];
if(empty($_POST['caplic_num'])){ $caplic_num = "0"; } else { $caplic_num = $_POST['caplic_num']; }
$caplic_mon = $_POST['caplic_mon'];
$vanual_num = ($vmensual_num * $ptarget_num) * 12;
if ($vanual_num>=$pbi && $vanual_num<=$pbf) { $potencial="3"; }
if ($vanual_num>=$pmi && $vanual_num<=$pmf) { $potencial="2"; }
if ($vanual_num>=$pai && $vanual_num<$paf) { $potencial="1"; }
if ($vanual_num>=$paf) { $potencial="1"; }
///////////////////////////////////////////////////////
// Modificar Información de Negocio ///////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmrequisitos SET vanual_num='$vanual_num', vanual_mon='$vanual_mon', vmensual_num='$vmensual_num', vmensual_uni='$vmensual_uni', ptarget_num='$ptarget_num', ptarget_mon='$ptarget_mon', caplic_num='$caplic_num', caplic_mon='$caplic_mon' WHERE id_proyecto='$id_proyecto'", $conexion);
	if (!$modificar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al modificar la información de negocio.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		}
///////////////////////////////////////////////////////
// Modificar Potencial de Proyecto ////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmproyectos SET potencial='$potencial' WHERE id_proyecto='$id_proyecto'", $conexion);
	if (!$modificar) {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nError al modificar el potencial del proyecto.")</script>';
		echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "La <strong>Información de Negocio</strong> fue modificada por";
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
echo '<script language="javascript">alert("Cation : Proyectos\n\nSe modificó la información de negocio correctamente.")</script>';
echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#contenido'</script>";
mysql_close($conexion);
?>
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
// Variables y valores del Proyecto ///////////////////
///////////////////////////////////////////////////////
$id_usugenera = $_POST['id_usugenera'];
$id_usugeneraori = $_POST['id_usugenera'];
if(empty($_POST['nombre_proyecto']))
{
	$nombre_proyecto = "Proyecto Sin Nombre Definido";
}
else {
	$nombre_proyecto = $_POST['nombre_proyecto'];
	$nombre_proyecto = ucfirst($nombre_proyecto);
}
$id_cliente = $_POST['id_cliente'];
$fecha_requerida = $_POST['fecha_requerida'];
if (empty($_POST['descripcion']))
{
	$descripcion = "Sin Descripción Definida";	
}
else {
	$descripcion = $_POST['descripcion'];
	$descripcion = ucfirst($descripcion);
}
$tipo = $_POST['tipo'];
$categoria = $_POST['categoria'];
$segmento = $_POST['segmento'];
$prioridad = "Normal";
$status = "Generado / Sin Asignar";
///////////////////////////////////////////////////////
// Insertar Nuevo Proyecto ////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmproyectos (id_usugenera, id_usugeneraori, nombre_proyecto, tipo, categoria, segmento, id_cliente, fecha_generacion, hora_generacion, fecha_requerida, prioridad, potencial, descripcion, status)
						VALUES ('{$id_usugenera}', '{$id_usugeneraori}', '{$nombre_proyecto}', '{$tipo}', '{$categoria}', '{$segmento}', '{$id_cliente}', '{$fecha}', '{$hora}', '{$fecha_requerida}', '{$prioridad}', '{$potencial}', '{$descripcion}', '$status')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción de Proyecto")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Obtener ID del Proyecto generado ///////////////////
///////////////////////////////////////////////////////
$proyecto_id=mysql_query("SELECT MAX(id_proyecto) AS proyecto_id FROM tmproyectos", $conexion);
$array = mysql_fetch_array($proyecto_id, MYSQL_ASSOC);
$idp = $array['proyecto_id'];
///////////////////////////////////////////////////////
// Detalles del Desarrollo 	///////////////////////////
///////////////////////////////////////////////////////
$etiquetado = $_POST['etiquetado'];
$estado_fisico = $_POST['estado_fisico'];
$envase = $_POST['envase'];
$almacenamiento = $_POST['almacenamiento'];
if(empty($_POST['dosis'])){ $dosis = "0"; } else { $dosis = $_POST['dosis']; }
///////////////////////////////////////////////////////
// Alérgenos //////////////////////////////////////////
///////////////////////////////////////////////////////
if(isset($_POST['check_alergenos'])){
	$alergenos = "1";
	if (isset($_POST['a1'])){$a1 = "1";} else {$a1 = "0";}
	if (isset($_POST['a2'])){$a2 = "1";} else {$a2 = "0";}
	if (isset($_POST['a3'])){$a3 = "1";} else {$a3 = "0";}
	if (isset($_POST['a4'])){$a4 = "1";} else {$a4 = "0";}
	if (isset($_POST['a5'])){$a5 = "1";} else {$a5 = "0";}
	if (isset($_POST['a6'])){$a6 = "1";} else {$a6 = "0";}
	if (isset($_POST['a7'])){$a7 = "1";} else {$a7 = "0";}
	if (isset($_POST['a8'])){$a8 = "1";} else {$a8 = "0";}
	}
else {
	$alergenos = "0";
	$a1 = "0";
	$a2 = "0";
	$a3 = "0";
	$a4 = "0";
	$a5 = "0";
	$a6 = "0";
	$a7 = "0";
	$a8 = "0";
}
///////////////////////////////////////////////////////
// Proceso ////////////////////////////////////////////
///////////////////////////////////////////////////////
if (empty($_POST['proceso']))
{
	$proceso = "No Definido";	
}
else {
	$proceso = $_POST['proceso'];
	$proceso = ucfirst($proceso);
}
///////////////////////////////////////////////////////
// Certificaciones ////////////////////////////////////
///////////////////////////////////////////////////////
if (isset($_POST['c1'])){$c1 = "1";} else {$c1 = "0";}
if (isset($_POST['c2'])){$c2 = "1";} else {$c2 = "0";}
if (isset($_POST['c3'])){$c3 = "1";} else {$c3 = "0";}
if (isset($_POST['c4'])){$c4 = "1";} else {$c4 = "0";}
if (isset($_POST['c5'])){$c5 = "1";} else {$c5 = "0";}
if (isset($_POST['check_certificacion'])){
	if (empty($_POST['certificacion']))
	{
		$certificacion = "0";
		}
	else {
		$certificacion = $_POST['certificacion'];
		$certificacion = strtoupper($certificacion);
		}
	}
	else {
		$certificacion = "0";
		}
///////////////////////////////////////////////////////
// Documentación entregada y requerida ////////////////
///////////////////////////////////////////////////////
if (isset($_POST['ec1'])){$ec1 = "1";} else {$ec1 = "0";}
if (isset($_POST['ec2'])){$ec2 = "1";} else {$ec2 = "0";}
if (isset($_POST['ec3'])){$ec3 = "1";} else {$ec3 = "0";}
if (isset($_POST['ec4'])){$ec4 = "1";} else {$ec4 = "0";}
if (isset($_POST['ec5'])){$ec5 = "1";} else {$ec5 = "0";}
if (isset($_POST['check_entregada'])){
	if (empty($_POST['entregada']))
	{
		$entregada = "0";
		}
	else {
		$entregada = $_POST['entregada'];
		$entregada = ucfirst($entregada);
		}
	}
	else {
		$entregada = "0";
		}
if (isset($_POST['rc1'])){$rc1 = "1";} else {$rc1 = "0";}
if (isset($_POST['rc2'])){$rc2 = "1";} else {$rc2 = "0";}
if (isset($_POST['rc3'])){$rc3 = "1";} else {$rc3 = "0";}
if (isset($_POST['rc4'])){$rc4 = "1";} else {$rc4 = "0";}
if (isset($_POST['rc5'])){$rc5 = "1";} else {$rc5 = "0";}
if (isset($_POST['check_requerida'])){
	if (empty($_POST['requerida']))
	{
		$requerida = "0";
		}
	else {
		$requerida = $_POST['requerida'];
		$requerida = ucfirst($requerida);
		}
	}
else {
	$requerida = "0";
	}
///////////////////////////////////////////////////////
// Información de envío ///////////////////////////////
///////////////////////////////////////////////////////
$env = $_POST['envio'];
if ($env=="1")
{
	$envio = "1";
	$direccion = "0";	
}
if ($env=="2")
{
	$envio = "2";
	$direccion = "0";	
}
if ($env=="3")
{
	if(empty($_POST['direccion']))
	{
		$envio = "1";
		$direccion = "0";
	}
	else {
		$envio = "3";
		$direccion = ucfirst($_POST['direccion']);	
	}
}
///////////////////////////////////////////////////////
// Información Adicional //////////////////////////////
///////////////////////////////////////////////////////
$clasificacion = $_POST['clasificacion'];
$termoresistente = $_POST['termoresistente'];
$solubilidad = $_POST['solubilidad'];
$demostracion = $_POST['demostracion'];
$anaquel = $_POST['anaquel'];
if ($anaquel=="")
{
	$anaquel = "0";
}
else {
	$anaquel = $anaquel;
}
///////////////////////////////////////////////////////
// Insertar Requisitos ////////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmrequisitos (id_proyecto, vanual_num, vanual_mon, vmensual_num, vmensual_uni, ptarget_num, ptarget_mon, caplic_num, caplic_mon, etiquetado, estado_fisico, envase, almacenamiento, dosis, alergenos, a1, a2, a3, a4, a5, a6, a7, a8, proceso, c1, c2, c3, c4, c5, certificacion, ec1, ec2, ec3, ec4, ec5, entregada, rc1, rc2, rc3, rc4, rc5, requerida, envio, direccion, clasificacion, termoresistente, solubilidad, demostracion, anaquel)
VALUES ('$idp', '$vanual_num', '$vanual_mon', '$vmensual_num', '$vmensual_uni', '$ptarget_num', '$ptarget_mon', '$caplic_num', '$caplic_mon', '$etiquetado', '$estado_fisico', '$envase', '$almacenamiento', '$dosis', '$alergenos', '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$proceso', '$c1', '$c2', '$c3', '$c4', '$c5', '$certificacion', '$ec1', '$ec2', '$ec3', '$ec4', '$ec5', '$entregada', '$rc1', '$rc2', '$rc3', '$rc4', '$rc5', '$requerida', '$envio', '$direccion', '$clasificacion', '$termoresistente', '$solubilidad', '$demostracion', '$anaquel')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción de Requisitos")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Insertar muestras de línea /////////////////////////
///////////////////////////////////////////////////////
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
			VALUES ('{$idp}','{$id_usugenera}','{$fecha}','{$hora}','{$codigo}','{$nombre_muestra}','{$cantidad}','{$unidadn}','{$unidad}', 'S')", $conexion);
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
$evento = "El proyecto fue generado por";
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$idp','{$id_usugenera}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../proyectos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////	
echo "<script language='javascript'>window.location='../proyecto_generado.php?idp=".$idp."#contenido'</script>";
mysql_close($conexion);
?>
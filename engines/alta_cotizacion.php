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
// Tipo de Cambio del día de Hoy //////////////////////
///////////////////////////////////////////////////////
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$arraythoy = mysql_fetch_object($cambiohoy);
$tcaplicado = $arraythoy->valor;
///////////////////////////////////////////////////////
// Variables y valores del Proyecto ///////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$id_cliente = $_POST['cliente'];
if(empty($_POST['atencion']))
{
	$atencion = "No definido";
}
else {
	$atencion = $_POST['atencion'];
	$atencion = ucwords($atencion);
}
$empresa = $_POST['empresa'];
$segmento = $_POST['segmento'];
$moneda = $_POST['moneda'];
if($moneda=="Pesos")
{
	$moneda = "1";
}
else {
	$moneda = "2";
}
$cantidad = $_POST['cantidad'];
if(empty($_POST['codigo']))
{
	$codigo = "No definido";
}
else {
	$codigo = $_POST['codigo'];
	$codigo = strtoupper($codigo);
}
if(empty($_POST['nombre']))
{
	$nombre = "No definido";
}
else {
	$nombre = $_POST['nombre'];
	$nombre = strtoupper($nombre);
}
$costo = $_POST['costo'];
$mo = $_POST['mo'];
$me = $_POST['me'];
$gt = $_POST['gt'];
$gi = $_POST['gi'];
$og = $_POST['og'];
$utilidad = $_POST['utp'];
$comision = $_POST['cop'];
$incoterm = $_POST['incoterm'];
$vigencia = $_POST['vigencia'];
$impuestos = $_POST['impuestos'];
$compra = $_POST['compra'];
if (empty($_POST['notas']))
{
	$notas = "No definido";	
}
else {
	$notas = $_POST['notas'];
	$notas = ucfirst($notas);
}
if (empty($_POST['observaciones']))
{
	$observaciones = "No definido";	
}
else {
	$observaciones = $_POST['observaciones'];
	$observaciones = ucfirst($observaciones);
}
$status = "Activa";
///////////////////////////////////////////////////////
// Insertar Nuevo Proyecto ////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmcotizaciones (id_usuario, id_cliente, fecha_alta, hora_alta, atencion, empresa, segmento, moneda	, tcaplicado, cantidad, codigo, nombre, costo, mo, me, gt, gi, og, utilidad, comision, incoterm, vigencia, impuestos, compra, notas, observaciones, status)
						VALUES ('{$id_usuario}', '{$id_cliente}', '{$fecha}', '{$hora}', '{$atencion}', '{$empresa}', '{$segmento}', '{$moneda}', '{$tcaplicado}', '{$cantidad}', '{$codigo}', '{$nombre}', '{$costo}', '$mo', '$me', '$gt', '$gi', '$og', '$utilidad', '$comision', '$incoterm', '$vigencia', '$impuestos', '$compra', '$notas', '$observaciones', '$status')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Cotizaciones\n\nError de inserción de Cotización")</script>';
			echo "<script language='javascript'>window.location='../cotizaciones.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Obtener ID de la Cotización generada ///////////////
///////////////////////////////////////////////////////
$cotizacion = mysql_query("SELECT MAX(id_cotizacion) AS id_cotizacion FROM tmcotizaciones", $conexion);
$array = mysql_fetch_array($cotizacion, MYSQL_ASSOC);
$idc = $array['id_cotizacion'];
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////	
echo "<script language='javascript'>window.location='../cotizacion_generada.php?idc=".$idc."#contenido'</script>";
mysql_close($conexion);
?>
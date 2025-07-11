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
// Variables y valores ////////////////////////////////
///////////////////////////////////////////////////////
if (!isset($_POST['pcodigo']))
if (!isset($_POST['ptc']))
exit;
$data = array(); 
$resultado = mysql_query("
SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tmcostos.id_costo, tmcostos.moneda, tmcostos.valor_pesos, tmcostos.valor_dolares, tcproveedores.id_proveedor, tcproveedores.nombre AS proveedor
FROM tcinsumos
JOIN tmcostos
JOIN tcproveedores
WHERE tcinsumos.id_insumo=tmcostos.id_insumo AND tcproveedores.id_proveedor=tmcostos.id_proveedor AND tcinsumos.codigo='".$_POST['pcodigo']."' ORDER BY tmcostos.id_costo DESC LIMIT 1;",$conexion); 
if (mysql_num_rows($resultado)==0)
{
	$data["nombre"]=""; 
	$data["valor_pesos"]="0";
	$data["valor_dolares"]="0";
	$data["proveedor"]="";
	$data["id_insumo"]="";
	$data["id_proveedor"]="";
}
else
{
	$valor = $_POST['ptc'];
	$insumo=mysql_fetch_array($resultado);
	$data["nombre"]=$insumo["nombre"]; 
	if ($insumo["moneda"]=="1")
		{
			$data["valor_pesos"] = number_format($insumo["valor_pesos"],4,".","");
			$data["valor_dolares"] = number_format($insumo["valor_pesos"] / $valor,4,".","");
		}
	if ($insumo["moneda"]=="2")
		{
			$data["valor_dolares"] = number_format($insumo["valor_dolares"],4,".","");
			$data["valor_pesos"] = number_format($insumo["valor_dolares"] * $valor,4,".","");
		}
	$data["proveedor"]=$insumo["proveedor"];
	$data["id_insumo"]=$insumo["id_insumo"];
	$data["id_proveedor"]=$insumo["id_proveedor"];
}
echo json_encode($data);
?>
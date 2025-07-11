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
// Información del Costo //////////////////////////////
///////////////////////////////////////////////////////
$id_costo = $_POST['id_costo'];
$costo=mysql_query("SELECT * FROM tmcostos WHERE id_costo='$id_costo'", $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($costo);
///////////////////////////////////////////////////////
// Variables y valores del Costo //////////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$valor = $_POST['valor'];
if (!empty($comentario)){
	$comentario == "Sin Comentarios";	
}
else {
	$comentario = ucfirst($_POST['comentario']);
}
$incrementables = "2";
$moneda = $infoarray->moneda;
$c_pesos = $infoarray->c_pesos;
$c_dolares = $infoarray->c_dolares;
$tcaplicado = $infoarray->tcaplicado;
///////////////////////////////////////////////////////
// Calculo de Costo integrado /////////////////////////
///////////////////////////////////////////////////////
if($moneda=="2")
{
	$cinc_dolares = $valor;
	$cinc_pesos = $valor * $tcaplicado;
	$valor_pesos = $c_pesos + $cinc_pesos;
	$valor_dolares = $c_dolares + $cinc_dolares;
}
else {
	$cinc_dolares = $valor / $tcaplicado;
	$cinc_pesos = $valor;
	$valor_pesos = $c_pesos + $cinc_pesos;
	$valor_dolares = $c_dolares + $cinc_dolares;
}
///////////////////////////////////////////////////////
// Actualizar Costo integrado /////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tmcostos SET id_usuincrementa='$id_usuario', valor_pesos='$valor_pesos', valor_dolares='$valor_dolares', incrementables='$incrementables', cinc_pesos='$cinc_pesos', cinc_dolares='$cinc_dolares', comentarioi='$comentario', fecha_altai='$fecha', hora_altai='$hora' WHERE id_costo='$id_costo'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Costos\n\nError al actualizar el incrementable.")</script>';
			echo '<script language="javascript">window.location="../costos.php#incrementables"</script>';
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
		}
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////		
echo '<script language="javascript">alert("Cation : Costos\n\nSe registró el incrementable correctamente.")</script>';
echo "<script language='javascript'>window.location='../costos.php#ultimos'</script>";
///////////////////////////////////////////////////////
// Cierre de la conexión con la base de datos /////////
///////////////////////////////////////////////////////	
mysql_close($conexion);
?>
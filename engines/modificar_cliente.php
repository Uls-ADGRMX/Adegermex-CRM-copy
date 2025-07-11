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
// Variables y valores del Cliente ////////////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$id_usugenera = $_GET["usuario"];
$nombre = strtoupper($_POST['nombre']);
$rfc = strtoupper($_POST['rfc']);
$tipo = $_POST['tipo'];
$pertenece = $_POST['pertenece'];
$calle = strtoupper($_POST['calle']);
$exterior = strtoupper($_POST['exterior']);
$interior = strtoupper($_POST['interior']);
$colonia = strtoupper($_POST['colonia']);
$municipio = strtoupper($_POST['municipio']);
$estado = strtoupper($_POST['estado']);
$pais = $_POST['pais'];
$cp = $_POST['cp'];
if(isset($_POST['check_origen'])){
	$oorigen = "1";
	if(empty($_POST['otro_origen']) OR $_POST['otro_origen']=="")
	{
		$origen = "Otro origen no definido";
	}
	else {
		$origen = ucfirst($_POST['otro_origen']);
	}
}
else {
	$origen = $_POST['origen'];
	$oorigen = "0";
}
$instrucciones = ucfirst($_POST['instrucciones']);
$segmento = ucwords($_POST['segmento']);
if(empty($_POST['estrategia']))
{
	$estrategia = "";
}
else {
	$estrategia = ucfirst($_POST['estrategia']);
}
if(empty($_POST['interna']))
{
	$interna = "";
}
else {
	$interna = ucfirst($_POST['interna']);
}
if(empty($_POST['lineas']))
{
	$lineas = "";
}
else {
	$lineas = ucfirst($_POST['lineas']);
}
if(empty($_POST['productos']))
{
	$productos = "";
}
else {
	$productos = ucfirst($_POST['productos']);
}
if(empty($_POST['procesos']))
{
	$procesos = "";
}
else {
	$procesos = ucfirst($_POST['procesos']);
}
$nombre_contacto = ucwords($_POST['nombre_contacto']);
$telefono = strtolower($_POST['telefono']);
$correo = strtolower($_POST['correo']);
$puesto = ucwords($_POST['puesto']);
$departamento = $_POST['departamento'];
///////////////////////////////////////////////////////
// Modificación de Cliente ////////////////////////////
///////////////////////////////////////////////////////
$modificar = mysql_query("UPDATE tcclientes SET nombre='$nombre', rfc='$rfc', tipo='$tipo', pertenece='$pertenece', calle='$calle', exterior='$exterior', interior='$interior', colonia='$colonia', municipio='$municipio', estado='$estado', pais='$pais', cp='$cp', origen='$origen', oorigen='$oorigen', instrucciones='$instrucciones', segmento='$segmento', estrategia='$estrategia', interna='$interna', lineas='$lineas', productos='$productos', procesos='$procesos', nombre_contacto='$nombre_contacto', telefono='$telefono', correo='$correo', puesto='$puesto', departamento='$departamento' WHERE id_cliente='$id'", $conexion);
		if (!$modificar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al modificar los datos del cliente.")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "El cliente fue modificado por";
$insertar = mysql_query("INSERT INTO tmeventos (id_cliente, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id','{$id_usugenera}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id."#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		echo '<script language="javascript">alert("Cation : Clientes\n\nSe modificó el cliente correctamente.")</script>';
		echo "<script language='javascript'>window.location='../cliente.php?id=".$id."#contenido'</script>";
		die();
		}
	mysql_close($conexion);
?>
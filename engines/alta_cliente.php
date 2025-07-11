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
$id_usugenera = $_GET['usuario'];
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
// Consulta para información de Parámetros ////////////
///////////////////////////////////////////////////////
$configuracion = "SELECT * FROM tmconfiguracion WHERE id_configuracion='1'";
$info=mysql_query($configuracion, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$asignar_cliente = $infoarray->asignar_cliente;
///////////////////////////////////////////////////////
// Validación de Cliente existente ////////////////////
///////////////////////////////////////////////////////
$cliente = mysql_query("SELECT * FROM tcclientes WHERE rfc='$rfc' OR nombre='$nombre'",$conexion) or die(mysql_error());
if (mysql_num_rows($cliente)==0)
{
	if ($asignar_cliente=="1")
		{
			$insertar = mysql_query("INSERT INTO tcclientes (id_asignado, nombre, fecha_alta, hora_alta, rfc, tipo, pertenece, calle, exterior, interior, colonia, municipio, estado, pais, cp, origen, oorigen, instrucciones, segmento, estrategia, interna, lineas, productos, procesos, nombre_contacto, telefono, correo, puesto, departamento) VALUES ('{$id_usugenera}', '{$nombre}', '{$fecha}', '{$hora}', '{$rfc}', '{$tipo}', '{$pertenece}', '{$calle}', '{$exterior}', '{$interior}', '{$colonia}', '{$municipio}', '{$estado}', '{$pais}', '{$cp}', '{$origen}', '{$oorigen}', '{$instrucciones}', '{$segmento}', '{$estrategia}', '{$interna}', '{$lineas}', '{$productos}', '{$procesos}', '{$nombre_contacto}', '{$telefono}', '{$correo}', '{$puesto}', '{$departamento}')", $conexion);
		}
	else {
			$insertar = mysql_query("INSERT INTO tcclientes (nombre, fecha_alta, hora_alta, rfc, tipo, pertenece, calle, exterior, interior, colonia, municipio, estado, pais, cp, origen, oorigen, instrucciones, segmento, estrategia, interna, lineas, productos, procesos, nombre_contacto, telefono, correo, puesto, departamento) VALUES ('{$nombre}', '{$fecha}', '{$hora}', '{$rfc}', '{$tipo}', '{$pertenece}', '{$calle}', '{$exterior}', '{$interior}', '{$colonia}', '{$municipio}', '{$estado}', '{$pais}', '{$cp}', '{$origen}', '{$oorigen}', '{$instrucciones}', '{$segmento}', '{$estrategia}', '{$interna}', '{$lineas}', '{$productos}', '{$procesos}', '{$nombre_contacto}', '{$telefono}', '{$correo}', '{$puesto}', '{$departamento}')", $conexion);
	}			
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al agregar cliente al sistema.")</script>';
			echo "<script language='javascript'>window.location='../clientes.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// ID del cliente generado ////////////////////////////
///////////////////////////////////////////////////////
$cliente_id=mysql_query("SELECT MAX(id_cliente) AS cliente_id FROM tcclientes", $conexion);
$array = mysql_fetch_array($cliente_id, MYSQL_ASSOC);
$idc = $array['cliente_id'];
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "El cliente fue generado por";
$insertar = mysql_query("INSERT INTO tmeventos (id_cliente, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$idc','{$id_usugenera}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../clientes.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		echo "<script language='javascript'>window.location='../cliente_generado.php?idc=$idc#contenido'</script>";
		}
else
{
	echo '<script language="javascript">alert("Cation : Clientes\n\nEl cliente que intenta agregar ya existe.\n\nVerifique los datos e ingrese un nombre o RFC de cliente distinto.")</script>';
	echo "<script language='javascript'>window.location='../clientes.php'</script>";
	die();
}
	mysql_close($conexion);
?>
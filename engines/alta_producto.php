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
// Función para eliminar acentos y ñ //////////////////
///////////////////////////////////////////////////////
function formato($cadena){
	$cadena = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	$cadena);
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	$cadena );
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	$cadena );
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	$cadena );
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	$cadena );
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
	$cadena	
    );
    return $cadena;
}
///////////////////////////////////////////////////////
// Variables y valores del Proyecto ///////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$status = "Activo";
if(empty($_POST['nombre_producto']))
{
	$nombre_producto = "Producto Sin Nombre Definido";
}
else {
	$nombre_producto = ucfirst($_POST['nombre_producto']);
}
$categoria = $_POST['categoria'];
if(empty($_POST['subcategoria']))
{
	$subcategoria = "No Definido";
}
else {
	$subcategoria = ucfirst($_POST['subcategoria']);
}
$region = $_POST['region'];
$pais = $_POST['pais'];
$zona = $_POST['zona'];
if(empty($_POST['fabricante']))
{
	$fabricante = "No Definido";
}
else {
	$fabricante = ucfirst($_POST['fabricante']);
}
if(empty($_POST['marca']))
{
	$marca = "No Definido";
}
else {
	$marca = ucfirst($_POST['marca']);
}
$pais_origen = $_POST['pais_origen'];
if(empty($_POST['almacenamiento']))
{
	$almacenamiento = "No Definido";
}
else {
	$almacenamiento = ucfirst($_POST['almacenamiento']);
}
if(empty($_POST['empaque']))
{
	$empaque = "0";
}
else {
	$empaque = $_POST['empaque'];
}
$empaque_unidad = $_POST['empaque_unidad'];
if(empty($_POST['precio']))
{
	$precio = "0";
}
else {
	$precio = $_POST['precio'];
}
if(empty($_POST['precio1']))
{
	$precio1 = "0";
}
else {
	$precio1 = $_POST['precio1'];
}
$fecha_busqueda = $_POST['fecha_busqueda'];
if(empty($_POST['web']))
{
	$web = "No Definido";
}
else {
	$web = strtolower($_POST['web']);
}
if(empty($_POST['tiendas']))
{
	$tiendas = "No Definido";
}
else {
	$tiendas = strtolower($_POST['tiendas']);
}
if(empty($_POST['descripcion']))
{
	$descripcion = "No Definido";
}
else {
	$descripcion = ucfirst($_POST['descripcion']);
}
if(empty($_POST['claims']))
{
	$claims = "No Definido";
}
else {
	$claims = strtolower($_POST['claims']);
}
if(empty($_POST['aplicacion']))
{
	$aplicacion = "No Definido";
}
else {
	$aplicacion = strtolower($_POST['aplicacion']);
}
$porcion = $_POST['porcion'];
$porcion_unidad = $_POST['porcion_unidad'];
$porcionn = $_POST['porcionn'];
$porcionn_unidad = $_POST['porcionn_unidad'];
if (isset($_POST['n1'])){$n1 = "1";} else {$n1 = "0";}
if (isset($_POST['n2'])){$n2 = "1";} else {$n2 = "0";}
if (isset($_POST['n3'])){$n3 = "1";} else {$n3 = "0";}
if (isset($_POST['n4'])){$n4 = "1";} else {$n4 = "0";}
if (isset($_POST['n5'])){$n5 = "1";} else {$n5 = "0";}
if (isset($_POST['n6'])){$n6 = "1";} else {$n6 = "0";}
if (isset($_POST['n7'])){$n7 = "1";} else {$n7 = "0";}
if(isset($_POST['check_ingredientes'])){
	$ingredientesad = "1";
	if(empty($_POST['ingredientesa']))
	{
		$ingredientesad = "0";
		$ingredientesa = "No Definido";
	}
	else {
		$ingredientesa = strtolower($_POST['ingredientesa']);
	}
}
else {
	$ingredientesad = "0";
	$ingredientesa = "No Definido";
}
if(empty($_POST['sabores']))
{
	$sabores = "No Definido";
}
else {
	$sabores = strtolower($_POST['sabores']);
}
if(empty($_POST['ingredientes']))
{
	$ingredientes = "No Definido";
}
else {
	$ingredientes = strtolower($_POST['ingredientes']);
}
if(empty($_POST['alergenos']))
{
	$alergenos = "No Definido";
}
else {
	$alergenos = strtolower($_POST['alergenos']);
}
if(empty($_POST['dieta']))
{
	$dieta = "No Definido";
}
else {
	$dieta = strtolower($_POST['dieta']);
}
///////////////////////////////////////////////////////
// Insertar Nuevo Producto ////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmproductos (id_usuario, fecha_alta, hora_alta, status, nombre_producto, categoria, subcategoria, region, pais, zona, fabricante, marca, pais_origen, almacenamiento, empaque, empaque_unidad, precio, precio1, fecha_busqueda, web, tiendas, descripcion, claims, aplicacion, porcion, porcion_unidad, porcionn, porcionn_unidad, n1, n2, n3, n4, n5, n6, n7, ingredientesad, ingredientesa, sabores, ingredientes, alergenos, dieta)
						VALUES ('{$id_usuario}', '{$fecha}', '{$hora}', '{$status}', '{$nombre_producto}', '{$categoria}', '{$subcategoria}', '{$region}', '{$pais}', '{$zona}', '{$fabricante}', '{$marca}', '{$pais_origen}', '{$almacenamiento}', '{$empaque}', '{$empaque_unidad}', '{$precio}', '{$precio1}', '{$fecha_busqueda}', '{$web}', '{$tiendas}', '{$descripcion}', '{$claims}', '{$aplicacion}', '{$porcion}', '{$porcion_unidad}', '{$porcionn}', '{$porcionn_unidad}', '{$n1}', '{$n2}', '{$n3}', '{$n4}', '{$n5}', '{$n6}', '{$n7}', '{$ingredientesad}', '{$ingredientesa}', '{$sabores}', '{$ingredientes}', '{$alergenos}', '{$dieta}')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError al insertar el Producto")</script>';
			echo "<script language='javascript'>window.location='../mercado.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Obtener ID del Producto generado ///////////////////
///////////////////////////////////////////////////////
$producto_id=mysql_query("SELECT MAX(id_producto) AS producto_id FROM tmproductos", $conexion);
$array = mysql_fetch_array($producto_id, MYSQL_ASSOC);
$id_producto = $array['producto_id'];
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "El producto fue generado por";
$insertar = mysql_query("INSERT INTO tmeventos (id_producto, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_producto','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../mercado.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Archivo adjunto ////////////////////////////////////
///////////////////////////////////////////////////////
$directorio = '../adjuntos/productos/';
$nombre = $_FILES['adjuntar']['name'];
$nombre_mod = formato($nombre);
$nombre_mod = preg_replace('([^A-Za-z0-9 .])','',$nombre_mod);
$nombre_mod = $id_producto."_".$nombre_mod;
$ruta = $directorio.$nombre_mod;
	if (move_uploaded_file($_FILES['adjuntar']['tmp_name'], $ruta))
	{
		$nombre_imagen = $nombre_mod;
		$peso_imagen = number_format(($_FILES['adjuntar']['size']/1024),2,".",",");
		$tipo_imagen = $_FILES['adjuntar']['type'];
	}
	else {
		$nombre_imagen = "0";
		$peso_imagen = "0";
		$tipo_imagen = "0";	
		}
///////////////////////////////////////////////////////
// Insertar imágen ////////////////////////////////////
///////////////////////////////////////////////////////
$actualizar = mysql_query("UPDATE tmproductos SET nombre_imagen='$nombre_imagen', peso_imagen='$peso_imagen', tipo_imagen='$tipo_imagen' WHERE id_producto='$id_producto'", $conexion);
	if (!$actualizar) {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError al insertar la imagen")</script>';
		echo "<script language='javascript'>window.location='../producto_generado.php?id=".$id_producto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		}
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////
echo "<script language='javascript'>window.location='../producto_generado.php?id=".$id_producto."#contenido'</script>";
mysql_close($conexion);
?>
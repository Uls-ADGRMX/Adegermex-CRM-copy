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
// Variables y valores de la imagen ///////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$id_producto = $_POST['id_producto'];
$tipo_subir = $_POST['tipo_subir'];
///////////////////////////////////////////////////////
// Archivo adjunto ////////////////////////////////////
///////////////////////////////////////////////////////
$directorio = '../adjuntos/productos/';
$horaa=date("YmdHis");
$nombre = $_FILES['adjuntar']['name'];
$nombre_mod = formato($nombre);
$nombre_mod = preg_replace('([^A-Za-z0-9 .])','',$nombre_mod);
$nombre_mod = $id_producto."_".$horaa."_".$nombre_mod;
$ruta = $directorio.$nombre_mod;
	if (move_uploaded_file($_FILES['adjuntar']['tmp_name'], $ruta))
	{
		$nombre_imagen = $nombre_mod;
		$peso_imagen = number_format(($_FILES['adjuntar']['size']/1024),2,".",",");
		$tipo_imagen = $_FILES['adjuntar']['type'];
	}
	else {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nLa imagen no pudo ser cargada.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		exit();
		}
///////////////////////////////////////////////////////
// Insertar Imagen ////////////////////////////////////
///////////////////////////////////////////////////////
if($tipo_subir=="p")
{
	$actualizar = mysql_query("UPDATE tmproductos SET nombre_imagen='$nombre_imagen', peso_imagen='$peso_imagen', tipo_imagen='$tipo_imagen' WHERE id_producto='$id_producto'", $conexion);
	if (!$actualizar) {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError al insertar la imagen")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
		}
	else {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nLa imagen su subió correctamente.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		}
}
if($tipo_subir=="s")
{
$insertar = mysql_query("INSERT INTO tcimagenes (id_producto, id_usuario, fecha_alta, hora_alta, nombre_imagen, peso_imagen, tipo_imagen) VALUES ('{$id_producto}', '{$id_usuario}', '{$fecha}', '{$hora}', '{$nombre_imagen}', '{$peso_imagen}', '{$tipo_imagen}')", $conexion);
	if (!$insertar) {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nError al insertar la imagen.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		exit();
	}
	else {
		echo '<script language="javascript">alert("Cation : Inteligencia de Mercado\n\nLa imagen su subió correctamente.")</script>';
		echo "<script language='javascript'>window.location='../producto.php?id=".$id_producto."#contenido'</script>";
		}
}
mysql_close($conexion);
?>
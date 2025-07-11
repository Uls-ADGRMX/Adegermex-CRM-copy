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
// Variables y valores del Contacto ///////////////////
///////////////////////////////////////////////////////
$id_cliente = $_POST['id_cliente'];
$id_usuario = $_POST['id_usuario'];
$nombre_contacto = ucwords($_POST['nombre_contacto']);
$telefono = strtolower($_POST['telefono']);
$correo = strtolower($_POST['correo']);
$puesto = ucwords($_POST['puesto']);
$departamento = $_POST['departamento'];
///////////////////////////////////////////////////////
// Registrar Contacto /////////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmcontactos (id_cliente, fecha_alta, hora_alta, nombre_contacto, telefono, correo, puesto, departamento) VALUES ('{$id_cliente}', '{$fecha}', '{$hora}', '{$nombre_contacto}', '{$telefono}', '{$correo}', '{$puesto}', '{$departamento}')", $conexion);		
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError al registrar el contacto.")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contactos'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Insertar Evento ////////////////////////////////////
///////////////////////////////////////////////////////
$evento = "Se agregó un nuevo <strong>Contacto</strong> para el cliente, registrado por";
$insertar = mysql_query("INSERT INTO tmeventos (id_cliente, id_usuario, tipo_evento, fecha, hora, evento)
						VALUES ('$id_cliente','{$id_usuario}','Actividad', '{$fecha}', '{$hora}','$evento')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Evento")</script>';
			echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contactos'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
		}
echo '<script language="javascript">alert("Cation : Clientes\n\nSe registró el contacto correctamente.")</script>';
echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#contactos'</script>";
die();
mysql_close($conexion);
?>
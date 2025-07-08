<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
$conexion = mysql_connect('localhost', 'crmadege_root', 'crmadege_pass');
if (!$conexion) {
    die('Error al conectar con la Base de Datos: ' . mysql_error());
	}
///////////////////////////////////////////////////////
// Selección de la Base de Datos //////////////////////
///////////////////////////////////////////////////////
$bdatos = mysql_select_db ('crmadege_cation', $conexion);
if (!$bdatos) {
    die ('Error al seleccionar la Base de Datos: ' . mysql_error());
}
?>
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
// Variables y valores de la Fórmula //////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$id_proyecto = $_POST['id_proyecto'];
$numero = $_POST['numero'];
$numero_nuevos = $_POST['numero_nuevos'];
if(empty($_POST['nombre_formula']))
{
	$nombre_formula = "Fórmula Sin Nombre Definido";
}
else {
	$nombre_formula = $_POST['nombre_formula'];
	$nombre_formula = ucfirst($nombre_formula);
}
if (empty($_POST['codigo_interno']))
{
	$codigo_interno = "ND";	
}
else {
	$codigo_interno = $_POST['codigo_interno'];
	$codigo_interno = strtoupper($codigo_interno);
}
if (empty($_POST['revision']))
{
	$revision = "ND";
}
else {
	$revision = $_POST['revision'];
	$revision = ucfirst($revision);
}
$cdkp = $_POST['cdkp'];
$cdkd = $_POST['cdkd'];
$tcaplicado = $_POST['tipocambio'];
if (empty($_POST['observaciones']))
{
	$observaciones = "Sin Observaciones";	
}
else {
	$observaciones = $_POST['observaciones'];
	$observaciones = ucfirst($observaciones);
}
///////////////////////////////////////////////////////
// Insertar Nueva Fórmula /////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmformulas (id_proyecto, id_usuario, fecha_alta, hora_alta, nombre_formula, codigo_interno, revision, cdkp, cdkd, tcaplicado, observaciones, master, status)
						VALUES ('{$id_proyecto}', '{$id_usuario}', '{$fecha}', '{$hora}', '{$nombre_formula}', '{$codigo_interno}', '{$revision}','{$cdkp}', '{$cdkd}', '{$tcaplicado}', '{$observaciones}', '0', 'Activa')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError de inserción de Fórmula")</script>';
			echo "<script language='javascript'>window.location='../formulas.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Obtener ID de la Fórmula generada //////////////////
///////////////////////////////////////////////////////
$formula_id=mysql_query("SELECT MAX(id_formula) AS formula_id FROM tmformulas", $conexion);
$array = mysql_fetch_array($formula_id, MYSQL_ASSOC);
$idf = $array['formula_id'];
///////////////////////////////////////////////////////
// Insertar Componentes de la Fórmula /////////////////
///////////////////////////////////////////////////////
for ($a=1; $a<=$numero; $a++){
	if (empty($_POST['codigo'.$a.'']))
	{
	}
	else
	{
		$id_insumo = $_POST['id_insumo'.$a.''];
		$ckgs = $_POST['ckgs'.$a.''];
		$porcentaje = $_POST['porcentaje'.$a.''];
		$cospesos = $_POST['cospesos'.$a.''];
		$cosdolar = $_POST['cosdolar'.$a.''];
		$ipesos = $_POST['ipesos'.$a.''];
		$idolar = $_POST['idolar'.$a.''];	
		$registro = mysql_query("INSERT INTO tmcomponentes (id_formula, id_insumo, ckgs, porcentaje, cospesos, cosdolar, ipesos, idolar)
			VALUES ('{$idf}','{$id_insumo}','{$ckgs}','{$porcentaje}','{$cospesos}','{$cosdolar}','{$ipesos}','{$idolar}')", $conexion);
		if (!$registro) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError de inserción de Componentes")</script>';
			echo "<script language='javascript'>window.location='../formulas.php#contenido'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		}
	}
}
///////////////////////////////////////////////////////
// Insertar Especificaciones de Diseño ////////////////
///////////////////////////////////////////////////////
if(empty($_POST['f1'])){ $f1 = "ND"; } else { $f1 = $_POST['f1']; }
if(empty($_POST['f2'])){ $f2 = "ND"; } else { $f2 = $_POST['f2']; }
if(empty($_POST['f3'])){ $f3 = "ND"; } else { $f3 = $_POST['f3']; }
if(empty($_POST['f4'])){ $f4 = "ND"; } else { $f4 = $_POST['f4']; }
if(empty($_POST['f5'])){ $f5 = "ND"; } else { $f5 = $_POST['f5']; }
if(empty($_POST['f6'])){ $f6 = "ND"; } else { $f6 = $_POST['f6']; }
if(empty($_POST['f7'])){ $f7 = "ND"; } else { $f7 = $_POST['f7']; }
if(empty($_POST['f8'])){ $f8 = "ND"; } else { $f8 = $_POST['f8']; }
if(empty($_POST['f9'])){ $f9 = "ND"; } else { $f9 = $_POST['f9']; }
if(empty($_POST['f10'])){ $f10 = "ND"; } else { $f10 = $_POST['f10']; }
if(empty($_POST['m1'])){ $m1 = "ND"; } else { $m1 = $_POST['m1']; }
if(empty($_POST['m2'])){ $m2 = "ND"; } else { $m2 = $_POST['m2']; }
if(empty($_POST['m3'])){ $m3 = "ND"; } else { $m3 = $_POST['m3']; }
if(empty($_POST['m4'])){ $m4 = "ND"; } else { $m4 = $_POST['m4']; }
if(empty($_POST['m5'])){ $m5 = "ND"; } else { $m5 = $_POST['m5']; }
if(empty($_POST['m6'])){ $m6 = "ND"; } else { $m6 = $_POST['m6']; }
if(empty($_POST['m7'])){ $m7 = "ND"; } else { $m7 = $_POST['m7']; }
if(empty($_POST['g1'])){ $g1 = "ND"; } else { $g1 = $_POST['g1']; }
if(empty($_POST['g2'])){ $g2 = "ND"; } else { $g2 = $_POST['g2']; }
if(empty($_POST['g3'])){ $g3 = "ND"; } else { $g3 = $_POST['g3']; }
if(empty($_POST['g4'])){ $g4 = "ND"; } else { $g4 = $_POST['g4']; }
if(empty($_POST['g5'])){ $g5 = "ND"; } else { $g5 = $_POST['g5']; }
if(empty($_POST['g6'])){ $g6 = "ND"; } else { $g6 = $_POST['g6']; }
if(empty($_POST['g7'])){ $g7 = "ND"; } else { $g7 = $_POST['g7']; }
if(empty($_POST['g8'])){ $g8 = "ND"; } else { $g8 = $_POST['g8']; }
if(empty($_POST['g9'])){ $g9 = "ND"; } else { $g9 = $_POST['g9']; }
if(empty($_POST['g10'])){ $g10 = "ND"; } else { $g10 = $_POST['g10']; }
if(empty($_POST['g11'])){ $g11 = "ND"; } else { $g11 = $_POST['g11']; }
if(empty($_POST['g12'])){ $g12 = "ND"; } else { $g12 = $_POST['g12']; }
if(empty($_POST['g13'])){ $g13 = "ND"; } else { $g13 = $_POST['g13']; }
if(empty($_POST['g14'])){ $g14 = "ND"; } else { $g14 = $_POST['g14']; }
$especific = mysql_query("INSERT INTO tmespecific (id_formula, f1, f2, f3, f4, f5, f6, f7, f8, f9, f10, m1, m2, m3, m4, m5, m6, m7, g1, g2, g3, g4, g5, g6, g7, g8, g9, g10, g11, g12, g13, g14) VALUES ('{$idf}', '{$f1}', '{$f2}', '{$f3}', '{$f4}', '{$f5}', '{$f6}', '{$f7}', '{$f8}', '{$f9}', '{$f10}', '{$m1}', '{$m2}', '{$m3}', '{$m4}', '{$m5}', '{$m6}', '{$m7}', '{$g1}', '{$g2}', '{$g3}', '{$g4}', '{$g5}', '{$g6}', '{$g7}', '{$g8}', '{$g9}', '{$g10}', '{$g11}', '{$g12}', '{$g13}', '{$g14}')", $conexion);
		if (!$especific) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError de inserción de Especificaciones")</script>';
			echo "<script language='javascript'>window.location='../formulas.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Insertar Insumos Nuevos ////////////////////////////
///////////////////////////////////////////////////////
for ($b=1; $b<=$numero_nuevos; $b++){
	if (empty($_POST['incodigo'.$b.'']))
	{
	}
	else
	{
		$id_insumo = $_POST['in_idinsum'.$b.''];
		$id_proveedor = $_POST['in_idprov'.$b.''];
		$incospesos = $_POST['incospesos'.$b.''];
		$incosdolar = $_POST['incosdolar'.$b.''];
		$registro = mysql_query("INSERT INTO tminnuevos (id_formula, id_insumo, id_proveedor, cospesos, cosdolar)
			VALUES ('{$idf}','{$id_insumo}','{$id_proveedor}','{$incospesos}','{$incosdolar}')", $conexion);
		if (!$registro) {
			echo '<script language="javascript">alert("Cation : Fórmulas\n\nError de inserción de Insumos Nuevos")</script>';
			echo "<script language='javascript'>window.location='../formulas.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
		}
	}
}
///////////////////////////////////////////////////////
// Redirección a mensaje de confirmación //////////////
///////////////////////////////////////////////////////
echo "<script language='javascript'>window.location='../formula_generada.php?idf=".$idf."&idp=".$id_proyecto."#contenido'</script>";
///////////////////////////////////////////////////////
// Se cierra conexión con la Base de Datos ////////////
///////////////////////////////////////////////////////
mysql_close($conexion);
?>
<?php
///////////////////////////////////////////////////////
// Inicio de Sesión ///////////////////////////////////
///////////////////////////////////////////////////////
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include 'scripts/conexion.php';
///////////////////////////////////////////////////////
// Datos del Usuario //////////////////////////////////
///////////////////////////////////////////////////////
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
///////////////////////////////////////////////////////
// Validación de estadistica por periodo //////////////
///////////////////////////////////////////////////////
if (empty($_GET['p']))
{
	$p = 0;
}
else {
	$p = 1;
	$fecha_inicial = $_POST['fecha_inicial'];
	$fecha_final = $_POST['fecha_final'];
	if ($fecha_inicial > $fecha_final)
	{
		$fr = 1;
	}
	else {
		$fr = 0;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Estadísticas</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Grafico Costos X Tipo -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $costosxtipo=mysql_query("SELECT incrementables, COUNT(*) AS total_inc FROM tmcostos WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY incrementables ORDER BY total_inc DESC",$conexion);
		  }
		  else {
			  $costosxtipo=mysql_query("SELECT incrementables, COUNT(*) AS total_inc FROM tmcostos GROUP BY incrementables ORDER BY total_inc DESC",$conexion);
		  }
		  $cxtn=mysql_num_rows($costosxtipo);
		  while($ct=mysql_fetch_array($costosxtipo)){
			  if ($ct['incrementables']=="0") { $tipo = "Costos directos"; }
			  if ($ct['incrementables']=="1") { $tipo = "Costos esperando incrementables"; }
			  if ($ct['incrementables']=="2") { $tipo = "Costos con incrementables"; }
			  $cantidad = $ct['total_inc'];
			  echo "['".$tipo." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#3498DB', '#28B463', '#F5B041'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('costosxtipo'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Costos X Agente de Compras -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Agente de Compras', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $costosxagente=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_agente FROM tmcostos JOIN tcusuarios WHERE tmcostos.id_usuario = tcusuarios.id_usuario AND tmcostos.fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_agente DESC",$conexion);
		  }
		  else {
			  $costosxagente=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_agente FROM tmcostos JOIN tcusuarios WHERE tmcostos.id_usuario = tcusuarios.id_usuario GROUP BY tcusuarios.nombre ORDER BY total_agente DESC",$conexion);
		  }
		  $cxan=mysql_num_rows($costosxagente);
		  while($ca=mysql_fetch_array($costosxagente)){
			  $agente = $ca['nombre'];
			  $cantidad = $ca['total_agente'];
			  echo "['".$agente." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
        };
        var chart = new google.visualization.PieChart(document.getElementById('costosxagente'));
        chart.draw(data, options);
      }
    </script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#B31919">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <?php include "header.php"; ?><br /></td>
  </tr>
</table>
<br />
<?php include "menu.php"; ?>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Estadísticas</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="factura-texto4"><a name="contenido" id="contenido"></a>Selección de periodo</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td bgcolor="#FFFFFF" align="center"><br/>
      <form action="estadisticas_costos.php?p=1#contenido" method="post">
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="80" align="center">Del</td>
            <td width="220" align="center" class="encabezado-tabla"><input type="date" name="fecha_inicial" id="fecha_inicial" class="textbox-med" required="required" autocomplete="off"/></td>
            <td width="80" align="center">al</td>
            <td width="220" align="center" class="encabezado-tabla"><input type="date" name="fecha_final" id="fecha_final" class="textbox-med" required="required" autocomplete="off"/></td>
            <td width="300" align="center"><input name="consultar" type="submit" class="boton-comentar" id="consultar" value="Consultar" /></td>
          </tr>
        </table>
        </form>
        <br/></td>
    </tr>
  </table>
  <br />
  <?php
  if($p==1 AND $fr==0) {
	echo '
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" class="mensaje-correcto">Usted está consultando información correspondiente al periodo del <strong>'.$fecha_inicial.'</strong> al <strong>'.$fecha_final.'</strong>.</td>
		</tr>
	</table>
	<br />';
  }
  else if ($p==1 AND $fr==1) {
	echo '
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" class="mensaje-error">El periodo de fechas ingresado es incorrecto. La fecha inicial es mayor a la fecha final.</td>
		</tr>
	</table>
	<br />';
  }
  ?>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Costos por Tipo</td>
      <td width="500" class="factura-texto4">Costos por Agente de Compras</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($cxtn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="costosxtipo" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($cxan=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="costosxagente" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
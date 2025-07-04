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
<!-- Grafico Cotizaciones X Segmento -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Segmento', 'Cotizaciones'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $cotizacionesxsegmento=mysql_query("SELECT tmcotizaciones.segmento, COUNT(*) AS total_seg FROM tmcotizaciones WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY segmento ORDER BY segmento ASC",$conexion);
		  }
		  else {
			  $cotizacionesxsegmento=mysql_query("SELECT tmcotizaciones.segmento, COUNT(*) AS total_seg FROM tmcotizaciones GROUP BY segmento ORDER BY segmento ASC",$conexion);
		  }
		  $cxsn=mysql_num_rows($cotizacionesxsegmento);
		  while($cs=mysql_fetch_array($cotizacionesxsegmento)){
			  $segmento = $cs['segmento'];
			  $cantidad = $cs['total_seg'];
			  echo "['".$segmento."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#6C8AD2'],
        };

        var chart = new google.charts.Bar(document.getElementById('cotizacionesxsegmento'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Cotizaciones X Empresa -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Empresa', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $cotizacionesxempresa=mysql_query("SELECT empresa, COUNT(*) AS total_empresa FROM tmcotizaciones WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY empresa ORDER BY total_empresa DESC",$conexion);
		  }
		  else {
			  $cotizacionesxempresa=mysql_query("SELECT empresa, COUNT(*) AS total_empresa FROM tmcotizaciones GROUP BY empresa ORDER BY total_empresa DESC",$conexion);
		  }
		  $cxen=mysql_num_rows($cotizacionesxempresa);
		  while($ce=mysql_fetch_array($cotizacionesxempresa)){
			  $empresa = $ce['empresa'];
			  $cantidad = $ce['total_empresa'];
			  echo "['".$empresa." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#38A79D', '#359E41'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('cotizacionesxempresa'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Cotizaciones X Moneda -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Moneda', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $cotizacionesxmoneda=mysql_query("SELECT moneda, COUNT(*) AS total_moneda FROM tmcotizaciones WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY moneda ORDER BY total_moneda DESC",$conexion);
		  }
		  else {
			  $cotizacionesxmoneda=mysql_query("SELECT moneda, COUNT(*) AS total_moneda FROM tmcotizaciones GROUP BY moneda ORDER BY total_moneda DESC",$conexion);
		  }
		  $cxmn=mysql_num_rows($cotizacionesxmoneda);
		  while($cm=mysql_fetch_array($cotizacionesxmoneda)){
			  if ($cm['moneda']=="1") { $moneda = "Pesos"; } else { $moneda = "Dolares"; }
			  $cantidad = $cm['total_moneda'];
			  echo "['".$moneda." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#C257B4', '#68D176'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('cotizacionesxmoneda'));
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
      <form action="estadisticas_cotizaciones.php?p=1#contenido" method="post">
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
      <td width="500" class="factura-texto4">Cotizaciones por Segmento</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br/>
        <?php
        if ($cxsn=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="cotizacionesxsegmento" style="width: 950px; height: 300px"></div>';
		}
		?>
        <br/></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Cotizaciones por Empresa</td>
      <td width="500" class="factura-texto4">Cotizaciones por Moneda</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($cxen=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="cotizacionesxempresa" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($cxmn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="cotizacionesxmoneda" style="width: 490px; height: 250px;"></div>';
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
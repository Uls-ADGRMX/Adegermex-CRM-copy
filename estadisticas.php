<?php
///////////////////////////////////////////////////////
// Eliminar Cache /////////////////////////////////////
///////////////////////////////////////////////////////
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
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
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
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
	$mes = date("m");
	$anio = date("Y");
	$fecha_inicial = $anio."-".$mes."-01";
	$fecha_final = $anio."-".$mes."-31";
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
///////////////////////////////////////////////////////
// Estadísticas de Proyectos //////////////////////////
///////////////////////////////////////////////////////
$proyectos = "SELECT COUNT(*) AS proyectos,
(SELECT COUNT(*) FROM tmproyectos WHERE status = 'Finalizado' AND fecha_termino BETWEEN '$fecha_inicial' AND '$fecha_final') AS finalizados,
(SELECT COUNT(*) FROM tmproyectos WHERE new_win = '1' AND fecha_termino BETWEEN '$fecha_inicial' AND '$fecha_final') AS wins,
(SELECT COUNT(*) FROM tmproyectos WHERE cierre_venta = '1' AND fecha_termino BETWEEN '$fecha_inicial' AND '$fecha_final') AS vendidos,
(SELECT COUNT(*) FROM tmproyectos WHERE cierre_venta = '0' AND fecha_termino BETWEEN '$fecha_inicial' AND '$fecha_final') AS novendidos
FROM tmproyectos
WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final'";
$estxproyectos=mysql_query($proyectos, $conexion) or die(mysql_error());
$arrayproyectos = mysql_fetch_object($estxproyectos);
///////////////////////////////////////////////////////
// Estadísticas de Proyectos Finalizados //////////////
///////////////////////////////////////////////////////
$finalizados=mysql_query("
SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.status, tmproyectos.fecha_generacion, tmproyectos.hora_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador, tcclientes.nombre AS cliente
FROM tmproyectos
JOIN tcusuarios
JOIN tcclientes
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = tcclientes.id_cliente AND tmproyectos.fecha_termino BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY id_proyecto DESC",$conexion);
$numero_finalizados=mysql_num_rows($finalizados);
///////////////////////////////////////////////////////
// Estadísticas de Muestras ///////////////////////////
///////////////////////////////////////////////////////
$muestras = "SELECT
(SELECT IFNULL(SUM(tmmuestras.cantidad),0) FROM tmmuestras WHERE tmmuestras.fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' AND tmmuestras.origen = 'S') AS solicitadas,
(SELECT IFNULL(SUM(tmmuestras.cantidad),0) FROM tmmuestras JOIN tmproyectos WHERE tmmuestras.id_proyecto = tmproyectos.id_proyecto AND tmproyectos.fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND tmmuestras.origen = 'E') AS entregadas";
$estxmuestras=mysql_query($muestras, $conexion) or die(mysql_error());
$arraymuestras = mysql_fetch_object($estxmuestras);
$ms = $arraymuestras->solicitadas;
$me = $arraymuestras->entregadas;
$proymuestras = "SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.segmento, tmproyectos.cierre_venta
FROM tmproyectos
WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final'";
$estxpm=mysql_query($proymuestras, $conexion) or die(mysql_error());
///////////////////////////////////////////////////////
// Estadísticas de Seguimientos y comentarios /////////
///////////////////////////////////////////////////////
$seguimientos = "SELECT COUNT(*) AS seguimientos,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Llamada') AS llamadas,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Correo') AS correos,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Visita') AS visitas,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Apoyo') AS apoyos,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Videoconferencia') AS videoconferencias,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Actividad') AS eventos,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND tipo_evento='Comentario') AS comentarios,
(SELECT COUNT(*) FROM tmeventos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND (nombre_adjunto<>'' AND nombre_adjunto<>'0')) AS adjuntos
FROM tmeventos
WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND (tipo_evento<>'Actividad' AND tipo_evento<>'Comentario')";
$estxseguimientos=mysql_query($seguimientos, $conexion) or die(mysql_error());
$arrayseguimientos = mysql_fetch_object($estxseguimientos);
///////////////////////////////////////////////////////
// Estadísticas de Actividad en sistema ///////////////
///////////////////////////////////////////////////////
$actividad = "SELECT COUNT(*) AS clientes,
(SELECT COUNT(*) FROM tmformulas WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS formulas,
(SELECT COUNT(*) FROM tcinsumos WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS insumos,
(SELECT COUNT(*) FROM tctcambio WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS tcambio,
(SELECT COUNT(*) FROM tcproveedores WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS proveedores,
(SELECT COUNT(*) FROM tmcostos WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS costos,
(SELECT COUNT(*) FROM tmcotizaciones WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS cotizaciones,
(SELECT COUNT(*) FROM tcusuarios WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final') AS usuarios
FROM tcclientes
WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final'";
$estxactividad=mysql_query($actividad, $conexion) or die(mysql_error());
$arrayactividad = mysql_fetch_object($estxactividad);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Estadísticas</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css?version=5.0" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Grafico Proyectos X Status -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Proyectos'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxstatus=mysql_query("SELECT tmproyectos.status, COUNT(*) AS total_stat FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY status ORDER BY status ASC",$conexion);
		  }
		  else {
			  $proyectosxstatus=mysql_query("SELECT tmproyectos.status, COUNT(*) AS total_stat FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY status ORDER BY status ASC",$conexion);
		  }
		  $pxsn=mysql_num_rows($proyectosxstatus);
		  while($ps=mysql_fetch_array($proyectosxstatus)){
			  $status = $ps['status'];
			  $cantidad = $ps['total_stat'];
			  echo "['".$status."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#58D68D'],
        };

        var chart = new google.charts.Bar(document.getElementById('proyectosxstatus'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Proyectos X Agente de Ventas -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Agente de Ventas', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxagente=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_agente FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_agente DESC",$conexion);
		  }
		  else {
			  $proyectosxagente=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_agente FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_agente DESC",$conexion);
		  }
		  $pxan=mysql_num_rows($proyectosxagente);
		  while($pa=mysql_fetch_array($proyectosxagente)){
			  $agente = $pa['nombre'];
			  $cantidad = $pa['total_agente'];
			  echo "['".$agente." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxagente'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Proyectos X Desarrollador -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Desarrollador', 'Cantidad'],
		  <?php
		  if($p==1 AND $fr==0)
		  {
			  $proyectosxdes=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_des FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usuasignado = tcusuarios.id_usuario AND fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_des DESC",$conexion);
		  }
		  else {
			  $proyectosxdes=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_des FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usuasignado = tcusuarios.id_usuario AND fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_des DESC",$conexion);
		  }
		  $pxdn=mysql_num_rows($proyectosxdes);
		  if ($pxdn=="0")
		  {
			  $proyectossdes=mysql_query("SELECT COUNT(*) AS sin_des FROM tmproyectos WHERE tmproyectos.id_usuasignado = 0",$conexion);
			  $psd=mysql_fetch_array($proyectossdes);
			  $cantidad = $psd['sin_des'];
			  echo "['Sin Desarrollador (".$cantidad.")',".$cantidad."],";
		  }
		  else {
			  while($pd=mysql_fetch_array($proyectosxdes)){
				  $desarrollador = $pd['nombre'];
				  $cantidad = $pd['total_des'];
				  echo "['".$desarrollador." (".$cantidad.")"."',".$cantidad."],";
				  }
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxdes'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Proyectos X Segmento -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Segmento', 'Proyectos'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxseg=mysql_query("SELECT tmproyectos.segmento, COUNT(*) AS total_seg FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY segmento ORDER BY segmento ASC",$conexion);
		  }
		  else {
			  $proyectosxseg=mysql_query("SELECT tmproyectos.segmento, COUNT(*) AS total_seg FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY segmento ORDER BY segmento ASC",$conexion);
		  }
		  $pxsegn=mysql_num_rows($proyectosxseg);
		  while($ps=mysql_fetch_array($proyectosxseg)){
			  $segmento = $ps['segmento'];
			  $cantidad = $ps['total_seg'];
			  echo "['".$segmento."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#20b2aa'],
        };

        var chart = new google.charts.Bar(document.getElementById('proyectosxseg'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Proyectos X Categoría -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Categoría', 'Proyectos'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxcat=mysql_query("SELECT tmproyectos.categoria, COUNT(*) AS total_cat FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY categoria ORDER BY categoria ASC",$conexion);
		  }
		  else {
			  $proyectosxcat=mysql_query("SELECT tmproyectos.categoria, COUNT(*) AS total_cat FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY categoria ORDER BY categoria ASC",$conexion);
		  }
		  $pxcatn=mysql_num_rows($proyectosxcat);
		  while($pc=mysql_fetch_array($proyectosxcat)){
			  $categoria = $pc['categoria'];
			  $cantidad = $pc['total_cat'];
			  echo "['".$categoria."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#FFD700'],
        };

        var chart = new google.charts.Bar(document.getElementById('proyectosxcat'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Proyectos X Potencial de Negocio -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potencial', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxpotencial=mysql_query("SELECT potencial, COUNT(*) AS total_potencial FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY potencial ORDER BY potencial ASC",$conexion);
		  }
		  else {
			  $proyectosxpotencial=mysql_query("SELECT potencial, COUNT(*) AS total_potencial FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY potencial ORDER BY potencial ASC",$conexion);
		  }
  		  $pxpn=mysql_num_rows($proyectosxpotencial);
		  while($pp=mysql_fetch_array($proyectosxpotencial)){
			  if ($pp['potencial']=="1") { $potencial = "Alto"; }
			  if ($pp['potencial']=="2") { $potencial = "Medio"; }
  			  if ($pp['potencial']=="3") { $potencial = "Bajo"; }
			  $cantidad = $pp['total_potencial'];
			  echo "['".$potencial." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#319F48', '#34CBE0', '#FA5252'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxpotencial'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Proyectos X Tipo de Proyecto -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxtipo=mysql_query("SELECT tipo, COUNT(*) AS total_tipo FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tipo ORDER BY total_tipo DESC",$conexion);
		  }
		  else {
			  $proyectosxtipo=mysql_query("SELECT tipo, COUNT(*) AS total_tipo FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tipo ORDER BY total_tipo DESC",$conexion);
		  }
		  $pxtn=mysql_num_rows($proyectosxtipo);
		  while($pt=mysql_fetch_array($proyectosxtipo)){
			  $tipo = $pt['tipo'];
			  $cantidad = $pt['total_tipo'];
			  echo "['".$tipo." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#E74983', '#29B4D3'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxtipo'));
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
      <td align="center" class="factura-texto4">Tablero - 
	  <?php
      	switch ($mes) {
			case "01":
				echo "Enero";
				break;
			case "02":
				echo "Febrero";
        		break;
			case "03":
        		echo "Marzo";
        		break;
			case "04":
        		echo "Abril";
        		break;
			case "05":
        		echo "Mayo";
        		break;
			case "06":
        		echo "Junio";
        		break;
			case "07":
        		echo "Julio";
        		break;
			case "08":
        		echo "Agosto";
        		break;
			case "09":
        		echo "Septiembre";
        		break;
			case "10":
        		echo "Octubre";
        		break;
			case "11":
        		echo "Noviembre";
        		break;
			case "12":
        		echo "Diciembre";
        		break;
				}
			echo " ".$anio;
	  ?></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="0" class="sombra">
    <tr>
      <td width="235" align="center" bgcolor="#FFFFFF" style="padding-top:15px;">
        <span class="titulo"><?php echo $arrayproyectos->proyectos; ?></span><br/>
        <span class="factura-texto-min">Proyectos generados en el mes</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Proyectos</span><a href="estadisticas_proyectos.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span><br/>
      </td>
      <td width="5" rowspan="2" align="center" bgcolor="#FFFFFF">
      	<img src="imagenes/linea-400.png" width="1" height="80" />
      </td>
      <td width="190" align="center" bgcolor="#FFFFFF" style="padding-top:15px;"><span style="padding-top:10px; padding-bottom:10px;"><span class="titulo"><?php echo $arrayproyectos->finalizados; ?></span><br/>
          <span class="factura-texto-min">Proyectos Finalizados</span></span><br/>
      </td>
      <td width="190" align="center" bgcolor="#FFFFFF" style="padding-top:15px;">
        <span class="titulo"><?php echo $arrayproyectos->wins; ?></span><br/>
        <span class="factura-texto-min">Proyectos NEW WIN</span><br/>
      </td>
      <td width="190" align="center" bgcolor="#FFFFFF" style="padding-top:15px;">
        <span class="titulo"><?php echo $arrayproyectos->vendidos; ?></span><br/>
        <span class="factura-texto-min">Proyectos Vendidos</span><br/>
      </td>
      <td width="190" align="center" bgcolor="#FFFFFF" style="padding-top:15px;">
        <span class="titulo"><?php echo $arrayproyectos->novendidos; ?></span><br/>
        <span class="factura-texto-min">Proyectos No Vendidos</span><br/>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF" style="padding-top:10px; padding-bottom:10px;"><img src="imagenes/proyectos.png" width="40" height="40"/></td>
      <td align="center" bgcolor="#FFFFFF" style="padding-top:10px; padding-bottom:10px;"><img src="imagenes/finalizar.png" width="40" height="40" /></td>
      <td align="center" bgcolor="#FFFFFF" style="padding-top:10px; padding-bottom:10px;"><img src="imagenes/newwins.png" width="40" height="40" /></td>
      <td align="center" bgcolor="#FFFFFF" style="padding-top:10px; padding-bottom:10px;"><img src="imagenes/vendidos.png" width="40" height="40" /></td>
      <td align="center" bgcolor="#FFFFFF" style="padding-top:10px; padding-bottom:10px;"><img src="imagenes/bad.png" width="40" height="40" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center" bgcolor="#27A9E3" style="padding-top:2px; padding-bottom:2px;"></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Proyectos por Status del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
      	<br/>
        <?php
        if ($pxsn=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxstatus" style="width: 950px; height: 300px"></div>';
		}
		?>
      <br /></td>
    </tr>
  </table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Proyectos Finalizados en el mes</td>
    <td width="500" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
	<tr>
    	<td align="center" bgcolor="#FFFFFF">
        <br/>
        <table width="890" border="0" align="center" cellpadding="4" cellspacing="0">
        	<tr class="encabezado-tabla">
            	<td width="50">Folio</td>
                <td width="375">Nombre del Proyecto</td>
                <td width="250">Cliente / Prospecto</td>
                <td width="145">Status</td>
                <td width="70">Prioridad</td>
            </tr>
            <tr>
            	<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
            </tr>
        </table>
        <div id="finalizados" style="width:980px; height:220px; overflow-y:scroll;">
		<?php
        	if($numero_finalizados=="0"){
				echo '
				<br />
				<table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">No hay proyectos finalizados.</td>
					</tr>
				</table>';
				}
			else {
				echo '
				<table width="890" border="0" align="center" cellpadding="4" cellspacing="0">';
					while($fila=mysql_fetch_array($finalizados)){
						echo '
						<tr class="';
							switch ($fila['cierre_venta']){
								case "1":
									echo "celda-cierre-si";
									break;
								case "0":
									echo "celda-cierre-no";
									break;
								case "":
									echo "celda-activa2";
									break;
							}
						echo '">
							<td width="50">'.$fila['id_proyecto'].'</td>
							<td width="375">';
							switch ($fila['potencial']){
								case "1":
									echo "<img src='imagenes/alta.png' title='Potencial Alto'>";
									break;
								case "2":
									echo "<img src='imagenes/normal.png' title='Potencial Medio'>";
									break;
								case "3":
									echo "<img src='imagenes/baja.png' title='Potencial Bajo'>";
									break;
								}
						echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="tooltip"><span class="tooltiptext">Generado por '.$fila['generador'].' | '.$fila['fecha_generacion'].'</span>'.$fila['nombre_proyecto'].'</a></td>
							<td width="250">'.$fila['cliente'].'</td>
							<td width="145"><span class="';
								switch ($fila['status']) {
									case "Generado / Sin Asignar":
										echo "generado-sin";
										break;
									case "Autorizado":
										echo "autorizado";
										break;
									case "Generado / Asignado":
										echo "generado-asignado";
										break;
									case "En Desarrollo":
										echo "desarrollo";
										break;
									case "Rechazado":
										echo "rechazado";
										break;
									case "Muestra Entregada":
										echo "muestra";
										break;
									case "Enviado al Cliente":
										echo "cliente";
										break;
									case "Aprobado":
										echo "aprobado";
										break;
									case "No Aprobado":
										echo "noaprobado";
										break;
									case "Reformular":
										echo "reformular";
										break;
									case "Finalizado":
										echo "finalizado";
										break;
									case "Eliminado":
										echo "eliminado";
										break;
									case "Prueba Piloto":
										echo "prueba";
										break;
									case "Recotizar":
										echo "recotizar";
										break;
									case "Revisado":
										echo "revisado";
										break;
									case "Remuestreo":
										echo "remuestreo";
										break;
									}
						echo '">'.$fila['status'].'</span></td>
							<td width="70">';
							if ($fila['prioridad']=="Urgente")
							{
								echo "<span class='texto-urgente'>Urgente</span>";
								}
							else {
								echo $fila['prioridad'];
								}
						switch ($fila['prioridad'])
							{
								case 'Alta':
									echo "<img src='imagenes/alta.png'/>";
									break;
								case 'Baja':
									echo "<img src='imagenes/baja.png'/>";
									break;
								case 'Normal':
									echo "<img src='imagenes/normal.png'/>";
									break;
								case 'Urgente':
									echo "<img src='imagenes/urgente.png'/>";
									break;
							}
						echo '
							</td>
						</tr>
						<tr>
							<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>';
					}
					echo '</table>';
				}
			?>
      </div>
      <br />
      </td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Proyectos por Agente de Ventas del mes</td>
    <td width="500" class="factura-texto4">Proyectos por Desarrollador del mes</td>
  </tr>
</table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="495" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
          <br/>
		  <?php
        if ($pxan=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxagente" style="width: 490px; height: 250px;"></div>';
		}
		?>
          <br/></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="495" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
          <br/>
		  <?php
        if ($pxdn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxdes" style="width: 490px; height: 250px;"></div>';
		}
		?>
          
          <br/></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Proyectos por Segmento del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
      	<br/>
		<?php
        if ($pxsegn=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxseg" style="width: 950px; height: 300px"></div>';
		}
		?>
      <br/></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Proyectos por Categoría del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
      <br/>
	  <?php
        if ($pxcatn=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxcat" style="width: 950px; height: 300px"></div>';
		}
		?>
      <br/></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Proyectos por Potencial de Negocio del mes</td>
      <td width="500" class="factura-texto4">Proyectos por Tipo de Proyecto del mes</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="495" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
          <br/>
		  <?php
        if ($pxpn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxpotencial" style="width: 490px; height: 250px;"></div>';
		}
		?>
          <br/></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="495" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
          <br/>
		  <?php
        if ($pxtn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxtipo" style="width: 490px; height: 250px;"></div>';
		}
		?>
          <br/></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <?php
  if($tipo_usuario=="Administrador" AND $id_usuario<>"29"){
	  echo '
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Muestras del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="200" align="center"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:37px; padding-bottom:37px;"><table width="195" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td align="center">
              		<span class="titulo">'.$ms.'</span><br/>
               	  <span class="factura-texto-min">Muestras Solicitadas</span></td>
            </tr>
            <tr>
              <td align="center"><img src="imagenes/linea-400.png" width="170" height="1" /></td>
            </tr>
            <tr>
              <td align="center">
              		<span class="titulo">'.$me.'</span><br/>
               	  <span class="factura-texto-min">Muestras Entregadas</span></td>
            </tr>
            <tr>
              <td align="center"><img src="imagenes/linea-400.png" width="170" height="1" /></td>
            </tr>
            <tr>
              <td align="center"><span class="titulo">';
			  if($ms<=0)
			  {
				  $cum = 100;
			  }
			  else {
				  $cum = ($me * 100) / $ms;
			  }
			  echo number_format($cum,2,".",",");
			  echo '%</span><br/>
                <span class="factura-texto-min">de ';
                if($cum > 70)
					{
						echo "<span class='finalizado'>cumplimiento</span>";
					}
					elseif ($cum > 35){
						echo "<span class='cliente'>cumplimiento</span>";
					}
					else
					{
						echo "<span class='eliminado'>cumplimiento</span>";
					}
				echo '</span></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
      <td width="800" align="center"><table width="795" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px;">
          <table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr class="encabezado-tabla">
              <td width="90" align="center">Folio</td>
              <td width="410" align="center">Nombre del Proyecto</td>
              <td width="120" align="center">Muestras<br />Solicitadas</td>
              <td width="120" align="center">Muestras<br />Entregadas</td>
              <td width="40" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" align="center"><img src="imagenes/linea-800.png" width="760" height="1" /></td>
              </tr>
          </table>
          <div id="muestras" style="width:750px; height:185px; overflow-y:scroll;">';
          if($arrayproyectos->proyectos==0)
		  	{
				echo "<br/>No hay proyectos registrados.";
			}
		  else {
		  echo '<table width="730" border="0" align="center" cellpadding="4" cellspacing="0">';
          while($fila=mysql_fetch_array($estxpm))
		  {
			  echo '
			  <tr class="';
			  switch ($fila['cierre_venta'])
			  {
				  case "1":
				  	echo "celda-cierre-si";
					break;
				case "0":
					echo "celda-cierre-no";
					break;
				case "":
					echo "celda-activa2";
					break;
				}
			  echo '">
			  	<td width="70" align="center">'.$fila['id_proyecto'].'</td>
				<td width="410"><a href="proyecto.php?id='.$fila['id_proyecto'].'#solicitadas" class="tooltip"><span class="tooltiptext">Generado el '.$fila['fecha_generacion'].' | Segmento: '.$fila['segmento'].'</span>'.$fila['nombre_proyecto'].'</a></td>';
				$id_proyecto = $fila['id_proyecto'];
				$cantidades = "SELECT
				(SELECT IFNULL(SUM(cantidad),0) FROM tmmuestras WHERE id_proyecto = '$id_proyecto' AND origen = 'S') AS solicitadas,
				(SELECT IFNULL(SUM(cantidad),0) FROM tmmuestras WHERE id_proyecto = '$id_proyecto' AND origen = 'E') AS entregadas";
				$mcantidades=mysql_query($cantidades, $conexion) or die(mysql_error());
				$arraycantidades = mysql_fetch_object($mcantidades);
				echo '
				<td width="115" align="center">'.$arraycantidades->solicitadas.'</td>
				<td width="115" align="center">'.$arraycantidades->entregadas.'</td>
				<td width="10" align="center">';
				$cs = $arraycantidades->solicitadas;
				$ce = $arraycantidades->entregadas;
				if($cs < $ce)
					{
						echo "<img src='imagenes/alta.png'/>";
					}
					elseif ($cs == $ce){
						echo "<img src='imagenes/normal.png'/>";
					}
					else
					{
						echo "<img src='imagenes/baja.png'/>";
					}
				echo '</td>
			</tr>
		<tr>
			<td colspan="5"><img src="imagenes/linea-800.png" width="715" height="1" /></td>
		</tr>';
		}
		echo '</table>';
	}
echo '
	</div>
	</td>
	</tr>
	</table></td>
    </tr>
  </table>
  <br />';
  }
  else {
  }
  ?>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Seguimientos y comentarios del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td width="170" align="center" bgcolor="#FFFFFF" style="padding-top:30px; padding-bottom:30px;"><span class="titulo"><?php echo $arrayseguimientos->seguimientos; ?></span><br/>
        <span class="factura-texto-min">Seguimientos registrados</span></td>
      <td width="5" align="center" bgcolor="#FFFFFF"><img src="imagenes/linea-400.png" width="1" height="80" /></td>
      <td width="165" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->llamadas; ?></span><br/>
        <span class="llamada">Llamadas teléfonicas</span></td>
      <td width="165" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->correos; ?></span><br/>
        <span class="correo">Correos electrónicos</span></td>
      <td width="165" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->visitas; ?></span><br/>
        <span class="visita">Visitas presenciales</span></td>
      <td width="165" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->apoyos; ?></span><br/>
        <span class="apoyo">Apoyos técnicos</span></td>
      <td width="165" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->videoconferencias; ?></span><br/>
        <span class="videoconferencia">Videoconferencias</span></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td width="330" align="center" bgcolor="#FFFFFF" style="padding-top:30px; padding-bottom:30px;"><span class="titulo"><?php echo $arrayseguimientos->eventos; ?></span><br/>
        <span class="factura-texto-min">Eventos registrados</span></td>
      <td width="5" align="center" bgcolor="#FFFFFF"><img src="imagenes/linea-400.png" width="1" height="80" /></td>
      <td width="330" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->comentarios; ?></span><br/>
      <span class="factura-texto-min">Comentarios publicados</span></td>
      <td width="5" align="center" bgcolor="#FFFFFF"><img src="imagenes/linea-400.png" width="1" height="80" /></td>
      <td width="330" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayseguimientos->adjuntos; ?></span><br/>
      <span class="factura-texto-min">Archivos adjuntos</span></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Actividad en sistema del mes</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="0" class="sombra">
    <tr>
      <td width="250" align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px;">
      	<span class="titulo"><?php echo $arrayactividad->clientes; ?></span>
        	<br/>
        <span class="factura-texto-min">Clientes dados de alta</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Clientes</span><a href="estadisticas_clientes.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span>
      </td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->formulas; ?></span><br/>
      <span class="factura-texto-min">Fórmulas generadas</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Fórmulas</span><a href="estadisticas_formulas.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span></td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->insumos; ?></span><br/>
      <span class="factura-texto-min">Insumos datos de alta</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Insumos</span><a href="estadisticas_insumos.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span></td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->tcambio; ?></span><br/>
      <span class="factura-texto-min">registros de Tipo de Cambio</span><br/></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#2255A4" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#5F7C8A" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#FDCF07" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#48A623" style="padding-top:2px; padding-bottom:2px;"></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="0" class="sombra">
    <tr>
      <td width="250" align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px;"><span class="titulo"><?php echo $arrayactividad->proveedores; ?></span><br/>
        <span class="factura-texto-min">Proveedores dados de alta</span></td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->costos; ?></span><br/>
        <span class="factura-texto-min">Costos registrados</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Costos</span><a href="estadisticas_costos.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span></td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->cotizaciones; ?></span><br/>
        <span class="factura-texto-min">Cotizaciones generadas</span> <span class="tooltipm"><span class="tooltiptextm">Información gráfica de Cotizaciones</span><a href="estadisticas_cotizaciones.php#contenido"><img src="imagenes/viñeta-verde.png" width="16" height="16"/></a></span></td>
      <td width="250" align="center" bgcolor="#FFFFFF"><span class="titulo"><?php echo $arrayactividad->usuarios; ?></span><br/>
        <span class="factura-texto-min">Usuarios dados de alta</span><br/></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#196589" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#684B8D" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#D1266A" style="padding-top:2px; padding-bottom:2px;"></td>
      <td align="center" bgcolor="#DA542E" style="padding-top:2px; padding-bottom:2px;"></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td class="factura-texto4"><a name="reportes" id="reportes"></a>Reportes</td>
  </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
    <td bgcolor="#FFFFFF" align="center"><br />
    <form action="reporte.php" method="post">
      <table width="980" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="485" align="center" valign="top"><table width="470" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="454" align="center"><span class="titulo"><strong>1</strong></span></td>
            </tr>
            <tr>
              <td align="center">Seleccione el reporte:</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td><select name="reporte" class="textbox-login" id="reporte2" style="width:450px; height:30px;">
                <optgroup label="Proyectos">
                  <option value="p1">Proyectos por Agente de Ventas</option>
                  <option value="p10">Proyectos por Agente de Ventas conteo por Status</option>
                  <option value="p11">Proyectos por Agente de Ventas conteo por Potencial de Negocio</option>
                  <option value="p12">Proyectos por Agente de Ventas conteo por Tipo de Proyecto</option>
                  <option value="p13">Proyectos por Agente de Ventas conteo por Segmento</option>
                  <option value="p14">Proyectos por Agente de Ventas conteo por Categoría</option>
                  <option value="p15">Proyectos por Agente de Ventas conteo por Prioridad</option>
                  <option value="p16">Proyectos por Agente de Ventas conteo por Desarrollador</option>
                  <option value="p21">Proyectos por Agente de Ventas conteo por Cierre de Venta</option>
                  <option value="p23">Proyectos por Agente de Ventas conteo por Origen del Cliente</option>
                  <option value="p3">Proyectos por Status</option>
                  <option value="p4">Proyectos por Potencial de Negocio</option>
                  <option value="p5">Proyectos por Tipo de Proyecto</option>
                  <option value="p6">Proyectos por Segmento</option>
                  <option value="p7">Proyectos por Categoría</option>
                  <option value="p8">Proyectos por Prioridad</option>
                  <option value="p9">Proyectos por Desarrollador</option>
                  <option value="p17">Proyectos por Desarrollador conteo por Status</option>
                  <option value="p18">Proyectos por Desarrollador conteo por Segmento</option>
                  <option value="p19">Proyectos por Desarrollador conteo por Categoría</option>
                  <option value="p20">Proyectos por Desarrollador conteo por Agente de Ventas</option>
                  <option value="p22">Proyectos por Cierre de Venta</option>
                  <option value="p24">Proyectos por Origen del Cliente</option>
                  <option value="p2">Proyectos por Cliente</option>
                  <option value="p25">Proyectos por Tipo de Aprobación</option>
                  <option value="p26">Proyectos por Tipo de No Aprobación</option>
                  </optgroup>
              </select></td>
            </tr>
          </table></td>
          <td width="10" align="center" valign="middle"><img src="imagenes/linea-400.png" width="1" height="200" /></td>
          <td width="485" align="center" valign="top"><table width="470" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td colspan="2" align="center"><span class="titulo"><strong>2</strong></span></td>
            </tr>
            <tr>
              <td colspan="2" align="center">Seleccione el periodo:</td>
            </tr>
            <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td width="140" align="center">Fecha inicial</td>
              <td width="314" align="center"><span class="encabezado-tabla">
                <input type="date" name="fecha_inicial" id="fecha_inicial" class="textbox-med" required="required" autocomplete="off" value="2023-01-01" style="width:300px;"/>
              </span></td>
            </tr>
            <tr>
              <td align="center">Fecha final</td>
              <td align="center"><span class="encabezado-tabla">
                <input type="date" name="fecha_final" id="fecha_final" class="textbox-med" required="required" autocomplete="off" value="<?php echo $fecha; ?>" style="width:300px;"/>
              </span></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <br />
      <input name="generar" type="submit" class="boton-login" id="generar" value="Generar Reporte" />
      </form>
    <br/></td>
  </tr>
</table>
  <br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
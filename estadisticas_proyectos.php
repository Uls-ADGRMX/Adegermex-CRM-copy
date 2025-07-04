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
<!-- Grafico Proyectos X Status -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxstatus=mysql_query("SELECT status, COUNT(*) AS total_status FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY status ORDER BY total_status DESC",$conexion);
		  }
		  else {
			  $proyectosxstatus=mysql_query("SELECT status, COUNT(*) AS total_status FROM tmproyectos GROUP BY status ORDER BY total_status DESC",$conexion);
		  }
		  $pxsn=mysql_num_rows($proyectosxstatus);
		  while($ps=mysql_fetch_array($proyectosxstatus)){
			  $status = $ps['status'];
			  $cantidad = $ps['total_status'];
			  echo "['".$status." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxstatus'));
        chart.draw(data, options);
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
			  $proyectosxagente=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_agente FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario GROUP BY tcusuarios.nombre ORDER BY total_agente DESC",$conexion);
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
			  $proyectosxseg=mysql_query("SELECT tmproyectos.segmento, COUNT(*) AS total_seg FROM tmproyectos GROUP BY segmento ORDER BY segmento ASC",$conexion);
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
			colors: ['#7CC950'],
        };

        var chart = new google.charts.Bar(document.getElementById('proyectosxseg'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Proyectos X Cierre de Venta -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Cierre', 'Total Cierres'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxcierre=mysql_query("SELECT cierre_venta, COUNT(*) AS total_cierres FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY cierre_venta ORDER BY cierre_venta ASC",$conexion);
		  }
		  else {
			  $proyectosxcierre=mysql_query("SELECT cierre_venta, COUNT(*) AS total_cierres FROM tmproyectos GROUP BY cierre_venta ORDER BY cierre_venta ASC",$conexion);
		  }
  		  $pxcn=mysql_num_rows($proyectosxcierre);
		  while($pc=mysql_fetch_array($proyectosxcierre)){
			  if ($pc['cierre_venta']=="") { $cierre = "Sin Registrar"; }
			  if ($pc['cierre_venta']=="1") { $cierre = "Vendido"; }
  			  if ($pc['cierre_venta']=="0") { $cierre = "No Vendido"; }
			  $cantidad = $pc['total_cierres'];
			  echo "['".$cierre." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#3498DB', '#E74C3C', '#2ECC71'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('proyectosxcierre'));
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
			  $proyectosxdes=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_des FROM tmproyectos JOIN tcusuarios WHERE tmproyectos.id_usuasignado = tcusuarios.id_usuario GROUP BY tcusuarios.nombre ORDER BY total_des DESC",$conexion);
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
			  $proyectosxcat=mysql_query("SELECT tmproyectos.categoria, COUNT(*) AS total_cat FROM tmproyectos GROUP BY categoria ORDER BY categoria ASC",$conexion);
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
			colors: ['#23CE9A'],
        };

        var chart = new google.charts.Bar(document.getElementById('proyectosxcat'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
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
			  $proyectosxtipo=mysql_query("SELECT tipo, COUNT(*) AS total_tipo FROM tmproyectos GROUP BY tipo ORDER BY total_tipo DESC",$conexion);
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
			  $proyectosxpotencial=mysql_query("SELECT potencial, COUNT(*) AS total_potencial FROM tmproyectos GROUP BY potencial ORDER BY potencial ASC",$conexion);
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
<!-- Grafico Proyectos X Día -->
<script type="text/javascript">
      google.charts.load("current", {packages:["calendar"]});
      google.charts.setOnLoadCallback(drawChart);

   function drawChart() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $proyectosxdia=mysql_query("SELECT DATE_FORMAT(fecha_generacion, '%Y') AS anio, DATE_FORMAT(fecha_generacion, '%m') AS mes, DATE_FORMAT(fecha_generacion, '%d') AS dia, COUNT(*) AS total_dia FROM tmproyectos WHERE fecha_generacion BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY fecha_generacion ORDER BY fecha_generacion ASC",$conexion);
		  }
		  else {
			  $proyectosxdia=mysql_query("SELECT DATE_FORMAT(fecha_generacion, '%Y') AS anio, DATE_FORMAT(fecha_generacion, '%m') AS mes, DATE_FORMAT(fecha_generacion, '%d') AS dia, COUNT(*) AS total_dia FROM tmproyectos GROUP BY fecha_generacion ORDER BY fecha_generacion ASC",$conexion);
		  }
		  $pxdn=mysql_num_rows($proyectosxdia);
		  while($pdia=mysql_fetch_array($proyectosxdia)){
			  $anio = $pdia['anio'];
			  $mes = $pdia['mes'] - 1;
			  $dia = $pdia['dia'];
			  $cantidad = $pdia['total_dia'];
			  echo "[ new Date(".$anio.",".$mes.",".$dia."), ".$cantidad."],";
		  }
		  ?>
        ]);
       var chart = new google.visualization.Calendar(document.getElementById('proyectosxdia'));
       var options = {
		 calendar: {
	      daysOfWeek: 'DLMMJVS',
		 }
       };
       chart.draw(dataTable, options);
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
      <form action="estadisticas_proyectos.php?p=1#contenido" method="post">
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
      <td width="500" class="factura-texto4">Proyectos por Status</td>
      <td width="500" class="factura-texto4">Proyectos por Agente de Ventas</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($pxsn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxstatus" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
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
            <br /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td width="500" class="factura-texto4">Proyectos por Segmento</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br/>
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
    <td width="500" class="factura-texto4">Proyectos por Cierre de Venta</td>
    <td width="500" class="factura-texto4">Proyectos por Desarrollador</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
          <?php
        if ($pxcn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxcierre" style="width: 490px; height: 250px;"></div>';
		}
		?>
          <br /></td>
      </tr>
    </table></td>
    <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
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
          <br /></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Proyectos por Categoría</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br/>
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
    <td width="500" class="factura-texto4">Proyectos por Tipo de Proyecto</td>
    <td width="500" class="factura-texto4">Proyectos por Potencial de Negocio</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
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
          <br /></td>
      </tr>
    </table></td>
    <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
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
          <br /></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4">Proyectos generados por día</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF" align="center"><br/>
		<?php
        if ($pxdn=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="proyectosxdia" style="width: 950px; height: 350px;"></div>';
		}
		?>
        <br/>
      </td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
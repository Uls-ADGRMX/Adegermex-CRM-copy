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
<!-- Grafico Fórmulas X Status -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $formulasxstatus=mysql_query("SELECT status, COUNT(*) AS total_status FROM tmformulas WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY status ORDER BY total_status DESC",$conexion);
		  }
		  else {
			  $formulasxstatus=mysql_query("SELECT status, COUNT(*) AS total_status FROM tmformulas GROUP BY status ORDER BY total_status DESC",$conexion);
		  }
		  $fxsn=mysql_num_rows($formulasxstatus);
		  while($fs=mysql_fetch_array($formulasxstatus)){
			  $status = $fs['status'];
			  $cantidad = $fs['total_status'];
			  echo "['".$status." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#28B463', '#E74C3C'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('formulasxstatus'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Fórmulas X Desarrollador -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Desarrollador', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $formulasxdesarrollador=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_des FROM tmformulas JOIN tcusuarios WHERE tmformulas.id_usuario = tcusuarios.id_usuario AND tmformulas.fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tcusuarios.nombre ORDER BY total_des DESC",$conexion);
		  }
		  else {
			  $formulasxdesarrollador=mysql_query("SELECT tcusuarios.nombre, COUNT(*) AS total_des FROM tmformulas JOIN tcusuarios WHERE tmformulas.id_usuario = tcusuarios.id_usuario GROUP BY tcusuarios.nombre ORDER BY total_des DESC",$conexion);
		  }
		  $fxdn=mysql_num_rows($formulasxdesarrollador);
		  while($fd=mysql_fetch_array($formulasxdesarrollador)){
			  $desarrollador = $fd['nombre'];
			  $cantidad = $fd['total_des'];
			  echo "['".$desarrollador." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
        };
        var chart = new google.visualization.PieChart(document.getElementById('formulasxdesarrollador'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Fórmulas X Tipo -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $formulasxtipo=mysql_query("SELECT master, COUNT(*) AS total_tipo FROM tmformulas WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY master ORDER BY total_tipo DESC",$conexion);
		  }
		  else {
			  $formulasxtipo=mysql_query("SELECT master, COUNT(*) AS total_tipo FROM tmformulas GROUP BY master ORDER BY total_tipo DESC",$conexion);
		  }
		  $fxtn=mysql_num_rows($formulasxtipo);
		  while($ft=mysql_fetch_array($formulasxtipo)){
			  if ($ft['master']=="0") { $tipo = "Fórmula de Desarrollo"; }
			  if ($ft['master']=="1") { $tipo = "Fórmula Maestra"; }
			  $cantidad = $ft['total_tipo'];
			  echo "['".$tipo." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#F39C12', '#3498DB'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('formulasxtipo'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Fórmulas X Origen -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Origen', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $formulasxorigen=mysql_query("SELECT id_proyecto, COUNT(*) AS total_origen FROM tmformulas WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY id_proyecto ORDER BY total_origen DESC",$conexion);
		  }
		  else {
			  $formulasxorigen=mysql_query("SELECT id_proyecto, COUNT(*) AS total_origen FROM tmformulas GROUP BY id_proyecto ORDER BY total_origen DESC",$conexion);
		  }
		  $fxon=mysql_num_rows($formulasxorigen);
		  while($fo=mysql_fetch_array($formulasxorigen)){
			  if ($fo['id_proyecto']=="0") { $origen = "Fórmula Directa"; } else { $origen = "Fórmula de Proyecto"; }
			  $cantidad = $fo['total_origen'];
			  echo "['".$origen." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#29C7AF', '#498BCD'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('formulasxorigen'));
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
      <form action="estadisticas_formulas.php?p=1#contenido" method="post">
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
      <td width="500" class="factura-texto4">Fórmulas por Status</td>
      <td width="500" class="factura-texto4">Fórmulas por Desarrollador</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($fxsn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="formulasxstatus" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($fxdn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="formulasxdesarrollador" style="width: 490px; height: 250px;"></div>';
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
      <td width="500" class="factura-texto4">Fórmulas por Tipo</td>
      <td width="500" class="factura-texto4">Fórmulas por Origen</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($fxtn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="formulasxtipo" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($fxon=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="formulasxorigen" style="width: 490px; height: 250px;"></div>';
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
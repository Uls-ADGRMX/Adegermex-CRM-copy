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
<!-- Grafico Clientes X País -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['País', 'Clientes'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $clientesxpais=mysql_query("SELECT tcclientes.pais, COUNT(*) AS total_pais FROM tcclientes WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY pais ORDER BY pais ASC",$conexion);
		  }
		  else {
			  $clientesxpais=mysql_query("SELECT tcclientes.pais, COUNT(*) AS total_pais FROM tcclientes GROUP BY pais ORDER BY pais ASC",$conexion);
		  }
		  $cxpi=mysql_num_rows($clientesxpais);
		  while($ci=mysql_fetch_array($clientesxpais)){
			  $pais = $ci['pais'];
			  $cantidad = $ci['total_pais'];
			  echo "['".$pais."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#ED4545'],
        };

        var chart = new google.charts.Bar(document.getElementById('clientesxpais'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
<!-- Grafico Clientes X Tipo -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $clientesxtipo=mysql_query("SELECT tipo, COUNT(*) AS total_tipo FROM tcclientes WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY tipo ORDER BY total_tipo DESC",$conexion);
		  }
		  else {
			  $clientesxtipo=mysql_query("SELECT tipo, COUNT(*) AS total_tipo FROM tcclientes GROUP BY tipo ORDER BY total_tipo DESC",$conexion);
		  }
		  $cxtn=mysql_num_rows($clientesxtipo);
		  while($ct=mysql_fetch_array($clientesxtipo)){
			  $tipo = $ct['tipo'];
			  $cantidad = $ct['total_tipo'];
			  echo "['".$tipo." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#55BB2F', '#33A8CD'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('clientesxtipo'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Clientes X Pertenece a -->
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Pertenece', 'Cantidad'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $clientesxpertenece=mysql_query("SELECT pertenece, COUNT(*) AS total_pertenece FROM tcclientes WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY pertenece ORDER BY total_pertenece DESC",$conexion);
		  }
		  else {
			  $clientesxpertenece=mysql_query("SELECT pertenece, COUNT(*) AS total_pertenece FROM tcclientes GROUP BY pertenece ORDER BY total_pertenece DESC",$conexion);
		  }
		  $cxpn=mysql_num_rows($clientesxpertenece);
		  while($cp=mysql_fetch_array($clientesxpertenece)){
			  $pertenece = $cp['pertenece'];
			  $cantidad = $cp['total_pertenece'];
			  echo "['".$pertenece." (".$cantidad.")"."',".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
          pieHole: 0.4,
		  chartArea:{left:10,top:10,width:'100%',height:'90%'},
		  is3D: false,
		  colors: ['#559FE5', '#76CFB0'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('clientesxpertenece'));
        chart.draw(data, options);
      }
    </script>
<!-- Grafico Clientes X Origen -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Origen', 'Clientes'],
		  <?php
		  if ($p==1 AND $fr==0)
		  {
			  $clientesxorigen=mysql_query("SELECT tcclientes.origen, COUNT(*) AS total_ori FROM tcclientes WHERE fecha_alta BETWEEN '$fecha_inicial' AND '$fecha_final' GROUP BY origen ORDER BY origen ASC",$conexion);
		  }
		  else {
			  $clientesxorigen=mysql_query("SELECT tcclientes.origen, COUNT(*) AS total_ori FROM tcclientes GROUP BY origen ORDER BY origen ASC",$conexion);
		  }
		  $cxon=mysql_num_rows($clientesxorigen);
		  while($co=mysql_fetch_array($clientesxorigen)){
			  $origen = $co['origen'];
			  $cantidad = $co['total_ori'];
			  echo "['".$origen."', ".$cantidad."],";
		  }
		  ?>
        ]);
        var options = {
			legend: { position: 'none' },
			axes: { x: { 0: { side: 'top', label: ''} }},
			colors: ['#F1B430'],
        };

        var chart = new google.charts.Bar(document.getElementById('clientesxorigen'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
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
      <form action="estadisticas_clientes.php?p=1#contenido" method="post">
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
      <td width="500" class="factura-texto4">Clientes por País</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br/>
        <?php
        if ($cxpi=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="clientesxpais" style="width: 950px; height: 300px"></div>';
		}
		?>
        <br/></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Clientes por Tipo</td>
      <td width="500" class="factura-texto4">Clientes por Pertenece a</td>
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
			echo '<div id="clientesxtipo" style="width: 490px; height: 250px;"></div>';
		}
		?>
            <br /></td>
        </tr>
      </table></td>
      <td width="500" align="center"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <?php
        if ($cxpn=="0") {
			echo '<table width="480" height="250px;" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="clientesxpertenece" style="width: 490px; height: 250px;"></div>';
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
      <td width="500" class="factura-texto4">Clientes por Origen</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br/>
        <?php
        if ($cxon=="0") {
			echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay información para generar el gráfico.</td>
        </tr></table>';
		}
		else {
			echo '<div id="clientesxorigen" style="width: 950px; height: 300px"></div>';
		}
		?>
        <br/></td>
    </tr>
  </table>
  <br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
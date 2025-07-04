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
// Validación de Tipo de Cambio registrado ////////////
///////////////////////////////////////////////////////
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$cambiohoy_num=mysql_num_rows($cambiohoy);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Tipo de Cambio</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Grafico de Comportamiento -->
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Pesos Mexicanos (MXN - $)'],
		  <?php
		  $tcreg=mysql_query("SELECT * FROM tctcambio ORDER BY fecha_alta ASC",$conexion);
		  while($fg=mysql_fetch_array($tcreg)){
			  $fecha_tc = $fg['fecha_alta'];
			  $valor_tc = $fg['valor'];
			  echo "['".$fecha_tc."',".$valor_tc."],";
		  }
		  ?>
        ]);

        var options = {
			colors: ['#48A623'],
			title: 'Comportamiento del Tipo de Cambio (MXN -> USD)',
			curveType: 'function',
			legend: { position: 'right' },
			vAxis: { title: 'Costo', titleTextStyle: {italic: false, color: '#666'}, textStyle: {fontName: 'Verdana', fontSize: 11}},
			hAxis: { title: 'Fecha',titleTextStyle: {italic: false, color: '#666'},textStyle: {fontName: 'Verdana',fontSize: 11}
	  },
};
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#48A623">&nbsp;</td>
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
    <td align="center" class="titulo">Tipo de Cambio</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Tipo de Cambio Actual</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <br />
    <?php
	if ($cambiohoy_num=="0") {
		echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td align="center"><img src="imagenes/moneda.png" width="180" height="180" /></td>
			</tr>
			<tr>
				<td align="center" class="factura-texto2">No hay registro de <strong>Tipo de Cambio</strong> del día de Hoy.</td>
			</tr>
		</table>'; }
		else {
			$arraythoy = mysql_fetch_object($cambiohoy);
			$valor = $arraythoy->valor;
			echo '<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="475" align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td align="center">El tipo de cambio definido para hoy es:</td>
            </tr>
            <tr>
              <td align="center" class="titulo"><strong>$ '.$valor.' MXN <img src="imagenes/mexico.png" width="41" height="30" /></strong></td>
            </tr>
            <tr>
              <td align="center" class="subtitulo">por Dólar Americano (USD - $) <img src="imagenes/usa-min.png" width="17" height="13" /></td>
            </tr>
          </table>
            <br />
            <table width="450" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="center" class="titulo"><strong>$ '.number_format(1/$valor,4,".",",").' USD <img src="imagenes/usa.png" width="40" height="30" /></strong></td>
              </tr>
              <tr>
                <td align="center" class="subtitulo">por Peso Mexicano (MXN - $) <img src="imagenes/mexico-min.png" width="16" height="12" /></td>
              </tr>
          </table></td>
          <td width="475" valign="top"><table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="3" align="center"><strong>Guía de Conversión</strong></td>
            </tr>
            <tr>
              <td colspan="3" align="center"><img src="imagenes/linea-400.png" width="400" height="1" /></td>
            </tr>
            <tr class="celda-activa2">
              <td width="150" align="right" class="subtitulo">$ 5 USD</td>
              <td width="76" align="center" class="subtitulo">=</td>
              <td width="150" class="subtitulo">$ '.number_format($valor*5,4,".",",").' MXN</td>
            </tr>
            <tr class="celda-activa2">
              <td align="right" class="subtitulo">$ 10 USD</td>
              <td align="center" class="subtitulo">=</td>
              <td class="subtitulo">$ '.number_format($valor*10,4,".",",").' MXN</td>
            </tr>
            <tr class="celda-activa2">
              <td align="right" class="subtitulo">$ 50 USD</td>
              <td align="center" class="subtitulo">=</td>
              <td class="subtitulo">$ '.number_format($valor*50,4,".",",").' MXN</td>
            </tr>
            <tr class="celda-activa2">
              <td align="right" class="subtitulo">$ 100 USD</td>
              <td align="center" class="subtitulo">=</td>
              <td class="subtitulo">$ '.number_format($valor*100,4,".",",").' MXN</td>
            </tr>
            <tr class="celda-activa2">
              <td align="right" class="subtitulo">$ 500 USD</td>
              <td align="center" class="subtitulo">=</td>
              <td class="subtitulo">$ '.number_format($valor*500,4,".",",").' MXN</td>
            </tr>
            <tr class="celda-activa2">
              <td align="right" class="subtitulo">$ 1,000 USD</td>
              <td align="center" class="subtitulo">=</td>
              <td class="subtitulo">$ '.number_format($valor*1000,4,".",",").' MXN</td>
            </tr>
          </table></td>
        </tr>
        </table>';
		};
?>
    <br /></td>
  </tr>
</table>
<?php
if ($cambiohoy_num=="0") {
	 echo '
<br /><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="registrar" id="registrar"></a>Registrar Tipo de Cambio</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <form action="engines/registrar_tcambio.php" method="post"><table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="260" align="center"><span class="titulo"><strong><img src="imagenes/usa.png" width="40" height="30" /></strong></span></td>
          <td width="280" align="center" class="encabezado-tabla">equivale el día de hoy a <input type="hidden" value="'.$id_usuario.'" id="id_usuario" name="id_usuario"></td>
          <td width="260" align="center"><img src="imagenes/mexico.png" width="41" height="30" /></td>
        </tr>
        <tr>
          <td align="center" class="titulo"><strong>1</strong></td>
          <td rowspan="2" align="center"><img src="imagenes/linea-conversion.png" width="280" height="45" /></td>
          <td align="center"><input name="valor" type="number" class="textbox-min-moneda" id="valor" min="0.0001" step="0.0001" value="21.0000" required="required"/></td>
          </tr>
        <tr>
          <td align="center" class="encabezado-tabla">Dólar Americano (USD - $)</td>
          <td align="center" class="encabezado-tabla">Pesos Mexicanos (MXN - $)</td>
        </tr>
		<tr>
          <td align="center" colspan="3"><br/>';
		  
		  echo "<span class='subtitulo'>Consulte el tipo de cambio indicado por <a href='http://www.banxico.org.mx/' target='_blank'>Banco de México</a> como referencia.<br/>Puede consultar también la referencia del <a href='https://www.dof.gob.mx/indicadores.php' target='_blank'>Diario Oficial de la Federación</a>.</span>";
		  echo '</td>
        </tr>
    </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Registrar Tipo de Cambio" /></td>
        </tr>
      </table></form><br /></td>
  </tr>
</table>';}
else {}
?>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Gráfico de Comportamiento</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br/>
<?php
$tcambio=mysql_query("SELECT * FROM tctcambio ORDER BY fecha_alta DESC LIMIT 15",$conexion);
$numero_tcambio=mysql_num_rows($tcambio);
	if ($numero_tcambio==0){
		echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay registros de <strong>Tipo de Cambio</strong> para generar el gráfico.</td>
        </tr></table>';
	}
	else {
		echo '<table width="950" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div id="curve_chart" style="width: 950px; height: 350px"></div></td>
        </tr>
      </table>';
	}
	?>
<br/></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Últimos 15 registros de Tipo de Cambio</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br /><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br/>
<?php
if ($numero_tcambio=="0") { echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/oops.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Tipo de Cambio</strong> para mostrar.</td>
      </tr>
    </table>';
	}
	else
	{
	echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr class="encabezado-tabla">
          <td width="70">Folio</td>
          <td width="140">Fecha</td>
          <td width="170">Moneda de Origen ( 1 )</td>
          <td width="230">Tipo de Cambio</td>
          <td width="180">Capturado por</td>
          <td width="20">&nbsp;</td>
        </tr>';
		while($fila=mysql_fetch_array($tcambio)){
			echo '
        <tr>
          <td colspan="6"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
        </tr>
        <tr class="celda-activa">
          <td>'.$fila['id_tcambio'].'</td>
          <td>'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
          <td>Dólar Americano <img src="imagenes/usa-min.png" width="17" height="13" /></td>
          <td><strong>'.$fila['valor'].'</strong> Pesos Mexicanos <img src="imagenes/mexico-min.png" width="16" height="12" /></td>';
		  $id_usucaptura = $fila['id_usuario'];
		  $capturador = mysql_query("SELECT nombre FROM tcusuarios WHERE id_usuario=$id_usucaptura", $conexion);
		  $arraycapturador = mysql_fetch_object($capturador);
		  echo '<td>'.$arraycapturador->nombre.'</td>';
		  echo '<td>';
		  if (($fila['id_usuario']==$id_usuario OR $tipo_usuario=="Administrador") AND $fila['fecha_alta']==$fecha)
		  {
			  echo '<a href="engines/eliminar_tcambio.php?id='.$fila['id_tcambio'].'"><img src="imagenes/wrong.png" width="16" height="16" title="Eliminar"/></a>';
		  }
		  else {
			echo '&nbsp;';  
		  }
		  echo '</td></tr>';
		}
		echo '</table>';
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
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
// Consulta para información del Insumo ///////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$insumo = "SELECT * FROM tcinsumos WHERE id_insumo='$id'";
$info=mysql_query($insumo, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Insumos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Costo (MXN - $)', 'Costo (USD - $)'],
		  <?php
		  $costoxinsumo=mysql_query("SELECT * FROM tmcostos WHERE id_insumo='$id' AND (incrementables='0' OR incrementables='2')",$conexion);
		  $numerocostos=mysql_num_rows($costoxinsumo);
		  while($costos=mysql_fetch_array($costoxinsumo)){
			  $fcosto = $costos['fecha_alta'];
			  $pcosto = $costos['valor_pesos'];
			  $dcosto = $costos['valor_dolares'];
			  echo "['".$fcosto."',".$pcosto.", ".$dcosto."],";
		  }
		  ?>
        ]);

        var options = {
			colors: ['#48A623', '#47689F'],
          title: 'Comportamiento del costo del insumo <?php echo $infoarray->nombre; ?>',
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#FFB848">&nbsp;</td>
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
    <td align="center" class="titulo">Insumos</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Información General</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><span class="titulo"><?php echo $infoarray->nombre; ?>&nbsp;</span><br/><span class="subtitulo">( Código: <?php echo $infoarray->codigo; ?> )</span></td>
      </tr>
    </table>
      <br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="4" class="encabezado-tabla"><img src="imagenes/linea-950.png" width="900" height="1" /></td>
          </tr>
        <tr>
          <td width="225" class="encabezado-tabla">Fecha de Alta</td>
          <td width="225" class="subtitulo"><?php echo $infoarray->fecha_alta.' | '.$infoarray->hora_alta.' horas'; ?></td>
          <td width="225" class="encabezado-tabla">Categoría</td>
          <td width="225" class="subtitulo"><?php echo $infoarray->categoria; ?></td>
        </tr>
        <tr>
          <td class="encabezado-tabla">Código  del Proveedor</td>
          <td class="subtitulo"><?php echo $infoarray->codigo_proveedor; ?></td>
          <td class="encabezado-tabla">Origen</td>
          <td class="subtitulo"><?php echo $infoarray->origen; ?></td>
        </tr>
        <tr>
          <td class="encabezado-tabla">Unidad de Medida</td>
          <td class="subtitulo"><?php echo $infoarray->unidad_medida; ?></td>
          <td class="encabezado-tabla">Tipo</td>
          <td class="subtitulo"><?php echo $infoarray->tipo; ?></td>
        </tr>
        <tr>
          <td valign="top" class="encabezado-tabla">Comentario</td>
          <td colspan="3" valign="top" class="subtitulo"><?php echo $infoarray->comentario; ?></td>
          </tr>
        <tr>
          <td colspan="4" class="encabezado-tabla"><img src="imagenes/linea-950.png" width="900" height="1" /></td>
          </tr>
      </table>
      <br />
      <?php
	 if ($numerocostos==0){
		 echo '<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><strong>Este insumo no tiene costos registrados.</strong></td>
        </tr>
</table>';
		}
	else
		{
	 $cactual=mysql_query("SELECT tmcostos.*, tcusuarios.nombre FROM tmcostos JOIN tcusuarios WHERE tmcostos.id_usuario = tcusuarios.id_usuario AND id_insumo='$id' AND (incrementables='0' OR incrementables='2') ORDER BY id_costo DESC LIMIT 1", $conexion) or die(mysql_error());
	 $actualarray=mysql_fetch_object($cactual);
	 echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td colspan="3" align="center" class="factura-texto-min"><strong class="subtitulo">El costo actual de este insumo es de</strong></td>
        </tr>
        <tr>
          <td width="210" align="center"><span class="titulo"><strong>$ '.number_format($actualarray->valor_pesos,4,".",",").'</strong></span><br />
            (MXN - $) <img src="imagenes/mexico-min.png" width="16" height="12" />'; if ($actualarray->moneda=="1") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
          <td width="280" align="center"><img src="imagenes/linea-conversion.png" width="280" height="45" />
		  </td>
          <td width="210" align="center"><strong><span class="titulo">$ '.number_format($actualarray->valor_dolares,4,".",",").'</span></strong><br />
            (USD - $) <img src="imagenes/usa-min.png" width="17" height="13" />'; if ($actualarray->moneda=="2") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><img src="imagenes/avatar'.$actualarray->id_usuario.'.png" width="80" height="80" /></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo">lo indicó <strong>'.$actualarray->nombre.'</strong> el día <strong>'.$actualarray->fecha_alta.'</strong> a las <strong>'.$actualarray->hora_alta.'</strong> horas.<br /><br /></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><strong>Incoterm:</strong> '.$actualarray->incoterm.', <strong>País:</strong> '.$actualarray->pais.', <strong>Ciudad:</strong> '.$actualarray->ciudad.', <strong>Cantidad a importar:</strong> '.$actualarray->cantidad.' kilogramos, <strong>Tipo de transporte:</strong> '.$actualarray->transporte.'</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><img src="imagenes/comentario.png" width="15" height="12" /> <strong>Comentario:</strong> '.$actualarray->comentario.'</td>
        </tr>';
		if ($actualarray->incrementables=="2")
		{
			echo '
			<tr>
				<td colspan="3" align="center"><img src="imagenes/linea-800.png" width="750"></td>
			</tr>
			<tr>
				<td colspan="3" align="center" class="subtitulo">El costo <span class="finalizado">Incluye incrementables</span> registrados por el usuario <strong>';
		  		$usuinc = $actualarray->id_usuincrementa;
				$datos3=mysql_query("SELECT * FROM tcusuarios WHERE id_usuario=$usuinc", $conexion) or die(mysql_error());
				$arranombre = mysql_fetch_object($datos3);
				echo $arranombre->nombre;
				echo '</strong> el día <strong>'.$actualarray->fecha_altai.'</strong> a las <strong>'.$actualarray->hora_altai.'</strong> horas.</td>
			</tr>
			<tr>';
			if ($actualarray->moneda=="2") {
				echo '<td align="center" colspan="3" class="subtitulo">Costo registrado: $ '.number_format($actualarray->c_dolares,4,".",",").' <img src="imagenes/usa-min.png"> + Costo incrementables: $ '.number_format($actualarray->cinc_dolares,4,".",",").' <img src="imagenes/usa-min.png"></td>';
			}
			else {
				echo '<td align="center" colspan="3" class="subtitulo">Costo registrado: $ '.number_format($actualarray->c_pesos,4,".",",").' <img src="imagenes/mexico-min.png"> + Costo incrementables: $ '.number_format($actualarray->cinc_pesos,4,".",",").' <img src="imagenes/mexico-min.png"></td>';
			}
			echo '
			<tr>
				<td colspan="3" align="center" class="subtitulo"><img src="imagenes/comentario.png" width="15" height="12" /> <strong>Comentario:</strong> '.$actualarray->comentarioi.'</td>
			</tr>';
		}
		else {
			}
		echo '
			</td>
		</tr>
		</table>';
		}
	?>
      <br /></td>
  </tr>
</table>
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
      if ($numerocostos==0){
		echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/grafico.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay registros de <strong>Costos</strong> para generar el gráfico.</td>
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
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Últimos costos registrados para este Insumo</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
<?php
if ($numerocostos==0){
	echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td align="center"><img src="imagenes/costos.png" width="180" height="180" /></td>
		</tr>
		<tr>
			<td align="center" class="factura-texto2">No hay registros de <strong>Costos</strong> para este insumo.</td>
		</tr></table>';
		}
	else
		{
			$coslist=mysql_query("SELECT * FROM tmcostos WHERE id_insumo='$id' AND (incrementables='0' OR incrementables='2') ORDER BY id_costo DESC LIMIT 20",$conexion);
			echo '<br/><table width="950" border="0" cellspacing="0" cellpadding="4">
			<tr class="encabezado-tabla">
			<td width="150"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
			<td width="100"><img src="imagenes/mexico-min.png" width="16" height="12" /> Costo</td>
			<td width="100"><img src="imagenes/usa-min.png" width="17" height="13" /> Costo</td>
			<td width="90">T.C. Aplicado</td>
			<td width="340">Proveedor</td>
			<td width="150">Capturado por</td>
			<td width="20">&nbsp;</td>
			</tr>';
		  	while($lista=mysql_fetch_array($coslist)){
				echo '
				<tr>
				<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
				</tr>
				<tr class="celda-activa">
				<td valign="top">'.$lista['fecha_alta'].' | '.$lista['hora_alta'].'</td>
				<td valign="top"><strong>$ '.number_format($lista['valor_pesos'],4,".",",").' </strong>'; if ($lista['moneda']=="1") {echo '<img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
				<td valign="top"><strong>$ '.number_format($lista['valor_dolares'],4,".",",").' </strong>'; if ($lista['moneda']=="2") {echo '<img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
				<td valign="top">$ '.number_format($lista['tcaplicado'],4,".",",").'</td>
				<td valign="top">';
				$idpro = $lista['id_proveedor'];
				$proveedor = "SELECT * FROM tcproveedores WHERE id_proveedor=$idpro";
				$datos=mysql_query($proveedor, $conexion) or die(mysql_error());
				$arraypro = mysql_fetch_object($datos);
				echo '<a href="proveedor.php?id='.$idpro.'#contenido" class="link">'.$arraypro->nombre.'</a>';
				echo' </td>
				<td valign="top">';
				$idusucosto = $lista['id_usuario'];
				$usucosto = "SELECT * FROM tcusuarios WHERE id_usuario=$idusucosto";
				$datos=mysql_query($usucosto, $conexion) or die(mysql_error());
				$arrayusucosto = mysql_fetch_object($datos);
				echo $arrayusucosto->nombre;
				echo '</td>';
				echo '<td>';
				if ($lista['incrementables']=="2") { echo '<img src="imagenes/alta.png" title="Incluye Incrementables">'; } else {}
				echo '</td>';
				echo '</tr>';
				}
			echo '</table><br/>';
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
<?php
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
include 'scripts/conexion.php';
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$nombre = $arrayusuario->nombre;
$tipo_usuario = $arrayusuario->tipo_usuario;
$departamento = $arrayusuario->departamento;
if (empty($_POST['id_insumo']) OR $_POST['id_insumo']=="0")
{
	$vacio = "1";
}
else {
$vacio = "0";
$id_insumo = $_POST['id_insumo'];
$ninsumo=mysql_query("SELECT nombre FROM tcinsumos WHERE id_insumo='$id_insumo'",$conexion);
$nomins = mysql_fetch_object($ninsumo);
if (empty($_POST['valor']) OR $_POST['valor']=="0")
{
	$valor = "1";
}
else {
	$valor = $_POST['valor'];
}
$moneda = $_POST['moneda'];
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$arraythoy = mysql_fetch_object($cambiohoy);
$tchoy = $arraythoy->valor;
if ($moneda =="1")
{
	$cossimp = $valor;
	$cossimd = $valor / $tchoy;
}
if ($moneda =="2")
{
	$cossimp = $valor * $tchoy;
	$cossimd = $valor;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Simulador</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#27A495">&nbsp;</td>
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
    <td align="center" class="titulo">Simulador</td>
  </tr>
</table>
<br />
<div class="tabcontent">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Generalidades</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table><br/>
<?php
if ($vacio=="1")
{
	echo '
	  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/insumo.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">El <strong>Insumo</strong> ingresado para la simulación es incorrecto.<br/>Verifique el código o nombre y <a href="simulador.php#contenido">vuelva a intentarlo</a>.</td>
      </tr>
    </table><br/>
	</td></tr>
	</table>';}
else {
	echo '
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td align="center" class="factura-texto3"><img src="imagenes/insumo_detalle.png" width="100" height="100"/><br/><strong class="factura-texto4">'.$nomins->nombre.'</strong></td>
          </tr>
          <tr>
            <td><table width="650" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr>
                <td colspan="2" align="center" class="subtitulo">El costo simulado para el insumo es:</td>
              </tr>
              <tr>
                <td><table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
                  <tr>
                    <td align="center"><strong><span class="factura-texto4"><img src="imagenes/mexico.png" width="41" height="30" /><br />
                      </span></strong></td>
                  </tr>
                  <tr>
                    <td align="center"><span class="factura-texto4"><strong>$ '.number_format($cossimp,4,".",",").' MXN</strong></span></td>
                  </tr>
                </table></td>
                <td><table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
                  <tr>
                    <td align="center"><strong><span class="factura-texto4"><img src="imagenes/usa.png" width="40" height="30" /><br />
                    </span></strong></td>
                  </tr>
                  <tr>
                    <td align="center"><span class="factura-texto4"><strong>$ '.number_format($cossimd,4,".",",").' USD</strong></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="subtitulo">por el Tipo de Cambio aplicado de: <strong>$ '.$tchoy.'</strong></td>
              </tr>
            </table></td>
          </tr>
        </table>
      <br /></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Resultados de la Simulación</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br/>';
$formulas=mysql_query("SELECT DISTINCT(tmcomponentes.id_formula), tmformulas.nombre_formula, tmformulas.codigo_interno, tmformulas.fecha_alta, tmformulas.hora_alta, tmformulas.status
FROM tmcomponentes
JOIN tmformulas
WHERE tmformulas.id_formula = tmcomponentes.id_formula AND tmformulas.master='1' AND tmcomponentes.id_insumo='$id_insumo' ORDER BY tmformulas.id_formula ASC",$conexion);
$numero_formulas=mysql_num_rows($formulas);
if ($numero_formulas=="0")
{
	echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/insumo.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">El <strong>Insumo</strong> seleccionado, no se encuentra actualmente en las formulaciones.<br/>Intente <a href="simulador.php#detalles">nuevamente</a> con otro Insumo.</td>
      </tr>
    </table>';
}
else
{
	echo '<br/><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mensaje-notificacion">Las cantidades resultantes de la simulación se expresan en <strong>Pesos Mexicanos (MXN)</strong> y redondeo a 4 dígitos.</td>
  </tr>
</table><br/>';
while($ff=mysql_fetch_array($formulas)){
	$idf = $ff['id_formula'];
	echo '<br/><table width="970" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr bgcolor="#E8E8E8">
				<td align="center"><strong><span class="factura-texto3">'.$ff['nombre_formula'].'</span></strong></td>
			</tr>
			<tr bgcolor="#E8E8E8">
				<td align="center"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
			</tr>
			<tr bgcolor="#E8E8E8">
				<td align="center">
					<table width="900" border="0" cellspacing="0" cellpadding="2">
						<tr class="encabezado-tabla">
							<td width="225" align="center">Folio de la Fórmula</td>
							<td width="225" align="center">Código de control interno</td>
							<td width="225" align="center">Status</td>
							<td width="225" align="center"><img src="imagenes/calendario.png"/> Fecha de Generación</td>
						</tr>
						<tr>
							<td class="subtitulo" align="center">'.$ff['id_formula'].'</td>
							<td class="subtitulo" align="center">'.$ff['codigo_interno'].'</td>
							<td class="subtitulo" align="center">'.$ff['status'].'</td>
							<td class="subtitulo" align="center">'.$ff['fecha_alta'].' | '.$ff['hora_alta'].' horas</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
				<br />
				<table width="950" border="0" align="center" cellpadding="4" cellspacing="1">
					<tr class="encabezado-tabla">
					<td width="150" align="center">Código</td>
					<td width="300" align="center">Nombre del Insumo</td>
					<td width="100" align="center">Cantidad</td>
					<td width="100" align="center">Costo Actual</td>
					<td width="100" align="center">Costo Simulado</td>
					<td width="100" align="center">Imp. Actual</td>
					<td width="100" align="center">Imp. Simulado</td>
				</tr>';
$componentes=mysql_query("
SELECT tmcomponentes.id_formula,
tcinsumos.id_insumo AS insuselect,
tcinsumos.codigo,
tcinsumos.nombre,
tmcomponentes.ckgs,
(SELECT tmcostos.moneda FROM tmcostos JOIN tcinsumos WHERE tmcostos.id_insumo = insuselect ORDER BY tmcostos.id_costo DESC LIMIT 1) AS moneda,
(SELECT tmcostos.valor_pesos FROM tmcostos JOIN tcinsumos WHERE tmcostos.id_insumo = insuselect ORDER BY tmcostos.id_costo DESC LIMIT 1) AS valor_pesos,
(SELECT tmcostos.valor_dolares FROM tmcostos JOIN tcinsumos WHERE tmcostos.id_insumo = insuselect ORDER BY tmcostos.id_costo DESC LIMIT 1) AS valor_dolares
FROM tmcomponentes
JOIN tcinsumos
JOIN tmformulas
WHERE tmcomponentes.id_insumo = tcinsumos.id_insumo AND tmcomponentes.id_formula = tmformulas.id_formula AND tmcomponentes.id_formula= '$idf' ORDER BY tmcomponentes.id_componente ASC",$conexion);
$timpact = 0;
$timpsim = 0;
while($fc=mysql_fetch_array($componentes)){
	echo '<tr ';
	if ($fc['insuselect'] == $id_insumo)
	{
		echo 'class="celda-simulacion"';
	}
	else
	{
		echo 'class="celda-activa2"';
	}
	echo '>
			<td align="center" valign="top">'.$fc['codigo'].'</td>
			<td valign="top"><a href="insumo.php?id='.$fc['insuselect'].'#contenido" class="link">'.$fc['nombre'].'</a></td>
			<td align="center" valign="top">'.number_format($fc['ckgs'],4,".",",").'</td>
			<td align="center" valign="top">$ ';
			if ($fc['moneda']=="1")
			{
				$cosact = $fc['valor_pesos'];
				echo number_format($cosact,4,".",",");
			}
			else {
				$cosact = $fc['valor_dolares']*$tchoy;
				echo number_format($cosact,4,".",",");
			}
			echo '</td><td align="center" valign="top">';
			if ($fc['insuselect']==$id_insumo)
			{
				echo '$ '.number_format($cossimp,4,".",",");
			}
			else {
				echo '';
			}
			echo '</td><td align="center" valign="top">$ ';
			$impactual = $cosact * $fc['ckgs'];
			echo number_format($impactual,4,".",",");
			$timpact = $timpact + $impactual;
			echo '</td><td align="center" valign="top">$ ';
			if ($fc['insuselect'] == $id_insumo)
			{
				$impsim = $cossimp * $fc['ckgs'];
				echo number_format($impsim,4,".",",");
				$timpsim = $timpsim + $impsim;
			}
			else {
				$impactual = $cosact * $fc['ckgs'];
				echo number_format($impactual,4,".",",");
				$timpsim = $timpsim + $impactual;
			}
			echo '</td></tr>';
		}
		echo '
		<tr class="encabezado-tabla">
			<td colspan="7" align="right">
				<img src="imagenes/linea-800.png" width="530" height="1" />
			</td>
		</tr>
		<tr class="encabezado-tabla">
			<td align="center">&nbsp;</td>
			<td width="300" align="center">Total:</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="center">$ '.number_format($timpact,4,".",",").'</td>
			<td width="100" align="center">$ '.number_format($timpsim,4,".",",").' ';
			if ($timpsim>$timpact)
			{
				echo "<img src='imagenes/incremento.png'/>";		
			}
			else if ($timpsim==$timpact) {
				echo "<img src='imagenes/normal.png'/>";
				
			}
			else {
				echo "<img src='imagenes/decremento.png'/>";
			}
			echo '</td>
		</tr>
	</table>
	<table width="960" border="0" cellspacing="0" cellpadding="2" style="background-color:#F8F8F8">
		<tr class="encabezado-tabla">
			<td width="225" align="center">Comportamiento</td>
		</tr>
		<tr>
			<td class="subtitulo" align="center">';
			if ($timpsim>$timpact)
			{
				$a = $timpsim - $timpact;
				$b = $a / $timpact;
				$comportamiento = $b * 100;
				echo "<span class='factura-texto2'>El costo directo se incrementó en <span class='incremento'>".number_format($comportamiento,2,".",",")." %</span>";
				
			}
			else if ($timpsim==$timpact)
			{
				$a = $timpact - $timpsim;
				$b = $a / $timpact;
				$comportamiento = $b * 100;
				echo "<span class='factura-texto2'>El costo directo permaneció en <span class='permanecio'>".number_format($comportamiento,2,".",",")." %</span>";
				
			}
			else {
				$a = $timpact - $timpsim;
				$b = $a / $timpact;
				$comportamiento = $b * 100;
				echo "<span class='factura-texto2'>El costo directo decrementó en <span class='decremento'>".number_format($comportamiento,2,".",",")." %</span>";
			}
			echo '</td>
		</tr>
	</table>
</td>
</tr>
</table><br/>';
}
}
echo '<br /></td>
    </tr>
  </table>';
}
?>
<br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
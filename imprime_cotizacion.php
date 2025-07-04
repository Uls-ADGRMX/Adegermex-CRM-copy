<?php
include 'scripts/conexion.php';
///////////////////////////////////////////////////////
// Fecha y Hora ///////////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// ID de la Fórmula ///////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion de la Cotización ///////////////////////
///////////////////////////////////////////////////////
$cotizacion = mysql_query("SELECT tmcotizaciones.*, tcusuarios.id_usuario, tcusuarios.nombre AS usuario, tcusuarios.departamento, tcclientes.id_cliente, tcclientes.nombre AS cliente
FROM tmcotizaciones
JOIN tcusuarios
JOIN tcclientes
WHERE tmcotizaciones.id_usuario = tcusuarios.id_usuario AND tmcotizaciones.id_cliente = tcclientes.id_cliente AND tmcotizaciones.id_cotizacion='$id'", $conexion) or die(mysql_error());
$arraycotizacion = mysql_fetch_object($cotizacion);
$id_usucot = $arraycotizacion->id_usuario;
$usuario = $arraycotizacion->usuario;
$departamento = $arraycotizacion->departamento;
$id_cliente = $arraycotizacion->id_cliente;
$cliente = $arraycotizacion->cliente;
$fecha_alta = $arraycotizacion->fecha_alta;
$hora_alta = $arraycotizacion->hora_alta;
$atencion = $arraycotizacion->atencion;
$empresa = $arraycotizacion->empresa;
if ($empresa=="Adegermex S.A. de C.V.")
{
	$empresa = "1";	
}
else {
	$empresa = "2";	
}
$segmento = $arraycotizacion->segmento;
$moneda = $arraycotizacion->moneda;
$tcaplicado = $arraycotizacion->tcaplicado;
$cantidad = $arraycotizacion->cantidad;
$codigo = $arraycotizacion->codigo;
$nombre_producto = $arraycotizacion->nombre;
$costo = $arraycotizacion->costo;
$mo = $arraycotizacion->mo;
$me = $arraycotizacion->me;
$gt = $arraycotizacion->gt;
$gi = $arraycotizacion->gi;
$og = $arraycotizacion->og;
$utilidad = $arraycotizacion->utilidad;
$comision = $arraycotizacion->comision;
$incoterm = $arraycotizacion->incoterm;
$vigencia = $arraycotizacion->vigencia;
$impuestos = $arraycotizacion->impuestos;
$compra = $arraycotizacion->compra;
$notas = $arraycotizacion->notas;
$observaciones = $arraycotizacion->observaciones;
$status = $arraycotizacion->status;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Cotizaciones</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="794" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="790" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="395" valign="top">
          <?php
		  if ($empresa=="1")
		  {
			echo '
			<img src="imagenes/adegermex-logo.png" width="350" height="85" />
			<br />
			<br />
			<span class="factura-texto2">Boulevard Miguel Ávila Camacho #937 Int. 102<br />
			Bosques de Echegaray, Naucalpan de Juárez,<br />
			Estado de México. C.P.: 53310<br />
			Teléfono: 55.5373.3983 | RFC: ADE8703309B6</span>
			<br />
			';
		  }
		  else {
			echo '
			<img src="imagenes/generalcopack-logo.png" width="350" height="126" />
			<br />
			<br />
			<span class="factura-texto2">Avenida Independencia #45 y #46 Bodega 1 y 2,<br />
			Reforma, San Mateo Atenco, Toluca de Lerdo,<br />
			Estado de México. C.P.: 52120<br />
			Teléfono: 722.541.2921 | RFC: GPM151215926</span>
			<br />
			';
		  }
		  ?>
          </td>
          <td width="395" align="right" valign="top"><span class="titulo">COTIZACIÓN</span><br />
            <span class="factura-texto2">Folio: <?php echo $id; ?><br />
            Página: 1 de 1<br />
            <br />
            <br />
            Fecha: <?php echo $fecha_alta; ?> | <?php echo $hora_alta; ?> horas</span></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="factura-texto2"><strong>En atención a: </strong></td>
        </tr>
        <tr>
          <td class="factura-texto2">
          <?php if ($atencion=="No definido" OR $atencion=="") { echo $cliente; } else { echo $atencion.' ('.$cliente.')'; }?></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="factura-texto2">Sirva la presente para enviarle un cordial saludo así mismo me permito poner a su consideración la cotización de los siguientes productos:</td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="5"><hr style="height:0.5px" color="#000"></td>
        </tr>
        <tr class="encabezado-tabla">
          <td width="150" align="center">Código</td>
          <td width="290" align="center">Nombre</td>
          <td width="100" align="center">Cantidad (kg)</td>
          <td width="120" align="center">Precio Unitario</td>
          <td width="120" align="center">Total de Línea</td>
        </tr>
        <tr>
          <td colspan="5"><hr style="height:0.5px" color="#000"></td>
        </tr>
        <tr>
          <td valign="top"><span class="subtitulo"><?php echo $codigo; ?></span></td>
          <td><span class="subtitulo"><?php echo $nombre_producto; ?></span></td>
          <td align="center"><span class="subtitulo"><?php echo $cantidad; ?></span></td>
          <td align="right"><span class="subtitulo">
            <?php
          $s1 = ($costo + $mo + $me + $gt + $gi + $og);
		  $s2 = ($s1 / (1 - ($utilidad / 100))) - $s1;
		  $s3 = (($s1 / (1 - ($utilidad / 100))) / (1 - ($comision / 100))) - ($s1 / (1 - ($utilidad / 100)));
		  $precio_unitario = $s1 + $s2 + $s3;
		  echo '$ '.number_format($precio_unitario,2,".",",");
		  ?>
          </span></td>
          <td align="right"><span class="subtitulo">
            <?php
          $total_linea = $precio_unitario * $cantidad;
		  echo '$ '.number_format($total_linea,2,".",",");
		  ?>
          </span></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><span class="subtitulo"><strong>Total:</strong></span></td>
          <td align="right"><span class="subtitulo">
            <?php
          $total_linea = $precio_unitario * $cantidad;
		  echo '$ '.number_format($total_linea,2,".",",");
		  ?>
          </span></td>
        </tr>
        <tr>
          <td colspan="5"><hr style="height:0.5px" color="#000" /></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="factura-texto2">Espero que  la información que le comparto sea de su interés.</td>
        </tr>
      </table>
      <br />
      <br />
      <br />
      <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><hr style="height:0.2px; width:60%" color="#000" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2"><?php echo $usuario; ?><br />
            <?php echo $departamento; ?></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td width="200" class="factura-texto2"><strong>Moneda:</strong></td>
          <td width="580" class="factura-texto2">
		  	<?php if($moneda=="1") { echo 'Pesos (MXN)'; } else { echo 'Dolares (USD)'; } ?>
          </td>
        </tr>
        <tr>
          <td class="factura-texto2"><strong>Incoterm:</strong></td>
          <td class="factura-texto2"><?php echo $incoterm; ?></td>
        </tr>
        <tr>
          <td class="factura-texto2"><strong>Vigencia de la cotización:</strong></td>
          <td class="factura-texto2"><?php echo $vigencia.' días'; ?> (hasta el <?php $fecha_vigencia = strtotime($fecha_alta."+ ".$vigencia."days"); echo date("Y-m-d", $fecha_vigencia); ?>)</td>
        </tr>
        <tr>
          <td class="factura-texto2"><strong>Impuestos:</strong></td>
          <td class="factura-texto2">Considerar <?php echo $impuestos.'%'; ?> de I.V.A.</td>
        </tr>
        <tr>
          <td class="factura-texto2"><strong>Mínimo de compra:</strong></td>
          <td class="factura-texto2"><?php echo $compra.' kilogramos'; ?></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td class="factura-texto2"><strong>Notas adicionales:</strong></td>
        </tr>
        <tr>
          <td class="factura-texto2"><?php echo $notas; ?></td>
        </tr>
      </table>
      <br />
      <table width="780" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td colspan="2" class="factura-texto2"><strong>Condiciones comerciales:</strong></td>
        </tr>
        <tr>
          <td width="20" align="left" valign="top" class="factura-texto2">1.</td>
          <td width="760" align="left" valign="top" class="factura-texto2">Los precios son por Kilogramo.<br /></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="factura-texto2">2.</td>
          <td align="left" valign="top" class="factura-texto2">En pedidos mayores a $1,800 USD o $30,000 MXN en la factura antes de I.V.A., la entrega se realiza sin costo en CDMX, Zona Metropolitana, Norte, Bajío y Pacifico o fletera que el cliente requiera, de lo contrario se deberá realizar la recolección en el almacén.</td>
        </tr>
        <tr>
          <td align="left" valign="top" class="factura-texto2">3.</td>
          <td align="left" valign="top" class="factura-texto2">Tiempo de entrega de 6 a 10 semanas para el primer pedido, posteriormente de acuerdo a Forecast.</td>
        </tr>
        <tr>
          <td align="left" valign="top" class="factura-texto2">4.</td>
          <td align="left" valign="top" class="factura-texto2">Los precios podrían cambiar en cualquier momento.</td>
        </tr>
        <tr>
          <td align="left" valign="top" class="factura-texto2">5.</td>
          <td align="left" valign="top" class="factura-texto2">Los productos cotizados están garantizados al cumplimiento de las especificaciones técnicas del producto, cualquier uso o funcionalidad final es responsabilidad del cliente.</td>
        </tr>
      </table>
<br /></td>
  </tr>
</table>
</body>
</html>
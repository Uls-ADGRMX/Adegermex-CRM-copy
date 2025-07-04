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
// ID de la Cotización ////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion de la Cotización ///////////////////////
///////////////////////////////////////////////////////
$cotizacion = mysql_query("SELECT tmcotizaciones.*, tcusuarios.id_usuario, tcusuarios.nombre AS usuario, tcclientes.id_cliente, tcclientes.nombre AS cliente
FROM tmcotizaciones
JOIN tcusuarios
JOIN tcclientes
WHERE tmcotizaciones.id_usuario = tcusuarios.id_usuario AND tmcotizaciones.id_cliente = tcclientes.id_cliente AND tmcotizaciones.id_cotizacion='$id'", $conexion) or die(mysql_error());
$arraycotizacion = mysql_fetch_object($cotizacion);
$id_usucot = $arraycotizacion->id_usuario;
$usuario = $arraycotizacion->usuario;
$id_cliente = $arraycotizacion->id_cliente;
$cliente = $arraycotizacion->cliente;
$fecha_alta = $arraycotizacion->fecha_alta;
$hora_alta = $arraycotizacion->hora_alta;
$atencion = $arraycotizacion->atencion;
$empresa = $arraycotizacion->empresa;
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
<!-- Imprimir Cotización -->
<script type="text/javascript">
function Imprime(cotizacion)
{
	cotizacion.focus();
	cotizacion.print();
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#D1266A">&nbsp;</td>
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
    <td align="center" class="titulo">Cotizaciones</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Cotización</td>
    <td width="500" align="right" class="factura-texto4">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="270" valign="middle"><table width="250" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td align="center" class="encabezado-tabla">Cotización generada por</td>
            </tr>
            <tr>
              <td align="center"><img src="imagenes/avatar<?php echo $id_usucot; ?>.png" width="80" height="80" /></td>
            </tr>
            <tr>
              <td align="center" class="subtitulo"><?php echo $usuario; ?></td>
            </tr>
            <tr>
              <td align="center" class="subtitulo">Fecha: <strong><?php echo $fecha_alta; ?></strong> a las <strong><?php echo $hora_alta; ?></strong> horas.</td>
            </tr>
            <tr>
              <td align="center" class="subtitulo">Status: <?php if($status=="Activa") { echo '<span class="finalizado">Activa</span>'; } else { echo '<span class="eliminado">Eliminada</span>'; } ?></td>
            </tr>
          </table></td>
          <td width="130" align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
          <td width="500"><table width="470" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td width="125" valign="top" class="encabezado-tabla">Cliente / Prospecto</td>
              <td width="375" class="subtitulo"><?php echo '<a href="cliente.php?id='.$id_cliente.'#contenido" class="link">'.$cliente.'</a>'; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">En atención a</td>
              <td class="subtitulo"><?php echo $atencion; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Empresa que cotiza</td>
              <td class="subtitulo"><?php echo $empresa; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Segmento</td>
              <td class="subtitulo"><?php echo $segmento; ?></td>
            </tr>
          </table>
            <br />
            <table width="470" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td width="125" valign="top" class="encabezado-tabla">Moneda</td>
                <td width="375" class="subtitulo"><?php if ($moneda=="1") { echo 'Pesos <img src="imagenes/mexico-min.png">'; } else { echo 'Dolares <img src="imagenes/usa-min.png">';	} ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Incoterm</td>
                <td class="subtitulo"><?php echo $incoterm; ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Vigencia</td>
                <td class="subtitulo"><?php echo $vigencia; ?> días ( hasta el <?php $fecha_vigencia = strtotime($fecha_alta."+ ".$vigencia."days"); echo date("Y-m-d", $fecha_vigencia); ?> )</td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Impuestos</td>
                <td class="subtitulo"><?php echo $impuestos; ?>% de I.V.A.</td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Mínimo de compra</td>
                <td class="subtitulo"><?php echo $compra; ?> kilogramos</td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Observaciones</td>
                <td class="subtitulo"><?php echo $observaciones; ?></td>
              </tr>
            </table></td>
        </tr>
      </table>
	  <?php
      if ($id_usucot==$id_usuario OR $tipo_usuario=="Administrador")
	  	{
			if ($status=="Activa")
			{
			echo '
			<br />
			<table width="900" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td colspan="2" align="center"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
				</tr>
				<tr>
					<td width="450" align="center"><input name="imprimir" type="submit" class="boton-finalizar" id="imprimir" value="Imprimir Cotización" onclick="Imprime(cotizacion);"/></td>
					<td width="450" align="center"><a href="confirmar_eliminar_cotizacion.php?id='.$id.'#contenido"><input name="eliminar" type="submit" class="boton-eliminar" id="eliminar" value="Eliminar Cotización" /></a></td>
				</tr>
			</table>';
			}
		}
		?>
        <br />
        </td>
    </tr>
  </table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4">Desglose de la cotización</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" class="factura-texto4"><strong>Producto</strong></td>
          </tr>
        <tr>
          <td width="664"><?php echo $nombre_producto.' ( '.$codigo.' )'; ?></td>
          <td width="220" align="right"><?php echo '$ '.number_format($costo,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
      </table>
      <br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" class="factura-texto4"><strong>Gastos</strong></td>
        </tr>
        <tr>
          <td width="664">Gastos de Mano de Obra</td>
          <td width="220" align="right"><?php echo '$ '.number_format($mo,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td>Gastos de Material de Empaque</td>
          <td align="right"><?php echo '$ '.number_format($me,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td>Gastos de Transporte</td>
          <td align="right"><?php echo '$ '.number_format($gt,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td>Gastos de Importación</td>
          <td align="right"><?php echo '$ '.number_format($gi,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td>Otros Gastos</td>
          <td align="right"><?php echo '$ '.number_format($og,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td align="right"><strong>Subtotal:</strong></td>
          <td align="right"><strong><?php
          $subtotal = $costo + $mo + $me + $gt + $gi + $og;
		  echo '$ '.number_format($subtotal,2,".",","); ?></strong></td>
        </tr>
      </table>
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" class="factura-texto4"><strong>Porcentajes</strong></td>
        </tr>
        <tr>
          <td width="664">Utilidad ( <strong><?php echo $utilidad.'%'; ?></strong> )</td>
          <td width="220" align="right"><?php
		  $cttg = $costo + $mo + $me + $gt + $gi + $og;
          $tutilidad = ($cttg / (1 - ($utilidad / 100))) - $cttg;
		  echo '$ '.number_format($tutilidad,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
        </tr>
        <tr>
          <td>Comisión del Agente de Ventas ( <strong><?php echo $comision.'%'; ?></strong> )</td>
          <td align="right"><?php
		  $stco = ($cttg / (1 - ($utilidad / 100)));
          $tcomision = ($stco / (1 - ($comision / 100))) - $stco;
		  echo '$ '.number_format($tcomision,2,".",","); ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
        </tr>
  </table>
<br />
<br />
<table width="900" border="0" cellspacing="0" cellpadding="4">
  <tr>
          <td width="664" class="texto-moneda">Precio de Venta por KG</td>
          <td width="220" align="right"><strong><?php
          $preciokg = $subtotal + $tutilidad + $tcomision;
		  echo '$ '.number_format($preciokg,2,".",","); ?></strong></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
        </tr>
        <tr>
          <td>Cantidad de kilogramos cotizados</td>
          <td align="right"><?php echo $cantidad; ?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
          </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr>
          <td class="texto-moneda-2">Total de la Cotización:</td>
          <td align="right" class="texto-moneda-2"><?php
          $total = $preciokg * $cantidad;
		  echo '$ '.number_format($total,2,".",","); ?></td>
        </tr>
    </table>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4">Formato</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="830" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><iframe src="imprime_cotizacion.php?id=<?php echo $id; ?>" name="cotizacion" id="cotizacion" width="820px" height="600px" style="border:dotted; border-color:#CCC;" scrolling="yes"></iframe></td>
        </tr>
</table>
      <br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
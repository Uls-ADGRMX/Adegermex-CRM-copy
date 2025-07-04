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
// Validar Tipo de Cambio /////////////////////////////
///////////////////////////////////////////////////////
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$cambiohoy_num=mysql_num_rows($cambiohoy);
if($cambiohoy_num<>0)
	{
	}
	else {
		header('Location: cotizacion_sintc.php#contenido');
	}
///////////////////////////////////////////////////////
// Validar clientes en sistema ////////////////////////
///////////////////////////////////////////////////////
$clientes=mysql_query("SELECT * FROM tcclientes ORDER BY nombre ASC",$conexion);
$numero_clientes=mysql_num_rows($clientes);
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
<!-- Funciones -->
<script>
function Moneda()
{
	var m = document.getElementById("moneda").value
	if (m=="Pesos")
	{
		document.getElementById("rmoneda").innerHTML = "<img src='imagenes/mexico.png' width='41' height='30' /> Pesos";
	}
	else
	{
		document.getElementById("rmoneda").innerHTML = "<img src='imagenes/usa.png' width='41' height='30' /> Dolares";
	}
}
function Suma() {
	// Valores de los campos
	var cantidad = document.getElementById("cantidad").value
	if (cantidad=="")
	{
		document.getElementById("rcantidad").innerHTML = 1
		document.getElementById("cantidad").value = 1
		var cantidad = 1
	}
	else
	{
		document.getElementById("rcantidad").innerHTML = cantidad
		var cantidad = cantidad
	}
	var costo = document.getElementById("costo").value
		if (costo=="")
		{
			document.getElementById("costo").value = 0
			document.getElementById("ct").value = 0
			var costo = 0
		}
		else
		{
			document.getElementById("ct").value = costo
			var costo = costo
		}
	var ct = document.getElementById("ct").value;
		if (ct=="") {
			document.getElementById("ct").value = 0
			var ct = 0
			}
	var mo = document.getElementById("mo").value;
		if (mo=="") {
			document.getElementById("mo").value = 0
			var mo = 0
			}
	var me = document.getElementById("me").value;
		if (me=="") {
			document.getElementById("me").value = 0
			var me = 0
			}
	var gt = document.getElementById("gt").value;
		if (gt=="") {
			document.getElementById("gt").value = 0
			var gt = 0
			}
	var gi = document.getElementById("gi").value;
		if (gi=="") {
			document.getElementById("gi").value = 0
			var gi = 0
			}
	var og = document.getElementById("og").value;
		if (og=="") {
			document.getElementById("og").value = 0
			var og = 0
			}
	var ut = document.getElementById("ut").value;
	var utp = document.getElementById("utp").value;
		if (utp=="") {
			document.getElementById("utp").value = 0
			var utp = 0
			}
	var co = document.getElementById("co").value;
	var cop = document.getElementById("cop").value;
		if (cop=="") {
			document.getElementById("cop").value = 0
			var cop = 0
			}
	// Calculo del total de Gastos
	var tgastos = parseFloat(mo) + parseFloat(me) + parseFloat(gt) + parseFloat(gi) + parseFloat(og)
	var tgastosf = tgastos.toFixed(2);
	// Calculo de total de Porcentajes
		var cttg = parseFloat(ct) + parseFloat(tgastos)
		var porut = 1 - (parseFloat(utp) / 100)
		var stut = parseFloat(cttg) / parseFloat(porut)
		var utilidad = parseFloat(stut) - parseFloat(cttg)
		var tutilidad = utilidad.toFixed(2);
		document.getElementById("ut").value = tutilidad
		var porco = 1 - (parseFloat(cop) / 100)
		var stco = parseFloat(stut) / parseFloat(porco)
		var comision = parseFloat(stco) - parseFloat(stut)
		var tcomision = comision.toFixed(2);
		document.getElementById("co").value = tcomision
		var co = document.getElementById("co").value;
		var ut = document.getElementById("ut").value;
		var tporce = parseFloat(ut) + parseFloat(co)
		var tporcef = tporce.toFixed(2);
	// Calculo original de total de Porcentajes
		//	var utilidad = (parseFloat(utp) * (parseFloat(ct) + parseFloat(tgastos)))/100
		//	var tutilidad = utilidad.toFixed(2);
		//	document.getElementById("ut").value = tutilidad
		//	var ut = document.getElementById("ut").value;
		//	var comision = (parseFloat(cop) * parseFloat(utilidad))/100
		//	var tcomision = comision.toFixed(2);
		//	document.getElementById("co").value = tcomision
		//	var co = document.getElementById("co").value;
		//	var tporce = parseFloat(ut) + parseFloat(co)
		//	var tporcef = tporce.toFixed(2);
	// Calculo de Precio de Venta por Kg
	var tprecio = parseFloat(tgastos) + parseFloat(tporce) + parseFloat(costo)
	var tpreciof = tprecio.toFixed(2);
	// Calculo de total de la cotizacion
	var tpreciot = parseFloat(tprecio) * parseFloat(cantidad)
	var tpreciotf = tpreciot.toFixed(2);
	// Mostrar resultado del total de Producto
	document.getElementById("tpr").innerHTML = "<strong>$ " + costo + "</strong>"
	// Mostrar resultado del total de Gastos
	document.getElementById("tg").innerHTML = "<strong>$ " + tgastosf + "</strong>"
	// Mostrar resultado del total de Porcentajes
	document.getElementById("tp").innerHTML = "<strong>$ " + tporcef + "</strong>"
	// Mostrar resultado de Precio de Venta por Kg
	document.getElementById("precio").innerHTML = "<strong>$ " + tpreciof + "</strong>"
	// Mostrar resultado de Precio de Venta por Kg en resumen
	document.getElementById("rprecio").innerHTML = "$ " + tpreciof
	// Mostrar resultado de total de la cotización
	document.getElementById("total").innerHTML = "$ " + tpreciotf
}
function Vigencia()
{
	var vigencia = document.getElementById("vigencia").value
	if (vigencia=="")
	{
		document.getElementById("vigencia").value = 1
	}
}
function Impuestos()
{
	var impuestos = document.getElementById("impuestos").value
	if (impuestos=="")
	{
		document.getElementById("impuestos").value = 0
	}
}
function Compra()
{
	var compra = document.getElementById("compra").value
	if (compra=="")
	{
		document.getElementById("compra").value = 1
	}
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4"><a name="contenido" id="contenido"></a>Generar nueva Cotización</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="333"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
          <div id="rmoneda" class="titulo"><img src="imagenes/mexico.png" width="41" height="30" /> Pesos</div>
          Moneda<br />
          <br /></td>
      </tr>
    </table></td>
    <td width="333"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><br />
            <div id="rcantidad" class="titulo">1</div>
            Kilogramos<br />
            <br /></td>
        </tr>
    </table></td>
    <td width="333"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br />
            <div id="rprecio" class="titulo">$ 0.00</div>
            Precio de Venta por Kg<br />
            <br /></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br /><form action="engines/alta_cotizacion.php" method="post" name="cotenv"><div id="Generalidades" class="tabcontent"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Generalidades')" id="defaultOpen" hidden="hidden"></a>
          <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50" align="center"><img src="imagenes/1-activo-azul.png" width="39" height="40" /></td>
              <td width="162" class="encabezado-tabla">Generalidades</td>
              <td width="50" align="center"><img src="imagenes/2-inactivo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Producto</td>
              <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Incrementables</td>
              <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
              <td width="164" class="subtitulo">Información Comercial</td>
            </tr>
          </table>
          <br />
          <br />
          <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
          <td align="center" class="titulo">Generalidades</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
    </table>
          <br />
          <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
        <td width="240" valign="middle">Cliente / Prospecto</td>
        <td width="694"><?php
				echo '<select name="cliente" class="textbox" id="cliente" style="height:35px; width:560px;"/>';
				echo '<optgroup label="Clientes / Prospectos">';
                	if ($numero_clientes=="0")
					{
						echo '<option value="0">No hay clientes o prospectos en sistema</option>';
					}
					else {
						while($fila=mysql_fetch_array($clientes))
						{
							echo "<option value='".$fila['id_cliente']."'>".$fila['nombre']."</option>";
						}
					}
				echo '</optgroup>';
				echo '</select>';
		?></td>
      </tr>
      <tr>
        <td valign="middle">En atención a</td>
        <td width="694"><input name="atencion" type="text" class="textbox" id="atencion" placeholder="En atención a" autocomplete="off" autofocus="autofocus"/></td>
      </tr>
      <tr>
        <td valign="middle">Empresa que cotiza</td>
        <td width="694"><select name="empresa" class="textbox" id="empresa" style="height:35px; width:560px;">
              <optgroup label="Empresas">
                <option>Adegermex S.A. de C.V.</option>
                <option>General Co-Pack de México S.A. de C.V.</option>
              </optgroup>
              </select></td>
      </tr>
      <tr>
        <td valign="middle">Segmento de la cotización</td>
        <td width="694"><select name="segmento" class="textbox-med" id="segmento" style="height:35px;">
                <option>Panificación</option>
                <option>Lácteos</option>
                <option>Cárnicos</option>
                <option>Bebidas</option>
                <option>Snacks</option>
                <option>Culinario</option>
                <option>Vegetales</option>
                <option>Food Service</option>
                <option>Otro</option>
              </select></td>
      </tr>
    </table>
          <br />
          <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="titulo">Cantidad y moneda</td>
            </tr>
            <tr>
              <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
            </tr>
          </table>
          <br />
          <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td width="240" valign="middle">Moneda</td>
              <td colspan="2"><select name="moneda" class="textbox-med" id="moneda" style="height:35px;" onchange="Moneda();">
                <optgroup label="Monedas">
                  <option>Pesos</option>
                  <option>Dolares</option>
                  </optgroup>
              </select></td>
            </tr>
            <tr>
              <td valign="top">Cantidad a cotizar</td>
              <td width="102"><input name="cantidad" type="number" min="1" step="1" class="textbox-min" id="cantidad" placeholder="#" autocomplete="off" value="1" oninput="Suma();"/></td>
              <td width="584">Kilogramos</td>
            </tr>
          </table>
          <br />
<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">
            <br />
          <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Producto')"><input class="boton-login" type="button" name="paso2" id="paso2" value="Continuar (Paso 2)" /></a></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          ó <a href="cotizaciones.php">Cancelar</a></td>
      </tr>
</table>
      <br />
        </div>
<div id="Producto" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Generalidades</td>
      <td width="50" align="center"><img src="imagenes/2-activo-azul.png" width="39" height="40" /></td>
      <td width="162" class="encabezado-tabla">Producto</td>
      <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Incrementables</td>
      <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
      <td width="164" class="subtitulo">Información Comercial</td>
    </tr>
  </table>
  <br />
  <div id="captura" style="display:block">
    <table width="600" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center" class="mensaje-correcto">Ingrese el <strong>código, nombre y costo</strong> del producto a cotizar.</td>
          </tr>
        </table>
        <br />
      <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr class="encabezado-tabla">
          <td width="214" align="center">Código del Producto</td>
          <td width="384" align="center">Nombre del Producto</td>
          <td width="286" align="center">Costo</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
        </tr>
        <tr>
          <td align="center"><input name="codigo" type="text" class="textbox-min" id="codigo" placeholder="Código" autocomplete="off" style="width:120px;"/></td>
          <td align="center"><input name="nombre" type="text" class="textbox" id="nombre" placeholder="Nombre del Producto" style="width:300px;" autocomplete="off"/></td>
          <td align="center"><input name="costo" type="number" min="0.01" step="0.01" class="textbox-min" id="costo" placeholder="$" style="width:120px;" autocomplete="off" oninput="Suma();" value="0.00"/></td>
        </tr>
      </table>
    </div>
      <br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Incrementables')"><input class="boton-login" type="button" name="paso3" id="paso3" value="Continuar (Paso 3)" /></a></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Generalidades')">Volver (Paso 1)</a> ó <a href="cotizaciones.php">Cancelar</a></td>
      </tr>
</table>
      <br />
</div>
<div id="Incrementables" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Generalidades</td>
      <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Producto</td>
      <td width="50" align="center"><img src="imagenes/3-activo-azul.png" width="39" height="40" /></td>
      <td width="162" class="encabezado-tabla">Incrementables</td>
      <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
      <td width="164" class="subtitulo">Información Comercial</td>
    </tr>
  </table>
  <br />
  <br />
  <table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="titulo">Producto</td>
    </tr>
  </table>
  <br />
  <table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="750" class="factura-texto3">Costo del Producto</td>
      <td width="150" align="right">$
        <input name="ct" type="number" min="0.00" step="0.01" class="textbox-min" id="ct" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();" readonly="readonly"/></td>
    </tr>
    <tr>
      <td colspan="2"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><span class="factura-texto3"><strong class="factura-texto2">Total de Producto</strong></span></td>
      <td align="center"><div id="tpr" class="factura-texto2"><strong>$ 0.00</strong></div></td>
    </tr>
  </table>
  <table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="titulo">Gastos</td>
    </tr>
</table>
  <br />
  <table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="750" class="factura-texto3">Gastos de Mano de Obra</td>
      <td width="150" align="right">$ 
        <input name="mo" type="number" min="0.00" step="0.01" class="textbox-min" id="mo" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/></td>
    </tr>
    <tr>
      <td colspan="2"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
      </tr>
    <tr>
      <td class="factura-texto3">Gastos de Material de Empaque</td>
      <td align="right">$ 
        <input name="me" type="number" min="0.00" step="0.01" class="textbox-min" id="me" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/></td>
    </tr>
    <tr>
      <td colspan="2" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
      </tr>
    <tr>
      <td class="factura-texto3">Gastos de Transporte</td>
      <td align="right">$ 
        <input name="gt" type="number" min="0.00" step="0.01" class="textbox-min" id="gt" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/></td>
    </tr>
    <tr>
      <td colspan="2" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
      </tr>
    <tr>
      <td class="factura-texto3">Gastos de Importación</td>
      <td align="right">$ 
        <input name="gi" type="number" min="0.00" step="0.01" class="textbox-min" id="gi" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/></td>
    </tr>
    <tr>
      <td colspan="2" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
      </tr>
    <tr>
      <td class="factura-texto3">Otros Gastos</td>
      <td align="right">$ 
        <input name="og" type="number" min="0.00" step="0.01" class="textbox-min" id="og" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/></td>
    </tr>
    <tr>
      <td colspan="2" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
      </tr>
    <tr>
      <td colspan="2" class="factura-texto3">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="factura-texto3"><strong class="factura-texto2">Total de Gastos</strong></td>
      <td align="center"><div id="tg" class="factura-texto2"><strong>$ 0.00</strong></div></td>
    </tr>
</table>
  <table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="titulo">Porcentajes</td>
    </tr>
</table>
  <br />
  <table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto3">Utilidad</td>
      <td width="150" class="factura-texto3"><input name="utp" type="number" min="0.00" max="100.00" step="0.01" class="textbox-min" id="utp" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/>
        %</td>
      <td width="100" align="center" class="factura-texto3"><img src="imagenes/viñeta-verde.png" width="16" height="16" /></td>
      <td width="150" align="right">$ 
        <input name="ut" type="number" min="0.00" step="0.01" class="textbox-min" id="ut" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();" readonly="readonly"/></td>
    </tr>
    <tr>
      <td colspan="4" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
    </tr>
    <tr>
      <td class="factura-texto3">Comisión del Agente de Ventas</td>
      <td class="factura-texto3"><input name="cop" type="number" min="0.00" max="100.00" step="0.01" class="textbox-min" id="cop" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();"/>
        %</td>
      <td align="center" class="factura-texto3"><img src="imagenes/viñeta-verde.png" width="16" height="16" /></td>
      <td align="right">$ 
        <input name="co" type="number" min="0.00" step="0.01" class="textbox-min" id="co" placeholder="$" style="width:120px;" autocomplete="off" value="0.00" oninput="Suma();" readonly="readonly"/></td>
    </tr>
    <tr>
      <td colspan="4" class="factura-texto3"><img src="imagenes/linea-800.png" width="750" height="1" /></td>
    </tr>
    <tr>
      <td colspan="4" class="factura-texto3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="right" class="factura-texto3"><strong class="factura-texto2">Total de Porcentajes</strong></td>
      <td align="center"><div id="tp" class="factura-texto2"><strong>$ 0.00</strong></div></td>
    </tr>
</table>
  <br />
  <br />
  <table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="683" align="right" class="factura-texto3"><strong class="texto-moneda-2">Precio de Venta por Kg</strong></td>
      <td width="201" align="center"><div id="precio" class="texto-moneda-2"><strong>$ 0.00</strong></div></td>
    </tr>
</table>
<br />
<br />
<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Comercial')">
            <input class="boton-login" type="button" name="paso4" id="paso4" value="Continuar (Paso 4)" />
            </a></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Producto')">Volver (Paso 2)</a> ó <a href="cotizaciones.php">Cancelar</a></td>
        </tr>
</table><br/></div>

<div id="Comercial" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Generalidades</td>
      <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Producto</td>
      <td width="50" align="center"><img src="imagenes/3-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Incrementables</td>
      <td width="50" align="center"><img src="imagenes/4-activo-azul.png" width="39" height="40" /></td>
      <td width="164" class="encabezado-tabla">Información Comercial</td>
    </tr>
  </table>
  <br />
  <table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
          <td align="center" class="factura-texto4"><strong>Total de la cotización</strong></td>
          </tr>
        <tr>
          <td align="center" class="factura-texto3"><div id="total" class="texto-moneda-2"><strong>$ 0.00</strong></div></td>
          </tr>
        <tr>
          <td align="center" class="factura-texto-min">No incluye impuestos</td>
        </tr>
    </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Información comercial</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
    </table>
      <br />
      <table width="730" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="170">Incoterm</td>
          <td width="560"><select name="incoterm" class="textbox-med" id="incoterm" style="height:35px;">
          <optgroup label="Transporte en general">
            <option>Ex-Works (EXW)</option>
            <option>Free Carrier (FCA)</option>
            <option>Carriage Paid To (CPT)</option>
            <option>Carriage and Insurance Paid To (CIP)</option>
            <option>Delivered At Place (DAP)</option>
            <option>Delivered at Place Unloaded (DPU)</option>
            <option>Delivered Duty Paid (DDP)</option>
            </optgroup>
          <optgroup label="Transporte marítimo">
            <option>Free Alongside Ship (FAS)</option>
            <option>Free On Board (FOB)</option>
            <option>Cost and Freight (CFR)</option>
            <option>Cost, Insurance, and Freight (CIF)</option>
            </optgroup>
          <optgroup label="No definido">
            <option>No definido</option>
            </optgroup>
          </select></td>
        </tr>
        <tr>
          <td>Vigencia de la cotización</td>
          <td><input name="vigencia" type="number" min="1" step="1" class="textbox-min" id="vigencia" placeholder="$" style="width:60px;" autocomplete="off" value="30" oninput="Vigencia();"/> 
            dias</td>
        </tr>
        <tr>
          <td>Impuestos</td>
          <td><input name="impuestos" type="number" min="0" step="1" class="textbox-min" id="impuestos" placeholder="$" style="width:60px;" autocomplete="off" value="16" oninput="Impuestos();"/>
            % de I.V.A.</td>
        </tr>
        <tr>
          <td>Mínimo de compra</td>
          <td><input name="compra" type="number" min="1" step="1" class="textbox-min" id="compra" placeholder="$" style="width:60px;" autocomplete="off" value="300" oninput="Compra();"/> 
            kilogramos</td>
        </tr>
      </table>
      <br />
      <table width="730" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="175" valign="top">Notas adicionales</td>
          <td width="555">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><textarea name="notas" cols="45" rows="5" class="textbox-comentario" id="notas" placeholder="Indique notas o comentarios adicionales de la cotización" required="required"></textarea></td>
          </tr>
        <tr>
          <td valign="top">Observaciones</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><textarea name="observaciones" cols="45" rows="5" class="textbox-comentario" id="observaciones" placeholder="Indique las observaciones de la cotización" required="required"></textarea></td>
          </tr>
</table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="button" name="enviar" id="enviar" value="Generar Nueva Cotización!" onclick="cotenv.submit()"/></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Incrementables')">Volver (Paso 3)</a> ó <a href="cotizaciones.php">Cancelar</a></td>
      </tr>
</table><br/></div></form><script>
function seccion(evt, paso) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(paso).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?>
<br />
</body>
</html>
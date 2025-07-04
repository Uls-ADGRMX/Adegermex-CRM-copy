<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Fórmulas</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
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
// Informacion del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$formula=mysql_query("
SELECT *, tmformulas.fecha_alta AS fgen, tmformulas.hora_alta AS hgen, tcusuarios.nombre AS generador
FROM tmformulas
JOIN tmespecific
JOIN tcusuarios
WHERE tmformulas.id_formula=tmespecific.id_formula AND tmformulas.id_usuario=tcusuarios.id_usuario AND tmformulas.id_formula='$id'", $conexion) or die(mysql_error());
$arrayformula = mysql_fetch_object($formula);
$id_formula = $arrayformula->id_formula;
///////////////////////////////////////////////////////
// Informacion de Componentes /////////////////////////
///////////////////////////////////////////////////////
$comp=mysql_query("
SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tmcomponentes.*
FROM tmcomponentes
JOIN tcinsumos
WHERE tmcomponentes.id_insumo=tcinsumos.id_insumo AND tmcomponentes.id_formula='$id_formula' ORDER BY tmcomponentes.id_componente ASC",$conexion);
$ncomp=mysql_num_rows($comp);
$totales=mysql_query("
SELECT SUM(tmcomponentes.ckgs) AS tckgs, SUM(tmcomponentes.clts) AS tclts, SUM(tmcomponentes.porcentaje) AS tporcentaje, SUM(tmcomponentes.ipesos) AS tipesos, SUM(tmcomponentes.idolar) AS tidolar
FROM tmcomponentes
WHERE tmcomponentes.id_formula='$id_formula'",$conexion);
$atotales = mysql_fetch_object($totales);
///////////////////////////////////////////////////////
// Informacion de Insumos Nuevos /////////////////////
///////////////////////////////////////////////////////
$insumos=mysql_query("
SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tminnuevos.cospesos, tminnuevos.cosdolar, tcproveedores.id_proveedor, tcproveedores.nombre AS proveedor, tminnuevos.id_innuevo
FROM tminnuevos
JOIN tcinsumos
JOIN tcproveedores
WHERE tminnuevos.id_insumo=tcinsumos.id_insumo AND tminnuevos.id_proveedor=tcproveedores.id_proveedor AND tminnuevos.id_formula='$id_formula' ORDER BY tminnuevos.id_innuevo ASC",$conexion);
$ninsumos=mysql_num_rows($insumos);
?>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="794" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="160" rowspan="3" align="center" valign="top"><img src="imagenes/adegermex-logo-min.png" width="97" height="94" /></td>
          <td width="372" rowspan="2" class="factura-texto4">ADEGERMEX S.A. DE C.V.</td>
          <td width="258" align="right"><span class="factura-texto-min">Página 1 de 1</span></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="372" valign="top" class="factura-texto"><table width="330" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td class="factura-texto3"></td>
            </tr>
            <tr>
              <td>Boulevard Miguel Ávila Camacho #937, Int. 102<br /> 
              Bosques de Echegaray, Naucalpan de Juárez,
<br /> 
Estado de México. C.P.: 53310
</td>
            </tr>
            <tr>
              <td>Teléfono: 55.5373.3983 | RFC: ADE8703309B6</td>
            </tr>
        </table></td>
          <td align="center"><table width="250" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="factura-texto">Folio</td>
            </tr>
            <tr>
              <td align="center" class="factura-texto3"><strong><?php echo $id_formula; ?></strong></td>
            </tr>
            <tr>
              <td align="center" class="factura-texto3">Revisión / Versión</td>
            </tr>
            <tr>
              <td align="center" class="factura-texto3"><strong><?php echo $arrayformula->revision; ?></strong></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="factura-texto3"><strong>FORMULACIÓN</strong></td>
        </tr>
      </table>
      <hr style="height:0.5px" color="#000">
    <table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="395" valign="top"><table width="385" border="0" align="center" cellpadding="0" cellspacing="3">
          <tr>
            <td><span class="factura-texto-min"><strong>Nombre del la Fórmula / Producto</strong></span></td>
            </tr>
          <tr>
            <td class="factura-texto"><span class="factura-texto-min"><?php echo $arrayformula->nombre_formula; ?></span></td>
            </tr>
        </table>
          <table width="385" border="0" align="center" cellpadding="0" cellspacing="3">
            <tr>
              <td width="140" class="factura-texto-min"><strong>Número de Componentes:</strong></td>
              <td width="236" class="factura-texto-min"><?php echo $ncomp; ?></td>
            </tr>
            <tr>
              <td class="factura-texto-min"><strong>Tipo de Cambio Aplicado:</strong></td>
              <td class="factura-texto-min">$ <?php echo $arrayformula->tcaplicado; ?></td>
            </tr>
      </table></td>
        <td width="395" valign="top"><table width="360" border="0" align="center" cellpadding="0" cellspacing="3">
          <tr>
            <td width="135"><span class="factura-texto-min"><strong>Fecha de Generación:</strong></span></td>
            <td width="216"><span class="factura-texto-min"><?php echo $arrayformula->fgen.' | '.$arrayformula->hgen.' horas'; ?></span></td>
          </tr>
          <tr>
            <td class="factura-texto-min"><strong>Fecha de Impresión:</strong></td>
            <td width="216" class="factura-texto-min"><?php echo $fecha.' | '.$hora.' horas';?></td>
          </tr>
          <tr>
            <td class="factura-texto"><span class="factura-texto-min"><strong>Código de control interno:</strong></span></td>
            <td class="factura-texto"><span class="factura-texto-min"><?php echo $arrayformula->codigo_interno; ?></span></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <table width="790" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
      <tr>
        <td colspan="10"><hr style="height:0.5px" color="#000"></td>
        </tr>
      <tr class="factura-texto-min">
        <td width="90" align="center"><strong>Código</strong></td>
        <td width="220" align="center"><strong>Insumo</strong></td>
        <td width="60" align="center">&nbsp;</td>
        <td width="60" align="center"><strong>Cantidad<br />
          Kg</strong></td>
        <td width="60" align="center">&nbsp;</td>
        <td width="60" align="center"><strong>Porcentaje<br />
          %</strong></td>
        <td width="60" align="center"><strong>Costo<br />
          MXN / Kg</strong></td>
        <td width="60" align="center"><strong>Costo<br />
          USD / Kg</strong></td>
        <td width="60" align="center"><strong>Importe<br />
          MXN</strong></td>
        <td width="60" align="center"><strong>Importe<br />
          USD</strong></td>
      </tr>
      <tr>
        <td colspan="10"><hr style="height:0.5px" color="#000"></td>
      </tr>
       <?php
	   	if ($ncomp=="0"){
			echo '
			<tr class="factura-texto-min">
				<td valign="top" align="center" colspan="10">No existen componentes para esta formulación</td>
			</tr>';
		}
		else {
			while($fila=mysql_fetch_array($comp))
			{
				echo '<tr class="factura-texto-min" style="border-bottom:0.2pt solid black; height:15px;">
        <td valign="top">'.$fila['codigo'].'</td>
        <td valign="top">'.$fila['nombre'].'</td>
        <td align="center">&nbsp;</td>
        <td align="center">'.$fila['ckgs'].'</td>
        <td align="center">&nbsp;</td>
        <td align="center">'.$fila['porcentaje'].'</td>
        <td align="center">'.$fila['cospesos'].'</td>
        <td align="center">'.$fila['cosdolar'].'</td>
        <td align="center">'.$fila['ipesos'].'</td>
        <td align="center">'.$fila['idolar'].'</td>
      </tr>';
			}
		}
	   ?>
      <tr class="factura-texto-min">
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top"><strong>Total:</strong></td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong><?php echo number_format($atotales->tckgs,4,".",","); ?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong><?php echo number_format($atotales->tporcentaje,2,".",","); ?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong><?php echo number_format($atotales->tipesos,4,".",","); ?></strong></td>
        <td align="center"><strong><?php echo number_format($atotales->tidolar,4,".",","); ?></strong></td>
      </tr>
    </table>
    <br />
    <table width="780" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="110"><strong><span class="factura-texto-min">Humedad</span></strong></td>
        <td width="150" class="factura-texto-min"><?php if ($arrayformula->f1=="ND"){ echo $arrayformula->f1; } else { echo $arrayformula->f1.' %';} ?></td>
        <td width="110"><strong><span class="factura-texto-min">Cloruros</span></strong></td>
        <td width="150" class="factura-texto-min"><?php if ($arrayformula->f7=="ND"){ echo $arrayformula->f7; } else { echo $arrayformula->f7.' %';} ?></td>
        <td width="110"><strong><span class="factura-texto-min">Coliformes Totales</span></strong></td>
        <td width="150" class="factura-texto-min"><?php if ($arrayformula->m3=="ND"){ echo $arrayformula->m3; } else { echo $arrayformula->m3.' UFC/g';} ?></td>
      </tr>
      <tr>
        <td><strong><span class="factura-texto-min">Cenizas</span></strong></td>
        <td class="factura-texto-min">
          <?php if ($arrayformula->f2=="ND"){ echo $arrayformula->f1; } else { echo $arrayformula->f1.' %';} ?></td>
        <td><strong><span class="factura-texto-min">Prueba Lugol</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f8=="ND"){ echo $arrayformula->f8; } else { echo $arrayformula->f8;} ?></td>
        <td><strong><span class="factura-texto-min">E. coli</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m4=="ND"){ echo $arrayformula->m4; } else { echo $arrayformula->m4.' UFC/g';} ?></td>
      </tr>
      <tr>
        <td><strong><span class="factura-texto-min">NaCl</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f3=="ND"){ echo $arrayformula->f3; } else { echo $arrayformula->f3.' %';} ?></td>
        <td><strong><span class="factura-texto-min">Densidad a 25°C</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f9=="ND"){ echo $arrayformula->f9; } else { echo $arrayformula->f9.' g/cm3';} ?></td>
        <td><strong><span class="factura-texto-min">Salmonella</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m5=="ND"){ echo $arrayformula->m5; } else { echo $arrayformula->m5.' /25';} ?></td>
      </tr>
      <tr>
        <td><strong><span class="factura-texto-min">Particulas Magnéticas</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f4=="ND"){ echo $arrayformula->f4; } else { echo $arrayformula->f4.' %';} ?></td>
        <td><strong><span class="factura-texto-min">°Brix</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f10=="ND"){ echo $arrayformula->f10; } else { echo $arrayformula->f10;} ?></td>
        <td><strong><span class="factura-texto-min">S. aureus</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m6=="ND"){ echo $arrayformula->m6; } else { echo $arrayformula->m6.' UFC/g';} ?></td>
      </tr>
      <tr>
        <td><strong><span class="factura-texto-min">pH (puro)</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f5=="ND"){ echo $arrayformula->f5; } else { echo $arrayformula->f5;} ?></td>
        <td class="factura-texto-min"><strong>CTB</strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m1=="ND"){ echo $arrayformula->m1; } else { echo $arrayformula->m1.' UFC/g';} ?></td>
        <td><span class="factura-texto-min"><strong>B. aureus</strong></span></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m7=="ND"){ echo $arrayformula->m7; } else { echo $arrayformula->m7.' UFC/g';} ?></td>
      </tr>
      <tr>
        <td><strong><span class="factura-texto-min">pH (sol a 10%)</span></strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->f6=="ND"){ echo $arrayformula->f6; } else { echo $arrayformula->f5;} ?></td>
        <td class="factura-texto-min"><strong>HyL</strong></td>
        <td class="factura-texto-min"><?php if ($arrayformula->m2=="ND"){ echo $arrayformula->m2; } else { echo $arrayformula->m2.' UFC/g';} ?></td>
        <td class="factura-texto-min">&nbsp;</td>
        <td class="factura-texto-min">&nbsp;</td>
      </tr>
    </table>
    <br />
    <table width="790" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="5"><hr style="height:0.5px" color="#000" /></td>
      </tr>
      <tr class="factura-texto-min">
        <td width="95" align="center"><strong>Código</strong></td>
        <td width="215" align="center"><strong>Insumo</strong></td>
        <td width="60" align="center"><strong>Costo<br />
MXN / Kg</strong></td>
        <td width="60" align="center"><strong>Costo<br />
USD / Kg</strong></td>
        <td align="center"><strong>Proveedor</strong></td>
        </tr>
      <tr>
        <td colspan="5"><hr style="height:0.5px" color="#000" /></td>
      </tr>
      <?php
	   	if ($ninsumos=="0"){
			echo '
			<tr class="factura-texto-min">
				<td valign="top" align="center" colspan="5">No existen insumos nuevos para esta formulación</td>
			</tr>';
		}
		else {
			while($fila=mysql_fetch_array($insumos))
			{
				echo '<tr class="factura-texto-min">
        <td valign="top">'.$fila['codigo'].'</td>
        <td valign="top">'.$fila['nombre'].'</td>
        <td align="center">'.$fila['cospesos'].'</td>
        <td align="center">'.$fila['cosdolar'].'</td>
        <td>'.$fila['proveedor'].'</td>
        </tr>';
			}
		}
	   ?>
    </table>
    <br />
    <table width="780" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="520" rowspan="2" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><span class="factura-texto-min"><strong>Observaciones:</strong></span><br />
              <span class="factura-texto-min"><?php echo $arrayformula->observaciones; ?></span></td>
          </tr>
        </table></td>
        <td width="260" align="center" style="border:solid; border-color:#333; border-width:1px;"><strong class="factura-texto-min">Costo Directo de la Formulación</strong></td>
      </tr>
      <tr>
        <td align="center" style="border:solid; border-color:#333; border-width:1px;"><table width="250" border="0" cellspacing="0" cellpadding="2">
          <tr class="factura-texto-min">
            <td width="50">&nbsp;</td>
            <td width="100" align="center"><strong>Kg</strong></td>
            <td width="100" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td class="factura-texto-min"><strong>MXN</strong></td>
            <td align="center" class="factura-texto-min">$ <?php echo $arrayformula->cdkp; ?></td>
            <td align="center" class="factura-texto-min">&nbsp;</td>
          </tr>
          <tr>
            <td class="factura-texto-min"><strong>USD</strong></td>
            <td align="center" class="factura-texto-min">$ <?php echo $arrayformula->cdkd; ?></td>
            <td align="center" class="factura-texto-min">&nbsp;</td>
          </tr>
      </table></td>
      </tr>
    </table>
    <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="195"><br />
          <br />
          <br />
          <br /></td>
        <td width="195">&nbsp;</td>
        <td width="195">&nbsp;</td>
        <td width="195">&nbsp;</td>
      </tr>
      <tr>
        <td><hr style="height:0.2px" width="80%" color="#666"/></td>
        <td><hr style="height:0.2px" width="80%" color="#666"/></td>
        <td><hr style="height:0.2px" width="80%" color="#666"/></td>
        <td><hr style="height:0.2px" width="80%" color="#666"/></td>
      </tr>
      <tr class="factura-texto">
        <td align="center" valign="top" class="factura-texto-min">Ing. <?php echo $arrayformula->generador; ?><br />
          Elaboró</td>
        <td align="center" valign="top" class="factura-texto-min"><br />
          Visto Bueno</td>
        <td align="center" valign="top" class="factura-texto-min"><br />
          Aprobó</td>
        <td align="center" valign="top" class="factura-texto-min"><br />
          Autorizó</td>
      </tr>
</table></td>
  </tr>
</table>
</body>
</html>
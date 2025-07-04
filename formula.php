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
///////////////////////////////////////////////////////
// ID de la Fórmula ///////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$formula=mysql_query("
SELECT *, tmformulas.status AS status, tmformulas.fecha_alta AS fformula, tmformulas.hora_alta AS hformula
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
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#5F7C8A">&nbsp;</td>
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
    <td align="center" class="titulo">Fórmulas</td>
  </tr>
</table>
<div class="tabcontent">
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Detalles de la Fórmula</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id_formula; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo"><?php echo $arrayformula->nombre_formula; ?>&nbsp;</td>
        </tr>
      </table>
      <?php
	if ($arrayformula->id_proyecto=="0")
	{
		}
	else {
		$id_proyecto = $arrayformula->id_proyecto;
		$proyecto = mysql_query("SELECT nombre_proyecto FROM tmproyectos WHERE id_proyecto=$id_proyecto", $conexion);
		$aproyecto = mysql_fetch_object($proyecto);
		echo '<table width="950" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td align="center" valign="middle"><strong>Proyecto asociado</strong></td>
        </tr>
        <tr>
          <td align="center" valign="middle"><a href="proyecto.php?id='.$id_proyecto.'#contenido" class="link">'.$aproyecto->nombre_proyecto.' (Folio: '.$id_proyecto.')</a></td>
        </tr>
      </table><br/>';
	  }
?>
      <table width="800" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="220" align="center" class="encabezado-tabla">Fórmula generada por</td>
          <td width="167" rowspan="2" align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /><br />
		  <?php if ($arrayformula->status=="Activa") { echo '<span class="autorizado">'.$arrayformula->status.'</span>'; } else { echo '<span class="eliminado">'.$arrayformula->status.'</span>'; } ?></td>
          <td width="389" align="center" class="encabezado-tabla">Costo Directo de la Formulación</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/avatar<?php echo $arrayformula->id_usuario; ?>.png" width="80" height="80" /><br />
            <br />
            <span class="subtitulo"><?php echo $arrayformula->nombre; ?></span></td>
          <td align="center"><table width="380" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="100" align="center"><img src="imagenes/mexico.png" width="41" height="30" /><br />
                <span class="factura-texto-min">MXN</span></td>
              <td width="140"><strong>$ <span class="subtitulo"><?php echo $arrayformula->cdkp; ?></span></strong></td>
              <td width="140" class="subtitulo">Kilogramo</td>
              </tr>
            </table>
            <br />
            <table width="380" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td width="100" align="center"><span class="encabezado-tabla"><img src="imagenes/usa.png" width="40" height="30" /><br />
                  </span><span class="factura-texto-min">USD</span></td>
                <td width="140"><strong>$ <span class="subtitulo"><?php echo $arrayformula->cdkd; ?></span></strong></td>
                <td width="140" class="subtitulo">Kilogramo</td>
                </tr>
            </table></td>
        </tr>
        </table>
      <br />
      <table width="800" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="120" valign="top"><span class="encabezado-tabla"><img src="imagenes/comentario.png" width="15" height="12" /> Observaciones:</span></td>
          <td width="680" valign="top"><span class="subtitulo"><?php echo $arrayformula->observaciones; ?></span></td>
        </tr>
      </table>
      <br />
      <table width="840" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="4" align="center"><img src="imagenes/linea-950.png" width="830" height="1" /></td>
          </tr>
        <tr class="subtitulo">
          <td align="center">Fecha de Alta</td>
          <td align="center">Código de control interno</td>
          <td align="center">Revisión / Versión</td>
          <td align="center">Tipo de Fórmula</td>
        </tr>
        <tr>
          <td align="center" width="210"><strong><?php echo $arrayformula->fformula.' | '.$arrayformula->hformula.' horas';?></strong></td>
          <td align="center" width="210"><strong><?php echo $arrayformula->codigo_interno; ?></strong></td>
          <td align="center" width="210"><strong><?php echo $arrayformula->revision; ?></strong></td>
          <td align="center" width="210"><strong><?php if ($arrayformula->master=="0") {echo 'Desarrollo';} else { echo 'Maestra <img src="imagenes/estrella.png" width="14" height="14" title="Fórmula Maestra">';}?></strong></td>
        </tr>
    </table>
      <br />
      <?php
	  if ($arrayformula->status=="Eliminada")
	  {
	  }
	  else {
	  	if ($id_usuario==$arrayformula->id_usuario OR $tipo_usuario=="Administrador")
			{
				echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="316" align="center"><a href="imprimir_formula.php?id='.$id_formula.'#contenido"><input name="imprimir" type="button" class="boton-finalizar" id="imprimir" value="Imprimir Fórmula" /></a></td>
          <td width="316" align="center"><a href="confirmar_eliminar_formula.php?id='.$id_formula.'&idp='.$arrayformula->id_proyecto.'#contenido"><input name="eliminar" type="button" class="boton-eliminar" id="eliminar" value="Eliminar Fórmula" /></a></td>
          <td width="316" align="center">';
		  	if ($arrayformula->master=="0") {
				echo '<a href="engines/tipo_formula.php?id='.$id_formula.'&tipo=1"><input name="maestra" type="button" class="boton-aprobado" id="maestra" value="Fórmula Maestra" /></a>';
			}
			else {
				echo '<a href="engines/tipo_formula.php?id='.$id_formula.'&tipo=0"><input name="desarrollo" type="button" class="boton-desarrollar" id="desarrollo" value="Fórmula de Desarrollo" /></a>';
			}
		  
		  echo '</td>
        </tr>
      </table>
	  <br/>';
	  }
}
?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Registro de Análisis</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="250" align="center" valign="top" class="celda-activa2"><table width="240" border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="2" align="center" valign="top" class="factura-texto2"><strong>Fisicoquímicos</strong></td>
              </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="factura-texto2"><img src="imagenes/linea-400.png" width="235" height="1" /></td>
            </tr>
            <tr>
              <td width="135" valign="top" class="encabezado-tabla">Humedad</td>
              <td width="105" align="center" valign="top" class="subtitulo"><?php if ($arrayformula->f1=="ND"){ echo $arrayformula->f1; } else { echo $arrayformula->f1.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Cenizas</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->f2=="ND"){ echo $arrayformula->f1; } else { echo $arrayformula->f1.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">NaCl</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->f3=="ND"){ echo $arrayformula->f3; } else { echo $arrayformula->f3.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Particulas Magnéticas</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->f4=="ND"){ echo $arrayformula->f4; } else { echo $arrayformula->f4.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">pH (puro)</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->f5=="ND"){ echo $arrayformula->f5; } else { echo $arrayformula->f5;} ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">pH (sol a 10%)</td>
              <td align="center" class="subtitulo"><?php if ($arrayformula->f6=="ND"){ echo $arrayformula->f6; } else { echo $arrayformula->f5;} ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Cloruros</td>
              <td align="center" class="subtitulo"><?php if ($arrayformula->f7=="ND"){ echo $arrayformula->f7; } else { echo $arrayformula->f7.' %';} ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Prueba Lugol</td>
              <td align="center" class="subtitulo"><?php if ($arrayformula->f8=="ND"){ echo $arrayformula->f8; } else { echo $arrayformula->f8;} ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Densidad a 25°C</td>
              <td align="center" class="subtitulo"><?php if ($arrayformula->f9=="ND"){ echo $arrayformula->f9; } else { echo $arrayformula->f9.' g/cm3';} ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">°Brix</td>
              <td align="center" class="subtitulo"><?php if ($arrayformula->f10=="ND"){ echo $arrayformula->f10; } else { echo $arrayformula->f10;} ?></td>
            </tr>
          </table></td>
          <td width="250" align="center" valign="top" class="celda-activa2"><table width="240" border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="2" align="center" valign="top" class="factura-texto2"><strong>Microbiología</strong></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="encabezado-tabla"><span class="factura-texto2"><img src="imagenes/linea-400.png" width="235" height="1" /></span></td>
            </tr>
            <tr>
              <td width="135" valign="top" class="encabezado-tabla">CTB</td>
              <td width="105" align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m1=="ND"){ echo $arrayformula->m1; } else { echo $arrayformula->m1.' UFC/g';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">HyL</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m2=="ND"){ echo $arrayformula->m2; } else { echo $arrayformula->m2.' UFC/g';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Coliformes Totales</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m3=="ND"){ echo $arrayformula->m3; } else { echo $arrayformula->m3.' UFC/g';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">E. coli</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m4=="ND"){ echo $arrayformula->m4; } else { echo $arrayformula->m4.' UFC/g';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Salmonella</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m5=="ND"){ echo $arrayformula->m5; } else { echo $arrayformula->m5.' /25';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">S. aureus</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m6=="ND"){ echo $arrayformula->m6; } else { echo $arrayformula->m6.' UFC/g';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">B. aureus</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->m7=="ND"){ echo $arrayformula->m7; } else { echo $arrayformula->m7.' UFC/g';} ?></td>
            </tr>
          </table></td>
          <td width="250" align="center" valign="top" class="celda-activa2"><table width="240" border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="3" align="center" valign="top" class="factura-texto2"><strong>Granulometría</strong></td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top" class="encabezado-tabla"><span class="factura-texto2"><img src="imagenes/linea-400.png" width="235" height="1" /></span></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">&nbsp;</td>
              <td align="center" valign="top" class="subtitulo">Retiene</td>
              <td align="center" valign="top" class="subtitulo">Pasa</td>
            </tr>
            <tr>
              <td width="80" valign="top" class="encabezado-tabla">Malla 8</td>
              <td width="85" align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g1=="ND"){ echo "-"; } else { echo $arrayformula->g1.' %';} ?></td>
              <td width="85" align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g2=="ND"){ echo "-"; } else { echo $arrayformula->g2.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 14</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g3=="ND"){ echo "-"; } else { echo $arrayformula->g3.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g4=="ND"){ echo "-"; } else { echo $arrayformula->g4.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 30</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g5=="ND"){ echo "-"; } else { echo $arrayformula->g5.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g6=="ND"){ echo "-"; } else { echo $arrayformula->g6.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 40</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g7=="ND"){ echo "-"; } else { echo $arrayformula->g7.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g8=="ND"){ echo "-"; } else { echo $arrayformula->g8.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 60</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g9=="ND"){ echo "-"; } else { echo $arrayformula->g9.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g10=="ND"){ echo "-"; } else { echo $arrayformula->g10.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 80</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g11=="ND"){ echo "-"; } else { echo $arrayformula->g11.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g12=="ND"){ echo "-"; } else { echo $arrayformula->g12.' %';} ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Malla 100</td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g13=="ND"){ echo "-"; } else { echo $arrayformula->g13.' %';} ?></td>
              <td align="center" valign="top" class="subtitulo"><?php if ($arrayformula->g14=="ND"){ echo "-"; } else { echo $arrayformula->g14.' %';} ?></td>
            </tr>
          </table>            <br /></td>
          <td width="210" align="center"><img src="imagenes/matraz.png" width="164" height="228" /></td>
        </tr>
  </table>      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Fórmulación</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;"><?php echo $ncomp; ?> componentes</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <?php 
	if ($ncomp=="0"){
		echo '<br/><table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/formula.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay <strong>Componentes</strong> registrados para esta formulación.</td>
        </tr>
      </table><br/>';
	}
	else{
		echo '
		<br/><table width="980" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr class="encabezado-tabla">
				<td width="120" align="center">Código</td>
				<td width="260" align="center">Nombre del Insumo</td>
				<td width="75" align="center">&nbsp;</td>
				<td width="75" align="center">Cantidad<br />Kg</td>
				<td width="75" align="center">&nbsp;</td>
				<td width="75" align="center">Porcentaje<br />%</td>
				<td width="75" align="center">Costo<br />MXN / Kg</td>
				<td width="75" align="center">Costo<br />USD / Kg</td>
				<td width="75" align="center">Importe<br />MXN</td>
				<td width="75" align="center">Importe<br />USD</td>
			</tr>
			<tr class="encabezado-tabla">
				<td colspan="10" align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
			</tr>';
			while($fila=mysql_fetch_array($comp))
			{
				echo '
			<tr class="celda-activa">
				<td width="120" valign="top">'.$fila['codigo'].'</td>
				<td width="260" valign="top"><a href="insumo.php?id='.$fila['id_insumo'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
				<td width="75" align="center" valign="top">&nbsp;</td>
				<td width="75" align="center" valign="top">'.$fila['ckgs'].'</td>
				<td width="75" align="center" valign="top">&nbsp;</td>
				<td width="75" align="center" valign="top">'.$fila['porcentaje'].'</td>
				<td width="75" align="center" valign="top">'.$fila['cospesos'].'</td>
				<td width="75" align="center" valign="top">'.$fila['cosdolar'].'</td>
				<td width="75" align="center" valign="top">'.$fila['ipesos'].'</td>
				<td width="75" align="center" valign="top">'.$fila['idolar'].'</td>
			</tr>';
			}
			echo '
			<tr>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr class="encabezado-tabla">
				<td align="center">&nbsp;</td>
				<td align="center">Totales:</td>
				<td align="center">&nbsp;</td>
				<td align="center">'.number_format($atotales->tckgs,4,".",",").'</td>
				<td align="center">&nbsp;</td>
				<td align="center">'.number_format($atotales->tporcentaje,2,".",",").'</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">'.number_format($atotales->tipesos,4,".",",").'</td>
				<td align="center">'.number_format($atotales->tidolar,4,".",",").'</td>
			</tr>';
		echo '</table><br />';
		}
	?>
      
      </td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Insumos Nuevos</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;"><?php echo $ninsumos.' insumos nuevos' ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <?php 
	if ($ninsumos=="0"){
		echo '<br/><table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/insumo.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Insumos nuevos</strong> para esta formulación.</td>
      </tr>
    </table><br/>';
	}
	else{
		echo '
		<br/><br/><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr class="encabezado-tabla">
        <td width="135">Código</td>
        <td width="255">Nombre del Insumo</td>
        <td width="90"><img src="imagenes/mexico-min.png" width="16" height="12" /> Costo</td>
        <td width="90"><img src="imagenes/usa-min.png" width="17" height="13" /> Costo</td>
        <td width="380">Proveedor</td>
      </tr>
      <tr>
        <td colspan="5"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>';
		while($fila=mysql_fetch_array($insumos))
		{
		echo '
      <tr class="celda-activa">
        <td>'.$fila['codigo'].'</td>
        <td><a href="insumo.php?id='.$fila['id_insumo'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
        <td>'.$fila['cospesos'].'</td>
        <td>'.$fila['cosdolar'].'</td>
        <td><a href="proveedor.php?id='.$fila['id_proveedor'].'#contenido" class="link">'.$fila['proveedor'].'</a></td>
      </tr>';
		}
	  echo '</table><br/><br/>'
	  ;}
	?></td>
  </tr>
</table><br/>
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
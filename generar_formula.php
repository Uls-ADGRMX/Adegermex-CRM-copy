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
// Proyecto Asociado //////////////////////////////////
///////////////////////////////////////////////////////
$id_proyecto = $_GET["id"];
///////////////////////////////////////////////////////
// Número de insumos en la fórmula ////////////////////
///////////////////////////////////////////////////////
$numero = 20;
$numero_nuevos = 5;
///////////////////////////////////////////////////////
// Validación de insumos en sistema ///////////////////
///////////////////////////////////////////////////////
$insumos=mysql_query("SELECT * FROM tcinsumos",$conexion);
$ninsumos=mysql_num_rows($insumos);
///////////////////////////////////////////////////////
// Validación de costos en sistema ////////////////////
///////////////////////////////////////////////////////
$costos=mysql_query("SELECT * FROM tmcostos",$conexion);
$ncostos=mysql_num_rows($costos);
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
<!-- Autocompletar Fórmula -->
<script type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>  
<script type="text/javascript" src="scripts/jquery-ui-1.8.2.custom.min.js"></script>  
<script type="text/javascript">
jQuery(document).ready(function(){
<?php
///////////////////////////////////////////////////////
// Componentes de la fórmula //////////////////////////
///////////////////////////////////////////////////////
for ($insumo=1; $insumo<=$numero; $insumo++)
{
	echo"
	$('#codigo".$insumo."').focusout (function(){
		var codigo = $(this).val();
		var tc = document.getElementById('tipocambio').value;
		$.ajax ({
			url:'engines/valores.php',
			type:'POST', 
			dataType:'json', 
			data: {pcodigo: codigo, ptc: tc},
			success: function(res){
				$('#id_insumo".$insumo."').val(res.id_insumo)
				$('#insumo".$insumo."').val(res.nombre)
				$('#densidad".$insumo."').val(res.densidad)
				$('#cospesos".$insumo."').val(res.valor_pesos)
				$('#cosdolar".$insumo."').val(res.valor_dolares)
				}
			})
		}
	)";
}
///////////////////////////////////////////////////////
// Componentes nuevos de la fórmula ///////////////////
///////////////////////////////////////////////////////
for ($y=1; $y<=$numero_nuevos; $y++)
{
	echo"
	$('#incodigo".$y."').focusout (function(){
		var codigo = $(this).val();
		var tc = document.getElementById('tipocambio').value;
		$.ajax ({
			url:'engines/valores.php', 
			type:'POST', 
			dataType:'json', 
			data: {pcodigo: codigo, ptc: tc},
			success: function(res){
				$('#innombre".$y."').val(res.nombre)
				$('#incospesos".$y."').val(res.valor_pesos)
				$('#incosdolar".$y."').val(res.valor_dolares)
				$('#in_idinsum".$y."').val(res.id_insumo)
				$('#in_idprov".$y."').val(res.id_proveedor)
				$('#inproveedor".$y."').val(res.proveedor)
				}
			})
		}
	)";
}
?>
});
</script>
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
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Generar Fórmula</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <br />
	<?php
    if ($ninsumos=="0" OR $ncostos=="0"){
			echo '
			<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td align="center"><img src="imagenes/formula.png" width="180" height="180" /></td>
				</tr>
				<tr>
					<td align="center" class="factura-texto2">Verifique que existen <a href="insumos.php">Insumos</a> y <a href="costos.php">Costos</a> registrados en el sistema para generar nuevas <b>Fórmulas</b>.</td>
				</tr>
			</table>';
		}
		else {
			echo '
			<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" class="titulo">Formulación</td>
				</tr>
				<tr>
					<td align="center"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
				</tr>
			</table>
			<br />
			<form action="engines/alta_formula.php" method="post" name="formulacion" id="formulacion">';
				if ($id_proyecto=="0"){
					}
				else {
					$proyecto = mysql_query("SELECT nombre_proyecto FROM tmproyectos WHERE id_proyecto=$id_proyecto", $conexion);
					$aproyecto = mysql_fetch_object($proyecto);
					echo '
					<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center" valign="middle"><strong>Nombre del Proyecto</strong></td>
						</tr>
						<tr>
							<td align="center" valign="middle">'.$aproyecto->nombre_proyecto.'</td>
						</tr>
					</table>
					<br/>';
					}
				echo '
				<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td align="center" valign="middle"><strong>Nombre de la Fórmula / Producto</strong>
							<input type="hidden" id="id_usuario" name="id_usuario" value="'.$id_usuario.'">
							<input type="hidden" id="numero" name="numero" value="'.$numero.'">
							<input type="hidden" id="numero_nuevos" name="numero_nuevos" value="'.$numero_nuevos.'">
							<input type="hidden" id="id_proyecto" name="id_proyecto" value="'.$id_proyecto.'">
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle">
							<input name="nombre_formula" type="text"  class="textbox" id="nombre_formula" placeholder="Ejemplo: Cobertura de Chocolate" autocomplete="off" autofocus="autofocus" required="required"/>
						</td>
					</tr>
				</table>
				<br />
				<table width="750" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td width="74" valign="middle">Código</td>
						<td width="255" valign="middle">
							<input name="codigo_interno" type="text" required="required" class="textbox-med" id="codigo_interno" placeholder="Código de control interno" autocomplete="off" maxlength="15"/>
						</td>
						<td width="129" valign="middle">Revisión / Versión</td>
						<td width="260" valign="middle"><input name="revision" type="number" required="required" class="textbox-med" id="revision" placeholder="#" autocomplete="off" maxlength="4" step="1" min="1" value="1"/></td>
					</tr>
				</table>
				<br />
				<br />
				<table width="350" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td align="center" class="mensaje-notificacion">Defina el tipo de cambio a utilizar:</td>
					</tr>
					<tr>
						<td align="center" class="subtitulo"><input type="number" class="textbox-min" name="tipocambio" id="tipocambio" value="21.0000" step="0.0001" min="0.0001" required="required" style="font-size:16px;"></td>
					</tr>
				</table>
				<br />
				<br />
				<table width="900" border="0" cellpadding="1" cellspacing="0">
					<tr class="encabezado-tabla">
						<td width="120" align="center">Código</td>
						<td width="260" align="center">Nombre del Insumo</td>
						<td width="75" align="center">Cantidad<br />Kg</td>
						<td width="75" align="center">Porcentaje<br />%</td>
						<td width="75" align="center">Costo<br />MXN / Kg</td>
						<td width="75" align="center">Costo<br />USD / Kg</td>
						<td width="75" align="center">Importe<br />MXN</td>
						<td width="75" align="center">Importe<br />USD</td>
					</tr>
					<tr>
						<td colspan="8" align="center"><img src="imagenes/linea-800.png" width="900" height="1" /></td>
					</tr>
				</table>
				<div id="componentes" style="width:970px; height:320px; overflow-y:scroll; border:0px; border-color:#CCC;">
					<table width="900" border="0" align="center" cellpadding="1" cellspacing="0">';
						for ($insumo=1; $insumo<=$numero; $insumo++){
							echo '
							<tr>
								<td width="15" align="center" class="factura-texto-min">'.$insumo.'</td>
								<td width="120" align="center"><input name="codigo'.$insumo.'" type="text" class="textbox-form-codigo" id="codigo'.$insumo.'" placeholder="Código" autoomplete="off"/></td>
								<td width="260" align="center">
									<input name="insumo'.$insumo.'" type="text" class="textbox-form-nombre" id="insumo'.$insumo.'" placeholder="Nombre del Insumo" readonly="readonly"/>
									<input type="hidden" name="id_insumo'.$insumo.'" id="id_insumo'.$insumo.'">
								</td>
								<td width="75" align="center"><input name="ckgs'.$insumo.'" type="number" class="textbox-form" id="ckgs'.$insumo.'" min="0" step="0.00000001" placeholder="Kgs" value="0"/></td>
								<td width="75" align="center"><input name="porcentaje'.$insumo.'" type="text" class="textbox-form-resultado" id="porcentaje'.$insumo.'" min="0" max="100" placeholder="%" value="0" readonly="readonly"/></td>
								<td width="75" align="center"><input name="cospesos'.$insumo.'" type="number" class="textbox-form-resultado" id="cospesos'.$insumo.'" min="0" placeholder="$" value="0" readonly="readonly"/></td>
								<td width="75" align="center"><input name="cosdolar'.$insumo.'" type="text" class="textbox-form-resultado" id="cosdolar'.$insumo.'" min="0" placeholder="$" value="0" readonly="readonly"/></td>
								<td width="75" align="center"><input name="ipesos'.$insumo.'" type="text" class="textbox-form-resultado" id="ipesos'.$insumo.'" min="0" placeholder="$"  value="0" readonly="readonly"/></td>
								<td width="75" align="center"><input name="idolar'.$insumo.'" type="text" class="textbox-form-resultado" id="idolar'.$insumo.'" min="0" placeholder="$" value="0" readonly="readonly"/></td>
							</tr>';
						}
					echo '
					</table>
				</div>
				<table width="900" border="0" align="center" cellpadding="1" cellspacing="0">
					<tr>
						<td colspan="8" align="right"><img src="imagenes/linea-400.png" width="900" height="1" /></td>
					</tr>
					<tr>
						<td width="117" align="center">&nbsp;</td>
						<td width="252" class="encabezado-tabla">Totales:</td>
						<td width="74" align="center"><input name="tkgs" type="text" class="textbox-form-resultado-bold" id="tkgs" step="0.0001" min="0" placeholder="Kgs" readonly="readonly"/></td>
						<td width="73" align="center"><input name="tporcentaje" type="text" class="textbox-form-resultado-bold" id="tporcentaje" step="0.01" min="0" max="100" placeholder="%" readonly="readonly"/></td>
						<td width="73" align="center">&nbsp;</td>
						<td width="73" align="center">&nbsp;</td>
						<td width="73" align="center"><input name="tipesos" type="text" class="textbox-form-resultado-bold" id="tipesos" step="0.0001" min="0" placeholder="$" readonly="readonly"/></td>
						<td width="76" align="center"><input name="tidolar" type="text" class="textbox-form-resultado-bold" id="tidolar" step="0.0001" min="0" placeholder="$" readonly="readonly"/></td>
					</tr>
				</table>
				<br/>
				<table width="600" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td align="center"><input name="calcular" type="button" class="boton-cliente" id="calcular" value="Calcular Formulación" onclick="';
							for ($g=1; $g<=$numero; $g++){
								echo 'ipesos'.$g.'.value=(parseFloat(ckgs'.$g.'.value)*parseFloat(cospesos'.$g.'.value)).toFixed(4);';
								}
							for ($h=1; $h<=$numero; $h++){
								echo 'idolar'.$h.'.value=(parseFloat(ckgs'.$h.'.value)*parseFloat(cosdolar'.$h.'.value)).toFixed(4);';
								}
							echo 'tkgs.value=(';
								for ($a=1; $a<=$numero; $a++){
									if ($a==$numero){
										echo 'parseFloat(ckgs'.$a.'.value)';
										}
									else {
										echo 'parseFloat(ckgs'.$a.'.value)+';}
										}
									echo ').toFixed(4);';
							for ($i=1; $i<=$numero; $i++){
								echo 'porcentaje'.$i.'.value=(parseFloat(parseFloat((ckgs'.$i.'.value)/tkgs.value)*100)).toFixed(2);';
								}
							echo 'tporcentaje.value=(';
								for ($c=1; $c<=$numero; $c++){
									if ($c==$numero){
										echo 'parseFloat(porcentaje'.$c.'.value)';
										}
									else {
										echo 'parseFloat(porcentaje'.$c.'.value)+';}
										}
									echo ').toFixed(2);';
							echo 'tipesos.value=(';
							for ($d=1; $d<=$numero; $d++){
								if ($d==$numero){
									echo 'parseFloat(ipesos'.$d.'.value)';
									}
								else {
									echo 'parseFloat(ipesos'.$d.'.value)+';}
									}
								echo ').toFixed(4);';
								echo 'tidolar.value=(';
								for ($e=1; $e<=$numero; $e++){
									if ($e==$numero){
										echo 'parseFloat(idolar'.$e.'.value)';
										}
									else {
										echo 'parseFloat(idolar'.$e.'.value)+';
										}
									}
								echo ').toFixed(4);';
								echo 'cdkp.value=(parseFloat(tipesos.value)/parseFloat(tkgs.value)).toFixed(4);
								cdkd.value=(parseFloat(tidolar.value)/parseFloat(tkgs.value)).toFixed(4);
								cdlp.value=(parseFloat(tipesos.value)/parseFloat(tlts.value)).toFixed(4);
								cdld.value=(parseFloat(tidolar.value)/parseFloat(tlts.value)).toFixed(4);
								tdensidad.value=(parseFloat(tkgs.value)/parseFloat(tlts.value)).toFixed(4);
								"/>
						</td>
					</tr>
				</table>
				<br />
				<table width="375" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr class="factura-texto2">
						<td><strong>Costo Directo</strong></td>
						<td align="center">Kilogramo (kg)</td>
					</tr>
					<tr>
						<td width="150"><img src="imagenes/mexico-min.png" width="16" height="12" /> Pesos (MXN)</td>
						<td width="225" align="center"><input name="cdkp" type="text" class="textbox-form-resultado-bold" id="cdkp" value="0.0000" readonly="readonly"/></td>
					</tr>
					<tr>
						<td><img src="imagenes/usa-min.png" width="17" height="13" /> Dolares (USD)</td>
						<td align="center"><input name="cdkd" type="text" class="textbox-form-resultado-bold" id="cdkd" value="0.0000" readonly="readonly"/></td>
					</tr>
				</table>
				<br />
				<br />
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Registro de Análisis</td>
  </tr>
  <tr>
    <td align="center"><img src="imagenes/linea-850.png" width="850" height="1" /></td>
  </tr>
</table>
<br />
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" align="center" bgcolor="#EFEFEF" class="factura-texto4">Fisicoquímicos</td>
    <td width="680" class="celda-activa">
      <table width="640" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td width="160"><strong>Humedad</strong></td>
        <td width="160">
          <input name="f1" type="number" class="textbox-min" id="f1" autocomplete="off" placeholder="#" step="0.01" min="0"/>
          %</td>
        <td width="160"><strong>pH (sol a 10%)</strong></td>
        <td width="160"><input name="f6" type="number" class="textbox-min" id="f6" autocomplete="off" placeholder="#" step="0.01" min="0"/></td>
      </tr>
      <tr>
        <td><strong>Cenizas</strong></td>
        <td>
<input name="f2" type="number" class="textbox-min" id="f2" autocomplete="off" placeholder="#" step="0.01" min="0"/>
%</td>
        <td><strong>Cloruros</strong></td>
        <td><input name="f7" type="number" class="textbox-min" id="f7" autocomplete="off" placeholder="#" step="0.01" min="0"/> 
          %</td>
      </tr>
      <tr>
        <td><strong>NaCl</strong></td>
        <td>
<input name="f3" type="number" class="textbox-min" id="f3" autocomplete="off" placeholder="#" step="0.01" min="0"/>
%</td>
        <td><strong>Prueba Lugol</strong></td>
        <td><input name="f8" type="number" class="textbox-min" id="f8" autocomplete="off" placeholder="#" step="0.01" min="0"/></td>
      </tr>
      <tr>
        <td><strong>Particulas Magnéticas</strong></td>
        <td>
<input name="f4" type="number" class="textbox-min" id="f4" autocomplete="off" placeholder="#" step="0.01" min="0"/>
%</td>
        <td><strong>Densidad a 25°C</strong></td>
        <td><input name="f9" type="number" class="textbox-min" id="f9" autocomplete="off" placeholder="#" step="0.01" min="0"/> 
          g/cm<sup>3</sup></td>
      </tr>
      <tr>
        <td><strong>pH (puro)</strong></td>
        <td><input name="f5" type="number" class="textbox-min" id="f5" autocomplete="off" placeholder="#" step="0.01" min="0"/></td>
        <td><strong>°Brix</strong></td>
        <td><input name="f10" type="number" class="textbox-min" id="f10" autocomplete="off" placeholder="#" step="0.01" min="0"/></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" align="center" bgcolor="#EFEFEF" class="factura-texto4">Microbiología</td>
    <td width="680" align="center" class="celda-activa"><table width="640" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="160"><strong>CTB</strong></td>
        <td width="160"><input name="m1" type="number" class="textbox-min" id="m1" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          UFC/g        </td>
        <td width="160"><strong>Salmonella</strong></td>
        <td width="160"><input name="m5" type="number" class="textbox-min" id="m5" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          /25g        </td>
      </tr>
      <tr>
        <td><strong>HyL</strong></td>
        <td><input name="m2" type="number" class="textbox-min" id="m2" autocomplete="off" placeholder="#" step="0.01" min="0"/> 
          UFC/g</td>
        <td><strong>S. aureus</strong></td>
        <td><input name="m6" type="number" class="textbox-min" id="m6" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          UFC/g </td>
      </tr>
      <tr>
        <td><strong>Coliformes Totales</strong></td>
        <td><input name="m3" type="number" class="textbox-min" id="m3" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          UFC/g </td>
        <td><strong>B. aureus</strong></td>
        <td><input name="m7" type="number" class="textbox-min" id="m7" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          UFC/g </td>
      </tr>
      <tr>
        <td><strong>E. coli</strong></td>
        <td><input name="m4" type="number" class="textbox-min" id="m4" autocomplete="off" placeholder="#" step="0.01" min="0"/>        
          UFC/g </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" align="center" bgcolor="#EFEFEF" class="factura-texto4">Granulometría</td>
    <td width="680" align="center" class="celda-activa"><table width="640" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="151"><strong>Malla 8</strong></td>
        <td width="227"> Retiene
          <input name="g1" type="number" class="textbox-min" id="g1" autocomplete="off" placeholder="#" step="0.01" min="0"/>
%</td>
        <td width="238"> Pasa
          <input name="g2" type="number" class="textbox-min" id="g2" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 14</strong></td>
        <td> Retiene
          <input name="g3" type="number" class="textbox-min" id="g3" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g4" type="number" class="textbox-min" id="g4" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 30</strong></td>
        <td>Retiene
          <input name="g5" type="number" class="textbox-min" id="g5" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g6" type="number" class="textbox-min" id="g6" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 40</strong></td>
        <td>Retiene
          <input name="g7" type="number" class="textbox-min" id="g7" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g8" type="number" class="textbox-min" id="g8" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 60</strong></td>
        <td>Retiene
          <input name="g9" type="number" class="textbox-min" id="g9" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g10" type="number" class="textbox-min" id="g10" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 80</strong></td>
        <td>Retiene
          <input name="g11" type="number" class="textbox-min" id="g11" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g12" type="number" class="textbox-min" id="g12" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
      <tr>
        <td><strong>Malla 100</strong></td>
        <td>Retiene
          <input name="g13" type="number" class="textbox-min" id="g13" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
        <td>Pasa
          <input name="g14" type="number" class="textbox-min" id="g14" autocomplete="off" placeholder="#" step="0.01" min="0"/>
% </td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<br />
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="factura-texto4"><strong>Insumos Nuevos</strong></td>
  </tr>
</table>
<br />
<table width="950" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr class="encabezado-tabla">
    <td width="135" align="center">Código</td>
    <td width="255" align="center">Nombre del Insumo</td>
    <td width="90" align="center">Costo<br />
      MXN / Kg</td>
    <td width="90" align="center">Costo<br />
      USD / Kg</td>
    <td width="380" align="center">Proveedor</td>
  </tr>
  <tr>
    <td colspan="5"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
    </tr>';
	for ($z=1; $z<=$numero_nuevos; $z++)
	{
		echo '
  <tr>
    <td><input name="incodigo'.$z.'" type="text" class="textbox-form-codigo" id="incodigo'.$z.'" placeholder="Código"/></td>
    <td>
		<input name="innombre'.$z.'" type="text" class="textbox-form-nombre" id="innombre'.$z.'" placeholder="Nombre del Insumo" readonly="readonly"/>
		<input type="hidden" name="in_idinsum'.$z.'" id="in_idinsum'.$z.'">
	</td>
    <td align="center"><input name="incospesos'.$z.'" type="text" class="textbox-form-resultado" id="incospesos'.$z.'" placeholder="0" readonly="readonly"/></td>
    <td align="center"><input name="incosdolar'.$z.'" type="text" class="textbox-form-resultado" id="incosdolar'.$z.'" placeholder="0" readonly="readonly"/></td>
    <td>
		<input name="inproveedor'.$z.'" type="text" class="textbox-form-proveedor" id="inproveedor'.$z.'" placeholder="Nombre del Proveedor" readonly="readonly"/>
		<input type="hidden" name="in_idprov'.$z.'" id="in_idprov'.$z.'">	
	</td>
  </tr>';
	}
echo '
</table>
<br />
<br />
<table width="500" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="factura-texto3"><strong class="factura-texto2">Observaciones</strong></td>
  </tr>
  <tr>
    <td><textarea name="observaciones" class="textbox-box" id="observaciones" autocomplete="off" placeholder="Comentarios breves de la formulación" required="required"></textarea></td>
  </tr>
</table>
<br />
<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td align="center" class="subtitulo">Verifique la información ingresada ya que no podrá ser modificada posteriormente.<br />
      <br /></td>
  </tr>
  <tr>
    <td align="center"><input class="boton-login" type="submit" name="generar" id="generar" value="Generar Fórmula"/></td>
  </tr>
  <tr>
    <td align="center"><br />';
	echo '<span class="subtitulo">ó ';
	if ($id_proyecto=="0") { echo '<a href="formulas.php">Cancelar</a>'; } else { echo '<a href="proyecto.php?id='.$id_proyecto.'#contenido">Cancelar</a>'; }
	echo '</span></td>
  </tr>
</table></form>';
}
?>
      <br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Costos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Busqueda de Insumo -->
<script>
function loadXMLDoc()
	{
		var xmlhttp;
		var n=document.getElementById('buscar').value;
		if(n==''){
			document.getElementById("resultado").innerHTML="";
			return;
	}
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("resultado").innerHTML=xmlhttp.responseText;
		}
		else {
			document.getElementById("resultado").innerHTML='<img src="imagenes/loading.gif" width="16" height="11" />';
			}
		}
		xmlhttp.open("POST","engines/registro_costo.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#684B8D">&nbsp;</td>
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
    <td align="center" class="titulo">Costos</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td width="500" class="factura-texto4">Registrar Costo</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
    <?php
    if ($cambiohoy_num==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/moneda.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No se ha definido el <b>Tipo de Cambio</b> del día de hoy. Indique el <a href="tipo_cambio.php#registrar">Tipo de Cambio</a> primero para registrar nuevos <b>Costos</b>.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<table width="550" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr>
            <td>Registrar costo para el insumo:</td>
          </tr>
          <tr>
            <td><input name="buscar" type="text" required="required" class="textbox" id="buscar" placeholder="Ejemplo: 10100201 ó Ácido Cítrico" autocomplete="off" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
          </tr>
        </table>
        <br />
      <div id="resultado"></div>';
		  }
	  ?>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="incrementables" id="incrementables"></a>Costos esperando incrementables</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php
	$costosinc=mysql_query("
	SELECT tcinsumos.id_insumo, tcinsumos.codigo, tcinsumos.nombre, tmcostos.id_costo, tmcostos.fecha_alta, tmcostos.hora_alta, tmcostos.moneda, tmcostos.c_pesos, tmcostos.c_dolares, tcusuarios.nombre AS nombre_usuario
	FROM tmcostos
	JOIN tcinsumos, tcusuarios
	WHERE tmcostos.id_insumo = tcinsumos.id_insumo AND tmcostos.id_usuario = tcusuarios.id_usuario AND tmcostos.incrementables='1' ORDER BY id_costo DESC", $conexion);
	$numero_costosinc=mysql_num_rows($costosinc);
	  if ($numero_costosinc==0){
		  echo '
		  <br/><table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
		  	<tr>
        <td align="center"><img src="imagenes/costos.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Costos</strong> en espera de <strong>incrementables</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<br/><table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr class="encabezado-tabla">
          <td width="110">Código del Insumo</td>
          <td width="300">Nombre del Insumo</td>
          <td width="145"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha de Alta</td>
          <td width="135">Costo</td>
          <td width="140"><img src="imagenes/user.png" width="18" height="18" /> Registrado por</td>
          <td width="120" align="center">Incrementables</td>
        </tr>';
		  while($filaci=mysql_fetch_array($costosinc))
		  {
			  echo '
			  <tr>
			  	<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
			</tr>
			  <tr class="celda-activa">
			  	<td>'.$filaci['codigo'].'</td>
				<td><a href="insumo.php?id='.$filaci['id_insumo'].'#contenido" class="link">'.$filaci['nombre'].'</a></td>
				<td>'.$filaci['fecha_alta'].' | '.$filaci['hora_alta'].'</td>';
				if ($filaci['moneda']=="2")
				{
					echo '<td>$ '.number_format($filaci['c_dolares'],4,".",",").' <img src="imagenes/usa-min.png" width="17" height="13" /></td>';
				}
				else {
					echo '<td>$ '.number_format($filaci['c_pesos'],4,".",",").' <img src="imagenes/mexico-min.png" width="17" height="13" /></td>';
				}
				echo '<td>'.$filaci['nombre_usuario'].'</td>';
				if ($tipo_usuario<>"Administrador"){
					echo '<td align="center">En espera</td>';
				}
				else { 
					echo '<td align="center"><a href="incrementable.php?id='.$filaci['id_costo'].'#contenido">Registrar</a></td>';
					}
			echo '</tr>';
		  }
		  echo '</table>';
	  }
	  ?>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="ultimos" id="ultimos"></a>Últimos costos registrados</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <br />
    <?php
	$costos=mysql_query("SELECT * FROM tmcostos WHERE incrementables='0' OR incrementables='2' ORDER BY id_costo DESC LIMIT 5",$conexion);
	$numero_costos=mysql_num_rows($costos);
	  if ($numero_costos==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/costos.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Costos</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<table width="900" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<td align="center"><a href="engines/exportar_costos.php"><img src="imagenes/exportar_costos.png" border="0" class="opacidad-accion"></a></td>
		</tr>
      </table><br/>';
		  while($filac=mysql_fetch_array($costos))
		  {
		echo '		
		<table width="950" border="0" cellspacing="0" cellpadding="0">
        <tr class="celda-activa2">
          <td><br />
            <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="85" align="center" valign="top"><img src="imagenes/avatar'.$filac['id_usuario'].'.png" width="80" height="80" /></td>
              <td width="815" valign="top"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="370" class="factura-texto2"><strong>';
				  $idusucosto = $filac['id_usuario'];
				  $usucosto = "SELECT * FROM tcusuarios WHERE id_usuario=$idusucosto";
				  $datos=mysql_query($usucosto, $conexion) or die(mysql_error());
				  $arrayusucosto = mysql_fetch_object($datos);
				  echo $arrayusucosto->nombre;
				  echo '</strong> indicó el costo:</td>
                  <td width="394" align="right">'.$filac['fecha_alta'].' | '.$filac['hora_alta'].' horas <strong>(Folio: '.$filac['id_costo'].')</strong></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="imagenes/linea-800.png" width="800" height="1" /></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><br />
                    <table width="780" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td colspan="4" align="center" class="factura-texto3"><strong>';
				  $idinscosto = $filac['id_insumo'];
				  $inscosto = "SELECT * FROM tcinsumos WHERE id_insumo=$idinscosto";
				  $datos=mysql_query($inscosto, $conexion) or die(mysql_error());
				  $arrayinscosto = mysql_fetch_object($datos);
				  echo $arrayinscosto->nombre;
					  echo '</strong><br/><span class="subtitulo"><a href="proveedor.php?id='.$filac['id_proveedor'].'#contenido" class="link-min">';
				  $idpro = $filac['id_proveedor'];
				  $proveedor = "SELECT * FROM tcproveedores WHERE id_proveedor=$idpro";
				  $datos=mysql_query($proveedor, $conexion) or die(mysql_error());
				  $arraypro = mysql_fetch_object($datos);
				  echo $arraypro->nombre;
					  echo '</a></span></td>
                    </tr>
                    <tr>
                      <td width="195" align="center"><strong><span class="factura-texto3">$ '.number_format($filac['valor_pesos'],4,".",",").'</span></strong><br />
                        (MXN - $) <img src="imagenes/mexico-min.png" width="16" height="12" /> '; if ($filac['moneda']=="1") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
                      <td width="195" align="center"><strong><span class="factura-texto3">$ '.number_format($filac['valor_dolares'],4,".",",").'</span></strong><br />
                        (USD - $) <img src="imagenes/usa-min.png" width="17" height="13" /> '; if ($filac['moneda']=="2") {echo ' <img src="imagenes/pin.png" title="Moneda de Origen">';} echo '</td>
                      <td width="195" align="center"><strong><span class="factura-texto3">$ '.$filac['tcaplicado'].'</span></strong><br />
                        Tipo de Cambio Aplicado</td>
                      <td width="195" align="center" valign="top"><a href="insumo.php?id='.$filac['id_insumo'].'#contenido"><input name="insumo" type="button" class="boton-costo-insumo" id="insumo" value="Ver Insumo" /></a></td>
                    </tr>
                    </table>';
					if ($filac['incrementables']=="2")
					{
						echo '<br/><span class="finalizado">Incluye incrementables</span><br/>';	
					}
                    echo' <br /></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="imagenes/linea-800.png" width="800" height="1" /></td>
                </tr>
                <tr>
                  <td colspan="2"><strong><span class="factura-texto2"><img src="imagenes/comentario.png"> Comentario:</span></strong><br />'.$filac['comentario'].'</td>
                </tr>
                </table></td>
            </tr>
          </table>            <br /></td>
        </tr>
      </table><br/>';
		  }  
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
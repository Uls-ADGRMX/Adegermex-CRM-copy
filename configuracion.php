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
// Consulta para información de Parámetros ////////////
///////////////////////////////////////////////////////
$configuracion = "SELECT * FROM tmconfiguracion WHERE id_configuracion='1'";
$info=mysql_query($configuracion, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$asignar_cliente = $infoarray->asignar_cliente;
$orden_potencial = $infoarray->orden_potencial;
$eliminados = $infoarray->eliminados;
$pbi = $infoarray->pbi;
$pbf = $infoarray->pbf;
$pmi = $infoarray->pmi;
$pmf = $infoarray->pmf;
$pai = $infoarray->pai;
$paf = $infoarray->paf;
$noti1 = $infoarray->noti1;
$noti2 = $infoarray->noti2;
$noti3 = $infoarray->noti3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Configuración</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Validación de Potencial de Negocio -->
<script type="text/javascript">
function calcular () {
	try {
		var
		b = parseFloat(document.getElementById("pbf").value) || 0,
		d = parseFloat(document.getElementById("pmf").value) || 0
		
		document.getElementById("pmi").value = b + 1;
		document.getElementById("pai").value = d + 1;
		}
		catch (e) {}
	}
function vpbf () {
	try {
		var
		a = parseFloat(document.getElementById("pbi").value) || 0,
		b = parseFloat(document.getElementById("pbf").value) || 0
		if (b<a)
		{
			alert("El valor final del potencial bajo es menor al inicial.");
			document.getElementById("pbf").value = a + 1;
			
		}
		}
		catch (e) {}
	}
function vpmf () {
	try {
		var
		c = parseFloat(document.getElementById("pmi").value) || 0,
		d = parseFloat(document.getElementById("pmf").value) || 0
		if (d<c)
		{
			alert("El valor final del potencial medio es menor al inicial.");
			document.getElementById("pmf").value = c + 1;
		}
		}
		catch (e) {}
	}
function vpaf () {
	try {
		var
		e = parseFloat(document.getElementById("pai").value) || 0,
		f = parseFloat(document.getElementById("paf").value) || 0
		if (f<e)
		{
			alert("El valor final del potencial alto es menor al inicial.");
			document.getElementById("paf").value = e + 1;			
		}
		}
		catch (e) {}
	}
</script>
<!-- Checks -->
<script type="text/javascript">
	function mostrarRecalcular() {
        element = document.getElementById("divrecalcular");
        check = document.getElementById("recalcular");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#663300">&nbsp;</td>
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
    <td align="center" class="titulo">Configuración</td>
  </tr>
</table>
<br />
<div class="tabcontent">
<form action="engines/configurar.php" method="post">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Notificaciones</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Enviar notificación al publicar un nuevo comentario en los Proyectos</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="noti1" name="noti1" <?php if ($noti1=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Enviar notificación al publicar un nuevo seguimiento en los Clientes</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="noti3" name="noti3" <?php if ($noti3=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Enviar notificación al registrar un nuevo costo que requiere incrementables</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="noti2" name="noti2" <?php if ($noti2=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br /></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Exportaciones</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Exportar listado de Proyectos</td>
            <td width="200" align="right"><a href="engines/exportar_proyectos.php"><input name="exportar_proyectos" type="button" class="boton-costo-insumo" id="exportar_proyectos" value="Generar Archivo" /></a></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Exportar registro de Eventos</td>
            <td width="200" align="right"><a href="engines/exportar_eventos.php"><input name="exportar_eventos" type="button" class="boton-costo-insumo" id="exportar_eventos" value="Generar Archivo" /></a></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Exportar listado de Costos</td>
            <td width="200" align="right"><a href="engines/exportar_costos.php"><input name="exportar_costos" type="button" class="boton-costo-insumo" id="exportar_costos" value="Generar Archivo" /></a></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
      </table>
        <br /></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Clientes</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Asignar cliente automáticamente al usuario que genera el alta</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="asignar_cliente" name="asignar_cliente" <?php if ($asignar_cliente=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br /></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Proyectos</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">Ordenar proyectos por  potencial de negocio en el panel de proyectos</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="orden_potencial" name="orden_potencial" <?php if ($orden_potencial=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="700" class="factura-texto3">No mostrar proyectos Eliminados en el panel de proyectos</td>
            <td width="200" align="right"><label class="switch">
              <input type="checkbox" id="eliminados" name="eliminados" <?php if ($eliminados=="0") {} else { echo 'checked="checked"';} ?>/>
              <span class="sliders round"></span></label></td>
          </tr>
          <tr>
            <td colspan="2" class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="900" border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td class="factura-texto3">Definir potencial de negocio (USD - Dólares)</td>
          </tr>
          <tr>
            <td class="factura-texto3"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
          <tr>
            <td class="factura-texto3"><table width="600" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td>Potencial Bajo <img src="imagenes/baja.png" width="8" height="12" /></td>
                <td align="center">$
                  <input name="pbi" type="number" class="textbox-min" id="pbi" value="<?php echo $pbi; ?>" step="1" min="0" autocomplete="off" required="required" readonly="readonly"/></td>
                <td align="center" class="encabezado-tabla">a</td>
                <td align="center">$
                  <input name="pbf" type="number" class="textbox-min" id="pbf" value="<?php echo $pbf; ?>" oninput="calcular()" onfocusout="vpbf()" required="required"/></td>
              </tr>
              <tr>
                <td>Potencial Medio <img src="imagenes/normal.png" width="8" height="12" /></td>
                <td align="center">$
                  <input name="pmi" type="number" class="textbox-min" id="pmi" value="<?php echo $pmi; ?>" step="1" min="1" autocomplete="off" required="required" readonly="readonly"/></td>
                <td align="center" class="encabezado-tabla">a</td>
                <td align="center">$
                  <input name="pmf" type="number" class="textbox-min" id="pmf" value="<?php echo $pmf; ?>" oninput="calcular()" onfocusout="vpmf()" required="required"/></td>
              </tr>
              <tr>
                <td>Potencial Alto <img src="imagenes/alta.png" width="9" height="12" /></td>
                <td align="center">$
                  <input name="pai" type="number" class="textbox-min" id="pai" value="<?php echo $pai; ?>" step="1" min="1" autocomplete="off" required="required" readonly="readonly"/></td>
                <td align="center" class="encabezado-tabla">a</td>
                <td align="center">$
                  <input name="paf" type="number" class="textbox-min" id="paf" value="<?php echo $paf; ?>" oninput="calcular()" onfocusout="vpaf()"/></td>
              </tr>
            </table>
              <br />
              <table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="70" align="center" class="subtitulo"><label class="switch"><input type="checkbox" name="recalcular" id="recalcular" onchange="javascript:mostrarRecalcular()"/><span class="sliders round"></span></label></td>
                  <td width="380" class="subtitulo">Recalcular el potencial de negocio de todos los proyectos activos</td>
                </tr>
              </table>
              <br />
              <div id="divrecalcular" style="display: none;"><table width="700" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr>
                  <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
                    <br />
                    Este proceso modificara el potencial de negocio de todos los proyectos activos en el sistema con excepción de los proyectos <strong>Eliminados</strong> y <strong>Finalizados</strong>.<br/><br/>El proceso tardara unos instantes en completarse.</td>
                </tr>
              </table></div></td>
          </tr>
        </table>
        <br /></td>
    </tr>
</table>
  <br />
  <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
    <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar Cambios" /></td>
  </tr>
</table>
</form>
  <br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
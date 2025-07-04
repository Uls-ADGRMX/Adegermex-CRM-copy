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
<!-- Busqueda de Insumo -->
<script>
function loadXMLDoc()
	{
		var xmlhttp;
		var n=document.getElementById('buscar').value;
		if(n==''){
			document.getElementById("resultado").innerHTML="<span class='titulo'>&nbsp;</span>";
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
			
			}
		}
		xmlhttp.open("POST","engines/buscar_simulador.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
</script>
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
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Generar Simulación</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br /><form action="simulacion.php#contenido" method="post" name="simular">
        <div id="Descripcion" class="tabcontent">
        <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Descripcion')" id="defaultOpen" hidden="hidden"></a>
        <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50" align="center"><img src="imagenes/1-activo-azul.png" width="39" height="40" /></td>
            <td width="162" class="encabezado-tabla">Descripción General</td>
            <td width="50" align="center"><img src="imagenes/2-inactivo.png" width="39" height="40" /></td>
            <td width="162" class="subtitulo">Seleccionar Insumo</td>
            <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
            <td width="162" class="subtitulo">Indicar Costo simulado</td>
            <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
            <td width="164" class="subtitulo">Resultados e indicadores</td>
          </tr>
        </table>
        <br />
        <table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center"><img src="imagenes/simulacion.png" width="180" height="180" /></td>
          </tr>
          <tr>
            <td align="center" class="factura-texto2"><strong>¿Que función tiene el Simulador?</strong></td>
          </tr>
          <tr>
            <td class="factura-texto2">El proceso de simulación, ayudara a conocer  el impacto que tiene el incremento o decremento del costo de un insumo en cada una de las fórmulas en las que es utilizado.<br/></td>
          </tr>
        </table>
        <br />
		<?php
        if ($cambiohoy_num==0){
			echo '<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mensaje-correcto">Para generar un proceso de simulación, verifique que los siguientes parámetros estén capturados en el sistema:<br/><br/>- <strong>Tipo de Cambio</strong> del día de Hoy.<br/>- <strong>Insumos</strong> registrados en el sistema.<br/>- Formulaciones registradas como <strong>Maestras</strong>.</td>
  </tr>
</table>';
			}
		else {
			echo '<table width="850" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, ';
			echo "'Insumo'";
			echo ')"><input name="iniciar" type="button" class="boton-caprobar" id="iniciar" value="¡Iniciar Simulación!" /></a></td>
          </tr>
        </table>';
		}
		?>
</div>
        <div id="Insumo" class="tabcontent">
          <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
            <td width="162" class="subtitulo">Descripción General</td>
            <td width="50" align="center"><img src="imagenes/2-activo-azul.png" width="39" height="40" /></td>
            <td width="162" class="encabezado-tabla">Seleccionar Insumo</td>
            <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
            <td width="162" class="subtitulo">Indicar Costo simulado</td>
            <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
            <td width="164" class="subtitulo">Resultados e indicadores</td>
          </tr>
        </table>
        <br />
        <br />
        <table width="570" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td align="center" class="factura-texto3"><img src="imagenes/insumo_detalle.png" width="100" height="100" /></td>
          </tr>
          <tr>
            <td align="center" class="factura-texto3"><strong>Nombre o código del Insumo</strong></td>
          </tr>
          <tr>
            <td align="center"><input name="buscar" type="text" class="textbox" id="buscar" autocomplete="off" placeholder="Ejemplo: 10100201 ó ACIDO CITRICO" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
          </tr>
        </table>
        <br />
        <div id="resultado">
<span class="titulo">&nbsp;</span>
        </div>
        <br />
        <table width="850" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Costo')"><input name="paso3" type="button" class="boton-caprobar" id="paso3" value="Continuar (Paso 3)" /></a></td>
          </tr>
          <tr>
            <td align="center" class="subtitulo"><br />ó <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Descripcion')">Cancelar</a></td>
          </tr>
        </table>
        </div>
        <div id="Costo" class="tabcontent">
          <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Descripción General</td>
              <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Seleccionar Insumo</td>
              <td width="50" align="center"><img src="imagenes/3-activo-azul.png" width="39" height="40" /></td>
              <td width="162" class="encabezado-tabla">Indicar Costo simulado</td>
              <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
              <td width="164" class="subtitulo">Resultados e indicadores</td>
            </tr>
          </table>
          <br />
          <br />
          <table width="700" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td align="center" class="factura-texto3"><strong>Costo simulado del Insumo</strong></td>
            </tr>
          </table>
          <table width="700" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="210" align="center"><span class="factura-texto-min">Costo</span><br />                
              <input name="valor" type="number" class="textbox-min-moneda" id="valor" placeholder="$" step="0.0001" min="0.0001" max="999999.9999" value="1"/></td>
              <td width="280" align="center"><img src="imagenes/linea-conversion.png" width="280" height="45" /></td>
              <td width="210"><table width="160" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr>
                  <td width="120" align="center"><img src="imagenes/mexico.png" width="41" height="30" /><br />
                  <span class="factura-texto-min">MXN</span></td>
                  <td width="100" align="center"><img src="imagenes/usa.png" width="40" height="30" /><br />
                    <span class="factura-texto-min">USD</span></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><select name="moneda" class="textbox-min" id="moneda">
                  <option value="1">Pesos</option>
                  <option value="2">Dólares</option>
                  </select></td>
                </tr>
              </table></td>
            </tr>
          </table>
          <br />
          <br />
          <table width="850" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="#">
                <input name="ejecutar" type="button" class="boton-caprobar" id="ejecutar" value="¡Ejecutar simulación!" onclick="simular.submit()"/>
              </a></td>
            </tr>
            <tr>
              <td align="center" class="subtitulo"><br />
              <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Insumo')">Volver (Paso 2)</a> ó <a href="simulador.php">Cancelar</a></td>
            </tr>
          </table>
        </div></form><script>
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
</script>
        <br />
<br /></td>
    </tr>
  </table>
  <br />
  <?php include "footer.php"; ?><br/>
</body>
</html>
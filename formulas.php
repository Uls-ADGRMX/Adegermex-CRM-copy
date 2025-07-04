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
<title>Adegermex S.A. de C.V. | Fórmulas</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Busqueda de Cliente -->
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
		xmlhttp.open("POST","engines/buscar_formula.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("q="+n);
}
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
<div class="tabcontent">
<?php if($tipo_usuario=="Administrador" OR $tipo_usuario=="Desarrollador"){
	echo '<br/>
		<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
			<tr>
			<td align="center"><a href="generar_formula.php?id=0#contenido"><input class="boton-login" type="submit" name="generar" id="generar" value="Generar Nueva Fórmula"/></a></td>
			</tr>
		</table>';
		}
else{
	}
	?>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Buscar fórmula</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br />
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Buscar</td>
        </tr>
        <tr>
          <td><input name="buscar" type="text" required="required" class="textbox" id="buscar" placeholder="Nombre de la fórmula ó código de control interno" autocomplete="off" onkeyup="loadXMLDoc()" autofocus="autofocus"/></td>
        </tr>
      </table>
      <br />
      <div id="resultado"></div>
      <br/>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Últimas 15 fórmulas generadas</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
      	<br />
        <?php
	  $formulas=mysql_query("SELECT * FROM tmformulas ORDER BY id_formula DESC LIMIT 15",$conexion);
	  $numero_formulas=mysql_num_rows($formulas);
	  if ($numero_formulas==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/formula.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Fórmulas</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
          <tr class="encabezado-tabla">
            <td width="70">Folio</td>
            <td width="340">Nombre de la Fórmula / Producto</td>
            <td width="160"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
            <td width="180">Código de control interno</td>
			<td width="80">Status</td>
            <td width="100" align="center">Opciones</td>
          </tr>';
		  while($fila=mysql_fetch_array($formulas)){
		  echo '
          <tr>
            <td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
          </tr>
          <tr class="celda-activa">
            <td valign="top">'.$fila['id_formula'].'</td>
            <td valign="top"><a href="formula.php?id='.$fila['id_formula'].'#contenido" class="link">'.$fila['nombre_formula'].'</a>';
			if ($fila['master']=="1") {echo ' <img src="imagenes/estrella.png" width="14" height="14" title="Fórmula Maestra">';} else {} 
			echo '</td>
            <td valign="top">'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
            <td valign="top">'.$fila['codigo_interno'].'</td>
            <td valign="top">';
			if ($fila['status']=="Activa") { echo '<span class="autorizado">'.$fila['status'].'</span>'; } else { echo '<span class="eliminado">'.$fila['status'].'</span>'; }
			echo '</td>
            <td align="center" valign="top"><table width="60" border="0" cellspacing="0" cellpadding="0">
              <tr>';
			  echo '<td align="center"><a href="formula.php?id='.$fila['id_formula'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" title="Detalles"/></a></td>
              </tr>
            </table></td>
          </tr>';
		  }
		  echo'</table>';
	  }
	  ?>
      <br />
</td>
    </tr>
  </table>
  <br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
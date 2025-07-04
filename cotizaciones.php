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
<title>Adegermex S.A. de C.V. | Cotizaciones</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
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
<div class="tabcontent">
	<?php
if($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario"){
	echo '
	<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr>
			<td align="center">
				<a href="generar_cotizacion.php#contenido"><input class="boton-login" type="submit" name="agregar" id="agregar" value="Generar nueva Cotización"/></a>
			</td>
		</tr>
	</table>
	<br />';
}
?>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Últimas 50 cotizaciones generadas</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
<?php
	if($tipo_usuario=="Superusuario")
	{
	  $cotizaciones=mysql_query("
	  SELECT tmcotizaciones.*, tcclientes.id_cliente, tcclientes.nombre AS cliente
	  FROM tmcotizaciones
	  JOIN tcclientes
	  WHERE tmcotizaciones.id_cliente = tcclientes.id_cliente AND tmcotizaciones.id_usuario = '$id_usuario' ORDER BY id_cotizacion DESC LIMIT 50",$conexion);
	 }
	else {
	  $cotizaciones=mysql_query("
	  SELECT tmcotizaciones.*, tcclientes.id_cliente, tcclientes.nombre AS cliente
	  FROM tmcotizaciones
	  JOIN tcclientes
	  WHERE tmcotizaciones.id_cliente = tcclientes.id_cliente ORDER BY id_cotizacion DESC LIMIT 50",$conexion);
	}
	  $numero_cotizaciones=mysql_num_rows($cotizaciones);
	  if ($numero_cotizaciones==0){
		  echo '<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><img src="imagenes/cotizaciones.png" width="180" height="180" /></td>
      </tr>
      <tr>
        <td align="center" class="factura-texto2">No hay registros de <strong>Cotizaciones</strong> para mostrar.</td>
      </tr>
    </table>';
	  }
	  else {
		  echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
          <tr class="encabezado-tabla">
            <td width="70">Folio</td>
            <td width="390">Nombre del Cliente / Prospecto</td>
            <td width="160"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
            <td width="140">Moneda</td>
			<td width="70">Status</td>
            <td width="100" align="center">Opciones</td>
          </tr>';
		  while($fila=mysql_fetch_array($cotizaciones)){
		  echo '
          <tr>
            <td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
          </tr>
          <tr class="celda-activa">
            <td valign="top">'.$fila['id_cotizacion'].'</td>
            <td valign="top"><a href="cotizacion.php?id='.$fila['id_cotizacion'].'#contenido" class="link">'.$fila['cliente'].'</a></td>
            <td valign="top">'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
            <td valign="top">';
			if ($fila['moneda']=="1") { echo 'Pesos <img src="imagenes/mexico-min.png">'; } else { echo 'Dolares <img src="imagenes/usa-min.png">'; }
			echo '</td>';
			echo '<td valign="top">';
			if ($fila['status']=="Activa") { echo '<span class="autorizado">'.$fila['status'].'</span>'; } else { echo '<span class="eliminado">'.$fila['status'].'</span>'; }
			echo '</td>
            <td align="center" valign="top"><table width="60" border="0" cellspacing="0" cellpadding="0">
              <tr>';
			  echo '<td align="center"><a href="cotizacion.php?id='.$fila['id_cotizacion'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" title="Detalles"/></a></td>
              </tr>
            </table></td>
          </tr>';
		  }
		  echo'</table>';
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
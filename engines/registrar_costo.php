<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Zona Horaria predeterminada ////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
///////////////////////////////////////////////////////
// PHPMailer //////////////////////////////////////////
///////////////////////////////////////////////////////
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../scripts/phpmailer/PHPMailer.php';
require '../scripts/phpmailer/SMTP.php';
require '../scripts/phpmailer/Exception.php';
///////////////////////////////////////////////////////
// Consulta para información de Parámetros ////////////
///////////////////////////////////////////////////////
$configuracion = "SELECT * FROM tmconfiguracion WHERE id_configuracion='1'";
$info=mysql_query($configuracion, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$noti2 = $infoarray->noti2;
///////////////////////////////////////////////////////
// Tipo de Cambio del día de Hoy //////////////////////
///////////////////////////////////////////////////////
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$arraythoy = mysql_fetch_object($cambiohoy);
$tcaplicado = $arraythoy->valor;
///////////////////////////////////////////////////////
// Variables y valores del Costo //////////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$id_insumo = $_POST['id_insumo'];
$proveedor = $_POST['proveedor'];
$valor = $_POST['costo'];
$moneda = $_POST['moneda'];
if (isset($_POST['incrementa'])){
	$incrementables = "1";
	$cinc_pesos = "0";
	$cinc_dolares = "0";
	$valor_pesos = "0";
	$valor_dolares = "0";
	if ($moneda=="1")
	{
		$c_pesos = $valor;
		$c_dolares = $valor / $tcaplicado;
	}
	else 
	{
		$c_dolares = $valor;
		$c_pesos = $valor * $tcaplicado;
	}
}
else {
	$incrementables = "0";
	$c_pesos = "0";
	$c_dolares = "0";
	$cinc_pesos = "0";
	$cinc_dolares = "0";
	if ($moneda=="1")
	{
		$valor_pesos = $valor;
		$valor_dolares = $valor / $tcaplicado;
	}
	else 
	{
		$valor_dolares = $valor;
		$valor_pesos = $valor * $tcaplicado;
	}
}
$incoterm = $_POST['incoterm'];
$pais = $_POST['pais'];
if (empty($ciudad)){
	$ciudad = "No definido";	
}
else {
	$ciudad = strtoupper($_POST['ciudad']);
}
if (empty($_POST['cantidad'])){
	$cantidad = "0";	
}
else {
	$cantidad = $_POST['cantidad'];
}
$transporte = $_POST['transporte'];
if (empty($_POST['comentario'])){
	$comentario = "Sin Comentarios";	
}
else {
	$comentario = ucfirst($_POST['comentario']);
}
///////////////////////////////////////////////////////
// Insertar Nuevo Costo ///////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmcostos (id_insumo, id_proveedor, id_usuario, moneda, valor_pesos, valor_dolares, incrementables, incoterm, pais, ciudad, cantidad, transporte, c_pesos, c_dolares, cinc_pesos, cinc_dolares, tcaplicado, comentario, fecha_alta, hora_alta)
					VALUES ('$id_insumo', '$proveedor', '$id_usuario', '$moneda' ,'$valor_pesos', '$valor_dolares', '$incrementables', '$incoterm', '$pais', '$ciudad', '$cantidad', '$transporte', '$c_pesos', '$c_dolares', '$cinc_pesos', '$cinc_dolares', '$tcaplicado','$comentario', '$fecha','$hora')", $conexion);
		if (!$insertar) {
			echo '<script language="javascript">alert("Cation : Costos\n\nError de inserción del registro de costo")</script>';
			echo "<script language='javascript'>window.location='../costos.php'</script>";
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
		else {
			}
///////////////////////////////////////////////////////
// Enviar notificación ////////////////////////////////
///////////////////////////////////////////////////////
if ($incrementables=="1" AND $noti2=="1")
{
$datos=mysql_query("SELECT * FROM tcinsumos WHERE id_insumo=$id_insumo", $conexion) or die(mysql_error());
$arrayinsumo = mysql_fetch_object($datos);
$codigo = $arrayinsumo->codigo;
$nombre_insumo = $arrayinsumo->nombre;
$datos_usuario=mysql_query("SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario", $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos_usuario);
$nombre_usuario = $arrayusuario->nombre;
if ($moneda=="1")
{
	$costo = number_format($c_pesos,4,".",",");
	$mon = "MXN";
}
else
{
	$costo = number_format($c_dolares,4,".",",");
	$mon = "USD";
}
$destinos = mysql_query("
SELECT tcusuarios.correo
FROM tcusuarios
WHERE tcusuarios.tipo_usuario='Administrador' OR tcusuarios.tipo_usuario='Agente de Compras' AND tcusuarios.status='Activo'",$conexion);
$mail = new PHPMailer(true);
try {
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host       = 'mail.crmadegermex.com.mx';
$mail->SMTPAuth   = true;
$mail->Username   = 'notificaciones@crmadegermex.com.mx';
$mail->Password   = 'n0t1f1c4c10n3s';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->CharSet    = 'UTF-8';
$mail->setFrom('notificaciones@crmadegermex.com.mx', 'Adegermex S.A. de C.V. Proyectos I+D CRM');
while($ds=mysql_fetch_array($destinos)){
	$correo = $ds['correo'];
	$mail->addAddress($correo);
}
$mail->isHTML(true);
$mail->Subject = 'Adegermex S.A. de C.V. Proyectos I+D CRM : Un nuevo costo requiere incrementables';
$mail->Body    = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adegermex S.A. de C.V. Proyectos I+D CRM : Un nuevo costo requiere incrementables</title>
<style>
body {
	font-family: Georgia, "Times New Roman", Times, serif;
	color:#000;
}
.sombra {
	box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
}
.link-min {
	color: #00A672;
	text-decoration:none;
	font-size:11px;
}
.link-min:hover {
	color: #00A672;
	text-decoration:underline;
}
.texto-titulo{
	font-weight:bolder;
	font-size:19px;	
}
.texto-general{
	font-size:12px;	
}
.boton-login{
	width:480px;
	height:40px;
	background:#00A672;
	border: 1px solid white;
	color:#FFF;
	cursor:pointer;
	text-align:center;
}
.boton-login:hover{
	background:#FFF;
	border: 1px solid #00A672;
	color:#00A672;
	text-align:center;
}
</style>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
    <br />
    <br />
    <br />
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><br>
          <br>
          <img src="https://www.crmadegermex.com.mx/imagenes/adegermex-logo.png" width="337" height="80"><br>
          <br>
          <br>
          <span class="texto-titulo">¡Un nuevo costo requiere incrementables!</span><br>
          <br>
          <br>
          <table width="550" border="0" cellspacing="2" cellpadding="4">
            <tr>
              <td width="180" align="right" bgcolor="#F5F5F5" class="texto-general"><span class="texto-general">Código del Insumo:</span></td>
              <td width="354" valign="top">'.$codigo.'</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#F5F5F5" class="texto-general">Nombre del Insumo:</td>
              <td valign="top">'.$nombre_insumo.'</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#F5F5F5" class="texto-general">Costo:</td>
              <td valign="top">$ '.$costo.' '.$mon.'</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="texto-general">&nbsp;</td>
              </tr>
            <tr>
              <td align="right" bgcolor="#F5F5F5" class="texto-general">Fecha:</td>
              <td valign="top">'.$fecha.' | '.$hora.' horas</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#F5F5F5" class="texto-general">Usuario:</td>
              <td valign="top">'.$nombre_usuario.'</td>
            </tr>
          </table>
          <br>
          <table width="550" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td class="texto-general"><strong>'.$nombre_usuario.'</strong> comentó:</td>
            </tr>
            <tr>
              <td><img src="https://www.crmadegermex.com.mx/imagenes/linea-800.png" width="540" height="1"></td>
            </tr>
            <tr>
              <td valign="top" class="texto-general">'.$comentario.'</td>
            </tr>
          </table>
          <br>
          <br>
          <a href="https://www.crmadegermex.com.mx/costos.php#incrementables" target="_blank">
          <input name="ver" type="submit" class="boton-login" id="ver" value="Ver costos esperando incrementables">
          </a>          
          <br>
          <br>
          <br></td>
      </tr>
    </table>
    <br />
    <table width="550" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><span class="texto-general">© Adegermex S.A. de C.V. Todos los Derechos Reservados</span><br/><a href="https://www.adegermex.com.mx/" target="_blank" class="link-min">www.adegermex.com.mx</a></td>
      </tr>
    </table>
    <br />
    <br /></td>
  </tr>
</table>
</body>
</html>';
$mail->send();
}
catch (Exception $e)
{
}
}	
///////////////////////////////////////////////////////
// Redirección a página de confirmación ///////////////
///////////////////////////////////////////////////////		
echo '<script language="javascript">alert("Cation : Costos\n\nSe registró el costo correctamente.")</script>';
if ($incrementables=="1")
{
	echo "<script language='javascript'>window.location='../costos.php#incrementables'</script>";
}
else {
	echo "<script language='javascript'>window.location='../costos.php#ultimos'</script>";
}
///////////////////////////////////////////////////////
// Cierre de la conexión con la base de datos /////////
///////////////////////////////////////////////////////	
mysql_close($conexion);
?>
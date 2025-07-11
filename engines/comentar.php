<?php
///////////////////////////////////////////////////////
// Conexión a la Base de Datos ////////////////////////
///////////////////////////////////////////////////////
include '../scripts/conexion.php';
///////////////////////////////////////////////////////
// Fecha y Hora actual ////////////////////////////////
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
$noti1 = $infoarray->noti1;
$noti3 = $infoarray->noti3;
///////////////////////////////////////////////////////
// Función para eliminar acentos y ñ //////////////////
///////////////////////////////////////////////////////
function formato($cadena){
	$cadena = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	$cadena);
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	$cadena );
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	$cadena );
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	$cadena );
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	$cadena );
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
	$cadena	
    );
    return $cadena;
}
///////////////////////////////////////////////////////
// Variables y valores del Comentario /////////////////
///////////////////////////////////////////////////////
$id_usuario = $_POST['id_usuario'];
$id_proyecto = $_POST['id_proyecto'];
$id_cliente = $_POST['id_cliente'];
$tipo_evento = $_POST['tipo_evento'];
$comentario = $_POST['comentario'];
$comentario = ucfirst($comentario);
///////////////////////////////////////////////////////
// Archivo adjunto ////////////////////////////////////
///////////////////////////////////////////////////////
if ($id_proyecto=="0")
{
	$directorio = '../adjuntos/clientes/';	
}
else {
	$directorio = '../adjuntos/proyectos/';	
}
$fecha_archivo = date("ymdHis");
$nombre = $_FILES['adjuntar']['name'];
$nombre_mod = formato($nombre);
$nombre_mod = preg_replace('([^A-Za-z0-9 .])','',$nombre_mod);
$nombre_mod = $fecha_archivo."_".$nombre_mod;
$ruta = $directorio.$nombre_mod;
	if (move_uploaded_file($_FILES['adjuntar']['tmp_name'], $ruta))
	{
		$nombre_adjunto = $nombre_mod;
		$peso_adjunto = number_format(($_FILES['adjuntar']['size']/1024),2,".",",");
		$tipo_adjunto = $_FILES['adjuntar']['type'];
	}
	else {
		$nombre_adjunto = "0";
		$peso_adjunto = "0";
		$tipo_adjunto = "0";
		echo '<script language="javascript">alert("Cation : Adjuntos\n\nEl archivo adjunto no fue agregado.")</script>';
		}
///////////////////////////////////////////////////////
// Insertar comentario ////////////////////////////////
///////////////////////////////////////////////////////
$insertar = mysql_query("INSERT INTO tmeventos (id_proyecto, id_cliente, id_usuario, tipo_evento, fecha, hora, evento, nombre_adjunto, peso_adjunto, tipo_adjunto)
						VALUES ('{$id_proyecto}', '{$id_cliente}', '{$id_usuario}', '$tipo_evento', '{$fecha}','{$hora}', '{$comentario}', '{$nombre_adjunto}', '{$peso_adjunto}', '{$tipo_adjunto}')", $conexion);
		if (!$insertar) {
			if ($id_proyecto=="0")
				{
					echo '<script language="javascript">alert("Cation : Clientes\n\nError de inserción del Comentario")</script>';
					echo "<script language='javascript'>window.location='../cliente.php?id=".$id_cliente."#comentarios'</script>";
				}
			else {
					echo '<script language="javascript">alert("Cation : Proyectos\n\nError de inserción del Comentario")</script>';
					echo "<script language='javascript'>window.location='../proyecto.php?id=".$id_proyecto."#comentarios'</script>";
			}
			die("Fallo en la insercion de registro en la Base de Datos: " . mysql_error());
			exit();
			}
///////////////////////////////////////////////////////
// Enviar notificación ////////////////////////////////
///////////////////////////////////////////////////////
if ($id_cliente=="0" AND $noti1=="1")
{
$datos=mysql_query("SELECT * FROM tmproyectos WHERE id_proyecto=$id_proyecto", $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
$datos_usuario=mysql_query("SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario", $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos_usuario);
$nombre_usuario = $arrayusuario->nombre;
$destinos = mysql_query("
SELECT tcusuarios.correo
FROM tcusuarios
JOIN tmproyectos
WHERE tmproyectos.id_proyecto=$id_proyecto AND (
tmproyectos.id_usugenera=tcusuarios.id_usuario OR
tmproyectos.id_usuautoriza=tcusuarios.id_usuario OR
tmproyectos.id_usuasignador=tcusuarios.id_usuario OR
tmproyectos.id_usuasignado=tcusuarios.id_usuario OR
tmproyectos.id_usuasignado2=tcusuarios.id_usuario) AND tcusuarios.status='Activo'",$conexion);
$destinos2 = mysql_query("
SELECT tcusuarios.correo
FROM tcusuarios
JOIN tmproyectos
JOIN tcclientes
WHERE tmproyectos.id_proyecto=$id_proyecto AND
(tmproyectos.id_cliente=tcclientes.id_cliente AND tcclientes.id_asignado=tcusuarios.id_usuario) AND tcusuarios.status='Activo'",$conexion);
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
while($ds2=mysql_fetch_array($destinos2)){
	$correo = $ds2['correo'];
	$mail->addAddress($correo);
}
$mail->isHTML(true);
$mail->Subject = 'Adegermex S.A. de C.V. Proyectos I+D CRM : Nuevo Comentario';
$mail->Body    = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adegermex S.A. de C.V. Proyectos I+D CRM : Nuevo Comentario</title>
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
          <span class="texto-titulo">¡Hay un nuevo comentario!</span><br>
          <br>
          <br>
          <table width="550" border="0" cellspacing="2" cellpadding="4">
            <tr>
              <td width="180" align="right" bgcolor="#F5F5F5" class="texto-general"><span class="texto-general">Folio del Proyecto:</span></td>
              <td width="354" valign="top">'.$id_proyecto.'</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#F5F5F5" class="texto-general">Nombre del Proyecto:</td>
              <td valign="top">'.$nombre_proyecto.'</td>
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
          <a href="https://www.crmadegermex.com.mx/proyecto.php?id='.$id_proyecto.'#comentarios" target="_blank">
          <input name="ver" type="submit" class="boton-login" id="ver" value="Ver actividad del proyecto">
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
// Enviar notificación ////////////////////////////////
///////////////////////////////////////////////////////
if ($id_proyecto=="0" AND $noti3=="1")
{
$datos=mysql_query("SELECT * FROM tcclientes WHERE id_cliente=$id_cliente", $conexion) or die(mysql_error());
$arraycliente = mysql_fetch_object($datos);
$nombre_cliente = $arraycliente->nombre;
$datos_usuario=mysql_query("SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario", $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos_usuario);
$nombre_usuario = $arrayusuario->nombre;
$destinos = mysql_query("
SELECT tcusuarios.correo
FROM tcusuarios
JOIN tcclientes
WHERE tcclientes.id_cliente ='$id_cliente' AND (tcclientes.id_asignado = tcusuarios.id_usuario OR (tcusuarios.tipo_usuario='Administrador' AND tcusuarios.status='Activo'))",$conexion);
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
$mail->Subject = 'Adegermex S.A. de C.V. Proyectos I+D CRM : Nuevo Seguimiento a Cliente';
$mail->Body    = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adegermex S.A. de C.V. Proyectos I+D CRM : Nuevo Seguimiento a Cliente</title>
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
          <span class="texto-titulo">¡Hay un nuevo seguimiento a cliente!</span><br>
          <br>
          <br>
          <table width="550" border="0" cellspacing="2" cellpadding="4">
            <tr>
              <td width="180" align="right" bgcolor="#F5F5F5" class="texto-general">Nombre del Cliente:</td>
              <td width="354" valign="top">'.$nombre_cliente.'</td>
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
          <a href="https://www.crmadegermex.com.mx/cliente.php?id='.$id_cliente.'#comentarios" target="_blank">
          <input name="ver" type="submit" class="boton-login" id="ver" value="Ver actividad del cliente">
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
// Redirección ////////////////////////////////////////
///////////////////////////////////////////////////////
if ($id_proyecto=="0")
{
	header('Location: ../cliente.php?id='.$id_cliente.'#comentarios');
}
else {
	header('Location: ../proyecto.php?id='.$id_proyecto.'#comentarios');
}
mysql_close($conexion);
?>
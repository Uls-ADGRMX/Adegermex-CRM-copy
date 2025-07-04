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
// Consulta para información del Proveedor ////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$proveedor = "SELECT * FROM tcproveedores WHERE id_proveedor='$id'";
$info=mysql_query($proveedor, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proveedores</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#196589">&nbsp;</td>
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
    <td align="center" class="titulo">Proveedores</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Información del Proveedor</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/proveedor_info.png" width="100" height="100" /><br />
            <br/><span class="factura-texto4"><strong><?php echo $infoarray->nombre; ?></strong></span><br/>
            <span class="subtitulo">Fecha de Alta: <?php echo "<strong>".$infoarray->fecha_alta."</strong> a las <strong>".$infoarray->hora_alta."</strong> horas"; ?></span></td>
        </tr>
      </table><br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Insumos provistos por el Proveedor</td>
    <td width="500" align="right" class="factura-texto4"><?php
$insxprov=mysql_query("SELECT DISTINCT (tmcostos.id_insumo), tcinsumos.*
FROM tmcostos
JOIN tcinsumos
WHERE tmcostos.id_insumo=tcinsumos.id_insumo AND tmcostos.id_proveedor='$id'",$conexion);
$numeroins=mysql_num_rows($insxprov);
echo $numeroins;
?> insumos en total</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
<?php
if ($numeroins==0){
	echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td align="center"><img src="imagenes/insumo.png" width="180" height="180" /></td>
		</tr>
		<tr>
			<td align="center" class="factura-texto2">No hay registros de <strong>Insumos</strong> provistos por este proveedor.</td>
		</tr></table>';
		}
	else
		{
		echo '<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr class="encabezado-tabla">
		<td width="150">Código</td>
		<td width="370">Nombre del Insumo</td>
		<td width="230">Categoría</td>
		<td width="100">Origen</td>
		<td width="90">Opciones</td>
		</tr>';
		  while($fila=mysql_fetch_array($insxprov)){
			  echo '
			<tr>
			  	<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
			</tr>
			<tr class="celda-activa">
				<td>'.$fila['codigo'].'</td>
				<td><a href="insumo.php?id='.$fila['id_insumo'].'#contenido" class="link">'.$fila['nombre'].'</a></td>
				<td>'.$fila['categoria'].'</td>
				<td>'.$fila['origen'].'</td>
				<td width="90">
					<table width="60" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center" width="35"><a href="insumo.php?id='.$fila['id_insumo'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" class="opacidad-accion" title="Detalles"/></a>
							</td>
						</tr>
					</table>
				</td>
			</tr>';
		}
	  echo '</table>';
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
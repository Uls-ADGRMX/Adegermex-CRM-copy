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
// ID del Costo ////////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
$costo=mysql_query("SELECT tmcostos.*, tcinsumos.codigo, tcinsumos.nombre AS nombre_insumo, tcusuarios.nombre AS nombre_usuario, tcproveedores.id_proveedor, tcproveedores.nombre AS nombre_proveedor
FROM tmcostos
JOIN tcinsumos
JOIN tcusuarios
JOIN tcproveedores
WHERE tmcostos.id_insumo = tcinsumos.id_insumo AND tmcostos.id_usuario = tcusuarios.id_usuario AND tmcostos.id_proveedor = tcproveedores.id_proveedor AND tmcostos.id_costo = '$id'", $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($costo);
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Registrar Incrementables</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><span class="titulo"><?php echo $infoarray->nombre_insumo; ?></span><br />
            <span class="subtitulo">( Código: <?php echo $infoarray->codigo; ?> )</span></td>
        </tr>
        <tr>
          <td><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <form action="engines/incrementables.php" method="post">
      <table width="840" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td width="280" align="center" class="subtitulo">Costo registrado por <strong><?php echo $infoarray->nombre_usuario; ?></strong></td>
          <td width="280" align="center"><span class="subtitulo"><br />
            </span></td>
          <td width="280" align="center" class="subtitulo">Indique el costo de los <strong>incrementables</strong></td>
        </tr>
        <tr>
          <td align="center"><span class="titulo"><strong>$ <?php if ($infoarray->moneda=="2") { echo number_format($infoarray->c_dolares,4,".",","); } else { echo number_format($infoarray->c_pesos,4,".",","); }?></strong></span><br/>
            <br />
            <?php if ($infoarray->moneda=="2") { echo '(USD - $) <img src="imagenes/usa-min.png"/>'; } else { echo '(MXN - $) <img src="imagenes/mexico-min.png"/>'; }?>
            </td>
          <td width="280" align="center"><img src="imagenes/linea-proveedor.png" width="280" height="45" /><span class="subtitulo"><br />
          </span><strong><span class="titulo">+ </span></strong></td>
          <td width="280" align="center"><input name="valor" type="number" class="textbox-min-moneda" id="valor" min="0.0001" step="0.0001" value="1.0000" required="required"/>
            <br />
            <br />
            <?php if ($infoarray->moneda=="2") { echo '(USD - $) <img src="imagenes/usa-min.png"/>'; } else { echo '(MXN - $) <img src="imagenes/mexico-min.png"/>'; }?></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><img src="imagenes/linea-800.png" width="700" height="1" /></td>
          </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><table width="550" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="150" class="encabezado-tabla">Proveedor</td>
              <td width="400"><?php echo $infoarray->nombre_proveedor; ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Incoterm</td>
              <td width="400"><?php echo $infoarray->incoterm; ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">País</td>
              <td><?php echo $infoarray->pais; ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Ciudad</td>
              <td><?php echo $infoarray->ciudad; ?></td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Cantidad a importar</td>
              <td><?php echo $infoarray->cantidad; ?> kilogramos</td>
            </tr>
            <tr>
              <td class="encabezado-tabla">Tipo de transporte</td>
              <td><?php echo $infoarray->transporte; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Comentario</td>
              <td valign="top"><?php echo $infoarray->comentario; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo"><img src="imagenes/linea-800.png" width="700" height="1" /></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="subtitulo">El costo de incrementables se sumara al costo registrado para obtener el costo integrado.<br />
Tipo de cambio aplicable: <strong>$ <?php echo $infoarray->tcaplicado; ?></strong></td>
        </tr>
        </table>
      <table width="720" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td>Comentario:<input type="hidden" value="<?php echo $id; ?>" name="id_costo" id="id_costo" /><input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario" id="id_usuario" /></td>
        </tr>
        <tr>
          <td><textarea name="comentario" cols="45" rows="5" class="textbox-comentario" id="comentario" placeholder="Escriba un comentario sobre el registro de costo para los incrementables" required="required"></textarea></td>
        </tr>
</table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="costos.php#incrementables">Cancelar</a></td>
        </tr>
      </table></form><br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
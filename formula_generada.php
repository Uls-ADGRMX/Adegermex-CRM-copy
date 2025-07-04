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
$idf = $_GET['idf'];
$id_proyecto = $_GET['idp'];
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
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Generar Fórmula</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center" class="titulo">¡Fórmula generada exitosamente!</td>
          </tr>
          <tr>
            <td align="center" class="factura-texto4">Folio de la Fórmula: <strong><?php echo $idf; ?></strong></td>
          </tr>
          <tr>
            <td align="center"><a href="formula.php?id=<?php echo $idf; ?>#contenido">Detalles de la Fórmula</a> | <?php if ($id_proyecto<>"0") { echo '<a href="proyecto.php?id='.$id_proyecto.'#contenido">Detalles del Proyecto</a> | '; } ?><a href="formulas.php">Fórmulas</a></td>
          </tr>
        </table>
        <br />
        <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="imagenes/formula_generada.jpg" width="280" height="244" /><br /></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center">La fórmula será revisada por un administrador para su aprobación.</td>
          </tr>
        </table>
      <br /></td>
    </tr>
  </table>
  <br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
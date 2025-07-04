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
// Consulta para información de la Fórmula ////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
$formula=mysql_query("SELECT * FROM tmformulas WHERE id_formula='$id'", $conexion) or die(mysql_error());
$arrayformula = mysql_fetch_object($formula);
$id_formula = $arrayformula->id_formula;
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
<!-- Imprimir Página -->
<script type="text/javascript">
function Imprime(form)
{
	form.focus();
	form.print();
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
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Imprimir Fórmula</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id_formula; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <br />
      <table width="830" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><iframe src="imprime_formula.php?id=<?php echo $id_formula; ?>" name="formula" id="formula" width="820px" height="600px" style="border:dotted; border-color:#CCC;" scrolling="yes"></iframe>
          <iframe src="imprime_formulasc.php?id=<?php echo $id_formula; ?>" name="formulasc" id="formulasc" hidden="hidden"></iframe></td>
        </tr>
  </table>
      <br />
      <table width="540" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="270" align="center"><a href="#contenido">
            <input class="boton-finalizar" type="button" name="imprimir" id="imprimir" value="Imprimir Fórmula" onclick="Imprime(formula);"/>
            </a></td>
          <td width="270" align="center"><a href="#contenido">
            <input class="boton-noaprobado" type="button" name="imprimirsc" id="imprimirsc" value="Imprimir Fórmula sin Costos" onclick="Imprime(formulasc);"/>
            </a></td>
        </tr>
        <tr>
          <td colspan="2" align="center" class="subtitulo"><br />
            ó <a href="formula.php?id=<?php echo $id_formula; ?>#contenido">volver a la Fórmula</a></td>
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
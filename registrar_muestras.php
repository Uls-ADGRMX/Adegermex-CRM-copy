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
// ID del Proyecto ////////////////////////////////////
///////////////////////////////////////////////////////
$id = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion del Proyecto ///////////////////////////
///////////////////////////////////////////////////////
$proyecto = "SELECT * FROM tmproyectos WHERE id_proyecto=$id";
$datos=mysql_query($proyecto, $conexion) or die(mysql_error());
$arrayproyecto = mysql_fetch_object($datos);
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proyectos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
<!-- Autocompletar Muestras -->
<script type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>  
<script type="text/javascript" src="scripts/jquery-ui-1.8.2.custom.min.js"></script>  
<script type="text/javascript">
jQuery(document).ready(function(){
<?php
///////////////////////////////////////////////////////
// Muestras de línea //////////////////////////////////
///////////////////////////////////////////////////////
for ($y=1; $y<=10; $y++)
{
	echo"
	$('#codigo".$y."').focusout (function(){
		var codigo = $(this).val();
		var tc = 1;
		$.ajax ({
			url:'engines/valores.php', 
			type:'POST', 
			dataType:'json', 
			data: {pcodigo: codigo, ptc: tc},
			success: function(res){
				$('#nombre_muestra".$y."').val(res.nombre)
				}
			})
		}
	)";
}
?>
});
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#27A9E3">&nbsp;</td>
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
    <td align="center" class="titulo">Proyectos</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Registrar Muestras entregadas</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <form action="engines/entregar_muestras.php" method="post"><table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center"><img src="imagenes/registrar_muestras.png" width="100" height="100" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto4"><strong>Muestras entregadas</strong></td>
        </tr>
        <tr>
          <td align="center">Registre las muestras entregadas para el proyecto <strong><?php echo $nombre_proyecto; ?></strong>:
            <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id; ?>"><input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>"></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="6" cellspacing="0">
        <tr class="encabezado-tabla">
         <td width="20" align="center">&nbsp;</td>
          <td width="150" align="center">Código</td>
          <td width="320" align="center">Producto</td>
          <td width="460" align="center">Cantidad de Muestras</td>
        </tr>
        <?php
		for ($i=1; $i<=15; $i++)
		{
		echo '
        <tr>
		  <td align="center"><span class="subtitulo"><strong>'.$i.'</strong></span></td>
          <td align="center"><input name="codigo'.$i.'" type="text" class="textbox-min" id="codigo'.$i.'" placeholder="Código" autocomplete="off" style="width:120px;"/></td>
          <td align="center"><input name="nombre_muestra'.$i.'" type="text" class="textbox" id="nombre_muestra'.$i.'" placeholder="Nombre del Producto" autocomplete="off" style="width:300px;"/></td>
          <td align="center" valign="middle" class="subtitulo"><input name="cantidad'.$i.'" type="number" min="1" step="1" class="textbox-min" id="cantidad'.$i.'" autocomplete="off" placeholder="#" style="width:50px;"/>&nbsp;&nbsp;&nbsp;piezas de&nbsp;&nbsp;&nbsp;<input name="unidadn'.$i.'" type="number" min="1" step="1" class="textbox-min" id="unidadn'.$i.'" autocomplete="off" placeholder="#" style="width:50px;"/>&nbsp;&nbsp;<select name="unidad'.$i.'" class="textbox-min" id="unidad'.$i.'" style="height:30px;width:150px;">
                  <optgroup label="Unidad de Medida">
                    <option>Kilogramos</option>
                    <option>Gramos</option>
                    <option>Litros</option>
                    <option>Mililitros</option>
                    </optgroup>
                </select></td>
        </tr>';
		}
		?>
      </table>
      <br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="submit" name="registrar" id="registrar" value="Registrar Muestras entregadas" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="proyecto.php?id=<?php echo $id; ?>#contenido">Cancelar</a></td>
        </tr>
</table></form>      <br/></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
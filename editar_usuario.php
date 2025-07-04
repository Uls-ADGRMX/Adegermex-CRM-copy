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
// Consulta para información del Usuario //////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario='$id'";
$info=mysql_query($usuario, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Usuarios</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#DA542E">&nbsp;</td>
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
    <td align="center" class="titulo">Usuarios</td>
  </tr>
</table>
<br />
<div class="tabcontent"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Editar Usuario</td>
    <td width="500" align="right" class="factura-texto4">ID del usuario: <?php echo $infoarray->id_usuario; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    	<br />
    	<table width="650" border="0" cellspacing="0" cellpadding="4">
		  <tr>
		    <td align="center"><?php
        	$avatar = 'imagenes/avatar'.$id.'.png';
			if (file_exists($avatar)) {
				echo "<img src='imagenes/avatar".$id.".png'>";
				}
			else {
				echo "<img src='imagenes/avatar.png'>";
				}
			?></td>
	      </tr>
		  <tr>
		    <td align="center" class="factura-texto4"><?php echo $infoarray->nombre; ?></td>
	      </tr>
		  <tr>
		    <td align="center" class="subtitulo"><img src="imagenes/linea-800.png" width="650" height="1" /></td>
	      </tr>
		  <tr>
		    <td align="center"><span class="subtitulo">Status:
                <?php
          		switch ($infoarray->status) {
    				case "Activo":
        				echo "<span class='finalizado'>Activo</span>";
        				break;
    				case "Inactivo":
        				echo "<span class='eliminado'>Inactivo</span>";
        				break;
						}
						?>
		    </span></td>
	      </tr>
	    </table>
    	<br />
      <form action="engines/modificar_usuario.php?id=<?php echo $infoarray->id_usuario;?>" method="post"><table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td width="550">Nombre completo del Usuario</td>
        </tr>
        <tr>
          <td colspan="2"><input name="nombre" type="text" required="required" class="textbox" id="nombre" placeholder="Ejemplo: Roberto Moreno" value="<?php echo $infoarray->nombre; ?>" autocomplete="off"/></td>
        </tr>
      </table>
      <br />
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Departamento</td>
        </tr>
        <tr>
          <td><select name="departamento" class="textbox" id="departamento" style="height:30px;">
          		<option><?php echo $infoarray->departamento; ?></option>
                <optgroup label="Dirección General">
                  <option>Dirección General</option>
                  <option>Gerencia de Q & A</option>
                  <option>Asuntos Regulatorios</option>
                  <option>Abastecimiento Interno</option>
                  <option>Cadena de Suministro</option>
                  <option>Almacenes Externos</option>
                  <option>Logística Nacional</option>
                  <option>Gerencia de SGIA</option>
                  <option>Gerencia de Compras</option>
                  </optgroup>
                <optgroup label="Dirección Técnica-Comercial">
                  <option>Dirección Técnica-Comercial</option>
                  <option>Gerencia de Innovación y Desarrollo</option>
                  </optgroup>
                <optgroup label="Dirección de Finanzas">
                  <option>Dirección de Finanzas</option>
                  <option>TI</option>
                  <option>Nominas</option>
                  <option>Gerencia de Contabilidad</option>
                  <option>Tesorería y Cuentas por Pagar</option>
                  </optgroup>
                <optgroup label="Dirección de Operaciones">
                  <option>Dirección de Operaciones</option>
                  <option>Gerencia de Planta</option>
                  <option>Mantenimiento</option>
                  <option>Producción</option>
                  <option>Almacén</option>
                  </optgroup>
                <optgroup label="Gerencia General">
                  <option>Gerencia General</option>
                  <option>Gerencia de Desarrollos Agrícolas Sustentables</option>
                  <option>Gerencia de Comercio Exterior</option>
                  <option>Gerencia Corporativa de Mejora Continua</option>
                  <option>Gerencia de Servicio al Cliente</option>
                  <option>Gerencia de Gestión de Talento</option>
                  </optgroup>
              </select></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Usuario</td>
        </tr>
        <tr>
          <td><input name="usuario" type="text" required="required" class="textbox" id="usuario" placeholder="Ejemplo: rmoreno" value="<?php echo $infoarray->usuario; ?>" autocomplete="off"/></td>
        </tr>
</table>
      <br />
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Contraseña</td>
        </tr>
        <tr>
          <td><input name="password" type="text" required="required" class="textbox" id="password" placeholder="Ejemplo: ****" value="<?php echo $infoarray->password; ?>" autocomplete="off"/></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Correo electrónico</td>
        </tr>
        <tr>
          <td><input name="correo" type="email" required="required" class="textbox" id="correo" placeholder="Ejemplo: roberto_moreno@adegermex.com.mx" value="<?php echo $infoarray->correo; ?>" autocomplete="off"/></td>
        </tr>
      </table>
      <br />
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td>Tipo de Usuario / Privilegios</td>
        </tr>
        <tr>
          <td><select name="tipo_usuario" class="textbox" id="tipo_usuario" style="height:30px;">
          <option><?php echo $infoarray->tipo_usuario; ?></option>
            <option>Agente de Ventas</option>
            <option>Agente de Compras</option>
            <option>Desarrollador</option>
            <option>Consultor</option>
            <option>Administrador</option>
          </select></td>
        </tr>
  </table>
      <br />
      <table width="550" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td colspan="2">Privilegios especiales</td>
        </tr>
        <tr>
          <td colspan="2" align="center"><img src="imagenes/linea-800.png" width="550" height="1" /></td>
        </tr>
        <tr>
          <td width="43" align="center"><input name="autoriza" type="checkbox" id="autoriza" <?php if ($infoarray->autoriza=="1"){echo 'checked="checked"';}?>/></td>
          <td width="501">Autoriza Proyectos</td>
        </tr>
        <tr>
          <td width="43" align="center"><input name="asigna" type="checkbox" id="asigna" <?php if ($infoarray->asigna=="1"){echo 'checked="checked"';}?>/></td>
          <td>Asigna Clientes</td>
        </tr>
      </table>
      <br />
<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
        <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar Cambios" /></td>
      </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="usuarios.php#contenido">Cancelar</a></td>
        </tr>
    </table>
      </form><br /></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
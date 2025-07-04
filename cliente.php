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
$asigna = $arrayusuario->asigna;
///////////////////////////////////////////////////////
// Consulta para información del Cliente //////////////
///////////////////////////////////////////////////////
$id = $_GET["id"];
$cliente = "SELECT * FROM tcclientes WHERE id_cliente='$id'";
$info=mysql_query($cliente, $conexion) or die(mysql_error());
$infoarray=mysql_fetch_object($info);
$id_cliente = $infoarray->id_cliente;
$id_asignado = $infoarray->id_asignado;
///////////////////////////////////////////////////////
// Validación de acceso al Cliente ////////////////////
///////////////////////////////////////////////////////
if($id_usuario==$id_asignado OR $tipo_usuario=="Consultor" OR $tipo_usuario=="Administrador")
	{
		
	}
else {
		echo '<script language="javascript">alert("Cation : Clientes\n\nNo cuenta con acceso para ver este cliente.")</script>';
		echo "<script language='javascript'>window.location='principal.php#contenido'</script>";
	}
///////////////////////////////////////////////////////
// Contactos por Cliente //////////////////////////////
///////////////////////////////////////////////////////
$contactos=mysql_query("
SELECT *
FROM tmcontactos
WHERE tmcontactos.id_cliente = '$id_cliente' ORDER BY tmcontactos.id_contacto DESC",$conexion);
$numero_contactos=mysql_num_rows($contactos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Clientes</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#2255A4">&nbsp;</td>
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
    <td align="center" class="titulo">Clientes</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Información del Cliente</td>
      <td width="500" align="right" class="factura-texto4">ID Cliente: <?php echo $id_cliente; ?></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="258" align="center" valign="middle" class="subtitulo"><strong>Pertenece a</strong></td>
            <td width="130" align="center" valign="middle">&nbsp;</td>
            <td width="120" align="center" valign="middle"><strong><?php echo $infoarray->tipo; ?></strong></td>
            <td width="130" align="center" valign="middle">&nbsp;</td>
            <td width="258" align="center" valign="middle"><span class="subtitulo"><strong>Asignado a</strong></span></td>
          </tr>
          <tr>
            <td align="center" valign="middle"><img src="imagenes/empresa.png" width="100" height="100" /></td>
            <td width="130" align="center" valign="middle"><img src="imagenes/linea-pertenencia.png" width="121" height="25" /></td>
            <td align="center" valign="middle"><img src="imagenes/cliente.png" width="100" height="100" /></td>
            <td width="130" align="center" valign="middle"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
            <td align="center" valign="middle"><img src="imagenes/avatar<?php if(empty($id_asignado)){} else {echo $id_asignado;}?>.png" width="80" height="80" /></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="subtitulo"><?php echo $infoarray->pertenece; ?></td>
            <td colspan="3" align="center" valign="top"><strong><?php if($infoarray->nombre == ""){echo "No Definido";} else { echo $infoarray->nombre; } ?></strong><br/><span class="subtitulo"><?php if($infoarray->rfc == ""){echo "No Definido";} else { echo $infoarray->rfc; } ?></span></td>
            <td align="center" valign="top" class="subtitulo"><?php if(empty($id_asignado))
		  {
			  echo "Sin Asignar";
			  }
			  else {
				  $asignado = "SELECT * FROM tcusuarios WHERE id_usuario=$id_asignado";
$datos=mysql_query($asignado, $conexion) or die(mysql_error());
$arrayasignado = mysql_fetch_object($datos);
echo $arrayasignado->nombre;
				  }
		  ?></td>
          </tr>
        </table>
        <br />
<?php
if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado OR $asigna=="1")
{
	echo '<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>';
			if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado)
			{
				echo '
				<td width="325" align="center">
					<a href="editar_cliente.php?id='.$id_cliente.'#contenido"><input name="modificar" type="button" class="boton-vida" id="modificar" value="Modificar Cliente" />
					</a>
				</td>';
			}
			if ($tipo_usuario == "Administrador" OR $asigna=="1")
			{
				echo '
				<td width="325" align="center">
					<a href="asignar_cliente.php?id='.$id_cliente.'#contenido"><input name="asignar" type="button" class="boton-asignar" id="asignar" value="Asignar Cliente" /></a>
				</td>';
			}
	echo '</tr>
	</table>
	<br />';
}
?>
</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Domicilio</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td bgcolor="#FFFFFF"><br />
        <table width="850" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <td width="135" class="encabezado-tabla">Calle</td>
            <td width="290" class="subtitulo"><?php if($infoarray->calle == ""){echo "No Definido";} else { echo $infoarray->calle; } ?></td>
            <td width="135" class="encabezado-tabla">Municipio o Localidad</td>
            <td width="290" class="subtitulo"><?php if($infoarray->municipio == ""){echo "No Definido";} else { echo $infoarray->municipio; } ?></td>
          </tr>
          <tr>
            <td class="encabezado-tabla">Número Exterior</td>
            <td class="subtitulo"><?php if($infoarray->exterior == ""){echo "No Definido";} else { echo $infoarray->exterior; } ?></td>
            <td class="encabezado-tabla">Estado o Provincia</td>
            <td class="subtitulo"><?php if($infoarray->estado == ""){echo "No Definido";} else { echo $infoarray->estado; } ?></td>
          </tr>
          <tr>
            <td class="encabezado-tabla">Número Interior</td>
            <td class="subtitulo"><?php if($infoarray->interior == ""){echo "No Definido";} else { echo $infoarray->interior; } ?></td>
            <td class="encabezado-tabla">País</td>
            <td class="subtitulo"><?php if($infoarray->pais == ""){echo "No Definido";} else { echo $infoarray->pais; } ?></td>
          </tr>
          <tr>
            <td class="encabezado-tabla">Colonia</td>
            <td class="subtitulo"><?php if($infoarray->colonia == ""){echo "No Definido";} else { echo $infoarray->colonia; } ?></td>
            <td class="encabezado-tabla">Código Postal</td>
            <td class="subtitulo"><?php if($infoarray->cp == ""){echo "No Definido";} else { echo $infoarray->cp; } ?></td>
          </tr>
        </table>
        <br /></td>
    </tr>
  </table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="400" class="factura-texto4">Origen</td>
      <td width="600" class="factura-texto4">Envío</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="300" valign="top"><table width="395" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td bgcolor="#FFFFFF"><br />
            <table width="350" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
                <td width="120" rowspan="2"><img src="imagenes/origen.png" width="120" height="120" /></td>
                <td width="230" align="center" class="encabezado-tabla">¿Cómo nos conoció el cliente?</td>
              </tr>
            <tr>
              <td align="center" valign="top" style="padding-left:10px; padding-right:10px;"><span class="finalizado"><?php if($infoarray->origen == ""){echo "No Definido";} else { echo $infoarray->origen; } ?></span></td>
            </tr>
            </table>            <br /></td>
        </tr>
      </table></td>
      <td width="600" align="center" valign="top"><table width="595" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td bgcolor="#FFFFFF"><br />
            <table width="550" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td width="120" rowspan="2"><img src="imagenes/envio-cliente.png" width="120" height="120" /></td>
                <td width="430" class="encabezado-tabla" style="padding-left:20px; padding-right:20px;">Instrucciones para envío de muestras y documentación</td>
              </tr>
              <tr>
                <td valign="top" style="padding-left:20px; padding-right:20px;"><span class="subtitulo"><?php if($infoarray->instrucciones == ""){echo "No Definido";} else { echo $infoarray->instrucciones; } ?></span></td>
              </tr>
            </table><br /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Información de negocio</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td bgcolor="#FFFFFF"><br />
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="200" align="center" valign="top"><img src="imagenes/negocio.png" width="149" height="150" /></td>
            <td width="700" valign="top"><table width="680" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td width="200" valign="top" class="encabezado-tabla">Segmento del cliente</td>
                <td width="480" valign="top" class="subtitulo"><span class="cliente"><?php if($infoarray->segmento == ""){echo "No Definido";} else { echo $infoarray->segmento; } ?></span></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Estrategía de negocio del cliente</td>
                <td valign="top" class="subtitulo"><?php if($infoarray->estrategia == ""){echo "No Definido";} else { echo $infoarray->estrategia; } ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Estrategía de negocio interna</td>
                <td valign="top" class="subtitulo"><?php if($infoarray->interna == ""){echo "No Definido";} else { echo $infoarray->interna; } ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Líneas de negocio</td>
                <td valign="top" class="subtitulo"><?php if($infoarray->lineas == ""){echo "No Definido";} else { echo $infoarray->lineas; } ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Tipos de productos</td>
                <td valign="top" class="subtitulo"><?php if($infoarray->productos == ""){echo "No Definido";} else { echo $infoarray->productos; } ?></td>
              </tr>
              <tr>
                <td valign="top" class="encabezado-tabla">Procesos</td>
                <td valign="top" class="subtitulo"><?php if($infoarray->procesos == ""){echo "No Definido";} else { echo $infoarray->procesos; } ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <br /></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contactos" id="contactos"></a>Contacto principal</td>
      <td width="500" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td bgcolor="#FFFFFF"><br />
        <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="200" align="center" valign="top"><img src="imagenes/contacto.png" width="150" height="150" /></td>
            <td width="700" valign="top"><table width="680" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td colspan="2" class="factura-texto4"><strong><?php if($infoarray->nombre_contacto == ""){echo "No Definido";} else { echo $infoarray->nombre_contacto; } ?></strong></td>
                </tr>
              <tr>
                <td colspan="2"><?php if($infoarray->puesto == ""){echo "No Definido";} else { echo $infoarray->puesto; } ?></td>
                </tr>
              <tr>
                <td colspan="2"><img src="imagenes/linea-800.png" width="620" height="1" /></td>
                </tr>
              <tr>
                <td width="166"><span class="factura-texto2">Departamento</span></td>
                <td width="498"><span class="factura-texto2"><?php if($infoarray->departamento == ""){echo "No Definido";} else { echo $infoarray->departamento; } ?></span></td>
              </tr>
              <tr>
                <td><span class="factura-texto2">Teléfono</span></td>
                <td><span class="factura-texto2">
                  <?php if($infoarray->telefono == ""){echo "No Definido";} else { echo $infoarray->telefono; } ?>
                </span></td>
              </tr>
              <tr>
                <td><span class="factura-texto2">Correo electrónico</span></td>
                <td><span class="factura-texto2">
                  <?php if($infoarray->correo == ""){echo "No Definido";} else { echo '<a href="mailto:'.$infoarray->correo.'">'.$infoarray->correo.'</a>'; } ?>
                </span></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <br /></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Contactos</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
      <br/>
      	<?php
        	if ($numero_contactos==0)
			{
				echo '
					<table width="950" border="0" cellspacing="0" cellpadding="4">
						<tr>
							<td align="center"><img src="imagenes/contactos.png" width="180" height="180" /></td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay <strong>Contactos adicionales</strong> registrados para este cliente.</td>
						</tr>';
						if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado)
						{
						echo '
						<tr>
							<td align="center"><a href="registrar_contacto.php?id='.$id.'#contenido"><input class="boton-cvida" type="submit" name="contacto" id="contacto" value="Registrar nuevo Contacto"/></a></td>
						</tr>';
						}
					echo '</table>';
			}
			else {
				echo '
					<table width="950" border="0" cellspacing="0" cellpadding="4">
						<tr class="encabezado-tabla">
							<td width="240"><img src="imagenes/user.png" width="18" height="18" /> Nombre del contacto</td>
							<td width="250"><img src="imagenes/empresa2.png" width="15" height="17" /> Departamento</td>
							<td width="190">Teléfono</td>
							<td width="220">Correo electrónico</td>
							<td width="25" align="center">&nbsp;</td>
							<td width="25" align="center">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="6" align="center"><img src="imagenes/linea-950.png" width="940" height="1" /></td>
						</tr>';
					while($fila=mysql_fetch_array($contactos))
					{
						echo '
						<tr class="celda-activa2">
							<td class="tooltip"><span class="tooltiptext">'.$fila['puesto'].' | '.$fila['fecha_alta'].'</span>'.$fila['nombre_contacto'].'</td>
							<td>'.$fila['departamento'].'</td>
							<td>'.$fila['telefono'].'</td>
							<td><a href="mailto:'.$fila['correo'].'">'.$fila['correo'].'</a></td>
							<td align="center">';
							if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado)
								{
									echo '<a href="editar_contacto.php?id='.$fila['id_contacto'].'&idc='.$id_cliente.'#contenido"><img src="imagenes/editar.png" width="14" height="14" title="Editar"/></a>';
								}
							else {
									echo '&nbsp;';
							}
							echo '</td>
							<td align="center">';
							if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado)
								{
									echo '<a href="engines/eliminar_contacto.php?id='.$fila['id_contacto'].'&idc='.$id_cliente.'"><img src="imagenes/wrong.png" width="16" height="16" title="Eliminar"/></a>';
								}
							else {
									echo '&nbsp;';
							}
							echo '</td>
						</tr>';
					}
				echo '
						<tr>
							<td colspan="6" align="center"><img src="imagenes/linea-950.png" width="940" height="1" /></td>
						</tr>
						<tr>
							<td colspan="6" align="right" class="encabezado-tabla">'.$numero_contactos.' contactos en total</td>
						</tr>';
					if ($tipo_usuario == "Administrador" OR $id_usuario == $id_asignado)
						{
						echo '
						<tr>
							<td colspan="6" align="center"><a href="registrar_contacto.php?id='.$id_cliente.'#contenido"><input class="boton-cvida" type="submit" name="contacto" id="contacto" value="Registrar nuevo Contacto"/></a></td>
						</tr>';
						}
					echo '</table>';
			}
		?>
        <br />
      </td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Últimos 40 proyectos generados para el cliente</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
<br />
<?php
$pxc=mysql_query("SELECT tmproyectos.id_proyecto, tmproyectos.nombre_proyecto, tmproyectos.fecha_generacion, tmproyectos.status, tmproyectos.prioridad, tmproyectos.potencial, tmproyectos.cierre_venta, tcusuarios.nombre AS generador
FROM tmproyectos
JOIN tcusuarios
WHERE tmproyectos.id_usugenera = tcusuarios.id_usuario AND tmproyectos.id_cliente = $id_cliente ORDER BY tmproyectos.id_proyecto DESC LIMIT 40",$conexion);
	$npxc=mysql_num_rows($pxc);
	if ($npxc<>0){
		echo '
		<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr class="encabezado-tabla">
				<td width="50">Folio</td>
				<td width="390">Nombre del Proyecto</td>
				<td width="95">Generado el</td>
				<td width="140">Generado por</td>
				<td width="145">Status</td>
				<td width="70">Prioridad</td>
				<td width="60" align="center">Detalles</td>
			</tr>';
			while($fila=mysql_fetch_array($pxc)){
				echo '
					<tr>
						<td colspan="7"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
					</tr>
					<tr class="';
					switch ($fila['cierre_venta']) {
						case "1":
							echo "celda-cierre-si";
							break;
						case "0":
							echo "celda-cierre-no";
							break;
						case "":
							echo "celda-activa2";
							break;
							}
					echo '">
						<td width="50">'.$fila['id_proyecto'].'</td>
						<td width="390">';
						switch ($fila['potencial']) {
							case "1":
								echo "<img src='imagenes/alta.png' title='Potencial Alto'>";
								break;
							case "2":
								echo "<img src='imagenes/normal.png' title='Potencial Medio'>";
								break;
							case "3":
								echo "<img src='imagenes/baja.png' title='Potencial Bajo'>";
								break;
							}
						echo ' <a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" class="link">'.$fila['nombre_proyecto'].'</a></td>
						<td width="95">'.$fila['fecha_generacion'].'</td>
						<td width="140">'.$fila['generador'].'</td>
						<td width="145"><span class="';
						switch ($fila['status']) {
							case "Generado / Sin Asignar":
								echo "generado-sin";
								break;
							case "Autorizado":
								echo "autorizado";
								break;
							case "Generado / Asignado":
								echo "generado-asignado";
								break;
							case "En Desarrollo":
								echo "desarrollo";
								break;
							case "Rechazado":
								echo "rechazado";
								break;
							case "Muestra Entregada":
								echo "muestra";
								break;
							case "Enviado al Cliente":
								echo "cliente";
								break;
							case "Aprobado":
								echo "aprobado";
								break;
							case "No Aprobado":
								echo "noaprobado";
								break;
							case "Reformular":
								echo "reformular";
								break;
							case "Finalizado":
								echo "finalizado";
								break;
							case "Eliminado":
								echo "eliminado";
								break;
							case "Prueba Piloto":
								echo "prueba";
								break;
							case "Recotizar":
								echo "recotizar";
								break;
							case "Revisado":
								echo "revisado";
								break;
							case "Remuestreo":
								echo "remuestreo";
								break;
							}
						echo '">'.$fila['status'].'</span></td>
						<td width="70">';
						if ($fila['prioridad']=="Urgente") {
							echo "<span class='texto-urgente'>Urgente</span>";
							}
							else {
								echo $fila['prioridad'];
								}
							switch ($fila['prioridad']) {
								case 'Alta':
									echo "<img src='imagenes/alta.png'/>";
									break;
								case 'Baja':
									echo "<img src='imagenes/baja.png'/>";
									break;
								case 'Normal':
									echo "<img src='imagenes/normal.png'/>";
									break;
								case 'Urgente':
									echo "<img src='imagenes/urgente.png'/>";
									break;	
									}
							echo '
							</td>
							<td width="60" align="center"><a href="proyecto.php?id='.$fila['id_proyecto'].'#contenido" title="Detalles"><img src="imagenes/detalles.png" width="16" height="16" /></a></td>
						</tr>';
						}
					echo '
					</table>';
				}
				else {
					echo '
					<table width="950" border="0" cellspacing="0" cellpadding="4">
						<tr>
							<td align="center"><img src="imagenes/proyecto.png" width="180" height="180" /></td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay <strong>Proyectos</strong> generados para este cliente.</td>
						</tr>
					</table>';
					}
?>
<br /></td>
    </tr>
  </table>
  <br />
  <?php
  if($tipo_usuario=="Administrador")
  {
	  echo '
	  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
	  	<tr>
			<td width="500" class="factura-texto4">Últimas 40 cotizaciones generadas para el cliente</td>
			<td width="500" align="right" class="factura-texto4">&nbsp;</td>
		</tr>
	</table>
	<br />
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
		<tr>
			<td align="center" bgcolor="#FFFFFF">
			<br/>';
        	$cotizaciones=mysql_query("
			SELECT tmcotizaciones.*, tcusuarios.id_usuario, tcusuarios.nombre AS usuario
			FROM tmcotizaciones
			JOIN tcusuarios
			WHERE tmcotizaciones.id_usuario = tcusuarios.id_usuario AND tmcotizaciones.id_cliente = $id_cliente ORDER BY id_cotizacion DESC LIMIT 40",$conexion);
			$numero_cotizaciones=mysql_num_rows($cotizaciones);
			if ($numero_cotizaciones==0){
				echo '
					<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center"><img src="imagenes/cotizaciones.png" width="180" height="180" /></td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay <strong>Cotizaciones</strong> generadas para este cliente.</td>
						</tr>
					</table>';
					}
			else {
				echo '
				<table width="950" border="0" cellspacing="0" cellpadding="4">
					<tr class="encabezado-tabla">
						<td width="90">Folio</td>
						<td width="280"><img src="imagenes/user.png" width="18" height="18" /> Generada por</td>
						<td width="200"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
						<td width="170">Moneda</td>
						<td width="90">Status</td>
						<td width="100" align="center">Opciones</td>
					</tr>';
					while($fila=mysql_fetch_array($cotizaciones)){
						echo '
						<tr>
							<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
						</tr>
						<tr class="celda-activa">
							<td valign="top">'.$fila['id_cotizacion'].'</td>
							<td valign="top"><a href="cotizacion.php?id='.$fila['id_cotizacion'].'#contenido" class="link">'.$fila['usuario'].'</a></td>
							<td valign="top">'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
							<td valign="top">';
								if ($fila['moneda']=="1") { echo 'Pesos <img src="imagenes/mexico-min.png">'; } else { echo 'Dolares <img src="imagenes/usa-min.png">'; }
							echo '</td>';
							echo '<td valign="top">';
								if ($fila['status']=="Activa") { echo '<span class="autorizado">'.$fila['status'].'</span>'; } else { echo '<span class="eliminado">'.$fila['status'].'</span>'; }
							echo '</td>
							<td align="center" valign="top">
								<table width="60" border="0" cellspacing="0" cellpadding="0">
									<tr>';
									echo '<td align="center"><a href="cotizacion.php?id='.$fila['id_cotizacion'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" title="Detalles"/></a></td>
									</tr>
								</table>
							</td>
						</tr>';
						}
					echo '</table>';
					}
				echo '
				<br/>
			</td>
		</tr>
	</table>
	<br />';
	}
	else {
		}
  ?>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="comentarios" id="comentarios"></a>Seguimiento y registro de eventos</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
<?php
if( $id_usuario==$id_asignado OR $tipo_usuario=="Administrador")
	{
		echo '
		<br/>
		<form action="engines/comentar.php" method="post" enctype="multipart/form-data">
			<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="90" rowspan="2"><img src="imagenes/avatar'.$id_usuario.'.png" width="80" height="80" /></td>
					<td width="702" class="encabezado-tabla">'.$arrayusuario->nombre.'</td>
				</tr>
				<tr>
				<td align="center"><textarea name="comentario" cols="45" rows="5" class="textbox-comentario" id="comentario" placeholder="Escriba un comentario para el cliente" required="required"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="right" valign="middle">
						<input type="hidden" value="'.$id_usuario.'" name="id_usuario" id="id_usuario">
						<input type="hidden" value="0" name="id_proyecto" id="id_proyecto">
						<input type="hidden" value="'.$id_cliente.'" name="id_cliente" id="id_cliente">
						<label for="adjuntar"><img src="imagenes/adjuntar.png" width="20px" height="20px" title="Adjuntar archivo">
						<input id="adjuntar" name="adjuntar" class="adjuntar" type="file" accept=".pdf, .xls, .xlsx, .doc, .docx, .jpg, .jpeg, .png"/> Adjuntar archivo <span class="subtitulo"><i>(Máx. 5 Mb)</i></span>
						</label>
						&nbsp;
						<select class="textbox-med" id="tipo_evento" name="tipo_evento" style="width:230px; height:32px;">
							<option value="Comentario">Comentario</option>
							<option value="Llamada">Seguimiento: Llamada telefónica</option>
							<option value="Correo">Seguimiento: Correo electrónico</option>
							<option value="Visita">Seguimiento: Visita presencial</option>
							<option value="Videoconferencia">Seguimiento: Videoconferencia</option>';
							if ($tipo_usuario=="Administrador"){
								echo '
								<option value="Apoyo">Seguimiento: Apoyo Técnico</option>';
								}
						echo '</select>
						&nbsp;
						<input name="publicar" type="submit" class="boton-comentar" id="publicar" value="Publicar"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right" valign="middle">
						<span id="narchivo" class="subtitulo">&nbsp;</span>
						<script>
							let input = document.getElementById("adjuntar");
							let imageName = document.getElementById("narchivo")
								input.addEventListener("change", ()=>{
									let inputImage = document.querySelector("input[type=file]").files[0];
									imageName.innerHTML = "Archivo seleccionado: <i>" + inputImage.name + "</i>";
								})
						</script>
					</td>
				</tr>
			</table>
		</form>';
	}
	echo '<br/><br/>';
    $eventos=mysql_query("SELECT * FROM tmeventos WHERE id_cliente='$id_cliente' ORDER BY id_evento DESC",$conexion);
	while($fila=mysql_fetch_array($eventos)){
	$id_comentador = $fila['id_usuario'];
	$comentador = "SELECT * FROM tcusuarios WHERE id_usuario='$id_comentador'";
	$datos=mysql_query($comentador, $conexion) or die(mysql_error());
	$arraycomentador = mysql_fetch_object($datos);
	if($fila['tipo_evento']<>"Actividad"){
		echo '
		<table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td width="90" align="center" valign="top"><img src="imagenes/avatar'.$fila['id_usuario'].'.png" width="80" height="80" /></td>
				<td valign="top">
					<table width="800" border="0" cellspacing="0" cellpadding="2">
						<tr>
							<td width="525"><span class="encabezado-tabla">'.$arraycomentador->nombre.'</span> ';
							switch ($fila['tipo_evento']) {
								case "Comentario":
								echo "<span class='subtitulo'>comentó:</span>";
								break;
								case "Llamada":
								echo "<span class='subtitulo'>reportó seguimiento por <span class='llamada'>Llamada telefónica</span>:</span>";
								break;
								case "Correo":
								echo "<span class='subtitulo'>reportó seguimiento por <span class='correo'>Correo electrónico</span>:</span>";
								break;
								case "Visita":
								echo "<span class='subtitulo'>reportó seguimiento por <span class='visita'>Visita presencial</span>:</span>";
								break;
								case "Apoyo":
								echo "<span class='subtitulo'>reportó seguimiento por <span class='apoyo'>Apoyo Técnico</span>:</span>";
								break;
								case "Videoconferencia":
								echo "<span class='subtitulo'>reportó seguimiento por <span class='videoconferencia'>Videoconferencia</span>:</span>";
								break;
							}
							echo '</td>
							<td width="267" align="right" class="subtitulo">'.$fila['fecha']." | ".$fila['hora'].' horas</td>
						</tr>
						<tr>
							<td colspan="2"><img src="imagenes/linea-800.png" width="800" height="1" /></td>
						</tr>
						<tr>
							<td colspan="2" valign="top" style="padding-left:5px; padding-right:15px; padding-top:5px; padding-bottom:5px;">'.$fila['evento'].'</td>
						</tr>';
						if($fila['nombre_adjunto']=="0" OR $fila['nombre_adjunto']=="")
						{
							}
						else {
							echo '
						<tr>
							<td colspan="2" style="padding-top:15px; padding-bottom:15px;">
								<span class="mensaje-adjunto"><a href="adjuntos/clientes/'.$fila['nombre_adjunto'].'" target="_blank" class="link-min"><img src="imagenes/adjuntar.png" height="16px" width="16px"> '.$fila['nombre_adjunto'].' | '.$fila['peso_adjunto'].' Kb</a></span>
							</td>
						</tr>';
						}
						echo '
					</table>
				</td>
			</tr>
		</table><br/>';
		}
	if($fila['tipo_evento']=="Actividad"){
			echo '
			<table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td class="mensaje-correcto">'.$fila['evento'].' <strong>'.$arraycomentador->nombre.'</strong>. ('.$fila['fecha'].' | '.$fila['hora'].' horas)</td>
				</tr>
			</table><br/>';
		}
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
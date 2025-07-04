<?php
///////////////////////////////////////////////////////
// Eliminar Cache /////////////////////////////////////
///////////////////////////////////////////////////////
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
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
$autoriza = $arrayusuario->autoriza;
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
$id_usugenera = $arrayproyecto->id_usugenera;
$id_usugeneraori = $arrayproyecto->id_usugeneraori;
$id_usuautoriza = $arrayproyecto->id_usuautoriza;
$id_usuasignador = $arrayproyecto->id_usuasignador;
$id_usuasignado = $arrayproyecto->id_usuasignado;
$id_usuasignado2 = $arrayproyecto->id_usuasignado2;
$nombre_proyecto = $arrayproyecto->nombre_proyecto;
$tipo = $arrayproyecto->tipo;
$categoria = $arrayproyecto->categoria;
$segmento = $arrayproyecto->segmento;
$id_cliente = $arrayproyecto->id_cliente;
$fecha_generacion = $arrayproyecto->fecha_generacion;
$hora_generacion = $arrayproyecto->hora_generacion;
$fecha_requerida = $arrayproyecto->fecha_requerida;
$fecha_autorizacion = $arrayproyecto->fecha_autorizacion;
$hora_autorizacion = $arrayproyecto->hora_autorizacion;
$fecha_asignacion = $arrayproyecto->fecha_asignacion;
$hora_asignacion = $arrayproyecto->hora_asignacion;
$fecha_inicio = $arrayproyecto->fecha_inicio;
$hora_inicio = $arrayproyecto->hora_inicio;
$fecha_compromiso = $arrayproyecto->fecha_compromiso;
$fecha_termino = $arrayproyecto->fecha_termino;
$hora_termino = $arrayproyecto->hora_termino;
$fecha_aprobacion = $arrayproyecto->fecha_aprobacion;
$hora_aprobacion = $arrayproyecto->hora_aprobacion;
$prioridad = $arrayproyecto->prioridad;
$potencial = $arrayproyecto->potencial;
$descripcion = $arrayproyecto->descripcion;
$status = $arrayproyecto->status;
$cierre = $arrayproyecto->cierre_venta;
$new_win = $arrayproyecto->new_win;
///////////////////////////////////////////////////////
// Validación de acceso al Proyecto ///////////////////
///////////////////////////////////////////////////////
if($id_usuario==$id_usugenera OR $id_usuario==$id_usuautoriza OR $id_usuario==$id_usuasignador OR $id_usuario==$id_usuasignado OR $id_usuario==$id_usuasignado2 OR $tipo_usuario=="Consultor" OR $tipo_usuario=="Administrador")
	{
		
	}
else {
		echo '<script language="javascript">alert("Cation : Proyectos\n\nNo cuenta con acceso para ver este proyecto.")</script>';
		echo "<script language='javascript'>window.location='principal.php#contenido'</script>";
	}
///////////////////////////////////////////////////////
// Información de los Requisitos //////////////////////
///////////////////////////////////////////////////////
$requisitos = "SELECT * FROM tmrequisitos WHERE id_proyecto=$id";
$datos=mysql_query($requisitos, $conexion) or die(mysql_error());
$arrayrequisitos = mysql_fetch_object($datos);
///////////////////////////////////////////////////////
// Información del Cliente ////////////////////////////
///////////////////////////////////////////////////////
if ($id_cliente=="0")
{
	}
else {
$cliente = mysql_query("SELECT * FROM tcclientes WHERE id_cliente=$id_cliente", $conexion);
$arraycliente = mysql_fetch_object($cliente);
$nombre_cliente = $arraycliente->nombre;
$id_usucliente = $arraycliente->id_asignado;
}
///////////////////////////////////////////////////////
// Información del usuario Original ///////////////////
///////////////////////////////////////////////////////
if ($id_usugeneraori==0)
{
	$id_usugeneraori = $id_usugenera;
}
if ($id_usugenera<>$id_usugeneraori)
{
$ori = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usugeneraori";
$datosori=mysql_query($ori, $conexion) or die(mysql_error());
$arrayori = mysql_fetch_object($datosori);
$nombreori = $arrayori->nombre;
}
///////////////////////////////////////////////////////
// Información de Muestras solicitadas ////////////////
///////////////////////////////////////////////////////
$solicitadas=mysql_query("SELECT tmmuestras.*, tcusuarios.nombre AS solicitante FROM tmmuestras JOIN tcusuarios WHERE tmmuestras.id_usuario=tcusuarios.id_usuario AND id_proyecto=$id AND origen='S' ORDER BY id_muestra ASC",$conexion);
$nsolicitadas=mysql_num_rows($solicitadas);
$suma_solicitadas=mysql_query("SELECT SUM(cantidad) AS sumsol FROM tmmuestras WHERE id_proyecto=$id AND origen='S'",$conexion);
$asumsol = mysql_fetch_object($suma_solicitadas);
///////////////////////////////////////////////////////
// Información de Muestras entregadas /////////////////
///////////////////////////////////////////////////////
$entregadas=mysql_query("SELECT tmmuestras.*, tcusuarios.nombre AS entregante FROM tmmuestras JOIN tcusuarios WHERE tmmuestras.id_usuario=tcusuarios.id_usuario AND id_proyecto=$id AND origen='E' ORDER BY id_muestra ASC",$conexion);
$nentregadas=mysql_num_rows($entregadas);
$suma_entregadas=mysql_query("SELECT SUM(cantidad) AS sument FROM tmmuestras WHERE id_proyecto=$id AND origen='E'",$conexion);
$asument = mysql_fetch_object($suma_entregadas);
///////////////////////////////////////////////////////
// Información de Fórmulas ////////////////////////////
///////////////////////////////////////////////////////
$formulas=mysql_query("SELECT * FROM tmformulas WHERE id_proyecto=$id ORDER BY id_formula ASC",$conexion);
$numero_formulas=mysql_num_rows($formulas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Proyectos</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css?version=5.0" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
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
    <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Detalles del Proyecto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">Folio: <?php echo $id; ?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center" class="titulo">&nbsp;<?php echo $nombre_proyecto; ?>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2"> <img src="imagenes/usuario.png" /> <?php
		  if ($id_cliente==0)
		  	{
				echo "Sin Cliente Definido"; 
			}
			else {
				echo '<a href="cliente.php?id='.$id_cliente.'#contenido" class="link">'.$nombre_cliente.'</a>';
			}
		  ?></td>
        </tr>
        <tr>
          <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="160" align="center" class="subtitulo"><strong>Fecha de Generación</strong></td>
              <td width="280" rowspan="2"><table width="275" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><img src="imagenes/linea-tiempo.png" width="272" height="25" /></td>
                  </tr>
                <tr>
                  <td align="center"><span class="
          <?php switch ($status) {
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
						?>"><?php echo $status; ?></span></td>
                  </tr>
                </table></td>
              <td width="160" align="center" class="subtitulo"><strong>Fecha Requerida de Entrega</strong></td>
              </tr>
            <tr>
              <td align="center" class="factura-texto3"><?php echo $fecha_generacion; ?>&nbsp;</td>
              <td align="center" class="factura-texto3"><?php if($fecha_requerida=="0000-00-00"){ echo "No Definida";} else {echo $fecha_requerida;} ?></td>
              </tr>
            </table></td>
        </tr>
    </table>
      <br />
      <?php
	  	if($cierre=="1")
		{
			echo '
			<table width="640" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td width="320">
						<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="mensaje-notificacion">El proyecto fue <strong>Vendido</strong>.</td>
							</tr>
						</table>
					</td>';
					if ($new_win=="1")
					{
					echo '
					<td width="320">
						<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="mensaje-correcto">El proyecto es un <strong>New Win</strong>. <img src="imagenes/win.png" width="14" height="14" title="New Win"/></td>
							</tr>
						</table>
					</td>';
					}
				echo '</tr>';
		if($id_usuario==$id_usugenera)
		{
			echo '
			<tr>
				<td align="center" class="subtitulo" colspan="2">
					<a href="confirmar_cancelar_venta.php?id='.$id.'#contenido">Cancelar la Venta del Proyecto</a>
				</td>
			</tr>';	
		}
			echo '</table>
			<br />';
		}
		else if ($cierre=="0")
		{
			echo '
			<table width="300" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" class="mensaje-error">El proyecto <strong>no fue Vendido</strong>.</td>
				</tr>
			</table>
			<br />';
		}
		else
		{
		}
	  ?>
      <table width="870" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr class="encabezado-tabla">
          <td width="126" align="center"><?php
          if ($id_usugeneraori<>$id_usugenera)
		  {
			  echo "En seguimiento por";
			  }
			  else {
				  echo "Generado por";
				  }
				  ?>
          </td>
          <td width="121" align="center">&nbsp;</td>
          <td width="126" align="center">Autorizado por</td>
          <td width="121" align="center">&nbsp;</td>
          <td width="126" align="center">Asignado por</td>
          <td width="121" align="center">&nbsp;</td>
          <td width="129" align="center">Asignado a</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/avatar<?php echo $id_usugenera; ?>.png" width="80" height="80" /></td>
          <td align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
          <td align="center"><img src="imagenes/avatar<?php if(empty($id_usuautoriza)){} else {echo $id_usuautoriza;}?>.png" width="80" height="80" /></td>
          <td align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
          <td align="center"><img src="imagenes/avatar<?php if(empty($id_usuasignador)){} else {echo $id_usuasignador;}?>.png" width="80" height="80" /></td>
          <td align="center"><img src="imagenes/linea-asignacion.png" width="121" height="25" /></td>
          <td align="center"><img src="imagenes/avatar<?php if(empty($id_usuasignado)){} else {echo $id_usuasignado;}?>.png" width="80" height="80" /></td>
        </tr>
        <tr>
          <td align="center" valign="top"><span class="subtitulo">
		  <?php
          if(empty($id_usugenera))
		  {
			  echo "Sin Generador";
			  }
			  else {
				  $generador = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usugenera";
				  $datos=mysql_query($generador, $conexion) or die(mysql_error());
				  $arraygenerador = mysql_fetch_object($datos);
				  echo $arraygenerador->nombre;
				  }
			if ($id_usugenera<>$id_usugeneraori)
			{
			  echo '<span class="tooltip"><span class="tooltiptext">Proyecto generado por '.$nombreori.'</span><br/><strong>(?)</strong> </span>';
			}
		  ?>
          </span></td>
          <td align="center">&nbsp;</td>
          <td align="center" valign="top"><span class="subtitulo">
            <?php if(empty($id_usuautoriza))
		  {
			  echo "Sin Asignar";
			  }
			  else {
				  $autorizador = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuautoriza";
				  $datos=mysql_query($autorizador, $conexion) or die(mysql_error());
				  $arrayautorizador = mysql_fetch_object($datos);
				  echo $arrayautorizador->nombre;
				  }
		  ?>
          </span></td>
          <td align="center">&nbsp;</td>
          <td align="center" valign="top"><span class="subtitulo">
            <?php if(empty($id_usuasignador))
		  {
			  echo "Sin Asignar";
			  }
			  else {
				  $asignador = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuasignador";
				  $datos=mysql_query($asignador, $conexion) or die(mysql_error());
				  $arrayasignador = mysql_fetch_object($datos);
				  echo $arrayasignador->nombre;
				  }
		  ?>
          </span></td>
          <td align="center">&nbsp;</td>
          <td align="center"><span class="subtitulo">
		  <?php
          	if(empty($id_usuasignado))
				{
					echo "Sin Asignar";
				}
				else {
					$asignado = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuasignado";
					$datos=mysql_query($asignado, $conexion) or die(mysql_error());
					$arrayasignado = mysql_fetch_object($datos);
					echo $arrayasignado->nombre;
				}
				if($id_usuasignado2<>"0")
					{
						$asignado2 = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuasignado2";
						$datos=mysql_query($asignado2, $conexion) or die(mysql_error());
						$arrayasignado2 = mysql_fetch_object($datos);
						echo '<br /><strong>+<br /></strong><div class="tooltip"><span class="tooltiptext">'.$arrayasignado2->nombre.' es desarrollador(a) de apoyo</span>'.$arrayasignado2->nombre.'</div>';
					}
				?>
          </span></td>
        </tr>
</table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td class="factura-texto3"><strong><img src="imagenes/descripcion.png" width="15" height="15" /> Descripción del Proyecto</strong></td>
        </tr>
        <tr>
          <td><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
        <tr>
          <td class="subtitulo"><?php echo $descripcion; ?></td>
        </tr>
        </table>
        <br />
	  <?php
      if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND ($status=="Generado / Sin Asignar" OR $status=="Rechazado"))
	  	{
			echo '
				<a href="editar_generalidades.php?id='.$id.'#contenido">
					<input name="editar_generalidades" type="submit" class="boton-cvida" id="editar_generalidades" value="Editar Generalidades del Proyecto" />
				</a>
				<br/>
				<br/>';
			}
		else {
			echo '<br/>';
			}
		?>
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="475" class="factura-texto3"><img src="imagenes/calendario.png" width="15" height="15" /> <strong>Tiempos del Proyecto</strong></td>
          <td width="467" align="right" class="factura-texto3">Prioridad: <?php if ($prioridad=="Urgente"){echo "<span class='texto-urgente'>Urgente</span>";} else {echo $prioridad;} ?>  <?php switch ($prioridad) {
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
						?></td>
        </tr>
        <tr>
          <td colspan="2"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <table width="760" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="190" class="encabezado-tabla">Fecha de Generación</td>
          <td width="190" class="subtitulo"><?php echo $fecha_generacion." | ".$hora_generacion." horas"; ?></td>
          <td width="190"><span class="encabezado-tabla">Fecha de Inicio</span></td>
          <td width="190" class="subtitulo"><?php if ($fecha_inicio=="0000-00-00"){ echo "No Definida";} else { echo $fecha_inicio." | ".$hora_inicio." horas";} ?></td>
          </tr>
        <tr>
          <td class="encabezado-tabla">Fecha Requerdida de Entrega</td>
          <td class="subtitulo"><?php if($fecha_requerida=="0000-00-00"){ echo "No Definida";} else {echo $fecha_requerida;} ?></td>
          <td class="encabezado-tabla">Fecha Compromiso</td>
          <td class="subtitulo"><?php if($fecha_compromiso=="0000-00-00"){ echo "No Definida";} else {echo $fecha_compromiso;} ?></td>
          </tr>
        <tr>
          <td class="encabezado-tabla">Fecha de Autorización</td>
          <td class="subtitulo"><?php if ($fecha_autorizacion=="0000-00-00"){ echo "No Definida";} else { echo $fecha_autorizacion." | ".$hora_autorizacion." horas";} ?></td>
          <td><span class="encabezado-tabla">Fecha de Aprobación</span></td>
          <td class="subtitulo"><?php if ($fecha_aprobacion=="0000-00-00"){ echo "No Definida";} else { echo $fecha_aprobacion." | ".$hora_aprobacion." horas";} ?></td>
          </tr>
        <tr>
          <td class="encabezado-tabla">Fecha de Asignación</td>
          <td class="subtitulo"><?php if ($fecha_asignacion=="0000-00-00"){ echo "No Definida";} else { echo $fecha_asignacion." | ".$hora_asignacion." horas";} ?></td>
          <td><span class="encabezado-tabla">Fecha de Término</span></td>
          <td class="subtitulo"><?php if ($fecha_termino=="0000-00-00"){ echo "No Definida";} else { echo $fecha_termino." | ".$hora_termino." horas";} ?></td>
        </tr>
        </table>
<?php
if ($status=="Finalizado" OR $status=="Eliminado")
{
	echo '<br/>';
	}
else {
	echo '<br/><table width="950" border="0" cellspacing="0" cellpadding="4">';
	if ($autoriza=="1" AND ($status=="Generado / Sin Asignar" OR $status=="Revisado") )
	{
		echo '
		<tr>
			<td width="316" align="center"><a href="engines/autorizar.php?id='.$id.'"><input name="autorizar" type="submit" class="boton-autorizar" id="autorizar" value="Autorizar Proyecto" /></a></td>
			<td width="316" align="center"><a href="confirmar_rechazar.php?id='.$id.'#contenido"><input name="rechazar" type="submit" class="boton-rechazar" id="rechazar" value="Rechazar Proyecto" /></a></td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if ($tipo_usuario=="Administrador" AND ($status<>"Generado / Sin Asignar" AND $status<>"Revisado"))
	{
		echo '
		<tr>
			<td width="316" align="center"><a href="cambiar_prioridad.php?id='.$id.'#contenido"><input name="prioridad" type="submit" class="boton-comentar" id="prioridad" value="Cambiar Prioridad" /></a></td>
			<td width="316" align="center"><a href="asignar_proyecto.php?id='.$id.'#contenido"><input name="asignar" type="submit" class="boton-asignar" id="asignar" value="Asignar Proyecto"/></a></td>
			<td width="302" align="center"><a href="confirmar_eliminar.php?id='.$id.'#contenido"><input name="eliminar" type="submit" class="boton-eliminar" id="eliminar" value="Eliminar Proyecto"/></a></td>
		</tr>';
	}
	if ($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario AND ($status=="Generado / Asignado" OR $status=="En Desarrollo" OR $status=="Reformular" OR $status=="Remuestreo")){
        echo '
		<tr>
			<td width="316" align="center">';
			if ($status=="Generado / Asignado" OR $status=="Reformular" OR $status=="Remuestreo"){
				echo '<a href="engines/desarrollar.php?id='.$id.'"><input name="desarrollar" type="submit" class="boton-desarrollar" id="desarrollar" value="Comenzar Desarrollo" /></a>';
			}
			echo '
			</td>
			<td width="316" align="center">';
			if ($status=="En Desarrollo"){
				echo '<a href="engines/entregar_muestra.php?id='.$id.'"><input name="muestra" type="submit" class="boton-muestra" id="muestra" value="Entregar Muestra" /></a>';
			}
			echo '
			</td>
			<td width="302" align="center">';
			if ($status=="En Desarrollo"){
				echo '<a href="fecha_compromiso.php?id='.$id.'#contenido"><input name="fecha_compromiso" type="submit" class="boton-asignar" id="fecha_compromiso" value="Fecha Compromiso" /></a>';
			}
			echo '
			</td>
		</tr>';}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Muestra Entregada"){
		echo '
		<tr>
			<td width="315" align="center"><a href="engines/entregar_cliente.php?id='.$id.'"><input name="cliente" type="submit" class="boton-cliente" id="cliente" value="Entregar al Cliente"></a></td>
			<td width="316" align="center">&nbsp;</td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Enviado al Cliente"){
		echo '
		<tr>
			<td width="316" align="center">¿El proyecto fue Aprobado por el Cliente?</td>
			<td width="316" align="center"><a href="confirmar_aprobado.php?id='.$id.'#contenido"><input name="aprobado" type="submit" class="boton-aprobado" id="aprobado" value="Fue Aprobado" /></a></td>
			<td width="302" align="center"><a href="confirmar_noaprobado.php?id='.$id.'#contenido"><input name="noaprobado" type="submit" class="boton-noaprobado" id="noaprobado" value="No fue Aprobado" /></a></td>
        </tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Aprobado"){
		echo '
		<tr>
			<td width="316" align="center"><a href="confirmar_finalizar.php?id='.$id.'#contenido"><input name="finalizar" type="submit" class="boton-finalizar" id="finalizar" value="Finalizar Proyecto" /></a></td>
			<td width="316" align="center"><a href="engines/prueba.php?id='.$id.'"><input name="prueba" type="submit" class="boton-prueba" id="prueba" value="Prueba Piloto"></a></td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="No Aprobado"){
		echo '
		<tr>
			<td width="316" align="center"><a href="confirmar_remuestreo.php?id='.$id.'#contenido"><input name="remuestreo" type="submit" class="boton-remuestreo" id="remuestreo" value="Remuestreo del Proyecto" /></a></td>
			<td width="316" align="center"><a href="confirmar_reformular.php?id='.$id.'#contenido"><input name="reformular" type="submit" class="boton-reformular" id="reformular" value="Reformular Proyecto" /></a></td>
			<td width="302" align="center"><a href="confirmar_recotizar.php?id='.$id.'#contenido"><input name="recotizar" type="submit" class="boton-recotizar" id="recotizar" value="Recotizar Proyecto" /></a></td>
		</tr>
		<tr>
			<td width="316" align="center"><a href="confirmar_finalizar.php?id='.$id.'#contenido"><input name="finalizar" type="submit" class="boton-finalizar" id="finalizar" value="Finalizar Proyecto" /></a></td>
			<td width="316" align="center">&nbsp;</td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Prueba Piloto"){
		echo '
		<tr>
			<td width="316" align="center"><a href="confirmar_finalizar.php?id='.$id.'#contenido"><input name="finalizar" type="submit" class="boton-finalizar" id="finalizar" value="Finalizar Proyecto" /></a></td>
			<td width="316" align="center">&nbsp;</td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Recotizar"){
		echo '
		<tr>
			<td width="316" align="center"><a href="engines/entregar_cliente.php?id='.$id.'"><input name="cliente" type="submit" class="boton-cliente" id="cliente" value="Entregar al Cliente"></a></td>
			<td width="316" align="center">&nbsp;</td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
	if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND $status=="Rechazado"){
		echo '
		<tr>
			<td width="316" align="center"><a href="engines/revisar.php?id='.$id.'"><input name="revisar" type="submit" class="boton-revisado" id="revisar" value="Enviar a Revisión"></a></td>
			<td width="316" align="center">&nbsp;</td>
			<td width="302" align="center">&nbsp;</td>
		</tr>';
	}
}
echo '</table><br/>';
?></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Información de Negocio</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" class="mensaje-correcto">Proyecto con <strong><?php switch ($potencial) {
    				case "1":
        				echo "Potencial Alto <img src='imagenes/alta.png' title='Potencial Alto'>";
        				break;
					case "2":
        				echo "Potencial Medio <img src='imagenes/normal.png' title='Potencial Medio'>";
        				break;
    				case "3":
        				echo "Potencial Bajo <img src='imagenes/baja.png' title='Potencial Bajo'>";
        				break;
						} ?></strong></td>
        </tr>
      </table>
      <br />
      <table width="880" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr class="encabezado-tabla">
          <td width="220" align="center">Venta Anual</td>
          <td width="220" align="center">Volumen Mensual</td>
          <td width="220" align="center">Precio de Venta target por KG</td>
          <td width="220" align="center">Costo de la Aplicación</td>
        </tr>
        <tr>
          <td align="center" class="texto-moneda-2">$<?php echo number_format($arrayrequisitos->vanual_num,0,".",","); ?></td>
          <td align="center" class="texto-moneda-2"><?php echo number_format($arrayrequisitos->vmensual_num,0,".",","); ?></td>
          <td align="center" class="texto-moneda-2">$<?php echo number_format($arrayrequisitos->ptarget_num,2,".",","); ?></td>
          <td align="center" class="texto-moneda-2">$<?php echo number_format($arrayrequisitos->caplic_num,2,".",","); ?></td>
        </tr>
        <tr>
          <td align="center"><?php if($arrayrequisitos->vanual_mon == "Dolares") { echo $arrayrequisitos->vanual_mon.' <img src="imagenes/usa-min.png" width="17" height="13" />'; } else { echo $arrayrequisitos->vanual_mon.' <img src="imagenes/mexico-min.png" width="17" height="13" />'; } ?></td>
          <td align="center"><?php echo $arrayrequisitos->vmensual_uni; ?></td>
          <td align="center"><?php if($arrayrequisitos->ptarget_mon == "Dolares") { echo $arrayrequisitos->ptarget_mon.' <img src="imagenes/usa-min.png" width="17" height="13" />'; } else { echo $arrayrequisitos->ptarget_mon.' <img src="imagenes/mexico-min.png" width="17" height="13" />'; } ?></td>
          <td align="center"><?php if($arrayrequisitos->caplic_mon == "Dolares") { echo $arrayrequisitos->caplic_mon.' <img src="imagenes/usa-min.png" width="17" height="13" />'; } else { echo $arrayrequisitos->caplic_mon.' <img src="imagenes/mexico-min.png" width="17" height="13" />'; } ?></td>
        </tr>
  </table>
  <br />
<?php
if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND ($status=="Generado / Sin Asignar" OR $status=="Rechazado"))
{
	echo '
	<a href="editar_negocio.php?id='.$id.'#contenido">
		<input name="editar_negocio" type="submit" class="boton-cvida" id="editar_negocio" value="Editar Información de Negocio" />
	</a>
	<br/>
	<br/>';
}
else {	
}
?>
  </td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Información del Desarrollo</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr class="encabezado-tabla">
          <td width="300" align="center">Tipo de Proyecto</td>
          <td width="300" align="center">Segmento del Proyecto</td>
          <td width="300" align="center">Categoría del Proyecto</td>
        </tr>
        <tr>
          <td align="center"><?php echo $tipo; ?></td>
          <td align="center"><?php echo $segmento; ?></td>
          <td align="center"><?php echo $categoria; ?></td>
          </tr>
        <tr>
          <td colspan="3" align="center"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
      </table>
      <br />
	  <?php
      if (($id_usugenera==$id_usuario OR $id_usucliente==$id_usuario) AND ($status=="Generado / Sin Asignar" OR $status=="Rechazado" OR $status=="Autorizado" OR $status=="Generado / Asignado" OR $status=="Revisado" OR $status=="En Desarrollo" OR $status=="Muestra Entregada" OR $status=="Enviado al Cliente" OR $status=="Aprobado" OR $status=="No Aprobado" OR $status=="Reformular" OR $status=="Prueba Piloto" OR $status=="Rechazado" OR $status=="Recotizar" OR $status=="Remuestreo"))
	  	{
			echo '
				<a href="editar_clasificadores.php?id='.$id.'#contenido">
					<input name="editar_clasificadores" type="submit" class="boton-cvida" id="editar_clasificadores" value="Editar Clasificadores del Proyecto" />
				</a>
				<br/>
				<br/>';
			}
		else {
			}
		?>
      <table width="950" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="325" valign="top"><table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td align="right" class="encabezado-tabla">Etiquetado</td>
            </tr>
            <tr>
              <td align="right"><?php echo $arrayrequisitos->etiquetado; ?></td>
            </tr>
          </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="right" class="encabezado-tabla">Estado físico</td>
              </tr>
              <tr>
                <td align="right"><?php echo $arrayrequisitos->estado_fisico; ?></td>
              </tr>
            </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="right" class="encabezado-tabla">Presentación final (envase)</td>
              </tr>
              <tr>
                <td align="right"><?php echo $arrayrequisitos->envase; ?></td>
              </tr>
            </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="right" class="encabezado-tabla">Tipo de almacenamiento</td>
              </tr>
              <tr>
                <td align="right"><?php echo $arrayrequisitos->almacenamiento; ?></td>
              </tr>
          </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td align="right" class="encabezado-tabla">Dosis de uso</td>
              </tr>
              <tr>
                <td align="right"><?php echo $arrayrequisitos->dosis; ?>%</td>
              </tr>
          </table></td>
          <td width="300" align="center" valign="top"><?php
          switch ($arrayproyecto->segmento)
		  {
			  case "Panificación":
			  		echo '<img src="imagenes/desarrollo-panificacion.png" width="247" height="290" />';
					break;
			  case "Lácteos":
			  		echo '<img src="imagenes/desarrollo-lacteos.png" width="247" height="290" />';
					break;
			  case "Cárnicos":
			  		echo '<img src="imagenes/desarrollo-carnicos.png" width="247" height="290" />';
					break;
			  case "Bebidas":
			  		echo '<img src="imagenes/desarrollo-bebidas.png" width="247" height="290" />';
					break;
			  case "Snacks":
			  		echo '<img src="imagenes/desarrollo-snacks.png" width="247" height="290" />';
					break;
			  case "Culinario":
			  		echo '<img src="imagenes/desarrollo-culinario.png" width="247" height="290" />';
					break;
			  case "Vegetales":
			  		echo '<img src="imagenes/desarrollo-vegetales.png" width="247" height="290" />';
					break;
			  case "Food Service":
			  		echo '<img src="imagenes/desarrollo-foodservice.png" width="247" height="290" />';
					break;
			  default:
			  		echo '<img src="imagenes/desarrollo.png" width="247" height="290" />';
					break;
		  }
		  ?></td>
          <td width="325" valign="top"><table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
                <td class="encabezado-tabla">¿Permite el uso de alérgenos?</td>
              </tr>
              <tr>
                <td><?php if ($arrayrequisitos->alergenos=="0") { echo 'No Definido'; } else { echo 'Sí'; } ?></td>
              </tr>
          </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
              <td class="encabezado-tabla">Clasificación (Sabores)</td>
            </tr>
            <tr>
              <td><?php echo $arrayrequisitos->clasificacion; ?></td>
            </tr>
        </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td class="encabezado-tabla">Termoresistente (Sabores)</td>
              </tr>
              <tr>
                <td><?php echo $arrayrequisitos->termoresistente; ?></td>
              </tr>
            </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td class="encabezado-tabla">Solubilidad (Sabores)</td>
              </tr>
              <tr>
                <td><?php echo $arrayrequisitos->solubilidad; ?></td>
              </tr>
            </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td class="encabezado-tabla">Requerimiento (Sabores)</td>
              </tr>
              <tr>
                <td><?php echo $arrayrequisitos->demostracion; ?></td>
              </tr>
            </table>
            <br />
            <table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
                <td class="encabezado-tabla">Vida de Anaquel (Sabores)</td>
              </tr>
              <tr>
                <td><?php
                	$anaquel = $arrayrequisitos->anaquel;
					if ($anaquel=="0" OR $anaquel=="") {
						echo 'No Definido';
					}
					else {
						echo $anaquel.' meses';	
					}
					?></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" class="encabezado-tabla"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        <tr>
          <td width="450" class="encabezado-tabla">Uso de alérgenos</td>
          <td width="450"><span class="encabezado-tabla">Condiciones de Proceso</span></td>
        </tr>
        <tr>
          <td valign="top"><?php
          if ($arrayrequisitos->alergenos=="0"){
			  echo 'No Definido';
			  }
			  else {
			if ($arrayrequisitos->a1=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Cereales que contienen gluten<br/>'; }
			if ($arrayrequisitos->a2=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Huevo, sus productos y derivados<br/>'; }
			if ($arrayrequisitos->a3=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Pescado y sus productos<br/>'; }
			if ($arrayrequisitos->a4=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Cacahuate y sus productos<br/>'; }
			if ($arrayrequisitos->a5=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Soya y sus productos<br/>'; }
			if ($arrayrequisitos->a6=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Leche, sus productos y derivados<br/>'; }
			if ($arrayrequisitos->a7=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Nueces de árboles y sus derivados<br/>'; }
			if ($arrayrequisitos->a7=="1") { echo '<img src="imagenes/viñeta-amarillo.png" width="16" height="16" /> Sulfito en concentraciones de 10mg/kg o más'; }
			if ($arrayrequisitos->a1=="0" AND $arrayrequisitos->a2=="0" AND $arrayrequisitos->a3=="0" AND $arrayrequisitos->a4=="0" AND $arrayrequisitos->a5=="0" AND $arrayrequisitos->a6=="0" AND $arrayrequisitos->a7=="0" AND $arrayrequisitos->a8=="0") { echo 'No indicados';}
			  }
			  ?></td>
          <td valign="top"><?php echo $arrayrequisitos->proceso; ?></td>
        </tr>
      </table>
      <br />
      <table width="900" border="0" cellspacing="0" cellpadding="4">
        <tr class="encabezado-tabla">
          <td colspan="3" align="center"><img src="imagenes/linea-850.png" width="900" height="1" /></td>
          </tr>
        <tr class="encabezado-tabla">
          <td width="300">Certificaciones</td>
          <td width="300">Documentación entregada por el cliente</td>
          <td width="300">Documentación requerida por el cliente</td>
        </tr>
        <tr>
          <td valign="top"><?php
          if ($arrayrequisitos->c1=="0" AND $arrayrequisitos->c2=="0" AND $arrayrequisitos->c3=="0" AND $arrayrequisitos->c4=="0" AND $arrayrequisitos->c5=="0" AND $arrayrequisitos->certificacion=="0"){ echo 'No se requieren certificaciones'; }
		  else {
			  if ($arrayrequisitos->c1=="1") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> FSSC 22000<br/>'; }
			  if ($arrayrequisitos->c2=="1") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> KOSHER<br/>'; }
			  if ($arrayrequisitos->c3=="1") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> HALAL<br/>'; }
			  if ($arrayrequisitos->c4=="1") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> No GMO<br/>'; }
			  if ($arrayrequisitos->c5=="1") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> TTB<br/>'; }
			  if ($arrayrequisitos->certificacion<>"0") { echo '<img src="imagenes/viñeta-verde.png" width="16" height="16" /> '.$arrayrequisitos->certificacion; }
		  }
		  ?></td>
          <td valign="top"><?php
          if ($arrayrequisitos->ec1=="0" AND $arrayrequisitos->ec2=="0" AND $arrayrequisitos->ec3=="0" AND $arrayrequisitos->ec4=="0" AND $arrayrequisitos->ec5=="0" AND $arrayrequisitos->entregada=="0"){ echo 'Sin información entregada por el cliente'; }
		  else {
			  if ($arrayrequisitos->ec1=="1") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> Testigo<br/>'; }
			  if ($arrayrequisitos->ec2=="1") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> Base<br/>'; }
			  if ($arrayrequisitos->ec3=="1") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> Ficha Técnica<br/>'; }
			  if ($arrayrequisitos->ec4=="1") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> Hoja de Seguridad<br/>'; }
			  if ($arrayrequisitos->ec5=="1") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> Formulación<br/>'; }
			  if ($arrayrequisitos->entregada<>"0") { echo '<img src="imagenes/viñeta-azul.png" width="16" height="16" /> '.$arrayrequisitos->entregada; }
		  }
		  ?></td>
          <td valign="top"><?php
          if ($arrayrequisitos->rc1=="0" AND $arrayrequisitos->rc2=="0" AND $arrayrequisitos->rc3=="0" AND $arrayrequisitos->rc4=="0" AND $arrayrequisitos->rc5=="0" AND $arrayrequisitos->requerida=="0"){ echo 'Sin información requerida por el cliente'; }
		  else {
			  if ($arrayrequisitos->rc1=="1") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> Ficha Técnica<br/>'; }
			  if ($arrayrequisitos->rc2=="1") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> Hoja de Seguridad<br/>'; }
			  if ($arrayrequisitos->rc3=="1") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> Carta Garantía<br/>'; }
			  if ($arrayrequisitos->rc4=="1") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> Carta de Origen<br/>'; }
			  if ($arrayrequisitos->rc5=="1") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> Declaración de Alérgenos<br/>'; }
			  if ($arrayrequisitos->requerida<>"0") { echo '<img src="imagenes/viñeta-azulf.png" width="16" height="16" /> '.$arrayrequisitos->requerida; }
		  }
		  ?></td>
        </tr>
</table>
      <br/></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Envío</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br /><table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td width="200" align="center" valign="top"><?php
          switch ($arrayrequisitos->envio)
		  {
			  case "1":
			  		echo '<img src="imagenes/envio-agente.png" width="180" height="180" />';
					break;
			  case "2":
			  		echo '<img src="imagenes/envio-cliente.png" width="180" height="180" />';
					break;
			  case "3":
			  		echo '<img src="imagenes/envio-alternativo.png" width="180" height="180" />';
					break;
		  }
		  ?></td>
        <td width="700" align="center" valign="top">
		<?php
          switch ($arrayrequisitos->envio)
		  {
			  case "1":
			  		echo '<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="2" class="factura-texto3">La información y muestras del proyecto se entregaran al <strong>Agente de Ventas</strong>.</td>
            </tr>
          <tr>
            <td colspan="2"><img src="imagenes/linea-800.png" width="630" height="1" /></td>
            </tr>
          <tr>
            <td width="160" valign="top" class="encabezado-tabla">Nombre</td>
            <td width="490" valign="top" class="subtitulo">'.$arraygenerador->nombre.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Correo electrónico</td>
            <td valign="top" class="subtitulo">';
			if($arraygenerador->correo == ""){echo "No Definido";} else { echo '<a href="mailto:'.$arraygenerador->correo.'">'.$arraygenerador->correo.'</a>'; }
			echo '</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Departamento</td>
            <td valign="top" class="subtitulo">'.$arraygenerador->departamento.'</td>
          </tr>
        </table>';
					break;
			  case "2":
			  		echo '<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="2" class="factura-texto3">La información y muestras del proyecto se entregaran al <strong>Cliente</strong>.</td>
            </tr>
          <tr>
            <td colspan="2"><img src="imagenes/linea-800.png" width="630" height="1" /></td>
            </tr>
          <tr>
            <td width="160" valign="top" class="encabezado-tabla">Cliente</td>
            <td width="490" valign="top" class="subtitulo">'.$arraycliente->nombre.' (<a href="cliente.php?id='.$arraycliente->id_cliente.'#contenido">Ver Cliente</a>)</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">RFC</td>
            <td valign="top" class="subtitulo">'.$arraycliente->rfc.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Domicilio</td>
            <td valign="top" class="subtitulo">'.$arraycliente->calle.', '.$arraycliente->exterior.', '.$arraycliente->interior.', '.$arraycliente->colonia.', '.$arraycliente->municipio.', '.$arraycliente->estado.', '.$arraycliente->pais.'. C.P.: '.$arraycliente->cp.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Indicaciones para envío</td>
            <td valign="top" class="subtitulo">'.$arraycliente->instrucciones.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Contacto</td>
            <td valign="top" class="subtitulo">'.$arraycliente->nombre_contacto.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Teléfono</td>
            <td valign="top" class="subtitulo">';
			if($arraycliente->telefono == ""){echo "No Definido";} else { echo $arraycliente->telefono; }
			echo '</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Correo electrónico</td>
            <td valign="top" class="subtitulo">';
			if($arraycliente->correo == ""){echo "No Definido";} else { echo '<a href="mailto:'.$arraycliente->correo.'">'.$arraycliente->correo.'</a>'; }
			echo '</td>
          </tr>
        </table>';
					break;
			  case "3":
			  		echo '<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="2" class="factura-texto3">La información y muestras del proyecto se entregaran al <strong>Cliente</strong> (domicilio alterno).</td>
            </tr>
          <tr>
            <td colspan="2"><img src="imagenes/linea-800.png" width="630" height="1" /></td>
            </tr>
          <tr>
            <td width="160" valign="top" class="encabezado-tabla">Cliente</td>
            <td width="490" valign="top" class="subtitulo">'.$arraycliente->nombre.' (<a href="cliente.php?id='.$arraycliente->id_cliente.'#contenido">Ver Cliente</a>)</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">RFC</td>
            <td valign="top" class="subtitulo">'.$arraycliente->rfc.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Domicilio alterno</td>
            <td valign="top" class="subtitulo">'.$arrayrequisitos->direccion.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">&nbsp;</td>
            <td valign="top" class="subtitulo">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Contacto</td>
            <td valign="top" class="subtitulo">'.$arraycliente->nombre_contacto.'</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Teléfono</td>
            <td valign="top" class="subtitulo">';
			if($arraycliente->telefono == ""){echo "No Definido";} else { echo $arraycliente->telefono; }
			echo '</td>
          </tr>
          <tr>
            <td valign="top" class="encabezado-tabla">Correo electrónico</td>
            <td valign="top" class="subtitulo">';
			if($arraycliente->correo == ""){echo "No Definido";} else { echo '<a href="mailto:'.$arraycliente->correo.'">'.$arraycliente->correo.'</a>'; }
			echo '</td>
          </tr>
        </table>';
					break;
		  }
		  ?></td>
      </tr>
    </table>
      <br /></td>
  </tr>
</table>
<?php
if($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario OR $tipo_usuario=="Administrador")
{
	echo '
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="500" class="factura-texto4"><a name="formulaciones" id="formulaciones"></a>Fórmulas del Proyecto</td>
				<td width="500" align="right" class="factura-texto4" style="padding-right:15px;">';
				if ($numero_formulas==0){
					echo '0 fórmulas';
					}
				else {
					echo $numero_formulas.' fórmulas';
					}
				echo '</td>
			</tr>
		</table>
		<br/>
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td align="center" bgcolor="#FFFFFF">';
				if($numero_formulas==0){
					echo '<br/><table width="950" border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td align="center"><img src="imagenes/formula.png" width="180" height="180" /></td>
							</tr>
							<tr>
								<td align="center" class="factura-texto2">No hay <strong>Fórmulas</strong> generadas para este proyecto.</td>
							</tr>';
							if ($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario AND $status=="En Desarrollo"){
								echo '
									<tr>
										<td align="center">
											<a href="generar_formula.php?id='.$id.'#contenido"><input class="boton-cvida" type="submit" name="formulacion" id="formulacion" value="Generar nueva Fórmula"/></a>
										</td>
									</tr>';
								}
							else {
								}
					echo '</table>';
				}
				else {
					echo '
						<br/>
						<table width="950" border="0" cellspacing="0" cellpadding="4">
							<tr class="encabezado-tabla">
								<td width="70">Folio</td>
								<td width="390">Nombre de la Fórmula / Producto</td>
								<td width="140"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
								<td width="170">Código de control interno</td>
								<td width="60">Status</td>
								<td width="100" align="center">Opciones</td>
							</tr>';
							while($fila=mysql_fetch_array($formulas)){
								echo '
									<tr>
										<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
									</tr>
									<tr class="celda-activa">
										<td valign="top">'.$fila['id_formula'].'</td>
										<td valign="top"><a href="formula.php?id='.$fila['id_formula'].'#contenido" class="link">'.$fila['nombre_formula'].'</a>';
										if ($fila['master']=="1"){
											echo ' <img src="imagenes/estrella.png" width="14" height="14" title="Fórmula Maestra">';
										}
										else {
											}
									echo '
										</td>
										<td valign="top">'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
										<td valign="top">'.$fila['codigo_interno'].'</td>
										<td valign="top">';
										if ($fila['status']=="Activa"){
											echo '<span class="autorizado">'.$fila['status'].'</span>';
										}
										else {
											echo '<span class="eliminado">'.$fila['status'].'</span>';
										}
									echo '</td>
										<td align="center" valign="top"><table width="60" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center"><a href="formula.php?id='.$fila['id_formula'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" title="Detalles"/></a></td>
									</tr>
								</table>
							</td>
						</tr>';
						}
		  echo'
		  			</table>';
					if($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario AND $status=="En Desarrollo"){
						echo '<br/>
						<table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
							<tr>
								<td align="center">
									<a href="generar_formula.php?id='.$id.'#contenido"><input class="boton-cvida" type="submit" name="gformulacion" id="gformulacion" value="Generar nueva Fórmula" /></a>
								</td>
							</tr>
						</table>';
					}
					else {
						}
					}
				echo '
				<br />
				</td>
			</tr>
		</table>';
	}
	else {
	}
?>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="solicitadas" id="solicitadas"></a>Muestras solicitadas</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <?php if($nsolicitadas==0)
	  {
		  echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/muestras.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay registros de <strong>Muestras Solicitadas</strong> para este proyecto.</td>
        </tr>
		</table>';
		 }
		 else {
			 echo '<table width="930" border="0" cellspacing="0" cellpadding="4">
        <tr class="encabezado-tabla">
          <td width="100">Código</td>
          <td width="300">Producto</td>
          <td width="150"><img src="imagenes/user.png" width="15" height="15" /> Solicitadas por</td>
          <td width="120"><img src="imagenes/calendario.png" width="15" height="15" /> Fecha de Solicitud</td>
		  <td width="180">Cantidad</td>
		  <td width="30">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6"><img src="imagenes/linea-950.png" width="930" height="1" /></td>
          </tr>';
		  while($fila=mysql_fetch_array($solicitadas)){
		   echo '
		   <tr class="celda-activa">
		   		<td>'.$fila['codigo'].'</td>
				<td>'.$fila['nombre_muestra'].'</td>
				<td>'.$fila['solicitante'].'</td>
				<td class="tooltip"><span class="tooltiptext">Fecha de Solicitud: '.$fila['fecha_alta'].' | '.$fila['hora_alta'].' horas</span>'.$fila['fecha_alta'].'</td>
				<td>'.$fila['cantidad'].' piezas de '.$fila['unidadn'].' '.$fila['unidad'].'</td>
				<td>&nbsp;</td>
			</tr>';
			 }
			echo '
			<tr>
				<td colspan="6"><img src="imagenes/linea-950.png" width="930" height="1" /></td>
			</tr>
		   <tr class="encabezado-tabla">
		   		<td class="encabezado-tabla" colspan="6" align="right">'.$asumsol->sumsol.' piezas solicitadas en total</td>
			</tr>
			';
			echo '</table>';
		}
		?>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="entregadas" id="entregadas"></a>Muestras entregadas</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <?php if($nentregadas==0)
	  {
		  echo '<table width="950" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td align="center"><img src="imagenes/muestras.png" width="180" height="180" /></td>
        </tr>
        <tr>
          <td align="center" class="factura-texto2">No hay registros de <strong>Muestras Entregadas</strong> para este proyecto.</td>
        </tr>';
		if ($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario OR $id_usuasignador==$id_usuario AND ($status=="En Desarrollo" OR $status=="Muestra Entregada" OR $status=="Enviado al Cliente" OR $status=="Aprobado" OR $status=="No Aprobado" OR $status=="Reformular" OR $status=="Prueba Piloto" OR $status=="Remuestreo")){
			echo '
		<tr>
			<td align="center">
				<a href="registrar_muestras.php?id='.$id.'#contenido"><input class="boton-cvida" type="submit" name="muestras" id="muestras" value="Registrar Muestras entregadas"/></a>
			</td>
		</tr>';
		}
		else {
		}
		echo '</table>';
		 }
		 else {
			 echo '<table width="930" border="0" cellspacing="0" cellpadding="4">
        <tr class="encabezado-tabla">
          <td width="100">Código</td>
          <td width="300">Producto</td>
          <td width="150"><img src="imagenes/user.png" width="15" height="15" /> Entregadas por</td>
          <td width="120"><img src="imagenes/calendario.png" width="15" height="15" /> Fecha de Entrega</td>
		  <td width="180">Cantidad</td>
		  <td width="30">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6"><img src="imagenes/linea-950.png" width="930" height="1" /></td>
          </tr>';
		  while($fila=mysql_fetch_array($entregadas)){
		   echo '
		   <tr class="celda-activa">
		   		<td>'.$fila['codigo'].'</td>
				<td>'.$fila['nombre_muestra'].'</td>
				<td>'.$fila['entregante'].'</td>
				<td class="tooltip"><span class="tooltiptext">Fecha de Entrega: '.$fila['fecha_alta'].' | '.$fila['hora_alta'].' horas</span>'.$fila['fecha_alta'].'</td>
				<td>'.$fila['cantidad'].' piezas de '.$fila['unidadn'].' '.$fila['unidad'].'</td>
		   		<td>';
				if ($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario OR $id_usuasignador==$id_usuario AND ($status=="En Desarrollo" OR $status=="Muestra Entregada" OR $status=="Enviado al Cliente" OR $status=="Aprobado" OR $status=="No Aprobado" OR $status=="Reformular" OR $status=="Prueba Piloto" OR $status=="Remuestreo")){
					echo '<a href="engines/eliminar_muestra.php?id='.$fila['id_muestra'].'&idp='.$id.'"><img src="imagenes/wrong.png" width="16" height="16" title="Eliminar"/></a>';
				}
				else {
					echo '&nbsp;';
				}
			echo '</td></tr>';
			 }
			echo '
			<tr>
				<td colspan="6"><img src="imagenes/linea-950.png" width="930" height="1" /></td>
			</tr>
		   <tr>
		   		<td class="encabezado-tabla" colspan="6" align="right">'.$asument->sument.' piezas entregadas en total</td>
			</tr>';
			if ($id_usuasignado==$id_usuario OR $id_usuasignado2==$id_usuario OR $id_usuasignador==$id_usuario AND ($status=="En Desarrollo" OR $status=="Muestra Entregada" OR $status=="Enviado al Cliente" OR $status=="Aprobado" OR $status=="No Aprobado" OR $status=="Reformular" OR $status=="Prueba Piloto" OR $status=="Remuestreo")){
				echo '
			<tr>
				<td align="center" colspan="6">
					<a href="registrar_muestras.php?id='.$id.'#contenido"><input class="boton-cvida" type="submit" name="muestras" id="muestras" value="Registrar Muestras entregadas"/></a>
				</td>
			</tr>';
			}
			else {
			}
			echo '</table>';
		}
		?>
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><a name="comentarios" id="comentarios"></a>Historia del Proyecto</td>
    <td width="500" align="right" class="factura-texto4" style="padding-right:15px;">&nbsp;</td>
  </tr>
</table>
<br/>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
	<?php
    if ($status=="Eliminado" OR $status=="Finalizado" OR $status=="Generado / Sin Asignar")
	{
		}
	else
	{
		if($id_usuario==$id_usugenera OR $id_usuario==$id_usucliente OR $id_usuario==$id_usuasignador OR $id_usuario==$id_usuasignado OR $id_usuario==$id_usuasignado2 OR $tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario")
		{
			echo '
			<br/>
			<form action="engines/comentar.php" method="post" enctype="multipart/form-data"><table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
				<td width="90" rowspan="2"><img src="imagenes/avatar'.$id_usuario.'.png" width="80" height="80" /></td>
				<td width="702" class="encabezado-tabla">'.$arrayusuario->nombre.'</td>
			</tr>
			<tr>
				<td align="center"><textarea name="comentario" cols="45" rows="5" class="textbox-comentario" id="comentario" placeholder="Escriba un comentario para el proyecto '.$arrayproyecto->nombre_proyecto.'" required="required"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="right" valign="middle">
					<input type="hidden" value="'.$id_usuario.'" name="id_usuario" id="id_usuario">
					<input type="hidden" value="'.$id.'" name="id_proyecto" id="id_proyecto">
					<input type="hidden" value="0" name="id_cliente" id="id_cliente">
					<label for="adjuntar"><img src="imagenes/adjuntar.png" width="20px" height="20px" title="Adjuntar archivo">
						<input id="adjuntar" name="adjuntar" class="adjuntar" type="file" accept=".pdf, .xls, .xlsx, .doc, .docx, .jpg, .jpeg, .png"/> Adjuntar archivo <span class="subtitulo"><i>(Máx. 5 Mb)</i></span>
					</label>
					&nbsp;
					<select class="textbox-med" id="tipo_evento" name="tipo_evento" style="width:230px; height:32px;"';
					if ($id_usuario<>$id_usugenera AND $id_usuario<>$id_usucliente AND $id_usuario<>$id_usuasignado AND $id_usuario<>$id_usuasignado2 AND $id_usuario<>$id_usuasignador)
					{
						echo ' hidden="hidden"';
					}
					echo '><option value="Comentario">Comentario</option>';
					if ($id_usuario==$id_usugenera OR $id_usuario==$id_usucliente){
						echo '
						<option value="Llamada">Seguimiento: Llamada telefónica</option>
						<option value="Correo">Seguimiento: Correo electrónico</option>
						<option value="Visita">Seguimiento: Visita presencial</option>
						<option value="Videoconferencia">Seguimiento: Videoconferencia</option>';
					}
					if ($id_usuario==$id_usuasignado OR $id_usuario==$id_usuasignado2 OR $id_usuario==$id_usuasignador){
						echo '
						<option value="Apoyo">Seguimiento: Apoyo Técnico</option>';
					}
					echo'
					</select>
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
	else {}
	}
	echo '<br/><br/>';
    $eventos=mysql_query("SELECT * FROM tmeventos WHERE id_proyecto='$id' ORDER BY id_evento DESC",$conexion);
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
								<span class="mensaje-adjunto"><a href="adjuntos/proyectos/'.$fila['nombre_adjunto'].'" target="_blank" class="link-min"><img src="imagenes/adjuntar.png" height="16px" width="16px"> '.$fila['nombre_adjunto'].' | '.$fila['peso_adjunto'].' Kb</a></span>
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
<br/></td>
</tr>
</table>
<br />
<?php include "footer.php"; ?></div>
<br />
</body>
</html>
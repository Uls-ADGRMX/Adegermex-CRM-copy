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
// Fecha y Hora actual ////////////////////////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
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
// ID del Producto ////////////////////////////////////
///////////////////////////////////////////////////////
$id_producto = $_GET['id'];
///////////////////////////////////////////////////////
// Informacion del Producto ///////////////////////////
///////////////////////////////////////////////////////
$producto = "SELECT tmproductos.*, tcusuarios.nombre FROM tmproductos JOIN tcusuarios WHERE tmproductos.id_usuario = tcusuarios.id_usuario AND id_producto=$id_producto";
$datos=mysql_query($producto, $conexion) or die(mysql_error());
$arrayproducto = mysql_fetch_object($datos);
$id_usugenera = $arrayproducto->id_usuario;
$nombre_usugenera = $arrayproducto->nombre;
$fecha_alta = $arrayproducto->fecha_alta;
$hora_alta = $arrayproducto->hora_alta;
$status = $arrayproducto->status;
$nombre_producto = $arrayproducto->nombre_producto;
$categoria = $arrayproducto->categoria;
$subcategoria = $arrayproducto->subcategoria;
$region = $arrayproducto->region;
$pais = $arrayproducto->pais;
$zona = $arrayproducto->zona;
$fabricante = $arrayproducto->fabricante;
$marca = $arrayproducto->marca;
$pais_origen = $arrayproducto->pais_origen;
$almacenamiento = $arrayproducto->almacenamiento;
$empaque = $arrayproducto->empaque;
$empaque_unidad = $arrayproducto->empaque_unidad;
$precio = $arrayproducto->precio;
$precio1 = $arrayproducto->precio1;
$fecha_busqueda = $arrayproducto->fecha_busqueda;
$web = $arrayproducto->web;
$tiendas = $arrayproducto->tiendas;
$descripcion = $arrayproducto->descripcion;
$claims = $arrayproducto->claims;
$aplicacion = $arrayproducto->aplicacion;
$porcion = $arrayproducto->porcion;
$porcion_unidad = $arrayproducto->porcion_unidad;
$porcionn = $arrayproducto->porcionn;
$porcionn_unidad = $arrayproducto->porcionn_unidad;
$n1 = $arrayproducto->n1;
$n2 = $arrayproducto->n2;
$n3 = $arrayproducto->n3;
$n4 = $arrayproducto->n4;
$n5 = $arrayproducto->n5;
$n6 = $arrayproducto->n6;
$n7 = $arrayproducto->n7;
$ingredientesad = $arrayproducto->ingredientesad;
$ingredientesa = $arrayproducto->ingredientesa;
$sabores = $arrayproducto->sabores;
$ingredientes = $arrayproducto->ingredientes;
$alergenos = $arrayproducto->alergenos;
$dieta = $arrayproducto->dieta;
$nombre_imagen = $arrayproducto->nombre_imagen;
$peso_imagen = $arrayproducto->peso_imagen;
$tipo_imagen = $arrayproducto->tipo_imagen;
///////////////////////////////////////////////////////
// Imágenes del Producto //////////////////////////////
///////////////////////////////////////////////////////
$imagenes = mysql_query("SELECT * FROM tcimagenes WHERE id_producto = '$id_producto'",$conexion);
$numero_imagenes=mysql_num_rows($imagenes);
///////////////////////////////////////////////////////
// Informacion del Productos Similares ////////////////
///////////////////////////////////////////////////////
$similares = mysql_query("SELECT * FROM tmproductos WHERE categoria = '$categoria' AND id_producto<>'$id_producto' ORDER BY RAND() LIMIT 4",$conexion);
$numero_similares=mysql_num_rows($similares);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Título de la Página -->
<title>Adegermex S.A. de C.V. | Inteligencia de Mercado</title>
<!-- CSS -->
<link rel="stylesheet" href="css/css.css" type="text/css">
<!-- FavIcon -->
<link rel="shortcut icon" type="icon/ico" href="favicon.ico"/>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#393E46">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <?php include "header.php"; ?><br />
    </td>
  </tr>
</table>
<br />
<?php include "menu.php"; ?>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo">Inteligencia de Mercado</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Producto</td>
      <td width="500" align="right" class="factura-texto4">ID: <?php echo $id_producto; ?></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="370" align="center" valign="top" class="factura-texto4"><table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
		  <?php
		  $ruta_imagen = 'adjuntos/productos/'.$nombre_imagen;
		  if($nombre_imagen=="0" OR $nombre_imagen=="")
		  	{
				echo '<a href="subir_imagenes.php?id='.$id_producto.'&t=p#contenido" title="Subir Imagen"><img src="imagenes/noimagen.png" width="350" height="350" class="opacidad" /></a>';
			}
			else {
				if(file_exists($ruta_imagen))
					{
						echo '<a href="adjuntos/productos/'.$nombre_imagen.'" target="_blank"><img src="adjuntos/productos/'.$nombre_imagen.'" width="350" height="350" class="opacidad" /></a>';
					}
					else {
						echo '<a href="subir_imagenes.php?id='.$id_producto.'&t=p#contenido" title="Subir Imagen"><img src="imagenes/noimagen.png" width="350" height="350" class="opacidad" /></a>';
						}
					}
		  ?>
          </td>
        </tr>
        <?php
		  if($nombre_imagen=="0" OR $nombre_imagen=="")
		  	{
			}
			else {
				if(file_exists($ruta_imagen))
					{
						echo '
						<tr>
							<td style="padding-top:5px; padding-bottom:5px;" bgcolor="#FFFFFF" align="center">
								<a href="engines/eliminar_imagenp.php?id_producto='.$id_producto.'" class="link-min"><img src="imagenes/wrong.png" width="12px" height="12px;"> Eliminar</a>
							</td>
						</tr>';
					}
					else {
						}
					}
		?>
      </table></td>
      <td width="630" align="center" valign="top"><table width="620" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td valign="top" bgcolor="#FFFFFF" style="height:320px; padding-left:15px; padding-right:15px; padding-top:15px; padding-bottom:15px;"><table width="570" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td colspan="2"><span class="titulo"><strong><?php echo $nombre_producto; ?></strong></span></td>
                </tr>
              <tr>
                <td colspan="2"><span class="subtitulo">Categoria: <span class="noaprobado"><?php echo $categoria; ?></span> | Subcategoria: <span class="generado-sin"><?php echo $subcategoria; ?></span></span></td>
                </tr>
              <tr>
                <td colspan="2" style="padding-top:15px; padding-bottom:15px;"><span class="texto-moneda-2">$<?php echo $precio; ?> MXN</span></td>
                </tr>
              <tr>
                <td width="170"><strong><span class="factura-texto2">Precio por 1 Kg / L</span></strong></td>
                <td width="384">$<?php echo $precio1; ?> MXN</td>
              </tr>
              <tr>
                <td><strong><span class="factura-texto2">Presentación</span></strong></td>
                <td><?php echo $empaque." ".$empaque_unidad; ?></td>
              </tr>
              <tr>
                <td><strong><span class="factura-texto2">Almacenamiento</span></strong></td>
                <td><?php echo $almacenamiento; ?></td>
              </tr>
              <tr>
                <td style="padding-top:20px;"><strong><span class="factura-texto2">Fecha de Alta</span></strong></td>
                <td style="padding-top:20px;"><?php echo $fecha_alta; ?> a las <?php echo $hora_alta; ?> horas</td>
              </tr>
              <tr>
                <td><strong><span class="factura-texto2">Registrado por</span></strong></td>
                <td><?php
                $ruta_avatar = 'imagenes/avatar'.$id_usugenera.'.png';
				if(file_exists($ruta_avatar))
					{
						echo '<img src="imagenes/avatar'.$id_usugenera.'.png" width="50" height="50" title="'.$nombre_usugenera.'"/>';
					}
				else {
						echo '<img src="imagenes/avatar.png" width="50" height="50" title="'.$nombre_usugenera.'"/>';
				}
				?></td>
              </tr>
  </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <?php
  if($tipo_usuario=="Prueba")
  {
	  echo '
  <table width="980" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	  	<br/>
        <table width="700" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="350" align="center"><input name="modificar" type="button" class="boton-asignar" id="modificar" value="Modificar Producto" /></td>
            <td width="350" align="center"><input name="eliminar" type="button" class="boton-eliminar" id="eliminar" value="Eliminar Producto" /></td>
          </tr>
        </table>
        <br />
		</td>
    </tr>
  </table>
  <br />';
  }
  else {
  }
  ?>
  <?php
  if($numero_imagenes<>"0")
  {
		echo '
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>';
			while($fila=mysql_fetch_array($imagenes)){
				$nombre_imagen = $fila['nombre_imagen'];
				$ruta_imagen = 'adjuntos/productos/'.$nombre_imagen;
				echo '
				<td width="200" align="center">
					<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
            			<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">
                    			<a href="adjuntos/productos/'.$nombre_imagen.'" target="_blank">';
								if($nombre_imagen=="0" OR $nombre_imagen=="")
									{
										echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
									}
								else {
									if(file_exists($ruta_imagen))
										{
											echo '<img src="adjuntos/productos/'.$nombre_imagen.'" width="180" height="180" class="opacidad" />';
										}
									else {
										echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
										}
									}
								echo '
								</a>
							</td>
						</tr>';
						if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
						{
						echo '
						<tr>
							<td style="padding-top:5px; padding-bottom:5px;" bgcolor="#FFFFFF" align="center">
								<a href="engines/eliminar_imagen.php?id_imagen='.$fila["id_imagen"].'" class="link-min"><img src="imagenes/wrong.png" width="12px" height="12px;"> Eliminar</a>
							</td>
						</tr>';
						}
				echo '</table>
				</td>';
				}
			if($numero_imagenes=="1")
			{
				for($i=1; $i<=4; $i++)
				{
					echo '
					<td width="200" align="center" valign="top">
						<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
							<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">';
								if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
								{
									echo '
                    			<a href="subir_imagenes.php?id='.$id_producto.'&t=s#contenido" title="Subir Imagen">
									<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />
								</a>';
								}
								else {
									echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
								}
							echo '</td>
							</tr>
						</table>
					</td>';
				}
			}
			if($numero_imagenes=="2")
			{
				for($i=1; $i<=3; $i++)
				{
					echo '
					<td width="200" align="center" valign="top">
						<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
							<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">';
								if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
								{
									echo '
                    			<a href="subir_imagenes.php?id='.$id_producto.'&t=s#contenido" title="Subir Imagen">
									<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />
								</a>';
								}
								else {
									echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
								}
							echo '</td>
							</tr>
						</table>
					</td>';
				}
			}
			if($numero_imagenes=="3")
			{
				for($i=1; $i<=2; $i++)
				{
					echo '
					<td width="200" align="center" valign="top">
						<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
							<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">';
								if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
								{
									echo '
                    			<a href="subir_imagenes.php?id='.$id_producto.'&t=s#contenido" title="Subir Imagen">
									<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />
								</a>';
								}
								else {
									echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
								}
							echo '</td>
							</tr>
						</table>
					</td>';
				}
			}
			if($numero_imagenes=="4")
			{
				for($i=1; $i<=1; $i++)
				{
					echo '
					<td width="200" align="center" valign="top">
						<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
							<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">';
								if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
								{
									echo '
                    			<a href="subir_imagenes.php?id='.$id_producto.'&t=s#contenido" title="Subir Imagen">
									<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />
								</a>';
								}
								else {
									echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
								}
							echo '</td>
							</tr>
						</table>
					</td>';
				}
			}
		echo '</tr>
		</table>';
	}
	else {
		echo '
		<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>';
			for($i=1; $i<=5; $i++)
				{
				echo '<td width="200" align="center">
					<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
            			<tr>
                			<td align="center" bgcolor="#FFFFFF" style="height:180px;">';
								if($tipo_usuario=="Administrador" OR $id_usuario==$id_usugenera)
								{
									echo '
                    			<a href="subir_imagenes.php?id='.$id_producto.'&t=s#contenido" title="Subir Imagen">
									<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />
								</a>';
								}
								else {
									echo '<img src="imagenes/galeria.png" width="120" height="120" class="opacidad-accion" />';
								}
							echo '</td>
						</tr>
					</table>
				</td>';
				}
			echo '</tr>
		</table>';
	}
  ?>
  <br/>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="960" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td><strong>Descripción del Producto</strong></td>
          </tr>
          <tr>
            <td><img src="imagenes/linea-850.png" width="950" height="1" /></td>
          </tr>
          <tr>
            <td align="justify"><?php echo $descripcion; ?></td>
          </tr>
        </table>        <br />
      </td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Información Comercial</td>
      <td width="500" class="factura-texto4">Información de Mercado</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; height:160px;"><table width="470" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="140" align="center"><img src="imagenes/region.png" width="120" height="120" /></td>
              <td width="330"><table width="310" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr>
                  <td width="110" valign="top" class="encabezado-tabla">Región</td>
                  <td width="184" valign="top" class="subtitulo"><?php echo $region; ?></td>
                </tr>
                <tr>
                  <td valign="top" class="encabezado-tabla">País</td>
                  <td valign="top" class="subtitulo"><?php echo $pais; ?></td>
                </tr>
                <tr>
                  <td valign="top" class="encabezado-tabla">Zona</td>
                  <td valign="top" class="subtitulo"><?php echo $zona; ?></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
        </tr>
      </table></td>
      <td width="500" align="center" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; height:160px;"><table width="470" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="140" align="center"><img src="imagenes/comercial.png" width="120" height="120" /></td>
                <td width="330"><table width="310" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td width="110" valign="top" class="encabezado-tabla">Fabricante</td>
                    <td width="184" valign="top" class="subtitulo"><?php echo $fabricante; ?></td>
                  </tr>
                  <tr>
                    <td valign="top" class="encabezado-tabla">Marca Comercial</td>
                    <td valign="top" class="subtitulo"><?php echo $marca; ?></td>
                  </tr>
                  <tr>
                    <td valign="top" class="encabezado-tabla">País de Origen</td>
                    <td valign="top" class="subtitulo"><?php echo $pais_origen; ?></td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Búsqueda del Producto</td>
      <td width="500" class="factura-texto4">Etiquetado del Producto</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" valign="top" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; height:160px;"><table width="470" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="140" align="center"><img src="imagenes/buscar.png" width="120" height="120" /></td>
              <td width="330"><table width="310" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr>
                  <td width="110" valign="top" class="encabezado-tabla">Fecha de Búsqueda</td>
                  <td width="184" valign="top" class="subtitulo"><?php echo $fecha_busqueda; ?></td>
                </tr>
                <tr>
                  <td valign="top" class="encabezado-tabla">Sitio Web</td>
                  <td valign="top" class="subtitulo"><?php
                  if($web=="" OR $web=="No Definido")
				  {
					  echo 'No Definido';
				  }
				  else {
					  echo '<a href="'.$web.'" target="_blank">Ir al sitio web <img src="imagenes/viñeta-verde.png" width="14" height="14"></a>';
				  }
				  ?></td>
                </tr>
                <tr>
                  <td valign="top" class="encabezado-tabla">Tiendas de Compra</td>
                  <td valign="top" class="subtitulo"><?php echo $tiendas; ?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
      <td width="500" align="center" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px; height:160px;"><table width="470" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td align="center"><?php
			if($n1=="0" AND $n2=="0" AND $n3=="0" AND $n4=="0" AND $n5=="0" AND $n6=="0" AND $n7=="0")
			{
				echo '
				<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td class="mensaje-notificacion" align="center">Este producto no cuenta con sellos de la <strong>NOM 051</strong></td>
					</tr>
				</table>';
			}
			else {
				if($n1=="1")
				{
					echo '<img src="imagenes/nom051-n1.png" width="80" height="90"/>';
				}
				if($n2=="1")
				{
					echo '<img src="imagenes/nom051-n2.png" width="80" height="90"/>';
				}
				if($n3=="1")
				{
					echo '<img src="imagenes/nom051-n3.png" width="80" height="90"/>';
				}
				if($n4=="1")
				{
					echo '<img src="imagenes/nom051-n4.png" width="80" height="90"/>';
				}
				if($n5=="1")
				{
					echo '<img src="imagenes/nom051-n5.png" width="80" height="90"/>';
				}
				if($n6=="1")
				{
					echo '<br/><img src="imagenes/nom051-n6.png" width="400" height="31"/>';
				}
				if($n7=="1")
				{
					echo '<br/><img src="imagenes/nom051-n7.png" width="400" height="31" />';
				}
			}
			?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td width="500" class="factura-texto4">Información Nutrimental</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px;"><table width="470" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="factura-texto3">Porción Recomendada</td>
          </tr>
          <tr>
            <td align="center"><strong><?php
			if($porcion=="")
				{
					echo "No Definido";
				}
				else {
					echo $porcion.' '.$porcion_unidad;
				}
				?></strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="500" align="center" class="factura-texto4"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
      <tr>
        <td align="center" bgcolor="#FFFFFF" style="padding-top:15px; padding-bottom:15px;"><table width="470" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="factura-texto3">Porción Nutrimental</td>
          </tr>
          <tr>
            <td align="center"><strong><?php
			if($porcionn=="")
				{
					echo "No Definido";
				}
				else {
					echo $porcionn.' '.$porcionn_unidad;
				}
				?></strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="200" align="center" valign="middle"><img src="imagenes/nutrimental.png" width="180" height="180" /></td>
          <td width="700" valign="middle">
          <?php
          if($ingredientesad=="1")
		  {
			echo '
			<table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td width="664" align="center" valign="top" class="mensaje-notificacion">El producto <strong>contiene</strong> ingredientes <strong>ADEGERMEX</strong></td>
				</tr>
			</table>
            <br />
            <table width="680" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td width="165" valign="top" class="encabezado-tabla">Ingredientes ADEGERMEX</td>
					<td width="515" valign="top" class="subtitulo">'.$ingredientesa.'</td>
				</tr>
			</table>';  
		  }
		  else {
			  echo '
			  	<table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td width="664" align="center" valign="top" class="mensaje-correcto">El producto <strong>no contiene</strong> ingredientes <strong>ADEGERMEX</strong></td>
					</tr>
				</table>';
				}
		  ?>
          <br />
            <table width="680" border="0" align="center" cellpadding="4" cellspacing="0">
              <tr>
              <td valign="top" class="encabezado-tabla">Claims</td>
              <td valign="top" class="subtitulo"><?php echo $claims; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Aplicación</td>
              <td valign="top" class="subtitulo"><?php echo $aplicacion; ?></td>
            </tr>
            <tr>
              <td width="165" valign="top" class="encabezado-tabla">Sabores</td>
              <td width="515" valign="top" class="subtitulo"><?php echo $sabores; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Ingredientes</td>
              <td valign="top" class="subtitulo"><?php echo $ingredientes; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Alérgenos</td>
              <td valign="top" class="subtitulo"><?php echo $alergenos; ?></td>
            </tr>
            <tr>
              <td valign="top" class="encabezado-tabla">Tipo de Dieta</td>
              <td valign="top" class="subtitulo"><?php echo $dieta; ?></td>
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
    <td class="factura-texto4">Productos similares en <?php echo $categoria; ?></td>
    </tr>
</table>
<br />
<?php
if($numero_similares=="0")
{
	echo '
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
			<tr>
				<td align="center" bgcolor="#FFFFFF">
					<br />
					<table width="850" border="0" align="center" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center"><img src="imagenes/mercado.png" width="180" height="180" /></td>
						</tr>
						<tr>
							<td align="center" class="factura-texto2">No hay <strong>Productos similares</strong> agregados.</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>
		</table>
	';
}
else {
	echo '
	<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>';
			while($fila=mysql_fetch_array($similares)){
			echo '<td width="250" align="center" valign="top" class="factura-texto4">
				<table width="230" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
					<tr>
						<td align="center" bgcolor="#FFFFFF">
							<a href="producto.php?id='.$fila['id_producto'].'#contenido">';
							$nombre_imagen = $fila['nombre_imagen'];
							$ruta_imagen = 'adjuntos/productos/'.$nombre_imagen;
								if($nombre_imagen=="0" OR $nombre_imagen=="")
									{
										echo '<img src="imagenes/noimagen.png" width="230" height="230" class="opacidad" />';
									}
								else {
									if(file_exists($ruta_imagen))
										{
											echo '<img src="adjuntos/productos/'.$nombre_imagen.'" width="230" height="230" class="opacidad" />';
										}
									else {
										echo '<img src="imagenes/noimagen.png" width="230" height="230" class="opacidad" />';
										}
									}
							echo '
							</a>
						</td>
					<tr>
						<td bgcolor="#FFFFFF" align="center" style="padding-top:10px; padding-bottom:10px; padding-left:10px; padding-right:10px;" class="factura-texto2">
							'.$fila['nombre_producto'].'
						</td>
					</tr>
				</table>
			</td>';
			}
			if($numero_similares=="1")
			{
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
			}
			if($numero_similares=="2")
			{
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
			}
			if($numero_similares=="3")
			{
				echo '<td width="250" align="center" class="factura-texto4">&nbsp;</td>';
			}
		echo '</tr>
	</table>
	';
}
?><br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
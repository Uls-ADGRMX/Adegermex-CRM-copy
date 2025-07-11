<?php
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: index.php');
}
include ("../scripts/conexion.php");
$id_usuario = $_SESSION['id_usuario'];
$usuario = "SELECT * FROM tcusuarios WHERE id_usuario=$id_usuario";
$datos=mysql_query($usuario, $conexion) or die(mysql_error());
$arrayusuario = mysql_fetch_object($datos);
$tipo_usuario = $arrayusuario->tipo_usuario;
$q = $_POST["q"];
$formula = "SELECT * FROM tmformulas WHERE nombre_formula LIKE '%".$q."%' OR codigo_interno LIKE '%".$q."%' ORDER BY id_formula ASC LIMIT 10";
$resul_formula = mysql_query($formula,$conexion);
if(mysql_num_rows($resul_formula)==0)
	{
		echo "<span class='subtitulo'><center>No hay resultados que mostrar</center></span>";
	}
else
	{
		echo '<table width="950" border="0" cellspacing="0" cellpadding="4" align="center">
			<tr class="encabezado-tabla">
				<td width="70">Folio</td>
				<td width="340">Nombre de la Fórmula / Producto</td>
				<td width="160"><img src="imagenes/calendario.png" width="16" height="16" /> Fecha</td>
				<td width="160">Código de control interno</td>
				<td width="80">Status</td>
				<td width="100" align="center">Opciones</td>
			</tr>';
			while($fila=mysql_fetch_array($resul_formula)){
				echo '<tr>
					<td colspan="6"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
					</tr>
					<tr class="celda-activa">
						<td valign="top">'.$fila['id_formula'].'</td>
						<td valign="top"><a href="formula.php?id='.$fila['id_formula'].'#contenido" class="link">'.$fila['nombre_formula'].'</a>';
						if ($fila['master']=="1") {echo ' <img src="imagenes/estrella.png" width="14" height="14" title="Fórmula Maestra">';} else {}
						echo '</td>
						<td valign="top">'.$fila['fecha_alta'].' | '.$fila['hora_alta'].'</td>
						<td valign="top">'.$fila['codigo_interno'].'</td>
						<td valign="top">';
						if ($fila['status']=="Activa") { echo '<span class="autorizado">'.$fila['status'].'</span>'; } else { echo '<span class="eliminado">'.$fila['status'].'</span>'; }
						echo '</td>
						<td align="center" valign="top"><table width="60" border="0" cellspacing="0" cellpadding="0">
							<tr>';
								echo '<td align="center"><a href="formula.php?id='.$fila['id_formula'].'#contenido"><img src="imagenes/detalles.png" width="16" height="16" title="Detalles"/></a></td>
							</tr>
						</table>
						</td>
					</tr>';
					}
				echo'</table>';
				}
?>
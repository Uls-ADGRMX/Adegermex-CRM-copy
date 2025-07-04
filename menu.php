<?php
///////////////////////////////////////////////////////
// Menu por perfil de Usuario /////////////////////////
///////////////////////////////////////////////////////
switch ($tipo_usuario) {
	case "Administrador":
	echo '
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0"><tr>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="principal.php"><img src="imagenes/inicio-boton.png" width="180" height="74" class="opacidad"/></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="proyectos.php"><img src="imagenes/proyectos-boton.png" width="180" height="74" class="opacidad"/></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="clientes.php"><img src="imagenes/clientes-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="formulas.php"><img src="imagenes/formulas-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="insumos.php"><img src="imagenes/insumos-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="tipo_cambio.php"><img src="imagenes/cambio-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="proveedores.php"><img src="imagenes/proveedores-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="costos.php"><img src="imagenes/costos-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="simulador.php"><img src="imagenes/simulador-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="estadisticas.php"><img src="imagenes/estadisticas-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="cotizaciones.php"><img src="imagenes/cotizaciones-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="mercado.php"><img src="imagenes/mercado-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	break;
	case "Agente de Ventas":
	echo '
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="principal.php"><img src="imagenes/inicio-boton.png" width="180" height="74" class="opacidad"/></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="clientes.php"><img src="imagenes/clientes-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="estadisticas.php"><img src="imagenes/estadisticas-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="mercado.php"><img src="imagenes/mercado-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
	break;
	case "Agente de Compras":
	echo '
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="principal.php"><img src="imagenes/inicio-boton.png" width="180" height="74" class="opacidad"/></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="insumos.php"><img src="imagenes/insumos-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="proveedores.php"><img src="imagenes/proveedores-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="costos.php"><img src="imagenes/costos-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="tipo_cambio.php"><img src="imagenes/cambio-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
	break;
	case "Desarrollador":
	echo '
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="principal.php"><img src="imagenes/inicio-boton.png" width="180" height="74" class="opacidad"/></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="formulas.php"><img src="imagenes/formulas-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="insumos.php"><img src="imagenes/insumos-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="tipo_cambio.php"><img src="imagenes/cambio-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="simulador.php"><img src="imagenes/simulador-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="estadisticas.php"><img src="imagenes/estadisticas-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="mercado.php"><img src="imagenes/mercado-boton.png" width="180" height="74" class="opacidad" /></a></td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
				<td align="center">
					<table width="180" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
		break;
	case "Consultor":
	echo '
		<table width="1000" border="0" align="center" cellpadding="5" cellspacing="0"><tr>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="principal.php"><img src="imagenes/inicio-boton.png" width="180" height="74" class="opacidad"/></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="proyectos.php"><img src="imagenes/proyectos-boton.png" width="180" height="74" class="opacidad"/></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="clientes.php"><img src="imagenes/clientes-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="tipo_cambio.php"><img src="imagenes/cambio-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
			<td align="center">
				<table width="180" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="estadisticas.php"><img src="imagenes/estadisticas-boton.png" width="180" height="74" class="opacidad" /></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	break;
		}
///////////////////////////////////////////////////////
// Notificación de Tipo de Cambio del día /////////////
///////////////////////////////////////////////////////
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$cambiohoy=mysql_query("SELECT * FROM tctcambio WHERE fecha_alta='$fecha'",$conexion);
$cambiohoy_num=mysql_num_rows($cambiohoy);
if ($cambiohoy_num==0 AND ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Agente de Compras" OR $tipo_usuario=="Desarrollador"))
	{
		echo '
		<br/>
		<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="mensaje-error">No se ha definido el <b>Tipo de Cambio</b> del día de hoy. Es necesario registrar el tipo de cambio para la captura de <b>Costos</b>, <b>Cotizaciones</b> y // <b>Simulador</b>.</td>
			</tr>
		</table>';
		}
///////////////////////////////////////////////////////
// Notificación de último costo de Insumo /////////////
///////////////////////////////////////////////////////
if ($tipo_usuario=="Administrador" OR $tipo_usuario=="Superusuario" OR $tipo_usuario=="Desarrollador" OR $tipo_usuario=="Agente de Compras")
	{
		$costos=mysql_query("
		SELECT tcinsumos.nombre, tcinsumos.codigo, tmcostos.valor_pesos, tmcostos.valor_dolares
		FROM tmcostos
		JOIN tcinsumos
		WHERE tmcostos.id_insumo=tcinsumos.id_insumo AND (tmcostos.incrementables='0' OR tmcostos.incrementables='2') ORDER by tmcostos.id_costo DESC LIMIT 1",$conexion);
		$numero_costos=mysql_num_rows($costos);
		if ($numero_costos==0)
		{
			}
		else {
			$arraycosto=mysql_fetch_object($costos);
			echo '
			<br/>
			<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td class="mensaje-correcto">El insumo <strong>'.$arraycosto->nombre.' (Código: '.$arraycosto->codigo.')</strong> ahora tiene un costo de <strong>$ '.number_format($arraycosto->valor_pesos,4,".",",").' MXN ( $ '.number_format($arraycosto->valor_dolares,4,".",",").' USD )</strong></td>
				</tr>
			</table>';
			}
	}
?>
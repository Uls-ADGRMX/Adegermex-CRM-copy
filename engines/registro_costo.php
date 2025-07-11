<?php
session_start();
if(empty($_SESSION['id_usuario'])){
	header('Location: ../index.php');
}
include '../scripts/conexion.php';
$id_usuario = $_SESSION['id_usuario'];
$q = $_POST["q"];
$insumo = "SELECT * FROM tcinsumos WHERE codigo LIKE '$q%' OR nombre LIKE '%$q%' ORDER BY id_insumo ASC LIMIT 1";
$resul_insumo = mysql_query($insumo,$conexion);
if(mysql_num_rows($resul_insumo)==0)
	{
		echo "<span class='subtitulo'><center>No se encontraron resultados</center></span>";
	}
else
	{
		$fila_insumo=mysql_fetch_array($resul_insumo);
		$proveedores=mysql_query("SELECT * FROM tcproveedores ORDER BY nombre ASC",$conexion);
		$numero_proveedores=mysql_num_rows($proveedores);
		if ($numero_proveedores==0)
		{
			echo "<span class='subtitulo'><center>No se encontraron proveedores en sistema.<br/>Es necesario dar de alta <a href='proveedores.php'>Proveedores</a> para registrar costos.</center></span>";
			
		}
		else {
		echo '
			<form action="engines/registrar_costo.php" method="post">
				<table width="850" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
						<td><img src="imagenes/linea-850.png" width="850" height="1" /></td>
					</tr>
				</table>
				<br />
				<table width="850" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
						<td colspan="3" align="center">';
		echo '<input type="hidden" value="'.$id_usuario.'" id="id_usuario" name="id_usuario"><input type="hidden" value="'.$fila_insumo['id_insumo'].'" id="id_insumo" name="id_insumo"><span class="titulo">'.$fila_insumo['nombre'].'</span><br/><span class="subtitulo"><b>( Código: '.$fila_insumo['codigo'].' )</b></span></td>';
		echo '</tr>
		<tr>
			<td align="center"><input name="costo" type="number" class="textbox-min-moneda" id="costo" min="0.0001" step="0.0001" placeholder="$" required="required" value="1"/></td>
			<td width="280" rowspan="2" align="center"><img src="imagenes/linea-proveedor.png" width="280" height="45" /></td>
			<td width="285" align="center"><img src="imagenes/proveedor-min.png" width="100" height="57" /></td>
		</tr>
        <tr>
			<td width="285" align="center">
				<select name="moneda" class="textbox-min" id="moneda" style="height:35px;">
					<option value="1">Pesos</option>
					<option value="2">Dolares</option>
				</select>
			<td align="center">
				<select name="proveedor" class="textbox-med" id="proveedor" style="height:35px; width:250px;">';
					if ($numero_proveedores==0)
						{
							echo '<option value="0">Sin Proveedores registrados</option>';
						}
					else {
						echo '<optgroup label="Proveedores">';
						while ($filap=mysql_fetch_array($proveedores))
							{
								echo '<option value="'.$filap['id_proveedor'].'">'.$filap['nombre'].'</option>'; 
							}
						echo '</optgroup>';
						}
			echo '</select>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td width="210">¿Requiere incrementables?</td>
				<td colspan="3"><input type="checkbox" name="incrementa" id="incrementa"> Sí</td>
			</tr>
			<tr>
				<td>Incoterm</td>
				<td colspan="3"><select name="incoterm" class="textbox-med" id="incoterm" style="height:35px;">
					<optgroup label="Transporte en general">
						<option>Ex-Works (EXW)</option>
						<option>Free Carrier (FCA)</option>
						<option>Carriage Paid To (CPT)</option>
						<option>Carriage and Insurance Paid To (CIP)</option>
						<option>Delivered At Place (DAP)</option>
						<option>Delivered at Place Unloaded (DPU)</option>
						<option>Delivered Duty Paid (DDP)</option>
					</optgroup>
					<optgroup label="Transporte marítimo">
						<option>Free Alongside Ship (FAS)</option>
						<option>Free On Board (FOB)</option>
						<option>Cost and Freight (CFR)</option>
						<option>Cost, Insurance, and Freight (CIF)</option>
					</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<td>País</td>
                <td width="210">
                	<select name="pais" class="textbox-med" id="pais" style="height:30px;">
                    	<optgroup label="Principales">
                        	<option>MEXICO</option>
                            <option>ESTADOS UNIDOS</option>
                            <option>CANADA</option>
                        </optgroup>
                        <optgroup label="Otros">
                        	<option>AFGANISTAN</option>
                            <option>ALBANIA</option>
                            <option>ALEMANIA</option>
                            <option>ANDORRA</option>
                            <option>ANGOLA</option>
							<option>ANGUILLA</option>
							<option>ANTIGUA Y BARBUDA</option>
							<option>ANTILLAS HOLANDESAS</option>
							<option>ARABIA SAUDI</option>
							<option>ARGELIA</option>
							<option>ARGENTINA</option>
							<option>ARMENIA</option>
							<option>ARUBA</option>
							<option>AUSTRALIA</option>
							<option>AUSTRIA</option>
							<option>AZERBAIYAN</option>
<option>BAHAMAS</option>
<option>BAHREIN</option>
<option>BANGLADESH</option>
<option>BARBADOS</option>
<option>BELARUS</option>
<option>BELGICA</option>
<option>BELICE</option>
<option>BENIN</option>
<option>BERMUDAS</option>
<option>BHUTÁN</option>
<option>BOLIVIA</option>
<option>BOSNIA Y HERZEGOVINA</option>
<option>BOTSWANA</option>
<option>BRASIL</option>
<option>BRUNEI</option>
<option>BULGARIA</option>
<option>BURKINA FASO</option>
<option>BURUNDI</option>
<option>CABO VERDE</option>
<option>CAMBOYA</option>
<option>CAMERUN</option>
<option>CHAD</option>
<option>CHILE</option>
<option>CHINA</option>
<option>CHIPRE</option>
<option>COLOMBIA</option>
<option>COMORES</option>
<option>CONGO</option>
<option>COREA</option>
<option>COREA DEL NORTE </option>
<option>COSTA DE MARFIL</option>
<option>COSTA RICA</option>
<option>CROACIA</option>
<option>CUBA</option>
<option>DINAMARCA</option>
<option>DJIBOUTI</option>
<option>DOMINICA</option>
<option>ECUADOR</option>
<option>EGIPTO</option>
<option>EL SALVADOR</option>
<option>EMIRATOS ARABES UNIDOS</option>
<option>ERITREA</option>
<option>ESLOVENIA</option>
<option>ESPAÑA</option>
<option>ESTONIA</option>
<option>ETIOPIA</option>
<option>FIJI</option>
<option>FILIPINAS</option>
<option>FINLANDIA</option>
<option>FRANCIA</option>
<option>GABON</option>
<option>GAMBIA</option>
<option>GEORGIA</option>
<option>GHANA</option>
<option>GIBRALTAR</option>
<option>GRANADA</option>
<option>GRECIA</option>
<option>GROENLANDIA</option>
<option>GUADALUPE</option>
<option>GUAM</option>
<option>GUATEMALA</option>
<option>GUAYANA FRANCESA</option>
<option>GUERNESEY</option>
<option>GUINEA</option>
<option>GUINEA ECUATORIAL</option>
<option>GUINEA-BISSAU</option>
<option>GUYANA</option>
<option>HAITI</option>
<option>HONDURAS</option>
<option>HONG KONG</option>
<option>HUNGRIA</option>
<option>INDIA</option>
<option>INDONESIA</option>
<option>IRAN</option>
<option>IRAQ</option>
<option>IRLANDA</option>
<option>ISLA DE MAN</option>
<option>ISLA NORFOLK</option>
<option>ISLANDIA</option>
<option>ISLAS ALAND</option>
<option>ISLAS CAIMÁN</option>
<option>ISLAS COOK</option>
<option>ISLAS DEL CANAL</option>
<option>ISLAS FEROE</option>
<option>ISLAS MALVINAS</option>
<option>ISLAS MARIANAS DEL NORTE</option>
<option>ISLAS MARSHALL</option>
<option>ISLAS PITCAIRN</option>
<option>ISLAS SALOMON</option>
<option>ISLAS TURCAS Y CAICOS</option>
<option>ISLAS VIRGENES BRITANICAS</option>
<option>ISLAS VÍRGENES DE LOS ESTADOS UNIDOS</option>
<option>ISRAEL</option>
<option>ITALIA</option>
<option>JAMAICA</option>
<option>JAPON</option>
<option>JERSEY</option>
<option>JORDANIA</option>
<option>KAZAJSTAN</option>
<option>KENIA</option>
<option>KIRGUISTAN</option>
<option>KIRIBATI</option>
<option>KUWAIT</option>
<option>LAOS</option>
<option>LESOTHO</option>
<option>LETONIA</option>
<option>LIBANO</option>
<option>LIBERIA</option>
<option>LIBIA</option>
<option>LIECHTENSTEIN</option>
<option>LITUANIA</option>
<option>LUXEMBURGO</option>
<option>MACAO</option>
<option>MACEDONIA </option>
<option>MADAGASCAR</option>
<option>MALASIA</option>
<option>MALAWI</option>
<option>MALDIVAS</option>
<option>MALI</option>
<option>MALTA</option>
<option>MARRUECOS</option>
<option>MARTINICA</option>
<option>MAURICIO</option>
<option>MAURITANIA</option>
<option>MAYOTTE</option>
<option>MICRONESIA</option>
<option>MOLDAVIA</option>
<option>MONACO</option>
<option>MONGOLIA</option>
<option>MONTENEGRO</option>
<option>MONTSERRAT</option>
<option>MOZAMBIQUE</option>
<option>MYANMAR</option>
<option>NAMIBIA</option>
<option>NAURU</option>
<option>NEPAL</option>
<option>NICARAGUA</option>
<option>NIGER</option>
<option>NIGERIA</option>
<option>NIUE</option>
<option>NORUEGA</option>
<option>NUEVA CALEDONIA</option>
<option>NUEVA ZELANDA</option>
<option>OMAN</option>
<option>PAISES BAJOS</option>
<option>PAKISTAN</option>
<option>PALAOS</option>
<option>PALESTINA</option>
<option>PANAMA</option>
<option>PAPUA NUEVA GUINEA</option>
<option>PARAGUAY</option>
<option>PERU</option>
<option>POLINESIA FRANCESA</option>
<option>POLONIA</option>
<option>PORTUGAL</option>
<option>PUERTO RICO</option>
<option>QATAR</option>
<option>REINO UNIDO</option>
<option>REP.DEMOCRATICA DEL CONGO</option>
<option>REPUBLICA CENTROAFRICANA</option>
<option>REPUBLICA CHECA</option>
<option>REPUBLICA DOMINICANA</option>
<option>REPUBLICA ESLOVACA</option>
<option>REUNION</option>
<option>RUANDA</option>
<option>RUMANIA</option>
<option>RUSIA</option>
<option>SAHARA OCCIDENTAL</option>
<option>SAMOA</option>
<option>SAMOA AMERICANA</option>
<option>SAN BARTOLOME</option>
<option>SAN CRISTOBAL Y NIEVES</option>
<option>SAN MARINO</option>
<option>SAN PEDRO Y MIQUELON </option>
<option>SAN VICENTE Y LAS GRANADINAS</option>
<option>SANTA HELENA</option>
<option>SANTA LUCIA</option>
<option>SANTA SEDE</option>
<option>SANTO TOME Y PRINCIPE</option>
<option>SENEGAL</option>
<option>SERBIA</option>
<option>SEYCHELLES</option>
<option>SIERRA LEONA</option>
<option>SINGAPUR</option>
<option>SIRIA</option>
<option>SOMALIA</option>
<option>SRI LANKA</option>
<option>SUDAFRICA</option>
<option>SUDAN</option>
<option>SUECIA</option>
<option>SUIZA</option>
<option>SURINAM</option>
<option>SVALBARD Y JAN MAYEN</option>
<option>SWAZILANDIA</option>
<option>TADYIKISTAN</option>
<option>TAILANDIA</option>
<option>TANZANIA</option>
<option>TIMOR ORIENTAL</option>
<option>TOGO</option>
<option>TOKELAU</option>
<option>TONGA</option>
<option>TRINIDAD Y TOBAGO</option>
<option>TUNEZ</option>
<option>TURKMENISTAN</option>
<option>TURQUIA</option>
<option>TUVALU</option>
<option>UCRANIA</option>
<option>UGANDA</option>
<option>URUGUAY</option>
<option>UZBEKISTAN</option>
<option>VANUATU</option>
<option>VENEZUELA</option>
<option>VIETNAM</option>
<option>WALLIS Y FORTUNA</option>
<option>YEMEN</option>
<option>ZAMBIA</option>
<option>ZIMBABWE</option>
</optgroup>
              </select></td>
				<td width="90" align="center">Ciudad</td>
				<td width="290"><input name="ciudad" type="text" class="textbox-med" id="ciudad" placeholder="Indique la ciudad de procedencia" autocomplete="off" required="required"/></td>
			</tr>
			<tr>
				<td>Cantidad a importar</td>
				<td colspan="3"><input name="cantidad" type="number" min="0" step="1" class="textbox-min" id="cantidad" autocomplete="off" placeholder="#" value="1" required="required"/> kilogramos</td>
			</tr>
			<tr>
				<td>Tipo de transporte</td>
				<td colspan="3"><select name="transporte" class="textbox-med" id="transporte" style="height:35px;">
					<optgroup label="Tipo de transporte">
						<option>Terrestre</option>
						<option>Marítimo</option>
						<option>Aéreo</option>
					</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Comentarios</td>
				<td colspan="3"><textarea name="comentario" cols="45" rows="5" class="textbox-comentario" style="width:550px;" id="comentario" placeholder="Escriba un comentario sobre el registro de costo para el insumo" required="required"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center"><br /><input class="boton-login" type="submit" name="registrar" id="registrar" value="Registrar Costo" /></td>
			</tr>
		</table>
	</form>';
	}
}
?>
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
<!-- Check -->
<script type="text/javascript">
	function mostrarOrigen() {
        element = document.getElementById("divorigen");
        check = document.getElementById("check_origen");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" bgcolor="#F2F3F7">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sombra-header">
  <tr>
    <td height="1" bgcolor="#2255A4">&nbsp;</td>
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
    <td align="center" class="titulo">Clientes</td>
  </tr>
</table>
<br />
<div class="tabcontent">
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Alta de nuevo Cliente</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <form action="engines/alta_cliente.php?usuario=<?php echo $id_usuario; ?>" method="post">
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td class="factura-texto3"><img src="imagenes/descripcion.png" width="15" height="15" /> <strong>Generalidades</strong></td>
          </tr>
          <tr>
            <td><img src="imagenes/linea-800.png" width="800" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="550" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td align="center">Nombre del Cliente / Prospecto</td>
          </tr>
          <tr>
            <td><input name="nombre" type="text" required="required" class="textbox" id="nombre" placeholder="Ejemplo: Adegermex S.A. de C.V." autocomplete="off" autofocus="autofocus"/></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="266">RFC o ID Fiscal</td>
            <td width="266">Tipo</td>
            <td width="266">Pertenece a</td>
          </tr>
          <tr>
            <td><input name="rfc" type="text" class="textbox-med" id="rfc" placeholder="Ejemplo: ADE8703309B6" autocomplete="off" required="required"/></td>
            <td><select name="tipo" class="textbox-med" id="tipo" style="height:35px;">
              <optgroup label="Tipo">
                <option>Cliente</option>
                <option>Prospecto</option>
                </optgroup>
            </select></td>
            <td><select name="pertenece" class="textbox-med" id="pertenece" style="height:35px;">
              <optgroup label="Empresas">
                <option>Adegermex S.A. de C.V.</option>
                <option>General Co-Pack de México S.A. de C.V.</option>
                </optgroup>
            </select></td>
          </tr>
        </table>
        <br />
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td class="factura-texto3"><img src="imagenes/inicio.png" width="18" height="17" /> <strong>Domicilio</strong></td>
          </tr>
          <tr>
            <td><img src="imagenes/linea-800.png" width="800" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="281">Calle</td>
            <td>Número Exterior</td>
            <td width="266">Número Interior</td>
          </tr>
          <tr>
            <td><input name="calle" type="text" class="textbox-med" id="calle" placeholder="Calle" autocomplete="off" required="required"/></td>
            <td><input name="exterior" type="text" class="textbox-min" id="exterior" placeholder="# Exterior" autocomplete="off" required="required"/></td>
            <td><input name="interior" type="text" class="textbox-min" id="interior" placeholder="# Interior" autocomplete="off"/></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="281">Colonia</td>
            <td>Municipio o Localidad</td>
            <td width="266">Estado o Provincia</td>
          </tr>
          <tr>
            <td><input name="colonia" type="text" class="textbox-med" id="colonia" placeholder="Colonia" autocomplete="off" required="required"/></td>
            <td><input name="municipio" type="text" class="textbox-med" id="municipio" placeholder="Municipio o Localidad" autocomplete="off" required="required"/></td>
            <td><input name="estado" type="text" class="textbox-med" id="estado" placeholder="Estado o Provincia" autocomplete="off" required="required"/></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="281">País</td>
            <td>Código Postal o ZIP Code</td>
          </tr>
          <tr>
            <td><select name="pais" class="textbox-med" id="pais" style="height:35px;">
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
            <td><input name="cp" type="number" class="textbox-min" id="cp" placeholder="#" autocomplete="off" step="1" min="1" required="required"/></td>
          </tr>
        </table>
        <br />
        <br />
        </td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Origen y envío</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td class="factura-texto3"><img src="imagenes/web.png" width="16" height="16" /><strong> Origen</strong></td>
          </tr>
          <tr>
            <td><img src="imagenes/linea-800.png" width="800" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="263">¿Cómo nos conoció el cliente?</td>
            <td width="140">&nbsp;</td>
            <td width="373">&nbsp;</td>
          </tr>
          <tr>
            <td><select name="origen" class="textbox-med" id="origen" style="height:35px;">
              <optgroup label="Proactivo">
                <option>Búsqueda proactiva</option>
                </optgroup>
              <optgroup label="Reactivo">
                <option>Referencia</option>
                <option>Expo</option>
                <option>Llamada telefónica</option>
                <option>Correo electrónico</option>
                </optgroup>
              <optgroup label="Redes Sociales">
                <option>Facebook</option>
                <option>Instagram</option>
                <option>LinkedIn</option>
                </optgroup>
              <optgroup label="Internet">
                <option>Sitio Web</option>
                </optgroup>
              <optgroup label="Portales Industriales B2B">
                <option>Cosmos Online</option>
                <option>QuimiNet</option>
                </optgroup>
            </select></td>
            <td><input type="checkbox" name="check_origen" id="check_origen" onchange="javascript:mostrarOrigen()"/>
              Otro origen</td>
            <td><div id="divorigen" style="display:none;">
              <input type="text" class="textbox-med" placeholder="Indique otro origen" name="otro_origen" id="otro_origen" autocomplete="off" style="height:20px; width:320px;"/>
            </div></td>
          </tr>
        </table>
        <br />
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td class="factura-texto3"><img src="imagenes/detalles.png" width="16" height="16" /><strong> Información para envío</strong></td>
          </tr>
          <tr>
            <td><img src="imagenes/linea-800.png" width="800" height="1" /></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td>Instrucciones para envió de muestras y documentación</td>
          </tr>
          <tr>
            <td><textarea name="instrucciones" cols="50" rows="5" class="textbox-comentario" id="instrucciones" placeholder="Indique referencias del domicilio, horario de recepción, persona que recibe, requisitos para ingreso o alguna información relevante" required="required" style="width:780px;"></textarea></td>
          </tr>
        </table>
        <br />
        <br /></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Información de negocio</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="230">Segmento del cliente</td>
            <td width="570">
            <select name="segmento" class="textbox-med" id="segmento" style="height:35px;">
            	<optgroup label="Segmento">
                	<option>Panificación</option>
                    <option>Lácteos</option>
                    <option>Cárnicos</option>
                    <option>Bebidas</option>
                    <option>Snacks</option>
                    <option>Culinario</option>
                    <option>Vegetales</option>
                    <option>Food Service</option>
                    <option>Otro</option>
                 </optgroup>
             </select></td>
          </tr>
          <tr>
            <td>Estrategía de negocio del cliente</td>
            <td><textarea name="estrategia" cols="50" rows="5" class="textbox-comentario" id="estrategia" placeholder="Describa la estrategia de negocio del cliente" style="width:550px;"></textarea></td>
          </tr>
          <tr>
            <td>Estrategía de negocio interna</td>
            <td><textarea name="interna" cols="50" rows="5" class="textbox-comentario" id="interna" placeholder="Describa la estrategia de negocio interna a seguir para el cliente" style="width:550px;"></textarea></td>
          </tr>
          <tr>
            <td>Líneas de negocio</td>
            <td><textarea name="lineas" cols="50" rows="5" class="textbox-comentario" id="lineas" placeholder="Describa las líneas de negocio en tiene el cliente" style="width:550px;"></textarea></td>
          </tr>
          <tr>
            <td>Tipos de productos</td>
            <td><textarea name="productos" cols="50" rows="5" class="textbox-comentario" id="productos" placeholder="Describa los tipos de productos que produce o comercializa el cliente" style="width:550px;"></textarea></td>
          </tr>
          <tr>
            <td>Procesos</td>
            <td><textarea name="procesos" cols="50" rows="5" class="textbox-comentario" id="procesos" placeholder="Describa los procesos que tiene el cliente" style="width:550px;"></textarea></td>
          </tr>
        </table>
        <br />
        <br /></td>
    </tr>
  </table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Contacto principal</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="265">Nombre del contacto</td>
            <td width="265">Teléfono</td>
            <td width="270">Correo electrónico</td>
          </tr>
          <tr>
            <td><input name="nombre_contacto" type="text" class="textbox-med" id="nombre_contacto" placeholder="Nombre del contacto" autocomplete="off" required="required"/></td>
            <td><input name="telefono" type="tel" class="textbox-med" id="telefono" placeholder="Teléfono" autocomplete="off" required="required"/></td>
            <td><input name="correo" type="email" class="textbox-med" id="correo" placeholder="Correo electrónico" autocomplete="off" required="required"/></td>
          </tr>
        </table>
        <br />
        <table width="800" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="265">Puesto</td>
            <td width="265">Departamento</td>
            <td width="270">&nbsp;</td>
          </tr>
          <tr>
            <td><input name="puesto" type="text" class="textbox-med" id="puesto" placeholder="Puesto" autocomplete="off" required="required"/></td>
            <td><select name="departamento" class="textbox-med" id="departamento" style="height:35px;">
              <optgroup label="Dirección General">
                <option>Dirección General</option>
                </optgroup>
              <optgroup label="Dirección de Administración y Finanzas">
                <option>Dirección de Administración y Finanzas</option>
                <option>Compras</option>
                <option>Contabilidad</option>
                <option>Costos</option>
                <option>Gestión de Calidad</option>
                <option>Recursos Humanos</option>
                <option>Sistemas</option>
                <option>Ventas</option>
                </optgroup>
              <optgroup label="Dirección de Operaciones">
                <option>Dirección de Operaciones</option>
                <option>Almacén</option>
                <option>Calidad</option>
                <option>Investigación y Desarrollo</option>
                <option>Mantenimiento</option>
                <option>Planeación</option>
                <option>Producción</option>
                </optgroup>
              <optgroup label="Otro">
                <option>Otro</option>
                </optgroup>
            </select></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br />
        <br />
        <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
          </tr>
          <tr>
            <td align="center" class="subtitulo"><br />
              ó <a href="clientes.php">Cancelar</a></td>
          </tr>
        </table>
        <br />
        <br /></td>
    </tr>
  </table>
  </form><br />
  <?php include "footer.php"; ?></div>
<br />
</body>
</html>
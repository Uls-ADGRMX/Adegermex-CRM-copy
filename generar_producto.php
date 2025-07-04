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
<!-- Checks -->
<script type="text/javascript">
    function mostrarIngredientes() {
        element = document.getElementById("divingredientes");
        check = document.getElementById("check_ingredientes");
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
      <td width="500" class="factura-texto4"><a name="contenido" id="contenido"></a>Generar nuevo Producto</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <form action="engines/alta_producto.php" method="post" enctype="multipart/form-data">
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>"><br />
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="185" valign="middle">Nombre Comercial</td>
            <td width="765"><input name="nombre_producto" type="text" class="textbox" id="nombre_producto" placeholder="Indique el nombre comercial del producto" autocomplete="off" autofocus="autofocus" required="required"/></td>
          </tr>
      </table>
        <br />
<br /></td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <table width="960" border="0" cellspacing="0" cellpadding="4">
          <tr class="factura-texto-min">
            <td align="center" class="factura-texto3">Imágen Principal</td>
            <td width="494" rowspan="4" align="center" class="factura-texto3"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
                  <br />
                  - Cargue la imagen <strong>principal</strong> del producto, posteriormente podrá agregar imágenes adicionales.<br />
                  - Puede cargar imágenes en formato <strong>JPG, PNG y BMP</strong>.<br />
                  - Puede cargar imágenes de hasta <strong>5 Megabytes</strong>.</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td width="450" align="center"><label for="adjuntar"><img src="imagenes/galeria.png" width="130" height="130" title="Subir Imágen" class="opacidad" />
              <input id="adjuntar" name="adjuntar" class="adjuntar" type="file" accept=".jpg, .png, .jpeg, .bmp"/>
            </label></td>
            </tr>
          <tr>
            <td align="center" class="encabezado-tabla">Subir imágen</td>
            </tr>
          <tr>
            <td align="center">
            	<span id="narchivo" class="subtitulo">&nbsp;</span>
                </td>
            </tr>
        </table>
        <br /></td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Clasificación</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="195" valign="middle">Categoría</td>
            <td width="230"><select name="categoria" class="textbox-med" id="categoria" style="height:35px;">
              <option>No Definido</option>
              <optgroup label="Food">
                <option>Alimentación infantil</option>
                <option>Panadería</option>
                <option>Cereales para el desayuno</option>
                <option>Confitería de chocolate</option>
                <option>Lácteos</option>
                <option>Postres y helados</option>
                <option>Frutas y verduras</option>
                <option>Comidas preparadas</option>
                <option>Carnes procesadas</option>
                <option>Salsas y condimentos</option>
                <option>Alimentos instantáneos</option>
                <option>Snacks</option>
                <option>Sopa</option>
                <option>Azúcar y goma de mascar</option>
                <option>Edulcorantes y azúcar</option>
                </optgroup>
              <optgroup label="Drinks">
                <option>Bebidas alcohólicas</option>
                <option>Bebidas RTD</option>
                <option>Refrescos carbonatados</option>
                <option>Bebidas calientes</option>
                <option>Bebidas deportivas y energéticas</option>
                <option>Agua</option>
                <option>Otras bebidas</option>                
                </optgroup>
              <optgroup label="Pet">
                <option>Pet Food</option>
                <option>Pet Products</option>
                </optgroup>
            </select></td>
            <td width="115">Subcategoría</td>
            <td width="378"><input name="subcategoria" type="text" class="textbox-med" id="subcategoria" placeholder="Indique la subcategoría del producto" autocomplete="off" required="required"/></td>
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
      <td width="500" class="factura-texto4">Descripción del Producto</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="185" valign="top">Descripción</td>
            <td width="765"><textarea name="descripcion" cols="50" rows="5" class="textbox-box" id="descripcion" placeholder="Indique la descripción del producto (puede mencionar la denominación, origen de los ingredientes, sellos sustentables, declaraciones de salud, certificaciones, biodegradable, innovación, etcétera.)" style="width:550px;" required="required"></textarea></td>
          </tr>
        </table>
        <br />
        <br /></td>
    </tr>
  </table>
<br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Mercado</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
    <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="185" valign="middle">Región</td>
            <td width="765"><select name="region" class="textbox-login" id="region" style="height:35px;">
              <option>No Definido</option>
              <optgroup label="Región">
                <option>Norteamérica</option>
                <option>América Latina</option>
                <option>Asia</option>
                <option>Europa</option>
                <option>Medio Oriente y África</option>
                <option>Global</option>
                </optgroup>
            </select></td>
          </tr>
          <tr>
            <td valign="middle">País</td>
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
          </tr>
          <tr>
            <td valign="middle">Zona</td>
            <td><select name="zona" class="textbox-login" id="zona" style="height:35px;">
              <option>No Definido</option>
              <optgroup label="Zona">
                <option>Norte</option>
                <option>Sur</option>
                <option>Centro</option>
                <option>Oriente</option>
                <option>Occidente</option>
                <option>General</option>
                </optgroup>
            </select></td>
          </tr>
</table>
        <br />
<br /></td>
    </tr>
</table>
  <br />
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="500" class="factura-texto4">Información Comercial</td>
      <td width="500" align="right" class="factura-texto4">&nbsp;</td>
    </tr>
  </table>
  <br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
      <td align="center" bgcolor="#FFFFFF"><br />
        <br />
        <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="185" valign="middle">Fabricante o Distribuidor</td>
            <td width="765"><input name="fabricante" type="text" class="textbox" id="fabricante" placeholder="Indique el fabricante del producto" autocomplete="off" required="required"/></td>
          </tr>
          <tr>
            <td valign="middle">Marca Comercial</td>
            <td><input name="marca" type="text" class="textbox" id="marca" placeholder="Indique la marca comercial del producto" autocomplete="off" required="required"/></td>
          </tr>
          <tr>
            <td valign="middle">País de Origen</td>
            <td><select name="pais_origen" class="textbox-med" id="pais_origen" style="height:35px;">
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
          </tr>
        </table>
        <br />
<br /></td>
    </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Características del Producto</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Almacenamiento</td>
          <td width="765"><input name="almacenamiento" type="text" class="textbox" id="almacenamiento" placeholder="Indique el tipo de almacenamiento del producto" autocomplete="off"/></td>
        </tr>
        <tr>
          <td valign="middle">Presentación</td>
          <td><input name="empaque" type="number" class="textbox-min" id="empaque" placeholder="#" autocomplete="off" step="0.01" min="0" required="required"/>
            <select name="empaque_unidad" class="textbox-min" id="empaque_unidad" style="height:35px;width:150px;">
              <optgroup label="Unidad de Medida">
                <option>Kilogramos</option>
                <option>Gramos</option>
                <option>Litros</option>
                <option>Mililitros</option>
                </optgroup>
            </select></td>
          </tr>
        <tr>
          <td valign="middle">Precio</td>
          <td>$
            <input name="precio" type="number" class="textbox-min" id="precio" placeholder="$" autocomplete="off" step="0.01" min="0" required="required"/>
MXN</td>
        </tr>
        <tr>
          <td valign="middle">Precio por 1 Kg / L</td>
          <td>$
            <input name="precio1" type="number" class="textbox-min" id="precio1" placeholder="$" autocomplete="off" step="0.01" min="0" required="required"/>
MXN</td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Fecha de búsqueda</td>
          <td width="765"><input name="fecha_busqueda" type="date" class="textbox-med" id="fecha_busqueda" autocomplete="off" value="<?php echo $fecha; ?>"/></td>
        </tr>
        <tr>
          <td valign="middle">Sitio Web</td>
          <td><input name="web" type="url" class="textbox" id="web" placeholder="Indique la dirección de Internet del producto" autocomplete="off"/></td>
        </tr>
      </table>
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
            <br />
            Capture las <strong>Tiendas de Compra</strong> separando cada una de ellas por una coma (<strong>,</strong>).</td>
        </tr>
    </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Tiendas de compra</td>
          <td width="765"><input name="tiendas" type="text" class="textbox" id="tiendas" placeholder="Indique las tiendas de compra para el producto" autocomplete="off"/></td>
        </tr>
    </table>
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
            <br />
            Capture las <strong>Claims</strong> separando cada una de ellas por una coma (<strong>,</strong>).<br />
            <br />
            Puede mencionar si el producto es sin azúcar, de origen local, reducido en sodio, ingredientes de origen local, etcétera.</td>
        </tr>
    </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Claims</td>
          <td width="765"><input name="claims" type="text" class="textbox" id="claims" placeholder="Ingrese las etiquetas para el producto" autocomplete="off"/></td>
        </tr>
      </table>
<br />
      <br /></td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="factura-texto4">Especificaciones del Producto</td>
    <td width="500" align="right" class="factura-texto4">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
            <br />
            Capture las <strong>Aplicaciónes</strong> separando cada una de ellas por una coma (<strong>,</strong>).<br />
            <br />
            Puede mencionar información mostrada en el envase del producto como listo para servir, hidratar en X ml, etcétera.</td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Aplicación</td>
          <td width="765"><input name="aplicacion" type="text" class="textbox" id="aplicacion" placeholder="Indique el tipo de aplicacion del producto" autocomplete="off"/></td>
        </tr>
        <tr>
          <td valign="middle">Porción recomendada</td>
          <td><input name="porcion" type="number" class="textbox-min" id="porcion" placeholder="#" autocomplete="off" step="0.01" min="0"/>
            <select name="porcion_unidad" class="textbox-min" id="porcion_unidad" style="height:35px;width:150px;">
              <optgroup label="Unidad de Medida">
                <option>Kilogramos</option>
                <option>Gramos</option>
                <option>Litros</option>
                <option>Mililitros</option>
                </optgroup>
            </select></td>
        </tr>
        <tr>
          <td valign="middle">Porción nutrimental</td>
          <td><input name="porcionn" type="number" class="textbox-min" id="porcionn" placeholder="#" autocomplete="off" step="0.01" min="0"/>
            <select name="porcionn_unidad" class="textbox-min" id="porcionn_unidad" style="height:35px;width:150px;">
              <optgroup label="Unidad de Medida">
                <option>Kilogramos</option>
                <option>Gramos</option>
                <option>Litros</option>
                <option>Mililitros</option>
                </optgroup>
            </select></td>
        </tr>
  </table>
      <br />
      <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="934" valign="middle" class="factura-texto3"><strong>Norma Oficial Mexicana 051</strong></td>
          </tr>
    </table>
      <br />
      <table width="800" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="90" align="center"><label class="switch"><input type="checkbox" id="n1" name="n1"/><span class="sliders round"></span></label></td>
          <td width="310">Exceso de Calorias</td>
          <td width="90" align="center"><label class="switch"><input type="checkbox" id="n6" name="n6"/><span class="sliders round"></span></label></td>
          <td width="310">Contiene Edulcorantes</td>
        </tr>
        <tr>
          <td align="center"><label class="switch"><input type="checkbox" id="n2" name="n2"/><span class="sliders round"></span></label></td>
          <td>Exceso de Sodio</td>
          <td align="center"><label class="switch"><input type="checkbox" id="n7" name="n7"/><span class="sliders round"></span></label></td>
          <td>Contiene Cafeina</td>
        </tr>
        <tr>
          <td align="center"><label class="switch"><input type="checkbox" id="n3" name="n3"/><span class="sliders round"></span></label></td>
          <td>Exceso de Grasas Trans</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><label class="switch"><input type="checkbox" id="n4" name="n4"/><span class="sliders round"></span></label></td>
          <td>Exceso de Azucares</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><label class="switch"><input type="checkbox" id="n5" name="n5"/><span class="sliders round"></span></label></td>
          <td>Exceso de Grasas Saturadas</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br />
      <br /></td>
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><br />
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
            <br />
            Capture la siguiente información separando cada valor por una coma (<strong>,</strong>).</td>
        </tr>
</table>
      <br />
      <br />
      <table width="950" border="0" cellspacing="0" cellpadding="4">
      	<tr>
        	<td valign="middle" class="factura-texto3"><strong>¿Contiene ingredientes ADEGERMEX? <strong>
            	<input type="checkbox" name="check_ingredientes" id="check_ingredientes" onchange="javascript:mostrarIngredientes()"/>
                </strong>
            </td>
        </tr>
        </table>
	      	<div id="divingredientes" style="display: none;">
                	<table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
                    	<tr>
                        	<td width="185" valign="middle">Indique los ingredientes</td>
                            <td width="765"><input name="ingredientesa" type="text" class="textbox" id="ingredientesa" placeholder="Ingrese los ingredientes ADEGERMEX" autocomplete="off"/></td>
                        </tr>
                    </table>
                </div>
      <br/>
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td width="185" valign="middle">Sabores</td>
          <td width="765"><input name="sabores" type="text" class="textbox" id="sabores" placeholder="Ingrese los sabores del producto" autocomplete="off"/></td>
        </tr>
        <tr>
          <td valign="middle">Ingredientes</td>
          <td><input name="ingredientes" type="text" class="textbox" id="ingredientes" placeholder="Ingrese los ingredientes del producto" autocomplete="off"/></td>
        </tr>
        <tr>
          <td valign="middle">Alérgenos</td>
          <td><input name="alergenos" type="text" class="textbox" id="alergenos" placeholder="Ingrese los alergenos del producto" autocomplete="off"/></td>
        </tr>
        <tr>
          <td valign="middle">Tipo de dieta</td>
          <td><input name="dieta" type="text" class="textbox" id="dieta" placeholder="Ingrese el tipo de dieta del producto" autocomplete="off"/></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><input class="boton-login" type="submit" name="guardar" id="guardar" value="Guardar Producto" /></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            ó <a href="mercado.php">Cancelar</a></td>
        </tr>
  </table>
<br />
      <br /></td>
  </tr>
</table>
  </form><br />
  <?php include "footer.php"; ?></div>
<br />
<script>
	let input = document.getElementById("adjuntar");
	let imageName = document.getElementById("narchivo")
	input.addEventListener('change', ()=>{
		let inputImage = document.querySelector("input[type=file]").files[0];
		imageName.innerHTML = "<strong>Archivo seleccionado:</strong> <i>" + inputImage.name + "</i>&nbsp;<img src='imagenes/check.png'/>";
	})
</script>
</body>
</html>
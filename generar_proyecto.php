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
// Validar clientes en sistema ////////////////////////
///////////////////////////////////////////////////////
$clientes=mysql_query("SELECT * FROM tcclientes WHERE id_asignado = $id_usuario ORDER BY nombre ASC",$conexion);
$numero_clientes=mysql_num_rows($clientes);
if ($numero_clientes==0)
	{
		header('Location: proyecto_sinclientes.php#contenido');
	}
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
<!-- Checks -->
<script type="text/javascript">
	function mostrarEntregada() {
        element = document.getElementById("diventregada");
        check = document.getElementById("check_entregada");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
	function mostrarRequerida() {
        element = document.getElementById("divrequerida");
        check = document.getElementById("check_requerida");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
    function mostrarAlergenos() {
        element = document.getElementById("divalergenos");
        check = document.getElementById("check_alergenos");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
    function mostrarCertificacion() {
        element = document.getElementById("divcertificacion");
        check = document.getElementById("check_certificacion");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
    function mostrarEnvio() {
        element = document.getElementById("divenvio");
        check = document.getElementById("envio1");
        if (check.checked) {
            element.style.display='none';
        }
        check2 = document.getElementById("envio2");
        if (check2.checked) {
            element.style.display='none';
        }
        check3 = document.getElementById("envio3");
        if (check3.checked) {
            element.style.display='block';
        }
    }
</script>
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="factura-texto4"><a name="contenido" id="contenido"></a>Generar nuevo Proyecto</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="sombra">
  <tr>
    <td bgcolor="#FFFFFF"><br />
      <br /><form action="engines/alta_proyecto.php" method="post" name="proenv"><div id="Proyecto" class="tabcontent"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Proyecto')" id="defaultOpen" hidden="hidden"></a>
          <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50" align="center"><img src="imagenes/1-activo-azul.png" width="39" height="40" /></td>
              <td width="162" class="encabezado-tabla">Información del Proyecto</td>
              <td width="50" align="center"><img src="imagenes/2-inactivo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Información de Negocio</td>
              <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
              <td width="162" class="subtitulo">Detalles del Desarrollo</td>
              <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
              <td width="164" class="subtitulo">Información Adicional</td>
            </tr>
          </table>
          <br />
          <br />
          <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="titulo">Clasificación</td>
            </tr>
            <tr>
              <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
            </tr>
          </table>
          <br />
          <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Tipo de Proyecto</strong></td>
              <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Categoría del Proyecto</strong></td>
              <td width="316" align="center" class="factura-texto4"><strong class="factura-texto3">Segmento del Proyecto</strong></td>
            </tr>
            <tr>
              <td align="center"><select name="tipo" class="textbox-med" id="tipo" style="height:30px;">
                <option>Proactivo</option>
                <option>Reactivo</option>
              </select></td>
              <td align="center"><select name="categoria" class="textbox-med" id="categoria" style="height:30px;">
                <option>Ajos y Cebollas</option>
                <option>ADEROME Dairy</option>
                <option>ADEROME PVH</option>
                <option>ADEROME Seasoning</option>
                <option>ADEROME Smoke</option>
                <option>ADEROME YE</option>
                <option>Extractos de Té</option>
                <option>Presentación de Tecnologías</option>
                <option>Productos en Riesgo</option>
                <option>Sabores (QA)</option>
                <option>Tomates</option>
                <option>Otro</option>
              </select></td>
              <td align="center"><select name="segmento" class="textbox-med" id="segmento" style="height:30px;">
                <optgroup label="Panificación">
                	<option>Panificación - Sweet</option>
                	<option>Panificación - Harinas</option>
                	<option>Panificación - Cereales</option>
                </optgroup>
                <optgroup label="Lácteos">
                	<option>Lácteos - Quesos</option>
                	<option>Lácteos - Yogurth</option>
                	<option>Lácteos - Leche</option>
                </optgroup>
                <optgroup label="Bebidas">
                	<option>Bebidas - Alcohólicas</option>
                	<option>Bebidas - Isotonicas</option>
                	<option>Bebidas - Energéticas</option>
                	<option>Bebidas - Gasificadas</option>
                	<option>Bebidas - Base Agua</option>
                </optgroup>
                <optgroup label="Cárnicos">
                	<option>Cárnicos</option>
                </optgroup>
                <optgroup label="Snacks">
                	<option>Snacks</option>
                </optgroup>
                <optgroup label="Culinario">
                	<option>Culinario</option>
                </optgroup>
                <optgroup label="Vegetales">
                	<option>Vegetales</option>
                </optgroup>
                <optgroup label="Food Service">
                	<option>Food Service</option>
                </optgroup>
                <optgroup label="Otro">
                	<option>Otro</option>
                </optgroup>
              </select></td>
            </tr>
          </table>
          <br />
          <br />
          <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
          <td align="center" class="titulo">Generalidades</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
    </table>
          <br />
          <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
        <td width="240" valign="middle">Nombre del Proyecto</td>
        <td width="694"><input name="nombre_proyecto" type="text" class="textbox" id="nombre_proyecto" placeholder="Escriba el nombre del proyecto" autocomplete="off" autofocus="autofocus"/></td>
      </tr>
      <tr>
        <td valign="middle">Nombre del Cliente / Prospecto</td>
        <td width="694">
        <?php
		echo '<select name="id_cliente" class="textbox" id="id_cliente" style="height:35px; width:560px;"/>
        <optgroup label="Clientes / Prospectos">';
		while($fila=mysql_fetch_array($clientes))
			{
				echo "<option value='".$fila['id_cliente']."'>".$fila['nombre']."</option>";
			}
		echo '</optgroup>
        </select>';
		?>
        </td>
      </tr>
      <tr>
        <td valign="middle">Fecha requerida de entrega</td>
        <td width="694"><input name="fecha_requerida" type="date"  class="textbox-med" id="fecha_requerida" autocomplete="off" value="<?php
		$fecha_sugerida = strtotime('+10 day', strtotime($fecha));
		$fecha_sugerida=date('Y-m-d',$fecha_sugerida); echo $fecha_sugerida;?>"/></td>
      </tr>
      <tr>
        <td valign="middle">Descripción general del Proyecto</td>
        <td width="694"><textarea name="descripcion"  class="textbox-box" id="descripcion" autocomplete="off" placeholder="Escriba la descripción general del proyecto"></textarea></td>
      </tr>
    </table>
            <input type="hidden" name="id_usugenera" id="id_usugenera" value="<?php echo $id_usuario; ?>">
            <br />
          <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Negocio')"><input class="boton-login" type="button" name="paso2" id="paso2" value="Continuar (Paso 2)" /></a></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          ó <a href="principal.php">Cancelar</a></td>
      </tr>
</table>
      <br />
        </div>
<div id="Negocio" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Información del Proyecto</td>
      <td width="50" align="center"><img src="imagenes/2-activo-azul.png" width="39" height="40" /></td>
      <td width="162" class="encabezado-tabla">Información de Negocio</td>
      <td width="50" align="center"><img src="imagenes/3-inactivo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Detalles del Desarrollo</td>
      <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
      <td width="164" class="subtitulo">Información Adicional</td>
    </tr>
  </table>
  <br />
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Información de Negocio</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="mensaje-correcto"><strong>¡IMPORTANTE!</strong><br />
          <br />La información ingresada en este apartado definirá el <strong>Potencial del Proyecto</strong>.</td>
        </tr>
      </table>
      <br />
      <table width="900" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td colspan="2"><strong>Volumen Mensual</strong></td>
          <td colspan="2"><strong>Precio de venta target por KG</strong></td>
          <td colspan="2"><strong>Costo de la Aplicación</strong></td>
        </tr>
        <tr>
          <td width="90"><input name="vmensual_num" type="number" min="1" step="1" class="textbox-min" id="vmensual_num" placeholder="#" autocomplete="off"/></td>
          <td width="210"><select name="vmensual_uni" class="textbox-min" id="vmensual_uni" style="height:30px;">
            <option>Kilogramos</option>
          </select></td>
          <td width="90"><input name="ptarget_num" type="number" min="0.01" step="0.01" class="textbox-min" id="ptarget_num" placeholder="$" autocomplete="off"/></td>
          <td width="210"><select name="ptarget_mon" class="textbox-min" id="ptarget_mon" style="height:30px;">
            <option>Dolares</option>
          </select></td>
          <td width="90"><input name="caplic_num" type="number" min="1" step="0.01" class="textbox-min" id="caplic_num" placeholder="$" autocomplete="off"/></td>
          <td width="210"><select name="caplic_mon" class="textbox-min" id="caplic_mon" style="height:30px;">
            <option>Pesos</option>
            <option>Dolares</option>
          </select></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Desarrollo')"><input class="boton-login" type="button" name="paso3" id="paso3" value="Continuar (Paso 3)" /></a></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Proyecto')">Volver (Paso 1)</a> ó <a href="principal.php">Cancelar</a></td>
      </tr>
</table>
      <br />
</div>
<div id="Desarrollo" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Información del Proyecto</td>
      <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Información de Negocio</td>
      <td width="50" align="center"><img src="imagenes/3-activo-azul.png" width="39" height="40" /></td>
      <td width="162" class="encabezado-tabla">Detalles del Desarrollo</td>
      <td width="50" align="center"><img src="imagenes/4-inactivo.png" width="39" height="40" /></td>
      <td width="164" class="subtitulo">Información Adicional</td>
    </tr>
  </table>
  <br />
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Detalles del Desarrollo</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><table width="800" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="250" class="factura-texto3"><strong>Etiquetado</strong></td>
              <td width="282" class="factura-texto3"><strong>Estado físico</strong></td>
              <td width="244" class="factura-texto3"><strong>Presentación final (envase)</strong></td>
            </tr>
            <tr>
              <td><select name="etiquetado" class="textbox-med" id="etiquetado" style="height:30px;">
                <option>No Definido</option>
                <optgroup label="Etiquetado">
                  <option>Natural</option>
                  <option>Sin Glutamato Monosódico</option>
                  <option>Reducido en Sodio</option>
                  </optgroup>
              </select></td>
              <td><select name="estado_fisico" class="textbox-med" id="estado_fisico" style="height:30px;">
                <option>No Definido</option>
                <optgroup label="Estado físico">
                  <option>Líquido</option>
                  <option>Polvo</option>
                  <option>Cubicado</option>
                  <option>Rebanado</option>
                  <option>Mitades</option>
                  </optgroup>
              </select></td>
              <td><select name="envase" class="textbox-med" id="envase" style="height:30px;">
                <option>No Definido</option>
                <optgroup label="Presentación final (envase)">
                  <option>Saco</option>
                  <option>Cubeta</option>
                  <option>Caja</option>
                  <option>Bolsa</option>
                  <option>Porrón</option>
                  <option>Botella</option>
                  <option>Tambor</option>
                  <option>Sachet</option>
                  </optgroup>
              </select></td>
            </tr>
          </table>
            <br />
            <table width="800" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td width="250" class="factura-texto3"><strong>Tipo de almacenamiento</strong></td>
                <td width="282" class="factura-texto3"><strong>Dosis de uso</strong></td>
                <td width="244">&nbsp;</td>
              </tr>
              <tr>
                <td><select name="almacenamiento" class="textbox-med" id="almacenamiento" style="height:30px;">
                  <option>No Definido</option>
                  <optgroup label="Tipo de almacenamiento">
                    <option>Temperatura Ambiente</option>
                    <option>Refrigeración</option>
                    <option>Congelación</option>
                    </optgroup>
                </select></td>
                <td valign="middle"><input name="dosis" type="number" min="1" step="0.01" class="textbox-min" id="dosis" autocomplete="off" placeholder="#"/>
                  %</td>
                <td>&nbsp;</td>
              </tr>
</table>
            <br />
            <table width="800" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td valign="middle" class="factura-texto3"><strong>¿Permite el uso de alérgenos? <strong>
                  <input type="checkbox" name="check_alergenos" id="check_alergenos" onchange="javascript:mostrarAlergenos()"/>
                </strong></td>
              </tr>
              <tr>
                <td><div id="divalergenos" style="display: none;">
                  <table width="700" border="0" cellpadding="4" cellspacing="0">
                    <tr>
                      <td width="350"><input type="checkbox" name="a1" id="a1" /> 
                      Cereales que contienen gluten</td>
                      <td width="350"><input type="checkbox" name="a5" id="a5" /> 
                        Soya y sus productos</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="a2" id="a2" /> 
                        Huevo, sus productos y derivados
</td>
                      <td><input type="checkbox" name="a6" id="a6" /> 
                        Leche, sus productos y derivados
</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="a3" id="a3" /> 
                        Pescado y sus productos</td>
                      <td><input type="checkbox" name="a7" id="a7" /> 
                        Nueces de árboles y sus derivados</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" name="a4" id="a4" /> 
                        Cacahuate y sus productos</td>
                      <td><input type="checkbox" name="a8" id="a8" /> 
                        Sulfito en concentraciones de 10mg/kg o más</td>
                    </tr>
                  </table>
                </div></td>
              </tr>
            </table>
            <br />
            <table width="800" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td class="factura-texto3"><strong>Condiciones del proceso</strong></td>
                </tr>
              <tr>
                <td><textarea name="proceso" class="textbox-comentario" id="proceso" autocomplete="off" placeholder="Temperatura, equipo a utilizar, linea de producción, etc."></textarea></td>
                </tr>
</table>
            <br />
            <table width="800" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td class="factura-texto3"><strong>¿Requiere certificación?</strong></td>
                </tr>
              <tr>
                <td align="center" valign="top"><table width="750" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                      <td width="160"><input type="checkbox" name="c1" id="c1" /> 
                        FSSC 22000
</td>
                      <td width="160"><input type="checkbox" name="c2" id="c2" />
KOSHER</td>
                      <td width="160"><input type="checkbox" name="c3" id="c3" />
HALAL</td>
                      <td width="160"><input type="checkbox" name="c4" id="c4" />
No GMO</td>
                      <td width="160"><input type="checkbox" name="c5" id="c5" />
TTB</td>
                    </tr>
                </table>
                  <br />
                  <table width="750" border="0" align="center" cellpadding="4" cellspacing="0">
                    <tr>
                      <td width="200"><input type="checkbox" name="check_certificacion" id="check_certificacion" onchange="javascript:mostrarCertificacion()"/>
                        Otra certificación
                       </td>
                      <td width="550" height="35px"><div id="divcertificacion" style="display:none;">
                          <input type="text" class="textbox-login" placeholder="Indique otra certificación" name="certificacion" id="certificacion" autocomplete="off"/>
                          </div></td>
                    </tr>
    </table></td>
                </tr>
</table></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Documentación</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
    </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><table width="750" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="350"><span class="subtitulo"><strong class="factura-texto3">Entregada por el Cliente</strong></span></td>
              <td width="350"><span class="subtitulo"><strong class="factura-texto3">Requerida por el Cliente</strong></span></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="ec1" id="ec1" />
                Testigo</td>
              <td><input type="checkbox" name="rc1" id="rc1" />
                Ficha Técnica</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="ec2" id="ec2" />
                Base</td>
              <td><input type="checkbox" name="rc2" id="rc2" />
                Hoja de Seguridad</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="ec3" id="ec3" />
                Ficha Técnica</td>
              <td><input type="checkbox" name="rc3" id="rc3" />
                Carta Garantía</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="ec4" id="ec4" />
                Hoja de Seguridad</td>
              <td><input type="checkbox" name="rc4" id="rc4" /> 
                Carta de Origen</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="ec5" id="ec5" />
                Formulación</td>
              <td><input type="checkbox" name="rc5" id="rc5" />
                Declaración de Alérgenos</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="check_entregada" id="check_entregada" onchange="javascript:mostrarEntregada()"/>
                Otro</td>
              <td><input type="checkbox" name="check_requerida" id="check_requerida" onchange="javascript:mostrarRequerida()"/>
                Otro </td>
            </tr>
            <tr>
              <td><div id="diventregada" style="display:none;">
                <input name="entregada" type="text" class="textbox-med" id="entregada" placeholder="Otra documentación entregada" autocomplete="off"/>
              </div></td>
              <td><div id="divrequerida" style="display:none;">
                <input name="requerida" type="text" class="textbox-med" id="requerida" placeholder="Otra documentación requerida" autocomplete="off"/>
              </div></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Envío</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr>
          <td align="center" class="factura-texto3"><strong>La información y muestras del proyecto:</strong></td>
        </tr>
        <tr>
          <td align="center"><table width="650" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td width="50" align="center"><input type="radio" name="envio" id="envio1" checked="checked" value="1" onchange="javascript:mostrarEnvio()"/></td>
              <td width="600">Se entregaran al Agente de Ventas</td>
            </tr>
            <tr>
              <td align="center"><input type="radio" name="envio" id="envio2" value="2" onchange="javascript:mostrarEnvio()"/></td>
              <td>Se enviaran a la dirección fiscal del Cliente</td>
            </tr>
            <tr>
              <td align="center"><input type="radio" name="envio" id="envio3" value="3" onchange="javascript:mostrarEnvio()"/></td>
              <td>Se enviaran a una dirección alterna del Cliente</td>
            </tr>
          </table>
            <table width="650" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td width="50">&nbsp;</td>
                <td width="600"><div id="divenvio" style="display:none;">
                	<textarea name="direccion" cols="45" rows="5" class="textbox-comentario" id="direccion" placeholder="Indique la dirección alternativa para envío" required="required" style="width:500px; height:80px;"></textarea>
                </div></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center"><a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Adicional')">
            <input class="boton-login" type="button" name="paso4" id="paso4" value="Continuar (Paso 4)" />
            </a></td>
        </tr>
        <tr>
          <td align="center" class="subtitulo"><br />
            <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Negocio')">Volver (Paso 2)</a> ó <a href="principal.php">Cancelar</a></td>
        </tr>
</table><br/></div>

<div id="Adicional" class="tabcontent">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50" align="center"><img src="imagenes/1-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Información del Proyecto</td>
      <td width="50" align="center"><img src="imagenes/2-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Información de Negocio</td>
      <td width="50" align="center"><img src="imagenes/3-activo.png" width="39" height="40" /></td>
      <td width="162" class="subtitulo">Detalles del Desarrollo</td>
      <td width="50" align="center"><img src="imagenes/4-activo-azul.png" width="39" height="40" /></td>
      <td width="164" class="encabezado-tabla">Información adicional</td>
    </tr>
  </table>
  <br />
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Información adicional para Sabores</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
        </tr>
      </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><table width="800" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="272" class="factura-texto3"><strong>Clasificación</strong></td>
                <td width="270" class="factura-texto3"><strong>Termoresistente</strong></td>
                <td width="234" class="factura-texto3"><strong>Solubilidad</strong></td>
              </tr>
              <tr>
                <td><select name="clasificacion" class="textbox-med" id="clasificacion" style="height:30px;">
                  <option>No Definido</option>
                  <optgroup label="Clasificación">
                    <option>Natural</option>
                    <option>Idéntico al Natural</option>
                    <option>Artificial</option>
                    <option>Indistinto</option>
                    </optgroup>
                </select></td>
                <td><select name="termoresistente" class="textbox-med" id="termoresistente" style="height:30px;">
                  <option>No Definido</option>
                  <optgroup label="Termoresistente">
                    <option>Sí</option>
                    <option>No</option>
                    </optgroup>
                </select></td>
                <td><select name="solubilidad" class="textbox-med" id="solubilidad" style="height:35px;">
                  <option>No Definido</option>
                  <optgroup label="Solubilidad">
                  <option>Hidrosoluble</option>
                  <option>Oleosoluble</option>
                  <option>Dispersable</option>
                  </optgroup>
                </select></td>
              </tr>
</table>
            <br />
            <table width="800" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td width="272" class="factura-texto3"><strong>Requerimiento</strong></td>
                <td width="270" class="factura-texto3"><strong>Vida de Anaquel</strong></td>
                <td width="234" class="factura-texto3">&nbsp;</td>
                </tr>
              <tr>
                <td><select name="demostracion" class="textbox-med" id="demostracion" style="height:30px;">
                  <option>No Definido</option>
                  <optgroup label="Requerimiento">
                    <option>Demostración</option>
                    <option>Aplicación</option>
                    <option>Demostración y Aplicación</option>
                    </optgroup>
                </select></td>
                <td><input name="anaquel" type="number" min="1" max="99" step="1" class="textbox-min" id="anaquel" autocomplete="off" placeholder="#"/> 
                  meses</td>
                <td>&nbsp;</td>
                </tr>
        </table></td>
        </tr>
    </table>
      <br />
      <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="titulo">Muestras de línea</td>
        </tr>
        <tr>
          <td align="center"><img src="imagenes/linea-950.png" width="950" height="1" /></td>
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
        <td align="center" class="subtitulo"><strong>El proyecto será generado. Verifique la información ingresada antes de continuar.</strong><br /><br /></td>
        </tr>
        <tr>
        <td align="center"><input class="boton-login" type="button" name="enviar" id="enviar" value="Generar Nuevo Proyecto!" onclick="proenv.submit()"/></td>
        </tr>
        <tr>
        <td align="center" class="subtitulo"><br />
          <a href="javascript:void(0)" class="tablinks" onclick="seccion(event, 'Desarrollo')">Volver (Paso 3)</a> ó <a href="principal.php">Cancelar</a></td>
      </tr>
</table><br/></div></form><script>
function seccion(evt, paso) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(paso).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script></td>
  </tr>
</table>
<br />
<?php include "footer.php"; ?>
<br />
</body>
</html>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="124" rowspan="2" align="center" class="subtitulo"><a href="index.php"><img src="imagenes/avatar<?php echo $id_usuario; ?>.png" width="80" height="80" /></a></td>
          <td width="406" class="factura-texto4">¡Bienvenid@ <strong><?php echo $nombre; ?></strong>!</td>
          <td width="470" align="right" class="subtitulo"><img src="imagenes/inicio2.png"/> <a href="index.php">Inicio</a> | <?php if($tipo_usuario=="Administrador") { echo '<img src="imagenes/configuracion2.png"/> <a href="configuracion.php">Configuración</a> | <img src="imagenes/user.png"/> <a href="usuarios.php">Usuarios</a> | '; } ?><img src="imagenes/logout.png"/> <a href="logout.php">Cerrar Sesi&oacute;n</a></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
          	<img src="imagenes/usuario2.png" /> <?php echo $tipo_usuario; ?> | <img src="imagenes/empresa2.png" /> <?php echo $departamento; ?></td>
        </tr>
    </table>
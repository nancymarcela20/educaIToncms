<div style="text-align:center;">
    <h2>Configuraci&oacute;n de variables y par&aacute;metros</h2>
</div>
<?php
if (isset($_GET['msj'])) {
    $_autoro = 0;
    if (isset($_SESSION['flag'])) {
        if ($_SESSION['flag'] == 1) {
            $_autoro = 1;
        }
    }
    if ($_autoro == 1) {
        ?>
        <div id="modal" class="ufps-modal">
            <div class="ufps-modal-content">
                <div class="ufps-modal-header ufps-modal-header-red">
                    <span class="ufps-modal-close">&times;</span>
                    <h2 style="color:#fff;">SWAPIS</h2>
                </div>
                <div class="ufps-modal-body">
                    <?php
                    if ($_GET['msj'] == 1) {
                        echo "<p>Ha ocurrido un error actualizando las variables y par&aacute;metros en la base de datos</p>";
                    } elseif ($_GET['msj'] == 2) {
                        echo "<p>Las variables y par&aacute;metros se han actualizado de manera satisfactoria";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    function validaractividad(idedicion) {
        if (document.forms['annadir'].descripto.value.length > 0) {
            if (!isNaN(document.forms['annadir'].maxwidth.value) && !isNaN(document.forms['annadir'].minwidth.value) && !isNaN(document.forms['annadir'].maxheight.value) && !isNaN(document.forms['annadir'].sliderwidth.value) && !isNaN(document.forms['annadir'].sliderheight.value) && !isNaN(document.forms['annadir'].mininfowidth.value) && !isNaN(document.forms['annadir'].widthgallerythumb.value)) {
                if (document.forms['annadir'].maxwidth.value > 0 && document.forms['annadir'].minwidth.value > 0 && document.forms['annadir'].maxheight.value > 0 && document.forms['annadir'].sliderwidth.value > 0 && document.forms['annadir'].sliderheight.value > 0 && document.forms['annadir'].mininfowidth.value > 0 && document.forms['annadir'].widthgallerythumb.value > 0) {
                    if (confirm("Va a proceder a actualizar los valores de variables y parámetros") == true) {
                        document.forms['annadir'].submit();
                    }
                } else {
                    alert("Los campos de tamaño no pueden estar vacíos");
                }
            } else {
                alert("Deben escribirse números en los campos de tamaños");
            }
        } else {
            alert("La descripción del pie de página no puede estar en blanco");
        }
    }
</script>
<div style="clear:both; width:95%; margin:auto;">
    <form name="annadir" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="configuracion">
        <input type="hidden" name="accion" value="actualizar">
        <?php
        $_myConfiguracion = new Configuraciones();
        $_enlaces = $_myConfiguracion->obtenerVariables();
        if ($_enlaces != 'error') {
            ?>
            <p class="pnormal">Texto descriptivo en pie de p&aacute;gina:<br><textarea class="ufps-textarea" name="descripto"><?php echo str_replace("<br>", "\n", utf8_encode($_enlaces[0][0])); ?></textarea></p>
            <p class="pnormal">Ancho m&aacute;ximo de las im&aacute;genes en el sitio: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="maxwidth" value="<?php echo $_enlaces[0][4]; ?>"></p>
            <p class="pnormal">Alto m&aacute;ximo de las im&aacute;genes en el sitio: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="maxheight" value="<?php echo $_enlaces[0][8]; ?>"></p>
            <p class="pnormal">Ancho de las im&aacute;genes rotatorias del encabezado: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="sliderwidth" value="<?php echo $_enlaces[0][6]; ?>"></p>
            <p class="pnormal">Alto de las im&aacute;genes rotatorias del encabezado: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="sliderheight" value="<?php echo $_enlaces[0][7]; ?>"></p>
            <p class="pnormal">Ancho m&iacute;nimo de las im&aacute;genes rotatorias del encabezado: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="minwidth" value="<?php echo $_enlaces[0][5]; ?>"></p>
            <p class="pnormal">Ancho m&iacute;nimo de las im&aacute;genes en secci&oacute;n de novedades: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="mininfowidth" value="<?php echo $_enlaces[0][10]; ?>"></p>
            <p class="pnormal">Proporci&oacute;n de las im&aacute;genes en secci&oacute;n de novedades: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="ratioinfoimages" value="<?php echo $_enlaces[0][11]; ?>"></p>
            <p class="pnormal">Ancho de la imagen de vista previa de las galer&iacute;as: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="widthgallerythumb" value="<?php echo $_enlaces[0][12]; ?>"></p>
            <p class="pnormal">Ruta a Roxy Fileman&reg;: <input type="text" class="ufps-input-medium ufps-input" name="routetofileman" value="<?php echo $_enlaces[0][9]; ?>"></p>
            <div style="text-align:center; margin-top:15px; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad()"></div>
                <?php
            } else {
                echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">Error obteniendo las variables de configuraci&oacute;n</h2></div>";
            }
            ?>
    </form>
</div>

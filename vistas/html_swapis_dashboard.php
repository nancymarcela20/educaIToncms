<div style="text-align:center;">
    <h2>Tablero de mensajes</h2>
</div>
<div style="clear:both; width:95%; margin:auto;">
    <?php
    $info = new Informaciones;
    $_enlaces = $info->ultimaInformacion();
    if ($_enlaces[0][0] != "error") {
        ?>
        <div class="postit">
            <span style="font-size:0.9em; text-decoration:underline;">Fecha de la &uacute;ltima novedad</span>
            <p style="font-size:0.85em; line-height:1.2em;"><a target="_blank"  href="./index.php?modulo=verinformacion&idinfo=<?php echo $_enlaces[0][0]; ?>"><?php echo utf8_encode($_enlaces[0][2]); ?></a>, el <?php echo fechaLegible($_enlaces[0][1], 1); ?>.</p>
        </div>
        <?php
    }
    $info = new Galerias;
    $_enlaces = $info->ultimaGaleria();
    if ($_enlaces[0][0] != "error") {
        ?>
        <div class="postit">
            <span style="font-size:0.9em; text-decoration:underline;">Fecha de la &uacute;ltima galer&iacute;a</span>
            <p style="font-size:0.85em; line-height:1.2em;"><a target="_blank"  href="./index.php?modulo=detallegaleria&idgale=<?php echo $_enlaces[0][0]; ?>"><?php echo utf8_encode($_enlaces[0][2]); ?></a>, el <?php echo fechaLegible($_enlaces[0][1], 1); ?>.</p>
        </div>
        <?php
    }
    $info = new Ofertas;
    $_enlaces = $info->ultimaOferta();
    if ($_enlaces[0][0] != "error") {
        ?>
        <div class="postit">
            <span style="font-size:0.9em; text-decoration:underline;">Fecha de la &uacute;ltima oferta laboral</span>
            <p style="font-size:0.85em; line-height:1.2em;"><a target="_blank"  href="./index.php?pid=77"><?php echo utf8_encode($_enlaces[0][2]); ?></a>, el <?php echo fechaLegible($_enlaces[0][1], 1); ?>.</p>
        </div>
        <?php
    }
    $info = new TipoCalendarios;
    $_enlaces = $info->cantidadActividadesXCalendarios();
    if ($_enlaces[0][0] != "error") {
        ?>
        <div class="postit">
            <span style="font-size:0.9em; text-decoration:underline;">Actividades en calendarios</span>
            <p style="font-size:0.65em; line-height:1.2em;">
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo utf8_encode($_enlaces[$_a][0]);
                    if ($_enlaces[$_a][1]) {
                        echo " (" . $_enlaces[$_a][2] . ")";
                    } else {
                        echo " (&mdash;)";
                    }
                    echo "<br>";
                }
                ?>
            </p>
        </div>
        <?php
    }
    ?>

</div>

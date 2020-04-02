<?php
$_activo = 0;
$_pick = 1;
if (isset($_GET['modulo'])) {
    if ($_GET['modulo'] == 'veroferta') {
        $_pick = 0;
    }
}
if (isset($_GET['idtipoo'])) {
    if ($_GET['idtipoo'] != 0) {
        $_activo = $_GET['idtipoo'];
    }
}
$_mallainicial = 0;
$_actxpag = 15;
if (isset($_GET['mallainicial'])) {
    if ($_GET['mallainicial']) {
        $_mallainicial = $_GET['mallainicial'];
    }
}
if (isset($_POST['mallainicial'])) {
    if ($_POST['mallainicial']) {
        $_mallainicial = $_POST['mallainicial'];
    }
}
if (isset($_GET['ixp'])) {
    if ($_GET['ixp']) {
        $_actxpag = $_GET['ixp'];
    }
}
if ($_pick) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
        <h1 class="pull-left" style="font-size:36px;">Ofertas laborales</h1>

        <div class="gdl-custom-sidebar-title-m"><div class="ufps-tooltip" style="margin-top:30px; float:right; position:absolute; right:5px; top: 0px;"><span style="float:right"><img src="rsc/img/tune.png" style="cursor:pointer;" id="tuneBtn" onClick="TogglePopUp(event, 'ofertas')"></span><span class="ufps-tooltip-content-left" style="font-size:14px; font-weight:normal; margin-right:5px;">Ajustar filtro</span></div></div>
        <div style="clear:both;"></div>
        <div class="gdl-custom-sidebar" id="ofertas" style='z-index:9;'>
            <a onclick="filtreEvento(event, 'ofertas', '0', <?php echo $_GET['pid']; ?>, '')" class="ufps-btn<?php if ($_activo == 0) {
        echo " ufps-btn-light-active";
    } else {
        echo " ufps-btn-light";
    } ?>">Todos</a>
            <?php
            $_myTipoConvocatorias = new TipoConvocatorias();
            $_enlaces = $_myTipoConvocatorias->obtenerTipoConvocatorias();
            if ($_enlaces[0] != "error") {
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "              <a onclick=\"filtreEvento(event, 'ofertas', '" . $_enlaces[$_a][0] . "'," . $_GET['pid'] . ",'')\" class=\"ufps-btn";
                    if ($_activo == $_enlaces[$_a][0]) {
                        echo " ufps-btn-light-active";
                    } else {
                        echo " ufps-btn-light";
                    }
                    echo "\">" . utf8_encode($_enlaces[$_a][1]) . " <span style=\"background-color:" . $_enlaces[$_a][2] . ";\">&nbsp; &nbsp;</span></a>\n";
                }
            }
            ?>
        </div>
    </div>
    <?php
}
$_myInfo = new Ofertas($_activo);
if ($_pick) {
    $_totalregistros = $_myInfo->totalOfertas(1);
    $_enlaces = $_myInfo->obtenerOfertas($_mallainicial, $_actxpag);
} else {
    
}
if ($_enlaces[0] != "error") {
    ?>
    <div id='modal' class='ufps-modal'>
        <div id='modalentries' class="ufps-modal-content">
        </div>
    </div>
        <?php
        if ($_pick) {
            paginadornufps("pid=77", $_mallainicial, $_totalregistros, $_actxpag, "idtipoo", $_activo);
            ?>
        <div class="ufps-accordion">
                    <?php
                    for ($_a = 0; $_a < count($_enlaces); $_a++) {
                        ?>
                <button class="ufps-btn-accordionwhite ufps-btn-accordionlike ufps-btn-accordion"><?php echo utf8_encode($_enlaces[$_a][3]) . "<span style=\"float:right\">" . fechaLegible($_enlaces[$_a][1]) . "</span>"; ?></button>
                <div class="ufps-accordion-panel" style="padding:0 9px;">
                    <table class="ufps-table-void ufps-table" style="margin-top:10px;">
                        <?php
                        if ($_enlaces[$_a][2] != $_enlaces[$_a][1]) {
                            ?>
                            <tr><td>Fecha l&iacute;mite de la convocatoria:</td></tr><tr><td><?php echo fechaLegible($_enlaces[$_a][2]); ?></td></tr>
                            <?php
                        }
                        ?>
                        <tr><td>Descripci&oacute;n:</td></tr><tr><td><?php echo utf8_encode($_enlaces[$_a][4]); ?></td></tr>
                        <?php
                        if ($_enlaces[$_a][5]) {
                            ?>
                            <tr><td>Habilidades requeridas:</td></tr><tr><td><?php echo utf8_encode($_enlaces[$_a][5]); ?></td></tr>
                            <?php
                        }
                        if ($_enlaces[$_a][6]) {
                            ?>
                            <tr><td>Enlace para m&aacute;s informaci&oacute;n:</td><td><a alt="" target="_blank" href="<?php echo $_enlaces[$_a][5]; ?>"><?php echo $_enlaces[$_a][5]; ?></a></td></tr>
                    <?php
                }
                ?>
                    </table>
                </div>
            <?php
        }
        ?>
        </div>
        <?php
        paginadornufps("pid=77", $_mallainicial, $_totalregistros, $_actxpag, "idtipoo", $_activo);
        ?>
        <div style="height:20px"></div>
        <?php
    } else {
        
    }
} else {
    if ($_pick) {
        echo "<div style=\"width:90%; margin:auto; text-align:center; margin-top:20px;\">";
        if (isset($_GET['idtipoo'])) {
            $_tipoinformacion = strtolower($_myInfo->obtenerTipoConvocatoria($_activo));
            if ($_tipoinformacion == 'error') {
                echo "<h3 class=\"simple\">Lo sentimos, no encontramos ofertas laborales para el tipo de convocatoria que ha solicitado; le pedimos el favor de verificar su solicitud.</h3>";
                echo "<h3 class=\"simple\">Si lo desea, puede seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
            } else {
                echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos ofertas laborales en la convocatoria &laquo;" . utf8_encode($_tipoinformacion) . "&raquo; para mostrar; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a> o elegir otro <a href=\"javascript:TogglePopUp(event, 'ofertas');\">tipo de convocatoria</a>.</h3>";
            }
        } else {
            echo "<h3 class=\"simple\">No hay ofertas laborales definidas.</h3>";
        }
        echo "</div>";
    } else {
        
    }
}
?>

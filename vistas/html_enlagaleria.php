<?php
$_traemodales = "";
$_activo = 0;
$_pick = 1;
if (isset($_GET['modulo'])) {
    if ($_GET['modulo'] == 'detallegaleria') {
        $_pick = 0;
    }
}
if (isset($_GET['idtipog'])) {
    if ($_GET['idtipog'] != 0) {
        $_activo = $_GET['idtipog'];
    }
}
if ($_pick) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
        <h1 class="pull-left" style="font-size:36px;">Galer&iacute;as de im&aacute;genes</h1>
        <div class="gdl-custom-sidebar-title-m"><div class="ufps-tooltip" style="margin-top:30px; float:right; position:absolute; right:5px; top:0px;"><span style="float:right"><img src="rsc/img/tune.png" style="cursor:pointer;" id="tuneBtnG" onClick="TogglePopUp(event, 'galerias')"></span><span class="ufps-tooltip-content-left" style="font-size:14px; font-weight:normal; margin-right:5px;">Ajustar filtro</span></div></div>
        <div style="clear:both;"></div>
        <div class="gdl-custom-sidebar" id="galerias" style='z-index:9;'>
            <a onclick="filtreEvento(event, 'galerias', '0')" class="ufps-btn<?php
            if ($_activo == 0) {
                echo " ufps-btn-light-active";
            } else {
                echo " ufps-btn-light";
            }
            ?>">Todas</a>
               <?php
               $_myTipoGalerias = new Galerias(0);
               $_enlaces = $_myTipoGalerias->obtenerTiposGalerias(0, 0);
               if ($_enlaces[0] != "error") {
                   for ($_a = 0; $_a < count($_enlaces); $_a++) {
                       echo "              <a onclick=\"filtreEvento(event, 'galerias', '" . $_enlaces[$_a][0] . "')\" class=\"ufps-btn";
                       if ($_activo == $_enlaces[$_a][0]) {
                           echo " ufps-btn-light-active";
                       } else {
                           echo " ufps-btn-light";
                       }
                       echo "\">" . utf8_encode($_enlaces[$_a][1]) . "</a>\n";
                   }
               }
               ?>
        </div>
    </div>
    <?php
}
$_myInfo = new Galerias($_activo);
if ($_pick) {
    $_enlaces = $_myInfo->obtenerGalerias(0, 0);
} else {
    $_enlaces = $_myInfo->obtenerGalerias($_GET['idgale'], 1);
}
if ($_enlaces[0] != "error") {
    if ($_pick) {
        for ($_a = 0; $_a < count($_enlaces); $_a++) {
            $_silink = 0;
            if ($_enlaces[$_a][5]) {
                $_silink = 1;
            }
            ?>
            <div class="items-row cols-<?php echo $_enlaces[$_a][0]; ?> row-0">
                <div class="item-information column-1">
                        <?php if ($_enlaces[$_a][4]) { ?>
                        <div class="img-intro-right-nopointer20 img-intro-right">
                            <?php
                            if ($_silink) {
                                echo "<a href=\"./index.php?modulo=detallegaleria&idtipog=" . $_activo . "&idgale=" . $_enlaces[$_a][0] . "\">";
                            }
                            ?><img class="imgInformacion" src="<?php echo $_enlaces[$_a][2]; ?>" alt=""/><?php
                if ($_silink) {
                    echo "</a>";
                }
                            ?>
                        </div>
                            <?php } ?>
                    <div class="float_content">
                        <h1 class="tituloinformacion">
                        <?php
                        if ($_silink) {
                            echo "<a class=\"tituloGaleria\" href=\"./index.php?modulo=detallegaleria&idtipog=" . $_activo . "&idgale=" . $_enlaces[$_a][0] . "\">";
                        }
                        ?>
                    <?php echo utf8_encode($_enlaces[$_a][3]); ?><?php
            if ($_silink) {
                echo "</a>";
            }
                    ?>
                        </h1>
            <?php echo utf8_encode($_enlaces[$_a][4]); ?>
                    </div>
            <?php
            if ($_a < (count($_enlaces) - 1)) {
                echo "<span class=\"row-separator\"></span>";
            }
            ?>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
            <h1 class="pull-left" style="font-size:36px;">Galer&iacute;as de im&aacute;genes</h1>
        </div>
        <h1 class="tituloGaleria">
        <?php echo utf8_encode($_enlaces[0][3]); ?>
        </h1>

        <?php echo utf8_encode($_enlaces[0][4]); ?>

        <div style="clear:both; margin-bottom:15px;"></div>

        <?php
        if ($_enlaces[0][5]) {
            $_thumbs = explode("[|]", $_enlaces[0][5]);
            for ($_a = 0; $_a < count($_thumbs); $_a++) {
                $_eachimage = explode("{|}", $_thumbs[$_a]);
                if ($_a == 0) {
                    $_anterior = count($_thumbs) - 1;
                } else {
                    $_anterior = $_a - 1;
                }
                if (($_a + 1) == count($_thumbs)) {
                    $_siguiente = 0;
                } else {
                    $_siguiente = $_a + 1;
                }
                ?>
                <div class="img-intro-right30 img-intro-right">
                    <img onclick="openModalImage('modal<?php echo $_a; ?>')" src="<?php echo $_eachimage[0]; ?>" class="imgInformacion" alt=""/>
                </div>
                    <?php
                       $_traemodales .= "<div id=\"modal" . $_a . "\" class=\"ufps-image-modal\">\n<span class=\"ufps-image-modal-close\">&times;</span>\n<span class=\"ufps-image-modal-prev\" onclick=\"MyShow('modal" . $_anterior . "')\">&lt;</span>\n<span class=\"ufps-image-modal-next\" onclick=\"MyShow('modal" . $_siguiente . "')\">&gt;</span>\n<img class=\"ufps-image-modal-content\" src=\"" . $_eachimage[0] . "\"><div class=\"ufps-image-modal-caption\">" . utf8_encode($_eachimage[1]) . "</div>\n</div>";
                   }
               } else {
                   echo "<div style=\"text-align:center\"><h3 class=\"simple\">A&uacute;n no hay im&aacute;genes en esta galer&iacute;a.</h3></div>";
               }
               ?>
        <div style="clear:both"></div>
        <p class="readmore-center readmore">
            <a href="./index.php?modulo=galerias<?php
        /**/ if (isset($_GET['idtipog'])) {
            echo "&idtipog=" . $_GET['idtipog'];
        } if (isset($_GET['pagina'])) {
            echo "&pagina=\"" . $_GET['pagina'];
        }
        ?>">
                Ir a las galer&iacute;as</a>
        </p>
        <div style="clear:both"></div>
        <div style="min-height:30px;"></div>

        <?php
    }
} else {
    if ($_GET['modulo'] == 'detallegaleria') {
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
            <h1 class="pull-left" style="font-size:36px;">Galer&iacute;as de im&aacute;genes</h1>
        </div>
        <?php
    }
    if ($_pick) {
        if ($_GET['idtipog'] > 0) {
            $_tipogaleria = strtolower($_myInfo->obtenerTiposGalerias($_activo));
            if ($_tipoinformacion == 'error') {
                echo "<h3 class=\"simple\">Lo sentimos, no encontramos galer&iacute;as del tipo que ha solicitado; le pedimos el favor de verificar su solicitud.</h3>";
                echo "<h3 class=\"simple\">Si lo desea, puede seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
            } else {
                echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos galer&iacute;as de " . utf8_encode($_tipogaleria) . " para mostrar; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a> o elegir otro <a href=\"javascript:TogglePopUp(event, 'galerias');\">tipo de informaci&oacute;n</a>.</h3>";
            }
        } else {
            echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos galer&iacute;as para mostrar en nuestro sitio web; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
        }
    } else {
        echo "<h3 class=\"simple\">Lo sentimos, un error en nuestra base de datos impide que le mostremos la galer&iacute;a que usted solicit&oacute;.</h3>";
        echo "<h3 class=\"simple\">Le invitamos a seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
    }
}
?>

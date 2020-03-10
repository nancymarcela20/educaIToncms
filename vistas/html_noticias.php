<?php
echo "<!--Entra a html_noticias-->";
$_traemodales = "";
if ($_param != "outer") {
    $_activo = 0;
    $_pick = 1;
    $_desde = 0;
    if (isset($_GET['modulo'])) {
        if ($_GET['modulo'] == 'verinformacion') {
            $_pick = 0;
        }
    }
    if (isset($_GET['idtipoi'])) {
        if ($_GET['idtipoi'] != 0) {
            $_activo = $_GET['idtipoi'];
        }
    }
    if (isset($_GET['desde'])) {
        if ($_GET['desde']) {
            $_desde = $_GET['desde'];
        }
    }
    if ($_param == 'wide') {
        $_nnoticias = 4;
    } else {
        $_nnoticias = 10;
    }
    echo "<!--Antes de acceder a la base de datos-->";
    $_myInfo = new Informaciones($_activo);
    if ($_pick) {
        $_enlaces = $_myInfo->obtenerInformaciones($_desde, 0, $_nnoticias);
    } else {
        $_enlaces = $_myInfo->obtenerInformaciones($_GET['idinfo'], 1);
    }
} else {
    $_pick = 0;
}
echo "<!--Despues de acceder a la base de datos-->";
if ($_param == 'wide') {
    ?>
    <div style="clear:both;"></div>
    <div style="background-color: #e8e8e8; ">
        <div class="container content-prin profile">
            <div class="row margin-top-10">
                <div class="headline-center-v2 headline-center-v2-dark margin-bottom-10">
                    <h1 class="shop-h1" style="font-size: 30px;"><b>Novedades</b></h1>
                    <span class="bordered-icon"><i class="fa fa-newspaper-o" aria-hidden="true"></i></span>
                </div>
                <div class="col-md-12">
                    <div class="row equal-height-columns margin-bottom-10">
                        <div class="container">
                            <ul class="row block-grid-v2">
                                <?php
                                for ($_a = 0; $_a < 4; $_a++) {
                                    ?>
                                    <li class="col-md-3 col-sm-6 md-margin-bottom-30" style="padding-left: 14px;">
                                        <div class="easy-block-v1">
                                            <img onclick="openModalImage('modal<?php echo $_enlaces[$_a][0]; ?>')" src="<?php echo $_enlaces[$_a][7]; ?>" alt="" style="cursor:zoom-in;">
                                            <?php
                                            $_traemodales .= "<div id=\"modal" . $_enlaces[$_a][0] . "\" class=\"ufps-image-modal\">\n<span class=\"ufps-image-modal-close\">&times;</span>\n<img class=\"ufps-image-modal-content\" src=\"" . $_enlaces[$_a][4] . "\" alt=\"\">\n<div class=\"ufps-image-modal-caption\">" . utf8_encode($_enlaces[$_a][3]) . "</div>\n</div>";
                                            ?>
                                            <div class="easy-block-v1-badge rgba-red">
                                                <?php echo Date("j", strtotime($_enlaces[$_a][1])) . " de " . cmes(Date("m", strtotime($_enlaces[$_a][1])), 1) . " de " . Date("Y", strtotime($_enlaces[$_a][1])); ?>
                                            </div>
                                        </div>
                                        <div class="block-grid-v2-info rounded-bottom  bloques_eventos">
                                            <h5>
                                                <b><a href="index.php?modulo=verinformacion&idinfo=<?php echo $_enlaces[$_a][0]; ?>"><?php echo utf8_encode($_enlaces[$_a][3]); ?></a></b>
                                            </h5>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <a href="./index.php?modulo=principal" class="btn-u btn-u-sm pull-right tooltips" data-toggle="tooltip" data-placement="left" data-original-title="Ver m&aacute;s eventos">Ver más <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN EVENTOS -->
    <?php
} else {
    if ($_pick) {
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
            <h1 class="pull-left" style="font-size:36px;">Novedades</h1>
            <div class="gdl-custom-sidebar-title-m"><div class="ufps-tooltip" style="margin-top:30px; float:right; position:absolute; right:5px; top:0px;"><span style="float:right;"><img src="rsc/img/tune.png" style="cursor:pointer;" id="tuneBtn" onClick="TogglePopUp(event, 'eventos')"></span><span class="ufps-tooltip-content-left" style="font-size:14px; font-weight:normal; margin-right:5px;">Ajustar filtro</span></div></div>
            <div style="clear:both;"></div>
            <div class="gdl-custom-sidebar" id="eventos" style="z-index:9;">
                <a onclick="filtreEvento(event, 'eventos', '0')" class="ufps-btn<?php if ($_activo == 0) {
            echo " ufps-btn-light-active";
        } else {
            echo " ufps-btn-light";
        } ?>">Todas</a>
                <?php
                $_myTipoObservaciones = new Informaciones(0);
                $_enlacespick = $_myTipoObservaciones->obtenerTiposInformaciones(0, 1);
                if ($_enlacespick[0] != "error") {
                    for ($_a = 0; $_a < count($_enlacespick); $_a++) {
                        echo "              <a onclick=\"filtreEvento(event, 'eventos', '" . $_enlacespick[$_a][0] . "')\" class=\"ufps-btn";
                        if ($_activo == $_enlacespick[$_a][0]) {
                            echo " ufps-btn-light-active";
                        } else {
                            echo " ufps-btn-light";
                        }
                        echo "\">" . utf8_encode($_enlacespick[$_a][1]) . "</a>\n";
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
    if ($_enlaces[0] != "error") {
        if ($_pick) {
            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                $_silink = 0;
                if ($_enlaces[$_a][6]) {
                    $_silink = 1;
                }
                $_traemodales .= "<div id=\"modal" . $_enlaces[$_a][0] . "\" class=\"ufps-image-modal\">\n<span class=\"ufps-image-modal-close\">&times;</span>\n<img class=\"ufps-image-modal-content\" src=\"" . $_enlaces[$_a][4] . "\">\n<div class=\"ufps-image-modal-caption\">" . utf8_encode($_enlaces[$_a][3]) . "</div>\n</div>";
                ?>
                <div class="items-row cols-<?php echo $_enlaces[$_a][0]; ?> row-0">
                    <div class="item-information column-1">
                        <?php if ($_enlaces[$_a][4]) { ?>
                            <div class="img-intro-right">
                                <img onclick="openModalImage('modal<?php echo $_enlaces[$_a][0]; ?>')" src="<?php echo $_enlaces[$_a][4]; ?>" alt="" class="imgInformacion">
                            </div>
                                <?php } ?>
                        <div class="float_content">
                            <h1 class="tituloinformacion">
                            <?php if ($_silink) {
                                echo "<a class=\"anchorinformacion\" href=\"./index.php?modulo=verinformacion&idtipoi=" . $_activo . "&idinfo=" . $_enlaces[$_a][0] . "\">";
                            } ?>
                        <?php echo utf8_encode($_enlaces[$_a][3]); ?><?php if ($_silink) {
                    echo "</a>";
                } ?>
                            </h1>
                <?php echo utf8_encode($_enlaces[$_a][5]); ?>
                        </div>
                <?php
                if ($_enlaces[$_a][6]) {
                    ?>
                            <div style="clear:both"></div>
                            <p class="readmore">
                                <a href="<?php if ($_silink) {
                        echo "./index.php?modulo=verinformacion&idtipoi=" . $_activo . "&idinfo=" . $_enlaces[$_a][0];
                    } else {
                        echo "javascript:;";
                    } ?>">
                                    Leer más...</a>
                            </p>
                            <div style="clear:both"></div>
                    <?php
                }
                ?>
                    <?php if ($_a < (count($_enlaces) - 1)) {
                        echo "<span class=\"row-separator\"></span>";
                    } ?>
                    </div>
                </div>
                <?php
            }
        } else {
            if ($_param != "outer") {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
                    <h1 class="pull-left" style="font-size:36px;">Novedades</h1>
                </div>
                <h1 class="tituloinformacion">
                <?php echo utf8_encode($_enlaces[0][3]); ?>
                </h1>
                <?php if ($_enlaces[0][4]) { ?>
                    <div class="img-intro-right90 img-intro-right">
                        <img src="<?php echo $_enlaces[0][4]; ?>" class="imgInformacion" alt=""/>
                    </div>
                <?php } ?>
                <?php echo utf8_encode($_enlaces[0][5]); ?>
                <?php echo utf8_encode($_enlaces[0][6]); ?>
                <div style="clear:both"></div>
                <p class="readmore-center readmore">
                    <a href="./index.php?modulo=principal<?php /**/ if (isset($_GET['idtipoi'])) {
                    echo "&idtipoi=" . $_GET['idtipoi'];
                } if (isset($_GET['pagina'])) {
                    echo "&pagina=\"" . $_GET['pagina'];
                } ?>">
                        Ir a las informaciones</a>
                </p>
                <div style="clear:both"></div>
                <?php
            } else {
                echo utf8_encode($_enlaces[0][6]);
            }
            ?>
            <div style="clear:both; min-height:30px;"></div>

            <?php
        }
    } else {
        if ($_GET['modulo'] == 'verinformacion') {
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
                <h1 class="pull-left" style="font-size:36px;">Novedades</h1>
            </div>
            <?php
        }
        if ($_pick) {
            if ($_GET['idtipoi'] > 0) {
                $_tipoinformacion = strtolower($_myInfo->obtenerTiposInformaciones($_activo));
                if ($_tipoinformacion == 'error') {
                    echo "<h3 class=\"simple\">Lo sentimos, no encontramos el tipo de informaci&oacute;n que ha solicitado; le pedimos el favor de verificar su solicitud.</h3>";
                    echo "<h3 class=\"simple\">Si lo desea, puede seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
                } else {
                    echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos " . utf8_encode($_tipoinformacion) . " para mostrar; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a> o elegir otro <a href=\"javascript:TogglePopUp(event, 'eventos');\">tipo de informaci&oacute;n</a>.</h3>";
                }
            } else {
                echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos informaciones para mostrar en nuestro sitio web; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
            }
        } else {
            echo "<h3 class=\"simple\">Lo sentimos, un error en nuestra base de datos impide que le mostremos la informaci&oacute;n que usted solicit&oacute;.</h3>";
            echo "<h3 class=\"simple\">Le invitamos a seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
        }
    }
}
?>

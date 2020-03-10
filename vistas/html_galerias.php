<?php
$_activo = 0;
$_pick = 1;
$_desde = 0;
if (isset($_GET['modulo'])) {
    if ($_GET['modulo'] == 'vergalerias') {
        $_pick = 0;
    }
}
if (isset($_GET['idtipog'])) {
    if ($_GET['idtipog'] != 0) {
        $_activo = $_GET['idtipog'];
    }
}
if (isset($_GET['desde'])) {
    if ($_GET['desde']) {
        $_desde = $_GET['desde'];
    }
}
$_myInfo = new Galerias($_activo);
if ($_pick) {
    $_enlaces = $_myInfo->obtenerGalerias($_desde, 0, 6);
} else {
    $_enlaces = $_myInfo->obtenerGalerias($_GET['idgale'], 1);
}
if ($_param == 'wide') {
    if ($_enlaces[0] != "error") {
        ?>
        <div style="clear:both;"></div>
        <div style="background-color: #d4d4d4;">
            <div class="container content-prin profile">
                <div class="row margin-top-10">
                    <div class="headline-center-v2 headline-center-v2-dark margin-bottom-10">
                        <h1 class="shop-h1" style="font-size: 30px; color:#444;"><b>Galer&iacute;as</b></h1>
                        <span class="bordered-icon" style="color:#444;"><i class="fa fa-newspaper-o" aria-hidden="true"></i></span>
                    </div>
                    <div class="col-md-12">
                        <div class="row equal-height-columns margin-bottom-10">
                            <div class="container">
                                <ul class="row block-grid-v2">
                                    <?php
                                    if (count($_enlaces) < 6) {
                                        $_limite = count($_enlaces);
                                    } else {
                                        $_limite = 6;
                                    }
                                    for ($_a = $_desde; $_a < $_limite; $_a++) {
                                        ?>
                                        <li class="col-md-2 col-sm-3 col-xs-6 md-margin-bottom-30" style="padding-left: 14px;">
                                            <div class="easy-block-v1">
                                                <a href="./index.php?modulo=detallegaleria&idgale=<?php echo $_enlaces[$_a][0]; ?>">
                                                    <img src="<?php echo $_enlaces[$_a][2]; ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="block-grid-v2-info rounded-bottom  bloques_eventos">
                                                <h5>
                                                    <b><a href="index.php?modulo=detallegaleria&idgale=<?php echo $_enlaces[$_a][0]; ?>"><?php echo utf8_encode($_enlaces[$_a][3]); ?></a></b>
                                                </h5>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <a href="./index.php?modulo=galerias" class="btn-u btn-u-sm pull-right tooltips" data-toggle="tooltip" data-placement="left" data-original-title="Ver m&aacute;s galer&iacute;as">Ver más <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN EVENTOS -->
        <?php
    }
} else {
    if ($_enlaces[0] != "error") {
        ?>
        <div class="gdl-custom-sidebar gdl-custom-sidebar-nofirst">
            <h3 class="gdl-custom-sidebar-title-m">Galer&iacute;as</h3>
            <?php
            if (count($_enlaces) < 6) {
                $_limite = count($_enlaces);
            } else {
                $_limite = 6;
            }
            for ($_a = $_desde; $_a < $_limite; $_a++) {
                ?>
                <div class="col-md-6 col-sm-6 col-xs-6 col-md-margin-bottom-30" style="padding-left: 14px; margin-bottom: 14px;">
                    <div class="easy-block-v1">
                        <a href="./index.php?modulo=detallegaleria&idgale=<?php echo $_enlaces[$_a][0]; ?>">
                            <img src="<?php echo $_enlaces[$_a][2]; ?>" alt="">
                        </a>
                        <div class="easy-block-v1-badge rgba-black" style="z-index:0; width:100%; top: 0px; color:#fff; font-size:0.9em;">
                            <?php echo utf8_encode($_enlaces[$_a][3]); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div style="clear:both;"></div>
        <?php
    }
}
?>

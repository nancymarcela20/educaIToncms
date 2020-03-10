<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->
    <?php include ("html_header.php"); ?>
    <body class="header-fixed boxed-layout" style="position: relative; min-height: 100%; top: 0px;">
        <!--Contenido-->
        <div class="wrapper">
            <div id="menu-principal" class="header-v6 header-white-transparent header-sticky" style="position: relative;">
                <?php include ("html_navbar.php"); ?>
                <?php include ("html_bannerTop.php"); ?>
                <?php include ("html_menu.php"); ?>
            </div><!--header-v6-->
            <?php
            if (!isset($_GET['modulo'])) {
                $_GET['modulo'] = "";
            }
            switch ($_GET['modulo']) {
                case 'buscar': {
                        ?>
                        <div class="container content profile" style="position: relative;">
                            <div class="row margin-bottom-30">
                                <div id="informacionContent" class="col-md-8 mb-margin-bottom-30 shadow-wrapper">
                                    <?php
                                    include ("html_buscar.php");
                                    ?>
                                </div><!--informacionContent-->
                                <div class="col-md-4">
                                    <?php
                                    include ("html_informacionesPick.php");
                                    $_parametroP = "right";
                                    include ("html_proximas.php");
                                    $_param = "";
                                    include ("html_galerias.php");
                                    include ("html_listacorreo.php");
                                    include ("html_pad.php");
                                    ?>
                                </div><!--col-md-4-->
                            </div><!-- row margin-bottom-30-->
                        </div><!--container content profile-->
                        <?php
                        break;
                    }
                case 'calendarios': {
                        ?>
                        <div class="container content profile" style="position: relative;">
                            <div class="row margin-bottom-30">
                                <div id="informacionContent" class="col-md-8 mb-margin-bottom-30 shadow-wrapper">
                                    <?php
                                    include ("html_calendario.php");
                                    ?>
                                </div><!--informacionContent-->
                                <div class="col-md-4">
                                    <?php
                                    include ("html_informacionesPick.php");
                                    $_param = "";
                                    include ("html_galerias.php");
                                    include ("html_listacorreo.php");
                                    include ("html_pad.php");
                                    ?>
                                </div><!--col-md-4-->
                            </div><!-- row margin-bottom-30-->
                        </div><!--container content profile-->
                        <?php
                        break;
                    }
                case 'galerias':
                case 'detallegaleria': {
                        ?>
                        <div class="container content profile">
                            <div class="row margin-bottom-30">
                                <div id="informacionContent" class="col-md-8 mb-margin-bottom-30 shadow-wrapper">
                                    <?php
                                    include ("html_enlagaleria.php");
                                    ?>
                                </div><!--informacionContent-->
                                <div class="col-md-4">
                                    <?php
                                    include ("html_informacionesPick.php");
                                    $_parametroP = "right";
                                    include ("html_proximas.php");
                                    if ($_GET['modulo'] != 'galerias') {
                                        $_param = "";
                                        include ("html_galerias.php");
                                    }
                                    include ("html_listacorreo.php");
                                    include ("html_pad.php");
                                    ?>
                                </div><!--col-md-4-->
                            </div><!-- row margin-bottom-30-->
                        </div><!--container content profile-->
                        <?php
                        if (isset($_traemodales)) {
                            if ($_traemodales) {
                                echo $_traemodales;
                            }
                        }
                        break;
                    }
                case 'principal':
                case 'verinformacion': {
                        ?>
                        <div class="container content profile">
                            <div class="row margin-bottom-30">
                                <div id="informacionContent" class="col-md-8 mb-margin-bottom-30 shadow-wrapper">
                                    <?php
                                    $_param = "";
                                    include ("html_noticias.php");
                                    ?>
                                </div><!--informacionContent-->
                                <div class="col-md-4">
                                    <?php
                                    if ($_GET['modulo'] != 'principal') {
                                        include ("html_informacionesPick.php");
                                        $_nofirst = 1;
                                    } else {
                                        $_nofirst = 0;
                                    }
                                    $_parametroP = "right";
                                    include ("html_proximas.php");
                                    $_param = "";
                                    include ("html_galerias.php");
                                    include ("html_listacorreo.php");
                                    include ("html_pad.php");
                                    ?>
                                </div><!--col-md-4-->
                            </div><!-- row margin-bottom-30-->
                        </div><!--container content profile-->
                        <?php
                        if (isset($_traemodales)) {
                            if ($_traemodales) {
                                echo $_traemodales;
                            }
                        }
                        break;
                    }
                default: {
                        $_mid = 0;
                        if (isset($_GET['id'])) {
                            if ($_GET['id']) {
                                $_mid = $_GET['id'];
                            }
                        }
                        $_pid = 0;
                        if (isset($_GET['pid'])) {
                            if ($_GET['pid']) {
                                $_pid = $_GET['pid'];
                            }
                        }
                        if ($_mid > 0) {
                            $_myinformaciones = new Informaciones(0);
                            $_enlaces = $_myinformaciones->obtenerInformaciones($_mid, 1);
                            if ($_enlaces[0] == 'error') {
                                $_mid = 0;
                            }
                        }
                        if ($_pid > 0) {
                            $_mymenu = new Menus;
                            $_enlaces = $_mymenu->obtenerCamposXaEdicion($_pid);
                            if (is_file("vistas/" . substr($_enlaces[3], 3))) {
                                $_fileinclude = substr($_enlaces[3], 3);
                            } else {
                                $_pid = 0;
                            }
                        }
                        if ($_mid > 0) {
                            ?>
                            <div class="container content profile">
                                <div class="row margin-bottom-30">
                                    <?php echo showBreadCrumb($_myinformaciones->breadCrumb($_mid)); ?>
                                    <div id="informacionContent" class="col-md-<?php echo $_enlaces[0][8]; ?> mb-margin-bottom-30 shadow-wrapper">
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
                                            <h1 class="pull-left" style="font-size:36px;"><?php echo utf8_encode($_enlaces[0][3]); ?></h1>
                                        </div>
                                        <?php
                                        $_param = "outer";
                                        include ("html_noticias.php");
                                        ?>
                                    </div><!--informacionContent-->
                                    <?php
                                    $_resto = 12 - $_enlaces[0][8];
                                    if ($_resto > 0) {
                                        ?>
                                        <div class="col-md-<?php echo $_resto; ?>">
                                            <?php
                                            include ("html_informacionesPick.php");
                                            $_nofirst = 1;
                                            $_parametroP = "right";
                                            include ("html_proximas.php");
                                            $_param = "";
                                            include ("html_galerias.php");
                                            include ("html_listacorreo.php");
                                            include ("html_pad.php");
                                            ?>
                                        </div><!--col-md-4-->
                                        <?php
                                    }
                                    ?>
                                </div><!-- row margin-bottom-30-->
                            </div><!--container content profile-->
                            <?php
                        } else {
                            if ($_pid > 0) {
                                ?>
                                <div class="container content profile">
                                    <div class="row margin-bottom-30">
                                        <?php $_myinformaciones = new Informaciones(0);
                                        echo showBreadCrumb($_myinformaciones->breadCrumb($_enlaces[3])); ?>
                                        <div id="informacionContent" class="col-md-8 mb-margin-bottom-30 shadow-wrapper">
                                            <?php
                                            $_param = "";
                                            include ($_fileinclude);
                                            ?>
                                        </div><!--informacionContent-->
                                        <div class="col-md-4">
                                            <?php
                                            include ("html_informacionesPick.php");
                                            $_nofirst = 1;
                                            $_parametroP = "right";
                                            include ("html_proximas.php");
                                            $_param = "";
                                            include ("html_galerias.php");
                                            include ("html_listacorreo.php");
                                            include ("html_pad.php");
                                            ?>
                                        </div><!--col-md-4-->
                                    </div><!-- row margin-bottom-30-->
                                </div><!--container content profile-->
                                <?php
                            } else {
                                include ("html_slider.php");
                                /*                                                           include ("html_normativas.php"); */
                                $_param = "wide";
                                include ("html_noticias.php");
                                $_param = "wide";
                                include ("html_actividades.php");
                                $_param = "wide";
                                include ("html_galerias.php");
                                include ("html_socialmedia.php");
                            }
                            if (isset($_traemodales)) {
                                if ($_traemodales) {
                                    echo $_traemodales;
                                }
                            }
                        }
                        break;
                    }
            }
            ?>
        </div><!--wrapper-->
        <?php include ("html_footer.php"); ?>
        <?php include ("html_finallinks.php"); ?>
<?php include ("html_finalScripts.php"); ?>
    </body>
</html>


<?php ?>
<div id="barra-superior" class="header-v8">
    <!-- Topbar blog -->
    <div class="blog-topbar">
        <div class="topbar-search-block">
            <div class="container">
                <form name="buscar" method="get" action="index.php">
                    <input type="hidden" name="modulo" value="buscar">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar...">
                    <div class="search-close"><i class="icon-close"></i></div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-xs-7">
                    <div class="topbar-toggler" style="font-size: 10px; color: #eee; letter-spacing: 1px; text-transform: uppercase;"><span class="fa fa-angle-down"></span> PERFILES</div>
                    <ul class="topbar-list topbar-menu">
                        <?php
                        $_myPerfiles = new Perfiles();
                        $_enlaces = $_myPerfiles->obtenerPerfiles();
                        if ($_enlaces[0] != 'error') {
                            ?>
                            <?php
                            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                                echo "                     <li><a href=\"" . $_enlaces[$_a][3] . "\"";
                                if ($_enlaces[$_a][4] == 1) {
                                    echo " target=\"_blank\"";
                                }
                                echo "><i class=\"fa " . $_enlaces[$_a][2] . "\"></i>" . utf8_encode($_enlaces[$_a][1]) . "</a></li>\n";
                            }
                            ?>
                            <?php
                        }
                        ?>
                        <li class="cd-log_reg hidden-sm hidden-md hidden-lg"><strong><a class="cd-signup" href="javascript:void(0);">Lenguaje</a></strong>
                            <ul class="topbar-dropdown">
                                <li><a href="#">Inglés</a></li>
                                <li><a href="#">Español</a></li>
                            </ul></li>

                    </ul>
                </div>
                <div class="col-sm-5 col-xs-5 clearfix">
                    <i class="fa fa-search search-btn pull-right"></i>
                    <ul class="topbar-list topbar-log_reg pull-right visible-sm-block visible-md-block visible-lg-block">
                        <li class="cd-log_reg home" style="padding: 0px 12px;">
                            <div id="google_translate_element"></div><script type="text/javascript">
                          function googleTranslateElementInit() {
                              new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'en,fr,it', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
                          }
                            </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                        </li>

                    </ul>
                </div>
            </div><!--/end row-->
        </div><!--/end container-->
    </div>
    <!-- End Topbar blog -->
</div>
<?php
?>

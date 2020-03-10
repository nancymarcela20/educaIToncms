<?php ?>
<div class="menu-responsive">
    <!-- Logo -->
    <a class="logo logo-responsive" href="index.php" style="margin-left:5px;">
        <img src="rsc/img/Logo_educaiton.png" alt="Logo">
    </a>
    <!-- End Logo -->
    <!-- Toggle get grouped for better mobile display -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="sr-only">Cambiar navegaci&oacute;n</span>
        <span class="fa fa-bars"></span>
    </button>
    <!-- End Toggle -->
</div>
<!-- Navbar -->
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
    <div class="containermenu">
        <?php
        $_mymenu = new Menus();
        $_enlaces = $_mymenu->obtenerMenu();
        if ($_enlaces[0] != "error") {
            echo "<ul class=\"nav navbar-nav\" style=\"float:left;\">\n";
            echo sniffnivel($_enlaces, 0, 0, 0);
            echo "</ul>\n";
        }

        function sniffnivel($_enlaces, $nivel, $empezando, $rompa) {
            $_cadena = "";
            for ($_a = $empezando; $_a < count($_enlaces); $_a++) {
                if ($_enlaces[$_a][1] == 0 && $nivel == 0) {
                    if ($_enlaces[$_a][5] == 1) {
                        $_cadena .= "<li class=\"dropdown\">\n";
                        $_cadena .= "  <a href=\"javascript:;\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . utf8_encode($_enlaces[$_a][2]) . "</a>\n";
                        $_cadena .= "  <ul class=\"dropdown-menu\">\n";
                        $_cadena .= sniffnivel($_enlaces, $nivel + 1, $_a + 1, 1);
                        $_cadena .= "  </ul>\n";
                        $_cadena .= "</li>\n";
                    } else {
                        $_cadena .= "<li class=\"nodropdown\">\n";
                        $_cadena .= "  <a href=\"" . EnvelopeLink($_enlaces[$_a][3], $_enlaces[$_a][0]) . "\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\"";
                        if ($_enlaces[$_a][4] == 1) {
                            $_cadena .= " target=\"_blank\"";
                        }
                        $_cadena .= ">" . utf8_encode($_enlaces[$_a][2]) . "</a>";
                        $_cadena .= "</li>\n";
                    }
                } else {
                    if ($_enlaces[$_a][1] == $nivel) {
                        if ($_enlaces[$_a][5] == 1) {
                            $_cadena .= "<li class=\"dropdown-submenu\">\n";
                            $_cadena .= "  <a href=\"javascript:;\">" . utf8_encode($_enlaces[$_a][2]) . "</a>\n";
                            $_cadena .= "  <ul class=\"dropdown-menu";
                            if ($_enlaces[$_a][6] == 1) {
                                $_cadena .= " submenu-left";
                            }
                            $_cadena .= "\">\n";
                            $_cadena .= sniffnivel($_enlaces, $nivel + 1, $_a + 1, 1);
                            $_cadena .= "  </ul>\n";
                            $_cadena .= "</li>\n";
                        } else {
                            $_cadena .= "<li><a href=\"" . EnvelopeLink($_enlaces[$_a][3], $_enlaces[$_a][0]) . "\"";
                            if ($_enlaces[$_a][4] == 1) {
                                $_cadena .= " target=\"_blank\"";
                            }
                            $_cadena .= ">" . utf8_encode($_enlaces[$_a][2]) . "</a>";
                            $_cadena .= "</li>\n";
                        }
                    } else {
                        if ($_enlaces[$_a][1] < $nivel) {
                            if ($rompa == 1) {
                                $_a = count($_enlaces) + 1;
                            }
                        }
                    }
                }
            }
            return $_cadena;
        }
        ?>
    </div>
</div><!--/navbar-collapse-->

<?php ?>
<?php

$_myRedes = new RedesSociales();
$_enlaces = $_myRedes->obtenerRedes();
if ($_enlaces[0] != 'error') {
    echo "      <!-- ICONOS REDES SOCIALES -->\n";
    echo "      <div id=\"idcuadroredes\" class=\"cuadroredes\" style=\"height: " . (count($_enlaces) * 40 + 30) . "px\">\n";
    echo "        <div style=\"text-align:center; vertical-align:middle; font-size:1.25em; cursor:pointer; margin: 4px; padding: 0px; border-bottom: 1px dotted #666;\" onclick=\"document.getElementById('idcuadroredes').style.display='none';\"><i class=\"icon-close\"></i></div>\n";
    echo "        <ul class=\"social-icons social-icons-color margin-top-10\">";
    for ($_a = 0; $_a < count($_enlaces); $_a++) {
        echo "              <li class=\"tooltips\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"" . utf8_encode($_enlaces[$_a][2]) . "\"><a href=\"" . $_enlaces[$_a][3] . "\"";
        if ($_enlaces[$_a][3] == 1) {
            echo " target=\"_blank\"";
        }
        echo " class=\"" . $_enlaces[$_a][1] . "\"></a>\n";
        echo "              </li>\n";
    }
    echo "        </ul>\n";
    echo "      </div>\n";
    echo "      <!-- FIN ICONOS REDES SOCIALES -->\n";
}
?>
<?php ?>

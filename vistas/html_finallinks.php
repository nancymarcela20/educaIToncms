<?php ?>
<?php

$_myFinalL = new Enlaces(3);
$_enlaces = $_myFinalL->obtenerEnlaces();
if ($_enlaces[0] != 'error') {
    echo "  <div class=\"owl-clients-v1\" style=\"background-color:#EEE; padding: 5px;\">\n";
    for ($_a = 0; $_a < count($_enlaces); $_a++) {
        echo "    <div class=\"item\">\n";
        echo "      <a href=\"" . $_enlaces[$_a][0] . "\"";
        if ($_enlaces[$_a][2] == 1) {
            echo " target=\"_blank\"";
        }
        echo "><img src=\"" . $_enlaces[$_a][1] . "\" class=\"hover-shadow\" alt=\"\"></a>\n";
        echo "    </div>\n";
    }
    echo "  </div>\n";
}
?>
<?php ?>

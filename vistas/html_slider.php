<?php

$_myslides = new Slides();
$_enlaces = $_myslides->obtenerSlides();
if ($_enlaces[0] != "error") {
    echo "      <ul class=\"pgwSlider\">\n";
    for ($_a = 0; $_a < count($_enlaces); $_a++) {
        echo "        <li>";
        if ($_enlaces[$_a][3]) {
            echo "<a href=\"" . EnvelopeLink($_enlaces[$_a][3]) . "\"";
            if ($_enlaces[$_a][4]) {
                echo " target=\"_blank\"";
            }
            echo ">";
        }
        echo "<img src=\"" . $_enlaces[$_a][2] . "\" alt=\"\">\n";
        echo "<span style=\"font-family: inherit; font-size:1.0em; font-weight:bold; color:#111; cursor:auto;\">" . utf8_encode($_enlaces[$_a][1]) . "</span>";
        if ($_enlaces[$_a][3]) {
            echo "</a>\n";
        }
        echo "</li>\n";
    }
    echo "      </ul>\n";
}
?>

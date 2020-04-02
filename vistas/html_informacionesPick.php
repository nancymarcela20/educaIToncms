<?php ?>
<div class="gdl-custom-sidebar">
    <h3 class="gdl-custom-sidebar-title-m">Novedades</h3>
</div>
<div class="gdl-custom-sidebar">
    <?php
    $_myTipoObservaciones = new Informaciones(0);
    $_enlaces = $_myTipoObservaciones = $_myTipoObservaciones->obtenerTiposInformaciones(0, 1);
    if ($_enlaces[0] != "error") {
        for ($_a = 0; $_a < count($_enlaces); $_a++) {
            echo "              <a href=\"./index.php?modulo=principal&idtipoi=" . $_enlaces[$_a][0] . "\"><button class=\"ufps-btn-accordionlike\">" . $_enlaces[$_a][1] . "</button></a>\n";
        }
        echo "              <a href=\"./index.php?modulo=infoveroferta\"><button class=\"ufps-btn-accordionlike\">" . "Ofertas Laborales" . "</button></a>\n";
    }
    ?>
</div>
<?php
?>

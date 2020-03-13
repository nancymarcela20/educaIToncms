<?php
$_desde = 0;
if (isset($_GET['desde'])) {
    if ($_GET['desde']) {
        $_desde = $_GET['desde'];
    }
}
$_myactividades = new Actividades(0);
if ($_param == 'wide') {
    ?>
    <div style="background-color: #b43432; padding-bottom:10px;">
        <div class="container content-prin profile">
            <div class="row margin-bottom-10 margin-top-10">
                <div class="headline-center-v2 margin-bottom-10">
                    <h1 style="font-size: 30px; color:#fff;"><b>Próximas actividades</b></h1>
                    <span class="bordered-icon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                </div>
                <?php
                $_enlaces = $_myactividades->obtenerProximas($_desde, 4);
                if ($_enlaces[0] != "error") {
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    ?>
                    <div class="col-sm-3">
                        <div class="service-block-v1 md-margin-bottom-50" style="background: #fff; border-top: 5px solid #f1c40f;">
                            <i class="icon-custom icon-lg rounded-x icon-color-yellow icon-line fa fa-bookmark" style="background: #fff;"></i>
                            <h5 class="title-v3-bg text-uppercase">
                                <?php
                                if ($_enlaces[$_a][6]) {
                                    echo "<a href=\"" . $_enlaces[$_a][6] . "\"";
                                    if ($_enlaces[$_a][7] == 1) {
                                        echo " _target=\"_blank\"";
                                    }
                                    echo " style=\"text-transform:none; color:#464646;\">";
                                }
                                echo "<b>" . utf8_encode($_enlaces[$_a][5]) . "</b>";
                                if ($_enlaces[$_a][6]) {
                                    echo "</a>";
                                }
                                echo "</h5>\n";
                                echo "<p>" . utf8_encode(textoDesarrollo($_enlaces[$_a][1], $_enlaces[$_a][2])) . "</p>\n";
                                if ($_enlaces[$_a][6]) {
                                    echo "<a href=\"" . $_enlaces[$_a][6] . "\"";
                                    if ($_enlaces[$_a][7] == 1) {
                                        echo " _target=\"_blank\"";
                                    }
                                    echo "<b>Leer más</b></a>\n";
                                }
                                ?>
                        </div>
                    </div>
                    <?php
                }
                }else{
                    echo '<h1 style="font-size: 20px; color:#fff;"><b>Lo sentimos, no hay actividades próximas a mostrar.</b></h1>';
                }
                ?>
            </div><!--/row-->
            <a href="./index.php?modulo=calendarios" class="btn-u btn-u-sm pull-right tooltips" data-toggle="tooltip" data-placement="left" data-original-title="Ingresar a Calendario de Eventos">Ver más <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <!-- FIN DESTACADOS -->
    <?php
} else {
    
}
?>

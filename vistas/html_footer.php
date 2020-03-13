<?php
$_myvisitantes = new Visitantes();
$_myvisitantes->grabarVisitante();
$_myvisitantes->obtenerVisitantes();
?>
<div class="footer-v1 off-container">
    <div class="footer">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-3 col-sm-4 md-margin-bottom-40">
                    <div class="footer-main">
                        <a href="./"><img id="logo-footer" class="img-responsive" src="rsc/img/Logo_educaiton.png" alt="Logo Pie de Página"></a>
                    </div>
                </div><!--/col-md-3-->
                <!-- End About -->
                <!-- Latest -->
                <div class="col-md-3 col-sm-4 md-margin-bottom-40">
                    <div class="posts">
                        <div class="headline" style="border-bottom: #272727;"><h2>Visitantes</h2></div>
                        <ul class="list-unstyled latest-list">
                            <li style="color:#fff">
                                Hoy: <?php echo number_format($_myvisitantes->hoy, 0, ',', '.'); ?>
                            </li>
                            <li style="color:#fff">
                                &Uacute;ltimo mes: <?php echo number_format($_myvisitantes->mes, 0, ',', '.'); ?>
                            </li>
                            <li style="color:#fff">
                                Desde el principio: <?php echo number_format($_myvisitantes->genesis, 0, ',', '.'); ?>
                            </li>
                        </ul>
                    </div>
                </div><!--/col-md-3-->
                <!-- End Latest -->
                <!-- Link List -->
                <div class="col-md-3 col-sm-4  md-margin-bottom-40">
                    <div class="headline" style="border-bottom: #272727;"><h2>Enlaces de Interés</h2></div>
                    <ul class="list-unstyled latest-list">
                        <?php
                        $_mylogosfooter = new Enlaces(1);
                        $_enlaces = $_mylogosfooter->obtenerEnlaces();
                        if ($_enlaces[0] != 'error') {
                            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                                echo "                ";
                                echo "<li>";
                                if ($_enlaces[$_a][0]) {
                                    echo "<a href=\"" . EnvelopeLink($_enlaces[$_a][0]) . "\"";
                                    if ($_enlaces[$_a][2] == 1) {
                                        echo " target=\"_blank\"";
                                    }
                                    echo ">";
                                }
                                echo utf8_encode($_enlaces[$_a][1]);
                                if ($_enlaces[$_a][0]) {
                                    echo "</a>";
                                }
                                echo "</li>";
                                echo "\n";
                            }
                        }
                        ?>
                    </ul>
                </div><!--/col-md-3-->
                <!-- End Link List -->
                <!-- Address -->
                <div class="col-md-3 col-sm-4  map-img md-margin-bottom-40">
                    <div class="headline" style="border-bottom: #272727;"><h2>Contactos</h2></div>
                    <address class="md-margin-bottom-40">
                        <?php
                        $_mytextoFooter = new textoFooter();
                        echo utf8_encode(str_replace("\r", "", str_replace("\n", "<br>", $_mytextoFooter->obtenerTexto())));
                        ?>
                    </address>
                </div><!--/col-md-3-->
                <!-- End Address -->
            </div>
        </div>
    </div><!--/footer-->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p> 2020 © All Rights Reserved. Desarrollado por:
                        <a href="mailto:uvirtual@ufps.edu.co">Equipo educaITon - UFPS</a>
                    </p>
                </div>
                <!-- Social Links -->
                <div class="col-md-4">
                    <ul class="list-inline dark-social pull-right space-bottom-0">
                        <?php
                        $_myRedes = new RedesSociales();
                        $_enlaces = $_myRedes->obtenerRedes();
                        if ($_enlaces[0] != 'error') {
                            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                                echo "                <li>\n";
                                echo "                  <a data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" data-original-title=\"" . $_enlaces[$_a][6] . "\" href=\"" . $_enlaces[$_a][3] . "\"";
                                if ($_enlaces[$_a][3] == 1) {
                                    echo " target=\"_blank\"";
                                }
                                echo ">";
                                echo "                  <i class=\"" . $_enlaces[$_a][5] . "\" style=\"color:#fff;\"></i>";
                                echo "                  </a>\n";
                                echo "                </li>\n";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- End Social Links -->
            </div>
            <div class="alert alert-warning"><b>Importante:</b> Este sitio web y todo su contenido corresponden a un proyecto en ejecución de Educación Virtual en proceso de Registro Calificado. Aunque se encuentre público su uso es restringido para los fines del proyecto. Si requiere informaci&oacute;n adicional, por favor cont&aacute;ctenos a  uvirtual@ufps.edu.co</div>
            
        </div>
    </div><!--/copyright-->
</div>

<?php
?>

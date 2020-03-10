<?php
$_solocontenido = 0;
if (isset($_GET['ajax'])) {
    if ($_GET['ajax'] == 'proximas') {
        $_solocontenido = 1;
    }
}
if (!isset($_nofirst)) {
    $_nofirst = 1;
}
$_myactividades = new Actividades(0);
if (isset($_GET['semana'])) {
    if ($_GET['semana']) {
        $_myweek = $_GET['semana'];
    } else {
        $_myweek = 0;
    }
} else {
    $_myweek = 0;
}
$_enlaces = $_myactividades->obtenerActividades($_myweek);
if ($_parametroP == 'top') {
    if (!$_solocontenido) {
        ?>
        <div id="proximasContent" class="ufps-row">
            <?php
        }
        ?>
        <div class="ufps-col-mobile-12">
            <div class="gdl-custom-sidebar">
                <?php
            } else {
                if (!$_solocontenido) {
                    ?>
                    <div id="proximasContent" class="gdl-custom-sidebar gdl-custom-sidebar<?php if ($_nofirst == 1) {
                echo "-nofirst";
            } ?>">
                        <?php
                    }
                }
                ?>
                <h3 class="gdl-custom-sidebar-title-m"><?php if (isset($_myactividades->etiqueta)) {
                    echo $_myactividades->etiqueta;
                } ?><div class="ufps-tooltip" style="float:right;"><span style="float:right;"><a href="./index.php?modulo=calendarios"><img src="rsc/img/calendar.png"></a></span><span class="ufps-tooltip-content-left" style="font-size:14px; font-weight:normal; margin-right:5px;">Ir al calendario</span></div></h3>
                <div id="browseweek" class="browseweek" style="background:#424242; min-height:25px; width:<?php if ($_parametroP == 'top') {
                    echo "95";
                } elseif ($_parametroP == 'right') {
                    echo "100";
                } ?>%; margin:auto; margin-bottom:0px;"><div class="ufps-tooltip"><div style="margin-left:2px; margin-right:2px; float:left; top:0px; left:0px; width:25px;"><img src="rsc/img/rewind.png" style="cursor:pointer;" onclick="WeekDirection(<?php if (isset($_GET['semana'])) {
                            if ($_GET['semana']) {
                                echo $_GET['semana'];
                            } else {
                                echo "0";
                            }
                        } else {
                            echo "0";
                        } ?>, -1, '<?php echo $_parametroP; ?>');"></div><span class="ufps-tooltip-content-right">Semana anterior</span></div><div class="ufps-tooltip" style="float:right;"><div style="margin-left:2px; margin-right:2px; float:right; top:0px; right:0px; width:25px;"><img src="rsc/img/forward.png" style="cursor:pointer;" onclick="WeekDirection(<?php if (isset($_GET['semana'])) {
                            if ($_GET['semana']) {
                                echo $_GET['semana'];
                            } else {
                                echo "0";
                            }
                        } else {
                            echo "0";
                        } ?>, +1, '<?php echo $_parametroP; ?>');"></div><span class="ufps-tooltip-content-left">Semana siguiente</span></div></div>
                        <?php
                        if ($_enlaces[0] != 'error') {
                            if ($_parametroP == 'top') {
                                ?>
                        <div class="ufps-tab-container" id="tabs" style="margin: auto; width:95%;">
                            <ul class="ufps-tabs" style="cursor: pointer;">
                                <li><a class="ufps-tab-links" onmouseover="closeTab(event, 'tabs')" onclick="closeTab(event, 'tabs')" onmouseout="TurnOff(event, 'tabs')" style="">&times;</a></li>
                                <?php
                            }
                            $_tabulos = -1;
                            if ($_parametroP == 'right') {
                                $_textofecha = array();
                            }
                            $_textotabulos = array();
                            $_controldia = "";
                            $_controlmes = "";
                            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                                if ($_enlaces[$_a][1] > Date("Y-m-d", $_myactividades->minimafecha)) {
                                    $_eldia = substr($_enlaces[$_a][1], -2);
                                    $_elmes = substr($_enlaces[$_a][1], 5, 2);
                                } else {
                                    $_eldia = Date("d", $_myactividades->minimafecha);
                                    $_elmes = Date("m", $_myactividades->minimafecha);
                                }
                                if (substr($_eldia, 0, 1) == '0') {
                                    $_meldia = substr($_eldia, -1);
                                } else {
                                    $_meldia = $_eldia;
                                }
                                $_lafecha = $_meldia . " " . cmes($_elmes, 0);
                                if ($_controldia != $_eldia || $_controlmes != $_elmes) {
                                    $_controldia = $_eldia;
                                    $_controlmes = $_elmes;
                                    $_tabulos++;
                                    if ($_parametroP == 'top') {
                                        echo "                  <li><a class=\"ufps-tab-links\" onmouseover=\"openTab(event, 'tab" . ($_tabulos + 2) . "', 'tabs')\">" . $_lafecha . "</a></li>\n";
                                    } elseif ($_parametroP == 'right') {
                                        $_textofecha[$_tabulos] = $_meldia . " de " . cmes($_elmes, 1);
                                    }
                                }
                                if (!isset($_textotabulos[$_tabulos])) {
                                    $_textotabulos[$_tabulos] = "";
                                }
                                $_textotabulos[$_tabulos] .= "                    <tr>\n";
                                $_textotabulos[$_tabulos] .= "                      <td style=\"width:5%;text-align:right;vertical-align:top;padding-right:5px;\"><span class=\"ufps-badge ufps-badge-gray\" style=\"background-color:" . $_enlaces[$_a][8] . "\">&middot;</span>";
                                $_textotabulos[$_tabulos] .= "</td>";
                                $_textotabulos[$_tabulos] .= "\n<td style=\"text-align:justify;vertical-align:top;padding-bottom:15px;\">" . utf8_encode($_enlaces[$_a][5]);
                                if ($_enlaces[$_a][6]) {
                                    $_textotabulos[$_tabulos] .= " <a href=\"" . $_enlaces[$_a][6] . "\"";
                                    if ($_enlaces[$_a][7] == 1) {
                                        $_textotabulos[$_tabulos] .= " target=\"_blank\"";
                                    }
                                    $_textotabulos[$_tabulos] .= " style=\"text-decoration:none;\">[+ Leer m&aacute;s]</a>";
                                }
                                if ($_enlaces[$_a][1] != $_enlaces[$_a][2]) {
                                    $_textotabulos[$_tabulos] .= "<br><span style=\"width:33%; font-size:0.85em; padding-top:2px; color:#424242;\"><i>" . utf8_encode(textoDesarrollo($_enlaces[$_a][1], $_enlaces[$_a][2])) . " &nbsp; &nbsp; &nbsp; &nbsp; </i></span>\n";
                                }
                                $_textotabulos[$_tabulos] .= "                      </td></tr>\n";
                            }
                            if ($_parametroP == 'top') {
                                ?>
                            </ul>
                            <div id="tab1" class="ufps-tab-content"></div>
                            <?php
                            for ($_a = 0; $_a <= $_tabulos; $_a++) {
                                ?>
                                <div id="tab<?php echo ($_a + 2); ?>" class="ufps-tab-content">
                                    <table width="100%" border"0" cellpadding="5" cellspacing="0">
                        <?php
                        echo $_textotabulos[$_a];
                        ?>
                                </table>
                            </div>
                    <?php
                }
                ?>
                    </div>
                <?php
            } elseif ($_parametroP == 'right') {
                ?>
                    <div class="ufps-accordion">
                <?php
                for ($_a = 0; $_a <= $_tabulos; $_a++) {
                    ?>
                            <button class="ufps-btn-accordionlike ufps-btn-accordion"><?php echo $_textofecha[$_a]; ?></button>
                            <div class="ufps-accordion-panel" style="padding:0 9px;">
                                <table width="100%" border"0" cellpadding="5" cellspacing="0" style="margin-top:10px;">
            <?php
            echo $_textotabulos[$_a];
            ?>
                            </table>
                        </div>
            <?php
        }
        ?>
                </div>
        <?php
    }
} else {
    ?>
            <span style="text-align:center;"><h3 class="simple" style="margin-top:20px; color:#dd1617;">No hay actividades para mostrar</h3></span>
    <?php
}
?>
        <div class="clear" style="height:10px;"></div>
<?php
if ($_parametroP == 'top') {
    ?>
        </div><!--gdl-custom-sidebar-->
    </div><!--ufps-col-mobile-3-->
    <?php
    if (!$_solocontenido) {
        ?>
        </div><!--ufps-row-->
        <?php
    }
    ?>
    <?php
} else {
    if (!$_solocontenido) {
        ?>
        </div><!--proximasContent-->
        <?php
    }
}
?>

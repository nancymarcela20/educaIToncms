<?php
$_activo = 0;
$_pick = 1;
if (isset($_GET['modulo'])) {
    if ($_GET['modulo'] == 'verinformacion') {
        $_pick = 0;
    }
}
if (isset($_GET['idtipoc'])) {
    if ($_GET['idtipoc'] != 0) {
        $_activo = $_GET['idtipoc'];
    }
}
$_anno = Date("Y");
$_mes = Date("m");
if (isset($_GET['anno'])) {
    if ($_GET['anno'] > 0) {
        $_anno = $_GET['anno'];
    }
}
if (isset($_GET['mes'])) {
    if ($_GET['mes'] >= 0) {
        if ($_GET['mes'] > 12) {
            $_mes = 1;
            $_anno += 1;
        } elseif ($_GET['mes'] == 0) {
            $_mes = 12;
            $_anno -= 1;
        } else {
            $_mes = $_GET['mes'];
        }
    }
}
if ($_pick) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
        <h1 class="pull-left" style="font-size:36px;">Calendarios</h1>

        <div class="gdl-custom-sidebar-title-m"><div class="ufps-tooltip" style="margin-top:30px; float:right; position:absolute; right:5px; top: 0px;"><span style="float:right"><img src="rsc/img/tune.png" style="cursor:pointer;" id="tuneBtn" onClick="TogglePopUp(event, 'calendarios')"></span><span class="ufps-tooltip-content-left" style="font-size:14px; font-weight:normal; margin-right:5px;">Ajustar filtro</span></div></div>
        <div style="clear:both;"></div>
        <div class="gdl-custom-sidebar" id="calendarios" style='z-index:9;'>
            <a onclick="filtreEvento(event, 'calendarios', '0', <?php echo $_anno; ?>, <?php echo $_mes; ?>)" class="ufps-btn<?php
            if ($_activo == 0) {
                echo " ufps-btn-light-active";
            } else {
                echo " ufps-btn-light";
            }
            ?>">Todos</a>
               <?php
               $_myTipoCalendarios = new TipoCalendarios();
               $_enlaces = $_myTipoCalendarios->obtenerTipoCalendarios();
               if ($_enlaces[0] != "error") {
                   for ($_a = 0; $_a < count($_enlaces); $_a++) {
                       echo "              <a onclick=\"filtreEvento(event, 'calendarios', '" . $_enlaces[$_a][0] . "'," . $_anno . "," . $_mes . ")\" class=\"ufps-btn";
                       if ($_activo == $_enlaces[$_a][0]) {
                           echo " ufps-btn-light-active";
                       } else {
                           echo " ufps-btn-light";
                       }
                       echo "\">" . utf8_encode($_enlaces[$_a][1]) . " <span style=\"background-color:" . $_enlaces[$_a][2] . ";\">&nbsp; &nbsp;</span></a>\n";
                   }
               }
               ?>
        </div>
    </div>
    <?php
}
$_myInfo = new Actividades($_activo);
if ($_pick) {
    $_enlaces = $_myInfo->obtenerActividadesMes($_anno, $_mes);
    $_festivos = $_myInfo->obtenerFestivosMes($_anno, $_mes);
    $_conactividad = $_myInfo->obtenerDiasActivos($_anno, $_mes);
} else {
    
}
if ($_enlaces[0] != "error") {
    echo calendario($_anno, $_mes, 1, $_activo, $_festivos, $_conactividad);
    ?>
    <div id='modal' class='ufps-modal'>
        <div id='modalentries' class="ufps-modal-content">
        </div>
    </div>
    <?php
    if ($_pick) {
        $_tabulos = -1;
        $_textofecha = array();
        $_textotabulos = array();
        $_controldia = "";
        $_controlmes = "";
        for ($_a = 0; $_a < count($_enlaces); $_a++) {
            if ($_enlaces[$_a][1] > Date("Y-m-d", $_myInfo->minimafecha)) {
                $_eldia = substr($_enlaces[$_a][1], -2);
                $_elmes = substr($_enlaces[$_a][1], 5, 2);
            } else {
                $_eldia = Date("d", $_myInfo->minimafecha);
                $_elmes = Date("m", $_myInfo->minimafecha);
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
                $_textofecha[$_tabulos] = $_meldia . " de " . cmes($_elmes, 1);
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
        echo "<div style=\"width:90%; margin:auto; margin-top:20px;\">";
        echo "<h2 style=\"text-align:center;\">Actividades en este mes</h2>";
        for ($_a = 0; $_a <= $_tabulos; $_a++) {
            ?>
            <h3 class="calendario"><?php echo $_textofecha[$_a]; ?></h3>
            <table width="100%" border"0" cellpadding="5" cellspacing="0" style="margin-top:10px;">
            <?php
            echo $_textotabulos[$_a];
            ?>
            </table>
            <?php
            if ($_a < (count($_enlaces) - 1)) {
                echo "<span class=\"row-separator\"></span>";
            }
            ?>
            <?php
        }
        ?>
        </div>
        <div style="height:20px"></div>
        <?php
    } else {
        
    }
} else {
    echo calendario($_anno, $_mes, 0, $_activo, $_festivos, $_conactividad);
    if ($_pick) {
        echo "<div style=\"width:90%; margin:auto; text-align:center; margin-top:20px;\">";
        if (!empty($_GET['idtipoc'])) {
            $_tipoinformacion = strtolower($_myInfo->obtenerTipoCalendario($_activo));
            if ($_tipoinformacion == 'error') {
                echo "<h3 class=\"simple\">Lo sentimos, no encontramos actividades para el tipo de calendario que ha solicitado; le pedimos el favor de verificar su solicitud.</h3>";
                echo "<h3 class=\"simple\">Si lo desea, puede seguir a nuestra <a href=\"./\">p&aacute;gina principal</a>.</h3>";
            } else {
                echo "<h3 class=\"simple\">Lo sentimos, a&uacute;n no tenemos actividades en el calendario &laquo;" . utf8_encode($_tipoinformacion) . "&raquo; para mostrar; le invitamos a regresar a nuestra <a href=\"./\">p&aacute;gina principal</a> o elegir otro <a href=\"javascript:TogglePopUp(event, 'calendarios');\">tipo de informaci&oacute;n</a>.</h3>";
            }
        } else {
            echo "<h3 class=\"simple\">No hay actividades definidas en este a&ntilde;o y mes.</h3>";
        }
        echo "</div>";
    } else {
        
    }
}
?>

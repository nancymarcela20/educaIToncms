<div style="text-align:center;">
    <h2>Administraci&oacute;n de enlaces</h2>
</div>
<?php
$_mallainicial = 0;
$_tipoenlace = 1;
$_actxpag = 20;
if (isset($_GET['mallainicial'])) {
    if ($_GET['mallainicial']) {
        $_mallainicial = $_GET['mallainicial'];
    }
}
if (isset($_POST['mallainicial'])) {
    if ($_POST['mallainicial']) {
        $_mallainicial = $_POST['mallainicial'];
    }
}
if (isset($_GET['tenla'])) {
    if ($_GET['tenla']) {
        $_tipoenlace = $_GET['tenla'];
    }
}
if (isset($_POST['tenla'])) {
    if ($_POST['tenla']) {
        $_tipoenlace = $_POST['tenla'];
    }
}
if (isset($_GET['ixp'])) {
    if ($_GET['ixp']) {
        $_actxpag = $_GET['ixp'];
    }
}
if (isset($_GET['msj'])) {
    $_autoro = 0;
    if (isset($_SESSION['flag'])) {
        if ($_SESSION['flag'] == 1) {
            $_autoro = 1;
        }
    }
    if ($_autoro == 1) {
        ?>
        <div id="modal" class="ufps-modal">
            <div class="ufps-modal-content">
                <div class="ufps-modal-header ufps-modal-header-red">
                    <span class="ufps-modal-close">&times;</span>
                    <h2 style="color:#fff;">SWAPIS</h2>
                </div>
                <div class="ufps-modal-body">
                    <?php
                    if ($_GET['msj'] == 1) {
                        echo "<p>Ha ocurrido un error agregando el registro en la base de datos</p>";
                    } elseif ($_GET['msj'] == 2) {
                        echo "<p>El registro se ha agregado de manera satisfactoria";
                    } elseif ($_GET['msj'] == 3) {
                        echo "<p>Ha ocurrido un error cambiando el estado del registro en la base de datos</p>";
                    } elseif ($_GET['msj'] == 4) {
                        echo "<p>El estado del registro se ha cambiado de manera satisfactoria</p>";
                    } elseif ($_GET['msj'] == 5) {
                        echo "<p>Ha ocurrido un error editando el contenido del registro</p>";
                    } elseif ($_GET['msj'] == 6) {
                        echo "<p>El registro se ha editado de manera satisfactoria</p>";
                    } elseif ($_GET['msj'] == 10) {
                        echo "<p>El archivo elegido no es una imagen</p>";
                    } elseif ($_GET['msj'] == 11) {
                        echo "<p>La imagen elegida tiene unas dimensiones menores a las requeridas</p>";
                    } elseif ($_GET['msj'] == 12) {
                        echo "<p>Ha ocurrido un error redimensionando la imagen</p>";
                    } elseif ($_GET['msj'] == 13) {
                        echo "<p>Ha ocurrido un error subiendo la imagen al servidor</p>";
                    } elseif ($_GET['msj'] == 14) {
                        echo "<p>La imagen debe ser JPG, GIF o PNG</p>";
                    } elseif ($_GET['msj'] == 19) {
                        echo "<p>Se ha grabado con &eacute;xito el nuevo orden de los enlaces</p>";
                    } elseif ($_GET['msj'] == 20) {
                        echo "<p>Hubo un error grabando el nuevo orden de los enlaces</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nuevo Enlace</button></div>
<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="ordenar()">Ordenar enlaces</button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="enlaces">
        <input type="hidden" name="tipoenlace" value="<?php echo $_tipoenlace; ?>">
        <input type="hidden" name="accion" value="">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="mallainicial" value="">
        <input type="hidden" name="actxpag" value="">
        <input type="hidden" name="tipoenla" value="">
        <input type="hidden" name="estado" value="">
    </form>
    <script>
        function estado(_id, _estado, _mallainicial) {
            if (_estado == 1) {
                var texto = "activar";
            } else {
                var texto = "desactivar";
            }
            if (confirm("Va a proceder a " + texto + " un registro de actividad") == true) {
                document.forms['acciones'].accion.value = 'enestado';
                document.forms['acciones'].id.value = _id;
                document.forms['acciones'].mallainicial.value = _mallainicial;
                document.forms['acciones'].estado.value = _estado;
                document.forms['acciones'].submit();
            }
        }
        function editar(_id, _mallainicial) {
            document.forms['acciones'].accion.value = 'eneditar';
            document.forms['acciones'].id.value = _id;
            document.forms['acciones'].mallainicial.value = _mallainicial;
            document.forms['acciones'].submit();
        }
        function prepararaddbox() {
            document.forms['annadir'].etiqueta.value = '';
            document.forms['annadir'].url.value = '';
            document.forms['annadir'].afuera.checked = false;
            document.forms['annadir'].accion.value = 'nenlace';
            document.forms['annadir'].id.value = 0;
            document.getElementById("tituloaddbox").innerHTML = "Agregar un nuevo enlace";
            if (document.getElementById("ImagenActual")) {
                document.getElementById("ImagenActual").innerHTML = "I";
            }
            document.getElementById("urlstatus").src = "rsc/img/gray.png";
            openModal('modaladdbox', 1);
        }
        function cambiarpaginacion(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiaitemsxpagina";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].actxpag.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
        function cambiartipoenlace(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiatipoenlace";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].tipoenla.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
        function ordenar() {
            openModal('orderbox', 1);
        }
    </script>
    <?php
    $_myEnlaces = new Enlaces($_tipoenlace);
    $objInfo = new Informaciones(0);
    $_totalregistros = $_myEnlaces->totalEnlaces();
    $_enlaces = $_myEnlaces->obtenerPagina($_mallainicial, $_actxpag);
    if ($_enlaces != 'error') {
        paginador("enlaces", $_mallainicial, $_totalregistros, $_actxpag, "tenla", $_tipoenlace);
    }
    $_enlaceste = $_myEnlaces->obtenerTiposEnlaces(0);
    filasporpagina($_actxpag, 'tipoenlaces', $_enlaceste, $_tipoenlace);
    mallaenlaces($_mallainicial, $_enlaces, $_tipoenlace, $objInfo);
    filasporpagina($_actxpag, 'tipoenlaces', $_enlaceste, $_tipoenlace);
    if ($_enlaces != 'error') {
        paginador("enlaces", $_mallainicial, $_totalregistros, $_actxpag, "tenla", $_tipoenlace);
    }
    $_naturaleza = 0;
    $_campos = array();
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'eneditar') {
            $_naturaleza = $_POST['id'];
            $_campos = $_myEnlaces->obtenerCamposXaEdicion($_naturaleza);
        }
    }
    cuadromasenlace($_enlaces, $_naturaleza, $_campos, $_tipoenlace, $_myEnlaces->obtenerTiposEnlaces($_tipoenlace, 1), $objInfo);
    orderbox($_myEnlaces->obtenerEnlaces(), $_tipoenlace);

    function mallaenlaces($limite_inicial, $_enlaces, $tipoenlace, $objInfo) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>&nbsp;</th>
                <th>Id</th>
                <?php
                if ($tipoenlace == 1) {
                    ?>
                    <th>Etiqueta</th>
                    <?php
                } else {
                    ?>
                    <th>Imagen</th>
                    <?php
                }
                ?>
                <th>URL destino</th>
                <th>Estado</th>
                </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . "," . $limite_inicial . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar registro\"></a>";
                    if ($_enlaces[$_a][2] == 1) {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0," . $limite_inicial . ")\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    } else {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",1," . $limite_inicial . ")\"><img id=\"acti" . $_a . "\" src=\"rsc/img/activate.png\" onmouseover=\"Myhover('acti" . $_a . "','rsc/img/ractivate.png')\" onmouseout=\"Myhover('acti" . $_a . "','rsc/img/activate.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    }
                    echo "</td>";
                    echo "<td>" . $_enlaces[$_a][0] . "</td>";
                    if ($tipoenlace == 1) {
                        echo "<td>" . utf8_encode($_enlaces[$_a][4]) . "</td>";
                    } else {
                        echo "<td class=\"ufps-text-center\"><img src=" . $_enlaces[$_a][4] . "></td>";
                    }
                    echo "<td class=\"ufps-text-left\">";
                    if (is_numeric($_enlaces[$_a][5])) {
                        echo "<a target=\"_blank\" href=\"" . EnvelopeLink($_enlaces[$_a][5]) . "\"><img id=\"open" . $_a . "\" src=\"rsc/img/openlink.png\" onmouseover=\"Myhover('open" . $_a . "','rsc/img/ropenlink.png')\" onmouseout=\"Myhover('open" . $_a . "','rsc/img/openlink.png')\" title=\"Abrir enlace\"></a>&nbsp;";
                        echo utf8_encode($objInfo->etiquetaModulo($_enlaces[$_a][5]));
                    } else {
                        if ($_enlaces[$_a][5] && $_enlaces[$_a][5] != "javacript:;") {
//          echo $_enlaces[$_a][5];
                            echo "<a target=\"_blank\" href=\"" . $_enlaces[$_a][5] . "\"><img id=\"open" . $_a . "\" src=\"rsc/img/openlink.png\" onmouseover=\"Myhover('open" . $_a . "','rsc/img/ropenlink.png')\" onmouseout=\"Myhover('open" . $_a . "','rsc/img/openlink.png')\" title=\"Abrir enlace\"></a>";
                        } else {
                            echo "&nbsp;";
                        }
                    }
                    echo "</td>";
                    echo "<td class=\"ufps-text-center\">";
                    if ($_enlaces[$_a][2] == 1) {
                        echo "Activo";
                    } else {
                        echo "Inactivo";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        } else {
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de enlaces</h2></div>";
        }
    }

    function cuadromasenlace($_enlaces, $_idedicion, $_campos, $_tipoenlace, $_imgheight, $objInfo) {
        ?>
        <script>
            function validaractividad(idedicion) {
                var _sinetiqueta = 0;
                if (document.getElementById("ImagenActual")) {
                    _sinetiqueta = 1;
                }
                if (document.forms['annadir'].etiqueta.value.length > 0 || _sinetiqueta == 1) {
                    var _urlbien = 0;
                    if (document.forms['annadir'].url.value.length == 0) {
                        _urlbien = 1;
                    } else {
                        if (document.getElementById("urlstatus").src.substring(document.getElementById("urlstatus").src.length - 9, document.getElementById("urlstatus").src.length) == "urlok.png") {
                            _urlbien = 1;
                        }
                    }
                    if (_urlbien == 1) {
                        if (document.forms['annadir'].id.value > 0) {
                            if (idedicion > 0) {
                                document.forms['annadir'].estado.value = 'edicion';
                                if (confirm("Va a proceder a actualizar la actividad") == true) {
                                    document.forms['annadir'].submit();
                                }
                            } else {
                                document.forms['annadir'].submit();
                            }
                        } else {
                            document.forms['annadir'].submit();
                        }
                    } else {
                        alert("Hay un problema con la URL definida");
                    }
                } else {
                    alert("La actividad no puede estar en blanco");
                }
            }
            function checkurl(_url_) {
                if (_url_.length > 0) {
                    document.getElementById("urlstatus").src = "rsc/img/loadingBar.gif";
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("urlresult").innerHTML =
                                    this.responseText;
                        }
                    };
                    xhttp.open("GET", "controladores/checkurl.php?url=" + _url_, true);
                    xhttp.send();

                } else {
                    document.getElementById("urlstatus").src = "rsc/img/gray.png";
                }
            }
        </script>
        <div id="modaladdbox" class="ufps-modal" style="padding-top:50px;">
            <div class="ufps-modal-content">
                <div class="ufps-modal-header ufps-modal-header-red">
                    <span class="ufps-modal-close">&times;</span>
                    <!--
                        <div style="gdl-custom-sidebar" id="addbox">
                    -->
                    <!--
                          <div style="text-align:center;">
                    -->
                    <h2 id="tituloaddbox" style="color:#fff;"><?php if ($_idedicion) {
            echo "Editar enlace Id. " . $_idedicion;
        } else {
            echo "Agregar un nuevo enlace";
        } ?></h2>
                    <!--
                          </div>
                    -->
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <!--
                          <div style="margin-left:10px;">
                    -->
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post"<?php if ($_tipoenlace > 1) {
            echo " enctype=\"multipart/form-data\"";
        } ?>>
                        <input type="hidden" name="accion" value="nenlace">
                        <input type="hidden" name="estado" value="">
                        <input type="hidden" name="conimagen" value="<?php if ($_tipoenlace == 1) {
                        echo "0";
                    } else {
                        echo "1";
                    } ?>">
                        <input type="hidden" name="tenla" value="<?php echo $_tipoenlace; ?>">
                        <input type="hidden" name="maxheight" value="<?php echo $_imgheight; ?>">
                        <?php
                        if ($_idedicion) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $_campos[0]; ?>">
                            <input type="hidden" name="activo" value="<?php if ($_campos[2] == 1) {
                        echo "1";
                    } else {
                        echo "0";
                    } ?>">
                            <?php
                        }
                        if ($_tipoenlace == 1) {
                            ?>
                            <p class="pnormal">Descripci&oacute;n:<br><textarea class="ufps-textarea" name="etiqueta"><?php if ($_idedicion) {
                        echo utf8_encode($_campos[4]);
                    } ?></textarea></p>
                            <?php
                        } else {
                            ?>
                            <p class="pnormal"><?php if ($_idedicion) {
                        echo "<span id=\"ImagenActual\">Imagen actual:<br><img src=\"" . $_campos[4] . "\"><br><br>Nueva i</span>";
                    } else {
                        echo "I";
                    } ?>magen<?php if ($_imgheight) { ?><span style="font-style:italic;"> (alto m&iacute;nimo permitido: <?php echo $_imgheight; ?>px)</span><?php } ?>:<br><input type="file" name="etiqueta" id="uploadfile"></p>
                            <?php
                        }
                        ?>
                        <p class="pnormal">URL: <input type="text" class="ufps-input-short ufps-input" name="url" style="width:40%;" onblur="checkurl(document.forms['annadir'].url.value);"<?php if ($_idedicion) {
                        if ($_campos[5] != "javascript:;") {
                            if (!is_numeric($_campos[5])) {
                                echo " value=\"" . $_campos[5] . "\"";
                            }
                        }
                    } ?>> <span id="urlresult" style="margin-right:10px;"><img id="urlstatus" src="<?php if ($_idedicion) {
                        echo urlImage($_campos[5], $_idedicion);
                    } else {
                        echo "rsc/img/gray.png";
                    } ?>"></span> <input type="checkbox" name="afuera"<?php if ($_idedicion) {
                        if ($_campos[6] == 1) {
                            echo " checked";
                        }
                    } ?>> URL abre en nueva pesta&ntilde;a</p>
        <?php
        $_enlacesmod = $objInfo->obtenerModulosInfo();
        if ($_enlacesmod[0][0] != "error") {
            echo "<p class=\"pnormal\" style=\"margin-top:15px;\">M&oacute;dulo de informaci&oacute;n: ";
            echo "<select name=\"idmodulo\">";
            echo "<option value=\"0\">Elija un m&oacute;dulo de informaci&oacute;n asociado al enlace</option>";
            for ($_a = 0; $_a < count($_enlacesmod); $_a++) {
                $_chunk = "";
                if ($_idedicion) {
                    if ($_enlacesmod[$_a][0] == $_campos[5]) {
                        $_chunk = " selected";
                    }
                }
                echo "<option value=\"" . $_enlacesmod[$_a][0] . "\"" . $_chunk . ">" . utf8_encode($_enlacesmod[$_a][1]) . "</option>";
            }
            echo "<option value=\"0\">No asocie ning&uacute;n m&oacute;dulo de informaci&oacute;n al enlace</option>";
            echo "</select>";
            echo "</p>";
        }
        ?>
                        <div style="text-align:center; margin-top:25px;  margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad(<?php echo $_idedicion; ?>)"></div>
                    </form>
                    <!--
                          </div>
                    -->

                </div>
                <!--
                    </div>
                -->

            </div>
        </div>
    <?php
}

function orderbox($menuElements, $tipoenlace) {
    ?>
        <link rel="stylesheet" href="css/swapis/nested.css">
    <?php
    $_elmenu = "";
    if ($menuElements[0] != "error") {
        for ($_a = 0; $_a < count($menuElements); $_a++) {
            $_elmenu .= "<li id=\"list_" . ($_a + 1) . "\"><div>";
            if ($tipoenlace == 1) {
                $_elmenu .= utf8_encode($menuElements[$_a][1]);
            } else {
                $_elmenu .= "<img src=\"" . $menuElements[$_a][1] . "\" style=\"max-height:40px;\">";
            }
            echo "</div></li>";
        }
    }
    ?>
        <script>
            function grabarOrden() {
                arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                arraied = dump(arraied);
                document.forms['fordenar'].ordenado.value = arraied;
                document.forms['fordenar'].submit();
            }
            function dump(arr, level) {
                var dumped_text = "";
                if (!level)
                    level = 0;
                //The padding given at the beginning of the line.
                if (typeof (arr) == 'object') { //Array/Hashes/Objects
                    for (var item in arr) {
                        var value = arr[item];
                        if (typeof (value) == 'object') { //If it is an array,
                            /*
                             dumped_text += level_padding + "'" + item + "' ...\n";
                             */
                            dumped_text += dump(value, level + 1);
                        } else {
                            if (item == 'item_id' || item == 'depth') {
                                dumped_text += item + "|" + value + ";";
                            }
                        }
                    }
                } else { //Strings/Chars/Numbers etc.
                    dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
                }
                return dumped_text;
            }
        </script>
        <div id="orderbox" class="ufps-modal" style="padding-top:50px;">
            <div class="ufps-modal-content">
                <div class="ufps-modal-header ufps-modal-header-red">
                    <span class="ufps-modal-close">&times;</span>
                    <h2 id="tituloaddbox" style="color:#fff;">Ordenar enlaces</h2>
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <ol class="sortable" id="sortable">
    <?php
    echo $_elmenu;
    ?>
                    </ol>
                    <form name="fordenar" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
                        <input type="hidden" name="accion" value="enordenar">
                        <input type="hidden" name="tenla" value="<?php echo $tipoenlace; ?>">
                        <input type="hidden" name="ordenado" value="">
                        <p style="margin-bottom:10px; text-align:center;"><input type="button" onclick="grabarOrden()" value="Grabar nuevo orden"></p>
                    </form>
                </div>
            </div>
        </div>
    <?php
}
?>

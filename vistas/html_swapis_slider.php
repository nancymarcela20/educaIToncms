<div style="text-align:center;">
    <h2>Administraci&oacute;n de im&aacute;genes rotatorias</h2>
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
                    } elseif ($_GET['msj'] == 15) {
                        echo "<p>Las dimensiones de la imagen impiden cambiar el tamaño para que se ajuste a las medidas requeridas</p>";
                    } elseif ($_GET['msj'] == 19) {
                        echo "<p>Se ha grabado con &eacute;xito el nuevo orden de las im&aacute;genes rotatorias</p>";
                    } elseif ($_GET['msj'] == 20) {
                        echo "<p>Hubo un error grabando el nuevo orden de las im&aacute;genes rotatorias</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nueva Imagen Rotatoria</button></div>
<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="ordenar()">Ordenar im&aacute;genes rotatorias</button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="slider">
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
                document.forms['acciones'].accion.value = 'irestado';
                document.forms['acciones'].id.value = _id;
                document.forms['acciones'].mallainicial.value = _mallainicial;
                document.forms['acciones'].estado.value = _estado;
                document.forms['acciones'].submit();
            }
        }
        function editar(_id, _mallainicial) {
            document.forms['acciones'].accion.value = 'ireditar';
            document.forms['acciones'].id.value = _id;
            document.forms['acciones'].mallainicial.value = _mallainicial;
            document.forms['acciones'].submit();
        }
        function prepararaddbox() {
            document.forms['annadir'].titulo.value = '';
            document.forms['annadir'].texto.value = '';
            document.forms['annadir'].url.value = '';
            document.forms['annadir'].afuera.checked = false;
            document.forms['annadir'].accion.value = 'nimagenrot';
            document.forms['annadir'].id.value = 0;
            document.getElementById("tituloaddbox").innerHTML = "Agregar una nueva imagen rotatoria";
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
        function ordenar() {
            openModal('orderbox', 1);
        }
    </script>
    <?php
    $_myConfig = new Configuraciones;
    $objInfo = new Informaciones(0);
    $_minwidth = $_myConfig->obtenerMinWidthSlider();
    $_sliderwidth = $_myConfig->obtenerSliderDimensions();
    $_mySlides = new Slides();
    $_totalregistros = $_mySlides->totalSlides();
    $_enlaces = $_mySlides->obtenerPagina($_mallainicial, $_actxpag);
    if ($_enlaces != 'error') {
        paginador("slider", $_mallainicial, $_totalregistros, $_actxpag);
    }
    filasporpagina($_actxpag);
    mallaslides($_mallainicial, $_enlaces, $objInfo);
    filasporpagina($_actxpag);
    if ($_enlaces != 'error') {
        paginador("slider", $_mallainicial, $_totalregistros, $_actxpag);
    }
    $_naturaleza = 0;
    $_campos = array();
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'ireditar') {
            $_naturaleza = $_POST['id'];
            $_campos = $_mySlides->obtenerCamposXaEdicion($_naturaleza);
        }
    }
    cuadromasslide($_enlaces, $_naturaleza, $_campos, $_minwidth, $_sliderwidth[0][0], $_sliderwidth[0][1], $objInfo);
    orderbox($_mySlides->obtenerSlides());

    function mallaslides($limite_inicial, $_enlaces, $objInfo) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>&nbsp;</th>
                <th>Id</th>
                <th>T&iacute;tulo</th>
                <th>Texto</th>
                <th>Imagen</th>
                <th>URL destino</th>
                <th>Estado</th>
                </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . "," . $limite_inicial . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar registro\"></a>";
                    if ($_enlaces[$_a][1] == 1) {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0," . $limite_inicial . ")\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    } else {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",1," . $limite_inicial . ")\"><img id=\"acti" . $_a . "\" src=\"rsc/img/activate.png\" onmouseover=\"Myhover('acti" . $_a . "','rsc/img/ractivate.png')\" onmouseout=\"Myhover('acti" . $_a . "','rsc/img/activate.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    }
                    echo "</td>";
                    echo "<td>" . $_enlaces[$_a][0] . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][3]) . "</td>";
                    echo "<td>" . substr(utf8_encode($_enlaces[$_a][4]), 0, 50) . "...</td>";
                    echo "<td class=\"ufps-text-center\"><img src=" . $_enlaces[$_a][5] . " style=\"max-width:150px;\"></td>";
                    echo "<td class=\"ufps-text-left\">";
                    if (is_numeric($_enlaces[$_a][6])) {
                        echo "<a target=\"_blank\" href=\"" . EnvelopeLink($_enlaces[$_a][6]) . "\"><img id=\"open" . $_a . "\" src=\"rsc/img/openlink.png\" onmouseover=\"Myhover('open" . $_a . "','rsc/img/ropenlink.png')\" onmouseout=\"Myhover('open" . $_a . "','rsc/img/openlink.png')\" title=\"Abrir enlace\"></a>&nbsp;";
                        echo utf8_encode($objInfo->etiquetaModulo($_enlaces[$_a][6]));
                    } else {
                        if ($_enlaces[$_a][6]) {
//          echo $_enlaces[$_a][5];
                            echo "<a target=\"_blank\" href=\"" . $_enlaces[$_a][6] . "\"><img id=\"open" . $_a . "\" src=\"rsc/img/openlink.png\" onmouseover=\"Myhover('open" . $_a . "','rsc/img/ropenlink.png')\" onmouseout=\"Myhover('open" . $_a . "','rsc/img/openlink.png')\" title=\"Abrir enlace\"></a>";
                        } else {
                            echo "&nbsp;";
                        }
                    }
                    echo "</td>";
                    echo "<td class=\"ufps-text-center\">";
                    if ($_enlaces[$_a][1] == 1) {
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

    function cuadromasslide($_enlaces, $_idedicion, $_campos, $_imgwidth, $_sliderwidth, $_sliderheight, $objInfo) {
        ?>
        <script>
            function validaractividad(idedicion) {
                var _sinetiqueta = 0;
                if (document.getElementById("ImagenActual")) {
                    _sinetiqueta = 1;
                }
                if (document.forms['annadir'].etiqueta.value.length > 0 || _sinetiqueta == 1) {
                    if (document.forms['annadir'].titulo.value.length > 0) {
                        if (document.forms['annadir'].texto.value.length > 0) {
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
                            alert("El texto no puede estar vacío");
                        }
                    } else {
                        alert("El título no puede estar vacío");
                    }
                } else {
                    alert("Debe haber una imagen rotatoria definida");
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
            echo "Editar imagen rotatoria Id. " . $_idedicion;
        } else {
            echo "Agregar una nueva imagen rotatoria";
        } ?></h2>
                    <!--
                          </div>
                    -->
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <!--
                          <div style="margin-left:10px;">
                    -->
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="nimagenrot">
                        <input type="hidden" name="estado" value="">
                        <input type="hidden" name="conimagen" value="1">
                        <input type="hidden" name="minwidth" value="<?php echo $_imgwidth; ?>">
                        <input type="hidden" name="sliderwidth" value="<?php echo $_sliderwidth; ?>">
                        <input type="hidden" name="sliderheight" value="<?php echo $_sliderheight; ?>">
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
                        ?>
                        <p class="pnormal">T&iacute;tulo: <input type="text" class="ufps-input-short ufps-input" name="titulo" style="width:40%;"<?php if ($_idedicion) {
                        echo " value=\"" . utf8_encode($_campos[3]) . "\"";
                    } ?>>
                        <p class="pnormal">Texto:<br><textarea class="ufps-textarea" name="texto"><?php if ($_idedicion) {
                        echo utf8_encode($_campos[4]);
                    } ?></textarea></p>
                        <p class="pnormal"><?php if ($_idedicion) {
                        echo "<span id=\"ImagenActual\">Imagen actual:<br><img src=\"" . $_campos[5] . "\"><br><br>Nueva i</span>";
                    } else {
                        echo "I";
                    } ?>magen<?php if ($_imgwidth) { ?><span style="font-style:italic;"> (ancho m&iacute;nimo permitido: <?php echo $_imgwidth; ?>px; dimensiones recomendadas: <?php echo $_sliderwidth; ?> x <?php echo $_sliderheight; ?>px)</span><?php } ?>:<br><input type="file" name="etiqueta" id="uploadfile"><br>Cortar imagen en: <input type="radio" name="crop" value="1" checked> Borde superior <input type="radio" name="crop" value="2"> Centro <input type="radio" name="crop" value="3"> Borde inferior</p>
                        <p class="pnormal">URL: <input type="text" class="ufps-input-short ufps-input" name="url" style="width:40%;" onblur="checkurl(document.forms['annadir'].url.value);"<?php if ($_idedicion) {
                        if ($_campos[6] != "javascript:;") {
                            if (!is_numeric($_campos[6])) {
                                echo " value=\"" . $_campos[6] . "\"";
                            }
                        }
                    } ?>> <span id="urlresult" style="margin-right:10px;"><img id="urlstatus" src="<?php if ($_idedicion) {
                        echo urlImage($_campos[6], $_idedicion);
                    } else {
                        echo "rsc/img/gray.png";
                    } ?>"></span> <input type="checkbox" name="afuera"<?php if ($_idedicion) {
                        if ($_campos[7] == 1) {
                            echo " checked";
                        }
                    } ?>> URL abre en nueva pesta&ntilde;a</p>
    <?php
    $_enlacesmod = $objInfo->obtenerModulosInfo();
    if ($_enlacesmod[0][0] != "error") {
        echo "<p class=\"pnormal\" style=\"margin-top:15px;\">M&oacute;dulo de informaci&oacute;n: ";
        echo "<select name=\"idmodulo\">";
        echo "<option value=\"0\">Elija un m&oacute;dulo de informaci&oacute;n asociado a la imagen rotatoria</option>";
        for ($_a = 0; $_a < count($_enlacesmod); $_a++) {
            $_chunk = "";
            if ($_idedicion) {
                if ($_enlacesmod[$_a][0] == $_campos[6]) {
                    $_chunk = " selected";
                }
            }
            echo "<option value=\"" . $_enlacesmod[$_a][0] . "\"" . $_chunk . ">" . utf8_encode($_enlacesmod[$_a][1]) . "</option>";
        }
        echo "<option value=\"0\">No asocie ning&uacute;n m&oacute;dulo de informaci&oacute;n a la imagen rotatoria</option>";
        echo "</select>";
        echo "</p>";
    }
    ?>
                        <div style="text-align:center; margin-top:25px; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad(<?php echo $_idedicion; ?>)"></div>
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

function orderbox($menuElements) {
    ?>
        <link rel="stylesheet" href="css/swapis/nested.css">
    <?php
    $_elmenu = "";
    if ($menuElements[0] != "error") {
        for ($_a = 0; $_a < count($menuElements); $_a++) {
            $_elmenu .= "<li id=\"list_" . ($_a + 1) . "\"><div><img src=\"" . utf8_encode($menuElements[$_a][2]) . "\" style=\"max-height:50px;\"></div></li>";
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
                    <h2 id="tituloaddbox" style="color:#fff;">Ordenar im&aacute;genes rotatorias</h2>
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <ol class="sortable" id="sortable">
    <?php
    echo $_elmenu;
    ?>
                    </ol>
                    <form name="fordenar" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
                        <input type="hidden" name="accion" value="irordenar">
                        <input type="hidden" name="ordenado" value="">
                        <p style="margin-bottom:10px; text-align:center;"><input type="button" onclick="grabarOrden()" value="Grabar nuevo orden"></p>
                    </form>
                </div>
            </div>
        </div>
    <?php
}
?>

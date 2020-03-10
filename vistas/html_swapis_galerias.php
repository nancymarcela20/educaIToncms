<div style="text-align:center;">
    <h2>Administraci&oacute;n de galer&iacute;as</h2>
</div>
<?php
$_porgaleria = 1;
$_mallainicial = 0;
$_tipogaleria = 1;
$_actxpag = 20;
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'gagrid') {
        $_porgaleria = 0;
    }
}
if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'gagrid') {
        $_porgaleria = 0;
    }
}
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
if (isset($_GET['tgale'])) {
    if ($_GET['tgale']) {
        $_tipogaleria = $_GET['tgale'];
    }
}
if (isset($_POST['tgale'])) {
    if ($_POST['tgale']) {
        $_tipogaleria = $_POST['tgale'];
    }
}
if (isset($_GET['ixp'])) {
    if ($_GET['ixp']) {
        $_actxpag = $_GET['ixp'];
    }
}
if ($_porgaleria == 0) {

    $_idgaleria = 0;
    if (isset($_GET['id'])) {
        $_idgaleria = $_GET['id'];
    } else {
        if (isset($_POST['id'])) {
            $_idgaleria = $_POST['id'];
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
                            echo "<p>Ha ocurrido un error agregando la imagen a la galer&iacute;a</p>";
                        } elseif ($_GET['msj'] == 2) {
                            echo "<p>La imagen se ha agregado a la galer&iacute;a de manera satisfactoria";
                        } elseif ($_GET['msj'] == 3) {
                            echo "<p>Ha ocurrido un error borrando la imagen de la galer&iacute;a</p>";
                        } elseif ($_GET['msj'] == 4) {
                            echo "<p>La imagen se ha borrado de la galer&iacute;a</p>";
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
                        } elseif ($_GET['msj'] == 20) {
                            echo "<p>Ha ocurrido un error grabando el nuevo orden de las im&aacute;genes</p>";
                        } elseif ($_GET['msj'] == 21) {
                            echo "<p>Se ha grabado el nuevo orden de las im&aacute;genes</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>

    <div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nueva Imagen</button></div>
    <div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="ordenar()">Ordenar im&aacute;genes de la galer&iacute;a</button></div>
    <div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="regresar()">Regresar a las galer&iacute;as</button></div>
    <div style="clear:both;">

        <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
            <input type="hidden" name="modulo" value="galerias">
            <input type="hidden" name="accion" value="gagrid">
            <input type="hidden" name="saccion" value="">
            <input type="hidden" name="tipogaleria" value="<?php echo $_tipogaleria; ?>">
            <input type="hidden" name="id" value="<?php echo $_idgaleria; ?>">
            <input type="hidden" name="sid" value="">
            <input type="hidden" name="tipogale" value="">
            <input type="hidden" name="estado" value="">
        </form>
        <script>
            function estado(_id, _estado) {
                if (confirm("Va a proceder a borrar una imagen") == true) {
                    document.forms['acciones'].saccion.value = 'imestado';
                    document.forms['acciones'].sid.value = _id;
                    document.forms['acciones'].estado.value = _estado;
                    document.forms['acciones'].submit();
                }
            }
            function editar(_id) {
                document.forms['acciones'].saccion.value = 'imeditar';
                document.forms['acciones'].sid.value = _id;
                document.forms['acciones'].submit();
            }
            function prepararaddbox() {
                document.forms['annadir'].etiqueta.value = '';
                document.forms['annadir'].descripto.value = '';
                document.forms['annadir'].saccion.value = 'nimagen';
                document.forms['annadir'].sid.value = 0;
                document.getElementById("tituloaddbox").innerHTML = "Agregar una nueva imagen";
                if (document.getElementById("ImagenActual")) {
                    document.getElementById("ImagenActual").innerHTML = "I";
                }
                openModal('modaladdbox', 1);
            }
            function ordenar() {
                openModal('orderbox', 1);
            }
            function regresar() {
                document.forms['acciones'].saccion.value = 'cleanup';
                document.forms['acciones'].submit();
            }
        </script>
        <?php
        $_myConfig = new Configuraciones;
        $_imagewidth = $_myConfig->obtenerImagesDimensions();
        $_myGalerias = new Galerias($_tipogaleria);
        $_enlaces = $_myGalerias->obtenerImagenes($_idgaleria);
        mallaimagenes($_enlaces, $_tipogaleria, $_idgaleria);
        echo "<div style=\"clear:both; min-height:20px;\"></div>";
        $_naturaleza = 0;
        $_campos = array();
        if (isset($_POST['saccion'])) {
            if ($_POST['saccion'] == 'imeditar') {
                $_naturaleza = $_POST['sid'];
                $_campos = $_enlaces[$_naturaleza - 1];
            }
        }
        cuadromasimagen($_enlaces, $_naturaleza, $_campos, $_tipogaleria, $_imagewidth[0][0], $_imagewidth[0][1], $_idgaleria);
        orderbox($_enlaces, $_tipogaleria, $_idgaleria);
    } else {

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
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nueva Galer&iacute;a</button></div>

        <div style="clear:both;">

            <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
                <input type="hidden" name="modulo" value="galerias">
                <input type="hidden" name="tipogaleria" value="<?php echo $_tipogaleria; ?>">
                <input type="hidden" name="accion" value="">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="mallainicial" value="">
                <input type="hidden" name="actxpag" value="">
                <input type="hidden" name="tipogale" value="">
                <input type="hidden" name="estado" value="">
            </form>
            <script>
                function estado(_id, _estado, _mallainicial) {
                    if (_estado == 1) {
                        var texto = "activar";
                    } else {
                        var texto = "desactivar";
                    }
                    if (confirm("Va a proceder a " + texto + " una galería") == true) {
                        document.forms['acciones'].accion.value = 'gaestado';
                        document.forms['acciones'].id.value = _id;
                        document.forms['acciones'].mallainicial.value = _mallainicial;
                        document.forms['acciones'].estado.value = _estado;
                        document.forms['acciones'].submit();
                    }
                }
                function editar(_id, _mallainicial) {
                    document.forms['acciones'].accion.value = 'gaeditar';
                    document.forms['acciones'].id.value = _id;
                    document.forms['acciones'].mallainicial.value = _mallainicial;
                    document.forms['acciones'].submit();
                }
                function grid(_id, _mallainicial) {
                    document.forms['acciones'].accion.value = 'gagrid';
                    document.forms['acciones'].id.value = _id;
                    document.forms['acciones'].mallainicial.value = _mallainicial;
                    document.forms['acciones'].submit();
                }
                function prepararaddbox() {
                    document.forms['annadir'].etiqueta.value = '';
                    document.forms['annadir'].titulo.value = '';
                    document.forms['annadir'].descripto.value = '';

                    document.forms['annadir'].accion.value = 'ngaleria';
                    document.forms['annadir'].id.value = 0;
                    document.getElementById("tituloaddbox").innerHTML = "Agregar una nueva galer&iacute;a";
                    if (document.getElementById("ImagenActual")) {
                        document.getElementById("ImagenActual").innerHTML = "I";
                    }
                    openModal('modaladdbox', 1);
                }
                function cambiarpaginacion(_nuevovalor) {
                    document.forms['acciones'].accion.value = "cambiaitemsxpagina";
                    document.forms['acciones'].mallainicial.value = 0;
                    document.forms['acciones'].actxpag.value = _nuevovalor;
                    document.forms['acciones'].submit();
                }
                function cambiartipogaleria(_nuevovalor) {
                    document.forms['acciones'].accion.value = "cambiatipogaleria";
                    document.forms['acciones'].mallainicial.value = 0;
                    document.forms['acciones'].tipogale.value = _nuevovalor;
                    document.forms['acciones'].submit();
                }
            </script>
            <?php
            $_myConfig = new Configuraciones;
            $_ThumbWidth = $_myConfig->obtenerWidthGalleryThumb();
            $_myGalerias = new Galerias($_tipogaleria);
            $_totalregistros = $_myGalerias->totalGalerias();
            $_enlaces = $_myGalerias->obtenerPagina($_mallainicial, $_actxpag);
            if ($_enlaces != 'error') {
                paginador("galerias", $_mallainicial, $_totalregistros, $_actxpag, "tgale", $_tipogaleria);
            }
            $_galeriaste = $_myGalerias->obtenerTiposGalerias(0);
            filasporpagina($_actxpag, 'tipogalerias', $_galeriaste, $_tipogaleria);
            mallaenlaces($_mallainicial, $_enlaces, $_tipogaleria);
            filasporpagina($_actxpag, 'tipogalerias', $_galeriaste, $_tipogaleria);
            if ($_enlaces != 'error') {
                paginador("galerias", $_mallainicial, $_totalregistros, $_actxpag, "tgale", $_tipogaleria);
            }
            $_naturaleza = 0;
            $_campos = array();
            if (isset($_POST['accion'])) {
                if ($_POST['accion'] == 'gaeditar') {
                    $_naturaleza = $_POST['id'];
                    $_campos = $_myGalerias->obtenerCamposXaEdicion($_naturaleza);
                }
            }
            cuadromasenlace($_enlaces, $_naturaleza, $_campos, $_tipogaleria, $_ThumbWidth);
        }

        function mallaenlaces($limite_inicial, $_enlaces, $tipogaleria) {
            if ($_enlaces[0] != "error") {
                ?>
                <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                    <thead>
                    <th>&nbsp;</th>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>T&iacute;tulo</th>
                    <th>Imagen</th>
                    <th>Descripci&oacute;n</th>
                    <th>Im&aacute;genes</th>
                    <th>Estado</th>
                    </thead>
        <?php
        for ($_a = 0; $_a < count($_enlaces); $_a++) {
            echo "<tr>";
            echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . "," . $limite_inicial . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar rgistro\"></a>";
            if ($_enlaces[$_a][2] == 1) {
                echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0," . $limite_inicial . ")\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
            } else {
                echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",1," . $limite_inicial . ")\"><img id=\"acti" . $_a . "\" src=\"rsc/img/activate.png\" onmouseover=\"Myhover('acti" . $_a . "','rsc/img/ractivate.png')\" onmouseout=\"Myhover('acti" . $_a . "','rsc/img/activate.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
            }
            echo "</td>";
            echo "<td class=\"ufps-text-center\">" . $_enlaces[$_a][0] . "</td>";
            echo "<td class=\"ufps-text-center\">" . $_enlaces[$_a][3] . "</td>";
            echo "<td>" . utf8_encode($_enlaces[$_a][5]) . "</td>";
            echo "<td class=\"ufps-text-center\"><img src=" . $_enlaces[$_a][4] . " style=\"max-width:100px;\"></td>";
            echo "<td>" . utf8_encode($_enlaces[$_a][6]) . "</td>";
            echo "<td class=\"ufps-text-center\"><a href=\"javascript:grid(" . $_enlaces[$_a][0] . "," . $limite_inicial . "," . $tipogaleria . ")\"><img id=\"grid" . $_a . "\" src=\"rsc/img/grid.png\" onmouseover=\"Myhover('grid" . $_a . "','rsc/img/rgrid.png')\" onmouseout=\"Myhover('grid" . $_a . "','rsc/img/grid.png')\" style=\"min-width:26px; margin:2px;\" title=\"Administrar imágenes\"></a></td>";
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
                    echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de galer&iacute;as</h2></div>";
                }
            }

            function cuadromasenlace($_enlaces, $_idedicion, $_campos, $_tipogaleria, $_ThumbWidth) {
                ?>
            <script>
                function validaractividad(idedicion) {
                    var _sinetiqueta = 0;
                    if (document.getElementById("ImagenActual")) {
                        _sinetiqueta = 1;
                    }
                    if (isValidDate(document.forms['annadir'].fecha.value)) {
                        if (document.forms['annadir'].etiqueta.value.length > 0 || _sinetiqueta == 1) {
                            if (document.forms['annadir'].titulo.value.length > 0 && document.forms['annadir'].descripto.value.length > 0) {
                                if (document.forms['annadir'].id.value > 0) {
                                    if (idedicion > 0) {
                                        document.forms['annadir'].estado.value = 'edicion';
                                        if (confirm("Va a proceder a actualizar la galería") == true) {
                                            document.forms['annadir'].submit();
                                        }
                                    } else {
                                        document.forms['annadir'].submit();
                                    }
                                } else {
                                    document.forms['annadir'].submit();
                                }
                            } else {
                                alert("Debe escribirse un título y una descripción para la galería");
                            }
                        } else {
                            alert("Debe definirse una imagen para la galería");
                        }
                    } else {
                        alert("La fecha debe tener una estructura válida");
                    }
                }
                $(function () {
                    $("#fecha").datepicker({
                        changeYear: true,
                        dateFormat: "yy-mm-dd",
                        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
                        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                    });
                });
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
            echo "Editar galer&iacute;a Id. " . $_idedicion;
        } else {
            echo "Agregar una nueva galer&iacute;a";
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
                            <input type="hidden" name="accion" value="ngaleria">
                            <input type="hidden" name="estado" value="">
                            <input type="hidden" name="tgale" value="<?php echo $_tipogaleria; ?>">
                            <input type="hidden" name="thumbwidth" value="<?php echo $_ThumbWidth; ?>">
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
                            <p class="pnormal">Fecha: <input type="text" class="ufps-input-short ufps-input" name="fecha" id="fecha"<?php if ($_idedicion) {
        echo " value=\"" . $_campos[3] . "\"";
    } ?>></p>
                            <p class="pnormal">T&iacute;tulo: <input type="text" class="ufps-input-medium ufps-input" name="titulo"<?php if ($_idedicion) {
        echo " value=\"" . utf8_encode($_campos[5]) . "\"";
    } ?>></p>
                            <p class="pnormal"><?php if ($_idedicion) {
        echo "<span id=\"ImagenActual\">Imagen actual:<br><img src=\"" . $_campos[4] . "\"><br><br>Nueva i</span>";
    } else {
        echo "I";
    } ?>magen<?php if ($_ThumbWidth) { ?><span style="font-style:italic;"> (ancho m&iacute;nimo permitido: <?php echo $_ThumbWidth; ?>px)</span><?php } ?>:<br><input type="file" name="etiqueta" id="uploadfile"><br>Si es necesario cortar la imagen, hacerlo en: <input type="radio" name="crop" value="1" checked> Borde superior/izquierdo <input type="radio" name="crop" value="2"> Centro <input type="radio" name="crop" value="3"> Borde inferior/derecho</p>
                            <p class="pnormal">Descripci&oacute;n:<br><textarea class="ufps-textarea" name="descripto"><?php if ($_idedicion) {
            echo utf8_encode($_campos[6]);
        } ?></textarea></p>
                            <div style="text-align:center; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad(<?php echo $_idedicion; ?>)"></div>
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

            function mallaimagenes($_enlaces, $tipogaleria, $_idgaleria) {
                if ($_enlaces[0] != "error") {
                    ?>
                <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                    <thead>
                    <th>&nbsp;</th>
                    <th>Id</th>
                    <th>Imagen</th>
                    <th>Descripci&oacute;n</th>
                    </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar registro\"></a>";
                    echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0)\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Borrar registro\"></a>";
                    echo "</td>";
                    echo "<td class=\"ufps-text-center\">" . $_enlaces[$_a][0] . "</td>";
                    echo "<td class=\"ufps-text-center\"><img src=" . $_enlaces[$_a][1] . " style=\"max-width:100px;\"></td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][2]) . "</td>";
                    echo "</tr>";
                }
                ?>
                </table>
        <?php
    } else {
        echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay im&aacute;genes en la galer&iacute;a</h2></div>";
    }
}

function cuadromasimagen($_enlaces, $_idedicion, $_campos, $_tipogale, $_imagewidth, $_imageheight, $_idgaleria) {
    ?>
            <script>
                function validaractividad(idedicion) {
                    var _sinetiqueta = 0;
                    if (document.getElementById("ImagenActual")) {
                        _sinetiqueta = 1;
                    }
                    if (document.forms['annadir'].etiqueta.value.length > 0 || _sinetiqueta == 1) {
                        if (document.forms['annadir'].descripto.value.length > 0) {
                            if (document.forms['annadir'].sid.value > 0) {
                                if (idedicion > 0) {
                                    document.forms['annadir'].estado.value = 'edicion';
                                    if (confirm("Va a proceder a actualizar la imagen") == true) {
                                        document.forms['annadir'].submit();
                                    }
                                } else {
                                    document.forms['annadir'].submit();
                                }
                            } else {
                                document.forms['annadir'].submit();
                            }
                        } else {
                            alert("La imagen debe tener una descripción");
                        }
                    } else {
                        alert("Debe incluirse una imagen");
                    }
                }
                $(function () {
                    $("#fecha").datepicker({
                        changeYear: true,
                        dateFormat: "yy-mm-dd",
                        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
                        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                    });
                });
            </script>
            <div id="modaladdbox" class="ufps-modal" style="padding-top:50px;">
                <div class="ufps-modal-content-wide ufps-modal-content">
                    <div class="ufps-modal-header ufps-modal-header-red">
                        <span class="ufps-modal-close">&times;</span>
                        <h2 id="tituloaddbox" style="color:#fff;"><?php if ($_idedicion) {
        echo "Editar imagen Id. " . $_idedicion;
    } else {
        echo "Agregar una nueva imagen";
    } ?></h2>
                    </div>
                    <div class="ufps-modal-body" style="background-color: #cecece;">
                        <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="gagrid">
                            <input type="hidden" name="id" value="<?php echo $_idgaleria; ?>">
                            <input type="hidden" name="saccion" value="nimagen">
                            <input type="hidden" name="estado" value="">
                            <input type="hidden" name="conimagen" value="1">
                            <input type="hidden" name="tgale" value="<?php echo $_tipogale; ?>">
                            <input type="hidden" name="imagewidth" value="<?php echo $_imagewidth; ?>">
                            <input type="hidden" name="imageheight" value="<?php echo $_imageheight; ?>">
            <?php
            if ($_idedicion) {
                ?>
                                <input type="hidden" name="sid" value="<?php echo $_campos[0]; ?>">
                                <input type="hidden" name="activo" value="<?php if ($_campos[4] == 1) {
            echo "1";
        } else {
            echo "0";
        } ?>">
        <?php
    } else {
        ?>
                                <input type="hidden" name="sid" value="">
        <?php
    }
    ?>
                            <p class="pnormal"><?php if ($_idedicion) {
        echo "<span id=\"ImagenActual\">Imagen actual:<br><img src=\"" . $_campos[1] . "\" style=\"max-height:80px;\"><br><br>Nueva i</span>";
    } else {
        echo "I";
    } ?>magen<?php if ($_imagewidth) { ?> <span style="font-style:italic;">(dimensiones recomendadas: <?php echo $_imagewidth; ?>px de ancho o <?php echo $_imageheight; ?>px de alto)</span><?php } ?>:<br><input type="file" name="etiqueta" id="uploadfile"></p>
                            <p class="pnormal" style="margin-top:25px;">Descripci&oacute;n de la imagen:<br><textarea class="ufps-textarea" name="descripto"><?php if ($_idedicion) {
        echo utf8_encode($_campos[2]);
    } ?></textarea></p>
                            <div style="text-align:center; margin-top:25px; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad(<?php echo $_idedicion; ?>)"></div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
}

function orderbox($menuElements, $_tipogaleria, $_idgaleria) {
    ?>
            <link rel="stylesheet" href="css/swapis/nested.css">
    <?php
    $_elmenu = "";
    if ($menuElements[0] != "error") {
        for ($_a = 0; $_a < count($menuElements); $_a++) {
            $_elmenu .= "<li id=\"list_" . ($_a + 1) . "\"><div><img src=\"" . utf8_encode($menuElements[$_a][1]) . "\" style=\"max-height:50px;\"></div></li>";
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
                        <h2 id="tituloaddbox" style="color:#fff;">Ordenar im&aacute;genes de la galer&iacute;a</h2>
                    </div>
                    <div class="ufps-modal-body" style="background-color: #cecece;">
                        <ol class="sortable" id="sortable">
    <?php
    echo $_elmenu;
    ?>
                        </ol>
                        <form name="fordenar" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
                            <input type="hidden" name="modulo" value="galerias">
                            <input type="hidden" name="accion" value="gagrid">
                            <input type="hidden" name="saccion" value="imordenar">
                            <input type="hidden" name="tipogaleria" value="<?php echo $_tipogaleria; ?>">
                            <input type="hidden" name="id" value="<?php echo $_idgaleria; ?>">
                            <input type="hidden" name="sid" value="">
                            <input type="hidden" name="tipogale" value="">
                            <input type="hidden" name="estado" value="">
                            <input type="hidden" name="ordenado" value="">
                            <p style="margin-bottom:10px; text-align:center;"><input type="button" onclick="grabarOrden()" value="Grabar nuevo orden"></p>
                        </form>
                    </div>
                </div>
            </div>
    <?php
}
?>

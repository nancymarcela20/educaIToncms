<div style="text-align:center;">
    <h2>Administraci&oacute;n de informaciones y  m&oacute;dulos</h2>
</div>
<?php
$_mallainicial = 0;
$_tipoinfo = 1;
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
if (isset($_GET['tinfo'])) {
    if ($_GET['tinfo']) {
        $_tipoinfo = $_GET['tinfo'];
    }
}
if (isset($_POST['tinfo'])) {
    if ($_POST['tinfo']) {
        $_tipoinfo = $_POST['tinfo'];
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
                    } elseif ($_GET['msj'] == 16) {
                        echo "<p>La proporci&oacute;n de la imagen debe ser mayor a 2:1</p>";
                    } elseif ($_GET['msj'] == 17) {
                        echo "<p>Ocurri&oacute; un error grabando la imagen que se muestra en la p&aacute;gina principal</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
$_myConfig = new Configuraciones;
$objMenu = new Menus;
$_minwidth = $_myConfig->obtenerMinInfoImage();
$_imagewidth = $_myConfig->obtenerImagesDimensions();
$_myInformaciones = new Informaciones($_tipoinfo);
$_totalregistros = $_myInformaciones->totalInformaciones();
$_enlaces = $_myInformaciones->obtenerPagina($_mallainicial, $_actxpag);
$_esnoticia = $_myInformaciones->obtenerTiposInformaciones($_tipoinfo, 1);
?>

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox(<?php echo $_esnoticia; ?>)">Crear nueva informaci&oacute;n/m&oacute;dulo </button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="informaciones">
        <input type="hidden" name="tipoinformacion" value="<?php echo $_tipoinfo; ?>">
        <input type="hidden" name="accion" value="">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="mallainicial" value="">
        <input type="hidden" name="actxpag" value="">
        <input type="hidden" name="tipoinfo" value="">
        <input type="hidden" name="estado" value="">
    </form>
    <script>
        function estado(_id, _estado, _mallainicial) {
            if (_estado == 1) {
                var texto = "activar";
            } else {
                var texto = "desactivar";
            }
            if (confirm("Va a proceder a " + texto + " un registro de información/módulo") == true) {
                document.forms['acciones'].accion.value = 'infestado';
                document.forms['acciones'].id.value = _id;
                document.forms['acciones'].mallainicial.value = _mallainicial;
                document.forms['acciones'].estado.value = _estado;
                document.forms['acciones'].submit();
            }
        }
        function editar(_id, _mallainicial) {
            document.forms['acciones'].accion.value = 'infeditar';
            document.forms['acciones'].id.value = _id;
            document.forms['acciones'].mallainicial.value = _mallainicial;
            document.forms['acciones'].submit();
        }
        function prepararaddbox(esnoticia) {
            document.forms['annadir'].titulo.value = '';
            if (tinyMCE.get("texto") !== null) {
                largotexto = tinyMCE.get("texto").setContent('');
            }
            if (tinyMCE.get("textomas") !== null) {
                largotexto = tinyMCE.get("textomas").setContent('');
            }
            if (esnoticia == 1) {
                document.forms['annadir'].etiqueta.value = '';
                if (document.getElementById("ImagenActual")) {
                    document.getElementById("ImagenActual").innerHTML = "I";
                }
            } else {
                document.forms['annadir'].wide.value = '';
            }
            document.forms['annadir'].fecha.value = '';
            document.forms['annadir'].accion.value = 'ninformaciones';
            document.forms['annadir'].id.value = 0;
            document.getElementById("tituloaddbox").innerHTML = "Agregar una nueva informaci&oacute;n/m&oacute;dulo";
            openModal('modaladdbox', 1);
        }
        function cambiarpaginacion(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiaitemsxpagina";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].actxpag.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
        function cambiartipoinfo(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiatipoinfo";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].tipoinfo.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
    </script>
    <?php
    if ($_enlaces != 'error') {
        paginador("informaciones", $_mallainicial, $_totalregistros, $_actxpag, "tinfo", $_tipoinfo);
    }
    $_enlaceste = $_myInformaciones->obtenerTiposInformaciones(0);
    filasporpagina($_actxpag, 'tipoinfos', $_enlaceste, $_tipoinfo);
    mallaenlaces($_mallainicial, $_enlaces, $_tipoinfo, $_esnoticia);
    filasporpagina($_actxpag, 'tipoinfos', $_enlaceste, $_tipoinfo);
    if ($_enlaces != 'error') {
        paginador("informaciones", $_mallainicial, $_totalregistros, $_actxpag, "tinfo", $_tipoinfo);
    }
    $_naturaleza = 0;
    $_campos = array();
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'infeditar') {
            $_naturaleza = $_POST['id'];
            $_campos = $_myInformaciones->obtenerCamposXaEdicion($_naturaleza);
        }
    }

    cuadromasenlace($_enlaces, $_naturaleza, $_campos, $_tipoinfo, $_esnoticia, $_imagewidth[0][0], $_imagewidth[0][1], $_minwidth[0][0], $_minwidth[0][1], $objMenu);

    function mallaenlaces($limite_inicial, $_enlaces, $tipoinfo, $_esnoticia) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>&nbsp;</th>
                <th>Id</th>
                <th>T&iacute;tulo</th>
                <?php
                if ($_esnoticia == 1) {
                    ?>
                    <th>Fecha</th>
                    <th>Imagen</th>
                    <th>Texto inicial</th>
                    <?php
                } else {
                    ?>
                    <th>Texto</th>
                    <th>Elemento de men&uacute; asociado</th>
                    <?php
                }
                ?>
                <th>Estado</th>
                </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . "," . $limite_inicial . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar registro\"></a>";
                    if ($_enlaces[$_a][3] == 1) {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0," . $limite_inicial . ")\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    } else {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",1," . $limite_inicial . ")\"><img id=\"acti" . $_a . "\" src=\"rsc/img/activate.png\" onmouseover=\"Myhover('acti" . $_a . "','rsc/img/ractivate.png')\" onmouseout=\"Myhover('acti" . $_a . "','rsc/img/activate.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    }
                    echo "</td>";
                    echo "<td>" . $_enlaces[$_a][0] . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][6]) . "</td>";
                    if ($_esnoticia == 1) {
                        echo "<td>" . $_enlaces[$_a][5] . "</td>";
                        echo "<td class=\"ufps-text-center\">";
                        if ($_enlaces[$_a][7]) {
                            echo "<img src=" . $_enlaces[$_a][7] . " style=\"max-width:150px;\">";
                        } else {
                            echo "&nbsp;";
                        }
                        echo "</td>";
                        echo "<td>" . substr(strip_tags(utf8_encode($_enlaces[$_a][8])), 0, 100) . "</td>";
                    } else {
                        echo "<td>" . substr(strip_tags(utf8_encode($_enlaces[$_a][9])), 0, 100) . "</td>";
                        echo "<td>";
                        if (isset($_enlaces[$_a][11][0][0])) {
                            echo utf8_encode($_enlaces[$_a][11][0][1]);
                        } else {
                            echo "&nbsp;";
                        }
                        echo "</td>";
                    }
                    echo "<td class=\"ufps-text-center\">";
                    if ($_enlaces[$_a][3] == 1) {
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
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de informaciones</h2></div>";
        }
    }

    function cuadromasenlace($_enlaces, $_idedicion, $_campos, $_tipoinfo, $_esnoticia, $_imagewidth, $_imageheight, $_minwidth, $_ratioinfoimages, $objMenu) {
        ?>
        <script>
            function validaractividad(idedicion) {
                var _sinetiqueta = 0;
                largotexto = -1;
                if (document.getElementById("ImagenActual")) {
                    _sinetiqueta = 1;
                }
                if (tinyMCE.get("texto") !== null) {
                    largotexto = tinyMCE.get("texto").getContent().length;
                }
                if (isValidDate(document.forms['annadir'].fecha.value) || _sinetiqueta == 1) {
                    if (document.forms['annadir'].etiqueta.value.length > 0 || _sinetiqueta == 1) {
                        if (document.forms['annadir'].titulo.value.length > 0) {
                            if ((largotexto == -1 && tinyMCE.get("textomas").getContent().length > 0) || largotexto > 0) {
                                var str = tinyMCE.get("textomas").getContent();
                                if (document.forms['annadir'].wide.value > 0) {
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
                                    alert("No puede dejarse en blanco el número de columnas que ocupará la información");
                                }
                            } else {
                                alert("Los campos de texto no pueden quedar vacíos");
                            }
                        } else {
                            alert("La información debe llevar un título");
                        }
                    } else {
                        alert("Debe incluirse una imagen");
                    }
                } else {
                    alert("La fecha no tiene un formato aceptado; el formato es YYYY-MM-DD");
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
                    <!--
                        <div style="gdl-custom-sidebar" id="addbox">
                    -->
                    <!--
                          <div style="text-align:center;">
                    -->
                    <h2 id="tituloaddbox" style="color:#fff;"><?php if ($_idedicion) {
            echo "Editar informaci&oacute;n Id. " . $_idedicion;
        } else {
            echo "Agregar una nueva informaci&oacute;n/m&oacute;dulo";
        } ?></h2>
                    <!--
                          </div>
                    -->
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <!--
                          <div style="margin-left:10px;">
                    -->
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post"<?php if ($_esnoticia) {
            echo " enctype=\"multipart/form-data\"";
        } ?>>
                        <input type="hidden" name="accion" value="ninformaciones">
                        <input type="hidden" name="estado" value="">
                        <input type="hidden" name="conimagen" value="<?php if ($_esnoticia == 1) {
            echo "1";
        } else {
            echo "0";
        } ?>">
                        <input type="hidden" name="tinfo" value="<?php echo $_tipoinfo; ?>">
                        <input type="hidden" name="minwidth" value="<?php echo $_minwidth; ?>">
                        <input type="hidden" name="ratioinfoimages" value="<?php echo $_ratioinfoimages; ?>">
                        <input type="hidden" name="imagewidth" value="<?php echo $_imagewidth; ?>">
                        <input type="hidden" name="imageheight" value="<?php echo $_imageheight; ?>">
                        <?php
                        if ($_idedicion) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $_campos[0]; ?>">
                            <input type="hidden" name="activo" value="<?php if ($_campos[4] == 1) {
                        echo "1";
                    } else {
                        echo "0";
                    } ?>">
                            <?php
                        }
                        if ($_esnoticia == 1) {
                            ?>
                            <p class="pnormal">Fecha de la informaci&oacute;n: <input type="text" class="ufps-input-short ufps-input" name="fecha" id="fecha"<?php if ($_idedicion) {
                                echo " value=\"" . $_campos[5] . "\"";
                            } ?>></p>
                            <input type="hidden" name="wide" value="1">
        <?php
    } else {
        ?>
                            <input type="hidden" name="fecha" value="">
                            <?php
                        }
                        ?>
                        <p class="pnormal">T&iacute;tulo: <input type="text" class="ufps-input-medium ufps-input" name="titulo"<?php if ($_idedicion) {
                            echo " value=\"" . utf8_encode($_campos[6]) . "\"";
                        } ?>></p>
                        <?php
                        if ($_esnoticia == 1) {
                            ?>
                            <p class="pnormal"><?php if ($_idedicion) {
                        echo "<span id=\"ImagenActual\">Imagen actual:<br><img src=\"" . $_campos[7] . "\" style=\"max-height:80px;\"><br><br>Nueva i</span>";
                    } else {
                        echo "I";
                    } ?>magen<?php if ($_minwidth) { ?><span style="font-style:italic;"> (ancho m&iacute;nimo permitido: <?php echo $_minwidth; ?>px; dimensiones recomendadas: <?php echo $_imagewidth; ?>px de ancho o <?php echo $_imageheight; ?>px de alto)</span><?php } ?>:<br><input type="file" name="etiqueta" id="uploadfile"><br>Si es necesario para visualizar en la p&aacute;gina principal, cortar imagen en: <input type="radio" name="crop" value="1" checked> Borde superior <input type="radio" name="crop" value="2"> Centro <input type="radio" name="crop" value="3"> Borde inferior</p>
                            <p class="pnormal" style="margin-top:25px;">Descripci&oacute;n inicial:<br><textarea class="ufps-textarea" id="texto" name="texto"><?php if ($_idedicion) {
                        echo utf8_encode($_campos[9]);
                    } ?></textarea></p>
                            <?php
                        } else {
                            ?>
                            <p class="pnormal">Ancho en columnas: <input type="text" class="ufps-input-number ufps-input-short ufps-input" name="wide"<?php if ($_idedicion) {
                        echo " value=\"" . $_campos[2] . "\"";
                    } ?>></p>
                            <span id="ImagenActual"></span>
                            <input type="hidden" name="etiqueta" value="">
                            <input type="hidden" name="texto" value="">
        <?php
    }
    ?>
                        <p class="pnormal" style="margin-top:25px;"><?php if ($_esnoticia == 1) {
        echo "Ampliaci&oacute;n";
    } else {
        echo "Descripci&oacute;n";
    } ?>:<br><textarea class="ufps-textarea" id="textomas" name="textomas"><?php if ($_idedicion) {
        echo utf8_encode($_campos[10]);
    } ?></textarea></p>
        <?php
        $_enlacesmenu = $objMenu->obtenerElementosMenu();
        if ($_enlacesmenu[0][0] != "error") {
            echo "<p class=\"pnormal\" style=\"margin-top:15px;\">Asociar al siguiente elemento de men&uacute;: ";
            echo "<select name=\"idmenu\">";
            echo "<option value=\"0\">Elija un elemento de men&uacute; asociado a este m&oacute;dulo de informaci&oacute;n</option>";
            for ($_a = 0; $_a < count($_enlacesmenu); $_a++) {
                $_chunk = "";
                if ($_idedicion) {
                    if ($_enlacesmenu[$_a][0] == $_campos[11]) {
                        $_chunk = " selected";
                    }
                }
                echo "<option value=\"" . $_enlacesmenu[$_a][0] . "\"" . $_chunk . ">" . utf8_encode($_enlacesmenu[$_a][1]) . "</option>";
            }
            echo "<option value=\"0\">No asocie ning&uacute;n elemento de men&uacute; a este m&oacute;dulo de informaci&oacute;n</option>";
            echo "</select>";
            echo "</p>";
        }
        ?>
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
?>

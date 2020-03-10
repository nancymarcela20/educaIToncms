<div style="text-align:center;">
    <h2>Administraci&oacute;n de ofertas laborales</h2>
</div>
<?php
$_mallainicial = 0;
$_tipoconvocatoria = 0;
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
if (isset($_GET['tipocionvocatoria'])) {
    if ($_GET['tipoconvocatoria']) {
        $_tipocalendario = $_GET['tipoconvocatoria'];
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
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nueva Oferta laboral</button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="ofertas">
        <input type="hidden" name="accion" value="">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="mallainicial" value="">
        <input type="hidden" name="actxpag" value="">
        <input type="hidden" name="estado" value="">
    </form>
    <script>
        function estado(_id, _estado, _mallainicial) {
            if (_estado == 1) {
                var texto = "activar";
            } else {
                var texto = "desactivar";
            }
            if (confirm("Va a proceder a " + texto + " una oferta laboral") == true) {
                document.forms['acciones'].accion.value = 'ofestado';
                document.forms['acciones'].id.value = _id;
                document.forms['acciones'].mallainicial.value = _mallainicial;
                document.forms['acciones'].estado.value = _estado;
                document.forms['acciones'].submit();
            }
        }
        function editar(_id, _mallainicial) {
            document.forms['acciones'].accion.value = 'ofeditar';
            document.forms['acciones'].id.value = _id;
            document.forms['acciones'].mallainicial.value = _mallainicial;
            document.forms['acciones'].submit();
        }
        function prepararaddbox() {
            document.forms['annadir'].fechini.value = '';
            document.forms['annadir'].fechfin.value = '';
            document.forms['annadir'].cargo.value = '';
            if (tinyMCE.get("descripto") !== null) {
                largotexto = tinyMCE.get("descripto").setContent('');
            }
            if (tinyMCE.get("habilidades") !== null) {
                largotexto = tinyMCE.get("habilidades").setContent('');
            }
            document.forms['annadir'].url.value = '';
            document.forms['annadir'].afuera.checked = false;
            document.forms['annadir'].accion.value = 'noferta';
            document.forms['annadir'].id.value = 0;
            for (var i = 0; i < document.forms['annadir'].elements.length; i++) {
                if (document.forms['annadir'].elements[i].type == 'checkbox') {
                    if (document.forms['annadir'].elements[i].name.substring(0, 3) == 'con') {
                        document.forms['annadir'].elements[i].checked = false;
                    }
                }
            }
            document.getElementById("tituloaddbox").innerHTML = "Agregar una nueva oferta laboral";
            document.getElementById("urlstatus").src = "rsc/img/gray.png";
            openModal('modaladdbox', 1);
        }
        function cambiarpaginacion(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiaitemsxpagina";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].actxpag.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
    </script>
    <?php
    $_myOfertas = new Ofertas($_tipoconvocatoria);
    $_totalregistros = $_myOfertas->totalOfertas();
    $_enlaces = $_myOfertas->obtenerPagina($_mallainicial, $_actxpag);
    if ($_enlaces != 'error') {
        paginador("ofertas", $_mallainicial, $_totalregistros, $_actxpag);
    }
    filasporpagina($_actxpag);
    mallaregistros($_mallainicial, $_enlaces);
    filasporpagina($_actxpag);
    if ($_enlaces != 'error') {
        paginador("ofertas", $_mallainicial, $_totalregistros, $_actxpag);
    }
    $_enlaces = $_myOfertas->obtenerTipoConvocatoria(0);
    $_naturaleza = 0;
    $_campos = array();
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'ofeditar') {
            $_naturaleza = $_POST['id'];
            $_campos = $_myOfertas->obtenerCamposXaEdicion($_naturaleza);
        }
    }
    cuadromasregistro($_enlaces, $_naturaleza, $_campos);

    function mallaregistros($limite_inicial, $_enlaces) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>&nbsp;</th>
                <th>Id</th>
                <th>Fecha inicial</th>
                <th>Fecha final</th>
                <th>Cargo</th>
                <th>Descripci&oacute;n</th>
                <th>Habilidades</th>
                <th>URL destino</th>
                <th>Estado</th>
                </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td class=\"ufps-text-center\"><a href=\"javascript:editar(" . $_enlaces[$_a][0] . "," . $limite_inicial . ")\"><img id=\"edit" . $_a . "\" src=\"rsc/img/edit.png\" onmouseover=\"Myhover('edit" . $_a . "','rsc/img/redit.png')\" onmouseout=\"Myhover('edit" . $_a . "','rsc/img/edit.png')\" style=\"min-width:26px; margin:2px;\" title=\"Editar registro\"></a>";
                    if ($_enlaces[$_a][8] == 1) {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",0," . $limite_inicial . ")\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    } else {
                        echo "<a href=\"javascript:estado(" . $_enlaces[$_a][0] . ",1," . $limite_inicial . ")\"><img id=\"acti" . $_a . "\" src=\"rsc/img/activate.png\" onmouseover=\"Myhover('acti" . $_a . "','rsc/img/ractivate.png')\" onmouseout=\"Myhover('acti" . $_a . "','rsc/img/activate.png')\" style=\"min-width:26px; margin:2px;\" title=\"Cambiar estado del registro\"></a>";
                    }
                    echo "</td>";
                    echo "<td>" . $_enlaces[$_a][0] . "</td>";
                    echo "<td>" . $_enlaces[$_a][1] . "</td>";
                    echo "<td>" . $_enlaces[$_a][2] . "</td>";
                    echo "<td>" . utf8_encode(substr($_enlaces[$_a][3], 0, 60)) . "</td>";
                    echo "<td>" . utf8_encode(substr($_enlaces[$_a][4], 0, 60)) . "</td>";
                    echo "<td>" . utf8_encode(substr($_enlaces[$_a][5], 0, 60)) . "</td>";
                    echo "<td class=\"ufps-text-center\">";
                    if ($_enlaces[$_a][6]) {
//          echo $_enlaces[$_a][6];
                        echo "&nbsp;<a target=\"_blank\" href=\"" . $_enlaces[$_a][6] . "\"><img id=\"open" . $_a . "\" src=\"rsc/img/openlink.png\" onmouseover=\"Myhover('open" . $_a . "','rsc/img/ropenlink.png')\" onmouseout=\"Myhover('open" . $_a . "','rsc/img/openlink.png')\" title=\"Abrir enlace\"></a>";
                    } else {
                        echo "&nbsp;";
                    }
                    echo "</td>";
                    echo "<td class=\"ufps-text-center\">";
                    if ($_enlaces[$_a][8] == 1) {
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
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de ofertas</h2></div>";
        }
    }

    function cuadromasregistro($_enlaces, $_idedicion, $_campos) {
        ?>
        <script>
            function validaractividad(idedicion) {
                var largotexto = 0;
                if (tinyMCE.get("descripto") !== null) {
                    largotexto = tinyMCE.get("descripto").getContent().length;
                }
                if (isValidDate(document.forms['annadir'].fechini.value) && isValidDate(document.forms['annadir'].fechfin.value)) {
                    if (document.forms['annadir'].fechini.value <= document.forms['annadir'].fechfin.value) {
                        if (document.forms['annadir'].cargo.value.length > 0 && largotexto > 0) {
                            var _calendariomarcado = 0;
                            for (var i = 0; i < document.forms['annadir'].elements.length; i++) {
                                if (document.forms['annadir'].elements[i].type == 'checkbox') {
                                    if (document.forms['annadir'].elements[i].name.substring(0, 3) == 'con') {
                                        if (document.forms['annadir'].elements[i].checked == true) {
                                            _calendariomarcado = 1;
                                        }
                                    }
                                }
                            }
                            if (_calendariomarcado == 1) {
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
                                            if (confirm("Va a proceder a actualizar la oferta") == true) {
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
                                alert("Debe asociarse al menos un tipo de convocatoria a la actividad");
                            }
                        } else {
                            alert("La oferta no puede estar en blanco");
                        }
                    } else {
                        alert("La fecha inicial no puede ser posterior a la fecha final");
                    }
                } else {
                    alert("Las fechas no tienen un formato aceptado; el formato es YYYY-MM-DD");
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
            $(function () {
                $("#fechini").datepicker({
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                });
            });
            $(function () {
                $("#fechfin").datepicker({
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
                    <h2 id="tituloaddbox" style="color:#fff;"><?php if ($_idedicion) {
            echo "Editar oferta Id. " . $_idedicion;
        } else {
            echo "Agregar una nueva oferta";
        } ?></h2>
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post">
                        <input type="hidden" name="accion" value="noferta">
                        <input type="hidden" name="estado" value="">
                        <?php
                        if ($_idedicion) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $_campos[0]; ?>">
                            <input type="hidden" name="activo" value="<?php if ($_campos[8] == 1) {
                        echo "1";
                    } else {
                        echo "0";
                    } ?>">
                                <?php
                            }
                            ?>
                        <p class="pnormal">Fecha inicial: <input type="text" class="ufps-input-short ufps-input" name="fechini" id="fechini"<?php if ($_idedicion) {
                            echo " value=\"" . $_campos[1] . "\"";
                        } ?>></p>
                        <p class="pnormal">Fecha final: <input type="text" class="ufps-input-short ufps-input" name="fechfin" id="fechfin"<?php if ($_idedicion) {
                            echo " value=\"" . $_campos[2] . "\"";
                        } ?>> <span style="font-style:italic">(Use la misma fecha inicial para una oferta de duraci&oacute;n indefinida)</span></p>
                        <p class="pnormal">Cargo:<br><textarea class="ufps-textarea" name="cargo"><?php if ($_idedicion) {
                            echo utf8_encode($_campos[3]);
                        } ?></textarea></p>
                        <p class="pnormal">Descripci&oacute;n:<br><textarea class="ufps-textarea" id="descripto" name="descripto"><?php if ($_idedicion) {
                            echo utf8_encode($_campos[4]);
                        } ?></textarea></p>
                        <p class="pnormal" style="margin-top:15px;">Habilidades:<br><textarea class="ufps-textarea" id="habilidades" name="habilidades"><?php if ($_idedicion) {
                            echo utf8_encode($_campos[5]);
                        } ?></textarea></p>
                        <p class="pnormal">URL: <input type="text" class="ufps-input-short ufps-input" name="url" style="width:40%;" onblur="checkurl(document.forms['annadir'].url.value);"<?php if ($_idedicion) {
                            echo " value=\"" . $_campos[6] . "\"";
                        } ?>> <span id="urlresult" style="margin-right:10px;"><img id="urlstatus" src="<?php if ($_idedicion) {
                            if ($_campos[6]) {
                                echo "rsc/img/urlok.png";
                            } else {
                                echo "rsc/img/gray.png";
                            }
                        } else {
                            echo "rsc/img/gray.png";
                        } ?>"></span> <input type="checkbox" name="afuera"<?php if ($_idedicion) {
        if ($_campos[7] == 1) {
            echo " checked";
        }
    } ?>> URL abre en nueva pesta&ntilde;a</p>
                        <p class="pnormal">Convocatorias relacionadas:<br>
    <?php
    if ($_enlaces[0] != 'error') {
        for ($_a = 0; $_a < count($_enlaces); $_a++) {
            echo "<input type=\"checkbox\" name=\"con" . $_a . "\" value=\"" . $_enlaces[$_a][0] . "\" style=\"margin-left:15px;\"";
            if ($_idedicion) {
                for ($_b = 0; $_b < count($_campos[9]); $_b++) {
                    if ($_enlaces[$_a][0] == $_campos[9][$_b]) {
                        echo " checked";
                        break;
                    }
                }
            }
            echo "> " . utf8_encode($_enlaces[$_a][1]) . "<br>";
        }
    } else {
        echo "<p><i>No hay tipos de convocatorias definidas para asociar la actividad</i></p>";
    }
    ?>
                        </p>
                        <div style="text-align:center; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad(<?php echo $_idedicion; ?>)"></div>
                    </form>
                </div>
            </div>
        </div>
    <?php
}
?>

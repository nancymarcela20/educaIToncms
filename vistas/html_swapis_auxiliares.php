<div style="text-align:center;">
    <h2>Manejo de tablas auxiliares</h2>
</div>
<?php
if (!isset($_GET['table'])) {
    $_table = "";
} else {
    $_table = $_GET['table'];
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
                        echo "<p>Ha ocurrido un error actualizando las variables y par&aacute;metros en la base de datos</p>";
                    } elseif ($_GET['msj'] == 2) {
                        echo "<p>Las variables y par&aacute;metros se han actualizado de manera satisfactoria";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    function validaractividad(idedicion) {
        document.forms['showGrid'].accion.value = "guardar";
        document.forms['showGrid'].submit();
    }
    function nuevat() {
        document.forms['showGrid'].submit();
    }
    function estado(fila, objeto, estado) {
        var elem = document.getElementById("fila" + objeto);
        elem.style.display = 'none';
        eval("document.forms['showGrid'].rg" + fila + ".value = 0");
        alert("El registro se borrará efectivamente después de hacer clic en el botón Enviar");
    }
    $(function () {
        $("#id_").datepicker({
            changeYear: true,
            dateFormat: "yy-mm-dd",
            dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
        });
    });
    $(function () {
        $(".fechafestivo").datepicker({
            changeYear: true,
            dateFormat: "yy-mm-dd",
            dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
        });
    });
    $(function () {
        $(".colorcalendario").colorpicker({
            defaultPalette: 'web',
            strings: "Colores del tema,Colores base,Más colores,Colores web,Paleta,Historial,No hay historial."
        });
    });
    $(function () {
        $("#coloradd").colorpicker({
            defaultPalette: 'web',
            strings: "Colores del tema,Colores base,Más colores,Colores web,Paleta,Historial,No hay historial."
        });
    });
</script>
<div style="clear:both; width:95%; margin:auto;">
    <form name="showGrid" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="auxiliares">
        <input type="hidden" name="accion" value="nuevatabla">
        <?php
        $_myAuxiliares = new Auxiliares();
        $_enlaces = $_myAuxiliares->obtenerAuxiliares();
        if ($_enlaces[0] != 'error') {
            if (!$_table) {
                $_table = $_enlaces[0];
            }
            echo "<p>Elija la tabla de trabajo: <select name=\"table\" onchange=\"nuevat();\">";
            for ($_a = 0; $_a < count($_enlaces); $_a++) {
                $chunk = "";
                if ($_enlaces[$_a] == $_table) {
                    $chunk = " selected";
                }
                echo "<option value=\"" . $_enlaces[$_a] . "\"" . $chunk . ">" . $_enlaces[$_a] . "</option>";
            }
            echo "</select>";
            $_registrostabla = $_myAuxiliares->obtenerRegistros($_table);
            echo "<input type=\"hidden\" name=\"nregistros\" value=\"" . count($_registrostabla) . "\">";
            mallaregistros($_table, $_registrostabla);
            ?>
            <div style="text-align:center; margin-top:15px; margin-bottom:10px;">
                <input type="button" value="Enviar" onclick="validaractividad()"> &nbsp; &nbsp; <input type="button" value="Deshacer cambios" onclick="location.reload()">
            </div>
            <?php
        } else {
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">Error obteniendo las tablas auxiliares de la base de datos</h2></div>";
        }
        ?>
    </form>
</div>
<?php

function mallaregistros($tabla, $_registros) {

    if ($_registros[0] != "error") {
        ?>
        <table class="ufps-table-narrow ufps-table" style="width:95%; margin:auto;">
            <thead style="background-color:#ddd;">
            <td>&nbsp;</td>
            <?php
            switch ($tabla) {
                case 'tipoconvocatorias': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Color</th>
                        <th>Activo</th>
                        <th>Visible</th>
                        <th>Orden</th>
                        <?php
                        break;
                    }
                case 'tipocalendarios': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Color</th>
                        <th>Activo</th>
                        <th>Visible</th>
                        <th>Transversal</th>
                        <th>Orden</th>
                        <?php
                        break;
                    }
                case 'tipoenlaces': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Alto de imagen</th>
                        <?php
                        break;
                    }
                case 'tipogalerias': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Activo</th>
                        <th>Orden</th>
                        <?php
                        break;
                    }
                case 'tipoinformaciones': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Es novedad</th>
                        <th>Activo</th>
                        <th>Orden</th>
                        <?php
                        break;
                    }
                case 'tiporedessociales': {
                        ?>
                        <th>Id</th>
                        <th>Etiqueta</th>
                        <th>Clase en DIV flotante</th>
                        <th>Clase en pie de p&aacute;gina</th>
                        <?php
                        break;
                    }
                case 'tipousuarios': {
                        ?>
                        <th>Id</th>
                        <th>Descripci&oacute;n</th>
                        <th>Puede agregar</th>
                        <th>Puede autorizar</th>
                        <th>Puede cambiar</th>
                        <th>Puede borrar</th>
                        <?php
                        break;
                    }
                case 'tipofestivos': {
                        ?>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Descripci&oacute;n</th>
                        <?php
                        break;
                    }
            }
            ?>
        </thead>
        <tbody>
            <?php
            for ($_a = 0; $_a < count($_registros); $_a++) {
                echo "<tr id=\"fila" . $_registros[$_a]['id'] . "\">";
                echo "<input type=\"hidden\" name=\"rg" . $_a . "\" value=\"1\">";
                echo "<input type=\"hidden\" name=\"idrg" . $_a . "\" value=\"" . $_registros[$_a]['id'] . "\">";
                echo "<td><a href=\"javascript:estado(" . $_a . ",'" . $_registros[$_a]['id'] . "',0)\"><img id=\"dele" . $_a . "\" src=\"rsc/img/delete.png\" onmouseover=\"Myhover('dele" . $_a . "','rsc/img/rdelete.png')\" onmouseout=\"Myhover('dele" . $_a . "','rsc/img/delete.png')\" style=\"min-width:26px; margin:2px;\" title=\"Borrar registro\"></a></td>";
                switch ($tabla) {
                    case 'tipoconvocatorias': {
                            ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"color" . $_a . "\" type=\"text\" class=\"colorcalendario ufps-input-xshort ufps-input\" value=\"" . utf8_encode($_registros[$_a]['color']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"activo" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['activo'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"visible" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['visible'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"orden" . $_a . "\" type=\"text\" class=\"ufps-input-number ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['orden']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tipocalendarios': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"color" . $_a . "\" type=\"text\" class=\"colorcalendario ufps-input-xshort ufps-input\" value=\"" . utf8_encode($_registros[$_a]['color']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"activo" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['activo'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"visible" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['visible'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"transversal" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['transversal'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"orden" . $_a . "\" type=\"text\" class=\"ufps-input-number ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['orden']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tipoenlaces': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"altoimagen" . $_a . "\" type=\"text\" class=\"ufps-input-number ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['imgheight']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tipogalerias': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"activo" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['activo'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"orden" . $_a . "\" type=\"text\" class=\"ufps-input-number ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['orden']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tipoinformaciones': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"esnoticia" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['esnoticia'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"activo" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['activo'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"orden" . $_a . "\" type=\"text\" class=\"ufps-input-number ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['orden']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tiporedessociales': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"etiqueta" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['etiqueta']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"clasefloat" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['clasefloat']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"clasefooter" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['clasefooter']) . "\""; ?>></td>
                        <?php
                        break;
                    }
                case 'tipousuarios': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"puedeagregar" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['puedeagregar'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"puedeautorizar" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['puedeautorizar'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"puedecambiar" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['puedecambiar'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"puedeborrar" . $_a . "\" type=\"checkbox\"";
                        if ($_registros[$_a]['puedeborrar'] == 1) {
                            echo " checked";
                        } echo ">"; ?></td>
                        <?php
                        break;
                    }
                case 'tipofestivos': {
                        ?>
                        <td class="ufps-text-center"><?php echo $_registros[$_a]['id']; ?></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"id" . $_a . "\" type=\"text\" class=\"fechafestivo ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['id']) . "\""; ?>></td>
                        <td class="ufps-text-center"><?php echo "<input name=\"descripcion" . $_a . "\" type=\"text\" class=\"ufps-input-short ufps-input\" value=\"" . utf8_encode($_registros[$_a]['descripcion']) . "\""; ?>></td>
                        <?php
                        break;
                    }
            }
            echo "</tr>";
        }
        echo "<tr style=\"background-color:#cca0a0\">";
        echo "<td>&nbsp;</td>";
        switch ($tabla) {
            case 'tipoconvocatorias': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input id="coloradd" name="color_" type="text" class="ufps-input-xshort ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="activo_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="visible_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="orden_" type="text" class="ufps-input-number ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tipocalendarios': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input id="coloradd" name="color_" type="text" class="ufps-input-xshort ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="activo_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="visible_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="transversal_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="orden_" type="text" class="ufps-input-number ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tipoenlaces': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="altoimagen_" type="text" class="ufps-input-number ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tipogalerias': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="activo_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="orden_" type="text" class="ufps-input-number ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tipoinformaciones': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="esnoticia_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="activo_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="orden_" type="text" class="ufps-input-number ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tiporedessociales': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="etiqueta_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="clasefloat_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="clasefooter_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
            case 'tipousuarios': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="puedeagregar_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="puedeautorizar_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="puedecambiar_" type="checkbox"></td>
                    <td class="ufps-text-center"><input name="puedeborrar_" type="checkbox"></td>
                    <?php
                    break;
                }
            case 'tipofestivos': {
                    ?>
                    <td class="ufps-text-center">&nbsp;</td>
                    <td class="ufps-text-center"><input id="id_" name="id_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <td class="ufps-text-center"><input name="descripcion_" type="text" class="ufps-input-short ufps-input" value=""></td>
                    <?php
                    break;
                }
        }
        echo "</tr>";
        ?>
        </tbody>
        </table>
        <?php
        if ($tabla == 'tiporedessociales') {
            ?>
            <div style="margin:auto; text-align:center;"><p><a href="http://fontawesome.io/icons/" target="_blank">Iconos de la fuente Awesome para clase en pie de p&aacute;gina</a> &nbsp; &nbsp; <a href="./rsc/img/icons/social" target="_blank">Iconos de redes sociales del CSS para clase en DIV flotante</a></p></div>
            <?php
        }
    }
}
?>

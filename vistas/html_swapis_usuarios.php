<div style="text-align:center;">
    <h2>Administraci&oacute;n de usuarios</h2>
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
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="prepararaddbox()">Crear nuevo Usuario</button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="usuarios">
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
            if (confirm("Va a proceder a " + texto + " un usuario") == true) {
                document.forms['acciones'].accion.value = 'usestado';
                document.forms['acciones'].id.value = _id;
                document.forms['acciones'].mallainicial.value = _mallainicial;
                document.forms['acciones'].estado.value = _estado;
                document.forms['acciones'].submit();
            }
        }
        function editar(_id, _mallainicial) {
            document.forms['acciones'].accion.value = 'useditar';
            document.forms['acciones'].id.value = _id;
            document.forms['acciones'].mallainicial.value = _mallainicial;
            document.forms['acciones'].submit();
        }
        function prepararaddbox() {
            document.forms['annadir'].usuario.value = '';
            document.forms['annadir'].apellidos.value = '';
            document.forms['annadir'].nombres.value = '';
            document.forms['annadir'].emilio.value = '';
            document.forms['annadir'].accion.value = 'nusuario';
            document.forms['annadir'].id.value = 0;
            document.getElementById("tituloaddbox").innerHTML = "Agregar un nuevo usuario";
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
    $_myUsuario = new Usuario();
    $_totalregistros = $_myUsuario->totalUsuarios();
    $_enlaces = $_myUsuario->obtenerPagina($_mallainicial, $_actxpag);
    if ($_enlaces != 'error') {
        paginador("usuarios", $_mallainicial, $_totalregistros, $_actxpag);
    }
    filasporpagina($_actxpag);
    mallausuarios($_mallainicial, $_enlaces);
    filasporpagina($_actxpag);
    if ($_enlaces != 'error') {
        paginador("usuarios", $_mallainicial, $_totalregistros, $_actxpag);
    }
    $_naturaleza = 0;
    $_campos = array();
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'useditar') {
            $_naturaleza = $_POST['id'];
            $_campos = $_myUsuario->obtenerCamposXaEdicion($_naturaleza);
        }
    }
    cuadromasusuario($_enlaces, $_naturaleza, $_campos, $_myUsuario->obtenerTiposUsuario());

    function mallausuarios($limite_inicial, $_enlaces) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>&nbsp;</th>
                <th>Id</th>
                <th>Tipo de usuario</th>
                <th>Nombre de usuario</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Correo electr&oacute;nico</th>
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
                    echo "<td>" . utf8_encode($_enlaces[$_a][2]) . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][4]) . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][5]) . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][6]) . "</td>";
                    echo "<td>" . utf8_encode($_enlaces[$_a][7]) . "</td>";
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
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de usuarios</h2></div>";
        }
    }

    function cuadromasusuario($_enlaces, $_idedicion, $_campos, $_tiposusuario) {
        ?>
        <script>
            function validaractividad(idedicion) {
                if (document.forms['annadir'].usuario.value.length > 0 && document.forms['annadir'].apellidos.value.length > 0 && document.forms['annadir'].nombres.value.length > 0 && document.forms['annadir'].emilio.value.length > 0) {
                    if (isValidEmilio(document.forms['annadir'].emilio.value)) {
                        if (document.forms['annadir'].usuario.value.indexOf(" ") === -1) {
                            if (document.forms['annadir'].id.value > 0) {
                                if (idedicion > 0) {
                                    document.forms['annadir'].estado.value = 'edicion';
                                    if (confirm("Va a proceder a actualizar el usuario") == true) {
                                        document.forms['annadir'].submit();
                                    }
                                } else {
                                    document.forms['annadir'].submit();
                                }
                            } else {
                                document.forms['annadir'].submit();
                            }
                        } else {
                            alert("El nombre de usuario no puede contener espacios en blanco");
                        }
                    } else {
                        alert("El correo electrónico debe tener una estructura válida");
                    }
                } else {
                    alert("Todos los campos son obligatorios");
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
            echo "Editar usuario Id. " . $_idedicion;
        } else {
            echo "Agregar un nuevo usuario";
        } ?></h2>
                    <!--
                          </div>
                    -->
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <!--
                          <div style="margin-left:10px;">
                    -->
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post">
                        <input type="hidden" name="accion" value="nperfil">
                        <input type="hidden" name="estado" value="">
                        <input type="hidden" name="conimagen" value="0">
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
                        <p class="pnormal">Nombre de usuario: <input type="text" class="ufps-input-short ufps-input" name="usuario" style="width:40%;"<?php if ($_idedicion) {
                                echo " value=\"" . utf8_encode($_campos[3]) . "\"";
                            } ?>></p>
                        <p class="pnormal">Tipo de usuario: <select name="tipousuario" style="min-height:30px;"><?php
                                if ($_tiposusuario[0] != "error") {
                                    for ($_a = 0; $_a < count($_tiposusuario); $_a++) {
                                        $_chunk = "";
                                        if ($_idedicion) {
                                            if ($_campos[1] == $_tiposusuario[$_a][0]) {
                                                $_chunk = " selected";
                                            }
                                        }
                                        echo "<option value=\"" . $_tiposusuario[$_a][0] . "\"" . $_chunk . ">" . utf8_encode($_tiposusuario[$_a][1]) . "</option>";
                                    }
                                } else {
                                    echo "<option value=\"0\">No hay tipos de usuario definidos</option>";
                                }
                                echo "</select>";
                                ?></p>
                        <p class="pnormal">Apellidos: <input type="text" class="ufps-input-short ufps-input" name="apellidos" style="width:40%;"<?php if ($_idedicion) {
                                    echo " value=\"" . utf8_encode($_campos[4]) . "\"";
                                } ?>></p>
                        <p class="pnormal">Nombres: <input type="text" class="ufps-input-short ufps-input" name="nombres" style="width:40%;"<?php if ($_idedicion) {
                                    echo " value=\"" . utf8_encode($_campos[5]) . "\"";
                                } ?>></p>
                        <p class="pnormal">Correo electr&oacute;nico: <input type="text" class="ufps-input-short ufps-input" name="emilio" style="width:40%;"<?php if ($_idedicion) {
        echo " value=\"" . utf8_encode($_campos[6]) . "\"";
    } ?>></p>
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
?>

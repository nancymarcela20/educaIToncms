<div style="text-align:center;">
    <h2>Registro de visitantes</h2>
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

<div style="float:right; margin-right:30px; margin-bottom:30px;"><button class="ufps-btn" onclick="report()">Descargar informe</button></div>
<div style="clear:both;">

    <form name="acciones" method="post" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
        <input type="hidden" name="modulo" value="visitantes">
        <input type="hidden" name="accion" value="">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="mallainicial" value="">
        <input type="hidden" name="actxpag" value="">
        <input type="hidden" name="estado" value="">
    </form>
    <script>
        function report() {
            document.forms['annadir'].fechini.value = '';
            document.forms['annadir'].fechfin.value = '';
            openModal('modalreport', 1);
        }
        function cambiarpaginacion(_nuevovalor) {
            document.forms['acciones'].accion.value = "cambiaitemsxpagina";
            document.forms['acciones'].mallainicial.value = 0;
            document.forms['acciones'].actxpag.value = _nuevovalor;
            document.forms['acciones'].submit();
        }
    </script>
    <?php
    $_myUsuario = new Visitantes();
    $_totalregistros = $_myUsuario->totalVisitantes();
    $_enlaces = $_myUsuario->obtenerPagina($_mallainicial, $_actxpag);
    if ($_enlaces != 'error') {
        paginador("visitantes", $_mallainicial, $_totalregistros, $_actxpag);
    }
    filasporpagina($_actxpag);
    mallavisitantes($_mallainicial, $_enlaces);
    filasporpagina($_actxpag);
    if ($_enlaces != 'error') {
        paginador("visitantes", $_mallainicial, $_totalregistros, $_actxpag);
    }

    cuadroreportevisitantes();

    function mallavisitantes($limite_inicial, $_enlaces) {
        if ($_enlaces[0] != "error") {
            ?>
            <table class="ufps-table-narrow ufps-table ufps-table-inserted" style="width:95%; margin:auto;">
                <thead>
                <th>Fecha</th>
                <th>IP del cliente</th>
                <th>IP detr&aacute;s del proxy</th>
                </thead>
                <?php
                for ($_a = 0; $_a < count($_enlaces); $_a++) {
                    echo "<tr>";
                    echo "<td>" . $_enlaces[$_a][0] . "</td>";
                    echo "<td>" . $_enlaces[$_a][1] . "</td>";
                    echo "<td>" . $_enlaces[$_a][2] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        } else {
            echo "<div style=\"clear:both; text-align:center;\"><h2 style=\"color:red;\">No hay registros en la tabla de visitantes</h2></div>";
        }
    }

    function cuadroreportevisitantes() {
        ?>
        <script>
            function validaractividad(idedicion) {
                if (isValidDate(document.forms['annadir'].fechini.value) && isValidDate(document.forms['annadir'].fechfin.value)) {
                    if (document.forms['annadir'].fechini.value <= document.forms['annadir'].fechfin.value) {
                        document.forms['annadir'].submit();
                    } else {
                        alert("La fecha inicial no puede ser posterior a la fecha final");
                    }
                } else {
                    alert("Las fechas no tienen un formato aceptado; el formato es YYYY-MM-DD");
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
        <div id="modalreport" class="ufps-modal" style="padding-top:50px;">
            <div class="ufps-modal-content">
                <div class="ufps-modal-header ufps-modal-header-red">
                    <span class="ufps-modal-close">&times;</span>
                    <h2 id="tituloaddbox" style="color:#fff;">Reporte de visitantes</h2>
                </div>
                <div class="ufps-modal-body" style="background-color: #cecece;">
                    <form name="annadir" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post">
                        <input type="hidden" name="modulo" value="visitantes">
                        <input type="hidden" name="accion" value="reporte">

                        <p class="pnormal">Fecha inicial: <input type="text" class="ufps-input-short ufps-input" name="fechini" id="fechini"></p>
                        <p class="pnormal">Fecha final: <input type="text" class="ufps-input-short ufps-input" name="fechfin" id="fechfin"></p>
                        <div style="text-align:center; margin-top:25px; margin-bottom:10px;"><input type="button" value="Enviar" onclick="validaractividad()"></div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

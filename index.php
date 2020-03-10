<?php

include ("controladores/funciones.php");
include ("modelos/modelo.php");
if (isset($_GET['ajax'])) {
    switch ($_GET['ajax']) {
        case 'calendarios': {
                include ("vistas/html_calendario.php");
                break;
            }
        case 'galerias': {
                include ("vistas/html_enlagaleria.php");
                break;
            }
        case 'informaciones': {
                include ("vistas/html_informaciones.php");
                break;
            }
        case 'noticias': {
                include ("vistas/html_noticias.php");
                break;
            }
        case 'proximas': {
                $_parametroP = $_GET['posicion'];
                include ("vistas/html_proximas.php");
                break;
            }
        case 'ofertas': {
                include ("vistas/html_ofertas.php");
                break;
            }
        default: {
                include ("vistas/html_wrapper.php");
            }
    }
} else {
    include ("vistas/html_wrapper.php");
}
?>


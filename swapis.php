<?php
session_name("swapis");
session_start();
include ("modelos/modelo.php");
include ("controladores/funciones.php");
$_modulo = "";
$_null = 0;
if (isset($_GET['modulo'])) {
    $_modulo = $_GET['modulo'];
}
if (isset($_POST['modulo'])) {
    $_modulo = $_POST['modulo'];
}
if (isset($_POST['accion'])) {
    $preget_info = "";
    foreach ($_GET AS $key => $value) {
        if ($key != "msj") {
            $preget_info .= "&" . $key . "=" . $value;
        }
    }
    switch ($_modulo) {
        case "": {
                $_redirect = 1;
                if ($_POST['accion'] == 'login') {
                    $_badlogin = 1;
                    require_once 'controladores/PkcsKeyGenerator.php';
                    require_once 'controladores/DesEncryptor.php';
                    require_once 'controladores/PbeWithMd5AndDes.php';
                    require_once 'controladores/PBEParameters.php';
                    $_myUsuario = new Usuario();
                    $_myUsuario->obtenerUsuario($_POST['usuario']);
                    $_respuesta = PbeWithMd5AndDes::encrypt(
                                    $_POST['clave'], $keystring, $salt, $iterations, $segments
                    );
                    if ($_respuesta == $_myUsuario->clave) {
                        $_SESSION['usuario'] = $_POST['usuario'];
                        $_SESSION['idusuario'] = $_myUsuario->id;
                        $_SESSION['apellidos'] = utf8_encode($_myUsuario->apellidos);
                        $_SESSION['nombres'] = utf8_encode($_myUsuario->nombres);
                        $_badlogin = 0;
                    }
                } elseif ($_POST['accion'] == 'logout') {
                    $_badlogin = 2;
                    session_destroy();
                    unset($_SESSION);
                } elseif ($_POST['accion'] == 'changepw') {
                    $_SESSION['flag'] = 1;
                    $_badlogin = 1;
                    if (isset($_SESSION['usuario'])) {
                        if ($_SESSION['usuario']) {
                            require_once 'controladores/PkcsKeyGenerator.php';
                            require_once 'controladores/DesEncryptor.php';
                            require_once 'controladores/PbeWithMd5AndDes.php';
                            require_once 'controladores/PBEParameters.php';
                            $_myUsuario = new Usuario();
                            $_myUsuario->obtenerUsuario($_SESSION['usuario']);
                            $_respuesta = PbeWithMd5AndDes::encrypt(
                                            $_POST['pass'], $keystring, $salt, $iterations, $segments
                            );
                            if ($_respuesta == $_myUsuario->clave) {
                                if ($_POST['npassc'] == $_POST['npass']) {
                                    $_nrespuesta = PbeWithMd5AndDes::encrypt(
                                                    $_POST['npass'], $keystring, $salt, $iterations, $segments
                                    );
                                    $_badlogin = $_myUsuario->grabarPassword($_nrespuesta);
                                }
                            }
                        }
                    }
                }
                if ($_badlogin != 0) {
                    $get_info = "msj=" . $_badlogin;
                }
                break;
            }
        case "ofertas": {
                if ($_POST['accion'] == 'noferta') {
                    $_convocatorias = array();
                    $_oferta = new Ofertas(0);
                    foreach ($_POST as $clave => $valor) {
                        if (substr($clave, 0, 3) == 'con') {
                            array_push($_convocatorias, $valor);
                        }
                    }
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    $_msj = $_oferta->nuevaOferta($_POST['fechini'], $_POST['fechfin'], $_POST['descripto'], $_POST['url'], $_POST['afuera'], $_convocatorias, $_POST['estado'], $_POST['id'], $_POST['cargo'], $_POST['habilidades'], $_SESSION['idusuario']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'ofestado') {
                    $_oferta = new Ofertas(0);
                    $_msj = $_oferta->estadoOferta($_POST['id'], $_POST['estado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'ofeditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                }
                break;
            }
        case "calendario": {
                if ($_POST['accion'] == 'nactividad') {
                    $_calendarios = array();
                    $_actividad = new Actividades(0);
                    foreach ($_POST as $clave => $valor) {
                        if (substr($clave, 0, 3) == 'cal') {
                            array_push($_calendarios, $valor);
                        }
                    }
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    $_msj = $_actividad->nuevaActividad($_POST['fechini'], $_POST['fechfin'], $_POST['descripto'], $_POST['url'], $_POST['afuera'], $_calendarios, $_POST['estado'], $_POST['id'], $_SESSION['idusuario']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'acestado') {
                    $_actividad = new Actividades(0);
                    $_msj = $_actividad->estadoActividad($_POST['id'], $_POST['estado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'aceditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                }
                break;
            }
        case "enlaces": {
                if ($_POST['accion'] == 'nenlace') {
                    $_actividad = new Enlaces(0);
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    $_sincambio = 0;
                    if ($_POST['estado'] == 'edicion') {
                        if ($_POST['conimagen'] == 1) {
                            if (!$_FILES['etiqueta']['name']) {
                                $_sincambio = 1;
                            }
                        }
                    }
                    if (!isset($_POST['idmodulo'])) {
                        $_POST['idmodulo'] = "";
                    }
                    $_msj = 0;
                    if (isset($_FILES['etiqueta']['name'])) {
                        if ($_FILES['etiqueta']['name']) {
                            $target_dir = "../rsceducaiton/img/";
                            $target_file = $target_dir . basename($_FILES['etiqueta']['name']);
                            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                            $check = getimagesize($_FILES['etiqueta']['tmp_name']);
                            if ($check !== false) {
                                if ($check[1] != $_POST['maxheight']) {
                                    if ($check[1] < $_POST['maxheight']) {
                                        $_msj = 11;
                                    } else {
                                        if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                            $_newwidth = $check[0] * $_POST['maxheight'] / $check[1];
                                            $nimage = imagecreatetruecolor($_newwidth, $_POST['maxheight']);
                                            if ($imageFileType == 'jpeg' || $imageFileType == 'jpg') {
                                                $image = imagecreatefromjpeg($target_file);
                                            } elseif ($imageFileType == 'gif') {
                                                $image = imagecreatefromgif($target_file);
                                            } elseif ($imageFileType == 'png') {
                                                $image = imagecreatefrompng($target_file);
                                            } else {
                                                unlink($target_file);
                                                $_msj = 14;
                                            }
                                            if ($_msj == 0) {
                                                if (imagecopyresampled($nimage, $image, 0, 0, 0, 0, $_newwidth, $_POST['maxheight'], $check[0], $check[1]) == true) {
                                                    imagejpeg($nimage, $target_file, 95);
                                                    $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                                } else {
                                                    $_msj = 12;
                                                }
                                            }
                                        } else {
                                            $_msj = 13;
                                        }
                                    }
                                } else {
                                    if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                        $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                    } else {
                                        $_msj = 13;
                                    }
                                }
                            } else {
                                $_msj = 10;
                            }
                        }
                    }
                    if ($_msj == 0) {
                        $_msj = $_actividad->nuevaEnlace($_POST['etiqueta'], $_POST['url'], $_POST['afuera'], $_POST['estado'], $_POST['id'], $_POST['tenla'], $_SESSION['idusuario'], $_sincambio, $_POST['idmodulo']);
                    }
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'enestado') {
                    $_actividad = new Enlaces($_POST['tipoenlace']);
                    $_msj = $_actividad->estadoEnlace($_POST['id'], $_POST['estado']);
                    $_actividad->Reordenar();
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'eneditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'cambiatipoenlace') {
                    $get_info = "";
                    $_tenla = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "tenla") {
                            $_tenla = 1;
                            $get_info .= "&" . $key . "=" . $_POST['tipoenla'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_tenla == 0) {
                        $get_info .= "&tenla=" . $_POST['tipoenla'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'enordenar') {
                    $_actividad = new Enlaces($_POST['tenla']);
                    $_msj = $_actividad->grabarNuevoOrden($_POST['ordenado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                }
                break;
            }
        case "configuracion": {
                if ($_POST['accion'] == 'actualizar') {
                    $_configuracion = new Configuraciones();
                    $_msj = $_configuracion->grabarVariables($_POST['descripto'], $_POST['maxwidth'], $_POST['minwidth'], $_POST['sliderwidth'], $_POST['sliderheight'], $_POST['maxheight'], $_POST['routetofileman'], $_POST['mininfowidth'], $_POST['ratioinfoimages'], $_POST['widthgallerythumb']);
                    if ($_myjson = fopen($_POST['routetofileman'] . "/conf.json", "r")) {
                        $_lineas = fread($_myjson, 2048);
                        fclose($_myjson);
                        if ($cadalinea = explode("\n", $_lineas)) {
                            $newfile = "";
                            for ($_a = 0; $_a < count($cadalinea); $_a++) {
                                if (substr($cadalinea[$_a], 1, 12) == "MAX_IMAGE_WI") {
                                    $cadalinea[$_a] = "\"MAX_IMAGE_WIDTH\":     \"" . $_POST['maxwidth'] . "\",";
                                } elseif (substr($cadalinea[$_a], 1, 12) == "MAX_IMAGE_HE") {
                                    $cadalinea[$_a] = "\"MAX_IMAGE_HEIGHT\":    \"" . $_POST['maxheight'] . "\",";
                                }
                                if (strlen($cadalinea[$_a]) > 0) {
                                    $newfile .= $cadalinea[$_a] . "\n";
                                }
                            }
                        }
                        if ($_myjson = fopen($_POST['routetofileman'] . "/conf.json", "w")) {
                            fwrite($_myjson, $newfile);
                            fclose($_myjson);
                        }
                    }
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                }
                break;
            }
        case "slider": {
                if ($_POST['accion'] == 'nimagenrot') {
                    $_actividad = new Slides;
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    $_sincambio = 0;
                    if ($_POST['estado'] == 'edicion') {
                        if ($_POST['conimagen'] == 1) {
                            if (!$_FILES['etiqueta']['name']) {
                                $_sincambio = 1;
                            }
                        }
                    }
                    if (!isset($_POST['idmodulo'])) {
                        $_POST['idmodulo'] = "";
                    }
                    $_msj = 0;
                    if ($_FILES['etiqueta']['name']) {
                        $target_dir = "../rsceducaiton/img/";
                        $target_file = $target_dir . basename($_FILES['etiqueta']['name']);
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $check = getimagesize($_FILES['etiqueta']['tmp_name']);
                        if ($check !== false) {
                            if ($_POST['sliderwidth'] / $_POST['sliderheight'] >= $check[0] / $check[1]) {
                                if ($check[0] != $_POST['sliderwidth']) {
                                    if ($check[0] < $_POST['minwidth']) {
                                        $_msj = 11;
                                    } else {
                                        if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                            $_newheight = $check[1] * $_POST['sliderwidth'] / $check[0];
                                            $nimage = imagecreatetruecolor($_POST['sliderwidth'], $_POST['sliderheight']);
                                            if ($imageFileType == 'jpeg' || $imageFileType == 'jpg') {
                                                $image = imagecreatefromjpeg($target_file);
                                            } elseif ($imageFileType == 'gif') {
                                                $image = imagecreatefromgif($target_file);
                                            } elseif ($imageFileType == 'png') {
                                                $image = imagecreatefrompng($target_file);
                                            } else {
                                                unlink($target_file);
                                                $_msj = 14;
                                            }
                                            if ($_msj == 0) {
                                                if ($_POST['crop'] == 1) {
                                                    $_crop = 0;
                                                } elseif ($_POST['crop'] == 2) {
                                                    $_crop = ($check[1] - $_POST['sliderheight'] * $check[0] / $_POST['sliderwidth']) / 2 - 1;
                                                } elseif ($_POST['crop'] == 3) {
                                                    $_crop = $check[1] - $_POST['sliderheight'] * $check[0] / $_POST['sliderwidth'] - 1;
                                                }
                                                if (imagecopyresampled($nimage, $image, 0, 0, 0, $_crop, $_POST['sliderwidth'], $_POST['sliderheight'], $check[0], $_POST['sliderheight'] * $check[0] / $_POST['sliderwidth']) == true) {
                                                    imagejpeg($nimage, $target_file, 95);
                                                    $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                                } else {
                                                    $_msj = 12;
                                                }
                                            }
                                        } else {
                                            $_msj = 13;
                                        }
                                    }
                                } else {
                                    if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                        $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                    } else {
                                        $_msj = 13;
                                    }
                                }
                            } else {
                                $_msj = 15;
                            }
                        } else {
                            $_msj = 10;
                        }
                    }
                    if ($_msj == 0) {
                        $_msj = $_actividad->nuevaSlider($_POST['etiqueta'], $_POST['titulo'], $_POST['texto'], $_POST['url'], $_POST['afuera'], $_POST['estado'], $_POST['id'], $_SESSION['idusuario'], $_sincambio, $_POST['idmodulo']);
                    }
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'irestado') {
                    $_actividad = new Slides;
                    $_msj = $_actividad->estadoImagenRot($_POST['id'], $_POST['estado']);
                    $_actividad->Reordenar();
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'ireditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'irordenar') {
                    $_actividad = new Slides;
                    $_msj = $_actividad->grabarNuevoOrden($_POST['ordenado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                }
                break;
            }
        case "informaciones": {
                if ($_POST['accion'] == 'ninformaciones') {
                    $_actividad = new Informaciones(0);
                    $_POST['clippd'] = "";
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    if (!isset($_POST['idmenu'])) {
                        $_POST['idmenu'] = 0;
                    }
                    $_sincambio = 0;
                    if ($_POST['estado'] == 'edicion') {
                        if ($_POST['conimagen'] == 1) {
                            if (!$_FILES['etiqueta']['name']) {
                                $_sincambio = 1;
                            }
                        } else {
                            $_FILES['etiqueta']['name'] = "";
                        }
                    }
                    $_msj = 0;
                    if ($_FILES['etiqueta']['name']) {
                        $target_dir = "../rsceducaiton/img/";
                        $target_file = $target_dir . basename($_FILES['etiqueta']['name']);
                        $clipped_file = $target_dir . "clp_" . basename($_FILES['etiqueta']['name']);
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $check = getimagesize($_FILES['etiqueta']['tmp_name']);
                        if ($check !== false) {
                            if ($check[0] != $_POST['imagewidth']) {
                                if ($check[0] < $_POST['minwidth']) {
                                    $_msj = 11;
                                } else {
                                    if ($check[0] / $check[1] <= $_POST['ratioinfoimages']) {
                                        if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                            $_newheight = $check[1] * $_POST['imagewidth'] / $check[0];
                                            $nimage = imagecreatetruecolor($_POST['imagewidth'], $_newheight);
                                            if ($imageFileType == 'jpeg' || $imageFileType == 'jpg') {
                                                $image = imagecreatefromjpeg($target_file);
                                            } elseif ($imageFileType == 'gif') {
                                                $image = imagecreatefromgif($target_file);
                                            } elseif ($imageFileType == 'png') {
                                                $image = imagecreatefrompng($target_file);
                                            } else {
                                                unlink($target_file);
                                                $_msj = 14;
                                            }
                                            if ($_msj == 0) {
                                                if (imagecopyresampled($nimage, $image, 0, 0, 0, 0, $_POST['imagewidth'], $_newheight, $check[0], $check[1]) == true) {
                                                    imagejpeg($nimage, $target_file, 95);
                                                    $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                                    $nclipped = imagecreatetruecolor($_POST['minwidth'], $_POST['minwidth'] / $_POST['ratioinfoimages']);
                                                    if (isset($_POST['crop'])) {
                                                        if ($_POST['crop'] == 1) {
                                                            $_crop = 0;
                                                        } elseif ($_POST['crop'] == 2) {
                                                            $_crop = ($_newheight - $_POST['minwidth'] / $_POST['ratioinfoimages'] * $_POST['imagewidth'] / $_POST['minwidth']) / 2 - 1;
                                                        } elseif ($_POST['crop'] == 3) {
                                                            $_crop = $_newheight - $_POST['minwidth'] / $_POST['ratioinfoimages'] * $_POST['imagewidth'] / $_POST['minwidth'] - 1;
                                                        }
                                                    } else {
                                                        $_crop = 0;
                                                    }
                                                    if (imagecopyresampled($nclipped, $nimage, 0, 0, 0, $_crop, $_POST['minwidth'], $_POST['minwidth'] / $_POST['ratioinfoimages'], $_POST['imagewidth'], $_POST['minwidth'] / $_POST['ratioinfoimages'] * $_POST['imagewidth'] / $_POST['minwidth']) == true) {
                                                        imagejpeg($nclipped, $clipped_file, 95);
                                                        $_POST['clippd'] = $target_dir . "clp_" . $_FILES['etiqueta']['name'];
                                                    } else {
                                                        unlink($target_file);
                                                        $_msj = 17;
                                                    }
                                                } else {
                                                    $_msj = 12;
                                                }
                                            } else {
                                                $_msj = 13;
                                            }
                                        } else {
                                            $_msj = 13;
                                        }
                                    } else {
                                        $_msj = 16;
                                    }
                                }
                            } else {
                                if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                    $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                } else {
                                    $_msj = 13;
                                }
                            }
                        } else {
                            $_msj = 10;
                        }
                    }
                    if ($_msj == 0) {
                        $_msj = $_actividad->nuevaInformacion($_POST['etiqueta'], $_POST['titulo'], $_POST['texto'], $_POST['textomas'], $_POST['fecha'], $_POST['estado'], $_POST['id'], $_SESSION['idusuario'], $_sincambio, $_POST['clippd'], $_POST['tinfo'], $_POST['wide'], $_POST['idmenu']);
                    }
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'infestado') {
                    $_actividad = new Informaciones();
                    $_msj = $_actividad->estadoInformacion($_POST['id'], $_POST['estado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'infeditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'cambiatipoinfo') {
                    $get_info = "";
                    $_tinfo = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "tinfo") {
                            $_tinfo = 1;
                            $get_info .= "&" . $key . "=" . $_POST['tipoinfo'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_tinfo == 0) {
                        $get_info .= "&tinfo=" . $_POST['tipoinfo'];
                    }
                    $_redirect = 1;
                }
                break;
            }
        case "menu": {
                if ($_POST['accion'] == 'nmenu') {
                    $_actividad = new Menus;
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    if (!isset($_POST['idmodulo'])) {
                        $_POST['idmodulo'] = "";
                    }
                    $_msj = $_actividad->nuevaMenu($_POST['titulo'], $_POST['url'], $_POST['afuera'], $_POST['estado'], $_POST['id'], $_SESSION['idusuario'], $_POST['idmodulo'], $_POST['alaizquierda']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'meestado') {
                    $_actividad = new Menus;
                    $_msj = $_actividad->estadoEnlace($_POST['id'], $_POST['estado']);
                    $_actividad->Reordenar();
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'meeditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'meordenar') {
                    $_actividad = new Menus;
                    $_msj = $_actividad->grabarNuevoOrden($_POST['ordenado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                }
                break;
            }
        case "galerias": {
                if ($_POST['accion'] == 'ngaleria') {
                    $_actividad = new Galerias(0);
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    $_sincambio = 0;
                    if ($_POST['estado'] == 'edicion') {
                        if ($_POST['conimagen'] == 1) {
                            if (!$_FILES['etiqueta']['name']) {
                                $_sincambio = 1;
                            }
                        }
                    }
                    $_msj = 0;
                    if ($_FILES['etiqueta']['name']) {
                        $target_dir = "../rsceducaiton/img/";
                        $target_file = $target_dir . basename($_FILES['etiqueta']['name']);
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $check = getimagesize($_FILES['etiqueta']['tmp_name']);
                        if ($check !== false) {
                            if ($check[0] >= $_POST['thumbwidth'] && $check[1] >= $_POST['thumbwidth']) {
                                if ($check[0] == $_POST['thumbwidth'] && $check[1] == $_POST['thumbwidth']) {
                                    if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                        $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                    } else {
                                        $_msj = 13;
                                    }
                                } else {
                                    if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                        $nimage = imagecreatetruecolor($_POST['thumbwidth'], $_POST['thumbwidth']);
                                        if ($imageFileType == 'jpeg' || $imageFileType == 'jpg') {
                                            $image = imagecreatefromjpeg($target_file);
                                        } elseif ($imageFileType == 'gif') {
                                            $image = imagecreatefromgif($target_file);
                                        } elseif ($imageFileType == 'png') {
                                            $image = imagecreatefrompng($target_file);
                                        } else {
                                            unlink($target_file);
                                            $_msj = 14;
                                        }
                                        if ($_msj == 0) {
                                            if ($check[0] / $check[1] > 1) {
                                                $_cropy = 0;
                                                if ($_POST['crop'] == 1) {
                                                    $_cropx = 0;
                                                } elseif ($_POST['crop'] == 2) {
                                                    $_cropx = ($check[0] - $_POST['thumbwidth'] * $check[1] / $_POST['thumbwidth']) / 2 - 1;
                                                } elseif ($_POST['crop'] == 3) {
                                                    $_cropx = $check[0] - $_POST['thumbwidth'] * $check[1] / $_POST['thumbwidth'] - 1;
                                                }
                                                $_sourcex = $check[1] * $_POST['thumbwidth'] / $_POST['thumbwidth'];
                                                $_sourcey = $check[1];
                                            } else {
                                                $_cropx = 0;
                                                if ($_POST['crop'] == 1) {
                                                    $_cropy = 0;
                                                } elseif ($_POST['crop'] == 2) {
                                                    $_cropy = ($check[1] - $_POST['thumbwidth'] * $check[0] / $_POST['thumbwidth']) / 2 - 1;
                                                } elseif ($_POST['crop'] == 3) {
                                                    $_cropy = $check[1] - $_POST['thumbwidth'] * $check[0] / $_POST['thumbwidth'] - 1;
                                                }
                                                $_sourcey = $check[0];
                                                $_sourcex = $check[0] * $_POST['thumbwidth'] / $_POST['thumbwidth'];
                                            }
                                            if (imagecopyresampled($nimage, $image, 0, 0, $_cropx, $_cropy, $_POST['thumbwidth'], $_POST['thumbwidth'], $_sourcex, $_sourcey) == true) {
                                                imagejpeg($nimage, $target_file, 95);
                                                $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                            } else {
                                                $_msj = 12;
                                            }
                                        }
                                    } else {
                                        $_msj = 13;
                                    }
                                }
                            } else {
                                $_msj = 11;
                            }
                        } else {
                            $_msj = 10;
                        }
                    }
                    if ($_msj == 0) {
                        $_msj = $_actividad->nuevaGaleria($_POST['etiqueta'], $_POST['titulo'], $_POST['descripto'], $_POST['fecha'], $_POST['estado'], $_POST['id'], $_POST['tgale'], $_SESSION['idusuario'], $_sincambio);
                    }
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'gaestado') {
                    $_actividad = new Galerias(0);
                    $_msj = $_actividad->estadoGaleria($_POST['id'], $_POST['estado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'gaeditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'gagrid') {
                    $_redirect = 1;
                    $_limpio = 0;
                    if (isset($_POST['saccion'])) {
                        if ($_POST['saccion'] == 'nimagen') {
                            if (!isset($_POST['estado'])) {
                                $_POST['estado'] == "agregacion";
                            }
                            if (!isset($_POST['sid'])) {
                                $_POST['sid'] = 0;
                            }
                            $_sincambio = 0;
                            if ($_POST['estado'] == 'edicion') {
                                if ($_POST['conimagen'] == 1) {
                                    if (!$_FILES['etiqueta']['name']) {
                                        $_sincambio = 1;
                                    }
                                } else {
                                    $_FILES['etiqueta']['name'] = "";
                                }
                            }
                            $_GET['msj'] = 0;
                            if ($_FILES['etiqueta']['name']) {
                                $target_dir = "../rsceducaiton/img/";
                                $target_file = $target_dir . basename($_FILES['etiqueta']['name']);
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $check = getimagesize($_FILES['etiqueta']['tmp_name']);
                                if ($check !== false) {
                                    if ($check[0] <= $_POST['imagewidth'] && $check[1] <= $_POST['imageheight']) {
                                        if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                            $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                        } else {
                                            $_GET['msj'] = 13;
                                        }
                                    } else {
                                        if ($check[0] > $_POST['imagewidth']) {
                                            $nwidth = $_POST['imagewidth'];
                                            $nheight = $_POST['imagewidth'] * $check[1] / $check[0];
                                        } else {
                                            if ($check[1] > $_POST['imageheight']) {
                                                $nheight = $_POST['imageheight'];
                                                $nwidth = $_POST['imageheight'] * $check[0] / $check[1];
                                            }
                                        }
                                        if (move_uploaded_file($_FILES['etiqueta']['tmp_name'], $target_file)) {
                                            $nimage = imagecreatetruecolor($nwidth, $nheight);
                                            if ($imageFileType == 'jpeg' || $imageFileType == 'jpg') {
                                                $image = imagecreatefromjpeg($target_file);
                                            } elseif ($imageFileType == 'gif') {
                                                $image = imagecreatefromgif($target_file);
                                            } elseif ($imageFileType == 'png') {
                                                $image = imagecreatefrompng($target_file);
                                            } else {
                                                unlink($target_file);
                                                $_GET['msj'] = 14;
                                            }
                                            if ($_GET['msj'] == 0) {
                                                if (imagecopyresampled($nimage, $image, 0, 0, 0, 0, $nwidth, $nheight, $check[0], $check[1]) == true) {
                                                    imagejpeg($nimage, $target_file, 95);
                                                    $_POST['etiqueta'] = $target_dir . $_FILES['etiqueta']['name'];
                                                } else {
                                                    $_GET['msj'] = 12;
                                                }
                                            }
                                        } else {
                                            $_GET['msj'] = 13;
                                        }
                                    }
                                } else {
                                    $_GET['msj'] = 10;
                                }
                            }
                            if ($_GET['msj'] == 0) {
                                $_actividad = new Galerias(0);
                                $_GET['msj'] = $_actividad->nuevaImagen($_POST['id'], $_POST['etiqueta'], $_POST['descripto'], $_sincambio, $_POST['estado'], $_POST['sid']);
                                $_SESSION['flag'] = 1;
                                $_redirect = 1;
                            }
                        } elseif ($_POST['saccion'] == 'imeditar') {
                            $_SESSION['flag'] = 1;
                            $_redirect = 0;
                        } elseif ($_POST['saccion'] == 'imestado') {
                            $_SESSION['flag'] = 1;
                            $_actividad = new Galerias(0);
                            $_GET['msj'] = $_actividad->estadoImagen($_POST['id'], $_POST['sid']);
                        } elseif ($_POST['saccion'] == 'imordenar') {
                            $_actividad = new Galerias(0);
                            $_GET['msj'] = $_actividad->grabarNuevoOrden($_POST['id'], $_POST['ordenado']);
                            $_SESSION['flag'] = 1;
                        } elseif ($_POST['saccion'] == 'cleanup') {
                            $_limpio = 1;
                        }
                    } else {
                        if (isset($_POST['saccion'])) {
                            if ($_POST['saccion'] == 'cleanup') {
                                $_limpio = 1;
                            }
                        }
                    }
                    if ($_limpio == 0) {
                        $get_info = "";
                        $_accion = 0;
                        $_id = 0;
                        $_tgale = 0;
                        foreach ($_GET AS $key => $value) {
                            if ($key == "id") {
                                $_id = 1;
                            }
                            if ($key == "accion") {
                                $_accion = 1;
                            }
                            if ($key == "tgale") {
                                $_tgale = 1;
                            }
                            $get_info .= "&" . $key . "=" . $value;
                        }
                        if ($_accion == 0) {
                            $get_info .= "&accion=gagrid";
                        }
                        if ($_id == 0) {
                            $get_info .= "&id=" . $_POST['id'];
                        }
                        if ($_tgale == 0) {
                            $get_info .= "&tgale=" . $_POST['tipogaleria'];
                        }
                    } else {
                        if (!isset($get_info)) {
                            $get_info = "";
                        }
                        foreach ($_GET AS $key => $value) {
                            if ($key != "accion" && $key != "saccion" && $key != "id") {
                                $get_info .= "&" . $key . "=" . $value;
                            }
                        }
                    }
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'cambiatipogaleria') {
                    $get_info = "";
                    $_tgale = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "tgale") {
                            $_tenla = 1;
                            $get_info .= "&" . $key . "=" . $_POST['tipogale'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_tgale == 0) {
                        $get_info .= "&tgale=" . $_POST['tipogale'];
                    }
                    $_redirect = 1;
                }
                break;
            }
        case "perfiles": {
                if ($_POST['accion'] == 'nperfil') {
                    $_actividad = new Perfiles;
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    if (!isset($_POST['idmodulo'])) {
                        $_POST['idmodulo'] = "";
                    }
                    $_msj = $_actividad->nuevaPerfiles($_POST['etiqueta'], $_POST['faicon'], $_POST['url'], $_POST['afuera'], $_POST['estado'], $_POST['id'], $_SESSION['idusuario'], $_POST['idmodulo']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'peestado') {
                    $_actividad = new Perfiles;
                    $_msj = $_actividad->estadoPerfil($_POST['id'], $_POST['estado']);
                    $_actividad->Reordenar();
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'peeditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == 'peordenar') {
                    $_actividad = new Perfiles;
                    $_msj = $_actividad->grabarNuevoOrden($_POST['ordenado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                }
                break;
            }
        case "usuarios": {
                if ($_POST['accion'] == 'nusuario') {
                    $_actividad = new Usuario;
                    if (isset($_POST['afuera'])) {
                        $_POST['afuera'] = 1;
                    } else {
                        $_POST['afuera'] = 0;
                    }
                    if (!isset($_POST['estado'])) {
                        $_POST['estado'] = 'agregacion';
                    }
                    if (!isset($_POST['id'])) {
                        $_POST['id'] = "";
                    }
                    require_once 'controladores/PkcsKeyGenerator.php';
                    require_once 'controladores/DesEncryptor.php';
                    require_once 'controladores/PbeWithMd5AndDes.php';
                    require_once 'controladores/PBEParameters.php';
                    $_respuesta = PbeWithMd5AndDes::encrypt(
                                    $_POST['usuario'], $keystring, $salt, $iterations, $segments
                    );
                    $_msj = $_actividad->nuevaUsuario($_POST['usuario'], $_POST['apellidos'], $_POST['nombres'], $_POST['emilio'], $_POST['tipousuario'], $_POST['id'], $_POST['estado'], $_respuesta, $_SESSION['idusuario']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'usestado') {
                    $_actividad = new Usuario;
                    $_msj = $_actividad->estadoUsuario($_POST['id'], $_POST['estado']);
                    $_SESSION['flag'] = 1;
                    $_redirect = 1;
                    $get_info = $preget_info . "&msj=" . $_msj;
                } elseif ($_POST['accion'] == 'useditar') {
                    $_SESSION['flag'] = 1;
                    $_redirect = 0;
                } elseif ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                }
                break;
            }
        case "visitantes": {
                if ($_POST['accion'] == 'cambiaitemsxpagina') {
                    $get_info = "";
                    $_ixp = 0;
                    foreach ($_GET AS $key => $value) {
                        if ($key == "ixp") {
                            $_ixp = 1;
                            $get_info .= "&" . $key . "=" . $_POST['actxpag'];
                        } elseif ($key == "mallainicial") {
                            $get_info .= "&" . $key . "=0";
                        } else {
                            $get_info .= "&" . $key . "=" . $value;
                        }
                    }
                    if ($_ixp == 0) {
                        $get_info .= "&ixp=" . $_POST['actxpag'];
                    }
                    $_redirect = 1;
                } elseif ($_POST['accion'] == "reporte") {
                    $_reporte = new Reportes($_POST['fechini'], $_POST['fechfin']);
                    $_reporte->genereReporte();
                    $_redirect = 0;
                    $_null = 1;
                    $get_info = $preget_info;
                }
                break;
            }
        case 'auxiliares': {
                if ($_POST['accion'] == "nuevatabla") {
                    $_redirect = 1;
                    $get_info = "modulo=auxiliares&table=" . $_POST['table'];
                } elseif ($_POST['accion'] == "guardar") {
                    $_redirect = 1;
                    $_auxi = new Auxiliares;
                    $_auxi->grabarTabla($_POST);
                    $get_info = "modulo=auxiliares&table=" . $_POST['table'];
                }
                break;
            }
    }
    if (isset($_redirect)) {
        if ($_redirect) {
            $_strheader = "Location: ./swapis.php";
            if (isset($get_info)) {
                if ($get_info) {
                    $_strheader .= "?";
                    if ($get_info[0] == "&") {
                        $get_info = substr($get_info, 1 - strlen($get_info));
                    }
                }
            } else {
                $get_info = "";
            }
            header($_strheader . $get_info);
            exit();
        }
    }
}
if ($_null != 1) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <!--Metaetiqueta para el uso del conjunto de caracteres adecuado-->
            <meta charset="utf-8">
            <!--Metaetiqueta para corregir compatibilidad con navegador Microsft-->
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!--Metaetiqueta para la correcta visualización en dispositivos moviles-->
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
            <title>SWAPIS - Sitio Web Administrable para educaITon</title>
            <!--Añada primero el estilo de la libreria (ufps.css o ufps.min.css) y luego sus estilos propios-->
            <link href="css/swapis/ufps.css" rel="stylesheet">
            <link href="css/swapis/styles.css" rel="stylesheet">
            <link href="css/swapis/wpuniversity.css" rel="stylesheet">
            <link href="css/swapis/wpunivresp.css" rel="stylesheet">
            <link rel='stylesheet' id='stylesheet-css'  href='css/swapis/wpkitchen.css' type='text/css' media='all' />
            <link rel="stylesheet" href="css/swapis/jquery-ui.css">
            <link rel="stylesheet" href="css/swapis/evol-colorpicker.min.css">
            <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css">
            <script src="js/swapis/jquery-1.12.4.js"></script>
            <script type='text/javascript' src='js/swapis/jquery-migrate.min.js'></script>
            <script src="js/swapis/jquery-ui.js"></script>
            <!--Librerías para compatibilidad con versiones antiguas de Internet Explorer-->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <link href="./favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        </head>
        <body>
            <!--Contenido-->
    <?php
    if (!isset($_SESSION['usuario'])) {
        $_msj = "";
        if (isset($_GET['msj'])) {
            if ($_GET['msj'] == 1) {
                $_msj = "Inicio de sesi&oacute;n inv&aacute;lido";
            } elseif ($_GET['msj'] == 2) {
                $_msj = "Se ha cerrado la sesi&oacute;n de manera correcta";
            }
        }
        ?>
                <div class="ufps-container-fluid">
                    <div class="ufps-row">
                        <div class="ufps-col-mobile-1 ufps-col-tablet-2 ufps-col-netbook-4 ufps-col-desktop-4"></div>
                        <div class="ufps-col-mobile-10 ufps-col-tablet-8 ufps-col-netbook-4 ufps-col-desktop-4" style="margin-top:8%;">
                            <div style="width:100%; margin:auto; clear:both; margin-bottom:10px; text-align:center;"><img src="rsc/img/logo-educaiton.png" style="width:120px;"></div>
        <?php
        if ($_msj) {
            ?>
                                <div style="width:100%; margin:auto; clear:both; margin-bottom:10px; text-align:center; color:red"><?php echo $_msj; ?></div>
                                <?php
                            }
                            ?>
                            <div class="gdl-custom-sidebar" id="loginbox">
                                <form name='formulario' method='post' action='swapis.php'>
                                    <input type='hidden' name='accion' value='login'>
                                    Usuario<br><input type='text' name='usuario' style="width:100%;" autofocus><br><br>
                                    Clave<br><input type='password' name='clave' style="width:100%;"><br><br>
                                    <div style="width:100%; text-align:center;"><input type='submit' value='Enviar'></div>
                                </form>
                            </div>
                        </div>
                        <div class="ufps-col-mobile-1 ufps-col-tablet-2 ufps-col-netbook-4 ufps-col-desktop-4"></div>
                    </div>
                </div>
        <?php
    } else {
        if (isset($_GET['msj']) && !$_modulo) {
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
                    echo "<p>La contraseña actual no es correcta</p>";
                } elseif ($_GET['msj'] == 2) {
                    echo "<p>Ocurri&oacute; un error grabando la informaci&oacute;n de la nueva contrase&ntilde;a";
                } elseif ($_GET['msj'] == 3) {
                    echo "<p>La contrase&ntilde;a se ha actualizado con &eacute;xito</p>";
                }
                ?>
                                </div>
                            </div>
                        </div>
                                    <?php
                                }
                            }
                            ?>
                <form name="logout" action="swapis.php" method="post">
                    <input type="hidden" name="accion" value="logout">
                </form>
                <div class="ufps-container-fluid" style="padding:0px;">
                    <div class="ufps-row">
                        <div class="ufps-col-mobile-12 ufps-col-tablet-12 ufps-col-netbook-2 ufps-col-desktop-2" style="padding:0px;">
                            <div class="menuAdmin">
                                <div style="text-align:center;"><h4 class="titulomenuAdmin">Administraci&oacute;n del Sitio Web educaITon de la Universidad Francisco de Paula Santander</h4></div>
                                <div class="bloquemenuAdmin" style="margin-bottom:10px;"></div>
                                <a id="menu-control3" style="cursor:pointer;"><span>&#9776; MEN&Uacute;</span></a>
                                <div id="navigation3" class="menu-main-container3" style="margin-bottom:10px;">
                                    <ul id="dropmenu3" class="menu3">
                                        <li class="menu-item"><a href="?">Tablero de mensajes</a></li>
                                        <li class="menu-item"><a href="?modulo=enlaces">Enlaces</a></li>
                                        <li class="menu-item"><a href="?modulo=slider">Im&aacute;genes rotatorias</a></li>
                                        <li class="menu-item"><a href="?modulo=menu">Men&uacute;</a></li>
                                        <li class="menu-item"><a href="?modulo=informaciones">Informaciones y modulos</a></li>
                                        <li class="menu-item"><a href="?modulo=calendario">Calendario</a></li>
                                        <li class="menu-item"><a href="?modulo=galerias">Galer&iacute;as</a></li>
                                        <li class="menu-item"><a href="?modulo=perfiles">Perfiles</a></li>
                                        <li class="menu-item"><a href="?modulo=ofertas">Ofertas laborales</a></li>
                                        <li class="menu-item"><a href="?modulo=recursos">Recursos</a></li>
                                        <li class="menu-item"><a href="?modulo=auxiliares">Tablas auxiliares</a></li>
                                        <li class="menu-item"><a href="?modulo=configuracion">Configuraci&oacute;n</a></li>
                                        <li class="menu-item"><a href="?modulo=visitantes">Visitantes</a></li>
                                        <li class="menu-item"><a href="?modulo=usuarios">Usuarios</a></li>
                                    </ul>
                                </div>
                                <div class="bloquemenuAdmin"><p class="titulomenuAdmin"><span style="font-size:0.80em;">Sesi&oacute;n iniciada por</span><br><?php echo $_SESSION['nombres'] . "<br>" . $_SESSION['apellidos']; ?></p><a href="javascript:logOut();"><img id="logut" src="rsc/img/logout.png" style="margin-bottom:15px;" onmouseover="Myhover('logut', 'rsc/img/rlogout.png')" onmouseout="Myhover('logut', 'rsc/img/logout.png')" title="Cerrar sesión"></a> &nbsp; <a href="javascript:changeMe();"><img id="passw" src="rsc/img/key.png" style="margin-bottom:15px;" onmouseover="Myhover('passw', 'rsc/img/rkey.png')" onmouseout="Myhover('passw', 'rsc/img/key.png')" title="Cambiar contraseña"></a></div>
                            </div>
                        </div>
                        <div class="ufps-col-mobile-12 ufps-col-tablet-12 ufps-col-netbook-10 ufps-col-desktop-10" style="padding:0px; padding-left:10px;">
        <?php
        if (isset($_modulo)) {
            switch ($_modulo) {
                default: {
                        if ($_modulo) {
                            include ("vistas/html_swapis_" . $_modulo . ".php");
                        } else {
                            include ("vistas/html_swapis_dashboard.php");
                        }
                        break;
                    }
            }
        } else {
            include ("vistas/html_swapis_dashboard.php");
        }
        ?>
                        </div>
                    </div>
                </div>
                            <?php
                        }
                        ?>
            <!--Algunos componentes requieren el uso de la librería en javascript-->
            <script src="js/swapis/ufps.js"></script>
            <script>
                        jQuery('#menu-control3').click(function () {
                            jQuery('#navigation3').toggleClass('open');
                            jQuery('#dropmenu3 li').find('ul').css("display", "none");
                        }, function () {
                            jQuery('#navigation3').toggleClass('open');
                            jQuery('#dropmenu3 li').find('ul').css("display", "none");
                        });
                        function Myhover(id, imagen) {
                            var elem = document.getElementById(id);
                            elem.src = imagen;
                        }
            </script>
    <?php
    if (isset($_modulo)) {
        switch ($_modulo) {
            case 'ofertas':
            case 'usuarios':
            case 'perfiles':
            case 'galerias':
            case 'menu':
            case 'calendario':
            case 'enlaces':
            case 'slider':
            case 'informaciones': {
                    if (isset($_POST['accion'])) {
                        if (substr($_POST['accion'], -6) == 'editar' || $_POST['accion'] == 'gagrid' && $_POST['saccion'] == 'imeditar') {
                            $_autoro = 0;
                            if (isset($_SESSION['flag'])) {
                                if ($_SESSION['flag'] == 1) {
                                    $_autoro = 1;
                                }
                            }
                            if ($_autoro == 1) {
                                $_SESSION['flag'] = 0;
                                echo "        <script> openModal('modaladdbox', 1); </script>";
                            }
                        }
                    }
                    break;
                }
            default: {
                    
                }
        }
    }
    if (isset($_modulo)) {
        if (isset($_GET['msj'])) {
            if ($_GET['msj']) {
                $_autoro = 0;
                if (isset($_SESSION['flag'])) {
                    if ($_SESSION['flag'] == 1) {
                        $_autoro = 1;
                    }
                }
                if ($_autoro == 1) {
                    $_SESSION['flag'] = 0;
                    echo "          <script> openModal('modal'); </script>";
                }
            }
        }
    }
    ?>
            <script src='js/tinymce/js/tinymce/tinymce.min.js'></script><script src='js/tinymce/js/tinymce/tinymce.min.js'></script>
            <script src="js/swapis/evol-colorpicker.min.js"></script>
            <script>
                            if (document.getElementById("descripto")) {
                                tinymce.init({
                                    selector: '#descripto',
                                    language: 'es',
                                    height: 200,
                                    theme: 'modern',
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                                        'insertdatetime media nonbreaking save table contextmenu directionality',
                                        'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
                                    ],
                                    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                    file_browser_callback: RoxyFileBrowser,
                                    toolbar2: 'print preview media | forecolor backcolor emoticons | codesamplei',
                                    image_advtab: true,
                                    templates: [
                                        {title: 'Test template 1', content: 'Test 1'},
                                        {title: 'Test template 2', content: 'Test 2'}
                                    ],
                                    content_css: [
                                        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                        '//www.tinymce.com/css/codepen.min.css'
                                    ]
                                });
                            }
                            if (document.getElementById("habilidades")) {
                                tinymce.init({
                                    selector: '#habilidades',
                                                    language: 'es',
                                            height: 200,
                                                    theme: 'modern',
                                                    plugins: [
                                                            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                                            'searchreplace wordcount visualblocks visualchars code fullscreen',
                                                            'insertdatetime media nonbreaking save table contextmenu directionality',
                                                    'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
                                    ],
                                                    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                                    file_browser_callback: RoxyFileBrowser,
                                                    toolbar2: 'print preview media | forecolor backcolor emoticons | codesamplei',
                                                            image_advtab: true,
                                    templates: [
                                                    {title: 'Test template 1', content: 'Test 1'},
                                            {title: 'Test template 2', content: 'Test 2'}
                                            ],
                                                    content_css: [
                                                            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                            '//www.tinymce.com/css/codepen.min.css'
                                    ]
                                                            });
                            }
                                                            if (document.getElementById("texto")) {
                                tinymce.init({
                                    selector: '#texto',
                                                    language: 'es',
                                    height: 200,
                                    theme: 'modern',
                                    plugins: [
                                                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                                                    'insertdatetime media nonbreaking save table contextmenu directionality',
                                                            'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
                                                    ],
                                                            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                    file_browser_callback: RoxyFileBrowser,
                                                            toolbar2: 'print preview media | forecolor backcolor emoticons | codesamplei',
                                    image_advtab: true,
                                    templates: [
                                        {title: 'Test template 1', content: 'Test 1'},
                                        {title: 'Test template 2', content: 'Test 2'}
                                    ],
                                    content_css: [
                                        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                        '//www.tinymce.com/css/codepen.min.css'
                                    ]
                                });
                            }
                            if (document.getElementById("textomas")) {
                            tinymce.init({
                            selector: '#textomas',
                                    init_instance_callback : function(editor) {
                                    // jw: this code is heavily borrowed from tinymce.jquery.js:12231 but modified so that it will
                                    //     just remove the escaping and not add it back.
                                    editor.serializer.addNodeFilter('script,style', function(nodes, name) {
                                    var i = nodes.length, node, value, type;
                                            function trim(value) {
                                            /*jshint maxlen:255 */
                                            /*eslint max-len:0 */
                                            return value.replace(/(<!--\[CDATA\[|\]\]-->)/g, '\n').replace(/^[\r\n]*|[\r\n]*$/g, '')
                                .replace(/^\s*((<!--)?(\s*\/\/)?\s*<!\[CDATA\[|(<!--\s*)?\/\*\s*<!\[CDATA\[\s*\*\/|(\/\/)?\s*<!--|\/\*\s*<!--\s*\*\/)\s*[\r\n]*/gi, '')
                                .replace(/\s*(\/\*\s*\]\]>\s*\*\/(-->)?|\s*\/\/\s*\]\]>(-->)?|\/\/\s*(-->)?|\]\]>|\/\*\s*-->\s*\*\/|\s*-->\s*)\s*$/g, '');
                    }
                    while (i--) {
                        node = nodes[i];
                        value = node.firstChild ? node.firstChild.value : '';

                        if (value.length > 0) {
                            node.firstChild.value = trim(value);
                        }
                    }
                    });
                },
                language: 'es',
                height: 500,
                theme: 'modern',
                valid_elements : '*[*]',   
                extend_valid_elements: "script [src | async | defer | type | charset]",
                plugins: [
                  'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                  'searchreplace wordcount visualblocks visualchars code fullscreen',
                  'insertdatetime media nonbreaking save table contextmenu directionality',
                  'emoticons template paste textcolor colorpicker textpattern imagetools codesample',
                  'media'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                file_browser_callback: RoxyFileBrowser,
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesamplei',
                image_advtab: true,
                templates: [
                  { title: 'Test template 1', content: 'Test 1' },
                  { title: 'Test template 2', content: 'Test 2' }
                ],    
                content_css: [
                  '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                  '//www.tinymce.com/css/codepen.min.css'
                ],
                media_strict: false
               });
            }
            function RoxyFileBrowser(field_name, url, type, win) {
              var roxyFileman = './controladores/fileman/index.html';
              if (roxyFileman.indexOf("?") < 0) {
                roxyFileman += "?type=" + type;
              }
              else {
                roxyFileman += "&type=" + type;
              }
              roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
              if(tinyMCE.activeEditor.settings.language){
                roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
              }
              tinyMCE.activeEditor.windowManager.open({
                 file: roxyFileman,
                 title: 'Roxy Fileman',
                 width: 850,
                 height: 480,
                 resizable: "yes",
                 plugins: "media",
                 inline: "yes",
                 close_previous: "no"
              }, {     window: win,     input: field_name    });
              return false;
            }
            </script>
            <script src="js/swapis/jquery.mjs.nestedSortable.js"></script>
            <script>
                                                            if (document.getElementById("sortable")) {
                                                    $(document).ready(function(){
                                                    $('.sortable').nestedSortable({
                                                    handle: 'div',
                                                            items: 'li',
                                                            toleranceElement: '> div'
                                                    });
                                                    });
                                                    }
            </script>
            <!--
                <script type="text/javascript" src="js/wpuniversity.js"></script>
            -->
            <script>
                                        function validarchangepass(idedicion) {
                                        if (document.forms['changepass'].pass.value.length != 0 && document.forms['changepass'].npass.value.length != 0 && document.forms['changepass'].npassc.value.length != 0) {
                                        if (document.forms['changepass'].npass.value == document.forms['changepass'].npassc.value) {
                                        document.forms['changepass'].submit();
                                        } else {
                                        alert("Las contraseñas no coinciden");
                                        }
                                        } else {
                                        alert("Deben llenarse todos los campos");
                                        }
                                        }
            </script>
            <div id="modalchangepass" class="ufps-modal" style="padding-top:50px;">
                <div class="ufps-modal-content">
                    <div class="ufps-modal-header ufps-modal-header-red">
                        <span class="ufps-modal-close">&times;</span>
                        <h2 id="tituloaddbox" style="color:#fff;">Cambiar contrase&ntilde;a de usuario</h2>
                    </div>
                    <div class="ufps-modal-body" style="background-color: #cecece;">
                        <form name="changepass" action="swapis.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post">
                            <input type="hidden" name="accion" value="changepw">
                            <input type="hidden" name="modulo" value="">
                            <p class="pnormal">Contrase&ntilde;a actual: <input type="password" class="ufps-input-medium ufps-input" name="pass" autofocus></p>
                            <p class="pnormal">Contrase&ntilde;a nueva: <input type="password" class="ufps-input-medium ufps-input" name="npass"></p>
                            <p class="pnormal">Confirmar contrase&ntilde;a nueva: <input type="password" class="ufps-input-medium ufps-input" name="npassc"></p>
                            <div style="text-align:center; margin-top:25px;  margin-bottom:10px;"><input type="button" value="Enviar" onclick="validarchangepass()"></div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
}
?>

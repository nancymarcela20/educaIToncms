<?php
  class conexion {

    var $bd;
    var $bdatos;
    var $ruta;
    function __construct($basedatos="cmseducaiton", $ruta="") {
      $this->bdatos = $basedatos;
      $this->ruta = $ruta;
    }
    function conectar() {
      $_lectura = fopen($this->ruta."bdconf.dat","r");
      $_campos = fread($_lectura,2048);
      fclose($_lectura);
      if ($lineas = explode("\n",$_campos)) {
        $_myhost = explode("=",$lineas[0]);
        $_myuser = explode("=",$lineas[1]);
        $_mypass = explode("=",$lineas[2]);
        $this->bd = mysqli_connect($_myhost[1], $_myuser[1], $_mypass[1], $this->bdatos);
        //start: changed to Google Cloud Migrate  from Milton Jesus Vera Contreras 2019/07/03 
        if(!$this->bd) { printf("Error al conectarse a la BD");exit(); }
        if (!mysqli_set_charset($this->bd, "latin1")) { printf("Error cargando el conjunto de caracteres latin1: %s", mysqli_error($this->bd));  exit(); }
        //end: changed to Google Cloud Migrate  from Milton Jesus Vera Contreras 2019/07/03 
      }
    }
    function desconectar() {
      mysqli_close($this->bd);
    }
  }
  class Configuraciones {
    function __construct() {
    }
    function obtenerWidthGalleryThumb() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT width_gallery_thumb FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['width_gallery_thumb'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerImagesDimensions() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT max_width_images, max_height_images FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            array_push($_cadena, array($row['max_width_images'], $row['max_height_images']));
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerSliderDimensions() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT width_slider_images, height_slider_images FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            array_push($_cadena, array($row['width_slider_images'], $row['height_slider_images']));
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerMinInfoImage() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT min_width_info_images, ratio_info_images FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            array_push($_cadena,array($row['min_width_info_images'],$row['ratio_info_images']));
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,array(0,0));
      }
      return $_cadena;
    }
    function obtenerMinWidthSlider() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT min_width_slider_images FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['min_width_slider_images'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerVariables() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT TextoFooter, transition_time, show_time, galleries_in_mainpage, max_width_images, max_height_images, min_width_slider_images, width_slider_images, height_slider_images, route_to_fileman, min_width_info_images, ratio_info_images, width_gallery_thumb FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['TextoFooter'],$row['transition_time'],$row['show_time'],$row['galleries_in_mainpage'],$row['max_width_images'],$row['min_width_slider_images'],$row['width_slider_images'],$row['height_slider_images'],$row['max_height_images'],$row['route_to_fileman'],$row['min_width_info_images'],$row['ratio_info_images'],$row['width_gallery_thumb']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function grabarVariables($descripto, $maxwidth, $minwidth, $sliderwidth, $sliderheight, $maxheight, $routetofileman, $mininfowidth, $ratioinfoimages, $widthgallerythumb) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "UPDATE configuracion SET TextoFooter=\"".utf8_decode(str_replace("\n","<br>",$descripto))."\", max_width_images = ".$maxwidth.", min_width_slider_images = ".$minwidth.", width_slider_images = ".$sliderwidth.", height_slider_images = ".$sliderheight.", max_height_images = ".$maxheight.", route_to_fileman = \"".$routetofileman."\", min_width_info_images = ".$mininfowidth.", ratio_info_images = ".$ratioinfoimages.", width_gallery_thumb = ".$widthgallerythumb." WHERE 1 = 1";
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 2;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
  }
  class RedesSociales {
    function __construct() {
    }
    function obtenerRedes() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT redessociales.id, tiporedessociales.clasefloat, tiporedessociales.clasefooter, tiporedessociales.etiqueta, tooltip, url, afuera FROM redessociales INNER JOIN tiporedessociales ON redessociales.idclaseredsocial = tiporedessociales.id WHERE redessociales.activo = 1 ORDER BY redessociales.orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['clasefloat'],$row['tooltip'],$row['url'],$row['afuera'],$row['clasefooter'],$row['etiqueta']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Perfiles {
    function __construct() {

    }
    function nuevaPerfiles($etiqueta, $faicon, $url, $afuera, $estado, $id, $idusuario = 0, $idmodulo) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if (!$url && $idmodulo) {
        $url = $idmodulo;
      }
      if (!$url && !$idmodulo) {
        $url = "javascript:;";
      }
      if ($_mbd->bd) {
        $_tempSlides = new Perfiles;
        $_ultimorden = $_tempSlides->ultimoOrden();
        if ($estado != "edicion") {
          $_sql = "INSERT INTO perfiles (id, activo, orden, etiqueta, fa_icon, url, afuera, idusuario) values (NULL, 1, ".($_ultimorden+1).", \"".utf8_decode(str_replace("\"","\\\"",$etiqueta))."\", \"".utf8_decode(str_replace("\"","\\\"",$faicon))."\", \"".$url."\",".$afuera.",".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          $_sql = "UPDATE perfiles SET etiqueta=\"".utf8_decode(str_replace("\"","\\\"",$etiqueta))."\", fa_icon=\"".utf8_decode(str_replace("\"","\\\"",$faicon))."\", url=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function grabarNuevoOrden($matriz) {
      $tmpSlides = new Perfiles;
      $tmpEnlaces = $tmpSlides->obtenerPerfiles();
      $nuevomenu = array();
      $_items = explode(";",$matriz);
      $_hop = 1;
      for ($_a = 1; $_a < count($_items); $_a+=2) {
        $_orden = explode("|",$_items[$_a]);
        if (isset($_items[$_a+1])) {
          $_depth = explode("|",$_items[$_a+1]);
        } else {
          $_depth = array();
        }
        if (isset($_orden[1])) {
          for ($_b = 0; $_b < count($tmpEnlaces); $_b++) {
            if ($tmpEnlaces[$_b][5] == $_orden[1]) {
              $_orden[1] = $tmpEnlaces[$_b][0];
              break;
            }
          }
          array_push($nuevomenu, array($_hop, $_orden[1], $_depth[1], 0));
          $_hop++;
        }
      }
      $bocabajo = array_reverse($nuevomenu);
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      $_cadena = 20;
      if ($_mbd->bd) {
        for ($_a = 0; $_a < count($bocabajo); $_a++) {
          $_sql = "UPDATE perfiles SET orden = ".$bocabajo[$_a][0]." WHERE id = ".$bocabajo[$_a][1]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_cadena = 19;
          }
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function Reordenar() {
      $tmpObj = new Perfiles;
      $maxObj = $tmpObj->totalPerfiles(1);
      $_enlaces = $tmpObj->obtenerPerfiles();
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        for ($_a = count($_enlaces)-1; $_a >= 0; $_a--) {
          $_sql = "UPDATE perfiles SET orden = ".$maxObj." WHERE id = ".$_enlaces[$_a][0]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $maxObj--;
          }
        }
        $_mbd->desconectar();
      }
    }
    function ultimoOrden($id=0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT MAX(orden) AS maxorden FROM perfiles WHERE id NOT IN (".$id.") AND activo = 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['maxorden'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
/*
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
*/
      return $_cadena;
    }
    function estadoPerfil($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_tempSlide = new Perfiles;
        $_ultimorden = $_tempSlide->ultimoOrden($id);
        $_sql = "UPDATE perfiles SET activo = ".$estado.", orden = ".($_ultimorden+1)." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, activo, orden, etiqueta, fa_icon, url, afuera FROM perfiles WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['activo'];
            $_cadena[2] = $row['orden'];
            $_cadena[3] = $row['etiqueta'];
            $_cadena[4] = $row['fa_icon'];
            $_cadena[5] = $row['url'];
            $_cadena[6] = $row['afuera'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, activo, orden, etiqueta, fa_icon, url, afuera FROM perfiles ORDER BY perfiles.id LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['activo'],$row['orden'],$row['etiqueta'],$row['fa_icon'],$row['url'],$row['afuera']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalPerfiles($filtro = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_filtro = "";
        if ($filtro) {
          $_filtro = " WHERE activo = 1";
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM perfiles".$_filtro;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPerfiles() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, etiqueta, fa_icon, url, afuera, orden FROM perfiles WHERE activo = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['etiqueta'],$row['fa_icon'],$row['url'],$row['afuera'],$row['orden']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Enlaces {
    var $tipo;
    function __construct($_mitipo) {
      $this->tipo = $_mitipo;
    }
    function Reordenar() {
      $tmpObj = new Enlaces($this->tipo);
      $maxObj = $tmpObj->totalEnlaces(1);
      $_enlaces = $tmpObj->obtenerEnlaces();
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        for ($_a = count($_enlaces)-1; $_a >= 0; $_a--) {
          $_sql = "UPDATE enlaces SET orden = ".$maxObj." WHERE id = ".$_enlaces[$_a][3]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $maxObj--;
          }
        }
        $_mbd->desconectar();
      }
    }
    function grabarNuevoOrden($matriz) {
      $tmpEnla = new Enlaces($this->tipo);
      $tmpEnlaces = $tmpEnla->obtenerEnlaces();
      $nuevomenu = array();
      $_items = explode(";",$matriz);
      $_hop = 1;
      for ($_a = 1; $_a < count($_items); $_a+=2) {
        $_orden = explode("|",$_items[$_a]);
        if (isset($_items[$_a+1])) {
          $_depth = explode("|",$_items[$_a+1]);
        } else {
          $_depth = array();
        }
        if (isset($_orden[1])) {
          for ($_b = 0; $_b < count($tmpEnlaces); $_b++) {
            if ($tmpEnlaces[$_b][4] == $_orden[1]) {
              $_orden[1] = $tmpEnlaces[$_b][3];
              break;
            }
          }
          array_push($nuevomenu, array($_hop, $_orden[1], $_depth[1], 0));
          $_hop++;
        }
      }
      $bocabajo = array_reverse($nuevomenu);
      $_mbd = new conexion();
      $_mbd->conectar();
      $_cadena = 20;
      $_e = 1;
      if ($_mbd->bd) {
        for ($_a = 0; $_a < count($bocabajo); $_a++) {
          $_sql = "UPDATE enlaces SET orden = ".$bocabajo[$_a][0]." WHERE idtipoenlace = ".$this->tipo." AND id = ".$bocabajo[$_a][1]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_cadena = 19;
          }
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function ultimoOrden($tipoenlace, $id = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT MAX(orden) AS maxorden FROM enlaces WHERE id NOT IN (".$id.") AND idtipoenlace = ".$tipoenlace. " AND activo = 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['maxorden'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
/*
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
*/
      return $_cadena;
    }
    function nuevaEnlace($etiqueta, $url, $afuera, $estado, $id, $tenla, $idusuario = 0, $sincambio, $idmodulo) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if (!$url && $idmodulo) {
        $url = $idmodulo;
      }
      if (!$url && !$idmodulo) {
        $url = "javascript:;";
      }
      if ($_mbd->bd) {
        $_tempEnla = new Enlaces(0);
        $_ultimorden = $_tempEnla->ultimoOrden($tenla);
        if ($estado != "edicion") {
          $_sql = "INSERT INTO enlaces (id, idtipoenlace, activo, orden, etiqueta, urldestino, afuera, idusuario) values (NULL, ".$tenla.", 1, ".($_ultimorden+1).", \"".str_replace("\"","\\\"",utf8_decode($etiqueta))."\",\"".$url."\",".$afuera.",".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          if ($sincambio == 1) {
            $_sql = "UPDATE enlaces SET urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          } else {
            $_sql = "UPDATE enlaces SET etiqueta=\"".str_replace("\"","\\\"",utf8_decode($etiqueta))."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          }
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
   }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipoenlace, activo, orden, etiqueta, urldestino, afuera FROM enlaces WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['idtipoenlace'];
            $_cadena[2] = $row['activo'];
            $_cadena[3] = $row['orden'];
            $_cadena[4] = $row['etiqueta'];
            $_cadena[5] = $row['urldestino'];
            $_cadena[6] = $row['afuera'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function estadoEnlace($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_tempEnlace = new Enlaces($this->tipo);
        $_ultimorden = $_tempEnlace->ultimoOrden($this->tipo, $id);
        $_sql = "UPDATE enlaces SET activo = ".$estado.", orden = ".($_ultimorden+1)." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerTiposEnlaces($tiporequerido, $campo = 0) {
      if ($tiporequerido == 0) {
        $_cadena = array();
      } else {
        $_cadena = "";
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($tiporequerido == 0) {
          $_sql = "SELECT id, descripcion FROM tipoenlaces ORDER BY id";
        } else {
          $_sql = "SELECT tipoenlaces.descripcion, imgheight FROM tipoenlaces WHERE id = ".$tiporequerido;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            if ($tiporequerido == 0) {
              while ($row = $_resultado->fetch_assoc()) {
                array_push($_cadena, array($row['id'],$row['descripcion']));
              }
            } else {
              $row = $_resultado->fetch_assoc();
              if ($campo == 0) {
                $_cadena = $row['descripcion'];
              } elseif ($campo == 1) {
                $_cadena = $row['imgheight'];
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        if ($tiporequerido == 0) {
          array_push($_cadena,'error');
        } else {
          $_cadena = 'error';
        }
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipoenlace, activo, orden, etiqueta, urldestino, afuera FROM enlaces WHERE idtipoenlace = ".$this->tipo." LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['idtipoenlace'],$row['activo'],$row['orden'],$row['etiqueta'],$row['urldestino'],$row['afuera']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalEnlaces($filtro = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_filtro = "";
        if ($filtro) {
          $_filtro = " AND activo = 1";
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM enlaces WHERE idtipoenlace = ".$this->tipo.$_filtro;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerEnlaces() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT etiqueta, urldestino, afuera, id, orden FROM enlaces WHERE idtipoenlace = ".$this->tipo." AND activo = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['urldestino'],$row['etiqueta'],$row['afuera'],$row['id'],$row['orden']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class textoFooter {
    function __construct() {

    }
    function obtenerTexto() {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_cadena = "Error obteniendo informaci&oacute;n de pie de p&aacute;gina.";
      if ($_mbd->bd) {
        $_sql = "SELECT TextoFooter FROM configuracion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['TextoFooter'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      return $_cadena;
    }
  }
  class Slides {
    function __construct() {
    }
    function Reordenar() {
      $tmpObj = new Slides;
      $maxObj = $tmpObj->totalSlides(1);
      $_enlaces = $tmpObj->obtenerSlides();
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        for ($_a = count($_enlaces)-1; $_a >= 0; $_a--) {
          $_sql = "UPDATE slider SET orden = ".$maxObj." WHERE id = ".$_enlaces[$_a][6]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $maxObj--;
          }
        }
        $_mbd->desconectar();
      }
    }
    function grabarNuevoOrden($matriz) {
      $tmpSlides = new Slides;
      $tmpEnlaces = $tmpSlides->obtenerSlides();
      $nuevomenu = array();
      $_items = explode(";",$matriz);
      $_hop = 1;
      for ($_a = 1; $_a < count($_items); $_a+=2) {
        $_orden = explode("|",$_items[$_a]);
        if (isset($_items[$_a+1])) {
          $_depth = explode("|",$_items[$_a+1]);
        } else {
          $_depth = array();
        }
        if (isset($_orden[1])) {
          for ($_b = 0; $_b < count($tmpEnlaces); $_b++) {
            if ($tmpEnlaces[$_b][5] == $_orden[1]) {
              $_orden[1] = $tmpEnlaces[$_b][6];
              break;
            }
          }
          array_push($nuevomenu, array($_hop, $_orden[1], $_depth[1], 0));
          $_hop++;
        }
      }
      $bocabajo = array_reverse($nuevomenu);
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      $_cadena = 20;
      if ($_mbd->bd) {
        for ($_a = 0; $_a < count($bocabajo); $_a++) {
          $_sql = "UPDATE slider SET orden = ".$bocabajo[$_a][0]." WHERE id = ".$bocabajo[$_a][1]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_cadena = 19;
          }
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function estadoImagenRot($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_tempSlide = new Slides;
        $_ultimorden = $_tempSlide->ultimoOrden($id);
        $_sql = "UPDATE slider SET activo = ".$estado.", orden = ".($_ultimorden+1)." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function ultimoOrden($id=0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT MAX(orden) AS maxorden FROM slider WHERE id NOT IN (".$id.") AND activo = 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['maxorden'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
/*
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
*/
      return $_cadena;
    }
    function nuevaSlider($etiqueta, $titulo, $texto, $url, $afuera, $estado, $id, $idusuario = 0, $sincambio, $idmodulo) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if (!$url && $idmodulo) {
        $url = $idmodulo;
      }
      if (!$url && !$idmodulo) {
        $url = "";
      }
      if ($_mbd->bd) {
        $_tempSlides = new Slides(0);
        $_ultimorden = $_tempSlides->ultimoOrden();
        if ($estado != "edicion") {
          $_sql = "INSERT INTO slider (id, activo, orden, titulo, texto, imagen, urldestino, afuera, idusuario) values (NULL, 1, ".($_ultimorden+1).", \"".utf8_decode(str_replace("\"","\\\"",$titulo))."\", \"".utf8_decode(str_replace("\"","\\\"",$texto))."\", \"".$etiqueta."\",\"".$url."\",".$afuera.",".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          if ($sincambio == 1) {
            $_sql = "UPDATE slider SET titulo=\"".utf8_decode(str_replace("\"","\\\"",$titulo))."\", texto=\"".utf8_decode(str_replace("\"","\\\"",$texto))."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          } else {
            $_sql = "UPDATE slider SET titulo=\"".utf8_decode(str_replace("\"","\\\"",$titulo))."\", texto=\"".utf8_decode(str_replace("\"","\\\"",$texto))."\", imagen=\"".$etiqueta."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          }
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, activo, orden, titulo, texto, imagen, urldestino, afuera FROM slider WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['activo'];
            $_cadena[2] = $row['orden'];
            $_cadena[3] = $row['titulo'];
            $_cadena[4] = $row['texto'];
            $_cadena[5] = $row['imagen'];
            $_cadena[6] = $row['urldestino'];
            $_cadena[7] = $row['afuera'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, activo, orden, titulo, texto, imagen, urldestino, afuera FROM slider ORDER BY slider.id LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['activo'],$row['orden'],$row['titulo'],$row['texto'],$row['imagen'],$row['urldestino'],$row['afuera']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalSlides($filtro = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_filtro = "";
        if ($filtro) {
          $_filtro = " WHERE activo = 1";
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM slider".$_filtro;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerSlides() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT titulo, texto, imagen, urldestino, afuera, orden, id FROM slider WHERE activo = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['titulo'],$row['texto'],$row['imagen'],$row['urldestino'],$row['afuera'],$row['orden'],$row['id']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Menus {
    function __construct() {
    }
    function Reordenar() {
      $tmpObj = new Menus;
      $maxObj = $tmpObj->totalMenu(1);
      $_enlaces = $tmpObj->obtenerMenus();
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        for ($_a = count($_enlaces)-1; $_a >= 0; $_a--) {
          $_sql = "UPDATE menus SET orden = ".$maxObj." WHERE id = ".$_enlaces[$_a][0]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $maxObj--;
          }
        }
        $_mbd->desconectar();
      }
    }
    function grabarNuevoOrden($matriz) {
      $tmpMenu = new Menus;
      $tmpEnlaces = $tmpMenu->obtenerMenu();
      $nuevomenu = array();
      $_items = explode(";",$matriz);
      $_hop = 1;
      for ($_a = 1; $_a < count($_items); $_a+=2) {
        $_orden = explode("|",$_items[$_a]);
        if (isset($_items[$_a+1])) {
          $_depth = explode("|",$_items[$_a+1]);
        } else {
          $_depth = array();
        }
        if (isset($_orden[1])) {
          for ($_b = 0; $_b < count($tmpEnlaces); $_b++) {
            if ($tmpEnlaces[$_b][7] == $_orden[1]) {
              $_orden[1] = $tmpEnlaces[$_b][0];
              break;
            }
          }
          array_push($nuevomenu, array($_hop, $_orden[1], $_depth[1], 0));
          $_hop++;
        }
      }
      for ($_a = 0; $_a < count($nuevomenu); $_a++) {
        if (isset($nuevomenu[$_a+1][2])) {
          if ($nuevomenu[$_a+1][2] == $nuevomenu[$_a][2]+1) {
            $nuevomenu[$_a][3] = 1;
          }
        }
      }
      $bocabajo = array_reverse($nuevomenu);
      $_mbd = new conexion();
      $_mbd->conectar();
      $_cadena = 20;
      $_e = 1;
      if ($_mbd->bd) {
        for ($_a = 0; $_a < count($bocabajo); $_a++) {
          $_sql = "UPDATE menus SET orden = ".$bocabajo[$_a][0].", nivel=".($bocabajo[$_a][2]-1).", conhijos=".$bocabajo[$_a][3]." WHERE id = ".$bocabajo[$_a][1]." AND activo = 1";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_cadena = 19;
          }
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function obtenerElementosMenu() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, etiqueta FROM menus WHERE activo = 1 AND conhijos = 0 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['etiqueta']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function ultimoOrden($id = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT MAX(orden) AS maxorden FROM menus WHERE id NOT IN (".$id.") AND activo = 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['maxorden'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
/*
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
*/
      return $_cadena;
    }
    function nuevaMenu($titulo, $url, $afuera, $estado, $id, $idusuario = 0, $idmodulo, $izquierda) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if (!$url && $idmodulo) {
        $url = $idmodulo;
      }
      if (!$url && !$idmodulo) {
        $url = "javascript:;";
      }
      if ($_mbd->bd) {
        $_tempMenu = new Menus(0);
        $_ultimorden = $_tempMenu->ultimoOrden();
        if ($estado != "edicion") {
          $_sql = "INSERT INTO menus (id, activo, orden, nivel, conhijos, izquierda, etiqueta, urldestino, afuera, idusuario) values (NULL, 1 , ".($_ultimorden+1).", 0, 0, ".$izquierda.", \"".str_replace("\"","\\\"",utf8_decode($titulo))."\",\"".$url."\",".$afuera.",".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          $_sql = "UPDATE menus SET etiqueta=\"".str_replace("\"","\\\"",utf8_decode($titulo))."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario.", izquierda=".$izquierda." WHERE id=".$id;
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, izquierda, etiqueta, urldestino, afuera FROM menus WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['izquierda'];
            $_cadena[2] = $row['etiqueta'];
            $_cadena[3] = $row['urldestino'];
            $_cadena[4] = $row['afuera'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function estadoEnlace($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_tempMenu = new Menus(0);
        $_ultimorden = $_tempMenu->ultimoOrden($id);
        $_sql = "UPDATE menus SET activo = ".$estado.", orden = ".($_ultimorden+1)." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, activo, conhijos, izquierda, etiqueta, urldestino, afuera FROM menus ORDER BY id LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['activo'],$row['conhijos'],$row['izquierda'],$row['etiqueta'],$row['urldestino'],$row['afuera']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalMenus($filtro=0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_filtro = "";
        if ($filtro) {
          $_filtro = " WHERE activo = 1";
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM menus".$_filtro;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerMenu() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, nivel, etiqueta, urldestino, afuera, conhijos, izquierda, orden FROM menus WHERE activo = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['nivel'],$row['etiqueta'],$row['urldestino'],$row['afuera'],$row['conhijos'],$row['izquierda'],$row['orden']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Ofertas {
    var $tipoconv;
    var $etiqueta;
    var $ruta;
    function __construct($_convocatoria = 0, $ruta="") {
      $this->tipoconv = $_convocatoria;
      $this->ruta = $ruta;
    }
    function ultimaOferta() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT ofertas.id, fechahora, cargo FROM ofertas WHERE ofertas.activo = 1 ORDER BY id DESC LIMIT 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechahora'],$row['cargo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena, array('error'));
      }
      return $_cadena;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, fechainicial, fechafinal, cargo, descripcion, habilidades, urldestino, afuera, activo FROM ofertas WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['fechainicial'];
            $_cadena[2] = $row['fechafinal'];
            $_cadena[3] = $row['cargo'];
            $_cadena[4] = $row['descripcion'];
            $_cadena[5] = $row['habilidades'];
            $_cadena[6] = $row['urldestino'];
            $_cadena[7] = $row['afuera'];
            $_cadena[8] = $row['activo'];
            $_cadena[9] = array();
            $_sql = "SELECT idconvocatoria FROM ofertas_convocatorias WHERE idoferta = ".$id;
            $_resultado = $_mbd->bd->query($_sql);
            if ($_resultado) {
              if ($_resultado->num_rows !== 0) {
                while ($row = $_resultado->fetch_assoc()) {
                  array_push($_cadena[9], $row['idconvocatoria']);
                }
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function estadoOferta($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_sql = "UPDATE ofertas SET activo = ".$estado." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function nuevaOferta($fechini, $fechfin, $descripcion, $url, $afuera, $convocatorias, $estado, $id, $cargo, $habilidades, $idusuario = 0) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if ($_mbd->bd) {
        if ($estado != "edicion") {
          $_sql = "INSERT INTO ofertas (id, activo, fechainicial, fechafinal, cargo, descripcion, habilidades, urldestino, afuera, idusuario, fechahora) values (NULL, 1, \"".$fechini."\",\"".$fechfin."\",\"".str_replace("\"","\\\"",utf8_decode($cargo))."\",\"".str_replace("\"","\\\"",utf8_decode($descripcion))."\",\"".str_replace("\"","\\\"",utf8_decode($habilidades))."\",\"".$url."\",".$afuera.",".$idusuario.",\"".Date("Y-m-d H:i:s")."\")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_lastid = mysqli_insert_id($_mbd->bd);
            for ($_a = 0; $_a < count($convocatorias); $_a++) {
              $_sql = "INSERT INTO ofertas_convocatorias (idoferta, idconvocatoria) VALUES (".$_lastid.",".$convocatorias[$_a].")";
              $_mbd->bd->query($_sql);
            }
            $_e = 2;
          }
        } else {
          $_sql = "UPDATE ofertas  SET fechainicial=\"".$fechini."\", fechafinal=\"".$fechfin."\", cargo=\"".str_replace("\"","\\\"",utf8_decode($cargo))."\", descripcion=\"".str_replace("\"","\\\"",utf8_decode($descripcion))."\", habilidades=\"".str_replace("\"","\\\"",utf8_decode($habilidades))."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_sql = "DELETE FROM ofertas_convocatorias WHERE idoferta = ".$id;
            $_mbd->bd->query($_sql);
            for ($_a = 0; $_a < count($convocatorias); $_a++) {
              $_sql = "INSERT INTO ofertas_convocatorias (idoferta, idconvocatoria) VALUES (".$id.",".$convocatorias[$_a].")";
              $_mbd->bd->query($_sql);
            }
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function totalOfertas($soloact = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipoconv == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_mywhere = "ofertas_convocatorias.idconvocatoria IN (".$this->tipoconv.")";
        }
        if ($soloact == 1) {
          $_sactivos = " AND ofertas.activo = 1";
        } else {
          $_sactivos = "";
        }
        $_sql = "SELECT COUNT(*) FROM ofertas INNER JOIN ofertas_convocatorias ON ofertas.id = ofertas_convocatorias.idoferta WHERE ".$_mywhere.$_sactivos." GROUP BY ofertas.id";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $_cadena = $_resultado->num_rows;
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipoconv == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_mywhere = "ofertas_convocatorias.idconvocatorias IN (".$this->tipoconv.")";
        }
        $_sql = "SELECT ofertas.id, fechainicial, fechafinal, cargo, descripcion, habilidades, urldestino, afuera, activo FROM ofertas INNER JOIN ofertas_convocatorias ON ofertas.id = ofertas_convocatorias.idoferta WHERE ".$_mywhere." GROUP BY ofertas.id ORDER BY ofertas.id LIMIT ".$limiteinicial.",".$itemsxpage."";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['cargo'],$row['descripcion'],$row['habilidades'],$row['urldestino'],$row['afuera'],$row['activo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerTipoConvocatoria($tiporequerido) {
      if ($tiporequerido == 0) {
        $_cadena = array();
      } else {
        $_cadena = "";
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($tiporequerido == 0) {
          $_sql = "SELECT id, descripcion FROM tipoconvocatorias WHERE activo = 1 ORDER BY orden";
        } else {
          $_sql = "SELECT tipoconvocatorias.descripcion FROM tipoconvocatorias WHERE id = ".$tiporequerido;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            if ($tiporequerido == 0) {
              while ($row = $_resultado->fetch_assoc()) {
                array_push($_cadena, array($row['id'],$row['descripcion']));
              }
            } else {
              $row = $_resultado->fetch_assoc();
              $_cadena = $row['descripcion'];
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        if ($tiporequerido == 0) {
          array_push($_cadena,'error');
        } else {
          $_cadena = 'error';
        }
      }
      return $_cadena;
    }
    function obtenerOfertas($inicial, $itxpag) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipoconv == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_mywhere = "ofertas_convocatorias.idconvocatoria IN (".$this->tipoconv.")";
        }
        $_sql = "SELECT ofertas.id, fechainicial, fechafinal, cargo, ofertas.descripcion, habilidades, urldestino, afuera, tipoconvocatorias.color FROM ofertas INNER JOIN ofertas_convocatorias ON ofertas.id = ofertas_convocatorias.idoferta INNER JOIN tipoconvocatorias ON ofertas_convocatorias.idconvocatoria = tipoconvocatorias.id WHERE (fechainicial = fechafinal OR fechainicial < '".Date("Y-m-d")."' OR fechafinal >= '".Date("Y-m-d")."') AND ofertas.activo = 1 AND ".$_mywhere." GROUP BY ofertas.id ORDER BY fechainicial DESC, fechafinal DESC LIMIT ".$inicial.",".$itxpag;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['cargo'],$row['descripcion'],$row['habilidades'],$row['urldestino'],$row['afuera'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Actividades {
    var $tipocale;
    var $etiqueta;
    var $minimafecha;
    var $ruta;
    function __construct($_calendario, $ruta="") {
      $this->tipocale = $_calendario;
      $this->ruta = $ruta;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT actividades.id, fechainicial, fechafinal, horainicial, horafinal, descripcion, urldestino, afuera, activo FROM actividades WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['fechainicial'];
            $_cadena[2] = $row['fechafinal'];
            $_cadena[3] = $row['horainicial'];
            $_cadena[4] = $row['horafinal'];
            $_cadena[5] = $row['descripcion'];
            $_cadena[6] = $row['urldestino'];
            $_cadena[7] = $row['afuera'];
            $_cadena[8] = $row['activo'];
            $_cadena[9] = array();
            $_sql = "SELECT idcalendario FROM actividades_calendarios WHERE idactividad = ".$id;
            $_resultado = $_mbd->bd->query($_sql);
            if ($_resultado) {
              if ($_resultado->num_rows !== 0) {
                while ($row = $_resultado->fetch_assoc()) {
                  array_push($_cadena[9], $row['idcalendario']);
                }
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function estadoActividad($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_sql = "UPDATE actividades SET activo = ".$estado." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function nuevaActividad($fechini, $fechfin, $descripcion, $url, $afuera, $calendarios, $estado, $id, $idusuario = 0) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if ($_mbd->bd) {
        if ($estado != "edicion") {
          $_sql = "INSERT INTO actividades (id, activo, fechainicial, fechafinal, descripcion, urldestino, afuera, idusuario) values (NULL, 1, \"".$fechini."\",\"".$fechfin."\",\"".str_replace("\"","\\\"",utf8_decode($descripcion))."\",\"".$url."\",".$afuera.",".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_lastid = mysqli_insert_id($_mbd->bd);
            for ($_a = 0; $_a < count($calendarios); $_a++) {
              $_sql = "INSERT INTO actividades_calendarios (idactividad, idcalendario) VALUES (".$_lastid.",".$calendarios[$_a].")";
              $_mbd->bd->query($_sql);
            }
            $_e = 2;
          }
        } else {
          $_sql = "UPDATE actividades SET fechainicial=\"".$fechini."\", fechafinal=\"".$fechfin."\", descripcion=\"".str_replace("\"","\\\"",utf8_decode($descripcion))."\", urldestino=\"".$url."\", afuera=".$afuera.", idusuario=".$idusuario." WHERE id=".$id;
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_sql = "DELETE FROM actividades_calendarios WHERE idactividad = ".$id;
            $_mbd->bd->query($_sql);
            for ($_a = 0; $_a < count($calendarios); $_a++) {
              $_sql = "INSERT INTO actividades_calendarios (idactividad, idcalendario) VALUES (".$id.",".$calendarios[$_a].")";
              $_mbd->bd->query($_sql);
            }
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function totalActividades() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios();
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        $_sql = "SELECT COUNT(*) FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad WHERE ".$_mywhere." GROUP BY actividades.id";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $_cadena = $_resultado->num_rows;
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios();
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        $_sql = "SELECT actividades.id, fechainicial, fechafinal, horainicial, horafinal, descripcion, urldestino, afuera, activo FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad WHERE ".$_mywhere." GROUP BY actividades.id ORDER BY actividades.id LIMIT ".$limiteinicial.",".$itemsxpage."";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['horainicial'],$row['horafinal'],$row['descripcion'],$row['urldestino'],$row['afuera'],$row['activo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerTipoCalendario($tiporequerido) {
      if ($tiporequerido == 0) {
        $_cadena = array();
      } else {
        $_cadena = "";
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($tiporequerido == 0) {
          $_sql = "SELECT id, descripcion FROM tipocalendarios WHERE activo = 1 ORDER BY orden";
        } else {
          $_sql = "SELECT tipocalendarios.descripcion FROM tipocalendarios WHERE id = ".$tiporequerido;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            if ($tiporequerido == 0) {
              while ($row = $_resultado->fetch_assoc()) {
                array_push($_cadena, array($row['id'],$row['descripcion']));
              }
            } else {
              $row = $_resultado->fetch_assoc();
              $_cadena = $row['descripcion'];
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        if ($tiporequerido == 0) {
          array_push($_cadena,'error');
        } else {
          $_cadena = 'error';
        }
      }
      return $_cadena;
    }
    function obtenerProximas($pagina, $itxpag) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, fechainicial, fechafinal, horainicial, horafinal, descripcion, urldestino, afuera FROM actividades WHERE fechainicial >= '".Date("Y-m-d")."' AND activo = 1 ORDER BY fechainicial, fechafinal, horainicial, horafinal LIMIT ".($pagina*$itxpag).",".($pagina*$itxpag+$itxpag);
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['horainicial'],$row['horafinal'],$row['descripcion'],$row['urldestino'],$row['afuera']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerActividades($semana) {
      if ($semana == 0) {
        $_inicio = strtotime("now");
      } else {
        $_inicio = strtotime("+".$semana." week");
      }
      $_final = strtotime("+".($semana+1)." week");
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios();
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        if ($semana == 0) {
          $this->etiqueta = "Actividades de esta semana";
        } else {
          $this->etiqueta = "Actividades de la semana del ".Date("j",$_inicio)." de ".strtolower(cmes(Date("m", $_inicio),1))." al ".Date("j",$_final)." de ".strtolower(cmes(Date("m", $_final),1));
        }
        $this->minimafecha = $_inicio;
        $_sql = "SELECT actividades.id, fechainicial, fechafinal, horainicial, horafinal, actividades.descripcion, urldestino, afuera, tipocalendarios.color FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad INNER JOIN tipocalendarios ON actividades_calendarios.idcalendario=tipocalendarios.id WHERE (fechainicial BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-d",$_final)."' OR fechafinal BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-d",$_final)."' OR fechainicial < '".Date("Y-m-d",$_inicio)."' AND fechafinal > '".Date("Y-m-d",$_final)."') AND ".$_mywhere." AND actividades.activo = 1 GROUP BY actividades.id ORDER BY fechainicial, fechafinal, horainicial, horafinal";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['horainicial'],$row['horafinal'],$row['descripcion'],$row['urldestino'],$row['afuera'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerActividadesMes($anno,$mes) {
      $_cadena = array();
      $_inicio = strtotime($anno."-".$mes."-01");
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios();
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        $this->minimafecha = $_inicio;
        $_sql = "SELECT actividades.id, fechainicial, fechafinal, horainicial, horafinal, actividades.descripcion, urldestino, afuera, tipocalendarios.color FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad INNER JOIN tipocalendarios ON actividades_calendarios.idcalendario=tipocalendarios.id WHERE (fechainicial BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-t",$_inicio)."' OR fechafinal BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-t",$_inicio)."' OR fechainicial < '".Date("Y-m-d",$_inicio)."' AND fechafinal > '".Date("Y-m-t",$_inicio)."') AND ".$_mywhere." AND actividades.activo = 1 GROUP BY actividades.id ORDER BY fechainicial, fechafinal, horainicial, horafinal";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['horainicial'],$row['horafinal'],$row['descripcion'],$row['urldestino'],$row['afuera'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerActividadesDia($fecha) {
      $_cadena = array();
      $_inicio = strtotime($fecha);
      $_mbd = new conexion('educaiton', $this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios($this->ruta);
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        $this->minimafecha = $_inicio;
        $_sql = "SELECT actividades.id, fechainicial, fechafinal, horainicial, horafinal, actividades.descripcion, urldestino, afuera, tipocalendarios.color FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad INNER JOIN tipocalendarios ON actividades_calendarios.idcalendario=tipocalendarios.id WHERE (fechainicial = '".Date("Y-m-d",$_inicio)."' OR fechafinal = '".Date("Y-m-d",$_inicio)."' OR fechainicial < '".Date("Y-m-d",$_inicio)."' AND fechafinal > '".Date("Y-m-d",$_inicio)."') AND ".$_mywhere." AND actividades.activo = 1 GROUP BY actividades.id ORDER BY fechainicial, fechafinal, horainicial, horafinal";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechainicial'],$row['fechafinal'],$row['horainicial'],$row['horafinal'],$row['descripcion'],$row['urldestino'],$row['afuera'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerFestivosMes($anno,$mes) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT DAYOFMONTH(tipofestivos.id) AS dia, descripcion FROM tipofestivos WHERE YEAR(id) = ".$anno." AND MONTH(id) = ".$mes." ORDER BY id";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['dia'],$row['descripcion']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
/*        array_push($_cadena,0);*/
      }
      return $_cadena;
    }
    function obtenerFestivosDia($fecha) {
      $_cadena = array();
      $_mbd = new conexion("cmseducaiton", $this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT descripcion FROM tipofestivos WHERE id = '".$fecha."'";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,$row['descripcion']);
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
/*        array_push($_cadena,0);*/
      }
      return $_cadena;
    }
    function obtenerDiasActivos($anno,$mes) {
      $_cadena = array();
      $_inicio = strtotime($anno."-".$mes."-01");
      for ($_a = 0; $_a < Date("t",$_inicio); $_a++) {
        $_cadena[$_a] = 0;
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipocale == 0) {
          $_mywhere = "1 > 0";
        } else {
          $_micale = new TipoCalendarios();
          $_transversales = $_micale->obtenerCalendariosTransversales();
          $_mywhere = "actividades_calendarios.idcalendario IN (".$this->tipocale.",".implode(",",$_transversales).")";
        }
        $this->minimafecha = $_inicio;
        $_sql = "SELECT fechainicial, fechafinal FROM actividades INNER JOIN actividades_calendarios ON actividades.id = actividades_calendarios.idactividad WHERE (fechainicial BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-t",$_inicio)."' OR fechafinal BETWEEN '".Date("Y-m-d",$_inicio)."' AND '".Date("Y-m-t",$_inicio)."' OR fechainicial < '".Date("Y-m-d",$_inicio)."' AND fechafinal > '".Date("Y-m-t",$_inicio)."') AND ".$_mywhere." AND activo = 1 ORDER BY fechainicial, fechafinal";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              if ($row['fechainicial'] < Date("Y-m-d",$_inicio)) {
                $_tempinicio = $_inicio;
              } else {
                $_tempinicio = strtotime($row['fechainicial']);
              }
              if ($row['fechafinal'] > Date("Y-m-t",$_inicio)) {
                $_tempfinal = strtotime(Date("Y-m-t",$_inicio));
              } else {
                $_tempfinal = strtotime($row['fechafinal']);
              }
              $_control = 1;
              while ($_control == 1) {
                if (Date("Y-m-d",$_tempinicio) <= Date("Y-m-d",$_tempfinal)) {
                  $_cadena[Date("d",$_tempinicio)-1] = 1;
                  $_tempinicio = strtotime("+1 day",$_tempinicio);
                } else {
                  $_control = 0;
                }
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
/*
        array_push($_cadena,'error');
*/
      }
      return $_cadena;
    }
  }
  class Visitantes {
    var $hoy;
    var $mes;
    var $genesis;
    function __construct() {
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT fecha, ipcliente, ipforwarded FROM visitantes ORDER BY fecha DESC LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['fecha'],$row['ipcliente'], $row['ipforwarded']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalVisitantes() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT COUNT(*) AS tantos FROM visitantes";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerVisitantes() {
      $this->hoy = 0;
      $this->mes = 0;
      $this->genesis = 0;
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT COUNT(*) AS tantos FROM visitantes WHERE fecha = '".Date("Y-m-d")."'";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            $this->hoy = $row['tantos'];
          }
          $_resultado->free();
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM visitantes WHERE fecha BETWEEN (CURDATE() - INTERVAL 30 DAY) AND CURDATE()";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            $this->mes = $row['tantos'];
          }
          $_resultado->free();
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM visitantes";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            $this->genesis = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
    }
    function grabarVisitante() {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_behind = "";
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $_behind = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $_behind = $_SERVER['HTTP_CLIENT_IP'];
          }
        }
        $_sql = "INSERT INTO visitantes (fecha, ipcliente, ipforwarded) VALUES ('".Date("Y-m-d")."','".$_SERVER['REMOTE_ADDR']."','".$_behind."')";
        $_resultado = $_mbd->bd->query($_sql);
        $_mbd->desconectar();
      }
    }
  }
  class Galerias {
    var $tipogale;
    function __construct($_mitipogale = 0) {
      $this->tipogale = $_mitipogale;
    }
    function ultimaGaleria() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT galerias.id, fechahora, titulo FROM galerias WHERE galerias.activo = 1 ORDER BY id DESC LIMIT 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechahora'],$row['titulo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena, array('error'));
      }
      return $_cadena;
    }
    function grabarNuevoOrden($idgaleria, $matriz) {
      $_cadena = 20;
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT imagenes FROM galerias WHERE id = ".$idgaleria;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_cadena = 21;
            $row = $_resultado->fetch_assoc();
            if ($row['imagenes']) {
              $_tempfield = explode("[|]",$row['imagenes']);
            } else {
              $_tempfield = array();
            }
            $_imagesgaleria = array();
            for ($_a = 0; $_a < count($_tempfield); $_a++) {
              array_push($_imagesgaleria, $_tempfield[$_a]);
            }
            $nuevomenu = array();
            $_items = explode(";",$matriz);
            $_hop = 1;
            for ($_a = 1; $_a < count($_items); $_a+=2) {
              $_orden = explode("|",$_items[$_a]);
              if (isset($_orden[1])) {
                array_push($nuevomenu, $_orden[1]);
                $_hop++;
              }
            }
            $nuevoorden = array();
            for ($_a = 0; $_a < count($nuevomenu); $_a++) {
               array_push($nuevoorden,$_imagesgaleria[$nuevomenu[$_a]-1]);
            }
            $_sql1 = "UPDATE galerias SET imagenes =\"".implode("[|]",$nuevoorden)."\" WHERE id = ".$idgaleria;
            $_resultado1 = $_mbd->bd->query($_sql1);
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      return $_cadena;
    }
    function nuevaImagen($idgaleria, $imagen, $descripcion, $sincambio, $estado, $sid) {
      if ($estado != "edicion") {
        $_cadena = 1;
      } else {
        $_cadena = 5;
      }
      $_cadena = 1;
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT imagenes FROM galerias WHERE id = ".$idgaleria;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            if ($row['imagenes']) {
              $_tempfield = explode("[|]",$row['imagenes']);
            } else {
              $_tempfield = array();
            }
            if ($estado != "edicion") {
              $_cadena = 2;
              array_push($_tempfield,$imagen."{|}".utf8_decode($descripcion));
              $_sql1 = "UPDATE galerias SET imagenes =\"".implode("[|]",$_tempfield)."\" WHERE id = ".$idgaleria;
            } else {
              $_cadena = 6;
              $_tempimages = array();
              print_r($_tempfield);
              for ($_a = 0; $_a < count($_tempfield); $_a++) {
                $_tempimagen = explode("{|}",$_tempfield[$_a]);
                if ($_a == $sid-1) {
                  if ($sincambio == 0) {
                    array_push($_tempimages, array($imagen, utf8_decode($descripcion)));
                  } else {
                    array_push($_tempimages, array($_tempimagen[0], utf8_decode($descripcion)));
                  }
                } else {
                  array_push($_tempimages, array($_tempimagen[0], $_tempimagen[1]));
                }
              }
              $_imagespegadas = array();
              for ($_a = 0; $_a < count($_tempimages); $_a++) {
                array_push($_imagespegadas,implode("{|}",$_tempimages[$_a]));
              }
              $_sql1 = "UPDATE galerias SET imagenes =\"".implode("[|]",$_imagespegadas)."\" WHERE id = ".$idgaleria;
            }
            $_resultado1 = $_mbd->bd->query($_sql1);
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      return $_cadena;
    }
    function estadoImagen($idgaleria, $idimagen) {
      $_cadena = 3;
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT imagenes FROM galerias WHERE id = ".$idgaleria;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_cadena = 4;
            $row = $_resultado->fetch_assoc();
            if ($row['imagenes']) {
              $_tempfield = explode("[|]",$row['imagenes']);
            } else {
              $_tempfield = array();
            }
            $_tempimages = array();
            for ($_a = 0; $_a < count($_tempfield); $_a++) {
              if ($_a != $idimagen - 1) {
                $_tempimagen = explode("{|}",$_tempfield[$_a]);
                array_push($_tempimages, array($_tempimagen[0], $_tempimagen[1]));
              } else {
                unlink($_tempimagen[1]);
              }
            }
            $_imagespegadas = array();
            for ($_a = 0; $_a < count($_tempimages); $_a++) {
              array_push($_imagespegadas,implode("{|}",$_tempimages[$_a]));
            }
            $_gallerypegadas = implode("[|]",$_imagespegadas);
            $_sql1 = "UPDATE galerias SET imagenes =\"".$_gallerypegadas."\" WHERE id = ".$idgaleria;
            $_resultado1 = $_mbd->bd->query($_sql1);
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      return $_cadena;
    }
    function obtenerImagenes($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT imagenes FROM galerias WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            if ($row['imagenes']) {
              $_e = 0;
              $_tempfield = explode("[|]",$row['imagenes']);
              for ($_a = 0; $_a < count($_tempfield); $_a++) {
                $_tempimagen = explode("{|}",$_tempfield[$_a]);
                array_push($_cadena, array($_a+1, $_tempimagen[0], $_tempimagen[1]));
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function nuevaGaleria($etiqueta, $titulo, $descripto, $fecha, $estado, $id, $tgale, $idusuario = 0, $sincambio) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if ($_mbd->bd) {
        if ($estado != "edicion") {
          $_sql = "INSERT INTO galerias (id, idtipogaleria, activo, fecha, thumb, titulo, descripcion, imagenes, idusuario, fechahora) values (NULL, ".$tgale.", 1, \"".$fecha."\", \"".$etiqueta."\", \"".str_replace("\"","\\\"",utf8_decode($titulo))."\", \"".str_replace("\"","\\\"",utf8_decode($descripto))."\", \"\", ".$idusuario.",\"".Date("Y-m-d H:i:s")."\")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          if ($sincambio == 1) {
            $_sql = "UPDATE galerias SET fecha =\"".$fecha."\", titulo = \"".str_replace("\"","\\\"",utf8_decode($titulo))."\", descripcion = \"".str_replace("\"","\\\"",utf8_decode($descripto))."\", idusuario=".$idusuario." WHERE id=".$id;
          } else {
            $_sql = "UPDATE galerias SET thumb = \"".$etiqueta."\", fecha =\"".$fecha."\", titulo = \"".str_replace("\"","\\\"",utf8_decode($titulo))."\", descripcion = \"".str_replace("\"","\\\"",utf8_decode($descripto))."\", idusuario=".$idusuario." WHERE id=".$id;
          }
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function estadoGaleria($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_sql = "UPDATE galerias SET activo = ".$estado." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipogaleria, activo, fecha, thumb, titulo, descripcion FROM galerias WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['idtipogaleria'];
            $_cadena[2] = $row['activo'];
            $_cadena[3] = $row['fecha'];
            $_cadena[4] = $row['thumb'];
            $_cadena[5] = $row['titulo'];
            $_cadena[6] = $row['descripcion'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerTiposGalerias($tiporequerido, $todos=1) {
      if ($tiporequerido == 0) {
        $_cadena = array();
      } else {
        $_cadena = "";
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($tiporequerido == 0) {
          $_mywhere = "1 > 0";
          if ($todos == 0) {
            $_mywhere = "activo = 1";
          }
          $_sql = "SELECT id, descripcion FROM tipogalerias WHERE ".$_mywhere." ORDER BY orden";
        } else {
          $_sql = "SELECT descripcion FROM tipogalerias WHERE id = ".$tiporequerido;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            if ($tiporequerido == 0) {
              while ($row = $_resultado->fetch_assoc()) {
                array_push($_cadena, array($row['id'],$row['descripcion']));
              }
            } else {
              $row = $_resultado->fetch_assoc();
              $_cadena = $row['descripcion'];
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        if ($tiporequerido == 0) {
          array_push($_cadena,'error');
        } else {
          $_cadena = 'error';
        }
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipogaleria, activo, fecha, thumb, titulo, descripcion FROM galerias WHERE idtipogaleria = ".$this->tipogale." LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['idtipogaleria'],$row['activo'],$row['fecha'],$row['thumb'],$row['titulo'],$row['descripcion']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalGalerias() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT COUNT(*) AS tantos FROM galerias WHERE idtipogaleria = ".$this->tipogale;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerGalerias($pagina, $solita, $itxpag = 14) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipogale == 0) {
          $_mywhere = "idtipogaleria > 0";
        } else {
          $_mywhere = "idtipogaleria = ".$this->tipogale;
        }
        if ($solita == 0) {  
          $_sql = "SELECT galerias.id, fecha, thumb, titulo, galerias.descripcion, imagenes, idtipogaleria FROM galerias INNER JOIN tipogalerias ON galerias.idtipogaleria = tipogalerias.id WHERE galerias.imagenes <> '' AND tipogalerias.activo = 1 AND galerias.activo = 1 AND ".$_mywhere." ORDER BY fecha DESC LIMIT ".($pagina*$itxpag).",".($pagina*$itxpag+$itxpag);
        } else {
          $_sql = "SELECT galerias.id, fecha, thumb, titulo, galerias.descripcion, imagenes, idtipogaleria FROM galerias INNER JOIN tipogalerias ON galerias.idtipogaleria = tipogalerias.id WHERE galerias.imagenes <> '' AND tipogalerias.activo = 1 AND galerias.activo = 1 AND galerias.id = ".$pagina;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fecha'],$row['thumb'],$row['titulo'],$row['descripcion'],$row['imagenes']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Informaciones {
    var $tipoinfo;
    function __construct($_mitipoinfo = 0) {
      $this->tipoinfo = $_mitipoinfo;
    }
    function ultimaInformacion() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT informaciones.id, fechahora, titulo FROM informaciones INNER JOIN tipoinformaciones ON informaciones.idtipoinformacion = tipoinformaciones.id WHERE tipoinformaciones.esnoticia = 1 AND informaciones.activo = 1 ORDER BY id DESC LIMIT 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fechahora'],$row['titulo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena, array('error'));
      }
      return $_cadena;
    }
    function obtenerModulosInfo() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT informaciones.id, titulo FROM informaciones INNER JOIN tipoinformaciones ON informaciones.idtipoinformacion = tipoinformaciones.id WHERE tipoinformaciones.esnoticia = 0 ORDER BY informaciones.titulo";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['titulo']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena, array('error',0));
      }
      return $_cadena;
    }
    function etiquetaModulo($id) {
      $_cadena = "";
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT titulo FROM informaciones WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['titulo'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        $_cadena = 'error';
      }
      return $_cadena;
    }
    function nuevaInformacion($etiqueta, $titulo, $texto, $textomas, $fecha, $estado, $id, $idusuario = 0, $sincambio, $clipped, $tipoinfo, $wide, $idmenu) {
      $_mbd = new conexion();
      $_mbd->conectar();   
      echo "<script>
                alert("+$textomas+");
                window.location= 'url.php'
      </script>"; 
      
      $_textomas = str_replace("// <![CDATA["," ",$textomas);
      $_textomas = str_replace("// ]]>"," ",$textomas);
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if ($wide == "") {
        $wide = 0;
      }
      if ($fecha == "") {
        $fecha = Date("Y-m-d");
      }
      if ($_mbd->bd) {
        if ($estado != "edicion") {
          $_sql = "INSERT INTO informaciones (id, idusuario, idtipoinformacion, wide, autorizado, activo, fechahora, fecha, titulo, imagen, imgclipped, texto, textomas) values (NULL, ".$idusuario.", ".$tipoinfo.", ".$wide.", 1, 1, \"".Date("Y-m-d H:i:s")."\", \"".$fecha."\", \"".utf8_decode(str_replace("\"","\\\"",$titulo))."\",\"".$etiqueta."\", \"".$clipped."\", \"".utf8_decode(str_replace("\"","\\\"",$texto))."\", \"".utf8_decode(str_replace("\"","\\\"",$_textomas))."\")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            if ($idmenu) {
              $_lastid = mysqli_insert_id($_mbd->bd);
              $_sql1 = "UPDATE menus SET urldestino = ".$_lastid." WHERE id = ".$idmenu;
              $_mbd->bd->query($_sql1);
            }
            $_e = 2;
          }
        } else {
          if ($sincambio == 1) {
            $_sql = "UPDATE informaciones SET fecha = \"".$fecha."\", wide = ".$wide.", titulo = \"".utf8_decode(str_replace("\"","\\\"",$titulo))."\", texto = \"".utf8_decode(str_replace("\"","\\\"",$texto))."\", textomas = \"".utf8_decode(str_replace("\"","\\\"",$_textomas))."\", idusuario=".$idusuario." WHERE id=".$id;
          } else {
            $_sql = "UPDATE informaciones SET imagen = \"".$etiqueta."\", imgclipped = \"".$clipped."\", fecha = \"".$fecha."\", wide = ".$wide.", titulo = \"".utf8_decode(str_replace("\"","\\\"",$titulo))."\", texto = \"".utf8_decode(str_replace("\"","\\\"",$texto))."\", textomas = \"".utf8_decode(str_replace("\"","\\\"",$_textomas))."\", idusuario=".$idusuario." WHERE id=".$id;
          }
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            if ($idmenu) {
              $_sql1 = "UPDATE menus SET urldestino = ".$id." WHERE id = ".$idmenu;
            } else {
              $_sql1 = "UPDATE menus set urldestino = \"javascript:;\" WHERE urldestino = \"".$id."\"";
            }
            $_mbd->bd->query($_sql1);
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function estadoInformacion($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_sql = "UPDATE informaciones SET activo = ".$estado." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipoinformacion, wide, autorizado, activo, fecha, titulo, imagen, imgclipped, texto, textomas FROM informaciones WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['idtipoinformacion'];
            $_cadena[2] = $row['wide'];
            $_cadena[3] = $row['autorizado'];
            $_cadena[4] = $row['activo'];
            $_cadena[5] = $row['fecha'];
            $_cadena[6] = $row['titulo'];
            $_cadena[7] = $row['imagen'];
            $_cadena[8] = $row['imgclipped'];
            $_cadena[9] = $row['texto'];
            $_cadena[10] = $row['textomas'];
            $_cadena[11] = 0;
            $_idmenu = array();
            $_sql1 = "SELECT id FROM menus WHERE urldestino = ".$row['id'];
            $_resultado1 = $_mbd->bd->query($_sql1);
            if ($_resultado1) {
              if ($_resultado1->num_rows !== 0) {
                $row1 = $_resultado1->fetch_assoc();
                $_cadena[11] = $row1['id'];
                $_resultado1->free();
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerTiposInformaciones($tiporequerido, $campo = 0) {
      if ($tiporequerido == 0) {
        $_cadena = array();
      } else {
        $_cadena = "";
      }
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($tiporequerido == 0) {
          if ($campo == 0) {
            $_sql = "SELECT id, descripcion FROM tipoinformaciones ORDER BY id";
          } else {
            $_sql = "SELECT id, descripcion FROM tipoinformaciones WHERE esnoticia = 1 AND activo = 1 ORDER BY orden";
          }
        } else {
          $_sql = "SELECT tipoinformaciones.descripcion, esnoticia FROM tipoinformaciones WHERE id = ".$tiporequerido;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            if ($tiporequerido == 0) {
              while ($row = $_resultado->fetch_assoc()) {
                array_push($_cadena, array($row['id'],$row['descripcion']));
              }
            } else {
              $row = $_resultado->fetch_assoc();
              if ($campo == 0) {
                $_cadena = $row['descripcion'];
              } elseif ($campo == 1) {
                $_cadena = $row['esnoticia'];
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        if ($tiporequerido == 0) {
          array_push($_cadena,'error');
        } else {
          $_cadena = 'error';
        }
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipoinformacion, autorizado, activo, wide, fecha, titulo, imagen, texto, textomas, idusuario FROM informaciones WHERE idtipoinformacion = ".$this->tipoinfo." ORDER BY informaciones.id LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              $_idmenu = array();
              $_sql1 = "SELECT id, etiqueta FROM menus WHERE urldestino = ".$row['id'];
              $_resultado1 = $_mbd->bd->query($_sql1);
              if ($_resultado1) {
                if ($_resultado1->num_rows !== 0) {
                  $row1 = $_resultado1->fetch_assoc();
                  array_push($_idmenu, array($row1['id'], $row1['etiqueta']));
                  $_resultado1->free();
                }
              }
              array_push($_cadena,array($row['id'],$row['idtipoinformacion'],$row['autorizado'],$row['activo'],$row['wide'],$row['fecha'],$row['titulo'],$row['imagen'],$row['texto'],$row['textomas'],$row['idusuario'],$_idmenu));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalInformaciones() {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT COUNT(*) AS tantos FROM informaciones WHERE idtipoinformacion = ".$this->tipoinfo;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function breadCrumb($tiporequerido) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT nivel, orden FROM menus WHERE urldestino = '".$tiporequerido."'";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $row = $_resultado->fetch_assoc();
            $_niveli = $row['nivel'];
            $_orden = $row['orden'];
            $_resultado->free();
            $_sql = "SELECT orden, nivel, etiqueta, urldestino, id FROM menus WHERE orden <= ".$_orden." AND activo = 1 ORDER BY orden DESC";
            $_resultado = $_mbd->bd->query($_sql);
            if ($_resultado) {
              if ($_resultado->num_rows !== 0) {
                $_e = 0;
                while ($row = $_resultado->fetch_assoc()) {
                  if ($row['nivel'] == $_niveli) {
                    array_push($_cadena,array($row['etiqueta'], $row['urldestino'], $row['id']));
                    $_niveli--;
                  }
                }
              }
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,array('error','',''));
      }
      return array_reverse($_cadena);
    }
    function obtenerInformaciones($pagina, $solita, $itxpag = 10) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        if ($this->tipoinfo == 0) {
          $_mywhere = "idtipoinformacion > 0";
        } else {
          $_mywhere = "idtipoinformacion = ".$this->tipoinfo;
        }
        if ($solita == 0) {
          $_sql = "SELECT informaciones.id, fecha, fechahora, titulo, imagen, texto, textomas, imgclipped, wide FROM informaciones INNER JOIN tipoinformaciones ON informaciones.idtipoinformacion = tipoinformaciones.id WHERE tipoinformaciones.activo = 1 AND ".$_mywhere." AND tipoinformaciones.esnoticia = 1 AND autorizado = 1 AND informaciones.activo = 1 ORDER BY fecha DESC LIMIT ".($pagina*$itxpag).",".($pagina*$itxpag+$itxpag);
        } else {
          $_sql = "SELECT informaciones.id, fecha, fechahora, titulo, imagen, texto, textomas, imgclipped, wide FROM informaciones WHERE ".$_mywhere." AND autorizado = 1 AND activo = 1 AND informaciones.id = ".$pagina;
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['fecha'],$row['fechahora'],$row['titulo'],$row['imagen'],$row['texto'],$row['textomas'],$row['imgclipped'],$row['wide']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class TipoCalendarios {
    var $ruta;
    function __construct($_ruta="") {
      $this->ruta = $_ruta;
    }
    function cantidadActividadesXCalendarios() {
      $_cadena = array();
      $_mbd = new conexion("cmseducaiton",$this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "select tipocalendarios.descripcion, actividades.id, count(*) as tantos from tipocalendarios left join actividades_calendarios on tipocalendarios.id = actividades_calendarios.idcalendario left join actividades on actividades_calendarios.idactividad = actividades.id WHERE tipocalendarios.activo = 1  group by tipocalendarios.descripcion";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['descripcion'],$row['id'],$row['tantos']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,array('error'));
      }
      return $_cadena;
    }
    function obtenerTipoCalendarios() {
      $_cadena = array();
      $_mbd = new conexion("cmseducaiton",$this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, descripcion, color FROM tipocalendarios WHERE activo = 1 AND visible = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['descripcion'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerCalendariosTransversales() {
      $_cadena = array();
      $_mbd = new conexion("cmseducaiton",$this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id FROM tipocalendarios WHERE activo = 1 AND transversal = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,$row['id']);
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
/*        array_push($_cadena,'error');*/
      }
      return $_cadena;
    }
  }
  class TipoConvocatorias {
    var $ruta;
    function __construct($_ruta="") {
      $this->ruta = $_ruta;
    }
    function obtenerTipoConvocatorias() {
      $_cadena = array();
      $_mbd = new conexion("cmseducaiton",$this->ruta);
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, descripcion, color FROM tipoconvocatorias WHERE activo = 1 AND visible = 1 ORDER BY orden";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['descripcion'],$row['color']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
  }
  class Usuario {
    var $clave;
    var $apellidos;
    var $nombres;
    var $id;
    function __construct() {
    }
    function nuevaUsuario($usuario, $apellidos, $nombres, $emilio, $tipousuario, $id, $estado, $tempassword, $idusuario = 0) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($estado != "edicion") {
        $_e = 1;
      } else {
        $_e = 5;
      }
      if ($_mbd->bd) {
        $_tempSlides = new Usuario;
        if ($estado != "edicion") {
          $_sql = "INSERT INTO usuario (id, idtipousuario, activo, nombre, apellidos, nombres, correoe, contrasenia, idusuario) values (NULL, ".utf8_decode($tipousuario).", 1, \"".utf8_decode($usuario)."\", \"".utf8_decode($apellidos)."\", \"".utf8_decode($nombres)."\", \"".utf8_decode($emilio)."\", \"".$tempassword."\", ".$idusuario.")";
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 2;
          }
        } else {
          $_sql = "UPDATE usuario SET idtipousuario = ".$tipousuario.", nombre=\"".utf8_decode($usuario)."\", apellidos=\"".utf8_decode($apellidos)."\", nombres=\"".utf8_decode($nombres)."\", correoe = \"".utf8_decode($emilio)."\" WHERE id=".$id;
          $_mbd->bd->query($_sql);
          if (mysqli_error($_mbd->bd)) {
          } else {
            $_e = 6;
          }
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function estadoUsuario($id,$estado) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 3;
      if ($_mbd->bd) {
        $_tempSlide = new Usuario;
        $_sql = "UPDATE usuario SET activo = ".$estado." WHERE id = ".$id;
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 4;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
    function obtenerTiposUsuario() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, descripcion FROM tipousuarios ORDER BY id";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['descripcion']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,"error");
      }
      return $_cadena;
    }
    function obtenerCamposXaEdicion($id) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT id, idtipousuario, activo, nombre, apellidos, nombres, correoe FROM usuario WHERE id = ".$id;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena[0] = $row['id'];
            $_cadena[1] = $row['idtipousuario'];
            $_cadena[2] = $row['activo'];
            $_cadena[3] = $row['nombre'];
            $_cadena[4] = $row['apellidos'];
            $_cadena[5] = $row['nombres'];
            $_cadena[6] = $row['correoe'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerPagina($limiteinicial, $itemsxpage) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT usuario.id, idtipousuario, tipousuarios.descripcion, activo, nombre, apellidos, nombres, correoe FROM usuario INNER JOIN tipousuarios ON usuario.idtipousuario = tipousuarios.id ORDER BY usuario.id LIMIT ".$limiteinicial.",".$itemsxpage;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena,array($row['id'],$row['idtipousuario'], $row['descripcion'], $row['activo'],$row['nombre'],$row['apellidos'],$row['nombres'],$row['correoe']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function totalUsuarios($filtro = 0) {
      $_cadena = 0;
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_filtro = "";
        if ($filtro) {
          $_filtro = " WHERE activo = 1";
        }
        $_sql = "SELECT COUNT(*) AS tantos FROM usuario".$_filtro;
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $_cadena = $row['tantos'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
//        array_push($_cadena,'error');
      }
      return $_cadena;
    }
    function obtenerUsuario($nombre) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SELECT contrasenia, apellidos, nombres, id FROM usuario WHERE nombre = '".$nombre."' AND activo = 1";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            $row = $_resultado->fetch_assoc();
            $this->clave = $row['contrasenia'];
            $this->apellidos = $row['apellidos'];
            $this->nombres = $row['nombres'];
            $this->id = $row['id'];
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
    }
    function grabarPassword($npass) {
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 2;
      if ($_mbd->bd) {
        $_sql = "UPDATE usuario SET contrasenia = '".$npass."' WHERE id = ".$this->id." AND activo = 1";
        $_mbd->bd->query($_sql);
        if (mysqli_error($_mbd->bd)) {
        } else {
          $_e = 3;
        }
        $_mbd->desconectar();
      }
      return $_e;
    }
  }
  class Reportes {
    var $fechi;
    var $fechf;
    function __construct($fechai = "", $fechaf = "") {
      $this->fechi = $fechai;
      $this->fechf = $fechaf;
    }
    function genereReporte() {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT fecha, ipcliente, ipforwarded FROM visitantes WHERE fecha BETWEEN '".$this->fechi."' AND '".$this->fechf."' ORDER BY fecha DESC";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            date_default_timezone_set('America/Bogota');
            $dataArray = array();
            $_a = 0;
            require_once './controladores/PHPExcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('SWAPIS')
                                         ->setLastModifiedBy('SWAPIS')
                                         ->setTitle('Informe de visitantes en rango de fechas')
                                         ->setSubject('Informe de visitantes en rango de fechas')
                                         ->setDescription('Informe de visitantes en rango de fechas')
                                         ->setKeywords('')
                                         ->setCategory('');
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Fecha')
                                          ->setCellValue('B1', 'IP')
                                          ->setCellValue('C1', 'IP de Proxy');
            while ($row = $_resultado->fetch_assoc()) {
              $dataArray[$_a] = array($row['fecha'], $row['ipcliente'], $row['ipforwarded']);
              $_a++;
            }
            $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A2');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Informe_visitantes_'.$this->fechi.'_'.$this->fechf.'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter->save('php://output');
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
    }
  }
  class Buscar {
    function __construct() {
    }
    function buscar($query) {
      $_cadena = array();
      $_e = 1;
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        $_sql = "SELECT tipoinformaciones.descripcion, informaciones.id, titulo, texto, textomas, esnoticia FROM informaciones INNER JOIN tipoinformaciones ON informaciones.idtipoinformacion=tipoinformaciones.id WHERE informaciones.activo = 1 AND (texto like '%".$query."%' OR textomas like '%".$query."%') ORDER BY tipoinformaciones.descripcion, titulo";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena, array($row['descripcion'],$row['id'],$row['titulo'],$row['esnoticia'],$row['texto'],$row['textomas']));
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      } 
      if ($_e == 1) {
        array_push($_cadena,array("error"));
      }
      return $_cadena;
    }
  }
  class Auxiliares {
    var $tablactual;
    function __construct($tabla="") {
      $this->tablactual = $tabla;
    }
    function obtenerAuxiliares() {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        $_sql = "SHOW TABLES LIKE 'tipo%'";
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_array()) {
              array_push($_cadena, $row[0]);
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,"error");
      }
      return $_cadena;
    }
    function obtenerRegistros($tabla) {
      $_cadena = array();
      $_mbd = new conexion();
      $_mbd->conectar();
      $_e = 1;
      if ($_mbd->bd) {
        switch($tabla) {
          case 'tipocalendarios': {
            $_sql = "SELECT id, descripcion, color, activo, visible, transversal, orden FROM ".$tabla;
            break;
          }
          case 'tipoenlaces': {
            $_sql = "SELECT id, descripcion, imgheight FROM ".$tabla;
            break;
          }
          case 'tipogalerias': {
            $_sql = "SELECT id, descripcion, activo, orden FROM ".$tabla;
            break;
          }
          case 'tipoinformaciones': {
            $_sql = "SELECT id, descripcion, esnoticia, activo, orden FROM ".$tabla;
            break;
          }
          case 'tiporedessociales': {
            $_sql = "SELECT id, etiqueta, clasefloat, clasefooter FROM ".$tabla;
            break;
          }
          case 'tipousuarios': {
            $_sql = "SELECT id, descripcion, puedeagregar, puedeautorizar, puedecambiar, puedeborrar FROM ".$tabla;
            break;
          }
          case 'tipofestivos': {
            $_sql = "SELECT id, descripcion FROM ".$tabla;
            break;
          }
          case 'tipoconvocatorias': {
            $_sql = "SELECT id, descripcion, color, activo, visible, orden FROM ".$tabla;
            break;
          }
        }
        $_resultado = $_mbd->bd->query($_sql);
        if ($_resultado) {
          if ($_resultado->num_rows !== 0) {
            $_e = 0;
            while ($row = $_resultado->fetch_assoc()) {
              array_push($_cadena, $row);
            }
          }
          $_resultado->free();
        }
        $_mbd->desconectar();
      }
      if ($_e == 1) {
        array_push($_cadena,"error");
      }
      return $_cadena;
    }
    function grabarTabla($matrizota) {
      $_mbd = new conexion();
      $_mbd->conectar();
      if ($_mbd->bd) {
        switch($matrizota['table']) {
          case 'tipoconvocatorias': {
            if ($matrizota['descripcion_']) {
              $_activo = 1;
              $_visible = 0;
              $_transversal = 0;
              if (isset($matrizota['visible_'])) {
                $_visible = 1;
              }
              if (!$matrizota['orden_']) {
                $matrizota['orden_'] = 0;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, color, activo, visible, orden) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", \"".$matrizota['color']."\", ".$_activo.", ".$_visible.", ".$matrizota['orden_'].")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_activo = 0;
                $_visible = 0;
                if (isset($matrizota['activo'.$_a])) {
                  $_activo = 1;
                }
                if (isset($matrizota['visible'.$_a])) {
                  $_visible = 1;
                }
                if (!$matrizota['orden'.$_a]) {
                  $matrizota['orden'.$_a] = 0;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", color=\"".$matrizota['color'.$_a]."\", activo=".$_activo.", visible=".$_visible.", orden=".$matrizota['orden'.$_a]." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipocalendarios': {
            if ($matrizota['descripcion_']) {
              $_activo = 1;
              $_visible = 0;
              $_transversal = 0;
              if (isset($matrizota['visible_'])) {
                $_visible = 1;
              }
              if (isset($matrizota['transversal_'])) {
                $_transversal = 1;
              }
              if (!$matrizota['orden_']) {
                $matrizota['orden_'] = 0;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, color, activo, visible, transversal, orden) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", \"".$matrizota['color']."\", ".$_activo.", ".$_visible.", ".$_transversal.", ".$matrizota['orden_'].")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_activo = 0;
                $_visible = 0;
                $_transversal = 0;
                if (isset($matrizota['activo'.$_a])) {
                  $_activo = 1;
                }
                if (isset($matrizota['visible'.$_a])) {
                  $_visible = 1;
                }
                if (isset($matrizota['transversal'.$_a])) {
                  $_transversal = 1;
                }
                if (!$matrizota['orden'.$_a]) {
                  $matrizota['orden'.$_a] = 0;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", color=\"".$matrizota['color'.$_a]."\", activo=".$_activo.", visible=".$_visible.", transversal=".$_transversal.", orden=".$matrizota['orden'.$_a]." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipoenlaces': {
            if ($matrizota['descripcion_']) {
              if (!$matrizota['altoimagen_']) {
                $matrizota['altoimagen_'] = 0;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, imgheight) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", ".$matrizota['altoimagen_'].")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                if (!$matrizota['altoimagen'.$_a]) {
                  $matrizota['altoimagen'.$_a] = 0;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", imgheight=".$matrizota['altoimagen'.$_a]." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipogalerias': {
            if ($matrizota['descripcion_']) {
              $_activo = 1;
              if (!$matrizota['orden_']) {
                $matrizota['orden_'] = 0;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, activo, orden) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", ".$_activo.", ".$matrizota['orden_'].")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_activo = 0;
                if (isset($matrizota['activo'.$_a])) {
                  $_activo = 1;
                }
                if (!$matrizota['orden'.$_a]) {
                  $matrizota['orden'.$_a] = 0;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", activo=".$_activo.", orden=".$matrizota['orden'.$_a]." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipoinformaciones': {
            if ($matrizota['descripcion_']) {
              $_activo = 1;
              $_esnoticia = 0;
              if (isset($matrizota['esnoticia_'])) {
                $_esnoticia = 1;
              }
              if (!$matrizota['orden_']) {
                $matrizota['orden_'] = 0;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, esnoticia, activo, orden) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", ".$_esnoticia.", ".$_activo.", ".$matrizota['orden_'].")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_activo = 0;
                $_esnoticia = 0;
                if (isset($matrizota['activo'.$_a])) {
                  $_activo = 1;
                }
                if (isset($matrizota['esnoticia'.$_a])) {
                  $_esnoticia = 1;
                }
                if (!$matrizota['orden'.$_a]) {
                  $matrizota['orden'.$_a] = 0;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", esnoticia=".$_esnoticia.", activo=".$_activo.", orden=".$matrizota['orden'.$_a]." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tiporedessociales': {
            if ($matrizota['etiqueta_']) {
              $_sql = "INSERT INTO ".$matrizota['table']." (id, etiqueta, clasefloat, clasefooter) VALUES (NULL, \"".utf8_decode($matrizota['etiqueta_'])."\", \"".utf8_decode($matrizota['clasefloat_'])."\", \"".utf8_decode($matrizota['clasefooter_'])."\")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_sql = "UPDATE ".$matrizota['table']." SET etiqueta=\"".utf8_decode($matrizota['etiqueta'.$_a])."\", clasefloat=\"".utf8_decode($matrizota['clasefloat'.$_a])."\", clasefooter=\"".utf8_decode($matrizota['clasefooter'.$_a])."\" WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipousuarios': {
            if ($matrizota['descripcion_']) {
              $_puedeagregar = 0;
              $_puedeautorizar = 0;
              $_puedecambiar = 0;
              $_puedeborrar = 0;
              if (isset($matrizota['puedeagregar_'])) {
                $_puedeagregar = 1;
              }
              if (isset($matrizota['puedeautorizar_'])) {
                $_puedeautorizar = 1;
              }
              if (isset($matrizota['puedecambiar_'])) {
                $_puedecambiar = 1;
              }
              if (isset($matrizota['puedeborrar_'])) {
                $_puedeborrar = 1;
              }
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion, puedeagregar, puedeautorizar, puedecambiar, puedeborrar) VALUES (NULL, \"".utf8_decode($matrizota['descripcion_'])."\", ".$_puedeagregar.", ".$_puedeautorizar.", ".$_puedecambiar.", ".$_puedeborrar.")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_puedeagregar = 0;
                $_puedeautorizar = 0;
                $_puedecambiar = 0;
                $_puedeborrar = 0;
                if (isset($matrizota['puedeagregar'.$_a])) {
                  $_puedeagregar = 1;
                }
                if (isset($matrizota['puedeautorizar'.$_a])) {
                  $_puedeautorizar = 1;
                }
                if (isset($matrizota['puedecambiar'.$_a])) {
                  $_puedecambiar = 1;
                }
                if (isset($matrizota['puedeborrar'.$_a])) {
                  $_puedeborrar = 1;
                }
                $_sql = "UPDATE ".$matrizota['table']." SET descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\", puedeagregar=".$_puedeagregar.", puedeautorizar=".$_puedeautorizar.", puedecambiar=".$_puedecambiar.", puedeborrar=".$_puedeborrar." WHERE id = ".$matrizota['idrg'.$_a];
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = ".$matrizota["idrg".$_a];
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
          case 'tipofestivos': {
            if ($matrizota['id_']) {
              $_sql = "INSERT INTO ".$matrizota['table']." (id, descripcion) VALUES (\"".utf8_decode($matrizota['id_'])."\", \"".utf8_decode($matrizota['descripcion_'])."\")";
              $_mbd->bd->query($_sql);
            }
            for ($_a = 0; $_a < $matrizota['nregistros']; $_a++) {
              if ($matrizota["rg".$_a] == 1) {
                $_sql = "UPDATE ".$matrizota['table']." SET id=\"".utf8_decode($matrizota['id'.$_a])."\", descripcion=\"".utf8_decode($matrizota['descripcion'.$_a])."\" WHERE id = '".$matrizota['idrg'.$_a]."'";
                $_mbd->bd->query($_sql);
              } else {
                $_sql = "DELETE FROM ".$matrizota['table']." WHERE id = '".$matrizota["idrg".$_a]."'";
                $_mbd->bd->query($_sql);
              }
            }
            break;
          }
        }
        $_mbd->desconectar();
      }
    }
  }
?>

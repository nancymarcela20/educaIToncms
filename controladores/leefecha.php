<?php
  include ("../modelos/modelo.php");
  include ("./funciones.php");
  if (!isset($_GET['fecha'])) {
    $_GET['fecha'] = "";
  }
  if (!isset($_GET['tipoc'])) {
    $_GET['tipoc'] = 0;
  }
  $_myInfo = new Actividades($_GET['tipoc'],"../");
  $_enlaces = $_myInfo->obtenerActividadesDia($_GET['fecha']);
  $_festivos = $_myInfo->obtenerFestivosDia($_GET['fecha']);
  if ($_enlaces[0] != "error") {
    $_eldia = Date("d",$_myInfo->minimafecha);
    $_elmes = Date("m",$_myInfo->minimafecha);
    if (substr($_eldia,0,1) == '0') {
      $_meldia = substr($_eldia,-1);
    } else {
      $_meldia = $_eldia;
    }
    $_lafecha = $_meldia." de ".cmes($_elmes, 1);
    if (isset($_festivos[0])) {
      $_lafecha .= " <i>(".utf8_encode($_festivos[0]).")</i>";
    }
    echo "      <div class=\"ufps-modal-header ufps-modal-header-red\">";
    echo "        <span class=\"ufps-modal-close\">&times;</span>";
    echo "        <h4 class=\"tituloActividades\">".$_lafecha."</h4>";
    echo "      </div>";
    echo "      <div class=\"ufps-modal-body\">";
    echo "<table width=\"100%\" border\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"margin-top:10px;\">";
    for ($_a = 0; $_a < count($_enlaces); $_a++) {
      echo "<tr>\n";
      echo "  <td style=\"width:5%;text-align:right;vertical-align:top;padding-right:5px;\"><span class=\"ufps-badge ufps-badge-gray\" style=\"background-color:".$_enlaces[$_a][8]."\">&middot;</span>";
      echo "  </td>";
      echo "  <td style=\"vertical-align:top;padding-bottom:15px;\">".utf8_encode($_enlaces[$_a][5]);
      if ($_enlaces[$_a][6]) {
        echo "  <a href=\"".$_enlaces[$_a][6]."\"";
        if ($_enlaces[$_a][7] == 1) {
          echo " target=\"_blank\"";
        }
        echo " style=\"text-decoration:none;\">[+ Leer m&aacute;s]</a>";
      }
      if ($_enlaces[$_a][1] != $_enlaces[$_a][2]) {
        echo "<br><span style=\"width:33%; font-size:0.85em; padding-top:2px; color:#2c3e50;\"><i>".utf8_encode(textoDesarrollo($_enlaces[$_a][1],$_enlaces[$_a][2]))." &nbsp; &nbsp; &nbsp; &nbsp; </i></span>\n";
      }
      echo "                      </td></tr>\n";
    }
    echo "</table>";
    echo "</div>";
  } else {
    echo "      <div class=\"ufps-modal-header\">";
    echo "        <span class=\"ufps-modal-close\">&times;</span>";
    echo "        <h4>&nbsp;</h4>";
    echo "      </div>";
    echo "      <div class=\"ufps-modal-body\">";
    if ($_GET['fecha']) {
      echo "      Lo sentimos, no pudimos obtener las actividades que se realizan en ".$_GET['fecha'];
    } else {
      echo "      Lo sentimos, para obtener las actividades del calendario el sistema debe recibir la fecha de consulta.";
    }
    echo "      </div>";
  }
?>

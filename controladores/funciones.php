<?php
  function cmes($_elmes, $_largo) {
    switch ($_elmes) {
      case 1: {
        $_sarta = 'Enero';
        break;
      }
      case 2: {
        $_sarta = 'Febrero';
        break;
      }
      case 3: {
        $_sarta = 'Marzo';
        break;
      }
      case 4: {
        $_sarta = 'Abril';
        break;
      }
      case 5: {
        $_sarta = 'Mayo';
        break;
      }
      case 6: {
        $_sarta = 'Junio';
        break;
      }
      case 7: {
        $_sarta = 'Julio';
        break;
      }
      case 8: {
        $_sarta = 'Agosto';
        break;
      }
      case 9: {
        $_sarta = 'Septiembre';
        break;
      }
      case 10: {
        $_sarta = 'Octubre';
        break;
      }
      case 11: {
        $_sarta = 'Noviembre';
        break;
      }
      case 12: {
        $_sarta = 'Diciembre';
        break;
      }
    }
    if ($_largo == 0) {
      return substr($_sarta,0,3);
    } else {
      return $_sarta;
    }
  }
  function textoDesarrollo($_fechainicial, $_fechafinal, $_modo = 0) {
    if ($_modo == 0) {
      $_sarta = "Esta actividad se ";
      $_verbo = "";
      if ($_fechainicial < Date("Y-m-d")) {
        $_sarta .= "viene desarrollando";
        $_verbo = "y se extender&aacute; ";
      } elseif ($_fechainicial > Date("Y-m-d")) {
        $_sarta .= "desarrollar&aacute;";
      } else {
        $_sarta .= "desarrolla";
      }
      if ($_fechainicial != $_fechafinal) {
        $_sarta .= " desde el ".fechaLegible($_fechainicial,0)." ".$_verbo."hasta el ".fechaLegible($_fechafinal,0);
      } else {
        $_sarta .= " el ".fechaLegible($_fechainicial,0);
      }
    } elseif ($_modo == 1) {
      $_sarta = "";
      $_verbo = "";
      if ($_fechainicial < Date("Y-m-d")) {
        $_sarta .= "viene desarrollando";
        $_verbo = "y se extender&aacute; ";
      } elseif ($_fechainicial > Date("Y-m-d")) {
        $_sarta .= "desarrollar&aacute;";
      } else {
        $_sarta .= "desarrolla";
      }
      $_sarta .= " desde el ".fechaLegible($_fechainicial,0)." ".$_verbo."hasta el ".fechaLegible($_fechafinal,0);
    }
    return $_sarta;
  }
  function fechaLegible ($_mifecha, $_larga = 0) {
    $_lafecha = strtotime($_mifecha);
    $_sarta = Date("j",$_lafecha)." de ".strtolower(cmes(Date("m",$_lafecha),1));
    if (Date("Y") != Date("Y",$_lafecha) || $_larga == 1) {
      $_sarta .= " de ".Date("Y",$_lafecha);
    }
    return $_sarta;
  }
  function calendario($year = '', $month = '', $_actividades, $_tipoc, $_festivos, $_conactividad) {
    $str = '';
    $month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
    $day_list = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $day_label = array('D','L','M','M','J','V','S');
    $day = 1;
    $today = 0;
    $month_num = $month;
    $month = cmes($month_num,1);
    if($year == date('Y') && $month_num == date('m')) {	
      // set the flag that shows todays date but only in the current month - not past or future...
      $today = date('j');
    }
    $days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
    $first_day_in_month = date('D', mktime(0,0,0, $month_num, 1, $year)); 
    $str .= '<table class="calendar">';
    $str .= '<thead>';
    $str .= '<tr><th colspan="7" style="font-size:18px;"><span style="float:left"><img src="rsc/img/rrewind.png" style="cursor:pointer;" onclick="MonthDirection(' . $month_num . ',-1,' . $_tipoc . ',' . $year . ')"></span>' . ucfirst($month) . ' ' . $year . '<span style="float:right"><img src="rsc/img/rforward.png" style="cursor:pointer;" onclick="MonthDirection(' . $month_num . ',+1,' . $_tipoc . ',' . $year . ')"></span></th></tr>';
    $str .= '<tr>';
    for($i = 0; $i < 7;$i++) {
      $str .= '<th class="cell-header">' . $day_label[$i] . '</th>';
    }
    $str .= '</tr>';
    $str .= '</thead>';
    $str .= '<tbody>';
    $_contafestivos = 0;
    while($day <= $days_in_month) {
      $str .= '<tr>';
      for($i = 0; $i < 7; $i ++) {
        $cell = '&nbsp;';
        $class = '';
        $clas1 = ' class="cell-number" ';
        if($i == 0) {
          $class = ' cell-weekend ';
          $clas1 = ' class="cell-number-white" ';
        }
        if($day == $today) {
          $class = ' cell-today ';
        }
        if ($_contafestivos < count($_festivos)) {
          if ($day == $_festivos[$_contafestivos][0]) {
            $_contafestivos++;
            $class = ' cell-weekend ';
            $clas1 = ' class="cell-number-white" ';
          }
        }
        $first_day_in_month = strtolower($first_day_in_month);
        if(($first_day_in_month == strtolower($day_list[$i]) || $day > 1) && ($day <= $days_in_month)) {
          /*
          $str .= '<td ' . $class . ' onclick="ShowEntries(event,' . $i . ',' . $day . ',\'' . $year."-".$month_num."-".$day . '\',' . $_tipoc . ')" onmouseover="ShowEntries(event,' . $i . ',' . $day . ',\'' . $year."-".$month_num."-".$day . '\',' . $_tipoc . ')" onmouseout="HideEntries();"><div ' . $clas1 . '>' . $day . '</div><div class="cell-data">' . $cell . '</div></td>';
          */
          $str .= '<td class="';
          if ($_actividades) {
            if ($_conactividad[$day-1] == 1) {
              $str .= ' cell-hover '.$class.'"';
              $str .= ' onclick="ShowModal(event,\'modal\',\'' . $year."-".$month_num."-".$day . '\',' . $_tipoc . ')" style="cursor:pointer;"';
            } else {
              $str .= $class.'"';
            }
          } else {
            $str .= $class.'"';
          }
          $str .= '><div ' . $clas1 . '>' . $day . '</div><div class="cell-data">' . $cell . '</div></td>';
          $day++;
        } else {
          $str .= '<td class="' . $class . '">&nbsp;</td>';
        }
      }
      $str .= '</tr>';
    }
    $str .= '</tbody>';
    $str .= '</table>';
    return $str;
  }
  function paginador($modulo, $limite_inicial, $maxrows, $itemsxpage, $filtroetiqueta = "", $filtro = 0) {
    $_tail = "";
    if ($filtroetiqueta != "") {
      $_tail = "&".$filtroetiqueta."=".$filtro;
    }
    $_paginas = ceil($maxrows/$itemsxpage);
    $_paginactual = $limite_inicial/$itemsxpage+1;
    $_btn1 = "href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($limite_inicial-$itemsxpage)."&ixp=".$itemsxpage.$_tail."\"";
    $_btn2 = "href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($limite_inicial+$itemsxpage)."&ixp=".$itemsxpage.$_tail."\"";
    $_btn3 = "href=\"./swapis.php?modulo=".$modulo."&mallainicial=0&ixp=".$itemsxpage.$_tail."\"";
    $_btn4 = "href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($itemsxpage*($_paginas-1))."&ixp=".$itemsxpage.$_tail."\"";
    $_cls1 = "ufps-btn-darkgray";
    $_cls2 = "ufps-btn-darkgray";
    if ($limite_inicial <= 0) {
      $_btn1 = "";
      $_cls1 = "ufps-btn-disabled";
      $_btn3 = "";
    }
    if ($limite_inicial+$itemsxpage >= $maxrows) {
      $_btn2 = "";
      $_cls2 = "ufps-btn-disabled";
      $_btn4 = "";
    }
?>
      </table>
      <div class="ufps-pagination" style="margin-top:15px; margin-bottom:15px;">
        <a <?php echo $_btn3; ?> title="Inicio" class="<?php echo $_cls1; ?> ufps-btn">[<</a>
        <a <?php echo $_btn1; ?> title="Anterior" class="<?php echo $_cls1; ?> ufps-btn"><</a>
<?php
    if ($_paginas < 15) {
      for ($_a = 0; $_a < $_paginas; $_a++) {
        $_cls = "ufps-btn-darkgray";
        if ($limite_inicial == $_a*$itemsxpage) {
          $_cls = "ufps-btn-lightgray";
        }
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
      }
    } else {
      if ($_paginactual <= 10) {
        for ($_a = 0; $_a < 10; $_a++) {
          $_cls = "ufps-btn-darkgray";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightgray";
          }
          echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
        $_cls = "ufps-btn-darkgray";
        echo "        <a class=\"ufps-btn-darkgray ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".(($_paginas-2)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas-1)."</a>";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".(($_paginas-1)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas)."</a>";
      } elseif ($_paginas-4 > $_paginactual && $_paginactual > 4) {
        $_cls = "ufps-btn-darkgray";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=0".$_tail."\" class=\"".$_cls." ufps-btn\">1</a>";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">2</a>";
        echo "        <a class=\"ufps-btn-darkgray ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        for ($_a = $_paginactual - 5; $_a < $_paginactual + 4; $_a++) {
          $_cls = "ufps-btn-darkgray";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightgray";
          }
          echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
        if (($_paginas-1) - ($_a + 1) > 0) {
          echo "        <a class=\"ufps-btn-darkgray ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        }
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".(($_paginas-2)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas-1)."</a>";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".(($_paginas-1)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas)."</a>";
      } else {
        $_cls = "ufps-btn-darkgray";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=0&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">1</a>";
        echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">2</a>";
        echo "        <a class=\"ufps-btn-darkgray ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        for ($_a = $_paginas - 10; $_a < $_paginas; $_a++) {
          $_cls = "ufps-btn-darkgray";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightgray";
          }
          echo "        <a href=\"./swapis.php?modulo=".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
      }
    }
?>
        <a <?php echo $_btn2; ?> title="Siguiente" class="<?php echo $_cls2; ?> ufps-btn">></a>
        <a <?php echo $_btn4; ?> title="Final" class="<?php echo $_cls2; ?> ufps-btn">>]</a>
      </div>
<?php
  }
  function paginadornufps($modulo, $limite_inicial, $maxrows, $itemsxpage, $filtroetiqueta = "", $filtro = 0) {
    $_tail = "";
    if ($filtroetiqueta != "") {
      $_tail = "&".$filtroetiqueta."=".$filtro;
    }
    $_paginas = ceil($maxrows/$itemsxpage);
    $_paginactual = $limite_inicial/$itemsxpage+1;
    $_btn1 = "href=\"./index.php?".$modulo."&mallainicial=".($limite_inicial-$itemsxpage)."&ixp=".$itemsxpage.$_tail."\"";
    $_btn2 = "href=\"./index.php?".$modulo."&mallainicial=".($limite_inicial+$itemsxpage)."&ixp=".$itemsxpage.$_tail."\"";
    $_btn3 = "href=\"./index.php?".$modulo."&mallainicial=0&ixp=".$itemsxpage.$_tail."\"";
    $_btn4 = "href=\"./index.php?".$modulo."&mallainicial=".($itemsxpage*($_paginas-1))."&ixp=".$itemsxpage.$_tail."\"";
    $_cls1 = "ufps-btn-darkred";
    $_cls2 = "ufps-btn-darkred";
    if ($limite_inicial <= 0) {
      $_btn1 = "";
      $_cls1 = "ufps-btn-disabled";
      $_btn3 = "";
    }
    if ($limite_inicial+$itemsxpage >= $maxrows) {
      $_btn2 = "";
      $_cls2 = "ufps-btn-disabled";
      $_btn4 = "";
    }
?>
      </table>
      <div class="ufps-pagination" style="margin-top:15px; margin-bottom:15px;">
        <a <?php echo $_btn3; ?> title="Inicio" class="<?php echo $_cls1; ?> ufps-btn">[<</a>
        <a <?php echo $_btn1; ?> title="Anterior" class="<?php echo $_cls1; ?> ufps-btn"><</a>
<?php
    if ($_paginas < 15) {
      for ($_a = 0; $_a < $_paginas; $_a++) {
        $_cls = "ufps-btn-darkred";
        if ($limite_inicial == $_a*$itemsxpage) {
          $_cls = "ufps-btn-lightred";
        }
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
      }
    } else {
      if ($_paginactual <= 10) {
        for ($_a = 0; $_a < 10; $_a++) {
          $_cls = "ufps-btn-darkred";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightred";
          }
          echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
        $_cls = "ufps-btn-darkred";
        echo "        <a class=\"ufps-btn-darkred ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".(($_paginas-2)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas-1)."</a>";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".(($_paginas-1)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas)."</a>";
      } elseif ($_paginas-4 > $_paginactual && $_paginactual > 4) {
        $_cls = "ufps-btn-darkred";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=0".$_tail."\" class=\"".$_cls." ufps-btn\">1</a>";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">2</a>";
        echo "        <a class=\"ufps-btn-darkred ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        for ($_a = $_paginactual - 5; $_a < $_paginactual + 4; $_a++) {
          $_cls = "ufps-btn-darkred";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightred";
          }
          echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
        if (($_paginas-1) - ($_a + 1) > 0) {
          echo "        <a class=\"ufps-btn-darkred ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        }
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".(($_paginas-2)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas-1)."</a>";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".(($_paginas-1)*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_paginas)."</a>";
      } else {
        $_cls = "ufps-btn-darkred";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=0&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">1</a>";
        echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">2</a>";
        echo "        <a class=\"ufps-btn-darkred ufps-btn\" style=\"cursor:default;\">&hellip;</a>";
        for ($_a = $_paginas - 10; $_a < $_paginas; $_a++) {
          $_cls = "ufps-btn-darkred";
          if (($_a+1) == $_paginactual) {
            $_cls = "ufps-btn-lightred";
          }
          echo "        <a href=\"./index.php?".$modulo."&mallainicial=".($_a*$itemsxpage)."&ixp=".$itemsxpage.$_tail."\" class=\"".$_cls." ufps-btn\">".($_a+1)."</a>";
        }
      }
    }
?>
        <a <?php echo $_btn2; ?> title="Siguiente" class="<?php echo $_cls2; ?> ufps-btn">></a>
        <a <?php echo $_btn4; ?> title="Final" class="<?php echo $_cls2; ?> ufps-btn">>]</a>
      </div>
<?php
  }
  function filasporpagina($actual, $cualotro = "", $enlacesotro = array(), $elactual = "") {
?>
    <div style="clear:both; width:95%; margin:auto; margin-top:10px; margin-bottom:15px;">
      N&uacute;mero de filas por p&aacute;gina: <select name="actxpag" onchange="cambiarpaginacion(this.value)">
        <option<?php if ($actual == 10) { echo " selected"; } ?> value="10">10</option>
        <option<?php if ($actual == 20) { echo " selected"; } ?> value="20">20</option>
        <option<?php if ($actual == 50) { echo " selected"; } ?> value="50">50</option>
      </select>
<?php
    if ($cualotro == 'tipoenlaces') {
      echo " &nbsp; &nbsp; Tipos de enlace: <select name=\"tipoenlace\" onchange=\"cambiartipoenlace(this.value)\">";
      for ($_a = 0; $_a < count($enlacesotro); $_a++) {
        $chunk = "";
        if ($enlacesotro[$_a][0] == $elactual) {
          $chunk = " selected";
        }
        echo "<option".$chunk." value=\"".$enlacesotro[$_a][0]."\">".utf8_encode($enlacesotro[$_a][1])."</option>";
      }
      echo "</select>";
    } elseif ($cualotro == 'tipoinfos') {
      echo " &nbsp; &nbsp; Tipos de informaci&oacute;n: <select name=\"tipoinformacion\" onchange=\"cambiartipoinfo(this.value)\">";
      for ($_a = 0; $_a < count($enlacesotro); $_a++) {
        $chunk = "";
        if ($enlacesotro[$_a][0] == $elactual) {
          $chunk = " selected";
        }
        echo "<option".$chunk." value=\"".$enlacesotro[$_a][0]."\">".utf8_encode($enlacesotro[$_a][1])."</option>";
      }
      echo "</select>";
    } elseif ($cualotro == 'tipogalerias') {
      echo " &nbsp; &nbsp; Tipos de galer&iacute;a: <select name=\"tipogaleria\" onchange=\"cambiartipogaleria(this.value)\">";
      for ($_a = 0; $_a < count($enlacesotro); $_a++) {
        $chunk = "";
        if ($enlacesotro[$_a][0] == $elactual) {
          $chunk = " selected";
        }
        echo "<option".$chunk." value=\"".$enlacesotro[$_a][0]."\">".utf8_encode($enlacesotro[$_a][1])."</option>";
      }
      echo "</select>";
    }
?>
    </div>
<?php
  }
  function showBreadCrumb($_camino) {
    $_cadena = "";
    if ($_camino[0][0] != "error") {
      $_cadena .= "<ul class=\"ufps-current-page\">\n";
      for ($_a = 0; $_a < count($_camino); $_a++) {
        $_chunk = "";
        if ($_a == count($_camino) - 1) {
          $_chunk = "active";
        }
        $_cadena .= "<li class=\"".$_chunk."\"><a href=\"".EnvelopeLink($_camino[$_a][1], $_camino[$_a][2])."\">".utf8_encode($_camino[$_a][0])."</a></li>";
      }
      $_cadena .= "</ul><div style=\"clear:both;\"></div>\n";
    }
    return $_cadena;
  }
  function EnvelopeLink($_link, $_pid = 0) {
    if (is_numeric($_link)) {
      $_link = "./index.php?id=".$_link;
    } else {
      if (substr($_link,0,3) == ":::") {
        $_link = "./index.php?pid=".$_pid;
      }
    }
    return $_link;
  }
  function urlImage($_campo, $_idedicion) {
    $_sarta = "";
    if ($_idedicion) {
      if ($_campo) {
        if ($_campo != "javascript:;") {
          if (!is_numeric($_campo)) {
            $_sarta = "rsc/img/urlok.png";
          } else {
            $_sarta = "rsc/img/gray.png";
          }
        } else {
          $_sarta = "rsc/img/gray.png";
        }
      } else {
        $_sarta = "rsc/img/gray.png";
      }
    } else {
      $_sarta = "rsc/img/gray.png";
    }
  }
?>

<?php ?>
<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px; border-bottom: 3px solid #aa1916; padding: 0;">
    <h1 class="pull-left" style="font-size:36px;">Buscar en el sitio web</h1>
</div>
<?php
$_myMarco = new Buscar;
$search = explode(",", "á,é,í,ó,ú,Á,É,Í,Ó,Ú,ñ,Ñ");
$replace = explode(",", "&aacute;,&eacute;,&iacute;,&oacute;,&uacute;,&Aacute;,&Eacute;,&Iacute;,&Oacute;,&Uacute;,&ntilde;,&Ntilde");
$_GET['buscar'] = str_replace($search, $replace, $_GET['buscar']);
$_enlaces = $_myMarco->buscar($_GET['buscar']);
if ($_enlaces[0][0] != "error") {
    echo "<h3>Resultados encontrados: " . number_format(count($_enlaces), 0, ".", ",") . "</h3>";
    for ($_a = 0; $_a < count($_enlaces); $_a++) {
        if ($_enlaces[$_a][3] == 1) {
            $_ellink = "./index.php?modulo=verinformacion&idinfo=" . $_enlaces[$_a][1];
        } else {
            $_ellink = "./index.php?id=" . $_enlaces[$_a][1];
        }
        $_eltextoseparado = "";
        if (($_posicion = stripos($_enlaces[$_a][4], $_GET['buscar'])) !== FALSE) {
            $_cadenatratar = strip_tags($_enlaces[$_a][4]);
        } else {
            $_cadenatratar = strip_tags($_enlaces[$_a][5]);
        }
        $_posicion = stripos($_cadenatratar, $_GET['buscar']);
        if ($_posicion > 150) {
            $_iniciocorte = $_posicion - 150;
        } else {
            $_iniciocorte = 0;
        }
        $_eltextopreparado = str_ireplace($_GET['buscar'], "<strong style=\"color:#dd1617;\">" . $_GET['buscar'] . "</strong>", substr($_cadenatratar, $_iniciocorte, 300));
        ?>
        <div>
            <span class="ufps-badge ufps-badge-gray"><?php echo utf8_encode($_enlaces[$_a][0]); ?></span>
            <h2><a href="<?php echo $_ellink; ?>"><?php echo utf8_encode($_enlaces[$_a][2]); ?></a></h2>
            <div style="float:right; width:85%;"><?php echo $_eltextopreparado; ?></div>
        </div>
        <?php
        if ($_a < count($_enlaces) - 1) {
            ?>
            <span class="row-separator"></span>
            <?php
        }
    }
    ?>
    <div style="height:20px"></div>
    <?php
} else {
    echo "<div style=\"width:90%; margin:auto; text-align:center; margin-top:20px;\">";
    echo "<h3 class=\"simple\">No se encontraron resultados con <span style=\"font-style:italic;\">" . $_GET['buscar'] . ".</h3>";
    echo "</div>";
}
?>

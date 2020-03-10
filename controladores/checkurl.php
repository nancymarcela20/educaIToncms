<?php
  if (isset($_GET['url'])) {
    if ($_GET['url']) {
      $file = $_GET['url'];
      $file_headers = @get_headers($file);
      if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        echo "<img id=\"urlstatus\" src=\"rsc/img/urlnok.png\">";
      }
      else {
        echo "<img id=\"urlstatus\" src=\"rsc/img/urlok.png\">";
      }
    }
  }
?>

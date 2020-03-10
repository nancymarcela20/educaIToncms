<?php ?>
<html>
    <head>
        <script src='js/tinymce/js/tinymce/tinymce.min.js'></script>
    </head>
    <body>
        <textarea><p style="text-align: center; font-size: 15px;"><img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110" height="97" />
  </p>
  <h1 style="text-align: center;">Welcome to the TinyMCE editor demo!</h1>
  <h5 style="text-align: center;">Note, this is not an "enterprise/premium" demo.<br>Visit the <a href="https://www.tinymce.com/pricing/#demo-enterprise">pricing page</a> to demo our premium plugins.</h5>
  <p>Please try out the features provided in this full featured example.</p>
  <p>Note that any <b>MoxieManager</b> file and image management functionality in this example is part of our commercial offering – the demo is to show the integration.</h2>

  <h2>Got questions or need help?</h2>
  <ul>
    <li>Our <a href="//www.tinymce.com/docs/">documentation</a> is a great resource for learning how to configure TinyMCE.</li>
    <li>Have a specific question? Visit the <a href="http://community.tinymce.com/forum/">Community Forum</a>.</li>
    <li>We also offer enterprise grade support as part of <a href="http://tinymce.com/pricing">TinyMCE Enterprise</a>.</li>
  </ul>

  <h2>A simple table to play with</h2>
  <table style="text-align: center;">
    <thead>
      <tr>
        <th>Product</th>
        <th>Cost</th>
        <th>Really?</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>TinyMCE</td>
        <td>Free</td>
        <td>YES!</td>
      </tr>
      <tr>
        <td>Plupload</td>
        <td>Free</td>
        <td>YES!</td>
      </tr>
    </tbody>
  </table>

  <h2>Found a bug?</h2>
  <p>If you think you have found a bug please create an issue on the <a href="https://github.com/tinymce/tinymce/issues">GitHub repo</a> to report it to the developers.</p>

  <h2>Finally ...</h2>
  <p>Don't forget to check out our other product <a href="http://www.plupload.com" target="_blank">Plupload</a>, your ultimate upload solution featuring HTML5 upload support.</p>
  <p>Thanks for supporting TinyMCE! We hope it helps you and your users create great content.<br>All the best from the TinyMCE team.</p>
        </textarea>
        <script>
            tinymce.init({
                selector: 'textarea',
                language: 'es',
                height: 500,
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
            function RoxyFileBrowser(field_name, url, type, win) {
                var roxyFileman = './controladores/fileman/index.html';
                if (roxyFileman.indexOf("?") < 0) {
                    roxyFileman += "?type=" + type;
                } else {
                    roxyFileman += "&type=" + type;
                }
                roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
                if (tinyMCE.activeEditor.settings.language) {
                    roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
                }
                tinyMCE.activeEditor.windowManager.open({
                    file: roxyFileman,
                    title: 'Roxy Fileman',
                    width: 850,
                    height: 650,
                    resizable: "yes",
                    plugins: "media",
                    media_strict: false,
                    inline: "yes",
                    close_previous: "no"
                }, {window: win, input: field_name});
                return false;
            }
        </script>
    </body>
</html>
<?php
?>

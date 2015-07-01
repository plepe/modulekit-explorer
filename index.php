<?php include "conf.php"; /* load a local configuration */ ?>
<?php include "modulekit/loader.php"; /* loads all php-includes */ ?>
<?php call_hooks("init"); /* initialize submodules */ ?>

<?php
$explorer = new Explorer($base_path);

$ex_path = $explorer->get(array_key_exists('path', $_REQUEST) ? $_REQUEST['path'] : null);
if($ex_path == null)
  $body = "File not found!";
else
  $body = $ex_path->show();

Header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Modulekit Explorer</title>
    <?php print modulekit_to_javascript(); /* pass modulekit configuration to JavaScript */ ?>
    <?php print modulekit_include_js(); /* prints all js-includes */ ?>
    <?php print modulekit_include_css(); /* prints all css-includes */ ?>
    <?php print_add_html_headers(); /* print additional html headers */ ?>
  </head>
  <body>
<? print $body; ?>
  </body>
</html>


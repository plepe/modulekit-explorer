<?php include "conf.php"; /* load a local configuration */ ?>
<?php include "modulekit/loader.php"; /* loads all php-includes */ ?>
<?php call_hooks("init"); /* initialize submodules */ ?>
<?php
$explorer = new Explorer($base_path);

$ex_path = $explorer->get(array_key_exists('path', $_REQUEST) ? $_REQUEST['path'] : null);
if($ex_path === null) {
  Header("HTTP/1.1 404 File not found");

  print "File not found!";
  exit(0);
}

Header("Content-Type: " . $ex_path->mime_type());
Header("Content-Disposition: attachment; filename=\"{$ex_path->filename}\"");
print $ex_path->raw();

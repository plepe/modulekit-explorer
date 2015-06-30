<?php
include "conf.php";

include "inc/Explorer.php";
include "inc/ExplorerPath.php";
include "inc/basic_types.php";
include "inc/basic_actions.php";

$explorer = new Explorer($base_path);

$body = print_r($explorer->get(), 1);
?>
<!DOCTYPE HTML>
<html>
  <head>
  </head>
  <body>
<? print $body; ?>
  </body>
</html>


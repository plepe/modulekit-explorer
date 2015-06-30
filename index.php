<?php
include "conf.php";

include "inc/Explorer.php";
include "inc/ExplorerPath.php";
include "inc/basic_types.php";
include "inc/basic_actions.php";

$explorer = new Explorer($base_path);

$ex_path = $explorer->get(array_key_exists('path', $_REQUEST ? $_REQUEST['path'] : null));
$body = json_encode($ex_path->content());
?>
<!DOCTYPE HTML>
<html>
  <head>
  </head>
  <body>
  <pre>
<? print $body; ?>
  </pre>
  </body>
</html>


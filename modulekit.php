<?php
$id = "modulekit-explorer";

$depend = array("hooks", "html", "modulekit-table", "weight_sort");

$include = array(
  'php' => array(
    'inc/Explorer.php',
    'inc/ExplorerPath.php',
    'inc/ExplorerFileType.php',
    'inc/ExplorerAction.php',
    'inc/*.php',
  ),
  'js' => array(
    'inc/*.js',
  ),
);

<?php
function explorer_register_basic_actions($explorer) {
  $explorer->register_action("download", array(
    'title' => "Download",
    'not_mime_types' => array("directory"),
    'link' => function($file) {
      return "raw.php?path=" . htmlspecialchars(implode("/", $file->path));
    },
    'weight' => -10,
  ));
}

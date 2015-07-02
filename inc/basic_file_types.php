<?php
function explorer_register_basic_file_types($explorer) {
  $explorer->register_file_type('directory', array(
    'mime_types' => array("directory"),
    'view' => function($file) {
      $content = $file->content();
      $table = new table(array(
        'name' => array(
	  'name' => 'Filename',
	  'link' => '?path=[path]',
	),
	'size' => array(
	  'name' => 'Size',
	),
      ), $content);

      return $table->show();
    },
    'info' => function($file) {
      return array(
        'size' => 'directory',
      );
    },
  ));

  $explorer->register_file_type('image', array(
    'mime_types' => array("image/png", "image/jpeg", "image/gif"),
    'view' => function($file) {
      return "<img style='max-width: 100%; max-height: 100%' src='raw.php?path=" . htmlspecialchars(implode("/", $file->path)) . "' />";
    },
  ));

  $explorer->register_file_type('default', array(
    'not_mime_types' => array("directory"),
    'view' => function($file) {
      return "Cannot display file";
    },
    'weight' => 10,
  ));
}

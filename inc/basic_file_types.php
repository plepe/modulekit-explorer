<?php
function explorer_register_basic_file_types($explorer) {
  $explorer->register_file_type('directory', array(
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
  ));
}

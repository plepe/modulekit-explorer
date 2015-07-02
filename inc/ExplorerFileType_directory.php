<?php
class ExplorerFileType_directory extends ExplorerFileType {
  public $mime_types = array("directory");

  function view($file) {
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
  }

  function info($file) {
    return array_merge(
      parent::info($file),
      array(
	'size' => 'directory',
      )
    );
  }
}

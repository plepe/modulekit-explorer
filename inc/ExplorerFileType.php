<?php
class ExplorerFileType {
  public $weight = 0;
  public $mime_types = array();
  public $not_mime_types = array();
  public $icon = null;

  function __construct($id, $explorer) {
    $this->id = $id;
    $this->explorer = $explorer;
  }

  function view($file) {
    return null;
  }

  function info($file) {
    return array();
  }

  function thumbnail($file) {
    return null;
  }
}

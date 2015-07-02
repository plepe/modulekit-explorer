<?php
class ExplorerAction {
  public $weight = 0;
  public $mime_types = null;
  public $not_mime_types = null;
  public $title = null;

  function __construct($id, $explorer) {
    $this->id = $id;
    $this->explorer = $explorer;
  }
}


<?php
class ExplorerFileType_default extends ExplorerFileType {
  public $not_mime_types = array("directory");
  public $weight = 10;

  function view($file) {
    return "Cannot display file";
  }
}

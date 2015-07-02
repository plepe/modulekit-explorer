<?php
class ExplorerAction_download extends ExplorerAction {
  public $weight = 10;
  public $title = "Download";
  public $not_mime_types = array("directory");

  function link($file) {
    return "raw.php?path=" . htmlspecialchars(implode("/", $file->path));
  }
}

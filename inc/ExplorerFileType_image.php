<?php
class ExplorerFileType_image extends ExplorerFileType {
  public $mime_types = array("image/png", "image/jpeg", "image/gif");

  function view($file) {
    return "<img style='max-width: 100%; max-height: 100%' src='raw.php?path=" . htmlspecialchars(implode("/", $file->path)) . "' />";
  }
}

<?php
class ExplorerFileType_plaintext extends ExplorerFileType {
  public $mime_types = array("text/plain", "text/csv", "text/html", "application/xml", "text/x-shellscript", "text/x-php");

  function view($file) {
    $ret  = "<pre wrap>\n";

    $content = $file->raw();

    if($file->mime_encoding() == "iso-8859-1")
      $content = utf8_encode($content);

    $ret .= htmlspecialchars($content);

    $ret .= "</pre>\n";

    return $ret;
  }
}

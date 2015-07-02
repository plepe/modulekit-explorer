<?php
class ExplorerAction_diff extends ExplorerAction {
  public $weight = 5;
  public $title = "Diff";
  public $mime_types = array("text/plain", "text/csv", "text/html", "application/xml", "text/x-shellscript", "text/x-php");

  function rowify($str) {
    $ret = "";

    foreach(explode("\n", $str) as $i => $row) {
      $ret .= "<div row='$i'>" . htmlspecialchars($row) . "</div>";
    }

    return $ret;
  }

  function render($file, &$result, $view) {
    $compare_file = $file->explorer->get("Desktop/x/bar/studidaten1.csv");

    $result_content = $file->raw();
    $compare_content = $compare_file->raw();

    $result  = "<div class='ExplorerAction_diff' style='position: relative; width: 100%;'>\n";

    $result = "<div id='original' style='vertical-align: top; float: left; width: 50%; display: inline-block; overflow: auto;'>" . $this->rowify($result_content) . "</div>\n" .
              "<div id='compare' style='vertical-align: top; width: 50%; display: inline-block; overflow: auto;'>" . $this->rowify($compare_content) . "</div>\n";
    $result .= "</div>\n";
  }
}

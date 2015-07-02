<?php
class ExplorerAction_diff extends ExplorerAction {
  public $weight = 5;
  public $title = "Diff";
  public $mime_types = array("text/plain", "text/csv", "text/html", "application/xml", "text/x-shellscript", "text/x-php");

  function get_diff_index($file, $compare_file) {
    $p=popen("diff --strip-trailing-cr " . $file->get_absolute_path() . " " . $compare_file->get_absolute_path(), "r");
    $line_count=0;
    while($r=fgets($p)) {
      $line_count++;
      if(eregi("([0-9]+)(,[0-9]+)?([acd])([0-9]+)(,[0-9]+)?", $r, $m)) {
        if($m[2]=="")
          $m[2]=$m[1];
        else
          $m[2]=substr($m[2], 1);
        if($m[5]=="")
          $m[5]=$m[4];
        else
          $m[5]=substr($m[5], 1);

        switch($m[3]) {
          case "a":
            $diff_index1[$m[1]  ]=array($m[3], 0, $m[5]-$m[4]+1);
            $diff_index2[$m[4]-1]=array($m[3], $m[5]-$m[4]+1, 0);
            break;
          case "d":
            $diff_index1[$m[1]-1]=array($m[3], $m[2]-$m[1]+1, 0);
            $diff_index2[$m[4]  ]=array($m[3], 0, $m[2]-$m[1]+1);
            break;
          case "c":
            $diff_index1[$m[1]-1]=array($m[3], $m[2]-$m[1]+1, $m[5]-$m[4]-$m[2]+$m[1]);
            $diff_index2[$m[4]-1]=array($m[3], $m[5]-$m[4]+1, $m[2]-$m[1]-$m[5]+$m[4]);
            break;
          default:
        }
      }
    }

    pclose($p);

    return array($diff_index1, $diff_index2);
  }

  function rowify($str, $diff_index) {
    $ret = "";

    $r = 0;
    foreach(explode("\n", $str) as $i=>$row) {
      $class = '';

      if(array_key_exists($i, $diff_index)) {
	$class = "diff_{$diff_index[$i][0]}";

	for($j = 0; $j < $diff_index[$i][2]; $j++) {
	  $ret .= "<div class='{$class}' row='{$r}'></div>";
	  $r ++;
	}
      }

      $ret .= "<div class='{$class}' row='{$r}'>" . htmlspecialchars($row) . "</div>";

      $r++;
    }

    return $ret;
  }

  function render($file, &$result, $view) {
    $compare_file = $file->explorer->get("Desktop/x/bar/studidaten1.csv");

    $result_content = $file->raw();
    $compare_content = $compare_file->raw();

    $diff_index = $this->get_diff_index($file, $compare_file);

    $result  = "<div id='ExplorerAction_diff' style='position: relative; width: 100%;'>\n";

    $result = "<div id='original' style='vertical-align: top; float: left; width: 50%; display: inline-block; overflow: auto;'>" . $this->rowify($result_content, $diff_index[0]) . "</div>\n" .
              "<div id='compare' style='vertical-align: top; width: 50%; display: inline-block; overflow: auto;'>" . $this->rowify($compare_content, $diff_index[1]) . "</div>\n";
    $result .= "</div>\n";
  }
}

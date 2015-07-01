<?php
class ExplorerPath {
  function __construct($filename, $parent) {
    if($filename == null) {
      $this->filename = "/";
      $this->parent = null;
      $this->base_path = $parent->base_path;
      $this->path = array();
      $this->explorer = $parent;
    }
    else {
      $this->filename = $filename;
      $this->parent = $parent;
      $this->base_path = $parent->base_path . "/" . $filename;
      $this->path = array_merge($parent->path, array($filename));
      $this->explorer = $parent->explorer;
    }
  }

  function get_absolute_path() {
    if($this->parent === null)
      return $this->base_path;

    return $this->parent->get_absolute_path() . "/" . $this->filename;
  }

  function content() {
    $ret = array();
    $abs_path = $this->get_absolute_path();

    if(is_dir($abs_path)) {
      $f = opendir($abs_path);

      while($r = readdir($f)) {
	$ret[] = array(
	  'name' => $r,
	  'size' => filesize("{$abs_path}/{$r}"),
	);
      }

      closedir($f);
    }

    return $ret;
  }

  function render($view='view') {
    $type = $this->explorer->get_file_type('directory'); //$this->type[0]);

    if(array_key_exists($view, $type))
      return $type[$view]($this);

    return null;
  }

  function get($path) {
    if(preg_match("/^([^\/]*)\/(.*)$/", $path, $m)) {
      if($m[2] == "") {
	$filename = $m[1];
      }
      else {
	$filename = $m[1];
	$sub_path = $m[2];
      }
    }
    else
      $filename = $path;

    if(!file_exists($this->get_absolute_path()))
      return null;

    $sub = new ExplorerPath($filename, $this);

    if(!isset($sub_path))
      return $sub;
    else
      return $sub->get($m[2]);
  }
}

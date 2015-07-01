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

    $this->children_cache = array();
  }

  function get_absolute_path() {
    if($this->parent === null)
      return $this->base_path;

    return $this->parent->get_absolute_path() . "/" . $this->filename;
  }

  function children() {
    $abs_path = $this->get_absolute_path();

    if(is_dir($abs_path)) {
      $f = opendir($abs_path);

      while($r = readdir($f)) {
	if(!array_key_exists($r, $this->children_cache))
	  $this->children_cache[$r] = new ExplorerPath($r, $this);
      }

      closedir($f);
    }

    return array_values($this->children_cache);
  }

  function content() {
    $ret = array();

    foreach($this->children() as $child) {
      $ret[] = $child->info();
    }

    return $ret;
  }

  function info() {
    $abs_path = $this->get_absolute_path();

    return array(
      'path' => implode("/", $this->path),
      'name' => $this->filename,
      'size' => filesize($abs_path),
    );
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

    if(!array_key_exists($filename, $this->children_cache)) {
      if(!file_exists($this->get_absolute_path()))
	return null;

      $this->children_cache[$filename] = new ExplorerPath($filename, $this);
    }

    if(!isset($sub_path))
      return $this->children_cache[$filename];
    else
      return $this->children_cache[$filename]->get($m[2]);
  }
}

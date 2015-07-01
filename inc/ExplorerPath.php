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
    $this->types_cache = null;
  }

  function mime_type() {
    return finfo_file($this->explorer->finfo, $this->get_absolute_path());
  }

  function types() {
    if($this->types_cache !== null)
      return $this->types_cache;

    $this->types_cache = array();
    foreach($this->explorer->registered_file_types() as $type_id=>$type) {
      if(array_key_exists('mime_types', $type))
	if(!in_array($this->mime_type(), $type['mime_types']))
	  continue;

      if(array_key_exists('not_mime_types', $type))
	if(in_array($this->mime_type(), $type['not_mime_types']))
	  continue;

      if(array_key_exists('match', $type))
	if(!$type['match']($this))
	  continue;

      $this->types_cache[$type_id] = $type;
    }

    weight_sort($this->types_cache);

    return $this->types_cache;
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
	if(($r == ".") || ($r == ".."))
	  continue;

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

    $ret = array(
      'path' => implode("/", $this->path),
      'name' => $this->filename,
      'size' => filesize($abs_path),
    );

    foreach($this->types() as $type) {
      if(array_key_exists('info', $type))
	$ret = array_merge($ret, $type['info']($this));
    }

    return $ret;
  }

  function render($view='view') {
    $type = $this->explorer->get_file_type('directory'); //$this->type[0]);

    if(array_key_exists($view, $type))
      return $type[$view]($this);

    return null;
  }

  function show($view='view') {
    return $this->render($view);
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

    if(($filename == ".") || ($filename == ".."))
      return null;

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

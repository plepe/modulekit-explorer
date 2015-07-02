<?php
class ExplorerPath {
  function __construct($filename, $parent) {
    if($filename == null) {
      $this->filename = "root";
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
    $this->actions_cache = null;
  }

  function mime_type() {
    return finfo_file($this->explorer->finfo, $this->get_absolute_path());
  }

  function types() {
    if($this->types_cache !== null)
      return $this->types_cache;

    $this->types_cache = array();
    foreach($this->explorer->registered_file_types() as $type_id=>$type) {
      if($type->mime_types)
	if(!in_array($this->mime_type(), $type->mime_types))
	  continue;

      if($type->not_mime_types)
	if(in_array($this->mime_type(), $type->not_mime_types))
	  continue;

      if(method_exists($type, 'match'))
	if(!$type->match($this))
	  continue;

      $this->types_cache[$type_id] = $type;
    }

    weight_sort($this->types_cache);

    return $this->types_cache;
  }

  function actions() {
    if($this->actions_cache !== null)
      return $this->actions_cache;

    $this->actions_cache = array();
    foreach($this->explorer->registered_actions() as $action_id=>$action) {
      if($action->mime_types)
	if(!in_array($this->mime_type(), $action->mime_types))
	  continue;

      if($action->not_mime_types)
	if(in_array($this->mime_type(), $action->not_mime_types))
	  continue;

      if(method_exists($action, 'match'))
	if(!$action->match($this))
	  continue;

      $this->actions_cache[$action_id] = $action;
    }

    weight_sort($this->actions_cache);

    return $this->actions_cache;
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

	if(!is_readable("{$abs_path}/{$r}"))
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
      $ret = array_merge($ret, $type->info($this));
    }

    return $ret;
  }

  function render($view='view') {
    foreach($this->types() as $type) {
      return $type->view($this);
    }

    return null;
  }

  function show_actions() {
    $ret  = "<ul class='actions'>\n";
    foreach($this->actions() as $action_id=>$action) {
      if(method_exists($action, 'link'))
	$link = $action->link($this);
      else
	$link = "?path=" . htmlspecialchars(implode("/", $this->path)) . "&amp;action=" . htmlspecialchars($action_id);

      $ret .= "<li><a href='{$link}'>{$action->title}</a></li>";
    }
    $ret .= "</ul>\n";

    return $ret;
  }

  function show_path() {
    $ret  = "<div class='path'>\n";
    $parts = array();
    $p = $this;
    while($p) {
      $parts = array_merge(array(
        "<a href='?path=" . htmlspecialchars(implode("/", $p->path)) . "'>" . htmlspecialchars($p->filename) . "</a>"
      ), $parts);

      $p = $p->parent;
    }
    $ret .= implode(" / ", $parts);
    $ret .= "</div>\n";

    return $ret;
  }

  function show($view='view') {
    $ret  = "<div class='show {$view}'>\n";
    $ret .= $this->show_actions();
    $ret .= $this->show_path();
    $ret .= "<div class='content'>\n";
    $ret .= $this->render($view);
    $ret .= "</div>\n";
    $ret .= "</div>\n";

    return $ret;
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

  function raw() {
    return file_get_contents($this->get_absolute_path());
  }
}

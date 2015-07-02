<?php
class Explorer {
  function __construct($base_path, $options=array()) {
    $this->base_path = $base_path;
    $this->options = $options;

    $this->file_types = array();
    $this->actions = array();

    explorer_register_basic_file_types($this);
    explorer_register_basic_actions($this);

    $this->finfo = finfo_open(FILEINFO_MIME_TYPE);
  }

  function get($path=null) {
    if(!isset($this->root))
      $this->root = new ExplorerPath(null, $this);

    if(($path === null) || ($path === ""))
      return $this->root;
    else
      return $this->root->get($path);
  }

  function register_file_type($id, $class) {
    $this->file_types[$id] = new $class($id, $this);
  }

  function get_file_type($id) {
    return $this->file_types[$id];
  }

  function registered_file_types() {
    return $this->file_types;
  }

  function register_action($id, $class) {
    $this->actions[$id] = new $class($id, $this);
  }

  function get_action($id) {
    return $this->actions[$id];
  }

  function registered_actions() {
    return $this->actions;
  }

  function show() {
    $param = $_REQUEST;

    $ex_path = $this->get(array_key_exists('path', $param) ? $param['path'] : null);

    if($ex_path == null)
      return "File not found!";

    return $ex_path->show();
  }
}

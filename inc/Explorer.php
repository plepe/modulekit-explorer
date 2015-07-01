<?php
class Explorer {
  function __construct($base_path, $options=array()) {
    $this->base_path = $base_path;
    $this->options = $options;

    $this->file_types = array();
    $this->actions = array();

    explorer_register_basic_file_types($this);

    $this->finfo = finfo_open(FILEINFO_MIME_TYPE);
  }

  function get($path=null) {
    if(!isset($this->root))
      $this->root = new ExplorerPath(null, $this);

    if($path === null)
      return $this->root;
    else
      return $this->root->get($path);
  }

  function register_file_type($id, $options) {
    $this->file_types[$id] = $options;
  }

  function get_file_type($id) {
    return $this->file_types[$id];
  }

  function registered_file_types() {
    return $this->file_types;
  }

  function register_action($id, $options) {
    $this->actions[$id] = $options;
  }
}

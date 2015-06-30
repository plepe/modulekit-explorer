<?php
class Explorer {
  function __construct($base_path, $options=array()) {
    $this->base_path = $base_path;
    $this->options = $options;

    $this->file_types = array();
    $this->actions = array();
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

  function register_action($id, $options) {
    $this->actions[$id] = $options;
  }
}

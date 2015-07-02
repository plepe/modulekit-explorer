<?php
function explorer_register_basic_file_types($explorer) {
  $explorer->register_file_type('directory', 'ExplorerFileType_directory');
  $explorer->register_file_type('image', 'ExplorerFileType_image');
  $explorer->register_file_type('default', 'ExplorerFileType_default');
  $explorer->register_file_type('default', 'ExplorerFileType_plaintext');
}

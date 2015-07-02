<?php
function explorer_register_basic_actions($explorer) {
  $explorer->register_action('download', 'ExplorerAction_download');
}

<?php
function explorer_register_basic_actions($explorer) {
  $explorer->register_action('download', 'ExplorerAction_download');
  $explorer->register_action('diff', 'ExplorerAction_diff');
}

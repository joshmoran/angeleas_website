<?php
function global_test()
{
  $msg = "local variable";
  echo 'local msg: ' . $msg . "\n";
  echo 'global msg: ' . $GLOBALS["msg"] . "\n";
}

$msg = "global variable";
global_test();
?>
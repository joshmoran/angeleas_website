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

CREATE USER 'angelauser'@'localhost' IDENTIFIED BY 'sMwUK8DgC6mPjuXFscY9zYN3xX743Zs5SRwszAC8NFTWEf8C8E82mfMDiGcWsPYV3oPEsmhdizzpqi8GpwdiJNf326NZ3vGZA4gT';

GRANT ALL PRIVILEGES ON angeladb.* TO 'angelauser'@'localhost';
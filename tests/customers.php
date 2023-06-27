<?php

echo 'yeds;';
require "src/model/customer.php";
use store\model;

$customer = new model\customer();
$customer->setName('Josh');
echo '<br>The customers name is ' . $customer->getName();

var_dump($customer);

?>

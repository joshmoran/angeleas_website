<?php

session_start();

echo 'Basket ID is ' . $_SESSION['basket_id'] . '<br>';
echo 'Customer ID is ' . $_SESSION['customer_id'] . '<br>';
echo 'Currently logged in ' . $_SESSION['loggedIn'] . '<br>';
echo 'Username of active user ' . $_SESSION['username'] . '<br>';

?> c
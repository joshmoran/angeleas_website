<?php

session_start();
$_SESSION['admin'] = true;

echo $_SESSION['admin'];

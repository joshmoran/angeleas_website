<?php

echo  "The register_globals value is " . ini_get('register_globals');

session_start();
$name = 'josh kelly';
$color = $_SESSION["color"];

print '<form action="sessionview.php" method="post">';
print 'What is your name? ';
print '<input name="name" type="text" value="' . $name . '" /><br/>';
print 'What is your favorite color? ';
print '<input name="color" type="text" value="' . $color . '" /><br/>';
print '<input type="submit"/ >';
print '<input type="submit" name="clear" value="Clear Details" />';
?>
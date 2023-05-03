<?php
session_start();
echo $_SESSION['customer_id'];
$pass = '$2y$10$NmlWw7N8AeXssEjJ0BIYW.MVHnYK5TW3htdFBcfU6fSH/TQTnc75y';

if ( password_verify( 'password', $pass)) {
	echo "passwords match";	
} else {
	echo "passwords DO NOT match";	
}
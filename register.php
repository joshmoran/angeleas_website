<?php

require 'src/functions.php';
function randomNumber() {
    return random_int(0, 9999999999);
}

if (isset($_POST['register'])) {
    require "src/database.php";

    echo 'yes,, yes, yes';

	$firstName = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
	$lastName = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));

    $postEmail = $_POST['email'];

	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
	$home = trim(filter_input(INPUT_POST, 'phoneHome', FILTER_SANITIZE_NUMBER_INT));
	$mobile = trim(filter_input(INPUT_POST, 'phoneMobile', FILTER_SANITIZE_NUMBER_INT));

	//$dob = trim(filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_NUMBER_INT));

    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

	// Important Values - |first_name, last_name, $email, username, password

    //Checking if customer id already exists

    do {
        $customerNo = randomNumber();

        $sqlCheckID = "SELECT customer_id from customers where customer_id = " . $customerNo;
        $checkID = mysqli_query($db, $sqlCheckID);

        $count = mysqli_fetch_array($checkID);
    } while ( $count['cnt'] = 0  );

	$sqlCustomer = "INSERT INTO customers VALUES ('$customerNo', '$firstName', '$lastName', '$email', '$address', '$home', '$mobile')";

    if( mysqli_query($db, $sqlCustomer) ) {
        $error_message = 'Successfully added to customers';
    } else {
        $error_message = 'Could not add to Customers';
        return false;
    }

    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlAccount = "INSERT INTO accounts VALUES ( '$customerNo', '$username', '$encryptedPassword');";

    if( mysqli_query($db, $sqlAccount) ) {
        $error_message = 'Successfully added to Accounts';
    } else {
        $error_message = 'Could not add to Accounts';
        return false;
    }

    do {
        $basketNo = randomNumber();
        $sqlBasket = "SELECT count(*) as count from cart where basket_id = " . $basketNo;
        $checkBasket = mysqli_query($db, $sqlBasket);
        $count = mysqli_fetch_array($checkBasket);
    } while ( $count['count'] = 0 );

    $sqlCart = "INSERT INTO orders VALUES ( '$basketNo', '$customerNo', null, false )";

    if( mysqli_query($db, $sqlCart) ) {
        $error_message = 'Successfully added to Cart';
    } else {
        $error_message = 'Could not add to Cart';
        return false;
    }

    $_SESSION['customer_id'] = $customerNo;
    $_SESSION['basket_id'] = $basketNo;
    $_SESSION['loggedIn'] = true;
	$_SESSION['username'] = $username;

    header("Location: account.php");
	die();
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Template</title>
	<link type="text/css" href="src/css/css.css" rel="stylesheet" />
</head>

<body>
	<?php
	include "inc/header.php";
	?>
	<div id-"container">
		<div id="messages">
			<?php
			if (isset($error_message)) {
				echo '<p class="message">' . $error_message . '</p>';
			}
			?>
		</div>
		<div>
			<h2>Already have an account?</h2>
			<a href="login.php">Login</a>
		</div>
		<form method="post" action="">
			<table>

				<tr>
					<th colspan="2">
						<h2>Registration</h2>
					</th>
				</tr>
				<tr>
					<td><label for="firstname">First name: </label></td>
					<td><input type="text" name="firstname" value="" /></td>
				</tr>
				<tr>
					<td><label for="lastname">Last Name: </label></td>
					<td><input type="text" name="lastname" value="" /></td>
				</tr>
				<tr>
					<td><label for="email">Email: </label></td>
					<td><input type="text" name="email" value="" /></td>
				</tr>
				<tr>
					<td><label for="address">Address: </label></td>
					<td><input type="text" name="address" /></td>
				</tr>`
				<tr>
					<td><label for="phoneHome">Home Phone Number:</label></td>
					<td><input type="text" name="phoneHome" value="" /></td>
				</tr>
				<tr>
					<td><label for="phoneMobile">Mobile Number</label></td>
					<td><input type="text" name="phoneMobile" value="" /></td>
				</tr>
				<tr>
					<td><label for="dob">Date of birth:</label></td>
					<td><input type="text" name="dob" value="" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<h3>Account Details:</h3>
					</td>
				</tr>
				<tr>
					<td><label for="username">Username:</label></td>
					<td><input type="text" name="username" value="" required /></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" name="password" value="" required /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="register" value="Register" /></td>
				</tr>
			</table>
		</form>
	</div>
	<?php
	include "inc/footer.php";
	?>
	<script type="text/javascript" src="src/js/js.js"></script>
</body>

</html>
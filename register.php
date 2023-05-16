<?php
session_start();

require 'src/functions.php';
function randomNumber() {
    return random_int(0, 9999999999);
}
$customerNo;

if (isset($_POST['register'])) {
    require "src/database.php";

    echo 'yes,, yes, yes';

	$firstName = htmlspecialchars( $_POST['firstname']);
	$lastName = htmlspecialchars( $_POST['lastname']);
	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$home = trim(filter_input(INPUT_POST, 'phoneHome', FILTER_SANITIZE_NUMBER_INT));
	$mobile = trim(filter_input(INPUT_POST, 'phoneMobile', FILTER_SANITIZE_NUMBER_INT));
	$dob = trim(filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_NUMBER_INT));

	$cardnumber = trim( filter_input( INPUT_POST, 'cardnumber', FILTER_SANITIZE_NUMBER_INT));
	$cardexpiry = trim( filter_input( INPUT_POST, 'expiry', FILTER_SANITIZE_NUMBER_INT));

	$address_1st = htmlspecialchars( $_POST['1st_line']);
	$address_2nd = htmlspecialchars( $_POST['2nd_line']);
	$address_3rd = htmlspecialchars( $_POST['3rd_line']);
	$region = htmlspecialchars( $_POST['region']);
	$postcode = htmlspecialchars( $_POST['postcode']);

    $username = htmlspecialchars( $_POST['username']);
	$password = htmlspecialchars( $_POST['password']);

	// Important Values - |first_name, last_name, $email, username, password

    //Checking if customer id already exists

	// for table -- customers
    do {
        $customerNo = randomNumber();

        $sqlCheckID = "SELECT customer_id from customers where customer_id = " . $customerNo;
        $checkID = mysqli_query($db, $sqlCheckID);

        $count = mysqli_fetch_array($checkID);
    } while ( $count['cnt'] = 0  );

	$sqlCustomer = "INSERT INTO customers VALUES ('$customerNo', '$firstName', '$lastName', '$email', '$home', '$mobile')";

    if( mysqli_query($db, $sqlCustomer) ) {
        $error_message = 'Successfully added to customers';
    } else {
        $error_message = 'Could not add to Customers';
        return false;
    }

	// for table -- accounts
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlAccount = "INSERT INTO accounts VALUES ( '$customerNo', '$username', '$encryptedPassword');";

    if( mysqli_query($db, $sqlAccount) ) {
        $error_message = 'Successfully added to Accounts';
    } else {
        $error_message = 'Could not add to Accounts';
        return false;
    }
	// for table -- cart
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
	// for table -- credit_cards
	$sqlCards = "INSERT INTO credit_cards VALUES ( '$customerNo', '$cardnumber', '$cardexpiry' )";

	
	if (mysqli_query( $db, $sqlCards)){
		$error_message = 'Successfully added to Cards';
	} else {
		$error_message = 'Could not add to Cards';
        return false;
	}

	// for table -- $address
	$sqlAddress = "INSERT INTO address VALUES ( '$customerNo', '$address_1st', '$address_2nd', '$address_3rd', '$region', '$postcode' )";

    if( mysqli_query($db, $sqlAddress) ) {
        $error_message = 'Successfully added to Addresses';
    } else {
        $error_message = 'Could not add to Addresses';
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
						<h3>Card Number</h3>
					</td>
				</tr>
				<tr>
					<td><label for="cardnumber">Card Number: </label></td>
					<td><input type="number" name="cardnumber" maxlength="16" value="" /></td>
				</tr>
				<tr>
					<td><label for="expiry">Expiry: </label></td>
					<td><input type="date" name="expiry" value="" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<h3>Address</h3>
					</td>
				</tr>
				<tr>
					<td><label for="1st_line">1st Line : </label></td>
					<td><input type="text" name="1st_line" value="" /></td>
				</tr>
				<tr>
					<td><label for="2nd_line">2nd Line: </label></td>
					<td><input type="text" name="2nd_line" value="" /></td>
				</tr>
				<tr>
					<td><label for="3rd_line">3rd Line: </label></td>
					<td><input type="text" name="3rd_line" value="" /></td>
				</tr>
				<tr>
					<td><label for="region">Region: </label></td>
					<td><input type="text" name="region" value="" /></td>
				</tr>
				<tr>
					<td><label for="postcode">Postcode: </label></td>
					<td><input type="text" name="postcode" value="" /></td>
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
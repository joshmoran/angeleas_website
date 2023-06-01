<?php
session_start();

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require 'src/functions.php';
require 'src/random_number.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['register'])) {
		require "src/database.php";

		$errors = 0;

		function checkemail($str)
		{
			return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
		}

		// required
		// FIRST NAME 
		// LAST NAME 
		// Email

		// USERNAME 
		// PASSWORD

		// Import Customers details from the form
		$firstName = trim(mysqli_real_escape_string($db, $_POST['firstname']));
		$lastName = trim(mysqli_real_escape_string($db, $_POST['lastname']));
		$email = trim(mysqli_real_escape_string($db, $_POST['email']));
		$home = trim(mysqli_real_escape_string($db, $_POST['phoneHome']));
		$mobile = trim(mysqli_real_escape_string($db, $_POST['phoneMobile']));
		// Check Requirements for inputted values meet the Requirements

		// FIRST NAME 
		if (strlen($firstName) <= 3 || $firstName == null || $firstName == '') {
			$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
			$errors++;
		}

		// LAST NAME
		if (strlen($lastName) <= 3 || $lastName == null || $lastName == '') {
			$errorLastName = 'Last Name is required and must not be empty or less than 3 characters.';
			$errors++;
		}

		// EMAIL - CHECK IF VALID EMAIL ADDRESS
		$regex = '/\b[a-z0-9-_.]+@[a-z0-9-_.]+(\.[a-z0-9]+)+/';
		if (checkemail($email) === false || strlen($email) == '' || $email == null) {
			$errorEmail = 'Email is required and must be a valid email address.';
			$errors++;
		}

		// HOME NUMBER - ONLY CHECK IF INPUT IS ENTERED
		if (strlen($home) != 11 || strlen($home) > 1) {
			$errorPhone = 'Please enter a valid home phone number. Region (5 characters) and the extension (6 characters).';
			$errors++;
		}

		// MOBILE NUMBER - ONLY CHECK IF INPUT IS ENTERED
		if (strlen($mobile) != 11 || strlen($mobile) > 1) {
			$errorMobile = 'Please enter a valid mobile phone number. Please use 0 at the start';
			$errors++;
		}


		$address_1st = htmlspecialchars($_POST['1st_line']);
		$address_2nd = htmlspecialchars($_POST['2nd_line']);
		$address_3rd = htmlspecialchars($_POST['3rd_line']);
		$region = htmlspecialchars($_POST['region']);
		$postcode = htmlspecialchars($_POST['postcode']);

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		// Important Values - |first_name, last_name, $email, username, password

		//Checking if customer id already exists


		if ($errors == 0) {
			// for table -- customers
			do {
				$customerNo = randomNumber();

				$sqlCheckID = "SELECT customer_id from customers where customer_id = " . $customerNo;
				$checkID = mysqli_query($db, $sqlCheckID);
			} while (mysqli_num_rows($checkID) > 0);

			// if (strlen($address_1st) >= 1 || $address_1st != null || $address_1st != '' || strlen($postcode) >= 1 || $postcode != null || $postcode != '' || strlen($region) >= 1 || $region != null || $region != '') {
			$addressIm = $address_1st . ', ' . $address_2nd . ', ' . $address_3rd . ', ' . $region . ',' . $postcode;
			$sqlCustomer = "INSERT INTO customers VALUES ('$customerNo', '$firstName', '$lastName', '$email', '$addressIm', '$home', '$mobile')";

			if (mysqli_query($db, $sqlCustomer)) {
				$error_message = 'Successfully added to customers';
			} else {
				$error_message = 'Could not add to Customers';
				return false;
			}
			// }

			// for table -- accounts
			$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
			$sqlAccount = "INSERT INTO accounts VALUES ( '$customerNo', '$username', '$encryptedPassword')";

			if (mysqli_query($db, $sqlAccount)) {
				$error_message = 'Successfully added to Accounts';
			} else {
				$error_message = 'Could not add to Accounts';
				return false;
			}
			// for table -- cart
			do {
				$basketNo = randomNumber();
				$sqlBasket = "SELECT order_id from orders where order_id = " . $basketNo;
				$checkBasket = mysqli_query($db, $sqlBasket);
			} while (mysqli_num_rows($checkBasket) > 0);

			$sqlCart = "INSERT INTO orders VALUES ( '$basketNo', '$customerNo', null, false )";

			if (mysqli_query($db, $sqlCart)) {
				$error_message = 'Successfully added to Cart';
			} else {
				$error_message = 'Could not add to Cart';
				return false;
			}

			// for table -- $address
			$sqlAddress = "INSERT INTO address VALUES ( '$customerNo', '$address_1st', '$address_2nd', '$address_3rd', '$region', '$postcode' )";

			if (mysqli_query($db, $sqlAddress)) {
				$error_message = 'Successfully added to Addresses';
			} else {
				$error_message = 'Could not add to Addresses';
				return false;
			}

			$_SESSION['customer_id'] = $customerNo;
			$_SESSION['basket_id'] = $basketNo;
			$_SESSION['loggedIn'] = true;
			$_SESSION['admin'] = false;
			header("Location: account.php");
			die();
		} else {
			$error_message = 'Their has been a problem submitting your registration if this problem persists please contact the system administrator';
			return false;
		}
	}
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
			<p>Address and credit cards can be added later, through the account portal and through the basket</ </div>
			<form method="post" action="register.php">
				<table>

					<tr>
						<th colspan="3">
							<h2>Registration</h2>
						</th>
					</tr>
					<tr>
						<td><label for="firstname">First name: </label></td>
						<td><input type="text" name="firstname" value="" /></td>
						<td><?php if (isset($errorFirstName)) {
								echo $errorFirstName;
							} ?></td>
					</tr>
					<tr>
						<td><label for="lastname">Last Name: </label></td>
						<td><input type="text" name="lastname" value="" /></td>
						<td><?php if (isset($errorLastName)) {
								echo $errorLastName;
							} ?></td>
					</tr>
					<tr>
						<td><label for="email">Email: </label></td>
						<td><input type="text" name="email" value="" /></td>
						<td><?php if (isset($errorEmail)) {
								echo $errorEmail;
							} ?></td>
					</tr>
					<tr>
						<td><label for="phoneHome">Home Phone Number:</label></td>
						<td><input type="text" name="phoneHome" value="" /></td>
						<td><?php if (isset($errorPhone)) {
								echo $errorPhone;
							} ?></td>
					</tr>
					<tr>
						<td><label for="phoneMobile">Mobile Number</label></td>
						<td><input type="text" name="phoneMobile" value="" /></td>
						<td><?php if (isset($errorMobile)) {
								echo $errorMobile;
							} ?></td>
					</tr>
					<tr>
						<td colspan="3">
							<h3>Address</h3>
						</td>
					</tr>
					<tr>
						<td><label for="1st_line">1st Line : </label></td>
						<td><input type="text" name="1st_line" value="" /></td>
						<td><?php if (isset($errorAddress1)) {
								echo $errorAddress1;
							} ?></td>
					</tr>
					<tr>
						<td><label for="2nd_line">2nd Line: </label></td>
						<td><input type="text" name="2nd_line" value="" /></td>
						<td><?php if (isset($errorAddress2)) {
								echo $errorAddress2;
							} ?></td>
					</tr>
					<tr>
						<td><label for="3rd_line">3rd Line: </label></td>
						<td><input type="text" name="3rd_line" value="" /></td>
						<td><?php if (isset($errorAddress3)) {
								echo $errorAddress3;
							} ?></td>
					</tr>
					<tr>
						<td><label for="region">Region: </label></td>
						<td><input type="text" name="region" value="" /></td>
						<td><?php if (isset($errorRegion)) {
								echo $errorRegion;
							} ?></td>
					</tr>
					<tr>
						<td><label for="postcode">Postcode: </label></td>
						<td><input type="text" name="postcode" value="" /></td>
						<td><?php if (isset($errorPostcode)) {
								echo $errorPostcode;
							} ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<h3>Account Details:</h3>
						</td>
					</tr>
					<tr>
						<td><label for="username">Username:</label></td>
						<td><input type="text" name="username" value="" required /></td>
						<td><?php if (isset($errorUsername)) {
								echo $errorUsername;
							} ?></td>
					</tr>
					<tr>
						<td><label for="password">Password:</label></td>
						<td><input type="password" name="password" value="" required /></td>
						<td><?php if (isset($errorPassword)) {
								echo $errorPassword;
							} ?></td>
					</tr>
					<tr>
						<td colspan="3"><input type="submit" name="register" value="Register" /></td>
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
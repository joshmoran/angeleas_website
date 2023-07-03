<?php
session_start();

require 'src/variables.php';
require 'src/random_number.php';

function sanitizeInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['register'])) {
		require "src/database.php";

		$errors = array();
		$sql = 'INSERT INTO customers VALUES ( ';



		function checkEmail($str)
		{
			return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? true : false;
		}

		// required
		// FIRST NAME 
		// LAST NAME 
		// Email

		// USERNAME 
		// PASSWORD

		//
		// Customer details
		//
		$firstName = sanitizeInput($_POST['firstname']);
		$lastName = sanitizeInput($_POST['lastname']);
		$email = sanitizeInput($_POST['email']);
		$home = sanitizeInput($_POST['phoneHome']);
		$mobile = sanitizeInput($_POST['phoneMobile']);
		// Check Requirements for inputted values meet the Requirements

		// FIRST NAME 
		if (!empty($_POST['firstname']))
			if (strlen($firstName) < 3) {
				$sql .=  ' firstname = "' . mysqli_real_escape_string($db, $_POST['firstname']);
			} else {
				$errors[] = 'First Name';
				$errorFirstName = 'First name must be or equal to 3 characters. ';
			}
	} else {
		$errorFirstName = 'First Name is a required field.';
	}

	// LAST NAME
	if (!empty($_POST['lastname'])) {
		if (strlen($lastName) < 3) {
			$errorLastName = 'Last Name is required and must not be empty or less than 3 characters.';
			$errors++;
		}
	}
	// EMAIL - CHECK IF VALID EMAIL ADDRESS
	$regex = '/\b[a-z0-9-_.]+@[a-z0-9-_.]+(\.[a-z0-9]+)+/';
	if (checkEmail($email) === false || strlen($email) == '' || $email == null) {
		$errorEmail = 'Email is required and must be a valid email address.';
		$errors++;
	}

	// HOME NUMBER - ONLY CHECK IF INPUT IS ENTERED
	if (strlen($home) != 11 && strlen($home) > 0) {
		$errorPhone = 'Please enter a valid home phone number. Region (5 characters) and the extension (6 characters).';
		$errors++;
	}

	// MOBILE NUMBER - ONLY CHECK IF INPUT IS ENTERED
	if (strlen($mobile) != 11 && strlen($mobile) > 1) {
		$errorMobile = 'Please enter a valid mobile phone number. Please use 0 at the start';
		$errors++;
	}

	//
	// Address
	//
	$address_1st = sanitizeInput($_POST['line1']);
	$address_2nd = sanitizeInput($_POST['line2']);
	$address_3rd = sanitizeInput($_POST['line3']);
	$region = sanitizeInput($_POST['region']);
	$postcode = sanitizeInput($_POST['postcode']);

	// Address - line 1
	if (strlen($address_1st) < 4) {
		$errorAddress1 = 'Address line 1 must be more than 4 characters';
		$errors++;
	}

	// Address - Line 2 
	if (strlen($address_2nd) < 4) {
		$errorAddress2 = 'Address line 2 must be more than 4 characters.';
		$errors++;
	}

	// Postcode
	if (strlen($postcode) != 7) {
		$errorPostcode = 'Please enter a valid postcode.';
		$errors++;
	}

	$username = sanitizeInput($_POST['username']);
	$password = sanitizeInput($_POST['password']);

	$checkUsername = mysqli_query($db, 'SELECT * FROM accounts WHERE username = "' . $username . '"');

	if (strlen($username) < 7) {
		$errorUsername = 'Username must be more than 6 characters long.';
	} else if (mysqli_num_rows($checkUsername) > 0) {
		$errorUsername = 'Username already in use';
	}

	// Important Values - |first_name, last_name, $email, username, password

	//Checking if customer id already exists

	echo 'There are ' . $errors . ' found.';
	if ($errors == 0) {
		// for table -- customers
		do {
			$customerNo = randomNumber();

			$sqlCheckID = "SELECT customer_id from customers where customer_id = " . $customerNo;
			$checkID = mysqli_query($db, $sqlCheckID);
		} while (mysqli_num_rows($checkID) != 0);

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

		$sqlCart = "INSERT INTO orders ( order_id, customer_id, complete) VALUES ( '$basketNo', '$customerNo', false )";

		if (mysqli_query($db, $sqlCart)) {
			$error_message = 'Successfully added to Cart';
		} else {
			$error_message = 'Could not add to Cart';
			return false;
		}

		// for table -- $address
		$sqlAddress = "INSERT INTO address (`customer_id`, `1_line`, `2_line`, `3_line`, `region`, `postcode`) VALUES ( '$customerNo', '$address_1st', '$address_2nd', '$address_3rd', '$region', '$postcode' )";

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
		//header("Location: register.php?" . $getMessage);
		exit();
	}
}


?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $websiteName; ?> - Register</title>
	<link type="text/css" href="src/css/css.css" rel="stylesheet" />
</head>

<body>
	<?php
	include "inc/header.php";
	?>
	<div id="container">
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
			<p>Address and credit cards can be added later, through the account portal and through the basket</p>
			<form method="post" action="register.php">
				<table>
					<tr>
						<th colspan="3">
							<h2>Registration</h2>
						</th>
					</tr>
					<tr>
						<td colspan="3">
							<h3>Customer Details</h3>
						</td>
					</tr>
					<tr>
						<td><label for="firstname">First name: </label></td>
						<td><input type="text" name="firstname" value="<?php if (isset($_POST['firstname'])) {
																			echo $_POST['firstname'];
																		} ?>" required /></td>
						<td><?php if (isset($errorFirstName)) {
								echo $errorFirstName;
							} ?></td>
					</tr>
					<tr>
						<td><label for="lastname">Last Name: </label></td>
						<td><input type="text" name="lastname" value="<?php if (isset($_POST['lastname'])) {
																			echo $_POST['lastname'];
																		} ?>" required /></td>
						<td><?php if (isset($errorLastName)) {
								echo $errorLastName;
							} ?></td>
					</tr>
					<tr>
						<td><label for="email">Email: </label></td>
						<td><input type="text" name="email" value="<?php if (isset($_POST['email'])) {
																		echo $_POST['email'];
																	} ?>" required /></td>
						<td><?php if (isset($errorEmail)) {
								echo $errorEmail;
							} ?></td>
					</tr>
					<tr>
						<td><label for="phoneHome">Home Phone Number:</label></td>
						<td><input type="text" name="phoneHome" value="<?php if (isset($_POST['phoneHome'])) {
																			echo $_POST['phoneHome'];
																		} ?>" /></td>
						<td><?php if (isset($errorPhone)) {
								echo $errorPhone;
							} ?></td>
					</tr>
					<tr>
						<td><label for="phoneMobile">Mobile Number</label></td>
						<td><input type="text" name="phoneMobile" value="<?php if (isset($_POST['phoneMobile'])) {
																				echo $_POST['phoneMobile'];
																			} ?>" /></td>
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
						<td><label for="line1">1st Line : </label></td>
						<td><input type="text" name="line1" value="<?php if (isset($_POST['line1'])) {
																		echo $_POST['line1'];
																	} ?>" /></td>
						<td><?php if (isset($errorAddress1)) {
								echo $errorAddress1;
							} ?></td>
					</tr>
					<tr>
						<td><label for=" line2">2nd Line: </label></td>
						<td><input type="text" name="line2" value="<?php if (isset($_POST['line2'])) {
																		echo $_POST['line2'];
																	} ?>" /></td>
						<td><?php if (isset($errorAddress2)) {
								echo $errorAddress2;
							} ?></td>
					</tr>
					<tr>
						<td><label for="line3">3rd Line: </label></td>
						<td><input type="text" name="line3" value="<?php if (isset($_POST['line3'])) {
																		echo $_POST['line3'];
																	} ?>" /></td>
						<td><?php if (isset($errorAddress3)) {
								echo $errorAddress3;
							} ?></td>
					</tr>
					<tr>
						<td><label for="region">Region: </label></td>
						<td><input type="text" name="region" value="<?php if (isset($_POST['region'])) {
																		echo $_POST['region'];
																	} ?>" /></td>
						<td><?php if (isset($errorRegion)) {
								echo $errorRegion;
							} ?></td>
					</tr>
					<tr>
						<td><label for="postcode">Postcode: </label></td>
						<td><input type="text" name="postcode" value="<?php if (isset($_POST['postcode'])) {
																			echo $_POST['postcode'];
																		} ?>" /></td>
						<td><?php if (isset($errorPostcode)) {
								echo $errorPostcode;
							} ?></td>
					</tr>
					<tr>
						<td colspan="3">
							<h3>Account Details:</h3>
						</td>
					</tr>
					<tr>
						<td><label for="username">Username:</label></td>
						<td><input type="text" name="username" value="<?php if (isset($_POST['username'])) {
																			echo $_POST['username'];
																		} ?>" required /></td>
						<td><?php if (isset($errorUsername)) {
								echo $errorUsername;
							} ?></td>
					</tr>
					<tr>
						<td><label for="password">Password:</label></td>
						<td><input type="password" name="password" value="<?php if (isset($_POST['password'])) {
																				echo $_POST['password'];
																			} ?>" required /></td>
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
		<script type="text/javascript" src="src/js/register.js"></script>
</body>

</html>
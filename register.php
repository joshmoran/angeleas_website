<?php
session_start();

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require 'src/variables.php';
require 'src/random_number.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//Customer details 
	if (isset($_GET['firstName'])) {
		$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
	}

	if (isset($_GET['firstName'])) {
		$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
	}

	if (isset($_GET['firstName'])) {
		$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
	}

	if (isset($_GET['firstName'])) {
		$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
	}

	if (isset($_GET['firstName'])) {
		$errorFirstName = 'First Name is required and must not be empty or less than 3 characters.';
	}
}


function sanitizeInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
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
			<p>Address and credit cards can be added later, through the account portal and through the basket</ </div>
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
						<td><input type="text" name="lastname" value="" required /></td>
						<td><?php if (isset($errorLastName)) {
								echo $errorLastName;
							} ?></td>
					</tr>
					<tr>
						<td><label for="email">Email: </label></td>
						<td><input type="text" name="email" value="" required /></td>
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
						<td colspan="3">
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

<?php

t
?>
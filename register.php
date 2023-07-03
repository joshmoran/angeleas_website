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

var_dump($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['register'])) {
		require "src/database.php";

		$errors = 0;
		$customerNo = 0;
		$basketNo = 0;

		do {
			$no = randomNumber();
			(int)$customerNo = $no;

			$sqlCheckID = "SELECT customer_id from customers where customer_id = " . $customerNo;
			$checkID = mysqli_query($db, $sqlCheckID);
			echo $customerNo . '<br>';
		} while (mysqli_num_rows($checkID) != 0);

		echo '<br>';

		$sqlCustomers = 'INSERT INTO customers VALUES ( "' . $customerNo . '"';
		$sqlAccount = ' INSERT INTO accounts VALUES ( "' . $customerNo . '"';

		$checkUsername = mysqli_query($db, 'SELECT * FROM accounts WHERE username = "' . mysqli_real_escape_string($db, $_POST['username']) . '"');

		function checkEmail($str)
		{
			return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? true : false;
		}

		//
		// Customer details
		// Check Requirements for inputted values meet the Requirements

		// FIRST NAME 
		if (!empty($_POST['firstname'])) {
			if (strlen($_POST['firstname']) > 3) {
				$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['firstname']) . '"';
			} else {
				$errorFirstName = 'First name must not be empty or less than 3 characters.';
				$errors++;
			}
		} else {
			$errorFirstName = ' First name is required.';
			$errors++;
		}

		// LAST NAME
		if (!empty($_POST['lastname'])) {
			if (strlen($_POST['lastname']) > 3) {
				$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['lastname']) . '"';
			} else {
				$errorLastName = 'Last name must not be empty or less than 3 characters.';
				$errors++;
			}
		} else {
			$errorLastName = 'Last name is required.';
			$errors++;
		}

		// EMAIL - CHECK IF VALID EMAIL ADDRESS
		$regex = '/\b[a-z0-9-_.]+@[a-z0-9-_.]+(\.[a-z0-9]+)+/';
		if (!empty($_POST['email'])) {
			if (checkEmail($_POST['email']) === true || strlen($ema_POST['email']) != '' || $_POST['email'] != null) {
				$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['email']) . '"';
			} else {
				$errorEmail = 'Email is required and must be a valid email address.';
				$errors++;
			}
		} else {
			$errorEmail = 'Email is required.';
			$errors++;
		}

		// HOME NUMBER - ONLY CHECK IF INPUT IS ENTERED
		if (!empty($_POST['phoneHome'])) {
			if (strlen($_POST['phoneHome']) != 11 && strlen($_POST['phoneHome']) > 0) {
				$errorPhone = 'Please enter a valid home phone number. Region (5 characters) and the extension (6 characters).';
				$errors++;
			} else {
				$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['phoneHome']) . '"';
			}
		} else {
			$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['phoneHome']) . '"';
		}

		// MOBILE NUMBER - ONLY CHECK IF INPUT IS ENTERED
		if (!empty($_POST['phoneMobile'])) {
			if (strlen($_POST['phoneMobile']) != 11 && strlen($_POST['phoneMobile']) > 1) {
				$errorMobile = 'Please enter a valid mobile phone number. Please use 0 at the start';
				$errors++;
			} else {
				$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['phoneMobile']) . '"';
			}
		} else {
			$sqlCustomers .= ', "' . mysqli_real_escape_string($db, $_POST['phoneMobile']) . '"';
		}

		//
		// Account details
		// Check Requirements for inputted values meet the Requirements


		if (!empty($_POST['username'])) {
			if (mysqli_num_rows($checkUsername) > 0) {
				$errorUsername = 'Username already in use';
				$errors++;
			} else if (strlen($_POST['username']) > 7) {
				$sqlAccount .= ', "' . mysqli_real_escape_string($db, $_POST['username']) . '"';
			} else {
				$errorUsername = 'Username must be more than 6 characters long.';
				$errors++;
			}
		} else {
			$errorUsername = 'Username is required.';
			$errors++;
		}

		if (!empty($_POST['password'])) {
			if (strlen($_POST['password']) > 8) {
				$sqlAccount .= ', "' . mysqli_real_escape_string($db, password_hash($_POST['password'], PASSWORD_DEFAULT)) . '"';
			} else {
				$errorPassword = 'Password must be more than 7 characters long.';
				$errors++;
			}
		} else {
			$errorPassword = 'Password is required.';
			$errors++;
		}

		$sqlCustomers .= ')';
		$sqlAccount .= ')';

		if ($errors == 0) {
			$adminMessage = 'Their has been a problem submitting your registration if this problem persists please contact the system administrator';
			// for table -- customers


			if (mysqli_query($db, $sqlCustomers) == false) {
				$error_message = $adminMessage;
				return false;
			}
			// }

			// for table -- accounts
			if (mysqli_query($db, $sqlAccount) == false) {
				$error_message = $adminMessage;
				return false;
			}
			// for table -- cart
			do {
				$no = randomNumber();
				$basketNo = $no;
				$sqlBasket = "SELECT order_id from orders where order_id = " . $basketNo;
				$checkBasket = mysqli_query($db, $sqlBasket);
			} while (mysqli_num_rows($checkBasket) != 0);

			$sqlCart = "INSERT INTO orders ( order_id, customer_id, complete) VALUES ( '$basketNo', '$customerNo', false )";

			if (mysqli_query($db, $sqlCart) == false) {
				$error_message = $adminMessage;
				return false;
			}

			$_SESSION['customer_id'] = $customerNo;
			$_SESSION['basket_id'] = $basketNo;
			$_SESSION['loggedIn'] = true;
			$_SESSION['admin'] = false;
			header("Location: account.php");
		} else {
			$error_message = 'Please correct the errors to continue with registration.';
			//header("Location: register.php?" . $getMessage);
		}

		$_POST['register'] = null;

		echo $sqlAccount;
		echo '<br>';
		echo $sqlCustomers;
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
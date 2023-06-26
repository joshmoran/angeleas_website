<?php
session_start();
require "src/functions.php";
require "src/database.php";

//$_SESSION['loggedIn'] = false;

// Important information

// customer name = split into first and second namer 
// email 
// home no
// mobile no

// add card to account
// add address to account 
$errors = array();
if (isset($_SESSIOn['loggedIn']) && $_SESSION['loggedIn'] == false) {
	header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Three Sections of Details 
	// Customer Information
	// Addresses
	// Credit Card Numbers
	require "src/database.php";

	function checkSql($statement)
	{
		if (!$statement) {
			echo 'option one';
			if (isset($_POST['makeChangesCustomer'])) {
				return 'UPDATE customers SET ';
			} else if (isset($_POST['makeChangesAddress'])) {
				return 'UPDATE address SET ';
			} else if (isset($_POST['makeChangesCreditCard'])) {
				return 'UPDATE credit_cards SET ';
			}
		} else {
			echo 'option two';
			return ', ';
		}
	}

	if (isset($_POST['makeChangesCustomer'])) {

		// $sqlCustomer = "UPDATE customers SET ";
		// Check if variables are empty, if empty and not required, move on
		//	- first_name
		//	- last_name
		//	- email
		//	- home
		//	- mobile


		$sqlCustomer = '';
		$errorCustomer = array();

		if (!empty($_POST['firstName'])) {
			$comma = checkSql($sqlCustomer);

			$sqlCustomer .= $comma . ' first_name = "' . mysqli_real_escape_string($db, $_POST['firstName']) . '" ';
		} else {
			$errorCustomer[] = "First Name is a required field";
		}

		if (!empty($_POST['lastName'])) {
			$comma = checkSql($sqlCustomer);
			$sqlCustomer .= $comma . ' last_name = "' . mysqli_escape_string($db, $_POST['lastName']) . '" ';
		} else {
			$errorCustomer[] = "last Name is a required field";
		}

		if (!empty($_POST['email'])) {
			$comma = checkSql($sqlCustomer);
			$sqlCustomer .= $comma . ' email = "' . mysqli_escape_string($db, $_POST['email']) . '" ';
		} else {
			$errorCustomer[] = "last Name is a required field";
		}

		if (!empty($_POST['mobile'])) {
			$comma = checkSql($sqlCustomer);
			$sqlCustomer .= $comma . ' mobile = "' . mysqli_escape_string($db, $_POST['mobile']) . '" ';
		} else {
			$errorCustomer[] = "last Name is a required field";
		}

		if (!empty($_POST['home'])) {
			$comma = checkSql($sqlCustomer);
			$sqlCustomer .= $comma . ' home = "' . mysqli_escape_string($db, $_POST['home']) . '" ';
		} else {
			$errorCustomer[] = "last Name is a required field";
		}
		$sqlCustomer .= " WHERE customer_id = " . $_SESSION['customer_id'];

		if (count($errorCustomer)) {
			if (mysqli_query($db, $sqlCustomer)) {
				$errorCustomer[] = 'Successfully updated your customer details';
			} else {
				$errorCustomer[] = 'Something went wrong. Please try again later';
			}
		} else {
		}
		$errorCustomer = array();
		$_POST['makeChangesCustomer'] = null;
	}

	if (isset($_POST['makeChangesAddress'])) {
		$sqlAddress = '';
		$errorsAddress = array();

		if (!empty($_POST['address1st'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' 1_line = "' . mysqli_real_escape_string($db, $_POST['address1st']) . '" ';
		} else {
			$errorsAddress[] = "First Name is a required field";
		}
		if (!empty($_POST['address2nd'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' 2_line = "' . mysqli_real_escape_string($db, $_POST['address2nd']) . '" ';
		} else {
			$errorsAddress[] = "First Name is a required field";
		}
		if (!empty($_POST['address3rd'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' 3_line = "' . mysqli_real_escape_string($db, $_POST['address3rd']) . '" ';
		} else {
			$errorsAddress[] = "First Name is a required field";
		}
		if (!empty($_POST['region'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' region = "' . mysqli_real_escape_string($db, $_POST['region']) . '" ';
		} else {
			$errorsAddress[] = "First Name is a required field";
		}
		if (!empty($_POST['postcode'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' postcode = "' . mysqli_real_escape_string($db, $_POST['postcode']) . '" ';
		} else {
			$errorsAddress[] = "First Name is a required field";
		}
		$sqlCreditCard .= ' WHERE customer_id = "' . $_SESSION['customer_id'] . '"';

		if (count($errorsAddress)) {
			if (mysqli_query($db, $sqlCreditCard)) {
				$errorsAddress[] = 'Successfully update your credit card details.';
			} else {
				$errorsAddress[] = 'Something went wrong. Please try again later.';
			}
		} else {
			$errorsAddress[] = 'Please resolve the issues to continue with the change.';
		}
	}

	if (isset($_POST['makeChangesCreditCard'])) {
		$sqlCreditCard = '';
		$errorsCard = array();

		if (!empty($_POST['cardnumber'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' cardnumber = "' . mysqli_real_escape_string($db, $_POST['cardnumber']) . '" ';
		} else {
			$errorsCard[] = "Card Number is invalid";
		}

		if (!empty($_POST['expiry'])) {
			$comma = checkSql($sqlCreditCard);
			$sqlCreditCard .= $comma . ' expiry = "' . mysqli_real_escape_string($db, $_POST['expiry']) . '" ';
		} else {
			$errorsCard[] = "Expiry is invalid";
		}

		$sqlCreditCard .= ' WHERE customer_id = "' . $_SESSION['customer_id'] . '"';

		if (count($errorsCard)) {
			if (mysqli_query($db, $sqlCreditCard)) {
				$errorsCard[] = 'Successfully update your credit card details.';
			} else {
				$errorsCard[] = 'Something went wrong. Please try again later.';
			}
		} else {
			$errorsCard[] = 'Please resolve the issues to continue with the change.';
		}
	}
}

// $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
// $nameSplit = explode(' ', $name);
// $nameSplit[0] = $firstName;
// $nameSplit[1] = $lastName;
// $addressFirst = trim(filter_input(INPUT_POST, 'addressFirstLine', FILTER_SANITIZE_STRING));
// $addressSecond = trim(filter_input(INPUT_POST, 'addressSecondLine', FILTER_SANITIZE_STRING));
// $postcode = trim(filter_input(INPUT_POST, 'addressPostcode', FILTER_SANITIZE_STRING));
// $address = $addressFirst . ', ' . $addressSecond . ', ' . $postcode;
// // $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANATIZE_STRING));




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
	<div id="container">
		<div id="messages">
			<?php
			if (isset($error_message)) {
				echo '<p class="messages">' . $error_message . '</p>';
			}
			if (count($errors) > 1) {
				foreach ($errors as $error) {
					echo '<p id="message">' . $error . '</p>';
				}
			}
			?>
		</div>
		<form method="post" id="makeChanges" action="account_details.php">
			<!-- 
				Main categories, each with a select button
					- Details
					- Address
					- Credit Cards
			 -->
			<table>
				<!-- 
					CHANGE CUSTOMER DETAILS 
				 -->
				<tr>
					<th colspan="2">
						<h2>Change account details</h2>
					</th>
				</tr>
				<tr>
					<td><label for="personalChanges">Make changes to my personal details</label></td>
					<td><input type="checkbox" id="personalChanges" name="personalChanges" /></td>
				</tr>
				<!-- 
					INPUTS TO BE ADDED
						- FIRST NAME
						- LAST NAME
						- EMAIL
						- HOME NO
						- MOBILE NO
				 -->
				<tr>
					<?php

					$sqlCustomer = "SELECT * FROM customers WHERE customer_id = '" . $_SESSION['customer_id'] . "'";

					foreach (mysqli_query($db, $sqlCustomer) as $user) :

					?>

						<td><label for="firstName">First Name: </label></td>
						<td><input type="text" name="firstName" <?php if (isset($user['first_name'])) {
																	echo 'value="' . $user['first_name'] . '"';
																} ?> /></td>
				</tr>
				<tr>
					<td><label for="lastName">Last Name: </label></td>
					<td><input type="text" name="lastName" <?php if (isset($user['last_name'])) {
																echo 'value="' . $user['last_name'] . '"';
															} ?> /></td>
				</tr>
				<tr>
					<td><label for="email">Email: </label></td>
					<td><input type="text" name="email" <?php if (isset($user['email'])) {
															echo 'value="' . $user['email'] . '"';
														} ?> /></td>
				</tr>
				<tr>
					<td><label for="home">Home Number: </label></td>
					<td><input type="text" name="home" <?php if (!empty($user['home'])) {
															echo 'value="' . $user['home'] . '"';
														} ?> /></td>
				</tr>
				<tr>
					<td><label for="mobile">Mobile Number: </label></td>
					<td><input type="text" name="mobile" <?php if (!empty($user['mobile'])) {
																echo 'value="' . $user['mobile'] . '"';
															} ?> /></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" name="makeChangesCustomer" value="Submit">Submit</button></td>
				</tr>

			<?php
					endforeach;
			?>
			<!--
					CHANGE ADDRESS DETAILS
						- first line 
						- second line 
						- third line 
						- region
						- postcode
				 -->
			<tr>
				<th colspan="2">Change address details</th>
			</tr>
			<tr>
				<td><label for="personalChanges">Make changes to my personal details</label></td>
				<td><input type="checkbox" id="personalChanges" name="personalChanges" /></td>
			</tr>
			<!-- 
			<select name="whichAddress"> -->


			<?php
			$count = 0;
			$sqlAddress = "SELECT * FROM address WHERE customer_id = '" . $_SESSION['customer_id'] . "'";
			$addressRows = mysqli_query($db, $sqlAddress);

			var_dump($addressRows);

			while ($address = mysqli_fetch_row($addressRows)) :
				$fullAddress = $address[2] . ', ' . $address[3] . ', ' . $address[4] . ', ' . $address[5] . ', ' . $address[6];
				
				echo '<option onclick="changeAddress(' . $address[1] . '';
			?>

				<!-- <tr>
					<td><label for="address1st">First Line</label></td>
					<td><input type="text" <?php if (isset($_POST['address1st'])) {
												echo " value='" . $_POST['address1st'] . "'";
											} ?> /></td>
				</tr>
				<tr>
					<td><label for="address2nd">Second Line</label></td>
					<td><input type="text" name="address2nd" /></td>
				</tr>
				<tr>
					<td><label for="address3rd">Third Line</label></td>
					<td><input type="text" name="address3rd" /></td>
				</tr>
				<tr>
					<td><label for="region">Region</label></td>
					<td><input type="text" name="region" /></td>
				</tr>
				<tr>
					<td><label for="postcode">Postcode</label></td>
					<td><input type="text" name="postcode"></td>
				</tr> -->

			<?php
				$count++;
			endwhile;

			?>
			<tr>
				<td colspan="2"><button type="submit" name="makeChanges" value="Submit">Submit</button></td>
			</tr>
			<!-- 
					CHANGE CREDIT CARD
				  -->
			<tr>
				<th colspan="3">
					<h2>Payment Details</h2>
				</th>
			</tr>
			<?php
			$sqlCreditCard = "SELECT * FROM ";

			?>
			<tr>
				<td><label for="paymentChange">Make payment details changes</label></td>
				<td colspan="2"><input type="checkbox" name="paymentChange" /></td>
			</tr>


			<tr>
				<td><label for="username">Username: </label></td>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td><label for="passwordc">Password: </label></td>
				<td><input type="text" name="passwordc" /></td>
			</tr>

			<tr>
				<td colspan="2"><button type="submit" name="makeChangesAccount">Submit</button></td>
			</tr>

			</table>
		</form>
		<?php
		include "inc/footer.php";
		?>
		<script src="src/js/js.js"></script>
</body>

</html>
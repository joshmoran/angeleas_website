<?php
session_start();
require "src/functions.php";

//$_SESSION['loggedIn'] = false;

// Important information

// customer name = split into first and second namer 
// email 
// home no
// mobile no

// add card to account
// add address to account 

if ($_SESSION['loggedIn'] == false) {
	header("Location: login.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Three Sections of Details 
	// Customer Information
	// Addresses
	// Credit Card Numbers
	require "src/database.php";

	$sqlCustomer = "UPDATE customers SET ";
	$sqlAddress = "UPDATE address SET ";
	$sqlCreditCard = "UPDATE credit_cards SET ";

	function checkSql($toParse)
	{
		if ($toParse == 'customer') {

			if ($sqlCustomer != "UPDATE customers SET ") {
				$sqlCustomer .= ", ";
			}
		} else if ($toParse == 'address') {
			if ($sqlAddress != "UPDATE address SET ") {
				$sqlAddress .= ', ';
			}
		} else if ($toParse == 'credit_card') {
			if ($sqlCreditCard != "UPDATE credit_cards SET ") {
				$sqlCreditCard = ', ';
			}
		}
	}

	if (isset($_POST['makeChangesCustomer'])) {
		// Check if variables are empty, if empty and not required, move on
		//	- first_name
		//	- first_name
		//	- first_name
		//	- first_name
		//	- first_name
		if (($_POST['first_name'])) {
			checkSql('customer');
			$sqlCustomer .= ' first_name = ' . mysqli_real_escape_string($db, $_POST['first_name']) . ' ';
		} else {
			$errors[] = "First Name is a required field";
		}

		if (empty($_POST['last_name'])) {
			checkSql('customer');
			$sqlCustomer .= ' last_name = "' . mysqli_escape_string($db, $_POST['last_name']) . '" ';
		} else {
			$errors[] = "last Name is a required field";
		}

		if (empty($_POST['last_name'])) {
			checkSql('customer');
			$sqlCustomer .= ' last_name = "' . mysqli_escape_string($db, $_POST['last_name']) . '" ';
		} else {
			$errors[] = "last Name is a required field";
		}

		if (empty($_POST['last_name'])) {
			checkSql('customer');
			$sqlCustomer .= ' last_name = "' . mysqli_escape_string($db, $_POST['last_name']) . '" ';
		} else {
			$errors[] = "last Name is a required field";
		}

		if (empty($_POST['last_name'])) {
			checkSql('customer');
			$sqlCustomer .= ' last_name = "' . mysqli_escape_string($db, $_POST['last_name']) . '" ';
		} else {
			$errors[] = "last Name is a required field";
		}
	} else if (isset($_POST['makeChangesAddress'])) {
	} else if (isset($_POST['makeChangesCreditCard'])) {
	} else {
		$errors[] = 'Could not processing your request. Please try again. If this happens again, please contact us.';
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
					<td><label for="firstName">First Name: </label></td>
					<td><input type="text" name="firstName" /></td>
				</tr>
				<tr>
					<td><label for="lastName">Last Name: </label></td>
					<td><input type="text" name="lastName" /></td>
				</tr>
				<tr>
					<td><label for="email">Email: </label></td>
					<td><input type="text" name="email" /></td>
				</tr>
				<tr>
					<td><label for="mobile">Mobile Number: </label></td>
					<td><input type="text" name="mobile" /></td>
				</tr>
				<tr>
					<td><label for="home">Home Number: </label></td>
					<td><input type="text" name="home" /></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" name="makeChanges" value="Submit">Submit</button></td>
				</tr>
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
				<tr>
					<td><label for="address1st">First Line</label></td>
					<td><input type="text" name="address1st" /></td>
				</tr>
				<tr>
					<td><label for="address2nd">Second Line</label></td>
					<td><input type="text" name="address2nd" /></td>
				</tr>
				<tr>
					<td><label for="address3rd">First Line</label></td>
					<td><input type="text" name="address3rd" /></td>
				</tr>
				<tr>
					<td><label for="region">Second Line</label></td>
					<td><input type="text" name="region" /></td>
				</tr>
				<tr>
					<td><label for="addressPostcode">Postcode</label></td>
					<td><input type="text" name="postcode"></td>
				</tr>
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
				<tr>
					<td><label for="paymentChange">Make payment details changes</label></td>
					<td colspan="2"><input type="checkbox" name="paymentChange" /></td>
				</tr>


				<tr>
					<td><label for="cardnumber">Card Number: </label></td>
					<td><input type="text" name="cardnumber" /></td>
				</tr>
				<tr>
					<td><label for="expiry">Expiry</label></td>
					<td><input type="text" name="expiry" /></td>
				</tr>

				<tr>
					<td colspan="2"><button type="submit" name="makeChanges">Submit</button></td>
				</tr>

			</table>
		</form>
		<?php
		include "inc/footer.php";
		?>
		<script src="src/js/js.js"></script>
</body>

</html>
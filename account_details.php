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


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$name = trim( filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$nameSplit = explode(' ', $name);
	$nameSplit[0] = $firstName;
	$nameSplit[1] = $lastName;
	$addressFirst = trim(filter_input(INPUT_POST, 'addressFirstLine', FILTER_SANITIZE_STRING));
	$addressSecond = trim(filter_input(INPUT_POST, 'addressSecondLine', FILTER_SANITIZE_STRING));
	$postcode = trim(filter_input(INPUT_POST, 'addressPostcode', FILTER_SANITIZE_STRING));
	$address = $addressFirst . ', ' . $addressSecond . ', ' . $postcode;
	// $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANATIZE_STRING));

	
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
				if(isset($error_message)){
				echo '<p class="messages">' . $error_message . '</p>';
				}
			?>
		</div>
		<form method="post" action=".php">
			<table>
				<tr>
					<th colspan="3">
						<h2>Change account details</h2>
					</th>
				</tr>
				<tr>
					<td><label for="name">Name: </label></td>
					<td><input type="text" colspan="2" /></td>
				</tr>
				<tr>
					<td><label for="addressFirstLine">First Line</label></td>
					<td><input type="text" value="<?php ?>" for="addressFirstLine" /></td>
				</tr>
				<tr>
					<td>
						<llabel for="addressSecondLine">Second Line</label>
					</td>
					<td><input type="text" value="<?php ?>" for="addressSecondLine"></td>
				</tr>
				<tr>
					<td><label for="addressPostcode">Postcode</label></td>
					<td><input type="text" value="<?php ?>" for="addressPostcode"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</form>
		<?php
		include "inc/footer.php";
		?>
		<script src="src/js/js.js"></script>
</body>
</html>
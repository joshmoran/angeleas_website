<?php
session_start();
//$error_message = 'yesssss';
include "src/functions.php";

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
	header("Location: index.php");
}
if (isset($_POST['login'])) {
	require "src/database.php";

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql_query = "select count(*) as cntUser from accounts where username='$username'";
	$result = mysqli_query($db, $sql_query);
	$row = mysqli_fetch_array($result);

	$count = $row['cntUser'];

	if ($count > 0) {
		$error_message = 'Could find the username, looking for password';

		$sql_query = "SELECT customer_id, pass from accounts where username = '$username'";
		$passwordSalt = mysqli_query($db, $sql_query);
		$accountResult = mysqli_fetch_assoc($passwordSalt);

		if (password_verify($_POST['password'], $accountResult['pass'])) {
			$customerID = $accountResult['customer_id'];

			$sqlOrders = "SELECT order_id, customer_id FROM orders WHERE customer_id = '$customerID' AND complete = false";
			$orderQuery = mysqli_query($db, $sqlOrders);
			$basketID = mysqli_fetch_column($orderQuery, 0);

			if (mysqli_num_rows($orderQuery) < 1) {
				$basketID = generateBasket();
				$sqlInsert = "INSERT INTO orders (order_id, customer_id, complete ) VALUES ( '$basketID', '$customerID', false )";
				$sqlBasketInsert = mysqli_query($db, $sqlInsert);
				$_SESSION['basket_id'] = $basketID;
			} else {
				$_SESSION['basket_id'] = mysqli_fetch_column($orderQuery, 0);
			}

			$_SESSION['username'] = $username;
			$_SESSION['customer_id'] = $customerID;
			$_SESSION['basket_id'] = $basketID;
			$_SESSION['loggedIn'] = true;
			$_SESSION['admin'] = true;

			$error_message = 'It has been matched and verified';
			header('location: ./account.php');
			exit();
		} else {
			$error_message = 'Passwords do not match';
			die();
		}
	} else {
		echo "Invalid username and password";
	}
	//	header('Location: index.php');
	// /$error_message = $username . ' - ' . $password;
	// $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
	// $password = trim( filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING));
	// $error_message = 'yep';

	// if (login_account($username, $password)) {
	// 	$error_message = 'Yes, it worked';
	// 	$_SESSION['loggedIn'] = true;
	// 	$_SESSION['username'] = $username;
	// 	$_SESSION['id'] = $user['customer_id'];
	// 	header("Location: account.php");
	// 	exit();
	// } else {
	// 	$error_message = 'Could not login successfully';
	// 	header("Location: login.php");
	// 	die();
	// }
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $websiteName . ' - Login'; ?></title>
	<link type="text/css" href="src/css/css.css" rel="stylesheet" />
</head>

<body>
	<?php
	include "inc/header.php";
	?>
	<div id="messages">
		<?php
		if (isset($error_message)) {
			echo '<p class="messageText">' . $error_message . '</p>';
		}
		?>
	</div>
	<div id="container">
		<form method="post" action="">
			<table>
				<tr>
					<th colspan="2">
						<h2>Login</h2>
					</th>
				</tr>
				<tr>
					<td><label for="username">Username: </label></td>
					<td><input type="text" name="username" id="username" placeholder="exampleusername" /></td>
				</tr>
				<tr>
					<td><label for="password">Password: </label></td>
					<td><input type="password" name="password" id="password" /></td>
				</tr>
				<tr>
					<td colspan="2"><a href="register.php">No Account? Click Here to Register</a></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="login" value="Login" /></td>
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
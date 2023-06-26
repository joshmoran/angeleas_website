<?php
session_start();
// Important Columns to be include - Order No,
require "src/database.php";
require "src/variables.php";

$basketID = $_SESSION['basket_id'];
$customerID = $_SESSION['customer_id'];

if ($_SESSION['loggedIn'] == false) {
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="View existing and old orders you have ordered.">
	<title><?php echo $websiteName; ?> - Orders</title>
	<link type="text/css" href="src/css/css.css" rel="stylesheet" />
	<link type="text/css" href="src/css/account_orders.css" rel="stylesheet" />
</head>

<body>
	<?php
	include "inc/header.php";
	?>

	<div id="container">
		<div id="return">
			<a href="account.php"><button>Return to your account</button></a>
		</div>
		<table>
			<p></p>
			<?php
			$sqlOrders = "SELECT order_id, time_ordered, status, complete  FROM orders WHERE customer_id = '$customerID' AND complete = true ORDER BY time_ordered ASC";
			$results = mysqli_query($db, $sqlOrders);

			$string = '';

			if (mysqli_num_rows($results) < 1) {
				$string = '<tr><td>Im sorry you have not placed any orders</td></tr>';
			} else {
				$string =  "<tr>
									<th>Order Number</th>
									<th>Order Status</th>
									<th>Total</th>
									<th>More Information</th>
								</tr>";

				while ($order =  mysqli_fetch_assoc($results)) {
					$string .= "<tr>";
					$string .= "<td>" . $order['order_id'] . "</td>";
					$string .= "<td>" . $order['status'] . "</td>";
					$string .= "<td>" . $order['time_ordered'] . "</td>";
					$string .= "<td><a href='order_history.php?id=" . $order['order_id'] . "' >Details</a></td>";
					$string .= "</tr>";
				}
			}


			print_r($string);
			?>

		</table>
	</div>
	<?php
	include "inc/footer.php";
	?>
	<script src="src/js/js.js"></script>
</body>

</html>
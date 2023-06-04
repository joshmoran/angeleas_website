<?php
session_start();
include 'src/variables.php';

if (empty($_GET['id'])) {
	header("Location: login.php");
}

require "src/database.php";
$orderID = $_GET['id'];
$sqlOrder = "SELECT * FROM purchases RIGHT JOIN orders ON purchases.basket_id = orders.order_id RIGHT JOIN products ON purchases.product_id = products.id RIGHT JOIN customers ON purchases.customer_id = customers.customer_id WHERE orders.order_id = " . $orderID;

$results = mysqli_query($db, $sqlOrder);

if ($_SESSION['loggedIn'] == false) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title><?php echo $websiteName; ?> - Order Details</title>
	<link href="src/css/css.css" rel="stylesheet" type="text/css" />
	<link href="src/css/order_history.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php include("inc/header.php"); ?>
	<div id="container">
		<div id="return">
			<a href="account_orders.php"><button>Return to your orders</button></a>
		</div>
		<div id="split">
			<div id="basket">
				<table>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Quantity</th>
					</tr>
					<!--
				Sections to include
					- split section
						- map of address
						- details of order
					- table of basket orders
					- Feedback and queries
-->
					<?php
					require("src/database.php");


					$string = '';

					while ($row = mysqli_fetch_assoc($results)) {
						echo '<tr>';
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
						echo "<td>" . $row['price'] . "</td>";
						echo "<td>" . $row['quantity'] . "</td>";
						echo "</tr>";
					}

					echo $string;
					?>


				</table>
			</div>
			<div id="orderDetails">
				<!-- 
						Sections for labels:
							- Customer name
							- Order no
							- Status 
							- Date 
							- Address on order
							- Card - last 4 numbers
						-->

				<?php
				$sqlCustomer = "SELECT * FROM customers RIGHT JOIN orders ON customers.customer_id = orders.customer_id  WHERE customers.customer_id = " . $_SESSION['customer_id'] . ' AND orders.order_id = ' . $_GET['id'];
				$customerResult = mysqli_query($db, $sqlCustomer);
				$customerArray = mysqli_fetch_array($customerResult);

				$name = $customerArray['first_name'] . ' ' . $customerArray['last_name'];
				?>
				<table>
					<tr>
						<label for="name">Customers Name:
							<input type="text" id="name" name="name" value="<?php echo $customerArray['name']; ?>" />
							<span></span>
						</label>
					</tr>

					<tr>
						<label for="order">Order No:
							<input type="text" id="order" name="order" value="<?php echo $_GET['id']; ?>" />
							<span></span>
						</label>
					</tr>

					<tr>

						<label for="status">Status:
							<input type="text" id="status" name="status" value="<?php echo $customerArray['status']; ?>" />
							<span><?php if (isset($errorStatus)) {
										echo $errorStatus;
									} ?></span>
						</label>
					</tr>

					<tr>
						<label for="dateOrdered">Date Ordered:
							<input type="text" id="dateOrdered" name="dateOrdered" value="<?php echo $customerArray['time_ordered']; ?>" />
							<span></span>
						</label>
					</tr>

					<tr>
						<label for="payment">Payment (last 4 digits):
							<input type="text" id="payment" name="payment" value="<?php echo $customerArray['card']; ?>" />
							<span></span>
						</label>
					</tr>
				</table>

			</div>
		</div>

		<?php include("inc/footer.php"); ?>
		<script src="src/js/js.js"></script>
</body>

</html>
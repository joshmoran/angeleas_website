<?php
session_start();

require "src/variables.php";
require "src/database.php";
require "src/random_number.php";

if (isset($_GET['del'])) {
	$sqlDelete = "DELETE FROM cart WHERE product_id = " . $_GET['del'] . " AND basket_id = " . $_SESSION['basket_id'];
	$queryDel = mysqli_query($db, $sqlDelete);
}

if (!isset($basketID)) {
	$basketID = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_SESSION['basket_id'])) {
		// Check if outstanding basket none
		$sql = "SELECT basket_id FROM basket WHERE customer_id = " . $_SESSION['customer_id'] . " AND complete = false";
		$basketResult = mysqli_query($db, $sql);

		if (mysqli_num_rows($basketResult) === 0) {
			do {
				$no = randomNumber();

				$sql = "SELECT basket_id FROM cart WHERE basket_id = " . $no;
				$result = mysqli_query($db, $sql);

				$_SESSION['basket_id'] = $no;
			} while (mysqli_num_rows($result) > 0);
		}
	}

	if (isset($_SESSION['loggedIn'])) {
		(int)$basketID = $_SESSION['basket_id'];
	} else {
		header("Location: index.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="View the current items you have in the basket, before you purchase and order the them.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $websiteName; ?> - Basket</title>
	<link rel="stylesheet" href="src/css/css.css" type="text/css " />
	<link rel="stylesheet" href="src/css/basket.css" type="text/css " />
</head>

<body>
	<?php
	include "inc/header.php";
	?>

	<div id="container">
		<table>
			<form action="basket.php" method="post" id="basket">
				<?php
				require("src/database.php");


				if (isset($_SESSION['customer_id'])) {
					$sqlOrder = "SELECT * FROM cart INNER JOIN products on cart.product_id = products.id WHERE cart.basket_id = '" . $_SESSION['basket_id'] . "'";
					$query = mysqli_query($db, $sqlOrder);
					if (mysqli_num_rows($query) < 1) {


						echo "<tr>";
						echo "<th>Remove</th>";
						echo "<th>Name</th>";
						echo "<th>Price</th>";
						echo "<th>Quantity</th>";
						echo "<th>Total</th>";
						echo "</tr>";

						$total = 0;

						$customerID = $_SESSION['customer_id'];
						$basketID = $_SESSION['basket_id'];

						$sqlBasket = "SELECT * FROM cart WHERE basket_id = $basketID";
						$basketQuery = mysqli_query($db, $sqlOrder);

						// while ( $products = mysqli_fetch_assoc($basketQuery) ) {
						// 	echo "<tr>";
						// 	echo "<td><input type='submit' name='delete' /> value='" . $products['id'] . "'><img src='src/img/ui/delete-f.svg' /></a></td>";
						// 	echo "<td>" . $products['product_name'] . "</td>";
						// 	echo "<td>" . $products['product_price'] . "</td>";
						// 	echo "<td>" . $products['product_quantity'] . "</td>";
						// 	echo "<td>" . $products['product_name'] . "</td>";
						// 	echo "</tr>";
						// }

						while ($row = mysqli_fetch_assoc($query)) {
							(float)$total += (float)$row['price'] * (int)$row['quantity'];
							echo "<tr>";
							echo "<td><a href='basket.php?del=" . $row['id'] . "'><img src='src/img/ui/delete-f.svg' value='" . $row['id'] . "' alt='Delete selected item from the basket' /></a></td>";
							echo "<td>" . $row['name'] . "</td>";
							echo "<td>" . $row['description'] . "</td>";
							echo "<td>" . $row['quantity'] . "</td>";
							$itemTotal = $row['price'] * $row['quantity'];
							echo "<td>£" . number_format($itemTotal, 2, '.', ',')  . "</td>";
							echo "</tr>";
						}

						echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td>Total: </td>";
						echo "<td>£" . number_format($total, 2, '.', ',') . "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td><button><a href='purchase.php'>Checkout</a></button></td>";
						echo "</tr>";
					} else {
						echo "<tr><th>Please add something to the basket</th>";
					}
				} else {
					echo '<tr><th>Please login or create an account to add items to the basket</th></tr>';
				}
				?>
			</form>
		</table>
	</div>

	<?php include "inc/footer.php"; ?>

	<script src="src/js/jquery.js"> </script>
	<script>
		function deleteRow(e) {
			//var posting = $.post('basket.php', { id: e.target.parentElement.value }, () => {
			//	console.log(e.target.parentElement.value);
			//});
			//let data = {
			//	id: e.target.parentElement.value
			//};

			//fetch("basket.php", {
			//	method: "POST",
			//	headers: { 'Content-Type': 'application/json' },
			//	body: JSON.stringify(data)
			//}).then(res => {
			//	console.log("Request complete! response:", res);
			//	});

			var url = 'basket.php';
			var formData = new FormData();
			var id = e.target.parentElement.value;
			formData.append('id', id);

			fetch(url, {
					method: 'POST',
					body: formData
				})
				.then(function(response) {
					return response.text();
				})
				.then(function(body) {
					console.log(body);
				});


		}
	</script>
</body>

</html>
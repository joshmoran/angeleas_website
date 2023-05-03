<?php
session_start();

require "src/database.php";
echo $_POST['id'];
if ( isset( $_POST['id'] )){

	echo 'The selected element is ' . $_POST['id'];
}

if ( !empty( $_SESSION['loggedIn'] )){
	(int)$basketID = $_SESSION['basket_id'];
	echo $basketID;
} else {
	header("Location: index.php");
}

$sqlOrder = "SELECT * FROM cart INNER JOIN products on cart.product_id = products.id WHERE basket_id = '$basketID'";

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Basket</title>
	<link rel="stylesheet" href="src/css/css.css" />
</head>

<body>
	<?php
		include "inc/header.php";
	?>

	<div id="container">
		<table>
			<?php
				require("src/database.php");
				$query = mysqli_query($db, $sqlOrder);

				if ( mysqli_num_rows( $query ) < 1 ) {
					$string = "<tr>";
					$string .= "<th>Please add something to the basket</th>";

					echo $string;
				} else {
					echo "<tr>";
					echo "<th>Remove</th>";
					echo "<th>Name</th>";
					echo "<th>Price</th>";
					echo "<th>Quantity</th>";
					echo "<th>Total</th>";
					echo "</tr>";

					$total = 0;

					while ( $row = mysqli_fetch_assoc($query) ){
						(float)$total += (float)$row['price'] * (int)$row['quantity'];
						echo "<tr>";
						echo "<td><button id='delete' onclick='deleteRow(event)' value='" . $row['id'] . "'><img src='src/img/ui/delete-f.svg' value='" . $row['id'] . "' /></button></td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
						echo "<td>" . $row['price'] . "</td>";
						echo "<td>" . $row['quantity'] . "</td>";
						echo "</tr>";
					}

					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>Total: </td>";
					echo "<td>" . $total . "</td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><button >Checkout</button></td>";
					echo "</tr>";

				}
			?>
		</table>
	</div>
	
<?php include "inc/footer.php"; ?>

	<script src="src/js/jquery.js">	</script>
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

			fetch(url, { method: 'POST', body: formData })
				.then(function (response) {
					return response.text();
				})
				.then(function (body) {
					console.log(body);
				});
		

		}	
	</script>
</body>
</html>
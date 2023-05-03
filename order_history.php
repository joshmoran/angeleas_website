<?php
session_start();

//if ($_SESSION['loggedIn'] == false || empty($_POST['id'])){
//    header("Location: index.php");
//}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link href="src/css/css.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php include("inc/header.php"); ?>
		<table>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Amount</th>
				<th>Quantity</th>
			</tr>
			<?php
			require("src/database.php");
			$orderID = $_GET['id'];
			$sqlOrder = "SELECT products.*, cart.* 
FROM cart 
INNER JOIN products ON cart.product_id = products.id
WHERE cart.basket_id = " . $orderID;
			$results = mysqli_query($db, $sqlOrder);

			$string ='';

			while ($row = mysqli_fetch_assoc($results)) {
				$string .= '<tr>';
				$string .= "<td>" . $row['name'] . "</td>";
				$string .= "<td>" . $row['description'] . "</td>";
				$string .= "<td>" . $row['price'] . "</td>";
				$string .= "<td>" . $row['quantity'] . "</td>";
				$string .= "</tr>";
			}

			echo $string;
			?>

		<?php include("inc/footer.php"); ?>
		</table>
		<script src="src/js/js.js"></script>
	</body>
</html>
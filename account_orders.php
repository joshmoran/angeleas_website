<?php
session_start();
// Important Columns to be include - Order No,
require "src/database.php";

$basketID = $_SESSION['basket_id'];
$customerID = $_SESSION['customer_id'];
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
		<table>
			<?php
				$sqlOrders = "SELECT order_id, date, status  FROM orders WHERE customer_id = '$customerID' AND complete = true";
				$results = mysqli_query( $db, $sqlOrders );

				$string = '';

				if (mysqli_num_rows($results) < 1 ) {
					$string = '<tr><td>Im sorry you have not placed any orders</td></tr>';
				} else {
					$string =  "<tr>
									<th>Order Number</th>
									<th>Order Status</th>
									<th>Total</th>
									<th>More Information</th>
								</tr>";

					while ( $order =  mysqli_fetch_assoc($results)	) {
						$string .= "<tr>";
						$string .= "<td>" . $order['order_id'] . "</td>";
						$string .= "<td>";
						$string .= $order['status']; 
						$string .= "</td>";
						$string .= "<td>" . $order['date'] . "</td>";
						$string .= "<td><a href='order_history.php?id=" . $order['order_id'] . "' >Details</a></td>";
						$string .= "</tr>";
					}
				}


				print_r( $string );
			?>
		
		</table>
	</div>
	<?php
	include "inc/footer.php";
	?>
	<script src="src/js/js.js"></script>
</body>

</html>
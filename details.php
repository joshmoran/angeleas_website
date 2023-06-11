<?php
session_start();
require "src/database.php";
require "src/random_number.php";

$error_message  = '';
if (!isset($_GET['id']) || empty($_GET['id'])) {
	header("Location: products.php");
}

if (empty($_SESSION['loggedIn']) || !isset($_SESSION['loggedIn'])) {
	if (!isset($_SESSION['customer_id'])) {
		header("Location: products.php?error=customer");
	}

	if (!isset($_SESSION['basket_id'])) {
		header("Location: products.php?error=basket");
	}
}
if (!isset($_SESSION['customer_id']) || empty($_SESSION['customer_id'])) {
	do {
		$no = randomNumber();

		$sql = "SELECT * FROM customers WHERE customer_id = $no";
		$customerResult = mysqli_query($db, $sql);
	} while (mysqli_num_rows($customerResult) < 1);
	$_SESSION['customer_id'] = $no;
	$no = '';
}
if (empty($_SESSION['basket_id'])) {
	// Check if basket id exists in the database, if not create it and update table 'orders'
	$sql = "SELECT order_id FROM orders WHERE customer_id = " . $_SESSION['customer_id'] . " AND complete = '0'";
	$sqlResult = mysqli_query($db, $sql);

	if (mysqli_num_rows($sqlResult) == 0) {
		do {
			$no = randomNumber();
			$_SESSION['basket_id'] = $no;
			$sql = "SELECT * FROM cart WHERE basket_id = $no";
			$basketResults = mysqli_query($db, $sql);
		} while (mysqli_num_rows($basketResults) > 1);

		$no = '';
		$sqlOrder = "INSERT INTO orders (customer_id, order_id, complete) VALUES ( '" . $_SESSION['customer_id'] . "', '" . $_SESSION['basket_id'] . "', 0 )";
		mysqli_query($db, $sqlOrder);
	} else {
		if ($row  = mysqli_fetch_column($sqlResult)) {
			var_dump($row);
			$_SESSION['basket_id'] = $row['basket_id'];
		}
	}
}

if (!empty($_POST['addToBasket'])) {
	$item = $_POST['item'];
	$quantity = $_POST['quantity'];
	$price = $_POST['cost'];
	$productID = $_GET['id'];

	$total = (int)$quantity * (float)$price;
	// Check status is complete
	$sqlStatus = "SELECT * FROM orders WHERE customer_id = " . $_SESSION['customer_id'] . " AND complete = 0";
	$status = mysqli_query($db, $sqlStatus);

	if (mysqli_num_rows($status) === 0  || $_SESSION['basket_id'] == '') {

		do {
			$basketNo = randomNumber();

			$sqlCheckID = "SELECT order_id from orders where order_id = " . $basketNo;
			$checkID = mysqli_query($db, $sqlCheckID);

			$_SESSION['basket_id'] = $basketNo;
		} while (mysqli_num_rows($checkID) > 1);

		$sqlAddToOrder = "INSERT INTO orders ( order_id, customer_id, complete)  VALUES ( '" . $_SESSION['basket_id']  . "', '" .  $_SESSION['customer_id'] . "', 0 )";

		$addOrderQuery = mysqli_query($db, $sqlAddToOrder);
		// $addBasket = mysqli_query($db, $sqlBasket);
	} else {
		$basketNo = $_SESSION['basket_id'];
	}

	// Check if already in basket - if so, update, if not INSERT
	$sqlCheckBasket = "SELECT * FROM cart WHERE basket_id = " . $_SESSION['basket_id'] . " AND product_id = " . $_GET['id'];
	$checkBasketResult = mysqli_query($db, $sqlCheckBasket);

	if (mysqli_num_rows($checkBasketResult) > 0) {
		$sqlInsertToCart = "UPDATE cart SET quantity = " . $quantity . " WHERE basket_id = " . $_SESSION['basket_id'] . " AND product_id = " . $_GET['id'];
	} else {
		$sqlInsertToCart = "INSERT INTO cart ( basket_id, product_id, quantity, total_price ) VALUES ( '" . $_SESSION['basket_id'] . "', '$item', '$quantity', '$total')";
	}
	//header("Location: basket.php");
	//
	$sqlCartResults = mysqli_query($db, $sqlInsertToCart);
	$error_message = 'Add to cart';
}
?>
<!DOCTYPE html>
<html>
<link href="src/css/css.css" rel="stylesheet" type="text/css">
<link href="src/css/details.css" rel="stylesheet" type="text/css">
<title><?php $websiteName . ' - Details'; ?></title>
</head>

<body>
	<header>
		<?php
		include("inc/header.php");
		?>
	</header>
	<div id="messages">
		<?php
		echo '<p>' . $error_message . '</p>';
		?>
	</div>
	<div id="contentSplit">
		<?php
		$string = '';

		if (isset($_GET['id'])) {
			$item = $_GET['id'];
		} else if (isset($_COOKIE['product_id'])) {
			$item = $_COOKIE['product_id'];
		} else {
			header("Location: products.php");
		}

		$sqlItem = "SELECT * FROM products where id = '$item'";
		$results = mysqli_query($db, $sqlItem);
		while ($products = mysqli_fetch_assoc($results)) {
			$string .= "<div id='leftSide'>";
			$string .= "<img src='" . $products['image_src'] . "' alt='" . $products['description'] . "' />";
			$string .= "</div>";
			$string .= "<div id='rightSide'>";
			$string .= "<form method='post'>";
			$string .= "<h2>" . $products['name'] . "</h2>";
			$string .= "<p>" . $products['description'] . "</p>";
			$string .= "<label for='cost'>Price: </label><input type='number' value='£" . $products['price'] . "' name='cost' />";

			$sqlCheckInCart = "SELECT quantity FROM cart WHERE basket_id = " . $_SESSION['basket_id'] . " AND product_id = " . $_GET['id'];
			$sqlCheckInCartQuery = mysqli_query($db, $sqlCheckInCart);
			$string .= '<br>';
			if (mysqli_num_rows($sqlCheckInCartQuery) > 0) {
				while ($inCart = mysqli_fetch_array($sqlCheckInCartQuery)) {
					$string .= "<label for='quantity'>Quantity: </label><input type='number' value='" . $inCart['quantity'] . "' name='quantity' />";
					break;
				}
			} else {
				$string .= "<label for='quantity'>Quantity: </label><input type='number' placeholder='1' name='quantity' value='1'/>";
			}
			$string .= "<input type='hidden' value='" . $products['id'] . "' name='item' />";
			$string .= '<br>';
			$string .= "<input type='submit' name='addToBasket' value='Add to basket' />";
			$string .= "</form>";
			$string .= "</div>";
		}
		echo $string;
		?>
	</div>
	<footer>
		<?php
		include("inc/footer.php");
		?>
	</footer>
	<script src="src/js/js.js"></script>
</body>

</html>
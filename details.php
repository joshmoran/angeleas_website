<?php
session_start();
require "src/database.php";

$error_message  = '';
if ( !isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header("Location: products.php");
}

if ( empty( $_SESSION['basket_id'] && isset( $_SESSION['customer_id'])) ){
	do {
		$no = randomNumber();

		$sqlBasket = "SELECT * FROM orders WHERE customer_id = " . $_SESSION['customer_id'] . " AND order_id = " . $no;
		$basketResults = mysqli_query($db, $sqlBasket);

		$count = mysqli_num_rows($basketResults);
	} while ( $count < 1 );

	$_SESSION['basket_id'] = $no;
}

// if (isset($_POST['addToBasket'])) {
//    $item = $_GET['id'];
//    $quantity = $_POST['quantity'];
//    $price = $_POST['price'];

// }

//if (empty($_GET['id'])){
//    header("Location: products.php");
//    die();
//}

// $_SESSION['current_item'] = $_GET['id'];
function randomNumber() {
    return random_int(0, 9999999999);
}

if ( !empty($_POST['addToBasket'])) {
	$item = $_POST['item'];
	$quantity = $_POST['quantity'];
	$price = $_POST['cost'];
	$productID = $_GET['id'];

	$total = (int)$quantity * (float)$price;
	// Check status is complete
	$sqlStatus = "SELECT * FROM orders WHERE customer_id = " . $_SESSION['customer_id'] . " AND complete = 0";
	$status = mysqli_query( $db, $sqlStatus );
	
	if ( mysqli_num_rows ( $status ) === 0  || $_SESSION['basket_id'] == '') {
		do {
			$basketNo = randomNumber();

			$sqlCheckID = "SELECT order_id from orders where order_id = " . $basketNo;
			$checkID = mysqli_query($db, $sqlCheckID);
			
			$count = mysqli_num_rows($checkID);

		} while ( $count = 0);
		$_SESSION['basket_id'] = $basketNo;
		$sqlAddToOrder = "INSERT INTO orders ( order_id, customer_id, complete)  VALUES ( " . $basketNo  . ", " .  $_SESSION['customer_id'] . ", 0 )";
		$sqlBasket = "update orders set order_id = " . $basketNo . " WHERE complete = 0 AND customer_id = " . $_SESSION['customer_id'];
		$addOrderQuery = mysqli_query($db, $sqlAddToOrder);
		$addBasket = mysqli_query($db, $sqlBasket);
		
	} else {
		$basketNo = $_SESSION['basket_id'];
	} 

	// Check if already in basket - if so, update, if not INSERT
	$sqlCheckBasket = "SELECT * FROM cart WHERE basket_id = " . $_SESSION['basket_id']. " AND product_id = ". $_GET['id'];
	$checkBasketResult = mysqli_query($db, $sqlCheckBasket);

	if ( mysqli_num_rows( $checkBasketResult ) > 0 ) { 
		$sqlInsertToCart = "UPDATE cart SET quantity = " . $quantity . " WHERE basket_id = ". $_SESSION['basket_id']. " AND product_id = ". $_GET['id'];
	} else {
		$sqlInsertToCart = "INSERT INTO cart VALUES ( '$basketNo', '$item', '$quantity', '$total')";
		
	}
	//header("Location: basket.php");
//
$sqlCartResults = mysqli_query($db, $sqlInsertToCart);	
	$error_message = 'Add to cart';
}
?>
<!DOCTYPE html>
<html>
    <link href="src/css/css.css" rel="stylesheet">
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
			
			if ( isset( $_GET['id'])) {
				$item = $_GET['id'];
			} else if ( isset( $_COOKIE['product_id'] )) {
				$item = $_COOKIE['product_id'];
			} else {
				header("Location: products.php");
			}

			$sqlItem = "SELECT * FROM products where id = '$item'";
			$results = mysqli_query($db, $sqlItem);
			while( $products = mysqli_fetch_assoc($results)){
				$string .= "<div id='leftSide'>";
				$string .= "<img src='" . $products['image_src'] . "' alt='" . $products['description'] . '" />';
				$string .= "</div>";
				$string .= "<div id='rightSide'>";
				$string .= "<form method='post'>";
				$string .= "<h2>" . $products['name'] . "</h2>";
				$string .= "<p>" . $products['description'] . "</p>";
				$string .= "<input type='number' value='" . $products['price'] . "' name='cost' />";
				
				$sqlCheckInCart = "SELECT quantity FROM cart WHERE basket_id = " . $_SESSION['basket_id'] . " AND product_id = " . $_GET['id'];
				$sqlCheckInCartQuery = mysqli_query($db, $sqlCheckInCart);
				if ( mysqli_num_rows($sqlCheckInCartQuery) > 0 ){
					while ( $inCart = mysqli_fetch_array($sqlCheckInCartQuery) ) {
						$string .= "<input type='number' value='" . $inCart['quantity'] . "' name='quantity' />";
						break;
					}
				} else  {
					$string .= "<input type='number' placeholder='1' name='quantity' value='1'/>";
				}
				$string .= "<input type='hidden' value='" . $products['id'] . "' name='item' />";
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
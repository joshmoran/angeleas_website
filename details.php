<?php
session_start();
require_once "src/database.php";

$error_message  = '';
if ( !isset( $_GET['id'] )){
	// if ( isset( $_SESSION['product_id']) ){
	// 	header("Location: details.php?id=" . $_SESSION['product_id']);
	// } else {
	// 	header("Location: products.php");
	// }
} else if ( isset( $_GET['id'])){
	$product = $_GET['id'];
	setcookie("product_id", $product, time() - 3600);
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


if ( !empty($_POST['addToBasket'])) {
	$item = $_POST['item'];
	$quantity = $_POST['quantity'];
	$price = $_POST['cost'];

	$basketID = $_SESSION['basket_id'];
	$productID = $_GET['id'];
	$sqlCheckInCart = "SELECT * from cart WHERE product_id = " . 

	$sqlInsertToCart = "INSERT INTO cart VALUES ( '$basketID', '$item', '$quantity', '$total')";

	$sqlCartResults = mysqli_query($db, $sqlInsertToCart);

	header("Location: basket.php");

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
				
				$sqlCheckInCart = "SELECT quantity FROM cart WHERE product_id = " . $product;
				$sqlCheckInCartQuery = mysqli_query($db, $sqlCheckInCart);
				if ( mysqli_num_rows($sqlCheckInCartQuery) > 0 ){
					$inCart = mysqli_fetch_column($sqlCheckInCartQuery);
					$string .= "<input type='number' value='" . $inCart . "' name='quantity' />";
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
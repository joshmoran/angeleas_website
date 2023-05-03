<?php
session_start();
require_once "src/database.php";

$error_message  = '';

//if (isset($_POST['addToBasket'])) {
//    $item = $_GET['id'];
//    $quantity = $_POST['quantity'];
//    $price = $_POST['price'];
//    echo 'yse';

//    header("Location: details.php?id=" . $item);
//}

//if (empty($_GET['id'])){
//    header("Location: products.php");
//    die();
//}


if ( !empty($_POST['addToBasket'])) {
	$item = $_POST['item'];
	$quantity = $_POST['quantity'];
	$price = $_POST['cost'];

	$basketID = $_SESSION['basket_id'];

	(float)$total = (float)$price * (int)$quantity;

	$sqlInsertToCart = "INSERT INTO cart VALUES ( '$basketID', '$item', '$quantity', '$total')";

	$sqlCartResults = mysqli_query($db, $sqlInsertToCart);

	header("Location: details.php?id=" . $item);

	$error_message .= 'Add to cart';
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
			
			$item = $_GET['id'];

			$sqlItem = "SELECT * FROM products where id = '$item'";
			$results = mysqli_query($db, $sqlItem);
			while( $products = mysqli_fetch_assoc($results)){
				$string .= "<div id='leftSide'>";
				$string .= "<img src='" . $products['image_src'] . "' alt='" . $products['description'] . '" />';
				$string .= "</div>";
				$string .= "<div id='rightSide'>";
				$string .= "<form action='details.php' method='post'>";
				$string .= "<h2>" . $products['name'] . "</h2>";
				$string .= "<p>" . $products['description'] . "</p>";
				$string .= "<input type='number' value='" . $products['price'] . "' name='cost' />";
				$string .= "<input type='number' placeholder='1' name='quantity' value='1'/>";
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
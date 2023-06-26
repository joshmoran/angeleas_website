<?php
session_start();

//require "src/functions.php";
require "src/database.php";
$itemsPerPage = 5;


if (!isset($filter)) {
    $filter = 0;
}
if (!isset($pageNo)) {
    $pageNo = 0;
}
if (!isset($item) && !isset($quantity)) {
    $item = 0;
    $quantity = 0;
}

if (!empty($_GET['error'])) {
    if ($_GET['error'] == 'customer' || $_GET['error'] == 'basket') {
        $error_message = 'Please Login to continue';
    }
}

if (isset($_SESSION['basket_id'])) {
    $basketID = $_SESSION['basket_id'];
}

if (isset($_SESSION['customer_id'])) {
    $customerID = $_SESSION['customer_id'];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


if (!empty($_POST['pages'])) {
    (int)$pageNo = $_POST['page'];

    if (isset($_SESSION['basket'])) {
        $basket = $_SESSION['basket'];
    } else {
        $basket = array();
    }
}
if (!empty($_POST['category'])) {
    (int)$filter = $_POST['cat'];
}

//if (!empty($_POST['item'])) {
//    $item = $_POST['buy'];
//    $quantity = $_POST['quantity'];
//    $price = $_POST['price'];

//    $lengthBasket = count ( $_SESSION['cart']);

//    $_SESSION['cart'][] =  array(
//        'title' => $item,
//        'quantity' => $quantity,
//        'price' => $price
//    );

//    var_dump($_SESSION['cart'][0]);


//    $error_message = 'item: ' . $item . ' - quantity: ' . $quantity . ' - price: ' . $price;
//    var_dump($_SESSION['cart']);
//    if ($_SESSION['loggedIn'] == true) {
//        try {
//             addToBasket( $item, $quantity, $price);
//        } catch (Exception $e) {
//            $error_message = $e->getMessage();
//        }
//    } else {
//        $error_message = 'Please login to continue';
//    }
//}
//if (!empty($_POST['item'])) {
//    echo 'yes, yes';
//    $totalPages = $_SESSION['totalItems'];


//    for( $a = 0; $a < $totalPages; $a++ ){
//        if (  isset( $_SESSION['item' . $a]) || isset( $_SESSION['quantity' . $a]) || isset( $_SESSION['price' . $a] )) {

//            $item = $_POST['buy' . $a];
//            echo $item;

//            $quantity = $_POST['quantity' . $a];
//            echo $quantity;

//            $price = $_POST['price' . $a];
//            echo $price;

//            if ( isset($_POST['name' . $a])){
//                $error_message = 'This Item' . $item . ' for this many ' . $quatity . " for this price " . $price;
//            }
//        }
//    }
//}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="View all products in our catalog">
    <title><?php echo $websiteName . ' - All Products'; ?></title>

    <link rel="stylesheet" href="src/css/css.css" type="text/css " />
    <link rel="stylesheet" href="src/css/products.css" type="text/css " />

</head>

<body>
    <?php
    require "inc/header.php";
    ?>
    <div id="container">
        <div id="messages">
            <?php
            if (isset($error_message)) {
                echo '<h2 id="message">Error - ' . $error_message . '</h2>';
            }
            ?>
        </div>
        <div id="top">
            <h1>All Products</h1>
            <form method="POST" action="products.php">
                <div id="pagination">
                    <?php
                    $sql = "SELECT * FROM products";

                    if (isset($filter) && $filter != 0) {
                        $sql .= " WHERE id = " . $filter;
                    }
                    $result = mysqli_query($db, $sql);
                    $totalPages = mysqli_num_rows($result);
                    $_SESSION['totalItems'] = $totalPages;
                    (int)$noOfPages = ceil($totalPages  / $itemsPerPage) - 1;
                    for ($a = 0; $a <= $noOfPages; $a++) {
                        echo '<button type="submit" form="pages" name="page" value="' . $a . '">Page ' . $a + 1 . '</button>';
                    }

                    ?>
                </div>
            </form>
            <form action="products.php" id="category" method="post">
                <label for="category">Category: </label>
                <select id="category" name="cat" selected="<?php echo $filter; ?>">
                    <option value="0">All Products</option>
                    <?php
                    $result = mysqli_query($db, "SELECT * FROM types");

                    while ($type = mysqli_fetch_assoc($result)) {
                        echo '<option type="submit" form="category" value="' . $type['id'] . '" name="cat">' . $type['name'] . '</option>';
                    }
                    ?>

                </select>

                <input type="submit" name="category" value="Filter" />
            </form>
        </div>
        <div id="container">
            <form action="products.php" method="post" name="item">

                <ul id="listParent">
                    <?php
                    $sql = "SELECT * FROM products";
                    if (isset($filter) && $filter !== 0) {
                        $pageNo = $_POST['cat'];
                        $sql .= " WHERE category = " . (int)$filter;
                    }
                    $sql .= " LIMIT " . (int)$itemsPerPage;
                    if (isset($_POST['page'])) {
                        $pageNo = $_POST['page'];
                    } else {
                        $pageNo = 0;
                    }
                    $offsetNo = $pageNo * $itemsPerPage;
                    if (!empty($pageNo)) {
                        $sql .= " OFFSET " . (int)$offsetNo;
                    }
                    $result = mysqli_query($db, $sql);
                    //                    $prod = getProducts($pageNo, $itemsPerPage, $filter);
                    $counter = 1;
                    $string = '';
                    while ($products = mysqli_fetch_assoc($result)) {
                        //(int)$no =  $products['id'];
                        echo '<li><a href="details.php?id=' . $products['id'] . '"><img src="' . $products['image_src'] . '" alt="' . $products['description'] . '" /></a><h2>' . $products['name'] . '</h2>
						<p>' . $products['price'] . '</p></li>';
                    }

                    //$0counter = $counter + 1;
                    // <input type="number" name="quantity' . $products['id'] . '" value="" />
                    //  <input type="hidden" name="buy" value="' . $products['id'] . '
                    // <input type="submit" name="item" value="Submit" />" />

                    //        $string .= '<a href="details.php?id=' . $products['id'] . '" class="product">
                    //    <img src="' . $products['image_src'] . '" alt="' . $products['description'] . '" />

                    //    <input type="number" name="quantity" placeholder="1" />
                    //    <input type="number" name="price" value="' . $products['price'] . '"  placeholder="1" disabled />
                    //    <input type="submit" name="name"  value="add to basket" />
                    //</a>';
                    //        $string = $products['id'];

                    //						print_r ( $string );

                    ?>
                </ul>
            </form>
        </div>
    </div>
    <?php
    //  include("inc/footer.php");
    ?>
    <script src="src/js/js.js"></script>
</body>

</html>
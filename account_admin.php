<?php
session_start();
if ($_SESSION['admin'] == false) {
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="src/css/css.css" type="text/css" />
    <title></title>
</head>

<body>
    <?php
    include "inc/header.php";
    ?>
    <div id="container">
        <table>
            <tr>
                <th>Order Number</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Order Details</th>
                <th>Postage Details</th>
            </tr>
            <?php
            require "src/database.php";
            $sql = "SELECT * FROM orders LEFT JOIN customers ON orders.customer_id=customers.customer_id WHERE complete = 1";
            $sqlQuery = mysqli_query($db, $sql);
            while ($user = $sqlQuery->fetch_assoc()) {
                echo '<tr';
                var_dump($user['addres']);
                echo '<td>' . $user['order_id'] . '</td';
                echo '<td>' . $user['time_ordered'] . '</td>';
                echo '<td>' . $user['status'] . '</td>';
                // Customer ID
                $customerID = $_SESSION['customer_id'];
                // Customer Order Details
                $sqlItems = "SELECT purchases.quantity, purchases.product_id, products.name FROM purchases INNER JOIN products ON purchases.product_id=products.id WHERE purchases.customer_id = " . $customerID;
                $sqlQueryItems = mysqli_query($db, $sqlItems);
                echo '<td>';
                while ($user = mysqli_fetch_assoc($sqlQueryItems)) {

                    echo $item['name'] . ' X ' . $item['quantity'] . '<br>';
                }
                echo '</td>';
                // Customer Address
                $sqlAddress = "SELECT * FROM address WHERE customer_id = $customerID";
                $sqlQueryAddress = mysqli_query($db, $sqlAddress);
                foreach (mysqli_fetch_assoc($sqlQueryAddress) as $address) {
                    echo '<td>' . $address['1_line'] . '<br>' . $address['2_line'] . '<br>' . $address['3_line'] . '<br>' . $address['region'] . '<br>' . $address['postcode'] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </div>
    <?php
    include "inc/footer.php";
    ?>
</body>

</html>
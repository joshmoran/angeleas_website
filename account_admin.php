<?php
session_start();

require "src/database.php";


if ($_SESSION['admin'] == false || !isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    header("Location:login.php");
}
// dispatch 
// accept 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['accept']) && isset($_GET['customer_id']) && isset($_GET['basket_id'])) {
        $customerID = mysqli_escape_string($db, $_GET['customer_id']);
        $basketID = mysqli_escape_string($db, $_GET['basket_id']);

        $sql = "UPDATE orders SET status = 'order accepted, awaiting dispatch' WHERE customer_id = $customerID AND order_id = $basketID";

        if (mysqli_query($db, $sql)) {
            $error_message = 'Changed status - accepted order';
        } else {
            $error_message = 'There has been a problem changing the order status, please contact the administrator';
        }
    }

    if (isset($_GET['dispatch']) == true && isset($_GET['customer_id']) && isset($_GET['basket_id'])) {
        $customerID = mysqli_escape_string($db, $_GET['customer_id']);
        $basketID = mysqli_escape_string($db, $_GET['basket_id']);
        echo '2';

        $sql = "UPDATE orders SET status = 'order dispatched' WHERE customer_id = " . $customerID . " AND order_id = " . $basketID;

        if (mysqli_query($db, $sql)) {
            $error_message = 'Changed status - accepted order';
        } else {
            $error_message = 'There has been a problem changing the order status, please contact the administrator';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The interface for administration staff to view pending orders and change their current order status">
    <link rel=" stylesheet" href="src/css/css.css" type="text/css" />
    <title><?php echo $websiteName; ?> - Admin</title>
</head>

<body>
    <?php
    include "inc/header.php";
    ?>
    <?php
    if (isset($error_message)) {
        echo '<p class="message">' . $error_message . '</p>';
    }
    ?>
    <div id="container">
        <table><?php
                require "src/database.php";


                $sql = "SELECT * FROM orders LEFT JOIN customers ON orders.customer_id=customers.customer_id WHERE complete = 1 AND NOT status = 'order dispatched'";
                $sqlQuery = mysqli_query($db, $sql);

                if (mysqli_num_rows($sqlQuery) > 0) {
                    $string = '<thead><th>Order Number</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Order Details</th>
                <th>Postage Details</th>
                <th>Accept Order</th>
                <th>Order Dispatched</th>
                </thead>';
                    while ($user = $sqlQuery->fetch_assoc()) {


                        $string .= '<tr>';

                        $string .=  '<td>' . $user['order_id'] . '</td>';
                        $string .=  '<td>' . $user['time_ordered'] . '</td>';
                        $string .=  '<td>' . $user['status'] . '</td>';
                        // Customer ID
                        $customerID = $_SESSION['customer_id'];
                        // Customer Order Details
                        $sqlItems = "SELECT * FROM purchases INNER JOIN products ON purchases.product_id=products.id WHERE purchases.customer_id = " . $customerID;
                        $sqlQueryItems = mysqli_query($db, $sqlItems);
                        $string .=  '<td><ul>';
                        while ($item = $sqlQueryItems->fetch_assoc()) {
                            $string .=  '<li>' . $item['name'] . ' X ' . $item['quantity'] . '</li>';
                        }
                        $string .=  '</ul></td>';
                        // Customer Address
                        $address = explode(",", $user['address']);
                        $string .=  '<td>' . $user['name'] . '<br>' . trim($address[0]) . '<br>' . trim($address[1]) . '<br>' . trim($address[2]) . '<br>' . trim($address[3]) . '<br>' . trim($address[4]) . '</td>';
                        // $sqlAddress = "SELECT * FROM address WHERE customer_id = $customerID";
                        // $sqlQueryAddress = mysqli_query($db, $sqlAddress);
                        // foreach (mysqli_fetch_assoc($sqlQueryAddress) as $address) {
                        //     
                        // }
                        // order status breakdown
                        // 'waiting for to be accepted'
                        // 'order accepted, awaiting dispatch'
                        // 'order dispatched'
                        if ($user['status'] == 'waiting for to be accepted') {
                            $string .= '<td><a href="account_admin.php?accept=true&customer_id=' . $user['customer_id'] . '&basket_id=' . $user['order_id'] . '"><button>Accept</button></a></td>';
                        } else {
                            $string .= '<td></td>';
                        }

                        if ($user['status'] != 'order dispatched') {
                            $string .= '<td><a href="account_admin.php?dispatch=true&customer_id=' . $user['customer_id'] . '&basket_id=' . $user['order_id'] . '"><button>Dispatched</button></a></td>';
                        } else {
                            $string .= '<td></td>';
                        }
                        $string .=  '</tr>';
                    }

                    echo $string;
                } else {
                    echo '<tr>';
                    echo '<td>There are no outstanding orders</td>';
                    echo '</tr>';
                }

                ?><tbody>
        </table>
    </div><?php
            include "inc/footer.php";
            ?>
</body>

</html>
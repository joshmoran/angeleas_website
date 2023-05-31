<?php
session_start();
if ($_SESSION['admin'] == false) {
    header("Location:login.php");
}
// dispatch 
// accept 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accept']) && isset($_POST['customer_id']) && isset($_POST['basket_id'])) {
        $customerID = mysqli_escape_string($db, $_POST['customer_id']);
        $basketID = mysqli_escape_string($db, $_POST['basket_id']);

        $sql = "UPDATE orders SET status = 'order accepted, awaiting dispatch' WHERE customer_id = $customerID AND basket_id = $basketID";

        if ( mysqli_query($db, $sql)) {
            $errors[] = ''
        }
    }

    if (isset($_POST['accept']) && isset($_POST['customer_id']) && isset($_POST['basket_id'])) {
    }
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
    <style>
        table,
        td,
        th,
        tr {
            border: 1px solid #000;
        }

        th {
            width: 5em;
        }

        td {
            width: 10em;
        }
    </style>

</head>

<body><?php
        include "inc/header.php";
        ?><div id="container">
        <table><?php
                require "src/database.php";
                $sql = "SELECT * FROM orders LEFT JOIN customers ON orders.customer_id=customers.customer_id WHERE complete = 1 AND NOT status = 'order dispatched'";
                $sqlQuery = mysqli_query($db, $sql);
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

                    var_dump($user);
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
                    $address = explode(",", $user['addres']);
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
                        $string .= '<td><a href="account_admin.php?accept=true&customer_id=' . $user['order_id'] . '&basket_id=' . $user['order_id'] . '"><button>Accept</button></a></td>';
                    } else {
                        $string .= '<td></td>';
                    }

                    if ($user['status'] != 'order dispatched') {
                        $string .= '<td><a href="account_admin.php?dispatch=true&customer_id=' . $user['order_id'] . '&basket_id=' . $user['order_id'] . '"><button>Dispatched</button></a></td>';
                    } else {
                        $string .= '<td></td>';
                    }
                    $string .=  '</tr>';
                }

                echo $string;
                ?><tbody>
        </table>
    </div><?php
            include "inc/footer.php";
            ?></body>

</html>
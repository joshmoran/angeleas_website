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
            $sql = "SELECT * FROM orders INNER JOIN customers ON orders.customer_id=customers.customer_id WHERE complete = 1";
            $sqlQuery = mysqli_query($db, $sql);
            foreach (mysqli_fetch_assoc($sqlQuery) as $user) {
                echo 
            }
            ?>
        </table>
    </div>
    <?php
    include "inc/footer.php";
    ?>
</body>

</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account Home</title>
    <link href="src/css/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include "inc/header.php";
	echo $_SESSION['customer_id'];
    ?>
    <div id="container">
        <table>
            <tr>
                <th colspan="2">Your Account</th>
            </tr>
            <tr>
                <td><a href="account_details.php">Change Account Details</a></td>
                <td><a href="account_orders.php">Your Order</a></td>
            </tr>
        </table>
    </div>
    <?php
    include "inc/footer.php"
    ?>
    <script src="src/js/js.js"></script>
</body>

</html>
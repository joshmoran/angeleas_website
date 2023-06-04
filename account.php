<?php
session_start();
require 'src/variables.php';
if ($_SESSION['loggedIn'] == false) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $websiteName; ?> - Account Home</title>
    <link href="src/css/css.css" rel="stylesheet" type="text/css" />
    <link href="src/css/account.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include "inc/header.php";

    ?>
    <div id="container">

                <h2>Your Account</h2>
                <a href="account_details.php">Change Account Details</a>
                <a href="account_orders.php">Your Order</a>
                <?php
                if ($_SESSION['admin']) {
                    echo '<a href="account_admin.php">View pending orders</a>';
                }
                ?>
            </tr>
        </table>
    </div>
    <?php
    include "inc/footer.php"
    ?>
    <script src="src/js/js.js"></script>
</body>

</html>
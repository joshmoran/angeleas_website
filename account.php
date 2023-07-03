<?php
session_start();
require 'src/variables.php';
require 'src/database.php';
if ($_SESSION['loggedIn'] == false || !isset($_SESSION['loggedIn'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Main Page for logged in accounts and offers use for: viewing orders or changing details">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <?php
        $sqlName = "SELECT first_name, last_name FROM customers WHERE customer_id = " . $_SESSION['customer_id'];
        $nameQuery = mysqli_query($db, $sqlName);

        foreach ($nameQuery as $user) {
            $fullName = $user['first_name'] . ' ' . $user['last_name'];
        }

        $sqlName = "SELECT username FROM accounts WHERE customer_id = " . $_SESSION['customer_id'];
        $usernameQuery = mysqli_query($db, $sqlName);

        foreach ($usernameQuery as $user) {
            $username = $user['username'];
        }
        ?>

        <h3 style="text-align: center">Welcome <?php echo $fullName . ' (' . $username . ')'; ?></h3>
        <a href="account_details.php"><button>Change Account Details</button></a>
        <br>
        <br>
        <a href="account_orders.php"><button>Your Orders</button></a>
        <br>
        <?php
        if ($_SESSION['admin']) {
            echo '<br>';
            echo '<a href="account_admin.php"><button>View pending orders</button></a>';
        }
        ?>
    </div>
    <?php
    include "inc/footer.php"
    ?>
    <script src="src/js/js.js"></script>
</body>

</html>
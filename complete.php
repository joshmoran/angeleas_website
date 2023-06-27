<?php
session_start();
include "src/variables.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Your order has been placed. Thank you for your support. We will update you on your order progress">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $websiteName; ?> - Order Complete</title>
    <link href="src/css/css.css" rel="stylesheet" type="text/css" />
    <style>
        .complete {
            margin: 0 auto;
            top: 6em;
            width: fit-content;
            height: 15em;
        }
    </style>
</head>

<body>
    <?php
    include "inc/header.php";
    ?>
    <div id="messages">
        <?php
        if (isset($error_message)) {
            echo '<h2 id="message">Error - ' . $error_message . '</h2>';
        }
        ?>
    </div>
    <div class="container">
        <div class="complete">
            <h1>Thank you for your order</h1>
            <p>We will email you when their are updates on your order</p>
        </div>
    </div>
    <?php
    include "inc/footer.php";
    ?>
</body>

</html>
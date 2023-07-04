<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="src/css/css.css" rel="stylesheet" type="text/css" />
    <title></title>
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
            echo '<p class="message">' . $error_message . '</p>';
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
<?php
    require "src/functions.php";

if (!isset($_COOKIE['loggedIn']) || $_COOKIE['loggedIn'] == 0) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="src/css/css.css" />
    <title><?php echo $websiteName . ' - Logout'; ?></title>
</head>

<body>
    <?php
    include "inc/header.php";
    ?>

    <div id="messages">
        <?php
        if (isset($message)) {
            echo '<h2>Error - ' . $message . '</h2>';
        }
        ?>
    </div>

    <?php
    include "inc/footer.php";
    ?>
</body>
</html>
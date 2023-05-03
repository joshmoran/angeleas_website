<?php
session_start();
require "src/functions.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $websiteName . ' - Home'; ?></title>
    <link rel="stylesheet" href="src/css/css.css" type="text/css" />
</head>

<body>
    <?php include("inc/header.php"); ?>
    <div id="container">
        <div id="imgScroll">
            <img src="src/img/banner/0.jpg" alt="banner">
            <ul id="btnImg">
                <li><button id="home0"><img src="src/img/banner/selected.jpg" /></button></li>
                <li><button id="home1"><img src="src/img/banner/unselected.jpg" /></button></li>
                <li><button id="home2"><img src="src/img/banner/unselected.jpg" /></button></li>
            </ul>
        </div>
        <div id="contentSplit">
            <div id="leftSide">

            </div>
            <div id="rightSide">

            </div>
        </div>
        <?php include("inc/footer.php"); ?>
        <script src="src/js/js.js"></script>
</body>

</html>
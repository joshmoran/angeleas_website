<?php
$status = $_SESSION['loggedIn'];

if ( $status == false ) {
    header("Location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title></title>    
        <link href="src/css/css.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- 
                1. Address
                2. Card Numbers
                3. Basket 
            -->
            <div id="address">

            </div>
            <div id="card">

            </div>
            <div id="basket">

            </div>
        </div>
    </body>
</html>
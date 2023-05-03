<?php

// basket tqble
//// orderNo
//// customerNo
/// productNo
/// quantity
//// total_price


function addToBasket( $item, $quantity, $total ) {
    require "src/database.php";

    $pending = $db->query("");

if ( !empty( $pending )){
    do {
        $randomNo = rand(100000, 999999 );
        $checkNo = $db->query('SELECT product_id FROM cart WHERE product_id = ' . $randomNo );
    } while ( empty($checkNo));
}
    
    $sql = "INSERT INTO cart (basket_id, product_id, quantity, total_price ) VALUES ( ?, ?, ?, ? );";
    $intoBasket = $db->prepare($sql);
    $intoBasket->bindParam(1, $randomNo, PDO::PARAM_INT);
    $intoBasket->bindParam(2, $item, PDO::PARAM_INT);
    $intoBasket->bindParam(3, $quantity, PDO::PARAM_INT);
    $intoBasket->bindParam(4, $total, PDO::PARAM_INT);
    $intoBasket->execute();
    echo $randomNo;
    return true;
}

function listBasket() {
    require "src/database.php";

    $sql = "SELECT * FROM cart WHERE customer_id = ?;";

    $listBasket = $db->prepare( $sql );
    $listBasket->bindParam( 1, $customer_id, PDO::PARAM_INT);
    $listBasket->execute();

    return $listBasket;
}
if ( !empty( $_POST['button'])){
    echo 'yep';
    try {
        if ( addToBasket('item', 2, 5.99)){
            return true;
        } else {
            echo 'nope';
        }
    } catch (Exception $e){
        echo $e->getMessage();
    }
}
?>

<div id="container">
<form action="creating.php" id="button" method="post">
    <input type="submit" name="button" value="Click Me" >
</form>
</div>

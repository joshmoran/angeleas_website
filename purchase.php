<?php
session_start();
$status = $_SESSION['loggedIn'];
require "src/database.php";

if ( $status == false ) {
    header("Location: index.php");
    die();
}

if ( !empty( $_POST['addAddress'])){
    $line1 = $_POST['1_line'];
    $line2 = $_POST['2_line'];
    $line3 = $_POST['3_line'];
    $region = $_POST['region'];
    $postcode = $_POST['postcode'];

    $customerID = $_SESSION['customer_id'];

    $sqlAddAddress= "INSERT INTO address VALUES ( '$customerID', '$line1', '$line2', '$line3', '$region', '$postcode' )";

    if ( mysqli_query($db, $sqlAddAddress)){
        $error_message = 'Successfully added the address';
    } else {
        $error_message = "Failed to add address";
    }

    $_POST['addAddress'] = '';
}
if ( !empty( $_POST['addCard'])){
    $card = $_POST['card_number'];
    $expiry = $_POST['expiry'];

    $customerID = $_SESSION['customer_id'];

    $sqlAddCard = "INSERT INTO credit_cards VALUES ( '$customerID', '$card', '$expiry' )";

    if ( mysqli_query($db, $sqlAddCard)){
        $error_message = 'Successfully added the card';
    } else {
        $error_message = "Failed to add card";
    }

    $_POST['addCard'] = '';
    
}

if ( !empty( $_POST['purchase']) ) {
    $selectedCard = $_POST['card'];
    $selectedAddress = $_POST['address'];

    $customerID = $_SESSION['customer_id'];
    $basketID = $_SESSION['basket_id'];

    $time = date('Y-m-d');

    $sqlCart = "SELECT * FROM cart WHERE basket_id = '$basketID'";
    $cartQuery =  mysqli_query($db, $sqlCart);

    while ($row = mysqli_fetch_array($cartQuery)) {
        $sqlPurchase = "INSERT INTO purchases ( basket_id, customer_id, product_id, quantity ) VALUES ( " . $basketID . ", " . $customerID . ", " . $row['product_id'] . ", " . $row['total_price'] . " );";
        $purchaseQuery = mysqli_query($db, $sqlPurchase );
        $sqlPurchase = '';
    }

    $sqlName = "SELECT first_name, last_name FROM customers where customer_id = " . $customerID;
    $nameQuery = mysqli_query($db, $sqlName);

    while( $nameArray = mysqli_fetch_array($nameQuery) ){
        $name = $nameArray['first_name'] . ' ' . $nameArray['last_name'];
    }
    
    $insertCard = substr($selectedCard,12, 4);
    echo $insertCard;

    $sqlOrder = "UPDATE orders SET status = 'waiting for to be accepted', complete = true, date = " . date('Ymd') . ", address = '" . $selectedAddress . "', card = " . $insertCard . ", name = '" . $name . "' WHERE order_id = " . $_SESSION['basket_id'] . " AND customer_id = " . $_SESSION['customer_id'];
    $orderQuery = mysqli_query( $db, $sqlOrder );

    $sqlDeleteCart = "DELETE FROM cart WHERE basket_id = " . $basketID;

    $_SESSION['basket_id'] = '';

    if ( mysqli_query( $db, $sqlDeleteCart)  ) {
        header("Location: complete.php");
        exit();
    } else {
        $error_message = "Could not complete your order";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title></title>
        <link href="src/css/css.css" rel="stylesheet" type="text/css" />
        <style>
            #addressModel {
                display: none;
            }

            #cardModel {
                display: none;
            }
        </style>

    </head>
    <body>
        <?php
            include "inc/header.php";
            
        ?>
        <div id="container">
            <div id="messages">
            <?php
            if (isset($error_message)) {
                echo '<h2 id="message">Error - ' . $error_message . '</h2>';
            }
            ?>
        </div>
            <!-- 
                1. Address
                2. Card Numbers
                3. Basket 
            -->
            <h2>Your Order</h2>
            <form action="purchase.php" method="post" id="purchase">
            <div id="address">
                <h2>Address: </label>
                <br>
                <select name="address" form="purchase">
                    <?php
                        $sqlAddress = "SELECT 1_line, 2_line, 3_line, region, postcode FROM address WHERE id = " . $_SESSION['customer_id'];
                        $addressQuery = mysqli_query($db,$sqlAddress);
                        
                        while( $row = mysqli_fetch_assoc($addressQuery) ){
                            $string = implode(", ", $row);
                            echo "<option value='$string'>$string</option>";
                        }
                    ?>
                </select>
                <button id='addressBtn'>Add a new address</button>

            </div>
            <div id="addressModel"">
                <form action="purchase.php" method="post" id="addAddress">
                    <label for="1_line">1st Line</label>
                    <input type="text" name="1_line" placeholder="First line of address" />
                    <br>
                    <label for="2_line">2nd Line</label>
                    <input type="text" name="2_line" placeholder="Second line of address" />
                    <br>
                    <label for="3_line">3rd Line</label>
                    <input type="text" name="3_line" placeholder="Third line of address" />
                    <br>
                    <label for="region">Region</label>
                    <input type="text" name="region" placeholder="Third line of address" />
                    <br>
                    <label for="postcode">Postcode</label>
                    <input type="text" name="postcode" placeholder="Third line of address" />
                    <br>
                    <input type="submit" name="addAddress" value="Add address" />
                </form>
            </div>
            <div id="card">
                <h2>Credit Card</h2>
                <select name="card" form="purchase">
                <?php
                $customerID = $_SESSION['customer_id'];
                    $sqlCard = "SELECT * FROM credit_cards WHERE customer_id = " . $customerID;
                    $cardQuery = mysqli_query($db, $sqlCard);
                    var_dump($cardQuery);
                    while( $row = mysqli_fetch_assoc($cardQuery) ){
                        (int)$cardNo = $row['card_number'];
                        $cardNoFormatted = implode(' ', str_split( $cardNo, 4));

                        echo $cardNoFormatted;
                        echo "<option>Card Number:  " . $cardNoFormatted . ", Expiry:  " . $row['expiry'] . "</option>";
                        echo substr($cardNo,12, 4);
                    }

                ?>
                </select>
                    <button id="cardBtn">Add Card</button>
            </div>
            <div id="cardModel">
                <form action="purchase.php" method="post" id="addCard">
                    <label for="card_number">Card Number</label>
                    <input type="text" name="card_number" placeholder="Card number" />
                    <br>
                    <label for="expiry">Expiry</label>
                    <input type="text" name="expiry" placeholder="Expiry" />
                    <br>
                    <input type="submit" name="addCard" value="Add card to account" />
                </form>
            </div>
        
            <div id="basket">
                <table>.
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
                        $basketID = $_SESSION['basket_id'];
                        $sqlCart = "SELECT * FROM cart INNER JOIN products on cart.product_id = products.id  WHERE basket_id = ". $basketID;
                        $basketQuery = mysqli_query($db,$sqlCart);

                        $total = 0;

                        while ( $row = mysqli_fetch_assoc($basketQuery)){
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "</tr>";

                            $total += (int)$row['quantity'] * (float)$row['price'];
                        }
                    ?>
                    <tr>
                        <td colspan="3" align="right">Grand Total:</td>
                        <td><?php echo $total; ?></td>
                    </tr>

                </table>
            </div>
            <input type="submit" name="purchase" form="purchase" value="Process Order" />
            </form>
        </div>
        <?php
            include "inc/footer.php";
        ?>
        <script src="inc/js/js.js"></script>
        <script>
            let addressModelDiv = document.getElementById('addressModel');
            let addressModelBtn = document.getElementById('addressBtn');
            
            addressModelBtn.addEventListener('click', (event) => {
                event.preventDefault();
                if ( addressModelDiv.offsetHeight < 1 && addressModelDiv.offsetWidth < 1 ) {
                    addressModelDiv.style.display = 'block';
                } else {
                    addressModelDiv.style.display = 'none';
                }
            });

            let cardModelDiv = document.getElementById('cardModel');
            let cardModelBtn = document.getElementById('cardBtn');

            cardModelBtn.onclick = function(event) {
                event.preventDefault();
                if ( cardModelDiv.offsetHeight < 1 && cardModelDiv.offsetWidth < 1 ) {
                    cardModelDiv.style.display = 'block';
                } else {
                    cardModelDiv.style.display = 'none';
                }
            };

        </script>
    </body>
</html>
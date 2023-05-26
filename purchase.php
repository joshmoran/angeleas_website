<?php
session_start();
require "src/database.php";

// Check if user is logged in, if not then redirect him to login page
if ($_SESSION['loggedIn'] == false || !isset($_SESSION['loggedIn'])) {
    header("Location: index.php");
    die();
}

// Initialize array for any errors
$errors = array();

// On page load check if there are any errors being passed
if (isset($_GET['error'])) {
    // For address errors
    if ($_GET['error'] == 'address') {
        $errors[] = 'Please provide a valid address.';
    }

    // For credit card errors
    if ($_GET['error'] == 'card') {
        $errors[] = 'Please provide a valid credit card number.';
    }
}

// Add functionality to add an address to the users account
if (!empty($_POST['addAddress'])) {
    $customerID = $_SESSION['customer_id'];

    // Main variables needed
    // line 1, line 2, region and postcode

    // First line of address
    if (empty($_POST['1_line'])) {
        $errors[] = 'Please provide a valid first line of address.';
    } else {
        $line1 = mysqli_real_escape_string($db, $_POST['1_line']);
    }

    // Second line of address
    if (empty($_POST['2_line'])) {
        $errors[] = 'Please provide a valid second line of address.';
    } else {
        $line2 = mysqli_real_escape_string($db, $_POST['2_line']);
    }

    $line3 = mysqli_real_escape_string($db, $_POST['3_line']);

    // Region of address
    if (empty($_POST['region'])) {
        $errors[] = 'Please provide a valid region.';
    } else {
        $region = mysqli_real_escape_string($db, $_POST['region']);
    }

    // Postcode of address
    if (empty($_POST['postcode'])) {
        $errors[] = 'Please provide a valid postcode.';
    } else {
        $postcode = mysqli_real_escape_string($db, $_POST['postcode']);
    }

    // If there are no errors in the required fields, submit and insert the data into the 'address' table    
    if (empty($errors)) {
        $sqlAddAddress = "INSERT INTO address VALUES ( '$customerID', '$line1', '$line2', '$line3', '$region', '$postcode' )";

        if (mysqli_query($db, $sqlAddAddress)) {
            $errors[] = 'Successfully added the address';
        } else {
            $errors[] = "Failed to add address";
        }
    }

    // Clear the information in the POST address variable
    $_POST['addAddress'] = '';
}

// Add functionality to add a credit card to the users account
if (!empty($_POST['addCard'])) {
    $customerID = $_SESSION['customer_id'];

    // Credit card number
    if (empty($_POST['card_number'])) {
        $errors[] = 'Please provide a valid credit card number.';
    } else if (strlen($_POST['card_number']) != 16) {
        $errors[] = 'Please provide a valid credit card number. It must be 16 digits long';
    } else {
        $card = mysqli_real_escape_string($db, $_POST['card_number']);
    }

    // Expiry of the card
    if (empty($_POST['expiry']) && strlen($_POST['expiry']) != 8) {
        $errors[] = 'Please provide a valid expiry date. It must be 8 digits long';
    } else {
        $expiry = mysqli_real_escape_string($db, $_POST['expiry']);
    }

    // If there are no errors in the required fields, submit and insert the data into the 'credit_card' table    
    if (empty($errors)) {
        $sqlAddCard = "INSERT INTO credit_cards VALUES ( '" . $customerID . "', '" . $card . "', '" . $expiry . "' )";

        if (mysqli_query($db, $sqlAddCard)) {
            $error_message = 'Successfully added the card';
        } else {
            $error_message = "Failed to add card";
        }
    }
    $_POST['addCard'] = '';
}

// Process the payment 
if (!empty($_POST['purchase'])) {
    // Add session variables to variables
    $customerID = $_SESSION['customer_id'];
    $basketID = $_SESSION['basket_id'];

    // Get the current date stamp 
    $time = date('Y-m-d');

    // Parse the data in the selected field 
    if (empty($_POST['card']) || empty($_POST['address'])) {
        $errors[] = 'Im sorry there has been an issue with processing the order';
    } else {
        $card = mysqli_real_escape_string($db, $_POST['card']);
        $address = mysqli_real_escape_string($db, $_POST['address']);
    }

    // If there are no errors in the required fields, submit and insert/remove selected data
    if (empty($errors)) {
        $sqlCart = "SELECT * FROM cart WHERE basket_id = '$basketID'";
        $cartQuery =  mysqli_query($db, $sqlCart);

        while ($row = mysqli_fetch_array($cartQuery)) {
            $sqlPurchase = "INSERT INTO purchases ( basket_id, customer_id, product_id, quantity ) VALUES ( " . $basketID . ", " . $customerID . ", " . $row['product_id'] . ", " . $row['total_price'] . " );";
            $purchaseQuery = mysqli_query($db, $sqlPurchase);
        }

        $sqlName = "SELECT first_name, last_name FROM customers where customer_id = " . $customerID;
        $nameQuery = mysqli_query($db, $sqlName);

        while ($nameArray = mysqli_fetch_array($nameQuery)) {
            $name = $nameArray['first_name'] . ' ' . $nameArray['last_name'];
        }

        $insertCard = substr($selectedCard, 12, 4);

        $sqlOrder = "UPDATE orders SET status = 'waiting for to be accepted', complete = true, time_ordered = " . date('Ymd') . ", address = '" . $address . "', card = '" . $card . "', name = '" . $name . "' WHERE order_id = " . $_SESSION['basket_id'] . " AND customer_id = " . $_SESSION['customer_id'];
        $orderQuery = mysqli_query($db, $sqlOrder);

        $sqlDeleteCart = "DELETE FROM cart WHERE basket_id = " . $basketID;

        $_SESSION['basket_id'] = '';

        if (mysqli_query($db, $sqlDeleteCart)) {
            header("Location: complete.php");
            exit();
        } else {
            $error_message = "Could not complete your order";
        }
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
            // For single errors 
            if (isset($error_message)) {
                echo '<h2 id="message">Error - ' . $error_message . '</h2>';
            }

            // For an array of errors 
            if (count($errors) > 1) {
                foreach ($errors as $error) {
                    echo '<p id="message">' . $error . '</p>';
                }
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
                <h2>Address: </h2>
                <?php
                if (isset($errorAddress)) {
                    echo '<h2>Error - ' . $errorAddress . '</h2>';
                }
                require_once "src/database.php";
                $sqlAddress = "SELECT 1_line, 2_line, 3_line, region, postcode FROM address WHERE customer_id = " . $_SESSION['customer_id'];
                $addressQuery = mysqli_query($db, $sqlAddress);



                if (mysqli_num_rows($addressQuery) > 0) {

                    echo '<select name="address">';
                    while ($row = mysqli_fetch_assoc($addressQuery)) {
                        $string = implode(", ", $row);
                        echo "<option value='$string'>$string</option>";
                    }

                    echo '</select>';
                } else {
                    echo '<p>Please add an address to continue with the purchase</p>';
                }

                ?>

                <button id='addressBtn'>Add a new address</button>

            </div>
            <div id="addressModel"">
                <form action=" purchase.php" method="post" id="addAddress">
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

        <?php
        $customerID = $_SESSION['customer_id'];
        $sqlCard = "SELECT * FROM credit_cards WHERE customer_id = " . $customerID;
        $cardQuery = mysqli_query($db, $sqlCard);
        if (mysqli_num_rows($cardQuery) > 0) {
            echo '<select name="card" form="purchase">';
            while ($row = mysqli_fetch_assoc($cardQuery)) {
                (int)$cardNo = $row['cardnumber'];
                $cardNoFormatted = implode(' ', str_split($cardNo, 4));
                echo $cardNoFormatted;
                $fourDigits = substr($cardNo, 12, 4);

                echo "<option value='" . $fourDigits . "'>Card Number (last 4 digits):  " . $fourDigits . ", Expiry:  " . $row['expiry'] . "</option>";
            }
            echo '</select>';
        } else {
            echo '<p>Please add a credit card to continue with the purchase</p>';
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
            <input type="date" name="expiry" placeholder="Expiry" />
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
            $sqlCart = "SELECT * FROM cart INNER JOIN products on cart.product_id = products.id  WHERE basket_id = " . $basketID;
            $basketQuery = mysqli_query($db, $sqlCart);

            $total = 0;

            while ($row = mysqli_fetch_assoc($basketQuery)) {
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
            if (addressModelDiv.offsetHeight < 1 && addressModelDiv.offsetWidth < 1) {
                addressModelDiv.style.display = 'block';
            } else {
                addressModelDiv.style.display = 'none';
            }
        });

        let cardModelDiv = document.getElementById('cardModel');
        let cardModelBtn = document.getElementById('cardBtn');

        cardModelBtn.onclick = function(event) {
            event.preventDefault();
            if (cardModelDiv.offsetHeight < 1 && cardModelDiv.offsetWidth < 1) {
                cardModelDiv.style.display = 'block';
            } else {
                cardModelDiv.style.display = 'none';
            }
        };
    </script>
</body>

</html>
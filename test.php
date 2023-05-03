<?php
require "src/database.php";

$sql = "SELECT customer_id FROM customers WHERE customer_id = ?";
#no = 2;

$query = $db->prepare( $sql );
$query->bindParam( 1, $no, PDO::PARAM_INT );
$query->execute();

echo $query;
print_r($query);
    if ( !empty( $_POST['form1'])){ 
        echo "Form 1 has been clicked";
    }
    
    if ( !empty( $_POST['form2'])) {
        echo "Form 2 has been clicked";
    } ?>


<form action="test.php" method="post" id="form1">
    <input type="text" name="user">
    <input type="password" name="password">
    <input type="submit" value="submit" name="form1">
</form>

<br />

<form action="test.php" method="post" id="form2">
    <input type="text" name="user">
    <input type="password" name="password">
    <input type="submit" value="submit" name="form2">
</form>
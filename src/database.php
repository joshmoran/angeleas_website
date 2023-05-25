<?php
$websiteName = 'Angelas Website';
$dbname = 'angeladb';
$dbuser = 'angelauser';
$dbpass = 'sMwUK8DgC6mPjuXFscY9zYN3xX743Zs5SRwszAC8NFTWEf8C8E82mfMDiGcWsPYV3oPEsmhdizzpqi8GpwdiJNf326NZ3vGZA4gT';
ini_set("display_errors", "on");



// try {
//     $db = new PDO("sqlite:src/database.db");
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (Exception $e) {
//     echo $e->getMessage();
//     die();
// }

try {
    $db = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);
    //$db = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "connection failed " . $e->getMessage();
    unset($db);
}

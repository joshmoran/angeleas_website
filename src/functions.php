<?php
//session_start();
//require "src/customer.php";
//register_globals=on;

$websiteName = 'Angelas Website';
$itemsPerPage = 5;
global $user;
global $basketID;
global $customerID;


class CustomerAccount
{
	public $id;
	public $order;
	public $loggedIn = false;

	//	function __construct( $id, $order ){
	//      $this->id = $id;
	//       $this->order = $order;
	//		$this->loggedIn = true;
	//}

	function getID()
	{
		return $this->id;
	}

	function getBasket()
	{
		return $this->order;
	}
}

if (!empty($customer)) {
	var_dump($customer->$id);
	var_dump($customer->$order);
}
// require_once "src/database.php";
//checkLoginStatus();

// global $username;
// global $customer_id;

// session_set_cookie_params(['samesite' => 'None']);



function logout_account()
{
	try {
		//session_destroy();
		session_start();
		session_destroy();
		removeCookie('customer_id', '');
		removeCookie('logged_in', false);
		header('Location: index.php');
		return true;
	} catch (Exception $e) {
		return false;
	}
	//header("Location: index.php");
}

function getLengthOfCustomers()
{
	require "src/database.php";

	$accountsLength = $db->query('SELECT LENGTH( customer_id ) FROM accounts');
	foreach ($accountsLength as $items) {
		$customer_id = $items[0];
	}
	return $customer_id;
}

function getLengthOfProducts($filter = null)
{
	require "src/database.php";

	$sql = "SELECT COUNT( id ) FROM products";

	$output = mysqli_query($db, $sql);

	return $output;
}

function checkLoginStatus()
{
	if ($_COOKIE['loggedIn'] == null || empty($_COOKIE['loggedIn'] || $_COOKIE['loggedIn'] == false)) {
		session_start();
		session_destroy();
		//header("Location: login.php");
		sleep(3);
		header("Location: index.php");
		return false;
	} else {

		//header("Location: account.php");
		return true;
	}
}

function getCategories()
{
	require "src/database.php";

	$sql = "SELECT * FROM types";

	$categories = $db->query($sql);

	return $categories;
}

function getProducts($pageNo, $itemsPerPage, $filter = null)
{
	require 'src/database.php';

	$sql = "SELECT id, name, description, category, price, image_src FROM products";
	$noOfPages = $pageNo * $itemsPerPage;
	$limit = ' LIMIT ' . $itemsPerPage . ' OFFSET ' . $noOfPages;

	if ($filter != 0) {
		$sql .= ' WHERE category = ?' . $limit;
		$products = mysqli_prepare($db, $sql);
		$products->bind_param("i", $filter);
	} else {
		$sql = $sql .  $limit;
		$products = $db->prepare($sql);
	}
	$products->execute();

	return $products;
}

// function getBasket($custID = null)
// {
// 	require "src/database.php";

// 	$sql = "SELECT cart.basket_id, cart.product_id, cart.quantity, cart.total_price FROM cart LEFT JOIN orders ON cart.basket_id = orders.basket_id WHERE orders.customer_id = ? ";

// 	$output = $db->prepare($sql);
// 	$output->bindParam(1, $custID, PDO::PARAM_INT);
// 	$output->execute();

// 	return $output;
// }
//
function getNameOfCategory($filter)
{
	require "src/database.php";

	$sql = "SELECT id, name FROM types WHERE name = ?";
	$output = mysqli_prepare($db, $sql);
	$output->bind_param(1, $filter, PDO::PARAM_STR);
	$output->execute();

	return $output;
}

// 			Working
// function addToBasket($item, $quantity, $total)
// {
// 	require "src/database.php";
// 	echo $_SESSION['id'];
// 	//	$customerID = $user->getID();
// 	$basketID = $user->order;

// 	$sql = "INSERT INTO cart (basket_id, product_id, quantity, total_price ) VALUES ( ?, ?, ?, ? );";
// 	$intoBasket = $db->prepare($sql);
// 	$intoBasket->bindParam(1, $basketID, PDO::PARAM_INT);
// 	$intoBasket->bindParam(2, $item, PDO::PARAM_INT);
// 	$intoBasket->bindParam(3, $quantity, PDO::PARAM_INT);
// 	$intoBasket->bindParam(4, $total, PDO::PARAM_INT);
// 	$intoBasket->execute();
// 	var_dump($user);
// 	echo $_SESSION['basket'];
// 	return true;
// }

function generateBasket()
{
	require "src/database.php";

	do {
		$randomNo = rand(100000, 999999);
		$checkNo = $db->query('SELECT product_id FROM cart WHERE product_id = ' . $randomNo);
	} while (empty($checkNo));

	return $randomNo;
}

// function hasBasket($id)
// {
// 	require "src/database.php";

// 	$sql = "SELECT * FROM orders WHERE customer_id = ? && complete = false";
// 	$query = $db->prepare($sql);
// 	$query->bindParam(1, $id, PDO::PARAM_INT);
// 	$query->execute();

// 	return $query;
// }

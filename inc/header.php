<ul id="navParent">
	<li><a href="index.php">Home</a></li>
	<li><a href="products.php">Store</a></li>
	<li><a href="about.php">About</a></li>
	<li><a href="contact.php">Contact</a></li>
	<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
		echo '<li><a href="account.php">My Account</a></li>';
		echo '<li><a href="logout.php">Logout</a></li>';
	} else {
		echo '<li><a href="login.php">Login</a></li>';
	} ?>
	<li><a href="basket.php">Basket</a></li>
</ul>
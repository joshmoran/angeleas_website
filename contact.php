<?php
session_start();
require "src/variables.php";

if (!empty($_POST['email'])) {
	try {
		$to = 'josh@lovingfamily.co.uk';
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		echo $subject . ' ' . $message;
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;" . "charset=iso-8859-1" . "\r\n";

		// More headers
		$headers .= 'From: <webmaster@lovingfamily.co.uk>' . "\r\n";
		$headers .= 'Cc: myboss@example.com' . "\r\n";

		mail($to, $subject, $message, $headers);
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}
// to, subject, message, header, parameters

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="Please fill out the form to submit a message to out team. We will be back in touch within 72 hours">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $websiteName;
			?> - Contact</title>
	<link href="src/css/css.css" rel="stylesheet" type="text/css" />
	<link href="src/css/contact.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php include("inc/header.php"); ?>
	<div id="container">
		<div id="errors">
			<?php
			if (isset($error_message)) {
				echo "<h3 id='error_message'>" . $error_message . "</h3>";
			}
			?>
		</div>
		<form action="contact.php" id="email" method="post">
			<h2>Contact Us</h1>
				<p>Please contact us for any quieries, issues or questions that you want answered.</p>
				<p>Please allow for 72 hours for a response</p>

				<label for="name">Your Name: </label>
				<input type="text" name="name" id="name" placeholder="John Smith">

				<label for="subject">Subject: </label>
				<input type="text" name="subject" id="subject" placeholder="Reason for contacting">

				<label for="message">Message: </label>
				<textarea name="message" id="message" cols="40" rows="8">Write Something</textarea>

				<input type="hidden" value="'<?php echo if(isset($_SESSION['loggedIn'])){echo $_SESSION['customer_id']; } ?>" ?>

				<input type="submit" name="email" value="Submit">
		</form>
	</div>

	<?php include("inc/footer.php"); ?>
	<script src="src/css/css.css"></script>
</body>

</html>
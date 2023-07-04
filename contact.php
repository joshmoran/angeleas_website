<?php
session_start();
require "src/variables.php";

if (isset($_POST['email'])) {
	$to = 'josh@lovingfamily.co.uk';
	$errors = 0;
	if (!empty($_POST['subject'])) {
		$subject = $_POST['subject'];
	} else {
		$errors++;
		$errorSubject = "Subject is required";
	}

	if (empty($_POST['name'])) {
		$errors++;
		$errorName = "Name is required";
	}

	if (!empty($_POST['message'])) {
		$message = "Name: " . $_POST['name'] . "<br>Customer Number: ";
		if (isset($_SESSION['customer_id '])) {
			$message .= $_SESSION['customer_id'];
		} else {
			$message .= ' guest';
		}
		$message .= "<br>Message: " . $_POST['message'];
		// Always set content-type when sending HTML email
	} else {
		$errorMessage = 'A message is required.';
	}
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;" . "charset=iso-8859-1" . "\r\n";

	// More headers
	$headers .= 'From: <webmaster@lovingfamily.co.uk>' . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	if ($errors == 0) {
		if (mail($to, $subject, $message, $headers)) {
			$error_message = 'Message sent successfully.';
		} else {
			$error_message = 'There has been an internal issue. Please contact the system administrator.';
		}
	} else {
		$error_message = 'Please correct the errors below to submit the message.';
	}
	$_POST['email'] = null;
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
		<div id="messages">
			<?php
			if (isset($error_message)) {
				echo '<p class="message">' . $error_message . '</p>';
			}
			?>
		</div>
		<form action="contact.php" id="email" method="post">
			<tr>
				<th colspan="3">
					<h2>Contact Us</h2>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<p>Please contact us for any queries, issues or questions that you want answered.</p>
				</th>
			</tr>

			<tr>
				<th colspan="3">
					<p>Please allow for 72 hours for a response</p>
				</th>
			</tr>
			<tr>
				<td><label for="name">Your Name: </label></td>
				<td><input type="text" name="name" id="name" placeholder="John Smith"></td>
				<td>
					<p><?php if (isset($errorName)) echo $errorName; ?></p>
				</td>
			</tr>
			<tr>
				<td><label for="subject">Subject: </label></td>
				<td><input type="text" name="subject" id="subject" placeholder="Reason for contacting"></td>
				<td>
					<p class="error"><?php if (isset($errorSubject)) echo $errorSubject; ?></p>
				</td>
			</tr>
			<tr>
				<td><label for="message">Message: </label></td>
				<td><textarea name="message" id="message" cols="40" rows="8">Write Something</textarea></td>
				<td>
					<p class="error"><?php if (isset($errorMessage)) {
											echo $errorMessage;
										} ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="3"><input type="hidden" name="customerid" value="'<?php if (isset($_SESSION['loggedIn'])) {
																					echo $_SESSION['customer_id'];
																				} ?>" ?></td>
			</tr>

			<tr>
				<td colspan="3"><input type="submit" name="email" value="Submit"></td>
			</tr>
		</form>
	</div>

	<?php include("inc/footer.php"); ?>
	<script src="src/css/css.css"></script>
</body>

</html>
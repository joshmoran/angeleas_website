
			var data = <?php echo json_encode($_POST['firstname'] ?? null) ?>;

			alert(data);

			window.addEventListener('load', () => {

				// Customer Details

				// First Name
				document.querySelector('input[name=firstname]').value = <?php echo json_encode($_POST['firstname'] ?? null) ?>;
				// Last Name
				document.querySelector('input[name=lastname]').value = <?php echo json_encode($_POST['lastname'] ?? null) ?>;
				// Email
				document.querySelector('input[name=email]').value = <?php echo json_encode($_POST['email'] ?? null) ?>;
				// Phone Home
				document.querySelector('input[name=phoneHome]').value = <?php echo json_encode($_POST['phoneHome'] ?? null) ?>;
				// Mobile Name
				document.querySelector('input[name=phoneMobile]').value = <?php echo json_encode($_POST['phoneMobile'] ?? null) ?>;

				// Address

				// Address Line 1
				document.querySelector('input[name=line1]').value = <?php echo json_encode($_POST['line1'] ?? null) ?>;
				// Address Line 2
				document.querySelector('input[name=line2]').value = <?php echo json_encode($_POST['line2'] ?? null) ?>;
				// Address Line 3
				document.querySelector('input[name=line3]').value = <?php echo json_encode($_POST['line3'] ?? null) ?>;
				// Region
				document.querySelector('input[name=region]').value = <?php echo json_encode($_POST['region'] ?? null) ?>;
				// Postcode
				document.querySelector('input[name=postcode]').value = <?php echo json_encode($_POST['postcode'] ?? null) ?>;

				// account

				// Username
				document.querySelector('input[name=username]').value = <?php echo json_encode($_POST['username'] ?? null) ?>;
				// Password
				document.querySelector('input[name=password]').value = <?php echo json_encode($_POST['password'] ?? null) ?>;
			});
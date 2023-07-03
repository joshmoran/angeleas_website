window.addEventListener( 'load',() => {

	// Customer Details

	// First Name
	document.querySelector( 'input[name=firstname]' ).value = <? php echo json_encode( $_POST[ 'firstname' ] ?? null ) ?>
		// Last Name
		document.querySelector( 'input[name=lastname]' ).value = <? php echo json_encode( $_POST[ 'lastname' ] ?? null ) ?>
			// Email
			document.querySelector( 'input[name=email]' ).value = <? php echo json_encode( $_POST[ 'email' ] ?? null ) ?>
				// Phone Home
				document.querySelector( 'input[name=phoneHome]' ).value = <? php echo json_encode( $_POST[ 'phoneHome' ] ?? null ) ?>
					// Mobile Name
					document.querySelector( 'input[name=phoneMobile]' ).value = <? php echo json_encode( $_POST[ 'phoneMobile' ] ?? null ) ?>

						// Address
						// account

						// Username
						document.querySelector( 'input[name=username]' ).value = <? php echo json_encode( $_POST[ 'username' ] ?? null ) ?>
							// Password
							document.querySelector( 'input[name=password]' ).value = <? php echo json_encode( $_POST[ 'password' ] ?? null ) ?>
} )
<!DOCTYPE html>
<html>
	<body>
		
		<script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
		<form method="POST" action="" id="my-form">
			<input type="text"/>
			<input type="submit" name="submit" />
		</form>
		<script>
			$(document).ready(function() {
			$(document).on('submit', '#my-form', function() {
				sendContactForm();
			return false;
			});
			});
		</script>

		<?php 
				if(isset($_POST['submit'])){
					echo "heldddddddddddddddddddddddddlo";
				}
		?>
	</body>
</html>
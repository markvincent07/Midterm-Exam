<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - Computer Science Tutoring</title>
	<style>
		body {
			font-family: "Arial", sans-serif;
			background-color: #f4f6f8;
			margin: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}
		.container {
			background-color: #ffffff;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			width: 450px;
			padding: 2rem;
			text-align: center;
		}
		h1 {
			color: #333;
			margin-bottom: 1rem;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		label {
			font-weight: bold;
			margin: 0.5rem 0 0.2rem;
		}
		input[type="text"], input[type="password"] {
			font-size: 1em;
			padding: 0.8em;
			width: 100%;
			margin-bottom: 1rem;
			border: 1px solid #ddd;
			border-radius: 5px;
		}
		input[type="submit"] {
			font-size: 1em;
			padding: 0.8em;
			background-color: #4CAF50;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			width: 100%;
		}
		input[type="submit"]:hover {
			background-color: #45a049;
		}
		.message {
			color: red;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php  
		if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
			echo "<p class='message' style='color: " . ($_SESSION['status'] == "200" ? "green" : "red") . ";'>{$_SESSION['message']}</p>";
			unset($_SESSION['message']);
			unset($_SESSION['status']);
		}
		?>
		<h1>Register Here</h1>
		<form action="core/handleForms.php" method="POST">
			<label for="username">Username</label>
			<input type="text" name="username" required>

			<label for="first_name">First Name</label>
			<input type="text" name="first_name" required>

			<label for="last_name">Last Name</label>
			<input type="text" name="last_name" required>

			<label for="password">Password</label>
			<input type="password" name="password" required>

			<label for="confirm_password">Confirm Password</label>
			<input type="password" name="confirm_password" required>

			<input type="submit" name="insertNewUserBtn" value="Register">
		</form>
	</div>
</body>
</html>

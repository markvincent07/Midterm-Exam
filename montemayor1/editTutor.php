<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Computer Science Online Tutoring Platform</title>
	<style>
		body {
			font-family: "Arial", sans-serif;
			background-color: #f4f4f9;
			color: #333;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}

		.container {
			width: 80%;
			max-width: 600px;
			background-color: #ffffff;
			border: 1px solid #ddd;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
			text-align: center; 
		}

		.container h1 {
			margin-top: 0;
			margin-bottom: 20px;
		}

		.container p {
			margin: 10px 0;
			text-align: left; 
		}

		.container label {
			font-weight: bold;
			display: block;
			margin-bottom: 5px;
		}

		.container input, .container select {
			font-size: 1.2em;
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			margin-bottom: 15px;
		}

		.container input[type="submit"] {
			background-color: #3498db;
			color: white;
			border: none;
			cursor: pointer;
			font-size: 1.2em;
			padding: 12px;
			border-radius: 5px;
			transition: background-color 0.3s;
			width: 100%; /* Stretch button width */
		}

		.container input[type="submit"]:hover {
			background-color: #2980b9;
		}

		.container a {
			color: #3498db;
			text-decoration: none;
			font-size: 1.2em;
			display: block;
			margin-bottom: 20px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Edit Information</h1>
		<?php $getTutorByID = getTutorByID($pdo, $_GET['tutor_id']); ?>
		<form action="core/handleForms.php?tutor_id=<?php echo $_GET['tutor_id']; ?>" method="POST">
			<a href="index.php?tutor_id=<?php echo $_GET['tutor_id']; ?>">Return to Home</a>
			<p>
				<label for="firstName">First Name</label> 
				<input type="text" name="firstName" value="<?php echo $getTutorByID['first_name']; ?>" required>
			</p>
			<p>
				<label for="lastName">Last Name</label> 
				<input type="text" name="lastName" value="<?php echo $getTutorByID['last_name']; ?>" required>
			</p>
			<p>
				<label for="email">Email</label>
				<input type="email" name="email" value="<?php echo $getTutorByID['email']; ?>" required>
			</p>
			<p>
			<label for="specialization">Specialization</label> 
			<select name="specialization" id="specialization">
				<option value="Computer Networks and Security">Computer Networks and Security</option>
				<option value="Data Analysis">Data Analysis</option>
				<option value="Discrete Structures">Discrete Structures</option>
				<option value="Human Computer Interaction">Human Computer Interaction</option>
				<option value="Multimedia Development">Multimedia Development</option>
				<option value="Networks and Communications">Networks and Communications</option>
				<option value="Professional Elective">Professional Elective</option>
				<option value="Software Engineering">Software Engineering</option>
				<option value="Social Issues and Professional Practice">Social Issues and Professional Practice</option>
				<option value="Automata Theory and Formal Languages">Automata Theory and Formal Languages</option>
				<option value="Data and Digital Communications">Data and Digital Communications</option>
				<option value="Modeling and Simulation">Modeling and Simulation</option>
				<option value="Information Assurance and Security">Information Assurance and Security</option>
				<option value="Operating Systems">Operating Systems</option>
				<option value="Object-Oriented Programming">Object-Oriented Programming</option>
				<option value="Data Structures and Algorithms">Data Structures and Algorithms</option>
				<option value="Programming Languages">Programming Languages</option>
				value="<?php echo $getTutorByID['email']; ?>">
			</select>
		</p>
			<p>
				<label for="dateAdded">Date Added</label>
				<input type="datetime-local" name="dateAdded" value="<?php echo $getTutorByID['date_added']; ?>" required>
			</p>
			<input type="submit" name="editTutorBtn" value="Save Changes">
		</form>
	</div>
</body>
</html>

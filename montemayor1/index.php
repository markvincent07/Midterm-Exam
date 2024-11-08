<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Computer Science Online Tutoring Platform</title>
	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}
		body {
			font-family: "Arial", sans-serif;
			background-color: #f4f6f8;
			color: #333;
			padding: 20px;
		}
		.container {
			max-width: 1200px;
			margin: auto;
			padding: 2rem;
			background-color: #ffffff;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			position: relative;
		}
		h1, h2, h3 {
			text-align: center;
			color: #4CAF50;
		}
		.greeting h2 {
			margin-bottom: 0;
		}
		.greeting .username {
			color: #2b8cbe;
			font-weight: bold;
		}
		.logout-button {
			position: absolute;
			top: 20px;
			right: 20px;
			background-color: #ff4c4c;
			color: white;
			border: none;
			border-radius: 5px;
			padding: 0.5rem 1rem;
			cursor: pointer;
			text-decoration: none;
			font-weight: bold;
		}
		.logout-button:hover {
			background-color: #ff3333;
		}
		.message {
			color: red;
			text-align: center;
			margin-bottom: 1rem;
			font-weight: bold;
		}
		form {
			margin: 2rem 0;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		form p {
			margin: 0.5rem 0;
			width: 100%;
			max-width: 500px;
		}
		label {
			display: block;
			margin-bottom: 0.3rem;
			font-weight: bold;
		}
		input[type="text"], input[type="email"], input[type="datetime-local"], select {
			width: 100%;
			padding: 0.8rem;
			border: 1px solid #ddd;
			border-radius: 5px;
			font-size: 1em;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			border: none;
			border-radius: 5px;
			padding: 0.8rem 2rem;
			cursor: pointer;
			font-size: 1em;
			margin-top: 1rem;
		}
		input[type="submit"]:hover {
			background-color: #45a049;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 2rem;
			font-size: 0.9em;
		}
		th, td {
			padding: 0.8rem;
			border: 1px solid #ddd;
			text-align: left;
		}
		th {
			background-color: #4CAF50;
			color: white;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		.action-links a {
			margin-right: 10px;
			color: #4CAF50;
			text-decoration: none;
			font-weight: bold;
		}
		.action-links a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>

<div class="container">
	<?php if (isset($_SESSION['message'])) { ?>
		<p class="message"><?php echo $_SESSION['message']; ?></p>
	<?php unset($_SESSION['message']); } ?>

	<h2>Computer Science Online Tutoring Platform </h2>

	<div class="greeting">
		<h2><br>Welcome, <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h2>
		<a href="core/handleForms.php?logoutUserBtn=1" class="logout-button">Logout</a>
	</div>

	<h2><br>Register a new tutor below.</h2>
	<form action="core/handleForms.php" method="POST">
		<p><label for="firstName">First Name</label> <input type="text" name="firstName" required></p>
		<p><label for="lastName">Last Name</label> <input type="text" name="lastName" required></p>
		<p><label for="email">Email</label> <input type="email" name="email" style="width: 100%;" required></p>
		<p>
			<label for="specialization">Specialization</label> 
			<select name="specialization" id="specialization" required>
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
			</select>
		</p>
		<p><label for="dateAdded">Date Added</label> <input type="datetime-local" name="dateAdded" required></p>
		<input type="submit" name="insertTutorBtn" value="Add Tutor">
	</form>

	<table>
	  <tr>
	    <th>Tutor ID</th>
	    <th>First Name</th>
	    <th>Last Name</th>
		<th>Email</th>
	    <th>Specialization</th>
		<th>Date Added</th>
		<th>Added By</th>
		<th>Updated By</th>
		<th>Last Updated</th>
		<th>Action</th>
	  </tr>

	  <?php $seeAllTutor = seeAllTutor($pdo); ?>
	  <?php foreach ($seeAllTutor as $row) { ?>
	  <tr>
	  	<td><?php echo htmlspecialchars($row['tutor_id']); ?></td>
	  	<td><?php echo htmlspecialchars($row['first_name']); ?></td>
	  	<td><?php echo htmlspecialchars($row['last_name']); ?></td>
		<td><?php echo htmlspecialchars($row['email']); ?></td>
	  	<td><?php echo htmlspecialchars($row['specialization']); ?></td>
	  	<td><?php echo htmlspecialchars($row['date_added']); ?></td>
		<td><?php echo htmlspecialchars($row['added_by']); ?></td>
		<td><?php echo htmlspecialchars($row['updated_by']); ?></td>
		<td><?php echo $row['last_updated']; ?></td>


	  	<td class="action-links">
	  		<a href="editTutor.php?tutor_id=<?php echo $row['tutor_id'];?>">Edit</a>
	  		<a href="deleteTutor.php?tutor_id=<?php echo $row['tutor_id'];?>">Delete</a>
			<a href="studentsOverview.php?tutor_id=<?php echo $row['tutor_id'];?>">Students Overview</a>
	  	</td>
	  </tr>
	  <?php } ?>
	</table>
</div>

</body>
</html>

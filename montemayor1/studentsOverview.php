<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

$tutorId = $_GET['tutor_id'];
$getInfoByTutorID = getInfoByTutorID($pdo, $tutorId);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student Overview - Computer Science Online Tutoring Platform</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			color: #333;
			margin: 0;
			padding: 20px;
			background-color: #f4f4f9;
		}

		.container {
			width: 100%;
			max-width: 1200px;
			margin: 0 auto;
		}

		h1, h2 {
			text-align: center;
			color: #333;
		}

		a {
			text-decoration: none;
			color: #3498db;
		}

		.return-link {
			display: inline-block;
			margin-bottom: 20px;
			font-weight: bold;
		}

		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
			margin-bottom: 30px;
		}

		label {
			display: block;
			font-weight: bold;
			margin-bottom: 8px;
		}

		input, select {
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 1em;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			cursor: pointer;
			font-size: 1.1em;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th, td {
			border: 1px solid #ddd;
			padding: 12px;
			text-align: center;
		}

		th {
			background-color: #3498db;
			color: white;
		}

		tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		tr:hover {
			background-color: #f1f1f1;
		}

		.action-buttons a {
		display: inline-block;
		margin: 2px 5px;
		padding: 6px 12px;
		color: #fff;
		text-decoration: none;
		border-radius: 4px;
		font-size: 0.9em;
		}

		.action-buttons a.edit {
			background-color: #4CAF50; 
		}

		.action-buttons a.delete {
			background-color: #e74c3c; 
		}

		.action-buttons a:hover {
			opacity: 0.8;
		}

	</style>
</head>
<body>

<div class="container">
	<a href="index.php" class="return-link">Return to Home</a>



	<form action="core/handleForms.php?tutor_id=<?php echo $tutorId; ?>" method="POST">
		<h2>Add New Student</h2>
		<label for="firstName">First Name</label>
		<input type="text" name="firstName" required>

		<label for="lastName">Last Name</label>
		<input type="text" name="lastName" required>

		<label for="email">Email</label>
		<input type="email" name="email" required>

		<label for="preferredSubject">Preferred Subject</label>
		<select name="preferredSubject" id="preferredSubject" required>
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

		<label for="dateAdded">Date Added</label>
		<input type="datetime-local" name="dateAdded" required>

		<input type="submit" name="insertStudentBtn" value="Add Student">
	</form>

	<!-- Students Table -->
	<table>
	  <tr>
	    <th>Student ID</th>
	    <th>First Name</th>
	    <th>Last Name</th>
	    <th>Email</th>
	    <th>Preferred Subject</th>
	    <th>Tutor</th>
	    <th>Date Added</th>
	    <th>Added By</th>
	    <th>Updated By</th>
	    <th>Last Updated</th>
	    <th>Action</th>
	  </tr>

	  <?php 
	  $getStudentsByTutor = getStudentsByTutor($pdo, $tutorId); 
	  foreach ($getStudentsByTutor as $row) { 

	  ?>
	  <tr id="student-<?php echo $row['student_id']; ?>" class="<?php echo $isNewStudent ? 'new-student' : ''; ?>">
	    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
	    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
	    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
	    <td><?php echo htmlspecialchars($row['email']); ?></td>
	    <td><?php echo htmlspecialchars($row['preferred_subject']); ?></td>
	    <td><?php echo htmlspecialchars($row['tutor_name']); ?></td>
	    <td><?php echo htmlspecialchars($row['date_added']); ?></td>
	    <td><?php echo htmlspecialchars($row['added_by']); ?></td>
	    <td><?php echo htmlspecialchars($row['updated_by']); ?></td>
	    <td><?php echo htmlspecialchars($row['last_updated']); ?></td>

	    <td class="action-buttons">
			<a href="editStudent.php?student_id=<?php echo $row['student_id']; ?>&tutor_id=<?php echo $_GET['tutor_id']; ?>" class="edit">Edit</a>
			<a href="deleteStudent.php?student_id=<?php echo $row['student_id']; ?>&tutor_id=<?php echo $_GET['tutor_id']; ?>" class="delete">Delete</a>
		</td>
	  </tr>
	  <?php } ?>
	</table>
</div>


</body>
</html>

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
			font-size: 1.2em;
			text-align: center;
			margin: 20px;
		}

		.container {
			display: inline-block;
			padding: 20px;
			border: 1px solid #ccc;
			margin-top: 20px;
			width: 80%;
			max-width: 600px;
			background-color: #f9f9f9;
		}

		.container p {
			margin: 10px 0;
		}

		/* Button styling */
		input[type="submit"] {
			background-color: #e74c3c;
			color: white;
			padding: 12px 24px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-size: 1em;
			transition: background-color 0.3s ease;
		}

		input[type="submit"]:hover {
			background-color: #c0392b;
		}
	</style>
</head>
<body>
	<h1>Are you sure you want to delete this tutor?</h1>
	<?php $getTutorByID = getTutorByID($pdo, $_GET['tutor_id']); ?>
	<form action="core/handleForms.php?tutor_id=<?php echo $_GET['tutor_id']; ?>" method="POST">
		<div class="container">
			<p><strong>First Name:</strong> <?php echo htmlspecialchars($getTutorByID['first_name']); ?></p>
			<p><strong>Last Name:</strong> <?php echo htmlspecialchars($getTutorByID['last_name']); ?></p>
			<p><strong>Email:</strong> <?php echo htmlspecialchars($getTutorByID['email']); ?></p>
			<p><strong>Specialization:</strong> <?php echo htmlspecialchars($getTutorByID['specialization']); ?></p>
			<p><strong>Date Added:</strong> <?php echo htmlspecialchars($getTutorByID['date_added']); ?></p>
			<input type="submit" name="deleteTutorBtn" value="Delete">
		</div>
	</form>
</body>
</html>

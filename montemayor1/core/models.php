<!-- Functions for interacting with the database -->

<?php 

require_once 'dbConfig.php';

date_default_timezone_set('Asia/Manila'); 

function insertIntoTutor($pdo,$first_name, $last_name, $email, $specialization, $date_added, $added_by) {

	$sql = "INSERT INTO tutor_records (first_name,last_name,email,specialization,date_added,added_by) VALUES (?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);

	$executeQuery = $stmt->execute([$first_name, $last_name,
		$email, $specialization, $date_added, $added_by]);

	if ($executeQuery) {
		return true;	
	}
}

function seeAllTutor($pdo) {
	$sql = "SELECT * FROM tutor_records";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserFullName($pdo, $username) {
    $sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    return $stmt->fetchColumn();
}

function getTutorByID($pdo, $tutor_id) {
	$sql = "SELECT * FROM tutor_records WHERE tutor_id = ?";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute([$tutor_id])) {
		return $stmt->fetch();
	}
}


function updateTutor($pdo, $tutor_id, $first_name, $last_name, $email, $specialization, $date_added, $updated_by, $last_updated) {
	$sql = "UPDATE tutor_records 
				SET first_name = ?, 
					last_name = ?, 
					email = ?, 
					specialization = ?, 
					date_added = ?, 
					updated_by = ?, 
					last_updated = ?
			WHERE tutor_id = ?
			";
	$stmt = $pdo->prepare($sql);

	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $specialization, $date_added, $updated_by, $last_updated, $tutor_id]);

	if ($executeQuery) {
		return true;
	}
	return false;
}



function deleteTutor($pdo, $tutor_id) {

	$sql = "DELETE FROM tutor_records WHERE tutor_id = ?";
	$stmt = $pdo->prepare($sql);

	$executeQuery = $stmt->execute([$tutor_id]);

	if ($executeQuery) {
		return true;
	}

}

function insertIntoStudent($pdo, $first_name, $last_name, $email, $preferred_subject, $date_added, $tutor_id, $added_by) {
    $sql = "INSERT INTO student_records (first_name, last_name, email, preferred_subject, date_added, tutor_id, added_by) 
            VALUES (?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $email, $preferred_subject, $date_added, $tutor_id, $added_by]);

    if ($executeQuery) {
        return true;    
    }
}


function getInfoByTutorID($pdo, $tutor_id) {
	$sql = "SELECT * FROM tutor_records WHERE tutor_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$tutor_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}



function getStudentsByTutor($pdo, $tutor_id) {
	
	$sql = "SELECT 
				student_records.student_id,
				student_records.first_name,
				student_records.last_name,
				student_records.email,
				student_records.preferred_subject,
				student_records.date_added,
				student_records.added_by,        
            	student_records.updated_by,      
            	student_records.last_updated,    
				CONCAT(tutor_records.first_name,' ',tutor_records.last_name) AS tutor_name
			FROM student_records
			JOIN tutor_records ON student_records.tutor_id = tutor_records.tutor_id
			WHERE student_records.tutor_id = ? 
			
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$tutor_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getStudentByID($pdo, $student_id) {
	$sql = "SELECT 
				student_records.student_id as student_id,
				student_records.first_name as first_name,
				student_records.last_name as last_name,
				student_records.email as email,
				student_records.preferred_subject as preferred_subject,
				student_records.date_added as date_added,
				CONCAT(tutor_records.first_name,' ',tutor_records.last_name) AS student_tutor
			FROM student_records
			JOIN tutor_records ON student_records.tutor_id = tutor_records.tutor_id
			WHERE student_records.student_id  = ?
			";
			
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$student_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateStudent($pdo, $first_name, $last_name, $email, $preferred_subject, $date_added, $student_id, $updated_by, $last_updated) {
    $sql = "UPDATE student_records 
            SET first_name = ?, 
                last_name = ?, 
                email = ?, 
                preferred_subject = ?, 
                date_added = ?, 
                updated_by = ?, 
                last_updated = ? 
            WHERE student_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $email, $preferred_subject, $date_added, $updated_by, $last_updated, $student_id]);

    if ($executeQuery) {
        return true;
    }
    return false;
}



function deleteStudent($pdo, $student_id) {
	$sql = "DELETE FROM student_records WHERE student_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$student_id]);
	if ($executeQuery) {
		return true;
	}
}

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occurred with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}



?>
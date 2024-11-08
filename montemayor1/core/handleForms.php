<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';  

date_default_timezone_set('Asia/Manila'); 

if (isset($_POST['insertTutorBtn'])) {
	$firstName = trim($_POST['firstName']);
	$lastName = trim($_POST['lastName']);
	$email = trim($_POST['email']);
	$specialization = trim($_POST['specialization']);
	$dateAdded = trim($_POST['dateAdded']);
	$username = $_SESSION['username'];
    

    $addedBy = getUserFullName($pdo, $username);

	if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($specialization) && !empty($dateAdded)) {
			$query = insertIntoTutor($pdo, $firstName, $lastName, 
			$email, $specialization, $dateAdded, $addedBy);

		if ($query) {
			header("Location: ../index.php");
		}

		else {
			echo "Insertion failed";
		}
	}

	else {
		echo "Make sure that no fields are empty";
	}
	
}


if (isset($_POST['editTutorBtn'])) {
	$tutor_id = $_GET['tutor_id'];
	$firstName = trim($_POST['firstName']);
	$lastName = trim($_POST['lastName']);
	$email = trim($_POST['email']);
	$specialization = trim($_POST['specialization']);
	$dateAdded = trim($_POST['dateAdded']);
	$username = $_SESSION['username'];

	// Retrieve the current user's full name
	$updatedBy = getUserFullName($pdo, $username);
	// Get the current timestamp for 'last updated'
	$lastUpdated = date("Y-m-d H:i:s");

	if (!empty($tutor_id) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($specialization) && !empty($dateAdded)) {
		$query = updateTutor($pdo, $tutor_id, $firstName, $lastName, $email, $specialization, $dateAdded, $updatedBy, $lastUpdated);

		if ($query) {
			header("Location: ../index.php");
		} else {
			echo "Update failed";
		}
	} else {
		echo "Make sure that no fields are empty";
	}
}


if (isset($_POST['deleteTutorBtn'])) {

	$query = deleteTutor($pdo, $_GET['tutor_id']);

	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Deletion failed";
	}
}

if (isset($_POST['insertStudentBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $preferredSubject = trim($_POST['preferredSubject']);
    $dateAdded = trim($_POST['dateAdded']);
    $username = $_SESSION['username'];

    $addedBy = getUserFullName($pdo, $username);

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($preferredSubject) && !empty($dateAdded)) {
        $query = insertIntoStudent($pdo, $firstName, $lastName, $email, $preferredSubject, $dateAdded, $_GET['tutor_id'], $addedBy);

        if ($query) {
            header("Location: ../studentsOverview.php?tutor_id=" . $_GET['tutor_id']);
        } else {
            echo "Insertion failed";
        }
    } else {
        echo "Make sure that no fields are empty";
    }
}


if (isset($_POST['editStudentBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $preferredSubject = trim($_POST['preferredSubject']);
    $dateAdded = trim($_POST['dateAdded']);
    $username = $_SESSION['username'];

    $updatedBy = getUserFullName($pdo, $username);
    $lastUpdated = date("Y-m-d H:i:s");

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($preferredSubject) && !empty($dateAdded)) {
        $query = updateStudent($pdo, $firstName, $lastName, $email, $preferredSubject, $dateAdded, $_GET['student_id'], $updatedBy, $lastUpdated);

        if ($query) {
            header("Location: ../studentsOverview.php?tutor_id=" . $_GET['tutor_id']);
        } else {
            echo "Update failed";
        }
    } else {
        echo "Make sure that no fields are empty";
    }
}




if (isset($_POST['deleteStudentBtn'])) {

	$query = deleteStudent($pdo, $_GET['student_id']);

	if ($query) {
		header("Location: ../studentsOverview.php?tutor_id=" . $_GET['tutor_id']);
	}
	else {
		echo "Deletion failed";
	}
}

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = "400";
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);

		if ($loginQuery['status'] == '200') {
			$usernameFromDB = $loginQuery['userInfoArray']['username'];
			$passwordFromDB = $loginQuery['userInfoArray']['password'];

			if (password_verify($password, $passwordFromDB)) {
				$_SESSION['username'] = $usernameFromDB;
				header("Location: ../index.php");
			}
		}

		else {
			$_SESSION['message'] = $loginQuery['message'];
			$_SESSION['status'] = $loginQuery['status'];
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure no input fields are empty";
		$_SESSION['status'] = "400";
		header("Location: ../login.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}

?>
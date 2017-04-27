<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/access.inc.php';

if (!userIsLoggedIn()) {
	include '../login.html.php';
	exit();
}

if (!userIsAdmin()) {
	$error = 'Only the Administrator may access this page.';
	include '../accessdenied.html.php';
	exit();
}
if (isset($_GET['add'])) {
	$pagetitle = 'New User';
	$action = 'addform';
	$firstname = '';
	$lastname = '';
	$username = '';
	$email = '';
	$password = '';
	$id = '';
	$button = 'Add user';

	include 'form.html.php';
	exit();
}
if (isset($_GET['addform'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/info/include/salt.inc.php';

	$firstname = mysqli_real_escape_string($link, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($link, $_POST['lastname']);
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	
	$sql = "INSERT INTO user SET
		   firstname='$firstname',
		   lastname='$lastname',
		   username='$username',
		   email='$email',
		   password=md5('{$password}" . SALT . "');";
	if (!mysqli_query($link, $sql)) {
		$err = 'Error adding submitted user.';
		include $_SERVER['DOCUMENT_ROOT'] . 				'/logininfo/include/errmsg.html.php';
		exit();
	}

	header('Location: .');
	exit();
}
if (isset($_POST['action']) and $_POST['action'] == 'Edit') {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';

	$username = mysqli_real_escape_string($link, $_POST['username']);
	$sql = "SELECT firstname, lastname, email FROM user WHERE username='$username'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$err = 'Error fetching user details.';
		include $_SERVER['DOCUMENT_ROOT'] . 				'/logininfo/include/errmsg.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	$pagetitle = 'Edit User';
	$action = 'editform';
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$password = '';
	$button = 'Update user';

	include 'form.html.php';
	exit();
}
if (isset($_GET['editform'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/salt.inc.php';

	$username = mysqli_real_escape_string($link, $_POST['username']);
	$firstname = mysqli_real_escape_string($link, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($link, $_POST['lastname']);
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	if ($_POST['password']) { 
		$password = "password=md5('" . 
		      mysqli_real_escape_string($link, $_POST['password']) . SALT . "'),";
	}
	$sql = "UPDATE user SET
		   firstname='$firstname',
		   lastname='$lastname',
		   $password
		   email='$email'
		   WHERE username='$username'";
	if (!mysqli_query($link, $sql)) {
		$err = 'Error updating submitted user.' . mysqli_error($link);
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	header('Location: .');
	exit();
}
if (isset($_POST['action']) and $_POST['action'] == 'Delete') {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
	$username = mysqli_real_escape_string($link, $_POST['username']);

	// Inactivate the user
	$sql = "UPDATE user SET
		    active='0'
		    WHERE username='$username'";
	if (!mysqli_query($link, $sql)) {
		$err = 'Error deleting user.';
		include $_SERVER['DOCUMENT_ROOT'] . 				'/logininfo/include/errmsg.html.php';
		exit();
	}

	header('Location: .');
	exit();
}
// Display user list
include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
$result = mysqli_query($link, "SELECT username, firstname, lastname, email, admin FROM user WHERE active='1'");
if (!$result) {
	$err = 'Error fetching user list from database!';
	include $_SERVER['DOCUMENT_ROOT'] . 	'/logininfo/include/errmsg.html.php';
	exit();
}

while ($row = mysqli_fetch_assoc($result)) {
	$users[] = array('lastname' => $row['lastname'], 'firstname' => $row['firstname'], 
					      'username' => $row['username'], 'email' => $row['email'], 'admin' => $row['admin']);
}

include 'userlist.html.php';
?>
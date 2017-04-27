<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/salt.inc.php';
// needs to be change on different servers
function userIsLoggedIn() {
	if (isset($_POST['action']) and $_POST['action'] == 'login') {
		if (!isset($_POST['username']) or $_POST['username'] == '' or
			!isset($_POST['password']) or $_POST['password'] == '') {
			$GLOBALS['loginError'] = 'Please fill in both fields';
			return FALSE;
		}

		$password = md5($_POST['password'] . SALT);

		if (databaseContainsUser($_POST['username'], $password)) {
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $password;
			return TRUE;
		} else {
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			$GLOBALS['loginError'] = 'The specified username or password was incorrect.';
			return FALSE;
		}
	}

	if (isset($_POST['action']) and $_POST['action'] == 'logout') {
		session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		header('Location: ' . $_POST['goto']);
		exit();
	}

	session_start();
	if (isset($_SESSION['loggedIn'])) {
		return databaseContainsUser($_SESSION['username'], $_SESSION['password']);
	}
}
function databaseContainsUser($username, $password) {
	include $_SERVER['DOCUMENT_ROOT'] . '/../include/db.inc.php';

	$username = mysqli_real_escape_string($link, $username);
	$password = mysqli_real_escape_string($link, $password);

	$sql = "SELECT COUNT(*) FROM user
		WHERE username='$username' AND password='$password'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$error = 'Error searching for user.';
		include $_SERVER['DOCUMENT_ROOT'] . '/../include/error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	if ($row[0] > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function userIsAdmin() {
	include $_SERVER['DOCUMENT_ROOT'] . '/../include/db.inc.php';

	$username = mysqli_real_escape_string($link, $_SESSION['username']);

	$sql = "SELECT COUNT(*) FROM user
			WHERE username = '$username' AND admin = '1'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$error = 'Error searching for administrator.';
		include $_SERVER['DOCUMENT_ROOT'] . '/../include/error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	if ($row[0] > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}
?>
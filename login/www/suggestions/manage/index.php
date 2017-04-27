<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/access.inc.php';

if (!userIsLoggedIn()) {
	include '../login.html.php';
	exit();
}

if (isset($_POST['add'])) {
	$action = 'addform';
	$text = '';
	$recipient = $_POST['recipient'];
	$button = 'Submit Suggestion';

	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';

	// Build the full name of the recipient of this suggestion
	$sql = "SELECT firstname, lastname FROM user WHERE username='{$recipient}'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$err = 'Error fetching recipient&rsquo;s full name.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}
         $row = mysqli_fetch_array($result);
	$fullname = $row['firstname'] . ' ' . $row['lastname'];
	$pagetitle = "New Suggestion for {$fullname}";

	include 'form.html.php';
	exit();
}
if (isset($_GET['addform'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';

	$recipient = mysqli_real_escape_string($link, $_POST['recipient']);
	$text = mysqli_real_escape_string($link, $_POST['text']);
	$suggester = $_SESSION['username'];

	if ($recipient == '') {
		$err = 'No recipient specified for this suggestion.
			Click &lsquo;back&rsquo; and try again.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	$sql = "INSERT INTO suggestion SET
			suggester='$suggester',
			recipient='$recipient',
			content='$text'";
	if (!mysqli_query($link, $sql)) {
		$err = 'Error storing submitted suggestion.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	header('Location: .');
	exit();
}
if (isset($_POST['edit'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';

	$id = mysqli_real_escape_string($link, $_POST['id']);
	$sql = "SELECT suggester, recipient, content FROM suggestion WHERE id='$id'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$err = 'Error fetching suggestion for editing.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}
	$row = mysqli_fetch_assoc($result);

	if ($row['suggester'] != $_SESSION['username']) {
		$err = 'Invalid attempt to edit suggestion.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	// Build the full name of the recipient of this suggestion
	$recipient = $row['recipient'];
	$sql = "SELECT firstname, lastname FROM user WHERE username='{$recipient}'";
	$result = mysqli_query($link, $sql);
	if (!$result) {
		$err = 'Error fetching recipient&rsquo;s full name.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}
	$row2 = mysqli_fetch_assoc($result);
	$fullname = $row2['firstname'] . ' ' . $row2['lastname'];

	$pagetitle = "Edit Suggestion for {$fullname}";
	$action = 'editform';
	$text = $row['content'];
	$recipient = $row['recipient'];
	$button = 'Update Suggestion';
	
	include 'form.html.php';
	exit();
}
if (isset($_GET['editform'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';

	$recipient = mysqli_real_escape_string($link, $_POST['recipient']);
	$text = mysqli_real_escape_string($link, $_POST['text']);
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$suggester = $_SESSION['username'];

	if ($recipient == '') {
		$err = 'No recipient specified for this suggestion.
			Click &lsquo;back&rsquo; and try again.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	$sql = "UPDATE suggestion SET
		suggester='$suggester',
		recipient='$recipient',
		content='$text'
		WHERE id='$id'";
	if (!mysqli_query($link, $sql)) {
		$err = 'Error storing edited suggestion.';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}

	header('Location: .');
	exit();
}
// Display listing of submitted suggestions
include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
$result = mysqli_query($link, "SELECT username, firstname, lastname FROM user 
			WHERE active='1' AND admin='0'");
if (!$result) {
	$err = 'Error fetching users from database!';
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
	exit();
}

while ($row = mysqli_fetch_array($result)) {
	$result2 = mysqli_query($link, "SELECT suggestion.id, posted, content FROM suggestion
                 INNER JOIN user ON suggester=user.username 
	        WHERE recipient='{$row[username]}' AND user.username='{$_SESSION[username]}'");
	if (!$result2) {
		$err = 'Error fetching suggestions from database!';
		include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
		exit();
	}
	$suggestions = array();
	while ($sug = mysqli_fetch_assoc($result2)) {
		$suggestions[] = $sug;
	}
	
	$users[] = array('recipient' => $row['username'], 
		             	'firstname' => $row['firstname'], 
			'lastname' => $row['lastname'], 
			'suggestions' => $suggestions);
}

include 'list.html.php';
?>
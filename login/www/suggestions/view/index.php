<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/access.inc.php';

if (!userIsLoggedIn()) {
	include '../login.html.php';
	exit();
}

// Display listing of this user's suggestions
include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/db.inc.php';
$result = mysqli_query($link, "SELECT posted, content FROM suggestion 
                WHERE recipient='{$_SESSION[username]}' ORDER BY posted DESC");
if (!$result) {
	$err = 'Error fetching user&rsquo;s suggestions from database!';
	include $_SERVER['DOCUMENT_ROOT'] . '/logininfo/include/errmsg.html.php';
	exit();
}

$suggestions = array();
while ($row = mysqli_fetch_assoc($result))
{
	$suggestions[] = $row['content'];
}

include 'view.html.php';
?>
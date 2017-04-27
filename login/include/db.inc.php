<?php
$link = mysqli_connect('localhost', 'root', 'root');
if (!$link) {
	$err = 'Unable to connect to the database server';
	include 'errmsg.html.php';
	exit();
}

if (!mysqli_select_db($link, 'demo')) {
	$err = 'Unable to locate the necessary database';
	include 'errmsg.html.php';
	exit();
}
?>
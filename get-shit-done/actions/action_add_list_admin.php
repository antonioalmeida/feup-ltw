<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}

	$username = $_SESSION['username'];

	if ( !preg_match ("/^\d+$/", $_GET['listID'])) {
		die("ERROR: ID can only contain numbers");
	}
	if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_GET['username'])) {
		die("ERROR: Username invalid");
	}

	$listID = $_GET["listID"];
	$newUser = $_GET["username"];

	if (isAdmin($username, $listID))
		listAddAdmin($listID, $newUser);

?>

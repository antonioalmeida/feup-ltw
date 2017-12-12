<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}

if ( !preg_match ("/^[a-zA-Z]?[\w-]*(?![-_])*(\w)*$/", $_GET['name'])) {
    die("ERROR: Search username invalid");
}

getUsersWithNameLike($_GET['name']);
?>

<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(!isset($_SESSION['username'])) {
			echo -1;
	    header('Location: ' . '../404.php');
}

	$username = $_SESSION['username'];

	if ( !preg_match ("/^\d+$/", $_GET['id'])) {
	  die("ERROR: itemID can only contain numbers");
	}

	$itemID = $_GET["id"];

	if (isItemAdmin($username, $itemID))
		$hasDeleted = deleteItem($itemID);

	if($hasDeleted)
		echo $itemID;
	else
		echo -1;

?>

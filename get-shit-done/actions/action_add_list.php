<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
if(!$isLoggedIn){
    header('Location: ' . '../404.php');
}
$username = $_SESSION['username'];

if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_GET['title'])) {
  die("ERROR: title can only contain letters, numbers and most common punctuaction");
}
if ( !preg_match ("/^\d+$/", $_GET['category'])) {
  die("ERROR: Category ID can only contain numbers");
}

if ($_SESSION['csrf'] !== $_GET['csrf']){
    die("ERROR: Request does not appear to be legitimate");
}

$title = (string) $_GET["title"];
$creationDate = date("d-m-Y");
$category = $_GET["category"];

addList($username, $title, $creationDate, $category);
?>

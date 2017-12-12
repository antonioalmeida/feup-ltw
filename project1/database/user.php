<?php
  function isLoginCorrect($username, $password) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array(strtolower($username)));
    $user = $stmt->fetch();
    return ($user !== false && password_verify($password, $user['password']));
  }

  function usernameExists($username){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User where username = ?');
    $stmt->execute(array(strtolower($username)));
    return ($stmt->fetch() !== false);
}

function emailInUse($email){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User where email = ?');
    $stmt->execute(array(strtolower($email)));
    return ($stmt->fetch() !== false);
}

function newUser($username, $password, $email){
    global $dbh;
    $options = ['cost' => 12];
    $stmt = $dbh->prepare('INSERT INTO User (userName, password, email) values(?, ?, ?)');
    $stmt->execute(array(strtolower($username), password_hash($password, PASSWORD_DEFAULT, $options), strtolower($email)));
}

function getUser($username) {
  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM User WHERE userName = ?');
  $stmt->execute(array(strtolower($username)));
  return $stmt->fetch();
}

function getUserPicture($username) {
  global $dbh;
  $stmt = $dbh->prepare('SELECT picture FROM User WHERE userName = ?');
  $stmt->execute(array(strtolower($username)));
  return $stmt->fetch();
}

function updateUser($username, $picture,$name, $bio) {
  global $dbh;
  $stmt = $dbh->prepare('UPDATE User SET picture = ?, name = ?, bio = ? WHERE username = ?');
  $stmt->execute(array($picture, $name, $bio, strtolower($username)));
}

function updatePictureUser($username, $picture) {
  global $dbh;
  $stmt = $dbh->prepare('UPDATE User SET picture = ? WHERE username = ?');

  try {
    $stmt->execute(array($picture, strtolower($username)));
    return true;
  }
  catch (Exception $e) {
      return false;
  }
}

function getUsersWithNameLike($name) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT username from User where username like ?');
    $stmt->execute(array('%'.strtolower($name).'%'));
    $names = $stmt->fetchAll();

    echo json_encode($names);
    return true;
}

?>

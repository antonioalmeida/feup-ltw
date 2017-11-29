<?php

function getUserLists($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id as listId, List.title as listName, List.creationDate as creationDate, Category.name as categoryName, Color.code as categoryColor from List, Category, Color where List.creator == ? and List.category == Category.id and Category.color == Color.Code;');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function isAdmin($username, $listID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT user FROM List, ListAdmin WHERE user = ? AND ListAdmin.list = ?');
    $stmt->execute(array($username, $listID));
    return ($stmt->fetch() !== false);
}

function addList($username, $title, $creationDate, $category) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO List (title, creationDate, category, creator) values(?, ?, ?, ?)');

    try {
        $stmt->execute(array($title, $creationDate, $category, $username));
    } catch (Exception $e) {
        print_r($e->errorInfo);
        return;
    }
    // return added list as JSON
    $newList = getLastList($username);
    echo json_encode($newList);
}

function addItem($id_list, $description, $dueDate, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Item (description, dueDate, Color, list) values(?, ?, ?, ?)');

    try {
        $stmt->execute(array($description, $dueDate, $color, $id_list));
    } catch (Exception $e) {
        print_r($e->errorInfo);
        return;
    }
    // return added list as JSON
    $newItem = getLastItem($id_list);
    echo json_encode($newItem);
}

function getLastList($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id, List.title, List.creationDate, Category.name, Category.color FROM List, Category, User WHERE List.creator == ? AND List.category = Category.id ORDER BY List.id DESC LIMIT 1');
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function getLastItem($id_list) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item WHERE list == ? ORDER BY Item.id DESC LIMIT 1');
    $stmt->execute(array($id_list));
    return $stmt->fetch();
}

function getUserList($username, $id) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM List WHERE creator = ? AND id =?');
    $stmt->execute(array($username,$id));
    return $stmt->fetch();
}

function getAdminList($id) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM List WHERE creator = ? AND id =?');
    $stmt->execute(array($username,$id));
    return $stmt->fetch();
}

function getListItems($listId) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item WHERE list = ?');
    $stmt->execute(array($listId));
    return $stmt->fetchAll();
}

function setItemComplete($itemId) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item SET complete = 1 WHERE Item.id = ?;');
    $stmt->execute(array($itemId));
    return;
}

function deleteList($listId) {
    global $dbh;
    $stmt = $dbh->prepare('DELETE from List where List.id == ?;');
    $stmt->execute(array($listId));
    return;
}

function getUserAvailableCategories($userId) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT id, name from category where user is null union select id, name from category where user = ?;');
    $stmt->execute(array($userId));
    return $stmt->fetchAll();
}

?>

<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/database/db.db";
  $dbh = new PDO("sqlite:$path", $path);
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

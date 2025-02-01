<?php
    require 'login.php';
    $db = new SQLite3('db.sqlite3');
    $dbinfo = $db->query("SELECT * FROM admins WHERE id = '{$_COOKIE["user"]}'");
?>
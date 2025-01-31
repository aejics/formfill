<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $db = SQLite3.open('db.sqlite3');
    if(!db) {
        echo "Erro ao abrir a base de dados";
        exit();
    } else {
        echo "Base de dados aberta com sucesso";
    }
?>
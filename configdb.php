<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $db = new SQLite3('db.sqlite3');
    if(!$db) {
        echo "Erro ao abrir a base de dados";
        exit();
    } else {
        echo "Base de dados aberta com sucesso";
    }
    $db->query("CREATE TABLE cache_giae(id VARCHAR(10) NOT NULL UNIQUE, nome VARCHAR(99) NOT NULL, nomecompleto VARCHAR(150) NOT NULL, email VARCHAR(99), PRIMARY KEY (id))");
    $db->query("CREATE TABLE admins(id VARCHAR(10) NOT NULL UNIQUE, atividade BOOL, PRIMARY KEY (id), FOREIGN KEY (id) REFERENCES cache_giae(id))");
    $result = $db->query("SELECT * FROM cache_giae");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }
    while ($row = $result->fetchArray()) {
        echo "ID: $row[0] NOME: $row[1] NOME COMPLETO: $row[2] EMAIL: $row[3]";
        echo "<hr />\n";
    }    
?>
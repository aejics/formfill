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
    $temp = 0;
    $db->query("CREATE TABLE test (id SERIAL PRIMARY KEY, email VARCHAR(50));");
    while ($temp < 10) {
       $temp = $temp + 1;
       $db->query("INSERT INTO test (id,email) VALUES (". $temp . ", 'mail" . $temp . "@aejics.org');");
    }
    $result = $db->query("SELECT * FROM test WHERE ID <= 5");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }
    while ($row = $result->fetchArray()) {
        echo "ID: $row[0] EMAIL: $row[1]";
        echo "<hr />\n";
    }    
?>
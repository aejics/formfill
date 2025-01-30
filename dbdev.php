<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $env = parse_ini_file('.env');
    $db = pg_connect('host=172.21.190.180 dbname=formfill user=postgres password=' . $env["passsql"]);
    $temp = 0;
    //pg_query($db, "CREATE TABLE test (id SERIAL PRIMARY KEY, email VARCHAR(50))");
    //while ($temp < 10) {
    //    $temp = $temp + 1;
    //    pg_query($db, "INSERT INTO test (id,email) VALUES (". $temp . ", 'mail" . $temp . "@aejics.org');");
    //}
    $result = pg_query($db, "SELECT * FROM test WHERE ID <= 5");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }
    while ($row = pg_fetch_row($result)) {
        echo "ID: $row[0] EMAIL: $row[1]";
        echo "<hr />\n";
    }
?>
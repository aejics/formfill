<?php
    require 'login.php';
    $db = new SQLite3('db.sqlite3');
    $dbinfo = $db->query("SELECT * FROM cache_giae WHERE id = '{$_COOKIE["user"]}'");
    $nome = utf8_encode($dbinfo->fetchArray()[2]);
    if (isset($_COOKIE["loggedin"])) {
        echo("
        <div class='h-100 d-flex align-items-center justify-content-center flex-column'>
            <p class='h2 mb-4'>Bem-vindo, <b>{$nome}</b></p>
            <button type='button' class='btn btn-secondary btn-lg btn-block' onclick='window.open(\"form.php?formid=1\", \"popup\", \"width=800,height=600,scrollbars=yes,resizable=yes\")' >
            Declaração de Falta
            <p class='h6'>Documento para informar de futura falta.</p>
            <p class='h6'><i>Deve ser preenchido com sessão do declarador</i></p></button>
        ");
    };
    require 'src/footer.php';
?>
    </body>
</html>
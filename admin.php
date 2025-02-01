<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require 'login.php';
    $db = new SQLite3('db.sqlite3');
    $dbinfo = $db->query("SELECT * FROM admins WHERE id = '{$_COOKIE["user"]}'");
    if (!$dbinfo) {
        echo "An error occurred.\n";
        exit;
    }
    if ($dbinfo->fetchArray()['atividade'] == 1) {
        $db->close();
        if (!$_GET['action']){
        // Sidebar
            echo "</div><div class='d-flex' style='height: 85vh;'>
                <div class='flex-shrink-0 p-3 text-bg-dark' style='width: 280px;'>
                <h1>Administração</h1>        
                <ul class='nav nav-pills flex-column mb-auto'>
                    <li class='nav-item'>
                    <a href='/admin.php' class='nav-link "; if ($_SERVER['REQUEST_URI'] == "/admin.php") {echo "active";};
                    echo"'>
                        Dashboard</a></li>
                    <li>
                    <a href='/admin.php?section=manutencao' class='nav-link "; if ($_SERVER['REQUEST_URI'] == "/admin.php?section=manutencao") {echo "active";};
                    echo"'>
                        Manutenção</a></li>
                    <li>
                    <a href='/admin.php?section=forms' class='nav-link "; if ($_SERVER['REQUEST_URI'] == "/admin.php?section=forms") {echo "active";};
                    echo"'>
                        Formulários</a></li>
                </ul>
                </div><div class='flex-grow-1 d-flex align-items-center justify-content-center flex-column'>";
        }
        if (!$_GET['action'] && !$_GET['section']) {
            // Dashboard principal
            echo "<h1>Dashboard</h1>";
        } else if ($_GET['section'] == "manutencao") {
            // Opções de Manutenção
            echo "<div class='flex-grow-1 d-flex align-items-center justify-content-center flex-column'>";
            echo "<h1>Manutenção</h1><hr>";
            echo "<button type='button btn-primary' class='btn btn-primary w-30' onclick='window.open(\"admin.php?action=gestao_cache\", \"popup\", \"width=1200,height=600,scrollbars=yes,resizable=yes\")'>Gestão Manual da Cache do GIAE</button>";
        } else if ($_GET['section'] == "forms") {
            echo "<h1>Formulários</h1>";
        } else if ($_GET['action'] == "gestao_cache") {
            echo "<h1>Gestão Manual da Cache do GIAE</h1>";
            if ($_POST['user']) {
                $db = new SQLite3('db.sqlite3');
                $result = $db->query("SELECT * FROM cache_giae WHERE id LIKE '%{$_POST['user']}%'");
                if (!$result) {
                    echo "Não existe tal utilizador.\n";
                    exit;
                }
                echo "<table class='table'><tr><th scope='col'>ID</th><th scope='col'>NOME</th><th scope='col'>NOME COMPLETO</th><th scope='col'>EMAIL</th><th scope='col'>AÇÕES</th></tr>";
                while ($row = $result->fetchArray()) {
                    $nome = utf8_encode($row[1]);
                    $nomecompleto = utf8_encode($row[2]);
                    echo "<tr><td>$row[0]</td><td>$nome</td><td>$nomecompleto</td><td>$row[3]</td><td><a href='/admin.php?action=gestao_cache&subaction=edit&user=$row[0]'>EDITAR</a>  <a href='/admin.php?action=gestao_cache&subaction=delete&user=$row[0]'>APAGAR</a></tr>";
                }
                $db->close();
            }
            if ($_GET['subaction'] == "edit") {
                if ($_POST["nome"]){
                    $db = new SQLite3('db.sqlite3');
                    $valordb = $db->prepare("UPDATE cache_giae SET nome = :nome, nomecompleto = :nomecompleto, email = :email WHERE id = :id");
                    $valordb->bindValue(':nome', utf8_decode($_POST["nome"]), SQLITE3_TEXT);
                    $valordb->bindValue(':nomecompleto', utf8_decode($_POST["nomecompleto"]), SQLITE3_TEXT);
                    $valordb->bindValue(':email', utf8_decode($_POST["email"]), SQLITE3_TEXT);
                    $valordb->bindValue(':id', $_GET['user'], SQLITE3_TEXT);
                    $valordb->execute();
                    var_dump($valordb->getSQL(true));
                    $db->close();
                    echo "<div class='alert alert-success text-center' role='alert'>Utilizador atualizado com sucesso.</div>";
                }
                if ($_GET['user']){
                    $db = new SQLite3('db.sqlite3');
                    $result = $db->query("SELECT * FROM cache_giae WHERE id = '{$_GET['user']}'");
                    if (!$result) {
                        echo "Não existe tal utilizador.\n";
                        exit;
                    }
                    $row = $result->fetchArray();
                    $db->close();
                    $nome = utf8_encode($row[1]);
                    $nomecompleto = utf8_encode($row[2]);
                    echo "<form action='/admin.php?action=gestao_cache&subaction=edit&user={$_GET['user']}' method='POST'>
                    <div class='form-floating'>
                        <input type='text' class='form-control' id='nome' name='nome' value='$nome'>
                        <label for='nome' class='form-label'>Nome</label>
                    </div>
                    <br>
                    <div class='form-floating'>
                        <input type='text' class='form-control' id='nome' name='nomecompleto' value='$nomecompleto'>
                        <label for='nomecompleto' class='form-label'>Nome completo</label>
                    </div>
                    <br>
                    <div class='form-floating'>
                        <input type='email' class='form-control' id='nome' name='email' value='$row[3]'>
                        <label for='email' class='form-label'>Email</label>
                    </div>
                    <br>
                    <button type='submit' class='btn btn-primary w-100'>Atualizar</button></form><hr>";
                }
            }
            if ($_GET['subaction' == "delete"]) {
                $db = new SQLite3('db.sqlite3');
                $valordb = $db->prepare("DELETE FROM cache_giae WHERE id = :id");
                $valordb->bindValue(':id', $_GET['user'], SQLITE3_TEXT);
                $valordb->execute();
                $db->close();
                echo "<div class='alert alert-success text-center' role='alert'>Utilizador apagado com sucesso.</div>";
            }
            echo "<form action='/admin.php?action=gestao_cache' method='POST'>
            <div class='form-floating'>
                <input type='text' class='form-control' id='user' name='user' required placeholder='fxxxx ou axxxxx'>
                <label for='user' class='form-label'>ID p/gerir</label>
            </div></form><hr>";
        } 
        include 'src/footer.php';
    } else {
        http_response_code(403);
        echo "<div class='alert alert-danger text-center' role='alert'>Não tem autorização para entrar nesta página.</div>
        <div class='text-center'>
        <button type='button' class='btn btn-primary w-100' onclick='history.back()'>Voltar</button></div>";
        exit;
    }
?>
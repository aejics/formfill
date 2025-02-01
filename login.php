<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>FormFill</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="/src/main.css" rel="stylesheet">
</head>
<body>
    <?php require 'src/header.php'; ?>
    <br>
    <div class='h-100 d-flex align-items-center justify-content-center flex-column'>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once(__DIR__ . "/vendor/autoload.php");
    $db = new SQLite3('db.sqlite3');
    $action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
    $loggedin = filter_input(INPUT_COOKIE, 'loggedin', FILTER_UNSAFE_RAW);
    if (!$loggedin && $action !== "loginform" && $action !== "login"){
        header('Location: /login.php?action=loginform');
    }
    if ($action == "loginform"){
        print("<div class='h-100 d-flex align-items-center justify-content-center flex-column'>
            <p class='h2 mb-4'>Autentique-se via GIAE AEJICS</p>
            <p class='mb-4'>Utilize as credenciais do GIAE AEJICS para continuar para <b>FormFill</b></p>
            <form action='/login.php?action=login' method='POST' class='w-200' style='max-width: 600px;'>
                <div class='mb-3'>
                    <label for='user' class='form-label'>Nome de utilizador <b class='required'>*</b>:</label>
                    <input type='text' class='form-control' id='user' name='user' required autofocus placeholder='fxxxx ou axxxxx'>
                </div>
                <div class='mb-3'>
                    <label for='pass' class='form-label'>Palavra-passe <b class='required'>*</b>:</label>
                    <input type='password' class='form-control' id='pass' name='pass' required placeholder='********'>
                </div>
                <button type='submit' class='btn btn-primary w-100'>Iniciar sessão</button>
                <hr>
                <p class='h6'><i>Problemas a fazer login? Contacte o Apoio Informático.</i></p>
            </form>
            <hr>
        </div>");
    }
    if ($action == "login"){
        $user = filter_input(INPUT_POST, 'user', FILTER_UNSAFE_RAW);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_UNSAFE_RAW);
        $giae = new \juoum\GiaeConnect\GiaeConnect("giae.aejics.org", $user, $pass);
        $config = json_decode($giae->getConfInfo(), true);
        $perfil = json_decode($giae->getPerfil(), true);
        if (strpos($giae->getConfInfo(), 'Erro do Servidor') !== false){
            echo("<div class='alert alert-danger text-center' role='alert'>A sua palavra-passe está errada.</div>
            <div class='text-center'>
            <button type='button' class='btn btn-primary w-100' onclick='history.back()'>Voltar</button></div>");
        }
        else {
            setcookie("loggedin", "true", time() + 3599, "/");
            setcookie("session", $giae->session, time() + 3599, "/");
            setcookie("user", $_POST["user"], time() + 3599, "/");
            $valordb = $db->prepare("INSERT INTO cache_giae(id, nome, nomecompleto, email) VALUES (:1, :2, :3, :4);");
            $valordb->bindValue(':1', mb_convert_encoding($_POST["user"], 'ISO-8859-1', 'auto'), SQLITE3_TEXT);
            $valordb->bindValue(':2', mb_convert_encoding($config['nomeutilizador'], 'ISO-8859-1', 'auto'), SQLITE3_TEXT);
            $valordb->bindValue(':3', mb_convert_encoding($perfil['perfil']['nome'], 'ISO-8859-1', 'auto'), SQLITE3_TEXT);
            $valordb->bindValue(':4', mb_convert_encoding($perfil['perfil']['email'], 'ISO-8859-1', 'auto'), SQLITE3_TEXT);
            $valordb->execute();
            header('Location: /');
        }
    };
    if ($loggedin){
        $giae->session = filter_input(INPUT_COOKIE, 'session', FILTER_UNSAFE_RAW);
        $giae = new \juoum\GiaeConnect\GiaeConnect("giae.aejics.org");
        $giae->session=$_COOKIE["session"];
        // Este código funciona especificamente com a maneira de verificação no GIAE AEJICS.
        // Pode não funcionar da mesma maneira nos outros GIAEs. Caso não funcione na mesma maneira, corriga este código e faça um pull request!
        if (str_contains($giae->getConfInfo(), 'Erro do Servidor')){
            header('Location: /login.php?action=logout');
            die("A sua sessão expirou");
        }
    }
    if ($action == "logout"){
        $giae = new \juoum\GiaeConnect\GiaeConnect("giae.aejics.org");
        $giae->session=$_COOKIE["session"];
        $giae->logout();
        setcookie("loggedin", "", time() - 3600, "/");
        echo("<div class='alert alert-success text-center' role='alert'>A sua sessão foi terminada com sucesso.</div>
        <div class='text-center'>
        <button type='button' class='btn btn-primary w-100' onclick='history.back()'>Voltar</button></div>");
    };
    require 'src/footer.php';
?>
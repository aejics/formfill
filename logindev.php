<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>FormFill</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="/css/main.css" rel="stylesheet">
</head>
<body>
    <?php require 'src/header.php'; ?>
    <br>
    <div class='h-100 d-flex align-items-center justify-content-center flex-column'>
<?php
    require_once(__DIR__ . "/vendor/autoload.php");
    if ($_GET["action"] = "login"){
        die("login");
    };
    if ($_GET["action"] = "logout"){
        die("logout");
    };
    if (isset($_COOKIE["loggedin"])){
        $giae = new \juoum\GiaeConnect\GiaeConnect("giae.aejics.org");
        $giae->session=$_COOKIE["session"];
        // Este código funciona especificamente com a maneira de verificação no GIAE AEJICS.
        // Pode não funcionar da mesma maneira nos outros GIAEs. Caso não funcione na mesma maneira, corriga este código e faça um pull request!
        if (str_contains($giae->getConfInfo(), 'Erro do Servidor')){
            header('Location: /logout.php');
        }
    }
?>
    <?php require 'src/footer.php'; ?>
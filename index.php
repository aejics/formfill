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
    <?php 
        require_once(__DIR__ . "/vendor/autoload.php");
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    ?>
    <body>
        <?php include 'src/header.php'; ?>
        <br>
        <?php
            require 'logindev.php';
            if (isset($_COOKIE["loggedin"])) {
                echo("
                <div class='h-100 d-flex align-items-center justify-content-center flex-column'>
                    <p class='h2 mb-4'>Bem-vindo, <b>" . $_COOKIE["nomedapessoa"] . "</b></p>
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
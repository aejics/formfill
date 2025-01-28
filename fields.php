<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>FormFill - Preenchimento</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="/css/main.css" rel="stylesheet">
</head>
<body>
    <?php include 'src/verifsessaovalida.php'; ?>
    <?php include 'src/header.php'; ?>
    <br>
    <div class='h-100 d-flex align-items-center justify-content-center flex-column'>
    <p class='h2 mb-4'>Preencha o Formulário</p>
    <p class='mb-4'>Este formulário obriga o preenchimento dos seguintes campos:</p>
    <form action="doc.php" method="post">
    <?php
        if ($_GET["formid"] == 1){
            echo("
            <input type='hidden' name='formid' value='1'>
            <div class='mb-3'>
                <label for='data_inicio' class='form-label'>Data de início <b class='required'>*</b>:</label>
                <input type='date' class='form-control' id='data_inicio' name='data_inicio' required>
            </div>
            <div class='mb-3'>
                <label for='data_fim' class='form-label'>Data de fim <b class='required'>*</b>:</label>
                <input type='date' class='form-control' id='data_fim' name='data_fim' required>
            </div>
            <div class='mb-3'>
                <label for='motivo' class='form-label'>Motivo <b class='required'>*</b>:</label>
                <input type='text' class='form-control' id='motivo' name='motivo' required>
            </div>
            <button type='submit' class='btn btn-primary w-100'>Criar documento</button>
            ");
        }
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="/css/main.css" rel="stylesheet">
</head>
<body>
<br>
<div class='h-100 d-flex align-items-center justify-content-center flex-column'>
<p class='h2 mb-4'>Preencha o Formulário</p>
<p class='mb-4'>Este formulário obriga o preenchimento dos seguintes campos:</p>
<form action="doc.php" method="post">
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $formulario = json_decode(file_get_contents("1.json"));
    echo "<input type='hidden' name='formid' value='1'>";
    foreach ($formulario->campos as $index=>$quest){
        echo "<div class='mb-3'>";
        echo "<label for='{$quest->idcampo}' class='form-label'>{$quest->descricao}";
        if ($quest->obrigatorio){
            echo " <b class='required'>*</b>";
        };
        echo ":</label>";
        echo "<input type='{$quest->tipo}' class='form-control' id='{$quest->idcampo}' name='{$quest->idcampo}'";
        if ($quest->obrigatorio){
            echo "required";
        }
        echo "></div>";
    }
    echo "<button type='submit' class='btn btn-primary w-100'>Submeter</button>";
?>    
</body>
</html>

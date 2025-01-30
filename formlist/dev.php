<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
            echo "<b class='required'>*</b>";
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

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="doc.php" method="post">
        <input type="hidden" name="formid" value="1">    
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">
        <label for="data_inicio">Data de início</label>
        <input type="date" name="data_inicio" id="data_inicio">
        <label for="data_fim">Data de fim</label>
        <input type="date" name="data_fim" id="data_fim">
        <label for="motivo">Motivo</label>
        <input type="text" name="motivo" id="motivo">
        <button type="submit">Enviar</button>
</body>
</html>
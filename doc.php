<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>FormFill - Documento Criado</title>
    <link href="/css/main.css" rel="stylesheet">
</head>
<body>
    <?php include 'src/header.php'; ?>
    <?php
        require_once(__DIR__ . "/vendor/autoload.php");
        class PDF extends FPDF
        {
            function criarDocumento($titulo, $texto)
            {
                $this->AddPage();
                $this->SetXY(10, 40);
                $this->Image("img/logoaejics.png", 10, 10, 20);
                $this->Image("img/logominedu.png", 130, 15, 65);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 10, $titulo, 0, 1, 'C', false);
                $this->SetFont('Arial', '', 13);
                $this->MultiCell(0, 10, $texto, 0, 0, '', false);
            }
        }

        $formid = intval($_POST['formid']);
        switch ($formid) {
            case 1:
                $pdf = new PDF();
                // Formulário de Falta
                $texto = mb_convert_encoding('Informo que eu, ' . $_COOKIE['nomedapessoa'] . ', não irei comparecer ao serviço nas datas de ' . $_POST['data_inicio'] . ' até ' . $_POST['data_fim'] . ' por motivo de ' . $_POST['motivo'] . "\r\n\r\n\r\nSobral de Monte Agraço, \r\n" . date('d\/m\/Y'), 'ISO-8859-1', 'UTF-8');
                $pdf->criarDocumento(mb_convert_encoding('Declaração de Falta', 'ISO-8859-1', 'UTF-8'), $texto);
                mkdir('filledforms');
                $nomeficheiro = date('YmdHisv') . ".pdf";
                $pdf->Output('F', 'filledforms/' . $nomeficheiro);
                break;
        }
    ?>
    <h2 class="text-center">Documento criado com sucesso!</h1>
    <p class='font-weight-light text-center'>Caso seja necessário, por favor assine o documento por via de CMD</p>
    <iframe src="/filledforms/<?php echo($nomeficheiro); ?>" type="application/pdf" width="100%" height="390px"></iframe>
    <?php include 'src/footer.php'; ?>
</body>
</html>
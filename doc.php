<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>FormFill - Documento Criado</title>
    <link href="/src/main.css" rel="stylesheet">
</head>
<body>
    <?php include 'src/header.php'; ?>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $env = parse_ini_file('.env');
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require_once(__DIR__ . "/vendor/autoload.php");
        class PDF extends FPDF
        {
            function criarDocumento($titulo, $texto)
            {
                $this->AddPage();
                $this->SetXY(10, 40);
                $this->Image("src/logoaejics.png", 10, 10, 20);
                $this->Image("src/logominedu.png", 130, 15, 65);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 10, $titulo, 0, 1, 'C', false);
                $this->SetFont('Arial', '', 13);
                $this->MultiCell(0, 10, $texto, 0, 'J');
                $this->MultiCell(0, 10, $texto, 0, 'J');
                $this->MultiCell(0, 10, $texto, 0, 'J');
                
            }
        }

        $formid = intval($_POST['formid']);
        switch ($formid) {
            case 1:
                $pdf = new PDF();
                // Formulário de Falta
                $db = new SQLite3('db.sqlite3');
                $user = filter_input(INPUT_COOKIE, 'user', FILTER_UNSAFE_RAW);
                //fetch array 2
                $result = $db->query("SELECT * FROM cache_giae WHERE id = '{$user}'");
                $texto = "lol teste {$result->fetchArray()[2]}";
                $pdf->criarDocumento(utf8_decode('Declaração de Falta'), $texto);
                mkdir('filledforms');
                $nomeficheiro = date('YmdHisv') . ".pdf";
                $pdf->Output('F', 'filledforms/' . $nomeficheiro);
        }
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp-mail.outlook.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'a11531@aejics.org';
        $mail->Password   = $env["pass"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
        $mail->setFrom('a11531@aejics.org', 'FormFill');
        $mail->addAddress('a11531@aejics.org', 'Marco Pisco');     //Add a recipient
        $mail->addCC('marco@marcopisco.com');
        
            //Attachments
        $mail->addAttachment('filledforms/' . $nomeficheiro);         //Add attachments
        
            //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Documento gerado e preenchido';
        $mail->Body    = utf8_decode('Envio o formulário preenchido por ' . $_COOKIE["nomedapessoa"] . '. Está anexado neste email.');
        
        $mail->send();
    ?>
    <h2 class="text-center">Documento criado com sucesso!</h1>
    <p class='font-weight-light text-center'>Caso seja necessário, por favor assine o documento por via de CMD. Foi lhe enviado por email.</p>
    <iframe src="/filledforms/<?php echo($nomeficheiro); ?>" type="application/pdf" width="100%" height="390px"></iframe>
    <?php include 'src/footer.php'; ?>
</body>
</html>
<?php
    require('login.php');
    require_once(__DIR__ . "/vendor/autoload.php");
    class PDF extends FPDF
    {
        // Gerar documento do formulário preenchido
        function criarDocumento($titulo, $texto)
        {
            mkdir ('filledforms');
            $this->AddPage();
            $this->SetXY(10, 40);
            $this->Image("src/logoaejics.png", 10, 10, 20);
            $this->Image("src/logominedu.png", 130, 15, 65);
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(0, 10, $titulo, 0, 1, 'C', false);
            $this->SetFont('Arial', '', 13);
            $this->MultiCell(0, 10, $texto, 0, 'J');      
            $nomeficheiro = 'filledforms/' . date('YmdHisv') . ".pdf";
            $this->Output('F', $nomeficheiro);
            return $nomeficheiro;
        }
    }
    $pdf = new PDF();
    $formid = filter_input(INPUT_POST, 'formid', FILTER_UNSAFE_RAW); // Recolher o ID do Formulário
    $formulario = json_decode(file_get_contents("formlist/" . $_POST["formid"] . ".json")); // Com esse ID, buscar config do formulário
    $texto = $formulario->doc->texto; // Texto que está na config
    $db = new SQLite3('db.sqlite3'); // Conectar à Base de Dados
    $user = filter_input(INPUT_COOKIE, 'user', FILTER_UNSAFE_RAW); // Ir buscar ID do utilizador
    $dbresult = $db->query("SELECT * FROM cache_giae WHERE id = '{$user}'"); // Buscar dados à DB
    // Data de Hoje (# é dados do Sistema)
    $texto = str_replace('#data#', utf8_encode(date('d/m/Y')), $texto);
    // Dados da Base de Dados
    $texto = str_replace('§nomecompleto§', utf8_encode($dbresult->fetchArray()[2]), $texto);
    $texto = str_replace('§nome§', utf8_encode($dbresult->fetchArray()[1]), $texto);
    $texto = str_replace('§id§', utf8_encode($dbresult->fetchArray()[0]), $texto);
    $texto = str_replace('§email§', utf8_encode($dbresult->fetchArray()[3]), $texto);
    $db->close();
    // Campos do Formulário ()
    foreach ($formulario->campos as $index=>$quest){
        $texto = str_replace("&" . $quest->idcampo . "&", utf8_encode(filter_input(INPUT_POST, $quest->idcampo, FILTER_UNSAFE_RAW)), $texto);
    }
    // Título do Formulário
    $titulo = $formulario->nome;
    // Local do PDF preenchido
    $linkpdfpreenchido = $pdf->criarDocumento(utf8_decode($titulo), utf8_decode($texto));
?>
    <h2 class="text-center">Documento criado com sucesso!</h1>
    <p class='font-weight-light text-center'>Caso seja necessário, por favor assine o documento por via de CMD. Foi lhe enviado por email.</p>
    <iframe src="<?php echo($linkpdfpreenchido); ?>" type="application/pdf" width="100%" height="390px"></iframe>
    <?php include 'src/footer.php'; ?>
</body>
</html>
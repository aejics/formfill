<?php
require_once(__DIR__ . "/vendor/autoload.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        $texto = mb_convert_encoding('Informo que eu, ' . $_POST['nome'] . ', não irei comparecer ao serviço nas datas de ' . $_POST['data_inicio'] . ' até ' . $_POST['data_fim'] . ' por motivo de ' . $_POST['motivo'] . "\r\n\r\n\r\nSobral de Monte Agraço, \r\n" . date('d\/m\/Y'), 'ISO-8859-1', 'UTF-8');
        $pdf->criarDocumento(mb_convert_encoding('Declaração de Falta', 'ISO-8859-1', 'UTF-8'), $texto);
        mkdir('filledforms');
        $pdf->Output('F', 'filledforms/' . date('YmdHisv') . '.pdf');
        break;
}

?>
<iframe src="/filledforms/<?php echo(date('YmdHisv') . '.pdf'); ?>" type="application/pdf" width="100%" height="100%"></iframe>
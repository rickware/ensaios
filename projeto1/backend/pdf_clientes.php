<?php
// salvar PDF CLIENTES
require "./database.php";
require('../../referencias/fpdf184/fpdf.php');

class pdf_clientes extends FPDF {

  function CarregaDados($conn) {
    $result = mysqli_query($conn, 'SELECT * FROM rbmweb.clientes ORDER BY nome;');
    $data = mysqli_fetch_all($result, MYSQLI_NUM);

    return $data;
  }

  function Tabela($header, $data) {
    // largura das colunas
    $c1 = 10;
    $c2 = 50;
    $c3 = 60;
    $c4 = 30;
    $w = array($c1,$c2,$c3,$c4);

    // Header
    for ($i = 0; $i < count($header); $i++) {
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $this->Ln();

    // Data
    foreach ($data as $row) {
      $this->Cell($w[0], 6, $row[0], 'LR', 0, 'C');
      $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L');
      $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L');
      $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C');
      $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

}

$pdf = new pdf_clientes();
$header = array('ID', 'NOME', 'EMAIL', 'CELULAR');
$data = $pdf->CarregaDados($conn);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 10, 'CLIENTES');
$pdf->Ln();
$pdf->Tabela($header, $data);
$pdf->Output(I,"clientes.pdf",true);


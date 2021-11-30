<?php
// salvar PDF PRODUTOS
require "./database.php";
require('../../referencias/fpdf184/fpdf.php');

class pdf_produtos extends FPDF {

  function CarregaDados($conn) {
    $result = mysqli_query($conn, 'SELECT id, categoria, nome, unidade, preco, estoque FROM rbmweb.produtos ORDER BY categoria ,nome;');
    $data = mysqli_fetch_all($result, MYSQLI_NUM);

    return $data;
  }
//ID 	CATEGORIA 	NOME 	UNIDADE 	PREÇO 	ESTOQUE
  function Tabela($header, $data) {
    // largura das colunas
    $c1 = 10; $c2 = 20; $c3 = 50; $c4 = 60; $c5 = 20; $c6 = 20;
    $w = array($c1,$c2,$c3,$c4,$c5,$c6);

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
      $this->Cell($w[3], 6, $row[3], 'LR', 0, 'L');
      $this->Cell($w[4], 6, $row[4], 'LR', 0, 'C');
      $this->Cell($w[5], 6, $row[5], 'LR', 0, 'C');
      $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

}

$pdf = new pdf_produtos();
$strPreco = utf8_decode('PREÇO');
$header = array('ID', 'CATEGORIA','NOME', 'UNIDADE', $strPreco, 'EM ESTOQUE');
$data = $pdf->CarregaDados($conn);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 10, 'PRODUTOS');
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Tabela($header, $data);
$pdf->Output('I','produtos.pdf',true);


<?php
// salvar PDF PRODUTOS
require "./database.php";
require('../../referencias/fpdf184/fpdf.php');

class pdf_vendas extends FPDF {

  function CarregaDados($conn) {
    $result = mysqli_query($conn, "select p.id as pedido, c.nome as cliente, count(t.nome) as produtos,
      format(sum(t.preco * d.quantidade),2,'de_DE') as valor
      from clientes c
      inner join pedidos p on p.cliente_id = c.id
      inner join pedido_detalhes d on d.pedido_id = p.id
      left join produtos t on t.id = d.produto_id
      where 1
      group by pedido
      order by pedido");
    $data = mysqli_fetch_all($result, MYSQLI_NUM);
    return $data;
  }

  function Tabela($header, $data) {
    // largura das colunas
    $c1 = 40; $c2 = 40; $c3 = 40; $c4 = 40;
    $w = array($c1,$c2,$c3,$c4);

    // Header
    for ($i = 0; $i < count($header); $i++) {
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $this->Ln();

    // Data
    foreach ($data as $row) {
      $this->Cell($w[0], 6, $row[0], 'LR', 0, 'C');
      $this->Cell($w[1], 6, $row[1], 'LR', 0, 'C');
      $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C');
      $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C');
      $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

}

$pdf = new pdf_vendas();
$strPreco = utf8_decode('PREÇO');
$header = array('PEDIDO', 'CLIENTE','QUANTIDADE DE PRODUTOS', 'VALOR DO PEDIDO');
$data = $pdf->CarregaDados($conn);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 10, 'VENDAS');
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Tabela($header, $data);
$pdf->Output('I','vendas.pdf',true);


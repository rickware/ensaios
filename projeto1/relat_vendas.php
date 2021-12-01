<?php
require "./backend/database.php";
$result = mysqli_query($conn, "select c.nome as cliente, p.id as pedido, count(t.nome) as produtos,
format(sum(t.preco * d.quantidade),2,'de_DE') as valor
from clientes c
inner join pedidos p on p.cliente_id = c.id
inner join pedido_detalhes d on d.pedido_id = p.id
left join produtos t on t.id = d.produto_id
where 1
group by pedido
order by pedido");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto 1 - Relat&oacute;rio Vendas</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <p id="success"></p>
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Relat&oacute;rio <b>Vendas</b></h2>
            </div>
            <div class="col-sm-6">
              <a href="./relatorios.php" target="_self" title="RETORNAR">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                </svg>
              </a>
              <span onclick="salvar()" id="botao" class="btn btn-success">GERAR PDF</span>
            </div>
          </div>
        </div>
        <div id="report">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>PEDIDO</th>
              <th>CLIENTE</th>
              <th>QUANTIDADE DE PRODUTOS</th>
              <th>VALOR DO PEDIDO</th>
            </tr>
          </thead>
          <tbody>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              // if($debug){fb($row, FirePHP::DUMP);}
              ?>
              <tr>
                <td><?php echo $row["pedido"] ?></td>
                <td><?php echo $row["cliente"]; ?></td>
                <td><?php echo $row["produtos"]; ?></td>
                <td><?php echo $row["valor"]; ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
    <script>
      function salvar() {
        location.replace("./backend/pdf_vendas.php");
      }
    </script>
  </body>
</html>

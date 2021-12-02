<?php
ob_start();
require './backend/database.php';
fb('start', FIREPHP::INFO);

FILTER_NULL_ON_FAILURE;
$idcliente = filter_input(INPUT_GET, 'idcliente', FILTER_SANITIZE_NUMBER_INT);
if (!$idcliente) {
  $idcliente = 0;
}

function monta_select_cliente($link, $idcliente) {
  $resultcli = mysqli_query($link, "select id, nome from clientes");
  $resposta = '<select name="selcli" id="selcli" class="form-control" onchange="carregadadosCliente()">';
  while ($row = mysqli_fetch_assoc($resultcli)) {
    $resposta .= '<option value="' . $row["id"];
    if ($row["id"] === $idcliente) {
      $resposta .= '" selected ';
    }
    $resposta .= '">' . $row["nome"] . '</option>';
  }
  $resposta .= '</select>';
  return $resposta;
}

$select_cliente = monta_select_cliente($conn, $idcliente);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto 1 - CRUD VENDAS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/ajax_pedidos.js"></script>
  </head>
  <body>
    <div class="container">
      <p id="success"></p>
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h5 style="text-align: right;">Selecione o Cliente &Rightarrow;</h5>
              <h2>CRUD <b>PEDIDOS</b></h2>
            </div>
            <div class="col-sm-6">
              <form id="seleciona_cliente" style="margin-bottom: 5px;">
<?php echo $select_cliente; ?>
              </form>
              <a href="../index.php" target="_self" title="RETORNAR">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                </svg>
              </a>
              <a id="btn-novo" href="#novoPedidoModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons"></i> <span>Novo Pedido</span>
              </a>
              <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple">
                <i class="material-icons"></i> <span>Remover</span>
              </a>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="tabelaPedidos">
            <thead>
              <tr>
                <th>PEDIDO NUMERO</th>
                <th>QUANTIDADE DE ITENS</th>
                <th>VALOR DO PEDIDO</th>
                <th>AÇÃO</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal Novo HTML -->
    <div id="novoPedidoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Gerar Novo Pedido</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>CLIENTE:</label>
                <input type="text" id="nome" name="nome" class="form-control" readonly="true">
                <input type="hidden" id="idcliente" name="idcliente" class="form-control" required>
              </div>

            </div>
            <div class="modal-footer">
              <input type="hidden" value="pedido" name="crud">
              <input type="hidden" value="1" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">CONFIRMAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Exclui HTML -->
    <div id="excluiPedidoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <div class="modal-header">
              <h4 class="modal-title">Excluir Produto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_d" name="id" class="form-control">
              <p>Está certo que deseja continuar?</p>
              <p class="text-warning"><small>ESTA AÇÃO NÃO PODE SER DESFEITA.</small></p>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-danger" id="delete">EXCLUIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>var id_cliente = <?php echo $idcliente ?>;</script>
  </body>
</html>

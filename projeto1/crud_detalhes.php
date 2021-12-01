<?php
ob_start();
require './backend/database.php';

function monta_select_produtos($link){
  $resultcli = mysqli_query($link, "select id, nome from produtos");
  $resposta  = '<select name="idproduto" id="produto_u" class="form-control">';
  while ($row = mysqli_fetch_assoc($resultcli)){
    $resposta .= '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
  }
  $resposta .='</select>';
  return $resposta;
}

FILTER_NULL_ON_FAILURE;
$idCliente = filter_input(INPUT_GET, 'idcliente', FILTER_SANITIZE_NUMBER_INT);
$idPedido  = filter_input(INPUT_GET, 'idpedido', FILTER_SANITIZE_NUMBER_INT);

fb($idPedido,FIREPHP::INFO);
        
if($idPedido>-1){
  $select_produtos = monta_select_produtos($conn);
  
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto 1 - CRUD Pedido</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/ajax_detalhes.js"></script>
  </head>
  <body>
    <div class="container">
      <p id="success"></p>
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>CRUD <b>Itens do Pedido</b>&nbsp;<?php echo $idPedido?></h2>
            </div>
            <div class="col-sm-6">
              <a href="./crud_pedidos.php?idcliente=<?php echo $idCliente?>" target="_self" title="RETORNAR" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                </svg>
              </a>
              <a id="novoDetalhe" href="#novoDetalheModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons"></i> <span>Novo Item</span>
              </a>
              <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple">
                <i class="material-icons"></i> <span>Remover</span>
              </a>
            </div>
          </div>
        </div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll">
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>PRODUTO</th>
              <th>QUANTIDADE</th>
              <th>PRE&Ccedil;O</th>
              <th>VALOR</th>
              <th>AÇÃO</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $sql = "select p.id as pedido, d.id,
              t.nome as produto, t.id as idproduto,
              d.quantidade, t.preco,
              format((t.preco * d.quantidade),2,'de_DE') as valor
              from clientes c
              inner join pedidos p on p.cliente_id = c.id
              inner join pedido_detalhes d on d.pedido_id = p.id
              left join produtos t on t.id = d.produto_id
              where p.id = $idPedido";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
              //fb($row, FirePHP::DUMP);
              ?>
              <tr id="<?php echo $row['id']; ?>">
                <td>
                  <span class="custom-checkbox">
                    <input type="checkbox" class="cliente_checkbox" data-item-id="<?php echo $row['id']; ?>">
                    <label for="checkbox2"></label>
                  </span>
                </td>
                <td><?php echo $row["produto"] ?></td>
                <td><?php echo $row["quantidade"]; ?></td>
                <td><?php echo $row["preco"]; ?></td>
                <td><?php echo $row["valor"]; ?></td>
                <td>
                  <a href="#editaDetalheModal" class="edit" data-toggle="modal">
                    <i class="material-icons update" data-toggle="tooltip" 
                       data-id="<?php echo $row['id']; ?>" 
                       data-produto="<?php echo $row['idproduto']; ?>" 
                       data-quantidade="<?php echo $row['quantidade']; ?>" 
                       title="Editar"></i>
                  </a>
                  <a href="#excluiDetalheModal" class="delete" data-id="<?php echo $row['id']; ?>" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Excluir"></i>
                  </a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>

    <!-- Modal Novo HTML -->
    <div id="novoDetalheModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar Item</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Produto:</label>
                <?php echo $select_produtos; ?>
              </div>
              <div class="form-group">
                <label>Quantidade:</label>
                <input type="text" id="quantidade" name="quantidade" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="crud" value="detalhe">
              <input type="hidden" name="tipo" value="1">
              <input type="hidden" name="idpedido" value="<?php echo $idPedido?>">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">INSERIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edita HTML -->
    <div id="editaDetalheModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="update_form">
            <div class="modal-body">
              <input type="hidden" id="id_u" name="iddetalhe" class="form-control" required>
              <div class="form-group">
                <label>Produtos:</label>
                <?php echo $select_produtos; ?>
              </div>
              <div class="form-group">
                <label>Quantidade:</label>
                <input type="text" id="quantidade_u" name="quantidade" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="detalhe" name="crud">
              <input type="hidden" value="2" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-info" id="btn-update">ATUALIZAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Exclui HTML -->
    <div id="excluiDetalheModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <div class="modal-header">
              <h4 class="modal-title">Excluir Pedido</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_d" name="id" class="form-control">
              <p>Está certo que deseja continuar?</p>
              <p class="text-warning"><small>ESTA AÇÃO NÃO PODE SER DESFEITA.</small></p>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="pedido" name="crud">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-danger" id="delete">EXCLUIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
      <script> var id_pedido = <?php echo $idPedido ?>;</script>
  </body>
</html>



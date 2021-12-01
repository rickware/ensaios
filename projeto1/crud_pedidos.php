<?php
ob_start();
require './backend/database.php';
fb('start', FIREPHP::INFO);

function monta_select_cliente ($link){
  $resultcli = mysqli_query($link, "select id, nome from clientes");
  $resposta  = '<select name="selcli" id="selcli" class="form-control" onchange="carregar()">';
  while ($row = mysqli_fetch_assoc($resultcli)){
    $resposta .= '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
  }
  $resposta .='</select>';
  return $resposta;
}

$select_cliente = monta_select_cliente ($conn);
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
              <a href="#novoPedidoModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons"></i> <span>Novo Pedido</span>
              </a>
              <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple">
                <i class="material-icons"></i> <span>Remover</span>
              </a>
            </div>
          </div>
        </div>

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

    <!-- Modal Novo HTML -->
    <div id="novoPedidoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Novo Pedido</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>NOME:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
              </div>
              <div class="form-group">
                <label>UNIDADE:</label>
                <input type="text" id="unidade" name="unidade" class="form-control" required>
              </div>
              <div class="form-group">
                <label>PRE&Ccedil;O:</label>
                <input type="text" id="preco" name="preco" class="form-control" required>
              </div>
              <div class="form-group">
                <label>ESTOQUE:</label>
                <input type="text" id="estoque" name="estoque" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="1" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">INSERIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edita HTML -->
    <div id="editaPedidoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <a class="btn btn-default" href="./crud_detalhe.php?idvenda=18"
               <h4>Editar Pedido</h4></a>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="update_form">
            
       <section class="u-clearfix u-section-2" id="sec-057c">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-table u-table-responsive u-table-1">
          <table class="table table-striped table-hover">
            <colgroup>
              <col width="38.7%">
              <col width="14.3%">
              <col width="13.2%">
              <col width="13.8%">
              <col width="20%">
            </colgroup>
            <thead class="u-palette-1-light-2 u-table-header u-table-header-1">
              <tr style="height: 50px;">
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">PRODUTO</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">QUANTIDADE</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">VALOR</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">SUB-TOTAL</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">ACAO</th>
              </tr>
            </thead>
            <tbody class="u-table-body">
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">AGUA</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">3</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">5,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">50,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">EDITAR&nbsp; &nbsp;REMOVER</td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">FEIJAO</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">2</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">5,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">ARROZ</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">1</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">BOLO</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">2</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">15.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">30,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">SAL</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">1</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">8.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">8.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
            </tbody>
          </table>
          </form> 
        </div>
      </div>
    </section>   
          
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
    
    <script>   
      function carregar() {
        var id_cliente = $("#selcli option:selected").val();
        var request = './backend/controller.php?acao=carregapedidoscliente&cliente=' + id_cliente;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          var result = JSON.parse(this.responseText);
          if (result.length > 0) {
            for (i = 0, len = result.length; i < len; i++) {
              var acaoCell = '<a href="#editaPedidoModal" class="edit" data-toggle="modal">'+
              '<i class="material-icons update" data-toggle="tooltip"'+
              'data-id="'+result[i][0]+'"'+
              'data-produtos="'+result[i][1]+'"'+
              'data-total="'+result[i][2]+'"'+
              'title="Editar"></i>'+
              '</a>'+
              '<a href="#excluiPedidoModal" class="delete" data-id="'+result[i][0]+'" data-toggle="modal">'+
              '  <i class="material-icons" data-toggle="tooltip" title="Excluir"></i>'+
              '</a>';

              var linha = '<tr><td>'+result[i][0]+'</td><td>'+result[i][1]+'</td><td>'+result[i][2]+'</td><td>'+acaoCell+'</td></tr>';

              $('#tabelaPedidos > tbody:last-child').append(linha);
            }
          }
        };
        xhttp.open("GET", request, true);
        xhttp.send();
      }


      ;
    </script>

  </body>
</html>


